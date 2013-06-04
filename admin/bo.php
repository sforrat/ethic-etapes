<?
session_start();
$_SESSION["AccessPreprodOK"]=1;
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

include "include/inc_init_bo.inc.php";

include "include/inc_header.inc.php";
include "include/inc_list_order.inc.php";
include "include/inc_list.inc.php";
include "include/inc_form.inc.php";
include "include/inc_view.inc.php";
include "include/inc_footer.inc.php";

//show_source(NomFichier($_SERVER['PHP_SELF'],0));
?>
