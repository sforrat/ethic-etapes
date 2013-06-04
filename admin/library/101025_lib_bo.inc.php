<? 
// +--------------------------------------------------------------------------+
// | Back-Office - 10/12/2002                                                 |
// +--------------------------------------------------------------------------+
// | Copyright (c) 2002-2003 FullSud Team                                     |
// +--------------------------------------------------------------------------+
// | License:  Contact Fullsud : contact@fullsud.com                          |
// +--------------------------------------------------------------------------+
// | Library that sets fonction for Back-Office                               |
// |                                                                          |
// | usage:                                                                   |
// |                                                                          |
// | example:                                                                 |
// |                                                                          |
// | required: - PHP                                                          |
// |           - MySQL                                                        |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Author:   Yoann CULAS <yculas@fullsud.com>                               |
// +--------------------------------------------------------------------------+



// +--------------------------------------------------------------------------+
// |                                                                          |
// |         Fonction qui supprime tout les prefixes                          |
// |         et les suffixes propres au back office                          |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Parameters : String                                                      |
// +--------------------------------------------------------------------------+
// | Date : 10/12/2002                                                        |
// +--------------------------------------------------------------------------+
// | Date derni�re modif : 10/12/2002                                         |
// +--------------------------------------------------------------------------+

function bo_strip_pre_suf($str, $type="", $len="") {
	global $datatype_list_data, $mysql_datatype_text;

	$str = ereg_replace("^id_"._CONST_BO_TABLE_PREFIX,"",$str);
	$str = ereg_replace("^id_"._CONST_BO_TABLE_DATA_PREFIX,"",$str);
	$str = ereg_replace("^id_","",$str);

	if (($len==ereg_replace("(.*)\((.*)\)","\\2",$datatype_list_data)) && ($type==$mysql_datatype_text)) {
		$str = ereg_replace("(.*)_(.*)[0-9]$","\\1",$str);
	}
	else {
		$str = ereg_replace("_1","",$str);
	}


	$str = ereg_replace("^"._CONST_BO_CODE_NAME."","",$str);
	$str = ereg_replace(_CONST_BO_AUTO_SUFFIX."$","",$str);

	if (_CONST_BO_TABLE_DATA_PREFIX) {
		$str = ereg_replace(_CONST_BO_TABLE_DATA_PREFIX,"",$str);
	}
	if (_CONST_BO_TABLE_PREFIX) {
		$str = ereg_replace(_CONST_BO_TABLE_PREFIX,"",$str);
	}

	if (_CONST_BO_REQUIRE_SUFFIX) {
		$str = ereg_replace(_CONST_BO_REQUIRE_SUFFIX,"",$str);
	}

	$str = ereg_replace("_"," ",$str);

	// SPECIFIQUE INSA pour virer les gab en entete de content type=3
	$str = ereg_replace("gab ","",$str);

	$str = strtolower($str);

	$str = ucfirst($str);
	//$str = ucwords($str);

	return ($str);
}


// +--------------------------------------------------------------------------+
// |                                                                          |
// |         Fonction qui affiche les separateurs                             |
// |         entre les barres d'outils                                        |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Parameters : Aucun                                                       |
// +--------------------------------------------------------------------------+
// | Date : 17/02/2003                                                        |
// +--------------------------------------------------------------------------+
// | Date derni�re modif : 17/02/2003                                         |
// +--------------------------------------------------------------------------+
function get_bo_toolbar_separateur() {
	?>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
		<tr>
			<td><img alt="" src="images/icones/inter_toolbar.png" border="0" width="100%" height="2"></td>
		</tr>
	</table>		 	
	<?
}


// +--------------------------------------------------------------------------+
// |                                                                          |
// |         Fonction qui gere les traitements                                |
// |         relatifs aux evenements SQL                                      |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Parameters : String                                                      |
// +--------------------------------------------------------------------------+
// | Date : 17/02/2003                                                        |
// +--------------------------------------------------------------------------+
// | Date derni�re modif : 17/02/2003                                         |
// +--------------------------------------------------------------------------+
function bo_event($event_process,$debug_mode,$id,$event_name="") {
	//EVENEMENT
	if ($event_process) {
		echo "<br><hr>".$event_name." :<br>";
		$event_process = ereg_replace("[\$]","\$field_",$event_process);
		$event_process = ereg_replace("[�]","\$",$event_process);
		eval($event_process);
		if ($debug_mode == 1) {
			echo nl2br($event_process);
		}
		echo "<br><hr>";
	}
}


