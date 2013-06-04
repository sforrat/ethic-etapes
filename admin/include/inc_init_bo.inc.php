<? 
if (isset ($_REQUEST['SessionClose']))
deconnection($_REQUEST['SessionClose']);
connection();//Connection a la base de données

//session_start();



if(!isset($Home)){
$Home = "";
}
if (isset($_REQUEST['Home']))
	$Home = $_REQUEST['Home'];
	

if(!isset($idItem)){
$idItem = "";
}
if (isset($_REQUEST['idItem']))
	$idItem = $_REQUEST['idItem'];


if(!isset($TableDef)){
$TableDef = "";
}
if (isset($_REQUEST['TableDef']))
	$TableDef = $_REQUEST['TableDef'];


if(!isset($ID)){
$ID  = "";
}
if (isset($_REQUEST['ID']))
	$ID = $_REQUEST['ID'];


if(!isset($object_wkf)){
$object_wkf = "";
}
if (isset($_REQUEST['object_wkf']))
	$object_wkf = $_REQUEST['object_wkf'];
	

if(!isset($idObj)){
$idObj = "";
}
if (isset($_REQUEST['idObj']))
	$idObj = $_REQUEST['idObj'];
	
if(!isset($init_portfolio)){
$init_portfolio = "";
}
if (isset($_REQUEST['init_portfolio']))
	$init_portfolio = $_REQUEST['init_portfolio'];

if(!isset($DisplayMode)){
$DisplayMode = "";
}
if (isset($_REQUEST['DisplayMode']))
	$DisplayMode = $_REQUEST['DisplayMode'];

if(!isset($Debug)){
$Debug = "";
}
if (isset($_REQUEST['Debug']))
	$Debug = $_REQUEST['Debug'];


if(!isset($punaise_value)){
$punaise_value ="";
}
if (isset($_REQUEST['punaise_value']))
	$punaise_value = $_REQUEST['punaise_value'];


if(!isset($DeleteDatabase)){
$DeleteDatabase = "";
}
if (isset($_REQUEST['DeleteDatabase']))
	$DeleteDatabase = $_REQUEST['DeleteDatabase'];


if(!isset($empty_current_table)){
$empty_current_table="";
}
if (isset($_REQUEST['empty_current_table']))
	$empty_current_table = $_REQUEST['empty_current_table'];


if(!isset($Dump)){
$Dump = "";
}
if (isset($_REQUEST['Dump']))
	$Dump = $_REQUEST['Dump'];


if(!isset($exp)){
$exp = "";
}
if (isset($_REQUEST['exp']))
	$exp = $_REQUEST['exp'];

if(!isset($mode)){
$mode = "";
}
if (isset($_REQUEST['mode']))
	$mode = $_REQUEST['mode'];


if(!isset($methode)){
$methode = "";
}
if (isset($_REQUEST['methode']))
	$methode = $_REQUEST['methode'];
	

if(!isset($Search)){
$Search = "";
}
if (isset($_REQUEST['Search']))
	$Search = $_REQUEST['Search'];
	

if(!isset($viewTask)){
$viewTask = "";	
}
if (isset($_REQUEST['viewTask']))
	$viewTask = $_REQUEST['viewTask'];


if(!isset($ShowFields)){
$ShowFields="";
}
if (isset($_REQUEST['ShowFields']))
	$ShowFields = $_REQUEST['ShowFields'];
	

if(!isset($ShowAllRec)){
$ShowAllRec = "";	
}
if (isset($_REQUEST['ShowAllRec']))
	$ShowAllRec = $_REQUEST['ShowAllRec'];
	
if(!isset($AscDesc)){
$AscDesc = "";
}
if (isset($_REQUEST['AscDesc']))
	$AscDesc = $_REQUEST['AscDesc'];
	

if(!isset($Page)){
$Page = "";
}
if (isset($_REQUEST['Page']))
	$Page = $_REQUEST['Page'];
		
if(!isset($ordre)){
$ordre	="";
}
if (isset($_REQUEST['ordre']))
	$ordre = $_REQUEST['ordre'];
	
if(!isset($DisplayMenu)){
$DisplayMenu="";
}
if (isset($_REQUEST['DisplayMenu']))
	$DisplayMenu = $_REQUEST['DisplayMenu'];

if(!isset($Filters)){
$Filters = "";
}
if (isset($_REQUEST['Filters']))
	$Filters = $_REQUEST['Filters'];


if(!isset($formMain_selection)){
$formMain_selection ="";
}
if (isset($_REQUEST['formMain_selection']))
	$formMain_selection = $_REQUEST['formMain_selection'];
	

if(!isset($target)){
$target ="";
}
if (isset($_REQUEST['target']))
	$target = $_REQUEST['target'];
		
	
if(!isset($TableDefModif)){
	$TableDefModif = "";
}
if (isset($_REQUEST['TableDefModif']))
	$TableDefModif = $_REQUEST['TableDefModif'];
	
if(!isset($TableSelect)){
	$TableSelect = "";
}
if (isset($_REQUEST['TableSelect']))
	$TableSelect = $_REQUEST['TableSelect'];	
	
