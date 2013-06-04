<?

//SBA 061229
//-----------------------------------------------------------------------------------------------------
// Renvoie la valeur du champ url_page pour la rubrique Rub
function get_url_nav_bo($Rub) 
{	
	$StrSQL = "
		    SELECT
       _nav.url_page
		    FROM
    			_nav
	    	WHERE
							_nav.id__nav=".$Rub;

	$Rst = mysql_query($StrSQL);
	$url = mysql_result($Rst, 0, 0);
	
	if (!$url) $url = _URL_PAGE_PAR_DEFAUT;
	
	// on ajoute le Rub a la fin ssi si il n'est pas déja positionné dans url_nav (redirection d'une
	// rub vers une autre), et si ce n'est pas un lien externe
	if ( (!eregi("rub",$url)) && (!eregi("http",$url)) )
	{
	   if (!eregi("\?",$url)) {
	   		$url .= "?Rub=".$Rub;
	   } else {
	   	  $url .= "&Rub=".$Rub;
	   }
	}

	return ($url);	
}


//La personne a choisi de quitter le Back-Office
function deconnection($SessionClose) {
	if ($SessionClose==1) 
	{
	       if (isset($_COOKIE[session_name()])) {
   	          setcookie(session_name(), '', time()-42000, '/');
	       }
	       session_unset();	       
	       $_SESSION = array();
	       session_destroy();
	}
}

//Fonction d'upload de fichier
function UploadFile($id, $FichierUName, $FichierU, $CheminU) {
//Modifier le mardi 11 juin 2002
//	error_reporting(E_ALL);
	
	//Suppression de l'ancien fichier image
	DeleteFile($id, $CheminU);

	//Upload du fichier
	$Tfile = split("\.",$FichierUName);
	$fileExt = $Tfile[count($Tfile)-1];

	$NomLeft = split("\.",$id);

	if (count($NomLeft)>1) {
		@array_pop($NomLeft);
	}
	
	$NomDuFichier = @join($NomLeft,".").".".$fileExt;
	
	$tmp_name = $FichierU['tmp_name'];
	
	//copy($FichierU, $CheminU."/".$NomDuFichier);
	// protection contre la copie
	if (is_uploaded_file($tmp_name))
	{
		// protection contre les erreurs d'upload
		if (!move_uploaded_file($tmp_name ,$CheminU."/".$NomDuFichier)) $NomDuFichier="";				
	}
	else
	{
		// protection contre le hacking d'upload
		$NomDuFichier="";
	}	

	return($NomDuFichier);//nom du fichier a inscrire dans la base
}

function UploadFile_2($FichierUName, $FichierU, $CheminU) 
{
	global $debug_mode;
	// upload du fichier
		
	//die($FichierUName." ".$FichierU." ".$CheminU);
	
	$tab_extensions_autorisees = explode(",",_CONST_UPLOAD_EXTENSIONS_AUTORISEES);
		
	$lib_erreur = Array($bo_lib_tools_aucune_erreur_telecharge,$bo_lib_tools_file_too_big,$bo_lib_tools_file_too_big,$bo_lib_tools_file_incomplete,$bo_lib_tools_no_file); 

	
	if( isset($_FILES[$FichierU] ) && ($_FILES[$FichierU]["name"]!="") )
	{
	   $Img = get_filename_from_text($_FILES[$FichierU]["name"]);
	   $ImgDir = $CheminU;	
	   
	   $Tfile = split("\.",$Img);
	   $fileExt = strtolower($Tfile[count($Tfile)-1]);
	   
	   if (!in_array($fileExt,$tab_extensions_autorisees))
	   {
	   	$erreur =$bo_lib_tools_error_telecharge.$Img.$bo_lib_tools_extension_not_allowed;
	   	$fichier="";
	   }
	   else
	   {
	      if(( $_FILES[$FichierU]["error"] != UPLOAD_ERR_OK )&&(strcmp("4.2.0",phpversion())<=0))
	      {				
	   	 $erreur = $bo_lib_tools_error_telecharge.$lib_erreur[$_FILES[$FichierU]["error"]].$bo_lib_tools_file_not_upload;
	      }
	      else
	      { 		      	  		      	
		  if( is_uploaded_file( $_FILES[$FichierU]['tmp_name'] ))
		  {
     		     //$unique_name = "logo_".$_REQUEST['raison_sociale']."_".$_REQUEST['uid'];	     		    	     		      	
     		     //$NomLeft = get_filename_from_text($unique_name);

		     //$NomDuFichier = $NomLeft.".".$fileExt;	  
		     $NomDuFichier = get_filename_from_text($FichierUName);
		     
		     // on efface l'ancien, s'il existe..
		     DeleteFile($NomDuFichier, $ImgDir);

		     if ( move_uploaded_file( $_FILES[$FichierU]['tmp_name'], $ImgDir.$NomDuFichier ) ) 
		     {
		     	chmod ($ImgDir.$NomDuFichier, 0644);
		     	$fichier = $NomDuFichier;
		     	$erreur="";
		     }
		     else
		     {
			$erreur =  $bo_lib_tools_error_file_move.$Img.$bo_lib_tools_file_not_upload;			
			//$erreur .= "(".addslashes($ImgDir.$NomDuFichier).")";
			$fichier="";
		     }
		  }
		  else
		  {
			$erreur =  $bo_lib_tools_error_file_security.$Img.$bo_lib_tools_file_not_upload;				
			//$erreur .= "(".addslashes($ImgDir.$NomDuFichier).")";
			$fichier="";
		  } 
	      }
	   }
	   if ($erreur!="") echo("<script>alert('".addslashes($erreur)."');</script>");
	   
	   if ($debug_mode)  echo($erreur);
	   
	   return $fichier;		   
	}
}

function DeleteFile($id, $CheminU) {
	//Suppression de l'ancien fichier
  if (is_file($CheminU."/".$id)) unlink($CheminU."/".$id);
}


//For those of you who are still using PHP 3 and those who want in_array to return the key for the value being searched for,
//try the following alternative function:
function is_in_array($needle,$haystack) {
	$needleFound = false;
	$returnValue = false;
	reset($haystack);
	while ((list($key,$value) = each($haystack)) && !$needleFound) {
		if ($needle == $value) {
			$needleFound = true;
			$returnValue = $key;
		}
	}
	return $returnValue;
}

function GetModeNameFromMode($mode,$ModeCol,$TitreCol) {

	for ($ij=0; $ij<count($ModeCol); $ij++) {
		if ($ModeCol[$ij] == $mode) {
			return($TitreCol[$ij]);
			break;
		}
	}
}

