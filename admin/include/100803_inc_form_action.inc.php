<? 
$bUpdateDicDataNav = false;
$noFile = false ;
if (isset($_REQUEST['action']) && $_REQUEST['action']==1) {//Action valide

	//Creation des requetes SQL
	if ($_REQUEST['ID']) {
		$id = $_REQUEST['ID'];
	}

	$nbTrads=0;
	$nbr_div = 1;

	if ($object_type==3 || $TableDef == 3)
	{
		$strLangue="SELECT * FROM _langue ORDER BY _langue_by_default desc, id__langue asc";
		$rsLangues=@mysql_query($strLangue);
		$nbr_div = @mysql_num_rows($rsLangues);

	}

	$group_id = "";
	for($lg = 0; $lg < $nbr_div; $lg++)
	{
		$UPDATE = "";
		$INSERT = "";
		$DELETE = "";
		$StrINSERTleft = "";
		$StrINSERTright = "";

		if ($object_type==3)
		{
			$id = @mysql_result($result, $lg, "id_".$CurrentTableName);
		}
		if ($TableDef == 3)
		{
			$id = @mysql_result($result, $lg, "id__object");

		}

		if ($object_type==3 && $mode == "modif")
		{
			$sqlGroupId = "SELECT _group_gab_id FROM _object WHERE id__object = " . $idObj;
			$rstGroupId = mysql_query ( $sqlGroupId );
			$group_id_modif = @mysql_result($rstGroupId, 0, "_group_gab_id");
		}

		//echo("id : ".$id."<br>");

		$object_bo_langue = @mysql_result($rsLangues,$lg,"id__langue");

		for ($k=0; $k<$nb_cols; $k++) {
			$fieldname =	@mysql_field_name($result, $k);
			$fieldtype =	@mysql_field_type($result, $k);
			$fieldlen  =	@mysql_field_len($result, $k);
			$tablename =	@mysql_field_table($result, $k);

			$form_fieldname= "field_".$fieldname;				//$form_fieldname= "idtable_".$k;//$fieldname;

			if ($object_type==3)
			{
				$form_fieldname = $form_fieldname."_".@mysql_result($rsLangues,$lg,"_langue_abrev");
			}

			if (isset($_REQUEST[$form_fieldname]))
			$value_form_fieldname = $_REQUEST[$form_fieldname];
			else
			$value_form_fieldname = "";





			// *** CHAMP MULTILINGUE ***
			$chaine = "select multilingue from "._CONST_BO_CODE_NAME."lib_champs where field='".$fieldname."' and id_"._CONST_BO_CODE_NAME."table_def=".$TableDef;
			$RSlc = @mysql_query($chaine);
			if(@mysql_result($RSlc,0,"multilingue")==1)
			$flag_multilingue=1;
			else
			$flag_multilingue=0;



			if ($k == 0) {
				$UPDATE .=  "Update $tablename set ";
				$INSERT .=  "Insert into $tablename ";
				$DELETE .=  "Delete from $tablename ";
				$clef = $fieldname;
			}
			else {

				if(isMultilingue($fieldname,$TableDef)==1)
				{

					$formfield_trad[$nbTrads]['form_fieldname']	    =$form_fieldname;
					$formfield_trad[$nbTrads]['fieldname']			=$fieldname;
					$formfield_trad[$nbTrads]['fieldtype']			=$fieldtype;
					$formfield_trad[$nbTrads]['fieldlen']			=$fieldlen;
					$formfield_trad[$nbTrads]['tablename']			=$tablename;
					$nbTrads++;

				}


				//************    LISTE A CHOIX MULTIPLES
				if ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey)) {


					$UPDATE .=  "$fieldname=\"".@implode(",",$value_form_fieldname)."\",";
					$StrINSERTleft .= $fieldname.",";
					$StrINSERTright .= "\"".@implode(",",$value_form_fieldname)."\",";

				}
				//------------ MODIF LAC 12/2004
				// pb : le varchar(254) est trop petit pour stocker tous les id dans la table user..
				// passage du champ en longtext => detection dans inc_form ici=
				elseif(($_REQUEST['TableDef']==8)&&($fieldname == $datatype_arbo))
				{
					$UPDATE .=  "$fieldname=\"".@implode(",",$value_form_fieldname)."\",";
					$StrINSERTleft .= $fieldname.",";
					$StrINSERTright .= "\"".@implode(",",$value_form_fieldname)."\",";
					continue;
				}
				//------------ FIN MODIF LAC
				//************    LISTE DE DONNEES
				elseif ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_list_data)) {
					$UPDATE .=  "$fieldname=\"".@implode("|",$value_form_fieldname)."\",";
					$StrINSERTleft .= $fieldname.",";
					$StrINSERTright .= "\"".@implode("|",$value_form_fieldname)."\",";
				}
				//************    TEXTE
				elseif ($fieldtype==$mysql_datatype_text && $fieldlen!=ereg_replace("(.*)\((.*)\)","\\2",$datatype_file) ) {

					$valeur_formfieldname = $value_form_fieldname;
					$valeur_formfieldname = str_replace("<", "&lt;",$valeur_formfieldname);
					$valeur_formfieldname = str_replace(">", "&gt;",$valeur_formfieldname);
					$UPDATE .=  "$fieldname=\"".$valeur_formfieldname."\",";
					$StrINSERTleft .= $fieldname.",";
					$StrINSERTright .= "\"".$valeur_formfieldname."\",";

				}

				//************    CHAMPS DATE ET HEURE
				if ($fieldtype==$datatype_date || $fieldtype==$datatype_datetime) {
					$datetemp = split("/",substr($value_form_fieldname,0,10));
					$newdate = $datetemp[2]."-".$datetemp[1]."-".$datetemp[0];

					//Gestion del'heure
					if ($fieldtype==$datatype_datetime) {
						$newtime = " ".date("H:i:s",GetTimestampFromDate(substr($value_form_fieldname,0,10),substr($value_form_fieldname,-8)));
					}
					else {
						$newtime = "";
					}



					if (ereg("_update_date",$fieldname)) {
						$UPDATE .=  "$fieldname=NOW(),";

					}
					else
					{
						$UPDATE .=  "$fieldname=\"".($newdate.$newtime)."\",";
					}

					$StrINSERTleft .= $fieldname.",";
					//Date du jour par defaut
					if (ereg("_auto",$fieldname)) {
						$StrINSERTright .= "NOW(),";
					}
					//DAte saisie par l'utilisateur
					else {
						$StrINSERTright .= "\"".($newdate.$newtime)."\",";
					}
				}

				//On test si il s'agit d'un champs d'ordonnancement
				//09/08/2002
				if ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_order)) {
					$ordonnancement[] = 1;
					$ordonnancement[] = $tablename;
					$ordonnancement[] = $value_form_fieldname;
				}

				//************    CHAMP TEXTAREA
				if ($fieldtype==$mysql_datatype_text_rich) {

					if (!get_magic_quotes_gpc()) { // le champ a-t'il �t� d�ja �chapp� ?
						$value = addslashes($value_form_fieldname); // non
					}
					else {
						$value = $value_form_fieldname; // oui
					}

					$value = str_replace ( "€", "&euro;", $value );

					$value = utf8_decode($value);
					$value = unhtmlentities($value);
					$value = utf8_encode($value);
					//MDI : la ligne suivante permet de rectifier l'erreur commise par la fonction utf8_encode sur l'encodage de l'�
					//$value = str_replace(chr(0xC2).chr(0x80) , chr(0xE2).chr(0x82).chr(0xAC),  $value);

					$UPDATE .=  "$fieldname='".$value."',";
					$StrINSERTleft .= $fieldname.",";
					$StrINSERTright .= "'".$value."',";
				}
				//************    LISTE DEROULANTE
				if ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_key)) {
					$UPDATE .=  "$fieldname='".$value_form_fieldname."',";
					$StrINSERTleft .= $fieldname.",";
					$StrINSERTright .= "'".$value_form_fieldname."',";

					//===============================
					// SPEC  --> is pere =temoignage alors gabarits auto dans la liste
					//===============================
					if($_REQUEST['TableDef']==2 )
					{
						if($fieldname=="id__nav_pere")
						{
							$bUpdateDicDataNav = true;
						}
					}
					//---------fin spec------------
				}
				//************    CHAMPS TEXTE CONTENANT UNE VALEUR NUMERIQUE
				if (
				(
				$fieldtype==$mysql_datatype_integer
				|| $fieldtype==$mysql_datatype_real
				)
				&& (
				(
				$fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_integer)
				|| $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_order)
				|| $fieldlen==$datatype_real
				)
				)
				) {
					if ($value_form_fieldname=="0") {
						$value_form_fieldname = "0";
					}
					elseif (empty($value_form_fieldname)) {//Si rien n'a ete saisie
						$value_form_fieldname = "NULL"; //On met le champs a NULL
					}

					$UPDATE .=  "$fieldname=".$value_form_fieldname.",";
					$StrINSERTleft .= $fieldname.",";
					$StrINSERTright .= $value_form_fieldname.",";
				}

				//CASE A COCHER
				if ($fieldtype==$mysql_datatype_integer && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_booleen) ) {
					if ($value_form_fieldname == 1) {//Coch�e
						$valeur = 1;
					}
					else {//Non coch�e
						$valeur = 0;
					}

					$UPDATE .=  "$fieldname=".$valeur.",";
					$StrINSERTleft .= $fieldname.",";
					$StrINSERTright .= $valeur.",";
				}

				//FICHIER
				if ($fieldtype==$mysql_datatype_text && $fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_file) ) {
					if ($mode=="nouveau" && $compteur==0) {//Upload du fichier si nouveau
						//01/06/2001 --> Pour des problemes de compatibilit� MySQL 3.23 et 3.22
						//J'insere l'id puis le suprime pour connaitre la valeur du prochain id a inserer
						mysql_query("Insert into ".$tablename." (".$fieldname.") values (\" \")");
						$id = mysql_insert_id();
						mysql_query("Delete from ".$tablename." where id_".$tablename."=".$id."");
						$compteur++;
						$id++;
						//						//on recupere la valeur de la clef (l'id le + grand + 1)
						//						$id = 1 + @mysql_result(mysql_query("select max(id_".$tablename.") as id_".$tablename." from ".$tablename),0,"id_".$tablename);
					}

					//On recupere le nom du champ dans la base afin de supprimer le fichier sur le server si il y a besoin
					$NomDuFichierDansLaBase = @mysql_result(@mysql_query("select ".$tablename.".".$fieldname." from ".$tablename." where ".$tablename.".id_".$tablename."=".$id),0,$tablename.".".$fieldname);

					//Nom donn� au fichier = 95 premiers carc du nom original + id champ
					$TFile = split("\.",$_FILES[$form_fieldname]["name"]);
					for ($n=0;$n<count($TFile);$n++) {
						$TFile[$n] = trim($TFile[$n]);
					}
					$FileExt = array_pop($TFile);
					$TFile = substr(join($TFile,"."),0, 95);
					$FileName = $TFile."_".$id.".".$FileExt;


					//					Avant
					//					$FileName = substr($fieldname."_".$id.".".$FileExt,0, 70);



					//Si une image a ete selectionn� ou si on supprime l'image
					if (($_FILES[$form_fieldname]["name"]) || $_REQUEST["PictureDelete_".$fieldname] || $_REQUEST["choose_img_type_".$form_fieldname] == "1") {
						if ($_REQUEST["PictureDelete_".$fieldname]==1) {//On supprime l'image existante
							DeleteFile($NomDuFichierDansLaBase, $UploadPath[$CtImUpload]);
							$fichier = "";
						}
						else {
							DeleteFile($NomDuFichierDansLaBase, $UploadPath[$CtImUpload]);
							$fichier = UploadFile_2($fieldname."_".$FileName, $form_fieldname, $UploadPath[$CtImUpload]);
						}

						//Portfolio
						if ($_REQUEST["choose_img_type_".$form_fieldname] == "1") {
							$fichier = $_REQUEST[$form_fieldname."_port"];
						}

						$UPDATE .=  "$fieldname=\"".$fichier."\",";
						$StrINSERTleft .= $fieldname.",";
						$StrINSERTright .= "\"".$fichier."\",";
						$noFile = false ;
					}
					//************    GESTION DES UPLOAD EN MODE DUPLICATION
					elseif (($_REQUEST[$form_fieldname."_duplicate"])) {
						copy($UploadPath[$CtImUpload]."/".$_REQUEST[$form_fieldname."_duplicate"], $UploadPath[$CtImUpload]."/duplicate_".$_REQUEST[$form_fieldname."_duplicate"]);
						$StrINSERTleft .= $fieldname.",";
						$StrINSERTright .= "\"duplicate_".$_REQUEST[$form_fieldname."_duplicate"]."\",";
						$noFile = false ;
					}
					else
					{
						//$noFile utile que pour une table qui ne comporte qu'un seul champ + id_table
						if($nb_cols<=2)
						{
							$noFile = true ;
						}
					}

					//Suppression de l'images
					if ($mode == "supr") {
						//Suppression du fichier lier
						DeleteFile($NomDuFichierDansLaBase, $UploadPath[$CtImUpload]);
					}

					$CtImUpload++;
				}
			}
		} //fin boucle sur les champs de l'objet en cours




		$UPDATE = substr($UPDATE, 0, -1);//Suppression de la dernier virgule
		$UPDATE .=  " where ".$clef."=$id";
		//suppression des enregistrements de traductions si besoin
		if($nbTrads>0)
		$DELETE ="DELETE t,td FROM $tablename as t INNER JOIN "._CONST_BO_PREFIX_TABLE_TRAD.$tablename." as td ON td.id__".$tablename."=t.id_".$tablename;

		$DELETE .=  " where ".$clef."=".$id;
		$INSERT = $INSERT." (".substr($StrINSERTleft, 0, -1).") Values (".substr($StrINSERTright, 0, -1).")";//Composition de la requete



		//////////////////////////////////////////////////////
		//					NOUVEAU
		//////////////////////////////////////////////////////
		if ($mode=="nouveau") {


			


			//EVENEMENT
			bo_event($SQLBeforeInsert,$debug_mode,$id,"sql_before_insert");

			//Requete ajout
			$StrSQL = $INSERT;
			mysql_query($StrSQL) or die(mysql_error());//execution de la requete
			$id=mysql_insert_id();
			$id_ajout = $id;

			// FFR ---On enregistre un nouvel utilisateur si ajout d'un centre :
			if( $_GET["TableDef"]==_CONST_TABLEDEF_CENTRE){
				/*$sql_I = "INSERT INTO _user ( `nom`,
				`login`,
				`password`,
				`email`,
				`id__profil`,
				`portfolio_access_16`,
				`id__langue`,
				`id_centre`)
				VALUES        ( '".$_REQUEST["field_libelle"]."',
				'".$_REQUEST["field_login"]."',
				'".$_REQUEST["field_passe"]."',
				'".$_REQUEST["field_email"]."',
				'"._PROFIL_CENTRE."',
				'PortFolio & Upload',
				'1,2,3,4',
				'$id_ajout')";
				$result_I = mysql_query($sql_I);*/

				//On envoi un mail au centre :

				//----------------------------
			}
			// -----------------------------------------------------------------

			// FFR
			if( $_GET["TableDef"]==_CONST_TABLEDEF_CENTRE){
				$sql_U 		= "update centre set date_inscription=NOW() where id_centre=$id";
				$result_U 	= mysql_query($sql_U);
			}

			// FFR --- On remplit �galement les tarifs enfants et scolaire du s�jour
			if( $_GET["TableDef"]==_CONST_TABLEDEF_ACCUEIL_GROUPE ||
			$_GET["TableDef"]==_CONST_TABLEDEF_GROUPE_ADULTE ||
			$_GET["TableDef"]==_CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE){
				$sql_I = "Insert into sejour_tarif_groupe (HS_bb,
                                                                  HS_dp,
                                                                  HS_pc,
                                                                  HS_rs,
                                                                  MS_bb,
                                                                  MS_dp,
                                                                  MS_pc,
                                                                  MS_rs,
                                                                  BS_bb,
                                                                  BS_dp,
                                                                  BS_pc,
                                                                  BS_rs,
                                                                  id__table_def,
                                                                  IdSejour)
                                                                  
                                                        VALUES   ('".$_REQUEST["HS_bb"]."',
                                                                  '".$_REQUEST["HS_dp"]."',
                                                                  '".$_REQUEST["HS_pc"]."',
                                                                  '".$_REQUEST["HS_rs"]."',
                                                                  '".$_REQUEST["MS_bb"]."',
                                                                  '".$_REQUEST["MS_dp"]."',
                                                                  '".$_REQUEST["MS_pc"]."',
                                                                  '".$_REQUEST["MS_rs"]."',
                                                                  '".$_REQUEST["BS_bb"]."',
                                                                  '".$_REQUEST["BS_dp"]."',
                                                                  '".$_REQUEST["BS_pc"]."',
                                                                  '".$_REQUEST["BS_rs"]."',
                                                                  '".$_GET["TableDef"]."',
                                                                  '".$id."')";
				//echo $sql_I;
				$result_I = mysql_query($sql_I);

				$sql_I = "Insert into sejour_tarif_groupe_plus (HS_bb,
                                                                  HS_dp,
                                                                  HS_pc,
                                                                  HS_rs,
                                                                  MS_bb,
                                                                  MS_dp,
                                                                  MS_pc,
                                                                  MS_rs,
                                                                  BS_bb,
                                                                  BS_dp,
                                                                  BS_pc,
                                                                  BS_rs,
                                                                  id__table_def,
                                                                  IdSejour)
                                                                  
                                                        VALUES   ('".$_REQUEST["HS_bb_n"]."',
                                                                  '".$_REQUEST["HS_dp_n"]."',
                                                                  '".$_REQUEST["HS_pc_n"]."',
                                                                  '".$_REQUEST["HS_rs_n"]."',
                                                                  '".$_REQUEST["MS_bb_n"]."',
                                                                  '".$_REQUEST["MS_dp_n"]."',
                                                                  '".$_REQUEST["MS_pc_n"]."',
                                                                  '".$_REQUEST["MS_rs_n"]."',
                                                                  '".$_REQUEST["BS_bb_n"]."',
                                                                  '".$_REQUEST["BS_dp_n"]."',
                                                                  '".$_REQUEST["BS_pc_n"]."',
                                                                  '".$_REQUEST["BS_rs_n"]."',
                                                                  '".$_GET["TableDef"]."',
                                                                  '".$id."')";
				//echo $sql_I;
				$result_I = mysql_query($sql_I);

			}
			//---------------------------------------------------------------------





			// FFR --- On remplit egalement le d�tail des hebergement si on est dans un ajout de centre
			if($_GET["TableDef"]==_CONST_TABLEDEF_CENTRE){

				$sql_S = "select * from centre_type_chambre";
				$result_S = mysql_query($sql_S);

				while($myrow_S= mysql_fetch_array($result_S)){
					$idType = $myrow_S["id_centre_type_chambre"];
					$sql_I = "INSERT into centre_detail_hebergement ( id_centre_2,
                                                                  id_centre_type_chambre,
                                                                  nb_chambre,
                                                                  nb_lit,
                                                                  nb_lavDouWC_chambre,
                                                                  nb_lavDouWC_lit,
                                                                  nb_lavDou_chambre,
                                                                  nb_lavDou_lit,
                                                                  nb_lavOuWC_chambre,
                                                                  nb_lavOuWC_lit,
                                                                  nb_noWC_chambre,
                                                                  nb_noWC_lit)
                                                                  
                                                            VALUES( '".$id."',
                                                                    '".$idType."',
                                                                    '".$_REQUEST["nb_chambre_".$idType]."',
                                                                    '".$_REQUEST["nb_lit_".$idType]."',
                                                                    '".$_REQUEST["nb_lavDouWC_chambre_".$idType]."',
                                                                    '".$_REQUEST["nb_lavDouWC_lit_".$idType]."',
                                                                    '".$_REQUEST["nb_lavDou_chambre_".$idType]."',
                                                                    '".$_REQUEST["nb_lavDou_lit_".$idType]."',
                                                                    '".$_REQUEST["nb_lavOuWC_chambre_".$idType]."',
                                                                    '".$_REQUEST["nb_lavOuWC_lit_".$idType]."',
                                                                    '".$_REQUEST["nb_noWC_chambre_".$idType]."',
                                                                    '".$_REQUEST["nb_noWC_lit_".$idType]."')";
					$result_I = mysql_query($sql_I);


					//Si un profil "centre" ajoute un centre on update avec son id
					if($_SESSION['ses_profil_user'] == _PROFIL_CENTRE){
						$sql_U  = "update centre set idCentre = ".$_SESSION['ses_id_bo_user']." where id_centre=".$id;
						$result_U = mysql_query($sql_U);
					}
					// -----------------------------------------------------------

				}

			}





			if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQL <br>".mysql_errno() . ": " . mysql_error());

			//===============================================================
			// RAJOUT des gabarits lors d'une cr�ation d'une nav dans l'arbo
			// d�finit le ou les gabarits attribu�s par d�faut � une nav
			//=================================================================
			if($bUpdateDicDataNav && _DEFAULT_GAB_TABLES != "")
			{
				$sqlUpdateDicData = "
            	
            	UPDATE _dic_data 
            	SET id__nav = CONCAT(id__nav,',$id')
            	WHERE 
            	";
				$tmp = explode(",",_DEFAULT_GAB_TABLES);
				for($zz = 0;$zz<count($tmp);$zz++){
					if($zz == 0)
					$sqlGabCentraux .= "nom_table = '".$tmp[$zz]."'";
					else
					$sqlGabCentraux .= " or nom_table = '".$tmp[$zz]."'";
				}
				$tmp = "";

				$sqlUpdateDicData = $sqlUpdateDicData.$sqlGabCentraux ;
				mysql_query($sqlUpdateDicData);

			}

			//==================================


			if ($object_type==3)
			{
				//get_bo_tablename($tablename)
				$item_ref_id = mysql_insert_id();

				if ($group_id == "")
				{
					$group_id = $tablename."_".mysql_insert_id();
				}

				$StrSQLObj = "
                                INSERT INTO
                                        "._CONST_BO_CODE_NAME."object
                                    (
                                        id_"._CONST_BO_CODE_NAME."table_def,
                                        name_req,
                                        description,
                                        date_create_auto,
                                        date_update_auto,
                                        table_ref_req,
                                        item_table_ref_req,
                                        id_"._CONST_BO_CODE_NAME."workflow_state,
                                        id_"._CONST_BO_CODE_NAME."nav,
                                        id_"._CONST_BO_CODE_NAME."user,
                                        ordre,
	                                        		id_"._CONST_BO_CODE_NAME."langue,
	                                        		id_"._CONST_BO_CODE_NAME."user_autor,
		                                        		id_"._CONST_BO_CODE_NAME."object_source,
		                                        		_group_gab_id
                                    )
                                VALUES
                                    (
                                        ".$TableDef.",
                                        \"".$_REQUEST['object_name']."\",
                                        \"".$_REQUEST['object_desc']."\",
                                        NOW(),
                                        NOW(),
                                        \"".($tablename)."\",
                                        $item_ref_id,
                                        ".$_REQUEST['id_bo_workflow_state'].",
                                        ".$_REQUEST['object_bo_nav'].",
                                        ".$_SESSION['ses_id_bo_user'].",
                                        \"".$_REQUEST['object_ordre']."\",
                                        			".$object_bo_langue.",
                                        			".$_SESSION['ses_id_bo_user'].",
	                                        			\"".($_REQUEST['id_obj_source'])."\",
	                                        			\"".$group_id."\"
                                    )
                             ";
				mysql_query($StrSQLObj);
				if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQLObj<br>".mysql_errno() . ": " . mysql_error());

				if ($debug_mode)  echo get_sql_format($StrSQLObj);
			}


			//MODE POPUP
			if ($DisplayMode == "PopUp")
			{
				?> 
				<script>
				JS_update_listbox_from_popup('<?=$mode?>', 'field_id_<?=$tablename?>', '<?=$_REQUEST["field_".$tablename]?>', <?=mysql_insert_id()?>);
				</script>
				<?
			}

			//EVENEMENT
			bo_event($SQLAfterInsert,$debug_mode,$id,"sql_after_insert");


		}

		//////////////////////////////////////////////////////
		//					MODIFICATION
		//////////////////////////////////////////////////////
		elseif ($mode=="modif") {

			
			
			
			if( $_GET["TableDef"]==_CONST_TABLEDEF_ACCUEIL_GROUPE ||
			$_GET["TableDef"]==_CONST_TABLEDEF_GROUPE_ADULTE||
			$_GET["TableDef"]==_CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE){

				$sql_S = "select count(*) as nb from sejour_tarif_groupe where id__table_def = '".$_REQUEST["TableDef"]."' and IdSejour='".$_REQUEST["ID"]."'";
				$result_S = mysql_query($sql_S);
				$nb = mysql_result($result_S,0,"nb");
				if($nb>0){
				// FFR --- On met �galement � jour les tarifs enfants et scolaires
				$sql_U = "UPDATE sejour_tarif_groupe set          HS_bb = '".$_REQUEST["HS_bb"]."',
                                                                HS_dp = '".$_REQUEST["HS_dp"]."',
                                                                HS_pc = '".$_REQUEST["HS_pc"]."',
                                                                HS_rs = '".$_REQUEST["HS_rs"]."',
                                                                MS_bb = '".$_REQUEST["MS_bb"]."',
                                                                MS_dp = '".$_REQUEST["MS_dp"]."',
                                                                MS_pc = '".$_REQUEST["MS_pc"]."',
                                                                MS_rs = '".$_REQUEST["MS_rs"]."',
                                                                BS_bb = '".$_REQUEST["BS_bb"]."',
                                                                BS_dp = '".$_REQUEST["BS_dp"]."',
                                                                BS_pc = '".$_REQUEST["BS_pc"]."',
                                                                BS_rs = '".$_REQUEST["BS_rs"]."'
                                                    WHERE id__table_def = '".$_REQUEST["TableDef"]."' and IdSejour='".$_REQUEST["ID"]."'";
				//die($sql_U);
				$result_U = mysql_query($sql_U);
				}else{
					$sql_I = "Insert into sejour_tarif_groupe (HS_bb,
                                                                  HS_dp,
                                                                  HS_pc,
                                                                  HS_rs,
                                                                  MS_bb,
                                                                  MS_dp,
                                                                  MS_pc,
                                                                  MS_rs,
                                                                  BS_bb,
                                                                  BS_dp,
                                                                  BS_pc,
                                                                  BS_rs,
                                                                  id__table_def,
                                                                  IdSejour)
                                                                  
                                                        VALUES   ('".$_REQUEST["HS_bb"]."',
                                                                  '".$_REQUEST["HS_dp"]."',
                                                                  '".$_REQUEST["HS_pc"]."',
                                                                  '".$_REQUEST["HS_rs"]."',
                                                                  '".$_REQUEST["MS_bb"]."',
                                                                  '".$_REQUEST["MS_dp"]."',
                                                                  '".$_REQUEST["MS_pc"]."',
                                                                  '".$_REQUEST["MS_rs"]."',
                                                                  '".$_REQUEST["BS_bb"]."',
                                                                  '".$_REQUEST["BS_dp"]."',
                                                                  '".$_REQUEST["BS_pc"]."',
                                                                  '".$_REQUEST["BS_rs"]."',
                                                                  '".$_GET["TableDef"]."',
                                                                  '".$_REQUEST["ID"]."')";
					//echo $sql_I;
					$result_I = mysql_query($sql_I);
				}
				
				
				
				$sql_S = "select count(*) as nb from sejour_tarif_groupe_plus where id__table_def = '".$_REQUEST["TableDef"]."' and IdSejour='".$_REQUEST["ID"]."'";
				$result_S = mysql_query($sql_S);
				$nb = mysql_result($result_S,0,"nb");
				
				if($nb>0){
				$sql_U = "UPDATE sejour_tarif_groupe_plus set     HS_bb = '".$_REQUEST["HS_bb_n"]."',
                                                                HS_dp = '".$_REQUEST["HS_dp_n"]."',
                                                                HS_pc = '".$_REQUEST["HS_pc_n"]."',
                                                                HS_rs = '".$_REQUEST["HS_rs_n"]."',
                                                                MS_bb = '".$_REQUEST["MS_bb_n"]."',
                                                                MS_dp = '".$_REQUEST["MS_dp_n"]."',
                                                                MS_pc = '".$_REQUEST["MS_pc_n"]."',
                                                                MS_rs = '".$_REQUEST["MS_rs_n"]."',
                                                                BS_bb = '".$_REQUEST["BS_bb_n"]."',
                                                                BS_dp = '".$_REQUEST["BS_dp_n"]."',
                                                                BS_pc = '".$_REQUEST["BS_pc_n"]."',
                                                                BS_rs = '".$_REQUEST["BS_rs_n"]."'
                                                    WHERE id__table_def = '".$_REQUEST["TableDef"]."' and IdSejour='".$_REQUEST["ID"]."'";
				$result_U = mysql_query($sql_U);
				}else{
					$sql_I = "Insert into sejour_tarif_groupe_plus (HS_bb,
                                                                  HS_dp,
                                                                  HS_pc,
                                                                  HS_rs,
                                                                  MS_bb,
                                                                  MS_dp,
                                                                  MS_pc,
                                                                  MS_rs,
                                                                  BS_bb,
                                                                  BS_dp,
                                                                  BS_pc,
                                                                  BS_rs,
                                                                  id__table_def,
                                                                  IdSejour)
                                                                  
                                                        VALUES   ('".$_REQUEST["HS_bb_n"]."',
                                                                  '".$_REQUEST["HS_dp_n"]."',
                                                                  '".$_REQUEST["HS_pc_n"]."',
                                                                  '".$_REQUEST["HS_rs_n"]."',
                                                                  '".$_REQUEST["MS_bb_n"]."',
                                                                  '".$_REQUEST["MS_dp_n"]."',
                                                                  '".$_REQUEST["MS_pc_n"]."',
                                                                  '".$_REQUEST["MS_rs_n"]."',
                                                                  '".$_REQUEST["BS_bb_n"]."',
                                                                  '".$_REQUEST["BS_dp_n"]."',
                                                                  '".$_REQUEST["BS_pc_n"]."',
                                                                  '".$_REQUEST["BS_rs_n"]."',
                                                                  '".$_REQUEST["TableDef"]."',
                                                                  '".$_REQUEST["ID"]."')";
					//echo $sql_I;
					$result_I = mysql_query($sql_I);
				}
				//----------------------------------------------------------------

			}
			
			
			// DCA -- On envoie un mail de confirmation d'activation de compte
			if( $_GET["TableDef"]==_CONST_TABLEDEF_MEMBRE)
			{
				//si la session existe : 
				$id_langue = 1;
				if (isset ($_SESSION['ses_langue']) && $_SESSION['ses_langue']!="")
					$id_langue = $_SESSION['ses_langue'];
				
				$sql_test = "SELECT email, flag_mail_envoye 
				FROM membres 
				WHERE id_membres = '".$_REQUEST["ID"]."' ";
				$result_test = mysql_query($sql_test);
				$data_test = mysql_fetch_assoc($result_test);
				
				if($_POST['field_actif'] == 1 && $data_test['flag_mail_envoye'] == 0)
				{
					// d�finition des variables de template
					$sqlTradLib = "SELECT tr.libelle 
	            	FROM tradotron t INNER JOIN trad_tradotron tr ON t.id_tradotron = tr. id__tradotron
	            	WHERE tr.id__langue = '".$id_langue."' 
	            	AND code_libelle = 'lib_activation_compte' ";
					$resultTradLib = mysql_query($sqlTradLib);
					$dataTradLib = mysql_fetch_assoc($resultTradLib);
					$titre = $dataTradLib['libelle'];
					
					$sqlTradLib = "SELECT tr.libelle 
	            	FROM tradotron t INNER JOIN trad_tradotron tr ON t.id_tradotron = tr. id__tradotron
	            	WHERE tr.id__langue = '".$id_langue."' 
	            	AND code_libelle = 'lib_message_activation_compte' ";
					$resultTradLib = mysql_query($sqlTradLib);
					$dataTradLib = mysql_fetch_assoc($resultTradLib);
					$message = $dataTradLib['libelle'];
					
					$urlSite = _CONST_APPLI_URL;
					
					// lecture du fichier de template
					$file_name = '../tpl/gab/mail/mail.tpl';
					$rs = fopen($file_name, 'r');
					$file_content = fread($rs, filesize($file_name));
					fclose($rs);
					
					// construction du message � partir du template
					$message_mail = str_replace('#{$titre}#', $titre, $file_content);
					$message_mail = str_replace('#{$urlSite}#', $urlSite, $message_mail);
					$message_mail = str_replace('#{$message}#', $message, $message_mail);
					
					$aEnvoi = envoie_mail($data_test["email"], $message_mail, _MAIL_WEBMASTER, $titre);
					
					// mise � jour du flag mail envoy�
					$sql_up = "UPDATE membres 
					SET flag_mail_envoye = 1 
					WHERE id_membres = '".$_REQUEST["ID"]."' ";
					$result_up = mysql_query($sql_up);
				}
				

				//----------------------------
			}


			// FFR -- On met � jour la table _user
			if( $_GET["TableDef"]==_CONST_TABLEDEF_CENTRE){
				/*
				$sql_U = "UPDATE _user set  `login` = '".$_REQUEST["field_login"]."',
				`password` = '".$_REQUEST["field_passe"]."',
				`email` = '".$_REQUEST["field_email"]."'
				WHERE id_centre='".$_REQUEST["ID"]."'";
				$result_U = mysql_query($sql_U);
				*/
				//On envoi un mail au centre :

				//----------------------------
			}


			// FFR --- On met a jour egalement le d�tail des hebergements si on est dans une modification de centre
			if($_GET["TableDef"]==_CONST_TABLEDEF_CENTRE){

				$sql_S = "select * from centre_type_chambre";
				$result_S = mysql_query($sql_S);

				while($myrow_S= mysql_fetch_array($result_S)){
					$idType = $myrow_S["id_centre_type_chambre"];
					$sql_U ="update centre_detail_hebergement set nb_chambre = '".$_REQUEST["nb_chambre_".$idType]."',
                                                              nb_lit = '".$_REQUEST["nb_lit_".$idType]."',
                                                              nb_lavDouWC_chambre = '".$_REQUEST["nb_lavDouWC_chambre_".$idType]."',
                                                              nb_lavDouWC_lit = '".$_REQUEST["nb_lavDouWC_lit_".$idType]."',
                                                              nb_lavDou_chambre = '".$_REQUEST["nb_lavDou_chambre_".$idType]."',
                                                              nb_lavDou_lit = '".$_REQUEST["nb_lavDou_lit_".$idType]."',
                                                              nb_lavOuWC_chambre = '".$_REQUEST["nb_lavOuWC_chambre_".$idType]."',
                                                              nb_lavOuWC_lit = '".$_REQUEST["nb_lavOuWC_lit_".$idType]."',
                                                              nb_noWC_chambre = '".$_REQUEST["nb_noWC_chambre_".$idType]."',
                                                              nb_noWC_lit = '".$_REQUEST["nb_noWC_lit_".$idType]."'  
                                                WHERE id_centre_2='".$_REQUEST["ID"]."' AND id_centre_type_chambre='".$idType."'";

					$result_U = mysql_query($sql_U);

				}

			}


			//EVENEMENT
			bo_event($SQLBeforeUpdate,$debug_mode,$id,"sql_before_update");


			//*** 10/09/2007-MVA ajout trad
			//*** Test si autre chose que des champs de traduction
			//*** Dans ce cas mise � jour dans la table de reference

			if($k>$nbTrads+1)//*** on ne modifie pas l'id de l'enregistrement
			{
				//TLY --> si contenus existants et qu on rajoute de nouvelles langues dans le BO, les objets des nouvelles langues ne peuvent pas �tre
				//updatees si elles n existent pas
				if($object_type==3 && $id == "")
				{
					//Requete d insertion
					$StrSQL = $INSERT;
					mysql_query($StrSQL);//execution de la requete
					$item_ref_id = mysql_insert_id();
					if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQL <br>".mysql_errno() . ": " . mysql_error());

					$group_id = $group_id_modif;

					//----------------------------
					$StrSQLObj = "
                                INSERT INTO
                                        "._CONST_BO_CODE_NAME."object
                                    (
                                        id_"._CONST_BO_CODE_NAME."table_def,
                                        name_req,
                                        description,
                                        date_create_auto,
                                        date_update_auto,
                                        table_ref_req,
                                        item_table_ref_req,
                                        id_"._CONST_BO_CODE_NAME."workflow_state,
                                        id_"._CONST_BO_CODE_NAME."nav,
                                        id_"._CONST_BO_CODE_NAME."user,
                                        ordre,
	                                        		id_"._CONST_BO_CODE_NAME."langue,
	                                        		id_"._CONST_BO_CODE_NAME."user_autor,
		                                        		id_"._CONST_BO_CODE_NAME."object_source,
		                                        		_group_gab_id
                                    )
                                VALUES
                                    (
                                        ".$TableDef.",
                                        \"".$_REQUEST['object_name']."\",
                                        \"".$_REQUEST['object_desc']."\",
                                        NOW(),
                                        NOW(),
                                        \"".($tablename)."\",
                                        $item_ref_id,
                                        ".$_REQUEST['id_bo_workflow_state'].",
                                        ".$_REQUEST['object_bo_nav'].",
                                        ".$_SESSION['ses_id_bo_user'].",
                                        \"".$_REQUEST['object_ordre']."\",
                                        			".$object_bo_langue.",
                                        			".$_SESSION['ses_id_bo_user'].",
	                                        			\"".($_REQUEST['id_obj_source'])."\",
	                                        			\"".$group_id."\"
                                    )
                             ";
					mysql_query($StrSQLObj);
					if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQLObj<br>".mysql_errno() . ": " . mysql_error());

					if ($debug_mode)  echo get_sql_format($StrSQLObj);

				}
				else
				{
					//Requete de modification
					$StrSQL = $UPDATE;
					//trace($_POST);
					//die();
					
					
					
					if ($debug_mode)
					{
						print_r($_REQUEST);
						echo("UPDATE: $UPDATE");
					}

					//une table avec 2 champs seuelement pour eviter des err de requetes genre update table set where wxx=xx (manque l interieur avec le set pour les images)
					if(!$noFile)
					{
						mysql_query($StrSQL) or die(mysql_error());;//execution de la requete
						if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQL<br>".mysql_errno() . ": " . mysql_error());
					}




					if ($object_type==3){
						$item_ref_id = $id;
						$StrSQLObj = "
			                        UPDATE 
			                                "._CONST_BO_CODE_NAME."object 
			                        SET 
			                            name_req=\"".$_REQUEST['object_name']."\", 
			                            description=\"".$_REQUEST['object_desc']."\", 
			                            date_update_auto=NOW(), 
			                            id_"._CONST_BO_CODE_NAME."langue = ".$object_bo_langue.", 
			                            id_"._CONST_BO_CODE_NAME."nav = ".$_REQUEST['object_bo_nav'].", 
			                            id_"._CONST_BO_CODE_NAME."user = ".$_SESSION['ses_id_bo_user'].", 
			                            id_"._CONST_BO_CODE_NAME."workflow_state = ".$_REQUEST['id_bo_workflow_state'].",
			                            ordre = \"".$_REQUEST['object_ordre']."\"
			                        WHERE 
			                             _group_gab_id ='".$group_id_modif."'                              
			                        AND 
			                            item_table_ref_req =".$id;                	
						mysql_query($StrSQLObj);

						if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQLObj<br>".mysql_errno() . ": " . mysql_error());


						if ($debug_mode)  echo get_sql_format($StrSQLObj);

					}
					//MODE POPUP
					if ($DisplayMode == "PopUp") {
							?> 
							<script>
							JS_update_listbox_from_popup('<?=$mode?>', 'field_id_<?=$tablename?>', '<?=$_REQUEST["field_".$tablename]?>', <?=$ID?>);
							</script>
							<?
					}

					//EVENEMENT
					bo_event($SQLAfterUpdate,$debug_mode,$id,"sql_after_update");
				}
			}

		}

		if($mode=="modif" || $mode=="nouveau")
		{
			
			if($_REQUEST["TableDef"] == _CONST_TABLEDEF_ACTUALITE || $_REQUEST["TableDef"] == _CONST_TABLEDEF_BON_PLAN){
				MakeCsvActu(1,'');
				MakeCsvActu(2,'_us');
				MakeCsvActu(3,'_de');
				MakeCsvActu(5,'_es');
			}
			
			if($_REQUEST["TableDef"] == _CONST_TABLEDEF_ACTUALITE_THEMATIQUE){
        MakeHtaccess();
      }
			if($_SESSION["ses_profil_user"] == _PROFIL_CENTRE){
				$message = date("d-m-Y")."<br />";
				$message .= "Action : ".$mode."<br />";
				$message .= "Table : ".$tablename."<br />";

				
				$sql_S = "select ville, libelle from centre where id_centre = ".$_SESSION["ses_id_centre"];
				$result_S = mysql_query($sql_S);
				$message .= "Centre : ".mysql_result($result_S,0,"ville")."/".mysql_result($result_S,0,"libelle")."<br />";
			

				$sejour="";
				if($_REQUEST["field_nom"] != ""){
					$sejour = $_REQUEST["field_nom"];
				}elseif($_REQUEST["field_nom_stage"] != ""){
					$sejour = $_REQUEST["field_nom_stage"];
				}elseif($_REQUEST["field_libelle"] != ""){
					$sejour = $_REQUEST["field_libelle"];
				}
				if($sejour!=""){
					$message .= "Sejour : ".$sejour."<br />";
				}
				envoie_mail(_MAIL_CONTACT_EMPLOI,$message,_MAIL_CONTACT_EMPLOI,"ETHIC ETAPES - Action BO effectu�e");
			}
// 07/09/2007-MVA ajout trad
			if($nbTrads>0)
			{
				//*** Si nouveau
				//*** Je repertorie les langue afin de leur creer un control plus tard
				$strLangue="SELECT * FROM _langue ORDER BY _langue_by_default desc, id__langue asc";
				$rsLangues=@mysql_query($strLangue);

				//*** pr�pare une requete d'insertion au cas ou
				//*** l'enregistrement p�re n'ai pas de trad associ�


				//*** parcours des langues
				for($i=0;$i<@mysql_num_rows($rsLangues);$i++)
				{


					$UPDATE_TRAD=	"UPDATE "._CONST_BO_PREFIX_TABLE_TRAD.$tablename." SET ";


					$right=" VALUES(".$id.",".@mysql_result($rsLangues,$i,"id__langue");
					$left=	"INSERT INTO "._CONST_BO_PREFIX_TABLE_TRAD.$tablename."(id__".$tablename.",id__langue";

					//*** parcours des champs � traduire
					for($j=0;$j<$nbTrads;$j++)
					{

						if($j>0)
						{
							$UPDATE_TRAD.=",";
						}

						$left.=",".$formfield_trad[$j]['fieldname'];

						//*** traitement de la valeur post�e


						$field_trad_name=$formfield_trad[$j]['form_fieldname']."_".@mysql_result($rsLangues,$i,"id__langue");

						$value=genValueforSQL($formfield_trad[$j],$mode,@mysql_result($rsLangues,$i,"id__langue"),$id,$tablename);

						$right.=",'".$value."'";
						$UPDATE_TRAD.=$formfield_trad[$j]['fieldname']."='".$value."'";

					}


					//*** finalisation des requetes
					$UPDATE_TRAD.=" WHERE id__langue=".@mysql_result($rsLangues,$i,"id__langue")." AND id__".$tablename."=".$id;
					$left.=")";
					$right.=")";
					$INSERT_TRAD=$left.$right;
					
					
					//*** test l'existence de la trad dans la base
					$strSQL="SELECT * FROM "._CONST_BO_PREFIX_TABLE_TRAD.$tablename." WHERE id__langue=".@mysql_result($rsLangues,$i,"id__langue")." AND id__".$tablename."=".$id;
					if(mysql_num_rows(mysql_query($strSQL))==0)
					{
						mysql_query($INSERT_TRAD) or die(mysql_error());
					}
					else
					{

						//On update que si on a les droits sur la langue ou si on est root
						if ($_SESSION['ses_profil_user']==1 || in_array(mysql_result($rsLangues,$i,"id__langue"), explode(",",$_SESSION['ses_id_langue_user'])) )
						{

							mysql_query($UPDATE_TRAD) or die(mysql_error());
						}

					}
					if (mysql_error()) die(mysql_error()."Erreur sur traitement trad".$INSERT_TRAD.$UPDATE_TRAD."<br>");
				}


				//=========================================================================
				// A chaque fois qu'on cr�e un libell�, on maj le fichier de trad
				//===================================================================
				genereFichiersTrad($_REQUEST["TableDef"]);

			}

if($_REQUEST["TableDef"] == _CONST_TABLEDEF_ACTUALITE){
        $url = _CONST_APPLI_URL."blogActu.php";
        	$url_es = _CONST_APPLI_URL."blogActu_es.php";
				$url_de = _CONST_APPLI_URL."blogActu_de.php";
				$url_us = _CONST_APPLI_URL."blogActu_us.php";

        
       echo "
       <b>Administration du blog.</b>
        <br>Les actualités vont être transférées dans le blog.
        <br><br><a href='$url' class='new-window' id='LienBlog'>Cliquez ici pour continuer.</a>
        <script>
        
        $('#LienBlog').click(function(){
                window.open($(this).attr('href') );
 window.open('$url_es');
                window.open('$url_de');
                window.open('$url_us');
                history.go(-2);
                return false;
               
        });
        //$('#LienBlog').click();
        self.focus();
        </script>";
        die();
      
        
      }elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_BON_PLAN){
        $url = _CONST_APPLI_URL."blogBonPlan.php";
        $url_es = _CONST_APPLI_URL."blogBonPlan_es.php";
				$url_de = _CONST_APPLI_URL."blogBonPlan_de.php";
				$url_us = _CONST_APPLI_URL."blogBonPlan_us.php";

       echo "
        <b>Administration du blog.</b><br>Les bons plans vont être transférés dans le blog.<a href='$url' class='new-window' id='LienBlog'><br><br>Cliquez ici pour continuer.</a>
        <script>
        
        $('#LienBlog').click(function(){
                window.open($(this).attr('href') );
                window.open('$url_es');
                window.open('$url_de');
                window.open('$url_us');
                history.go(-2);
                return false;
               
        });
        //$('#LienBlog').click();
        self.focus();
        </script>";
        die();
      }

		}

		//////////////////////////////////////////////////////
		//					SUPPRESSION
		//////////////////////////////////////////////////////
		elseif ($mode=="supr") {

			
			if($_SESSION["ses_profil_user"] == _PROFIL_CENTRE){
				$message = date("d-m-Y")."<br />";
				$message .= "Action : ".$mode."<br />";
				$message .= "Table : ".$tablename."<br />";

				
				$sql_S = "select ville, libelle from centre where id_centre = ".$_SESSION["ses_id_centre"];
				$result_S = mysql_query($sql_S);
				$message .= "Centre : ".mysql_result($result_S,0,"ville")."/".mysql_result($result_S,0,"libelle")."<br />";
			

				$sejour="";
				if($_REQUEST["field_nom"] != ""){
					$sejour = $_REQUEST["field_nom"];
				}elseif($_REQUEST["field_nom_stage"] != ""){
					$sejour = $_REQUEST["field_nom_stage"];
				}elseif($_REQUEST["field_libelle"] != ""){
					$sejour = $_REQUEST["field_libelle"];
				}
				if($sejour!=""){
					$message .= "Sejour : ".$sejour."<br />";
				}
				envoie_mail(_MAIL_CONTACT_EMPLOI,$message,_MAIL_CONTACT_EMPLOI,"ETHIC ETAPES - Action BO effectu�e");
			}
			// Patch GPO - 23/03/2009
			// Correction sur la suppression de tout les gabarits dans toutes les langues
			if ($_REQUEST['TableDef']==3)
			{
				//get_bo_tablename($tablename)

				$sqlGroupId =  "SELECT _group_gab_id,item_table_ref_req, table_ref_req FROM _object WHERE id__object = " .$_REQUEST['ID'];
				$rstGroupId = mysql_query ( $sqlGroupId );

				if ( mysql_num_rows ( $rstGroupId ) > 0 )
				{
					//delete dans la table gabarit
					$sqlDelItems =  "SELECT item_table_ref_req, table_ref_req FROM _object WHERE _group_gab_id='".mysql_result($rstGroupId,0,"_group_gab_id" )."'";
					$rsDelItems = mysql_query($sqlDelItems);
					for($xx = 0 ; $xx < mysql_num_rows($rsDelItems); $xx++)
					{
						$sqlDelete = " DELETE FROM ".mysql_result($rsDelItems,$xx,"table_ref_req")." WHERE id_".mysql_result($rsDelItems,$xx,"table_ref_req")." = '".mysql_result($rsDelItems,$xx,"item_table_ref_req")."'";
						mysql_query($sqlDelete);
						if (mysql_error()) die("Erreur dans l'execution de la requete : $sqlDelete<br>".mysql_errno() . ": " . mysql_error());
					}

					//delete dans la table object
					$StrSQL = "DELETE FROM _object ";
					$StrSQL .= " WHERE _group_gab_id = '".mysql_result($rstGroupId,0,"_group_gab_id" )."'";
					mysql_query($StrSQL);//execution de la requete
					if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQL<br>".mysql_errno() . ": " . mysql_error());
				}
			}
			else
			{

				//EVENEMENT
				bo_event($SQLBeforeDelete,$debug_mode,$id,"sql_before_delete");


				// FFR -- Si suppression des centes on sauvegardes ses donn�es
				if($_REQUEST["TableDef"]== _CONST_TABLEDEF_CENTRE){
					delete_centre($_GET["ID"]);
				}


				//Requete suppression
				$StrSQL = $DELETE;
				mysql_query($StrSQL);//execution de la requete

				if (mysql_error()) die("Erreur dans l'execution de la requete : $StrSQL<br>".mysql_errno() . ": " . mysql_error());

				//===============================================================
				// retrait des gabarits lors d'une suppression d'une nav dans l'arbo
				//=================================================================
				if($bUpdateDicDataNav && _DEFAULT_GAB_TABLES != "")
				{

					$tmp = explode(",",_DEFAULT_GAB_TABLES);
					for($zz = 0;$zz<count($tmp);$zz++){
						if($zz == 0)
						$sqlGabCentraux .= "nom_table = '".$tmp[$zz]."'";
						else
						$sqlGabCentraux .= " or nom_table = '".$tmp[$zz]."'";
					}

					//suppression -- des gabs associ�s
					$sqlSelectDicData = "
							            	SELECT nom_table,id__nav 
							            	FROM _dic_data            
											WHERE ".$sqlGabCentraux;

					$rsSqlSelectDicData = mysql_query($sqlSelectDicData);
					for($xx=0;$xx<mysql_num_rows($rsSqlSelectDicData);$xx++)
					{
						$idNav = mysql_result($rsSqlSelectDicData,$xx,"id__nav");
						$new_id_nav = ereg_replace("(^|,)$id(,|$)","",$idNav);

						$sqlUpdateDicData = "
		            	
			            	UPDATE _dic_data 
			            	SET id__nav = '$new_id_nav'
			            	WHERE nom_table ='".mysql_result($rsSqlSelectDicData,$xx,"nom_table")."' ";           		
						//		            	tt($sqlUpdateDicData);
						mysql_query($sqlUpdateDicData);
					}
				}

				//=========================================================================
				// A chaque fois qu'on cr�e un libell�, on maj le fichier de trad
				//===================================================================
				genereFichiersTrad($_REQUEST["TableDef"]);


				//MODE POPUP
				if ($DisplayMode == "PopUp") {
				?> 
				<script>
				JS_update_listbox_from_popup('<?=$mode?>', 'field_id_<?=$tablename?>', '', <?=$ID?>);
				</script>
				<?
				}

				//EVENEMENT
				bo_event($SQLAfterDelete,$debug_mode,$id,"sql_after_delete");

			}

			$CtImUpload=0;
	
			
			if($_REQUEST["TableDef"] == _CONST_TABLEDEF_ACTUALITE || $_REQUEST["TableDef"] == _CONST_TABLEDEF_BON_PLAN){
				MakeCsvActu(1,'');
				MakeCsvActu(2,'_us');
				MakeCsvActu(3,'_de');
				MakeCsvActu(5,'_es');
			}
			
		  if($_REQUEST["TableDef"] == _CONST_TABLEDEF_ACTUALITE_THEMATIQUE){
        MakeHtaccess();
      }
      
     
      
if($_REQUEST["TableDef"] == _CONST_TABLEDEF_ACTUALITE){
        $url = _CONST_APPLI_URL."blogActu.php";
        $url_es = _CONST_APPLI_URL."blogActu_es.php";
				$url_de = _CONST_APPLI_URL."blogActu_de.php";
				$url_us = _CONST_APPLI_URL."blogActu_us.php";
				
        echo "
        <b>Administration du blog.</b><br>Les actualités vont être transférées dans le blog.<a href='$url' class='new-window' id='LienBlog'><br><br>Cliquez ici pour continuer.</a>
        <script>
        
        $('#LienBlog').click(function(){
                window.open($(this).attr('href') );
                window.open('$url_es');
                window.open('$url_de');
                window.open('$url_us');
                history.go(-2);
                return false;
               
        });
        //$('#LienBlog').click();
        self.focus();
        </script>";
        die();
      }elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_BON_PLAN){
        $url = _CONST_APPLI_URL."blogBonPlan.php";
        $url_es = _CONST_APPLI_URL."blogBonPlan_es.php";
				$url_de = _CONST_APPLI_URL."blogBonPlan_de.php";
				$url_us = _CONST_APPLI_URL."blogBonPlan_us.php";
				
       echo "
        <b>Administration du blog.</b><br>Les bons plans vont être transférés dans le blog.<a href='$url' class='new-window' id='LienBlog'><br><br>Cliquez ici pour continuer.</a>
        <script>
        
        $('#LienBlog').click(function(){
                window.open($(this).attr('href') );
                window.open('$url_es');
                window.open('$url_de');
                window.open('$url_us');
                history.go(-2);
                return false;
               
        });
        //$('#LienBlog').click();
        self.focus();
        </script>";
        die();
      }
      
      
      
 
		}


		//Gestion des ordonnancements
		//09/08/2002

		if ($mode=="nouveau") {
			$id = mysql_insert_id();
		}

		//Si mode DebugMode Active:1 alors on redirige vers la liste des items de la page en cours
		if ($silent_debug_mode)
		{
			$fp = fopen(_CONST_APPLI_PATH."admin/dump/sql/query/debug_inc_form_action.sql","a+");
			fwrite($fp,"\n".Date("d-m-Y H:i:s")." : TABLEDEF : ".$TableDef."\n");
			fwrite($fp,"\nREQUETES : \nINSERT : ".$INSERT);
			fwrite($fp,"\nDELETE : ".$DELETE);
			fwrite($fp,"\nUPDATE : ".$UPDATE);
			fwrite($fp,"\n---------------------------------------------------------");
			fclose($fp);

		}


		if ($debug_mode != 1)
		{


			if ($DisplayMode=="PopUp") {
				echo("<script type=\"text/javascript\">".($_REQUEST['reloadRef'] == 1&&false ? "opener.valid_form();" : "")."self.close();</script>");

			}elseif($_REQUEST['url_retour']!=""){

				if($_REQUEST["mode"]=="nouveau"){
					$querystring = "&ID=".$id_ajout;
				}

				if($_REQUEST["ancreId"]!=""){
					$queryAncre = "&".str_replace("#","",$_REQUEST["ancreId"])."=1";
					$querystring .= $queryAncre.$_REQUEST["ancreId"];
				}
				//die("-->".$_REQUEST['url_retour'].$querystring);
				echo "<Script>document.location.href=\"".$_REQUEST['url_retour'].$querystring."\"</script>";

			}else{

				if($_REQUEST["mode"]!="supr"){

					if($_REQUEST["ID"]!=""){
						$idRef = $_REQUEST["ID"];
					}else{
						$idRef = $id_ajout;
					}

					if($_REQUEST["mode"]=="nouveau"){
						$querystring = "&ID=".$id_ajout;
					}
					$retourFormulaire = $_POST["url_retour_2"].$querystring;

					//&& $_SESSION["ses_id_profil"]==_PROFIL_CENTRE
					if($_REQUEST["field_id_centre"] == -1 ){
						desactive_sejour($idRef,$tablename);
						echo "<Script>
                    if  (confirm(\"Vous devez selectionner un centre pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                         document.location.href='$retourFormulaire';
                    }else{ 
                      document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";
                    }
                  </script>";

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_CVL && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_date_accessible INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_date_accessible.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];


						$sql_S = "SELECT COUNT(*) as nb FROM sejour_date_accessible inner join cvl on (cvl.id_cvl = sejour_date_accessible.IdSejour) WHERE sejour_date_accessible.IdSejour = cvl.id_cvl AND cvl.id_cvl=".$_REQUEST["ID"];


						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<1){ //  Test si au mois 1 date
							desactive_sejour($idRef,$tablename);
							echo "	<Script>
				                      if  (confirm(\"Vous devez saisir au moins une 'Date de disponibilité' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
				                           document.location.href='$retourFormulaire';
				                      }else{ 
				                        document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";
				                      }
				                    </script>";

						}else{


							$idCentre = $_POST["field_id_centre"];
							//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

							$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def="._CONST_TABLEDEF_CVL.") INNER JOIN cvl ON (sejour_les_plus.IdSejour = cvl.id_cvl AND cvl.id_cvl=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";


							$result_S = mysql_query($sql_S);
							$nb1 = mysql_result($result_S,0,"nb");
							if($nb1<2){ //  Test si au 2 plus centre
								desactive_sejour($idRef,$tablename);
								echo "<Script>
					                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
					                           document.location.href='$retourFormulaire';
					                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
					                    </script>";

							}else{
								valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

							}





							//valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];



						$sql_S = "SELECT COUNT(*) as nb  FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def=".$_REQUEST["TableDef"].") INNER JOIN stages_thematiques_individuels ON (sejour_les_plus.IdSejour = stages_thematiques_individuels.id_stages_thematiques_individuels AND stages_thematiques_individuels.id_stages_thematiques_individuels=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";


						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ 
                        document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";
                      }
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_SEJOUR_SHORT_BREAK  && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def=".$_REQUEST["TableDef"].") INNER JOIN short_breaks ON (sejour_les_plus.IdSejour = short_breaks.id_short_breaks AND short_breaks.id_short_breaks=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";
						//die($sql_S);
						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def=".$_REQUEST["TableDef"].") INNER JOIN accueil_individuels_familles ON (sejour_les_plus.IdSejour = accueil_individuels_familles.id_accueil_individuels_familles AND accueil_individuels_familles.id_accueil_individuels_familles=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";

						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_SEJOUR_STAGE_THEM_GROUPE && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def="._CONST_TABLEDEF_SEJOUR_STAGE_THEM_GROUPE.") INNER JOIN stages_thematiques_groupes ON (sejour_les_plus.IdSejour = stages_thematiques_groupes.id_stages_thematiques_groupes AND stages_thematiques_groupes.id_stages_thematiques_groupes=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";


						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_SEJOUR_TOURISTIQUE && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def="._CONST_TABLEDEF_SEJOUR_TOURISTIQUE.") INNER JOIN sejours_touristiques ON (sejour_les_plus.IdSejour = sejours_touristiques.id_sejours_touristiques AND sejours_touristiques.id_sejours_touristiques=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";

						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_ACCUEIL_GROUPE  && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];


						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def="._CONST_TABLEDEF_ACCUEIL_GROUPE.") INNER JOIN accueil_groupes_scolaires ON (sejour_les_plus.IdSejour = accueil_groupes_scolaires.id_accueil_groupes_scolaires AND accueil_groupes_scolaires.id_accueil_groupes_scolaires=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";

						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_SEMINAIRE  && $_REQUEST["noVerif"]!=1){

						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def=".$_REQUEST["TableDef"].") INNER JOIN seminaires ON (sejour_les_plus.IdSejour = seminaires.id_seminaires AND seminaires.id_seminaires=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";

						//die($sql_S);
						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");





						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_ACCUEIL_REUNION  && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];

						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def="._CONST_TABLEDEF_ACCUEIL_REUNION.") INNER JOIN accueil_reunions ON (sejour_les_plus.IdSejour = accueil_reunions.id_accueil_reunions AND accueil_reunions.id_accueil_reunions=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";
						$result_S = mysql_query($sql_S);
						$nb0 = mysql_result($result_S,0,"nb");




						$sql_SS = "SELECT COUNT(*) as nb FROM sejour_salle_acceuil_reunion INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_salle_acceuil_reunion.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];
						$result_S = mysql_query($sql_SS);
						$nb1 = mysql_result($result_S,0,"nb");


						$sql_S = "SELECT COUNT(*) as nb FROM sejour_restauration_repas INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_restauration_repas.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];
						$result_S = mysql_query($sql_S);
						$nb2 = mysql_result($result_S,0,"nb");

						$sql_S = "SELECT COUNT(*) as nb FROM sejour_restauration_pause INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_restauration_pause.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];
						$result_S = mysql_query($sql_S);
						$nb3 = mysql_result($result_S,0,"nb");

						if($nb0<2){
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                        if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                             document.location.href='$retourFormulaire';
                        }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                      </script>";


						}elseif($nb1<1){
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins une salle pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}elseif($nb2<1){
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins une formule repas pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche  ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ 
                        document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";
                      }
                    </script>";

						}elseif($nb3<1){
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins une formule pause pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_CVL  && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def="._CONST_TABLEDEF_CVL.") INNER JOIN cvl ON (sejour_les_plus.IdSejour = cvl.id_cvl AND cvl.id_cvl=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";

						die($sql_S);
						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
				                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
				                           document.location.href='$retourFormulaire';
				                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
				                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_GROUPE_ADULTE  && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def="._CONST_TABLEDEF_GROUPE_ADULTE.") INNER JOIN accueil_groupes_jeunes_adultes ON (sejour_les_plus.IdSejour = accueil_groupes_jeunes_adultes.id_accueil_groupes_jeunes_adultes AND accueil_groupes_jeunes_adultes.id_accueil_groupes_jeunes_adultes=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";

						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_CLASSE_DECOUVERTE  && $_REQUEST["noVerif"]!=1){
						$idCentre = $_POST["field_id_centre"];
						//$sql_S = "SELECT COUNT(*) as nb FROM sejour_les_plus INNER JOIN $tablename ON ($tablename.id_$tablename = sejour_les_plus.IdSejour AND $tablename.id_centre=$idCentre) WHERE id__table_def=".$_REQUEST["TableDef"];

						$sql_S = "SELECT COUNT(*) as nb FROM trad_sejour_les_plus INNER JOIN sejour_les_plus ON (trad_sejour_les_plus.id__sejour_les_plus = sejour_les_plus.id_sejour_les_plus and sejour_les_plus.id__table_def="._CONST_TABLEDEF_CLASSE_DECOUVERTE.") INNER JOIN classe_decouverte ON (sejour_les_plus.IdSejour = classe_decouverte.id_classe_decouverte AND classe_decouverte.id_classe_decouverte=".$_REQUEST["ID"].") WHERE (trad_sejour_les_plus.id__langue = '1')";

						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");
						if($nb1<2){ //  Test si au 2 plus centre
							desactive_sejour($idRef,$tablename);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Les Plus du sejour' pour que votre sejour soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}else{
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);

						}

					}elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_CENTRE && $_REQUEST["noVerif"]!=1){ // V�rification de la fiche centre :

						if($_REQUEST["ID"]!=""){
							$idCentre = $_REQUEST["ID"];
						}else{
							$idCentre = $id_ajout;
						}



						$sql_S = "SELECT COUNT(*) AS nb FROM centre_site_touristique WHERE id_centre_1=$idCentre";
						$result_S = mysql_query($sql_S);
						$nb1 = mysql_result($result_S,0,"nb");

						$sql_S = "SELECT COUNT(*) AS nb FROM centre_les_plus WHERE id_centre_1=$idCentre";
						$result_S = mysql_query($sql_S);
						$nb2 = mysql_result($result_S,0,"nb");

						if($nb1<2){ //  Test si au 2 plus centre
							desactive_centre($idCentre);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Sites touristiques' pour que votre centre soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}elseif($nb2<2){ //  Test si au 2 plus centre
							desactive_centre($idCentre);
							echo "<Script>
                      if  (confirm(\"Vous devez saisir au moins deux 'Plus du centre' pour que votre centre soit valide. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                      }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";

						}elseif(   in_array(_ID_ENVIRONNEMENT_MONTAGNE,$_REQUEST["field_id_centre_environnement"])){
							$nb = count($_REQUEST["field_id_centre_environnement_montagne"]);
							if($nb==0){
								desactive_centre($idCentre);
								echo "<Script>
                      if  (confirm(\"Si l'environnement montagne a ete coche, vous devez preciser quel massif. Voulez-vous revenir sur votre fiche ?\")) {  // Clic sur OK
                           document.location.href='$retourFormulaire';
                       }else{ document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\";}
                    </script>";
							}else{
								active_centre($idCentre);
								valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);
							}
						}else{
							active_centre($idCentre);
							valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);
						}
					}else{
						active_centre($idCentre);
						valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);
					}

				}else{
					active_centre($idCentre);
					valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection);
				}
			}






		}

	}
}



function valideFin($TableDef,$target,$DisplayMode,$AscDesc,$ordre,$Search,$idItem,$Page,$DisplayMenu,$formMain_selection){
	if ($_REQUEST['object_bo_nav'] && $stay_on_current_form!=1) {//redirection vers la liste des objets
		echo "<Script>document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=3&idItem=".$_REQUEST['object_bo_nav']."&formMain_selection=".$formMain_selection."&Page=".$Page."\"</script>";//Retour a la liste des objets
	}
	elseif ($target)
	{
		//redirection vers une page autre la page elle-meme
		echo "<Script>document.location.href=\"".$target."\"</script>";
	}
	else
	{

		echo "<Script>document.location.href=\"".NomFichier($HTTP_SERVER_VARS["PHP_SELF"],0)."?TableDef=".$TableDef."&DisplayMode=".$DisplayMode."&AscDesc=".$AscDesc."&ordre=".$ordre."&Search=".$Search."&idItem=".$idItem."&Page=".$Page."&DisplayMenu=".$DisplayMenu."&formMain_selection=".$formMain_selection."\"</script>";//Retour a la liste
	}

}
?>
