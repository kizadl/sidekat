<?php 
//error_reporting(0);

function getRegisteredAPI(){
    return ['abcd','40997e7e26c3e420543916766870b635','diskominfokeren'];
}

function IsInputValid($inputs){
    $apikey = $inputs['APIKEY'];

    include 'services/config.php';
    $dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
   
   $sqljumarsip=("SELECT * FROM m_tempat");
   $resultjumarsip = mysqli_query($dbconn,$sqljumarsip);
   $jumarsip = mysqli_num_rows($resultjumarsip);

    if ($apikey == "40997e7e26c3e420543916766870b635" AND $jumarsip > 0){
        return true;
    }else{
        return false;
    }
}

function jsonOutput($status,$message,$data){
    $response = ['status' => $status,'message' => $message,'data' => $data ];
    header("content-type: application/json");

    echo json_encode ($response);
}

function getNewsData(){
    include 'services/config.php';
    $dbconn = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname)or die('Could not connect: '); 
   $nik=$_POST['NIK'];
   
   $qriserver = ("SELECT server_lokal FROM set_server WHERE id_server='1'");
   $dbserver = mysqli_query($dbconn,$qriserver);$s= mysqli_fetch_assoc($dbserver);
   $QRurl = $s['server_lokal'];
   mysqli_free_result($dbserver);
   
   $sqljumarsip=("SELECT * FROM arsip_surat WHERE nik='".$nik."' AND kd_layanan='12' OR nik='".$nik."' AND kd_layanan='15' OR nik='".$nik."' AND kd_layanan='16'");
   $resultjumarsip = mysqli_query($dbconn,$sqljumarsip);
   $jumarsip = mysqli_num_rows($resultjumarsip);
   
   $sqljumtrans=("SELECT * FROM trans_surat WHERE nik='".$nik."' AND kd_layanan='12' AND ket_status='terima' OR nik='".$nik."' AND kd_layanan='15' AND ket_status='terima' OR nik='".$nik."' AND kd_layanan='16' AND ket_status='terima'");
   $resultjumtrans = mysqli_query($dbconn,$sqljumtrans);
   $jumtrans = mysqli_num_rows($resultjumtrans);
   
   $data=array();
   if ($jumtrans > 0){
       $sql=("SELECT id_surat,kd_layanan,tgl_edit,no_surat,layanan,id_desa,id_kecamatan FROM trans_surat WHERE nik='".$nik."' AND kd_layanan='12' AND ket_status='terima' OR nik='".$nik."' AND kd_layanan='15' AND ket_status='terima' OR nik='".$nik."' AND kd_layanan='16' AND ket_status='terima'");
       $result = mysqli_query($dbconn,$sql);	
       while($t=mysqli_fetch_array($result)) {
           $mdsurat = md5($t['id_surat']);$kdlayanan = $t['kd_layanan'];
           $isiteks = $QRurl.$kdlayanan."-".$mdsurat.".html";

           $kdkecamatan = $t['id_kecamatan'];$kddesa = $t['id_desa'];
           $thnedit = date('Y', strtotime($t['tgl_edit']));$blnedit = date('m', strtotime($t['tgl_edit']));
          
           $tempdir = $QRurl."data-pdf/".$thnedit."/".$blnedit."/".$kdkecamatan."/".$kddesa."/".$kdlayanan."/".$mdsurat.".pdf";

           //$lokasifile = "../../data-pdf/".$thnedit."/".$blnedit."/".$kdkecamatan."/".$kddesa."/".$kdlayanan."/".$mdsurat.".pdf";  
           //$fileContents = file_get_contents($lokasifile); 
           //$base64_hasil = base64_encode($fileContents);
 
           $row_array=array();
           $row_array['nik']= $nik;
           $row_array['tanggal']=$t['tgl_edit'];$row_array['nosurat']=$t['no_surat'];$row_array['layanan']=$t['layanan'];
           $row_array['url']=$tempdir;
           //$row_array['pdf64']=$base64_hasil;
           array_push($data, $row_array);
        }$result->close();
   } else if ($jumarsip > 0){
       $sql=("SELECT id_asal,kd_layanan,tgl_edit,no_surat,layanan,id_desa,id_kecamatan FROM arsip_surat WHERE nik='".$nik."' AND kd_layanan='12' OR nik='".$nik."' AND kd_layanan='15' OR nik='".$nik."' AND kd_layanan='16'");
       $result = mysqli_query($dbconn,$sql);
       while($t=mysqli_fetch_array($result)) {
           $mdsurat = md5($t['id_asal']);$kdlayanan = $t['kd_layanan'];
           $isiteks = $QRurl.$kdlayanan."-".$mdsurat.".html";

           $kdkecamatan = $t['id_kecamatan'];$kddesa = $t['id_desa'];
           $thnedit = date('Y', strtotime($t['tgl_edit']));$blnedit = date('m', strtotime($t['tgl_edit']));
           
           $tempdir = $QRurl."data-pdf/".$thnedit."/".$blnedit."/".$kdkecamatan."/".$kddesa."/".$kdlayanan."/".$mdsurat.".pdf";
           
           //$lokasifile = "../../data-pdf/".$thnedit."/".$blnedit."/".$kdkecamatan."/".$kddesa."/".$kdlayanan."/".$mdsurat.".pdf";  
           //$fileContents = file_get_contents($lokasifile); 
           //$base64_hasil = base64_encode($fileContents);
 
           $row_array=array();
           $row_array['nik']= $nik;
           $row_array['tanggal']=$t['tgl_edit'];$row_array['nosurat']=$t['no_surat'];$row_array['layanan']=$t['layanan'];
           $row_array['url']=$tempdir;
           //$row_array['pdf64']=$base64_hasil;
           array_push($data, $row_array);
        }$result->close();
   }else{
       $row_array=array();
       $row_array['nik']= $nik;
       $row_array['tanggal']=null;$row_array['nosurat']=null; $row_array['layanan']=null;
       $row_array['url']=null;
       //$row_array['pdf64']=null;
       array_push($data, $row_array);
   
   }
  return $data;
   $dbconn->close();
}

if (IsInputValid($_POST)){
    jsonOutput("200","success",getNewsData());
} else {
    jsonOutput("400","Input NIK tidak valid","Data tidak ditemukan");
}
?>