//Form d'edition de formulaire
if(!isset($Form_titre_rubrique_array)){
	$Form_titre_rubrique_array = "";
}
if (isset($_REQUEST['Form_titre_rubrique_array']))
	$Form_titre_rubrique_array = $_REQUEST['Form_titre_rubrique_array'];	

if(!isset($Form_titre_bouton_array)){
	$Form_titre_bouton_array = "";
}
if (isset($_REQUEST['Form_titre_bouton_array']))
	$Form_titre_bouton_array = $_REQUEST['Form_titre_bouton_array'];	
	
if(!isset($Form_item)){
	$Form_item = "";
}
if (isset($_REQUEST['Form_item']))
	$Form_item = $_REQUEST['Form_item'];	
	
if(!isset($Form_titre_col)){
	$Form_titre_col = "";
}
if (isset($_REQUEST['Form_titre_col']))
	$Form_titre_col = $_REQUEST['Form_titre_col'];	
	
if(!isset($Form_mode_col)){
	$Form_mode_col = "";
}
if (isset($_REQUEST['Form_mode_col']))
	$Form_mode_col = $_REQUEST['Form_mode_col'];	
	
if(!isset($Form_upload_path)){
	$Form_upload_path = "";
}
if (isset($_REQUEST['Form_upload_path']))
	$Form_upload_path = $_REQUEST['Form_upload_path'];	
	
if(!isset($Form_cur_table_name)){
	$Form_cur_table_name = "";
}
if (isset($_REQUEST['Form_cur_table_name']))
	$Form_cur_table_name = $_REQUEST['Form_cur_table_name'];	
	
if(!isset($Form_id_bo_menu)){
	$Form_id_bo_menu = "";
}
if (isset($_REQUEST['Form_id_bo_menu']))
	$Form_id_bo_menu = $_REQUEST['Form_id_bo_menu'];	


if(!isset($Form_menu_title)){
	$Form_menu_title = "";
}
if (isset($_REQUEST['Form_menu_title']))
	$Form_menu_title = $_REQUEST['Form_menu_title'];	

	
if(!isset($Form_ordre_menu)){
	$Form_ordre_menu = "";
}
if (isset($_REQUEST['Form_ordre_menu']))
	$Form_ordre_menu = $_REQUEST['Form_ordre_menu'];

if(!isset($SelecDerouleForm)){
	$SelecDerouleForm = "";
}
if (isset($_REQUEST['SelecDerouleForm']))
	$SelecDerouleForm = $_REQUEST['SelecDerouleForm'];

if(!isset($nb_mode))
{
	$nb_mode= "";
}

if (isset($_REQUEST['nb_mode']))
{
	$nb_mode= $_REQUEST['nb_mode'];
	
	for ($i=0 ; $i < $nb_mode ; $i++) 
	{	
		if(!isset(${"mode_".$i}))
		{
			${"mode_".$i}= "";
		}
		else 
		{
			${"mode_".$i} = $_REQUEST["mode_".$i];
		}
	}
}
	
$object_type = 0;
$id_bo_object="";
$tab_selec_deroulante = "";

//Redirection sur la page des taches en cours
if ($Home == 1) {
    redirect(NomFichier($_SERVER['PHP_SELF'], 0)."?TableDef=3&viewTask=1");
}



//----------------------------------------
//--------------ITEM DE NAVIGATION
//----------------------------------------
    //On recupere les id peres de l'element de navigation courant
    $navID = get_bo_item_pere($idItem);
    array_pop($navID);
    $navID = array_reverse($navID);
    $navID[] = $idItem;

    //foreach ( $navID as $v) {
    //    echo $v."-";
    //}

