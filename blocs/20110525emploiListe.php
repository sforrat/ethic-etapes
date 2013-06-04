<?
/**********************************************************************************/
/*	C2IS :
/*	Auteur : 	FFR
/*	Date :
/*	Version :	1.0
/*	Fichier :	emploiListe.php
/*
/*	Description :	Emploi Liste
/*
/**********************************************************************************/

// Initialisation de la page
$path="./";

$sql = "SELECT
			offre_emploi.id_offre_emploi,
			offre_emploi.libelle,
			offre_emploi.descriptif,
			offre_emploi.id_offre_type,
			DATE_FORMAT(offre_emploi.periode_debut,'%d-%m-%Y') as periode_debut,
			DATE_FORMAT(offre_emploi.periode_fin,'%d-%m-%Y') as periode_fin,
			offre_type.libelle as contrat,
			centre.ville,
			centre.code_postal,
			offre_secteur_activite.libelle as secteur
		FROM 
			offre_emploi
		INNER JOIN	offre_type on (offre_type.id_offre_type =offre_emploi.id_offre_type)
		INNER JOIN	centre on (centre.id_centre =offre_emploi.id_centre)
		INNER JOIN	offre_secteur_activite on (offre_secteur_activite.id_offre_secteur_activite =offre_emploi.id_offre_secteur_activite)";


//SELECT offre_emploi.id_offre_emploi, offre_emploi.libelle, offre_emploi.descriptif, offre_emploi.id_offre_type, DATE_FORMAT(offre_emploi.periode_debut,'%d-%m-%Y') as periode_debut, DATE_FORMAT(offre_emploi.periode_fin,'%d-%m-%Y') as periode_fin, offre_type.libelle as contrat, centre.ville, centre.code_postal, offre_secteur_activite.libelle as secteur FROM offre_emploi INNER JOIN offre_type on (offre_type.id_offre_type =offre_emploi.id_offre_type) INNER JOIN centre on (centre.id_centre =offre_emploi.id_centre) INNER JOIN offre_secteur_activite on (offre_secteur_activite.id_offre_secteur_activite =offre_emploi.id_offre_secteur_activite) where offre_emploi.id_offre_secteur_activite= and centre.id_centre_region= and offre_emploi.id_offre_type=

//-------------- Ajout des filtres :
if( ($_POST["secteur_filter"]!="0" && isset($_POST["secteur_filter"])) ||  ($_SESSION["secteur_filter"]!="0" && $_SESSION["secteur_filter"]!="")){

	if($_POST["secteur_filter"] != ""){
		
		$var = $_POST["secteur_filter"];
	}else{
		$var = $_SESSION["secteur_filter"];
	}


	if (eregi("where", $sql)) {
		$sql.= " and ";
	}else{
		$sql.=" where ";
	}
	$sql.=" offre_emploi.id_offre_secteur_activite=".$var;
}

if( ($_POST["region_filter"]!="0" && isset($_POST["region_filter"])) || ($_SESSION["region_filter"]!="0" && $_SESSION["region_filter"]!="")){
	if($_POST["region_filter"] != ""){

		$var = $_POST["region_filter"];
	}else{
		$var = $_SESSION["region_filter"];
	}
	if (eregi("where", $sql)) {
		$sql.= " and ";
	}else{
		$sql.=" where ";
	}
	$sql.=" centre.id_centre_region=".$var;
}

if(($_POST["contractType_filter"]!="0" && isset($_POST["contractType_filter"])) || ($_SESSION["contractType_filter"]!="0" && $_SESSION["contractType_filter"]!="")){
	if($_POST["contractType_filter"] != ""){
			
		$var = $_POST["contractType_filter"];
	}else{
		$var = $_SESSION["contractType_filter"];
	}

	if (eregi("where", $sql)) {
		$sql.= " and ";
	}else{
		$sql.=" where ";
	}
	$sql.=" offre_emploi.id_offre_type=".$var;
}
//--------------
/*
if (eregi("where", $sql)) {
$sql.= " and ";
}else{
$sql.=" where ";
}
$sql.=" date_publication<=Now() and date_depublication>Now() ";
*/

