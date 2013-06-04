<?php

// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");
session_start();

/* Cryptage et comparaison avec la valeur stockée dans $_SESSION['captcha'] */
$userCode = strtoupper($_POST['userCode']);
if( md5($userCode) != $_SESSION['captcha'] ){
	echo "|BAD_CAPTCHA";
}
else{
	echo "|OK";
}
	

?>