<?
// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");
$img_defaut = 'images/upload/portfolio_img/home_generique.jpg';
$id_thematique = isset($_REQUEST['theme']) ? $_REQUEST['theme'] : 1;

$arrayThematique = array(1,2,3,4,5);

echo "begin=1&liste=";
foreach ($arrayThematique as $theme)
{
	$sql = "SELECT id_bandeau, visuel 
	FROM bandeau 
	WHERE ".get_multi_fullkit_choice('id_bandeau_thematique',$theme)." 
	AND ".get_multi_fullkit_choice('id_actualite_thematique',$id_thematique); 
	$sql .= " ORDER BY RAND()";
	//$sql .= " nb_aleatoire";
	
	//$sql = "SELECT id_bandeau, visuel FROM bandeau ORDER BY id_bandeau ASC";
	$rst = mysql_query($sql);
	
//	while($myrow = mysql_fetch_array($rst)){
//		$image = getFileFromBDD($myrow["visuel"], "bandeau", "../");
//		$titre = getTradTable('bandeau',$_SESSION['ses_langue'], 'titre',$myrow['id_bandeau']);
//		$sous_titre = getTradTable('bandeau',$_SESSION['ses_langue'], 'sous_titre',$myrow['id_bandeau']);
//		$description = getTradTable('bandeau',$_SESSION['ses_langue'], 'description',$myrow['id_bandeau']);
//		$url = getTradTable('bandeau',$_SESSION['ses_langue'], 'url',$myrow['id_bandeau']);
//		
//		$arrayResult[]  = urlencode($image.'|'.$titre.'|'.$sous_titre.'|'.$description.'|'.$url);
//	}
	
	
	if (mysql_num_rows($rst) > 0)
	{
		$image = getFileFromBDD(mysql_result($rst, 0, "visuel"), "bandeau", "../");
		$titre = getTradTable('bandeau',$_SESSION['ses_langue'], 'titre',mysql_result($rst, 0, 'id_bandeau'));
		$sous_titre = getTradTable('bandeau',$_SESSION['ses_langue'], 'sous_titre',mysql_result($rst, 0, 'id_bandeau'));
		$description = getTradTable('bandeau',$_SESSION['ses_langue'], 'description',mysql_result($rst, 0, 'id_bandeau'));
		$url = getTradTable('bandeau',$_SESSION['ses_langue'], 'url',mysql_result($rst, 0, 'id_bandeau'));
		
		$arrayResult[]  = $image.'|'.$titre.'|'.$sous_titre.'|'.$description.'|'.$url;
	}
	else 
	{
		$arrayResult[]  = $img_defaut.'||||';
	}
}


$nbResult = count($arrayResult);
for ($i = 0 ; $i < $nbResult ; $i++)
{
	if ($i != 0)
		echo ';';
	echo str_replace(";"," ",html_entity_decode($arrayResult[$i]));
}

echo "&tempo=5000&end=1";


?>