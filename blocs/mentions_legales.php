<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	RPL 							  
/*	Date : 		SEPTEMBRE 2010
/*	Version :	1.0							  
/*	Fichier :	mentions_legales.php						  
/*										  
/*	Description :	Bloc de cr�dits photos sous les mentions l�gales �ditoriales                 
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";

// r�cup�rations des cr�dits photo
$sqlQuery = "SELECT img, auteur FROM portfolio_img
			WHERE auteur IS NOT NULL AND auteur <> ''
				AND id_portfolio_rub NOT IN (1,2,61,62,63,64,65,66,67,69,71,72,73,74,75,76)
			ORDER BY img";
$sqlResult = set_query($sqlQuery);
while ( $row = mysql_fetch_array($sqlResult, MYSQL_ASSOC) ){
	$arrCredits[] = $row;
}
$this -> assign( 'arrCredits', $arrCredits );

$this -> display('blocs/mentions_legales.tpl');
?>
