<?

//si la session existe : 
$id_langue = 1;
if (isset ($_SESSION['ses_langue']) && $_SESSION['ses_langue']!="")
	$id_langue = $_SESSION['ses_langue'];

$sql_langue = "SELECT * from _langue where id__langue = ".$id_langue;
$rst_langue = mysql_query($sql_langue);

if (mysql_numrows($rst_langue)>0)
{
	$langueFile = "library_local/languages/lib_language_".mysql_result($rst_langue, 0, "_langue_abrev").".inc.php";
	if(file_exists($langueFile)) require $langueFile;
	else 
	{				
		$langueFile = "library_local/languages/lib_language_en.inc.php";
		require $langueFile ;
	}
}
else 
{
	$langueFile = "library_local/languages/lib_language_en.inc.php";
	if(file_exists($langueFile)) 	require $langueFile ;
}
?>
