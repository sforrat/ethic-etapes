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


// Initialisation de la page
$path="../";
require($path."include/inc_header.inc.php");



if($_POST["action"]==1){


$cmptOuvertureFichier = 0;

$id_langue = $_POST["langueExport"];


$xml = "<?xml version=\"1.0\" encoding=\"utf-8\" ?>";
$xml.= "<FICHESCENTRE>";

$sql = "SELECT DISTINCT centre.*, trad_centre.* FROM centre INNER JOIN trad_centre ON (centre.id_centre = trad_centre.id__centre and trad_centre.id__langue=".$id_langue.")";



$result = mysql_query($sql) or die(mysql_error()."<br>Requete : ".$sql);
$nb = mysql_num_rows($result);


while($myrow = mysql_fetch_array($result)){
	
	if($cmptOuvertureFichier == 0){
		$fp = fopen("export_centre.xml", 'w');
		$cmptOuvertureFichier = 1;
	}else{
		$fp = fopen("export_centre.xml", 'a');
	}
	
	$xml.= "<centre>";

	// ----------------------------------------------------------------
	$xml.= "  <nom><![CDATA[".$myrow["libelle"]."]]></nom>\n";

	// ----------------------------------------------------------------
	$xml.= "  <Fiche_publiee>";
	if($myrow["etat"] == 1){
		$xml.= "oui";
	}else{
		$xml.= "non";
	}
	$xml.= "</Fiche_publiee>\n";
	// ----------------------------------------------------------------
	$xml.= "<Ambiance>";
	if($myrow["id_centre_ambiance"]!=""){
		$texte = test_virgule_fin($myrow["id_centre_ambiance"]);
		$sql_S = "select trad_centre_ambiance.libelle from trad_centre_ambiance where id__langue=".$id_langue." and id__centre_ambiance in (".$texte.")";

		$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
		while($myrow_S = mysql_fetch_array($result_S)){
			$xml.= $myrow_S["libelle"]."\n";
		}
	}
	$xml.= "</Ambiance>\n";
	// ----------------------------------------------------------------
	$xml.= "<thematique>";
	if($myrow["id_centre_environnement"]!=""){

		$texte = test_virgule_fin($myrow["id_centre_environnement"]);
		$sql_S = "select trad_centre_environnement.libelle from trad_centre_environnement where id__langue=".$id_langue." and id__centre_environnement in (".$texte.")";
		$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
		while($myrow_S = mysql_fetch_array($result_S)){
			$xml.= $myrow_S["libelle"]."\n";
		}
	}
	$xml.= "</thematique>\n";
	// ----------------------------------------------------------------
	$xml.= "<environnement_montagne>";
	if($myrow["id_centre_environnement_montagne"]!=""){
		$texte = test_virgule_fin($myrow["id_centre_environnement_montagne"]);
		$sql_S = "select trad_centre_environnement_montagne.libelle  from trad_centre_environnement_montagne where id__langue=".$id_langue." and id__centre_environnement_montagne in (".$texte.")";

		$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
		while($myrow_S = mysql_fetch_array($result_S)){
			$xml.= $myrow_S["libelle"]."\n";
		}
	}
	$xml.= "</environnement_montagne>\n";
	// ----------------------------------------------------------------
	$xml.= "<adresse>".$myrow["adresse"]."</adresse>\n";
	// ----------------------------------------------------------------
	$xml.= "<cp>".$myrow["code_postal"]."</cp>\n";
	// ----------------------------------------------------------------
	$xml.= "<ville>".$myrow["ville"]."</ville>\n";
	// ----------------------------------------------------------------
	$xml.= "<web>".$myrow["site_internet"]."</web>\n";
	// ----------------------------------------------------------------
	$xml.= "<telephone>".$myrow["telephone"]."</telephone>\n";
	// ----------------------------------------------------------------
	$xml.= "<fax>".$myrow["fax"]."</fax>\n";
	// ----------------------------------------------------------------
	$xml.= "<tel_resa>".$myrow["tel_resa"]."</tel_resa>\n";
	// ----------------------------------------------------------------
	$xml.= "<fax_resa>".$myrow["fax_resa"]."</fax_resa>\n";
	// ----------------------------------------------------------------
	$xml.= "<email>".$myrow["email"]."</email>\n";
	// ----------------------------------------------------------------
	$xml.= "<latitude>".$myrow["latitude"]."</latitude>\n";
	// ----------------------------------------------------------------
	$xml.= "<longitude>".$myrow["longitude"]."</longitude>\n";
	// ----------------------------------------------------------------
	$xml.= "  <acces_route>";
	if($myrow["acces_route_4"] == "Oui"){
		$xml.= "oui";
	}else{
		$xml.= "non";
	}
	$xml.= "</acces_route>\n";
	// ----------------------------------------------------------------
	$xml.= "  <acces_route_texte>".$myrow["acces_route_texte"]."</acces_route_texte>\n";
	// ----------------------------------------------------------------
	$xml.= "  <acces_train>";
	if($myrow["acces_train_4"] == "Oui"){
		$xml.= "oui";
	}else{
		$xml.= "non";
	}
	$xml.= "</acces_train>\n";
	// ----------------------------------------------------------------
	$xml.= "  <acces_train_texte>".$myrow["acces_train_texte"]."</acces_train_texte>\n";
	// ----------------------------------------------------------------
	$xml.= "  <acces_avion>";
	if($myrow["acces_avion_4"] == "Oui"){
		$xml.= "oui";
	}else{
		$xml.= "non";
	}
	$xml.= "</acces_avion>\n";
	// ----------------------------------------------------------------
	$xml.= "  <acces_avion_texte>".$myrow["acces_avion_texte"]."</acces_avion_texte>\n";
	// ----------------------------------------------------------------
	$xml.= "  <acces_bus_metro>";
	if($myrow["acces_bus_metro_4"] =="Oui"){
		$xml.= "oui";
	}else{
		$xml.= "non";
	}
	$xml.= "</acces_bus_metro>\n";
	// ----------------------------------------------------------------
	$xml.= "  <acces_bus_metro_texte>".$myrow["acces_bus_metro_texte"]."</acces_bus_metro_texte>\n";
	// ----------------------------------------------------------------
	$xml.= "  <presentation><![CDATA[".$myrow["presentation"]."]]></presentation>\n";
	// ----------------------------------------------------------------
	$xml.= "  <classement1>".$myrow["id_centre_classement"]."</classement1>\n";
	// ----------------------------------------------------------------
	$xml.= "  <classement2>".$myrow["id_centre_classement_1"]."</classement2>\n";
	// ----------------------------------------------------------------
	$xml.= "  <nb_lit>".$myrow["nb_lit"]."</nb_lit>\n";
	// ----------------------------------------------------------------
	$xml.= "  <nb_chambre>".$myrow["nb_chambre"]."</nb_chambre>\n";
	// ----------------------------------------------------------------
	$xml.= "  <nb_chambre_handicap>".$myrow["nb_chambre_handicap"]."</nb_chambre_handicap>\n";
	// ----------------------------------------------------------------
	$xml.= "  <nb_lit_handicap>".$myrow["nb_lit_handicap"]."</nb_lit_handicap>\n";
	// ----------------------------------------------------------------
	$xml.= "  <nb_couvert>".$myrow["nb_couvert"]."</nb_couvert>\n";
	// ----------------------------------------------------------------
	$xml.= "  <type_service>";
	if($myrow["couvert_assiette"] == 1){
		$xml.= "à l'assiette\n";
	}
	if($myrow["couvert_self"] == 1){
		$xml.= "self service ou plats sur table";
	}
	$xml.="</type_service>\n";
	// ----------------------------------------------------------------
	$xml.= "<nb_salle_reunion>".$myrow["nb_salle_reunion"]."</nb_salle_reunion>\n";
	// ----------------------------------------------------------------
	$xml.= "<capacite_salle>".$myrow["capacite_salle"]."</capacite_salle>\n";
	// ----------------------------------------------------------------
	for($cmpt=1;$cmpt<=8;$cmpt++){
		$sql_S    = "select * from centre_detail_hebergement where id_centre_2='".$myrow["id_centre"]."' and id_centre_type_chambre=$cmpt";
		$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
		$myrow_S  = mysql_fetch_array($result_S);
		$xml.= "<C_totalch$cmpt>".$myrow_S["nb_chambre"]."</C_totalch$cmpt>\n";
		$xml.= "<C_totallits$cmpt>".$myrow_S["nb_lit"]."</C_totallits$cmpt>\n";
		$xml.= "<C_nb_lavDouWC_chambre$cmpt>".$myrow_S["nb_lavDouWC_chambre"]."</C_nb_lavDouWC_chambre$cmpt>\n";
		$xml.= "<C_nb_lavDouWC_lit$cmpt>".$myrow_S["nb_lavDouWC_lit"]."</C_nb_lavDouWC_lit$cmpt>\n";
		$xml.= "<C_nb_lavDou_chambre$cmpt>".$myrow_S["nb_lavDou_chambre"]."</C_nb_lavDou_chambre$cmpt>\n";
		$xml.= "<C_nb_lavDou_lit$cmpt>".$myrow_S["nb_lavDou_lit"]."</C_nb_lavDou_lit$cmpt>\n";
		$xml.= "<C_nb_lavOuWC_chambre$cmpt>".$myrow_S["nb_lavOuWC_chambre"]."</C_nb_lavOuWC_chambre$cmpt>\n";
		$xml.= "<C_nb_lavOuWC_lit$cmpt>".$myrow_S["nb_lavOuWC_lit"]."</C_nb_lavOuWC_lit$cmpt>\n";
		$xml.= "<C_nb_noWC_chambre$cmpt>".$myrow_S["nb_noWC_chambre"]."</C_nb_noWC_chambre$cmpt>\n";
		$xml.= "<C_nb_noWC_lit$cmpt>".$myrow_S["nb_noWC_lit"]."</C_nb_noWC_lit$cmpt>\n";
		// ----------------------------------------------------------------
	}
	$label =  explode(",",$myrow["id_centre_detention_label"]);
	if(in_array(1,$label)){
		$xml.= "<Ecolabel_obstention>oui</Ecolabel_obstention>\n";
	}else{
		$xml.= "<Ecolabel_obstention>non</Ecolabel_obstention>\n";
	}
	$handicap="";

	foreach($label as $val){
		if($val >0){
			$sql_S = "select libelle from trad_centre_detention_label where id__centre_detention_label=$val and id__langue=1";
			$result_S = mysql_query($sql_S) or die($sql_S.mysql_error());
			$myrow_S  = mysql_fetch_array($result_S);
			$handicap .= $myrow_S["libelle"]."\n";
		}
	}
	$xml.= "<labellisation_tourismehandicap>$handicap</labellisation_tourismehandicap>\n";
	// ----------------------------------------------------------------
	$xml.= "<agrement_tourisme_ouinon>".$myrow["agrement_tourisme_4"]."</agrement_tourisme_ouinon>\n";
	$xml.= "<agrement_tourisme_numero>".$myrow["agrement_tourisme_texte"]."</agrement_tourisme_numero>\n";
	$xml.= "<agrement_jeunesse_et_sports_ouinon>".$myrow["agrement_jeunesse_4"]."</agrement_jeunesse_et_sports_ouinon>\n";
	$xml.= "<agrement_jeunesse_et_sports_numero>".$myrow["agrement_jeunesse_texte"]."</agrement_jeunesse_et_sports_numero>\n";
	$xml.= "<agrement_education_nationale_ouinon>".$myrow["agrement_edu_nationale_4"]."</agrement_education_nationale_ouinon>\n";
	$xml.= "<agrement_edu_nationale_numero>".$myrow["agrement_edu_nationale_texte"]."</agrement_edu_nationale_numero>\n";
	$xml.= "<agrement_ddass_ouinon>".$myrow["agrement_ddass_4"]."</agrement_ddass_ouinon>\n";
	$xml.= "<agrement_ddass_numero>".$myrow["agrement_ddass_texte"]."</agrement_ddass_numero>\n";
	$xml.= "<agrement_formation_ouinon>".$myrow["agrement_formation_4"]."</agrement_formation_ouinon>\n";
	$xml.= "<agrement_formation_numero>".$myrow["agrement_formation_text"]."</agrement_formation_numero>\n";
	$xml.= "<agrement_ancv_ouinon>".$myrow["agrement_ancv_4"]."</agrement_ancv_ouinon>\n";
	$xml.= "<agrement_ancv_numero>".$myrow["agrement_ancv_text"]."</agrement_ancv_numero>\n";
	$xml.= "<agrement_autre>".$myrow["agrement_autre_4"]."</agrement_autre>\n";
	$xml.= "<agrement_autre_numero>".$myrow["agrement_autre_text"]."</agrement_autre_numero>\n";
	// ----------------------------------------------------------------

	$sql_S = "SELECT
				trad_centre_les_plus.libelle 
			FROM 
				trad_centre_les_plus
			INNER JOIN 
				centre_les_plus ON (trad_centre_les_plus.id__centre_les_plus = centre_les_plus.id_centre_les_plus AND trad_centre_les_plus.id__langue=$id_langue AND centre_les_plus.id_centre_1=".$myrow["id_centre"].")"; 
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	$cmpt = 1;
	while($myrow_S = mysql_fetch_array($result_S)){
		$xml.= "<les_plus_centres$cmpt><![CDATA[".$myrow_S["libelle"]."]]></les_plus_centres$cmpt>\n";
		$cmpt++;
	}
	// ----------------------------------------------------------------
	$environnement =  explode(",",$myrow["id_centre_environnement"]);
	$txt="";
	foreach($environnement as $val){
		if($val != 1 && $val!=""){
			$sql_S = "select libelle from trad_centre_environnement where id__centre_environnement=$val and id__langue=1";
			$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
			$myrow_S  = mysql_fetch_array($result_S);
			$txt .= $myrow_S["libelle"]."\n";
		}
	}
	$xml.= "<environnement>".$txt."</environnement>\n";
	// ----------------------------------------------------------------

	$sql_S = "SELECT
				trad_centre_site_touristique.libelle ,
				centre_site_touristique.adresse
			FROM 
				trad_centre_site_touristique
			INNER JOIN 
				centre_site_touristique ON (trad_centre_site_touristique.id__centre_site_touristique = centre_site_touristique.id_centre_site_touristique AND trad_centre_site_touristique.id__langue=$id_langue AND centre_site_touristique.id_centre_1=".$myrow["id_centre"].")"; 
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	$cmpt = 1;
	while($myrow_S = mysql_fetch_array($result_S)){
		$xml.= "<site_touristique_$cmpt><![CDATA[".$myrow_S["libelle"]."]]></site_touristique_$cmpt>\n";
		$xml.= "<site_touristique_".$cmpt."_lien><![CDATA[".$myrow_S["adresse"]."]]></site_touristique_".$cmpt."_lien>\n";
		$cmpt++;
	}
	// ----------------------------------------------------------------
	$tab =  explode(",",$myrow["id_centre_activite"]);
	$txt="";
	foreach($tab as $val){
		if($val>0){
			$sql_S = "select libelle from trad_centre_activite where id__centre_activite=$val and id__langue=1";
			$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
			$myrow_S  = mysql_fetch_array($result_S);
			$txt .= $myrow_S["libelle"]."\n";
		}
	}
	$xml.= "<activites_groupes_et_individuels>".$txt."</activites_groupes_et_individuels>\n";
	// ----------------------------------------------------------------
	if($myrow["aerodrome_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<aerodrome>".$txt."</aerodrome>\n";
	if($myrow["aerodrome_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<aerodrome_pr>".$txt."</aerodrome_pr>\n";
	$xml.= "<aerodrome_pr_dist>".$myrow["aerodrome_distance"]."</aerodrome_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["centre_equestre_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<centre_equestre>".$txt."</centre_equestre>\n";
	if($myrow["centre_equestre_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<centre_equestre_pr>".$txt."</centre_equestre_pr>\n";
	$xml.= "<centre_equestre_pr_dist>".$myrow["centre_equestre_distance"]."</centre_equestre_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["centre_nautique_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<centre_nautique>".$txt."</centre_nautique>\n";
	if($myrow["centre_nautique_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<centre_nautique_pr>".$txt."</centre_nautique_pr>\n";
	$xml.= "<centre_nautique_pr_dist>".$myrow["centre_nautique_distance"]."</centre_nautique_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["salle_sport_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<salle_sport>".$txt."</salle_sport>\n";
	if($myrow["salle_sport_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<salle_sport_pr>".$txt."</salle_sport_pr>\n";
	$xml.= "<salle_sport_pr_dist>".$myrow["salle_sport_distance"]."</salle_sport_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["terrain_jeux_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<terrain_jeux>".$txt."</terrain_jeux>\n";
	if($myrow["terrain_jeux_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<terrain_jeux_pr>".$txt."</terrain_jeux_pr>\n";
	$xml.= "<terrain_jeux_pr_dist>".$myrow["terrain_jeux_distance"]."</terrain_jeux_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["parcours_sante_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<parcours_sante>".$txt."</parcours_sante>\n";
	if($myrow["parcours_sante_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<parcours_sante_pr>".$txt."</parcours_sante_pr>\n";
	$xml.= "<parcours_sante_pr_dist>".$myrow["parcours_sante_distance"]."</parcours_sante_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["sauna_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<sauna>".$txt."</sauna>\n";
	if($myrow["sauna_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<sauna_pr>".$txt."</sauna_pr>\n";
	$xml.= "<sauna_pr_dist>".$myrow["sauna_distance"]."</sauna_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["terrain_boule_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<terrain_boule>".$txt."</terrain_boule>\n";
	if($myrow["terrain_boule_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<terrain_boule_pr>".$txt."</terrain_boule_pr>\n";
	$xml.= "<terrain_boule_pr_dist>".$myrow["terrain_boule_distance"]."</terrain_boule_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["gymnase_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<gymnase>".$txt."</gymnase>\n";
	if($myrow["gymnase_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<gymnase_pr>".$txt."</gymnase_pr>\n";
	$xml.= "<gymnase_pr_dist>".$myrow["gymnase_distance"]."</gymnase_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["raquette_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<raquette>".$txt."</raquette>\n";
	if($myrow["raquette_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<raquette_pr>".$txt."</raquette_pr>\n";
	$xml.= "<raquette_pr_dist>".$myrow["raquette_distance"]."</raquette_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["arc_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<arc>".$txt."</arc>\n";
	if($myrow["arc_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<arc_pr>".$txt."</arc_pr>\n";
	$xml.= "<arc_pr_dist>".$myrow["arc_distance"]."</arc_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["escalade_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<escalade>".$txt."</escalade>\n";
	if($myrow["escalade_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<escalade_pr>".$txt."</escalade_pr>\n";
	$xml.= "<escalade_pr_dist>".$myrow["escalade_distance"]."</escalade_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["patinoire_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<patinoire>".$txt."</patinoire>\n";
	if($myrow["patinoire_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<patinoire_pr>".$txt."</patinoire_pr>\n";
	$xml.= "<patinoire_pr_dist>".$myrow["patinoire_distance"]."</patinoire_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["pingpong_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<pingpong>".$txt."</pingpong>\n";
	if($myrow["pingpong_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<pingpong_pr>".$txt."</pingpong_pr>\n";
	$xml.= "<pingpong_pr_dist>".$myrow["pingpong_distance"]."</pingpong_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["musculation_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<musculation>".$txt."</musculation>\n";
	if($myrow["musculation_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<musculation_pr>".$txt."</musculation_pr>\n";
	$xml.= "<musculation_pr_dist>".$myrow["musculation_distance"]."</musculation_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["stade_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<stade>".$txt."</stade>\n";
	if($myrow["stade_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<stade_pr>".$txt."</stade_pr>\n";
	$xml.= "<stade_pr_dist>".$myrow["stade_distance"]."</stade_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["tennis_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<tennis>".$txt."</tennis>\n";
	if($myrow["tennis_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<tennis_pr>".$txt."</tennis_pr>\n";
	$xml.= "<tennis_pr_dist>".$myrow["tennis_distance"]."</tennis_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["sentier_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<sentier>".$txt."</sentier>\n";
	if($myrow["sentier_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<sentier_pr>".$txt."</sentier_pr>\n";
	$xml.= "<sentier_pr_dist>".$myrow["sentier_distance"]."</sentier_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["swingolf_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<swingolf>".$txt."</swingolf>\n";
	if($myrow["swingolf_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<swingolf_pr>".$txt."</swingolf_pr>\n";
	$xml.= "<swingolf_pr_dist>".$myrow["swingolf_distance"]."</swingolf_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["velodrome_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<velodrome>".$txt."</velodrome>\n";
	if($myrow["velodrome_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<velodrome_pr>".$txt."</velodrome_pr>\n";
	$xml.= "<velodrome_pr_dist>".$myrow["velodrome_distance"]."</velodrome_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["practice_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<practice>".$txt."</practice>\n";
	if($myrow["practice_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<practice_pr>".$txt."</practice_pr>\n";
	$xml.= "<practice_pr_dist>".$myrow["practice_distance"]."</practice_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["golf_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<golf>".$txt."</golf>\n";
	if($myrow["golf_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<golf_pr>".$txt."</golf_pr>\n";
	$xml.= "<golf_pr_dist>".$myrow["golf_distance"]."</golf_pr_dist>\n";
	// ----------------------------------------------------------------
	if($myrow["dojo_surplace"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<dojo>".$txt."</dojo>\n";
	if($myrow["dojo_proche"] == 1){
		$txt = "oui";
	}else{
		$txt = "non";
	}
	$xml.= "<dojo_pr>".$txt."</dojo_pr>\n";
	$xml.= "<dojo_pr_dist>".$myrow["dojo_distance"]."</dojo_pr_dist>\n";
	// ----------------------------------------------------------------
	$tab =  explode(",",$myrow["id_centre_service"]);
	$txt="";
	foreach($tab as $val){
		if($val != 1 && $val!=""){
			$sql_S = "select libelle from trad_centre_service where id__centre_service=$val and id__langue=1";
			$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
			$myrow_S  = mysql_fetch_array($result_S);
			$txt .= $myrow_S["libelle"]."\n";
		}
	}
	$xml.= "<services_dispos_centre><![CDATA[".$txt."]]></services_dispos_centre>\n";
	// ----------------------------------------------------------------
	$tab =  explode(",",$myrow["id_centre_espace_detente"]);
	$txt="";
	foreach($tab as $val){
		if($val != 1 && $val!=""){
			$sql_S = "select libelle from trad_centre_espace_detente where id__centre_espace_detente=$val and id__langue=1";
			$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
			$myrow_S  = mysql_fetch_array($result_S);
			$txt .= $myrow_S["libelle"]."\n";
		}
	}
	$xml.= "<espaces_detente><![CDATA[".$txt."]]></espaces_detente>\n";
	// ----------------------------------------------------------------
	$sql_S    = "select id_accueil_groupes_jeunes_adultes as id from accueil_groupes_jeunes_adultes where id_centre='".$myrow["id_centre"]."'";
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	$idSejour = mysql_result($result_S,0,"id");
	

  if(!$idSejour){
		$idSejour=9999999999;
	}
	$sql_S	  = "select
					HS_bb,
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
                    BS_rs
				FROM
					sejour_tarif_groupe
				WHERE
					IdSejour =".$idSejour." and id__table_def="._CONST_TABLEDEF_GROUPE_ADULTE ;
					
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	$xml.= "<GHb_HS_bb>".mysql_result($result_S,0,"HS_bb")."</GHb_HS_bb>\n";
	$xml.= "<GHb_HS_dp>".mysql_result($result_S,0,"HS_dp")."</GHb_HS_dp>\n";
	$xml.= "<GHb_HS_pc>".mysql_result($result_S,0,"HS_pc")."</GHb_HS_pc>\n";
	$xml.= "<GHb_HS_rs>".mysql_result($result_S,0,"HS_rs")."</GHb_HS_rs>\n";
	$xml.= "<GHb_MS_bb>".mysql_result($result_S,0,"MS_bb")."</GHb_MS_bb>\n";
	$xml.= "<GHb_MS_dp>".mysql_result($result_S,0,"MS_dp")."</GHb_MS_dp>\n";
	$xml.= "<GHb_MS_pc>".mysql_result($result_S,0,"MS_pc")."</GHb_MS_pc>\n";
	$xml.= "<GHb_MS_rs>".mysql_result($result_S,0,"MS_rs")."</GHb_MS_rs>\n";
	$xml.= "<GHb_BS_bb>".mysql_result($result_S,0,"BS_bb")."</GHb_BS_bb>\n";
	$xml.= "<GHb_BS_dp>".mysql_result($result_S,0,"BS_dp")."</GHb_BS_dp>\n";
	$xml.= "<GHb_BS_pc>".mysql_result($result_S,0,"BS_pc")."</GHb_BS_pc>\n";
	$xml.= "<GHb_BS_rs>".mysql_result($result_S,0,"BS_rs")."</GHb_BS_rs>\n";
	
	// ----------------------------------------------------------------
	$sql_S    = "select id_accueil_individuels_familles as id from accueil_individuels_familles where id_centre='".$myrow["id_centre"]."'";
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	$id_sejour_3 = mysql_result($result_S,0,"id");
	
	if(mysql_result($result_S,0,"id")>0){
		$sql_S	  = "select
					HS_bb,
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
                    BS_rs
				FROM
					sejour_tarif_groupe
				WHERE
					IdSejour =".mysql_result($result_S,0,"id")." and id__table_def="._CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE;
		$result_S = mysql_query($sql_S) or die($sql_S.mysql_error()."<br>Requete : ".$sql_S);
	}
	$xml.= "<IH_HS_bb>".mysql_result($result_S,0,"HS_bb")."</IH_HS_bb>\n";
	$xml.= "<IH_HS_dp>".mysql_result($result_S,0,"HS_dp")."</IH_HS_dp>\n";
	$xml.= "<IH_HS_pc>".mysql_result($result_S,0,"HS_pc")."</IH_HS_pc>\n";
	$xml.= "<IH_HS_rs>".mysql_result($result_S,0,"HS_rs")."</IH_HS_rs>\n";
	$xml.= "<IH_MS_bb>".mysql_result($result_S,0,"MS_bb")."</IH_MS_bb>\n";
	$xml.= "<IH_MS_dp>".mysql_result($result_S,0,"MS_dp")."</IH_MS_dp>\n";
	$xml.= "<IH_MS_pc>".mysql_result($result_S,0,"MS_pc")."</IH_MS_pc>\n";
	$xml.= "<IH_MS_rs>".mysql_result($result_S,0,"MS_rs")."</IH_MS_rs>\n";
	$xml.= "<IH_BS_bb>".mysql_result($result_S,0,"BS_bb")."</IH_BS_bb>\n";
	$xml.= "<IH_BS_dp>".mysql_result($result_S,0,"BS_dp")."</IH_BS_dp>\n";
	$xml.= "<IH_BS_pc>".mysql_result($result_S,0,"BS_pc")."</IH_BS_pc>\n";
	$xml.= "<IH_BS_rs>".mysql_result($result_S,0,"BS_rs")."</IH_BS_rs>\n";
	// ----------------------------------------------------------------
	$sql_S    = "select id_accueil_groupes_scolaires as id from accueil_groupes_scolaires where id_centre='".$myrow["id_centre"]."'";
  $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
  $idSejour2 = mysql_result($result_S,0,"id");
	if(mysql_result($result_S,0,"id")>0){
		$sql_S	  = "select
					HS_bb,
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
                    BS_rs
				FROM
					sejour_tarif_groupe
				WHERE
					IdSejour =".mysql_result($result_S,0,"id")." and id__table_def="._CONST_TABLEDEF_ACCUEIL_GROUPE;
		$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	}
	
	$xml.= "<TS_HS_bb>".mysql_result($result_S,0,"HS_bb")."</TS_HS_bb>\n";
	$xml.= "<TS_HS_dp>".mysql_result($result_S,0,"HS_dp")."</TS_HS_dp>\n";
	$xml.= "<TS_HS_pc>".mysql_result($result_S,0,"HS_pc")."</TS_HS_pc>\n";
	$xml.= "<TS_HS_rs>".mysql_result($result_S,0,"HS_rs")."</TS_HS_rs>\n";
	$xml.= "<TS_MS_bb>".mysql_result($result_S,0,"MS_bb")."</TS_MS_bb>\n";
	$xml.= "<TS_MS_dp>".mysql_result($result_S,0,"MS_dp")."</TS_MS_dp>\n";
	$xml.= "<TS_MS_pc>".mysql_result($result_S,0,"MS_pc")."</TS_MS_pc>\n";
	$xml.= "<TS_MS_rs>".mysql_result($result_S,0,"MS_rs")."</TS_MS_rs>\n";
	$xml.= "<TS_BS_bb>".mysql_result($result_S,0,"BS_bb")."</TS_BS_bb>\n";
	$xml.= "<TS_BS_dp>".mysql_result($result_S,0,"BS_dp")."</TS_BS_dp>\n";
	$xml.= "<TS_BS_pc>".mysql_result($result_S,0,"BS_pc")."</TS_BS_pc>\n";
	$xml.= "<TS_BS_rs>".mysql_result($result_S,0,"BS_rs")."</TS_BS_rs>\n";
	// ----------------------------------------------------------------
	if(!$idSejour){
		$idSejour=9999999999;
	}
	$sql_S = "	select
					        haute_saison,
                	moyenne_saison,
                	basse_saison,
                	haute_saison_n1,
                	moyenne_saison_n1,
                	basse_saison_n1
	           FROM
	           		trad_accueil_groupes_jeunes_adultes
	           where 
	          		id__langue=$id_langue and 
	          		id__accueil_groupes_jeunes_adultes=$idSejour";
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	$xml.= "<haute_saison_accueil_groupes_jeunes_adultes><![CDATA[".mysql_result($result_S,0,"haute_saison")."]]></haute_saison_accueil_groupes_jeunes_adultes>\n";
	$xml.= "<moyenne_saison_accueil_groupes_jeunes_adultes><![CDATA[".mysql_result($result_S,0,"moyenne_saison")."]]></moyenne_saison_accueil_groupes_jeunes_adultes>\n";
	$xml.= "<basse_saison_accueil_groupes_jeunes_adultes><![CDATA[".mysql_result($result_S,0,"basse_saison")."]]></basse_saison_accueil_groupes_jeunes_adultes>\n";
	$xml.= "<haute_saison_accueil_groupes_jeunes_adultes_n1><![CDATA[".mysql_result($result_S,0,"haute_saison_n1")."]]></haute_saison_accueil_groupes_jeunes_adultes_n1>\n";
	$xml.= "<moyenne_saison_accueil_groupes_jeunes_adultes_n1><![CDATA[".mysql_result($result_S,0,"moyenne_saison_n1")."]]></moyenne_saison_accueil_groupes_jeunes_adultes_n1>\n";
	$xml.= "<basse_saison_accueil_groupes_jeunes_adultes_n1><![CDATA[".mysql_result($result_S,0,"basse_saison_n1")."]]></basse_saison_accueil_groupes_jeunes_adultes_n1>\n";
	// ----------------------------------------------------------------
	if(!$idSejour2){
		$idSejour2=9999999999;
	}
	$sql_S = "	select
					haute_saison,
                	moyenne_saison,
                	basse_saison,
                	haute_saison_n1,
                	moyenne_saison_n1,
                	basse_saison_n1
	           FROM
	           		trad_accueil_groupes_scolaires
	           where 
	          		id__langue=$id_langue and 
	          		id__accueil_groupes_scolaires=$idSejour2";
	          	
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	$xml.= "<haute_saison_accueil_groupes_scolaires><![CDATA[".mysql_result($result_S,0,"haute_saison")."]]></haute_saison_accueil_groupes_scolaires>\n";
	$xml.= "<moyenne_saison_accueil_groupes_scolaires><![CDATA[".mysql_result($result_S,0,"moyenne_saison")."]]></moyenne_saison_accueil_groupes_scolaires>\n";
	$xml.= "<basse_saison_accueil_groupes_scolaires><![CDATA[".mysql_result($result_S,0,"basse_saison")."]]></basse_saison_accueil_groupes_scolaires>\n";
	$xml.= "<haute_saison_accueil_groupes_scolaires_n1><![CDATA[".mysql_result($result_S,0,"haute_saison_n1")."]]></haute_saison_accueil_groupes_scolaires_n1>\n";
	$xml.= "<moyenne_saison_accueil_groupes_scolaires_n1><![CDATA[".mysql_result($result_S,0,"moyenne_saison_n1")."]]></moyenne_saison_accueil_groupes_scolaires_n1>\n";
	$xml.= "<basse_saison_accueil_groupes_scolaires_n1><![CDATA[".mysql_result($result_S,0,"basse_saison_n1")."]]></basse_saison_accueil_groupes_scolaires_n1>\n";
	// ----------------------------------------------------------------
	if(!$id_sejour_3){
		$id_sejour_3=9999999999;
	}
	$sql_S = "	select
					        haute_saison,
                	moyenne_saison,
                	basse_saison,
                	haute_saison_n1,
                	moyenne_saison_n1,
                	basse_saison_n1
	           FROM
	           		trad_accueil_individuels_familles
	           where 
	          		id__langue=$id_langue and 
	          		id__accueil_individuels_familles=$id_sejour_3";
	  
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	$xml.= "<haute_saison_accueil_individuels_familles><![CDATA[".mysql_result($result_S,0,"haute_saison")."]]></haute_saison_accueil_individuels_familles>\n";
	$xml.= "<moyenne_saison_accueil_individuels_familles><![CDATA[".mysql_result($result_S,0,"moyenne_saison")."]]></moyenne_saison_accueil_individuels_familles>\n";
	$xml.= "<basse_saison_accueil_individuels_familles><![CDATA[".mysql_result($result_S,0,"basse_saison")."]]></basse_saison_accueil_individuels_familles>\n";
	$xml.= "<haute_saison_accueil_individuels_familles_n1><![CDATA[".mysql_result($result_S,0,"haute_saison_n1")."]]></haute_saison_accueil_individuels_familles_n1>\n";
	$xml.= "<moyenne_saison_accueil_individuels_familles_n1><![CDATA[".mysql_result($result_S,0,"moyenne_saison_n1")."]]></moyenne_saison_accueil_individuels_familles_n1>\n";
	$xml.= "<basse_saison_accueil_individuels_familles_n1><![CDATA[".mysql_result($result_S,0,"basse_saison_n1")."]]></basse_saison_accueil_individuels_familles_n1>\n";
	
  
  
  // ----------------------------------------------------------------
	$sql_S    = "select id_accueil_groupes_jeunes_adultes as id from accueil_groupes_jeunes_adultes where id_centre='".$myrow["id_centre"]."'";
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	$idSejour = mysql_result($result_S,0,"id");
	if(mysql_result($result_S,0,"id")>0){
		$sql_S	  = "select
					HS_bb,
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
                    BS_rs
				FROM
					sejour_tarif_groupe_plus
				WHERE
					IdSejour =".mysql_result($result_S,0,"id")." and id__table_def="._CONST_TABLEDEF_GROUPE_ADULTE ;
		$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	}
	
	$xml.= "<GHb_HS_bb_n1>".mysql_result($result_S,0,"HS_bb")."</GHb_HS_bb_n1>\n";
	$xml.= "<GHb_HS_dp_n1>".mysql_result($result_S,0,"HS_dp")."</GHb_HS_dp_n1>\n";
	$xml.= "<GHb_HS_pc_n1>".mysql_result($result_S,0,"HS_pc")."</GHb_HS_pc_n1>\n";
	$xml.= "<GHb_HS_rs_n1>".mysql_result($result_S,0,"HS_rs")."</GHb_HS_rs_n1>\n";
	$xml.= "<GHb_MS_bb_n1>".mysql_result($result_S,0,"MS_bb")."</GHb_MS_bb_n1>\n";
	$xml.= "<GHb_MS_dp_n1>".mysql_result($result_S,0,"MS_dp")."</GHb_MS_dp_n1>\n";
	$xml.= "<GHb_MS_pc_n1>".mysql_result($result_S,0,"MS_pc")."</GHb_MS_pc_n1>\n";
	$xml.= "<GHb_MS_rs_n1>".mysql_result($result_S,0,"MS_rs")."</GHb_MS_rs_n1>\n";
	$xml.= "<GHb_BS_bb_n1>".mysql_result($result_S,0,"BS_bb")."</GHb_BS_bb_n1>\n";
	$xml.= "<GHb_BS_dp_n1>".mysql_result($result_S,0,"BS_dp")."</GHb_BS_dp_n1>\n";
	$xml.= "<GHb_BS_pc_n1>".mysql_result($result_S,0,"BS_pc")."</GHb_BS_pc_n1>\n";
	$xml.= "<GHb_BS_rs_n1>".mysql_result($result_S,0,"BS_rs")."</GHb_BS_rs_n1>\n";
	// ----------------------------------------------------------------
	$sql_S    = "select id_accueil_individuels_familles as id from accueil_individuels_familles where id_centre='".$myrow["id_centre"]."'";
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	if(mysql_result($result_S,0,"id")>0){
		$sql_S	  = "select
					HS_bb,
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
                    BS_rs
				FROM
					sejour_tarif_groupe_plus
				WHERE
					IdSejour =".mysql_result($result_S,0,"id")." and id__table_def="._CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE;
		$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
	}
	$xml.= "<IH_HS_bb_n1>".mysql_result($result_S,0,"HS_bb")."</IH_HS_bb_n1>\n";
	$xml.= "<IH_HS_dp_n1>".mysql_result($result_S,0,"HS_dp")."</IH_HS_dp_n1>\n";
	$xml.= "<IH_HS_pc_n1>".mysql_result($result_S,0,"HS_pc")."</IH_HS_pc_n1>\n";
	$xml.= "<IH_HS_rs_n1>".mysql_result($result_S,0,"HS_rs")."</IH_HS_rs_n1>\n";
	$xml.= "<IH_MS_bb_n1>".mysql_result($result_S,0,"MS_bb")."</IH_MS_bb_n1>\n";
	$xml.= "<IH_MS_dp_n1>".mysql_result($result_S,0,"MS_dp")."</IH_MS_dp_n1>\n";
	$xml.= "<IH_MS_pc_n1>".mysql_result($result_S,0,"MS_pc")."</IH_MS_pc_n1>\n";
	$xml.= "<IH_MS_rs_n1>".mysql_result($result_S,0,"MS_rs")."</IH_MS_rs_n1>\n";
	$xml.= "<IH_BS_bb_n1>".mysql_result($result_S,0,"BS_bb")."</IH_BS_bb_n1>\n";
	$xml.= "<IH_BS_dp_n1>".mysql_result($result_S,0,"BS_dp")."</IH_BS_dp_n1>\n";
	$xml.= "<IH_BS_pc_n1>".mysql_result($result_S,0,"BS_pc")."</IH_BS_pc_n1>\n";
	$xml.= "<IH_BS_rs_n1>".mysql_result($result_S,0,"BS_rs")."</IH_BS_rs_n1>\n";
	// ----------------------------------------------------------------
	$sql_S    = "select id_accueil_groupes_scolaires as id from accueil_groupes_scolaires where id_centre='".$myrow["id_centre"]."'";
	$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);

	$idSejour2 = mysql_result($result_S,0,"id");
	if(mysql_result($result_S,0,"id")>0){
		$sql_S	  = "select
					HS_bb,
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
                    BS_rs
				FROM
					sejour_tarif_groupe_plus
				WHERE
					IdSejour =".mysql_result($result_S,0,"id")." and id__table_def="._CONST_TABLEDEF_ACCUEIL_GROUPE;
		$result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
		
			
	}
	
	$xml.= "<TS_HS_bb_n1>".mysql_result($result_S,0,"HS_bb")."</TS_HS_bb_n1>\n";
	$xml.= "<TS_HS_dp_n1>".mysql_result($result_S,0,"HS_dp")."</TS_HS_dp_n1>\n";
	$xml.= "<TS_HS_pc_n1>".mysql_result($result_S,0,"HS_pc")."</TS_HS_pc_n1>\n";
	$xml.= "<TS_HS_rs_n1>".mysql_result($result_S,0,"HS_rs")."</TS_HS_rs_n1>\n";
	$xml.= "<TS_MS_bb_n1>".mysql_result($result_S,0,"MS_bb")."</TS_MS_bb_n1>\n";
	$xml.= "<TS_MS_dp_n1>".mysql_result($result_S,0,"MS_dp")."</TS_MS_dp_n1>\n";
	$xml.= "<TS_MS_pc_n1>".mysql_result($result_S,0,"MS_pc")."</TS_MS_pc_n1>\n";
	$xml.= "<TS_MS_rs_n1>".mysql_result($result_S,0,"MS_rs")."</TS_MS_rs_n1>\n";
	$xml.= "<TS_BS_bb_n1>".mysql_result($result_S,0,"BS_bb")."</TS_BS_bb_n1>\n";
	$xml.= "<TS_BS_dp_n1>".mysql_result($result_S,0,"BS_dp")."</TS_BS_dp_n1>\n";
	$xml.= "<TS_BS_pc_n1>".mysql_result($result_S,0,"BS_pc")."</TS_BS_pc_n1>\n";
	$xml.= "<TS_BS_rs_n1>".mysql_result($result_S,0,"BS_rs")."</TS_BS_rs_n1>\n";
        // ----------------------------------------------------------------

        // GPE - 2011-02-21
        $xml.= "<inscription_newsletter>";

        $sql_S    = "select id_types_newsletter from centre_contact where id_centre_2=".$myrow["id_centre"];
        $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);
        $sTypeNews =  mysql_result($result_S,0,"id_types_newsletter");

        if($sTypeNews != null && $sTypeNews != "")
        {
            $aTypeNews =  explode(",", $sTypeNews);

            foreach($aTypeNews as $iValue)
            {
                $sql_S    = "select libelle from trad_types_newsletter where id__types_newsletter=".$iValue;
                $result_S = mysql_query($sql_S) or die(mysql_error()."<br>Requete : ".$sql_S);

                $xml.= mysql_result($result_S,0,"libelle")."\n";
            }
            
        }
        $xml.= "</inscription_newsletter>";

	$xml.= "</centre>";
	
	fwrite($fp, $xml);
	$xml="";
	fclose($fp);

}



$xml= "</FICHESCENTRE>";
$fp = fopen("export_centre.xml", 'a');
fwrite($fp, $xml);
fclose($fp);


echo "<a href='telecharge.php?src=export_centre.xml'><font face='arial'>Cliquez ici pour télécharger le fichier XML</font></a>";

}
else{
  
  echo"<form action=\"\" method=\"POST\">";
  echo"<input type='hidden' value='1' name='action'/>";
  echo "<table>";
  echo "<tr>";
  echo "  <td>Choisissez une langue pour l'export :</td>";
  echo "  <td>";
  echo "    <select name='langueExport'>";
  
  $sql = "SELECT _langue, id__langue FROM _langue";  
  $result = mysql_query($sql);
  while($myrow = mysql_fetch_array($result)){
    echo"<option value='".$myrow["id__langue"]."'>".$myrow["_langue"]."</option>";
  }
        
  echo "    </select>";
  echo "  </td>";
  echo "</tr>";
  echo "<tr>";
  echo "  <td colspan='2'><input type='submit' value='Valider' /></td>";
  echo "</tr>";
   echo "</table>";
  
  echo"<form>";
  
  
}


function test_virgule_fin($texte){
	$rest = substr($texte, -1);
	if($rest == ","){
		$return = substr($texte, 0, -1);
	}else{
		$return = $texte;
	}
	return $return;
}
?>