//----------------------------------------
//----------------BO TABLE DEF
//----------------------------------------

	//Selection des information du formulaire selectionne
	/*
	$StrSQL =	"
				SELECT
                        "._CONST_BO_CODE_NAME."profil.*,
                        "._CONST_BO_CODE_NAME."table_def.*,
                        "._CONST_BO_CODE_NAME."menu."._CONST_BO_CODE_NAME."menu
				FROM  
                        "._CONST_BO_CODE_NAME."table_def, "._CONST_BO_CODE_NAME."profil,
                        "._CONST_BO_CODE_NAME."menu 
				WHERE 
                        id_"._CONST_BO_CODE_NAME."table_def = ".$TableDef." 
				AND   
                        "._CONST_BO_CODE_NAME."profil.id_"._CONST_BO_CODE_NAME."profil = "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil
				AND   
                        "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu = "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."menu
				";
	*/
	
	$StrSQL =	"
				SELECT
                        "._CONST_BO_CODE_NAME."table_def.*,
                        "._CONST_BO_CODE_NAME."menu."._CONST_BO_CODE_NAME."menu
				FROM  
                        "._CONST_BO_CODE_NAME."table_def, "._CONST_BO_CODE_NAME."profil,
                        "._CONST_BO_CODE_NAME."menu 
				WHERE 
                        id_"._CONST_BO_CODE_NAME."table_def = ".$TableDef." 
				AND   
                        "._CONST_BO_CODE_NAME."menu.id_"._CONST_BO_CODE_NAME."menu = "._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."menu
				LIMIT 1";

				
	$RstBoTableDef	= mysql_query($StrSQL);

	//On verifie si la structure de formulaire selectionné est authorisé pour l'utilisateur
	$ItemMenuProfilId			= @mysql_result($RstBoTableDef,0,""._CONST_BO_CODE_NAME."table_def.id_"._CONST_BO_CODE_NAME."profil");

	$array_id_profil_allowed = split(",",$ItemMenuProfilId);

	// Le user n'est pas autoriser a voir le formulaire selectionné
	if ($TableDef && $TableDef!=2 && $TableDef!=3 && !(in_array($_SESSION['ses_profil_user'],$array_id_profil_allowed))  && $_SESSION['ses_profil_user'] !=1 && $DisplayMode!="PopUp") 
	{
	?>
	<script>
	<!--
		alert('DÃ©solÃ©,\nVos droits actuels sur l\'application ne vous autorisent pas Ã  effectuer cette action.\nVeuillez contacter votre administrateur.');		
		window.location.href="<? echo _CONST_APPLI_URL."admin/";?>";
	//-->
	</script>
	<?
	   // et on arrete le script pour être sur qu'il ne se termine pas
	   exit();	
	}

	//Verification des variables user
	if (NomFichier($_SERVER['PHP_SELF'],0) != "index.php") {
		LoginBack($_SESSION['ses_user']);
	}

	//Selection de l'affichage de la liste
	$SelectListe			= @mysql_result($RstBoTableDef,0,"select_liste")." ";
	$Alias					= @split(";",@mysql_result($RstBoTableDef,0,"alias"));
	$SelectModifAjout		= @mysql_result($RstBoTableDef,0,"select_modif_ajout")." ";
	$SelectUpdateInsert		= @mysql_result($RstBoTableDef,0,"select_update_insert")." ";
	//Clause from de la requete SQL
	$SQLBody			= @mysql_result($RstBoTableDef,0,"sql_body")." ";
	//Intitulés des differentes dossiers
	$TitreRubriqueArray		= @split(";",GetTxtFromHtml(utf8_decode (@mysql_result($RstBoTableDef,0,"titre_rubrique_array"))));
	$TitreRubriqueArray		= array_map ("htmlentities",$TitreRubriqueArray );
	//Intitulés des differents boutons
	$TitreBoutonArray		= @split(";",GetTxtFromHtml(utf8_decode(@mysql_result($RstBoTableDef,0,"titre_bouton_array"))));
	$TitreBoutonArray		= array_map ("htmlentities",$TitreBoutonArray );
	//item concerné
	$item				= @mysql_result($RstBoTableDef,0,"item");
	//tri sur clef etrangere
	$champ_selection		= @mysql_result($RstBoTableDef,0,"champ_selection");
	//champ affiche de la clef etrangere
	$tab_selec_deroulante 		= split(";",@mysql_result($RstBoTableDef,0,"deroulante_selection"));
	
	//Intitulés des colonnes supplementaires
	if (@mysql_result($RstBoTableDef,0,"titre_col")) {
		$TitreCol				= @split(";",@mysql_result($RstBoTableDef,0,"titre_col"));
	}
	else {
		$TitreCol = array();
	}
	//Action des colonnes supplementaires
	if (@mysql_result($RstBoTableDef,0,"mode_col")) {
		$ModeCol				= @split(";",@mysql_result($RstBoTableDef,0,"mode_col"));
	}
	else {
		$ModeCol = array();
	}


	//Path des images à uploader
	if ($RstBoTableDef && str_replace(" ","",mysql_result($RstBoTableDef,0,"upload_path"))!="") 
	{
	   $UploadPath = split(";",mysql_result($RstBoTableDef,0,"upload_path"));

	   //-------------------------------------------------------------------------------------------
	   // LAC : 12/11 : 
	   // on remplace les liens d'upload relatif par les liens physiques absolus sur le serveur
	   for ($t=0;$t<count($UploadPath);$t++)
	   {
	      if ( eregi("../images/upload",$UploadPath[$t]))
	      {
	         $UploadPath[$t] = eregi_replace("../images/upload/",_CONST_BO_BINARY_UPLOAD,$UploadPath[$t]);
				}
	   }
	 
	   //print_r($UploadPath);
	   
	   // FIN
	   //-------------------------------------------------------------------------------------------
	}
	else 
	{
		$UploadPath = array();
	}

	//Titre la rubrique de la page
	$PageTitre				= @mysql_result($RstBoTableDef,0,""._CONST_BO_CODE_NAME."menu."._CONST_BO_CODE_NAME."menu");

	//Liste des fichier popup assossie au table etrangeres
	if (@mysql_result($RstBoTableDef,0,"popup_id")) {
		$PoPupId			= @split(";",@mysql_result($RstBoTableDef,0,"popup_id"));
	}
	else {
		$PoPupId = array();
	}

	//
	$CurrentPageTitle		= @mysql_result($RstBoTableDef,0,"menu_title");
	$MenuCurrentItemTitle	= @mysql_result($RstBoTableDef,0,""._CONST_BO_CODE_NAME."menu");


	//Evenement

	$SQLBeforeInsert		= @mysql_result($RstBoTableDef,0,"sql_before_insert");
	$SQLAfterInsert			= @mysql_result($RstBoTableDef,0,"sql_after_insert");
		
	$SQLBeforeUpdate		= @mysql_result($RstBoTableDef,0,"sql_before_update");
	$SQLAfterUpdate			= @mysql_result($RstBoTableDef,0,"sql_after_update");

	$SQLBeforeDelete		= @mysql_result($RstBoTableDef,0,"sql_before_delete");
	$SQLAfterDelete			= @mysql_result($RstBoTableDef,0,"sql_after_delete");



	//Moteur de recherche interne au formaulaire
	$SearchEngine			= @mysql_result($RstBoTableDef,0,"search_engine");

	//Activation des filtres interne au formulaire
	$EnabledFilter			= @mysql_result($RstBoTableDef,0,"enable_filter");

	//Activation Les tris sur les colonnes des listings
	$EnableListingOrder	= @mysql_result($RstBoTableDef,0,"enable_listing_order");




	//On recupere le nombre maximum de ligne que l'on pourra créer pour le formulaire
	$LineMax			= @mysql_result($RstBoTableDef,0,"line_max");

	$CurrentTableName	= @mysql_result($RstBoTableDef,0,"cur_table_name");


	$tab_selec_deroulante_field = array();
	
	$rst_field_table = mysql_query("Show columns from ".$CurrentTableName);
	
	for ($i_field_table = 0; $i_field_table< mysql_numrows($rst_field_table); $i_field_table++)
	{
		$tab_selec_deroulante_field[mysql_result($rst_field_table, $i_field_table,0 )] = $tab_selec_deroulante[$i_field_table];
	}


	$show_id			= @mysql_result($RstBoTableDef,0,"show_id");
	


