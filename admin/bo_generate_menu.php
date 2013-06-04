<?

$chemin = _CONST_APPLI_URL."admin/bo_static_menu.php";
$file = fopen($chemin, "r");
$cont = "";
while (!feof($file)) { //on parcoure toutes les lignes
  $cont .= fgets($file, 4096); // lecture du contenu de la ligne
}

$html = fopen("menu.php", "w");	
fwrite($html,$cont);

echo "Publication Terminée";
fclose($html);
?>