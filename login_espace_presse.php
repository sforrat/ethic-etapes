<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	login_espace_membre.php						  
/*										  
/*	Description :	Login espace membre
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");


// connexion
if (isset($_REQUEST['login']) && isset($_REQUEST['mdp']))
{
	if (trim($_REQUEST['login']) != '' && trim($_REQUEST['mdp']) != '')
	{
		$login = stripcslashes(trim($_REQUEST['login']));
		$mdp = stripcslashes(trim($_REQUEST['mdp']));
		
		
		$sql = "SELECT id_membres 
		FROM membres 
		WHERE email = '".$login."' 
		AND mot_passe = '".$mdp."' 
		AND actif = 1 ";
	
		$rst = mysql_query($sql);
	}
	
	if (!$rst)
		echo mysql_error();
	
	if(mysql_num_rows($rst) == 1)
	{
		$_SESSION['user_connect'] = mysql_result($rst, 0, 'id_membres');
	}
	else 
	{
		$template->assign('errorMsg', get_libLocal('lib_error_login'));
		$template->assign('login', $_REQUEST['login']);
		$template->assign('mdp', $_REQUEST['mdp']);
	}
}

// deconnexion
elseif ($_REQUEST['action'] == 'deconnexion')
{
	unset ($_SESSION['user_connect']);
}


// redirection
if(!empty($_SESSION['user_connect']))
{	
		redirect(_CONST_APPLI_URL.get_url_nav(_NAV_DOSSIER_PRESSE));
	}	

// affichage du formulaire
else 
{
		$type = 'Presse';		
	$template->assign('type', $type);
	$template->assign('urlMdpOublie', get_url_nav(_NAV_MDP_OUBLIE_PRESSE));
	$template->assign('urlInscription', get_url_nav(_NAV_INSCRIPTION_PRESSE));
	$template->assign('action', get_url_nav($_REQUEST['Rub']));
	$template->assign('titre', mb_strtoupper(get_nav($_REQUEST['Rub']),'utf-8'));
	$template->display('login_espace_presse.tpl');
}

?>