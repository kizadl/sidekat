<?php
error_reporting(0);
include '../../services/config.php';
include '../../services/tgl_indo.php';
$dbconn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Could not connect: ');

$sqlx = ("SELECT * FROM komentar WHERE ket_komentar='komentar' ORDER BY id_komentar DESC LIMIT 10");
$result = mysqli_query($dbconn, $sqlx);
while ($t = mysqli_fetch_array($result)) {
	$idkomentar = $t['id_komentar'];
	$tglkomentar = tgl_indo($t['tgl_komentar']);
	$jamkomentar = $t['jam_komentar'];
	$nama = ucwords(strtolower($t['nama']));

	echo "<div class='d-flex mt-3'>
	<div class='flex-1 ms-2 fs--1'>
        <p class='mb-1 bg-200 rounded-3 p-2'>
			<strong>$nama</strong> <br/> $t[isi_komentar]
            </p>
            <div class='px-2'><a role='button' href='#!' class='cmdBalasKomentar' data-idkomentar='$idkomentar'>Balas</a> &bull; $tglkomentar - $jamkomentar </div>
          </div>
        </div>";

	$sqlbls = ("SELECT * FROM komentar WHERE ket_komentar='balasan' AND id_balas='" . $t['id_komentar'] . "' ORDER BY id_komentar DESC LIMIT 5");
	$resultbls = mysqli_query($dbconn, $sqlbls);
	$jumbalas = mysqli_num_rows($resultbls);
	if ($jumbalas >= 1) {
		while ($b = mysqli_fetch_array($resultbls)) {
			$tglbalas = tgl_indo($b['tgl_komentar']);
			$jambalas = $b['jam_komentar'];
			$namabalas = ucwords(strtolower($b['nama']));
			echo "<div class='d-flex mt-2'>
			<div class='flex-1 ms-3 fs--1'>
			  <p class='mb-0 rounded-3 p-2'><a class='fw-semi-bold' href='#!'>$namabalas</a> @ <strong>$nama</strong><br/>
			  	$b[isi_komentar]
			  </p>
			  <div class='px-2'> $tglbalas - $jambalas </div>
			</div>
		  </div>";
		}
	}
}

$result->close();
$dbconn->close();
