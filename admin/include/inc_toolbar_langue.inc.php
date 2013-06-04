<? 
/******************************************************************************************/
/*	C2IS : 		Projet xxx					          */
/*	Auteur : 	API 								  */
/*	Date : 		Mars 2006							  */
/*	Version :	1.0								  */
/*										  	  */	
/*	Description :	Barre de gestion des langues
/******************************************************************************************/

?>
<script language="javascript">
function majLangue() {
	document.form_langue.submit();
}
</script>
<script language="javascript">
function majPays() {
	document.form_pays.submit();
}
</script>
<table  cellspacing="2" cellpadding="2" <?   if($_SESSION['ses_profil_user'] == _PROFIL_CENTRE){ echo "style='visibility:hidden'";}?> >

<tr>
<form name="form_langue" action="<?=NomFichier($PHP_SELF,0)."?".$QUERY_STRING?>" method="post"> 
<td><?=$inc_toolbar_langue_langue;?></td>
<td >
<select name="L" class="InputText" onChange="majLangue();">
<?
// *** liste de sélection de la langue
$chaine = "SELECT * FROM _langue ";

//En fonction de l'utilisateur, on affiche les langues auquelles il a droit.
if ($_SESSION['ses_profil_user']!=1)
{
	$chaine.= " WHERE id__langue in (".$_SESSION['ses_id_langue_user'].")";
}
$chaine .=" order by id__langue";

$RS_langue = mysql_query($chaine);

for ($i=0; $i< mysql_num_rows($RS_langue) ; $i++) {
	//SBA 07/08/06 -> deplacement du set de la variable $langue
        //$langue  = mysql_result($RS_langue,$i,"_langue"); 

    if (($_REQUEST['L']==mysql_result($RS_langue,$i,"id__langue"))||($_SESSION['ses_langue']==mysql_result($RS_langue,$i,"id__langue"))) 
        {
	       	$str_selected = " selected ";
	       	$_SESSION['langue']  = mysql_result($RS_langue,$i,"_langue"); 
	       	$_SESSION['ses_langue']          = mysql_result($RS_langue,$i,"id__langue");
					$_SESSION['ses_langue_ext']      = mysql_result($RS_langue,$i,"_langue_abrev");
					$_SESSION['ses_langue_mere']      = mysql_result($RS_langue,$i,"lan_id");
					$_SESSION['ses_langue_ext_sql']  = "";
       	}
       	else
       	{
			$str_selected = " ";
	}
	echo("<option value=\"".mysql_result($RS_langue,$i,"id__langue")."\" ".$str_selected." >".mysql_result($RS_langue,$i,"_langue")."</option>");
}

// *** langue par défaut
if (!isset($_SESSION['ses_langue']) || ($_SESSION['ses_langue']=="")) {
	
	$chaine = "SELECT * FROM _langue where _langue_by_default=1";
	
	//En fonction de l'utilisateur, on affiche les langues auquelles il a droit.
	if ($_SESSION['ses_profil_user']!=1)
	{
		$str_langue_autorise = implode(",",$_SESSION['ses_id_langue']);
		$chaine.= " and id__langue in (".$str_langue_autorise.")";
	}


	$RS = mysql_query($chaine);
	
	if (mysql_num_rows($RS)>0) 
	{
		$_SESSION['langue']  = mysql_result($RS,0,"_langue"); 
	 	$_SESSION['ses_langue']          = mysql_result($RS,0,"id__langue");
		$_SESSION['ses_langue_ext']      = mysql_result($RS,0,"_langue_abrev");
		$_SESSION['ses_langue_mere']     = mysql_result($RS,0,"lan_id");
	}
	else
	{
		$_SESSION['langue']  = mysql_result($RS_langue,0,"_langue"); 
	 	$_SESSION['ses_langue']          = mysql_result($RS_langue,0,"id__langue");
		$_SESSION['ses_langue_ext']      = mysql_result($RS_langue,0,"_langue_abrev");
		$_SESSION['ses_langue_mere']     = mysql_result($RS_langue,0,"lan_id");
	}
	$_SESSION['ses_langue_ext_sql']  = "";
}
?>
</select></td>
</form>
</tr>
</table>
