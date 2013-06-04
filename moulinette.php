<?
// Initialisation de la page
$path="./";
require($path."include/inc_header.inc.php");


$sql =  "select 
            id_accueil_groupes_jeunes_adultes,
            sejour_preparation_commentaire, 
            sejour_rentree_commentaire, 
            sejour_oxygenation_commentaire 
         from 
            accueil_groupes_jeunes_adultes";
            
$result = mysql_query($sql) or die($sql.mysql_error());

while($myrow = mysql_fetch_array($result)){
  $sql_U = "update trad_accueil_groupes_jeunes_adultes set 
              sejour_preparation_commentaire='".addslashes($myrow["sejour_preparation_commentaire"])."' ,
              sejour_rentree_commentaire='".addslashes($myrow["sejour_rentree_commentaire"])."' ,
              sejour_oxygenation_commentaire='".addslashes($myrow["sejour_oxygenation_commentaire"])."'  
            where
            
            id__accueil_groupes_jeunes_adultes=".$myrow["id_accueil_groupes_jeunes_adultes"]." and id__langue=1";
            
            echo $sql_U."<br><br><br>";
  $result_U = mysql_query($sql_U) or die($sql_U.mysql_error());
}
            

?>