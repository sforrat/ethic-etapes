<html>
<head>
<style type="text/css">
<!--
.style1 {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
	font-weight: bold;
	color: #CC0000;
}
.style2 {
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
	color: #CC0000;
}
.style5 {font-family: Arial, Helvetica, sans-serif; font-size: 14px; font-weight: bold; color: #CC0000; }
.style8 {font-size: 16px}
.style10 {
	font-size: 16px;
	color: #CC0000;
	font-family: Arial, Helvetica, sans-serif;
	font-weight: bold;
}
.style11 {
	color: #CC0000
}
body,td,th {
	font-family: Arial, Helvetica, sans-serif;
	font-size: 12px;
}
-->
</style>
</head>
<body>

<?


// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");


//			ce bout de style permet à excel d'interpreter les <br>
//		 	comme des saut de lignes et non des changement de cellules
$somecontent = "<style>
<!--
br
{mso-data-placement:same-cell;}
-->
</style>
<table border=1>";

$sql = "select * from contact";
$result = mysql_query($sql);
$somecontent .="<tr>
					<td>Date </td>
					<td>Type contact</td>
					<td>Civilite</td>
					<td>Nom </td>
					<td>Nom ecole</td>
					<td>Email </td>
					<td>Adresse </td>
					<td>Code postal</td>
					<td>Ville </td>
					<td>Pays </td>
					<td>Telephone </td>
					<td>Fax </td>
					<td>Niveau scolaire</td>
					<td>Etablissement type</td>
					<td>Discipline sportive</td>
					<td>Structure </td>
					<td>Media </td>
					<td>Association </td>
					<td>Collectivite </td>
					<td>Fonction </td>
					<td>Equipement </td>
					<td>Commentaire </td>
					<td>Newsletter </td>
					
				</tr>	";
while($myrow = mysql_fetch_array($result)){
	$somecontent .= "<tr valign='top'><td>".$myrow["date"]."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["type_contact"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["civilite"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["nom"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["ecole"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["email"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["adresse"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["cp"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["ville"])."</td>";
	
	$sql_S = "select libelle from trad_pays where id__pays=".$myrow["id_pays"]." and id__langue=1";
	$result_S = mysql_query($sql_S);
	$somecontent .= "<td>".mysql_result($result_S,0,"libelle")."</td>";
	
	
		
	$somecontent .= "<td>".utf8_decode($myrow["telephone"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["fax"])."</td>";
	
	$car = substr($myrow["id_types_newsletter"],-1);
  if($car == ","){
    $sejour_niveau_scolaire = substr($myrow["id_sejour_niveau_scolaire"],0,-1);
  }else{
    $sejour_niveau_scolaire = $myrow["id_sejour_niveau_scolaire"];
  }
	$sql_S = "select libelle from trad_sejour_niveau_scolaire where id__sejour_niveau_scolaire in(".$sejour_niveau_scolaire.") and id__langue=1";
	$result_S = mysql_query($sql_S);
	$i=0;
	$somecontent .= "<td>";
	while($myrow_S = mysql_fetch_array($result_S)){
		if($i>0){
			$somecontent .="<br>";
		}
		$somecontent .=utf8_decode($myrow_S["libelle"]);
		$i=1;
	}
	$somecontent .= "</td>";
	
	
	$car = substr($myrow["id_types_newsletter"],-1);
  if($car == ","){
    $etablissement_type = substr($myrow["id_etablissement_type"],0,-1);
  }else{
    $etablissement_type = $myrow["id_etablissement_type"];
  }
	$sql_S = "select libelle from trad_etablissement_type where id__etablissement_type in (".$etablissement_type.") and id__langue=1";
	$result_S = mysql_query($sql_S);
	$i=0;
	$somecontent .= "<td>";
	while($myrow_S = mysql_fetch_array($result_S)){
		if($i>0){
			$somecontent .="<br>";
		}
		$somecontent .=utf8_decode($myrow_S["libelle"]);
		$i=1;
	}
	$somecontent .= "</td>";	
	
	
	$car = substr($myrow["id_types_newsletter"],-1);
  if($car == ","){
    $discipline_sportive = substr($myrow["id_discipline_sportive"],0,-1);
  }else{
    $discipline_sportive = $myrow["id_discipline_sportive"];
  }
	$sql_S = "select libelle from trad_discipline_sportive where id__discipline_sportive in(".$discipline_sportive.") and id__langue=1";
	$result_S = mysql_query($sql_S);
	$i=0;
	$somecontent .= "<td>";
	while($myrow_S = mysql_fetch_array($result_S)){
		if($i>0){
			$somecontent .="<br>";
		}
		$somecontent .=utf8_decode($myrow_S["libelle"]);
		$i=1;
	}
	$somecontent .= "</td>";
	
	$somecontent .= "<td>".utf8_decode($myrow["structure"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["media"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["association"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["collectivite"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["fonction"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["equippement"])."</td>";
	$somecontent .= "<td>".utf8_decode(nl2br($myrow["commentaire"]))."</td>";
	
	
  $car = substr($myrow["id_types_newsletter"],-1);
  if($car == ","){
    $newsletter = substr($myrow["id_types_newsletter"],0,-1);
  }else{
    $newsletter = $myrow["id_types_newsletter"];
  }
	
	$sql_S = "select libelle from trad_types_newsletter where id__types_newsletter in(".$newsletter.") and id__langue=1";
	$result_S = mysql_query($sql_S);
	$i=0;
	$somecontent .= "<td>";
	while($myrow_S = mysql_fetch_array($result_S)){
		if($i>0){
			$somecontent .="<br>";
		}
		$somecontent .=utf8_decode($myrow_S["libelle"]);
		$i=1;
	}
	$somecontent .= "</td>";
	
	$somecontent .= "</tr>";
}
$somecontent .="</table>";




$filename = 'export_contact_general.xls';


// Assurons nous que le fichier est accessible en écriture
if (is_writable($filename)) {

    // Dans notre exemple, nous ouvrons le fichier $filename en mode d'ajout
    // Le pointeur de fichier est placé à la fin du fichier
    // c'est là que $somecontent sera placé
    if (!$handle = fopen($filename, 'w')) {
         echo "Impossible d'ouvrir le fichier ($filename)";
         exit;
    }

    // Ecrivons quelque chose dans notre fichier.
    if (fwrite($handle, $somecontent) === FALSE) {
        echo "Impossible d'écrire dans le fichier ($filename)";
        exit;
    }

    echo "L'écriture dans le fichier ($filename) a réussi";
    echo "<br><a href='telecharge.php?src=$filename'>Cliquez ici pour télécharger le fichier d'export</a>";

    fclose($handle);

} else {
    echo "Le fichier $filename n'est pas accessible en écriture.";
}
?>
</body>
</html>