// +--------------------------------------------------------------------------+
// |                                                                          |
// |         Fonction qui affiche les Options des                             |
// |         listes d�roulantes                                               |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Parameters : Aucun                                                       |
// +--------------------------------------------------------------------------+
// | Date : 10/05/2003                                                        |
// +--------------------------------------------------------------------------+
// | Date derni�re modif : 23/05/2003                                         |
// +--------------------------------------------------------------------------+
function get_option_edit_table() {
	global $PoPupId,$CtForKey,$PHP_SELF,$TableDef,$id,$mode,$PopUp,$ItemListerTitle, $methode, $form_fieldname;
	//On affiche les option Creer/Lister
	//On recupere la valeur du tableau correspondant au x eme element de type clef etrangere
	$PopUp = $PoPupId[$CtForKey];

	//	if ($methode!="duplicate") {
	if ($PopUp) {
		echo "&nbsp;&nbsp;<a href=\"javascript:MM_openBrWindow('bo.php?TableDef=$PopUp&fieldRefered=".$form_fieldname."&Referer=".NomFichier($PHP_SELF,0)."&InitTableDef=$TableDef&mode=nouveau&RefererParam=id=$id&ModeReferer=$mode&DisplayMode=PopUp','PopUpUpdate','resizable=yes,scrollbars=yes,height=400,width=600')\"><img src='images/icones/img_new.gif' border='0' alt='Cr&eacute;er'></a>";
		echo "&nbsp;/&nbsp;<a href=\"javascript:MM_openBrWindow('bo.php?TableDef=$PopUp&fieldRefered=".$form_fieldname."&DisplayMode=PopUp','PopUpCreate','resizable=yes,scrollbars=yes,height=510,width=600')\"><img src='images/icones/icone_ed1.gif' border='0' alt='".$ItemListerTitle."'></a>";
	}
	$CtForKey++;
	//	}
}



//retourne le nom de la table
function get_bo_tablename($name) {

	$str_sql = "
                SELECT
                    libelle
                FROM
                    "._CONST_BO_CODE_NAME."dic_data
                WHERE
                    nom_table = \"".$name."\"
                ";

	$rst = mysql_query($str_sql);

	return(@mysql_result($rst,0,0));
}


// +--------------------------------------------------------------------------+
// | Date : 14/10/2003                                                        |
// +--------------------------------------------------------------------------+
// | Date derni�re modif : 14/10/2003                                         |
// +--------------------------------------------------------------------------+

