<?
$Action = 0;
if (isset($_REQUEST['Action']))
	$Action = $_REQUEST['Action'];

$show_new_line = 0;
$WidthTableType="";
$fond_cellule="";

if(!isset ($media_select)){
$media_select = "";
}
if (isset($_REQUEST['media_select'])){
	$media_select = $_REQUEST['media_select'];
}
if (isset($_REQUEST['field_list_data'])){
	$field_list_data = $_REQUEST["field_list_data"];
}
if(!isset ($new_field_name)){
$new_field_name = "";
}
if (isset($_REQUEST['new_field_name']))
	$new_field_name = $_REQUEST['new_field_name'];


if(!isset ($new_media_field_name)){
$new_media_field_name = "";
}
if (isset($_REQUEST['new_media_field_name']))
	$new_media_field_name = $_REQUEST['new_media_field_name'];

if(!isset ($new_media_att_require)){
$new_media_att_require = 0;
}
if (isset($_REQUEST['new_media_att_require']))
	$new_media_att_require = $_REQUEST['new_media_att_require'];
	
if(!isset ($new_media_multilingue)){
	$new_media_multilingue = 0;
}
if (isset($_REQUEST['new_media_multilingue']))
	$new_media_multilingue = $_REQUEST['new_media_multilingue'];
	
if(!isset ($new_media_field_type)){
$new_media_field_type = "";
}	
if (isset($_REQUEST['new_media_field_type']))
	$new_media_field_type = $_REQUEST['new_media_field_type'];
	
if(!isset ($type)){
$type = "";
}
if (isset($_REQUEST['type']))
	$type  = $_REQUEST['type'];

if(!isset ($required)){
$required = "";
}
if (isset($_REQUEST['required']))
	$required  = $_REQUEST['required'];
	
if(!isset ($table_name)){
$table_name = "";
}
if (isset($_REQUEST['table_name']))
	$table_name = $_REQUEST['table_name'];

//Creation de la table
if (isset($_REQUEST['media_name']) && $_REQUEST['media_name'] && isset($_REQUEST['N']) && $_REQUEST['N']==1) {
	$show_new_line = 1;

	$table_name = strtolower(get_no_accent_from_text(ereg_replace("'", "",ereg_replace("\"", "",ereg_replace(" ", "_",stripslashes($_REQUEST['media_name']))))));

	//Creation du repertoire pour l'upload des images
	if (!file_exists(_CONST_BO_BINARY_UPLOAD._CONST_BO_TABLE_DATA_PREFIX.$table_name)) { 
		mkdir(_CONST_BO_BINARY_UPLOAD._CONST_BO_TABLE_DATA_PREFIX.$table_name, 0775); 
	}
	
	$table_name = _CONST_BO_TABLE_DATA_PREFIX.$table_name;
	$StrSQL = "CREATE TABLE `".$table_name."` (`id_".$table_name."` ".$datatype_key." AUTO_INCREMENT,  `".$table_name."` ".$datatype_text.", PRIMARY KEY(`id_".$table_name."`)) ENGINE="._DEFAUT_ENGINE." DEFAULT CHARACTER SET "._DEFAULT_CHARSET_BDD." COLLATE "._DEFAULT_COLLATION_BDD;
	$res = mysql_query($StrSQL);
	$media_select = $table_name;

	if (!$res) die("Defaut create table : $StrSQL => ".mysql_error());

	//Mise a jour de la table bo_table_def
	$StrSQL = "insert into "._CONST_BO_CODE_NAME."table_def (id_"._CONST_BO_CODE_NAME."profil, id_"._CONST_BO_CODE_NAME."menu, date_auto, select_liste, alias, select_modif_ajout, select_update_insert, sql_body, titre_rubrique_array, titre_bouton_array, item, titre_col, mode_col, upload_path, cur_table_name, menu_title, ordre_menu, sql_after_delete, search_engine) values (1, 1, NOW(),  \"Select ".$table_name.".*\",\"\", \"Select ".$table_name.".*\", \"Select ".$table_name.".*\",\"from ".$table_name."\", \"Liste des ".$_REQUEST['media_name'].";Cr√©ation;Modification;Suppression\", \"Cr√©er;Modifier;Supprimer\", \"".$_REQUEST['media_name']."\", \"Nouveau;Modifier;Supprimer\", \"nouveau;modif;supr\", \"\", \"".$table_name."\", \"".$_REQUEST['media_name']."\", \"1\", \"\", 0)";
	$res = mysql_query($StrSQL);

	if (!$res) die("Defaut create table def : $StrSQL => ".mysql_error());	
	//echo $StrSQL;
	$mon_id_bo_table_def = mysql_insert_id();
	
	
	//Mise a jour de la table bo_dic_data
	$strSQL = "INSERT INTO "._CONST_BO_CODE_NAME."dic_data (id_"._CONST_BO_CODE_NAME."table_def, nom_table, libelle, type) VALUES (".$mon_id_bo_table_def.", \"".$table_name."\", \"".$_REQUEST['media_name']."\", 2)";
	$res = mysql_query($strSQL);
	if (!$res) die("Defaut insert dic data : $strSQL => ".mysql_error());	
	
	redirect(NomFichier($_SERVER['PHP_SELF'],0)."?media_select=".$media_select);
}

//Creation d'une table annexe
if (isset($_REQUEST['table_annexe_name']) && $_REQUEST['table_annexe_name'] && isset($_REQUEST['NEW_A']) && $_REQUEST['NEW_A']==1) {

	$table_name = strtolower(get_no_accent_from_text(ereg_replace("'", "",ereg_replace("\"", "",ereg_replace(" ", "_",stripslashes($_REQUEST['table_annexe_name']))))));

	$table_name = _CONST_BO_TABLE_PREFIX.$table_name;
	mysql_query("CREATE TABLE `".$table_name."` (`id_".$table_name."` ".$datatype_key." AUTO_INCREMENT,".$table_name." ".$datatype_text.", PRIMARY KEY(`id_".$table_name."`)) ENGINE="._DEFAUT_ENGINE." DEFAULT CHARACTER SET "._DEFAULT_CHARSET_BDD." COLLATE "._DEFAULT_COLLATION_BDD);

	//Insertion d'un enregistrement (Aucun) par defaut dans la table
	mysql_query("INSERT INTO ".$table_name." (id_".$table_name.", ".$table_name.") VALUES (NULL, '(Aucun)')");
	
	//echo $StrSQL;

	//Mise a jour de la table bo_table_def
	$StrSQL = "insert into "._CONST_BO_CODE_NAME."table_def (id_"._CONST_BO_CODE_NAME."profil, id_"._CONST_BO_CODE_NAME."menu, date_auto, select_liste, alias, select_modif_ajout, select_update_insert, sql_body, titre_rubrique_array, titre_bouton_array, item, titre_col, mode_col, upload_path, cur_table_name, menu_title, ordre_menu, sql_after_delete, search_engine) values (1, 1, NOW(),  \"Select ".$table_name.".*\",\"\", \"Select ".$table_name.".*\", \"Select ".$table_name.".*\",\"from ".$table_name." where id_".$table_name."!=1\", \"Liste des ".ucfirst(str_replace(_CONST_BO_TABLE_PREFIX,"",$table_name)).";Cr√©ation;Modification;Suppression\", \"Cr√©er;Modifier;Supprimer\", \"".ucfirst(str_replace(_CONST_BO_TABLE_PREFIX,"",$table_name))."\", \"Nouveau;Modifier;Supprimer\", \"nouveau;modif;supr\", \"\", \"".$table_name."\", \"Table -> ".ucfirst(str_replace(_CONST_BO_TABLE_PREFIX,"",$table_name))."\", \"1\", \"\", 1)";
	mysql_query($StrSQL);

	
	$mon_id_bo_table_def = mysql_insert_id();	
	
	//Mise a jour de la table bo_dic_data
	mysql_query("INSERT INTO "._CONST_BO_CODE_NAME."dic_data (id_"._CONST_BO_CODE_NAME."table_def, nom_table, libelle, type) VALUES (".$mon_id_bo_table_def.", \"".$table_name."\", \"".$table_name."\", 1)");

	redirect(NomFichier($_SERVER['PHP_SELF'],0));
}

