<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	inc_header.inc.php					  
/*										  
/*	Description :	Fichier inclus dans toutes les pages. Inclus les 	  
/*			librairies et fichiers de configuration ncessaire        
/*			au bon fonctionnement de l'application			  
/*			Ouvre la connexion					  
/*			Instancie un nouvel objet de type template		  
/*										  
/**********************************************************************************/

// Dmarre tat de session
//session_cache_limiter('private');  // pour viter le message qui demande si on veut reposter les infos lorsque on fait back
session_start();



if (eregi("(^http|^ftp)",$path))
{
	mail("exploitation@c2is.fr","hacking detected",date("Y-m-s_H:i:s")." >>>> ".$_SERVER["HTTP_HOST"]." >>>> ".$_SERVER["SCRIPT_NAME"]." >>>> ".$_SERVER["REMOTE_ADDR"]." >>> ".$path);
	die("SECURITY ERROR !! your personal data has been sent to administrator.");
}

$GLOBALS['path'] = $path;

// Fichier de paramtrage gnraux front et back office
require_once($path."admin/library_local/lib_global.inc.php");
require_once($path."admin/library_local/lib_local.inc.php");

// Librairies des fonctions standards
require_once($path."admin/library/lib_design.inc.php");
require_once($path."admin/library/lib_tools.inc.php");
require_once($path."include/inc.tool.traduction.php");
require_once($path."admin/library/fonction.inc.php");
require_once($path."include/class.mysql.inc.php");
require_once($path."admin/library/class_page.php");
require_once($path."admin/library/class.search.inc");

// Librairie des fonctions gnriques Front Office Fullkit CMS + Smarty
require_once($path."include/lib_front.inc.php");
require_once($path."include/lib_navigation.inc.php");

// Class smarty extended pour le projet 
require($path."include/Smarty_local.class.php");

// Librairie spcifique au projet 
require_once($path."include/lib_local_front.inc.php");


// Ouverture de la connexion  la base
$db = new sql_db($Host, $UserName, $UserPass, $BaseName, false);

if(!$db->db_connect_id)
{
   message_die(CRITICAL_ERROR, "Connexion  la base de donnes impossible");
}

$template = new Smarty_local; // instanciation nouvel objet template enrichit par les parametres locaux
     
$template->compile_check = true; // vrifie si un template a t modifi a chaque appel
				 // peut tre pass  False en production pour amliorer
				 // les performances. Attention lors des mises  jour
$template->debugging = DEBUG_SMARTY;    // Constante positionne dans lib_global.inc.php

$template->caching = false; // cache de compilation des templates ? => ATTENTION avec les pages dynamiques..

// on s'affranchit de l'interpretation par smarty des { sur les js par ex.
// en changeant les dlimiteurs gauche et droite par dfaut par des #{
$template->left_delimiter = '#{';
$template->right_delimiter = '}#';

$template->register_function('smarty_trad', 'smarty_trad');

$GLOBALS['template']=$template;

// on vrifie si la rub courante a du contenu
if (isset($_REQUEST['Rub']) && $GLOBALS['Rub'] != _NAV_ACCUEIL)
{
   // si le param est pass dans la requete
   // on recupere la premiere rubrique fille qui possde du contenu
   // ou la rubrique en cours, si elle en a
   $GLOBALS['Rub'] = get_rub_filled($_REQUEST['Rub']);
}
else
{
   // aucun param pass, on est sur la home
   $GLOBALS['Rub'] = _NAV_ACCUEIL;
}
$aRub = getInfosRub($GLOBALS['Rub']);

// positionnement de la langue en cours ($_SESSION et prise en compte des changts de langue)
set_langue();

//Load libs
loadLibelles();
		

// recuperation du prefix en fonction de la langue
if ($_SESSION['ses_langue']==2) {		// usa + anglais
	$GLOBALS['prefix'] = "_en";
	$code_langue = "en";
	$str_language = "<meta http-equiv=\"Content-Language\" content=\"en-us\"/>";		

}
else {			// franais
	$GLOBALS['prefix'] = "_fr";
	$code_langue = "fr";
	$str_language = "<meta http-equiv=\"Content-Language\" content=\"fr\"/>";	
	
}

if (!nav_exist($GLOBALS['Rub'],0)) // mettre 1 pour tester seulement les nav dont selected = 1
{
	$GLOBALS['Rub'] = 1;	
	redirect(_CONST_APPLI_PATH); // vrifie si la valeur de Rub existe dans l'arbo
   				    // renvoie sur la home page sinon
	exit();
}

