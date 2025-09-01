<?php
// Dynamic router: baca semua .htaccess dan jalankan RewriteRule-nya.

$rootPath = __DIR__;
$uriRaw = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
// Serve static file directly if it exists
if ($uriRaw !== '/' && file_exists($rootPath . $uriRaw)) {
    return false;
}

$uri = ltrim($uriRaw, '/');

function loadFile($path)
{
    global $rootPath;
    $fullPath = $rootPath . '/' . ltrim($path, '/');
    $fullPath = str_replace('\\', '/', $fullPath);

    if (!file_exists($fullPath)) {
        http_response_code(404);
        echo "404 Not Found: $fullPath";
        exit;
    }

    $oldDir = getcwd();
    chdir(dirname($fullPath)); // jaga relative path
    if (!empty($_GET)) {
        $_SERVER['QUERY_STRING'] = http_build_query($_GET);
    }
    require $fullPath;
    chdir($oldDir);
    exit;
}

// Helper: normalize paths with .. and .
function normalizePathParts(array $parts)
{
    $out = [];
    foreach ($parts as $p) {
        if ($p === '' || $p === '.') continue;
        if ($p === '..') {
            array_pop($out);
            continue;
        }
        $out[] = $p;
    }
    return $out;
}

// Scan .htaccess files and collect RewriteRule entries
$rules = [];
$it = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($rootPath, RecursiveDirectoryIterator::SKIP_DOTS));
foreach ($it as $f) {
    if (!$f->isFile()) continue;
    if ($f->getFilename() !== '.htaccess') continue;

    $dir = str_replace('\\', '/', $f->getPath());
    $relDir = ltrim(substr($dir, strlen($rootPath)), '/'); // may be ''
    $content = @file_get_contents($f->getPathname());
    if ($content === false) continue;

    $lines = preg_split('/\r?\n/', $content);
    foreach ($lines as $line) {
        $line = trim($line);
        if ($line === '' || strpos($line, 'RewriteRule') === false) continue;
        if (strpos($line, '#') === 0) continue;

        if (preg_match('/^RewriteRule\s+(\S+)\s+(\S+)/i', $line, $m)) {
            $pattern = $m[1];
            $target = $m[2];
            $rules[] = ['base' => $relDir, 'pattern' => $pattern, 'target' => $target];
        }
    }
}

// Sort rules: longer base first (more specific directories first)
usort($rules, function ($a, $b) {
    return strlen($b['base']) - strlen($a['base']);
});

// Try matching rules
foreach ($rules as $r) {
    $base = $r['base'];

    // determine sub-uri that this htaccess would see
    if ($base === '') {
        $sub = $uri;
    } else {
        if ($uri === $base) {
            $sub = '';
        } elseif (strpos($uri, $base . '/') === 0) {
            $sub = substr($uri, strlen($base) + 1);
        } else {
            continue; // this htaccess doesn't apply
        }
    }

    // Prepare regex from pattern (apache regex is compatible)
    $pat = $r['pattern'];
    // Ensure delimiter doesn't appear in pattern
    $delim = '~';
    $regex = $delim . $pat . $delim;

    if (@preg_match($regex, '') === false) {
        // fallback: escape and build simple match
        $regex = $delim . str_replace('/', '\\/', $pat) . $delim;
    }

    if (preg_match($regex, $sub, $m)) {
        // replace $n in target with capture groups
        $target = $r['target'];
        $target = preg_replace_callback('/\$(\d+)/', function ($mm) use ($m) {
            $i = (int)$mm[1];
            return isset($m[$i]) ? $m[$i] : '';
        }, $target);

        // split path and query
        $parts = explode('?', $target, 2);
        $pathPart = $parts[0];
        $queryPart = isset($parts[1]) ? $parts[1] : '';

        // resolve pathPart relative to htaccess directory
        $resolved = '';
        if (strpos($pathPart, '/') === 0) {
            // absolute from project root
            $resolved = ltrim($pathPart, '/');
        } elseif (strpos($pathPart, './') === 0 || strpos($pathPart, '../') === 0) {
            $baseParts = $base === '' ? [] : explode('/', $base);
            $p = $pathPart;
            while (strpos($p, './') === 0) {
                $p = substr($p, 2);
            }
            while (strpos($p, '../') === 0) {
                array_pop($baseParts);
                $p = substr($p, 3);
            }
            $resolvedParts = array_merge($baseParts, $p === '' ? [] : explode('/', $p));
            $resolvedParts = normalizePathParts($resolvedParts);
            $resolved = implode('/', $resolvedParts);
        } elseif ($pathPart === '') {
            $resolved = $base; // target empty => directory
        } else {
            // relative to htaccess directory
            $resolvedParts = $base === '' ? explode('/', $pathPart) : array_merge(explode('/', $base), explode('/', $pathPart));
            $resolvedParts = normalizePathParts($resolvedParts);
            $resolved = implode('/', $resolvedParts);
        }

        // apply query part into $_GET
        if ($queryPart !== '') {
            // replace any $n still present
            $queryPart = preg_replace_callback('/\$(\d+)/', function ($mm) use ($m) {
                $i = (int)$mm[1];
                return isset($m[$i]) ? $m[$i] : '';
            }, $queryPart);
            parse_str($queryPart, $qp);
            foreach ($qp as $k => $v) {
                $_GET[$k] = $v;
            }
        }

        // finally load resolved file (if resolved is empty, try index.php)
        $toLoad = $resolved === '' ? 'index.php' : $resolved;
        loadFile($toLoad);
    }
}

// If nothing matched, fallback to index.php
loadFile('index.php');