//Suppression d'une table annexe
if (isset($_REQUEST['delete_table_annnexe']) && $_REQUEST['delete_table_annnexe'] && isset($_REQUEST['SUPP_A']) && $_REQUEST['SUPP_A']==1) {
	
//	$obj_champ_recherche = new Champ_recherche();
	
	
	$RstTable = mysql_list_tables($BaseName);

	for ($i=0 ; $i < @mysql_num_rows($RstTable) ; $i++) {
		if (substr(@mysql_tablename($RstTable, $i), 0, 6)==_CONST_BO_TABLE_DATA_PREFIX)
		{ 
			// maj du moteur de recherche
//				$obj_champ_recherche->remove_champ(@mysql_tablename($RstTable, $i)."/id_".$delete_table_annnexe);
			// maj des champs pointant sur cette table annexe dans les tables spe
				$temp_champ = "id_".$delete_table_annnexe;
				mysql_query("ALTER TABLE `".@mysql_tablename($RstTable, $i)."` DROP `".$temp_champ."`");
		}
	}
//	$obj_champ_recherche->maj_bdd();
	
	
	mysql_query("DROP TABLE `".$delete_table_annnexe."`"); 
	
	//Supression dans la table bo_table_def
	$StrSQL = "delete from "._CONST_BO_CODE_NAME."table_def where cur_table_name=\"".$delete_table_annnexe."\"";
	//echo $StrSQL;
	mysql_query($StrSQL);

	//Supression dans la table bo_dic_data
	$StrSQL = "delete from "._CONST_BO_CODE_NAME."dic_data where nom_table=\"".$delete_table_annnexe."\"";
	mysql_query($StrSQL); 



	redirect(NomFichier($_SERVER['PHP_SELF'],0));
}

//Suppression d'une table
if ($_REQUEST['DT']==1) {
	
		$strTbf="SELECT id__table_def FROM _table_def WHERE cur_table_name='".$delete_table."'";
		$rs=@mysql_query($strTbf);
		$temp_table_def=mysql_result($rs,0,"id__table_def");
	
	// maj du moteur de recherche pour tous les champs de cette table
//	$rs_champs = mysql_query("select * from ".$delete_table);
//	$obj_champ_recherche = new Champ_recherche();
	
//	for ($i=0; $i<@mysql_num_fields($rs_champs) ; $i++)
//	{
//		$field_name = @mysql_field_name($rs_champs, $i);
//		$obj_champ_recherche->remove_champ($delete_table."/".$field_name);
//	}
//	$obj_champ_recherche->maj_bdd();
	
	mysql_query("DROP TABLE `".$_REQUEST['delete_table']."`"); 

	
	//Supression dans la table bo_dic_data
	$StrSQL = "delete from "._CONST_BO_CODE_NAME."dic_data where nom_table=\"".$_REQUEST['delete_table']."\"";
	mysql_query($StrSQL); 

	//Supression dans la table bo_table_def
	$StrSQL = "delete from "._CONST_BO_CODE_NAME."table_def where cur_table_name=\"".$_REQUEST['delete_table']."\"";
	mysql_query($StrSQL); 

		
		//Supression d'une table de trad
		$StrSQL = "delete from "._CONST_BO_CODE_NAME."lib_champs where id__table_def=".$temp_table_def;
		mysql_query($StrSQL); 
		
		$StrSQL = "DROP TABLE `"._CONST_BO_PREFIX_TABLE_TRAD.$delete_table."`";
		mysql_query($StrSQL); 



	redirect(NomFichier($_SERVER['PHP_SELF'],0)."?media_select=".$media_select);
}


$strTbf="SELECT id__table_def FROM _table_def WHERE cur_table_name='".$table_name."'";
$rs=@mysql_query($strTbf);
$temp_table_def=mysql_result($rs,0,"id__table_def");



//Suppression d'un champ
if ($_REQUEST['DF'] == 1) {
	mysql_query("ALTER TABLE `".$table_name."` DROP `".$_REQUEST['F']."`");
	
	// maj du moteur de recherche
//	$obj_champ_recherche = new Champ_recherche();
//	$champ_stocke = $table_name."/".$F;
//	$obj_champ_recherche->remove_champ($champ_stocke);
//	$obj_champ_recherche->maj_bdd();
	
	// maj du champ uploadpath pour les fichiers binaires
	if ($type==$datatype_file)
	{ 
		$rs_def = @mysql_query("SELECT upload_path FROM "._CONST_BO_CODE_NAME."table_def where cur_table_name='".$table_name."'");
		$nb_def = mysql_num_rows($rs_def);
		
		if ($nb_def!=0)
		{
			$temp_chemin = mysql_result($rs_def,0,"upload_path");
			
			$pos = strpos ($temp_chemin,$table_name);
			$taille = strlen($table_name);
			if (strpos($temp_chemin,";"))
				{ $pos = $pos + $taille + 2; }
			else 
				{ $pos = $pos + $taille + 1; }
			$maj = substr($temp_chemin,$pos);
				
			$rs_maj_def = @mysql_query("update "._CONST_BO_CODE_NAME."table_def set upload_path='".$maj."' where cur_table_name='".$table_name."'");
		}
	 }
	 
	 
	 	//06/09/2007-MVA-Champs multilingues dans table de contenus
		if(isMultilingue($F,$temp_table_def))
		{
			mysql_query("ALTER TABLE `"._CONST_BO_PREFIX_TABLE_TRAD.$table_name."` DROP `".$F."`");
			mysql_query("DELETE FROM _lib_champs  WHERE field='".$F."' AND id__table_def=".$temp_table_def);
			
			
			//*** si plus aucun champ de traduction dans la table, on la supprime
			//*** Cela Èvite d'avoir ‡ supprimer des tables ‡ la main en cas d'erreur
			//*** et d'avoir un tas de table de traduction vide ‡ terme
			$rsfields=mysql_list_fields($BaseName,_CONST_BO_PREFIX_TABLE_TRAD.$table_name);
			$nbfiels=(mysql_num_fields($rsfields));
			//*** s'il ne reste que les 3 champs de base (id,idlangue,id table mere)
			if($nbfiels==3)
				mysql_query("DROP TABLE `"._CONST_BO_PREFIX_TABLE_TRAD.$table_name."`");
				
		}

	redirect(NomFichier($_SERVER['PHP_SELF'],0)."?media_select=".$media_select);
}



