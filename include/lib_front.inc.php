<?
/**********************************************************************************/
/*	C2IS : 		projet
/*	Auteur : 	auteur
/*	Date : 		Aout 2009
/*	Version :	1.0
/*	Fichier :	lib_front.inc.php
/*
/*	Description :	Fichier inclus dans toutes les pages du front office
/*			par l'intermediaire de inc_header. Librairie contenant
/*			les fonctions gÃ¯Â¿Â½nÃ¯Â¿Â½riques utilisÃ¯Â¿Â½es dans les projets
/*			dans lesquels les contenu est content managÃ¯Â¿Â½e.
/*
/**********************************************************************************/


//================================================================================================
// 								FONCTIONS NAV /  RUB / REECRITURE
//=================================================================================================
//recupere les infos d'une Rub
function getInfosRub($_Rub)
{

	$rq = "SELECT
   			n.id__nav, tr._nav, n.url_page
   		    FROM 
   		    	_nav n   		    	
   		    INNER JOIN
   		    	trad__nav tr on n.id__nav = tr.id___nav    		    	
   		    WHERE 
   		    	n.id__nav = $_Rub
   		    /*AND 
   		    	selected = 1 */
   		    AND 
   		    	tr.id__langue = ".$_SESSION['ses_langue']."
   		    ORDER BY ordre
   		    ";		
	//	tt($rq);
	$rs = set_query($rq);
	while($row = mysql_fetch_array($rs))
	{
		$id_itemN3 = $row[id__nav];
		$libelle_N3 =  $row[_nav];
	}
	$item_menu_pro_n1 = array("url_lien_item_n1" => get_url_nav($id_itemN3), "libelle_lien_item_n1" => $libelle_N3);
	return $item_menu_pro_n1;
}

//========================================================
// La nav $_RubTest est elle dans l arbo de $_Rub ?
//========================================================
function isRubBelongToNavId($_Rub,$_RubTest)
{
	$aNav = get_navID($_Rub);
	for($i=0;$i<count($aNav);$i++)
	{
		if($aNav[$i] == $_RubTest)
		{
			return true;
		}
	}
	return false;
}


//-----------------------------------------------------------------------------------------------------
// FONCTION get_navID : Renvoie un tableau contenant les id de tous les niveaux de nav
// dans le chemin en cours, en partant de la home (1) jusqu'au Rub courant.
//-----------------------------------------------------------------------------------------------------

function get_navID($Rub)
{
	// On recupere les id peres de l'element de navigation courant
	// permet de rÃ¯Â¿Â½cupÃ¯Â¿Â½rer les Ã¯Â¿Â½lÃ¯Â¿Â½ments du rÃ¯Â¿Â½fÃ¯Â¿Â½rencement des pages de contenus en particulier

	unset($GLOBALS['array_pere']); // on detruit le tableau rÃ¯Â¿Â½cursif global

	$navID = get_item_pere($Rub); // et on rappelle la fonction rÃ¯Â¿Â½cursive de parcours de la nav
	//array_pop($navID); //Retire l'accueil
	$id_pere=$navID[0]; // id_pere contient l'id de l'item directement supÃ¯Â¿Â½rieur
	$navID = array_reverse($navID);
	$navID[] = $Rub; // navID contient le chemin complet de la nav courante

	return $navID;
}

//-----------------------------------------------------------------------------------------------------
//    RETOURNE LE CHEMIN DE FER RECURSIVEMENT POUR LES RUB EDITORIALES
//
// 		enable_lien_n1 : est ce que les items de niveau 1 sont cliquables fans le chemin de fer ?
//										 true : oui, false: non

function get_chemin_fer_interne($Rub, $navID, $enable_lien_n1=true) {
	$tab_chemin = array();
	$i=1;

	if (in_array($Rub, $GLOBALS['_NAV_SEJOUR']) && isset($_REQUEST['id']))
	{
		$Rub = 'fiche_sejour';
		$navID[] = 'fiche_sejour';
	}

	foreach ($navID as $v)
	{
		if ( $enable_lien_n1 || ( (!$enable_lien_n1) && ($i!=2) ) ) // suppression lien sur item n1
		{
			if ($v != $Rub) {

				if($v == _NAV_ACCUEIL){
					$url = _CONST_APPLI_URL;
                    // RPL - titre = libelle
                    $titre = ucfirst(strtolower(get_libLocal('lib_home')));
				}else{
					$url = get_url_nav($v);
                    $titre = get_trad_nav($v);
				}
				// pas rub en cours, et lien autorisÃ¯Â¿Â½
				$tab_chemin[] = array(
				"URL"			=>	$url,
				"TITLE"		=>	$titre,
				"TARGET"	=>	get_target_nav($v),
				"LIBELLE"	=>	$titre,
				"SELECTED"=>	0
				);
			}
			else {
				if($v == _NAV_OFFRE_EMPLOI_FICHE){
					$libelle = get_libelle_fiche_emploi($_GET["idOffre"]);
				}
				else if($v == _NAV_FICHE_ORGANISATEUR_CVL){
					$libelle = getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'libelle', $_REQUEST['id']);
				}
				else if ($v == _NAV_FICHE_CENTRE){
					$sql = "SELECT libelle, ville FROM centre where id_centre = ".$_REQUEST['id_centre'];
					$rst = mysql_query($sql);

					if (!$rst)
					echo mysql_error().' - '.$sql;

					$libelle = mysql_result($rst,0, 'libelle');

				}
				else if ($v == 'fiche_sejour'){
					$libelle = get_nom_sejour($_REQUEST['Rub'], $_REQUEST["id"]);
				}
				else{
					$libelle = get_trad_nav($v);
				}

				// rub en cours
				$tab_chemin[] = array(
				"URL"			=>	"",
				"TITLE"		=>	"",
				"TARGET"	=>	"",
				"LIBELLE"	=>	$libelle,
				"SELECTED"=> 	1
				);
			}
		}
		else
		{
			$libelle = get_trad_nav($v);

			// lien pas autorisÃ¯Â¿Â½
			$tab_chemin[] = array(
			"URL"			=>	"",
			"TITLE"		=>	"",
			"TARGET"	=>	"",
			"LIBELLE"	=>	$libelle,
			"SELECTED"=> 	0
			);
		}
		$i++;
	}
	return $tab_chemin;
}
//-----------------------------------------------------------------------------------------------------
// +--------------------------------------------------------------------------+
// |                                                                          |
// |         RETOURNE LES PERES D'UN ELEMENT DU MENU                          |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Date : 14/03/2003                                                        |
// +--------------------------------------------------------------------------+

function get_item_pere($item, $selected = false){
	global $array_pere;

	$StrSQL = "
            SELECT 
                _nav.id__nav_pere
            FROM 
                _nav 
            WHERE 
                _nav.id__nav = ".$item;
	if ( $selected)
	$StrSQL.="
            AND 
                _nav.selected=1 ";
	$StrSQL.="
            ORDER BY 
                _nav.ordre,
                _nav.id__nav 
            ";

	// echo get_sql_format($StrSQL)."<br><br>";

	$Rst = mysql_query($StrSQL);

	$pere = @mysql_result($Rst,0,0);

	//echo "--- <b>".$pere."</b> ---";
	$array_pere[] = $pere;

	if ($pere && $pere != _NAV_ACCUEIL) {
		get_item_pere($pere);
	}

	return $array_pere;
}
//-----------------------------------------------------------------------------------------------------

// +--------------------------------------------------------------------------+
// |                                                                          |
// |         RETOURNE LES ELEMENTS DE NAVIGATION DE LA PAGE COURANTE          |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Date : 14/03/2003                                                        |
// +--------------------------------------------------------------------------+
//Permet de recuperer le title et les meta de la rubrique courante
function get_header($Rub,$methode)
{
	$navID = get_navID($Rub);

	$methode = strtolower($methode);

	$StrSQL = "
		SELECT
			navigation.".$methode.", _nav._nav
		FROM
			navigation, _nav
		WHERE
			navigation.id__nav = _nav.id__nav
		AND
			navigation.id__langue=".$_SESSION['ses_langue']."
		AND
			_nav.id__nav=".$Rub;


	$Rst = mysql_query($StrSQL);


	if (mysql_num_rows($Rst)>0) {
		if ($methode=="meta_description") {
			$return = "<meta name=\"description\" content=\"".mysql_result($Rst, 0, "navigation.".$methode)."\"/>";

		}else if ($methode=="meta_keyword") {
			$return = "<meta name=\"keywords\" content=\"".mysql_result($Rst, 0, "navigation.".$methode)."\"/>";

		}else if ($methode=="title") {
			$return = mysql_result($Rst, 0, "navigation.".$methode);
		}
	}

	if (empty($return) && $methode=="title") {
		$return = get_trad_nav($Rub)." - "._CONST_APPLI_NAME;

	}else	if (empty($return) && $methode=="meta_description") {
		$return = "<meta name=\"description\" content=\""._CONST_APPLI_NAME." : ".get_trad_nav($Rub)."\"/>";

	}else	if (empty($return) && $methode=="meta_keyword") {
		$return = "<meta name=\"keywords\" content=\"".get_trad_nav($Rub)."\"/>";
	}

	return $return;
}
//-----------------------------------------------------------------------------------------------------
// Renvoie la valeur du champ _nav pour la rubrique Rub
function get_nav($Rub)
{
	$StrSQL = "
		    SELECT
       trad__nav._nav
		    FROM
    			trad__nav
	    	WHERE
							trad__nav.id___nav=".$Rub." and id__langue=".$_SESSION["ses_langue"];

	$Rst = mysql_query($StrSQL);

	return (mysql_result($Rst, 0, "trad__nav._nav"));
}

//-----------------------------------------------------------------------------------------------------

// Renvoie la valeur du champ url_page pour la rubrique Rub
function get_url_page($Rub)
{
	$StrSQL = "
		    SELECT
       			_nav.url_page
		    FROM
    			_nav
	    	WHERE
					_nav.id__nav=".$Rub;

	//echo $StrSQL;
	$Rst = mysql_query($StrSQL);
	$url = mysql_result($Rst, 0, 0);

	if (!$url) $url = _URL_PAGE_PAR_DEFAUT;

	return $url;
}


function get_url_nav_centre($Rub,$idCentre,$aParams=""){
	if (!strcmp(_CONST_ENABLE_REWRITING,"true")){
		$params[] = array("prefixe" => '', 'id' => $idCentre);

		foreach ($aParams as $p)
		$params[] = array("prefixe" => '', 'id' => $p['id']);

		return get_url_nav_centre_rewrited($Rub,"",$params);
	}else{
		$params[0]["id_name"]  = "id_centre";
		$params[0]["id"]       = $idCentre;

		foreach ($aParams as $p)
		$params[] = array("id_name" => $p['id_name'], 'id' => $p['id']);


		$url = get_url_nav($Rub,$params);
		return $url;
	}
}

function get_url_nav_organisateur_cvl($Rub,$idOrganisateur,$aParams=""){
	if (!strcmp(_CONST_ENABLE_REWRITING,"true")){
		$params[] = array("prefixe" => '', 'id' => $idOrganisateur);

		foreach ($aParams as $p)
		$params[] = array("prefixe" => '', 'id' => $p['id']);

		return get_url_nav_organisateur_cvl_rewrited($Rub,"",$params);
	}else{
		$params[0]["id_name"]  = "id";
		$params[0]["id"]       = $idOrganisateur;

		foreach ($aParams as $p)
		$params[] = array("id_name" => $p['id_name'], 'id' => $p['id']);


		$url = get_url_nav($Rub,$params);
		return $url;
	}
}

//-----------------------------------------------------------------------------------------------------
// renvoie le lien a mettre en place pour atteindre cette rubrique
// reecrit au pas si reecriture activÃ¯Â¿Â½e
function get_url_nav($Rub,$aParams="")
{
	if (!strcmp(_CONST_ENABLE_REWRITING,"true"))
	{
		return get_url_nav_rewrited($Rub,"",$aParams);
	}
	else
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

		// on ajoute le Rub a la fin ssi si il n'est pas dÃ¯Â¿Â½ja positionnÃ¯Â¿Â½ dans url_nav (redirection d'une
		// rub vers une autre), et si ce n'est pas un lien externe
		if($Rub=="" || $Rub== _NAV_ACCUEIL)
		{
			$url = _CONST_APPLI_URL;
		}
		else
		{

			if ( (!eregi("rub",$url)) && (!eregi("http",$url)) )
			{
				if (!eregi("\?",$url)) {
					$url .= "?Rub=".$Rub;
				} else {
					$url .= "&Rub=".$Rub;
				}
			}


			if($aParams!="")
			{
				for($i=0;$i<count($aParams);$i++)
				{
					$url .="&".$aParams[$i]["id_name"]."=".$aParams[$i]["id"];
				}
			}
		}

		return ($url);
	}
}


function get_url_nav_sejour($Rub,$idSejour)
{
	if (!strcmp(_CONST_ENABLE_REWRITING,"true"))
	{
		$params[] = array("prefixe" => '', 'id' => $idSejour);
		return get_url_nav_sejour_rewrited($Rub,"",$params);
	}
	else
	{

		$url = "fiche_sejour.php";

		if (!$url) $url = _URL_PAGE_PAR_DEFAUT;

		// on ajoute le Rub a la fin ssi si il n'est pas dÃ¯Â¿Â½ja positionnÃ¯Â¿Â½ dans url_nav (redirection d'une
		// rub vers une autre), et si ce n'est pas un lien externe
		if($Rub=="" || $Rub== _NAV_ACCUEIL)
		{
			$url = _CONST_APPLI_URL;
		}
		else
		{

			if ( (!eregi("rub",$url)) && (!eregi("http",$url)) )
			{
				if (!eregi("\?",$url)) {
					$url .= "?Rub=".$Rub;
				} else {
					$url .= "&Rub=".$Rub;
				}
			}

			$url .="&id=".$idSejour;

		}
	}

	return ($url);
}


//-----------------------------------------------------------------------------------------------------
// renvoie le target du lien associÃ¯Â¿Â½ Ã¯Â¿Â½ la nav Rub
function get_target_nav($Rub) {
	/*
	A IMPLEMENTER APRES AVOIR MODIFIER LA STRUCTURE DE LA TABLE _NAV
	$StrSQL = "
	SELECT
	_nav.target_url
	FROM
	_nav
	WHERE
	_nav.id__nav=".$Rub;

	//echo $StrSQL;
	$Rst = mysql_query($StrSQL);
	return mysql_result($Rst, 0, 0);
	// POUR L'INSTANT : je teste juste si j'ai un http:// dans le champ url_page
	*/
	return(eregi("http://",get_url_page($Rub))?"_blank":"");
}
//-----------------------------------------------------------------------------------------------------
// renvoie true si la valeur de Rub existe dans l'arborescence (table _nav, champ id_nav)
function nav_exist($Rub,$test_selected=0)
{
	$StrSQL = "
		    SELECT
       		       id__nav
		   FROM
    		      _nav
	    	   WHERE
		      _nav.id__nav=\"".$Rub."\"";

	if ($test_selected == 1)
	{
		$StrSQL .= "
		   AND 
		      selected = 1";
	}

	$Rst = mysql_query($StrSQL);

	return (mysql_num_rows($Rst) == 1);
}
//-----------------------------------------------------------------------------------------------------
// +--------------------------------------------------------------------------+
// |                                                                          |
// |         RETOURNE LES PREMIER FILS D'UN ELEMENT DU MENU                   |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Date : 14/03/2003                                                        |
// +--------------------------------------------------------------------------+

