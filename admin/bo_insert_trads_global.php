<?

/**********************************************************************************/
/*	C2IS : 		Projet 					          */
/*	Auteur : 	 							  */
/*	Date : 		Fevrier 2008						  */
/*	Version :	1.0							  */
/*	Fichier :	extraction_traduction.php			  */
/*										  */	
/*	Description : 
/*										  */
/**********************************************************************************/
require "../include/class.mysql.inc.php";
$nbtrads=1;
$TdBgColor1="#D7E1EE";
$TdBgColor2="#E6F5FB";
$bg=$TdBgColor1;
//insertion en base
?>

<script type="text/javascript">


function IsNumeric(sText)
{
   var ValidChars = "0123456789.";
   var IsNumber=true;
   var Char;

 
   for (i = 0; i < sText.length && IsNumber == true; i++) 
      { 
      Char = sText.charAt(i); 
      if (ValidChars.indexOf(Char) == -1) 
         {
         	IsNumber = false;
         }
      }
   return IsNumber;
   
   }


function increase_trads()
{
	
	if(this.document.form_trad.nbtot.value != '')
	{
		if(IsNumeric(this.document.form_trad.nbtot.value))
			var val=this.document.form_trad.nbtot.value;
		else
		{
			alert('Veuillez saisir un chiffre');
			return;
		}	
	}
	else
	{
		var val=this.document.form_trad.nbtrads.value;
		val++;
	}
	
	this.document.form_trad.nbtrads.value = val;
	form_trad.submit(); 
	
	return 0;
}
	
</script>
<form name='form_trad' method='post' action='<? NomFichier($PHP_SELF,0)."?TableDef="._ID_TAB_DEF_INSERT_LIB ?>' >
	<table cellspacing=0 cellpadding=0>
		<tr>
			<td valign="top" colspan="4"> 	
					<strong> <span><? echo utf8_encode('Insertion de libellés') ?> </span> </strong></td>
		</tr>
		<tr>
			<td colspan="4" style="border-bottom:solid 1px #000">&nbsp;</td>
		</tr>

