<?
//Menus de niveau 1
global $db;
//Url accueil
$this -> assign("url_home", _CONST_APPLI_URL);

//Menus
$aMenu = get_menu_gauche(_NAV_ACCUEIL,$navID,$db,_NAV_SITE);


//trace($aMenu);

$this -> assign("item_menu_n1",$aMenu);

$this->assign("Rub",$_GLOBALS["Rub"]);
$this -> display("blocs/menus.tpl");
?>