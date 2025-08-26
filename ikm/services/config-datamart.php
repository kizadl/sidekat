<?php
try {
	$pdo = new PDO("sqlsrv:Server=192.168.33.6,1433;Database=Datamart", "dev_dispendik" , "JBR5@tuD4ta");
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo "Connection failed: " . $e->getMessage();
}

?>


