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

$idinformasi = $_GET['idinformasi'];

$tempdir = "data-informasi/".$idinformasi.".pdf";

?>
<iframe name="myiframe" id="myiframe" src="<?php echo $tempdir;?>"></iframe>
</div>
</body>
</html>