if($_GET["P"]>1){
	$currentPage = $_GET["P"];
	$startPage = _NB_ENR_PAGE_RES_OFFRE * ($_GET["P"]-1);
	$endPage = $startPage + _NB_ENR_PAGE_RES_OFFRE ;
	
}else{
	$currentPage = 1;
	$startPage = 0;
	$endPage =$startPage+_NB_ENR_PAGE_RES_OFFRE;
}
$sqlCount = $sql;
$sql .= " LIMIT $startPage,$endPage";
//echo $sql;
$this->assign("nbTotal",$nb);
$result = mysql_query($sql);
$nb = mysql_num_rows($result);
while($myrow = mysql_fetch_array($result)){
	$tab["libelle"] = mb_strtoupper($myrow["libelle"],"utf-8");
	$tab["contrat"] = mb_strtoupper($myrow["contrat"],"utf-8");
	$tab["ville"] = $myrow["ville"];
	$tab["dept"] = substr($myrow["code_postal"],0,2);
	$tab["description"] = coupe_espace(nl2br(html_entity_decode($myrow["descriptif"])),200);
	$tab["secteur"] = $myrow["secteur"];
	$tab["url"] = get_url_nav_offre(_NAV_OFFRE_EMPLOI_FICHE,$myrow["id_offre_emploi"]);

	if($myrow["periode_fin"] != "" && $myrow["id_offre_type"]!= _ID_CDI){
		$tab["periode_texte"] = get_libLocal('lib_periode');
		$tab["periode"] = str_replace("##DATE_DEBUT##",$myrow["periode_debut"],get_libLocal('lib_du_au'));
		$tab["periode"] = str_replace("##DATE_FIN##",$myrow["periode_fin"],$tab["periode"]);
	}else{
		$tab["date_debut_texte"] = get_libLocal('lib_date_debut_contrat');
		$tab["periode_debut"] = $myrow["periode_debut"];
	}

	$TabOffre[] = $tab;
	unset($tab);
}

$this->assign("nbTotal",$nb);
$this->assign("TabOffre",$TabOffre);



//Pagination
$resultCount = mysql_query($sqlCount);
$nb = mysql_num_rows($resultCount);
$nbPages = ceil($nb / _NB_ENR_PAGE_RES_OFFRE);
//echo "-->".$nbPages;

$startPage = $currentPage - ceil(_NB_PAGE_TOT_RES/2) + 1;
$endPage = $currentPage + ceil(_NB_PAGE_TOT_RES/2) ;

if ($startPage <= 0)
$startPage = 1;

if ($endPage > $nbPages)
$endPage = $nbPages +1;


$this -> assign ('startPage', $startPage);
$this -> assign ('endPage', $endPage);
// --------------------------------------------------------------
// --- URL PREVIOUS
if(isset($_REQUEST['P'])){
	if(($_REQUEST['P'] > 1)){
		$previousPage = $_REQUEST['P']-1;
	}else{
		$previousPage = 1;
	}
}

if($previousPage == 1 || !$previousPage){
	$url_previous = get_url_nav(_NAV_OFFRE_EMPLOI_LISTE);
}else{
	$params[0]["id"] = $previousPage;
	$url_previous = get_url_nav(_NAV_OFFRE_EMPLOI_LISTE,$params);
}
$this -> assign ('urlPreviousPage', $url_previous);
// --------------------------------------------------------------
// --- URL NEXT
if(isset($_REQUEST['P'])){
	$val  = $_REQUEST['P']+1;
	if($val >= $nbPages){
		
		$next = $nbPages;
	}else{
		
		$next = $_REQUEST['P']+1;
	}
}else{
	
	$next  = $nbPages;
}

if($next ==1  || !$next){
	$url_next = get_url_nav(_NAV_OFFRE_EMPLOI_LISTE);
}else{
	$params[0]["id"] = $next;
	$url_next = get_url_nav(_NAV_OFFRE_EMPLOI_LISTE,$params);
}
$this -> assign ('urlNextPage', $url_next);
// --------------------------------------------------------------
// --- Derniere page
if($nbPages>1){
	$params[0]["id"] = $nbPages;
	$this -> assign ('url_last_page', get_url_nav(_NAV_OFFRE_EMPLOI_LISTE,$params));
}else{
	$this -> assign ('url_last_page', get_url_nav(_NAV_OFFRE_EMPLOI_LISTE));
}

// --------------------------------------------------------------

$this -> assign ('currentPage', $currentPage);
$this -> assign ('nextPage', $url_next);

$this -> assign ('urlPagination', get_url_nav($_REQUEST['Rub']));
$this -> assign ('nbPages', $nbPages);
$this->assign("nbTotal",$nb);


// ------ FFR
unset($tab);
for($i = $startPage; $i<$endPage;$i++){
	$params[0]["id_name"]="P";
	$params[0]["id"]=$i;
	
	if($i == 1){
		$tab["url"] = get_url_nav(_NAV_OFFRE_EMPLOI_LISTE);
	}else{
		$tab["url"] = get_url_nav(_NAV_OFFRE_EMPLOI_LISTE,$params);
	}
	
	$tab["currentPage"] = $i;
	
	$TabPagination[] = $tab;
	unset($tab);
}
$this -> assign ('TabPagination', $TabPagination);
$this -> assign ('$page', $_GET["P"]);
// ----------
$this -> display('blocs/emploiListe.tpl');
?>