function get_item_fils($item){

	//AHE : Si on appel get_item_fils plusiseurs fois, alors celle-ci garde les valeurs du prÃ¯Â¿Â½cÃ¯Â¿Â½dent appel
	//global $array_fils;
	$array_fils = array();

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


	$Rst = mysql_query($StrSQL);

	for ($i=0;$i<mysql_num_rows($Rst);$i++)
	{

		$fils	= @mysql_result($Rst,$i,0);


		if (is_numeric($fils))
		{
			//Specif Ethic Etapes
			if ($_SESSION['ses_langue'] != _ID_FR)
			{
				if (!in_array($fils, $GLOBALS["_NAV_SEJOUR_V_ETRANGERE"]))
				continue;
			}

			$array_fils[] = $fils;

			get_item_fils($fils);
		}
	}

	return $array_fils;
}

//-----------------------------------------------------------------------------------------------------
// fonction qui renvoie le premier Ã¯Â¿Â½lÃ¯Â¿Â½ment fils de la rub courante
// sur lequel est liÃ¯Â¿Â½ du contenu.
// Permet de descendre automatiquement d'un cran si aucun contenu n'est associÃ¯Â¿Â½
// au niveau courant

function get_rub_filled($rub)
{
	//AFFICHAGE DU PREMIER ITEM DE NIVEAU N-1 AYANT AU MOINS UN ELEMENT
	$childID = get_item_fils($rub);

	//print_r ($childID);

	$childID = array_reverse($childID);
	$childID[] = $rub;
	$childID = array_reverse($childID);


	$find_first = 0;

	// on change la valeur de Rub si pas rubrique specifique !
	//if (($Rub!=_LABOS_NAV_ID) && ($Rub!=_PLAN_NAV_ID) && ($Rub!=_ACTUALITES_NAV_ID))
	//{
	$Rub = $rub;
	//   	tt($childID);
	for ($i=0; $i < count($childID) ;$i++)
	{
		if ( check_item($childID[$i]) === true && $find_first==0)
		{
			//    $RubTmp = $childID[$i];
			//echo "-".$childID[$i];
			$find_first = 1;
			$Rub = $childID[$i];
		}
	}
	//}
	return $Rub;
}
//-----------------------------------------------------------------------------------------------------

// test si du contenu est liÃ¯Â¿Â½ sur la rub passÃ¯Â¿Â½e en paramÃ¯Â¿Â½tre
// EntrÃ¯Â¿Â½e : $Rub
// Sortie : 1 = contenu liÃ¯Â¿Â½, 0 = pas de contenu liÃ¯Â¿Â½
function check_item($Rub) {

	$StrSQL =   "
                SELECT  
                    _object.*  
                FROM  
                    _object,  
                    _nav,
                    _langue
                WHERE  
                    _object.id__nav = _nav.id__nav  
                AND
                    _object.id__langue = _langue.id__langue
                AND 
                    _nav.id__nav = \"".$Rub."\" 
                AND
                    _langue.id__langue = ".$_SESSION['ses_langue']."
                AND
                    _object.id__workflow_state = "._WF_DISPLAYED_STATE_VALUE;

	$rst = mysql_query($StrSQL);


	if (mysql_num_rows($rst) > 0) {
		return true;
	}
	else {
		return false;
	}

}

// Renvoie la valeur du champ _nav pour la rubrique Rub
function get_trad_nav_reecrite($Rub)
{
	$trad_nav="";
	$StrSQL = "
		    SELECT
       n.*, tn._nav, tn.url_reecrite
		    FROM
    			_nav n
    		LEFT JOIN trad__nav tn on tn.id___nav = n.id__nav AND tn.id__langue=".$_SESSION['ses_langue']."
	    	WHERE
							n.id__nav=".$Rub;


	$Rst = mysql_query($StrSQL);

	if (mysql_result($Rst, 0, "tn.url_reecrite") != "")
	{
		$trad_nav = mysql_result($Rst, 0, "tn.url_reecrite");
	}else{
		$trad_nav = mysql_result($Rst, 0, "tn._nav");
	}

	if ($trad_nav=="")
	{
		$StrSQL = "
		    SELECT
       _nav._nav
		    FROM
    			_nav
	    	WHERE
							_nav.id__nav=".$Rub;

		$Rst = mysql_query($StrSQL);

		$trad_nav = mysql_result($Rst, 0, "_nav._nav") ;
	}

	return $trad_nav ;
}
function get_libelle_fiche_emploi($id){
	$sql_S = "	SELECT
					offre_emploi.libelle,
					offre_type.libelle as contrat
					
				FROM 
					offre_emploi
				INNER JOIN	offre_type on (offre_type.id_offre_type =offre_emploi.id_offre_type)
				
				WHERE
					id_offre_emploi=".$id;
	$result_S = mysql_query($sql_S);
	$libelle = mb_strtoupper(mysql_result($result_S,0,"libelle"),"utf-8")." ".mb_strtoupper(mysql_result($result_S,0,"contrat"),"utf-8");
	return $libelle;
}


// Renvoie la valeur du champ _nav pour la rubrique Rub
function get_trad_nav($Rub,$_idLangue = "")
{
	$trad_nav="";
	$idLangue = $_idLangue != "" ? $idLangue : $_SESSION['ses_langue'];
	$idLangue = $idLangue == "" ? _ID_LANGUE_FR : $idLangue ;
	$StrSQL = "
		    SELECT
       n.*, tn._nav
		    FROM
    			_nav n
    		LEFT JOIN trad__nav tn on tn.id___nav = n.id__nav AND tn.id__langue=".$idLangue."
	    	WHERE
							n.id__nav=".$Rub;


	$Rst = mysql_query($StrSQL);
	$trad_nav = mysql_result($Rst, 0, "tn._nav") ;

	if ($trad_nav=="")
	{
		$StrSQL = "
		    SELECT
       _nav._nav
		    FROM
    			_nav
	    	WHERE
							_nav.id__nav=".$Rub;

		$Rst = mysql_query($StrSQL);
		$trad_nav = mysql_result($Rst, 0, "_nav._nav") ;
	}

	return $trad_nav ;
}

// Renvoie la valeur de l'url rÃ¯Â¿Â½Ã¯Â¿Â½crite pour la rub reÃ¯Â¿Â½ue en paramÃ¯Â¿Â½tre
// chaque membre de l'url est formattÃ¯Â¿Â½e selon les rÃ¯Â¿Â½gles Ã¯Â¿Â½noncÃ¯Â¿Â½es par le rÃ¯Â¿Â½fÃ¯Â¿Â½renceur
// entrÃ¯Â¿Â½e : Rub
// Sortie : url rÃ¯Â¿Â½Ã¯Â¿Â½crite sous la forme /niv1/niv2/[...]/Rub
// chaque nivx est rÃ¯Â¿Â½Ã¯Â¿Â½crit pour respecter la regle : minuscule, pas d'accents, espaces remplacÃ¯Â¿Â½s par des -

function get_url_nav_rewrited_old($Rub)
{
	if ($Rub == 1) return "1accueil";

	//On vÃ¯Â¿Â½rifie si il y a pas la prÃ¯Â¿Â½sence d'une rub dÃ¯Â¿Â½jÃ¯Â¿Â½
	$str_url = get_url_page($Rub);
	$pos = strpos($str_url, "?Rub=");
	if ( $pos != "" ) {
		$pos = ( $pos + 5 );
		$temp_rub = substr( $str_url, $pos);
		$Rub = $temp_rub;
	}

	$navID = get_navID($Rub);

	array_shift($navID); // on enleve accueil
	$url_finale = "";

	// recompose chaque sous partie de l'url
	$i=1;
	foreach($navID as $v)
	{
		if ( (count($navID) == 1) || ($i>1) )
		{
			$v = get_trad_nav($v);
			$v = get_formatte_membre_url_rewrited($v);
			$url_finale .= $v."/";
		}
		$i++;
	}
	// et on ajoute la rub en fin
	if  (substr($url_finale,-1) == "/") $url_finale = substr($url_finale,0,-1);
	$url_finale .= ".".$Rub."/";
	return $url_finale;

}


// Renvoie la valeur de l'url rÃ¯Â¿Â½Ã¯Â¿Â½crite pour la rub reÃ¯Â¿Â½ue en paramÃ¯Â¿Â½tre
// chaque membre de l'url est formattÃ¯Â¿Â½e selon les rÃ¯Â¿Â½gles Ã¯Â¿Â½noncÃ¯Â¿Â½es par le rÃ¯Â¿Â½fÃ¯Â¿Â½renceur
// entrÃ¯Â¿Â½e : Rub
// Sortie : url rÃ¯Â¿Â½Ã¯Â¿Â½crite sous la forme /niv1/niv2/[...]/Rub
// chaque nivx est rÃ¯Â¿Â½Ã¯Â¿Â½crit pour respecter la regle : minuscule, pas d'accents, espaces remplacÃ¯Â¿Â½s par des -

function get_url_nav_offre($Rub,$idoffre){

	if (strcmp(_CONST_ENABLE_REWRITING,"true"))
	{

		$params[0]["id_name"]  = "idOffre";
		$params[0]["id"]       = $idoffre;

		return get_url_nav($Rub,$params);
	} else{
	
		$sql_S = "select libelle from offre_emploi where id_offre_emploi=".$idoffre;
		$result_S = mysql_query($sql_S);
		$libelle = get_formatte_membre_url_rewrited(mysql_result($result_S,0,"libelle"));
		return "offre-emploi/".$libelle.".$Rub.$idoffre.html";
	}

}


function get_url_nav_rewrited($Rub,$_idLangue = "",$_aParams = "")
{
	//------------------------------
	// url specifique On verifie si il y a pas la presence d'une rub dÃ¯Â¿Â½jÃ¯Â¿Â½
	//----------------------------------
	$str_url = get_url_page($Rub);
	$pos = strpos($str_url, "?Rub=");
	if ( $pos != "" )
	{
		$pos =  $pos + 5 ;
		$temp_rub = substr( $str_url, $pos);
		$Rub = $temp_rub;
	}

	//-------------------------------------------
	// Parcours de l arbo pour recuperer les menus
	//----------------------------------------------
	$navID = get_navID($Rub);
	array_shift($navID); // on enleve accueil ca depend de l arboarray_shift($navID); // on enleve accueil ca depend de l arbo

	$url_finale = "";

	//-------------------------------------------
	// recompose chaque sous partie de l'url
	//-------------------------------------------
	$i=1;
	foreach($navID as $v)
	{
		$v = get_trad_nav($v,$_idLangue);
		$v = utf8_decode($v);
		$v = get_formatte_membre_url_rewrited($v);
		$url_finale .= $v."/";
		$i++;
	}

	//-------------------------------------------
	// et on ajoute la rub en fin
	//-------------------------------------------
	if  (substr($url_finale,-1) == "/") $url_finale = substr($url_finale,0,-1);
	$url_finale .= ".".$Rub;
	if($_aParams!="")
	{
		for($i=0;$i<count($_aParams);$i++)
		{
			//$url_finale .=",".get_formatte_membre_url_rewrited(utf8_decode($_aParams[$i]["id_name"])).",".$_aParams[$i]["prefixe"].$_aParams[$i]["id"];
			$url_finale .=",".$_aParams[$i]["prefixe"].$_aParams[$i]["id"];
		}
	}
	$url_finale .= ".html";
	//FFR
	//$url_finale = $_SESSION['ses_langue_ext']."/".$url_finale;

	//	 tt(($url_finale));
	return $url_finale;
}

function get_url_nav_sejour_rewrited($Rub,$_idLangue = "",$_aParams = "")
{
	//------------------------------
	// url specifique On vÃ¯Â¿Â½rifie si il y a pas la prÃ¯Â¿Â½sence d'une rub dÃ¯Â¿Â½jÃ¯Â¿Â½
	//----------------------------------
	$str_url = get_url_page($Rub);
	$pos = strpos($str_url, "?Rub=");
	if ( $pos != "" )
	{
		$pos =  $pos + 5 ;
		$temp_rub = substr( $str_url, $pos);
		$Rub = $temp_rub;
	}

	//-------------------------------------------
	// Parcours de l arbo pour recuperer les menus
	//----------------------------------------------
	$navID = get_navID($Rub);
	array_shift($navID); // on enleve accueil ca depend de l arbo
	$url_finale = "";

	//-------------------------------------------
	// recompose chaque sous partie de l'url
	//-------------------------------------------
	$i=1;
	foreach($navID as $v)
	{
		$v = get_trad_nav($v,$_idLangue);
		$v = utf8_decode($v);
		$v = get_formatte_membre_url_rewrited($v);
		$url_finale .= $v."/";
		$i++;
	}


	//-------------------------------------------
	//On affiche le nom du sÃ¯Â¿Â½jour
	//-------------------------------------------
	$nom_sejour = get_nom_sejour($Rub, $_aParams[0]["id"], true);

	$nom_sejour = trim($nom_sejour);
	$nom_sejour = utf8_decode($nom_sejour);
	$nom_sejour = stripAccents($nom_sejour);
	$nom_sejour = str_replace(' ','_',$nom_sejour);
	$nom_sejour = str_replace("'",'_',$nom_sejour);
	$nom_sejour = str_replace("/",'',$nom_sejour);
	$nom_sejour = str_replace(":",'',$nom_sejour);
	$nom_sejour = str_replace(",",'',$nom_sejour);
	$nom_sejour = str_replace("?",'',$nom_sejour);
	$nom_sejour = str_replace("!",'',$nom_sejour);
  	$nom_sejour = str_replace(".",'',$nom_sejour);
  	$nom_sejour = str_replace("\"",'',$nom_sejour);
	$url_finale .= $nom_sejour.'/';



	//-------------------------------------------
	// et on ajoute la rub en fin
	//-------------------------------------------
	if  (substr($url_finale,-1) == "/") $url_finale = substr($url_finale,0,-1);
	$url_finale .= ".".$Rub;
	if($_aParams!="")
	{
		for($i=0;$i<count($_aParams);$i++)
		{
			//$url_finale .=",".get_formatte_membre_url_rewrited(utf8_decode($_aParams[$i]["titre"])).",".$_aParams[$i]["prefixe"].$_aParams[$i]["id"];
			$url_finale .=".".$_aParams[$i]["prefixe"].$_aParams[$i]["id"];
		}
	}
	$url_finale .= ".html";
	//$url_finale = $_SESSION['ses_langue_ext']."/".$url_finale;
	
	//	 tt(($url_finale));
	return $url_finale;
}

function get_nom_sejour($Rub, $idSejour, $rewriting = false)
{
	$nom_sejour = '';
	if ($GLOBALS["_NAV_SEJOUR_NOM"][$Rub] == 'nom_centre')
	{
		$sql = "SELECT libelle, ville
				FROM centre 
				INNER JOIN ".$GLOBALS["_NAV_SEJOUR_TABLE"][$Rub]." on centre.id_centre = ".$GLOBALS["_NAV_SEJOUR_TABLE"][$Rub].".id_centre 
				WHERE id_".$GLOBALS["_NAV_SEJOUR_TABLE"][$Rub]." = ".$idSejour;
		//echo "sql = ".$sql;
		$rst = mysql_query($sql);
		if (!$rst)
		echo mysql_error().' - '.$sql;
		else
		{
			if ($rewriting)
			$nom_sejour = get_rewrited_centre(mysql_result($rst,0, 'ville'), mysql_result($rst,0, 'libelle'));
			else
			$nom_sejour =  mysql_result($rst,0, 'libelle');
		}
	}
	else if (substr($GLOBALS["_NAV_SEJOUR_NOM"][$Rub],0,5) == 'trad_')
	{
		$nom_sejour = getTradTable($GLOBALS["_NAV_SEJOUR_TABLE"][$Rub],$_SESSION['ses_langue'], substr($GLOBALS["_NAV_SEJOUR_NOM"][$Rub],5), $idSejour);
	}
	else
	{
		$sql = "SELECT ".$GLOBALS["_NAV_SEJOUR_NOM"][$Rub]." FROM ".$GLOBALS["_NAV_SEJOUR_TABLE"][$Rub]." WHERE id_".$GLOBALS["_NAV_SEJOUR_TABLE"][$Rub]." = ".$idSejour;
		$rst = mysql_query($sql);
		if (!$rst)
		echo mysql_error().' - '.$sql;
		else
		$nom_sejour = mysql_result($rst,0, 'nom');
	}
    
    //RPL - 17/06/2011 : lacune du systeme de reecriture d'url
    $nom_sejour = str_replace("(","",$nom_sejour);
    $nom_sejour = str_replace(")","",$nom_sejour);
    
	return $nom_sejour;
} // get_nom_sejour($Rub, $idSejour)


