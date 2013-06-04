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

$sql = "select * from inscription_newsletter";
$result = mysql_query($sql);
$somecontent .="<tr>
					<td>Date </td>
					<td>Civilit&eacute;</td>
					<td>Nom </td>
					<td>Email </td>
					<td>Newsletter </td>
					
				</tr>	";
while($myrow = mysql_fetch_array($result)){

	$somecontent .= "<td>".utf8_decode($myrow["date"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["civilite"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["nom"])."</td>";
	$somecontent .= "<td>".utf8_decode($myrow["email"])."</td>";
	
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




$filename = 'export_contact_newsletter.xls';


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