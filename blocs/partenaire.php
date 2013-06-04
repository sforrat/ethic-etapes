<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	FFR 							  
/*	Date : 		
/*	Version :	1.0							  
/*	Fichier :	partenaire.php						  
/*										  
/*	Description :	Page Partenaire                
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
		
$sql = "select 
			partenaire.libelle,
			partenaire.visuel,
			partenaire.url,
			trad_partenaire.description
		from
			partenaire
		inner join 
			trad_partenaire on(trad_partenaire.id__langue=".$_SESSION["ses_langue"]." and trad_partenaire.id__partenaire=partenaire.id_partenaire)";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["visuel"] = getFileFromBDD($myrow["visuel"],"partenaire");
	$tab["libelle"] = $myrow["libelle"];
	$tab["description"] = $myrow["description"];
	if (!eregi("http", $myrow["url"])) {
		$tab["url"] = "http://".$myrow["url"];
	}else{
		$tab["url"] = $myrow["url"];
	}
	$TabPartenaire[] = $tab;
	unset($tab);
}
$this->assign('TabPartenaire',$TabPartenaire);

$this -> display('blocs/partenaire.tpl');
?>