function get_rewrited_centre($ville, $nom)
{
	$ville = trim($ville);
	$ville = utf8_decode($ville);
	$ville = stripAccents($ville);
	$ville = str_replace(' ','_',$ville);
	$ville = str_replace("'",'_',$ville);
	$ville = str_replace("/",'',$ville);

	$nom = trim($nom);
	$nom = utf8_decode($nom);
	$nom = stripAccents($nom);
	$nom = str_replace(' ','_',$nom);
	$nom = str_replace("'",'_',$nom);
	$nom = str_replace("/",'',$nom);

	if (substr($nom,0,12) == 'ethic_etapes')
	{
		$nom = substr($nom,12);

		if (substr($nom,0,3) == '_-_')
		$nom = '_'.substr($nom,3);
	}

	return $ville.$nom;
}

function get_url_nav_centre_rewrited($Rub,$_idLangue = "",$_aParams = "")
{
	//------------------------------
	// url specifique On vÃ¯Â¿Â½rifie si il y a pas la prÃ¯Â¿Â½sence d'une rub dÃ¯Â¿Â½jÃ¯Â¿Â½
	//----------------------------------
	$str_url = get_url_page($Rub);
	$pos = strpos($str_url, "?Rub=");
	if ( $pos != "" )
	{
		$pos =  $pos + 5 ;
		$temp_rub = substr( $str_url, $pos);
		$Rub = $temp_rub;
	}

	//-------------------------------------------
	// Parcours de l arbo pour recuperer les menus
	//----------------------------------------------
	$navID = get_navID($Rub);
	array_shift($navID); // on enleve accueil ca depend de l arbo
	$url_finale = "";

	//-------------------------------------------
	// recompose chaque sous partie de l'url
	//-------------------------------------------
	$i=1;
	foreach($navID as $v)
	{
		if ($v == _NAV_FICHE_CENTRE)continue; //On n'affiche pas 'fiche-centre'

		$v = get_trad_nav($v,$_idLangue);
		$v = utf8_decode($v);
		$v = get_formatte_membre_url_rewrited($v);
		$url_finale .= $v."/";
		$i++;
	}

	//-------------------------------------------
	//On affiche le nom du centre
	//-------------------------------------------
	$sql = "SELECT libelle, ville FROM centre where id_centre = ".$_aParams[0]["id"];
	//echo '<br />get_url_nav_centre() : '.$sql.'<br />';
	
	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error().' - '.$sql;

	$libelle = mysql_result($rst,0, 'libelle');
	$ville = mysql_result($rst,0, 'ville');

	$url_finale .= get_rewrited_centre($ville, $libelle).'/';

	//-------------------------------------------
	// et on ajoute la rub en fin
	//-------------------------------------------
	if  (substr($url_finale,-1) == "/") $url_finale = substr($url_finale,0,-1);
	$url_finale .= ".".$Rub;
	if($_aParams!="")
	{
		for($i=0;$i<count($_aParams);$i++)
		{
			//$url_finale .=",".get_formatte_membre_url_rewrited(utf8_decode($_aParams[$i]["titre"])).",".$_aParams[$i]["prefixe"].$_aParams[$i]["id"];
			$url_finale .=".".$_aParams[$i]["prefixe"].$_aParams[$i]["id"];
		}
	}
	$url_finale .= ".html";
	//$url_finale = $_SESSION['ses_langue_ext']."/".$url_finale;

	//	 tt(($url_finale));
	return $url_finale;
}

function get_url_nav_organisateur_cvl_rewrited($Rub,$_idLangue = "",$_aParams = "")
{
	//------------------------------
	// url specifique On vÃ¯Â¿Â½rifie si il y a pas la prÃ¯Â¿Â½sence d'une rub dÃ¯Â¿Â½jÃ¯Â¿Â½
	//----------------------------------
	$str_url = get_url_page($Rub);
	$pos = strpos($str_url, "?Rub=");
	if ( $pos != "" )
	{
		$pos =  $pos + 5 ;
		$temp_rub = substr( $str_url, $pos);
		$Rub = $temp_rub;
	}

	//-------------------------------------------
	// Parcours de l arbo pour recuperer les menus
	//----------------------------------------------
	$navID = get_navID($Rub);
	array_shift($navID); // on enleve accueil ca depend de l arbo
	$url_finale = "";

	//-------------------------------------------
	// recompose chaque sous partie de l'url
	//-------------------------------------------
	$i=1;
	foreach($navID as $v)
	{
		if ($v == _NAV_FICHE_ORGANISATEUR_CVL)continue; //On n'affiche pas 'fiche-organisateur-cvl'

		$v = get_trad_nav($v,$_idLangue);
		
		
		
		
		$v = utf8_decode($v);
		
		$v = get_formatte_membre_url_rewrited($v);
		$url_finale .= $v."/";
		$i++;
	}

	//-------------------------------------------
	//On affiche de l'organisateur
	//-------------------------------------------

	$libelle = getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'libelle', $_aParams[0]["id"] );
	$libelle = utf8_decode($libelle);
	$libelle = get_formatte_membre_url_rewrited($libelle);
	$url_finale .= get_formatte_membre_url_rewrited($libelle).'/';

	//-------------------------------------------
	// et on ajoute la rub en fin
	//-------------------------------------------
	if  (substr($url_finale,-1) == "/") $url_finale = substr($url_finale,0,-1);
	$url_finale .= ".".$Rub;
	if($_aParams!="")
	{
		for($i=0;$i<count($_aParams);$i++)
		{
			//$url_finale .=",".get_formatte_membre_url_rewrited(utf8_decode($_aParams[$i]["titre"])).",".$_aParams[$i]["prefixe"].$_aParams[$i]["id"];
			$url_finale .=".".$_aParams[$i]["prefixe"].$_aParams[$i]["id"];
		}
	}
	
	$url_finale .= ".html";
	//$url_finale = $_SESSION['ses_langue_ext']."/".$url_finale;
	
	//	 tt(($url_finale));
	return $url_finale;
}
 

// retourne une chaine formattÃ¯Â¿Â½e selon les rÃ¯Â¿Â½gles du rÃ¯Â¿Â½fÃ¯Â¿Â½renceur
// renvoie une chaine en minuscule, sans accent, et dont les espaces sont remplacÃ¯Â¿Â½s par des -
function get_formatte_membre_url_rewrited($str)
{
  //echo $str."<br>";
	$str = stripAccents(mb_strtolower(unhtmlentities($str),"utf-8"));
	$str = trim($str);
	//		$str = str_replace(".","",$str);
	$str = str_replace("\"","",$str);	//On enleve les " des noms sinon ca gene pour les liens
	$str = str_replace("?","",$str);	//On enleve les ? des noms
	$str = str_replace("â€œ","",$str);	//On enleve les â€œ des noms
	$str = str_replace("'","-",$str);	//On remplace les apostrophes par un -
	$str = str_replace("â€™","-",$str);	//On remplace les apostrophes par un -
	$str = str_replace(",","",$str);
	$str = str_replace(" ","-",$str);
	$str = str_replace("(","-",$str);
	$str = str_replace(")","-",$str);
    $str = str_replace("/","-",$str);
	$str = str_replace("'","-",$str);
	$str = str_replace("?","",$str);
	$str = str_replace("+","",$str);
    $str = str_replace("--","-",$str);
	return $str;
}


function genereHtacess()
{
	$sHtaccess = " AddDefaultCharset utf-8 \n Options +FollowSymlinks\n RewriteEngine on\n\n";

	$sql = " 	SELECT url_page,id__nav,tn._nav
				FROM _nav n 
						INNER JOIN trad__nav tn ON n.id__nav = tn.id___nav
				WHERE url_page !='' and url_page not LIKE 'http:%' 
				AND tn.id__langue = 1";

	$aRubs = getAllFieldsFromRst($sql);
	for($i=0;$i<count($aRubs);$i++)
	{
		$sHtaccess .= "	#".utf8_decode($aRubs[$i]["_nav"])."\n";
		$sHtaccess .= "	RewriteRule ^.*[\.]".$aRubs[$i]["id__nav"]."[\.]html$ ".$aRubs[$i]["url_page"]."?Rub=".$aRubs[$i]["id__nav"]." [QSA,NC,L]\n\n";
	}

	$sHtaccess .= "    #Page editorial\n";
	$sHtaccess .= "	RewriteRule ^.*[\.]([0-9^/]+)[\.]html$ editorial.php?Rub=$1 [QSA,NC,L]\n";

	tt(_CONST_PATH_TO_APPLI.".htaccess");
	tt($sHtaccess);
	if($fp=fopen(_CONST_PATH_TO_APPLI.".htaccess",'w+'))
	{
		//		tt("rrrr");
		fwrite($fp,$sHtaccess);
		fclose($fp);
	}
}

//================================================================================================
// 								FONCTIONS OBJECT
//=================================================================================================

//=========================================================================
// RENVOIE UN OBJET GABARIT A PARTIR D'UN ID et D UNE RUB
//=========================================================================
function getObject($_id, $_Rub)
{
	$datatype_text					= "varchar(255)";
	$datatype_long_text				= "text";
	$datatype_rich_text				= "mediumtext";
	$datatype_url					= "varchar(250)";
	$datatype_file					= "varchar(100)";
	$datatype_integer				= "int(10)";
	$datatype_currency				= "float(10,2)";
	$datatype_float					= "float(9,2)";
	$datatype_booleen				= "int(1)";
	$datatype_key					= "int(11) unsigned";
	$datatype_multikey				= "varchar(254)";
	$datatype_list_data				= "varchar(253)";
	$datatype_mail					= "varchar(252)";
	$datatype_color					= "varchar(15)";
	$datatype_arbo					= "id_"._CONST_BO_CODE_NAME."nav";
	$datatype_password				= "varchar(20)";
	$datatype_password_length 		= 8;
	$datatype_order					= "int(9)";
	$datatype_order_name			= "ordre";
	$datatype_date					=	$datatype_date_auto		= "date";
	$datatype_datetime				=	$datatype_datetime_auto	= "datetime";
	$datatype_blob					=	"blob";

	$sql =   "
		        SELECT  
	        	    	_object.*  
	        	FROM  
	            		_object,  
	            		_nav,
	            		_langue
	        	WHERE  
	            		_object.id__nav = _nav.id__nav  
	        	AND
	            		_object.id__langue = _langue.id__langue
	        	AND 
	            		_nav.id__nav = \"".$_Rub."\" 	        	
	        	AND
	            		_langue.id__langue = ".$_SESSION['ses_langue']."
	        	AND
	            		_object.id__workflow_state = "._WF_DISPLAYED_STATE_VALUE."
	
	            ORDER BY  _object.ordre ASC ";



	$rs = mysql_query($sql);

	while($row = mysql_fetch_array($rs))
	{

		$sql_object = " 	SELECT 	".$row[table_ref_req].".*
								FROM " .$row[table_ref_req]."
								WHERE  ".$row[table_ref_req].".id_".$row[table_ref_req]." = ".$row[item_table_ref_req] ;

		$rstContent = mysql_query($sql_object);
		if($rstContent)
		{
			$nb_cols = mysql_num_fields($rstContent);
			for ($k=0;$k<$nb_cols;$k++)
			{
				$fieldname  =	mysql_field_name($rstContent, $k);
				$fieldtype  =	mysql_field_type($rstContent, $k);
				$fieldlen	  =	mysql_field_len($rstContent, $k);
				$tablename  =	mysql_field_table($rstContent, $k);

				// Corrige erreur TATOOINE !! A retirer en prod
				if($_SERVER['SERVER_NAME'] == "10.63.1.83")
				{
					if ($fieldtype == "string") $fieldlen = $fieldlen / 3;
					if (!is_int($fieldlen)) $fieldlen = $fieldlen * 3; // divisÃ¯Â¿Â½ par erreur..
					// Fin a retirer en prod
				}

				$valeur = mysql_result($rstContent,0,$k);
				if ($valeur!="")
				{
					switch($fieldtype)
					{
						case "string":
							// Cas particulier sur les varchar (cf inc_init_bo)
							// URL
							if ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_url))
							{
								$valeur = "<a href=\"".$valeur."\">".$valeur."</a>";
							}
							// LISTE MULTIPLE SUR CLE ETRANGERE
							elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey))
							{
								if($_Rub ==  _NAV_GLOSSAIRE && $row[item_table_ref_req] == $_id  )
								{
									$aIdValeurs = split(",",$valeur);
									$aURL = array();
									for($z=0;$z<count($aIdValeurs);$z++)
									{
										if(verifContentId(_NAV_GLOSSAIRE,$aIdValeurs[$z]))
										{
											$aRes["url"][$z]["libelle"] = getLibelleContent("libelle","gab_glossaire",$aIdValeurs[$z]);
											$aRes["url"][$z]["url"] = getUrl(_NAV_FICHE_DEFINITION,"id=".$aIdValeurs[$z]);
										}

									}
								}
								else
								{
									$valeur=""; // liste a selection multiple sur clÃ¯Â¿Â½ Ã¯Â¿Â½trangÃ¯Â¿Â½re. Rien pour l'instant
								}
							}
							// FICHIER / IMAGE
							elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_file))
							{
								if( is_numeric( $valeur ) )
								{
									$img_dir = "portfolio_img";
									$valeur  = get_portfolio_img( $valeur );
								}
								else
								{
									$img_dir = $row[table_ref_req];
								}
								if($valeur != "" && file_exists(_CONST_PATH_TO_APPLI."images/upload/".$img_dir."/".$valeur))
								$valeur = "images/upload/".$img_dir."/".$valeur;
								else
								$valeur=""; //images/structuresite/photo-generique.jpg

							};
							break;

						case  "datetime":
							//spec trie par date du gabarit et non par l'ordre de la table object
							/*
							$aDate = explode(" ",$valeur);
							$myDate = split("-",$aDate[0]);
							$myTime = split(":",$aDate[1]);

							$myMktime = mktime($myTime[0],$myTime[1],$myTime[2],$myDate[1],$myDate[2],$myDate[0]);
							if( $myMktime_temp == "")
							{
							$myMktime_temp = $myMktime;
							$highestId = $row[item_table_ref_req] ;
							}
							if( $myMktime > $myMktime_temp  )
							{
							$myMktime_temp = $myMktime;
							$highestId = $row[item_table_ref_req] ;
							}
							*/

						case "date":
							$valeur = $_SESSION['ses_langue']==_ID_LANGUE_FR ?  Cdate($valeur,1) : CDateEn($valeur,1);
							break;
					}
				}

				$valeur = ereg_replace("<(p|\/p)[^>]*>", "", $valeur);
				if( $row[item_table_ref_req] == $_id )
				$aRes[$fieldname] = $valeur ;


			}
		}
		else
		echo mysql_error();

	}
	/*
	if($_id == "" && $highestId!="" && $tablename!="" )
	{
	$sql = "SELECT * from $tablename where id_$tablename = $highestId ";
	$aRes[0]  = getAllFieldsFromRst($sql);

	$aRes = $aRes[0][0];

	}
	*/

	return $aRes;
}
//==================================================
// CMS FRONT - Check pour une Rub si ya du content ou non
//==================================================
function isContentNull($_rub,$_template,$_urlRub)
{
	global $db;
	if(eregi("editorial\.php",$_urlRub))
	{
		$aContent = getContent($db,$_template,$_rub,false,false);
		if(count($aContent) > 0)
		{
			return false;
		}
		else
		{
			return true;
		}
	}
	else
	{
		return false;
	}
}