function get_bo_portfolio($path = "", $path_img = "../images/upload/portfolio_img/") {

	global $fieldvalue, $form_fieldname, $StyleChamps, $portfolio_default_img;

	$return =  "
        <table border='0' cellpadding='0' cellspacing='0' width='80%'>
            <tr>
               <td colspan=\"2\" valign=\"top\" align=\"left\" nowrap><font size=-1><?=$bo_lib_bo_select_file_portfolio?>&nbsp;</font></td>
            </tr>
            <td>
            <td valign=\"top\">
    ";

	$return .= "
            <script>

                function JS_change_portfolio_preview(path, source, target) {                		
                    if (JS_get_portfolio_img_type(source.value) == \"img\") {
                        
                        document.getElementById(target).src = path + JS_get_portfolio_img_path(source.value);
                    }
                    else {
                        document.getElementById(target).src = path + '../../../admin/images/icones_explorer/' + JS_get_portfolio_img_path(source.value);
                    }
                }

            </script>
        ";

	$return .= "
    <select id=\"$form_fieldname\" name=\"".$form_fieldname."_port\" onChange=\"JS_change_portfolio_preview('".$path.$path_img."', this, 'img_portfolio_preview_".$form_fieldname."')\" class=\"".$StyleChamps." allSelectPortfolio\">
                            ";
	// Pleins de modif, _PROFIL_CENTRE
	if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
	{
		$str_portfolio_rub = "
                            SELECT 
                                    *
                            FROM
                                    portfolio_rub
                            WHERE
                            		id__user ='".$_SESSION["ses_user_id"]."'
                            ORDER BY
                                    portfolio_rub

    	";
	}
	else
	{
		$str_portfolio_rub = "
                            SELECT 
                                    *
                            FROM
                                    portfolio_rub
                            ORDER BY
                                    portfolio_rub

    	";
	}


	$rst_portfolio_rub = mysql_query($str_portfolio_rub);
	$return .= "<option value=\"\">Choisir une image</option>\n";
	for ($pfi=0; $pfi<@mysql_num_rows($rst_portfolio_rub) ; $pfi++) {

		$id_portfolio_rub = @mysql_result($rst_portfolio_rub,$pfi,0);
		$portfolio_rub    = @mysql_result($rst_portfolio_rub,$pfi,1);

		if ($pfi==0) {
			if($_SESSION["ses_profil_user"]==_PROFIL_CENTRE)
			{
				$return .= "<optgroup label=\"".$portfolio_rub."\">\n";
			}
			else
			{
				$return .= "<option value=\"\">".$portfolio_rub."</option>\n";
			}
		}
		else {
			$return .= "<optgroup label=\"".$portfolio_rub."\">\n";
		}

		$str_portfolio_img = "
                                SELECT 
                                        *
                                FROM
                                        portfolio_img
                                WHERE
                                        id_portfolio_rub = ".$id_portfolio_rub."
                                ORDER BY
                                        portfolio_img

        ";
		$rst_portfolio_img = mysql_query($str_portfolio_img);

		for ($pfj=0; $pfj<@mysql_num_rows($rst_portfolio_img) ; $pfj++) {

			$id_portfolio_img       = @mysql_result($rst_portfolio_img,$pfj,0);
			$portfolio_img          = @mysql_result($rst_portfolio_img,$pfj,1);
			$portfolio_img_name     = @mysql_result($rst_portfolio_img,$pfj,2);

			if ($id_portfolio_img == $fieldvalue) {
				$selected = "selected=\"selected\"";
				$portfolio_default_img = $path.$path_img.$portfolio_img_name;
			}
			else {
				$selected = "";
			}

			$return .= "<option value=\"".$id_portfolio_img."\" ".$selected.">".$portfolio_img."</option>\n";
		}
	}

	if ($fieldvalue=="") {
		$portfolio_default_img = $path."images/pixtrans.gif";
	}

	$return .= "
                </select>
                </td>
                <td valign=\"top\" align=\"left\">";    


	$return .= "               <img src=\"".$portfolio_default_img."\" width=\"100\" name=\"img_portfolio_preview_".$form_fieldname."\" id=\"img_portfolio_preview_".$form_fieldname."\">";



	$return .= "    		</td>
            </tr>
         </table>
    ";

	return $return;
}

