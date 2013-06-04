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
		
		//AHE Spec Ethic Etapes
		if (in_array($TableDef,$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) && $_SESSION['ses_profil_user'] != _PROFIL_CENTRE)
			include "include/inc_search_engineCentre.inc.php";
		
		
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

                            if ($viewTask==1) {
                                   echo "<td><img src='images/icones/taches.gif'>&nbsp;&nbsp;</td><td>".$inc_list_tache."</td>";
                            }else {
				// *** API 30/06/05 affichage du libelle menu dans le cartouche
				$chaine = "select menu_title from "._CONST_BO_CODE_NAME."table_def where id_"._CONST_BO_CODE_NAME."table_def=".$TableDef;
				$RS_libelle = mysql_query($chaine);

				if (mysql_num_rows($RS_libelle)>0) {
		                        echo "<td><img src='images/icones/all_form.gif'>&nbsp;&nbsp;</td><td>".mysql_result($RS_libelle,0,"menu_title")."</td>";
				}else{
		                        echo "<td><img src='images/icones/all_form.gif'>&nbsp;&nbsp;</td><td>".(bo_strip_pre_suf($TitreRubriqueArray[0]))."</td>";
				}
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
                        $nbLigne = @mysql_num_rows($result);
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

                //TRAITEMENT LI� AUX OBJETS
                if ($TableDef==3 && $viewTask!=1){
                    //SBA 080207 - On n'affiche que les gabarits sur lequels on a les droits
                    $sql_def = @mysql_query(
                    "	
                    	SELECT "._CONST_BO_CODE_NAME."dic_data.id_"._CONST_BO_CODE_NAME."table_def, 
                    		   "._CONST_BO_CODE_NAME."dic_data.libelle,
                    		   t.id_"._CONST_BO_CODE_NAME."profil,
                    		   id__dic_data
                    		   
                        FROM "._CONST_BO_CODE_NAME."dic_data 
                        	INNER JOIN "._CONST_BO_CODE_NAME."table_def t 
                        			ON t.id_"._CONST_BO_CODE_NAME."table_def = "._CONST_BO_CODE_NAME."dic_data.id_"._CONST_BO_CODE_NAME."table_def 
                        
                        WHERE type=3 ORDER BY position_in_dropdown, libelle");
                                        
                    //Fin SBA 080207
                    $nb_tab_obj = @mysql_num_rows($sql_def);
                    ?>
                    <script>
                    function nouveau(){
                    	if(document.all){ // 10/07/08: MDI replaced "document.all" by "document.getElementById' function to fix firefox bugs 
                        	doc = document.all('sel_object');
                    	}else{
                    		doc = document.getElementById('sel_object');;
                    	}
                        tabledef = doc.options[doc.selectedIndex].value;
                        document.location.href="<?=NomFichier($_SERVER['PHP_SELF'],0)?>?idItem=<?=$idItem?>&TableDef="+tabledef+"&mode=nouveau";
                    }
                    function chg_img_alt(){         // 10/07/08: MDI replaced "document.all" by "document.getElementById' function to fix firefox bugs             
                        if(document.all){
                        doc = document.all('sel_object');
                    	}else{
                    		doc = document.getElementById('sel_object');;
                    	}
                        txt = doc.options[doc.selectedIndex].innerText;
                        document.all('img_nouv').alt = "<?=$inc_list_creer?>" +txt;
                    }
                    </script>
                    <?                    
                    
                    $nb_choix_gab = 0;
                    
                    for ($i=0; $i<$nb_tab_obj; $i++) { 
                    	
                    	$tab_profil = explode(",",@mysql_result($sql_def,$i,"id_"._CONST_BO_CODE_NAME."profil")) ; //Profil qui ont droit � ce gabarit
                    	
                    	if (in_array($_SESSION['ses_profil_user'], $tab_profil))
                    	{
                    		$nb_choix_gab++;
                    		//Si on a au moins un choix de gabarit
                    		if ($nb_choix_gab==1)
                    		{
                    		?>
                    			&nbsp;&nbsp;&nbsp;<select name="sel_object" id="sel_object" class="InputText" onChange="chg_img_alt();"> 	
                            <?        
                    		}
                    		
                    		
                    		//if ( hasGabaritRights ( @mysql_result( $sql_def, $i, "id_"._CONST_BO_CODE_NAME."dic_data"), $idItem ) )
                    		//{   ?>                 	
	                        	<option value="<?=@mysql_result($sql_def,$i,"id_"._CONST_BO_CODE_NAME."table_def");?>"><?=ucfirst(@mysql_result($sql_def,$i,"libelle"));?></option>
	                    <?	//}
                    	}
                    }
                    //Si on a au moins un choix de gabarit on propose la possibilit� de cr�er un contenu
                    if ($nb_choix_gab>0)
                    {
                    	
                    	?>
                    	</select>&nbsp;<a href="javascript:nouveau();"><img name="img_nouv" id="img_nouv" alt="<?=$inc_list_creer.@mysql_result($sql_def,0,"libelle");?>" src="images/icones/img_new.gif" border="0"></a>
                    	
                    	<?
                    }
                    ?>
                    
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
                            if($_SESSION["ses_profil_user"] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE){
                               echo "&nbsp;"; 
                              //echo "&nbsp;&nbsp;&nbsp;<a href=\"".NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=$TableDef&mode=nouveau&DisplayMode=$DisplayMode&formMain_selection=".$formMain_selection."\">"."<img src=\"images/icones/img_new.gif\" border=\"0\" alt=\"".$TitreCol[is_in_array("nouveau",$ModeCol)]."\"></a>";
                            }else{
                                if($_SESSION["ses_profil_user"] == _PROFIL_CENTRE && 
                                
                                  ( $_GET["TableDef"] == _CONST_TABLEDEF_ACCUEIL_GROUPE ||
                                    $_GET["TableDef"] == _CONST_TABLEDEF_GROUPE_ADULTE ||
                                    $_GET["TableDef"] == _CONST_TABLEDEF_ACCUEIL_REUNION || 
                                    $_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE ||
                                    $_GET["TableDef"] == _CONST_TABLEDEF_ORGANISATEUR_CVL) 
                                    
                                    && $nbLigne>=1){
                                    //$_GET["TableDef"] == _CONST_TABLEDEF_ACCUEIL_GROUPE || 
                                  echo "&nbsp;";
                                }
                                else{
                                  if($_GET["TableDef"] == _CONST_TABLEDEF_ACTUALITE){
                                    $txt = "Cliquez ici pour ajouter une nouvelle actualit&eacute;e";
                                  }elseif($_GET["TableDef"] == _CONST_TABLEDEF_ACCUEIL_GROUPE ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_ACCUEIL_REUNION ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_ACCUEIL_REUNION ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_GROUPE_ADULTE){
                                    $txt = "Cliquez ici pour ajouter un nouvel accueil";
                                  }elseif($_GET["TableDef"] == _CONST_TABLEDEF_BON_PLAN){
                                    $txt = "Cliquez ici pour ajouter un nouveau bon plan";
                                  }elseif($_GET["TableDef"] == _CONST_TABLEDEF_ORGANISATEUR_CVL){
                                    $txt = "Cliquez ici pour ajouter un organisateur CVL";
                                  }elseif($_GET["TableDef"] == _CONST_TABLEDEF_CLASSE_DECOUVERTE ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_CVL ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_SEMINAIRE ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_TOURISTIQUE ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_STAGE_THEM_GROUPE ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_SHORT_BREAK ||
                                          $_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL
                                          ){
                                    $txt = "Cliquez ici pour ajouter un nouveau sejour";
                                  }elseif($_GET["TableDef"] == _CONST_TABLEDEF_OFFRE_EMPLOI){
                                    $txt = "Cliquez ici pour ajouter une nouvelle offre d'emploi";
                                  }elseif($_GET["TableDef"] == _CONST_TABLEDEF_CENTRE){
                                    $txt = "Cliquez ici pour ajouter un nouveau centre";
                                  }
                                
                                	//SPEC FFR ETHIC ETAPES
                                  echo "&nbsp;&nbsp;&nbsp;<a href=\"".NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=$TableDef&mode=nouveau&DisplayMode=$DisplayMode&formMain_selection=".$formMain_selection."\">$txt "."<img src=\"images/icones/img_new.gif\" border=\"0\" alt=\"".$TitreCol[is_in_array("nouveau",$ModeCol)]."\"></a>";
									              }
                            }
                        }
                }
            }
	
	?>
				
				</td>
			</tr>
			</table><br>
			