//=========================================================================
// CMS FRONT
//=========================================================================
function getContent($db, $_this,$_Rub, $_display = true, $_gabDefault = true)// $this -> template
{

  
	if(!$db->db_connect_id)
	{
		message_die(CRITICAL_ERROR, "Connexion Ã¯Â¿Â½ la base de donnÃ¯Â¿Â½es impossible");
	}

	// C'est une page contenant des objets gÃ¯Â¿Â½rÃ¯Â¿Â½s par le Content Management System et le workflow
	//On recupere le contenu de la rubrique en cours
	$StrSQL =   "
		        SELECT  
	        	    	_object.*  
	        	FROM  
	            		_object,  
	            		_nav,
	            		_langue
	        	WHERE  
	            		_object.id__nav = _nav.id__nav  
	            AND		
	            		_object.table_ref_req!='gab_bandeau_resultat'		
	        	AND
	            		_object.id__langue = _langue.id__langue
	        	AND 
	            		_nav.id__nav = $_Rub 
	        	AND
	            		_langue.id__langue = ".$_SESSION['ses_langue']."
	        	AND
	            		_object.id__workflow_state = "._WF_DISPLAYED_STATE_VALUE."
				ORDER BY  _object.ordre ASC";


	if (!($rsObject = $db->sql_query($StrSQL))) {
		message_die(GENERAL_ERROR, 'Impossible d\'exÃ¯Â¿Â½cuter la requÃ¯Â¿Â½te', '', __LINE__, __FILE__, $StrSQL,$db);
	}

	$nbres = $db->sql_numrows();

	// si pas de contenu , affichage du contenu anglais par dÃ¯Â¿Â½faut
	if( $nbres == 0)
	{
		if($_display && $_gabDefault )	$_this->display("gab/gab_default.tpl");
	}
	else
	{
		if($_display)
		traite_content($db, $_this,$_Rub,$_display);
		else
		return  traite_content($db, $_this,$_Rub,$_display);
	}

}



//=========================================================================
// CMS FRONT
//=========================================================================
function traite_content($db, &$ptr_this, $_Rub,$_display = true)
{
	global $path;
	global $datatype_text;
	global $datatype_multikey;
	global $datatype_url;
	global $datatype_file;
	global $datatype_arbo;

	$nbres = $db->sql_numrows();
	$compt = 0 ;

	for( $i=0; $i < $nbres; $i++ )
	{
		$row = $db->sql_fetchrow();
		$id_object 	= $row[id__object];
		$type       = $row[table_ref_req];
		$id         = $row[item_table_ref_req];
		//echo "-".$id_object."-".$id."-".$type."<br><br>";

		$StrSQLContent = "
	          			SELECT 
	              			".$type.".* 
	          			FROM 
	              			".$type." 
	          			WHERE  
	              			".$type.".id_".$type." = ".$id." 
	          		";
		//  echo "<br>".get_sql_format($StrSQLContent);
		$rstContent = mysql_query( $StrSQLContent );

		if (mysql_num_rows($rstContent) == 1)
		{

			// Maintenant qu'on a l'objet de contenu
			// on l'affiche Ã¯Â¿Â½ l'aide de son template dans la page courante

			$nb_cols = mysql_num_fields($rstContent);

			for ($k=0;$k<$nb_cols;$k++)
			{
				$fieldname  =	mysql_field_name($rstContent, $k);
				$fieldtype  =	mysql_field_type($rstContent, $k);
				$fieldlen	  =	mysql_field_len($rstContent, $k);
				$tablename  =	mysql_field_table($rstContent, $k);


				// Corrige erreur TATOOINE !! A retirer en prod
				if($_SERVER['SERVER_NAME'] == "10.63.1.83")
				{
					if ($fieldtype == "string") $fieldlen = $fieldlen / 3;
					if (!is_int($fieldlen)) $fieldlen = $fieldlen * 3; // divisÃ¯Â¿Â½ par erreur..
					// Fin a retirer en prod
				}

				//					echo($fieldname." - ".$fieldtype." $datatype_file - ".$fieldlen." -  <br>");

				$valeur = mysql_result($rstContent,0,$k);


				if ($valeur!="")
				{
					switch($fieldtype)
					{
						case "string":
							// Cas particulier sur les varchar (cf inc_init_bo)
							// URL
							if ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_url))
							{
								$valeur = "<a href=\"".$valeur."\">".$valeur."</a>";
							}
							// LISTE MULTIPLE SUR CLE ETRANGERE
							elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_multikey))
							{
								if($_Rub ==  _NAV_GLOSSAIRE )
								{
									$aIdValeurs = split(",",$valeur);

									if($_display)
									{
										$aURL = array();
										for($z=0;$z<count($aIdValeurs);$z++)
										{
											if(verifContentId(_NAV_GLOSSAIRE,$aIdValeurs[$z]))
											{
												$aUrl[$z]["url"] = getUrl(_NAV_FICHE_DEFINITION,"id=".$aIdValeurs[$z]);
												$aUrl[$z]["libelle"] = getLibelleContent("libelle","gab_glossaire",$aIdValeurs[$z]);
											}
										}
										$ptr_this -> assign("aUrl",$aUrl);
									}
									else
									{
										$aURL = array();
										for($z=0;$z<count($aIdValeurs);$z++)
										{
											if(verifContentId(_NAV_GLOSSAIRE,$aIdValeurs[$z]))
											{
												$aUrl[$z]["url"] = getUrl(_NAV_FICHE_DEFINITION,"id=".$aIdValeurs[$z]);
												$aUrl[$z]["libelle"] = getLibelleContent("libelle","gab_glossaire",$aIdValeurs[$z]);
											}

										}
										$aRes[$i]["url"] =  $aUrl;
									}
								}
								else
								{
									$valeur=""; // liste a selection multiple sur clÃ¯Â¿Â½ Ã¯Â¿Â½trangÃ¯Â¿Â½re. Rien pour l'instant
								}
							}
							// FICHIER / IMAGE
							elseif ($fieldlen==ereg_replace("(.*)\((.*)\)","\\2",$datatype_file))
							{
								if( is_numeric( $valeur ) )
								{
									$img_dir = "portfolio_img";
									$valeur  = get_portfolio_img( $valeur );
								}
								else
								{
									$img_dir = $type;
								}

								if($valeur != "" && file_exists(_CONST_PATH_TO_APPLI."images/upload/".$img_dir."/".$valeur))
								$valeur = "images/upload/".$img_dir."/".$valeur;
								else
								{
									$valeur="";
								}


							};
							break;
						case  "datetime":
						case "date":
							$valeur = $_SESSION['ses_langue']==_ID_LANGUE_FR ?  Cdate($valeur,1) : CDateEn($valeur,1);
							break;


						case "int" :   if($fieldname == $datatype_arbo || eregi($datatype_arbo."_[0-9]",$fieldname) )
						{
							$valeur = getUrl($valeur);
						}
						default:
					}
				}
				//echo("<br>".$fieldname." ".$fieldtype." ".$fieldlen." ".$tablename."<br>");

				// on affecte la valeur au tag (tag = nom du champ de la table)
				//echo("<br>".$fieldname." ==> ".$valeur."<br>");

				get_special_rules($tablename, $ptr_this, $fieldname, $valeur); // regles specifiques au contenu en cours
				$url = get_url_nav($_Rub);
        $valeur = str_replace('href="#','href="'.$url.'#',$valeur);
				if($_display)
				$ptr_this -> assign($fieldname,($valeur));
				else
				$aRes[$i][$fieldname] = $valeur;
			}


			if($_display)
			{
				/*
				//specifique A  --
				if($tablename == "gab_onglet_left" || $tablename == "gab_onglet_right"  )
				{
				$sql ="
				SELECT
				count(*) as nb
				FROM
				_object, _langue, _nav
				WHERE
				table_ref_req = '$tablename'
				AND
				_langue.id__langue=_object.id__langue
				AND
				_nav.id__nav=_object.id__nav
				AND
				_object.id__nav= ".$_Rub."
				AND
				_object.id__langue = ".$_SESSION['ses_langue']."
				";

				$aQ = getAllFieldsFromRst($sql);
				$ptr_this -> assign("nb_objs",$aQ[0]["nb"]);
				$num_obj++;
				$ptr_this -> assign("num_obj",$num_obj);


				if(($num_obj-1)%2 == 0)
				{
				$ptr_this -> assign("bMod2",1);
				}
				else
				{
				$ptr_this -> assign("bMod2",0);
				}

				}
				//=== fin spÃ¯Â¿Â½cifique
				*/
				//echo "gab/".$tablename._CONST_TPL_EXT;
				$ptr_this->display("gab/".$tablename._CONST_TPL_EXT);
			}
		}

	}

	if(!$_display) return $aRes;
}


//=========================================================================
// CMS FRONT
//=========================================================================
//-----------------------------------------------------------------------------------------------------
function get_special_rules($tablename,&$ptr_this, $fieldname, &$valeur)
{
	// permet d'instancer certaines valeurs specifiques au contenu en cours d'affichage
	switch($tablename)
	{
		case "maintitle": // cas particulier pour rÃ¯Â¿Â½cupÃ¯Â¿Â½rer le nom de l'ancre correspondant au maintitle
		if ($fieldname == "maintitle")
		$ptr_this -> assign("ancre",get_filename_from_text($valeur));
		break;

		case "page_header":
			if (($fieldname == "automenu")&&($valeur==1))
			{
				// on rÃ¯Â¿Â½cupere tous les maintitle du nav en cours pour le menu de droite
				$StrSQL =   "
        	        SELECT  
                	    	maintitle.maintitle                	    	 
                	FROM  
                    		maintitle
                    	INNER JOIN
                    		_object
                    	ON
                    		_object.item_table_ref_req = maintitle.id_maintitle
                	AND
                    		_object.id__workflow_state = "._WF_DISPLAYED_STATE_VALUE."
			AND 
                    		_object.table_ref_req = \"maintitle\"
			INNER JOIN
				_nav
			ON				                    		
                    		_object.id__nav = _nav.id__nav  
                	AND 
                    		_nav.id__nav = \"".$GLOBALS['Rub']."\"                     		
                    	INNER JOIN
                    		_langue
                	ON
                    		_object.id__langue = _langue.id__langue
                	AND
                    		_langue.id__langue = ".$_SESSION['ses_langue']."
                	ORDER BY
                    		_object.ordre ASC
                    	";

				//echo($StrSQL);

				$rstMenu = mysql_query($StrSQL);

				for($i=0;$i<mysql_num_rows($rstMenu);$i++)
				{
					$tab_menu_ligne[ANCRE] = get_filename_from_text(mysql_result($rstMenu,$i,0));
					$tab_menu_ligne[LIBELLE] = mysql_result($rstMenu,$i,0);
					$tab_menu[] = $tab_menu_ligne;
				}
				$ptr_this -> assign("tab_menu",$tab_menu);
			}
			break;
		default:
			break;
	}
}




//================================================================================================
// 								FONCTIONS LANGUES
//=================================================================================================
//-----------------------------------------------------------------------------------------------------
// Positionne la langue courante en fonction de la langue par dÃ¯Â¿Â½faut du navigateur et des variables de session en cours

function set_langue() {
	//GESTION DE LA LANGUE
	if (strcmp(_CONST_ENABLE_MULTILANGUE_FRONT,"true") != 0) {
		get_default_langue();
	}
	else
	{
		if (
		(
		!isset($_SESSION['ses_langue'])
		||
		!isset($_SESSION['ses_langue_ext'])
		||
		!isset($_SESSION['ses_langue_ext_sql'])
		)
		)
		{
			if (strcmp(_CONST_ENABLE_DETECT_LANGUE_NAVIGATOR,"true")==0) {
				//DÃ¯Â¿Â½tection de la langue pas defaut du navigateur si autorisÃ¯Â¿Â½
				$strSQL = "SELECT id__langue, _langue_abrev, _langue_ext_sql FROM _langue";
				$rstLangue = mysql_query($strSQL);
				$nb_langue = mysql_num_rows($rstLangue);

				$find = 0;

				for ($i=0; ( ($i<$nb_langue) && (!isset( $_SESSION['ses_langue'])) ) ;$i++)
				{
					$id__langue = mysql_result($rstLangue,$i,"id__langue");
					$langue_ext = mysql_result($rstLangue,$i,"_langue_abrev");
					$langue_ext_sql = mysql_result($rstLangue,$i,"_langue_ext_sql");

					$arrayAbrevLangFirst = split ( ",", getenv("HTTP_ACCEPT_LANGUAGE") ) ;

					if ( eregi ( $langue_ext, $arrayAbrevLangFirst[0] ) )
					{
						$_SESSION['ses_langue']             = $id__langue;
						$_SESSION['ses_langue_ext']         = $langue_ext;
						$_SESSION['ses_langue_ext_sql']     = $langue_ext_sql;
						$find = 1;
					}
				}
				// aucune langue repÃ¯Â¿Â½rÃ¯Â¿Â½e dans le navigateur..
				if (!$find) get_default_langue();
			}
			else
			{
				// detection langue navigateur interdit : on force la langue a la langue par dÃ¯Â¿Â½faut
				get_default_langue();
			}
		}
		else
		{
			//Switch de langue : on souhaite changer de langue
			if ( isset($_REQUEST['L']) && ($_REQUEST['L']!="") )
			{
				if (intval($_REQUEST['L']) == $_REQUEST['L']) { // L reÃ¯Â¿Â½u est une chaine (_langue_abrev) , ou un entier (id_langue) ?
					$champ = "id__langue";
					$valeur = intval($_REQUEST['L']);
				} else {
					$champ = "_langue_abrev";
					$valeur = "'".$_REQUEST['L']."'";
				}

				$strSQL = "SELECT id__langue, _langue_abrev, _langue_ext_sql FROM _langue WHERE ".$champ." = ".$valeur." LIMIT 1";
				$rstLangue = mysql_query($strSQL);



				if (mysql_num_rows($rstLangue) == 1)
				{
					$_SESSION['ses_langue']             = mysql_result($rstLangue,0,"id__langue");
					$_SESSION['ses_langue_ext']         = mysql_result($rstLangue,0,"_langue_abrev");
					$_SESSION['ses_langue_ext_sql']     = mysql_result($rstLangue,0,"_langue_ext_sql");
				}
				else
				{
					get_default_langue();
				}
			}
		}
	}
}

