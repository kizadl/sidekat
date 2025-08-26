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

$mdsekolah = $_GET['mdsekolah'];
$mdptk = $_GET['mdptk'];

$tempdir = "../data-sk/".$mdsekolah."/".$mdptk.".pdf";

?>
<iframe name="myiframe" id="myiframe" src="<?php echo $tempdir;?>"></iframe>
</div>
</body>
</html>