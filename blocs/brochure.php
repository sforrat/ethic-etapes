<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		20/05/2010
/*	Version :	1.0							  
/*	Fichier :	brochure.php						  
/*										  
/*	Description :	Page Brochure                
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
		
$sql = "select 
			brochure.pdf,
			brochure.visuel,
			trad_brochure.libelle,
			trad_brochure.description
		from
			brochure
		inner join 
			trad_brochure on(trad_brochure.id__langue=".$_SESSION["ses_langue"]." and trad_brochure.id__brochure=brochure.id_brochure)";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["visuel"] = getFileFromBDD($myrow["visuel"],"brochure");
	$tab["pdf"] = getFileFromBDD($myrow["pdf"],"brochure");
	$tab["libelle"] = $myrow["libelle"];
	$tab["description"] = $myrow["description"];
	
	$TabBrochure[] = $tab;
	unset($tab);
}
$this->assign('TabBrochure',$TabBrochure);

$this -> display('blocs/brochure.tpl');
?>
