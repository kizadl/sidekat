<?php
session_start();

unset($_SESSION['IDOPERATOR']); 
unset($_SESSION['USERNAME']); 
unset($_SESSION['NMOPERATOR']);
unset($_SESSION['AKSES']);
unset($_SESSION['IDINSTANSI']);
unset($_SESSION['HALAMAN']); 

session_destroy();
 
echo"
<script>
window.location='web-view.php';
</script>";
exit; 
?>