<?php

# SESSION
$session_logged				= "TecWeb";
# DB
$db_host					= "localhost";
$db_name					= "TecWeb";
$db_user					= "admin";
$db_pass					= "admin";

$dbh = null;
try {
	$dbh = new PDO("mysql:host=$db_host;dbname=$db_name", $db_user, $db_pass, [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]);
	$dbh->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$dbh->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);
} catch (PDOException $e) {
	echo "dbh -> " . $e->getMessage() . ".<br/>\n";
}

if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
?>