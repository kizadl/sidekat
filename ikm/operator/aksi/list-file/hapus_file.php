<?php
$idsekolah = trim($_POST['idsekolah']);
$ruang = trim($_POST['ruang']);
$urlfile = trim($_POST['urlfile']);

function handle_error( $errno, $errstr, $errfile, $errline ) {
    die( $errstr );
}
set_error_handler( 'handle_error' );

if( ! @unlink( "$urlfile" ) ) {
     echo "err";
}else {
     echo "ok";
}

?>