function get_arbo_dhtml($id_pere, $Level){
    $StrSQLFils = "
					Select *
					from "._CONST_BO_CODE_NAME."nav
					where id_"._CONST_BO_CODE_NAME."nav_pere = ".$id_pere."
					";

    $RstMessageFils = mysql_query($StrSQLFils);
    if ($Level==0){
        $id_bo_nav	= @mysql_result($RstMessageFils,0,"id_"._CONST_BO_CODE_NAME."nav");
        $nom    = ucfirst(strtolower(@mysql_result($RstMessageFils,0,""._CONST_BO_CODE_NAME."nav")));
        ?>
        //Create main menu
        var m<?=$id_bo_nav?> = new menuObject("m<?=$id_bo_nav?>",pageWidth/2,pageHeight/2+100,"<?=$nom?>",pageHeight/6);
        m<?=$id_bo_nav?>.startAngle = 90;
        
        //show menu and caption
        m<?=$id_bo_nav?>.show();
        m<?=$id_bo_nav?>.showCaption();
        
        <?
        $actionfin = "m".$id_bo_nav.".expand();";
        get_arbo_dhtml($id_bo_nav, 1);
    }else{
        if (@mysql_num_rows($RstMessageFils)) {
            $Level++;
            $nb_fils = @mysql_num_rows($RstMessageFils);
            for ($i=1;$i<=$nb_fils;$i++) {
                $id_bo_nav	= @mysql_result($RstMessageFils,$i-1,"id_"._CONST_BO_CODE_NAME."nav");
                $nom    = ucfirst(strtolower(@mysql_result($RstMessageFils,$i-1,""._CONST_BO_CODE_NAME."nav")));                
                echo "m".$id_bo_nav." = m".$id_pere.".addItem(\"".$nom."\",\"toggle\");\n";
                echo "m".$id_bo_nav.".startAngle = 0;\n";
                get_arbo_dhtml($id_bo_nav,$Level);
            }
                
        }
    }
    echo $actionfin;
}

function get_arbo_menu_left($id_pere, $Level){
	global $nb_get_arbo_menu_left;
	$nb_get_arbo_menu_left++;

	$StrSQLFils = "
					Select *
					from "._CONST_BO_CODE_NAME."nav
					where id_"._CONST_BO_CODE_NAME."nav_pere = ".$id_pere;
	
	if ($_SESSION['ses_profil_user']>2) // affichage de tous les items meme cachés si admin
	{
		$StrSQLFils .= "					
					and "._CONST_BO_CODE_NAME."nav.selected=1 ";
	}
					
	$StrSQLFils .= "order by ordre, id_"._CONST_BO_CODE_NAME."nav
					";
    $RstMessageFils = mysql_query($StrSQLFils);

	if ($Level==0){
		?>
		<script language="JavaScript" src="js/outlook.js"></script>
		<script language="JavaScript">
		var Link = new Array();
		<?

	$actionfin = "start(1);\n</script>";
	}
	if (@mysql_num_rows($RstMessageFils)) {
		$Level++;
		$nb_fils = @mysql_num_rows($RstMessageFils);
		for ($i=1;$i<=$nb_fils;$i++) {
			$id_bo_nav	= @mysql_result($RstMessageFils,$i-1,"id_"._CONST_BO_CODE_NAME."nav");
			$nom    = ucfirst(strtolower(coupe_espace(@mysql_result($RstMessageFils,$i-1,""._CONST_BO_CODE_NAME."nav"),60)));                
			

			echo "\nLink[".intval($nb_get_arbo_menu_left-1)."] = \"".intval($Level-1)."|".$nom."|bo.php?TableDef=3&idItem=".$id_bo_nav."|_parent\";";

			get_arbo_menu_left($id_bo_nav,$Level);
		}
	}

	echo $actionfin;
}

