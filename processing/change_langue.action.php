<?
// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");

if ($_REQUEST['L'])
	$_SESSION['ses_langue'] = $_REQUEST['L'];

switch($_REQUEST['L']){
	case 1:
		$url = 'http://www.ethic-etapes.fr';
		break;
	case 5 :
		$url = 'http://www.ethic-etapes.de';
		break;
	case 2 :
		$url = 'http://www.ethic-etapes.com';
		break;
	default:
		$url = 'http://www.ethic-etapes.fr';
		break;
}
	
	
redirect($url);	

?>