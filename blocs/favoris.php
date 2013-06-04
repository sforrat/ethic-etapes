<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	DCA 							  
/*	Date : 		JUILLET 2010
/*	Version :	1.0							  
/*	Fichier :	favoris.php						  
/*										  
/*	Description :	Bloc liens favoris               
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="./";
		
$sql = "select 
			liens_favoris.libelle,
			liens_favoris.visuel,
			liens_favoris.url,
			trad_liens_favoris.description
		from
			liens_favoris
		inner join 
			trad_liens_favoris on(trad_liens_favoris.id__langue=".$_SESSION["ses_langue"]." and trad_liens_favoris.id__liens_favoris=liens_favoris.id_liens_favoris)";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
	$tab["visuel"] = getFileFromBDD($myrow["visuel"],"liens_favoris");
	$tab["libelle"] = $myrow["libelle"];
	$tab["description"] = $myrow["description"];
	if (!eregi("http", $myrow["url"])) {
		$tab["url"] = "http://".$myrow["url"];
	}else{
		$tab["url"] = $myrow["url"];
	}
	$TabFavoris[] = $tab;
	unset($tab);
}

$this->assign('TabFavoris', $TabFavoris);

$this -> display('blocs/favoris.tpl');
?>
