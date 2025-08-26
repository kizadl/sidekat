<html>
<head>
<style type="text/css">
#myiframe {width:100%; height:100%;} 
</style>
</head>
<body>
<div id="scroller">
<?php
error_reporting(0);

$npsn = $_GET['npsn'];

$tempdir = "../data-surat/".$npsn."/".$npsn.".pdf";

?>
<iframe name="myiframe" id="myiframe" src="<?php echo $tempdir;?>"></iframe>
</div>
</body>
</html>