//----------------------------------------
//----------------BO USER    -------------
//----------------------------------------

    $str_user = "
            SELECT 
                    "._CONST_BO_CODE_NAME."user.id_"._CONST_BO_CODE_NAME."nav,
                    "._CONST_BO_CODE_NAME."user.portfolio_access_16
            FROM   
                    "._CONST_BO_CODE_NAME."user  
            WHERE  
                    "._CONST_BO_CODE_NAME."user.id_"._CONST_BO_CODE_NAME."user = ".$_SESSION['ses_id_bo_user']." 
            ";

    //echo get_sql_format($str_user);

    $rst_user	            = @mysql_query($str_user);

    $arr_user_right_rub    = @mysql_result($rst_user,0,_CONST_BO_CODE_NAME."user.id_"._CONST_BO_CODE_NAME."nav");
    $arr_user_nav_right    = @split(",",$arr_user_right_rub);
    $user_portfolio_type   = @mysql_result($rst_user,0,_CONST_BO_CODE_NAME."user.portfolio_access_16");


//----------------------------------------
//----------------BO PROFIL    -------------
//----------------------------------------

    $str_profil = "
            SELECT 
                    "._CONST_BO_CODE_NAME."profil.* 
            FROM 
                    "._CONST_BO_CODE_NAME."profil 
            WHERE 
                    "._CONST_BO_CODE_NAME."profil.id_"._CONST_BO_CODE_NAME."profil = ".$_SESSION['ses_profil_user']." 
            ";

    //echo get_sql_format($str_profil);

    $rst_profil            = @mysql_query($str_profil);

    //Liste des etats visible par le profil dans sa liste de tache !
    $profil_list_wf_state_allow_in_task    = @mysql_result($rst_profil,0,_CONST_BO_CODE_NAME."profil.id_"._CONST_BO_CODE_NAME."workflow_state");


//----------------------------------------
//----------------BO DIC DATA-------------
//----------------------------------------

	//On récupère le type d'objet
	$StrSQLType =	"
				Select type, id_"._CONST_BO_CODE_NAME."workflow, libelle
				from "._CONST_BO_CODE_NAME."dic_data 
				where id_"._CONST_BO_CODE_NAME."table_def = ".$TableDef."
				";

	$RstType	    = @mysql_query($StrSQLType);

	if ( $RstType && mysql_num_rows($RstType) ==1 )
	{
        	$object_type    = mysql_result($RstType,0,0);
        	$object_wkf     = mysql_result($RstType,0,1);
        	$object_libelle = mysql_result($RstType,0,2);
        	
        	if ($object_libelle =="") $object_libelle = $item;        	
        	
	   	//echo(get_sql_format($StrSQLType)."<br>Type:$object_type, WF :$object_wkf");
	}

