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
	//$sql .= " ORDER BY RAND()";
	$sql .= " ORDER BY id_bandeau ASC";
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
		while($myrow = mysql_fetch_array($rst)){
	  		$image = getFileFromBDD($myrow["visuel"], "bandeau", "../");
	  		$titre = getTradTable('bandeau',$_SESSION['ses_langue'], 'titre',$myrow['id_bandeau']);
	  		$sous_titre = getTradTable('bandeau',$_SESSION['ses_langue'], 'sous_titre',$myrow['id_bandeau']);
	  		$description = getTradTable('bandeau',$_SESSION['ses_langue'], 'description',$myrow['id_bandeau']);
	  		$url = getTradTable('bandeau',$_SESSION['ses_langue'], 'url',$myrow['id_bandeau']);
	  		
	  		if( $description != "" )
		  		$arrayResult[]  = urlencode(html_entity_decode($image.'|'.$titre.'|'.$sous_titre.'|'.$description.'|'.$url));
		}
	}
	else 
	{
		$arrayResult[]  = $img_defaut.'||||';
	}
}

if( count($arrayResult) == 0 ){
	$arrayResult[]  = $img_defaut.'||||';
}

	
$nbResult = count($arrayResult);
for ($i = 0 ; $i < $nbResult ; $i++)
{
	if ($i != 0)
		echo ';';
	echo str_replace(";"," ",$arrayResult[$i]);
}

echo "&tempo=8000&end=1";

echo "<hr />";
foreach( $arrayResult as $res ){
	$tmp = explode("%7C",$res);
	foreach($tmp as $membre)
		echo "- ".$membre."<br />";
	echo "<hr />";
}

?>