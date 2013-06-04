<?
session_start();
require "library/fonction.inc.php";
require "library_local/lib_global.inc.php";
connection();
require "library_local/lib_local.inc.php";
require "library/lib_tools.inc.php";
require "library/lib_bo.inc.php";
get_bo_langue();
require "library_local/lib_language.inc.php";
require "library/class_bo.inc.php";
require "library/class_SqlToTable.inc.php";
require "library/lib_design.inc.php";

require "include/inc_init_bo.inc.php";

include "include/inc_header.inc.php";



//Gestion du fichier en cours d'utilisation
if (!isset($_SESSION["ses_use_include"])) {
	$_SESSION["ses_use_include"] = $_REQUEST['file']; 
}
else {
	if (isset($_REQUEST['file']) && $_REQUEST['file'] && $_REQUEST['file']!=$_SESSION["ses_use_include"]) {
		$_SESSION["ses_use_include"] = $_REQUEST['file'];
	}
}



//Inclusion du fichier passé en parametre 
include $_SESSION["ses_use_include"];


include "include/inc_footer.inc.php";

?>
