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
		
$tabNav = get_navID($_GET["Rub"]);

$sql = "select trad__nav.id___nav,trad__nav._nav from trad__nav inner join _nav on (trad__nav.id___nav = _nav.id__nav) where trad__nav.id__langue=".$_SESSION["ses_langue"]." and id__nav_pere=".$tabNav[1]." and _nav.selected=1 order by _nav.ordre";
$result = mysql_query($sql);

while($myrow = mysql_fetch_array($result)){
	
	$tab['titre'] = mb_strtoupper($myrow["_nav"],"utf-8");
	if($tabNav[2] == $myrow["id___nav"]){
		$tab["classe"] ="active";
		$sql_S = "SELECT trad__nav.id___nav,trad__nav._nav from trad__nav inner join _nav on(trad__nav.id___nav = _nav.id__nav and
																							_nav.id__nav_pere = ".$tabNav[2]." and
																							_nav.selected=1 and 
																							trad__nav.id__langue=".$_SESSION["ses_langue"].") order by _nav.ordre";
		
		
		$result_S  = mysql_query($sql_S);
		while($myrow_S = mysql_fetch_array($result_S)){
			if($_GET["Rub"] == $myrow_S["id___nav"] || $tabNav[3]  == $myrow_S["id___nav"]){
				$tab2["classe"] ="active";
			}else{
				$tab2["classe"] ="";
			}
			$tab2["titre"] = $myrow_S["_nav"];
			$tab2["url"] = get_url_nav($myrow_S["id___nav"]);
			$tab["ss_rub"][] = $tab2;
		}
		
	}else{
		$tab["classe"] ="";
		
	}
	$tab["url"] = get_url_nav($myrow["id___nav"]);
	$TabNav[] = $tab;
	unset($tab2);
	unset($tab);
}


$this->assign("TabNav",$TabNav);


$this -> display('blocs/menuGaucheEdito.tpl');
?>