//----------------------------------------
//----------------BO OBJECT COMMON--------
//----------------------------------------

    if (empty($_REQUEST['idObj'])) {
        $StrFindObj = "
                SELECT  
                        id_"._CONST_BO_CODE_NAME."object 
                FROM    
                        "._CONST_BO_CODE_NAME."object 
                WHERE   
                        id_"._CONST_BO_CODE_NAME."table_def = ".$TableDef." 
                AND     
                        item_table_ref_req=".$_REQUEST['ID']."
                ";
        //echo $StrFindObj;
        $RstObj = mysql_query($StrFindObj);
        
        if (@mysql_result($RstObj,0,$id_bo_object)) {
            $idObj = @mysql_result($RstObj,0,$id_bo_object);
        }
        else {
            unset($idObj);
            $idObj = "";
        }

    }

    //On récupère le type d'objet
    $StrSQLObj  =	"
                    Select name_req, ordre, description, date_create_auto, date_update_auto, id_"._CONST_BO_CODE_NAME."nav, id_"._CONST_BO_CODE_NAME."table_def, id_"._CONST_BO_CODE_NAME."workflow_state, id_"._CONST_BO_CODE_NAME."langue, id_"._CONST_BO_CODE_NAME."user, id_"._CONST_BO_CODE_NAME."user_autor, id_"._CONST_BO_CODE_NAME."object_source
                    from "._CONST_BO_CODE_NAME."object 
                    where id_"._CONST_BO_CODE_NAME."object = ".$idObj."
                ";
    $RstObj	    = mysql_query($StrSQLObj);


//----------------------------------------
//----------------BO WORKFLOW-------------
//----------------------------------------

    // LAC : 24/02/2004 : on rebascule l'objet en etat wf par défaut en mode duplication => il doit refaire toute la chaine
    if (( $RstObj && mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."workflow_state"))&&($_REQUEST['methode']!="duplicate")){
        $wks = mysql_result($RstObj,0,"id_"._CONST_BO_CODE_NAME."workflow_state");
        $StrSQLWks  =	"
                    Select id_"._CONST_BO_CODE_NAME."workflow_state, "._CONST_BO_CODE_NAME."workflow_state
                    from "._CONST_BO_CODE_NAME."workflow_state 
                    where id_"._CONST_BO_CODE_NAME."workflow_state = ".$wks."
                    AND id_"._CONST_BO_CODE_NAME."workflow_1 = ".$object_wkf."
				";        
    }else{//recherche de l'id de l'état par defaut
        $StrSQLWks  =	"
                    Select id_"._CONST_BO_CODE_NAME."workflow_state, "._CONST_BO_CODE_NAME."workflow_state
                    from "._CONST_BO_CODE_NAME."workflow_state 
                    where defaut = 1
                    AND id_"._CONST_BO_CODE_NAME."workflow_1 = ".$object_wkf."
				";
    }
    $RstWks	    = mysql_query($StrSQLWks);
    $wks_id = @mysql_result($RstWks,0,"id_"._CONST_BO_CODE_NAME."workflow_state");
    if ($wks_id){
        $StrSQLWkt  =	"
                        SELECT "._CONST_BO_CODE_NAME."workflow_trans, "._CONST_BO_CODE_NAME."workflow_state, "._CONST_BO_CODE_NAME."workflow_trans.id_"._CONST_BO_CODE_NAME."workflow_state_1, "._CONST_BO_CODE_NAME."workflow_trans.id_"._CONST_BO_CODE_NAME."workflow_state
                        FROM "._CONST_BO_CODE_NAME."workflow_trans, "._CONST_BO_CODE_NAME."workflow_state
                        WHERE "._CONST_BO_CODE_NAME."workflow_state.id_"._CONST_BO_CODE_NAME."workflow_state = "._CONST_BO_CODE_NAME."workflow_trans.id_"._CONST_BO_CODE_NAME."workflow_state_1
                        AND "._CONST_BO_CODE_NAME."workflow_trans.id_"._CONST_BO_CODE_NAME."workflow_state = ".$wks_id."

                        AND
                            (
                                    "._CONST_BO_CODE_NAME."workflow_trans.id_"._CONST_BO_CODE_NAME."profil = '".$_SESSION['ses_profil_user']."'
                            OR  
                                    "._CONST_BO_CODE_NAME."workflow_trans.id_"._CONST_BO_CODE_NAME."profil like ('".$_SESSION['ses_profil_user'].",%')
                            OR
                                    "._CONST_BO_CODE_NAME."workflow_trans.id_"._CONST_BO_CODE_NAME."profil like ('%,".$_SESSION['ses_profil_user']."')
                            OR  
                                    "._CONST_BO_CODE_NAME."workflow_trans.id_"._CONST_BO_CODE_NAME."profil like ('%,".$_SESSION['ses_profil_user'].",%')
                            )
                    ";
        $RstWkt	    = mysql_query($StrSQLWkt);
    }
		if (isset($RstWkt))
    $nb_trans = mysql_num_rows($RstWkt);
    else
    	$nb_trans = 0;
    

    if ($nb_trans<1 && $object_type==3 && $object_wkf!=1) {
        $workflow_allow = 0;
        $input_allow = "disabled";
    }
    else {
        $workflow_allow = 1;
        $input_allow = "";
    }