// +--------------------------------------------------------------------------+
// | Date : 14/10/2003                                                        |
// +--------------------------------------------------------------------------+
// | Date derni�re modif : 14/10/2003                                         |
// +--------------------------------------------------------------------------+
function get_bo_langue() {

	//GESTION DE LA LANGUE
	if (
	(
	!isset($_SESSION['ses_langue'])
	||
	!isset($_SESSION['ses_langue_ext'])
	||
	!isset($_SESSION['ses_langue_ext_sql'])
	)
	) {

		//Gestion de la langue par defaut
		// on verifie les langues autorisées pour ce user
		$chaine = "SELECT * FROM _langue ";

		if ($_SESSION['ses_profil_user']!=1)
		{
			$chaine.= " WHERE id__langue in (".$_SESSION['ses_id_langue_user'].")";
		}

		$chaine .=" order by id__langue";
		$RS_langue = mysql_query($chaine);
		$nb_langue = mysql_num_rows($RS_langue);

		$trouvee=0;

		for ($i=0; $i< $nb_langue ; $i++)
		{
			// on regarde la langue par défaut du navigateur
			if (eregi(mysql_result($RS_langue,$i,"_langue_abrev"),getenv("HTTP_ACCEPT_LANGUAGE"))) {
				$_SESSION['ses_langue']             = mysql_result($RS_langue,$i,"id__langue");
				$_SESSION['ses_langue_ext']         = mysql_result($RS_langue,$i,"_langue_abrev");
				$_SESSION['ses_langue_ext_sql']     = (mysql_result($RS_langue,$i,"_langue_abrev")=="fr"?"":"_".mysql_result($RS_langue,$i,"_langue_abrev"));
				$trouvee = 1;
			}

			// sinon, on regarde si la langue par défaut est dans la liste des langurs autorisées pour cet internaute
			if (mysql_result($RS_langue,$i,"_langue_abrev") == 1) {
				$_SESSION['ses_langue']             = mysql_result($RS_langue,$i,"id__langue");
				$_SESSION['ses_langue_ext']         = mysql_result($RS_langue,$i,"_langue_abrev");
				$_SESSION['ses_langue_ext_sql']     = (mysql_result($RS_langue,$i,"_langue_abrev")=="fr"?"":"_".mysql_result($RS_langue,$i,"_langue_abrev"));
				$trouvee = 1;
			}
		}

		// aucune langue nav dans la liste des langues autorisées, et langue par défaut pas dans la liste de ce user
		// on lui affecte la premiere langue de sa liste...
		if (!$trouvee) {
			$_SESSION['ses_langue']             = mysql_result($RS_langue,0,"id__langue");
			$_SESSION['ses_langue_ext']         = mysql_result($RS_langue,0,"_langue_abrev");
			$_SESSION['ses_langue_ext_sql']     = (mysql_result($RS_langue,0,"_langue_abrev")=="fr"?"":"_".mysql_result($RS_langue,0,"_langue_abrev"));
		}
	}
	else {
		//Switch de langue
		if (isset($_REQUEST['L']) && ($_REQUEST['L'] != "") ) {
			if ($_REQUEST['L']==2) {
				$_SESSION['ses_langue']             = 2;
				$_SESSION['ses_langue_ext']         = "en";
				$_SESSION['ses_langue_ext_sql']     = "_en";
			}
			if ($_REQUEST['L']==1) {
				$_SESSION['ses_langue']             = 1;
				$_SESSION['ses_langue_ext']         = "fr";
				$_SESSION['ses_langue_ext_sql']     = "";
			}
			if ($_REQUEST['L']==3) {
				$_SESSION['ses_langue']             = 3;
				$_SESSION['ses_langue_ext']         = "es";
				$_SESSION['ses_langue_ext_sql']     = "_es";
			}
		}

		//echo "<br>-".$L."- -".$ses_langue_ext."- -".$ses_langue."- -".$ses_langue_ext_sql."-<br>";

	}



	//    return $return;

}


// +--------------------------------------------------------------------------+
// |                                                                          |
// |         RETOURNE LES PERES D'UN ELEMENT DU MENU                          |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Date : 14/03/2003                                                        |
// +--------------------------------------------------------------------------+

function get_bo_item_pere($item){
	global $array_pere;

	$StrSQL = "
            SELECT 
                _nav.id__nav_pere
            FROM 
                _nav 
            WHERE 
                _nav.id__nav = ".$item;

	if ($_SESSION['ses_profil_user']>2) // affichage de tous les items meme cach�s si admin
	{
		$StrSQL .= "
            AND 
                _nav.selected=1 
            ";
	}

	$StrSQL .= "
            ORDER BY 
                _nav.ordre,
                _nav.id__nav 
            ";

	//echo get_sql_format($StrSQL)."<br><br>";

	$Rst = mysql_query($StrSQL);

	$pere	= @mysql_result($Rst,0,0);

	//echo "--- <b>".$pere."</b> ---";
	$array_pere[] = $pere;

	if ($pere) {
		get_bo_item_pere($pere);
	}

	return $array_pere;
}

// +--------------------------------------------------------------------------+
// |                                                                          |
// |         RETOURNE LES PREMIER FILS D'UN ELEMENT DU MENU                   |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Date : 23/02/2004                                                        |
// +--------------------------------------------------------------------------+

