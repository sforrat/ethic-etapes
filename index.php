<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY 							  
/*	Date : 		JUIN 2009
/*	Version :	1.0							  
/*	Fichier :	index.php						  
/*										  
/*	Description :	Home page Front office du site                        

/**********************************************************************************/

if($_GET["closepopup"] == 1){
  echo "<script>self.close()</script>";
  die();
}



// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");

// Affichage la page elle même
// les blocs sont inclus directement dans le template de la page
// les variables de positionnement de contexte sont passées depuis cette page vers les différents blocs



// -- Publicite
$sql = "select 
			home_publicite.visuel,
			trad_home_publicite.libelle,
			trad_home_publicite.url
		FROM 
			home_publicite
		INNER JOIN 
			trad_home_publicite on (trad_home_publicite.id__langue=".$_SESSION["ses_langue"].")
    WHERE 
      home_publicite.id__langue=".$_SESSION["ses_langue"];
$result = mysql_query($sql);
$myrow = mysql_fetch_array($result);
$template -> assign ("pub_visuel", getFileFromBDD($myrow["visuel"],"home_publicite"));
$template -> assign ("pub_url", $myrow["url"]);
$template -> assign ("pub_libelle", $myrow["libelle"]);



// -- On detruits les sessions de la liste de recherche :
$_SESSION["idCentre"]="";
unset($_SESSION["idCentre"]);
$_SESSION["params"]="";
unset($_SESSION["params"]);
$_SESSION["amb_filter"]="";
unset($_SESSION["amb_filter"]);
$_SESSION["individuel"]="";
unset($_SESSION["individuel"]);
$_SESSION["groupe"]="";
unset($_SESSION["groupe"]);
// ------------------------------------------------------


// Test si session langue est bien initialisée :
if($_SESSION['ses_langue'] == ""){
	redirect(_CONST_APPLI_URL."index.php?Rub=1&L=1");
	die();
}


//-----------------------------------------
//			Actualités / Bons Plans
//  On affiche 1 Actu + 1 Bon Plan + 1 Actu ...
//-----------------------------------------
$params['home'] = true;

$nbActu = getActualites($listeActu, $params);
$nbBP = getBonPlan($listeBP, $params);

$nb = ($nbActu > $nbBP) ? $nbActu : $nbBP;
for ($i = 0 ; $i < $nb ; $i++)
{
	if ($i < $nbActu)
	$liste[] = array (	"titre" => $listeActu[$i]["titre"],
						"description" => $listeActu[$i]["description"],
						"lien" => $listeActu[$i]["lien"]);
						
	if ($i < $nbBP)
	$liste[] = array (	"titre" => $listeBP[$i]["titre"],
						"description" => $listeBP[$i]["description"],
						"lien" => $listeBP[$i]["lien"]);												
}

$template -> assign ("nbActu", count($liste));
$template -> assign ("listeActu", $liste);


//-----------------------------------------
//				Centre
//-----------------------------------------
$centre = getCentreRand();

if (strlen($centre['description'])> 130)
	$centre['description'] = substr($centre['description'],0,130)."...";
	
$template -> assign ("centre", $centre);


//-----------------------------------------
//				Séjour
//-----------------------------------------
$template -> assign ('libelle_sejour_moins_18_ans', get_nav(_NAV_SEJOUR_MOINS_18_ANS));
$template -> assign ('libelle_sejour_reunion', 		get_nav(_NAV_SEJOUR_REUNION));
$template -> assign ('libelle_sejour_decouverte', 	str_replace(' ','<br/>',get_nav(_NAV_SEJOUR_DECOUVERTE)));

$template -> assign ('url_sejour_moins_18_ans', get_url_nav(_NAV_SEJOUR_MOINS_18_ANS));
$template -> assign ('url_sejour_reunion', 		get_url_nav(_NAV_SEJOUR_REUNION));
$template -> assign ('url_sejour_decouverte', 	get_url_nav(_NAV_SEJOUR_DECOUVERTE));

$sejour = getSejourRand();

if (strlen($sejour['description'])> 130)
	$sejour['description'] = substr($sejour['description'],0,130)."...";
	
$template -> assign ("sejour", $sejour);


//------------------------------------------
//				Flash Home
//------------------------------------------
$id_theme = isset($_REQUEST['theme']) ? $_REQUEST['theme'] : 1;
$template -> assign("theme", $id_theme);
$template -> assign("lib_suite", urlencode(html_entity_decode(get_libLocal("lib_lire_la_suite"))));

if($_POST["detention_label"] != "" || $_POST["environnement_filter"] != ""){
	$template -> assign ("scrollto", 1);
}



$template->display('index.tpl');
?>