// renvoie la langue qui a Ã¯Â¿Â½tÃ¯Â¿Â½ positionnÃ¯Â¿Â½e comme langue par dÃ¯Â¿Â½faut pour le site courant
function get_default_langue()
{
	$strSQL = "SELECT id__langue, _langue_abrev FROM _langue WHERE _langue_by_default = 1 LIMIT 1";
	$rstLangue = mysql_query($strSQL);

	if (mysql_num_rows($rstLangue))
	{
		$_SESSION['ses_langue']             = mysql_result($rstLangue,0,"id__langue");
		$_SESSION['ses_langue_ext']         = mysql_result($rstLangue,0,"_langue_abrev");
		$_SESSION['ses_langue_ext_sql']     = (mysql_result($rstLangue,0,"_langue_abrev")=="fr"?"":"_".mysql_result($rstLangue,0,"_langue_abrev"));
	}
	else
	{
		// pas de langue positionnÃ¯Â¿Â½e par dÃ¯Â¿Â½faut... on renvoie la premiÃ¯Â¿Â½re langue trouvÃ¯Â¿Â½e...
		$strSQL = "SELECT id__langue, _langue_abrev FROM _langue LIMIT 1 order by id__langue";
		$rstLangue = mysql_query($strSQL);

		if (mysql_num_rows($rstLangue))
		{
			$_SESSION['ses_langue']             = mysql_result($rstLangue,0,"id__langue");
			$_SESSION['ses_langue_ext']         = mysql_result($rstLangue,0,"_langue_abrev");
			$_SESSION['ses_langue_ext_sql']     = mysql_result($rstLangue,0,"_langue_ext_sql");
		}
		else
		{
			// la table langue ne contient pas de langue.. pas possible car sinon pas de contenu.. mais bon.. on le prÃ¯Â¿Â½voit..
			// et on renvoie francais par dÃ¯Â¿Â½faut...
			$_SESSION['ses_langue']             = 1;
			$_SESSION['ses_langue_ext']         = "fr";
			$_SESSION['ses_langue_ext_sql']     = "";
		}
	}
}



//================================================================================================
// 								FONCTIONS IMAGES
//=================================================================================================

// Redimensionner une image
/*
function red_image($img_src,$img_dest,$dst_w,$dst_h,$rep_dest) {
// Lit les dimensions de l'image

//echo $img_src;
$size = getimagesize($img_src);
// echo "<br>-->".$size[0]."<br>";
$src_w = $size[0]; $src_h = $size[1];

// Teste les dimensions tenant dans la zone
$test_h = round(($dst_w / $src_w) * $src_h);
$test_w = round(($dst_h / $src_h) * $src_w);
// Si Height final non prÃ¯Â¿Â½cisÃ¯Â¿Â½ (0)
if(!$dst_h) $dst_h = $test_h;
// Sinon si Width final non prÃ¯Â¿Â½cisÃ¯Â¿Â½ (0)
elseif(!$dst_w) $dst_w = $test_w;
// Sinon teste quel redimensionnement tient dans la zone
elseif($test_h>$dst_h) $dst_w = $test_w;
else $dst_h = $test_h;

// La vignette existe ?
$test = (file_exists($img_dest));
// L'original a Ã¯Â¿Â½tÃ¯Â¿Â½ modifiÃ¯Â¿Â½ ?
if($test)
$test = (filemtime($img_dest)>filemtime($img_src));
// Les dimensions de la vignette sont correctes ?
if($test) {
$size2 = GetImageSize($img_dest);
$test = ($size2[0]==$dst_w);
$test = ($size2[1]==$dst_h);
}

// CrÃ¯Â¿Â½er la vignette ?
if(!$test) {

// CrÃ¯Â¿Â½e une image vierge aux bonnes dimensions
// $dst_im = ImageCreate($dst_w,$dst_h);
$dst_im = ImageCreateTrueColor($dst_w,$dst_h);
// Copie dedans l'image initiale redimensionnÃ¯Â¿Â½e
$src_im = ImageCreateFromJpeg($img_src);

// ImageCopyResized($dst_im,$src_im,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
ImageCopyResampled($dst_im,$src_im,0,0,0,0,$dst_w,$dst_h,$src_w,$src_h);
// Sauve la nouvelle image
ImageJpeg($dst_im,$rep_dest.$img_dest,_CONST_JPG_COMPRESSION_QUALITY);
// DÃ¯Â¿Â½truis les tampons
ImageDestroy($dst_im);
ImageDestroy($src_im);
}

return $img_dest;
}

*/
// FONCTION qui renvoie le chemin complet vers la photo
function get_image($nom_image, $img_dir, $alt, $w, $h )
{
	if ($nom_image)
	{
		if( is_numeric( $nom_image ) )
		{
			$img_dir        = "portfolio_img";
			$nom_image      = get_portfolio_img( $nom_image );
		}

		return get_img( $nom_image, "images/upload/".$img_dir."/", $alt, $w, $h );
	}
	else
	{
		return "";
	}
}
//-----------------------------------------------------------------------------------------------------
/* 					FUNCTION FULLRCH
//-----------------------------------------------------------------------------------------------------
Description : recherche FULLTEXT sur une base mysql
Cette recherche utilise la method levenstein pour reperer dans deux textes le ou les mots qui correpondent Ã¯Â¿Â½ la recherche
tous les mot recherchÃ¯Â¿Â½ devront se trouver dans l'un ou l'autre des deux texte
vous pouvez rechercher plusieurs mots en les separant par des espaces
Cette fonction peut prendre beaucoup de temps si la base mysql est importante
retourne un tableau dont tous les $ch1 qui correspondent a la recherche sinon affiche un message et retoune FALSE
Fonction inspirÃ¯Â¿Â½e de celle dÃ¯Â¿Â½veloppÃ¯Â¿Â½e par c.janssens (cyril.janssens@caramail.com)

$rch : chaine recherchÃ¯Â¿Â½e (exacte !)
$strSQL : requete SQL Ã¯Â¿Â½ executer
$nbchamps : nb de champs sur lesquels portent la recherche : on recherche du champ 1 Ã¯Â¿Â½ $nbchamps
$coef : coefficient levenstein, recommandÃ¯Â¿Â½ 2

N.B. : la connexion doit Ã¯Â¿Â½tre ouverte au prÃ¯Â¿Â½alable
*/

// fonction de comparaison des min valeurs avec le seuil
function tval($val,$coef)
{
	if(min($val) <= $coef)
	{
		return TRUE;
	}
	else
	{
		return FALSE;
	}
}

function fullrch($rch,$strSQL,$nbchamps,$coef=2)
{

	// lance la requete
	$req = mysql_query($strSQL);

	$rec = array();
	$rch = trim($rch);
	$rch = (substr($rch,-1)=="s"?substr($rch,0,-1):$rch);

	// parcours des resultats
	while($data = mysql_fetch_array($req))
	{
		// pour tous les champs recherchÃ¯Â¿Â½s dans la requÃ¯Â¿Â½te (en dehors du premier champ qui doit renvoyer la clÃ¯Â¿Â½!)
		for ($c=1;$c<=$nbchamps;$c++) // Ã¯Â¿Â½ partir de 1 car 1er champ = clÃ¯Â¿Â½ Ã¯Â¿Â½ renvoyer si trouvÃ¯Â¿Â½
		{
			// formatte le resultat
			$data[$c] = ereg_replace(",","",$data[$c]);
			$data[$c] = ereg_replace("'","",$data[$c]);
			$data[$c] = strip_tags($data[$c]);

			$str3 = $data[$c];
			$tstr3 = explode(" ",$str3);

			$jaf = array();
			$nb = count($tstr3);
			// parcours les mots du champ renvoyÃ¯Â¿Â½s par la requÃ¯Â¿Â½te
			for($i = 0;$i < $nb;$i++)
			{
				$tstr3[$i] = trim($tstr3[$i]);
				$pourc = levenshtein(get_no_accent_from_text(strtolower($rch)),get_no_accent_from_text(strtolower($tstr3[$i])));
				//echo("<br>Rec : ".get_no_accent_from_text(strtolower($rch))."  -- Mot : ".get_no_accent_from_text(strtolower($tstr3[$i]))." --> $pourc<br><hr>");
				array_push($jaf,$pourc); // construit le tableau de pourcentage temporaire
			}

			if((tval($jaf,$coef) === TRUE) && (!in_array($data[0],$rec)))
			{
				array_push($rec,$data[0]); // on ajoute Ã¯Â¿Â½ la liste des id valides s'il n'est pas dÃ¯Â¿Â½ja dans le tableau
			}
		}
	}
	return $rec; // renvoie le tableau des id = [req[0]] valides
	mysql_free_result($req);
}
/*-------------------------------------------------------------------------------------------*/
// renvoie une chaine de like formattÃ¯Â¿Â½e Ã¯Â¿Â½ la multiple choice du fullkit...
//
// permet de s'affranchir des non jointures sur les champs foreign keys du fullkit
//
function get_multi_fullkit_choice($fieldname,$searchvalue)
{
	$return = " (".$fieldname." like '".$searchvalue."' OR ";
	$return .= $fieldname." like '%,".$searchvalue.",%' OR ";
	$return .= $fieldname." like '".$searchvalue.",%' OR ";
	$return .= $fieldname." like '%,".$searchvalue."') ";

	return $return;
}
/*-------------------------------------------------------------------------------------------*/


//================================================================================================
// 								FONCTIONS MANIPULATION DE DATE
//=================================================================================================
function date_add($val,$jour,$format=1) {
	if (ereg("/",$val)) {
		$tab = split("/",$val);
		$ts = mktime(0,0,0,$tab['1'],$tab['0'],$tab['2']);
	}else{
		$tab = split("-",$val);
		$ts = mktime(0,0,0,$tab['1'],$tab['2'],$tab['0']);
	}

	$ts = $ts + ($jour*90000); // important pour changement d'heure !
	switch($format) {
		case 1 :
			return(date("d/m/Y", $ts));
			break;
		case 2 :
			return(date("Y-m-d", $ts));
			break;
		default :
			return(date("d/m/Y", $ts));
			break;
	}
}

function date_sub($val,$jour) {
	if (ereg("/",$val)) {
		$tab = split("/",$val);
		$ts = mktime(0,0,0,$tab['1'],$tab['0'],$tab['2']);
	}else{
		$tab = split("-",$val);
		$ts = mktime(0,0,0,$tab['1'],$tab['2'],$tab['0']);
	}

	$ts = $ts - ($jour*80000); // important pour changement d'heure !
	switch($format) {
		case 1 :
			return(date("d/m/Y", $ts));
			break;
		case 2 :
			return(date("Y-m-d", $ts));
			break;
		default :
			return(date("d/m/Y", $ts));
			break;
	}
}

// compare 2 dates
function date_compare($val1,$val2) {
	$tab1 = split("-",$val1);
	$tab2 = split("-",$val2);

	if (($tab1['0']==$tab2['0'])&&($tab1['1']==$tab2['1'])&&($tab1['2']==$tab2['2'])) {
		return 1;
	}else{
		return 0;
	}
}

//donne la diff en termes de mois / semaines / jours / heures /secs
function date_diff($_mkTime1,$_mkTime2)
{
	//calcul du nombre de mois
	$difference = $_mkTime2 - $_mkTime1;
	$residu = $difference % ((365/12)*86400);  // 1461/48 pour 4 ans
	$nb_mois = floor(($difference - $residu) / ((365/12)*86400));

	//calcul du nombre de semaine
	$difference = $residu;
	$residu = $difference % (7*86400);
	$nb_semaines = floor(($difference - $residu) / (7*86400));

	//calcul du nombre de jours
	$difference = $residu;
	$residu = $difference % 86400;
	$nb_jours = floor(($difference - $residu) / 86400);

	//calcul du nombre d'heures
	$difference = $residu;
	$residu = $difference % 3600;
	$nb_heures = floor(($difference - $residu) / 3600);

	//calcul du nombre de minutes
	$difference = $residu;
	$residu = $difference % 60;
	$nb_minutes = floor(($difference - $residu) / 60);

	//nombre de secondes
	$nb_secondes = $residu;
	//affichage du rÃ¯Â¿Â½sultat
	//echo $calcul.$nb_mois." mois ".$nb_semaines." semaines ".$nb_jours." jours ".$nb_heures." heures ".$nb_minutes." minutes et ".$nb_secondes." secondes";

	return array("mois" => $nb_mois,
	"semaine" => $nb_semaines,
	"jours" => $nb_jours,
	"heures" => $nb_heures,
	"minutes" => $nb_minutes,
	"secondes" => $nb_secondes );
}

//donne la diff en termes de mois / semaines / jours / heures /secs
function date_diff_jours ($_mkTime1,$_mkTime2)
{
	//calcul du nombre de jours
	$difference = $_mkTime2 - $_mkTime1;;
	$residu = $difference % 86400;
	$nb_jours = floor(($difference - $residu) / 86400);
	return $nb_jours;
}

function compare_date($d1,$d2){
	$d1_array = explode("-",$d1);
	$d2_array = explode("-",$d2);
	$millis = mktime(0, 0, 0, $d1_array[1] , $d1_array[2] , $d1_array[0]);
	$millis2 = mktime(0, 0, 0, $d2_array[1] , $d2_array[2] , $d2_array[0]);
	if($millis < $millis2)
	return "inf";
	elseif($millis == $millis2)
	return "eq";
	else
	return "sup";
}


//================================================================================================
// 								FONCTIONS LIEES A UN FLASH
//=================================================================================================
// retourne le code flash pour afficher un graph
function getGraph($type,$id_graph) {
	// histogramme
	if ($type==1) {
		$str_graph = "./admin/graphiques/lineaire.swf";
		$hauteur = 400;

		// camembert
	}else{
		$str_graph = "./admin/graphiques/camembert.swf";
		$hauteur = 200;
	}

	$retour = '<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="400" height="'.$hauteur.'">';
	$retour = $retour.'<param name="movie" value="'.$str_graph.'?id_graph='.$id_graph.'">';
	$retour = $retour.'<param name="quality" value="high">';
	$retour = $retour.'<embed src="'.$str_graph.'?id_graph='.$id_graph.'" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="400" height="'.$hauteur.'"></embed></object>';

	return $retour;
}

// format le text en flash text
function setFlashText($texte, $_bminuscule = false) {
	$temp = unhtmlentities($texte);
	$temp = !$_bminuscule ? ereg_replace("<br />","\n",$temp) : eregi_replace("<br />","\n",$temp);
	$temp = !$_bminuscule ? ereg_replace("<p>","",$temp) : eregi_replace("<p>","",$temp);
	$temp = !$_bminuscule ? ereg_replace("</p>","",$temp) : eregi_replace("</p>","",$temp);
	$temp = utf8_encode($temp);
	return $temp;
}


//================================================================================================
// 								FONCTIONS CHAINES CARACTERES
//=================================================================================================

// *** Retourne un texte avec les accents en minuscule
function getMinAccent($texte) {

	$texte = str_replace("", "", $texte);
	$texte = str_replace("", "", $texte);
	$texte = str_replace("", "", $texte);
	$texte = str_replace("", "", $texte);

	$texte = str_replace("", "", $texte);
	$texte = str_replace("", "", $texte);
	$texte = str_replace("", "", $texte);

	$texte = str_replace("", "", $texte);
	$texte = str_replace("", "", $texte);

	$texte = str_replace("", "", $texte);

	$texte = str_replace("", "", $texte);
	$texte = str_replace("", "", $texte);

	$texte = str_replace("", "", $texte);
	$texte = str_replace("", "", $texte);

	$texte = str_replace("É", "é", $texte);
	$texte = str_replace("Ê", "ê", $texte);
	$texte = str_replace("È", "è", $texte);
	$texte = str_replace("Ë", "ë", $texte);

	$texte = str_replace("À", "à", $texte);
	$texte = str_replace("Â", "â", $texte);
	$texte = str_replace("Ä", "ä", $texte);

	$texte = str_replace("Î", "î", $texte);
	$texte = str_replace("Ï", "ï", $texte);

	$texte = str_replace("Ô", "ô", $texte);

	$texte = str_replace("Û", "û", $texte);
	$texte = str_replace("Ü", "ü", $texte);

	$texte = str_replace("Ç", "ç", $texte);
	$texte = str_replace("Œ", "œ", $texte);

	return $texte;
}