//Retourne l'arbo du site
function get_arbo($id_pere, $Indic, $Level, $id_item, $BgColor, $Mode=0, $ShowInd=0, $ShowNum=0, $FilterNum="", $sql_filter="", $with_user_rights=1) {
	global $nb, $txt_color_lien, $nb_table;
	global $idItem, $table_style, $navID;
	global $ses_profil_user, $arr_user_nav_right;
      
	$nb++;

	$StrSQLFils = "Select id__nav, COALESCE( tn._nav, _nav._nav ) as _nav,  selected,_type_nav.libelle  from "._CONST_BO_CODE_NAME."nav";
	//Patch SBA pour la gestion mutlilingue
	$StrSQLFils.= " LEFT JOIN trad__nav tn on tn.id__"._CONST_BO_CODE_NAME."nav = _nav.id__nav and tn.id__langue = ".$_SESSION['ses_langue'];
	// Patch DRO : Affichage des type de nav
	$StrSQLFils .= " LEFT JOIN _type_nav ON _type_nav.id__type_nav = _nav.id__type_nav";
	
	$StrSQLFils .= " where id_"._CONST_BO_CODE_NAME."nav_pere = ".$id_pere;
	$StrSQLFils .= $sql_filter;
	
	$hsv = get_hsv_color($BgColor);
	$txt_color_lien = "LienNoir";
	$FontColorStyle = "color=black";

	if (($Mode==1 || $Mode==3) && $Level==0) {

		if ($Mode==3) { ?>
			<script language="JavaScript">
		        function expand_and_collapse(mode) {
			        if (document.all) {
			        	for (var i=0; i < document.all.length; i++) {
			                	if (document.all(i).tagName == 'TABLE' && document.all(i).id != '') {
			                        	if (mode=='expand') {
			                                	document.all(i).style.display = 'block';
			                                }else {
								if (document.all(i).id.substring(document.all(i).id.lastIndexOf("_")+1, document.all(i).id.length) > 1) {
			                                        	document.all(i).style.display = 'none';
				                                }
			                                }
						}else if (document.all(i).tagName == 'IMG' && document.all(i).id != '') {
			                                if (mode=='expand') {
								document.all(i).src = 'images/moins.gif';
			                                }else {
								if (document.all(i).id.substring(document.all(i).id.lastIndexOf("_")+1, document.all(i).id.length) > 1) {
			                                        	document.all(i).src = 'images/plus.gif';
								}
			                                }
						}
					}
				}
			}
		        </script>
	            	<table cellspacing="1" cellpadding="2" border="0" width="250">
	                <tr><td colspan="2"></td><td align="right">
	                <table border="0" cellpadding="1" cellspacing="0">
	                <tr>
	                <td>&nbsp;<img style="cursor:pointer" alt="Fermer tous" onClick="expand_and_collapse('collapse')" hspace=10 src='images/moins.gif'>
	                    <img style="cursor:pointer" alt="Ouvrir tous" onClick="expand_and_collapse('expand')" hspace=10 src='images/plus.gif'>
			</td>
	                </tr>
	                </table>
	                </td></tr>
<?
	                $traitement_fin = "</table>";
		}else { ?>
			<table cellspacing="0" cellpadding="2" border="0">
			<tr>
			<td bgcolor="<?=$BgColor?>">
			<b style="<?=$FontColorStyle?>" >Arborescence du site</b>
			</td>
			</tr>
<?			$traitement_fin = "</table>";
		}
	}

	if ((($Mode==1 || $Mode==3))&&($_SESSION['ses_profil_user']>2)) {
		$StrSQLFils .= " and "._CONST_BO_CODE_NAME."nav.selected=1";
	}
	// Patch DRO : Affichage des type de nav
	$StrSQLFils .= " ORDER BY _type_nav.ordre, _nav.ordre, id_"._CONST_BO_CODE_NAME."nav";
	//$StrSQLFils .= " order by ordre, id_"._CONST_BO_CODE_NAME."nav";

	//echo($StrSQLFils);

//	*** => Execution de la requete
	$RstMessageFils = mysql_query($StrSQLFils);

	if (mysql_num_rows($RstMessageFils)) {
		$Level++; //On compte les niveau

		if ($Mode==3) {                
			$nb_table++;
			echo "<tr><td valign=top></td><td colspan=2 width='100%'>\n\n<table id='table_".$nb_table."_".$Level."' ".$table_style." border=0 cellpadding=0 cellspacing=1 bgcolor=\"".get_inter_color($BgColor,0.5)."\"  width='100%'>";
	        }
	
		for ($i=1;$i<=@mysql_num_rows($RstMessageFils);$i++) {
			$id_bo_nav = mysql_result($RstMessageFils,$i-1,"id_"._CONST_BO_CODE_NAME."nav");
			
			//SBA 061229 
			$url_page = get_url_nav_bo($id_bo_nav);
			//$url_page = (mysql_result($RstMessageFils,$i-1,"url_page")!=""?mysql_result($RstMessageFils,$i-1,"url_page"):_URL_PAGE_PAR_DEFAUT);
			$nom = $ArrayPuce[$Level]."&nbsp;";
	           	
			// affichage des menus non selectionné comme affiché pour l'admin
			$cache=0;
			if ((mysql_result($RstMessageFils,$i-1,""._CONST_BO_CODE_NAME."nav.selected"))==0) {
				$cache=1;
				if ($Mode!=0) {
					$nom.="<i><u>";
				}
			}
	           	
			$nom.=(coupe_espace(@mysql_result($RstMessageFils,$i-1,""._CONST_BO_CODE_NAME."nav"),60));
				
			if (((mysql_result($RstMessageFils,$i-1,""._CONST_BO_CODE_NAME."nav.selected"))==0)&&($Mode!=0)) {
				$nom.="</u></i>&nbsp;&nbsp;<img src='images/pasvu.gif' width=17 height=14 border=0 valign=baseline alt='Non visible'>";
				$cache=1;
			}
	           
			if (is_array($id_item) && in_array($id_bo_nav,$id_item)) {
				$Selected = "Selected";
			}elseif ($id_bo_nav == $id_item) {
				$Selected = "Selected";
			}else {
				$Selected = "";
			}
	
			$Ind=$Indic.$i.".";
	
			//Affichage ou non de l'indentation
			if ($ShowInd == 1) {
				$Indentation = str_repeat("&nbsp;&nbsp;",($Level));
			}
	
			//Affichage ou non de la numerotation
			if ($ShowNum == 1) {
		                $Numerotation = $Ind;
			}
	
			if (is_array($arr_user_nav_right) && in_array($id_bo_nav,$arr_user_nav_right)) {
				$allow = 1;
			}elseif ($id_bo_nav == $id_item) {
		                $allow = 1;
			}else {
				$allow = 0;
			}
	
           //POUR L'ADMINISTRATEUR
           if ($_SESSION['ses_profil_user']<=2) 
           {
				$allow = 1;
				$cache=0;
			}
	
			if (!$cache) { 
				// ajout du flag with_user_rights
				if (($Mode==0)||($Mode==4)) {
			                if (($allow == 1)||($with_user_rights == 0)) {
						if ($Mode==0) {
							echo "<option style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=".$id_bo_nav." ".$Selected.">".$Indentation.$Numerotation.$nom."</option>\n";
						}else{
							echo "<option style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=\""._CONST_APPLI_PATH.$url_page."\" ".$Selected.">".$Indentation.$Numerotation.$nom."&nbsp;&nbsp;&nbsp;</option>\n";
						}
					}else{
						if ($Mode==0) {
							echo "<optgroup style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=".$id_bo_nav." ".$Selected." label=\"".$Indentation.$Numerotation.$nom."\">\n";
						}else{
							echo "<optgroup style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=\""._CONST_APPLI_PATH.$url_page."\" ".$Selected." label=\"".$Indentation.$Numerotation.$nom."&nbsp;&nbsp;\">\n";
						}
					}

				}elseif ($Mode==2) {
					echo "<option style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=\"id_bo_nav=".$id_bo_nav."\" ".$Selected.">".$Indentation.$Numerotation.$nom."</option>\n";
	
				}elseif ($Mode==3) {
					if ($idItem==$id_bo_nav){
						$color = get_reverse_color($MenuBgColor);
						$nom = "<!-- <span class=navActiveState>&gt;</span> -->".$nom."<!-- <span class=navActiveState>&lt;</span> -->";
					}else{
						$color = $BgColor;
					}
		
			                //Expand and Collapse
					$strsqlfils = "Select count(*) as nbe from "._CONST_BO_CODE_NAME."nav where id_"._CONST_BO_CODE_NAME."nav_pere = ".intval($id_bo_nav);
					$RS_nbe = mysql_query($strsqlfils);
					$nb_fils = mysql_result($RS_nbe,0,"nbe");
		
				         // on determine si le niveau courant a au moins 1 fils autorisé pour le user connecté
				         // cela permet de determiner si il faut dérouler l'arbo ou pas	      
			      
			                unset($has_a_fils_allowed);	         
				        $has_a_fils_allowed = 0;
			         	         	         
				        $childID = Array();
				        $array_fils = Array();
			         
				        reset($childID);
				        reset($array_fils);
			         
				        unset($GLOBALS['array_fils']);
			                  	         
				        $childID = get_bo_item_fils($id_bo_nav);        	         	 
				 		 		 
		  		        for ($r=0; $r < count($childID) ;$r++) {
						if (in_array($childID[$r],$arr_user_nav_right) ) {
							$has_a_fils_allowed=1;
						}
					}
	
					unset($childID);
					unset($GLOBALS['array_fils']);
			                         
					if ( ($Level < 0 || in_array($id_bo_nav, $navID)) || ($_REQUEST['Home']==1) ||( ($_REQUEST['viewTask']==1) && (($allow == 1) || ($has_a_fils_allowed ==1)) ) ) {
						$table_style = "style='display:block'";
		
						if ($nb_fils>0) {
				                        $img_collapse = "<img id='img_nav_".intval($nb_table+1)."_".intval($Level+1)."' vspace=3 hspace=3 style='cursor:pointer' src='images/moins.gif' border='0' onclick=\"switch_img(this);show_item('table_".intval($nb_table+1)."_".intval($Level+1)."');\">";
						}else {
							$img_collapse = "";
						}
			                }else {
						$table_style = "style='display:none'";
		
						if ($nb_fils>0) {
							$img_collapse = "<img id='img_nav_".intval($nb_table+1)."_".intval($Level+1)."' vspace=3 hspace=3 style='cursor:pointer' src='images/plus.gif' border='0' onclick=\"switch_img(this);show_item('table_".intval($nb_table+1)."_".intval($Level+1)."');\">";
				                }else {
							$img_collapse = "";
			                	}
					}
		
					if ($allow == 1)
					{
						// Patch DRO : Affichage des type de nav
						if ( $Level == 1 )
						{
							if ( $i > 1 )
								$old_type_nav = @mysql_result ( $RstMessageFils, $i-2, "_type_nav.libelle" );
							else
								$old_type_nav = "";
							
							$type_nav = @mysql_result ( $RstMessageFils, $i-1, "_type_nav.libelle" );
							

							if ( $type_nav != $old_type_nav )
								echo ( "<tr><td colspan=\"3\" class=\"type_nav\">".coupe_espace( $type_nav, 60 )."</td></tr>\n" );
						}	

						echo "<tr><td style=\"color:black\" bgcolor=\"".$color."\" align=center valign=top >".$img_collapse."</td><td  style=\"color:black\" bgcolor=\"".$color."\" align=left valign=top >".$Numerotation."</td><td style=\"color:black\" bgcolor=\"".$color."\" width='100%'>"."&nbsp;".$Indentation.""."<a href=\"bo.php?TableDef=3&idItem=".$id_bo_nav."\" class=\"".$txt_color_lien."\">".str_replace("&nbsp;","",$nom)."</a></td></tr>\n";
					}else{
						echo "<tr><td style=\"color:#6E6E6E\" bgcolor=\"".$color."\" align=center valign=top >".$img_collapse."</td><td  style=\"color:#6E6E6E\" bgcolor=\"".$color."\" align=left valign=top >".$Numerotation."</td><td style=\"color:#6E6E6E\" bgcolor=\"".$color."\" width='100%'>"."&nbsp;".$Indentation.str_replace("&nbsp;","",$nom)."</td></tr>\n";
					}
				}else{
					echo "<tr><td style=\"".$FontColorStyle."\" bgcolor=\"".$BgColor."\" nowrap>".$Indentation.$Numerotation.$nom."</td></tr>\n";
				}
	
				get_arbo($id_bo_nav, $Ind, $Level, $id_item, get_inter_color($BgColor,0.6), $Mode, $ShowInd, $ShowNum, $FilterNum, $sql_filter, $with_user_rights);
			}
		}

	        if ($Mode==3) {
			echo "</table>\n\n</td></tr>";
	        }
	}

	echo $traitement_fin;
}


