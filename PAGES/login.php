<?php
require_once "../PHP/modulesInit.php";


$output = file_get_contents("../HTML/login.html");
echo str_replace("<menu></menu>",modulesInit::menu(),$output);

if(!isset($_SESSION))
  session_start();
if(isset($_SESSION['login']) && !$_SESSION['login']->status) {
  $output = str_replace("<p id='loginError' class='hidden'>","<p id='loginError'>",$output);
  session_destroy();
}

?>
