<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	recherche_geographique.php						  
/*										  
/*	Description :	Recherche géographique               
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";

// --- Les labels
getListeCentreInfos("detention_label", $listeInfo);
$this->assign("TabLabel",$listeInfo);
if($_REQUEST["detention_label"] == ""){
  $this->assign("resa_filter1",0);
}else{
  $this->assign("resa_filter1",$_REQUEST["detention_label"]);
}
// --------------

// --- Environnement
$nbEnv = getListeCentreInfos("ambiance", $listeEnvironnement); 
// On recherche sur l'ambiance mais je n'ai pas changé le noms des variables qui sont intitulées "environnement".

for ($i = 0 ; $i < $nbEnv ; $i++)
{
	if ($listeEnvironnement[$i]['id'] == _CONST_CENTRE_ENV_MOYENNE_MONTAGNE) //Moyenne montagne ne doit pas apparaitre dans le liste
	   continue;
	$listeEnv[] = $listeEnvironnement[$i];
}
$this->assign("TabEnv",$listeEnv);

$this -> assign ("Rub", $_REQUEST["Rub"]);
if($_REQUEST["environnement_filter"] == ""){
  $this->assign("resa_filter2",0);
}else{
  $this->assign("resa_filter2",$_REQUEST["environnement_filter"]);
}
// --------------



// --- Url du form pour le moteur géo soit la page elle mm
if($_REQUEST["Rub"]=="" || $_REQUEST["Rub"]== _NAV_ACCUEIL){
  $urlRecherche = _CONST_APPLI_URL;
  $this->assign("is_resa_filter2",true);
  // RPL 09/06/2011
  $this->assign("allcentre",1);
}else{
  //$urlRecherche = get_url_nav($_REQUEST["Rub"])."&".$_SERVER["QUERY_STRING"];
  $urlRecherche = get_url_nav($_REQUEST["Rub"]);
  //$urlRecherche = '#';
}
$this->assign("url_recherche",$urlRecherche);
// --------------


if($_REQUEST["Rub"]==_NAV_FICHE_CENTRE){
  $this->assign("allcentre",0);
  $this->assign("centreID",$_REQUEST["id_centre"]);
  $sql = "select flash_paris from centre where id_centre=".$_REQUEST["id_centre"];
  $result = mysql_query($sql);
  $isOnParis = mysql_result($result,0,"flash_paris");
  if($isOnParis == 1){
  	$this->assign("isOnParis",1);
  }else{
  	$this->assign("isOnParis",0);
  }
}else{
  $this->assign("allcentre",1);
}

if($_GET["Rub"] != _NAV_FICHE_CENTRE){
	$this->assign("is_resa_filter1",1);
}else{
	$this->assign("is_resa_filter1",0);
}



$this -> display('blocs/recherche_geographique.tpl');
?>
