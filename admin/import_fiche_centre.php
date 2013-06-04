<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	TLY 							  
/*	Date : 		JUIN 2009
/*	Version :	1.0							  
/*	Fichier :	index.php						  
/*										  
/*	Description :	Home page Front office du site                        

/**********************************************************************************/
echo "ttt";
// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");




function objectsIntoArray($arrObjData, $arrSkipIndices = array())
{
    $arrData = array();
    
    // if input is object, convert into array
    if (is_object($arrObjData)) {
        $arrObjData = get_object_vars($arrObjData);
    }
    
    if (is_array($arrObjData)) {
        foreach ($arrObjData as $index => $value) {
            if (is_object($value) || is_array($value)) {
                $value = objectsIntoArray($value, $arrSkipIndices); // recursive call
            }
            if (in_array($index, $arrSkipIndices)) {
                continue;
            }
            $arrData[$index] = $value;
        }
    }
    return $arrData;
}
?>

Usage:

<?php
$xmlUrl = "export/export_fiche_centre.xml"; // XML feed file/URL
$xmlStr = file_get_contents($xmlUrl);
$xmlObj = simplexml_load_string($xmlStr);
$arrXml = objectsIntoArray($xmlObj);
/*
echo "<pre>";
print_r($arrXml["RESULTSET"]["ROW"]);
echo "</pre>";
*/
$j = 0;
foreach($arrXml["RESULTSET"]["ROW"] as $val){

    $id = $val["@attributes"]["RECORDID"];
    //echo "id = ".$id."<br>";

    $i = 0;
    foreach($val as $values){
    
          if($j>0){
          
          trace($values);
          //echo( explode("",$values[163]["DATA"])."<br>" );
            //if($j==74){
                //trace($val);
            //}
            //-----------------------------------------
            // Traduction
            $telephone                    = $values[10]["DATA"];
            $fax                          = $values[11]["DATA"];
            $tel_resa                     = $values[12]["DATA"];
            $fax_resa                     = $values[13]["DATA"];
            $acces_route_texte            = $values[19]["DATA"];
            $acces_train_texte            = $values[21]["DATA"];
            $acces_avion_texte            = $values[23]["DATA"];
            $acces_bus_texte              = $values[25]["DATA"];
            $presentaion                  = $values[26]["DATA"];
            $decouverte_touristique       = $values[141]["DATA"];
            $agrement_edu_nationale_texte = $values[127]["DATA"];
            $agrement_jeunesse_texte      = $values[125]["DATA"];
            $agrement_tourisme_texte      = $values[123]["DATA"];
            $agrement_ddass_texte         = $values[129]["DATA"];                                  
            // ----------------------------------------
            if($values[1]["DATA"] == "oui"){
              $etat = 1;
            }else{
              $etat = 0;
            }
            // ----------------------------------------
            //Ambiance centre
            $tab = array();
            $ambiance_centre="";
            $tab = explode("\n",$values[2]["DATA"]);
            foreach($tab as $valActivite){
              $texte = $valActivite;
              if($texte !="Array" && $texte){
                $sql_S = "select id__centre_ambiance from trad_centre_ambiance where libelle='$texte'";
                $result_S = mysql_query($sql_S);
                $nb = mysql_num_rows($result_S);
                if($nb){
                    $ambiance_centre.= mysql_result($result_S,0,"id__centre_ambiance").",";
                }else{
                    $sql_I = "insert into centre_ambiance (libelle) VALUES('')";
                    $result_II = mysql_query($sql_I);
                    $id = mysql_insert_id();
                    
                    $sql_I = "insert into trad_centre_ambiance (id__centre_ambiance ,id__langue ,libelle) VALUES ('$id','1','$texte')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_ambiance (id__centre_ambiance ,id__langue ,libelle) VALUES ('$id','2','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_ambiance (id__centre_ambiance ,id__langue ,libelle) VALUES ('$id','3','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_ambiance (id__centre_ambiance ,id__langue ,libelle) VALUES ('$id','5','')";
                    $result_I = mysql_query($sql_I);
                    $ambiance_centre.= $id.",";
                }
              }
            }
            
            
           
            // ----------------------------------------
            // Environnement
            $tab = array();
            $centre_environnement="";
            $tab = explode("\n",$values[3]["DATA"]);
            foreach($tab as $valActivite){
              $texte = $valActivite;
              if($texte !="Array" && $texte){
                $sql_S = "select id__centre_environnement from trad_centre_environnement where libelle='$texte'";
                $result_S = mysql_query($sql_S);
                $nb = mysql_num_rows($result_S);
                if($nb){
                    $centre_environnement.= mysql_result($result_S,0,"id__centre_environnement").",";
                }else{
                    $sql_I = "insert into centre_environnement (libelle) VALUES('')";
                    $result_II = mysql_query($sql_I);
                    $id = mysql_insert_id();
                    
                    $sql_I = "insert into trad_centre_environnement (id__centre_environnement ,id__langue ,libelle) VALUES ('$id','1','$texte')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_environnement (id__centre_environnement ,id__langue ,libelle) VALUES ('$id','2','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_environnement (id__centre_environnement ,id__langue ,libelle) VALUES ('$id','3','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_environnement (id__centre_environnement ,id__langue ,libelle) VALUES ('$id','5','')";
                    $result_I = mysql_query($sql_I);
                    $centre_environnement.= $id.",";
                }
              }
            }
            // ----------------------------------------
            // Centre environnement montagne
            $tab = array();
            $centre_environnement_montagne="";
            $tab = explode("\n",$values[4]["DATA"]);
            foreach($tab as $valActivite){
              $texte = $valActivite;
              if($texte !="Array" && $texte){
                $sql_S = "select id__centre_environnement_montagne from trad_centre_environnement_montagne where libelle='$texte'";
                $result_S = mysql_query($sql_S);
                $nb = mysql_num_rows($result_S);
                if($nb){
                    $centre_environnement_montagne.= mysql_result($result_S,0,"id__centre_environnement_montagne").",";
                }else{
                    $sql_I = "insert into centre_environnement_montagne (libelle) VALUES('')";
                    $result_I = mysql_query($sql_I);
                    $id = mysql_insert_id();
                    
                    $sql_I = "insert into trad_centre_environnement_montagne (id__centre_environnement_montagne ,id__langue ,libelle) VALUES ('$id','1','$texte')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_environnement_montagne (id__centre_environnement_montagne ,id__langue ,libelle) VALUES ('$id','2','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_environnement_montagne (id__centre_environnement_montagne ,id__langue ,libelle) VALUES ('$id','3','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_environnement_montagne (id__centre_environnement_montagne ,id__langue ,libelle) VALUES ('$id','5','')";
                    $result_I = mysql_query($sql_I);
                    $centre_environnement_montagne.= $id.",";
                }
              }
            }
            // ----------------------------------------
            // Région
            if($values[17]["DATA"] != "Array" && $values[17]["DATA"] !=""){
              $sql_S = "select id_centre_region from centre_region where libelle='".addslashes($values[17]["DATA"])."'";
              
              $result_S = mysql_query($sql_S);
              $nb = mysql_num_rows($result_S);
              if($nb>0){
                $id_region = mysql_result($result_S,0,"id_centre_region");
              }else{
                $sql_I = "insert into centre_region (libelle) VALUES ('".addslashes($values[17]["DATA"])."')";
                //echo $sql_I."<br>";
                $result_I = mysql_query($sql_I);
                $id_region = mysql_insert_id();
              }
            }
            // ----------------------------------------
            // Acces route
            if($values[18]["DATA"] == "oui"){
              $acces_route = "Oui";
            }else{
              $acces_route="Non";
            }
            // ----------------------------------------
            // Acces train
            if($values[20]["DATA"] == "oui"){
              $acces_train = "Oui";
            }else{
              $acces_train="Non";
            }
            // ----------------------------------------
            // Acces Avion
            if($values[22]["DATA"] == "oui"){
              $acces_avion = "Oui";
            }else{
              $acces_avion="Non";
            }
            // ----------------------------------------
            // Acces Bus
            if($values[24]["DATA"] == "oui"){
              $acces_bus = "Oui";
            }else{
              $acces_bus="Non";
            }
            // ----------------------------------------
            // Type Couvert
            $tab = array();
            $tab = explode("\n",$values[37]["DATA"]);
            if(in_array("self-service ou plats sur table",$tab)){
              $couvert_self = "1";
            }else{
              $couvert_self = "0";
            }
            
            if(in_array("à l'assiette",$tab)){
              $couvert_assiette = "1";
            }else{
              $couvert_assiette = "0";
            }
            // ----------------------------------------
            // detention_label
            $tab = array();
            $id_centre_detention_label="";
            $tab = explode("\n",$values[120]["DATA"]);
            if(in_array("moteur",$tab)){
              $id_centre_detention_label .= "2,";
            }
            if(in_array("mental",$tab)){
              $id_centre_detention_label .= "3,";
            }
            if(in_array("auditif",$tab)){
              $id_centre_detention_label .= "4,";
            }
            if(in_array("visuel",$tab)){
              $id_centre_detention_label .= "5,";
            }
            if($values[121]["DATA"]== "oui"){
              $id_centre_detention_label .= "1,";
            }
            // ----------------------------------------
            // Agréments :
            if($values[122]["DATA"]== "oui"){
              $agrement_tourisme = "Oui";
            }else{
              $agrement_tourisme = "Non";
            }
            if($values[124]["DATA"]== "oui"){
              $agrement_jeunesse = "Oui";
            }else{
              $agrement_jeunesse = "Non";
            }
            if($values[126]["DATA"]== "oui"){
              $agrement_edu_nationale = "Oui";
            }else{
              $agrement_edu_nationale = "Non";
            }
            if($values[128]["DATA"]== "oui"){
              $agrement_ddass = "Oui";
            }else{
              $agrement_ddass = "Non";
            }
            if($values[130]["DATA"]== "oui"){
              $agrement_formation = "Oui";
            }else{
              $agrement_formation = "Non";
            }
            if($values[132]["DATA"]== "oui"){
              $agrement_ancv = "Oui";
            }else{
              $agrement_ancv = "Non";
            }
            if($values[134]["DATA"]== "oui"){
              $agrement_autre = "Oui";
            }else{
              $agrement_autre = "Non";
            }
            // ----------------------------------------
            // Activité
            $tab = array();
            $id_activite="";
            $tab = explode("\n",$values[162]["DATA"]);
            foreach($tab as $valActivite){
              $texte = $valActivite;
              if($texte !="Array" && $texte){
                $sql_S = "select id__centre_activite from trad_centre_activite where libelle='$texte'";
                $result_S = mysql_query($sql_S);
                $nb = mysql_num_rows($result_S);
                if($nb){
                    $id_activite.= mysql_result($result_S,0,"id__centre_activite").",";
                }else{
                    $sql_I = "insert into centre_activite (libelle) VALUES('')";
                    $result_I = mysql_query($sql_I);
                    $id = mysql_insert_id();
                    
                    $sql_I = "insert into trad_centre_activite (id__centre_activite ,id__langue ,libelle) VALUES ('$id','1','$texte')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_activite (id__centre_activite ,id__langue ,libelle) VALUES ('$id','2','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_activite (id__centre_activite ,id__langue ,libelle) VALUES ('$id','3','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_activite (id__centre_activite ,id__langue ,libelle) VALUES ('$id','5','')";
                    $result_I = mysql_query($sql_I);
                    $id_activite.= $id.",";
                }
              }
            }

            // ----------------------------------------
            // Service
            $tab = array();
            $id_service="";
            
            $tab = explode("\n",$values[232]["DATA"]);
          
            //die();
            foreach($tab as $valService){
              $texte = $valService;
              $texte = trim($texte);
              
              if($texte !="Array" && $texte){
                $sql_S = "select id__centre_service from trad_centre_service where libelle='$texte'";
                $result_S = mysql_query($sql_S);
                $nb = mysql_num_rows($result_S);
                
                if($nb){
                    $id_service.= mysql_result($result_S,0,"id__centre_service").",";
                }else{
                    $sql_I = "INSERT INTO centre_service (libelle) VALUES('')";
                    $result_I = mysql_query($sql_I);
                    $id = mysql_insert_id();
                    
                    $sql_I = "insert into trad_centre_service (id__centre_service ,id__langue ,libelle) VALUES ('$id','1','$texte')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_service (id__centre_service ,id__langue ,libelle) VALUES ('$id','2','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_service (id__centre_service ,id__langue ,libelle) VALUES ('$id','3','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_service (id__centre_service ,id__langue ,libelle) VALUES ('$id','5','')";
                    $result_I = mysql_query($sql_I);
                    $id_service.= $id.",";
                }
              }
            }
           
            // ----------------------------------------
            // Centre détente
            $tab = array();
            $id_detente="";
            $tab = explode("\n",$values[233]["DATA"]);
            foreach($tab as $valDetente){
              $texte = $valDetente;
              if($texte !="Array" && $texte){
                $sql_S = "select id__centre_espace_detente from trad_centre_espace_detente where libelle='$texte'";
                $result_S = mysql_query($sql_S);
                $nb = mysql_num_rows($result_S);
                if($nb){
                    $id_detente.= mysql_result($result_S,0,"id__centre_espace_detente").",";
                }else{
                    $sql_I = "insert into centre_espace_detente (libelle) VALUES('')";
                    $result_I = mysql_query($sql_I);
                    $id = mysql_insert_id();
                    
                    $sql_I = "insert into trad_centre_espace_detente (id__centre_espace_detente ,id__langue ,libelle) VALUES ('$id','1','$texte')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_espace_detente (id__centre_espace_detente ,id__langue ,libelle) VALUES ('$id','2','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_espace_detente (id__centre_espace_detente ,id__langue ,libelle) VALUES ('$id','3','')";
                    $result_I = mysql_query($sql_I);
                    $sql_I = "insert into trad_centre_espace_detente (id__centre_espace_detente ,id__langue ,libelle) VALUES ('$id','5','')";
                    $result_I = mysql_query($sql_I);
                    $id_detente.= $id.",";
                }
              }
            }

            // ----------------------------------------
            $sql = "INSERT INTO centre (  id_centre,
                                          libelle,
                                          etat,
                                          id_centre_ambiance,
                                          id_centre_environnement,
                                          id_centre_environnement_montagne,
                                          adresse,
                                          code_postal,
                                          ville,
                                          site_internet,
                                          email,
                                          latitude,
                                          longitude,
                                          id_centre_region,  
                                          acces_route_4,
                                          acces_train_4,
                                          acces_avion_4,
                                          acces_bus_metro_4,
                                          id_centre_classement,
                                          id_centre_classement_1,
                                          nb_lit,
                                          nb_chambre,
                                          nb_chambre_handicap,
                                          nb_lit_handicap,
                                          nb_couvert,
                                          couvert_assiette,
                                          couvert_self,
                                          nb_salle_reunion,
                                          capacite_salle_max,
                                          id_centre_detention_label,                                         
                                          agrement_tourisme_4,
                                          agrement_tourisme_texte,
                                          agrement_jeunesse_4,
                                          agrement_jeunesse_texte,
                                          agrement_edu_nationale_4,
                                          agrement_edu_nationale_texte,
                                          agrement_ddass_4,
                                          agrement_ddass_texte,
                                          agrement_formation_4,
                                          agrement_formation_text,
                                          agrement_ancv_4,
                                          agrement_ancv_text,
                                          agrement_autre_4,
                                          agrement_autre_text,
                                          id_centre_activite,
                                          aerodrome_surplace,
                                          aerodrome_proche,
                                          aerodrome_distance,
                                          centre_equestre_surplace,
                                          centre_equestre_proche,
                                          centre_equestre_distance,
                                          centre_nautique_surplace,
                                          centre_nautique_proche,
                                          centre_nautique_distance,
                                          salle_sport_surplace,
                                          salle_sport_proche,
                                          salle_sport_distance,
                                          terrain_jeux_surplace,
                                          terrain_jeux_proche,
                                          terrain_jeux_distance,
                                          parcours_sante_surplace,
                                          parcours_sante_proche,
                                          parcours_sante_distance,
                                          sauna_surplace,
                                          sauna_proche,
                                          sauna_distance,
                                          terrain_boule_surplace,
                                          terrain_boule_proche,
                                          terrain_boule_distance,
                                          gymnase_surplace,
                                          gymnase_proche,
                                          gymnase_distance,
                                          raquette_surplace,
                                          raquette_proche,
                                          raquette_distance,
                                          arc_surplace,
                                          arc_proche,
                                          arc_distance,
                                          escalade_surplace,
                                          escalade_proche,
                                          escalade_distance,
                                          patinoire_surplace,
                                          patinoire_proche,
                                          patinoire_distance,
                                          pingpong_surplace,
                                          pingpong_proche,
                                          pingpong_distance,
                                          musculation_surplace,
                                          musculation_proche,
                                          musculation_distance,
                                          stade_surplace,
                                          stade_proche,
                                          stade_distance,
                                          tennis_surplace,
                                          tennis_proche,
                                          tennis_distance,
                                          sentier_surplace,
                                          sentier_proche,
                                          sentier_distance,
                                          swingolf_surplace,
                                          swingolf_proche,
                                          swingolf_distance,
                                          velodrome_surplace,
                                          velodrome_proche,
                                          velodrome_distance,
                                          practice_surplace,
                                          practice_proche,
                                          practice_distance,
                                          golf_surplace,
                                          golf_proche,
                                          golf_distance,
                                          dojo_surplace,
                                          dojo_proche,
                                          dojo_distance,
                                          id_centre_service,
                                          id_centre_espace_detente)
                            VALUES ('".$id."',
                                    '".addslashes($values[0]["DATA"])."',
                                    '".$etat."',
                                    '".$ambiance_centre."',
                                    '".$centre_environnement."',
                                    '".$centre_environnement_montagne."',
                                    '".addslashes($values[5]["DATA"])."',
                                    '".addslashes($values[6]["DATA"])."',
                                    '".addslashes($values[7]["DATA"])."',
                                    '".addslashes($values[9]["DATA"])."',
                                    '".addslashes($values[14]["DATA"])."',
                                    '".addslashes($values[15]["DATA"])."',
                                    '".addslashes($values[16]["DATA"])."',
                                    '$id_region',
                                    '$acces_route',
                                    '$acces_train',
                                    '$acces_avion',
                                    '$acces_bus',
                                    '".addslashes($values[27]["DATA"])."',
                                    '".addslashes($values[29]["DATA"])."',
                                    '".addslashes($values[31]["DATA"])."',
                                    '".addslashes($values[32]["DATA"])."',
                                    '".addslashes($values[33]["DATA"])."',
                                    '".addslashes($values[34]["DATA"])."',
                                    '".addslashes($values[36]["DATA"])."',
                                    '$couvert_assiette',
                                    '$couvert_self',
                                    '".addslashes($values[38]["DATA"])."',
                                    '".addslashes($values[39]["DATA"])."',
                                    '$id_centre_detention_label',
                                    '$agrement_tourisme',
                                    '".addslashes($values[123]["DATA"])."',
                                    '$agrement_jeunesse',
                                    '".addslashes($values[125]["DATA"])."',
                                    '$agrement_edu_nationale',
                                    '".addslashes($values[127]["DATA"])."',
                                    '$agrement_ddass',
                                    '".addslashes($values[129]["DATA"])."',
                                    '$agrement_formation',
                                    '".addslashes($values[131]["DATA"])."',
                                    '$agrement_ancv',
                                    '".addslashes($values[133]["DATA"])."',
                                    '$agrement_autre',
                                    '".addslashes($values[135]["DATA"])."',
                                    '$id_activite',
                                    IF ('".$values[163]["DATA"]."'='oui',1,0),
                                    IF ('".$values[164]["DATA"]."'='oui',1,0),
                                    '".$values[165]["DATA"]."',
                                    IF ('".$values[166]["DATA"]."'='oui',1,0),
                                    IF ('".$values[167]["DATA"]."'='oui',1,0),
                                    '".$values[168]["DATA"]."',
                                    IF ('".$values[169]["DATA"]."'='oui',1,0),
                                    IF ('".$values[170]["DATA"]."'='oui',1,0),
                                    '".$values[171]["DATA"]."',
                                    IF ('".$values[172]["DATA"]."'='oui',1,0),
                                    IF ('".$values[173]["DATA"]."'='oui',1,0),
                                    '".$values[174]["DATA"]."',
                                    IF ('".$values[175]["DATA"]."'='oui',1,0),
                                    IF ('".$values[176]["DATA"]."'='oui',1,0),
                                    '".$values[177]["DATA"]."',
                                    IF ('".$values[178]["DATA"]."'='oui',1,0),
                                    IF ('".$values[179]["DATA"]."'='oui',1,0),
                                    '".$values[180]["DATA"]."',
                                    IF ('".$values[181]["DATA"]."'='oui',1,0),
                                    IF ('".$values[182]["DATA"]."'='oui',1,0),
                                    '".$values[183]["DATA"]."',
                                    IF ('".$values[184]["DATA"]."'='oui',1,0),
                                    IF ('".$values[185]["DATA"]."'='oui',1,0),
                                    '".$values[186]["DATA"]."',
                                    IF ('".$values[187]["DATA"]."'='oui',1,0),
                                    IF ('".$values[188]["DATA"]."'='oui',1,0),
                                    '".$values[189]["DATA"]."',
                                    IF ('".$values[190]["DATA"]."'='oui',1,0),
                                    IF ('".$values[191]["DATA"]."'='oui',1,0),
                                    '".$values[192]["DATA"]."',
                                    IF ('".$values[193]["DATA"]."'='oui',1,0),
                                    IF ('".$values[194]["DATA"]."'='oui',1,0),
                                    '".$values[195]["DATA"]."',
                                    IF ('".$values[196]["DATA"]."'='oui',1,0),
                                    IF ('".$values[197]["DATA"]."'='oui',1,0),
                                    '".$values[198]["DATA"]."',
                                    IF ('".$values[199]["DATA"]."'='oui',1,0),
                                    IF ('".$values[200]["DATA"]."'='oui',1,0),
                                    '".$values[201]["DATA"]."',
                                    IF ('".$values[202]["DATA"]."'='oui',1,0),
                                    IF ('".$values[203]["DATA"]."'='oui',1,0),
                                    '".$values[204]["DATA"]."',
                                    IF ('".$values[205]["DATA"]."'='oui',1,0),
                                    IF ('".$values[206]["DATA"]."'='oui',1,0),
                                    '".$values[207]["DATA"]."',
                                    IF ('".$values[208]["DATA"]."'='oui',1,0),
                                    IF ('".$values[209]["DATA"]."'='oui',1,0),
                                    '".$values[210]["DATA"]."',
                                    IF ('".$values[211]["DATA"]."'='oui',1,0),
                                    IF ('".$values[212]["DATA"]."'='oui',1,0),
                                    '".$values[213]["DATA"]."',
                                    IF ('".$values[214]["DATA"]."'='oui',1,0),
                                    IF ('".$values[215]["DATA"]."'='oui',1,0),
                                    '".$values[216]["DATA"]."',
                                    IF ('".$values[217]["DATA"]."'='oui',1,0),
                                    IF ('".$values[218]["DATA"]."'='oui',1,0),
                                    '".$values[219]["DATA"]."',
                                    IF ('".$values[220]["DATA"]."'='oui',1,0),
                                    IF ('".$values[221]["DATA"]."'='oui',1,0),
                                    '".$values[222]["DATA"]."',
                                    IF ('".$values[223]["DATA"]."'='oui',1,0),
                                    IF ('".$values[224]["DATA"]."'='oui',1,0),
                                    '".$values[225]["DATA"]."',
                                    IF ('".$values[226]["DATA"]."'='oui',1,0),
                                    IF ('".$values[227]["DATA"]."'='oui',1,0),
                                    '".$values[228]["DATA"]."',
                                    IF ('".$values[229]["DATA"]."'='oui',1,0),
                                    IF ('".$values[230]["DATA"]."'='oui',1,0),
                                    '".$values[231]["DATA"]."',
                                    '$id_service',
                                    '$id_detente')";
            $sql = str_replace("Array","",$sql);
            echo $id."- ".$values[0]["DATA"]."<br>";
            if($values[0]["DATA"] != ""){
              $result = mysql_query($sql);
              $idCentre = mysql_insert_id() or die(mysql_error());
              
              $sql_I = "insert into trad_centre ( id__langue,
                                                  id__centre,
                                                  acces_route_texte,
                                                  acces_train_texte,
                                                  acces_avion_texte,
                                                  acces_bus_metro_texte,
                                                  presentation,
                                                  agrement_edu_nationale_texte,
                                                  agrement_jeunesse_texte,
                                                  agrement_tourisme_texte,
                                                  agrement_ddass_texte,
                                                  presentation_region,
                                                  telephone,
                                                  fax,
                                                  tel_resa,
                                                  fax_resa)
                                                  
                                          VALUES  ( '1',
                                                    '$idCentre',
                                                    '".addslashes($acces_route_texte)."',
                                                    '".addslashes($acces_train_texte)."',
                                                    '".addslashes($acces_avion_texte)."',
                                                    '".addslashes($acces_bus_texte)."',
                                                    '".addslashes($presentaion)."',
                                                    '".addslashes($agrement_edu_nationale_texte)."',
                                                    '".addslashes($agrement_jeunesse_texte)."',
                                                    '".addslashes($agrement_tourisme_texte)."',
                                                    '".addslashes($agrement_ddass_texte)."',
                                                    '".addslashes($decouverte_touristique)."',
                                                    '".addslashes($telephone)."',
                                                    '".addslashes($fax)."',
                                                    '".addslashes($tel_resa)."',
                                                    '".addslashes($fax_resa)."')";
                                                    
              $sql_I = str_replace("Array","",$sql_I);                                      
              $result_I = mysql_query($sql_I) or die(mysql_error());
              
              $sql_I = "insert into trad_centre (id__langue,id__centre) VALUES ('2','$idCentre')";
              $result_I = mysql_query($sql_I);
              $sql_I = "insert into trad_centre (id__langue,id__centre) VALUES ('3','$idCentre')";
              $result_I = mysql_query($sql_I);
              $sql_I = "insert into trad_centre (id__langue,id__centre) VALUES ('5','$idCentre')";
              $result_I = mysql_query($sql_I);
              
              // Centre détail hebergement
              $cmpt = 40;
              for($k = 1; $k<9 ; $k++){
                  $cmpt = 40 +($k-1);
                  $cmpt2 = $cmpt+8;
                  $cmpt3 = $cmpt2+8;
                  $cmpt4 = $cmpt3+8;
                  $cmpt5 = $cmpt4+8;
                  $cmpt6 = $cmpt5+8;
                  $cmpt7 = $cmpt6+8;
                  $cmpt8 = $cmpt7+8;
                  $cmpt9 = $cmpt8+8;
                  $cmpt10 = $cmpt9+8;
                  $sql_I = "insert into centre_detail_hebergement ( id_centre_2,
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
                                                                
                                                      VALUES ('".$idCentre."',
                                                              '$k',
                                                              '".$values[$cmpt]["DATA"]."',
                                                              '".$values[$cmpt2]["DATA"]."',
                                                              '".$values[$cmpt3]["DATA"]."',
                                                              '".$values[$cmpt4]["DATA"]."',
                                                              '".$values[$cmpt5]["DATA"]."',
                                                              '".$values[$cmpt6]["DATA"]."',
                                                              '".$values[$cmpt7]["DATA"]."',
                                                              '".$values[$cmpt8]["DATA"]."',
                                                              '".$values[$cmpt9]["DATA"]."',
                                                              '".$values[$cmpt10]["DATA"]."')";
                  
                  
                  $sql_I = str_replace("Array","",$sql_I);  
                  $result_I = mysql_query($sql_I);
              
              }
              //-----------------------------
              // Site touristiques
              for($k=1;$k<11;$k++){
                $cmpt = 142 + (2* ($k-1));
                $cmpt2 = $cmpt+1;
                
                if($values[$cmpt]["DATA"] != "Array" && $values[$cmpt]["DATA"]!="" && $values[$cmpt2]["DATA"]!="Array"){
                  $sql_I    = "INSERT INTO centre_site_touristique (adresse,id_centre_1) VALUES ('".$values[$cmpt2]["DATA"]."','$idCentre')";
                  
                    $result_I = mysql_query($sql_I);           
                    $idSite   = mysql_insert_id(); 
                    echo $sql_I."<br>";
                    $sql_I    = "INSERT INTO trad_centre_site_touristique ( id__centre_site_touristique,
                                                                            libelle,
                                                                            id__langue)
                                                                            
                                                               VALUES     ( '".$idSite."',
                                                                            '".$values[$cmpt]["DATA"]."',
                                                                            '1')";
                    $sql_I = str_replace("Array","",$sql_I); 
                    $result_I = mysql_query($sql_I); 
                    
                    
                    $sql_I    = "INSERT INTO trad_centre_site_touristique ( id__centre_site_touristique,libelle,id__langue)    VALUES     ( '".$idSite."','','2')";
                    $result_I = mysql_query($sql_I); 
                    $sql_I    = "INSERT INTO trad_centre_site_touristique ( id__centre_site_touristique,libelle,id__langue)    VALUES     ( '".$idSite."','','3')";
                    $result_I = mysql_query($sql_I);
                    $sql_I    = "INSERT INTO trad_centre_site_touristique ( id__centre_site_touristique,libelle,id__langue)    VALUES     ( '".$idSite."','','5')";
                    $result_I = mysql_query($sql_I);  
                  }
               
              }
              //-----------------------------
              // Les + du centre
              for($k=1;$k<6;$k++){
                $cmpt = 135+$k;
                
                if($values[$cmpt]["DATA"] != "Array" && $values[$cmpt]["DATA"] != ""){
                  $sql_I        = "INSERT INTO centre_les_plus (id_centre_1) VALUES ('$idCentre')";
                  $result_I     = mysql_query($sql_I);           
                  $idlesplus    = mysql_insert_id(); 
                  
                  $sql_I        = "INSERT INTO trad_centre_les_plus ( id__centre_les_plus,
                                                                          libelle,
                                                                          id__langue)
                                                                          
                                                             VALUES     ( '".$idlesplus."',
                                                                          '".$values[$cmpt]["DATA"]."',
                                                                          '1')";
                  $sql_I = str_replace("Array","",$sql_I); 
                  $result_I = mysql_query($sql_I); 
                  
                  
                  $sql_I    = "INSERT INTO trad_centre_les_plus ( id__centre_les_plus,libelle,id__langue)    VALUES     ( '".$idlesplus."','','2')";
                  $result_I = mysql_query($sql_I); 
                  $sql_I    = "INSERT INTO trad_centre_les_plus ( id__centre_les_plus,libelle,id__langue)    VALUES     ( '".$idlesplus."','','3')";
                  $result_I = mysql_query($sql_I);
                  $sql_I    = "INSERT INTO trad_centre_les_plus ( id__centre_les_plus,libelle,id__langue)    VALUES     ( '".$idlesplus."','','5')";
                  $result_I = mysql_query($sql_I);  
                }
              }
              //-----------------------------
              // Accueil groupe jeune adulte
              $sql_I    = "INSERT INTO accueil_groupes_jeunes_adultes (id_centre) VALUES ('$idCentre')";
              $result_I = mysql_query($sql_I);
              $idSejour = mysql_insert_id(); 
              $sql_I    = "INSERT INTO sejour_tarif_groupe ( HS_bb,
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
                                                                        
                                                              VALUES (  '".$values[234]["DATA"]."',
                                                                        '".$values[235]["DATA"]."',
                                                                        '".$values[236]["DATA"]."',
                                                                        '".$values[237]["DATA"]."',
                                                                        '".$values[238]["DATA"]."',
                                                                        '".$values[239]["DATA"]."',
                                                                        '".$values[240]["DATA"]."',
                                                                        '".$values[241]["DATA"]."',
                                                                        '".$values[242]["DATA"]."',
                                                                        '".$values[243]["DATA"]."',
                                                                        '".$values[244]["DATA"]."',
                                                                        '".$values[245]["DATA"]."',
                                                                        '"._CONST_TABLEDEF_GROUPE_ADULTE."',
                                                                        '$idSejour')";
              $sql_I = str_replace("Array","",$sql_I); 
              //echo $sql_I."<br>";
              $result_I = mysql_query($sql_I);
              
              $sql_I    = "INSERT INTO sejour_tarif_groupe_plus       ( HS_bb,
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
                                                                        
                                                              VALUES (  '".$values[276]["DATA"]."',
                                                                        '".$values[277]["DATA"]."',
                                                                        '".$values[278]["DATA"]."',
                                                                        '".$values[279]["DATA"]."',
                                                                        '".$values[280]["DATA"]."',
                                                                        '".$values[281]["DATA"]."',
                                                                        '".$values[282]["DATA"]."',
                                                                        '".$values[283]["DATA"]."',
                                                                        '".$values[284]["DATA"]."',
                                                                        '".$values[285]["DATA"]."',
                                                                        '".$values[286]["DATA"]."',
                                                                        '".$values[287]["DATA"]."',
                                                                        '"._CONST_TABLEDEF_GROUPE_ADULTE."',
                                                                        '$idSejour')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              
              $sql_I    = "INSERT INTO trad_accueil_groupes_jeunes_adultes (id__accueil_groupes_jeunes_adultes,
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '1',
                                                                  '".$values[270]["DATA"]."',
                                                                  '".$values[271]["DATA"]."',
                                                                  '".$values[272]["DATA"]."',
                                                                  '".$values[312]["DATA"]."',
                                                                  '".$values[313]["DATA"]."',
                                                                  '".$values[314]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I) or die(mysql_error());
              $sql_I    = "INSERT INTO trad_accueil_groupes_jeunes_adultes (id__accueil_groupes_jeunes_adultes, 
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '2',
                                                                  '".$values[270]["DATA"]."',
                                                                  '".$values[271]["DATA"]."',
                                                                  '".$values[272]["DATA"]."',
                                                                  '".$values[312]["DATA"]."',
                                                                  '".$values[313]["DATA"]."',
                                                                  '".$values[314]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              $sql_I    = "INSERT INTO trad_accueil_groupes_jeunes_adultes (id__accueil_groupes_jeunes_adultes, 
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '3',
                                                                  '".$values[270]["DATA"]."',
                                                                  '".$values[271]["DATA"]."',
                                                                  '".$values[272]["DATA"]."',
                                                                  '".$values[312]["DATA"]."',
                                                                  '".$values[313]["DATA"]."',
                                                                  '".$values[314]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              $sql_I    = "INSERT INTO trad_accueil_groupes_jeunes_adultes (id__accueil_groupes_jeunes_adultes, 
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '5',
                                                                  '".$values[270]["DATA"]."',
                                                                  '".$values[271]["DATA"]."',
                                                                  '".$values[272]["DATA"]."',
                                                                  '".$values[312]["DATA"]."',
                                                                  '".$values[313]["DATA"]."',
                                                                  '".$values[314]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              //-----------------------------
              // Accueil individuel
              $sql_I    = "INSERT INTO accueil_individuels_familles (id_centre) VALUES ('$idCentre')";
              $result_I = mysql_query($sql_I);
              $idSejour = mysql_insert_id(); 
              $sql_I    = "INSERT INTO sejour_tarif_groupe ( HS_bb,
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
                                                                        
                                                              VALUES (  '".$values[246]["DATA"]."',
                                                                        '".$values[247]["DATA"]."',
                                                                        '".$values[248]["DATA"]."',
                                                                        '".$values[249]["DATA"]."',
                                                                        '".$values[250]["DATA"]."',
                                                                        '".$values[251]["DATA"]."',
                                                                        '".$values[252]["DATA"]."',
                                                                        '".$values[253]["DATA"]."',
                                                                        '".$values[254]["DATA"]."',
                                                                        '".$values[255]["DATA"]."',
                                                                        '".$values[256]["DATA"]."',
                                                                        '".$values[257]["DATA"]."',
                                                                        '"._CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE."',
                                                                        '$idSejour')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              
              $sql_I    = "INSERT INTO sejour_tarif_groupe_plus ( HS_bb,
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
                                                                        
                                                              VALUES (  '".$values[288]["DATA"]."',
                                                                        '".$values[289]["DATA"]."',
                                                                        '".$values[290]["DATA"]."',
                                                                        '".$values[291]["DATA"]."',
                                                                        '".$values[292]["DATA"]."',
                                                                        '".$values[293]["DATA"]."',
                                                                        '".$values[294]["DATA"]."',
                                                                        '".$values[295]["DATA"]."',
                                                                        '".$values[296]["DATA"]."',
                                                                        '".$values[297]["DATA"]."',
                                                                        '".$values[298]["DATA"]."',
                                                                        '".$values[299]["DATA"]."',
                                                                        '"._CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE."',
                                                                        '$idSejour')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              
              
              $sql_I    = "INSERT INTO trad_accueil_individuels_familles (id__accueil_individuels_familles,
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '1',
                                                                  '".$values[270]["DATA"]."',
                                                                  '".$values[271]["DATA"]."',
                                                                  '".$values[272]["DATA"]."',
                                                                  '".$values[312]["DATA"]."',
                                                                  '".$values[313]["DATA"]."',
                                                                  '".$values[314]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              $sql_I    = "INSERT INTO trad_accueil_individuels_familles (id__accueil_individuels_familles,
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '2',
                                                                  '".$values[270]["DATA"]."',
                                                                  '".$values[271]["DATA"]."',
                                                                  '".$values[272]["DATA"]."',
                                                                  '".$values[312]["DATA"]."',
                                                                  '".$values[313]["DATA"]."',
                                                                  '".$values[314]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              $sql_I    = "INSERT INTO trad_accueil_individuels_familles (id__accueil_individuels_familles,
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '3',
                                                                  '".$values[270]["DATA"]."',
                                                                  '".$values[271]["DATA"]."',
                                                                  '".$values[272]["DATA"]."',
                                                                  '".$values[312]["DATA"]."',
                                                                  '".$values[313]["DATA"]."',
                                                                  '".$values[314]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              $sql_I    = "INSERT INTO trad_accueil_individuels_familles (id__accueil_individuels_familles,
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '5',
                                                                  '".$values[270]["DATA"]."',
                                                                  '".$values[271]["DATA"]."',
                                                                  '".$values[272]["DATA"]."',
                                                                  '".$values[312]["DATA"]."',
                                                                  '".$values[313]["DATA"]."',
                                                                  '".$values[314]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              //-----------------------------
              // Accueil de scolaire
              $sql_I    = "INSERT INTO accueil_groupes_scolaires (id_centre) VALUES ('$idCentre')";
              $result_I = mysql_query($sql_I);
              $idSejour = mysql_insert_id(); 
              $sql_I    = "INSERT INTO sejour_tarif_groupe ( HS_bb,
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
                                                                        
                                                              VALUES (  '".$values[258]["DATA"]."',
                                                                        '".$values[259]["DATA"]."',
                                                                        '".$values[260]["DATA"]."',
                                                                        '".$values[261]["DATA"]."',
                                                                        '".$values[262]["DATA"]."',
                                                                        '".$values[263]["DATA"]."',
                                                                        '".$values[264]["DATA"]."',
                                                                        '".$values[265]["DATA"]."',
                                                                        '".$values[266]["DATA"]."',
                                                                        '".$values[267]["DATA"]."',
                                                                        '".$values[268]["DATA"]."',
                                                                        '".$values[269]["DATA"]."',
                                                                        '"._CONST_TABLEDEF_ACCUEIL_GROUPE."',
                                                                        '$idSejour')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              $sql_I    = "INSERT INTO sejour_tarif_groupe_plus ( HS_bb,
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
                                                                        
                                                              VALUES (  '".$values[300]["DATA"]."',
                                                                        '".$values[301]["DATA"]."',
                                                                        '".$values[302]["DATA"]."',
                                                                        '".$values[303]["DATA"]."',
                                                                        '".$values[304]["DATA"]."',
                                                                        '".$values[305]["DATA"]."',
                                                                        '".$values[306]["DATA"]."',
                                                                        '".$values[307]["DATA"]."',
                                                                        '".$values[308]["DATA"]."',
                                                                        '".$values[309]["DATA"]."',
                                                                        '".$values[310]["DATA"]."',
                                                                        '".$values[311]["DATA"]."',
                                                                        '"._CONST_TABLEDEF_ACCUEIL_GROUPE."',
                                                                        '$idSejour')";
                                                                        
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              
              $sql_I    = "INSERT INTO trad_accueil_groupes_scolaires (id__accueil_groupes_scolaires,
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '1',
                                                                  '".$values[273]["DATA"]."',
                                                                  '".$values[274]["DATA"]."',
                                                                  '".$values[275]["DATA"]."',
                                                                  '".$values[315]["DATA"]."',
                                                                  '".$values[316]["DATA"]."',
                                                                  '".$values[317]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              $sql_I    = "INSERT INTO trad_accueil_groupes_scolaires (id__accueil_groupes_scolaires,
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '2',
                                                                  '".$values[273]["DATA"]."',
                                                                  '".$values[274]["DATA"]."',
                                                                  '".$values[275]["DATA"]."',
                                                                  '".$values[315]["DATA"]."',
                                                                  '".$values[316]["DATA"]."',
                                                                  '".$values[317]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              $sql_I    = "INSERT INTO trad_accueil_groupes_scolaires (id__accueil_groupes_scolaires,
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '3',
                                                                  '".$values[273]["DATA"]."',
                                                                  '".$values[274]["DATA"]."',
                                                                  '".$values[275]["DATA"]."',
                                                                  '".$values[315]["DATA"]."',
                                                                  '".$values[316]["DATA"]."',
                                                                  '".$values[317]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              $sql_I    = "INSERT INTO trad_accueil_groupes_scolaires (id__accueil_groupes_scolaires,
                                                                            id__langue,
                                                                            haute_saison,
                                                                            moyenne_saison,
                                                                            basse_saison,
                                                                            haute_saison_n1,
                                                                            moyenne_saison_n1,
                                                                            basse_saison_n1) 
                                                                            
                                                          VALUES ('$idSejour',
                                                                  '5',
                                                                  '".$values[273]["DATA"]."',
                                                                  '".$values[274]["DATA"]."',
                                                                  '".$values[275]["DATA"]."',
                                                                  '".$values[315]["DATA"]."',
                                                                  '".$values[316]["DATA"]."',
                                                                  '".$values[317]["DATA"]."')";
              $sql_I = str_replace("Array","",$sql_I); 
              $result_I = mysql_query($sql_I);
              
              //-----------------------------
              
            }
            
            $i++;
          }
          $j++;
    }
    
}


$sql = "DELETE FROM centre_site_touristique WHERE adresse='Array'";
$result = mysql_query($sql);

$sql = "select id_centre_les_plus from centre_les_plus";
$result = mysql_query($sql);
while($myrow = mysql_fetch_array($result)){
    $sql_S = "select libelle from trad_centre_les_plus where id__langue=1 and id__centre_les_plus='".$myrow["id_centre_les_plus"]."'";
    $result_S = mysql_query($sql_S);
    $libelle = mysql_result($result_S,0,"libelle");
    if($libelle == ""){
      $sql_D = "delete from trad_centre_les_plus where id__centre_les_plus='".$myrow["id_centre_les_plus"]."'";
      $result_D = mysql_query($sql_D);
      
      $sql_D = "delete from centre_les_plus where id_centre_les_plus='".$myrow["id_centre_les_plus"]."'";
      $result_D = mysql_query($sql_D);
    }
}
$sql = "DELETE FROM centre_region WHERE libelle='Array'";
$result = mysql_query($sql);
?>