<?
if( isset($_REQUEST['insert']))
{
	
	if(isset($_REQUEST['nbtrads']))
		$nbtrads=$_REQUEST['nbtrads'];
	
	$db = new sql_db($Host, $UserName, $UserPass, $BaseName, false);
	if(!$db->db_connect_id)
	{
			echo '<br>echec connexion';
	   	message_die(CRITICAL_ERROR, "Connexion à base de données impossible");
	}
	?>
	<td>
	<?
	for($i=1;$i<=$nbtrads;$i++)
	{
		if(isset($_REQUEST['code_'.$i]) && $_REQUEST['code_'.$i] != '')
		{
			$strVerif="SELECT count(*) FROM "._CONST_TRAD_TABLE_NAME." WHERE "._CONST_TRAD_CODE_LIB."='".$_REQUEST['code_'.$i]."'";
			if(mysql_result(mysql_query($strVerif),0,0) == 0)
			{
				$strInsert="INSERT INTO "._CONST_TRAD_TABLE_NAME." values ('','".$_REQUEST['code_'.$i]."','".addslashes($_REQUEST['libelle_'.$i])."','')";
				
				mysql_query($strInsert);
				$strLangue="SELECT id__langue FROM _langue";
				$rs=mysql_query($strLangue);
				//*** requete
				if ( ! ( $rs = $db->sql_query( $strLangue ) ) )
					message_die(GENERAL_ERROR, 'Impossible d\'exécuter la requête', '', __LINE__, __FILE__, $strLangue);
				
				$id=mysql_insert_id();
				while($row= $db->sql_fetchrow($rs))
				{	
					mysql_query("INSERT INTO trad_"._CONST_TRAD_TABLE_NAME." values ('',$id,".$row[id__langue].",'".addslashes($_REQUEST['libelle_'.$i.'_'.$row[id__langue]])."')");		
				}
				
				if(!mysql_error())
					echo utf8_encode('<br> '.$_REQUEST['code_'.$i].' a été inseré avec succès');
				else
					echo utf8_encode("<br> Erreur sur l'insertion de : ".$_REQUEST['code_'.$i].".");
			}
			else
			{
				echo utf8_encode("<br> Attention! ".$_REQUEST['code_'.$i]." existe déjà dans la base et n''a pas été réinseré.");
			}
		}
	}
	echo '<br><br>'.utf8_encode('Pour ressaisir un libellé ').'<a href="'.NomFichier($PHP_SELF,0)."?TableDef="._ID_TAB_DEF_INSERT_LIB.'">'.utf8_encode('cliquez ici').'</a>';
	?>
		</td>
	<?
}
//ajout de champs pour une traduction supplémentaire
else
{

	if(isset($_REQUEST['nbtrads']))
		$nbtrads=$_REQUEST['nbtrads'];
		
		$sqlLangue = "SELECT * FROM _langue WHERE afficher = 1 ORDER BY ordre";
		$rstLangue = mysql_query ( $sqlLangue );
		
?>

		<tr>
		<td valign="top" colspan="4" >
			<br>
			<table cellspacing=1 style="width:100%" cellpadding=2>
				<tr>
					<td style="background:<?=$TdBgColor1?>">
						Code</td>
					<? for ( $i = 0; $i < mysql_num_rows ( $rstLangue ); $i++ ) { ?>	
					<td style="background:<?=$TdBgColor1?>">
						<?=utf8_encode('Libellé ' . mysql_result ( $rstLangue, $i, "_langue" ) )?></td>
					<? } ?>
				</tr>	
					<?
											
							
						$i=1;
						while($i<=$nbtrads)
						{
							if($bg==$TdBgColor2)
								$bg=$TdBgColor1;
							else
								$bg=$TdBgColor2;

							?>
							<tr>
								<td valign="top" bgcolor="<?=$bg?>">
									<input type="text" value="<?=$_REQUEST['code_'.$i]?>" name="code_<?=$i?>" id="code_<?=$i?>" ></td>
								<? for ( $j = 0; $j < mysql_num_rows ( $rstLangue ); $j++ ) { ?>	
								<td valign="top" bgcolor="<?=$bg?>" >
									<input type="text" value="<?=$_REQUEST['libelle_'.$i]?>"  name="libelle_<?=$i?>_<?=mysql_result ( $rstLangue, $j, "id__langue" )?>" id="libelle_<?=$i?>_<?=mysql_result ( $rstLangue, $j, "id__langue" )?>"></td>
								<? } ?>
							</tr>
							<?
							$i++;
						}
					?>
				</table>
			</td>
		<tr>
			<td colspan="4" style="border-bottom:solid 1px #000">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align=right>
			<br>
				<a href="#" onclick="javascript:increase_trads();"> Ajouter une traduction  (saisissez un chiffre pour n traductions)</a> <input type="text" name="nbtot" ></td>
		</tr>
		<tr>
			<td colspan="4" style="border-bottom:solid 1px #000">&nbsp;</td>
		</tr>
		<tr>
			<td colspan="4" align=right>
			<br>
				<input type="hidden" value="<?= $nbtrads ?>" name="nbtrads" />
				<input type="submit" name="insert" value="insert">  </td>
<?
}

			//=========================================================================
            // A chaque fois qu'on crée un libellé, on maj le fichier de trad
            //===================================================================
			if(_CONST_TRAD_GENERE_FIC)
	        {
	        	
	        	$sqlGetLangues = "SELECT * FROM _langue ORDER BY ordre ";
	        	$rstGetLangues = mysql_query($sqlGetLangues);
	        	while ($aLangues = mysql_fetch_array($rstGetLangues, MYSQL_ASSOC)) 
	        	{
	            	$sqlTradLibs = "SELECT  * 
	            					FROM tradotron t INNER JOIN trad_tradotron tr ON t.id_tradotron = tr. id__tradotron
	            					WHERE tr.id__langue = '".$aLangues["id__langue"]."' ";	
	            	
	            	$rstTradLibs = mysql_query($sqlTradLibs);
	            	$x=0; $sTradlibs = "";
	            	while ($aTrads = mysql_fetch_array($rstTradLibs, MYSQL_ASSOC))
	            	{
	            		if($x>0) $sTradlibs .=",\n";
	            		$sTradlibs .= "\"".stripAccents(utf8_decode($aTrads["code_libelle"]))."\" => \"".$aTrads["libelle"]."\"";
	            		$x++;
	            	}
	
	            	if($aLangues["id__langue"]==_ID_LANGUE_JP)
	            	{
	            		$sTradLibs = "<? /**********************************************/\n/*A NE PAS MODIFIER*/\n/***************************/\nglobal \$localisations;\n\$localisations = array($sTradlibs);\n?>";
	            	}
	            	else 
	            	{
	            		$sTradLibs = "<? global \$localisations;\n\$localisations = array($sTradlibs);\n?>";
	            	}
					$fileName = "../include/language/lib_language_".$aLangues["_langue_abrev"].".inc.php";
					
					file_put_contents_php4($fileName,$sTradLibs,"w+");
	        	}
	        }
?>
		</tr>
	</table>
</form>