//Retourne la taille d'un repertoire avec ses sous repertoire
function get_dir_size($dir) {
	$dir_size = exec("du -ksh ".$dir);
	$dir_size = split("\t",$dir_size);
	return $dir_size[0];
}


//Retourne l'affichage s'une requete SQL
function get_sql_format($StrSQL) {

	$tab = "\n&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";

	$style = "
	<style>
		.sql, .sqlclause, .sqloperator {
			font-size: 11px;
			font-family: \"Courier New\";
		}

		.sql {
			color : #FF00FF;
			font-weight: normal;
			background-color:#F2F2F2;
		}
		.sqlclause {
			color : red;
			font-weight: bold;
		}
		.sqloperator {
			color : blue;
			font-weight: normal;
		}
	</style>
	";

	//Operateurs
	//$StrSQL = ereg_replace("([=!<>.,%*])+","<span class='sqloperator'>\\1</span>",$StrSQL);

	//$StrSQL = eregi_replace("'","<span class=\"sqloperator\">'</span>",$StrSQL);
	$StrSQL = ereg_replace("=","<span class=\"sqloperator\">=</span>",$StrSQL);
	$StrSQL = ereg_replace("!","<span class=\"sqloperator\">!</span>",$StrSQL);
	//$StrSQL = eregi_replace("\"","<span class=\"sqloperator\">&quot;</span>",$StrSQL);
//	$StrSQL = ereg_replace("\<","<span class=\"sqloperator\">&lt;</span>",$StrSQL);
//	$StrSQL = ereg_replace("\>","<span class=\"sqloperator\">&gt;</span>",$StrSQL);
	$StrSQL = ereg_replace("\.","<span class=\"sqloperator\">.</span>",$StrSQL);
	$StrSQL = eregi_replace(",","<span class=\"sqloperator\">,</span><BR>".$tab,$StrSQL);
	$StrSQL = eregi_replace("%","<span class=\"sqloperator\">%</span>",$StrSQL);
	$StrSQL = eregi_replace("\*","<span class=\"sqloperator\">*</span>",$StrSQL);

	$StrSQL = eregi_replace("\(","<span class=\"sqloperator\">(</span>",$StrSQL);
	$StrSQL = eregi_replace("\)","<span class=\"sqloperator\">)</span>",$StrSQL);
	$StrSQL = eregi_replace("\+","<span class=\"sqloperator\">+</span>",$StrSQL);
	$StrSQL = eregi_replace("\-","<span class=\"sqloperator\">-</span>",$StrSQL);

	$StrSQL = ereg_replace("NOW","<span class=\"sqloperator\">NOW</span>",$StrSQL);


	//Numerique
	$StrSQL = eregi_replace("([0-9]+)","<span class=\"sqloperator\">\\1</span>",$StrSQL);


	//Clauses sql
	$StrSQL = eregi_replace("^Select","&nbsp;<span class=\"sqlclause\">SELECT</span> <br>".$tab,trim($StrSQL));
	$StrSQL = eregi_replace("Update ","&nbsp;<span class=\"sqlclause\">UPDATE</span> <br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("Show fields","&nbsp;<span class=\"sqlclause\">SHOW FIELDS</span> <br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("Delete ","&nbsp;<span class=\"sqlclause\">DELETE</span> <br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("from ","<BR>&nbsp;<span class=\"sqlclause\">FROM</span> <br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("set ","<br>&nbsp;<span class=\"sqlclause\">SET</span> <br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("where( |[(])","<BR>&nbsp;<span class=\"sqlclause\">WHERE</span>\\1 <br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("group by","<BR>&nbsp;<span class=\"sqlclause\">GROUP BY</span> <br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("insert into","<BR>&nbsp;<span class=\"sqlclause\">INSERT INTO </span><br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("VALUES","<BR>&nbsp;<span class=\"sqlclause\">VALUES</span> <br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("order by","<BR>&nbsp;<span class=\"sqlclause\">ORDER BY</span><br>".$tab,$StrSQL);

	$StrSQL = eregi_replace("left join","<BR>&nbsp;<span class=\"sqlclause\">LEFT JOIN</span><br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("right join","<BR>&nbsp;<span class=\"sqlclause\">RIGHT JOIN</span><br>".$tab,$StrSQL);
	$StrSQL = eregi_replace(" on ","<BR>".$tab."<span class=\"sqlclause\"> ON </span>",$StrSQL);

	//$StrSQL = eregi_replace("or( |[(])","<BR>".$tab."<span class=\"sqlclause\">OR</span>\\1",$StrSQL);
	//$StrSQL = eregi_replace("and( |[(])","<BR>".$tab."<span class=\"sqlclause\">AND</span>\\1",$StrSQL);
	$StrSQL = eregi_replace("or( |[(])","<BR>&nbsp;<span class=\"sqloperator\">OR</span>\\1 <br>".$tab,$StrSQL);
	$StrSQL = eregi_replace("and( |[(])","<BR>&nbsp;<span class=\"sqloperator\">AND</span>\\1 <br>".$tab,$StrSQL);


	$StrSQL = eregi_replace(" as ","<span class=\"sqlclause\"> AS </span>",$StrSQL);

	$StrSQL = eregi_replace(" asc","<span class=\"sqlclause\"> ASC</span>",$StrSQL);
	$StrSQL = eregi_replace(" desc","<span class=\"sqlclause\"> DESC</span>",$StrSQL);
	//$StrSQL = eregi_replace(" asc(,|$)","<span class=\"sqlclause\"> ASC</span>\\1",$StrSQL);
	//$StrSQL = eregi_replace(" desc(,|$)","<span class=\"sqlclause\"> DESC</span>\\1",$StrSQL);


	$StrSQL = eregi_replace(" like( |[(])","<span class=\"sqlclause\"> LIKE</span>\\1",$StrSQL);
	$StrSQL = eregi_replace(" in( |[(])","<span class=\"sqlclause\"> IN</span>\\1",$StrSQL);
	$StrSQL = eregi_replace(" not( |[(])","<span class=\"sqlclause\"> NOT</span>\\1",$StrSQL);


	//Cas particuliers
	$StrSQL = eregi_replace("&nbsp; ","&nbsp;",$StrSQL);

	$StrSQL = $style."<span class=\"sql\">".$StrSQL."</span>";

	return $StrSQL;
}

//Fait un dump d'une requete en xml
//Attention : utilise la bibliothèque sql2xml de PEAR
function make_xml_file($Host, $BaseName, $UserName, $UserPass, $strsql, $item) {

	$str_connect = "mysql://".$UserName.":".$UserPass."@".$Host."/".$BaseName;
	
	require "/usr/local/lib/php/XML/sql2xml.php";
	$sql2xmlclass = new xml_sql2xml($str_connect);
	$xmlstring = $sql2xmlclass->getxml($strsql);

	$Path = "dump/xml/";
	$File = "xml_".$item."_".date("ymd_His").".xml";
	
    archive($Path.$File,$xmlstring);
    telecharge($Path.$File);
}
//Fait un dump d'une requete en csv
function make_csv_file($strsql, $item, $delimiter=";") {

    $result = mysql_query($strsql);
    
    $out="";
    $change = array("\n", "\r"); // caractères interdits dans les CSV à retirer			

    while ($row=mysql_fetch_assoc($result)) 
    {					
      $tab_keys = array_keys($row);
	        
      $entete = "";
	              	   
      // enlève les caractères spéciaux HTML (&eacute;...) et surtout les sauts de ligne pour format CSV
      for ($e=0;$e<count(array_keys($row));$e++)	
      {		   			      
         $entete .= str_replace($change,"",unhtmlentities($tab_keys[$e])).$delimiter;
	 $out .= str_replace($change,"",unhtmlentities($row[$tab_keys[$e]])).$delimiter;
      }
      $entete .= "\n";			   
      $out .= "\n";
      unset($tab_keys);
    }
    $Path = "dump/csv/";
	$File = "csv_".$item."_".date("ymd_His").".csv";
    // ecrit le fichier généré sur le disque
    archive($Path.$File,$entete.$out);
    
    // et force le download en HTTP
    telecharge($Path.$File);
}

//Fait un dump de la base
function make_dump($Host, $BaseName, $UserName, $UserPass, $DownLoad=0) {

	$Path = "dump/sql/base/";
	$File = "dump_".$BaseName."_".date("ymd_His").".sql";

	//$Str = "mysqldump --add-drop-table ".$BaseName." -u ".$UserName." -p".$UserPass." -h ".$Host." > ".$Path.$File;
    $Str = "mysqldump --add-drop-table ".$BaseName." -u ".$UserName." -p".$UserPass." -h ".$Host;
	//exec($Str);
    exec($Str,$contenu);            
    $out = join ("\n", $contenu);
    
    archive($Path.$File,$out);
	if ($DownLoad==1) {
		telecharge($Path.$File);
	}
//	echo $Str;
}
//Vide une table
function make_empty_table($table) {

	$str_sql = "DELETE FROM ".$table;
	//echo $str_sql;
	mysql_query($str_sql);
}

//Ecrit $contenu dans $file et supprime le(s) fichier(s) selon le nombre d'archives à garder : _CONST_ARCHIV_LIMIT
function archive($file,$contenu){
    $fp = fopen($file, "w");
  	if (!$fp){
  		die ("Erreur ecriture du fichier $file");
  	}
  	$r = fwrite($fp, $contenu);
  	fclose($fp);
    
    $dir = dirname($file)."/";
    $handle = opendir($dir);
    while($f = readdir($handle)){
        if ( $f == "" || $f == "." || $f == ".." ) continue;
        if (!is_dir($dir.$f)){
            $tab_date[$dir.$f] = filemtime($dir.$f);
        }
    }
    $nbfic = count($tab_date);
    if ($nbfic>_CONST_ARCHIV_LIMIT){
        asort($tab_date);
        reset($tab_date);
        $nbfic_to_delete = $nbfic-_CONST_ARCHIV_LIMIT;
        for($i=0;$i<$nbfic_to_delete;$i++) {
            $key = key($tab_date);
            unlink($key);
            next($tab_date);
        }

    }
}
//Appelle la page forçant le téléchargement du fichier $source
function telecharge($source){
    echo "<script>";
    echo "location.href='telecharge.php?src=".$source."';";
    echo "</script>";
}
//Supprime tout les element de la base de données qui n'appartienne pas au site
function DeleteData($Host, $BaseName, $UserName, $UserPass) {

	//On fait un dump de la base avant de faire des suppression de table
	make_dump($Host, $BaseName, $UserName, $UserPass);

	$RstTable = mysql_list_tables($BaseName);
	//Liste des tables
	for ($i=0 ; $i < @mysql_num_rows($RstTable) ; $i++) {
		//Toutes les autres tables du sites
		if (!eregi("^"._CONST_BO_CODE_NAME, @mysql_tablename($RstTable, $i))) {
			mysql_query("Drop Table ".@mysql_tablename($RstTable, $i));
		}
	}

	mysql_query("Delete from "._CONST_BO_CODE_NAME."table_def where "._CONST_BO_CODE_NAME."item=0");
	mysql_query("Delete from "._CONST_BO_CODE_NAME."menu where id_"._CONST_BO_CODE_NAME."menu>9");
	mysql_query("Delete from "._CONST_BO_CODE_NAME."nav where id_"._CONST_BO_CODE_NAME."nav>1");
	mysql_query("Delete from "._CONST_BO_CODE_NAME."newsletter;\n");
	mysql_query("Delete from "._CONST_BO_CODE_NAME."profil where id_"._CONST_BO_CODE_NAME."profil>1");
	mysql_query("Delete from "._CONST_BO_CODE_NAME."user where id_"._CONST_BO_CODE_NAME."user>1");
	mysql_query("Delete from "._CONST_BO_CODE_NAME."stat");
	mysql_query("Delete from "._CONST_BO_CODE_NAME."dic_data where type!=0");
	mysql_query("Delete from "._CONST_BO_CODE_NAME."object");

	redirect("bo.php");
}

function  get_nb_use_session($KeyWord=";", $View=0, $NbSeconde=3600) {


	$NbTime=0;

	if ($dir = @opendir(session_save_path())) {

		while($file = readdir($dir)) {

			if (!is_dir($file) && eregi("sess",$file)) {

				$MonFichier = session_save_path()."/".$file;

				if (filemtime($MonFichier)+$NbSeconde>time()) {
					$Curfile = fopen($MonFichier,"r");

					while (!feof($Curfile)) {//Tant que non fin de fichier
						$ligne = fgets($Curfile, 4096);//Lecture du fichier ligne par ligne

						if (@ereg($KeyWord, $ligne) && !@ereg($KeyWord."\|N;", $ligne)) {
							$NbTime++;
						}

						if ($View==1) {
							echo @ereg_replace($KeyWord, "<b>".$KeyWord."</b>", $ligne)."\n<br>";

						}

						//"<b>".$KeyWord."</b>"
					}
					fclose($Curfile);
				}
			}
		}
		closedir($dir);
		return($NbTime);
	}
}


//Fonction permettant d'inserer dans la table BoStat toutes les requetes effectuees sur le back office
function StatsBo($id_bo_user,$HTTP_USER_AGENT,$TableDef,$QUERY_STRING,$PHP_SELF,$interface="Back-Office") {
		if (empty($TableDef)) {
			$TableDef = 0;
		}
		if (empty($_SESSION['ses_id_bo_user'])) {
			$_SESSION['ses_id_bo_user'] = 0;
		}

		$surftool	= $_SERVER['HTTP_USER_AGENT'];
//		$domain 	= gethostbyaddr(getenv("REMOTE_ADDR"));

		$os = os($_SERVER['HTTP_USER_AGENT']);
		$browser = browser($_SERVER['HTTP_USER_AGENT']);
//		$origin = country($domain);
//		$refer 	= explode("?", getenv("HTTP_REFERER"));
//		$refer	= $refer[0];


		$StrStats = "INSERT INTO "._CONST_BO_CODE_NAME."stat (session_id, interface, date, id_"._CONST_BO_CODE_NAME."user, user_agent, id_"._CONST_BO_CODE_NAME."table_def, query_string, file_name, os, ip, agent) VALUES (\"".session_id()."\", \"".$interface."\", NOW(), ".$_SESSION['ses_id_bo_user'].", \"".$_SERVER['HTTP_USER_AGENT']."\", ".$TableDef.", \"".$_SERVER['QUERY_STRING']."\",\"".NomFichier($_SERVER['PHP_SELF'],0)."\",\"".$os."\",\"".getenv("REMOTE_ADDR")."\",\"".$browser."\")";
	
	if (strcmp(_CONST_STAT_BO,"None")!=0 ) {		
		mysql_query($StrStats);		
        //echo get_sql_format($StrStats);
	}

}

//Fonction pour les statistiques
function browser($agent){
	if((ereg("Nav", $agent)) || (ereg("Gold", $agent)) || (ereg("X11", $agent)) || (ereg("Mozilla", $agent)) || (ereg("Netscape6", $agent)) AND (!ereg("MSIE", $agent))) $browser = "Netscape 6";
	elseif((ereg("Nav", $agent)) || (ereg("Gold", $agent)) || (ereg("X11", $agent)) || (ereg("Mozilla", $agent)) || (ereg("Netscape", $agent)) AND (!ereg("MSIE", $agent))) $browser = "Netscape 4 ";
	elseif(ereg("MSIE 6", $agent))		$browser = "Internet Explorer 6";
	elseif(ereg("MSIE 5.5", $agent))	$browser = "Internet Explorer 5.5";
	elseif(ereg("MSIE 5", $agent))		$browser = "Internet Explorer 5";
	elseif(ereg("MSIE 4", $agent))		$browser = "Internet Explorer 4";
	elseif(ereg("MSIE 3", $agent))		$browser = "Internet Explorer 3";
	elseif(ereg("MSIE 2", $agent))		$browser = "Internet Explorer 2";
	elseif(ereg("MSIE 1", $agent))		$browser = "Internet Explorer 1";
	elseif(ereg("Opera", $agent))		$browser = "Opera";
	elseif(ereg("Konqueror", $agent))	$browser = "Konqueror";
	else $browser = "Autres";

	return $browser;
}

function os($agent){
	if(ereg("Mac", $agent) || ereg("PPC", $agent)) $os = "Mac OS";
	elseif(ereg("Linux", $agent)) $os = "Linux";
	elseif(ereg("Windows NT 4", $agent))	$os = "Windows NT 4";
	elseif(ereg("Windows NT 5.1", $agent))	$os = "Windows XP";
	elseif(ereg("Windows NT 5", $agent))	$os = "Windows 2000";
	elseif(ereg("Windows 98", $agent))		$os = "Windows 98";
	elseif(ereg("Windows 95", $agent))		$os = "Windows 95";
	else $os = "Autres";

	return $os;
}

function country($dialhost){
	global $country;
	$thing 	= explode(".", $dialhost);
	$code 	= $thing[(count($thing)-1)];

	$destination = $country[$code];
	return $destination;
}

//Retourne le nombre de seconde
function getmicrotime(){
	list($usec, $sec) = explode(" ",microtime());
	return ((float)$usec + (float)$sec);
}

function my_filesize($file) {
    // First check if the file exists.
    if(!is_file("./".$file)) return("");
    // Setup some common file size measurements.
    $kb = 1024;         // Kilobyte
    $mb = 1024 * $kb;   // Megabyte
    $gb = 1024 * $mb;   // Gigabyte
    $tb = 1024 * $gb;   // Terabyte
    // Get the file size in bytes.
    $size = filesize($file);
    /* If it's less than a kb we just return the size, otherwise we keep
going until
    the size is in the appropriate measurement range. */
    if($size < $kb) {
        return $size." Octets";
    }
    else if($size < $mb) {
        return number_format($size/$kb,2,",","")." Ko";
    }
    else if($size < $gb) {
        return number_format($size/$mb,2,",","")." Mo";
    }
    else if($size < $tb) {
        return number_format($size/$gb,2,",","")." Go";
    }
    else {
        return number_format($size/$tb,2,",","")." To";
    }
}

//08/08/2002
function get_ext_file_picto($fichier) {
	//Tableau associatif des icones fichiers
	$ArrayIcones = array("xls"=>"icone_xls.gif", "pdf"=>"icone_pdf.gif", "ppt"=>"icone_ppt.gif", "doc"=>"icone_doc.gif", "exe"=>"icone_exe.gif", "html"=>"icone_htm.gif", "zip"=>"icone_zip.gif", "htm"=>"icone_htm.gif", ""=>"icone_fichier.gif","txt"=>"icone_fichier.gif","jpg"=>"icone_jpg2.gif","jpeg"=>"icone_jpg2.gif","png"=>"icone_jpg2.gif","gif"=>"icone_gif2.gif");

	$Extension = split("\.",$fichier);
	$Extension = strtolower($Extension[count($Extension)-1]);

	$IconeFichier = $ArrayIcones[$Extension];

	if (empty($IconeFichier)) {
		$IconeFichier = "icone_no_ext_pt.gif";
	}

	return ($IconeFichier);
}

// 29/10/2002
// retourne le numero à suffixer a un champ table annexe etrangere ajoutee dans une table
function get_suffix_table_annexe($table_name, $search_field) {

	$StrSQL = "select * from ".$table_name;
	$Rst = mysql_query($StrSQL);

	$cpt = 0;
	for ($j=0; $j<@mysql_num_fields($Rst) ; $j++) {
		$field_name = @mysql_field_name($Rst, $j);

		if (eregi($search_field, $field_name))
			{ $cpt++; }
	}

	if ($cpt==0) {
		return "";
	}
	else {
		return "_".$cpt;
	}

}

//29/10/2002
//retourne le nom de la table annexe sans sont suffixe
function get_table_annexe_name($name) {
		$arr = @split("_",$name);

		if ($arr[count($arr)-1]>0) {
			array_pop($arr);
		}
		$arr = @join("_",$arr);

		return $arr;
}

//29/10/2002
//retourne le suffixe du nom de la table annexe
function get_table_annexe_suffix($name) {
		$arr = @split("_",$name);

		return $arr[count($arr)-1];
}

//FONCTION PERMETTANT DE SAVOIR DANS QUEL MEDIA UNE TABLE ANNEXE EST UTILISE
//DATE : 25/10/2002
//Cette fonction est utilisee dans le BO pour l'affichage des couleurs des tables annexes dans le menu tables annexes
function get_info_from_table_annexe($base_name, $search_field, $color1="white", $color2="black") {

	$RstTable = mysql_list_tables($base_name);

	for ($i=0 ; $i < @mysql_num_rows($RstTable); $i++) {
		$StrSQL = "select * from ".@mysql_tablename($RstTable, $i);

		$nb_fois = 0;

		//if (eregi("^"._CONST_BO_CODE_NAME."",@mysql_tablename($RstTable, $i))) {
			$Rst = mysql_query($StrSQL);

			for ($j=0; $j<@mysql_num_fields($Rst) ; $j++) {

				$field_name =	@mysql_field_name($Rst, $j);
				$field_type =	@mysql_field_type($Rst, $j);
				$field_len  =	@mysql_field_len($Rst, $j);
				$table_name =	@mysql_field_table($Rst, $j);

				if ($table_name!=$search_field && eregi("^id_".$search_field,$field_name) && $nb_fois==0) {
					$table_name_in_use[] =  $table_name;
					$nb_fois++;
				}

			}
		//}
	}

	if (count($table_name_in_use)>0) {
		if (count($table_name_in_use)>1) {
			$ar_return[] = $color1;
			$ar_return[] = join(",&nbsp;",$table_name_in_use);

			return $ar_return;

		}
		else {
			$ar_return[] = $color2;//@mysql_result(mysql_query("select couleur_lien from type_media where nom_table=\"".$table_name_in_use[0]."\""),0,0);
			$ar_return[] = $table_name_in_use[0];

			return $ar_return;
		}
	}
	else {
		$ar_return[] = "";
		$ar_return[] = $bo_lib_tools_not_used;
		return $ar_return;
	}


}


function password_generator($size=8 , $with_numbers=true , $with_tiny_letters=true , $with_capital_letters=true){
 $pass_g = "";
  $sizeof_lchar = 0;
  $letter = "";
  $letter_tiny = "abcdefghijklmnopqrstuvwxyz";
  $letter_capital = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
  $letter_number = "0123456789";

  if($with_tiny_letters == true){
  $sizeof_lchar += 26;
  if (isset($letter)) $letter .= $letter_tiny;
  else $letter = $letter_tiny;
  }

  if($with_capital_letters == true){
  $sizeof_lchar += 26;
  if (isset($letter)) $letter .= $letter_capital;
  else $letter = $letter_capital;
  }

  if($with_numbers == true){
  $sizeof_lchar += 10;
  if (isset($letter)) $letter .= $letter_number;
  else $letter = $letter_number;
  }

  if($sizeof_lchar > 0){
  srand((double)microtime()*date("YmdGis"));

  for($cnt = 0; $cnt < $size; $cnt++){
  $char_select = rand(0, $sizeof_lchar - 1);
  $pass_g .= $letter[$char_select];
  }
  }
  return $pass_g;

}

//SDE 2003-02-17

function get_value_for_script($script){
    preg_match_all("/".Template_left_delimiter."([^".Template_right_delimiter."]+)".Template_right_delimiter."/",$script,$res);
    for ($i=0;$i<count($res[0]);$i++){
       global $$res[1][$i];
       $script = str_replace(Template_left_delimiter.$res[1][$i].Template_right_delimiter,$$res[1][$i],$script);       
    }
    return $script;
}

function get_uid() {
    return md5(uniqid (rand()));
}

// *** fonction simple de parcours de repertoire
function list_dir($chdir,$id_item_parent1,$mon_dir="")
{
	  global $id_item,$mon_path,$rep;

	  $var_retour = "";        
	  unset($sdirs);
	  unset($sfiles);
	  chdir($chdir);
        
	  $self = basename($_SERVER['PHP_SELF']);
	  $handle = opendir('.');
	  while ($file = readdir($handle))
	  {
         //echo($file."<br>");
	   	if(is_dir($file) && $file != "." && $file != "..")
	  	{ $sdirs[] = $file; }
		elseif (is_file($file))
		{ $sfiles[] = $file; }
	  }
	  
	  $dir = getcwd();
	  $dir1 = str_replace($root, "", $dir);
	  $count = substr_count($dir1, "/") + substr_count($dir1, "\\");
        
	  if(is_array($sdirs))
	  {
		 sort($sdirs);
	  	 reset($sdirs);
		 
	  	 for($y=0; $y<sizeof($sdirs); $y++)
	  	 {
			  $id_item++;
			  // on n'affiche pas les répertoires
			  //echo htmlentities($sdirs[$y]);
        
			  $cwd1[0] = $dir;
	  		  $cwd1[1] = $sdirs[$y];
			  $chdir = join("/", $cwd1);
			  
			  $var_retour = $var_retour.list_dir($chdir,$id_item,$chdir);
		 }
	  }
	 		  
	  chdir($chdir);
	  
	  if(is_array($sfiles))
	  {
	   	 sort($sfiles);
	 	 reset($sfiles);
		 
		 $sizeof = sizeof($sfiles);
		 
		 for($y=0; $y<$sizeof; $y++)
		 {
			 $id_item++;
			  if ($mon_dir) {
				  $nom_path = str_replace($mon_path,"",$mon_dir)."/";
			  }
			  else {
				 $nom_path = $rep;
			  }

			$var_retour = $var_retour."<option value=\"".$sfiles[$y]."\">".$sfiles[$y]."</option>"; 
		 }
	  }

	  return $var_retour;
}

// *** Retourne le libelle de l'item dans la bonne langue
function get_libLangue($chaine) {
	global ${$chaine."_".$_SESSION['ses_langue']};

	return ${$chaine."_".$_SESSION['ses_langue']};
}


// Fonction qui renvoie true si on detecte que nous sommes sur Windows XP SP2
// permet de selectionne le type d'editeur textrich
function isWindowsXPSP2()
{
   if ( eregi("Windows NT 5.1", $_SERVER['HTTP_USER_AGENT']) && eregi("SV1", $_SERVER['HTTP_USER_AGENT']) )
   {
  	return true;
   }
   else
   {
  	return false;
   }
}

// Détection windows + IE : renvoie true si détécté
function isWIE()
{
   if ( ereg("MSIE", $_SERVER['HTTP_USER_AGENT']) && ereg("Windows", $_SERVER['HTTP_USER_AGENT']) )
   {
  	return true;
   }
   else
   {
  	return false;
   }
}   	


//Retourne l'arbo du site en mode clic pour eviter surcharge
function get_arbo_light($id_pere, $Indic, $Level, $id_item, $BgColor, $Mode=0, $ShowInd=0, $ShowNum=0, $FilterNum="", $sql_filter="", $with_user_rights=1) {
	global $nb, $txt_color_lien, $nb_table;
	global $idItem, $table_style, $navID;
	global $ses_profil_user, $arr_user_nav_right;
      
	$nb++;

	if ($id_pere!=1) {
		$chaine = "select _nav, id__nav_pere  from _nav where id__nav=".$id_pere;
		$RS = mysql_query($chaine);

		$id__nav_pere = mysql_result($RS,0,"id__nav_pere");
		echo("<tr><td colspan=2 width='100%'><b>&nbsp;&nbsp;>>&nbsp".mysql_result($RS,0,"_nav")."</b><br></td></tr>");
	}

	$StrSQLFils = "Select * from "._CONST_BO_CODE_NAME."nav where id_"._CONST_BO_CODE_NAME."nav_pere = ".$id_pere;
	$StrSQLFils .= $sql_filter;
	
	$hsv = get_hsv_color($BgColor);
	$txt_color_lien = "LienNoir";
	$FontColorStyle = "color=black";

	$StrSQLFils .= " order by ordre, id_"._CONST_BO_CODE_NAME."nav";


//	*** => Execution de la requete
	$RstMessageFils = mysql_query($StrSQLFils);

	if (mysql_num_rows($RstMessageFils)) {
		$Level++; //On compte les niveau

		if ($Mode==3) {                
			$nb_table++;
			echo "<tr><td colspan=2 width='100%'>\n\n<table id='table_".$nb_table."_".$Level."' ".$table_style." border=0 cellpadding=0 cellspacing=1 bgcolor=\"".get_inter_color($BgColor,0.5)."\"  width='100%'>";
	        }
	
		for ($i=1;$i<=@mysql_num_rows($RstMessageFils);$i++) {
			$id_bo_nav = mysql_result($RstMessageFils,$i-1,"id_"._CONST_BO_CODE_NAME."nav");
			$nom = $ArrayPuce[$Level]."&nbsp;";
	           	
			// affichage des menus non selectionné comme affiché pour l'admin
			$cache=0;
			if ((mysql_result($RstMessageFils,$i-1,""._CONST_BO_CODE_NAME."nav.selected"))==0) {
				$cache=1;
				if ($Mode!=0) {
					$nom.="<i><u>";
				}
			}
	           	
			$nom.=(coupe_espace(@mysql_result($RstMessageFils,$i-1,""._CONST_BO_CODE_NAME."nav"),60));
				
			if (((mysql_result($RstMessageFils,$i-1,""._CONST_BO_CODE_NAME."nav.selected"))==0)&&($Mode!=0)) {
				$nom.="</u></i>&nbsp;&nbsp;<img src='images/pasvu.gif' width=17 height=14 border=0 valign=baseline alt='Non visible'>";
				$cache=1;
			}
	           
			if (is_array($id_item) && in_array($id_bo_nav,$id_item)) {
				$Selected = "Selected";
			}elseif ($id_bo_nav == $id_item) {
				$Selected = "Selected";
			}else {
				$Selected = "";
			}
	
			$Ind=$Indic.$i.".";
	
			//Affichage ou non de l'indentation
			if ($ShowInd == 1) {
				$Indentation = str_repeat("&nbsp;&nbsp;",($Level));
			}
	
			//Affichage ou non de la numerotation
			if ($ShowNum == 1) {
		                $Numerotation = $Ind;
			}
	
			if (is_array($arr_user_nav_right) && in_array($id_bo_nav,$arr_user_nav_right)) {
				$allow = 1;
			}elseif ($id_bo_nav == $id_item) {
		                $allow = 1;
			}else {
				$allow = 0;
			}
	
			if (($_SESSION['ses_profil_user']<=2) || ($Mode == 0)) {
				$allow = 1;
				$cache=0;
			}
	
			if (!$cache) { 
				// ajout du flag with_user_rights
				if (($Mode==0)||($Mode==4)) {
			                if (($allow == 1)||($with_user_rights == 0)) {
						if ($Mode==0) {
							echo "<option style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=".$id_bo_nav." ".$Selected.">".$Indentation.$Numerotation.$nom."</option>\n";
						}else{
							echo "<option style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=\"".$url_page."?Rub=".$id_bo_nav."\" ".$Selected.">".$Indentation.$Numerotation.$nom."</option>\n";
						}
					}else{
						if ($Mode==0) {
							echo "<optgroup style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=".$id_bo_nav." ".$Selected." label=\"".$Indentation.$Numerotation.$nom."\">\n";
						}else{
							echo "<optgroup style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=\"".$url_page."?Rub=".$id_bo_nav."\" ".$Selected." label=\"".$Indentation.$Numerotation.$nom."\">\n";
						}
					}

				}elseif ($Mode==2) {
					echo "<option style=\"".$FontColorStyle.";background-color:".$BgColor."\" value=\"id_bo_nav=".$id_bo_nav."\" ".$Selected.">".$Indentation.$Numerotation.$nom."</option>\n";
	
				}elseif ($Mode==3) {
					if ($idItem==$id_bo_nav){
						$color = get_reverse_color($MenuBgColor);
						$nom = "<!-- <span class=navActiveState>&gt;</span> -->".$nom."<!-- <span class=navActiveState>&lt;</span> -->";
					}else{
						$color = $BgColor;
					}
		
			                //Expand and Collapse
					$strsqlfils = "Select count(*) as nbe from "._CONST_BO_CODE_NAME."nav where id_"._CONST_BO_CODE_NAME."nav_pere = ".intval($id_bo_nav);
					$RS_nbe = mysql_query($strsqlfils);
					$nb_fils = mysql_result($RS_nbe,0,"nbe");
		
      
					if ($nb_fils>0) {
			                        $img_collapse = "<a href='javascript:getArboFils(".$id_bo_nav.");'><img id='img_nav_".intval($nb_table+1)."_".intval($Level+1)."' vspace=3 hspace=3 style='cursor:pointer' src='images/plus.gif' border='0'></a>";
					}else {
						$img_collapse = "";
					}
		
					if ($allow == 1) {
						echo "<tr><td style=\"color:black\" bgcolor=\"".$color."\" align=center valign=top >".$img_collapse."</td><td  style=\"color:black\" bgcolor=\"".$color."\" align=left valign=top >".$Numerotation."</td><td style=\"color:black\" bgcolor=\"".$color."\" width='100%'>"."&nbsp;".$Indentation.""."<a href=\"bo.php?TableDef=3&idItem=".$id_bo_nav."&idFils=".$id_pere."\" class=\"".$txt_color_lien."\">".str_replace("&nbsp;","",$nom)."</a></td></tr>\n";
					}else{
						echo "<tr><td style=\"color:#6E6E6E\" bgcolor=\"".$color."\" align=center valign=top >".$img_collapse."</td><td  style=\"color:#6E6E6E\" bgcolor=\"".$color."\" align=left valign=top >".$Numerotation."</td><td style=\"color:#6E6E6E\" bgcolor=\"".$color."\" width='100%'>"."&nbsp;".$Indentation.str_replace("&nbsp;","",$nom)."</td></tr>\n";
					}
				}else{
					echo "<tr><td style=\"".$FontColorStyle."\" bgcolor=\"".$BgColor."\" nowrap>".$Indentation.$Numerotation.$nom."</td></tr>\n";
				}
	
			}
		}

	        if ($Mode==3) {
			echo "</table>\n\n</td></tr>";
	        }
	}

	if ($id_pere!=1) {
		echo("<tr><td colspan=2 width='100%' align='right'><a href='javascript:navRetour(".$id__nav_pere.")'>Retour</a><br><br></td></tr>");
	}
	echo $traitement_fin;
}



if(! function_exists("file_put_contents_php4")){
      function file_put_contents_php4($filename,$data,$mode="a+")
      {
					if($fp=fopen($filename,$mode))
					fwrite($fp,$data);
					fclose($fp);
					return true;
      }
}

?>