//24/09/2003
if ($_REQUEST['change_type_to_text'] == 1) {

    $str_update = "ALTER TABLE `".$table_name."` CHANGE `".$_REQUEST['F']."` `".$_REQUEST['F']."` ".$array_type["TEXT"];
    mysql_query($str_update);

    //echo get_sql_format($str_update);

    $Action = 0;
}


//Modification d'un champ
if ($Action == 1 && $_REQUEST['UF']==1 ) {

    //LIST DATA
    if ($type==$datatype_list_data) {
        $new_field_name = $new_field_name.$field_list_data;
        $required = 0;
    }

	//On suffixe le nom du champ pour fixer l'attribut 
	//obligatoire de la saisie du champ
	 if ($required==1) {
		 if (!eregi(_CONST_BO_REQUIRE_SUFFIX."$",$new_field_name)) {
			$new_field_name .= _CONST_BO_REQUIRE_SUFFIX;
		 }
	 }
	 else {
 		$new_field_name = eregi_replace(_CONST_BO_REQUIRE_SUFFIX."$","",$new_field_name);
	 }

	//GESTION DU TYPE DE DONNEE ARBORESCENCE
	 if ($type==$datatype_arbo) {
		$new_field_name = $datatype_arbo;
		$type= $datatype_key;
	 }

	//GESTION DU TYPE ORDRE
	if ($type==$datatype_order) {
		$new_field_name = $datatype_order_name;
	}

	//GETION DU TYPE DE DONNEE DATE AUTOMATIQUE
	if ($type==$datatype_date_auto || $type==$datatype_datetime_auto) {
		if (!ereg("_auto$",$new_field_name)) {
			$new_field_name .= "_auto";
		}
		else {
			if ($new_media_field_type=="DATE" || $new_media_field_type=="DATETIME") {
				$new_field_name = ereg_replace("_auto","",$new_field_name);
			}
		}
	}

	if ($new_media_field_type == "CREATE_DATETIME_AUTO")
	{
		if (!ereg("_auto_creation_date$",$new_field_name)) {
			$new_field_name .= "_insert_datetime";
		}
	}
	
	
	if ($new_media_field_type == "UPDATE_DATETIME_AUTO")
	{
		if (!ereg("_auto_update_date$",$new_field_name)) {
			$new_field_name .= "_update_datetime";
		}
	}
	
	


	
	$StrSQL = "
            ALTER TABLE 
                    `".$table_name."` 
            CHANGE 
                `".$_REQUEST['old_field_name']."` `".ereg_replace(" ","",$new_field_name)."` ".$array_type[$new_media_field_type]."
            ";

	mysql_query($StrSQL);

		//06/09/2007-MVA-GESTION DES CHAMPS MULTILINGUES
				//echolninfile('multilingue='.$multilingue);
		if($multilingue==1)
		{
			//si deja multilingue
			//on change juste le nom du champ dans la tables specifs de trad
			if(isMultilingue($old_field_name,$temp_table_def)==1)
			{
				$StrSQL = "
        ALTER TABLE 
           `"._CONST_BO_PREFIX_TABLE_TRAD.$table_name."` 
         CHANGE 
                `".$old_field_name."` `".ereg_replace(" ","",$new_field_name)."` ".$array_type[$new_media_field_type]."
          ";
          
          
			}
			else
			{
				//vÈrifie l'existance d'une table de trad associÈ ‡ ce formulaire
				if(!mysql_table_existe(_CONST_BO_PREFIX_TABLE_TRAD.$table_name))
				{
					// crÈation de la table de trad
					// champs de base : 
					//	- id_auto 
					//	- clef etrangËre vers l'id de la table courante
					//	- id_langue (clef etrangere sur table langue)
					
					$sql_create_trad = "CREATE TABLE `"._CONST_BO_PREFIX_TABLE_TRAD.$table_name."` (`id_trad_".$table_name."` ".$datatype_key." AUTO_INCREMENT,`id__".$table_name."` int(11) unsigned,`id__langue` int(11) unsigned, PRIMARY KEY(`id_trad_".$table_name."`)) ENGINE=MyISAM ";
					mysql_query($sql_create_trad);
				}
				//sinon on l'aoute dans la table de trad
				$table_name=_CONST_BO_PREFIX_TABLE_TRAD.$table_name;
				$StrSQL="ALTER TABLE `".$table_name."` ADD `".ereg_replace(" ","",$new_field_name)."` ".$array_type[$new_media_field_type];
			}
			mysql_query($StrSQL);
			
			
			//gestion du champ multilingue dans _lib_champs
			$StrSQL="SELECT * FROM _lib_champs WHERE field='".$old_field_name."' AND id__table_def=".$temp_table_def;
			if( isMultiLingue($old_field_name,$temp_table_def)==1)
			{
				$StrSQL = "UPDATE _lib_champs SET multilingue=1,field='".$new_field_name."' WHERE field='".$old_field_name."' AND id__table_def=".$temp_table_def;
			}
			else
				$StrSQL = "INSERT INTO _lib_champs values('','".$new_field_name."','','','','',".$temp_table_def.",1)";

			mysql_query($StrSQL);
		}
		else//multilingue non selectionnÈ
		{
			//si on a dÈchochÈ multilingue on supprime toutes les valeurs 
			//du champs dans les tables specifs trad
			if(isMultilingue($old_field_name,$temp_table_def)==1)
			{
				mysql_query("ALTER TABLE `"._CONST_BO_PREFIX_TABLE_TRAD.$table_name."` DROP `".$old_field_name."`");

				//*** si plus aucun champ de traduction dans la table, on la supprime
				//*** Cela Èvite d'avoir ‡ supprimer des tables ‡ la main en cas d'erreur
				//*** et d'avoir un tas de table de traduction vide ‡ terme
				$rsfields=mysql_list_fields($BaseName,_CONST_BO_PREFIX_TABLE_TRAD.$table_name);
				$nbfiels=(mysql_num_fields($rsfields));
				//*** s'il ne reste que les 3 champs de base (id,idlangue,id table mere)
				if($nbfiels==3)
					mysql_query("DROP TABLE `"._CONST_BO_PREFIX_TABLE_TRAD.$table_name."`");
			
				$StrSQL = "UPDATE _lib_champs SET multilingue=0,field='".$new_field_name."' WHERE field='".$old_field_name."' AND id__table_def=".$temp_table_def;
				mysql_query($StrSQL);
			}
		}
    //echo get_sql_format($StrSQL);

	$nouv_type = $array_type[$new_media_field_type];
	$array_type = array_flip($array_type);
	
	// maj du moteur de recherche
//	$obj_champ_recherche = new Champ_recherche();
//	$obj_champ_recherche->remove_champ($table_name."/".$old_field_name);
//	$obj_champ_recherche->add_champ($table_name."/".$new_field_name);
//	$obj_champ_recherche->maj_bdd();
	
	
	// maj du champ uploadpath pour les fichiers binaires
	if (($type==$datatype_file) && ($nouv_type!=$datatype_file))
	{
		$rs_def = @mysql_query("SELECT upload_path from "._CONST_BO_CODE_NAME."table_def where cur_table_name='".$table_name."'");
		$nb_def = mysql_num_rows($rs_def);
		
		if ($nb_def!=0)
		{
			$temp_chemin = mysql_result($rs_def,0,"upload_path");
			
			$pos = strpos ($temp_chemin,$table_name);
			$taille = strlen($table_name);
			if (strpos($temp_chemin,";"))
				{ $pos = $pos + $taille + 2; }
			else 
				{ $pos = $pos + $taille + 1; }
			$maj = substr($temp_chemin,$pos);
				
			$rs_maj_def = @mysql_query("update "._CONST_BO_CODE_NAME."table_def set upload_path='".$maj."' where cur_table_name='".$table_name."'");

		if ($nb_def!=0)
		{
			$temp_chemin = mysql_result($rs_def,0,"upload_path");
			if ($temp_chemin!="")
				{ $temp_chemin = $temp_chemin.";"._CONST_BO_BINARY_UPLOAD.$table_name."/"; }
			else
				{ $temp_chemin = $temp_chemin._CONST_BO_BINARY_UPLOAD.$table_name."/"; }
			
			$rs_maj_def = @mysql_query("update "._CONST_BO_CODE_NAME."table_def set upload_path='".$temp_chemin."' where cur_table_name='".$table_name."'");
		}

		}
	}
	
	if (($type!=$datatype_file) && ($nouv_type==$datatype_file))
	{ 
		$rs_def = @mysql_query("select upload_path from "._CONST_BO_CODE_NAME."table_def where cur_table_name='".$table_name."'");
		$nb_def = mysql_num_rows($rs_def);
		
		if ($nb_def!=0)
		{
			$temp_chemin = mysql_result($rs_def,0,"upload_path");
			if ($temp_chemin!="")
				{ $temp_chemin = $temp_chemin.";"._CONST_BO_BINARY_UPLOAD.$table_name."/"; }
			else
				{ $temp_chemin = $temp_chemin._CONST_BO_BINARY_UPLOAD.$table_name."/"; }
			
			$rs_maj_def = @mysql_query("update "._CONST_BO_CODE_NAME."table_def set upload_path='".$temp_chemin."' where cur_table_name='".$table_name."'");
		}
			
	}
}

