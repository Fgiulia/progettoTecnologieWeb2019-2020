<?php
require("../../config/config.php");
require("../session_recovery.php");

$response = (Object) [
	"status" => false
	,"response" => "init"
];

try {

	unset($_SESSION["logged"]);
	
	$response->response = true;
	$response->status = true;

} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

?>