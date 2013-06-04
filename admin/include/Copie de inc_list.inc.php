<?
	if (!isset($_REQUEST['mode'])) { //Affichage de la liste

		//Calcule des largeurs des colonnes en fonction de leurs nombre
		if ($WidthType != "none") {
			$WidthTD = "width=".@intval($WidthTable/$nb_cols).$WidthType;
			$WidthTableType = "width=".$WidthTable.$WidthType;
		}
	
		//Routine permettant de switcher entre Asc et Desc
		if ($AscDesc == "Asc") {
			$AscDesc2 = "Desc";
			$imgOrdre = $ImgTriDesc;
		}
		else {
			$AscDesc2 = "Asc";
			$imgOrdre = $ImgTriAsc;
		}
	
		$ObjPage = new Page($result,$Page);
		$ObjPage->AffPageSurNbPage=false;
		$ObjPage->Fichier=NomFichier($_SERVER['PHP_SELF'],0);
	
	
	
		//++++++++++++++++++++++AFFICHAGE DU MOTEUR DE RECHERCHES++++++++++++++++++++++//
		if ($SearchEngine==1 && $DisplayMode!="PopUp") {
			if ($ShowFields!=1) {
				if ($ShowAllRec!=1) {
					//Champs pour le moteur de recherche
					//style="display:none"
					?><div id="DivSearch"><?
					include "include/inc_search_engine.inc.php";
					?></div><?
				}
			}
		}
		//----------------------FIN AFFICHAGE DU MOTEUR DE RECHERCHES----------------------//
	
	
		//++++++++++++++++++++++GESTION DU CARTOUCHE++++++++++++++++++++++//
		//Derniere modificaton : mardi 10 septembre 2002
		if ($_SERVER['QUERY_STRING']  && !eregi("Home=1",$_SERVER['QUERY_STRING'])) {
			?><table cellpadding=0 cellspacing=0 border=0>
			<tr>
				<td><table border="0" cellpadding="0" cellspacing="1" bgcolor="<?=$TableBgColor?>">
				<tr>
					<td>
						<table align="left"  bgcolor="<?=$TableBgColor?>" border="0" cellpadding="4" cellspacing="0">
							<tr>
								<td bgcolor="<?=get_inter_color($MenuBgColor,0.25)?>"><?

                ?><table cellpadding=0 cellspacing=0 border=0>
                    <tr><?

                        if ($ShowFields!=1) {

                            //if (substr($TitreRubriqueArray[0],-1) != "s" && $TitreRubriqueArray[0]!="Liste") {
                            //  echo "<b>".strtoupper(bo_strip_pre_suf($TitreRubriqueArray[0]."s"))."</b>";

                            if ($viewTask==1) {
                                   echo "<td><img src='images/icones/taches.gif'>&nbsp;&nbsp;</td><td>Liste des tâches en cours</td>";
                            }
                            else {
                                echo "<td><img src='images/icones/all_form.gif'>&nbsp;&nbsp;</td><td>".(bo_strip_pre_suf($TitreRubriqueArray[0]))."</td>";
                            }
                            
                        }
                        else {
                            echo "<td>".$inc_list_desc."</td>";
                        }
	
                        //Si on affiche le descriptif de la table
                        if ($ShowFields==1 || $ShowAllRec==1) {
                            $item = "Champ";
                        }
                        echo "<td>&nbsp;(".@mysql_num_rows($result).")</td>";
			?>
                    </tr>
                </table>
								</td>
							</tr>
						</table>
					</td>
				</tr>
			</table></td>
				<td valign="middle">
	<? 
			if ($DisplayMode!="PopUp" && $ShowFields!=1) {//Affichage ou non du lien nouveau

                //TRAITEMENT LIÉ AUX OBJETS
                if ($TableDef==3 && $viewTask!=1){
                    $sql_def = @mysql_query("SELECT id_"._CONST_BO_CODE_NAME."table_def, libelle FROM "._CONST_BO_CODE_NAME."dic_data WHERE type=3 ORDER BY libelle");
                    $nb_tab_obj = @mysql_num_rows($sql_def);
                    ?>
                    <script>
                    function nouveau(){
                        doc = document.all('sel_object');
                        tabledef = doc.options[doc.selectedIndex].value;
                        document.location.href="<?=NomFichier($_SERVER['PHP_SELF'],0)?>?idItem=<?=$idItem?>&TableDef="+tabledef+"&mode=nouveau";
                    }
                    function chg_img_alt(){
                        doc = document.all('sel_object');
                        txt = doc.options[doc.selectedIndex].innerText;
                        document.all('img_nouv').alt = "Créer "+txt;
                    }
                    </script>
                    &nbsp;&nbsp;&nbsp;<select name="sel_object" class="InputText" onChange="chg_img_alt();">
                    <?                    
                    for ($i=0; $i<$nb_tab_obj; $i++) {
                    ?>
                        <option value="<?=@mysql_result($sql_def,$i,"id_"._CONST_BO_CODE_NAME."table_def");?>"><?=ucfirst(@mysql_result($sql_def,$i,"libelle"));?></option>
                    <?}?>
                    </select>
                    <a href="javascript:nouveau();"><img name="img_nouv" alt="Créer <?=@mysql_result($sql_def,0,"libelle");?>" src="images/icones/img_new.gif" border="0"></a>
                    <?
                }
                //ICONE NOUVEL ENREGISTREMENT
                elseif ($viewTask!=1) {
                    if (
                            (
                                    in_array("nouveau",$ModeCol) 
                                && 
                                    !($LineMax>0)
                            ) 
                        || 
                            (
                                    $LineMax>@mysql_num_rows($result) 
                                && 
                                    in_array("nouveau",$ModeCol)
                            )
                    ) {
                            echo "&nbsp;&nbsp;&nbsp;<a href=\"".NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=$TableDef&mode=nouveau&DisplayMode=$DisplayMode&formMain_selection=".$formMain_selection."\">"."<img src=\"images/icones/img_new.gif\" border=\"0\" alt=\"".$TitreCol[is_in_array("nouveau",$ModeCol)]."\"></a>";
                        }
                }
            }
	
	?>
				
				</td>
			</tr>
			</table><br>
<?		// *** Gestionnaire de posistion
		// API
		// 28/05/2004
		// LAC 12/10/2004 (traitement type 3)
		if ($_REQUEST['viewTask']!=1)
		{				
			for ($cpt=0;$cpt<@mysql_num_fields($result);$cpt++) {
				if ((mysql_field_type($result, $cpt)=="int") && (mysql_field_len($result, $cpt)==9)) { ?>
					<script language="javascript">
					function openOrder(nom_table) {
						window.open("gesto_position/index.php?tableName="+nom_table<?php if (isset($_REQUEST['idItem']) && ($_REQUEST['idItem']!="")) { ?>+"&idItem=<?= $_REQUEST['idItem']?>"<?}?>,"order","toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=no,width=415,height=450");
					}
					</script>

<?					$order_button = new bo_button();
					$order_button->c1 = $MenuBgColor;
					$order_button->c2 = $MainFontColor;
					$order_button->name = "Gérer l'ordre >>";
				    	$order_button->action = "openOrder('".$CurrentTableName."')";
				
					$order_button->display();

					echo("<br>");
				}
			}
		}

		// *** SELECTION
		// API
		// 28/02/2004
		if ($champ_selection!="") {
			$table_selection = substr($champ_selection,3);

			$tmp_pos = 0;
			for ($cpt=0;$cpt<@mysql_num_fields($result);$cpt++) {
				if (@mysql_field_name($result, $cpt)==$champ_selection) {
					$tmp_pos = $cpt;
				}
			}
		 ?>
			<script language="javascript">
			function changeSelection() {
				document.formulaire_selection.submit();
			}
			</script>
			<table>
			<form method="post" action="<? echo (NomFichier($PHP_SELF,0)."?TableDef=".$TableDef); ?>" name="formulaire_selection">
			<tr>
			<td><?=$inc_list_choose?><?=$table_selection?></td> 
			<td><select name="formMain_selection" class="InputText" onchange="changeSelection();">
			<option value="0"><?=$inc_list_select_choose?></option>
<?			$chaine = "select * from ".$table_selection;
			$RS_selection = mysql_query($chaine);

			for ($i=0;$i<@mysql_num_rows($RS_selection);$i++) {
				if ($tab_selec_deroulante[$tmp_pos]!="") { ?>
					<option value="<?=@mysql_result($RS_selection,$i,@mysql_field_name($RS_selection,0))?>" <? if (@mysql_result($RS_selection,$i,@mysql_field_name($RS_selection,0))==$formMain_selection) { echo(" selected "); } ?>><?=@mysql_result($RS_selection,$i,$tab_selec_deroulante[$tmp_pos])?></option>
<?				}else{ ?>
					<option value="<?=@mysql_result($RS_selection,$i,@mysql_field_name($RS_selection,0))?>" <? if (@mysql_result($RS_selection,$i,@mysql_field_name($RS_selection,0))==$formMain_selection) { echo(" selected "); } ?>><?=@mysql_result($RS_selection,$i,1)?></option>
<?				}
			} ?>
			</select>
			</td>
			</tr>
			</form>
			</table>
<?		} ?>

			<img src="images/pixtrans.gif" border="0" width="14" height="3"><?
		}
		//----------------------FIN GESTION DU CARTOUCHE----------------------//
	
	
		if (@mysql_num_rows($result) <= 0) {
			
			if ($Search || count($_SESSION['ses_filter'])>0) {
				echo "<p><b>".$inc_list_no_enreg1."</b><br><a href='".NomFichier($PHP_SELF,0)."?TableDef=".$TableDef."'>".$inc_list_supp_filtre."</a></p>";
			}
			elseif ($TableDef) {
				echo "<p>".$inc_list_no_enreg2."</p>";
			}
		}
		else {
			echo "<table ".$WidthTableType." border=\"$TableBorder\" cellspacing=\"$TableCellspacing\" cellpadding=\"$TableCellpadding\" bgcolor=\"$TableBgColor\">";
			
			echo "<tr bgcolor=".$TableEnTeteGgColor.">";
			for ($j=$indice_de_depard; $j<$nb_cols; $j++) {
	
				$fieldtype =	@mysql_field_type($result, $j);
				$fieldlen  =	@mysql_field_len($result, $j);
				$fieldname  =	@mysql_field_name($result, $j);
				$tablename =	@mysql_field_table($result, $j);
	
				$value = @mysql_field_name($result, $j);
	
				//Si le champs est obligatoire
				if (substr($fieldname,-4)==_CONST_BO_REQUIRE_SUFFIX) {
					$value = substr($value,0,strlen($fieldname)-4);
				}
				//Si le champs est un champ date auto
				if (substr($fieldname,-5)=="_auto") {
					$value = substr($value,0,strlen($fieldname)-5);
				}
	
				//CLEF PRIMAIRE
				if ($show_id==1 && ereg($fieldname,"id_".$first_table_name) && $fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_key)) {
					$ColumnHeader = "ID";
				}
				elseif ($show_id==0 && ereg($fieldname,"id_".$first_table_name) && $fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_key)) {
					$ColumnHeader = "";
				}
				//ARBORESCENCE
				elseif (eregi("id_"._CONST_BO_CODE_NAME."nav",$Alias[$j]) || eregi("id_"._CONST_BO_CODE_NAME."nav",$value)) {
					$ColumnHeader = "Rubrique";
				}
				//SI IL Y A UN ALIAS
				elseif ($Alias[$j]) {
					$ColumnHeader =  bo_strip_pre_suf($Alias[$j],$fieldtype,$fieldlen);
				}
				elseif ($show_id==0  && $fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_key)) {
					$ColumnHeader = bo_strip_pre_suf($value,$fieldtype,$fieldlen);
				}
				//UPLOAD
				elseif ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_file) ) {
					$ColumnHeader = "";
				}
				//CLEF ETRANGERES
				elseif ((ereg("^id_"._CONST_BO_TABLE_PREFIX,$fieldname) || ereg("^id_"._CONST_BO_TABLE_DATA_PREFIX,$fieldname) || ereg("^id_",$fieldname)) && $fieldname!=$datatype_arbo && ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey))) {
					if (substr($fieldname,-2)=="_1") {
						$value = substr($value,0,strlen($fieldname)-2);
					}
					else {
						$value = $value;
					}
					$ColumnHeader = bo_strip_pre_suf($value,$fieldtype,$fieldlen);
				}
				//ARBORESCENCE
				elseif (eregi("id_"._CONST_BO_CODE_NAME."nav",$Alias[$j]) || eregi("id_"._CONST_BO_CODE_NAME."nav",$value)) {
					$ColumnHeader = "Rubrique";
				}
				elseif ($ShowFields==1 || $ShowAllRec==1) {
					$ColumnHeader = bo_strip_pre_suf($value,$fieldtype,$fieldlen);
					$OrderBy = "Off";
				}
				//SI IL N'Y A PAS D'ALIAS DANS LE TABLEAU ALIAS ALORS ON PREND LE NOM DES CHAMPS PAR DEFAUT
				else {
					$ColumnHeader = bo_strip_pre_suf($value,$fieldtype,$fieldlen);
				}
	
	
	
				if ($ordre == @mysql_field_table($result, $j).".".@mysql_field_name($result, $j)) {
					$img_ordre =  $imgOrdre;
				}
				else {
					$img_ordre = "";
				}
	
				if ($ColumnHeader && $OrderBy!="Off" && $EnableListingOrder) {//Affichage des liens permettants de trier les colonnes
					if (eregi("id_",@mysql_field_name($result, $j))) {
					echo "<th ".$WidthTD.">".$img_ordre.bo_strip_pre_suf($value,$fieldtype,$fieldlen)."</th>\n";
					}else{
						echo "<th ".$WidthTD."><a class=\"LienLight\" href='".NomFichier($_SERVER['PHP_SELF'],0)."?"."TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&DisplayMenu=".$DisplayMenu."&Search=".$Search."&".$Filters."&Page=".$Page."&AscDesc=".$AscDesc2."&formMain_selection=".$formMain_selection."&idItem=".$idItem."&ordre=".@mysql_field_table($result, $j).".".@mysql_field_name($result, $j)."'>".$ColumnHeader."</a>&nbsp;&nbsp;".$img_ordre."</th>\n";
					}
				}
				elseif ($ColumnHeader) {
					echo "<th ".$WidthTD.">".$img_ordre.bo_strip_pre_suf($value,$fieldtype,$fieldlen)."</th>\n";
				}
			}
	
	
			//Gestion de l'entete des colonnes d'option
			//Modification : mercredi 11 septembre 2002
			if ($ShowFields!=1) {//Affichage des colonnes d'option si on n'affiche pas le descriptif de la table
				if ($ShowAllRec!=1) {
					//Affichage des colonnes d'option
					$NbColColspan = count($TitreCol);
					for ($ij=0; $ij<count($TitreCol); $ij++) {
						if ($ModeCol[$ij] == "nouveau") {
	//						echo "<th ".$WidthTD.">".$TitreCol[$ij]."</th>\n";
							$NbColColspan--;
						}
					}
				}
			}
			if ($EnableListingOrder) {
				echo "<td ".$WidthTD." colspan=\"".$NbColColspan."\" align=\"left\"><span style='color:".$ActiveItemColorLight."'>&lt; Tris</span></th>\n";
			}

		}
	
		//AFFICHAGE DES FILTRES
		if ($EnabledFilter==1 && mysql_num_rows($result)>0) {
			echo "<tr bgcolor=".$TableEnTeteGgColor.">";
	
			for ($j=$indice_de_depard; $j<$nb_cols; $j++) {
	
				if (!ereg("filter_".$j."_null", $ses_filter[$j]) && count($ses_filter)>0) {
					$StyleListBox = "ActiveInputText";
				}
				else {
					$StyleListBox = "InputText";
				}
				
				?>
				<form method="post" action="<?echo NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&Search=".$Search;?>" name="FormFilter_<?echo $j;?>">
				<td <?echo $WidthTD;?>>
				<?
				$fieldtype  	 =	@mysql_field_type($result, $j);
				$fieldlen   	 =	@mysql_field_len($result, $j);
				$fieldname  	 =	@mysql_field_name($result, $j);
				$tablename 	 =	@mysql_field_table($result, $j);
				
				//Select permettant de recuperer les info des listes deroulantes de filtres
				if(($fieldtype==$datatype_date)||($fieldtype==$datatype_datetime))
				{
					// LAC : si datetime, pour les filtres, on ne va afficher que la date
					$StrSQLFilter = "Select distinct(DATE_FORMAT(".$fieldname.",'%Y-%m-%d')) as ".$fieldname." from ".$tablename." where ".$fieldname." != \"\" and ".$fieldname." is not NULL ";
				}
				else
				{
					$StrSQLFilter = "Select distinct(".$fieldname." ) from ".$tablename." where ".$fieldname." != \"\" and ".$fieldname." is not NULL ";
				}
				
				// LAC: 18/02 : on filtre sur les types 3 dans la liste des taches admin
				if (($TableDef==3) && ($tablename=="_dic_data")) $StrSQLFilter .=" AND type=3 ";
				
				$StrSQLFilter .= "group by ".$fieldname." order by ".$fieldname." Asc";

						
				$RstFilter = mysql_query($StrSQLFilter);
				
				//if ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_booleen)){
				//	echo get_sql_format($StrSQLFilter);
				//}
				
				?>
				<select onChange="javascript:document.FormFilter_<?echo $j;?>.submit();" name="filter_<?=$j;?>" class="<?=$StyleListBox;?>">
				<option value="<?="filter_".$j."_null";?>">(<?=$inc_list_aucun?>)</option>
				<?
				if (!ereg("id_"._CONST_BO_CODE_NAME."nav",@mysql_field_name($result, $j))) {
	
					for ($i=0;$i<=@mysql_num_rows($RstFilter) || $i<1;$i++) {
					
						if ($i==0){
							if ($ses_filter[$j] == $tablename.".".$fieldname."=####") {
								$Selected_vide = "Selected";
							}
							else {
								$Selected_vide = "";
							}
						
							?><option value="<?=$tablename.".".$fieldname."=#### and ".$tablename.".".$fieldname." is NULL";?>" <?=$Selected_vide?>>(<?=$inc_list_vide?>)</option><?
						}
						else {
							$value = $tmp_value = @mysql_result($RstFilter,$i-1 ,$fieldname);
		
						
							if ((ereg($tablename.".".$fieldname."=##".$value."##",$ses_filter[$j])) || (!strcasecmp (" DATE_FORMAT(".$tablename.".".$fieldname.", '%Y-%m-%d') =##".$value."##",stripslashes($ses_filter[$j])))) {						
								$Selected = "Selected";
							}
							else {
								$Selected = "";
								
							}
							
							if (($fieldtype==$datatype_date)||($fieldtype==$datatype_datetime)) {
								$value=CDate($value,$DateFormat);
							}
							elseif ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_booleen)) {
								if ($value==1) {
									$value = $inc_list_oui;
								}
								else {
									$value= $inc_list_non;
								}
							}
							//Gestion des clefs etrangeres
							//$j!=0 pour ne pas le faire sur la clef de la table
							elseif ($j!=0 && $fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_key)) {
								$value = mysql_result(mysql_query("Select * from ".get_table_annexe_name(ereg_replace("^id_","",$fieldname))." where ".get_table_annexe_name($fieldname)."=".$value),0,1);
								
							}
							//Gestion des clefs etrangere à choix multiple
							elseif ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey)) {
								$str = "select * from ".@eregi_replace("^id_([_a-z]*)(_[0-9]+)?$","\\1",$fieldname)." where ".@eregi_replace("^(id_[_a-z]*)(_[0-9]+)?$","\\1",$fieldname)." in (".$value.")";
								$rst_multi_key = mysql_query($str);
								
								//echo $str;
			
								$arr_multi_key = array();
			
								for ($i_l=0;$i_l<@mysql_num_rows($rst_multi_key);$i_l++) {
									$arr_multi_key[] = @mysql_result($rst_multi_key,$i_l,1);
								}
			
								if (@mysql_num_rows($rst_multi_key)>0) {
									$value = join(",&nbsp;",$arr_multi_key);
								}
								else {
									$value = "";
								}						
							}							
		
							// LAC : 24/02/2004 - gestion de filtres sur date
							if (($fieldtype==$datatype_date)||($fieldtype==$datatype_datetime)) 
							{
							?>							
							<option value=" DATE_FORMAT(<?=$tablename.".".$fieldname.", '%Y-%m-%d') =##".$tmp_value."##";?>" <?=$Selected;?>><?=coupe_espace(strip_tags($value),$NbMaxCar);?></option>
							<?
							}
							else
							{
							?>
							<option value="<?=$tablename.".".$fieldname." =##".$tmp_value."##";?>" <?=$Selected;?>><?=coupe_espace(strip_tags($value),$NbMaxCar);?></option>
							<?
							}													
						}						
					}	
					
				}
				//Affichage de l'arborescence
				elseif (eregi("id_"._CONST_BO_CODE_NAME."nav",@mysql_field_name($result, $j))) {
					$id_item_nav = split("=",$ses_filter[$j]);
					get_arbo(0, "&nbsp;&nbsp;",0,$id_item_nav[1],$ActiveItemColor,2,1,0,$j);
				}
				?>
				</select><?=$id_item_nav[1]?>
				</td>
				</form>
				<?
			}
	
			if ($EnabledFilter==1) {
				echo "<td ".$WidthTD." colspan=\"".count($TitreCol)."\"><span style='color:".$ActiveItemColorLight."'>&lt;&nbsp;Filtres</span></td>\n";
			}
	
			echo "</tr>";
		}
		//FIN DE L'AFFICHAGE DES FILTRES
	
		for ($i=$ObjPage->Min;$i<$ObjPage->Max;$i++) {
	
			if ($fond_cellule == $TdBgColor1) {
				$fond_cellule = $TdBgColor2;
			}
			else {
				$fond_cellule = $TdBgColor1;
			}
	
			//Roll over pour l'element selectionné
			$ItemEvent =  "onmouseover='ItemOn(this,\"".get_inter_color($ActiveItemColor,0.3)."\",\"".eregi_replace("px","",$FontSize)."\",\"".$nb_cols."\");'";
			$ItemEvent .= "onmouseout='ItemOff(this,\"".$FontColor."\",\"".eregi_replace("px","",$FontSize)."\",\"".$nb_cols."\");'";
	
			//GESTION DE L'ID DE L'ENREGISTREMENT	
			if (is_numeric(@mysql_result($result, $i , 0))) {
				$ID = "&ID=".@mysql_result($result, $i , 0);
                //SDE 07-02-2003
                $obj_id = @mysql_result($result, $i , 0);
			}
            //SDE 07-02-2003
            //Spécifique traitement formulaire objets / arbo
            $str_object         = mysql_query("Select id_"._CONST_BO_CODE_NAME."object, id_"._CONST_BO_CODE_NAME."nav, item_table_ref_req, id_"._CONST_BO_CODE_NAME."table_def from "._CONST_BO_CODE_NAME."object where id_"._CONST_BO_CODE_NAME."object=$obj_id");
            $item_table_ref     = mysql_result($str_object,0,"item_table_ref_req");
            $id_bo_object       = mysql_result($str_object,0,"id_"._CONST_BO_CODE_NAME."object");
            $table_ref          = mysql_result($str_object,0,"id_"._CONST_BO_CODE_NAME."table_def");
            $id_nav_obj 	= mysql_result($str_object,0,"id_"._CONST_BO_CODE_NAME."nav");
            if ($TableDef==3){
                $qString = "idItem=".$id_nav_obj."&TableDef=".$table_ref."&mode=modif&ID=".$item_table_ref."&idObj=".$id_bo_object;
                
                // LAC 24/02
                $dString = "idItem=".$id_nav_obj."&TableDef=".$table_ref."&mode=duplicate&methode=duplicate&ID=".$item_table_ref."&idObj=".$id_bo_object;
                
                echo "<tr bgcolor=".$fond_cellule." ".$ItemEvent." onDblclick=\"document.location.href='bo.php?".$qString."'\" style=\"cursor:pointer\">";
            }
	    else
	    {
	    	//traitement normal
                echo "<tr bgcolor=".$fond_cellule." ".$ItemEvent." onDblclick=\"document.location.href='".NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=$TableDef&mode=modif&".$ID."&Search=$Search&DisplayMode=$DisplayMode&DisplayMenu=$DisplayMenu&Page=$Page&formMain_selection=$formMain_selection&ordre=$ordre&AscDesc=$AscDesc&id=$i'\" style=\"cursor:pointer\">";
            }
			for ($k=$indice_de_depard; $k<$nb_cols; $k++) {
				$value = @mysql_result($result, $i ,@mysql_field_name($result, $k));
	
				$fieldtype =	@mysql_field_type($result, $k);
				$fieldlen  =	@mysql_field_len($result, $k);
				$fieldname  =	@mysql_field_name($result, $k);
				$fieldderoulante = $tab_selec_deroulante[$k];

				//CLEF PRIMAIRE
				if ($show_id==1 && ereg($fieldname,"id_".$first_table_name) && $fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_key) ) {
					echo "<td>".$value."</td>";
				}
				elseif ($show_id==0 && ereg($fieldname,"id_".$first_table_name) && $fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_key) ) {
	
				}
				//UPLOAD
				elseif ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_file) ) {
	
				}
				//CLEF ETRANGERES
				elseif (ereg("^id_",$fieldname) || ereg("^id_"._CONST_BO_TABLE_PREFIX,$fieldname) || ereg("^id_"._CONST_BO_TABLE_DATA_PREFIX,$fieldname) || ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey))) {
	
					if ($fieldtype==$mysql_datatype_integer) {
						$str = "select * from ".@eregi_replace("^id_([_a-z]*)(_[0-9]+)?$","\\1",$fieldname)." where ".@eregi_replace("^(id_[_a-z]*)(_[0-9]+)?$","\\1",$fieldname)."=".$value;
	
						//echo $str."<br>----".$fieldname;

						if ($fieldderoulante!="") {
							echo "<td>".@mysql_result(mysql_query($str),0,$fieldderoulante)."</td>";
						}else{
							echo "<td>".@mysql_result(mysql_query($str),0,1)."</td>";
						}
					}
					else {
						$str = "select * from ".@eregi_replace("^id_([_a-z]*)(_[0-9]+)?$","\\1",$fieldname)." where ".@eregi_replace("^(id_[_a-z]*)(_[0-9]+)?$","\\1",$fieldname)." in (".$value.")";
						$rst_multi_key = mysql_query($str);
						
						//echo $str;
	
						$arr_multi_key = array();
	
						for ($i_l=0;$i_l<@mysql_num_rows($rst_multi_key);$i_l++) {
							$arr_multi_key[] = @mysql_result($rst_multi_key,$i_l,1);
						}
	
						if (@mysql_num_rows($rst_multi_key)>0) {
							$value = join(",&nbsp;",$arr_multi_key);
						}
						else {
							$value = "";
						}
	
						echo "<td title=\"".$value."\">".coupe_espace($value,$NbMaxCar)."</td>";
					}
				}
				//CASE A COCHER
				elseif ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_booleen) ) {
					echo "<td align=\"center\">";
					if ($value == 1) {
						echo $ImgCheckBoxOn;
					}
					else {
						echo $ImgCheckBoxOff;
					}
					echo "</td>";
				}
				//EMAIL
				elseif (ereg("email",$fieldname)) {
	
					//BAYER
					//	if ($TableDef==239 && date("Y-m-d")>@mysql_result($result, $i , 8)) {
							//echo "<td><a href=\"mailto:".$value."?subject=Merci de ramener le ".@mysql_result($result, $i , 9)." ".@mysql_result($result, $i , 1)." (Réf : ".@mysql_result($result, $i , 0).") à la médiathèque. \" style='color:white'>".$value."</a></td>";	
					//	}
						//BAYER
					//	else {
							echo "<td><a href=\"mailto:".$value."\">".$value."</a></td>";
					//	}
					
				}
				//GESTION DES ELEMENTS RATACHÉS A L'ARBORESCENCE
				elseif (ereg("id_"._CONST_BO_CODE_NAME."nav",$fieldname) && $TableDef!=2) {
					$StrRub		= mysql_query("Select "._CONST_BO_CODE_NAME."nav from "._CONST_BO_CODE_NAME."nav where id_"._CONST_BO_CODE_NAME."nav=".$value);
					$Rub		= @mysql_result($StrRub,0,""._CONST_BO_CODE_NAME."nav");
					echo "<td>".$Rub."</td>";
					unset($Rub);
				}
				//TRAITEMENT DES DATES
				elseif ($fieldtype == $datatype_date_auto || $fieldtype == $datatype_date) {
					echo "<td ".$stylecolor.">".CDate($value,$DateFormat)."</td>";
				}
				//TRAITEMENT DES DATES ET DES HEURES
				elseif ($fieldtype == $datatype_datetime_auto || $fieldtype == $datatype_datetime) {
					echo "<td ".$stylecolor.">".CDate(substr($value,0,10),$DateFormat)." ".substr($value,-8)."</td>";
				}
				//TRAITEMENT DU FORMAT MONETAIRE
				elseif ($fieldtype == $mysql_datatype_real && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_currency)) {
					echo "<td ".$stylecolor." align=right>".number_format($value,2,","," ")." "._CONST_BO_DEFAULT_CURRENCY."&nbsp;</td>";
				}
				//TRAITEMENT DU FORMAT FLOAT
				elseif ($fieldtype == $mysql_datatype_real && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_float)) {
					echo "<td ".$stylecolor." align=right>".number_format($value,2,","," ")."&nbsp;</td>";
				}
				//TRAITEMENT DU FORMAT LIEN URL
				elseif ($fieldtype == $mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_url)) {
					echo "<td ".$stylecolor."><a href=\"".$value."\" target=\"_blank\">".$value."</a></td>";
				}				
				//TRAITEMENT DES ENTIERS
				elseif ($fieldtype == $mysql_datatype_integer) {
					echo "<td ".$stylecolor." align=right>".number_format($value,0,""," ")."&nbsp;</td>";
				}
				//COULEUR
				elseif ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_color)) {
					if ($value) {
						echo "<td align='center' valign='center'><table bgcolor='white' cellspacing='0' cellpadding='0' border='0' align='left'><tr><td bgcolor=\"".$value."\"><img src='images/pixtrans.gif' alt='".$value."' width='12' height='12'></td></tr></table>".$value."</td>";
					}
					else {
						echo "<td>&nbsp;</td>";
					}
				}
                //LISTE DE DONNEES
                elseif ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_list_data)) {
					echo "<td ".$stylecolor." title=\"".str_replace("|","\n",$value)."\">".str_replace("|",", ",$value)."</td>";
                }
				else {
					echo "<td ".$stylecolor." title=\"".trim(htmlentities(strip_tags($value)))."\">".coupe_espace((strip_tags($value)),$NbMaxCar)."</td>";
				}
			}
	
			if ($ShowFields!=1) {//Affichage des colonnes d'option si on n'affiche pas le descriptif de la table
				if ($ShowAllRec!=1) {
	
					$ItemEvent =  "onmouseover='ItemOn(this,\"".get_inter_color($ActiveItemColor)."\",\"".eregi_replace("px","",$FontSize)."\",\"".$nb_cols."\");'";
					$ItemEvent .= "onmouseout='ItemOff(this,\"".$FontColor."\",\"".eregi_replace("px","",$FontSize)."\",\"".$nb_cols."\");'";				
	
					//Affichage des colonnes d'option
					for ($ij=0; $ij<count($TitreCol); $ij++) {
						
	
						if ($ModeCol[$ij] != "nouveau") {
							if (eregi("SqlEditor",$ModeCol[$ij])){
								$value = strtolower(@mysql_result($result, $i , "id_"._CONST_BO_CODE_NAME."table_def"));//Id de la table BoTAbleDef
								echo "<td bgcolor=\"".get_inter_color($TableBgColor,0.4)."\" ".$ItemEvent."><a href=\"bo_include_launcher.php?file=bo_sql_editor.php&TableDefModif=$value\">"."<img src=\"images/icones/icone_sql.gif\" border=\"0\" alt=\"".$TitreCol[$ij]."\"></a></td>";
							}
							elseif ($ModeCol[$ij]=="postnewsletter"){
								echo "<td bgcolor=\"".get_inter_color($TableBgColor,0.4)."\" ".$ItemEvent.">&nbsp;<a href=\"bo_include_launcher.php?file=bo_newsletter.php&".$ID."\"><img src=\"images/icones/enveloppe.gif\" width=\"16\" border=\"0\" alt=\"".$TitreCol[$ij]."\"></a></td>";
							}
							elseif ($ModeCol[$ij]=="get_object_values"){
								echo "<td bgcolor=\"".get_inter_color($TableBgColor,0.4)."\" ".$ItemEvent.">&nbsp;<a href=\"bo.php?".$qString."\"><img src=\"images/icones/icone_ed1.gif\" width=\"16\" border=\"0\" alt=\"".$TitreCol[$ij]."\"></a></td>";
							}
							//Gestion du mode duplication
							elseif ($ModeCol[$ij]=="duplicate"){
								echo "<td align=\"center\" bgcolor='".get_inter_color($TableBgColor,0.4)."' ".$ItemEvent."><a href=\"".NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&mode=".$ModeCol[$ij]."&methode=".$ModeCol[$ij]."&id=".$i."&ordre=".$ordre."&AscDesc=".$AscDesc."&Search=".$Search.$ID."&".$Filters."\">"."<img src=\"images/icones/icone_copier.gif\" width=\"16\" border=\"0\" alt=\"".$TitreCol[$ij]."\">"."</a></td>";
							}
							// LAC 24/02 : Gestion duplication des objets
							elseif ($ModeCol[$ij]=="duplicate_object"){
								echo "<td align=\"center\" bgcolor='".get_inter_color($TableBgColor,0.4)."' ".$ItemEvent."><a href=\"bo.php?".$dString."\"><img src=\"images/icones/icone_copier.gif\" width=\"16\" border=\"0\" alt=\"".$TitreCol[$ij]."\">"."</a></td>";
								}
							else 
							{								
								if (eregi("Supprimer",$TitreCol[$ij])) 
								{
									$Picto = "icone_ed0.gif";
									$recapEnt = "";
								}
								elseif (eregi("Modifier",$TitreCol[$ij])) 
								{
									$Picto = "icone_ed1.gif";								
								}
								elseif (eregi("Voir",$TitreCol[$ij])) {
									$Picto = "icone_view.gif";
								   $recapEnt = "";
								}
								echo($recapEnt);
								echo "<td align=\"center\" bgcolor='".get_inter_color($TableBgColor,0.4)."' ".$ItemEvent."><a href=\"".NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&mode=".$ModeCol[$ij]."&id=".$i."&ordre=".$ordre."&AscDesc=".$AscDesc."&Page=".$Page."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search.$ID."&".$Filters."\">"."<img src=\"images/icones/".$Picto."\" width=\"16\" border=\"0\" alt=\"".$TitreCol[$ij]."\">"."</a></td>";
							}
						}
					}
				}
			}
			echo "</tr>\n";
		}
	
		echo "</table>";
	
		$ObjPage->Affiche($result, $Page, "&TableDef=".$TableDef."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&DisplayMode=".$DisplayMode."&idItem=".$_REQUEST['idItem']);
	
		//Gestion du lien Fermer en mode PopUp
		if (@mysql_num_rows($result) <= 0) {
			$LienFermer = "<blockquote>"."<a href=\"javascript:window.close();\">".$inc_list_fermer."</a>"."</blockquote>";
		}
		else {
			$LienFermer = "<a href=\"javascript:window.close();\">".$inc_list_fermer."</a>";
		}
		//Affichage du bouton de de fermeture de la fenetre pop-up
		if ($DisplayMode=="PopUp") {
			echo "<br>".$LienFermer;
		}
}

?>