//Ajout d'un nouveau champ
if ($_REQUEST['NF'] == 1) {


	$array_type_temp = array_flip($array_type);
	if (array_search($new_media_field_type,$array_type_temp)) {
		$type = $array_type[$new_media_field_type];
	}
	unset($array_type_temp);

	//CLEF ETRANGERES
	if ($type==$datatype_key || $type==$datatype_multikey) {
		$new_media_field_name = "id_".$new_media_field_name;
		$new_media_field_name = $new_media_field_name.get_suffix_table_annexe($table_name, $new_media_field_name);
	}
	
	// maj du champ uploadpath pour les fichiers binaires
	if ($type==$datatype_file) { 
			$rs_def = @mysql_query("select upload_path from "._CONST_BO_CODE_NAME."table_def where cur_table_name='".$table_name."'");
			$nb_def = mysql_num_rows($rs_def);
			
			if ($nb_def!=0)
			{
				$temp_chemin = mysql_result($rs_def,0,"upload_path");
				if ($temp_chemin!="")
					{ $temp_chemin = $temp_chemin.";"._CONST_BO_BINARY_UPLOAD.$table_name."/"; }
				else
					{ $temp_chemin = $temp_chemin._CONST_BO_BINARY_UPLOAD.$table_name."/"; }
				
				$rs_maj_def = @mysql_query("update "._CONST_BO_CODE_NAME."table_def set upload_path='".$temp_chemin."' where cur_table_name='".$table_name."'");
			}
			
	 }

	//GESTION DU TYPE DE DONNEE ARBORESCENCE
	 if ($type==$datatype_arbo) {
		$new_media_field_name = $datatype_arbo;
		$type= $datatype_key;
	 }
	
    //LIST DATA
    if ($type==$datatype_list_data) {
        $new_media_field_name .=  $field_list_data;
        $new_media_att_require = 0;
    }
    
    //GETION DU TYPE DE DONNEE DATE AUTOMATIQUE
	$type = test_date_format($type);

	if (($type==$datatype_date_auto || $type==$datatype_datetime_auto) && eregi("_AUTO",$new_media_field_type)) {
		$new_media_field_name .= "_auto";
	}

	//GESTION DU TYPE ORDRE
	if ($type==$datatype_order) {
		$new_media_field_name = $datatype_order_name;
	}

	//On suffixe le nom du champ pour fixer l'attribut 
	//obligatoire de la saisie du champ
	 if ($new_media_att_require==1 && !eregi("id_"._CONST_BO_TABLE_PREFIX2,$new_media_field_name)) {
		 if (!eregi(_CONST_BO_REQUIRE_SUFFIX."$",$new_media_field_name)) {
			$new_media_field_name .= _CONST_BO_REQUIRE_SUFFIX;
		 }
	 }
	 else {
		$new_media_field_name = eregi_replace(_CONST_BO_REQUIRE_SUFFIX."$","",$new_media_field_name);
	 }


	$StrSQL="ALTER TABLE `".$table_name."` ADD `".ereg_replace(" ","",$new_media_field_name)."` ".$type;
	mysql_query($StrSQL);
	//echo $StrSQL;

	//---------------MVA-06/09/2007---------------//
	//------------- SPECIF HOMAIR V2008-----------//
	//-----------GESTION DE LA TRADUCTION --------//
	
	// CHAMPS MULTILINGUES
	if($new_media_multilingue==1)
	{
			//vÈrifie l'existance d'une table de trad associÈ ‡ ce formulaire
			if(!mysql_table_existe(_CONST_BO_PREFIX_TABLE_TRAD.$table_name))
			{
				// crÈation de la table de trad
				// champs de base : 
				//	- id_auto 
				//	- clef etrangËre vers l'id de la table courante
				//	- id_langue (clef etrangere sur table langue)
				
				$sql_create_trad = "CREATE TABLE `"._CONST_BO_PREFIX_TABLE_TRAD.$table_name."` (`id_trad_".$table_name."` ".$datatype_key." AUTO_INCREMENT,`id__".$table_name."` int(11) unsigned,`id__langue` int(11) unsigned, PRIMARY KEY(`id_trad_".$table_name."`)) ENGINE=MyISAM ";
				mysql_query($sql_create_trad);
			}
			
			// type de champ diffÈrent suivant type 
			// de contenu ‡ traduire (short, long etc...)
			$table_name=_CONST_BO_PREFIX_TABLE_TRAD.$table_name;
			// insertion du champ ‡ traduire
			$StrSQL="ALTER TABLE `".$table_name."` ADD `".ereg_replace(" ","",$new_media_field_name)."` ".$type;
				mysql_query($StrSQL);
			
			//insertion entrÈe dans la table _lib_champs pour MULTILINGUES
			$StrSQL="INSERT INTO _lib_champs values('','".$new_media_field_name."','','','','',".$temp_table_def.",1)";
			
			mysql_query($StrSQL);	
	}

	//echo $StrSQL;
	redirect(NomFichier($_SERVER['PHP_SELF'],0)."?media_select=".$media_select);
}