//================================================================================================
// 								FONCTIONS BD
//=================================================================================================
//Renvoit le nom du fichier stockÃ¯Â¿Â½ en base (que ce soit un fichier portfolio ou un upload)
// Vide si on ne trouve pas le fichier sur le serveur
function getFileFromBDD($valeur_file,$table,$path="" )
{
	// Image
	$file_final = "";
	if ( $valeur_file != "" )
	{
		if( is_numeric($valeur_file ) )
		{
			$file_dir 			= "portfolio_img";
			$valeur_file  		= get_portfolio_img( $valeur_file );

		}
		else
		{
			$file_dir = $table;
		}

		//On regarde si le fichier existe
		$file_final = "images/upload/".$file_dir."/".$valeur_file;

		if (!file_exists($path.$file_final))
		{
			$file_final = "";
		}
	}
	else
	{
		$file_final = "";
	}

	return $file_final;
}


function set_query($sql){
	$result = mysql_query($sql);

	if(!$result){
		erreur_sql_to_file($sql, mysql_error());
	}else{
		return $result;
	}
}


function getAllFieldsFromRst($sql,$_tableName = "", $_path = "./")
{
	$datatype_file	= "varchar(100)";

	$rst = set_query($sql);
	$nb_fields_returned = count(mysql_fetch_array($rst,MYSQL_NUM));

	for($i=0;$i<mysql_num_rows($rst);$i++)
	{
		for($j=0;$j<$nb_fields_returned;$j++)
		{
			switch (mysql_field_name($rst,$j))
			{
				default :
					if (mysql_field_len($rst,$j)==ereg_replace("(.*)\((.*)\)","\\2",$datatype_file))
					{
						$aResult[$i][mysql_field_name($rst,$j)] = getFileFromBDD(mysql_result($rst,$i,mysql_field_name($rst,$j)),$_tableName,$_path);
					}
					else
					{
						$aResult[$i][mysql_field_name($rst,$j)] = mysql_result($rst,$i,mysql_field_name($rst,$j));
					}
			}
		}
	}

	mysql_free_result($rst);
	return $aResult;
}

//=====================================================
//Renvoie la liste des donnÃ¯Â¿Â½es d'une table
//=====================================================
function getListData($_tablename,$_fields,$_id="", $_orderBy = "",$_bTrad = 1)
{
	$aFields = split(";",$_fields);

	$sFields = "";
	for($i=0;$i<count($aFields);$i++)
	{
		if($_bTrad) $sFields .= "tr.";
		$sFields .= $aFields[$i];
		if($i<count($aFields)-1) $sFields .= "," ;
	}

	$sql= "SELECT t.id_$_tablename, $sFields
		   FROM $_tablename t ";

	if($_bTrad)
	{
		$sql .= " INNER JOIN trad_$_tablename tr ON t.id_$_tablename = tr.id__$_tablename  ";
	}

	$sql .= " WHERE 1=1 " ;

	if($_bTrad) $sql .= " AND tr.id__langue = ".$_SESSION["ses_langue"] ;

	if($_id!="") $sql .= " AND t.id_$_tablename = '$_id' " ;

	if($_orderBy == "")
	{
		$sql .=  "  ORDER BY ".$aFields[0]  ;	 // 1er element fourni par defaut
	}
	else
	{
		$sql .=  "  ORDER BY ".$_orderBy;
	}

	//	tt($sql);

	return getAllFieldsFromRst($sql);
}


//===========================================
// Verifie si la val existe bien not used yet
//==========================================
function verifExistence($_val,$_tablename,$_field)
{
	$sql = " select * from $_tablename t inner join trad_$_tablename tr
			 on t.id_$_tablename = tr.id__$_tablename 
		 	 where tr.$_field = '".trim(addslashes($_val))."'";
	//	echo $sql;
	$rs = set_query($sql);
	if(mysql_num_rows($rs)>0)
	{
		return true;
	}
	else
	{
		return false;
	}
}
//================================================================================================
// 								FONCTIONS TRACAGE ERREURS / LOGS
//=================================================================================================
function erreur_sql_to_file($sql,$err)
{
	global $path;
	$filename = $path."logs/erreur_sql.txt";
	file_put_contents_php4($filename,"\n".$sql."\n".$err."\n","a");
}

function erreur_email($email,$from,$sujet,$msg){
	global $path;
	$filename = $path."logs/erreur_email.txt";
	$sContent = "TO :$email FROM : $from SUJET : $sujet MESSAGE : \n $msg \n\n";
	file_put_contents_php4($filename,$sContent,"a");
}

function log_email($email,$from,$sujet,$msg,$res){
	global $path;
	$filename = $path."logs/erreur_email.txt";
	$test = $res ? "rÃ¯Â¿Â½ussi" : "Ã¯Â¿Â½chouÃ¯Â¿Â½";
	$date = getdate();
	$today = $date["year"]."-".$date["mon"]."-".$date["mday"];
	$sContent = "DATE : $today TO :$email FROM : $from SUJET : $sujet RESULTAT : $test  MESSAGE : \n $msg \n\n";
	//	tt($sContent);
	file_put_contents_php4($filename,$sContent,"a");
}


//================================================================================================
// 								FONCTIONS DIVERSES
//=================================================================================================

//-----------------------------------------------------------------------------------------------------
// Formattage des messages d'erreur si DEBUG Ã¯Â¿Â½ 1 dans lib_global

function message_die($msg_code, $msg_text = '', $msg_title = '', $err_line = '', $err_file = '', $sql = '',$db_err="") {
	global $db, $template;

	if($db_err=="") $db_err = $db;

	$sql_store = $sql;
	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) ) {
		$sql_error = $db_err->sql_error();

		$debug_text = '';
		if ( $sql_error['message'] != '' ) {
			$debug_text .= '<br /><br />SQL Error : ' . $sql_error['code'] . ' ' . $sql_error['message'];
		}
		if ( $sql_store != '' )	{
			$debug_text .= "<br /><br />$sql_store";
		}
		if ( $err_line != '' && $err_file != '' ) {
			$debug_text .= '</br /><br />Line : ' . $err_line . '<br />File : ' . $err_file;
		}
	}

	switch($msg_code) {
		case GENERAL_MESSAGE:
			if ( $msg_title == '' )	{
				$msg_title = 'Information';
			}
			break;

		case GENERAL_MESSAGE_END:
			if ( $msg_title == '' )	{
				$msg_title = 'Information';
			}
			break;

		case CRITICAL_MESSAGE:
			if ( $msg_title == '' )	{
				$msg_title = 'Erreur Critique';
			}
			break;

		case GENERAL_ERROR:
			if ( $msg_text == '' ) {
				$msg_text = 'Une erreur est survenue';
			}
			if ( $msg_title == '' )	{
				$msg_title = 'Erreur Generale';
			}
			break;

		case CRITICAL_ERROR:
			if ( $msg_text == '' ) {
				$msg_text = 'Une erreur critique';
			}
			if ( $msg_title == '' )	{
				$msg_title = '<b>Erreur Critique</b>';
			}
			break;
	}

	if ( DEBUG && ( $msg_code == GENERAL_ERROR || $msg_code == CRITICAL_ERROR ) ) {
		if ( $debug_text != '' ) {
			$msg_text = $msg_text . '<br /><br /><b><u>DEBUG MODE</u></b>' . $debug_text;
		}
	}

	if ( $msg_code != CRITICAL_ERROR ) {
		if ( $msg_code == GENERAL_MESSAGE_END ) {
			$msg_action = "window.opener.location.reload();window.close();";
			$msg_action_str = "Fermer";
		} else {
			$msg_action = "history.back();";
			$msg_action_str = "Retour";
		}
		$template->assign('MESSAGE_TITLE',$msg_title);
		$template->assign('MESSAGE_TEXT',$msg_text);
		$template->assign('MESSAGE_ACTION',$msg_action);
		$template->assign('MESSAGE_ACTION_STR',$msg_action_str);
		$template->display('message.tpl');
	} else {
		echo "<html>\n<body>\n" . $msg_title . "\n<br /><br />\n" . $msg_text . "</body>\n</html>";
	}
	exit;
}

//-----------------------------------------------------------------------------------------------------
// fonction qui affiche le bouton precedent pour la pagination
// param => pour roolover image
// p => page en cours
function getPrecedent($param,$p, $fichier) {
	$temp = "";
	if (($p>1) && ($p!="")) {
		$p = ($p-1);
		$temp = "<a href=\"".$fichier."?P=".$p."&".$param."\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image9311','','images/".$_SESSION['nom_saison']."/on/fleche-gauche.gif',1)\"><img src=\"images/".$_SESSION['nom_saison']."/off/fleche-gauche.gif\" name=\"Image9311\" width=\"15\" height=\"15\" border=\"0\" id=\"Image931\"></a>";
		//$temp = "<a href=\"javascript:go(".$p.");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image9311','','images/".$_SESSION['nom_saison']."/on/fleche-gauche.gif',1)\"><img src=\"images/".$_SESSION['nom_saison']."/off/fleche-gauche.gif\" name=\"Image9311\" width=\"15\" height=\"15\" border=\"0\" id=\"Image931\"></a>";
	}

	return $temp;
}
//-----------------------------------------------------------------------------------------------------
// fonction qui affiche le bouton suivant pour la pagination
// param => pour roolover image
// p => page en cours
// max => nombre total d'enregistrements
function getSuivant($param ="&",$p,$max, $fichier) {
	$temp = "";

	if ($p=="undefined") $p=1;

	if ((($p*_NB_ENR_PAGE_RES)<$max)) {
		$p = ($p+1);
		$temp = "<a href=\"".$fichier."?P=".$p."&".$param."\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image9411','','images/".$_SESSION['nom_saison']."/on/fleche-droite.gif',1)\"><img src=\"images/".$_SESSION['nom_saison']."/off/fleche-droite.gif\" name=\"Image9411\" width=\"15\" height=\"15\" border=\"0\" id=\"Image941\"></a>";
		//$temp = "<a href=\"javascript:go(".$p.");\" onMouseOut=\"MM_swapImgRestore()\" onMouseOver=\"MM_swapImage('Image9411','','images/".$_SESSION['nom_saison']."/on/fleche-droite.gif',1)\"><img src=\"images/".$_SESSION['nom_saison']."/off/fleche-droite.gif\" name=\"Image9411\" width=\"15\" height=\"15\" border=\"0\" id=\"Image941\"></a>";
	}

	return $temp;
}

function smarty_trad($params) {
	extract($params);
	echo  get_libLocal($params['value']);
}

// Tri un tableau
function sort_by_key($array, $index) {
	$sort = array();
	//prÃ¯Â¿Â½paration d'un nouveau tableau basÃ¯Â¿Â½ sur la clÃ¯Â¿Â½ Ã¯Â¿Â½ trier
	foreach ($array as $key => $val) {
		$sort[$key] = $val[$index];
	}
	//tri par ordre naturel et insensible Ã¯Â¿Â½ la casse
	//natcasesort($sort);

	//formation du nouveau tableau triÃ¯Â¿Â½ selon la clÃ¯Â¿Â½
	$output = array();
	foreach($sort as $key => $val) {
		$output[] = $array[$key];
	}
	return $output;
}

function DelDoublonNomTable($array){

	$tab = array();
	$sort = array();
	$temp= array();
	$nom_rub="";
	foreach ($array as $val) {
		
			if($val["table"]!="" && $val["libelle"]!="" && $val["table"]!="Espace membre"){
				if($val["table"] != $nom_rub){
					$nom_rub = $val["table"];
					$sort = $val;
				}else{
					$val["table"]="";
					$sort = $val;
				}
				$tab[] = $sort;
				unset($sort);
			}
		
	}
	
	foreach ($tab as $val) {
		if(!in_array($val["url"],$temp)){
			$temp[] = $val["url"];
			$sort[] = $val;
		}
	}
	
	//trace($sort);
	
	return($sort);
}
function arrayUnique($myArray)
{
    if(!is_array($myArray))
           return $myArray;

    foreach ($myArray as &$myvalue){
        $myvalue=serialize($myvalue);
    }

    $myArray=array_unique($myArray);

    foreach ($myArray as &$myvalue){
        $myvalue=unserialize($myvalue);
    }

    return $myArray;

} 
function GetMetaCentre($id_centre){
	//TITLE :
  $sql_S = "SELECT centre.libelle AS libelle_centre,ville,code_postal,nb_chambre,id_centre_activite,id_centre_service,id_centre_detention_label,
  centre_region.libelle AS libelle_region 
  FROM centre 
  INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
  WHERE id_centre=".$id_centre;
  $result_S = mysql_query($sql_S);
  $nom_centre = mysql_result($result_S,0,"libelle_centre");
  $ville_centre = mysql_result($result_S,0,"ville");
  $cp_centre = mysql_result($result_S,0,"code_postal");
  $nb_chambre = mysql_result($result_S,0,"nb_chambre");
  $activite = mysql_result($result_S,0,"id_centre_activite");
  $service = mysql_result($result_S,0,"id_centre_activite");
  $label = mysql_result($result_S,0,"id_centre_detention_label");
  $region = mysql_result($result_S,0,"libelle_region");
  
  $title = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_title_centre'));
  $title = str_replace("##VILLE##",$ville_centre,$title);
  $title = str_replace("##CP##",$region,$title);
  //$title = str_replace("##CP##",$cp_centre,$title);
  $tab[0]= $title;
   
  //Description :
  $sql_S = "SELECT presentation FROM trad_centre WHERE id__centre=".$id_centre." AND id__langue=".$_SESSION['ses_langue'];
  $result_S2 = mysql_query($sql_S);
  $description_centre = mysql_result($result_S2,0,"presentation");
  $description_centre = str_replace("\"", "'", $description_centre);
  if(strlen($description_centre)>200){
    $description_centre = coupe_espace($description_centre,200);
  }
  $description_centre = "<meta name=\"description\" content=\"$description_centre\"/>";
  //echo $description_centre;
  $tab[1] = $description_centre;

  //Keyword :
  $keyword = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_keyword_centre'));
  $keyword = str_replace("##VILLE##",$ville_centre,$keyword);
  $keyword = str_replace("##CP##",$region,$keyword);
  //$keyword = str_replace("##CP##",$cp_centre,$keyword);
  $keyword = str_replace("##NBCHAMBRE##",$nb_chambre,$keyword);
  
  $sql_S = "SELECT libelle FROM trad_centre_activite WHERE id__centre_activite IN($activite)  and id__langue=".$_SESSION['ses_langue'];
  $result_S = mysql_query($sql_S);
  $nb = mysql_num_rows($result_S);
  while($myrow = mysql_fetch_array($result_S)){
  	if($myrow["libelle"] != ""){	
  		$liste_activite .=$myrow["libelle"].","; 
  	}	
  }
  if($nb){
  	$keyword.=",".$liste_activite;
  }
  $liste="";
  $sql_S = "SELECT libelle FROM trad_centre_service WHERE id__centre_service IN($service)  and id__langue=".$_SESSION['ses_langue'];
  $result_S = mysql_query($sql_S);
  $nb_1 = mysql_num_rows($result_S);
  while($myrow = mysql_fetch_array($result_S)){
  	if($myrow["libelle"] != ""){	
  		$liste .=$myrow["libelle"].","; 
  	}	
  }
  if($nb_1){
  	if(!$nb){
  		$keyword.=",";
  	}
  
  	$keyword.=$liste;
  }
  
  $liste="";
  $sql_S = "SELECT libelle FROM trad_centre_detention_label WHERE id__centre_detention_label IN($label)  and id__langue=".$_SESSION['ses_langue'];
  $result_S = mysql_query($sql_S);
  $nb_2 = mysql_num_rows($result_S);
  while($myrow = mysql_fetch_array($result_S)){
  	if($myrow["libelle"] != ""){	
  		$liste .=$myrow["libelle"].","; 
  	}	
  }
  if($nb_2){
  	if(!$nb || !$nb_1){
  		$keyword.=",";
  	}
  	$keyword.=$liste;
  }
  
  
  $keyword = "<meta name=\"keywords\" content=\"".$keyword."\"/>";
  $tab[2] = $keyword;
  
  return $tab;
}

