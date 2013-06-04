<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	inc_header.inc.php					  
/*										  
/*	Description :	Fichier inclus dans toutes les pages. Inclus les 	  
/*			librairies et fichiers de configuration nécessaire        
/*			au bon fonctionnement de l'application			  
/*			Ouvre la connexion					  
/*			Instancie un nouvel objet de type template		  
/*										  
/**********************************************************************************/

ini_set('display_errors', 1);

// Démarre état de session
session_start();






//session_cache_limiter('private');  // pour éviter le message qui demande si on veut reposter les infos lorsque on fait back

if (eregi("(^http|^ftp)",$path))
{
	mail("exploitation@c2is.fr","hacking detected",date("Y-m-s_H:i:s")." >>>> ".$_SERVER["HTTP_HOST"]." >>>> ".$_SERVER["SCRIPT_NAME"]." >>>> ".$_SERVER["REMOTE_ADDR"]." >>> ".$path);
	die("SECURITY ERROR !! your personal data has been sent to administrator.");
}

$GLOBALS['path'] = $path;

// Fichier de paramètrage généraux front et back office
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

// Librairie des fonctions génériques Front Office Fullkit CMS + Smarty
require_once($path."include/lib_front.inc.php");
require_once($path."include/lib_navigation.inc.php");

// Class smarty extended pour le projet 
require($path."include/Smarty_local.class.php");

// Librairie spécifique au projet 
require_once($path."include/lib_local_front.inc.php");

// Ouverture de la connexion à la base
$db = new sql_db($Host, $UserName, $UserPass, $BaseName, false);

if(!$db->db_connect_id)
{
   message_die(CRITICAL_ERROR, "Connexion à la base de données impossible");
}

$template = new Smarty_local; // instanciation nouvel objet template enrichit par les parametres locaux
     
$template->compile_check = true; // vérifie si un template a été modifié a chaque appel
				 // peut être passé à False en production pour améliorer
				 // les performances. Attention lors des mises à jour
$template->debugging = DEBUG_SMARTY;    // Constante positionnée dans lib_global.inc.php

$template->caching = false; // cache de compilation des templates ? => ATTENTION avec les pages dynamiques..

// on s'affranchit de l'interpretation par smarty des { sur les js par ex.
// en changeant les délimiteurs gauche et droite par défaut par des #{
$template->left_delimiter = '#{';
$template->right_delimiter = '}#';

$template->register_function('smarty_trad', 'smarty_trad');

$GLOBALS['template']=$template;

// on vérifie si la rub courante a du contenu
if (isset($_REQUEST['Rub']) && $GLOBALS['Rub'] != _NAV_ACCUEIL)
{
   // si le param est passé dans la requete
   // on recupere la premiere rubrique fille qui possède du contenu
   // ou la rubrique en cours, si elle en a
   $GLOBALS['Rub'] = get_rub_filled($_REQUEST['Rub']);
}
else
{
   // aucun param passé, on est sur la home
   $GLOBALS['Rub'] = _NAV_ACCUEIL;
}
$aRub = getInfosRub($GLOBALS['Rub']);

// positionnement de la langue en cours ($_SESSION et prise en compte des changts de langue)




