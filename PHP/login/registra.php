<?php
ob_start();
require("../../config/config.php");
require("../base/fnQuery.php");
require("../session_recovery.php");

require("../lib/PHPMailer-6.0.1/src/Exception.php");
require("../lib/PHPMailer-6.0.1/src/PHPMailer.php");
require("../lib/PHPMailer-6.0.1/src/SMTP.php");

$response = (Object) [
	"status" => false
	,"response" => "init"
];

try {

	$mail = $_POST["mail"];
	$passw = $_POST["password"];
	$_POST["password"] = "";

	if ($dbh) {

	} else {
		$response->response = "Connessione database fallita";
	}
} catch (Exception $e) {
	$response->response = "Fatal error";
	echo $e->getMessage();
}

$obStr = ob_get_clean();
$response->response = $response->status ? $response->response : $response->response . ($obStr ? ". More info: " . $obStr : "");
ob_end_clean();

?>