function get_bo_item_fils($item){
	global $array_fils;

	$StrSQL = "
            SELECT 
                _nav.id__nav
            FROM 
                _nav 
            WHERE 
                _nav.id__nav_pere = ".$item." 
            AND 
                _nav.selected=1 
            ORDER BY 
                _nav.ordre,
                _nav.id__nav 
            ";

	//echo get_sql_format($StrSQL)."<br><br>";

	$Rst = mysql_query($StrSQL);

	for ($t=0;$t < mysql_num_rows($Rst);$t++)
	{

		$fils = @mysql_result($Rst,$t,0);

		//echo "--- <b>".$fils."</b> ---";
		if (is_numeric($fils)) {
			$array_fils[] = $fils;

			get_bo_item_fils($fils);
		}
	}
	return $array_fils;
}

// +--------------------------------------------------------------------------+
// |                                                                          |
// |     RETOURNE LE LISTING DES FICHIERS d'UN REPERTOIRE SUR LE SERVEUR      |
// |     sous la forme d'un select                                            |
// +--------------------------------------------------------------------------+
// | Date : 28/11/2003                                                        |
// +--------------------------------------------------------------------------+

function get_bo_Replist($mon_path) {
	global $fieldvalue, $form_fieldname, $StyleChamps;

	$portfolio_default_img="../images/px_trans.gif"; // image par d�faut

	$tab = split(";",$mon_path);
	$mon_path = $tab[0];

	$var_retour = "
            <script>
                function JS_change_portfolio_preview(path, source, target) {
                
                   
                
                    var extension = (source.value.substring(source.value.length-3,source.value.length));
                    if((extension=='jpg')||(extension=='gif')||(extension=='png')||(extension=='jpe'))
                    {
                        document.all[target].src = path + source.value;
                    }
                    else 
                    {
                        document.all[target].src = path + '../../../admin/images/icones_explorer/icone_' + extension + '.gif'; 

                    }
                    document.formulaire.lien_zoom.value = path + source.value;
                }
                
                function zoomit() {
                    var lien = document.formulaire.lien_zoom.value;
                    window.open(lien,'zoom');
                }
            </script>
            <input type='hidden' name='lien_zoom' value='".$portfolio_default_img."'>
            <table border='0' cellpadding='0' cellspacing='0' width='100%'>
            <tr><td valign=top>            

        ";

	$var_retour .="<select name=\"".$form_fieldname."_port\" onChange=\"JS_change_portfolio_preview('".$mon_path."', this, 'img_portfolio_preview_".$form_fieldname."')\" class=\"".$StyleChamps."\">";
	$var_retour .= "<option value=\"../images/px_trans.gif\">Vide</option>";
	$var_retour .= list_dir($mon_path,0);
	$var_retour .="</select></td><td valign=\"top\"><a href='#' onClick='zoomit()'><img src=\"".$portfolio_default_img."\" width=\"50\" name=\"img_portfolio_preview_".$form_fieldname."\" border=0></a></tr></table>";
	return $var_retour;
}

