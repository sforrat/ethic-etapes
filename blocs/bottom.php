<?
global $db;
if($_REQUEST["Rub"] == _NAV_ACCUEIL || !$_REQUEST["Rub"])
{
  $this -> assign ('urlBackTop', _CONST_APPLI_URL.'#header');
}
elseif($_REQUEST["Rub"] == _NAV_FICHE_CENTRE)
{
	$this -> assign ('urlBackTop', get_url_nav_centre($_REQUEST['Rub'], $_REQUEST['id_centre']).'#header');
}
elseif(!empty($_REQUEST['id']) && ($_REQUEST["Rub"] == _NAV_CLASSE_DECOUVERTE || $_REQUEST["Rub"] == _NAV_CVL 
|| $_REQUEST["Rub"] == _NAV_ACCUEIL_GROUPES_SCOLAIRES || $_REQUEST["Rub"] == _NAV_ACCEUIL_REUNIONS 
|| $_REQUEST["Rub"] == _NAV_INCENTIVE || $_REQUEST["Rub"] == _NAV_SEJOUR_REUNION || $_REQUEST["Rub"] == _NAV_SEMINAIRES 
|| $_REQUEST["Rub"] == _NAV_SEJOUR_DECOUVERTE || $_REQUEST["Rub"] == _NAV_ACCUEIL_GROUPE 
|| $_REQUEST["Rub"] == _NAV_ACCUEIL_SPORTIF || $_REQUEST["Rub"] == _NAV_SEJOURS_TOURISTIQUES_GROUPE 
|| $_REQUEST["Rub"] == _NAV_STAGES_THEMATIQUES_GROUPE || $_REQUEST["Rub"] == _NAV_ACCUEIL_INDIVIDUEL 
|| $_REQUEST["Rub"] == _NAV_SHORT_BREAK || $_REQUEST["Rub"] == _NAV_STAGES_THEMATIQUES_INDIVIDUEL))
{
	$this -> assign ('urlBackTop', get_url_nav_sejour($_REQUEST['Rub'], $_REQUEST['id']).'#header');
}
else
{
  $this -> assign ('urlBackTop', get_url_nav($_REQUEST['Rub']).'#header');
}


$navID = get_navID(_NAV_ACCUEIL);
$aMenu = get_menu_gauche(_NAV_ACCUEIL,$navID,$db,_NAV_FOOTER);
$this -> assign("item_menu_n1",$aMenu);
$this -> display("blocs/bottom.tpl");
?>