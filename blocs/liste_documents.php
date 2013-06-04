<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	liste_documents.php						  
/*										  
/*	Description :	Listes de documents pour l'espace memebre                    
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";

if ($_REQUEST['Rub'] == _NAV_CHARTE_GRAPHIQUE)
	$type = 'em_chartre_graphique';
else if ($_REQUEST['Rub'] == _NAV_ETAPES_ECHOS)
	$type = 'em_etape_echo';
else if ($_REQUEST['Rub'] == _NAV_DOSSIER_PRESSE)
	$type = 'ep_presse';	
else 
	$type = "";

if ($type != "")
{
	$sql = "SELECT id_".$type.", fichier, date FROM  ".$type." 
	WHERE ".get_multi_fullkit_choice('id_centre', $_SESSION['user_centre']);
	$rst = mysql_query($sql);

	
	if (!$rst)
		echo mysql_error().' - '.$sql;
		
	$nbRes = mysql_num_rows($rst);
	
	for ($i = 0 ; $i < $nbRes ; $i++)
	{
		$fichier = getFileFromBDD(mysql_result($rst, $i, 'fichier'), $type);
		$extension = strrchr($fichier,'.');
		$extension = substr($extension,1) ;   
		
		if (file_exists($fichier))
		{
			$listeFic[] = array('picto' => 'picto_pdf.png', //picto_archive.png
								'titre' => getTradTable($type, $_SESSION['ses_langue'], 'titre', mysql_result($rst, $i, 'id_'.$type)),
								'langue' => getTradTable($type, $_SESSION['ses_langue'], 'langue', mysql_result($rst, $i, 'id_'.$type)),
								'fichier' => $fichier,
								'taille' => ceil(filesize($fichier)/1000),
								'date' => mysql_result($rst, $i, 'date'),
								'type' => $extension);
		}
	}
	
	$this -> assign ('listeFic', $listeFic);
	
	$this -> display('blocs/liste_documents.tpl');
}
?>