// +--------------------------------------------------------------------------+
// |                                                                          |
// |        		 COMPOSE LES OPTIONS HTML DES TABLES SQL                      |
// |         			(organis�es selon leur type de nav)													|
// +--------------------------------------------------------------------------+
// | Date : 22/02/2007                                                        |
// +--------------------------------------------------------------------------+
function display_bo_organised_tables_options ( $selected_table )
{
	$display		= "";
	$RstTable 	= mysql_query( "Select * from "._CONST_BO_CODE_NAME."dic_data order by type desc, libelle" );
	$table_type = -1;

	for ( $i=0 ; $i < @mysql_num_rows($RstTable) ; $i++ )
	{
		if (@mysql_result($RstTable,$i, "nom_table")) // !ereg("bo",@mysql_result($RstTable,$i, "nom_table")) &&
		{

			if ( empty( $table_name ) )
			{
				$table_name		= @mysql_result($RstTable,$i, "nom_table");
				$table_alias	= @mysql_result($RstTable,$i, "libelle");
			}

			if ( @mysql_result($RstTable,$i, "nom_table") == $selected_table )
			{
				$selected			= "selected";
				$table_name		= @mysql_result($RstTable,$i, "nom_table");
				$table_alias	= @mysql_result($RstTable,$i, "libelle");
			}
			else
			{
				$selected="";
			}

			if ( $table_type != @mysql_result($RstTable, $i, "type") )
			{
				if ( $table_type != -1 )
				$display .= "</optgroup>";

				$new_type 	= @mysql_result($RstTable, $i, "type");
				$type_name 	= "";

				if ( $new_type == 3 )
				$type_name = "Gabarits";
				else if ( $new_type == 2 )
				$type_name = "Utilisateur";
				else if ( $new_type == 0 )
				$type_name = "Systeme";
				else
				$type_name = "Autre";

				$display .= "<optgroup label=\"".$type_name."\">";
				$table_type = $new_type;
			}

			$display .= "<option value='".@mysql_result($RstTable,$i, "nom_table")."' ".$selected.">".@mysql_result($RstTable,$i, "libelle")."</option>";
		}
	}

	if ( $table_type != -1 )
	$display .= "</optgroup>";

	return Array ( "display" => $display, "name" => $table_name, "alias" => $table_alias );
}

// fonction qui retourne le vrai nom d'une table sans les _1,_2,... de fin de table quand multie clef etrang�re sur la
// meme table
function getTruename($table) {
	return eregi_replace("(_[0-9]+)$","",$table);
}