//----------------------------------------
//----------------BO PARAM
//----------------------------------------

	$StrSQLInit = "
					Select * 
					from "._CONST_BO_CODE_NAME."param 
					where selected=1
					";

	$RstBoInit = mysql_query($StrSQLInit);

	//Affichage de la date par defaut
	$DefaultDate		= @mysql_result($RstBoInit,0,"defaul_tdate");//"__/__/____";

	//Retour
	$Retour				= @mysql_result($RstBoInit,0,"retour");//"Annuler";

	//Largeur des champs
	$FieldWidthSize		= @mysql_result($RstBoInit,0,"field_width_size");//40;
	$FieldHeightSize	= @mysql_result($RstBoInit,0,"field_height_size");//5;

	//Nombre de caractères maximum à afficher dans las champs dans le listing
	$NbMaxCar			= @mysql_result($RstBoInit,0,"nb_max_car");//50;

	//Taille du tableau pour l'affichage de la liste : none (taille calculée en fonction du nombre de colonne du tableau
	//Si $WidthType="none" : inneficasse | sinon : % ou px
	$WidthType			= @mysql_result($RstBoInit,0,"width_type");//"none";
	$WidthTable			= @mysql_result($RstBoInit,0,"width_table");//720;

	//Nombre de ligne affichées par page dans les listes
	define("_NB_ENR_PAGE", @mysql_result($RstBoInit,0,"nb_enr_page"), 1); //29/08/2001

	//Nombre de liens total vers les pages
	define("_NB_PAGE_TOT", @mysql_result($RstBoInit,0,"nb_page_tot"), 1); //29/08/2001

	//Format des dates
	$DateFormat			= @mysql_result($RstBoInit,0,"date_format");


	//Image de tris Haut et Bas
	$ImgTriAsc			= @mysql_result($RstBoInit,0,"img_tri_asc");//"trisbas.gif";
	$ImgTriDesc			= @mysql_result($RstBoInit,0,"img_tri_desc");//"trishaut.gif";

	if ($ImgTriAsc) {
		$ImgTriAsc = "<img src=\"images/options/".$ImgTriAsc."\" border=\"0\">&nbsp;&nbsp;&nbsp;";
	}
	if ($ImgTriDesc) {
		$ImgTriDesc = "<img src=\"images/options/".$ImgTriDesc."\" border=\"0\">&nbsp;&nbsp;&nbsp;";
	}

	//Image de case a cochée
	//	$ImgCheckBoxOn = "btcocheron.gif";
	$ImgCheckBoxOn		= @mysql_result($RstBoInit,0,"img_check_box_on");
	//	$ImgCheckBoxOff = "btcocheroff.gif";
	$ImgCheckBoxOff		= @mysql_result($RstBoInit,0,"img_check_box_off");

	if ($ImgCheckBoxOn) {
		$ImgCheckBoxOn = "<img src=\"images/options/".$ImgCheckBoxOn."\" border=\"0\">";
	}
	else {
		$ImgCheckBoxOn = "<b>Oui</b>";
	}
	if ($ImgCheckBoxOff) {
		$ImgCheckBoxOff = "<img src=\"images/options/".$ImgCheckBoxOff."\" border=\"0\">";
	}
	else {
		$ImgCheckBoxOff = "<font size =\"1\">Non</font>";
	}


	//Type de fichiers image acceptés et affiché dans le back office
		//28/08/2001	$ImgAcceptExt = array("jpg","gif","jpeg");
	$ImgAcceptExt = split(";", @mysql_result($RstBoInit,0,"img_accep_text"));

	//Titre à droite de la case a cocher pour la suppression des image en mode modif
	$NoPictureTitle		= @mysql_result($RstBoInit,0,"no_picture_title");//"Supprimer";


	//Affichage des option en mode pop-up
	if ($DisplayMode!="PopUp") {
		//Affichage des option en mode pop-up
		$DisplayMode		= @mysql_result($RstBoInit,0,"display_mode");//"OptionOn";
	}

	if (@mysql_result($RstBoInit,0,"display_mode")=="optionon") {
		if ($DisplayMode!="PopUp") {
				$ItemListerTitle = "Lister/Modifier";
		}
	}
	else {
		if ($DisplayMode!="PopUp") {
				$ItemListerTitle = "Lister";
		}
	}

	//Gestion du mode DebugMode
	$debug_mode			= @mysql_result($RstBoInit,0,"debug_mode");
	$silent_debug_mode		= @mysql_result($RstBoInit,0,"silent_debug_mode"); // ecrit les infos de debug dans un fichier texte dans /dump/sql/query




