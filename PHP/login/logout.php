<?php
ob_start();
require("../../config/config.php");
require("../session_recovery.php");

$response = (Object) [
	"status" => false
	,"response" => "init"
];

try {
	unset($_COOKIE[$session_logged]);
	
	$_SESSION = array();
	session_destroy();
	
	$response->response = true;
	$response->status = true;
} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

$obStr = ob_get_clean();
$response->response = $response->status ? $response->response : $response->response . ($obStr ? ". More info: " . $obStr : "");
ob_end_clean();
echo json_encode($response);
?>