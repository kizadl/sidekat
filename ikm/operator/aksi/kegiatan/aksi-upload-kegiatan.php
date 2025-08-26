<?php
error_reporting(0);
$idkegiatan= trim($_GET['idkegiatan']);
$ketfile= trim($_GET['ketfile']);
$ketfolder= trim($_GET['ketfolder']);

// define absolute folder path
if ($ketfolder=="headline"){
    if(!is_dir("../../../data-media/foto/headline"))
	mkdir("../../../data-media/foto/headline",0777,true); 
    $dest_folder = "../../../data-media/foto/headline/";
} else if ($ketfolder=="kegiatan"){
    if(!is_dir("../../../data-media/foto/kegiatan/$idkegiatan"))
	mkdir("../../../data-media/foto/kegiatan/$idkegiatan",0777,true); 
    $dest_folder = "../../../data-media/foto/kegiatan/$idkegiatan/";
} 

if (!empty($_FILES)) {
	
	// if dest folder doesen't exists, create it
	if(!file_exists($dest_folder) && !is_dir($dest_folder)) mkdir($dest_folder);

    foreach($_FILES['file']['tmp_name'] as $key => $value) {
        $tempFile = $_FILES['file']['tmp_name'][$key];
        if ($ketfolder=="headline"){
            $targetFile =  $dest_folder. $idkegiatan.".".$ketfile;
        } else {
            $targetFile =  $dest_folder. $_FILES['file']['name'][$key];
        }
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