//Modification d'un template
if ($_REQUEST['MOD_TEMP']==1) {
	$template = ereg_replace("'","",$template);	
	$StrSQL = "update "._CONST_BO_CODE_NAME."dic_data set template='".$template."' where id_"._CONST_BO_CODE_NAME."dic_data=".$_REQUEST['id_bo_dic_data'];
	
	mysql_query($StrSQL);
}

//Affichage de la liste des media deja existants
?>
<script language="javascript">
var BLOQUE;

BLOQUE = 0;
function change_liste(valeur) {
	<? 
	$array_type_temp = array_flip($array_type);
	?>
	var new_media_multilingue = getElementByIdOrName('new_media_multilingue');
 	new_media_multilingue.disabled=false;
 	
 	var liste_tables = getElementByIdOrName('liste_tables');
 	var list_data = getElementByIdOrName('list_data');
 	
            document.all["list_data"].style.display="none";
	if ( 
               valeur=="<?=$array_type_temp[$datatype_key]?>" 
            || valeur=="<?=$array_type_temp[$datatype_multikey]?>" 
            || valeur=="<?=$array_type_temp[$datatype_arbo]?>" 
            || valeur=="<?=$array_type_temp[$datatype_order]?>"
            || valeur=="<?=$array_type_temp[$datatype_list_data]?>"
    ) {
	
		new_media_multilingue.disabled=true;
    list_data.style.display="none";
    liste_tables.style.display="none";
    
		//ARBO && ORDRE
		if (valeur=="<?=$array_type_temp[$datatype_arbo]?>" || valeur=="<?=$array_type_temp[$datatype_order]?>"){

            if (valeur=="<?=$array_type_temp[$datatype_order]?>") {
              mon_type = "<?=$datatype_order_name?>";
            }
            else {
              mon_type = "<?=$datatype_arbo?>";
            }
            document.form_new_media_field.new_media_field_name.value = mon_type;
            //document.form_new_media_field.table_annexe.value = "";
            document.form_new_media_field.new_media_field_name.style.color="gray";
            document.form_new_media_field.new_media_field_name.readonly=true;

            BLOQUE = 1;

		}
        //LISTES DE DONNEES
        else if (valeur=="<?=$array_type_temp[$datatype_list_data]?>") {
            list_data.style.display="block";
            liste_tables.style.display="none";
            //document.form_new_media_field.new_media_field_name.value = "";
            document.form_new_media_field.field_table_annexe.value = "";
            document.form_new_media_field.field_list_data.value = "";
            document.form_new_media_field.new_media_field_name.style.color="black";
            document.form_new_media_field.new_media_field_name.readonly=false;

            BLOQUE = 0;
        }
		//LISTE DEROULANTES
		//LISTE DEROULANTES A CHOIX MULTIPLE
		else {
            liste_tables.style.display="block";
            list_data.style.display="none";
            document.form_new_media_field.new_media_field_name.value = "";
            document.form_new_media_field.field_table_annexe.value = "";
            document.form_new_media_field.field_list_data.value = "";
            document.form_new_media_field.new_media_field_name.style.color="gray";
            document.form_new_media_field.new_media_field_name.readonly=true;

            BLOQUE = 1;
		}


		//alert("IF");
	}
	else {
		new_media_multilingue.disabled=false;
		list_data.style.display     = "none";
    	liste_tables.style.display="none";
		document.form_new_media_field.new_media_field_name.style.color="black";
		//document.form_new_media_field.new_media_field_name.value = "";
		BLOQUE = 0;
		//alert("ELSE");
	}
}

function choose_table(name)
{
	document.form_new_media_field.new_media_field_name.value = eval("document.form_new_media_field."+name+".value");
}


function empechechar()
{
 if (BLOQUE==1)
 { event.returnValue=false; }
}

function supprimer(x)
{
 if (x==1)
 { temp = "document.form_delete_table.submit()";
   lib = "une table"; }
 
 if (x==2)
 { temp = "form_delete_table_annexe.submit()";
   lib = "une table annexe"; }
 
 if (confirm("Attention, vous √™tes sur le point de supprimer "+lib+".\nConfirmez vous ce choix ?"))
 { eval(temp); }
}
function voir_template()
{
 if (document.all["visu_template"].style.display=="block")
 	{ document.all["visu_template"].style.display="none"; }
 else
 	{ document.all["visu_template"].style.display="block"; }
}

function voir_table_annexe()
{
 if (document.all["voir_table_annexe"].style.display=="block")
 	{ document.all["voir_table_annexe"].style.display="none"; }
 else
 	{ document.all["voir_table_annexe"].style.display="block"; }
}

function visu_template()
{
 window.open("visu_template.php","popup","toolbar=no,directories=no,menubar=no,scrollbars=yes,resizable=yes,width=415,height=450");
}
</script>

<table cellspacing="3" border="0">
  <tr valign="middle"> 
    <td width="107">Tables annexes :&nbsp;&nbsp;</td>
    <td width="176"><a href="javascript:voir_table_annexe();"><img src="images/icones/icone_ed1.gif" border="0" alt="Table annexes"></a></td>
    <td width="214">&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr valign="middle"> 
    <form name="form_new_media" method="post" action="<?=NomFichier($_SERVER['PHP_SELF'],0)?>?N=1">
      <td>Nouvelle table : </td>
      <td><input type="text" name="media_name" id="media_name" class="InputText">
        &nbsp;<a href="javascript:document.form_new_media.submit()">Ok</a> </td>
    </form>
    <form name='form_media_select' method='post' action='<?=NomFichier($_SERVER['PHP_SELF'],0)?>'>
      <td align="right">S&eacute;lectionnez une table : </td>
      <td><select class='InputText' name='media_select' id='media_select' onchange='javascript:document.form_media_select.submit()'>
          <?
/*
	$RstTable = mysql_query("Select * from "._CONST_BO_CODE_NAME."dic_data order by type desc, libelle");
	for ($i=0 ; $i < @mysql_num_rows($RstTable) ; $i++) {
		if (@mysql_result($RstTable,$i, "nom_table")) { // !ereg("bo",@mysql_result($RstTable,$i, "nom_table")) &&
			
			if (empty($table_name)) {
				$table_name		= @mysql_result($RstTable,$i, "nom_table");
				$table_alias	= @mysql_result($RstTable,$i, "libelle");
			}
			
			if (@mysql_result($RstTable,$i, "nom_table")==$media_select) {
				$selected		= "selected";
				$table_name		= @mysql_result($RstTable,$i, "nom_table");
				$table_alias	= @mysql_result($RstTable,$i, "libelle");
			}
			else {
				$selected="";
			}

			echo "<option value='".@mysql_result($RstTable,$i, "nom_table")."' ".$selected.">".@mysql_result($RstTable,$i, "libelle")."</option>";
		}
	}
*/
          	$temp_media 	= display_bo_organised_tables_options( $media_select );
          	$table_name		= $temp_media ['name'];
          	$table_alias	= $temp_media ['alias'];
          	echo ( $temp_media ['display'] );

