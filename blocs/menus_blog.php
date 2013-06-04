<?
require $path."include/inc_header.inc.php";

//Url accueil
$template -> assign("url_home", _CONST_APPLI_URL);

//Menus
$aMenu = get_menu_gauche(_NAV_ACCUEIL,$navID,$db,_NAV_SITE);


//trace($aMenu);

$template -> assign("item_menu_n1",$aMenu);

$template->assign("Rub",$_GLOBALS["Rub"]);
$template -> display("blocs/menus_blogs.tpl");
?>