//----------------------------------------
//----------------BO STYLE
//----------------------------------------


	$StrSQLStyle = "
					Select * 
					from "._CONST_BO_CODE_NAME."style 
					where selected=1
					";
	$RstBoStyle = mysql_query($StrSQLStyle);	

	$StyleName  				= @mysql_result($RstBoStyle,0,"style_name");
    //Affichage du tableau pour le listing
	$TableBgColor				= @mysql_result($RstBoStyle,0,"table_bgcolor");
	$TableEnTeteGgColor			= @mysql_result($RstBoStyle,0,"table_entete_bgcolor");
	$TableBorder				= @mysql_result($RstBoStyle,0,"table_border_10");
	$TableCellspacing			= @mysql_result($RstBoStyle,0,"table_cellspacing_10");
	$TableCellpadding			= @mysql_result($RstBoStyle,0,"table_cellpadding_10");
	//Couleur de fond des cellules
	$TdBgColor1					= @mysql_result($RstBoStyle,0,"td_bgcolor_1");
	$TdBgColor2					= @mysql_result($RstBoStyle,0,"td_bgcolor_2");

	//Menu
	$MenuBgColor				= @mysql_result($RstBoStyle,0,"menu_bgcolor");
	$MenuTableBgColor			= @mysql_result($RstBoStyle,0,"menu_table_bgcolor");

	//Images du BO
	$ImgLogo					= @mysql_result($RstBoStyle,0,"img_logo");
	$ImgBandeauHautRight		= @mysql_result($RstBoStyle,0,"img_bandeau_haut_right");
	$ImgFond					= @mysql_result($RstBoStyle,0,"img_fond");

	$ImgLogoInfo				= @getimagesize("images/skins/".$ImgLogo);
	$ImgBandeauHautRightInfo	= @getimagesize("images/skins/".$ImgBandeauHautRight);


	//$MainFontColor			= @mysql_result($RstBoStyle,0,"main_fontcolor");
	$FontSize					= @mysql_result($RstBoStyle,0,"font_size_11");
	//$FontWeight				= @mysql_result($RstBoStyle,0,"font_weight");
	$FontType					= @mysql_result($RstBoStyle,0,"font_type");
	//$TextDecoration			= @mysql_result($RstBoStyle,0,"text_decoration");
	//$ActiveItemTextDecoration	= @mysql_result($RstBoStyle,0,"active_item_text_decoration");
	$ActiveItemColor			= @mysql_result($RstBoStyle,0,"active_item_color");
	$ActiveItemColorLight		= @mysql_result($RstBoStyle,0,"active_item_color_light");
	//$ActiveItemFontWeight		= @mysql_result($RstBoStyle,0,"active_item_font_weight");
	//$TitleFontSize			= @mysql_result($RstBoStyle,0,"title_font_size_11");
	//$BorderColor				= @mysql_result($RstBoStyle,0,"border_color");
	$BackgroundColor			= @mysql_result($RstBoStyle,0,"background_color");
	$MenuFontColor				= @mysql_result($RstBoStyle,0,"menu_font_color");
	$MenuBgColor				= @mysql_result($RstBoStyle,0,"menu_bgcolor");
	$MainFontColor				= @mysql_result($RstBoStyle,0,"main_font_color");



//----------------------------------------
//----------------PORTFOLIO
//----------------------------------------

// MODIF LAC 16/01 : suppression init du portfolio dans toutes les pages..
// uniquement dans les formulaires 
//if (isset($TableDef)&&($TableDef!=3))
// init_portfolio sert à forcer l'init dans les pages qui ne sont pas des tabledef
// par exemple le text rich (portfolio.php)
if ((isset($_REQUEST['mode']))||($init_portfolio==1))
{

    $str_portfolio_img = "
                            SELECT 
                                    *
                            FROM
                                    portfolio_img
    ";

    $rst_portfolio_img = mysql_query($str_portfolio_img);

    echo "<script>";
    echo "function JS_get_portfolio_img_path(id) {\n";

    $arr_id_img_portfolio   = array();
    $arr_name_img_portfolio = array();

    for ($pfj=0; $pfj<@mysql_num_rows($rst_portfolio_img) ; $pfj++) {

        $id_portfolio_img       = @mysql_result($rst_portfolio_img,$pfj,0);
        $portfolio_img_name     = @mysql_result($rst_portfolio_img,$pfj,2);

        $extension = split("\.",$portfolio_img_name);
        $extension = strtolower($extension[count($extension)-1]);

        $arr_id_img_portfolio[]     = $id_portfolio_img;

        if (in_array($extension, $ImgAcceptExt)) {
            $arr_name_img_portfolio[]   = $portfolio_img_name;
        }
        else {
            $arr_name_img_portfolio[]   = get_ext_file_picto($portfolio_img_name);
        }


    }

    echo "tab_img_id      = new Array(\"".join("\",\"",$arr_id_img_portfolio)."\");\n";
    echo "tab_img_name    = new Array(\"".join("\",\"",$arr_name_img_portfolio)."\");\n";

    echo "
        for (j=0; j<tab_img_id.length;j++) {
            if ((tab_img_id[j]==id)) {
                return(tab_img_name[j]);
            }
        }
        ";
    
    echo "}\n";
    echo "</script>";


    echo "<script>";
    echo "function JS_get_portfolio_img_type(id) {\n";

    $arr_id_img_portfolio   = array();
    $arr_name_img_type      = array();

    for ($pfj=0; $pfj<@mysql_num_rows($rst_portfolio_img) ; $pfj++) {

        $id_portfolio_img       = @mysql_result($rst_portfolio_img,$pfj,0);
        $arr_name_img_name      = @mysql_result($rst_portfolio_img,$pfj,2);

        $extension = split("\.",$arr_name_img_name);
        $extension = strtolower($extension[count($extension)-1]);

        $arr_id_img_portfolio[]     = $id_portfolio_img;

        if (in_array($extension, $ImgAcceptExt)) {
            $arr_name_img_type[]        = "img";
        }
        else {
            $arr_name_img_type[]        = $arr_name_img_name;
        }

    }

    echo "tab_img_id      = new Array(\"".join("\",\"",$arr_id_img_portfolio)."\");\n";
    echo "tab_img_type    = new Array(\"".join("\",\"",$arr_name_img_type)."\");\n";

    echo "
        for (j=0; j<tab_img_id.length;j++) {
            if ((tab_img_id[j]==id)) {
                return(tab_img_type[j]);
            }
        }
        ";
    
    echo "}\n";
    echo "</script>";
}