?>
        </select> </td>
    </form>
    <form name='form_delete_table' method='post' action='<?=NomFichier($_SERVER['PHP_SELF'],0)?>?DT=1'>
      <td><input type='hidden' name='delete_table' id='delete_table'  value='<?=$table_name?>'> &nbsp;<a href='javascript:supprimer(1);'>Supprimer</a></td>
    </form>
  </tr>
  <tr valign="middle" style="display:none" id="voir_table_annexe"> 
    <form name="form_new_table_annexe" method="post" action="<?=NomFichier($_SERVER['PHP_SELF'],0)?>?NEW_A=1">
      <td>Tables annexe :</td>
      <td><input type="text" name="table_annexe_name" id="table_annexe_name" class="InputText">
        &nbsp;<a href="javascript:document.form_new_table_annexe.submit()">Ok</a></td>
    </form>
    <td align="right">Selectionnez une table annexe : </td>
    <form name='form_delete_table_annexe' method='post' action='<?=NomFichier($_SERVER['PHP_SELF'],0)?>?SUPP_A=1'>
      <td><select class='InputText' name="delete_table_annnexe">
          <?
	$RstTable = mysql_query("Select * from "._CONST_BO_CODE_NAME."dic_data where type=1 order by type desc, libelle");
	for ($i=0 ; $i < @mysql_num_rows($RstTable) ; $i++) {
			echo "<option value='".@mysql_tablename($RstTable, $i,"nom_table")."'>".@mysql_tablename($RstTable, $i,"libelle")."</option>";
		}
	?>
        </select> </td>
      <td>&nbsp;<a href='javascript:supprimer(2);'>Supprimer</a></td>
    </form>
  </tr>
</table>
<hr>
<?
//Selection dans la liste deroulante par defaut
if (empty($media_select)) {
	$media_select = $table_name;
}