function MakeCsvActu($id_langue,$suffixe,$titreActu,$del){

	include_once("../include/lib_front.inc.php");

  if($titreActu!=""){
    $titreSearch = str_replace("\"","'",$titreActu);
  	$titreSearch = utf8_decode($titreSearch);
  	$titreSearch = stripslashes($titreSearch);
  	$titreSearch = get_formatte_membre_url_rewrited($titreSearch);
        
    $sql_S    = "select post_ID from evo_items__item where post_urltitle='".$titreSearch."'";
    $result_S = mysql_query($sql_S);
    $post_ID  = mysql_result($result_S,0,"post_ID");
   
    $sql_S    = "delete from evo_items__item where post_ID=$post_ID";
    $result_S = mysql_query($sql_S);
    
    $sql_S    = "delete from evo_postcats where postcat_post_ID=$post_ID";
    $result_S = mysql_query($sql_S);
  
    $sql_S    = "delete from evo_items__prerendering where itpr_itm_ID=$post_ID";
    $result_S = mysql_query($sql_S);
  }
  

  if($del!=1){
 
	$sql_S = "select id__langue,_langue_ext_sql from _langue where id__langue=".$id_langue;
	$query = mysql_query($sql_S);

	$BlogContent = "title,content,date,status,locale,urltitle,url,comment_status,ptyp_ID,pst_ID,tags,priority,excerpt,views,datedeadline,featured,order,titletag,double1,double2,double3,double4,double5,varchar1,varchar2,varchar3\n";
	$filename = 'blogActu'.$suffixe.'.txt';
	$handle = fopen($filename, 'w');
	while ($row = mysql_fetch_array($query)) {

		
		$sql = "SELECT
					'actualite' as nom_table,
					actualite.date_debut AS date_debut,
					actualite.date_fin AS date_fin,
					actualite.visuel_1  AS visuel_1,
					trad_actualite.libelle,
					trad_actualite.description_longue,
					trad_actualite.description_courte
				FROM 
					actualite
				INNER JOIN
					trad_actualite ON (trad_actualite.id__langue=1 AND trad_actualite.id__actualite=actualite.id_actualite)
				WHERE 
					
					actualite.date_fin >=NOW() AND trad_actualite.libelle != ''
				
					
				UNION (	
					SELECT
					    'bon_plan' as nom_table,
						bon_plan.date_debut,
						bon_plan.date_fin,
						bon_plan.visuel AS visuel_1,
						trad_bon_plan.libelle,
						trad_bon_plan.description AS description_longue,
						trad_bon_plan.description AS description_courte
					FROM 
						bon_plan
					INNER JOIN
						trad_bon_plan ON (trad_bon_plan.id__langue=".$row["id__langue"]." AND trad_bon_plan.id__bon_plan=bon_plan.id_bon_plan)
					WHERE 
						bon_plan.date_fin >=NOW() AND trad_bon_plan.libelle != ''
					)
					
				ORDER BY date_debut DESC";
	
		$result = mysql_query($sql);

		while ($myrow = mysql_fetch_array($result)) {
			$title = str_replace("\"","'",$myrow["libelle"]);

			$title_formated = utf8_decode($title);
			$title_formated = stripslashes($title_formated);
			$title_formated = get_formatte_membre_url_rewrited($title_formated);

			//$title_formated = get_formatte_membre_url_rewrited($title);
			if($myrow["description_longue"]!= ""){
				$content = str_replace("\"","'",$myrow["description_longue"]);
			}else{
				$content = str_replace("\"","'",$myrow["description_courte"]);
			}

			$content = str_replace("type='_moz'","",$content);



			$date = $myrow["date_debut"];
			if($row["id__langue"] == 1){
				$locale = "fr-FR";
			}elseif($row["id__langue"] == 2){
				$locale = "en_US";
			}elseif($row["id__langue"] == 3){
				$locale = "es_ES";
			}elseif($row["id__langue"] == 5){
				$locale = "de_DE";
			}
			$urltitle 	= getFileFromBDD($myrow["visuel_1"],$myrow["nom_table"],"../");
			if($urltitle!=""){

				list($width, $height, $type, $attr) = getimagesize(_CONST_APPLI_URL.$urltitle);
				if($width>150 ){
					$width=150;
					if($type == "image/jpeg"){
						$image = "../".$urltitle;
						$img = red_image($image,$image,150);
					}
				}
				$urltitle = "<img width='$width' style='display: block; float: left; margin: 10px;' src='"._CONST_RELATIVE_LOGICAL_PATH.$urltitle."' />";


			}
			$comment_status = "open";
			$status = "published";
			$datedeadline = $row["date_fin"];
			$main_cat_id = 16;

$content2 = nl2br($content);
			$BlogContent.= "\"$title\",\"$urltitle $content2\",$date,$status,$locale,$title_formated,,open,1,,,3,\"$content2\",0,$datedeadline,0,,,,,,,,,,\n";



			// Assurons nous que le fichier est accessible en ï¿½criture
			if (is_writable($filename)) {
				// Ecrivons quelque chose dans notre fichier.
				if (fwrite($handle, $BlogContent) === FALSE) {
					//echo "Impossible d'Ã©crire dans le fichier ($filename)";
					//exit;
				}
			} else {
				//echo "Le fichier $filename n'est pas accessible en ï¿½criture.";
			}

			$BlogContent="";

		}
		fwrite($handle, $BlogContent);
		fclose($handle);
	}

  }
	//MakeCsvBonPLan($id_langue,$suffixe);
}