//----------------------------------------
//----------------TRAITEMENTS DIVERS
//----------------------------------------


	//--------------
	//Insertion dans la table de stats
	StatsBo($_SESSION['ses_id_bo_user'],$_SERVER['HTTP_USER_AGENT'],$TableDef,$_SERVER['QUERY_STRING'],$_SERVER['PHP_SELF']);
	//--------------
	
	//--------------
	//Pour le calul du temps d'execution de la page
	//--------------
	$time_start = getmicrotime();


	//--------------
	//Gestion du mode Debug
	//--------------
	if ($Debug!="") {
		if ($Debug == 1) {
			mysql_query("UPDATE "._CONST_BO_CODE_NAME."param SET debug_mode='".$Debug."' where selected=1");
			$Debug = 0;
		}
		else { //($Debug == 0) {
			mysql_query("UPDATE "._CONST_BO_CODE_NAME."param SET debug_mode='".$Debug."' where selected=1");
			$Debug = 1;
		}
		$debug_mode = abs($Debug-1);
	}
	else {
		$RstDebug = mysql_query("Select debug_mode from "._CONST_BO_CODE_NAME."param where selected=1");

		if (@mysql_result($RstDebug,0,"debug_mode") == 1) {
			$Debug = 0;
		}
		else {
			$Debug = 1;
		}
	}

	//--------------
	//Gestion de la punaise pour le menu de gauche
	//Date : 13/01/2003
	//Modif : 13/01/2003
	//--------------
	if ($_REQUEST['punaise_value'] != "") {
		if (!isset($_SESSION['ses_punaise_value'])) {
			$_SESSION['ses_punaise_value'] = 0;				
			$punaise_value = 0;
			}

		if ($_REQUEST['punaise_value'] == 1) {
			$_SESSION['ses_punaise_value'] = 1;
			$punaise_value = 0;
		}
		else { 
			$_SESSION['ses_punaise_value'] = 0;
			$punaise_value = 1;
		}
		$_SESSION['ses_punaise_value'] = abs($punaise_value-1);
	}
	else {
		if ($_SESSION['ses_punaise_value'] == 1) {
			$punaise_value = 0;
		}
		else {
			if (!isset($_SESSION['ses_punaise_value'])) {
				$_SESSION['ses_punaise_value'] = 0;				
				$punaise_value = 0;
			} else {
			$punaise_value = 1;
		}
	}
	}


	//--------------
	//Gestion de la suppression des données
	//--------------
	if ($DeleteDatabase == 1 && $_SESSION['ses_profil_user']==1 && $_SESSION['ses_profil_user']) {
		DeleteData($Host, $BaseName,$UserName, $UserPass);
	}

	//--------------
	//Gestion de la suppression des données de la table courante
	//--------------
	if ($empty_current_table == 1) {
		make_empty_table($CurrentTableName);
	}
	
	//Gestion de l'affichage de la colonne ID
	if ($show_id==1){
		$indice_de_depard = 0;
	}
	else {
		$indice_de_depard = 1;
	}
	
	
	
	//--------------
	//GESTION DES FILTRES SELECTIONNÉS
	//Date : 13/01/2003
	//Modif : 13/01/2003
	//--------------
	$passe=0;

	//Gestion des filtres actifs		
	if (!isset($_SESSION["ses_filter"])){
		$_SESSION["ses_filter"] = array();
	}
	
	//on recupere le nombre de colonnes
	$nb_cols = @mysql_num_fields(mysql_query($SelectListe.$SQLBody));
	for ($j=$indice_de_depard; $j<$nb_cols; $j++) {
	
		if ( isset($_REQUEST["filter_".$j]) && $_REQUEST["filter_".$j] ) {
							
			$_SESSION["ses_filter"][$j] = $_REQUEST["filter_".$j];
			
			$passe = 1;

		}
		else {
			if (isset($_SESSION["ses_filter"][$j])){
				$_SESSION["ses_filter"][$j] = $_REQUEST["filter_".$j];
			}
			else {
				$_SESSION["ses_filter"][$j] = "filter_".$j."_null";
			}
			
		}
	}

	if ($passe==0){
		$_SESSION['ses_filter'] = "";
		unset($_SESSION['ses_filter']);

	}

?>