//Affichage du nom du media en cours
if ($show_new_line==1 || $media_select) {
?><h2>
<b>Table : 
<?=$table_alias?>
</b></h1><br>
Nouveau champ:<br>
<table width="100%" border="0">
<tr>
<td>
<table <?=$WidthTableType?> border="<?=$TableBorder?>" cellspacing="<?=$TableCellspacing?>" cellpadding="<?=$TableCellpadding?>" bgcolor="<?=$TableBgColor?>">
  <form name="form_new_media_field" method="post" action="<?=NomFichier($_SERVER['PHP_SELF'],0)?>?NF=1&table_name=<?=$table_name?>">
  <tr> 
    <th>Nom</th>
    <th>Type</th>
    <th>Obligatoire</th>
    <th>Multilingue</th>
    <th>&nbsp;</th>
  </tr>
  <? 
		if ($fond_cellule == $TdBgColor1) {
			$fond_cellule = $TdBgColor2;
 		}
		else {
			$fond_cellule = $TdBgColor1;
		}
?>
    <tr> 
      <td><input type="text" name="new_media_field_name" id="new_media_field_name" class="InputText" onKeyPress="empechechar();"></td>
      <td> 
        <?=fn_create_type_list()?>
      </td>
      <td align="center"> 
        <input type="checkbox" name="new_media_att_require" value="1">
      </td>
      <td align="center">
      	<input type="checkbox" name="new_media_multilingue" value="1"></td>
      <td><input type="hidden" name="media_select" id="media_select" value="<?=$table_name?>"> <a href="javascript:if (document.form_new_media_field.new_media_field_name.value!=''){document.form_new_media_field.submit();}" class="LienLight">cr&eacute;er</a></td>
    </tr>
</table>
</td>
<td id="liste_tables" width="100%" style="display:none">
<table <?=$WidthTableType?> border="<?=$TableBorder?>" cellspacing="<?=$TableCellspacing?>" cellpadding="<?=$TableCellpadding?>" bgcolor="<?=$TableBgColor?>">
	<tr><th>S√©lectionnez une table annexes : </th></tr>
	<tr bgcolor="<?=$TdBgColor2?>"><td align="center">
	<select name="field_table_annexe" class='InputText' onchange="choose_table(this.name);">
	<option value="">&gt;S√©lectionnez une table&lt;</option>
<?	
	  $str_table = "
					select *
					from "._CONST_BO_CODE_NAME."dic_data
					order by type desc, libelle
					";
					//where type not in(0)
	  $rst_table = mysql_query($str_table);
	  
	for ($i=0 ; $i < @mysql_num_rows($rst_table) ; $i++) {
		echo("<option value=\"".@mysql_result($rst_table, $i,"nom_table")."\">".@mysql_result($rst_table, $i,"libelle")."</option>");
	} ?>
	</select></td></tr>
</table>
</td>
<td id="list_data" width="100%" style="display:none">
<table <?=$WidthTableType?> border="<?=$TableBorder?>" cellspacing="<?=$TableCellspacing?>" cellpadding="<?=$TableCellpadding?>" bgcolor="<?=$TableBgColor?>">
	<tr><th>S√©lectionnez une table de donn√©es : </th></tr>
	<tr bgcolor="<?=$TdBgColor2?>"><td align="center">

        <?=get_data_list()?>
</td></tr>
</table>
</td>

</form>
</tr>
</table>
<br>
<br>
D√©tail de la table : 
<form name="form_update_field" method="post" action="<?=NomFichier($PHP_SELF,0)?>?UF=1&media_select=<?=$media_select?>&Action=1&table_name=<?=$table_name?>">
<table <?=$WidthTableType?> border="<?=$TableBorder?>" cellspacing="<?=$TableCellspacing?>" cellpadding="<?=$TableCellpadding?>" bgcolor="<?=$TableBgColor?>">
<?
$result = mysql_query("show fields from ".$media_select);
$nb_cols = @mysql_num_fields($result);
?>
  <tr> 
    <?
	$array_titre_col = array("Nom","Type","Obligatoire","Multilingue","Tag_template","Modifier","Supprimer");
$table_def=getIdTableDef($media_select);

for ($k=0; $k<7; $k++) {
	$fieldname =	@mysql_field_name($result, $k);
	$fieldtype =	@mysql_field_type($result, $k);
	$fieldlen  =	@mysql_field_len($result, $k);
	$tablename =	@mysql_field_table($result, $k);
?>
    <th> 
      <?=$array_titre_col[$k]?>
    </th>
    <? 
}
?>
  </tr>
  <? 

//On commence a deux pour masquer les champs de gestion de la table
$cpt = 1;
for ($i=1 ; $i<@mysql_num_rows($result) ; $i++) {
	if ($fond_cellule == $TdBgColor1) {
		$fond_cellule = $TdBgColor2;
	}
	else {
		$fond_cellule = $TdBgColor1;
	}

	?>
  <tr bgcolor="<?=$fond_cellule?>"> 
	<?
	for ($k=0;  $k<7; $k++) {
		
		$value = @mysql_result($result, $i ,@mysql_field_name($result, $k));
		
		$attribut  = "";
		
		
		//Liste des type de champs en mode modif
		if ($k==1 && $_REQUEST['UF']==1 &&  $_REQUEST['F']==@mysql_result($result, $i ,@mysql_field_name($result, 0))) {
			
            //LIST DATA
            if ($datatype_list_data == @mysql_result($result, $i ,@mysql_field_name($result, $k))) {

                $data_list_name = split("_",@mysql_result($result, $i ,@mysql_field_name($result, 0)));
                $data_list_name_id = $data_list_name[count($data_list_name)-1];

                $value = get_data_list($data_list_name_id)."<input type='hidden' name='new_media_field_type' id='new_media_field_type' value='LIST_DATA'><input type='checkbox' title='Changer le type' name='change_type_to_text' value='1' onClick=\"document.form_update_field.submit()\">";
                $value .= "<input type='hidden' name='UF' id='UF' value='".$_REQUEST['UF']."'>";
                $value .= "<input type='hidden' name='type' id='type' value='".$type."'>";
                //$value .= "<input type='hidden' name='Action' value='0'>";
                $value .= "<input type='hidden' name='table_name' id='table_name' value='".$table_name."'>";
                $value .= "<input type='hidden' name='F' id='F' value='".$_REQUEST['F']."'>";


            }
            //LISTE DES TYPES
            else {
                $value = fn_create_type_list($type, @mysql_result($result, $i ,@mysql_field_name($result, 0)));
            }

		}
		//Liste des champs en mode modif, mais pas le champ selectionne
		elseif ($k==1 && $_REQUEST['UF']==1) {
			$value = get_datatype_libelle($value, @mysql_result($result, $i ,@mysql_field_name($result, 0)));
		}
		//Liste des type de donnees
		elseif (array_search($value,$array_type)) {
			$value = get_datatype_libelle($value, @mysql_result($result, $i ,@mysql_field_name($result, 0)));
			
		}
		
	
		//Affiche le champ text pour la modification du nom du champ
		elseif ($_REQUEST['UF']==1 && $value == $_REQUEST['F'] && $Action!=1) {
            //LIST DATA
            if ($datatype_list_data == @mysql_result($result, $i ,@mysql_field_name($result, 1))) {
                $value_decomp = split("_", $value);
                $pop = array_pop($value_decomp);
                $value_new = join("_",$value_decomp);
                if (!is_numeric($pop)) {
                    $value_new  = $value;
                }

                $value_old = $value;
            }
            else {
                $value_new = $value;
                $value_old = $value;
            }
			$value= "<input type='text' name='new_field_name' id='new_field_name' class='InputText' value='".$value_new."'><input type='hidden' name='old_field_name' id='old_field_name' class='InputText' value='".$value_old."'>";
		}

		//Mode VAlidation de la modification en cours
		if ($k==5 && $_REQUEST['UF']==1 && $_REQUEST['F'] == @mysql_result($result, $i ,@mysql_field_name($result, 0))) {
			$value = "<input type=\"hidden\" name=\"type\" id=\"type\" value=\"".@mysql_result($result, $i ,@mysql_field_name($result, 1))."\"><a href='javascript:form_update_field.submit();'>Ok</a>";
			$attribut  = "colspan='2' align='center'";
		}


		//Gestion des cases a cocher pour gerer l'aspect obligatoire des champs
		//Mode Modif
		if ($k==2 && $Action!=1 && $_REQUEST['F'] == @mysql_result($result, $i ,@mysql_field_name($result, 0)) && $_REQUEST['UF']==1) {
			if (eregi(_CONST_BO_REQUIRE_SUFFIX."$",@mysql_result($result, $i ,@mysql_field_name($result, 0))) && $_REQUEST['UF']==1) {
				$value = "<input type=\"checkbox\" name=\"required\" id=\"required\" value=\"1\" checked>";
			}
			elseif (!eregi(_CONST_BO_REQUIRE_SUFFIX."$",@mysql_result($result, $i ,@mysql_field_name($result, 0))) && $_REQUEST['UF']==1) {
				$value = "<input type=\"checkbox\" name=\"required\" id=\"required\" value=\"1\">";
			}
			$attribut  = "align='center'";
		}
		//Gestion des cases a cocher pour gerer l'aspect obligatoire des champs
		//Mode normal
		elseif ($k==2) {
			if (eregi(_CONST_BO_REQUIRE_SUFFIX."$",@mysql_result($result, $i ,@mysql_field_name($result, 0)))) {
				$value = "<input type=\"checkbox\" name=\"required\" id=\"required\" disabled checked>";
			}
			elseif (!eregi(_CONST_BO_REQUIRE_SUFFIX."$",@mysql_result($result, $i ,@mysql_field_name($result, 0)))) {
				$value = "<input type=\"checkbox\" name=\"required\" id=\"required\" disabled>";
			}
			$attribut  = "align='center'";
		}
		//Gestion des cases a cocher pour gerer l'aspect multilingue des champs
		//Mode Modif
		elseif ($k==3 && $Action!=1 && $F == @mysql_result($result, $i ,@mysql_field_name($result, 0)) && $UF==1) {
			if (isMultilingue(@mysql_result($result, $i),$table_def)==1) {
				$value = "<input type=\"checkbox\" name=\"multilingue\" value=\"1\" checked>";
			}
			else{
				$value = "<input type=\"checkbox\" name=\"multilingue\" value=\"1\">";
			}
			$attribut  = "align='center'";
		}
		
		//Gestion des cases a cocher pour gerer l'aspect multilingue des champs
		//Mode normal
		elseif ($k==3) {
			if (isMultilingue(@mysql_result($result, $i),$table_def)==1) {
				$value = "<input type=\"checkbox\" name=\"multilingue\" disabled checked>";
			}
			else{
				$value = "<input type=\"checkbox\" name=\"multilingue\" disabled>";
			}
			$attribut  = "align='center'";
		}
	
		//Mode Template
		elseif ($k==4 && $i>0) {
			$value = htmlentities(Template_left_delimiter)."TAG_".@mysql_result($result, $i ,@mysql_field_name($result, 0)).htmlentities(Template_right_delimiter);
			$attribut  = "align='left'";
			$cpt++;
		}
		//Mode Modification
		elseif ( $k==5 && $i>0 && $_REQUEST['F'] != @mysql_result($result, $i ,@mysql_field_name($result, 0))) {
			$value="<a href='".NomFichier($_SERVER['PHP_SELF'],0)."?UF=1&media_select=".$media_select."&table_name=".$table_name."&F=".@mysql_result($result, $i ,@mysql_field_name($result, 0))."&type=".@mysql_result($result, $i ,@mysql_field_name($result, 1))."'>Modifier</a>";

			//Si il s'agit d'une liste deroulante,
			//On interdit la modification
			if (eregi("id_"._CONST_BO_TABLE_PREFIX2,@mysql_result($result, $i ,@mysql_field_name($result, 0)))) {
				$value = "";
			}
			elseif (eregi("id_"._CONST_BO_TABLE_DATA_PREFIX2,@mysql_result($result, $i ,@mysql_field_name($result, 0)))) {
				$value = "";
			}
			elseif (eregi("id_",@mysql_result($result, $i ,@mysql_field_name($result, 0)))) {
				$value = "";
			}
			$attribut  = "align='center'";
		}
		//Mode Suppression
		elseif ($k==6 && $i>0 && $_REQUEST['F'] != @mysql_result($result, $i ,@mysql_field_name($result, 0))) {
			$value="<a href='".NomFichier($_SERVER['PHP_SELF'],0)."?DF=1&media_select=".$media_select."&table_name=".$table_name."&F=".@mysql_result($result, $i ,@mysql_field_name($result, 0))."&type=".@mysql_result($result, $i ,@mysql_field_name($result, 1))."'>Supprimer</a>";
 			$attribut  = "align='center'";
		}

	
		//Gestion de l'affichage du nom des champs
		$value = eregi_replace("^id_"._CONST_BO_TABLE_PREFIX,"",$value);
		$value = eregi_replace(_CONST_BO_REQUIRE_SUFFIX."$","",$value);
		$value = ($value);


		if ($attribut) {
			?>
			<td <?=$attribut?>> 
			<?=$value?>
			</td>
			<?
		}
		elseif (!($k==6 &&  $_REQUEST['F'] == @mysql_result($result, $i ,@mysql_field_name($result, 0)))) {
			if ($k!=5) {?>
			<td>
			<?=$value?>
			</td>
			<?
		}
			
		}
		
		
	}		
	?>
  </tr>
  <? 
}
?>
</table>
<br>
</form>

<?
	$chaine = "select * from "._CONST_BO_CODE_NAME."dic_data where nom_table='".$media_select."' order by type desc, libelle";
	$rs_template = mysql_query($chaine);
?>

<table border="0">

<form name="form_update_template" method="post" action="<?=NomFichier($_SERVER['PHP_SELF'],0)?>?MOD_TEMP=1">
<tr>
<td nowrap>Modifier le template : </td>
<td><a href="javascript:voir_template();"><img border="0" src="images/icones/icone_ed1.gif" alt="Modifier le template"></a></td>
<td width="100%">&nbsp;&nbsp;<a href="javascript:visu_template();"><img border="0" src="images/icones/icone_view.gif" alt="Voir le template"></a></td>
</tr>
<tr id="visu_template" style="display:none">
<td>&nbsp;</td>
<td colspan="2"><textarea cols="50" rows="10" name="template"><?=@mysql_result($rs_template,0,"template");?></textarea>
&nbsp;<a href="javascript:document.form_update_template.submit();">Modifier</a>
</td>
<input type="hidden" name="id_bo_dic_data" id="id_bo_dic_data" value="<?=@mysql_result($rs_template,0,"id_"._CONST_BO_CODE_NAME."dic_data");?>">
<input type="hidden" name="media_select" id="media_select" value="<?=$media_select?>">
</tr>
</form>
</table>
<?
}