//if($_SERVER['REMOTE_ADDR'] == '213.162.49.33'){

	// Gestion des langues
	if($_SERVER['SERVER_NAME'] == 'www.ethic-etapes.com'){
		$strSQL = "SELECT id__langue, _langue_abrev, _langue_ext_sql FROM _langue WHERE id__langue = 2 LIMIT 1";
		$rstLangue = mysql_query($strSQL);

		if (mysql_num_rows($rstLangue) == 1)
		{
			$_SESSION['ses_langue']             = mysql_result($rstLangue,0,"id__langue");
			$_SESSION['ses_langue_ext']         = mysql_result($rstLangue,0,"_langue_abrev");
			$_SESSION['ses_langue_ext_sql']     = mysql_result($rstLangue,0,"_langue_ext_sql");
		}
	}elseif($_SERVER['SERVER_NAME'] == 'www.ethic-etapes.de'){
		$strSQL = "SELECT id__langue, _langue_abrev, _langue_ext_sql FROM _langue WHERE id__langue = 5 LIMIT 1";
		$rstLangue = mysql_query($strSQL);

		if (mysql_num_rows($rstLangue) == 1)
		{
			$_SESSION['ses_langue']             = mysql_result($rstLangue,0,"id__langue");
			$_SESSION['ses_langue_ext']         = mysql_result($rstLangue,0,"_langue_abrev");
			$_SESSION['ses_langue_ext_sql']     = mysql_result($rstLangue,0,"_langue_ext_sql");
		}
	}else{
		set_langue();
	}

	
//}




//Load libs
loadLibelles();
		

// recuperation du prefix en fonction de la langue
if ($_SESSION['ses_langue']==2) {		// usa + anglais
	$GLOBALS['prefix'] = "_en";
	$code_langue = "en";
	$str_language = "<meta http-equiv=\"Content-Language\" content=\"en-us\"/>";		

}
else {			// français
	$GLOBALS['prefix'] = "_fr";
	$code_langue = "fr";
	$str_language = "<meta http-equiv=\"Content-Language\" content=\"fr\"/>";	
	
}

if (!nav_exist($GLOBALS['Rub'],0)) // mettre 1 pour tester seulement les nav dont selected = 1
{
	$GLOBALS['Rub'] = 1;	
	redirect(_CONST_APPLI_PATH); // vérifie si la valeur de Rub existe dans l'arbo
   				    // renvoie sur la home page sinon
	exit();
}

// on récupére le chemin de nav courant
$navID = get_navID($GLOBALS['Rub']);

//==============================================================================
//RPL - 15/06/2011 : metas specifiques pour fiches centre et sejour
$tabMeta = array();
    
if( isset($_GET['id']) || isset($_GET['id_centre']) ){ 
    switch( $GLOBALS['Rub']){
        case _NAV_FICHE_CENTRE:
            $tabMeta = GetMetaCentre($_GET["id_centre"]);
            break;
        case _NAV_FICHE_ORGANISATEUR_CVL:
            $tabMeta = GetMetaCentreCvl($_GET["id_centre"]);
            break;
        case _NAV_ACCUEIL_GROUPE:
            $tabMeta = GetMetaAccueilGroupe($_GET["id"]);
            break;
        case _NAV_ACCUEIL_GROUPES_SCOLAIRES:
            $tabMeta = GetMetaSejourScolaire($_GET["id"]);
            break;
        case _NAV_ACCUEIL_INDIVIDUEL:
            $tabMeta = GetMetaAccueilIndividuel($_GET["id"]);
            break;
        case _NAV_ACCUEIL_SPORTIF:
            $tabMeta = GetMetaAccueilSportif($_GET["id"]);
            break;
        case _NAV_CLASSE_DECOUVERTE:
            $tabMeta = GetMetaSejourClasseDecouverte($_GET["id"]);
            break;
        case _NAV_ACCEUIL_REUNIONS:
            $tabMeta = GetMetaAccueilReunion($_GET["id"]);
            break;
        case _NAV_SHORT_BREAK:
            $tabMeta = GetMetaShortBreak($_GET["id"]);
            break;
        case _NAV_INCENTIVE:
            $tabMeta = GetMetaSeminaire($_GET["id"]);
            break;
        case _NAV_SEMINAIRES:
            $tabMeta = GetMetaSeminaire($_GET["id"]);
            break;
        case _NAV_CVL:
            $tabMeta = GetMetaSejourCvl($_GET["id"]);
            break;
        case _NAV_SEJOURS_TOURISTIQUES_GROUPE:
            $tabMeta = GetMetaSejourTouristique($_GET["id"]);
            break;
        case _NAV_STAGES_THEMATIQUES_GROUPE:
            $tabMeta = GetMetaStageThematiqueGroupe($_GET["id"]);
            break;
        case _NAV_STAGES_THEMATIQUES_INDIVIDUEL:
            $tabMeta = GetMetaStageThematiqueIndividuel($_GET["id"]);
            break;
        default:
            $tabMeta[0] = get_header($GLOBALS['Rub'],"title");
            $tabMeta[1] = strtolower(get_header($GLOBALS['Rub'],"meta_description"));
            $tabMeta[2] = strtolower(get_header($GLOBALS['Rub'],"meta_keyword"));
    }
}else{
    $tabMeta[0] = get_header($GLOBALS['Rub'],"title");
    $tabMeta[1] = strtolower(get_header($GLOBALS['Rub'],"meta_description"));
    $tabMeta[2] = strtolower(get_header($GLOBALS['Rub'],"meta_keyword"));
}
$template->assign("TITLE",$tabMeta[0]);	
$template->assign("META_KEYWORD",$tabMeta[2]);
$template->assign("META_DESCRIPTION",$tabMeta[1]);
//==============================================================================

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

