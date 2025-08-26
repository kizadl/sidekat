<?php
error_reporting(0);
include '../../../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');

$ketsekolah = trim($_POST['ketsekolah']);
$filterrombel = trim($_POST['filterrombel']);

if ($filterrombel == "semua" AND $ketsekolah == "SD"){

	$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,p.rombel_7,p.rombel_8,p.rombel_9,
	p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan
	FROM spm_sekolah p 
	WHERE p.bentuk_pendidikan='".$ketsekolah."' GROUP BY p.id_sekolah");

} else if ($filterrombel == "KMB" AND $ketsekolah == "SD"){

	$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
	p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,p.rombel_7,p.rombel_8,p.rombel_9,
	p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan
	FROM spm_sekolah p 
	LEFT JOIN spm_rombel r ON p.id_sekolah=r.id_sekolah
	WHERE p.bentuk_pendidikan='".$ketsekolah."' AND r.kurikulum='Kurikulum SD Merdeka' AND p.id_sekolah=r.id_sekolah GROUP BY p.id_sekolah");
	
} else if ($filterrombel == "semua" AND $ketsekolah == "SMP"){

		$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
		p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,p.rombel_7,p.rombel_8,p.rombel_9,
		p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan
		FROM spm_sekolah p 
		WHERE p.bentuk_pendidikan='".$ketsekolah."' GROUP BY p.id_sekolah");
	
	} else if ($filterrombel == "KMB" AND $ketsekolah == "SMP"){
	
		$sqlx = ("SELECT DISTINCT p.id_sekolah,p.npsn,
		p.rombel_1,p.rombel_2,p.rombel_3,p.rombel_4,p.rombel_5,p.rombel_6,p.rombel_7,p.rombel_8,p.rombel_9,
		p.nama_sekolah,p.status_sekolah,p.bentuk_pendidikan
		FROM spm_sekolah p 
		LEFT JOIN tbl_api_dispendik q ON p.npsn=q.npsn
		WHERE p.bentuk_pendidikan='".$ketsekolah."' AND r.kurikulum='Kurikulum SMP Merdeka' AND p.id_sekolah=r.id_sekolah GROUP BY p.id_sekolah");
		
}

$result = mysqli_query($dbconn,$sqlx);
$data = array();
$no=0;
while($t=mysqli_fetch_array($result)){
	$no++;

	if (substr($t['nama_sekolah'],0,53) == "UNIT PELAKSANA TEKNIS DAERAH (UPTD) SATUAN PENDIDIKAN"){
		$nmsekolah = substr($t['nama_sekolah'],54);
	} else {
		$nmsekolah = $t['nama_sekolah'];
	}

	if ($ketsekolah == "SD"){
		$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SD Merdeka',r.kurikulum,NULL)) AS jumKMB,
				COUNT(IF(r.kurikulum='Kurikulum SD 2013',r.kurikulum,NULL)) AS jumK13 
				FROM spm_rombel r WHERE r.id_sekolah='".$t['id_sekolah']."'");
		$dbjumlah = mysqli_query($dbconn, $qrijml);$c = mysqli_fetch_assoc($dbjumlah);
	} else if ($ketsekolah == "SMP"){
		$qrijml = ("SELECT COUNT(IF(r.kurikulum='Kurikulum SMP Merdeka',r.kurikulum,NULL)) AS jumKMB,
				COUNT(IF(r.kurikulum='Kurikulum SMP 2013',r.kurikulum,NULL)) AS jumK13 
				FROM spm_rombel r WHERE r.id_sekolah='".$t['id_sekolah']."'");
		$dbjumlah = mysqli_query($dbconn, $qrijml);$c = mysqli_fetch_assoc($dbjumlah);
	}

	$jumKMB = $c['jumKMB'];$jumK13 = $c['jumK13'];

	$jmlrombel = $t['rombel_1'] + $t['rombel_2'] + $t['rombel_3'] + $t['rombel_4'] + $t['rombel_5'] + $t['rombel_6'] + $t['rombel_7'] + $t['rombel_8'] + $t['rombel_9'];
	$row_array = array();
	$row_array['no']=$no;
	$row_array['idsekolah']=$t['id_sekolah'];
	$row_array['npsn']=$t['npsn'];
	$row_array['sttssekolah']=$t['status_sekolah'];
	$row_array['jumKMB']=$jumKMB;
	$row_array['jumK13']=$jumK13;
	$row_array['nmsekolah']=$nmsekolah;
	$row_array['rombel1']=$t['rombel_1'];
	$row_array['rombel2']=$t['rombel_2'];
	$row_array['rombel3']=$t['rombel_3'];
	$row_array['rombel4']=$t['rombel_4'];
	$row_array['rombel5']=$t['rombel_5'];
	$row_array['rombel6']=$t['rombel_6'];
	$row_array['rombel7']=$t['rombel_7'];
	$row_array['rombel8']=$t['rombel_8'];
	$row_array['rombel9']=$t['rombel_9'];
	$row_array['jmlrombel']=$jmlrombel;
	array_push($data,$row_array);
}
echo json_encode($data);
$result->close();$dbjumlah->close();
$dbconn->close();
?>  