//Afiche une liste deroulante de tous les types de donnees
//Date : mercredi 2 octobre 2002
function fn_create_type_list($type="", $field_name="") {

	global $array_type, $array_type_libelle, $datatype_date, $datatype_datetime;

	$list = "";
	$array_type_libelle_temp = $array_type_libelle;

	//Si on est en mode modif on cache la liste deroulante et choix multiple
	if ($type) {
		array_pop($array_type_libelle_temp);
		array_pop($array_type_libelle_temp);
	}

	$list .= "<select class='InputText' name='new_media_field_type' id='new_media_field_type' onchange='change_liste(this.value);'>";
	
	$array_type_temp = array_flip($array_type);

	$i=0;
	$s=0;
	//Gestion de la pre slesction dans la liste
	foreach ($array_type_libelle as $key => $value) {

		if ($array_type[$key] == $type && $s==0) {
			if ($type==$datatype_date) {
				if ((ereg("_auto$",$field_name) && ereg("_AUTO$",$key))) {
					$selected="selected";
					$s = 1;
				}
				elseif (!ereg("_auto$",$field_name) && $s==0) {
					$selected="selected";
					$s = 1;
				}
			}
			elseif ($type==$datatype_datetime && $s==0) {
				if ((ereg("_auto$",$field_name) && ereg("_AUTO$",$key))) {
					$selected="selected";
					$s = 1;
				}
				elseif (!ereg("_auto$",$field_name)) {
					$selected="selected";
					$s = 1;
				}
			}
			else {
				$s = 1;
				$selected="selected";
			}
		}
		else {
			$selected="";
		}


		$list .= "<option ".$selected." value='".$key."'>".$value."</option>";
	}

	$list .= "</select>";

	unset($array_type_libelle_temp);

	return $list;
}

//Retourne le bon type de date
//vendredi 13 d√©cembre 2002
function test_date_format($type) {
	
	global $new_media_field_type, $datatype_date, $datatype_datetime;

	if (empty($type)) {
		if (eregi("^".$datatype_date."$",$new_media_field_type)) {
			return($datatype_date);
		}
		elseif (eregi("^".$datatype_datetime."$",$new_media_field_type)) {
			return($datatype_datetime);
		}
	}
	else {
		return($type);
	}
}


//Retourne le nom du format du type passe en parametre
//vendredi 13 d√©cembre 2002
function get_datatype_libelle($type, $field_name) {
	
	global $array_type, $array_type_libelle, $datatype_date, $datatype_datetime;

	$array_tmp = array_flip($array_type);

	if (ereg($datatype_date,$type) || ereg($datatype_datetime,$type)) {
		if ($type==$datatype_date) {
			if (ereg("_auto$", $field_name)) {
				$return = $array_type_libelle["DATE_AUTO"];
			}
			else {
				$return = $array_type_libelle["DATE"];
			}
		}
		elseif  ($type==$datatype_datetime) {
			if (ereg("_auto$", $field_name)) {
				$return = $array_type_libelle["DATETIME_AUTO"];
			}
			else {
				$return = $array_type_libelle["DATETIME"];
			}
		}
	}
	else {
		if (empty($array_tmp[$type])) {
			$type_temp = $array_type[$type];
		}
		else {
			$type_temp = $array_tmp[$type];
		}
		$return = $array_type_libelle[$type_temp];
	}

	unset($array_tmp);

	return($return);
}

function get_data_list($default="") {

        $str_table = "
                select *
                from "._CONST_BO_CODE_NAME."list_data
                order by "._CONST_BO_CODE_NAME."list_data
                ";


        $rst_table = mysql_query($str_table);
        $value = "<select class='InputText' name='field_list_data'>";

        for ($indice=0 ; $indice < @mysql_num_rows($rst_table) ; $indice++) {
            if ($default == @mysql_result($rst_table, $indice,"id_"._CONST_BO_CODE_NAME."list_data")) {
                $selected = "selected";
            }
            else {
                $selected = "";
            }
            $value .= "<option value=\"_".@mysql_result($rst_table, $indice,"id_"._CONST_BO_CODE_NAME."list_data")."\" ".$selected.">".@mysql_result($rst_table, $indice,_CONST_BO_CODE_NAME."list_data")."</option>";
        }

        $value .= "</select>";

        return $value;
}

?>
