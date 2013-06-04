<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	sejour.php						  
/*										  
/*	Description :	Page sejour
/**********************************************************************************/

// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");

// inclusion des filtres smarty
include($path."include/inc_output_filters.inc.php");


$sql = "SELECT * FROM em_ref_fournisseur WHERE id_em_ref_fournisseur = ".$_REQUEST['idF'];
$rst = mysql_query($sql);

if (!$rst)
	echo mysql_error().' - '.$sql;
else 
{
	$nbRes = mysql_numrows($rst);
	if ($nbRes == 1)
	{
		$template -> assign ('titre', mb_strtoupper(mysql_result($rst, 0, 'societe'),'utf-8'));

		$texte = "";
		if (mysql_result($rst, 0, 'adresse1') != '')
			$texte .= '<strong>'.get_libLocal('lib_adresse'). ' : </strong>'.mysql_result($rst, 0, 'adresse1');
			
		if (mysql_result($rst, 0, 'adresse2') != '')
			$texte .= ' '.mysql_result($rst, 0, 'adresse2');			
			
		if (mysql_result($rst, 0, 'cp') != '')	
			$texte .= '<br/><strong>'.get_libLocal('lib_code_postal'). ' : </strong>'.mysql_result($rst, 0, 'cp');
			
		if (mysql_result($rst, 0, 'ville') != '')
			$texte .= '<br/><strong>'.get_libLocal('lib_ville'). ' : </strong>'.mysql_result($rst, 0, 'ville');
			
		if (mysql_result($rst, 0, 'telephone') != '')
			$texte .= '<br/><strong>'.get_libLocal('lib_telephone'). ' : </strong>'.mysql_result($rst, 0, 'telephone');
			
		if (mysql_result($rst, 0, 'email') != '')
			$texte .= '<br/><strong>'.get_libLocal('lib_email'). ' : </strong>'.mysql_result($rst, 0, 'email');
			
		if (mysql_result($rst, 0, 'site_internet') != '')
			$texte .= '<br/><strong>'.get_libLocal('lib_site_internet'). ' : </strong><a href="'.mysql_result($rst, 0, 'site_internet').'">'.mysql_result($rst, 0, 'site_internet').'</a>';
			
		if (mysql_result($rst, 0, 'prenom') != '')
			$texte .= '<br/><strong>'.get_libLocal('lib_prenom'). ' : </strong>'.mysql_result($rst, 0, 'prenom');
			
		if (mysql_result($rst, 0, 'nom') != '')
			$texte .= '<br/><strong>'.get_libLocal('lib_nom'). ' : </strong>'.mysql_result($rst, 0, 'nom');
			
		if (mysql_result($rst, 0, 'fonction') != '')
			$texte .= '<br/><strong>'.get_libLocal('lib_fonction'). ' : </strong>'.mysql_result($rst, 0, 'fonction');
			
		if (mysql_result($rst, 0, 'condition_catalogue') != '')
			$texte .= '<br/><strong>'.get_libLocal('lib_condition_catalogue'). ' : </strong>'.mysql_result($rst, 0, 'condition_catalogue');
		
		$template -> assign ('texte', $texte);
	}
	
}


		
$template->display('infos_fournisseur.tpl');
?>