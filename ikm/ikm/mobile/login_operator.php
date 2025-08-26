<?php
error_reporting(0);
include '../services/config.php';
$dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: ');
date_default_timezone_set('Asia/Jakarta');	

$tglserver=date('Y-m-d');
$userName = strtolower(trim($_POST['uid']));
$pwd=trim($_POST['pwrd']);
$pwd2 = md5($pwd);

$sql = ("SELECT p.id_instansi,p.id_induk,p.username,p.password,p.blokir,
		q.nm_instansi AS nminstansi,q.alamat AS alamatinstansi,q.kota AS kotainstansi,q.logo AS logoinstansi,q.ket_induk,
		r.nm_instansi AS nminduk,r.alamat AS alamatinduk,r.kota AS kotainduk,r.logo AS logoinduk
		FROM m_operator p 
		LEFT JOIN m_instansi q ON p.id_instansi=q.id_instansi
		LEFT JOIN m_instansi r ON p.id_induk=r.id_instansi
		WHERE p.username='".$userName."'");		
$resultx = mysqli_query($dbconn,$sql);

$myArray = array();
 while($t = $resultx->fetch_array(MYSQLI_ASSOC)) {
	$blokir =  $t['blokir'];
	$usernya =  $t['username'];
	if($usernya !== null OR $usernya !== ""){$user="ada";} else if($usernya == null OR $usernya == ""){$user="kosong";}	
	if ($pwd2 !== $t['password']){$ketpassword = "tidak";} else if ($pwd2 == $t['password']){$ketpassword = "sama";}
	
	$row_array = array();
	$row_array['tglserver']=$tglserver;
	$row_array['user']=$user;
	$row_array['blokir']=$blokir;
	$row_array['ketpassword']=$ketpassword;
	
	$row_array['idinstansi']=$t['id_instansi'];$row_array['nminstansi']=ucwords(strtolower($t['nminstansi']));$row_array['alamatinstansi']=$t['alamatinstansi'];
	$row_array['kotainstansi']=ucwords(strtolower($t['kotainstansi']));$row_array['logoinstansi']=$t['logoinstansi'];
	$row_array['ketinduk']=$t['ket_induk'];
	$row_array['idinduk']=$t['id_induk'];$row_array['nminduk']=ucwords(strtolower($t['nminduk']));$row_array['alamatinduk']=$t['alamatinduk'];
	$row_array['kotainduk']=ucwords(strtolower($t['kotainduk']));$row_array['logoinduk']=$t['logoinduk'];

    array_push($myArray,$row_array);
 }
echo json_encode($myArray);
$resultx->close();
$dbconn->close();
?>