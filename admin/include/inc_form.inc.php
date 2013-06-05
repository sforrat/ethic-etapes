<?

//---------------------------------
//FFR -- Sauvegarde de l'url de d�part si besoin de valider et de revenir sur la fiche
$query = str_replace("nouveau","modif",$_SERVER['REQUEST_URI']);
$url = split("bo.php?",$query);
$url_retour = "bo.php".$url[1];
//---------------------------------

if ($mode=="modif" || $mode=="nouveau" || $mode=="supr" || $mode=="duplicate")
{
    if($_GET["TableDef"] == _CONST_TABLEDEF_CENTRE && $mode=="modif"){
        $_SESSION["ID"] = $_GET["ID"];
    }

    //Mode duplication
    //Date 12/02/2003
    if ($methode=="duplicate"){
        $mode = "modif";
    }


    $fieldEffect = "onFocus=\"javascript:fieldEffect(this,'#D8D8D8');\" onBlur=\"javascript:fieldEffect(this,'".$BackgroundColor."');\" onMouseOver=\"javascript:fieldEffect(this,'#D8D8D8');\" onMouseOut=\"javascript:fieldEffect(this,'".$BackgroundColor."');\"";


    //Si l'id est passe
    if ($ID)
    {
        $id = 0;
    }

    $arr_date_popup = array();

    $CtImUpload=0;	//Compteur pour l'upload des images
    $CtForKey=0;	//Compteur comptant le nombre de clef etrangere dans la table

    if( $methode == "duplicate" )
    {
        echo "<p class=\"titre\"><font color=red>Duplication</font>  > ".ucfirst(bo_strip_pre_suf($object_libelle))."</p>";
    }
    elseif ($mode=="nouveau")
    {
        echo "<p class=\"titre\">".ucfirst($TitreRubriqueArray[1])." > ".ucfirst(bo_strip_pre_suf($object_libelle))."</p>";
    }
    elseif( $mode == "modif" )
    {
        echo "<p class=\"titre\">".ucfirst($TitreRubriqueArray[2])." > ".ucfirst(bo_strip_pre_suf($object_libelle))."</p>";
    }
    elseif( $mode == "supr" )
    {
        echo "<p class=\"titre\">".ucfirst($TitreRubriqueArray[3])." > ".ucfirst(bo_strip_pre_suf($object_libelle))."</p>";
    }


    if (empty($_REQUEST['action']))  //La modif a ete valid�
    {
        if ($mode=="modif" || $mode=="supr" || $mode=="nouveau")
        {
            for ($k=0; $k<$nb_cols; $k++)
            {

                $fieldvalue =	@mysql_result($result, $id ,@mysql_field_name($result, $k));
                $fieldname =	@mysql_field_name($result, $k);
                $tablename =	@mysql_field_table($result, $k);

                if (eregi("id_".$tablename,$fieldname)) //Identifiant
                {
                    $id_item = $fieldvalue;
                }
            }

            //Chargement su style, si botabledef, le style des champs change
            if ($TableDef == 1 || $TableDef == 11)
            {
                //$FieldWidthSize = $FieldWidthSize + 80;
                $StyleChamps =  "InputTextBo";
            }
            else
            {
                $StyleChamps =  "InputText";
            }

            //Mode duplication
            //Date 12/02/2003
            if ($methode=="duplicate")
            {
                $mode = "nouveau";
            }
            ?>
            <form method="post" action="<?echo NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=$TableDef&mode=$mode&ID=$ID&id=$id_item&idObj=$idObj&target=$target&action=1&Search=$Search&Page=$Page&AscDesc=$AscDesc&ordre=$ordre&DisplayMode=$DisplayMode&DisplayMenu=$DisplayMenu&formMain_selection=$formMain_selection";?>" id="formulaire" name="formulaire" enctype="multipart/form-data">
            <?
            // LAC 24/02/2004 : on passe en champ cach� l'id de l'objet source si objet dupliqu�
            if( $methode == "duplicate" )
            {
                ?>
                <input type="hidden" name="id_obj_source" id="id_obj_source" value="<?= $_REQUEST['idObj'] ?>-<?= $_REQUEST['ID']?>">
            <?
            }
            ?>
            <table border="0" cellspacing="1" cellpadding="3">
        <?
        }

        //Mode duplication
        //Date 12/02/2003
        if ($methode=="duplicate")
        {
            $mode = "modif";
            ?>
            <input type="hidden" name="idItem" id="idItem" value="<?=$idItem?>">
            <? // pour retour sur le bon element de nav
        }

        if ($mode=="supr")  //Supression
        {
            // CONFIRMATION DE SUPPRESSION DE L'OBJET
            if ($TableDef == 3)
            {
                // on recupere le nom de l'objet � supprimer
                $strSQLlibelle = "SELECT o.id__object, o.name_req, dd.libelle FROM "._CONST_BO_CODE_NAME."object as o LEFT JOIN "._CONST_BO_CODE_NAME."dic_data as dd ON dd.nom_table = o.table_ref_req WHERE o.id_"._CONST_BO_CODE_NAME."object = ".$_REQUEST['ID'];
                //echo($strSQLlibelle);
            }
            else
            {
                $strSQLlibelle = "SELECT * FROM ".$CurrentTableName." WHERE id_".$CurrentTableName." = ".$_REQUEST['ID'];

                $strTabledef='SELECT id__table_def FROM _table_def WHERE cur_table_name  = \''.$CurrentTableName.'\'';
                $rsTableDef=mysql_query($strTabledef);
                if(isMultilingue(mysql_field_name(mysql_query($strSQLlibelle),1),mysql_result($rsTableDef,0,0)))
                {
                    //on recompose la requete pour atteindre les libelles traduis
                    $strSQLlibelle = "SELECT id_".$CurrentTableName.", t.".mysql_field_name(mysql_query($strSQLlibelle),1)." FROM ".$CurrentTableName." LEFT JOIN "._CONST_BO_PREFIX_TABLE_TRAD.$CurrentTableName." t ON id_".$CurrentTableName."=id__".$CurrentTableName." AND id__langue=".$_SESSION['ses_langue']." WHERE id_".$CurrentTableName." = ".$_REQUEST['ID'];
                }
            }

            $object_name = mysql_result(mysql_query($strSQLlibelle),0,1);
            $object_type_libelle = mysql_result(mysql_query($strSQLlibelle),0,2);

            ?>
            <input type="hidden" name="idItem" id="idItem" value="<?=$idItem?>"><?//Pour le retour sur objet?>
            <tr><td colspan="2"><?=$inc_form_supp?>"<?=$item?>" : <i>"<?= $object_name ?>"</i> ?</td></tr>
            <tr><td colspan="2"><br>			<?
                    if (isset($_REQUEST['target']) && $_REQUEST['target']){//redirection vers une page autre la page elle-meme
                        $RetourTarget = $_REQUEST['target'];
                    }
                    else {
                        $RetourTarget = NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=$TableDef&idItem=$idItem&DisplayMode=$DisplayMode&formMain_selection=".$formMain_selection;
                    }
                    ?>
                    <!--<A HREF="<?=$RetourTarget?>"><?=$Retour?></A>-->

                </td></tr>
            <?
            $TitreBouton = $TitreBoutonArray[2];//On affecte a la variable titre bouton
        }

    if ($mode=="modif" || $mode=="nouveau")
    {


        //SDE 05/02/2003
        //Inclusion des donn�es communes � tous les objets de type editorial (type=3)
        if ($object_type==3)
        {
            include "include/inc_object_common.inc.php";
        }

        //Gestion des controles javascript
        $ar_required_fields_name	= array();
        $ar_required_fields_len		= array();
        $ar_required_fields_type	= array();
        $ar_required_fields_alias	= array();

        $nbr_div = 1;
        $lng_div = "default";
        $class = "";
        echo "</table>" ;
        echo "<div>" ;
        if ($object_type==3)
        {
            $class = "onglets_ctrls_multi";


            // *** liste de s�lection de la langue
            $strLangue = "SELECT * FROM _langue ";


            //En fonction de l'utilisateur, on affiche les langues auquelles il a droit.
            if ($_SESSION['ses_profil_user']!=1)
            {
                $strLangue.= " WHERE id__langue in (".$_SESSION['ses_id_langue_user'].")";
            }

            $strLangue.= " ORDER BY _langue_by_default desc, id__langue asc";


            $rsLangues=@mysql_query($strLangue);
            $nbr_div = mysql_num_rows($rsLangues);

            ?>
            <div class="onglets_langues">
                <ul>
                    <?
                    $index_lang_selected = 0;
                    //On regarde quelle langue s�lectionner :
                    for($index=0;$index<$nbr_div && $index_lang_selected==0 ;$index++)
                    {
                        $lg_nbr=mysql_result($rsLangues,$index,"id__langue");
                        if ($lg_nbr == $_SESSION['ses_langue'])
                        {
                            $index_lang_selected = $index;
                        }
                    }


                    for($index=0;$index<$nbr_div;$index++)
                    {
                        if ($index == $index_lang_selected)
                        {
                            $classe = "active";
                        }
                        else
                        {
                            $classe = "";
                        }

                        $lg_ext=mysql_result($rsLangues,$index,"_langue_abrev");
                        $lg_nbr=mysql_result($rsLangues,$index,"id__langue");

                        ?>

                        <li id="ong_<?= $lg_ext ?>" class="<?= $classe ?>">
                            <a href="javascript:void(0);" onclick="javascript:return highlight(this, 'gabarit_<?= $lg_ext ?>');"><?= $lg_ext ?></a>
                        </li>
                    <?
                    }
                    ?>

                </ul>
            </div>
        <?

        }

        echo "<div id=\"ctrl\">" ;
    for ($div=0; $div<$nbr_div; $div++)
    {
        if ($object_type==3)
        {
            $lng_div = mysql_result($rsLangues,$div,"_langue_abrev");
        }

        if ($div == 0)
        {
            $display="block";
        }
        else
        {
            $display="none";
        }

        //style=\"display:".$display."\"
        echo "<div id=\"gabarit_".$lng_div."\" class=\"".$class."\" style='display:$display' >" ;
        echo "<table>" ;
        if ($object_type!=3){
            echo "<tr height=\"25px\">
                <td colspan=\"3\"><em><b>* champs obligatoire</b></em><br />

                  <input type=\"hidden\" id=\"url_retour\" name=\"url_retour\" value=\"".$url_retour."\">
                  <input type=\"hidden\" id=\"url_retour_2\" name=\"url_retour_2\" value=\"".$url_retour."\">
                  <input type=\"hidden\" id=\"ancreId\" name=\"ancreId\" value=\"".$ancreId."\">
                  <input type=\"hidden\" id=\"noVerif\" name=\"noVerif\" \>
                </td>
              </tr>";
        }
    for ($k=0; $k<$nb_cols; $k++)
    {

        $fieldname			=	@mysql_field_name($result_fieldname, $k);
        $fieldname_alias		=	@mysql_field_name($result, $k);
        $fieldtype			=	@mysql_field_type($result, $k);
        $fieldlen			=	@mysql_field_len($result, $k);
        $tablename			=	@mysql_field_table($result, $k);


        $fieldderoulante	=	$tab_selec_deroulante_field[$fieldname];

        $form_fieldname= "field_".@mysql_field_name($result_fieldname, $k);				//$form_fieldname= "idtable_".$k;//$fieldname;

        if ($object_type==3)
        {
            $form_fieldname = $form_fieldname."_".$lng_div;

        }
        /*
        ||
        ($fieldname == "flash_x" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE) ||
        ($fieldname == "flash_y" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE) ||
        ($fieldname == "flash_paris" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE)
        */

        //FFR mettre ici les lignes a ne pas afficher :
        if( ($fieldname == "accueil" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_ACTUALITE) ||
            ($fieldname == "id_centre_classement" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE) ||
            ($fieldname == "id_centre_classement_1" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE) ||
            ($fieldname == "accueil" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_BON_PLAN) ||
            ($fieldname == "url_hostelworld" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE) ||
            ($fieldname == "video" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_ACTUALITE) ||
            ($fieldname == "video" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE) ||
            ($fieldname == "logo" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE) ||
            ($fieldname == "paris_arrondissement" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE)||
            ($fieldname == "flash_x" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE) ||
            ($fieldname == "xiti" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE) ||
            ($fieldname == "flash_y" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE) ||
            ($fieldname == "flash_paris" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] == _CONST_TABLEDEF_CENTRE)  ||
            ($fieldname == "installations_autres") ||
            ($fieldname == "commentaire_accueil_sportifs") ||
            ($fieldname == "sports_adaptes_FFH_libelle") ||
            ($fieldname == "forfait_autre_commentaire")||
            ($fieldname == "id__langue" && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $_GET["TableDef"] != _CONST_TABLEDEF_ACTUALITE && $_GET["TableDef"] != _CONST_TABLEDEF_BON_PLAN) ||

            ($fieldname == "visuel_facebook" && $_SESSION['ses_profil_user'] != '1' && $_GET["TableDef"] == _CONST_TABLEDEF_ACTUALITE) ||
            ($fieldname == "texte_facebook" && $_SESSION['ses_profil_user'] != '1' && $_GET["TableDef"] == _CONST_TABLEDEF_ACTUALITE)

        ){
            $displayTR =  " style='display:none' ";
        }
    else{
            $displayTR="";
        }


    if ($k!=0)
    {
        $EchoDebug = "";
        $EchoDebug .= "<span style=\"font-size:10; color:red\">";
        $EchoDebug .= "<br>Fieldtype : ".$fieldtype;
        $EchoDebug .= "<br>Fieldlen : ".$fieldlen;
        $EchoDebug .= "<br>Field : ".$tablename.".".$fieldname;
        $EchoDebug .= "<br>FieldName : ".$form_fieldname;
        $EchoDebug .= "</span>";
        //							echo  $EchoDebug;
        //Affichage en mode debug
        if ($debug_mode == 1 && $_SESSION['ses_profil_user']==1)
        {
            $EchoDebug = "";
            $EchoDebug .= "<span style=\"font-size:10; color:red\">";
            $EchoDebug .= "<br>Fieldtype : ".$fieldtype;
            $EchoDebug .= "<br>Fieldlen : ".$fieldlen;
            $EchoDebug .= "<br>Field : ".$tablename.".".$fieldname;
            $EchoDebug .= "<br>FieldName : ".$form_fieldname;
            $EchoDebug .= "</span>";
        }
        else
        {
            $EchoDebug = "";
        }

        // *** RAJOUT API 03/01/05 sur les alias des champs ***
        $chaine = "select libelle, up_title, description,multilingue from "._CONST_BO_CODE_NAME."lib_champs where field='".$fieldname."' and id_"._CONST_BO_CODE_NAME."table_def=".$TableDef;

        $RSlc = mysql_query($chaine);

        $flag_spec_name = 0;
        $flag_multilingue=0;

        //            echo $form_fieldname;

        //------------------------------------------
        // -- FFR Placement des p�riode de dispo --
        if( $_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL && $form_fieldname=="field_a_partir_de"){
            include("include/inc_list_sejour_date_dispo.inc.php");
        }


        if( ( $_REQUEST["TableDef"]==_CONST_TABLEDEF_CVL) && $form_fieldname=="field_acces_vacances_scolaire"){
            include("include/inc_list_sejour_date_dispo.inc.php");
        }

        //------------------------------------------
        // -- FFR Placement du tableau Traif groupe --
        //if ( $_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE && $form_fieldname=="field_conditions"){
        //  include("specifique/sejour_tarif_groupe.php");
        //}



        //------------------------------------------
        // -- FFR On inclut les Activit�s de loisir
        if ( ($_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_STAGE_THEM_GROUPE || $_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL) && $form_fieldname=="field_visuel_1") {
            include "include/inc_list_sejour_detail.inc.php";

        }
        //------------------------------------------



        //------------------------------------------
        // -- FFR On inclut les Activit�s de loisir
        if ( $_REQUEST["TableDef"]==_CONST_TABLEDEF_ACCUEIL_GROUPE && $form_fieldname=="field_visuel_1") {
            include "include/inc_list_sejour_loisirs_dispo.inc.php";

        }
        //------------------------------------------


        //------------------------------------------
        // -- FFR On inclut les formules
        if ( $_REQUEST["TableDef"]==_CONST_TABLEDEF_ACCUEIL_REUNION && $form_fieldname=="field_id_sejour_materiel_service") {
            include "include/inc_list_sejour_restauration_repas.inc.php";
            include "include/inc_list_sejour_restauration_pause.inc.php";
            include "include/inc_list_sejour_restauration_cocktail.inc.php";
            include "include/inc_list_sejour_formule_reunion.inc.php";
        }
        //------------------------------------------



        //------------------------------------------
        // -- FFR On inclut les Activit�s de loisir
        if ( $_REQUEST["TableDef"]==_CONST_TABLEDEF_ACCUEIL_REUNION && $form_fieldname=="field_commentaires_salles") {
            include "include/inc_list_sejour_salle_reunion.inc.php";

        }
        //------------------------------------------


        //------------------------------------------
        // -- FFR Placement des p�riode de dispo --
        if ( in_array($_GET["TableDef"],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) && $form_fieldname=="field_id_sejour_nb_lit__par_chambre"){
            //include("include/inc_list_sejour_date_dispo.inc.php");
        }

        //------------------------------------------
        // -- FFR On inclut les + du s�jour
        if ( in_array($_GET["TableDef"],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) && $form_fieldname=="field_visuel_1" ){//&& $_GET["TableDef"]!=_CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE) {
            include "include/inc_list_plusSejour.inc.php";
        }
        //------------------------------------------
        // -- FFR Placement du tableau D�tail de l'h�bergement --
        if ( in_array($_GET["TableDef"],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) && $form_fieldname=="field_haute_saison"){
            include("specifique/sejour_tarif_groupe.php");

        }

        // -- FFR Placement du tableau D�tail de l'h�bergement --
        if ( in_array($_GET["TableDef"],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) && $form_fieldname=="field_haute_saison_n1"){
            include("specifique/sejour_tarif_groupe_plus.php");

        }
        //------------------------------------------
        // -- FFR Placement du tableau Traif groupe --
        //if ( in_array($_GET["TableDef"],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) && $form_fieldname=="field_conditions_groupes"){
        //include("specifique/sejour_tarif_groupe.php");
        //}
        //echo $form_fieldname."<br>";
        //------------------------------------------
        // -- FFR Placement du flash g�olocalisation centre --
        if ( $_REQUEST["TableDef"]==_CONST_TABLEDEF_CENTRE && $form_fieldname=="field_flash_x"){
            include("specifique/geolocalisation_centre.php");
        }

        //-------------------------------------
        // -- TLY PLacement text :





        if (mysql_num_rows($RSlc)>0)
        {

            if(mysql_result($RSlc,0,"multilingue")==1)
            {
                $flag_multilingue=1;
            }

            if (mysql_result($RSlc,0,"libelle")!="")
            {
                // -- On inclut les sites touristique du centre
                if ($_GET["TableDef"]== _CONST_TABLEDEF_CENTRE && $form_fieldname=="field_id_centre_activite") {
                    include "include/inc_list_siteCentre.inc.php";
                }

                // -- On inclut les + du centre
                if ($_GET["TableDef"]== _CONST_TABLEDEF_CENTRE && $form_fieldname=="field_visuel_1") {

                    include "include/inc_list_plusCentre.inc.php";
                }


                // -- Placement du tableau D�tail de l'h�bergement --
                if($_GET["TableDef"]== _CONST_TABLEDEF_CENTRE && $form_fieldname=="field_nb_chambre"){
                    include("specifique/centre_detail_hebergement.php");
                }

                /*if ($_GET["TableDef"]== _CONST_TABLEDEF_CENTRE && $form_fieldname =="field_visuel_1"){
                echo "<tr><td colspan=\"4\"><hr><strong>Equipements &agrave; venir<br/><hr></strong></td></tr>";
                }*/


                if( $form_fieldname =="field_visuel_1"){

                    echo "<tr><td colspan=\"4\"><strong>Attention, la taille du visuel ne doit pas d&eacute;passer les 1.5 Mo.<br />Les extensions autoris&eacute;es sont \".jpeg\", \".jpg\", \".gif\", \".pdf\" , \".doc\", \".png\"</strong></td></tr>";
                }


                $flag_spec_name = 1;
                if (mysql_result($RSlc,0,"up_title")!="")
                {

                    echo("<tr><td valign=\"top\" colspan='3'>".mysql_result($RSlc,0,"up_title")."</td></tr>");
                }



                // RPL - 24/05/2001 : id inutile et genere un bug avec FCK
                //echo"<tr $displayTR id='$form_fieldname' ";
                echo"<tr $displayTR ";
                if( $form_fieldname=="field_etat"){
                    echo " style='display:none' ";
                }

                echo" ><td valign=\"middle\"  >".mysql_result($RSlc,0,"libelle");

                if (mysql_result($RSlc,0,"description")!="")
                {
                    echo("<br>".mysql_result($RSlc,0,"description"));
                }




                echo("</td>");
            }


        }
        // *** FIN RAJOUT API ***

    if ($flag_spec_name==0)
    {
        //Affiche le nom du champ
    if ($fieldname!="id_"._CONST_BO_TABLE_DATA_PREFIX2)
    {


        // -- On inclut les + du centre
        if ( ($_REQUEST['TableDef'] == _CONST_TABLEDEF_CENTRE) && ($fieldname == "field_presentation_region_text") ) {
            include "include/inc_list_plusCentre.inc.php";
        }

        // -- Placement du tableau D�tail de l'h�bergement --
        if($_GET["TableDef"]== _CONST_TABLEDEF_CENTRE && $form_fieldname=="field_agrement_edu_nationale"){
            include("specifique/centre_detail_hebergement.php");
        }
        //------------------------------------------------ --

        ?>


        <tr id='<?
    if($_GET["TableDef"] != 536){
        echo $form_fieldname;
    }?>' <?=$displayTR?> height='25px'  >
    <td valign="middle"><?
    //	echo $fieldvalue;
    //Si le formulaire est ratache a l'arbo et qu'on est pas sur le formulaire de cr�ation d'arborescence
    if (eregi("id_"._CONST_BO_CODE_NAME."nav",$fieldname) && $TableDef!=2)
    {
        echo $lib_form_rubrique;
    }

    //Gestion des listes de tables de donn�es
    elseif (eregi("^id_"._CONST_BO_TABLE_PREFIX,$fieldname) || eregi("^id_",$fieldname))
    {
        echo bo_strip_pre_suf($fieldname_alias,$fieldtype,$fieldlen)."&nbsp;:";
    }
    else
    {
        //Si le champ est obligatoire
        if (ereg(_CONST_BO_REQUIRE_SUFFIX."$",$fieldname))
        {
            echo "<span class=\"required\">";

            $ar_required_fields_name[]	= $form_fieldname;
            $ar_required_fields_len[]	= $fieldlen;
            $ar_required_fields_type[]	= $fieldtype;
            $ar_required_fields_alias[] = bo_strip_pre_suf($fieldname,$fieldtype,$fieldlen);
        }

        //FFR : cacher le champ flash ==> pas fait dans l edit formulaire a cause de l include du flash

        echo bo_strip_pre_suf($fieldname_alias,$fieldtype,$fieldlen)."&nbsp;:";

        //Si le champ est obligatoire
        if (eregi(_CONST_BO_REQUIRE_SUFFIX."$",$fieldname))
        {
            echo "&nbsp;&nbsp;<b>*</b></span>";
        }
    }

    ?><?=$EchoDebug?></td><?
    }
    }

    if ($mode=="modif")
    {
        $fieldvalue =	@mysql_result($result, $id ,@mysql_field_name($result, $k));

        if ($object_type==3)
        {
            $fieldvalue =	@mysql_result($result, $div ,@mysql_field_name($result, $k));
        }

    }
    else
    {
        $fieldvalue = "";
    }


    /**********************************************/
    /** On parcourt les champs suivant leur type **/
    /**********************************************/


    //07/09/07-MVA-SPECIF TRADUCTION
    //************    CHAMPS MULTI-LINGUES
    if($flag_multilingue==1)
    {
        include "include/inc_object_multilingue.php";

    }
    //************    DATE
    elseif ($fieldtype==$datatype_date || $fieldtype==$datatype_datetime)
    {
        //DATETIME
        if ($fieldtype==$datatype_datetime)
        {
            $arr_date_popup[$form_fieldname] = $fieldtype;
            $DefaultDateFormat = "&nbsp;<a href=\"javascript:cal_".$form_fieldname.".select(document.formulaire.".$form_fieldname.",'anchor1x_".$form_fieldname."','dd/MM/yyyy hh:mm:ss','false')\" NAME='anchor1x_".$form_fieldname."' ID='anchor1x_".$form_fieldname."'><img src='calendar/date.gif' border='0' alt='".$inc_form_select_date."'></a>"; //&nbsp;Format : JJ/MM/AAAA HH:MM:SS
            $field_date_size = 19;
        }
        else
        {
            $arr_date_popup[$form_fieldname] = $fieldtype;
            $DefaultDateFormat = "&nbsp;<a href=\"javascript:cal_".$form_fieldname.".select(document.formulaire.".$form_fieldname.",'anchor1x_".$form_fieldname."','dd/MM/yyyy','false');\" NAME='anchor1x_".$form_fieldname."' ID='anchor1x_".$form_fieldname."'><img src='calendar/date.gif' border='0' alt='".$inc_form_select_date."'></a>"; //&nbsp;Format : JJ/MM/AAAA
            $field_date_size = 11;
        }

        /* echo"<script>
        cal_".$form_fieldname.".addDisabledDates(\"Jan 01, 2011\", null);
        </script>";
        */
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
        echo "<td colspan='2'><DIV ID='datediv_".$form_fieldname."' STYLE='position:absolute;visibility:hidden;background-color:white;layer-background-color:white;'></DIV><input readonly ".$StyleChampDate." ".$fieldEffect." type=\"text\" class=\"".$StyleChamps."\" id=\"".$form_fieldname."\" name=\"".$form_fieldname."\" size=\"".$field_date_size."\" value=\"".$newdate."\" ".$input_allow.">".$DefaultDateFormat."</td>";
    }

    //------------ MODIF LAC 12/2004
    // pb : le varchar(254) est trop petit pour stocker tous les id dans la table user..
    // passage du champ en longtext => detection dans inc_form ici=
    elseif(($_REQUEST['TableDef']==8)&&($fieldname == $datatype_arbo))
    {
        echo "<td colspan='2'>";
        echo "<select class=\"".$StyleChamps."\" ".$input_allow." name=\"".$form_fieldname."[]\" id=\"".$form_fieldname."\" size='20' multiple>";

        if (empty($show_tree_from)) {
            $show_tree_from = 0;
        }

        get_arbo(1, "&nbsp;&nbsp;",0,@split(",",$fieldvalue),$MenuBgColor,0,1,1);
        echo "</select>";
        echo "</td>";
    }
    //------------ FIN MODIF LAC 12/2004

    //************    TOUS LES TYPE VARCHAR
    elseif ($fieldtype==$mysql_datatype_text )
    {

        //************    IMAGE OU FICHIER
        if ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_file)) //Fichier � uploader
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
                    // MODIF LAC 12/11 : lien absolu vers l'affichage des images dus au liens symboliques vers l'appli centralis�e
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
                $PictureDelete = "<br><input type=\"checkbox\" name=\"PictureDelete_$fieldname\" id=\"PictureDelete_$fieldname\" value=\"1\" ".$input_allow.">&nbsp;".$NoPictureTitle;
            }
            else
            {
                $Image = "";
                $PictureDelete = "";
                $imageWidthHeight = "";
            }

            if ($methode=="duplicate")
            {
                $hidden_file_name = "<input type=\"hidden\" value=\"".$fieldvalue."\" name=\"".$form_fieldname."_".$methode."\" id=\"".$form_fieldname."_".$methode."\" class=\"".$StyleChamps."\">";
            }
            else
            {
                $hidden_file_name ="";
            }
            //<td>&nbsp;&nbsp;</td>
            echo "
										<td colspan=\"2\" height=110>
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
            // si on est dans le menu PORTFOLIO, on offre la possibilit� de lister le contenu du rep
            // sinon, on affiche le menu d�roulant du portfolio

            if ($TableDef==332)
            {
                echo "<script>window.open( \"portfolio_view.php\", \"Portfolio\", \"toolbar=no,menubar=no,resizable=no,scrollbars=yes\" );</script>";

                //$str_nomTable = "SELECT upload_path FROM "._CONST_BO_CODE_NAME."table_def WHERE id__table_def = ".$TableDef;
                //$rst_nomTable = mysql_query( $str_nomTable );

                echo "
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
                echo get_bo_Replist( $UploadPath[0] );
                echo "
	                                                    </td>
	                                                    <td style=\"display:".$portfolio_style_td2."\" id=\"img_upload_".$form_fieldname."\" valign=\"top\">
	                                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
	                                                        <tr>
	                                                        <td valign=\"top\">".$inc_form_select_file."<br>
                                                            <input type=\"file\" ".$input_allow." class=\"".$StyleChamps."\" name=\"".$form_fieldname."\" id=\"".$form_fieldname."\" size=\"".intval($FieldWidthSize-47)."\" ".$fieldEffect.">
	                                                            ".$hidden_file_name."
	                                                        <br><font color=red><b>(fichier < 1.5Mo)</font><br><br>
									";

                if (_CONST_FTP_PORTOFOLIO_ENABLE=="true")
                {
                    echo "
	                                                        <a href=\""._CONST_FTP_PORTOFOLIO_URL."\" target=\"_blank\">via FTP</a>
										".$inc_form_warning_ftp;
                }

                echo "
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
									"; // dernier </td> ??
                $CtImUpload++;

            }
            else
            {
                $styleD = " style='display:none' ";
                /*if($_SESSION["ses_profil_user"] == _PROFIL_CENTRE){
                $styleD = " style='display:none' ";
                }else{
                $styleD  = "";
                }*/
                echo "
											<table border='0' cellpadding='0' cellspacing='5' width='450' height='60'>
													<tr>
	                                                    <td valign=\"top\" width='120' $styleD>
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
                //FFR => spec lien porfolio
                echo "<a href=\"#\" onclick=\"javascript:window.open( 'include/inc_portfolio_popup.inc.php?Ac=upload&form=1&selectId=$form_fieldname&TableDef=".$_REQUEST["TableDef"]."', '', 'toolbar=no,menubar=no,resizable=no,scrollbars=yes' ); return false;\" title=\"$lib_form_ajouter_porfolio\">$lib_form_ajouter_porfolio</a>";

                echo get_bo_portfolio();
                echo "
	                                                    </td>
	                                                    <td style=\"display:".$portfolio_style_td2."\" id=\"img_upload_".$form_fieldname."\" valign=\"top\">
	                                                        <table border='0' cellpadding='0' cellspacing='0' width='100%'>
	                                                        <tr>
	                                                        <td valign=\"top\">".$inc_form_select_image."<br>
                                                            <input type=\"file\" ".$input_allow." class=\"".$StyleChamps."\" name=\"".$form_fieldname."\" id=\"".$form_fieldname."\" size=\"".intval($FieldWidthSize-47)."\" ".$fieldEffect.">
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
											</table>";


                echo "</td>
	                ";
                $CtImUpload++;
            }
        }
        //************    COULEUR
        elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_color))
        {
            $ColorTdView = "<td><table width='100' cellpadding=\"0\" cellspacing=\"0\" border=\"0\"><tr><td><table cellpadding=\"0\" cellspacing=\"1\" border=\"0\" bgcolor=\"#000000\"><tr><td style='background-color:$fieldvalue;' id='Td$k'><a href=\"javascript:MM_openBrWindow('library/colorPicker.php?NomChamp=$form_fieldname&IdTd=Td$k','','status=no,scrollbars=no,resizable=no,height=253,width=170')\"><img src=\"images/pixtrans.gif\" width=\"15\" height=\"15\" border=0 alt=\"".$inc_form_choose_color."\"></a></td></tr></table></td></tr></table></td>";
            echo "<td><input ".$input_allow." class=\"".$StyleChamps."\" ".$fieldEffect." type=\"text\" name=\"".$form_fieldname."\" id=\"".$form_fieldname."\" size=\"".$FieldWidthSize."\" value=\"".$fieldvalue."\" onChange=\"javascript:Td$k.style.backgroundColor=formulaire.$form_fieldname.value\">".$ColorPicker."</td>".$ColorTdView;
        }
        //************    CHAMP MOT DE PASSE
        elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_password))
        {
            if ($mode=="nouveau")
            {
                $fieldvalue = password_generator($datatype_password_length);
            }
            echo "<td colspan='2'><input ".$fieldEffect." ".$input_allow." class=\"".$StyleChamps."\" type=\"text\" name=\"".$form_fieldname."\" id=\"".$form_fieldname."\" size=\"".intval(ereg_replace("(.*)\((.*)\)","\\2",$datatype_password)+1)."\" value=\"".$fieldvalue."\">&nbsp;".ereg_replace("(.*)\((.*)\)","\\2",$datatype_password).$inc_form_max_car." </td>";
        }
        //************    CHAMP TEXT
        elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_text))
        {
            //FFR : cacher le champ flash ==> pas fait dans l edit formulaire a cause de l include du flash
            if($_REQUEST["TableDef"]==_CONST_TABLEDEF_CENTRE && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE && ($form_fieldname == "field_libelle" || $form_fieldname == "field_latitude" || $form_fieldname == "field_longitude" || $form_fieldname == "field_flash_x"  || $form_fieldname == "field_flash_y"  || $form_fieldname == "field_flash_paris"))
            {
                $readonly = "readonly";
            }else{
                $readonly="";
            }

            if($form_fieldname == "field_a_partir_de_prix"){
                $actionJS = "onkeyup='isPrix(this)'";
            }else{
                $actionJS="";
            }
            echo "<td colspan='2'><input $actionJS $readonly ".$fieldEffect." ".$input_allow." class=\"".$StyleChamps."\" type=\"text\" name=\"".$form_fieldname."\" id=\"".$form_fieldname."\" size=\"".$FieldWidthSize."\" value=\"".$fieldvalue."\"></td>";
        }


        //************    LIEN URL
        elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_url))
        {
            if ($mode=="nouveau")
            {
                $fieldvalue = "http://www.";
            }

            echo "<td colspan='2'><input ".$fieldEffect." style=\"text-decoration:underline\" ".$input_allow." class=\"".$StyleChamps."\" type=\"text\" name=\"".$form_fieldname."\" id=\"".$form_fieldname."\" size=\"".$FieldWidthSize."\" value=\"".$fieldvalue."\">&nbsp;<a href=\"javascript:MM_openBrWindow(document.formulaire.".$form_fieldname.".value,'TestUrl','')\"><img src=\"images/icones/lien.gif\" border=\"0\"></a></td>";
        }
        //************    LISTE DE DONNEES
        elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_list_data))
        {
            echo "<td colspan='2'>";
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
            //echo $str_sql."<br>";
            $rst_list_data = mysql_query($str_sql);

            $list_data_data     = @mysql_result($rst_list_data,0,"data");
            $list_data_control  = @mysql_result($rst_list_data,0,"control_5");
            $list_data_order    = @mysql_result($rst_list_data,0,"order_8");
            $list_data_align    = @mysql_result($rst_list_data,0,"align_9");

            if (empty($list_data_order))
            {
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

                echo "<select class=\"".$StyleChamps."\" ".$input_allow." name=\"".$form_fieldname."[]\" id=\"".$form_fieldname."[]\" ".$multiple.">";

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
                        echo "<option value=\"".trim($v)."\" ".$selected.">".ucfirst($v)."</option>";
                    }
                    elseif (trim($v)!="")
                    {
                        echo "<option value=\"".trim($v)."\" ".$selected.">".ucfirst($v)."</option>";
                    }
                    $indice++;
                }
                echo "</select>";
            }

            //RADIO
            //CHECKBOX
            elseif (($list_data_control == "radio") || ($list_data_control == "checkbox"))
            {
                echo "<table border=0 cellpadding=1 cellspacing='1' bgcolor=#9A9A9A><tr><td bgcolor=#F7F7F7>";
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
                        echo "<input type='".$list_data_control."' name=\"".$form_fieldname."[]\" id=\"".$form_fieldname."[]\" ".$selected." value=\"".trim($v)."\" ".$input_allow.">".ucfirst(trim($v))."</option>";

                        if ($list_data_align == "horizontal")
                        {
                            echo "&nbsp;&nbsp;&nbsp;";
                        }
                        else
                        {
                            echo "<br>";
                        }
                    }
                    $indice++;
                }
                echo "</td></tr></table>";
            }
            //echo get_sql_format($str_sql);
            echo "</td>";
        }
        //************    LISTE DEROULANTES A CHOIX MULTIPLE SUR L'ARBORESCENCE
        elseif (($fieldname == $datatype_arbo) && ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey)))
        {
            echo "<td colspan='2'>";
            echo "<select class=\"".$StyleChamps."\" ".$input_allow." name=\"".$form_fieldname."[]\" id=\"".$form_fieldname."\" size='20' multiple>";

            if (empty($show_tree_from))
            {
                $show_tree_from = 0;
            }

            get_arbo(1, "&nbsp;&nbsp;",0,@split(",",$fieldvalue),$MenuBgColor,0,1,1);
            echo "</select>";

            echo "</td>";
        }
        //************    LISTE DEROULANTES A CHOIX MULTIPLE
        elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey))
        {

            echo "<td colspan='2'>";

            $str_multi_select = "Select * from ".ereg_replace("id_","",get_table_annexe_name($fieldname));
            //Si le premier enregistrement de la table concern�e est (Aucun), on ne l'affiche pas
            if (ereg("^\(Aucun\)$",@mysql_result(mysql_query("select * from ".ereg_replace("id_","",get_table_annexe_name($fieldname))),0,1)))
            {
                //if (!ereg("_data",get_table_annexe_name($fieldname))) {
                $str_multi_select .= " where ".get_table_annexe_name($fieldname)."!=1 ";
            }
            //echo $str_multi_select;

            $str_multi_filter = " order by ordre"; // si champ ordre, tri par d�faut
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

            $strTabledef='SELECT id__table_def FROM _table_def WHERE cur_table_name = \''.ereg_replace("id_","",get_table_annexe_name($fieldname)).'\'';
            $rsTableDef=mysql_query($strTabledef);



            //si champ externe multilingue
            $isMultilingue_deroul_multi = false;
            $name_champ_multilingue_deroul_multi = "";



            if($fieldderoulante && isMultilingue($fieldderoulante,mysql_result($rsTableDef,0,0))/* && $valid_multi!=1*/)// Modif Fred
            {
                $isMultilingue_deroul_multi = true;
                $name_champ_multilingue_deroul_multi = $fieldderoulante;
            }

            if(isMultilingue(mysql_field_name($rst_multi_select,1),mysql_result($rsTableDef,0,0)))
            {
                $isMultilingue_deroul_multi = true;
                $name_champ_multilingue_deroul_multi = mysql_field_name($rst_multi_select,1);
            }
            if($isMultilingue_deroul_multi)
            {
                //on recompose la requete pour atteindre les libelles traduis
                $str_multi_select='SELECT '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).',t.'.$name_champ_multilingue_deroul_multi.' FROM  '.ereg_replace("id_","",get_table_annexe_name($fieldname)).' INNER JOIN '._CONST_BO_PREFIX_TABLE_TRAD.ereg_replace("id_","",get_table_annexe_name($fieldname)).' t ON  '.ereg_replace("id_","",get_table_annexe_name($fieldname)).'.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' = id__'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' WHERE t.id__langue='.$_SESSION['ses_langue'];


                $str_multi_filter = " order by ordre"; // si champ ordre, tri par d�faut
                $rst_multi_select = mysql_query($str_multi_select.$str_multi_filter);

                if (mysql_error())
                {
                    $str_multi_filter = " order by t.".$name_champ_multilingue_deroul_multi.",".$fieldname;
                    $rst_multi_select = mysql_query($str_multi_select.$str_multi_filter);
                }

                if (mysql_error())
                {

                    $rst_multi_select = mysql_query($str_multi_select);
                }


            }

            if (@mysql_num_rows($rst_multi_select)>10)
            {
                $multi_select_size = 10;
            }
            else
            {
                $multi_select_size = @mysql_num_rows($rst_multi_select);
            }


            if($fieldname == "id_centre" && $_REQUEST["TableDef"]==_CONST_TABLEDEF_ORGANISATEUR_CVL && $_SESSION["ses_profil_user"] == _PROFIL_CENTRE){
                $sql_S = "select libelle,id_centre from centre where id_centre=".$_SESSION["ses_id_centre"];
                $result_S = mysql_query($sql_S);

                if($_REQUEST["mode"] == "nouveau"){
                    $fieldvalue = mysql_result($result_S,0,"id_centre");
                }

                echo "<strong>".mysql_result($result_S,0,"libelle")."</strong><input type='hidden' value='".$fieldvalue."' name='field_id_centre[]' id='field_id_centre[]'>";

            }else{

                echo"<div class=\"checkbox_select_multiple\" style=\"background-color:$TdBgColor1;display:block;\">";

                //echo "<select  class=\"".$StyleChamps."\" ".$input_allow." id=\"".$form_fieldname."\" name=\"".$form_fieldname."[]\" size=\"".$multi_select_size."\" multiple>";
                $ar_valeur = split(",",$fieldvalue);

                for ($s=0; $s<@mysql_num_rows($rst_multi_select) ;$s++)
                {
                    $id_val  = mysql_result($rst_multi_select,$s,0);
                    if (in_array(@mysql_result($rst_multi_select,$s,0),$ar_valeur) || ( $_GET["mode"]!="modif" && $form_fieldname == 'field_id_centre' && ($_GET["TableDef"] == 588 ||
                                $_GET["TableDef"] == 580 )))
                    {

                        $selected = "checked=\"checked\"";


                    }
                    else
                    {
                        $selected= "";
                    }

                    // RPL - specif champ multilingue id__langue
                    if( $form_fieldname == "field_id__langue" && $fieldvalue == '' && @mysql_result($rst_multi_select,$s,0) == _ID_FR )
                    {
                        $selected = "checked=\"checked\"";
                    }

                    if($form_fieldname=="field_id_sejour_theme"){
                        $verifsize="onchange=\"Verif_checkbox('$form_fieldname"."[]',2,this,'themes');\"";
                    }else{
                        $verifsize="";
                    }



                    if ($fieldderoulante!="")
                    {

                        //echo "<option value=\"".@mysql_result($rst_multi_select,$s,0)."\" ".$selected.">";
                        echo "<label for='$form_fieldname.$s'><input  $verifsize type=\"checkbox\" $selected value=\"".@mysql_result($rst_multi_select,$s,0)."\" id='$form_fieldname.$s' name=\"$form_fieldname"."[]\">";
                        if($selected != ""){
                            echo "<strong>";
                        }
                        $tab_temp = split(",",$fieldderoulante);

                        for ($b=0;$b<count($tab_temp);$b++)
                        {
                            if($form_fieldname == 'field_id_centre'){
                                $sql_SS = "select ville from centre where id_centre=$id_val";
                                $result_SS = mysql_query($sql_SS);
                                $ville =  mysql_result($result_SS,0,'ville')." - ";
                            }else{
                                $ville="";
                            }
                            echo (mysql_result($rst_multi_select,$s,$tab_temp[$b]));
                            if ($b!=count($tab_temp)-1) echo(" / ");
                        }
                        if($selected != ""){
                            echo "</strong>";
                        }
                        echo "</label><br>";
                        //echo("</option>");



                    }
                    else{

                        echo "<label for='$form_fieldname.$s'><input $verifsize type=\"checkbox\" $selected value=\"".@mysql_result($rst_multi_select,$s,0)."\" id='$form_fieldname.$s' name=\"$form_fieldname"."[]\">";
                        if($selected != ""){
                            echo "<strong>";
                        }

                        if($form_fieldname == 'field_id_centre'){
                            $sql_SS = "select ville from centre where id_centre=$id_val";
                            $result_SS = mysql_query($sql_SS);
                            $ville =  " - ".mysql_result($result_SS,0,'ville');
                        }else{
                            $ville="";
                        }


                        echo @mysql_result($rst_multi_select,$s,1).$ville;
                        if($selected != ""){
                            echo "</strong>";
                        }

                        echo"</label><br>";
                        //echo "<option value=\"".@mysql_result($rst_multi_select,$s,0)."\" ".$selected.">".@mysql_result($rst_multi_select,$s,1)."&nbsp;&nbsp;&nbsp;</option>";
                    }

                }

                echo "</div>";
                //echo "</select>";
            }
            get_option_edit_table();

            echo "</td>";
        }

    }
    //************    TEXTE LONG ET TEXTE RICHE
    elseif ($fieldtype==$mysql_datatype_text_rich)
    {
        if ($mode=="modif" || $mode=="nouveau")
        {
            //Editeur Html
            // Text rich si autoris�
            if ( ( $fieldlen > 65535) && (!strcmp(_CONST_ENABLE_RICHTEXT,"true")) )
            {
                if (empty($fieldvalue)) {
                    $table_height = "height='30'";
                }

                $NewFieldHeightSize = 0;
                $NewFieldWidthSize = intval(($FieldWidthSize*6)+16)."px";

                $action_editeur = "JavaScript:void(window.open('richtext/editor.php?fieldname=".$form_fieldname."&fieldvalue=','','directories=no,location=no,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,toolbar=no,width=720,height=600'))";
                $DivAttTextArea="style=\"position:absolute;left:1px;visibility:hidden; top:1px; width:1px; height:1px; z-index:1\"";
                //relative au lieu de absolute

                $editor_annexe = $inc_form_editor_annexe."<br><table width=\"".$NewFieldWidthSize."\" height=\"100%\" cellpadding=\"3\" cellspacing=\"1\" border=\"0\" bgcolor=\"".get_inter_color($MenuBgColor,0.5)."\"><tr><td style=\"cursor:pointer\" onDblClick=\"".$action_editeur."\" id=\"".$form_fieldname."_text\" bgcolor=\"".get_inter_color($MenuBgColor,0.03)."\" height='30'>".$fieldvalue."<input type=\"text\" id=\"t_$form_fieldname\" style=\"width:1px;height:1px\" /></td></tr></table>";

                $editor_object = "<textarea class='".$StyleChamps."' cols='0' rows='0' id=\"".$form_fieldname."_object\"><!--NAME--><!--SCRIPT--></textarea>";
                $show_in_div=1;
            }
            else
            {
                //Pas d'editeur Html autoris�
                $NewFieldHeightSize = 10;
                $NewFieldWidthSize = $FieldWidthSize-1;
                $action_editeur = "";
                $DivAttTextArea="";
                $editor_annexe = "";
                $editor_object = "";
                $show_in_div=0;
            }
            ?>
            <td colspan='2'><?=$editor_annexe?>
                <? if ($show_in_div) { ?><div <?=$DivAttTextArea?>><? } ?>
                    <textarea <?=$fieldEffect?> rows="<?=$NewFieldHeightSize?>" cols="<?=$NewFieldWidthSize?>" name="<?=$form_fieldname?>" id="<?=$form_fieldname?>" class="<?=$StyleChamps?>" <?=$input_allow?> ><?=$fieldvalue?></textarea> <?=$editor_object?>
                    <? if ($show_in_div) { ?></div><? } ?>
                <br>
            </td>
        <?
        }
    }
    //************    ENTIER
    elseif ($fieldtype==$mysql_datatype_integer || $fieldtype==$mysql_datatype_real)
    {
        //CASE A COCHER
        if ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_booleen) )
        {
            $TextboxType = "checkbox";
            if ($mode=="modif")
            {
                if ($fieldvalue=="1")
                {
                    $checked = "checked";
                }
                elseif ($fieldvalue!="1")
                {
                    $checked = "";
                }
            }
            if ($mode=="nouveau")
            {
                $checked = "";
            }
            echo "<td colspan='2'><input ".$fieldEffect." ".$input_allow." type=\"".$TextboxType."\" name=\"".$form_fieldname."\" id=\"".$form_fieldname."\" value=\"1\" ".$checked."></td>";
        }
        //REAL
        elseif ($fieldtype==$mysql_datatype_real)
        {
            echo "<td colspan='2'><input ".$fieldEffect." ".$input_allow." class=\"".$StyleChamps."\" maxlength=\"10\" type=\"text\" onkeyup='checkNumeric(this)' id=\"".$form_fieldname."\" name=\"".$form_fieldname."\" size=\"11\" value=\"".$fieldvalue."\">".$inc_form_real."</i></td>";
        }
        //ENTIER
        elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_integer))
        {

            //if( $_REQUEST["TableDef"]== _CONST_TABLEDEF_PLUS_SEJOUR && $form_fieldname == "field_IdSejour"){
            if( $form_fieldname == "field_IdSejour"){
                $table = str_replace("id_","",$_REQUEST["MasterKey"]);
                $sql_S = "select nom as libelle from $table where id_$table='".$_GET["MasterValue"]."'";
                $result_S = mysql_query($sql_S);
                if($fieldvalue == ""){
                    $fieldvalue = $_GET["MasterValue"];
                }

                $nom = mysql_result($result_S,0,"libelle");
                if($nom ==""){
                    $nom="Libell&eacute; non disponible";
                }



                echo "<td colspan='2'><strong>".$nom."</strong><input $readonly onkeyup='verif_numeric(this)' type=\"hidden\" id=\"".$form_fieldname."\" name=\"".$form_fieldname."\" value=\"".$fieldvalue."\"></td>";
            }else{

                if($form_fieldname == "field_nb_chambre"){
                    $readonly = "readonly";
                }else{
                    $readonly = "";
                }

                echo "<td colspan='2'><input $readonly onkeyup='verif_numeric(this)' ".$fieldEffect." ".$input_allow." class=\"".$StyleChamps."\" maxlength=\"10\" type=\"text\" id=\"".$form_fieldname."\" name=\"".$form_fieldname."\" size=\"11\" value=\"".$fieldvalue."\"></td>";
            }


        }
        //ORDRE
        elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_order))
        {
            echo "<td colspan='2'><input ".$fieldEffect." ".$input_allow." class=\"".$StyleChamps."\" maxlength=\"10\" type=\"text\" id=\"".$form_fieldname."\" name=\"".$form_fieldname."\" size=\"11\" value=\"".$fieldvalue."\"></td>";
        }
        //LISTES DEROULANTES
        elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_key))
        {
            echo "<td colspan='2'>";

            // -------------------------------------------------
            //	GESTION DES LISTES DE TABLES DE DONNEES EXTERNES
            if (eregi("^id_",$fieldname) || eregi("^id_"._CONST_BO_TABLE_PREFIX,$fieldname) || eregi("^id_"._CONST_BO_TABLE_DATA_PREFIX,$fieldname))
            {

                // LISTE DES TEMPLATES XLS
                if ($fieldname == "id_"._CONST_BO_CODE_NAME."xsl_tpl")
                {
                    echo "<script>";
                    echo "function preview(){";
                    echo "xsl_id=document.formulaire.".$form_fieldname.".options[document.formulaire.".$form_fieldname.".selectedIndex].value;";
                    echo "window.open('xml/preview.php?xsl_id='+xsl_id+'&strsql=".$StrSQL."')";
                    echo "}";
                    echo "</script>";
                    echo "<input type=\"hidden\" name=\"strsql\" id=\"strsql\" value=\"".$StrSQL."\">";
                    echo "<select class=\"".$StyleChamps."\" ".$input_allow." id=\"".$form_fieldname."\" name=\"".$form_fieldname."\">";
                    $str_listid = "SELECT id_"._CONST_BO_CODE_NAME."xsl_tpl FROM "._CONST_BO_CODE_NAME."table_def WHERE id_"._CONST_BO_CODE_NAME."table_def=".$TableDef;
                    $rst_listid = mysql_query($str_listid);
                    $table_name = ereg_replace("id_","",get_table_annexe_name($fieldname));
                    $str_table_data = "Select * from  ".$table_name." where id_"._CONST_BO_CODE_NAME."xsl_tpl IN (".mysql_result($rst_listid,0,0).") order by ".get_table_annexe_name($fieldname)." asc";

                    $rst_table_data = mysql_query($str_table_data);

                    for ($s=0; $s<@mysql_num_rows($rst_table_data) ;$s++)
                    {
                        if (@mysql_result($rst_table_data,$s,0)==$fieldvalue)
                        {
                            $selected = "selected";
                        }
                        else
                        {
                            $selected= "";
                        }
                        echo "<option value=\"".@mysql_result($rst_table_data,$s,0)."\" ".$selected.">".@mysql_result($rst_table_data,$s,1)."</option>";
                    }
                    echo "</select><a href=\"javascript:preview();\">Preview</a>";

                }

                // LISTE DEROULANTE SUR LES TRANSITIONS DU WORKFLOW
                elseif (($fieldname == "id_"._CONST_BO_CODE_NAME."workflow_state" || $fieldname == "id_"._CONST_BO_CODE_NAME."workflow_state_1") && $tablename == ""._CONST_BO_CODE_NAME."workflow_trans")
                {
                    echo "<select class=\"".$StyleChamps."\" ".$input_allow." id=\"".$form_fieldname."\" name=\"".$form_fieldname."\">";
                    $str_table_data = "    SELECT id_"._CONST_BO_CODE_NAME."workflow_state, "._CONST_BO_CODE_NAME."workflow_state, nom
	                                                             FROM "._CONST_BO_CODE_NAME."workflow_state, "._CONST_BO_CODE_NAME."workflow
	                                                             WHERE "._CONST_BO_CODE_NAME."workflow_state.id_"._CONST_BO_CODE_NAME."workflow_1 = "._CONST_BO_CODE_NAME."workflow.id_"._CONST_BO_CODE_NAME."workflow
	                                                             AND "._CONST_BO_CODE_NAME."workflow.id_"._CONST_BO_CODE_NAME."workflow != 1
	                                                        ";

                    $rst_table_data = mysql_query($str_table_data);

                    for ($s=0; $s<@mysql_num_rows($rst_table_data) ;$s++)
                    {
                        if (@mysql_result($rst_table_data,$s,0)==$fieldvalue)
                        {
                            $selected = "selected";
                        }
                        else {
                            $selected= "";
                        }
                        echo "<option value=\"".@mysql_result($rst_table_data,$s,0)."\" ".$selected.">".@mysql_result($rst_table_data,$s,2)." : ".@mysql_result($rst_table_data,$s,1)."</option>";
                    }
                    echo "</select>";
                }

                //LISTES DEROULANTES SUR L'ARBORESCENCE DU SITE
                elseif (ereg("id_"._CONST_BO_CODE_NAME."nav",$fieldname))
                {
                    echo "<select class=\"".$StyleChamps."\" ".$input_allow." id=\"".$form_fieldname."\" name=\"".$form_fieldname."\">";
                    /*if (eregi(""._CONST_BO_CODE_NAME."nav",$tablename))
                    {
                    $StrPere = mysql_query("Select id_"._CONST_BO_CODE_NAME."nav_pere from "._CONST_BO_CODE_NAME."nav where id_"._CONST_BO_CODE_NAME."nav=".$id_item);
                    $Pere = mysql_result($StrPere,0,"id_"._CONST_BO_CODE_NAME."nav_pere");
                    }
                    else
                    {
                    $Pere = $fieldvalue;
                    }
                    */
                    $Pere = $fieldvalue;
                    if (empty($show_tree_from))
                    {
                        $show_tree_from = 0;
                    }
                    // modif lac 22/09 : supprime with user rights si tabledef = navigation
                    // ou profil referenceur (pour les elements de navigation)
                    if (( $_REQUEST['TableDef']==_CONST_TABLEDEF_NAVIGATION ) || ($_SESSION['ses_profil_user'] == _ID_PROFIL_REFERENCEUR))
                    {
                        get_arbo( $show_tree_from, "&nbsp;&nbsp;", 0, $Pere, $MenuBgColor, 0, 1, 1,"","",0);
                    }
                    else
                    {
                        get_arbo( $show_tree_from, "&nbsp;&nbsp;", 0, $Pere, $MenuBgColor, 0, 1, 1,"","",1);
                    }
                    echo "</select>";
                }

                //GESTION DES LISTE DEROULANTES LISTES DE DONNEES STANDARDS
                else
                {
                    $str_table_data = "Select * from ".ereg_replace("id_","",get_table_annexe_name($fieldname));
                    // on exclu le profil root de la liste d�roulante si pas root connect�
                    if ($fieldname == "id_"._CONST_BO_CODE_NAME."profil" && $_SESSION['ses_profil_user'] != 1)
                    {
                        $str_table_data .= " WHERE id_"._CONST_BO_CODE_NAME."profil!=1 ";
                    }

                    $str_filter = " order by ordre"; // tri par d�faut sur champ ordre

                    // LAC 26/01/07 : formulaire fils ouvert en popup a partir d'un form pere
                    // on filtre la requete sur la valeur p�re re�ue pour forcer le choix du menu deroulant pere

                    if (isset($_REQUEST['MasterKey']) && isset($_REQUEST['MasterValue']) && $fieldname == $_REQUEST['MasterKey'])
                    {
                        $str_filter = " WHERE ".$_REQUEST['MasterKey']." = \"".$_REQUEST['MasterValue']."\" " ;
                    };

                    $rst_table_data = mysql_query($str_table_data.$str_filter);

                    if (mysql_error()) // champ ordre n'existe pas, on tri par nom de champ etranger
                    {
                        $str_filter = " order by ".ereg_replace("id_","",get_table_annexe_name($fieldname))." asc";
                        $rst_table_data = mysql_query($str_table_data.$str_filter);
                    }

                    if (mysql_error()) // pour les cas id_table_1 (avec les underscore + chiffre)
                    {
                        $str_filter = " order by ".get_table_annexe_name($fieldname)." asc";
                        $rst_table_data = mysql_query($str_table_data.$str_filter);
                    }


                    if (mysql_error())  // n'existe pas non plus, on tri par nom de champ
                    {
                        $str_filter = " order by ".get_table_annexe_name($fieldname)." asc";
                        $rst_table_data = mysql_query($str_table_data.$str_filter);
                    }

                    if (mysql_error())  // toujours pas, pas de tri
                    {
                        $str_filter = ""; // 18/12/06 - SBA
                        $rst_table_data = mysql_query($str_table_data.$str_filter);
                    }


                    // MVA-08/10/2007 SPECIF MULTILINGUE
                    // va chercher la taduction du champ dans la table externe
                    // � l'aide de la langue globale du fullkit

                    // recuperation du tabledef distant
                    $strTabledef='SELECT id__table_def FROM _table_def WHERE cur_table_name = \''.ereg_replace("id_","",get_table_annexe_name($fieldname)).'\'';
                    $rsTableDef=mysql_query($strTabledef);



                    //si champ externe multilingue
                    $isMultilingue_deroul_externe = false;
                    $name_champ_multilingue_deroul_externe = "";

                    if($fieldderoulante && isMultilingue($fieldderoulante,mysql_result($rsTableDef,0,0)) )
                    {

                        $isMultilingue_deroul_externe = true;
                        $name_champ_multilingue_deroul_externe = $fieldderoulante;
                    }

                    if(isMultilingue(mysql_field_name($rst_multi_select,1),mysql_result($rsTableDef,0,0)))
                    {

                        $isMultilingue_deroul_externe = true;
                        $name_champ_multilingue_deroul_externe = mysql_field_name($rst_multi_select,1);
                    }





                    if($isMultilingue_deroul_externe)
                    {
                        //on recompose la requete pour atteindre les libelles traduis
                        $str_table_data='SELECT tb.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).',t.'.$name_champ_multilingue_deroul_externe.' FROM  '.ereg_replace("id_","",get_table_annexe_name($fieldname)).' as tb INNER JOIN '._CONST_BO_PREFIX_TABLE_TRAD.ereg_replace("id_","",get_table_annexe_name($fieldname)).' t ON  tb.id_'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' = t.id__'.ereg_replace("id_","",get_table_annexe_name($fieldname)).' WHERE t.id__langue='.$_SESSION['ses_langue'];

                        $str_multi_filter = " order by ordre"; // si champ ordre, tri par d�faut
                        $rst_table_data = mysql_query($str_table_data.$str_multi_filter);

                        if (mysql_error())
                        {
                            $str_multi_filter = " order by ".$fieldname;
                            $rst_table_data = mysql_query($str_table_data.$str_multi_filter);
                        }

                        if (mysql_error())
                        {
                            $rst_table_data = mysql_query($str_table_data);

                        }

                        $rst_table_data = mysql_query($str_table_data.$str_filter);

                    }

                    // FIN SPECIF MULTILINGUE




                    if($form_fieldname == "field_id__table_def" &&

                        (
                            $_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_DETAIL ||
                            $_REQUEST["TableDef"]==_CONST_TABLEDEF_PLUS_SEJOUR ||
                            $_REQUEST["TableDef"]==_CONST_TABLEDEF_LOISIRS_SEJOUR ||
                            $_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_DATE_ACCESSIBLE ||
                            $_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_SALLE_ACCUEIL_REUNION ||
                            $_REQUEST["TableDef"]== _CONST_TABLEDEF_SEJOUR_RESTAURATION_REPAS ||
                            $_REQUEST["TableDef"]== _CONST_TABLEDEF_SEJOUR_RESTAURATION_PAUSE ||
                            $_REQUEST["TableDef"]== _CONST_TABLEDEF_SEJOUR_RESTAURATION_COCKTAIL ||
                            $_REQUEST["TableDef"]== _CONST_TABLEDEF_SEJOUR_FORMULE_REUNION)
                    ){
                        $sql_S = "select menu_title from _table_def where id__table_def=".$_REQUEST["InitTableDef"];
                        $result_S = mysql_query($sql_S);
                        echo "<strong>".mysql_result($result_S,0,"menu_title")."</strong><input type='hidden' value='".$_REQUEST["InitTableDef"]."' name='field_id__table_def' id='field_id__table_def'>";
                    }elseif($fieldname == "id_centre_1" && $_REQUEST["TableDef"]==_CONST_TABLEDEF_SITE_CENTRE){
                        $sql_S = "select libelle from centre where id_centre=".$_REQUEST["MasterValue"];
                        $result_S = mysql_query($sql_S);
                        echo "<strong>".mysql_result($result_S,0,"libelle")."</strong><input type='hidden' value='".$_REQUEST["MasterValue"]."' name='field_id_centre_1' id='field_id_centre_1'>";
                    }elseif($fieldname == "id_centre_1" && $_REQUEST["TableDef"]==_CONST_TABLEDEF_PLUS_CENTRE){
                        $sql_S = "select libelle from centre where id_centre=".$_REQUEST["MasterValue"];
                        $result_S = mysql_query($sql_S);
                        echo "<strong>".mysql_result($result_S,0,"libelle")."</strong><input type='hidden' value='".$_REQUEST["MasterValue"]."' name='field_id_centre_1' id='field_id_centre_1'>";
                    }else{

                        if($_SESSION['ses_profil_user'] == _PROFIL_CENTRE && $form_fieldname=="field_id_centre"){
                            $sql_S = "select libelle from centre where id_centre='".$_SESSION["ses_id_centre"]."'";
                            $result_S =  mysql_query($sql_S);
                            echo "<b>".mysql_result($result_S,0,"libelle")."</b><input type='hidden' name='$form_fieldname' id='$form_fieldname' value='".$_SESSION["ses_id_centre"]."' />";
                        }else{
                            //FFR

                            if($form_fieldname == "field_id_centre" && $_REQUEST["TableDef"]==8){
                                echo "<select class=\"".$StyleChamps."\" ".$input_allow." id=\"".$form_fieldname."\" name=\"".$form_fieldname."\">";
                                $sql_S = "SELECT id_centre,libelle,code_postal,ville FROM centre ORDER BY ville";
                                $result = mysql_query($sql_S);
                                while($myrow = mysql_fetch_array($result)){
                                    if ($myrow["id_centre"]==$fieldvalue)
                                    {
                                        $selected = "selected";
                                    }
                                    else
                                    {
                                        $selected= "";
                                    }
                                    $libelle = $myrow["ville"]." - ".$myrow["code_postal"]." - ".$myrow["libelle"];
                                    echo "<option value='".$myrow["id_centre"]."' $selected>$libelle</option>";
                                }
                                echo "</select>";
                            }
                            /*elseif( ($form_fieldname == "field_id_centre_classement" || $form_fieldname == "field_id_centre_classement_1") && $_SESSION['ses_profil_user'] == _PROFIL_CENTRE){
                                $sql_S = "select libelle FROM trad_centre_classement WHERE id__centre_classement =".$fieldvalue." AND id__langue=1";
                                $result_S = mysql_query($sql_S);
                                echo mysql_result($result_S,0,"libelle");
                            }*/
                            else{

                                // g�n�re le champ select
                                echo "<select class=\"".$StyleChamps."\" ".$input_allow." id=\"".$form_fieldname."\" name=\"".$form_fieldname."\">";

                                //D�but ALA 05/10/2007 Donner la possibilt� de ne pas choisir
                                if (@mysql_num_rows($rst_table_data) > 0)
                                {
                                    echo "<option value=\"-1\" >-------------------</option>";
                                }
                                //Fin modif ALA

                                for ($s=0; $s<@mysql_num_rows($rst_table_data) ;$s++)
                                {
                                    if ($champ_selection!="")
                                    {
                                        if (@mysql_result($rst_table_data,$s,0)==$formMain_selection)
                                        {
                                            $selected = "selected";
                                        }
                                        else
                                        {
                                            $selected= "";
                                        }
                                    }
                                    else
                                    {
                                        if (@mysql_result($rst_table_data,$s,0)==$fieldvalue)
                                        {
                                            $selected = "selected";
                                        }
                                        else
                                        {
                                            $selected= "";
                                        }
                                    }

                                    if ($fieldderoulante!="")
                                    {
                                        echo "<option value=\"".@mysql_result($rst_table_data,$s,0)."\" ".$selected.">";
                                        $tab_temp = split(",",$fieldderoulante);
                                        for ($b=0;$b<count($tab_temp);$b++)
                                        {
                                            echo (mysql_result($rst_table_data,$s,$tab_temp[$b]));
                                            if ($b!=count($tab_temp)-1) echo(" / ");
                                        }
                                        echo("</option>");
                                    }
                                    else
                                    {
                                        echo "<option value=\"".@mysql_result($rst_table_data,$s,0)."\" ".$selected.">".@mysql_result($rst_table_data,$s,1)."</option>";
                                    }
                                }
                                echo "</select>";
                            }
                        }
                    }//Fin liste deroulante donn�es standards
                }// Fin GESTION DES LISTES DE TABLES DE DONNEES EXTERNES
            }
            //Si c une cl� mais pas une table de donn�es externes..... (heu dans quel cas..?)
            // -------------------------------------------------
            //GESTION DES LISTE DEROULANTES STANDARDS
            else
            {
                $fieldnameaffiche =	@mysql_field_name(mysql_query("Select * from ".$tablename), 1);//Champ de la table a afficher
                $ListeResult =  mysql_query("Select * from ".$tablename." order by ".$fieldnameaffiche);

                echo "<select class=\"".$StyleChamps."\" ".$input_allow." id=\"".$form_fieldname."\" name=\"".$form_fieldname."\">";
                for ($i=0;$i<@mysql_num_rows($ListeResult) ;$i++)
                {
                    if ($mode=="modif") //on selectionne dans la liste l'element correspondant a l'enregistrement
                    {
                        if ($fieldvalue==@mysql_result($ListeResult,$i,"id_".$tablename)) {$selected = "selected";}	else {$selected = "";}
                    }
                    echo "<option value=\"".@mysql_result($ListeResult,$i,"id_".$tablename)."\" ".$selected.">".coupe_espace(strip_tags(@mysql_result($ListeResult,$i,$fieldnameaffiche)),$NbMaxCar)."</option>";
                }
                echo "</select>";
            }
            // -------------------------------------------------

            // recupere les options suppl�mentaires li�es au champ (nouveau, modif popup id par ex)
            get_option_edit_table();

            echo "</td>";
        }
    }
    }


    }
    //Fin de la boucle sur chacun des champs de la requete

    // BOUTON Pour post Facebook lors de validation
    if($_SESSION['ses_profil_user'] == '1' && $_GET["TableDef"] == _CONST_TABLEDEF_ACTUALITE)
    {
        echo '<tr>
                <td valign="middle">Poster sur Facebook à la Validation</td>
                <td colspan="2">
                    <input type="checkbox" value="1" id="post_on_facebook" name="post_on_facebook">
                </td>
            </tr>';
    }

    echo "</table>" ;
    echo "</div>";

    //remet a jour les path pr fichier d'upload (d'une langue a l'autre, les chemins sont les memes)
    $CtImUpload=0;

    }
    echo "</div>";
    echo "</div>";

    ?>
    <table border="0" cellspacing="1" cellpadding="3" width="90%">
