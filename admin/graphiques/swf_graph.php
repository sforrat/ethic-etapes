<?
/**********************************************************************************/
/*	C2IS : 		xxprojetxx
/*	Auteur : 	API 							  
/*	Date : 		Fevrier 2004						  
/*	Version :	1.0							  
/*	Fichier :	swf_graph.php					  	  
/*										  
/*	Description :	Page de parametrage des graphiques                	  
/*										  
/**********************************************************************************/

// Initialisation de la page
$path="../../";
require($path."include/inc_header.inc.php");

// *** HISTOGRAMME
if ($_REQUEST['id_graph']==1) {
	$legende_h = "Nbe de clic";
	$legende_a = "Jours";
	$legende = "";
	
	
	$chaine = "select * from co_clics where id_co_realisation=".$_SESSION['id_rea']." order by date";
	$RS = mysql_query($chaine);

	$list = "";
	for($i=0;$i<mysql_num_rows($RS);$i++) {
		$couleur = ereg_replace("#","0x",mysql_result($RS,$i,"couleur"));
		if ($list=="") {
			$list = $list.Cdate(mysql_result($RS,$i,"date"),2)."|".mysql_result($RS,$i,"nbe_clics")."|".$couleur;
		}else{
			$list = $list.";".Cdate(mysql_result($RS,$i,"date"),2)."|".mysql_result($RS,$i,"nbe_clics")."|".$couleur;
		}
	}
	
	$chaine_final = "&legende_h=".$legende_h;
	$chaine_final = $chaine_final."&legende_a=".$legende_a;
	$chaine_final = $chaine_final."&legende=".$legende;
	$chaine_final = $chaine_final."&list=".$list;

// *** LINEAIRE
}else if($_REQUEST['id_graph']==3) {
	$legende_h = "Nbe de clic";
	$legende_a = "Jours";
	$legende = "";

	$list = "10|50;30|30;50|75;70|150;80|50";

	$chaine_final = "&legende_h=".$legende_h;
	$chaine_final = $chaine_final."&legende_a=".$legende_a;
	$chaine_final = $chaine_final."&legende=".$legende;
	$chaine_final = $chaine_final."&flag_lissage=0";
	$chaine_final = $chaine_final."&list=".$list;

// *** CAMEMBERT
}else{

	$chaine = "select id_co_campagne from co_realisation where id_co_realisation=2";//.$_SESSION['id_rea'];
	$RS = mysql_query($chaine);

	if (mysql_num_rows($RS)>0) {
		$chaine = "select sum(nbe_clics) as total from co_clics, co_realisation where co_clics.id_co_realisation=co_realisation.id_co_realisation and id_co_campagne=".mysql_result($RS,0,"id_co_campagne");
		$RStotal = mysql_query($chaine);

		if (mysql_num_rows($RStotal)>0) {
			$total = mysql_result($RStotal,0,"total");
		}

		$chaine = "select * from co_realisation where id_co_campagne=".mysql_result($RS,0,"id_co_campagne")." order by date_realisation";
		$RS = mysql_query($chaine);

		$list = "";
		for($i=0;$i<mysql_num_rows($RS);$i++) {

			$url = "";

			// *** composition du libelle
				$str_lib="";
				$str = "select * from co_support where id_co_support=".mysql_result($RS,$i,"id_co_support");
				$RS_lib = mysql_query($str);
	
				if (mysql_num_rows($RS_lib)>0) {
					$str_lib = $str_lib.mysql_result($RS_lib,0,"libelle")." / ";
				}

				$str = "select * from co_format where id_co_format=".mysql_result($RS,$i,"id_co_format");
				$RS_lib = mysql_query($str);
	
				if (mysql_num_rows($RS_lib)>0) {
					$str_lib = $str_lib.mysql_result($RS_lib,0,"libelle");
				}

			// cas du premier
			if ($i==0) {
				$chaine_final = $chaine_final."&list_fond=".urlencode(setFlashText($str_lib))."|".$url;
			}else{
				$str  = "select sum(nbe_clics) as total from co_clics where id_co_realisation=".mysql_result($RS,$i,"id_co_realisation");
				$RS2 = mysql_query($str);
	
				if (mysql_num_rows($RS2)>0) {
					$couleur = ereg_replace("#","0x",mysql_result($RS,$i,"couleur_camembert"));
	
					$pourcentage = ((mysql_result($RS2,0,"total") / $total)*100);

					$item = array("pourcentage" => $pourcentage,"libelle" => $str_lib ,"url" => $url,"couleur" => $couleur);
					$tab[] = $item;
				}
			}
		}

		
		// *** tri du tableau
		echo(sort($tab));

		for ($i=0;$i<count($tab);$i++) {
			if ($list=="") {
				$list = $list.urlencode(setFlashText($tab[$i]["libelle"]))."|".$tab[$i]["pourcentage"]."|".$tab[$i]["couleur"]."|".$tab[$i]["url"];
			}else{
				$list = $list.";".urlencode(setFlashText($tab[$i]["libelle"]))."|".$tab[$i]["pourcentage"]."|".$tab[$i]["couleur"]."|".$tab[$i]["url"];
			}
		}
	}

	$chaine_final = $chaine_final."&list=".$list;
}

$chaine_final = $chaine_final."&fin_chargement=1";

echo($chaine_final);
?>