// on rcupre le chemin de nav courant
$navID = get_navID($GLOBALS['Rub']);

// Positionnement des variables globales pour le rfrencement

if($_GET["Rub"] == _NAV_FICHE_CENTRE && isset($_GET["id_centre"]))
{
  $tab = GetMetaCentre($_GET["id_centre"]);
 
  $template->assign("TITLE",$tab[0]);
  $template->assign("META_KEYWORD",$tab[2]);
  $template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches organisateurs de CVL
elseif($_GET["Rub"] == _NAV_FICHE_ORGANISATEUR_CVL && isset($_GET["id"]))
{
	$tab = GetMetaCentreCvl($_GET["id"]);
	
	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}

// fiches sÃ©jours - classes de dÃ©couverte
elseif($_GET["Rub"] == _NAV_CLASSE_DECOUVERTE && isset($_GET["id"]))
{
	$tab = GetMetaSejourClasseDecouverte($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - accueil de scolaires et d'enfants
elseif($_GET["Rub"] == _NAV_ACCUEIL_GROUPES_SCOLAIRES && isset($_GET["id"]))
{
	$tab = GetMetaSejourScolaire($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - CVL
elseif($_GET["Rub"] == _NAV_CVL && isset($_GET["id"]))
{
	$tab = GetMetaSejourCvl($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - accueil de rÃ©unions
elseif($_GET["Rub"] == _NAV_ACCEUIL_REUNIONS && isset($_GET["id"]))
{
	$tab = GetMetaAccueilReunion($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - sÃ©minaires
elseif(($_GET["Rub"] == _NAV_SEMINAIRES || $_GET["Rub"] == _NAV_INCENTIVE) && isset($_GET["id"]))
{
	$tab = GetMetaSeminaire($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - accueil de groupes adultes
elseif($_GET["Rub"] == _NAV_ACCUEIL_GROUPE && isset($_GET["id"]))
{
	$tab = GetMetaAccueilGroupe($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - accueil de sportifs
elseif($_GET["Rub"] == _NAV_ACCUEIL_SPORTIF && isset($_GET["id"]))
{
	$tab = GetMetaAccueilSportif($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - sÃ©jours touristiques groupes
elseif($_GET["Rub"] == _NAV_SEJOURS_TOURISTIQUES_GROUPE && isset($_GET["id"]))
{
	$tab = GetMetaSejourTouristique($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - stages thÃ©matiques groupes
elseif($_GET["Rub"] == _NAV_STAGES_THEMATIQUES_GROUPE && isset($_GET["id"]))
{
	$tab = GetMetaStageThematiqueGroupe($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - accueil d'individuels et familles
elseif($_GET["Rub"] == _NAV_ACCUEIL_INDIVIDUEL && isset($_GET["id"]))
{
	$tab = GetMetaAccueilIndividuel($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - Short breaks (breaks et week-ends)
elseif($_GET["Rub"] == _NAV_SHORT_BREAK && isset($_GET["id"]))
{
	$tab = GetMetaShortBreak($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}
// fiches sÃ©jours - stages thÃ©matiques indiviudels
elseif($_GET["Rub"] == _NAV_STAGES_THEMATIQUES_INDIVIDUEL && isset($_GET["id"]))
{
	$tab = GetMetaStageThematiqueIndividuel($_GET["id"]);

	$template->assign("TITLE",$tab[0]);
	$template->assign("META_KEYWORD",$tab[2]);
	$template->assign("META_DESCRIPTION",$tab[1]);
}  


else{

$template->assign("TITLE",get_header($GLOBALS['Rub'],"title"));
$template->assign("META_KEYWORD",strtolower(get_header($GLOBALS['Rub'],"meta_keyword")));
$template->assign("META_DESCRIPTION",strtolower(get_header($GLOBALS['Rub'],"meta_description")));
}







$template->assign("META_LANGUAGE",strtolower($str_language));
$template->assign("NOSCRIPT",get_header($GLOBALS['Rub'],"noscript"));
$template->assign("CONTENU_PIED",get_header($GLOBALS['Rub'],"div_footer"));
$template->assign("Rub",$GLOBALS['Rub']);
$template->assign("aRub",$aRub);
$template->assign("_GOOGLE_MAP_KEY",_GOOGLE_MAP_KEY);

if (strcmp(_ID_SITE_CYBERCITE,""))
{
   // permet d'activer le script tg_passage_cybercite dans footer si referencement CYBERCITE
   $template->assign("CYBERCITE_ID_SITE",_ID_SITE_CYBERCITE); 
}

$template -> assign("prefixe", $_SESSION['ses_langue_ext']);
$template -> assign("ses_langue", $_SESSION['ses_langue']);

//Gestion de la liste droulante des langues
switch ($_SESSION['ses_langue'])
{
	case _ID_FR :
		$currentLang = 'Français';
		break;
	case _ID_EN :
		$currentLang = 'English';
		break;
	case _ID_DE : 
		$currentLang = 'German';
		break;
	case _ID_ES :
		$currentLang = 'Spanish';
}
$template -> assign ('currentLang', $currentLang);

$listeLang = array();

//ON DESACTIVE LES LANGUES DISPONIBLES
//if ($_SESSION['ses_langue'] != _ID_FR)
//{
//	$paramListeLang[] = array('id_name' => 'L', 'id' => _ID_FR); 
//	$listeLang[] = array ('libelle' => 'Français', 'lien' => 'processing/change_langue.action.php?L='._ID_FR);
//}
//
//if ($_SESSION['ses_langue'] != _ID_EN)
//{
//	unset($paramListeLang);
//	$paramListeLang[] = array('id_name' => 'L', 'id' => _ID_EN); 
//	$listeLang[] = array ('libelle' => 'English', 'lien' => 'processing/change_langue.action.php?L='._ID_EN);
//}
//
//if ($_SESSION['ses_langue'] != _ID_DE)
//{
//	unset($paramListeLang);
//	$paramListeLang[] = array('id_name' => 'L', 'id' => _ID_DE); 
//	$listeLang[] = array ('libelle' => 'German', 'lien' => 'processing/change_langue.action.php?L='._ID_DE);
//}
//
//if ($_SESSION['ses_langue'] != _ID_ES)
//{
//	unset($paramListeLang);
//	$paramListeLang[] = array('id_name' => 'L', 'id' => _ID_ES); 	
//	$listeLang[] = array ('libelle' => 'Spanish', 'lien' => 'processing/change_langue.action.php?L='._ID_ES);
//}

$template -> assign ('listeLang', $listeLang);

	//Pour viter de garder les filtres en changeant de Catgories
	if ($_SESSION['filter'][$_REQUEST['Rub']]["Rub"] != $_REQUEST['Rub']){
	unset($_SESSION['filter']);
        }
$rub = $_REQUEST["Rub"];
	//On récupère en session les filtres pour les garder lors de l'utilisation de la pagination 
	if (isset($_REQUEST['P']) && $_REQUEST['P']>1)
	{
		$page = $_REQUEST['P'];
		$_REQUEST = $_SESSION['filter'][$_REQUEST['Rub']];
		$_REQUEST['P'] = $page;
	}
        else 
	{
		$page = 1;	
		$_REQUEST['P'] = $page;		
	}
	if($_REQUEST['Rub'] == ""){
	        	$_REQUEST['Rub'] = $rub;
        }
	if (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR"]) )
	{
                //if ($_REQUEST["P"]==1 && (count($_SESSION['filter'][$_REQUEST['Rub']])<=3)) //Plus que Rub et PHPSESSID
if( $_REQUEST["P"]==1 && $_REQUEST["requestFilter"]==1)
	{
$_REQUEST["requestFilter"]=0;
		  $_SESSION['filter'][$_REQUEST['Rub']] = $_REQUEST;
	        }
	else
	{
		if (isset($_SESSION['filter'][$_REQUEST['Rub']])){
			$_REQUEST = $_SESSION['filter'][$_REQUEST['Rub']];
			$_REQUEST['P'] = $page;
		}
	}
	}	

require_once($path."include/inc_chang_lang.inc.php");

$template->assign("urlLoginEspaceMembre",get_url_nav(_NAV_ESPACE_MEMBRE));
$template->assign("base_href",_CONST_APPLI_URL);

$template->assign("url_recherche",get_url_nav(_NAV_RECHERCHE));

if($_SESSION["AccessPreprodOK"] != 1){
	//redirect(_CONST_APPLI_URL."index_preprod.php");
	//die();
}
?>