<?
//SBA 25/11/2004
//Inclusion des champs de formulaires pour les formulaires
        if ($object_type==3 && $TableDef==_CONST_TABLEDEF_GAB_FORMULAIRE)
        {
            include "include/inc_object_formulaire.inc.php";
        }
// FIN SPEC SBA

//SDE 05/02/2003
//Inclusion du workflow pour les objets de type editorial (type=3)
        if ($object_type==3 && $object_wkf>1) {
            include "include/inc_object_workflow.inc.php";
        }
        if ($mode=="modif")
        {
            //$TitreBouton = $TitreBoutonArray[1];//On affecte a la variable titre bouton
            $TitreBouton = $inc_form_valider." >>";
        }
        if ($mode=="nouveau")
        {
            //$TitreBouton = $TitreBoutonArray[0];//On affecte a la variable titre bouton
            $TitreBouton = $inc_form_valider." >>";
        }
        if ($mode=="supr")
        {

        }

        if ($DisplayMode=="PopUp")
        {
            $RetourTarget = "javascript:PopupClose()";
            $Retour = $inc_form_fermer;

            // permet de controler les actions sur la validation d'un formulaire fils ouvert en popup
            if ($_REQUEST['reloadRef'] == 1 )
            {
                echo("<input type=\"hidden\" name=\"reloadRef\" value=\"1\">");
            }
        }
        else
        {
            if ($idItem)//retour sur les objets
            {
                $RetourTarget = NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=3&idItem=".$idItem."&formMain_selection=".$formMain_selection;
            }
            elseif (isset($_REQUEST['target']) && $_REQUEST['target'])//redirection vers une page autre la page elle-meme
            {
                $RetourTarget = $_REQUEST['target'];
            }
            else //retour sur le formulaire
            {
                $RetourTarget = NomFichier($_SERVER['PHP_SELF'],0)."?TableDef=$TableDef&DisplayMode=".$DisplayMode."&Search=".$Search."&ordre=".$ordre."&AscDesc=".$AscDesc."&formMain_selection=".$formMain_selection;
            }
        }

