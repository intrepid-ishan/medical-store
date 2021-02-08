<?php
try{
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=id13825346_store', 'id13825346_ish', 'lc5gMIo~tCIW[7ts');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $e)
{
	echo "connection failed" . $e->getMessage();
}