function MakeCsvBonPLan($id_langue,$suffixe){
	$sql_S = "select id__langue,_langue_ext_sql from _langue where id__langue=".$id_langue;
	$query = mysql_query($sql_S);

	$BlogContent = "title,content,date,status,locale,urltitle,url,comment_status,ptyp_ID,pst_ID,tags,priority,excerpt,views,datedeadline,featured,order,titletag,double1,double2,double3,double4,double5,varchar1,varchar2,varchar3\n";
	$filename = 'blogBonPlan'.$suffixe.'.txt';
	$handle = fopen($filename, 'w');
	while ($row = mysql_fetch_array($query)) {

		$sql  = "select
					bon_plan.date_debut,
					bon_plan.date_fin,
					bon_plan.visuel as visuel_1,
					trad_bon_plan.libelle,
					
					trad_bon_plan.description as description_longue
				from 
					bon_plan
				inner join
					trad_bon_plan on (trad_bon_plan.id__langue=".$row["id__langue"]." and trad_bon_plan.id__bon_plan=bon_plan.id_bon_plan)
				WHERE 
					bon_plan.date_fin >=NOW() and trad_bon_plan.libelle != ''
				order by
					bon_plan.date_debut DESC";
		$result = mysql_query($sql) or die(mysql_error());

		while ($myrow = mysql_fetch_array($result)) {
			$title = str_replace("\"","'",$myrow["libelle"]);
			//$title_formated = get_formatte_membre_url_rewrited($title);
			
			
			
			$title_formated = utf8_decode($title);
			$title_formated = stripslashes($title_formated);
			$title_formated = get_formatte_membre_url_rewrited($title_formated);
		
if($myrow["description_longue"]!= ""){
				$content = str_replace("\"","'",$myrow["description_longue"]);
			}else{
				$content = str_replace("\"","'",$myrow["description_courte"]);
			}
			$content = str_replace("type='_moz'","",$content);
			//if($content != ""){
			$date = $myrow["date_debut"];
			if($row["id__langue"] == 1){
				$locale = "fr-FR";
			}elseif($row["id__langue"] == 2){
				$locale = "en_US";
			}elseif($row["id__langue"] == 3){
				$locale = "es_ES";
			}elseif($row["id__langue"] == 5){
				$locale = "de_DE";
			}
			$urltitle 	= getFileFromBDD($myrow["visuel_1"],"bon_plan","../");
			if($urltitle!=""){
				
				list($width, $height, $type, $attr) = getimagesize(_CONST_APPLI_URL.$urltitle);
				if($width>150){
$width=150;
					if($type == "image/jpeg"){
					$image = "../".$urltitle;
					$img = red_image($image,$image,150);
				}
	}
				$urltitle = "<img width='$width' style='display:block; float: left; margin: 10px;' src='"._CONST_RELATIVE_LOGICAL_PATH.$urltitle."' />";
			}
			$comment_status = "open";
			$status = "published";
			$datedeadline = $row["date_fin"];
			$main_cat_id = 16;

		
			$BlogContent.= "\"$title\",\"<p>$urltitle $content</p>\",$date,$status,$locale,$title_formated,,open,1,,,3,\"$content\",0,$datedeadline,0,,,,,,,,,,\n";
		

		
			// Assurons nous que le fichier est accessible en �criture
			if (is_writable($filename)) {
				// Ecrivons quelque chose dans notre fichier.
				if (fwrite($handle, $BlogContent) === FALSE) {
					//echo "Impossible d'�crire dans le fichier ($filename)";
					//exit;
				}
			} else {
				//echo "Le fichier $filename n'est pas accessible en �criture.";
			}

			$BlogContent="";

		}
		fwrite($handle, $BlogContent);
		fclose($handle);
	}
}

function MakeHtaccess(){
  $filename = '../.htaccess';
  $tab = array();
  $buffer = "";
  $stop = 0;
  // Assurons nous que le fichier est accessible en écriture
  if (is_writable($filename)) {
  
      // Dans notre exemple, nous ouvrons le fichier $filename en mode lecture écriture
      // Le pointeur de fichier est placé au début du fichier
      $handle = fopen($filename, 'r+');
      
      while (!feof($handle)) {
        $buffer = fgets($handle, 4096);
        $buffer = trim($buffer);
       // echo $buffer."--<br>--";
        
        
        if($buffer == '#Bandeau_them/start'){
          $stop = 1;
         
        }elseif($buffer == '#Bandeau_them/end'){
            $tab[] = '#Bandeau_them/start';
            //On stocke les urls des thématiques
            $sql_S = "SELECT id__langue,url,id__actualite_thematique FROM trad_actualite_thematique WHERE url != ''";
            $result_S = mysql_query($sql_S);
            while($myrow = mysql_fetch_array($result_S)){
              $tab[] = 'RewriteRule ^'.$myrow["url"].'$ index.php?theme='.$myrow["id__actualite_thematique"].'&L='.$myrow["id__langue"].' [QSA,NC,L]';
            }
            $tab[] = '#Bandeau_them/end';
            $stop = 0;
        }else{
           if($stop == 0){
            $tab[] = $buffer;
           }
        }
        
       
      }
      fclose($handle);
      

      
      
      $handle = fopen($filename, 'w');
      foreach($tab as $val){
        fwrite($handle, $val);
fwrite($handle, "
");
      }
      fclose($handle);
  
  
  
  } 
}



?>