function GetMetaCentreCvl($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT organisateur_cvl.id_centre AS id_centre, 
	trad_organisateur_cvl.libelle AS nom_cvl, 
	trad_organisateur_cvl.presentation_organisme AS presentation, 
	centre_region.libelle AS libelle_region 
	FROM organisateur_cvl 
	INNER JOIN centre ON (organisateur_cvl.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	INNER JOIN trad_organisateur_cvl ON (trad_organisateur_cvl.id__organisateur_cvl = organisateur_cvl.id_organisateur_cvl 
	AND trad_organisateur_cvl.id__langue=".$_SESSION['ses_langue'].") 
	WHERE id_organisateur_cvl=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_centre = mysql_result($result_S,0,"nom_cvl");
	$region = mysql_result($result_S,0,"libelle_region");
	$description_centre = mysql_result($result_S,0,"presentation");
    $description_centre = str_replace("\"", "'", $description_centre);
	
	$title = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_title_orga_cvl'));
	$title = str_replace("##REGION##",$region,$title);
	$tab[0]= $title;
	
	//Description :
	if(strlen($description_centre)>200)
	{
		$description_centre = coupe_espace($description_centre,200);
	}
	$description_centre = "<meta name=\"description\" content=\"$description_centre\"/>";
	$tab[1] = $description_centre;
	
	//Keyword :
	$keyword = "<meta name=\"keywords\" content=\"\"/>";
	$tab[2] = $keyword;
	
	return $tab;
}

function GetMetaSejourClasseDecouverte($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT classe_decouverte.id_centre AS id_centre, 
	classe_decouverte.nom AS nom_sejour, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre_region.libelle AS libelle_region, 
	id_sejour_theme, 
	id_sejour_niveau_scolaire 
	FROM classe_decouverte 
	INNER JOIN centre ON (classe_decouverte.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	WHERE id_classe_decouverte=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$nom_sejour = mysql_result($result_S,0,"nom_sejour");
	$region = mysql_result($result_S,0,"libelle_region");
	$id_theme = mysql_result($result_S,0,"id_sejour_theme");
	$id_niveau = mysql_result($result_S,0,"id_sejour_niveau_scolaire");
	
	$title = str_replace("##SEJOUR##",$nom_sejour,get_libLocal('lib_title_classe_decouverte'));
	$title = str_replace("##REGION##",$region,$title);
	$tab[0]= $title;
	
	//Description :
	$sql_S2 = "SELECT interet_pedagogique 
	FROM trad_classe_decouverte 
	WHERE id__classe_decouverte=".$id_sejour." 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S2 = mysql_query($sql_S2);
	$interet = mysql_result($result_S2,0,"interet_pedagogique");
	if(strlen($interet)>200)
	{
		$interet = coupe_espace($interet,200);
	}
	if(!empty($interet))
	{
		$interet = str_replace("##INTERETS##",$interet,get_libLocal('lib_description_classe_decouverte'));
	}
	else
	{
		$interet = '';
	}
	$tab[1] = "<meta name=\"description\" content=\"$interet\"/>";
	
	//Keyword :
	$sql_S3 = "SELECT libelle 
	FROM trad_sejour_theme 
	WHERE id__sejour_theme IN (".$id_theme.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S3 = mysql_query($sql_S3);
	$theme = '';
	$i = 0;
	while($myrow = mysql_fetch_assoc($result_S3))
	{
		if($i > 0)
		{
			$theme.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$theme.= $myrow["libelle"]; 
		}
		
		$i ++;
	}
	
	$sql_S4 = "SELECT libelle 
	FROM trad_sejour_niveau_scolaire 
	WHERE id__sejour_niveau_scolaire IN (".$id_niveau.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S4 = mysql_query($sql_S4);
	$niveau = '';
	$j = 0;
	while($myrow = mysql_fetch_assoc($result_S4))
	{
		if($j > 0)
		{
			$niveau.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$niveau.= $myrow["libelle"]; 
		}
		
		$j ++;
	}
	
	$keyword = str_replace("##SEJOUR##",$nom_sejour,get_libLocal('lib_keywords_classe_decouverte'));
	$keyword = str_replace("##REGION##",$region,$keyword);
	$keyword = str_replace("##VILLE##",$ville_centre,$keyword);
	$keyword = str_replace("##CENTRE##",$nom_centre,$keyword);
	$keyword = str_replace("##THEME##",$theme,$keyword);
	$keyword = str_replace("##NIV_SCOLAIRE##",$niveau,$keyword);
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaSejourScolaire($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT accueil_groupes_scolaires.id_centre AS id_centre, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre.nb_chambre AS nb_chambre, 
	centre_region.libelle AS libelle_region, 
	centre.id_centre_detention_label AS labels, 
	centre.id_centre_activite AS activites, 
	centre.id_centre_service AS services 
	FROM accueil_groupes_scolaires 
	INNER JOIN centre ON (accueil_groupes_scolaires.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	WHERE id_accueil_groupes_scolaires=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$nom_sejour = mysql_result($result_S,0,"nom_sejour");
	$region = mysql_result($result_S,0,"libelle_region");
	$nb_chambre = mysql_result($result_S,0,"nb_chambre");
	$id_activites = mysql_result($result_S,0,"activites");
	$id_services = mysql_result($result_S,0,"services");
	$id_labels = mysql_result($result_S,0,"labels");
	
	$title = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_title_sejour_scolaire'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	$sql_S2 = "SELECT presentation 
	FROM trad_centre 
	WHERE id__centre=".$id_centre." 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S2 = mysql_query($sql_S2);
	$presentation = mysql_result($result_S2,0,"presentation");
    $presentation = str_replace("\"", "'", $presentation);
    
	if(strlen($presentation)>200)
	{
		$presentation = coupe_espace($presentation,200);
	}
	$tab[1] = "<meta name=\"description\" content=\"$presentation\"/>";
	
	//Keyword :
	$sql_S3 = "SELECT libelle 
	FROM trad_centre_activite 
	WHERE id__centre_activite IN (".$id_activites.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S3 = mysql_query($sql_S3);
	$activites = '';
	$i = 0;
	while($myrow = mysql_fetch_assoc($result_S3))
	{
		if($i > 0)
		{
			$activites.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$activites.= $myrow["libelle"]; 
		}
		
		$i ++;
	}
	
	$sql_S4 = "SELECT libelle 
	FROM trad_centre_service 
	WHERE id__centre_service IN (".$id_services.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S4 = mysql_query($sql_S4);
	$services = '';
	$j = 0;
	while($myrow = mysql_fetch_assoc($result_S4))
	{
		if($j > 0)
		{
			$services.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$services.= $myrow["libelle"]; 
		}
		
		$j ++;
	}
	
	$sql_S5 = "SELECT libelle 
	FROM trad_centre_detention_label 
	WHERE id__centre_detention_label IN (".$id_labels.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S5 = mysql_query($sql_S5);
	$labels = '';
	$k = 0;
	while($myrow = mysql_fetch_assoc($result_S5))
	{
		if($k > 0)
		{
			$labels.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$labels.= $myrow["libelle"]; 
		}
		
		$k ++;
	}
	
	$keyword = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_keywords_scolaire'));
	$keyword = str_replace("##REGION##",$region,$keyword);
	$keyword = str_replace("##VILLE##",$ville_centre,$keyword);
	$keyword = str_replace("##NB_CHAMBRES##",$nb_chambre,$keyword);
	if(!empty($services))
	{
		$keyword = str_replace("##SERVICES##",$services,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##SERVICES##",'',$keyword);
	}
	if(!empty($activites))
	{
		$keyword = str_replace("##ACTIVITES##",$activites,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##ACTIVITES##",'',$keyword);
	}
	if(!empty($labels))
	{
		$keyword = str_replace("##LABELS##",$labels,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##LABELS##",'',$keyword);
	}
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaSejourCvl($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT cvl.id_centre AS id_centre, 
	cvl.nom AS nom_sejour, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre_region.libelle AS libelle_region, 
	id_sejour_accueil_handicap 
	FROM cvl 
	INNER JOIN centre ON (cvl.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	WHERE id_cvl=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$nom_sejour = mysql_result($result_S,0,"nom_sejour");
	$region = mysql_result($result_S,0,"libelle_region");
	$id_handicap = mysql_result($result_S,0,"id_sejour_accueil_handicap");
	
	$title = str_replace("##SEJOUR##",$nom_sejour,get_libLocal('lib_title_cvl'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	$sql_S2 = "SELECT presentation 
	FROM trad_cvl 
	WHERE id__cvl=".$id_sejour." 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S2 = mysql_query($sql_S2);
	$presentation = strip_tags(mysql_result($result_S2,0,"presentation"));
    $presentation = str_replace("\"", "'", $presentation);
    
	if(strlen($presentation)>200)
	{
		$presentation = coupe_espace($presentation,200);
	}
	$tab[1] = "<meta name=\"description\" content=\"$presentation\"/>";
	
	//Keyword :
	$sql_S3 = "SELECT libelle 
	FROM trad_sejour_accueil_handicap 
	WHERE id__sejour_accueil_handicap IN (".$id_handicap.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S3 = mysql_query($sql_S3);
	$handicap = '';
	$i = 0;
	while($myrow = mysql_fetch_assoc($result_S3))
	{
		if($i > 0)
		{
			$handicap.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$handicap.= $myrow["libelle"]; 
		}
		
		$i ++;
	}
	
	$keyword = str_replace("##SEJOUR##",$nom_sejour,get_libLocal('lib_keywords_cvl'));
	$keyword = str_replace("##REGION##",$region,$keyword);
	$keyword = str_replace("##VILLE##",$ville_centre,$keyword);
	$keyword = str_replace("##CENTRE##",$nom_centre,$keyword);
	if(!empty($handicap))
	{
		$keyword = str_replace("##HANDICAP##",$handicap,$keyword);
	}
	else
	{
		$keyword = str_replace(", sÃƒÂ©jour adaptÃƒÂ© ##HANDICAP##",'',$keyword);
	}
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaAccueilReunion($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT accueil_reunions.id_centre AS id_centre, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre_region.libelle AS libelle_region, 
	centre.nb_salle_reunion AS nb_salles, 
	centre.capacite_salle_min AS cap_min, 
	centre.capacite_salle_max AS cap_max, 
	id_sejour_materiel_service 
	FROM accueil_reunions 
	INNER JOIN centre ON (accueil_reunions.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	WHERE id_accueil_reunions=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$region = mysql_result($result_S,0,"libelle_region");
	$nb_salles = mysql_result($result_S,0,"nb_salles");
	$capacite_min = mysql_result($result_S,0,"cap_min");
	$capacite_max = mysql_result($result_S,0,"cap_max");
	$id_services = mysql_result($result_S,0,"id_sejour_materiel_service");
	
	$title = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_title_accueil_reunion'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	$description = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_description_accueil_reunion'));
	$description = str_replace("##NB_SALLES##",$nb_salles,$description);
	$description = str_replace("##VILLE##",$ville_centre,$description);
	$description = str_replace("##CAP_MIN##",$capacite_min,$description);
	$description = str_replace("##CAP_MAX##",$capacite_max,$description);
	$tab[1] = "<meta name=\"description\" content=\"$description\"/>";
	
	//Keyword :
	$sql_S3 = "SELECT libelle 
	FROM trad_sejour_materiel_service 
	WHERE id__sejour_materiel_serviceid_sejour_materiel_service IN (".$id_services.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S3 = mysql_query($sql_S3);
	$services = '';
	$i = 0;
	while($myrow = mysql_fetch_assoc($result_S3))
	{
		if($i > 0)
		{
			$services.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$services.= $myrow["libelle"]; 
		}
		
		$i ++;
	}
	
	$keyword = str_replace("##REGION##",$region,get_libLocal('lib_keywords_accueil_reunion'));
	if(!empty($services))
	{
		$keyword = str_replace("##SERVICES##",$services,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##SERVICES##",'',$keyword);
	}
	$keyword = str_replace("##VILLE##",$ville_centre,$keyword);
	$keyword = str_replace("##CENTRE##",$nom_centre,$keyword);
	if(!empty($handicap))
	{
		$keyword = str_replace("##HANDICAP##",$handicap,$keyword);
	}
	else
	{
		$keyword = str_replace(", sÃƒÂ©jour adaptÃƒÂ© ##HANDICAP##",'',$keyword);
	}
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaSeminaire($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT seminaires.id_centre AS id_centre, 
	seminaires.nom AS nom_seminaire, 
	centre.ville AS ville_centre, 
	centre_region.libelle AS libelle_region 
	FROM seminaires 
	INNER JOIN centre ON (seminaires.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	WHERE id_seminaires=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_seminaire = mysql_result($result_S,0,"nom_seminaire");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$region = mysql_result($result_S,0,"libelle_region");
	
	$title = str_replace("##SEMINAIRE##",$nom_seminaire,get_libLocal('lib_title_seminaire'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	$sql_S2 = "SELECT descriptif 
	FROM trad_seminaires 
	WHERE id__seminaires=".$id_sejour." 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S2 = mysql_query($sql_S2);
	$presentation = strip_tags(mysql_result($result_S2,0,"descriptif"));
    $presentation = str_replace("\"", "'", $presentation);
    
	if(strlen($presentation)>200)
	{
		$presentation = coupe_espace($presentation,200);
	}
	$tab[1] = "<meta name=\"description\" content=\"$presentation\"/>";
	
	//Keyword :
	$keyword = str_replace("##REGION##",$region,get_libLocal('lib_keywords_seminaire'));
	$keyword = str_replace("##VILLE##",$ville_centre,$keyword);
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaAccueilGroupe($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT accueil_groupes_jeunes_adultes.id_centre AS id_centre, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre.nb_chambre AS nb_chambre, 
	centre_region.libelle AS libelle_region, 
	centre.id_centre_detention_label AS labels, 
	centre.id_centre_activite AS activites, 
	centre.id_centre_service AS services 
	FROM accueil_groupes_jeunes_adultes 
	INNER JOIN centre ON (accueil_groupes_jeunes_adultes.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	WHERE id_accueil_groupes_jeunes_adultes=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$region = mysql_result($result_S,0,"libelle_region");
	$nb_chambre = mysql_result($result_S,0,"nb_chambre");
	$id_activites = mysql_result($result_S,0,"activites");
	$id_services = mysql_result($result_S,0,"services");
	$id_labels = mysql_result($result_S,0,"labels");
	
	$title = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_title_accueil_groupes'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	$sql_S2 = "SELECT presentation 
	FROM trad_centre 
	WHERE id__centre=".$id_centre." 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S2 = mysql_query($sql_S2);
	$presentation = mysql_result($result_S2,0,"presentation");
    $presentation = str_replace("\"", "'", $presentation);
    
	if(strlen($presentation)>200)
	{
		$presentation = coupe_espace($presentation,200);
	}
	$tab[1] = "<meta name=\"description\" content=\"$presentation\"/>";
	
	//Keyword :
	$sql_S3 = "SELECT libelle 
	FROM trad_centre_activite 
	WHERE id__centre_activite IN (".$id_activites.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S3 = mysql_query($sql_S3);
	$activites = '';
	$i = 0;
	while($myrow = mysql_fetch_assoc($result_S3))
	{
		if($i > 0)
		{
			$activites.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$activites.= $myrow["libelle"]; 
		}
		
		$i ++;
	}
	
	$sql_S4 = "SELECT libelle 
	FROM trad_centre_service 
	WHERE id__centre_service IN (".$id_services.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S4 = mysql_query($sql_S4);
	$services = '';
	$j = 0;
	while($myrow = mysql_fetch_assoc($result_S4))
	{
		if($j > 0)
		{
			$services.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$services.= $myrow["libelle"]; 
		}
		
		$j ++;
	}
	
	$sql_S5 = "SELECT libelle 
	FROM trad_centre_detention_label 
	WHERE id__centre_detention_label IN (".$id_labels.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S5 = mysql_query($sql_S5);
	$labels = '';
	$k = 0;
	while($myrow = mysql_fetch_assoc($result_S5))
	{
		if($k > 0)
		{
			$labels.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$labels.= $myrow["libelle"]; 
		}
		
		$k ++;
	}
	
	$keyword = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_keywords_accueil_groupes'));
	$keyword = str_replace("##REGION##",$region,$keyword);
	$keyword = str_replace("##VILLE##",$ville_centre,$keyword);
	$keyword = str_replace("##NB_CHAMBRES##",$nb_chambre,$keyword);
	if(!empty($services))
	{
		$keyword = str_replace("##SERVICES##",$services,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##SERVICES##",'',$keyword);
	}
	if(!empty($activites))
	{
		$keyword = str_replace("##ACTIVITES##",$activites,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##ACTIVITES##",'',$keyword);
	}
	if(!empty($labels))
	{
		$keyword = str_replace("##LABELS##",$labels,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##LABELS##",'',$keyword);
	}
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaAccueilSportif($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT accueil_groupes_jeunes_adultes.id_centre AS id_centre, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre.nb_chambre AS nb_chambre, 
	centre_region.libelle AS libelle_region, 
	accueil_groupes_jeunes_adultes.id_sejour_services_sportifs AS services, 
	accueil_groupes_jeunes_adultes.id_sejour_centre_adapte AS sports 
	FROM accueil_groupes_jeunes_adultes 
	INNER JOIN centre ON (accueil_groupes_jeunes_adultes.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	WHERE id_accueil_groupes_jeunes_adultes=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$region = mysql_result($result_S,0,"libelle_region");
	$nb_chambre = mysql_result($result_S,0,"nb_chambre");
	$id_services = mysql_result($result_S,0,"services");
	$id_sports = mysql_result($result_S,0,"sports");
	
	$title = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_title_accueil_sportif'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	$sql_S3 = "SELECT libelle 
	FROM trad_sejour_centre_adapte 
	WHERE id__sejour_centre_adapte IN (".$id_sports.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S3 = mysql_query($sql_S3);
	$sports = '';
	$j = 0;
	while($myrow = mysql_fetch_assoc($result_S3))
	{
		if($j > 0)
		{
			$sports.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$sports.= $myrow["libelle"]; 
		}
		
		$j ++;
	}
	
	$presentation = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_description_accueil_sportif'));
	$presentation = str_replace("##VILLE##",$ville_centre,$presentation);
	if(!empty($sports))
	{
		$presentation = str_replace("##SPORTS##",$sports,$presentation);
	}
	else
	{
		$presentation = str_replace("##SPORTS##",'',$presentation);
	}
	$tab[1] = "<meta name=\"description\" content=\"$presentation\"/>";
	
	//Keyword :
	$sql_S4 = "SELECT libelle 
	FROM trad_sejour_services_sportifs 
	WHERE id__sejour_services_sportifs IN (".$id_services.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S4 = mysql_query($sql_S4);
	$services = '';
	$j = 0;
	while($myrow = mysql_fetch_assoc($result_S4))
	{
		if($j > 0)
		{
			$services.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$services.= $myrow["libelle"]; 
		}
		
		$j ++;
	}
	
	$keyword = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_keywords_accueil_sportif'));
	$keyword = str_replace("##REGION##",$region,$keyword);
	$keyword = str_replace("##VILLE##",$ville_centre,$keyword);
	$keyword = str_replace("##NB_CHAMBRES##",$nb_chambre,$keyword);
	if(!empty($services))
	{
		$keyword = str_replace("##SERVICES##",$services,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##SERVICES##",'',$keyword);
	}
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaSejourTouristique($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT sejours_touristiques.id_centre AS id_centre, 
	trad_sejours_touristiques.nom_sejour AS nom_sejour, 
	trad_sejours_touristiques.descriptif AS presentation, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre_region.libelle AS libelle_region 
	FROM sejours_touristiques 
	INNER JOIN centre ON (sejours_touristiques.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	INNER JOIN trad_sejours_touristiques ON (trad_sejours_touristiques.id__sejours_touristiques = sejours_touristiques.id_sejours_touristiques 
	AND trad_sejours_touristiques.id__langue=".$_SESSION['ses_langue'].") 
	WHERE id_sejours_touristiques=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_sejour = mysql_result($result_S,0,"nom_sejour");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$region = mysql_result($result_S,0,"libelle_region");
	$presentation_txt = strip_tags(mysql_result($result_S,0,"presentation"));
	$presentation_txt = str_replace("\"", "'", $presentation_txt);
    
	$title = str_replace("##SEJOUR##",$nom_sejour,get_libLocal('lib_title_sejour_touristique'));
	$title = str_replace("##REGION##",$region,$title);
	$tab[0]= $title;
	
	//Description :
	if(strlen($presentation_txt)>200)
	{
		$presentation_txt = coupe_espace($presentation_txt,200);
	}
	$presentation = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_description_sejour_touristique'));
	$presentation = str_replace("##VILLE##",$ville_centre,$presentation);
	$presentation = str_replace("##REGION##",$region,$presentation);
	$tab[1] = "<meta name=\"description\" content=\"".$presentation.$presentation_txt."\"/>";
	
	//Keyword :
	$keyword = str_replace("##VILLE##",$ville_centre,get_libLocal('lib_keywords_sejour_touristique'));
	$keyword = str_replace("##REGION##",$region,$keyword);
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaStageThematiqueGroupe($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT stages_thematiques_groupes.id_centre AS id_centre, 
	trad_stages_thematiques_groupes.nom_stage AS nom_sejour, 
	trad_stages_thematiques_groupes.descriptif AS presentation, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre_region.libelle AS libelle_region 
	FROM stages_thematiques_groupes 
	INNER JOIN centre ON (stages_thematiques_groupes.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	INNER JOIN trad_stages_thematiques_groupes ON (trad_stages_thematiques_groupes.id__stages_thematiques_groupes = stages_thematiques_groupes.id_stages_thematiques_groupes 
	AND trad_stages_thematiques_groupes.id__langue=".$_SESSION['ses_langue'].") 
	WHERE id_stages_thematiques_groupes=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_sejour = mysql_result($result_S,0,"nom_sejour");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$region = mysql_result($result_S,0,"libelle_region");
	$presentation_txt = strip_tags(mysql_result($result_S,0,"presentation"));
	$presentation_txt = str_replace("\"", "'", $presentation_txt);
    
	$title = str_replace("##SEJOUR##",$nom_sejour,get_libLocal('lib_title_stage_thematique_groupe'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	if(strlen($presentation_txt)>200)
	{
		$presentation_txt = coupe_espace($presentation_txt,200);
	}
	$tab[1] = "<meta name=\"description\" content=\"".$presentation_txt."\"/>";
	
	//Keyword :
	$keyword = $nom_centre.', '.$ville_centre.', '.$region.', '.$nom_sejour;
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaAccueilIndividuel($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT accueil_individuels_familles.id_centre AS id_centre, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre.nb_chambre AS nb_chambre, 
	centre_region.libelle AS libelle_region, 
	centre.id_centre_detention_label AS labels, 
	centre.id_centre_activite AS activites, 
	centre.id_centre_service AS services 
	FROM accueil_individuels_familles 
	INNER JOIN centre ON (accueil_individuels_familles.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	WHERE id_accueil_individuels_familles=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$region = mysql_result($result_S,0,"libelle_region");
	$nb_chambre = mysql_result($result_S,0,"nb_chambre");
	$id_activites = mysql_result($result_S,0,"activites");
	$id_services = mysql_result($result_S,0,"services");
	$id_labels = mysql_result($result_S,0,"labels");
	
	$title = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_title_accueil_individuel'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	$sql_S2 = "SELECT presentation 
	FROM trad_centre 
	WHERE id__centre=".$id_centre." 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S2 = mysql_query($sql_S2);
	$presentation = mysql_result($result_S2,0,"presentation");
    $presentation = str_replace("\"", "'", $presentation);
	if(strlen($presentation)>200)
	{
		$presentation = coupe_espace($presentation,200);
	}
	$tab[1] = "<meta name=\"description\" content=\"$presentation\"/>";
	
	//Keyword :
	$sql_S3 = "SELECT libelle 
	FROM trad_centre_activite 
	WHERE id__centre_activite IN (".$id_activites.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S3 = mysql_query($sql_S3);
	$activites = '';
	$i = 0;
	while($myrow = mysql_fetch_assoc($result_S3))
	{
		if($i > 0)
		{
			$activites.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$activites.= $myrow["libelle"]; 
		}
		
		$i ++;
	}
	
	$sql_S4 = "SELECT libelle 
	FROM trad_centre_service 
	WHERE id__centre_service IN (".$id_services.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S4 = mysql_query($sql_S4);
	$services = '';
	$j = 0;
	while($myrow = mysql_fetch_assoc($result_S4))
	{
		if($j > 0)
		{
			$services.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$services.= $myrow["libelle"]; 
		}
		
		$j ++;
	}
	
	$sql_S5 = "SELECT libelle 
	FROM trad_centre_detention_label 
	WHERE id__centre_detention_label IN (".$id_labels.") 
	AND id__langue=".$_SESSION['ses_langue']." ";
	$result_S5 = mysql_query($sql_S5);
	$labels = '';
	$k = 0;
	while($myrow = mysql_fetch_assoc($result_S5))
	{
		if($k > 0)
		{
			$labels.= ', ';
		}
		
		if(!empty($myrow["libelle"]))
		{	
			$labels.= $myrow["libelle"]; 
		}
		
		$k ++;
	}
	
	$keyword = str_replace("##CENTRE##",$nom_centre,get_libLocal('lib_keywords_accueil_individuel'));
	$keyword = str_replace("##REGION##",$region,$keyword);
	$keyword = str_replace("##VILLE##",$ville_centre,$keyword);
	$keyword = str_replace("##NB_CHAMBRES##",$nb_chambre,$keyword);
	if(!empty($services))
	{
		$keyword = str_replace("##SERVICES##",$services,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##SERVICES##",'',$keyword);
	}
	if(!empty($activites))
	{
		$keyword = str_replace("##ACTIVITES##",$activites,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##ACTIVITES##",'',$keyword);
	}
	if(!empty($labels))
	{
		$keyword = str_replace("##LABELS##",$labels,$keyword);
	}
	else
	{
		$keyword = str_replace(", ##LABELS##",'',$keyword);
	}
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaShortBreak($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT short_breaks.id_centre AS id_centre, 
	trad_short_breaks.nom AS nom_sejour, 
	trad_short_breaks.descriptif AS presentation, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre_region.libelle AS libelle_region 
	FROM short_breaks 
	INNER JOIN centre ON (short_breaks.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	INNER JOIN trad_short_breaks ON (trad_short_breaks.id__short_breaks = short_breaks.id_short_breaks 
	AND trad_short_breaks.id__langue=".$_SESSION['ses_langue'].") 
	WHERE id_short_breaks=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_sejour = mysql_result($result_S,0,"nom_sejour");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$region = mysql_result($result_S,0,"libelle_region");
	$presentation_txt = strip_tags(mysql_result($result_S,0,"presentation"));
    $presentation_txt = str_replace("\"", "'", $presentation_txt);
	
	$title = str_replace("##SEJOUR##",$nom_sejour,get_libLocal('lib_title_short_break'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	if(strlen($presentation_txt)>200)
	{
		$presentation_txt = coupe_espace($presentation_txt,200);
	}
	$tab[1] = "<meta name=\"description\" content=\"".$presentation_txt."\"/>";
	
	//Keyword :
	$keyword = str_replace("##REGION##",$region,get_libLocal('lib_keywords_short_break'));
	$keyword = str_replace("##VILLE##",$ville_centre,$keyword);
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function GetMetaStageThematiqueIndividuel($id_sejour)
{
	//TITLE :
	$sql_S = "SELECT stages_thematiques_individuels.id_centre AS id_centre, 
	trad_stages_thematiques_individuels.nom AS nom_sejour, 
	trad_stages_thematiques_individuels.descriptif AS presentation, 
	centre.libelle AS libelle_centre, 
	centre.ville AS ville_centre, 
	centre_region.libelle AS libelle_region 
	FROM stages_thematiques_individuels 
	INNER JOIN centre ON (stages_thematiques_individuels.id_centre = centre.id_centre) 
	INNER JOIN centre_region ON (centre.id_centre_region = centre_region.id_centre_region) 
	INNER JOIN trad_stages_thematiques_individuels ON (trad_stages_thematiques_individuels.id__stages_thematiques_individuels = stages_thematiques_individuels.id_stages_thematiques_individuels 
	AND trad_stages_thematiques_individuels.id__langue=".$_SESSION['ses_langue'].") 
	WHERE id_stages_thematiques_individuels=".$id_sejour;
	$result_S = mysql_query($sql_S);
	$id_centre = mysql_result($result_S,0,"id_centre");
	$nom_sejour = mysql_result($result_S,0,"nom_sejour");
	$nom_centre = mysql_result($result_S,0,"libelle_centre");
	$ville_centre = mysql_result($result_S,0,"ville_centre");
	$region = mysql_result($result_S,0,"libelle_region");
	$presentation_txt = strip_tags(mysql_result($result_S,0,"presentation"));
    $presentation_txt = str_replace("\"", "'", $presentation_txt);
    
	$title = str_replace("##SEJOUR##",$nom_sejour,get_libLocal('lib_title_short_break'));
	$title = str_replace("##REGION##",$region,$title);
	$title = str_replace("##VILLE##",$ville_centre,$title);
	$tab[0]= $title;
	
	//Description :
	if(strlen($presentation_txt)>200)
	{
		$presentation_txt = coupe_espace($presentation_txt,200);
	}
	$tab[1] = "<meta name=\"description\" content=\"$presentation_txt\"/>";
	
	//Keyword :
	$keyword = $nom_centre.', '.$ville_centre.', '.$region.', '.$nom_sejour;
	$tab[2] = "<meta name=\"keywords\" content=\"$keyword\"/>";
	
	return $tab;
}

function getBaliseXitiSejour($Rub,$id){
    
}
function getBaliseXitiCentre($id){
    $sql = "select xiti from centre where id_centre = ".$id;
    $result = mysql_query($sql);
    return mysql_result($result,0,"xiti");
}
?>