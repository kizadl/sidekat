<?php
error_reporting(0);
$idinstansi= trim($_GET['idinstansi']);
$ketfile= trim($_GET['ketfile']);
$ketfolder= trim($_GET['ketfolder']);

/*
if(!is_dir("../../data-surat/".$idinstansi))
		mkdir("../../data-surat/".$idinstansi,0777,true); 
		$path1 = "../../data-surat/".$idinstansi."/".$IDSurate.".pdf";
*/
// define absolute folder path
if ($ketfolder=="video"){
    if(!is_dir("../data-media/video"))
	mkdir("../data-media/video",0777,true); 
    $dest_folder = '../data-media/'.$ketfolder.'/';
} else if ($ketfolder=="kelas"){
    if(!is_dir("../data-media/foto/$idinstansi/kelas"))
	mkdir("../data-media/foto/$idinstansi/kelas",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/kelas/';
} else if ($ketfolder=="perpustakaan"){
    if(!is_dir("../data-media/foto/$idinstansi/perpustakaan"))
	mkdir("../data-media/foto/$idinstansi/perpustakaan",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/perpustakaan/';
} else if ($ketfolder=="kepsek"){
    if(!is_dir("../data-media/foto/$idinstansi/kepsek"))
	mkdir("../data-media/foto/$idinstansi/kepsek",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/kepsek/';
} else if ($ketfolder=="guru"){
    if(!is_dir("../data-media/foto/$idinstansi/guru"))
	mkdir("../data-media/foto/$idinstansi/guru",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/guru/';
} else if ($ketfolder=="pembinaan"){
    if(!is_dir("../data-media/foto/$idinstansi/pembinaan"))
	mkdir("../data-media/foto/$idinstansi/pembinaan",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/pembinaan/';
} else if ($ketfolder=="multimedia"){
    if(!is_dir("../data-media/foto/$idinstansi/multimedia"))
	mkdir("../data-media/foto/$idinstansi/multimedia",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/multimedia/';
} else if ($ketfolder=="komputer"){
    if(!is_dir("../data-media/foto/$idinstansi/komputer"))
	mkdir("../data-media/foto/$idinstansi/komputer",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/komputer/';
} else if ($ketfolder=="ips"){
    if(!is_dir("../data-media/foto/$idinstansi/ips"))
	mkdir("../data-media/foto/$idinstansi/ips",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/ips/';
} else if ($ketfolder=="ipa"){
    if(!is_dir("../data-media/foto/$idinstansi/ipa"))
	mkdir("../data-media/foto/$idinstansi/ipa",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/ipa/';
} else if ($ketfolder=="bahasa"){
    if(!is_dir("../data-media/foto/$idinstansi/bahasa"))
	mkdir("../data-media/foto/$idinstansi/bahasa",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/bahasa/';
} else if ($ketfolder=="wcumum"){
    if(!is_dir("../data-media/foto/$idinstansi/wcumum"))
	mkdir("../data-media/foto/$idinstansi/wcumum",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/wcumum/';
} else if ($ketfolder=="wcsiswa"){
    if(!is_dir("../data-media/foto/$idinstansi/wcsiswa"))
	mkdir("../data-media/foto/$idinstansi/wcsiswa",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/wcsiswa/';
} else if ($ketfolder=="wcguru"){
    if(!is_dir("../data-media/foto/$idinstansi/wcguru"))
	mkdir("../data-media/foto/$idinstansi/wcguru",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/wcguru/';
} else if ($ketfolder=="ibadah"){
    if(!is_dir("../data-media/foto/$idinstansi/ibadah"))
	mkdir("../data-media/foto/$idinstansi/ibadah",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/ibadah/';
} else if ($ketfolder=="asrama"){
    if(!is_dir("../data-media/foto/$idinstansi/asrama"))
	mkdir("../data-media/foto/$idinstansi/asrama",0777,true); 
    $dest_folder = '../data-media/foto/'.$idinstansi.'/asrama/';
}

if (!empty($_FILES)) {
	
	// if dest folder doesen't exists, create it
	if(!file_exists($dest_folder) && !is_dir($dest_folder)) mkdir($dest_folder);

    foreach($_FILES['file']['tmp_name'] as $key => $value) {
        $tempFile = $_FILES['file']['tmp_name'][$key];
        //$targetFile =  $dest_folder. $_FILES['file']['name'][$key];
        if ($ketfolder=="video"){
            $targetFile =  $dest_folder. $idinstansi.".".$ketfile;
        } else {
            $targetFile =  $dest_folder. $_FILES['file']['name'][$key];
        }
        //$targetFile =  $dest_folder. $idinstansi.".".$ketfile;
        move_uploaded_file($tempFile,$targetFile);
    }
 
    $data = [
    	"file" => $_POST["file"],
    	"dropzone" => $_POST["dropzone"],
    ];
    header('Content-type: application/json');
    echo json_encode($data);

    exit();

}