<?		
			if ($_GET["TableDef"] == 599)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les contacts";
			   $order_button->action = "ExportContact()";
			   $order_button->display();

			   echo("</td></tr></table>");
			}

			if ($_GET["TableDef"] == 621)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les contacts";
			   $order_button->action = "ExportContactGeneral()";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	  

      if ($_GET["TableDef"] == 624)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les contacts";
			   $order_button->action = "ExportContactSejour()";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			
			if ($_GET["TableDef"] == 623)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les contacts";
			   $order_button->action = "ExportContactDispo()";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			if ($_GET["TableDef"] == 622)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les contacts";
			   $order_button->action = "ExportContactNewsletter()";
			   $order_button->display();

			   echo("</td></tr></table>");
			}
	
			if ($_GET["TableDef"] == 512 && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les centres au format XML";
			   $order_button->action = "ExportCentreXML()";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
if ($_GET["TableDef"] == _CONST_TABLEDEF_ACCUEIL_GROUPE && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les accueils au format CSV";
			   $order_button->action = "ExportSejour(1)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			
				if ($_GET["TableDef"] == _CONST_TABLEDEF_ACCUEIL_REUNION && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les accueils au format XML";
			   $order_button->action = "ExportSejour(2)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			if ($_GET["TableDef"] == _CONST_TABLEDEF_GROUPE_ADULTE && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les accueils au format CSV";
			   $order_button->action = "ExportSejour(3)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			
			if ($_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les accueils au format CSV";
			   $order_button->action = "ExportSejour(4)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			
			if ($_GET["TableDef"] == _CONST_TABLEDEF_CLASSE_DECOUVERTE && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les séjours au format XLS";
			   $order_button->action = "ExportSejour(5)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			if ($_GET["TableDef"] == _CONST_TABLEDEF_CVL && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les séjours au format XLS";
			   $order_button->action = "ExportSejour(6)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			
			if ($_GET["TableDef"] == _CONST_TABLEDEF_SEMINAIRE && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les séjours au format XLS";
			   $order_button->action = "ExportSejour(7)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	if ($_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_TOURISTIQUE && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les séjours au format XLS";
			   $order_button->action = "ExportSejour(8)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			if ($_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_STAGE_THEM_GROUPE && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les séjours au format XLS";
			   $order_button->action = "ExportSejour(9)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			if ($_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_SHORT_BREAK && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les séjours au format XLS";
			   $order_button->action = "ExportSejour(10)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
			if ($_GET["TableDef"] == _CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL && $_SESSION["ses_profil_user"]!=_PROFIL_CENTRE)
			{
			   echo("<table><tr><td>");

										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = "Exporter les séjours au format XLS";
			   $order_button->action = "ExportSejour(11)";
			   $order_button->display();

			   echo("</td></tr></table>");
			}	
		// *** Gestionnaire de position
		// API
		// 28/05/2004
		// LAC 12/10/2004 (traitement type 3)

		$chaine = "select * from "._CONST_BO_CODE_NAME."select_champ where flag_actif=1 and 	id_"._CONST_BO_CODE_NAME."table_def=".$TableDef;
		$RS_list_select = mysql_query($chaine);

		if (mysql_num_rows($RS_list_select)>0) {
			$champ_selection = mysql_result($RS_list_select,0,"champ_selection");
			$table_selection = substr($champ_selection,3);
		}

		if (!isset($_REQUEST['viewTask']) || $_REQUEST['viewTask']!=1)
		{				
?>
					<script language="javascript">
					function openPreview() {
						window.open("../bo_preview.php?Rub=<?=$_REQUEST['idItem']?>","order","toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=no,width=800,height=550");
					}

					function massiveDelete() {
						if (confirm("<?=$inc_list_suppress_all?>")) {
							document.form_supp.submit();
						}
					}
					</script>
					<table cellspacing="" cellpadding="0" border="0">
					<tr><td>					
<?			
			  for ($cpt=0;$cpt<@mysql_num_fields($result);$cpt++) {
?>				

<?				if ((mysql_field_type($result, $cpt)=="int") && (mysql_field_len($result, $cpt)==9)) { ?>
					<script language="javascript">
					function openOrder(nom_table,selection) {
						window.open("gesto_position/index.php?tableName="+nom_table+"&selection="+selection+"&tbl_selection=<?=$table_selection?>"<?php if (isset($_REQUEST['idItem']) && ($_REQUEST['idItem']!="")) { ?>+"&idItem=<?= $_REQUEST['idItem']?>"<?}?>,"order","toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=no,width=415,height=450");
					}
					function openOrdernav() {
						window.open("gesto_position/index_nav.php","order","toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=no,width=470,height=450");
					}
					</script>					
<?
			        $order_button = new bo_button();
					$order_button->c1 = $MenuBgColor;
					$order_button->c2 = $MainFontColor;
					$order_button->name = $inc_list_gerer_ordre;

					if ($TableDef==2) {
						$order_button->action = "openOrdernav()";
					}else{
						$order_button->action = "openOrder('".$CurrentTableName."','".$_REQUEST['formMain_selection']."')";
					}
				
					$order_button->display();
					echo("</td><td>&nbsp;&nbsp;&nbsp;</td>");
				  }
					
			}
				
			
			
			  
			if (in_array("Supprimer",$TitreCol))
			{
			   echo("<td>");
										
			   $order_button = new bo_button();
			   $order_button->c1 = $MenuBgColor;
			   $order_button->c2 = $MainFontColor;
			   $order_button->name = $inc_list_supp_masse;
			   $order_button->action = "massiveDelete()";
			   //$order_button->display();

			   echo("</td>");
			}		  
			  
			echo("<td>&nbsp;&nbsp;&nbsp;</td>");
			/*
			echo("<td>");
			 	$preview_button = new bo_button();
				$preview_button->c1 = $MenuBgColor;
				$preview_button->c2 = $MainFontColor;
				$preview_button->name = "Preview >>";
				$preview_button->action = "openPreview()";
			
				$preview_button->display();
			echo("</td>");			
			*/
			echo("</tr></table><br>");
		}
		
	
			  	
		
		
		
    if($_REQUEST["TableDef"] == 3 && $_REQUEST["idItem"] == ""){
    		include("specifique/inc_menu_logo.php");
    }
		// *** SELECTION
		// API
		// 28/02/2004 | 01/03/2005

		$chaine = "select * from "._CONST_BO_CODE_NAME."select_champ where flag_actif=1 and id_"._CONST_BO_CODE_NAME."table_def=".$TableDef;
		$RS_list_select = mysql_query($chaine);

		if (mysql_num_rows($RS_list_select)>0) {

			if (mysql_result($RS_list_select,0,"libelle")!="") {
				$deb_libelle = mysql_result($RS_list_select,0,"libelle");
			}else{
				$deb_libelle = $inc_list_choose.$table_selection;
			}

			if (mysql_result($RS_list_select,0,"down_description")!="") {
				$fin_libelle = "<br>".mysql_result($RS_list_select,0,"down_description");
			}else{
				$fin_libelle = "";
			}

			$tmp_pos = 0;
			for ($cpt=0;$cpt<@mysql_num_fields($result);$cpt++) {
				if (@mysql_field_name($result, $cpt)==$champ_selection) {
					$tmp_pos = $cpt;
				}
			} ?>
			<script language="javascript">
			function changeSelection() {
				document.formulaire_selection.submit();
			}
			</script>
			<table>
			<form method="post" action="<? echo (NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=".$TableDef); ?>" name="formulaire_selection">
			<tr>
			<td valign="top"><?=$deb_libelle?><?=$fin_libelle?></td> 
			<td valign="top"><select name="formMain_selection" id="formMain_selection" class="InputText" onchange="changeSelection();">
			<option value="0"><?=$inc_list_select_choose?></option>
<?			
			if (mysql_result($RS_list_select,0,"flag_all_enable")==1) {
				echo("<option value=\"-1\" ".($_REQUEST['formMain_selection']==-1?"selected":"").">".$inc_list_select_choose_all."</option>");
			}
			
			$chaine = "select * from ".$table_selection." ".mysql_result($RS_list_select,0,"specific_sql");
			$RS_selection = mysql_query($chaine);

			for ($i=0;$i<@mysql_num_rows($RS_selection);$i++) {
				/*if ($tab_selec_deroulante[$tmp_pos]!="") { ?>*/
				if ($tab_selec_deroulante_field[$champ_selection]!="") { ?>
					<option value="<?=@mysql_result($RS_selection,$i,@mysql_field_name($RS_selection,0))?>" <?					 if (@mysql_result($RS_selection,$i,@mysql_field_name($RS_selection,0))==$formMain_selection) { echo(" selected "); } 
					echo(">");
					//$tab_temp = split(",",$tab_selec_deroulante[$tmp_pos]);
					$tab_temp = split(",",$tab_selec_deroulante_field[$champ_selection]);
					for ($j=0;$j<count($tab_temp);$j++) {
						echo(mysql_result($RS_selection,$i,$tab_temp[$j]));
						if ($j!=count($tab_temp)-1) echo(" / ");
					}

					//@mysql_result($RS_selection,$i,$tab_selec_deroulante[$tmp_pos])
					echo("</option>");
				}else{ ?>
					<option value="<?=@mysql_result($RS_selection,$i,@mysql_field_name($RS_selection,0))?>" <? if (@mysql_result($RS_selection,$i,@mysql_field_name($RS_selection,0))==$formMain_selection) { echo(" selected "); } ?>><?=@mysql_result($RS_selection,$i,1)?></option>
<?				}
			} ?>
			</select>
			</td>
			</tr>
			</form>
			</table><br>
<?		} ?>

			<img src="images/pixtrans.gif" border="0" width="14" height="3"><?
		}
		//----------------------FIN GESTION DU CARTOUCHE----------------------//
	
	
		if (@mysql_num_rows($result) <= 0) {
			
			if ($Search || (isset($_SESSION['ses_filter']) && count($_SESSION['ses_filter'])>0) ) {
				echo "<p><b>".$inc_list_no_enreg1."</b><br><a href='".NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=".$TableDef."'>".$inc_list_supp_filtre."</a></p>";
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

				// *** API RAJOUT DE L'ALIAS SUR LES LISTES
				// *** 01/03/2005
					$chaine = "select list_libelle from "._CONST_BO_CODE_NAME."lib_champs where field='".$value."' and id_"._CONST_BO_CODE_NAME."table_def=".$TableDef;
					$RSfield = mysql_query($chaine);
	
					$flag_spec_name = 0;	
					if (mysql_num_rows($RSfield)>0) {
						if (mysql_result($RSfield,0,"list_libelle")!="") {
							$flag_spec_name = 1;
							$ColumnHeader = mysql_result($RSfield,0,"list_libelle");
						}
					}
				// *** FIN RAJOUT API

				if ($flag_spec_name==0) {
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
					elseif ((count($Alias)>$j && eregi("id_"._CONST_BO_CODE_NAME."nav",$Alias[$j])) || eregi("id_"._CONST_BO_CODE_NAME."nav",$value)) {
						$ColumnHeader = "Rubrique";
					}
					//SI IL Y A UN ALIAS
					//elseif ($Alias[$j]) {
					//	$ColumnHeader =  bo_strip_pre_suf($Alias[$j],$fieldtype,$fieldlen);
					//}
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
					elseif ((count($Alias)>$j && eregi("id_"._CONST_BO_CODE_NAME."nav",$Alias[$j])) || eregi("id_"._CONST_BO_CODE_NAME."nav",$value)) {
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
				}
	

				if ($ordre == @mysql_field_table($result, $j).".".@mysql_field_name($result, $j)) {
					$img_ordre =  $imgOrdre;
				}
				else {
					$img_ordre = "";
				}
	
				if ($ColumnHeader && $OrderBy!="Off" && $EnableListingOrder) {//Affichage des liens permettants de trier les colonnes
					if (eregi("id_",@mysql_field_name($result, $j))) {
						// *** API ALIAS DES CHAMPS DE LA LISTE 02/03/05
						//echo "<th ".$WidthTD.">".$img_ordre.bo_strip_pre_suf($value,$fieldtype,$fieldlen)."</th>\n";
						echo "<th ".$WidthTD.">".$ColumnHeader."</th>\n";
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
				if ($ShowAllRec!=1 ) {
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
	
				if (!ereg("filter_".$j."_null", $_SESSION['ses_filter'][$j]) && count($_SESSION['ses_filter'])>0) {
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
				
				?>
		<select onChange="javascript:document.FormFilter_<?echo $j;?>.submit();" name="filter_<?=$j;?>" class="<?=$StyleListBox;?>">
				<option value="<?="filter_".$j."_null";?>">(<?=$inc_list_aucun?>)</option>
				<?
				if ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey)) {
				    //recuperation du tabledef de la table:
				    $table = str_replace("id_","",$fieldname);
				    $sql_S = "select id__table_def from _table_def where cur_table_name='".$table."'";
				    
				    $result_S = mysql_query($sql_S);
				    $tableDef = mysql_result($result_S,0,"id__table_def");
				    //Test si le champs est multilangue
				    $sql_S = "select multilingue from _lib_champs where field='libelle' and id__table_def='$tableDef'";
				   
            $result_S = mysql_query($sql_S);
				    if(mysql_result($result_S,0,"multilingue") == 1){
              $StrSQLFilter = "select libelle,id__".$table." as id from trad_".$table." where id__langue='".$_SESSION["ses_langue"]."'";
              $RstFilter = mysql_query($StrSQLFilter);
              echo $StrSQLFilter."<br>";
              while($myrow = mysql_fetch_array($RstFilter)){
                    echo "<option value=\"$tablename.".$fieldname." LIKE ##%".$myrow["id"]."%##\" $Selected>".$myrow["libelle"]."</option>";
              }
            }
				}else{
				
				
				//echo $StrSQLFilter."<br>";
				//if ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_booleen)){
				//	echo get_sql_format($StrSQLFilter);
				//}
				
				?>
				<?
				if (!ereg("id_"._CONST_BO_CODE_NAME."nav",@mysql_field_name($result, $j))) {
	
					for ($i=0;$i<=@mysql_num_rows($RstFilter) || $i<1;$i++) {
					
						if ($i==0){
							if ($_SESSION['ses_filter'][$j] == $tablename.".".$fieldname."=####") {
								$Selected_vide = "Selected";
							}
							else {
								$Selected_vide = "";
							}
						
							?><option value="<?=$tablename.".".$fieldname."=#### and ".$tablename.".".$fieldname." is NULL";?>" <?=$Selected_vide?>>(<?=$inc_list_vide?>)</option><?
						}
						else {
							$value = $tmp_value = @mysql_result($RstFilter,$i-1 ,$fieldname);
		          $val_select = $value;
		          
							if ((ereg($tablename.".".$fieldname."=##".$value."##",$_SESSION['ses_filter'][$j])) || (!strcasecmp (" DATE_FORMAT(".$tablename.".".$fieldname.", '%Y-%m-%d') =##".$value."##",stripslashes($_SESSION['ses_filter'][$j])))) {						
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
							//Gestion des clefs etrangere � choix multiple
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
					$id_item_nav = split("=",$_SESSION['ses_filter'][$j]);
					get_arbo(0, "&nbsp;&nbsp;",0,$id_item_nav[1],$ActiveItemColor,2,1,0,$j);
				}
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

		//FIN DE L'AFFICHAGE DES FILTRES ?>

		<form name="form_supp" action="<?echo NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&Search=".$Search;?>" method="post">
		<input type="hidden" name="MD" id="MD" value="1">
		<input type="hidden" name="deleteQuery" id="deleteQuery"  value="<?=$StrSQL?>">
	
<?		for ($i=$ObjPage->Min;$i<$ObjPage->Max;$i++) {
	
			if ($fond_cellule == $TdBgColor1) {
				$fond_cellule = $TdBgColor2;
			}
			else {
				$fond_cellule = $TdBgColor1;
			}
	
			//Roll over pour l'element selectionn�
			$ItemEvent =  "onmouseover='ItemOn(this,\"".get_inter_color($ActiveItemColor,0.3)."\",\"".eregi_replace("px","",$FontSize)."\",\"".$nb_cols."\");'";
			$ItemEvent .= "onmouseout='ItemOff(this,\"".$FontColor."\",\"".eregi_replace("px","",$FontSize)."\",\"".$nb_cols."\");'";
	
			//GESTION DE L'ID DE L'ENREGISTREMENT	
			if (is_numeric(@mysql_result($result, $i , 0))) {
				$ID = "&ID=".@mysql_result($result, $i , 0);
                //SDE 07-02-2003
                $obj_id = @mysql_result($result, $i , 0);
			}

      //SDE 07-02-2003
      //Sp�cifique traitement formulaire objets / arbo                  
      if ($TableDef==3)
      {
         $str_object         = mysql_query("Select id_"._CONST_BO_CODE_NAME."object, id_"._CONST_BO_CODE_NAME."nav, item_table_ref_req, id_"._CONST_BO_CODE_NAME."table_def from "._CONST_BO_CODE_NAME."object where id_"._CONST_BO_CODE_NAME."object=$obj_id");
         $item_table_ref     = mysql_result($str_object,0,"item_table_ref_req");
         $id_bo_object       = mysql_result($str_object,0,"id_"._CONST_BO_CODE_NAME."object");
         $table_ref          = mysql_result($str_object,0,"id_"._CONST_BO_CODE_NAME."table_def");
         $id_nav_obj 	= mysql_result($str_object,0,"id_"._CONST_BO_CODE_NAME."nav");

         $qString = "idItem=".$id_nav_obj."&TableDef=".$table_ref."&mode=modif&ID=".$item_table_ref."&idObj=".$id_bo_object;
                
         // LAC 24/02
				 $dString = "idItem=".$id_nav_obj."&TableDef=".$table_ref."&mode=duplicate&methode=duplicate&ID=".$item_table_ref."&idObj=".$id_bo_object."&Page=".$Page;
                
         echo "<tr bgcolor=".$fond_cellule." ".$ItemEvent." onclick=\"document.location.href='bo.php?".$qString."'\" style=\"cursor:pointer\">";
      }
	    else
	    {
	       //traitement normal
         echo "<tr bgcolor=".$fond_cellule." ".$ItemEvent." onclick=\"document.location.href='".NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=$TableDef&mode=modif&".$ID."&Search=$Search&DisplayMode=$DisplayMode&DisplayMenu=$DisplayMenu&Page=$Page&formMain_selection=$formMain_selection&ordre=$ordre&AscDesc=$AscDesc&id=$i'\" style=\"cursor:pointer\">";
      }
      
			for ($k=$indice_de_depard; $k<$nb_cols; $k++) {
				$value = @mysql_result($result, $i ,@mysql_field_name($result, $k));
	
				$fieldtype =	@mysql_field_type($result, $k);
				$fieldlen  =	@mysql_field_len($result, $k);
				$fieldname  =	@mysql_field_name($result, $k);
				//$fieldderoulante = $tab_selec_deroulante[$k];
				$fieldderoulante = $tab_selec_deroulante_field[$fieldname];


				//10/09/2007-MVA-gestion affichage des multilingue
				if(isMultilingue($fieldname,$TableDef)==1) 
				{
					$strValue="SELECT ".$fieldname." FROM "._CONST_BO_PREFIX_TABLE_TRAD.$tablename." t  WHERE id__".$tablename."=".@mysql_result($result, $i ,"id_".$tablename)." AND id__langue=".$_SESSION['ses_langue'];
					$rsValue=mysql_query($strValue);
					$value=mysql_result($rsValue,0,$fieldname);
				}
				
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
						// JOINTURE SIMPLE
						// ancienne version
						//$str = "select * from ".@eregi_replace("^id_([_a-z]*)(_[0-9]+)?$","\\1",$fieldname)." where ".@eregi_replace("^(id_[_a-z]*)(_[0-9]+)?$","\\1",$fieldname)."=".$value;
	
						// API 02/03/05 
						$str = "select * from ".getTruename(eregi_replace("id_","",$fieldname))." where ".getTruename($fieldname)."=".$value;
						//echo $str."<br>----".$fieldname;

		
						//08/10/2007-MVA-SPECIF MULTILINGUE
						$strTabledef='SELECT id__table_def FROM _table_def WHERE cur_table_name  = \''.ereg_replace("id_","",get_table_annexe_name($fieldname)).'\'';
						$rsTableDef=mysql_query($strTabledef);	
						
						// Si on recup un autre champ que le premier 
						if($fieldderoulante && isMultilingue($fieldderoulante,mysql_result($rsTableDef,0,0)))
						{
							//on recompose la requete pour atteindre les libelles traduis
							$str='SELECT '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).',t.'.$fieldderoulante.' FROM  '.ereg_replace("id_","",get_table_annexe_name($fieldname)).' INNER JOIN '._CONST_BO_PREFIX_TABLE_TRAD.ereg_replace("id_","",get_table_annexe_name($fieldname)).' t ON  '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' = t.id__'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' WHERE t.id__langue='.$_SESSION['ses_langue'].' AND '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.'.get_table_annexe_name($fieldname).'='.$value;

						}
						
						//si champ externe multilingue
						if(isMultilingue(mysql_field_name(mysql_query($str),1),mysql_result($rsTableDef,0,0)))
						{
							//on recompose la requete pour atteindre les libelles traduis
							$str='SELECT '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).',t.'.mysql_field_name(mysql_query($str),1).' FROM  '.ereg_replace("id_","",get_table_annexe_name($fieldname)).' INNER JOIN '._CONST_BO_PREFIX_TABLE_TRAD.ereg_replace("id_","",get_table_annexe_name($fieldname)).' t ON  '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' = t.id__'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' WHERE t.id__langue='.$_SESSION['ses_langue'].' AND '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.'.get_table_annexe_name($fieldname).'='.$value;
						}

						
						//SBA 08/03/21 pour la gestion de l'arbo
						if ($fieldname=="id__nav_pere")
						{
							$str = "select * from "._CONST_BO_CODE_NAME."nav where id_"._CONST_BO_CODE_NAME."nav=".$value;
							
							//08/10/2007-MVA-SPECIF MULTILINGUE
							$strTabledef='SELECT id__table_def FROM _table_def WHERE cur_table_name  = "'._CONST_BO_CODE_NAME.'nav"';
							$rsTableDef=mysql_query($strTabledef);	

							//si champ externe multilingue
							if(isMultilingue(mysql_field_name(mysql_query($str),1),mysql_result($rsTableDef,0,0)))
							{
								//on recompose la requete pour atteindre les libelles traduis
								$str='SELECT '.ereg_replace("id_","",get_table_annexe_name("id__nav")).'.id_'._CONST_BO_CODE_NAME.'nav,Coalesce(t.'._CONST_BO_CODE_NAME.'nav, '._CONST_BO_CODE_NAME.'nav._nav) as _nav  FROM  '._CONST_BO_CODE_NAME.'nav LEFT JOIN '._CONST_BO_PREFIX_TABLE_TRAD._CONST_BO_CODE_NAME.'nav t ON  '.ereg_replace("id_","",get_table_annexe_name('id__nav')).'.id_'._CONST_BO_CODE_NAME.'nav = t.id__'._CONST_BO_CODE_NAME.'nav AND t.id__langue='.$_SESSION['ses_langue'].' WHERE id_'._CONST_BO_CODE_NAME.'nav='.$value;																
							
						
							}
						}
						
						// FIN SPECIF MULTILINGUE
						
						// champs sp�cifi�s
						if ($fieldderoulante!="") {

							$tab_temp = split(",",$fieldderoulante);
							echo("<td>");
						
							for ($b=0;$b<count($tab_temp);$b++) {
								echo @mysql_result(mysql_query($str),0,$tab_temp[$b]);
								if ($b!=count($tab_temp)-1) echo(" / ");
							}
							echo("</td>");
						}else{
							echo "<td>".@mysql_result(mysql_query($str),0,1)."</td>";
						}
					}else {
						// JOINTURE MULTIPLE
						$str = "select * from ".@eregi_replace("^id_(([_a-z0-9]*)([a-z]+))(_[0-9]+)?$","\\1",$fieldname)." where ".@eregi_replace("^(id_[_a-z]*)(_[0-9]+)?$","\\1",$fieldname)." in (".$value.")";
						$rst_multi_key = mysql_query($str);
						
						//echo $str;
	
						//08/10/2007-MVA-SPECIF MULTILINGUE
						$strTabledef='SELECT id__table_def FROM _table_def WHERE item = \''.ereg_replace("id_","",get_table_annexe_name($fieldname)).'\'';
						$rsTableDef=mysql_query($strTabledef);	
						//si champ externe multilingue
						
						if(isMultilingue(mysql_field_name(mysql_query($str),1),mysql_result($rsTableDef,0,0)))
						{
							//on recompose la requete pour atteindre les libelles traduis
							$str='SELECT '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).',t.'.mysql_field_name(mysql_query($str),1).' FROM  '.ereg_replace("id_","",get_table_annexe_name($fieldname)).' INNER JOIN '._CONST_BO_PREFIX_TABLE_TRAD.ereg_replace("id_","",get_table_annexe_name($fieldname)).' t ON  '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' = id__'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' where '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.'.@eregi_replace("^(id_[_a-z]*)(_[0-9]+)?$","\\1",$fieldname).' in ('.$value.') AND  t.id__langue='.$_SESSION['ses_langue'];
						}
						// FIN SPECIF MULTILINGUE
						$rst_multi_key = mysql_query($str);
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
							//echo "<td><a href=\"mailto:".$value."?subject=Merci de ramener le ".@mysql_result($result, $i , 9)." ".@mysql_result($result, $i , 1)." (R�f : ".@mysql_result($result, $i , 0).") � la m�diath�que. \" style='color:white'>".$value."</a></td>";	
					//	}
						//BAYER
					//	else {
							echo "<td><a href=\"mailto:".$value."\">".$value."</a></td>";
					//	}
					
				}
				//GESTION DES ELEMENTS RATACH�S A L'ARBORESCENCE
				elseif (ereg("id_"._CONST_BO_CODE_NAME."nav",$fieldname) /*&& $TableDef!=2*/) {
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
								
								//FFR SPEC ETHIC ETAPES, pas de suppression si profil centre
								if (eregi("Supprimer",$TitreCol[$ij]) && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE && ($_REQUEST["TableDef"]== _CONST_TABLEDEF_CENTRE || 
								                                                                                          $_REQUEST["TableDef"]== _CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE ||
                                                                                                          $_REQUEST["TableDef"]== _CONST_TABLEDEF_ACCUEIL_GROUPE ||
                                                                                                          $_REQUEST["TableDef"]== _CONST_TABLEDEF_ACCUEIL_REUNION))
								{
									echo "<td align=\"center\" bgcolor='".get_inter_color($TableBgColor,0.4)."' >- </td>";
								}
								else
								{
//									echo "<td align=\"center\" bgcolor='".get_inter_color($TableBgColor,0.4)."' ".$ItemEvent."><a href=\"".NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&mode=".$ModeCol[$ij]."&id=".$i."&ordre=".$ordre."&AscDesc=".$AscDesc."&Page=".$Page."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search.$ID."&".$Filters."\">"."<img src=\"images/icones/".$Picto."\" width=\"16\" border=\"0\" alt=\"".$TitreCol[$ij]."\">"."</a></td>";
									echo "<td align=\"center\" bgcolor='".$fond_cellule."' ".$ItemEvent."><a href=\"".NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING']."&mode=".$ModeCol[$ij]."&id=".$i."&ordre=".$ordre."&AscDesc=".$AscDesc."&Page=".$Page."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search.$ID."&".$Filters."\" style=\"color:#000000;\">".$TitreCol[$ij]."</a></td>";
								}
							}
						}
					}
				}
			}
			
			if (($_SESSION['ses_profil_user']<=2)&&(in_array("Supprimer",$TitreCol))) {
				echo("<td><input type='checkbox' name='supress_".mysql_result($result,$i ,0)."' id='supress_".mysql_result($result,$i ,0)."' value='1' class='InputText'></td>");
			}
			echo "</tr>\n";
		}
	
		echo "</table>";
	
		$ObjPage->Affiche($result, $Page, "&TableDef=".$TableDef."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&DisplayMode=".$DisplayMode."&idItem=".$_REQUEST['idItem']."&formMain_selection=".$formMain_selection);

		echo("</form>");	

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

function getMultilingueForeignKey()
{
	
}
?>