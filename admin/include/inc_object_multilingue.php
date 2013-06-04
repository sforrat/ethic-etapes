<?


			//*** Je repertorie les langue afin de leur creer un control plus tard
			
			// *** liste de sélection de la langue
$strLangue = "SELECT * FROM _langue ";

//En fonction de l'utilisateur, on affiche les langues auquelles il a droit.
if ($_SESSION['ses_profil_user']!=1 && $_GET["TableDef"] != _CONST_TABLEDEF_ACTUALITE && $_GET["TableDef"] != _CONST_TABLEDEF_BON_PLAN)
{
	$strLangue.= " WHERE id__langue in (".$_SESSION['ses_id_langue_user'].")";
}
$strLangue.= " ORDER BY _langue_by_default desc, id__langue asc";



			$rsLangues=@mysql_query($strLangue);
			$rs=$rsLangues;

			
			//*** Début du bloc de saisie
			echo "<td colspan='2'><div >";
			$tbLan="<div class='onglets_langues'  ><ul>";
			$tbCtrl="<div id=\"ctrl\" >";
			
			$index_lang_selected = 0; 
			//On regarde quelle langue sélectionner : 
			for($index=0;$index<@mysql_num_rows($rs) && $index_lang_selected==0 ;$index++)
			{
				
				$lan_id=@mysql_result($rs,$index,"id__langue"); 
				if ($lan_id == $_SESSION['ses_langue'])
				{
					$index_lang_selected = $index;
				}
			}
			
				
			for($i=0;$i<@mysql_num_rows($rs);$i++)
			{
				$ctrl="";
				//*** Si premier element
				//*** j'ouvre le tableau
				if($i==$index_lang_selected)
				{
					$classe="class=\"active\"";
					$display="block";
				}
				else
				{
					$classe="";
					$display="none";
				}
			
				//*** informations sur la langue en cours de traitement 							
				//*** id+abreviation 							 							
				$lan_id=@mysql_result($rs,$i,"id__langue"); 							
				$lan_abr=@mysql_result($rs,$i,"_langue_abrev");
				//*** je vérifie si une valeure a déjà été saisie
				$form_fieldname=$form_fieldname."_".$lan_id;
				if($ID!="")
				{		
					$strValue="SELECT ".$fieldname." FROM ". _CONST_BO_PREFIX_TABLE_TRAD.$tablename." WHERE id__langue=".$lan_id." AND id__".$tablename."=".$ID;			
					$rsResult=mysql_query($strValue);
					$fieldvalue=mysql_result($rsResult,0,$fieldname);
				}
				else
					$fieldvalue="";
				
				
				
				//*** colonne libelle langue
				$tbLan.="<li id=\"ong_".$i."_".$lan_id."\" ".$classe." ><a href=\"#	\" onclick=\"javascript:return highlight(this, '".$fieldname."_".$lan_id."');\">".$lan_abr."</a></li>";	
				$tbCtrl.="<div id=\"".$fieldname."_".$lan_id."\" class=\"onglets_ctrls_multi\" style=\"display:".$display."\">";
				
				//DATETIME
				if ($fieldtype==$datatype_date || $fieldtype==$datatype_datetime) 
				{
						if ($fieldtype==$datatype_datetime) 
						{
							$arr_date_popup[$form_fieldname] = $fieldtype;
							$DefaultDateFormat = "&nbsp;<a href=\"javascript:cal_".$form_fieldname.".select(document.formulaire.".$form_fieldname.",'anchor1x_".$form_fieldname."','dd/MM/yyyy hh:mm:ss','false')\" NAME='anchor1x_".$form_fieldname."' ID='anchor1x_".$form_fieldname."'><img src='calendar/date.gif' border='0' alt='".$inc_form_select_date."'></a>"; //&nbsp;Format : JJ/MM/AAAA HH:MM:SS
							$field_date_size = 19;
						}
						else 
						{
							$arr_date_popup[$form_fieldname] = $fieldtype;
							$DefaultDateFormat = "&nbsp;<a href=\"javascript:cal_".$form_fieldname.".select(document.formulaire.".$form_fieldname.",'anchor1x_".$form_fieldname."','dd/MM/yyyy','false')\" NAME='anchor1x_".$form_fieldname."' ID='anchor1x_".$form_fieldname."'><img src='calendar/date.gif' border='0' alt='".$inc_form_select_date."'></a>"; //&nbsp;Format : JJ/MM/AAAA
							$field_date_size = 11;
						}

						if ($fieldvalue) 
						{
							if ($fieldtype==$datatype_datetime) 
							{
								$str_new_time = " ".date("H:i:s",GetTimestampFromDate(substr($fieldvalue,0,10),substr($fieldvalue,-8)));
							}
							else 
							{
								$str_new_time = "";
							}
							$datetemp = split("-",substr($fieldvalue,0,10));
							$newdate = $datetemp[2]."/".$datetemp[1]."/".$datetemp[0].$str_new_time;

							if ($newdate=="00/00/0000") 
							{
								$newdate = "";
							}
						}
						else 
						{
							$newdate = $DefaultDate;
						}

						//GESTION DES DATES DU JOUR AUTOMATIQUES
						if (ereg("_auto",$fieldname)) 
						{
							if ($mode=="nouveau") 
							{
								if ($fieldtype==$datatype_datetime) 
								{
									$str_new_time = " ".date("H:i:s",mktime());
								}
								else 
								{
									$str_new_time = "";
								}
								$newdate = 	CDate(date("Y-m-d"),1).$str_new_time;
							}
							$StyleChampDate = "readonly style=\"color:gray\"";
							$DefaultDateFormat = "";
						}
						else 
						{
							$StyleChampDate = ""; // car sinon, champ date readonly impose date obligatoire
							//$StyleChampDate = "readonly";
						}
						$ctrl .="<DIV ID='datediv_".$form_fieldname."' STYLE='position:absolute;visibility:hidden;background-color:white;layer-background-color:white;'></DIV><input ".$StyleChampDate." ".$fieldEffect." type=\"text\" class=\"".$StyleChamps."\" name=\"".$form_fieldname."\" size=\"".$field_date_size."\" value=\"".$newdate."\" ".$input_allow.">".$DefaultDateFormat;
					}

					//------------ MODIF LAC 12/2004
					// pb : le varchar(254) est trop petit pour stocker tous les id dans la table user..
					// passage du champ en longtext => detection dans inc_form ici=					
					elseif(($_REQUEST['TableDef']==8)&&($fieldname == $datatype_arbo))
					{
					   $ctrl .= "<select class=\"".$StyleChamps."\" ".$input_allow." name=\"".$form_fieldname."[]\" id=\"".$form_fieldname."\" size='20' multiple>";
							
					   if (empty($show_tree_from)) {
					      $show_tree_from = 0;
					   }

					   get_arbo(1, "&nbsp;&nbsp;",0,@split(",",$fieldvalue),$MenuBgColor,0,1,1);
					   $ctrl .= "</select>";
					}						
					//------------ FIN MODIF LAC 12/2004					
					
					//************    TOUS LES TYPE VARCHAR
					elseif ($fieldtype==$mysql_datatype_text) 
					{
						
						//************    IMAGE OU FICHIER
						if ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_file)) //Fichier à uploader
						{
							if ($fieldvalue && $mode=="modif") 
							{
								$DescFile = split("\.",$fieldvalue);

								$TestImageType = 0;

								for ($img=0 ; $img<count($ImgAcceptExt) ; $img++) 
								{
									if (@eregi($DescFile[count($DescFile)-1],$ImgAcceptExt[$img]))  // 21/07/2001 --> Test si le format du fichier est un format de fichier image existant dans la liste des images ImgAcceptExt[n]
									{
										$TestImageType = 1;
									}
								}
								if ( $TestImageType == 1 )
								{

									//Il s'agit alors d'une image de la liste $ImgAcceptExt[n]

									//On recupere la taille de l'image
									$ArrayImgInfo = @getimagesize($UploadPath[$CtImUpload].$fieldvalue);
									$ImgHeight	= $ArrayImgInfo[1];
									$ImgWidth	= $ArrayImgInfo[0];

									if ($ImgWidth>50) 
									{
										$WidthImgPreview = 	50;
									}
									else 
									{
										$WidthImgPreview = 	$ImgWidth;
									}

									
									//$Image = "<A HREF=\"javascript:JustSoPicWindow('".(eregi_replace($UploadPath[$CtImUpload].$fieldvalue."','".$ImgWidth."','".$ImgHeight."','','#FFFFFF','hug image','0');\"><img src=\"".$UploadPath[$CtImUpload].$fieldvalue."\" width=\"".$WidthImgPreview."\" border=\"0\" alt=\"$fieldname\"></A>";
									// MODIF LAC 12/11 : lien absolu vers l'affichage des images dus au liens symboliques vers l'appli centralisée
									$Image = "<A HREF=\"javascript:JustSoPicWindow('".eregi_replace(_CONST_BO_BINARY_UPLOAD,_CONST_APPLI_URL."images/upload/",$UploadPath[$CtImUpload]).$fieldvalue."','".$ImgWidth."','".$ImgHeight."','','#FFFFFF','hug image','0');\"><img src=\"".eregi_replace(_CONST_BO_BINARY_UPLOAD,_CONST_APPLI_URL."images/upload/",$UploadPath[$CtImUpload]).$fieldvalue."\" width=\"".$WidthImgPreview."\" border=\"0\" alt=\"$fieldname\"></A>";

									$imageWidthHeight = "<span style=font-size:8>L : ".$ImgWidth."<br>H: ".$ImgHeight."</span>";
								}
								else
								{
									//$Image = "<A HREF=\"".$UploadPath[$CtImUpload].$fieldvalue."\" target=\"_blank\">".$fieldvalue."</A>";
									$Image = "<A HREF=\"".eregi_replace(_CONST_BO_BINARY_UPLOAD,_CONST_APPLI_URL."images/upload/",$UploadPath[$CtImUpload]).$fieldvalue."\" target=\"_blank\">".$fieldvalue."</A>";
									$imageWidthHeight = "";
								}
								
								//Case a cocher pour supprimer l'image
								$PictureDelete = "<br><input type=\"checkbox\" name=\"PictureDelete_".$fieldname."_".$lan_id."\" value=\"1\" ".$input_allow.">&nbsp;".$NoPictureTitle;
							}
							else 
							{
								$Image = "";
								$PictureDelete = "";
								$imageWidthHeight = "";
							}

              if ($methode=="duplicate") 
              {
                  $hidden_file_name = "<input type=\"hidden\" value=\"".$fieldvalue."\" name=\"".$form_fieldname."_".$methode."\" class=\"".$StyleChamps."\">";
              }
              else 
              {
                  $hidden_file_name ="";
              }
							//<td>&nbsp;&nbsp;</td>
							$ctrl .= "
									<table><tr><td>
							";

							if ($mode != "nouveau") 
							{
						    if (is_numeric($fieldvalue)) 
						    {
					        if (eregi("upload",$user_portfolio_type) && eregi("portfolio",$user_portfolio_type)) 
					        {
				            $portfolio_style_option_td1 = "block";
				            $portfolio_style_option_td2 = "block";
				
				            $portfolio_checked_r1 = "checked";
				            $portfolio_checked_r2 = "";
				            $portfolio_style_td1 = "block";
				            $portfolio_style_td2 = "none";
					        }
					        elseif (eregi("portfolio",$user_portfolio_type)) 
					        {
				            $portfolio_style_option_td1 = "block";
				            $portfolio_style_option_td2 = "none";
				
				            $portfolio_checked_r1 = "checked";
				            $portfolio_checked_r2 = "";
				            $portfolio_style_td1 = "block";
				            $portfolio_style_td2 = "none";

					        }
					        elseif (eregi("upload",$user_portfolio_type)) 
					        {
				            $portfolio_style_option_td1 = "block";
				            $portfolio_style_option_td2 = "none";
				
				            $portfolio_checked_r1 = "checked";
				            $portfolio_checked_r2 = "";
				            $portfolio_style_td1 = "block";
				            $portfolio_style_td2 = "none";
					        }
						    }
						    elseif (empty($fieldvalue))
						    {
					        if (eregi("upload",$user_portfolio_type) && eregi("portfolio",$user_portfolio_type)) 
					        {
				            $portfolio_style_option_td1 = "block";
				            $portfolio_style_option_td2 = "block";
				
				            $portfolio_checked_r1 = "checked";
				            $portfolio_checked_r2 = "";
				            $portfolio_style_td1 = "block";
				            $portfolio_style_td2 = "none";
					        }
					        elseif (eregi("portfolio",$user_portfolio_type)) 
					        {
				            $portfolio_style_option_td1 = "block";
				            $portfolio_style_option_td2 = "none";
				
				            $portfolio_checked_r1 = "checked";
				            $portfolio_checked_r2 = "";
				            $portfolio_style_td1 = "block";
				            $portfolio_style_td2 = "none";
					        }
					        elseif (eregi("upload",$user_portfolio_type)) 
					        {
				            $portfolio_style_option_td1 = "none";
				            $portfolio_style_option_td2 = "block";
				
				            $portfolio_checked_r1 = "";
				            $portfolio_checked_r2 = "checked";
				            $portfolio_style_td1 = "block";
				            $portfolio_style_td2 = "none";
					        }
						    }
						    else 
						    {
						    	if (eregi("upload",$user_portfolio_type) && eregi("portfolio",$user_portfolio_type)) 
						    	{
				            $portfolio_style_option_td1 = "block";
				            $portfolio_style_option_td2 = "block";
				
				            $portfolio_checked_r1 = "";
				            $portfolio_checked_r2 = "checked";
				            $portfolio_style_td1 = "none";
				            $portfolio_style_td2 = "block";
						      }
					        elseif (eregi("portfolio",$user_portfolio_type)) 
					        {
				            $portfolio_style_option_td1 = "block";
				            $portfolio_style_option_td2 = "none";
				
				            $portfolio_checked_r1 = "checked";
				            $portfolio_checked_r2 = "";
				            $portfolio_style_td1 = "block";
				            $portfolio_style_td2 = "none";
					        }
					        elseif (eregi("upload",$user_portfolio_type)) 
					        {
				            $portfolio_style_option_td1 = "none";
				            $portfolio_style_option_td2 = "block";
				
				            $portfolio_checked_r1 = "";
				            $portfolio_checked_r2 = "checked";
				            $portfolio_style_td1 = "none";
				            $portfolio_style_td2 = "block";
					        }
						    }
							}
							else 
							{
						    if (eregi("upload",$user_portfolio_type) && eregi("portfolio",$user_portfolio_type)) 
						    {
					        $portfolio_checked_r1 = "checked";
					        $portfolio_checked_r2 = "";
					        $portfolio_style_td1 = "block";
					        $portfolio_style_td2 = "none";
					
					        $portfolio_style_option_td1 = "block";
					        $portfolio_style_option_td2 = "block";
						    }
						    elseif (eregi("portfolio",$user_portfolio_type)) 
						    {
					        $portfolio_checked_r1 = "checked";
					        $portfolio_checked_r2 = "";
					        $portfolio_style_td1 = "block";
					        $portfolio_style_td2 = "none";
					
					        $portfolio_style_option_td1 = "block";
					        $portfolio_style_option_td2 = "none";
						    }
						    elseif (eregi("upload",$user_portfolio_type)) 
						    {
					        $portfolio_checked_r1 = "";
					        $portfolio_checked_r2 = "checked";
					        $portfolio_style_td1 = "none";
					        $portfolio_style_td2 = "block";
					
					        $portfolio_style_option_td1 = "none";
					        $portfolio_style_option_td2 = "block";
						    }
						    else 
						    {
						        $portfolio_checked_r1 = "checked";
						        $portfolio_checked_r2 = "";
						        $portfolio_style_td1 = "block";
						        $portfolio_style_td2 = "none";
						    }
							}

              // SPECIFIQUE MENU PORTFOLIO 
              // si on est dans le menu PORTFOLIO, on offre la possibilité de lister le contenu du rep
              // sinon, on affiche le menu déroulant du portfolio

              if ($TableDef==332) 
              {
              	$ctrl .= "<script>window.open( \"portfolio_view.php\", \"Portfolio\", \"toolbar=no,menubar=no,resizable=no,scrollbars=yes\" );</script>";

	              //$str_nomTable = "SELECT uploAd_path FROM "._CONST_BO_CODE_NAME."table_def WHERE id__table_def = ".$TableDef;
	              //$rst_nomTable = mysql_query( $str_nomTable );

                $ctrl .= "
										<table border='0' cellpadding='0' cellspacing='5' width='450' height='100'>
												<tr>
                                                    <td valign=\"top\" width='120'>
                                                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                            <tr style=\"display:".$portfolio_style_option_td1."\">
                                                                <td width=20><input type=\"radio\" ".$input_allow." ".$portfolio_checked_r1." name=\"choose_img_type_".$form_fieldname."\" value=\"1\" onClick=\"javascript:document.all['img_portfolio_".$form_fieldname."'].style.display='block';document.all['img_upload_".$form_fieldname."'].style.display='none'\"></td>
                                                            	<td>".$inc_form_server_file."</td>
                                                            </tr>
                                                            <tr style=\"display:".$portfolio_style_option_td2."\">
                                                                <td width=20><input type=\"radio\" ".$input_allow." ".$portfolio_checked_r2." name=\"choose_img_type_".$form_fieldname."\" value=\"0\" onClick=\"javascript:document.all['img_upload_".$form_fieldname."'].style.display='block';document.all['img_portfolio_".$form_fieldname."'].style.display='none'\"></td>
                                                            	<td>".$inc_form_new_file."</td>
                                                            </tr>
                                                            </table>
                                                    </td>
                                                    <td style=\"display:".$portfolio_style_td1."\" id=\"img_portfolio_".$form_fieldname."\" valign=\"top\">                                                   
								";
								$ctrl .= get_bo_Replist( $UploadPath[0] );
								$ctrl .= "
                                                    </td>
                                                    <td style=\"display:".$portfolio_style_td2."\" id=\"img_upload_".$form_fieldname."\" valign=\"top\">
                                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                        <tr>
                                                        <td valign=\"top\">".$inc_form_select_file."<br>
                                                            <input type=\"file\" ".$input_allow." class=\"".$StyleChamps."\" name=\"".$form_fieldname."\" size=\"".intval($FieldWidthSize-47)."\" ".$fieldEffect.">
                                                            ".$hidden_file_name."
                                                        <br><font color=red><b>(fichier < 1.5Mo)</font><br><br>
								";
	              
	              if (_CONST_FTP_PORTOFOLIO_ENABLE=="true") 
                {
                	$ctrl .= "
                                                        <a href=\""._CONST_FTP_PORTOFOLIO_URL."\" target=\"_blank\">via FTP</a>
									".$inc_form_warning_ftp;
                }
								
								$ctrl .= "
                                                        </td>
                                                        <td align=center>
                                                            ".$Image.$PictureDelete."
                                                        </td>
                                                        <td>
                                                            ".$imageWidthHeight."
                                                        </td>
                                                        </tr>
                                                        </table>
                                                    </td>
												</tr>
										</table>
									</td>
								<tr></table>"; // dernier </td> ??
								$CtImUpload++;

              }
              else
              {
              	$ctrl .= "
										<table border='0' cellpadding='0' cellspacing='5' width='450' height='100'>
												<tr>
                                                    <td valign=\"top\" width='120'>
                                                            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                            <tr style=\"display:".$portfolio_style_option_td1."\">
                                                                <td width=20><input type=\"radio\" ".$input_allow." ".$portfolio_checked_r1." name=\"choose_img_type_".$form_fieldname."\" value=\"1\" onClick=\"javascript:document.all['img_portfolio_".$form_fieldname."'].style.display='block';document.all['img_upload_".$form_fieldname."'].style.display='none'\"></td>
                                                            	<td>".$inc_form_portfolio_image."</td>
                                                            </tr>
                                                            <tr style=\"display:".$portfolio_style_option_td2."\">
                                                                <td width=20><input type=\"radio\" ".$input_allow." ".$portfolio_checked_r2." name=\"choose_img_type_".$form_fieldname."\" value=\"0\" onClick=\"javascript:document.all['img_upload_".$form_fieldname."'].style.display='block';document.all['img_portfolio_".$form_fieldname."'].style.display='none'\"></td>
                                                            	<td>".$inc_form_portfolio_specifique."</td>
                                                            </tr>
                                                            </table>
                                                    </td>
                                                    <td style=\"display:".$portfolio_style_td1."\" id=\"img_portfolio_".$form_fieldname."\" valign=\"top\">

								";
								$ctrl .= get_bo_portfolio();
								$ctrl .= "
                                                    </td>
                                                    <td style=\"display:".$portfolio_style_td2."\" id=\"img_upload_".$form_fieldname."\" valign=\"top\">
                                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
                                                        <tr>
                                                        <td valign=\"top\">".$inc_form_select_image."<br>
                                                            <input type=\"file\" ".$input_allow." class=\"".$StyleChamps."\" name=\"".$form_fieldname."\" size=\"".intval($FieldWidthSize-47)."\" ".$fieldEffect.">
                                                            ".$hidden_file_name."
                                                        </td>
                                                        <td align=center>
                                                            ".$Image.$PictureDelete."
                                                        </td>
                                                        <td>
                                                            ".$imageWidthHeight."
                                                        </td>
                                                        </tr>
                                                        </table>
                                                    </td>
												</tr>
										</table>
									</td></table>";
                
								$CtImUploaD++;
									
              }
            }
						//************    COULEUR
						elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_color)) 
						{
							$ColorTdView = "<td><table width='100' cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td><table cellpadding=\"0\" cellspacing=\"1\" border=\"0\" bgcolor=\"#000000\"><tr><td style='background-color:$fieldvalue;' id='Td$k'><a href=\"javascript:MM_openBrWindow('library/colorPicker.php?NomChamp=$form_fieldname&IdTd=Td$k','','status=no,scrollbars=no,resizable=no,height=253,width=170')\"><img src=\"images/pixtrans.gif\" width=\"15\" height=\"15\" border=0 alt=\"".$inc_form_choose_color."\"></a></td></tr></table></td></tr></table></td>";
							$ctrl .= "<td><input ".$input_allow." class=\"".$StyleChamps."\" ".$fieldEffect." type=\"text\" name=\"".$form_fieldname."\" size=\"".$FieldWidthSize."\" value=\"".$fieldvalue."\" onChange=\"javascript:Td$k.style.backgroundColor=formulaire.$form_fieldname.value\">".$ColorPicker."</td>".$ColorTdView;
						}
						//************    CHAMP MOT DE PASSE
						elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_password)) 
						{
							if ($mode=="nouveau") 
							{
									$fieldvalue = password_generator($datatype_password_length);
							}
							$ctrl .= "<input ".$fieldEffect." ".$input_allow." class=\"".$StyleChamps."\" type=\"text\" id=\"".$form_fieldname."\" name=\"".$form_fieldname."\" size=\"".intval(ereg_replace("(.*)\((.*)\)","\\2",$datatype_password)+1)."\" value=\"".$fieldvalue."\">&nbsp;".ereg_replace("(.*)\((.*)\)","\\2",$datatype_password).$inc_form_max_car;
						}
						//************    CHAMP TEXT
						elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_text)) 
						{
							$ctrl.="<input ".$fieldEffect." ".$input_allow." class=\"".$StyleChamps."\" type=\"text\" id=\"".$form_fieldname."\"  name=\"".$form_fieldname."\" size=\"".$FieldWidthSize."\" value=\"".$fieldvalue."\">";
						}
						//************    LIEN URL
						elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_url)) 
						{
							if ($mode=="nouveau") {
									$fieldvalue = "http://www.";
							}
							
							$ctrl .= "<input ".$fieldEffect." style=\"text-decoration:underline\" ".$input_allow." class=\"".$StyleChamps."\" type=\"text\" id=\"".$form_fieldname."\"  name=\"".$form_fieldname."\" size=\"".$FieldWidthSize."\" value=\"".$fieldvalue."\">&nbsp;<a href=\"javascript:MM_openBrWindow(document.formulaire.".$form_fieldname.".value,'TestUrl','')\"><img src=\"images/icones/lien.gif\" border=\"0\"></a>";
						}
						//************    LISTE DE DONNEES
			    	elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_list_data)) 
			    	{
	            $id_list_data = split("_",$form_fieldname);
	            $id_list_data = $id_list_data[count($id_list_data)-1];
	
	            $str_sql = "
	                SELECT 
	                    "._CONST_BO_CODE_NAME."list_data.* 
	                FROM 
	                    "._CONST_BO_CODE_NAME."list_data 
	                WHERE 
	                    "._CONST_BO_CODE_NAME."list_data.id_"._CONST_BO_CODE_NAME."list_data = ".$id_list_data." 
	            ";
	
	            $rst_list_data = mysql_query($str_sql);
	
	            $list_data_data     = @mysql_result($rst_list_data,0,"data");
	            $list_data_control  = @mysql_result($rst_list_data,0,"control_5");
	            $list_data_order    = @mysql_result($rst_list_data,0,"order_8");
	            $list_data_align    = @mysql_result($rst_list_data,0,"align_9");
	
	            if (empty($list_data_order)) {
	                $list_data_order = "ksort";
	            }

              $list_data = split("\n", $list_data_data);

              //ordre de la liste
              eval("\$list_data_order(\$list_data);");

              $fieldvalue = split("\|",$fieldvalue);


              //LISTBOX
              if ($list_data_control == "listbox" || $list_data_control == "listbox multiple") 
              {
                if ($list_data_control == "listbox multiple") 
                {
                  $multiple = "multiple";
                }
                else 
                {
                	$multiple = "";
                }

                $ctrl .= "<select class=\"".$StyleChamps."\" ".$input_allow." name=\"".$form_fieldname."[]\" id=\"".$form_fieldname."[]\" ".$multiple.">";
                
                $indice = 0;

                foreach ($list_data as $v) 
                { 
                  if ((in_array(trim($v), $fieldvalue))) 
                  {
                    $selected = "selected";
                  }
                  else 
                  {
                    $selected = "";
                  }
                  if (trim($v)=="" && ($indice == 1)) 
                  {
                    $ctrl .= "<option value=\"".trim($v)."\" ".$selected.">".ucfirst($v)."</option>";
                  }
                  elseif (trim($v)!="") 
                  {
                    $ctrl .= "<option value=\"".trim($v)."\" ".$selected.">".ucfirst($v)."</option>";
                  }
                  $indice++;
              	}
                $ctrl .= "</select>";
              }
              //RADIO
              //CHECKBOX
              elseif (($list_data_control == "radio") || ($list_data_control == "checkbox")) 
              {
                $ctrl .= "<table border=0 cellpadding=1 cellspacing='1' bgcolor=#9A9A9A><tr><td bgcolor=#F7F7F7>";
                foreach ($list_data as $v) 
                {
                  if ((in_array(trim($v), $fieldvalue))) 
                  {
                    $selected = "checked";
                  }
                  else 
                  {
                    $selected = "";
                  }

                  if (trim($v)!="") 
                  {
                    $ctrl .= "<input type='".$list_data_control."' name=\"".$form_fieldname."[]\" id=\"".$form_fieldname."[]\" ".$selected." value=\"".trim($v)."\" ".$input_allow.">".ucfirst(trim($v))."</option>";

                    if ($list_data_align == "horizontal") 
                    {
                      echo "&nbsp;&nbsp;&nbsp;";
                    }
                    else 
                    {
                      $ctrl .= "<br>";
                    }
                	}
                  $indice++;
                }
                $ctrl .= "</td></tr></table>";
              }
              //echo get_sql_format($str_sql);
						}
						//************    LISTE DEROULANTES A CHOIX MULTIPLE SUR L'ARBORESCENCE
						elseif (($fieldname == $datatype_arbo) && ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey))) 
						{
							$ctrl .= "<select class=\"".$StyleChamps."\" ".$input_allow." name=\"".$form_fieldname."[]\" id=\"".$form_fieldname."\" size='20' multiple>";
							
							if (empty($show_tree_from)) 
							{
								$show_tree_from = 0;
							}
							
							get_arbo(1, "&nbsp;&nbsp;",0,@split(",",$fieldvalue),$MenuBgColor,0,1,1);
							$ctrl .= "</select>";

						}
						//************    LISTE DEROULANTES A CHOIX MULTIPLE
						elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey)) 
						{					
	
							$str_multi_select = "Select * from ".ereg_replace("id_","",get_table_annexe_name($fieldname));
							//Si le premier enregistrement de la table concernée est (Aucun), on ne l'affiche pas
							if (ereg("^\(Aucun\)$",@mysql_result(mysql_query("select * from ".ereg_replace("id_","",get_table_annexe_name($fieldname))),0,1))) 
							{
								//if (!ereg("_data",get_table_annexe_name($fieldname))) {
								$str_multi_select .= " where ".get_table_annexe_name($fieldname)."!=1 ";
							}
							//echo $str_multi_select;
							
							$str_multi_filter = " order by ordre"; // si champ ordre, tri par défaut 
							$rst_multi_select = mysql_query($str_multi_select.$str_multi_filter);
							
							if (mysql_error()) 
							{
								$str_multi_filter = " order by ".ereg_replace("id_","",get_table_annexe_name($fieldname));
								$rst_multi_select = mysql_query($str_multi_select.$str_multi_filter);
							}

							if (mysql_error()) 
							{
								$str_multi_filter = " order by ".$fieldname;
								$rst_multi_select = mysql_query($str_multi_select.$str_multi_filter);
							}
							
							if (mysql_error()) 
							{
								$rst_multi_select = mysql_query($str_multi_select);
							}


							if (@mysql_num_rows($rst_multi_select)>10) 
							{
								$multi_select_size = 10;
							}
							else 
							{
								$multi_select_size = @mysql_num_rows($rst_multi_select);
							}
							echo "<select  class=\"".$StyleChamps."\" ".$input_allow." id=\"".$form_fieldname."\" name=\"".$form_fieldname."[]\" size=\"".$multi_select_size."\" multiple>";

							$ar_valeur = split(",",$fieldvalue);

							for ($s=0; $s<@mysql_num_rows($rst_multi_select) ;$s++) 
							{
								if (in_array(@mysql_result($rst_multi_select,$s,0),$ar_valeur)) 
								{
									$selected = "selected";
								}
								else 
								{
									$selected= "";
								}
								if ($fieldderoulante!="") 
								{
									$ctrl .= "<option value=\"".@mysql_result($rst_multi_select,$s,0)."\" ".$selected.">";
									$tab_temp = split(",",$fieldderoulante);
									for ($b=0;$b<count($tab_temp);$b++) 
									{
										$ctrl .= (mysql_result($rst_multi_select,$s,$tab_temp[$b]));
										if ($b!=count($tab_temp)-1) echo(" / ");
									}
									$ctrl .=("</option>");
								}
								else
								$ctrl .= "<option value=\"".@mysql_result($rst_multi_select,$s,0)."\" ".$selected.">".@mysql_result($rst_multi_select,$s,1)."&nbsp;&nbsp;&nbsp;</option>";
							}
							$ctrl .= "</select>";
							
							get_option_edit_table();

						}

					}
					elseif($fieldtype==$mysql_datatype_text_rich)
					{
								//*** Text Area et TextRich
						if ($mode=="modif" || $mode=="nouveau") 
						{
									//Editeur Html
									// Text rich si autorisé
									if( ($fieldlen > 65535) && (!strcmp(_CONST_ENABLE_RICHTEXT,"true")))
									{
										if (empty($fieldvalue)) {
											$table_height = "height='30'";
										}
										
										$NewFieldHeightSize = 0;
										$NewFieldWidthSize = intval(($FieldWidthSize*6)+16)."px";
		
										$action_editeur = "JavaScript:void(window.open('richtext/editor.php?fieldname=".$form_fieldname."&fieldvalue=','','directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no,width=720,height=600'))";								
										$DivAttTextArea="style=\"position:absolute;left:1px;visibility:hidden; top:1px; width:1px; height:1px; z-index:1\"";
										//relative au lieu de absolute
		  
		                if($_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $form_fieldname == "field_presentation_1" && $_REQUEST["TableDef"] == _CONST_TABLEDEF_CENTRE){
		                    $texte_editor="";
                    }else{
                        $texte_editor=$inc_form_editor_annexe;
                    }
		      
										$editor_annexe = $texte_editor."<br><table width=\"".$NewFieldWidthSize."\" height=\"100%\" cellpadding=\"3\" cellspacing=\"1\" border=\"0\" bgcolor=\"".get_inter_color($MenuBgColor,0.5)."\"><tr><td style=\"cursor:pointer\" ";
                    
                    if($_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $form_fieldname == "field_presentation_1" && $_REQUEST["TableDef"] == _CONST_TABLEDEF_CENTRE){
                    
                         $actionJS = ""; 
                    }else{
                          $actionJS = "onDblClick=\"".$action_editeur."\"";
                    }
                    
                    $editor_annexe .= "id=\"".$form_fieldname."_text\" $actionJS bgcolor=\"".get_inter_color($MenuBgColor,0.03)."\" height='30'>".$fieldvalue."<input type=\"text\" id=\"t_$form_fieldname\" style=\"width:1px;height:1px\" /></td></tr></table>";
		
										$editor_object = "<textarea class='".$StyleChamps."' cols='0' rows='0' id=\"".$form_fieldname."_object\"><!--NAME--><!--SCRIPT--></textarea>";
										$show_in_div=1;
									}
									else //*** Text area simple
									{
									  //Pas d'editeur Html autorisé
										$NewFieldHeightSize = 10;
										$NewFieldWidthSize = $FieldWidthSize-1;								
										$action_editeur = "";							
										$DivAttTextArea="";
										$editor_annexe = "";								
										$editor_object = "";
										$show_in_div=0;
									}
													
									//*** début control
								  
								  $ctrl=$editor_annexe;
								  if ($show_in_div)
								  	$ctrl.="<div ".$DivAttTextArea.">";
								  
								  $ctrl.="<textarea ".$fieldEffect." rows=".$NewFieldHeightSize." cols=".$NewFieldWidthSize." name=".$form_fieldname." id=".$form_fieldname." class=".$StyleChamps." ".$input_allow." >".$fieldvalue."</textarea>".$editor_object;
								 	
								 	if ($show_in_div)
								  	$ctrl.="</div>";
						}
					}
					$ctrl.="</div>";
					$tbCtrl.=$ctrl;	
					$form_fieldname=recompose_formFieldName($form_fieldname);
				}
				$tbLan.= "</ul></div>";
				echo $tbLan;
				$tbCtrl.="</div>";
				echo $tbCtrl;
				echo "</div></td>";
				
			
?>