//Gestion de la liste déroulante des langues
switch ($_SESSION['ses_langue'])
{
	case _ID_FR :
		$currentLang = 'FranÃ§ais';
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
if ($_SESSION['ses_langue'] != _ID_FR)
{
	$paramListeLang[] = array('id_name' => 'L', 'id' => _ID_FR); 
	$listeLang[] = array ('libelle' => 'FranÃ§ais', 'lien' => 'http://www.ethic-etapes.fr');
}

if ($_SESSION['ses_langue'] != _ID_EN)
{
	unset($paramListeLang);
	$paramListeLang[] = array('id_name' => 'L', 'id' => _ID_EN); 
	$listeLang[] = array ('libelle' => 'English', 'lien' => 'http://www.ethic-etapes.com');
}

if ($_SESSION['ses_langue'] != _ID_DE)
{
	unset($paramListeLang);
	$paramListeLang[] = array('id_name' => 'L', 'id' => _ID_DE); 
	$listeLang[] = array ('libelle' => 'German', 'lien' => 'http://www.ethic-etapes.de');
}
/*
if ($_SESSION['ses_langue'] != _ID_ES)
{
	unset($paramListeLang);
	$paramListeLang[] = array('id_name' => 'L', 'id' => _ID_ES); 	
	$listeLang[] = array ('libelle' => 'Spanish', 'lien' => 'processing/change_langue.action.php?L='._ID_ES);
}
*/
$template -> assign ('listeLang', $listeLang);

	//On récupère en session les filtres pour les garder lors de l'utilisation de la pagination 
	//=====================================================
	// RPL - 07/06/2011 : correction logique
	if($_REQUEST['requestFilter'])
		$_SESSION['filter'][$_GET['Rub']] = $_REQUEST;
	//=====================================================
	if (isset($_REQUEST['P']))
	{
		//trace($_REQUEST);
		$page = $_REQUEST['P'];
		$rub = $_REQUEST['Rub'];
		$_REQUEST = $_SESSION['filter'][$_GET['Rub']];
		$_REQUEST['P'] = $page;
		$_REQUEST['Rub'] = $rub;
	}
	$_SESSION['filter'][$_GET['Rub']] = $_REQUEST;	

require_once($path."include/inc_chang_lang.inc.php");

$template->assign("urlLoginEspaceMembre",get_url_nav(_NAV_ESPACE_MEMBRE));
// RPL 31/05/2011 : Espace membre seulement en FR
$template->assign("displayEspaceMembre", $_SESSION['ses_langue']==1 );
$template->assign("base_href",_CONST_APPLI_URL);

$template->assign("url_recherche",get_url_nav(_NAV_RECHERCHE));



if($_SESSION["AccessPreprodOK"] != 1){
	//redirect(_CONST_APPLI_URL."index_preprod.php");
	//die();
}



?>