//echo "<tr><td colspan=\"3\"><br><A HREF=\"".$RetourTarget."\">".$Retour."</A></td></tr>";
    }


        //Retablisement du bon mode pour le formulaire appellant la popup
        if (isset($_REQUEST['ModeReferer']) && $_REQUEST['ModeReferer'] && $DisplayMode!="PopUp") {
            //			$mode = $_REQUEST['ModeReferer'];
        }


        //On ecrit la fonction qui va controle la saisie des champs
        echo "\n<script>\n";
        echo "function verif_fields() {\n";

        if ($mode=="modif" || $mode=="nouveau")
        {

            $cp=0;
            foreach($ar_required_fields_name as $value)
            {
                echo "if (!FS_ReqdFlds(formulaire,formulaire.".$value.",'".$ar_required_fields_alias[$cp]."',".$ar_required_fields_len[$cp].")) return false;\n";
                $cp++;
            }
        }

        echo "\nreturn true;}\n</script>\n";

        ?>
    <tr><td colspan="3" align="left">
        <?
        //Mode duplication
        //Date 12/02/2003
        if ($methode=="duplicate")
        {
            $TitreBouton = $inc_form_dupliquer;

        }
        //AFFICHAGE DU BOUTON ACTION
        //FFR changement du label du bouton pour la fiche centre en mode modification
        if($mode=="modif" && $_GET["TableDef"]==_CONST_TABLEDEF_CENTRE){
            $TitreBouton = "Valider les modifications";
        }

        $action_button = new bo_button();
        $action_button->c1 = $MenuBgColor;
        $action_button->c2 = $MainFontColor;
        if (($mode=="modif" || $mode=="nouveau" ) && in_array($_GET["TableDef"],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) ) {
            $action_button->name = "Valider et mettre en ligne >>";
        }else{
            $action_button->name = $TitreBouton;
        }


        //SPEC FFR TLY --> controle form specifique
        if($_REQUEST["TableDef"]==_CONST_TABLEDEF_CENTRE && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE && $mode!="supr")
        {
            $action_button->action = "validFormCentre()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_ORGANISATEUR_CVL && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormOrganisateurCVL()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_CLASSE_DECOUVERTE && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormClasseDecouverte()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_ACCUEIL_GROUPE && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormAccueilScolaire()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_CVL && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormCVL()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_ACCUEIL_REUNION && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormAccueilReunion()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_SEMINAIRE && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormSeminaires()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_GROUPE_ADULTE && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormAccueilGroupes()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_TOURISTIQUE && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormSejourTouristique()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_STAGE_THEM_GROUPE && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormSejourStageThemGroupe()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormSejourAccueilIndFamille()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_SHORT_BREAK && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormShortBreaksInd()";
        }
        elseif($_REQUEST["TableDef"]==_CONST_TABLEDEF_SEJOUR_STAGE_THEM_INDIVIDUEL && $_SESSION["ses_profil_user"]==_PROFIL_CENTRE  && $mode!="supr")
        {
            $action_button->action = "validFormStageThemIndividuel()";
        }
        else
        {
            $action_button->action = "valid_form()";
        }

        $action_button2 = new bo_button();
        $action_button2->c1 = $MenuBgColor;
        $action_button2->c2 = $MainFontColor;
        $action_button2->name = "Enregistrer sans mise en ligne";
        $action_button2->action = "valid_form_avec_desactivation('$mode','".$_REQUEST["ID"]."','".$_REQUEST["TableDef"]."')";


        if ($DisplayMode=="PopUp") {

            echo"
       <table>
        <tr>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td>
            <table cellspacing=\"1\" cellpadding=\"3\" border=\"0\" bgcolor=\"#b3bb57\">
            		<tbody>
                  <tr>
            			<td bgcolor=\"#e9ebcf\" title=\"\" onclick=\"window.close();\" style=\"cursor: pointer; background-color: rgb(233, 235, 207); color: rgb(0, 0, 0);\" onmouseout=\"this.style.backgroundColor='#e9ebcf';this.style.color='#000000'\" onmouseover=\"this.style.backgroundColor='#bec56f';this.style.color='#e5e5e5'\">
            			<<&nbsp;&nbsp;$Retour&nbsp;&nbsp;
            			</td>
            		</tr>
            	</tbody></table>
              </td>";



        }else{

            echo"
     <table>
     <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>
        <table cellspacing=\"1\" cellpadding=\"3\" border=\"0\" bgcolor=\"#b3bb57\">
        		<tbody>
              <tr>
        			<td bgcolor=\"#e9ebcf\" title=\"\" onclick=\"Annuler_form('$RetourTarget','".$_GET["mode"]."');\" style=\"cursor: pointer; background-color: rgb(233, 235, 207); color: rgb(0, 0, 0);\" onmouseout=\"this.style.backgroundColor='#e9ebcf';this.style.color='#000000'\" onmouseover=\"this.style.backgroundColor='#bec56f';this.style.color='#e5e5e5'\">
        			<<&nbsp;&nbsp;$Retour&nbsp;&nbsp;
        			</td>
        		</tr>
        	</tbody></table>
          </td>";

        }





        if (($mode=="modif" || $mode=="nouveau" ) && in_array($_GET["TableDef"],$GLOBALS["_CONST_TABLEDEF_SEJOUR"]) ) {
            echo"<td>";
            $action_button2->display();
            echo"</td>";
        }

        echo"<td>";

        //PERMET DE VALIDER OU NON EN FONCTION DU WORKFLOW
        //YCU
        //26/09/2003
        if ($workflow_allow==1 || $object_type!=3)
        {
            $action_button->display();
        }
        echo "</td></tr></table>";

        ?>
    </td>
        <?
    if( ( ( $TableDef >= 325 ) && ( $TableDef <= 330 ) ) || ( $TableDef == 330 ) ||
        ( $TableDef == 335 ) || ( $TableDef == 340 ) || ( $TableDef == 344 ) )
    {
        ?>
        <td>

            <script language="javascript">

                function previewDoc( )
                {
                    var ActionSaved = window.document.forms['formulaire'].action;

                    var f = window.document.forms['formulaire'];

                    f.action = 'preview.php' + window.location.search;
                    f.target = '_blank';

                    f.submit( );

                    f.action = ActionSaved;
                    f.target = '';
                }
            </script>
        <td>
            <?
            $preview_button = new bo_button( );
            $preview_button->c1 = $MenuBgColor;
            $preview_button->c2 = $MainFontColor;
            $preview_button->name = "Preview";
            $preview_button->action = "previewDoc( )";
            $preview_button->display( );
            ?>

        </td></tr>
    <?
    }
        ?>
    </table>
        <? /* A priori ne sert a rien.. mais evite la perte de valeurs dans le passage de $_REQUEST..*/ ?>
        <input type="hidden" name="dummy" id="dummy" value="1">
        </form>
        <?
        //Gestion en javascript des calendriers pour la saisie des dates
        echo "<script>\n";
        foreach ($arr_date_popup as $key => $value)
        {
            echo "var cal_".$key." = new CalendarPopup('datediv_".$key."');\n";
        }
        echo "</script>\n";

    }

    //Procedure de validation des modifications
    include "include/inc_form_action.inc.php";
}
