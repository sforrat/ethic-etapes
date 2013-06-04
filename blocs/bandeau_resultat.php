<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	bloc_gauche.php						  
/*										  
/*	Description :	Colonne de gauche                 
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";

// Récupération de la Rub
// selon qu'on vient de la recherche multicritères (Rub=4 par défaut)
// ou d'ailleurs (Rub fournie en paramètre)
if(isset($GLOBALS['nav_amb']))
	$Rub = $GLOBALS['nav_amb'];
else
	$Rub = $_REQUEST['Rub'];

$this -> assign ("titre", mb_strtoupper(get_trad_nav($_REQUEST['Rub']), "utf-8"));

	$sql = "SELECT titre, texte, visuel, item_table_ref_req
			FROM _object 
			INNER JOIN gab_bandeau_resultat on item_table_ref_req = id_gab_bandeau_resultat
			WHERE table_ref_req = 'gab_bandeau_resultat' 
			AND id__nav = ".$Rub.'
			AND id__langue = '.$_SESSION['ses_langue'];
	
	$rst = mysql_query($sql);
	
	$nbRes = mysql_num_rows($rst);
	
	if ($nbRes == 1)
	{		
		if (mysql_result($rst, 0, 'titre') != '')
			$this -> assign ("titre", mb_strtoupper(mysql_result($rst, 0, 'titre'),'utf-8'));
		$this -> assign ("texte", mysql_result($rst, 0, 'texte'));
		//$this -> assign ("texte", "Ref=".mysql_result($rst, 0, 'item_table_ref_req')." NAV=".$_REQUEST['Rub']);
		$this -> assign ("visuel", getFileFromBDD(mysql_result($rst, 0, 'visuel'),'gab_bandeau_resultat'));
	}
	
$this -> display('blocs/bandeau_resultat.tpl');	
	
?>