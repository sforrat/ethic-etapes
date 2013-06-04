<?
/**********************************************************************************/
/*	C2IS : 		
/*	Auteur : 	AHE 							  
/*	Date : 		MAI 2010
/*	Version :	1.0							  
/*	Fichier :	resultat_recherche.php						  
/*										  
/*	Description :	Affichage de tout type de resultat de recherche
/**********************************************************************************/

$Rub = $_GET['Rub'];
$params = array();

//trace($_REQUEST);
//trace($_SESSION);




if ($Rub == _NAV_FICHE_CENTRE)
{	
	if (!isset($_REQUEST['id_type_sejour']) || $_REQUEST['id_type_sejour'] == '')
		return;
	else 
		$Rub = $_REQUEST['id_type_sejour'];	
		
	$params['id_centre'] = $_REQUEST['id_centre'];	
	// [RPL] 18/10/2010 - pas de limitation d'affichage pour les recherches sur fiches centre
	$params['disableLimit'] = 1;
}

//------------------
//POUR LES -18 ANS--
//------------------
if ($Rub == _NAV_CLASSE_DECOUVERTE)
{
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	//**Prise en compte des filtres
	if (isset($_REQUEST['region_filter']) && $_REQUEST['region_filter'] != "")
		$params['id_centre_region'] = $_REQUEST['region_filter'];
		
	if (isset($_REQUEST['theme_filter']) && $_REQUEST['theme_filter'] != "")
		$params['id_sejour_theme'] = $_REQUEST['theme_filter'];	
		
		
	$nbNiveauScolaire = getListeSejourInfos('niveau_scolaire', $listeNiveauScolaire);
	for ($i = 0 ; $i < $nbNiveauScolaire; $i++)
	{
		if (isset($_REQUEST['niveau_scolaire_'.$listeNiveauScolaire[$i]["id"].'_filter']))	
			$params['id_sejour_niveau_scolaire'][] = $listeNiveauScolaire[$i]["id"];
	}
			
	//**Resultats	
	$nbRes = getListeSejour($Rub, $listeRes, $params);
}

elseif ($Rub == _NAV_ACCUEIL_GROUPES_SCOLAIRES)
{	
	$this->assign('txt_resultat',get_libLocal('lib_destination_trouvees'));
	
	//**Prise en compte des filtres
	if (isset($_REQUEST['region_filter']) && $_REQUEST['region_filter'] != "")
		$params['id_centre_region'] = $_REQUEST['region_filter'];
		
	$nbEnv = getListeCentreEnvironnement($listeEnvironnement);
	for ($i = 0 ; $i <= $nbEnv ; $i++)
	{	
		if (isset($_REQUEST['env_'.$listeEnvironnement[$i]["id"].'_filter']))	
			$params['id_centre_environnement'][] = $listeEnvironnement[$i]["id"];
	}
	
	//**Resultats	
	$nbRes = getListeSejour($Rub, $listeRes, $params);
}

elseif ($Rub == _NAV_CVL)
{
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	
	if ($_SESSION['ses_langue'] == _ID_FR)
	//if ($_SESSION['ses_langue'] == _ID_EN)
	{
		//**Prise en compte des filtres
		if (isset($_REQUEST['theme_filter']) && $_REQUEST['theme_filter'] != "")
			$params['id_sejour_theme'] = $_REQUEST['theme_filter'];	
			
		$nbAgeEnfant = getListeSejourInfos('tranche_age', $listeAgeEnfant);
		for ($i = 0 ; $i < $nbAgeEnfant; $i++)
		{
			if (isset($_REQUEST['tranche_age_'.$listeAgeEnfant[$i]["id"].'_filter']))	
				$params['id_sejour_tranche_age'][] = $listeAgeEnfant[$i]["id"];
		}		
			
		//**Resultats		
		$nbRes = getListeSejour($Rub, $listeRes, $params);
	}
	else 
	{
	//echo '<!--'.$_SERVER['REMOTE_ADDR'].'-->';
		$nbRes = getListeOrganisateurCVL($listeRes);
		
		
		if($_SERVER['REMOTE_ADDR'] == '213.162.49.33'){
			//trace($listeRes);
		}
	}
}	
	
//-------------------
//POUR VOS REUNIONS--
//-------------------
elseif ($Rub == _NAV_ACCEUIL_REUNIONS)
{
	$this->assign('txt_resultat',get_libLocal('lib_destination_trouvees'));
	
	if (isset($_REQUEST['region_filter']) && $_REQUEST['region_filter'] != "")
		$params['id_centre_region'] = $_REQUEST['region_filter'];
		
	if (isset($_REQUEST['capacite_reu_filter']) && $_REQUEST['capacite_reu_filter'] != "")
		$params['capacite_reu'] = $_REQUEST['capacite_reu_filter'];		
				
	$nbRes = getListeSejour($Rub, $listeRes, $params);
}

elseif ($Rub == _NAV_INCENTIVE || $Rub == _NAV_SEMINAIRES)
{
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	
	if ($Rub == _NAV_SEMINAIRES)
		$params['id_sejour_theme_seminaire'] = array(_CONST_SEJOUR_SEMINAIRE_THEME_VERT);	
	
	//**Prise en compte des filtres
	$nbEnv = getListeCentreEnvironnement($listeEnvironnement);
	for ($i = 0 ; $i <= $nbEnv ; $i++)
	{	
		if (isset($_REQUEST['env_'.$listeEnvironnement[$i]["id"].'_filter']))	
			$params['id_centre_environnement'][] = $listeEnvironnement[$i]["id"];
	}
	
	$nbThemeSeminaire = getListeSejourInfos('theme_seminaire', $listeThemeSeminaire);	
	for ($i = 0 ; $i <= $nbThemeSeminaire ; $i++)
	{	
		if (isset($_REQUEST['theme_seminaire_'.$listeThemeSeminaire[$i]["id"].'_filter']))	
			$params['id_sejour_theme_seminaire'][] = $listeThemeSeminaire[$i]["id"];
	}

	
	$nbRes = getListeSejour($Rub, $listeRes, $params);	
}


//--------------------------
//DECOUVERTES TOURISTIQUES--
//--------------------------
elseif ($Rub == _NAV_ACCUEIL_GROUPE)
{
	$this->assign('txt_resultat',get_libLocal('lib_destination_trouvees'));
	
	//**Prise en compte des filtres
	$nbEnv = getListeCentreEnvironnement($listeEnvironnement);
	for ($i = 0 ; $i <= $nbEnv ; $i++)
	{	
		if (isset($_REQUEST['env_'.$listeEnvironnement[$i]["id"].'_filter']))	
			$params['id_centre_environnement'][] = $listeEnvironnement[$i]["id"];
	}	
	
	if (isset($_REQUEST['capacite_lits_filter']) && $_REQUEST['capacite_lits_filter'] != "")
		$params['capacite_lits'] = $_REQUEST['capacite_lits_filter'];			
	
	$nbRes = getListeSejour($Rub, $listeRes, $params);
	//echo "LISTE OK / nb=$nbRes";
}

elseif ($Rub == _NAV_ACCUEIL_SPORTIF)
{
	$this->assign('txt_resultat',get_libLocal('lib_destination_trouvees'));
	
	//**Prise en compte des filtres
	$nbEnv = getListeCentreEnvironnement($listeEnvironnement);
	for ($i = 0 ; $i <= $nbEnv ; $i++)
	{	
		if (isset($_REQUEST['env_'.$listeEnvironnement[$i]["id"].'_filter']))	
			$params['id_centre_environnement'][] = $listeEnvironnement[$i]["id"];
	}		
	
	if (isset($_REQUEST['activite_filter']) && $_REQUEST['activite_filter'] != "")
		$params['id_centre_activite'] = $_REQUEST['activite_filter'];			
	
	$params['accueil_sportif'] = true;
	$nbRes = getListeSejourAccueilGroupe($listeRes, $params);		
}

elseif ($Rub == _NAV_SEJOURS_TOURISTIQUES_GROUPE)
{	
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	
	if (isset($_REQUEST['region_filter']) && $_REQUEST['region_filter'] != "")
		$params['id_centre_region'] = $_REQUEST['region_filter'];

	$nbPeriode = getListeSejourInfos('periode_disponibilite', $listePeriode);	
	for ($i = 0 ; $i <= $nbPeriode ; $i++)
	{	
		if (isset($_REQUEST['periode_disponibilite_'.$listePeriode[$i]["id"].'_filter']))	
			$params['id_sejour_periode_disponibilite'][] = $listePeriode[$i]["id"];
	}		
	
	$nbDuree = getListeSejourInfos('duree', $listeDuree);
	for ($i = 0 ; $i <= $nbDuree ; $i++)
	{	
		if (isset($_REQUEST['duree_'.$listeDuree[$i]["id"].'_filter']))	
			$params['id_sejour_duree'][] = $listeDuree[$i]["id"];
	}	
			
	$nbRes = getListeSejour($Rub, $listeRes, $params);
}

elseif ($Rub == _NAV_STAGES_THEMATIQUES_GROUPE)	
{
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	
	if (isset($_REQUEST['region_filter']) && $_REQUEST['region_filter'] != "")
		$params['id_centre_region'] = $_REQUEST['region_filter'];
	
	if (isset($_REQUEST['stage_theme_filter']) && $_REQUEST['stage_theme_filter'] != "")
		$params['id_sejour_stage_theme'] = $_REQUEST['stage_theme_filter'];	
	
	$nbRes = getListeSejour($Rub, $listeRes, $params);
}

elseif ($Rub == _NAV_ACCUEIL_INDIVIDUEL)	
{
	$this->assign('txt_resultat',get_libLocal('lib_destination_trouvees'));
	
	$nbEnv = getListeCentreEnvironnement($listeEnvironnement);
	for ($i = 0 ; $i <= $nbEnv ; $i++)
	{	
		if (isset($_REQUEST['env_'.$listeEnvironnement[$i]["id"].'_filter']))	
			$params['id_centre_environnement'][] = $listeEnvironnement[$i]["id"];
	}	
		
	$nbRes = getListeAcceuilIndividuels($listeRes, $params);	
}

elseif ($Rub == _NAV_SHORT_BREAK)	
{
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	
	if (isset($_REQUEST['region_filter']) && $_REQUEST['region_filter'] != "")
		$params['id_centre_region'] = $_REQUEST['region_filter'];
		
	$nbEnv = getListeCentreEnvironnement($listeEnvironnement);
	for ($i = 0 ; $i <= $nbEnv ; $i++)
	{	
		if (isset($_REQUEST['env_'.$listeEnvironnement[$i]["id"].'_filter']))	
			$params['id_centre_environnement'][] = $listeEnvironnement[$i]["id"];
	}	
	
	if (isset($_REQUEST['short_break_theme_filter']) && $_REQUEST['short_break_theme_filter'] != "")
		$params['id_sejour_short_break_theme'] = $_REQUEST['short_break_theme_filter'];	
	
	
	$nbRes = getListeSejour($Rub, $listeRes, $params);			
}

elseif ($Rub == _NAV_STAGES_THEMATIQUES_INDIVIDUEL)	
{
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	
	if (isset($_REQUEST['region_filter']) && $_REQUEST['region_filter'] != "")
		$params['id_centre_region'] = $_REQUEST['region_filter'];

	if (isset($_REQUEST['stage_theme_filter']) && $_REQUEST['stage_theme_filter'] != "")
		$params['id_sejour_stage_theme'] = $_REQUEST['stage_theme_filter'];			
		
	$nbPeriode = getListeSejourInfos('periode_disponibilite', $listePeriode);	
	for ($i = 0 ; $i <= $nbPeriode ; $i++)
	{	
		if (isset($_REQUEST['periode_disponibilite_'.$listePeriode[$i]["id"].'_filter']))	
			$params['id_sejour_periode_disponibilite'][] = $listePeriode[$i]["id"];
	}				
		
	$nbRes = getListeSejour($Rub, $listeRes, $params);		
}

//------------------
//LISTE DE SEJOURS--
//------------------
elseif ($Rub == _NAV_SEJOUR_MOINS_18_ANS)	
{
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	
	$listeCD = array();
	$listeAS = array();
	$listeCVL = array();
	
	$print_all = false;
	if (!isset($_REQUEST['type_sejour_'._NAV_CLASSE_DECOUVERTE.'_filter']) 
	&& !isset($_REQUEST['type_sejour_'._NAV_ACCUEIL_GROUPES_SCOLAIRES.'_filter']) 
	&& !isset($_REQUEST['type_sejour_'._NAV_CVL.'_filter']))
		$print_all = true;

	$nbMax = 0;
	$nbTotal = 0;
	if (isset($_REQUEST['type_sejour_'._NAV_CLASSE_DECOUVERTE.'_filter']) || $print_all)
	{
		$nbRes = getListeSejourClasseDecouverte($listeCD, array("disableLimit" => true));
		$nbTotal += $nbRes;		
		$nbMax = $nbRes;
	}
	if (isset($_REQUEST['type_sejour_'._NAV_ACCUEIL_GROUPES_SCOLAIRES.'_filter']) || $print_all)
	{
		$nbRes = getListeSejourAccueilScolaire($listeAS, array("disableLimit" => true));	
		$nbTotal += $nbRes;
		if ($nbRes > $nbMax)
			$nbMax = $nbRes;
	}
	if (isset($_REQUEST['type_sejour_'._NAV_CVL.'_filter']) || $print_all)		
	{
		$nbRes = getListeSejourCVL($listeCVL, array("disableLimit" => true));	
		$nbTotal += $nbRes;
		if ($nbRes > $nbMax)
			$nbMax = $nbRes;		
	}
		
	$liste = array();
	for ($i = 0; $i < $nbMax ; $i++)
	{
		if (isset ($listeCD[$i]))
			$liste[] = $listeCD[$i];
			
		if (isset ($listeAS[$i]))
			$liste[] = $listeAS[$i];

		if (isset ($listeCVL[$i]))
			$liste[] = $listeCVL[$i];
	}
	
	
	$page = (isset($_REQUEST['P']) && $_REQUEST['P'] > 1? $_REQUEST['P']  : 1);
	$start = ($page < 1) ? 0 : (($page - 1)* _NB_ENR_PAGE_RES);
	$end = $page * _NB_ENR_PAGE_RES;	
	
	for ($i = $start ; $i < $end ; $i++)
	{
		if (isset($liste[$i]))
			$listeRes[] = $liste[$i];
	}
	
	$nbRes = $nbTotal;
}

elseif ($Rub == _NAV_SEJOUR_REUNION)	
{
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	
	$listeAC = array();
	$listeSem = array();
	
	$print_all = false;
	if (!isset($_REQUEST['type_sejour_'._NAV_ACCEUIL_REUNIONS.'_filter']) 
	&& !isset($_REQUEST['type_sejour_'._NAV_INCENTIVE.'_filter'])
	&& !isset($_REQUEST['type_sejour_'._NAV_SEMINAIRES.'_filter']))
		$print_all = true;		
		
	$nbTotal = 0;	
	if (isset($_REQUEST['type_sejour_'._NAV_ACCEUIL_REUNIONS.'_filter']) || $print_all)
	{
		$nbRes = getListeSejourAcceuilReunion($listeAC, array("disableLimit" => true));
		$nbTotal += $nbRes;		
		$nbMax = $nbRes;
	}	
	if (isset($_REQUEST['type_sejour_'._NAV_INCENTIVE.'_filter']) || $print_all)	
	{
		$nbRes = getListeSejourSeminaires($listeSem, array("disableLimit" => true));
		$nbTotal += $nbRes;
		if ($nbRes > $nbMax)
			$nbMax = $nbRes;
	}
	else if (isset($_REQUEST['type_sejour_'._NAV_SEMINAIRES.'_filter']))	
	{
		$params['id_sejour_theme_seminaire'][] = _CONST_SEJOUR_SEMINAIRE_THEME_VERT;
		$params['disableLimit'] = true;
		$nbRes = getListeSejourSeminaires($listeSem, $params);	
		$nbTotal += $nbRes;
		if ($nbRes > $nbMax)
			$nbMax = $nbRes;		
	}
	
	$liste = array();
	for ($i = 0; $i < $nbMax ; $i++)
	{
		if (isset ($listeAC[$i]))
			$liste[] = $listeAC[$i];
			
		if (isset ($listeSem[$i]))
			$liste[] = $listeSem[$i];
	}
	
	
	$page = (isset($_REQUEST['P']) && $_REQUEST['P'] > 1? $_REQUEST['P']  : 1);
	$start = ($page < 1) ? 0 : (($page - 1)* _NB_ENR_PAGE_RES);
	$end = $page * _NB_ENR_PAGE_RES;	
	
	for ($i = $start ; $i < $end ; $i++)
	{
		if (isset($liste[$i]))
			$listeRes[] = $liste[$i];
	}
	
	//$listeRes = array_merge($listeAC, $listeSem);
	//shuffle($listeRes);
	$nbRes = $nbTotal;
}

elseif ($Rub == _NAV_SEJOUR_DECOUVERTE)	
{
	$this -> assign ('txt_resultat', get_libLocal('lib_lieux_trouves'));
	
	$listeAG = array();
	$listeTourG = array();	
	$listeThemG = array();	
	$listeAI = array();	
	$listeSB = array();	
	$listeThemI = array();	
	
	
	$print_all = false;
	if (!isset($_REQUEST['type_sejour_'._NAV_ACCUEIL_GROUPE.'_filter']) 
	&& !isset($_REQUEST['type_sejour_'._NAV_SEJOURS_TOURISTIQUES_GROUPE.'_filter'])
	&& !isset($_REQUEST['type_sejour_'._NAV_STAGES_THEMATIQUES_GROUPE.'_filter'])
	&& !isset($_REQUEST['type_sejour_'._NAV_ACCUEIL_INDIVIDUEL.'_filter'])
	&& !isset($_REQUEST['type_sejour_'._NAV_SHORT_BREAK.'_filter'])
	&& !isset($_REQUEST['type_sejour_'._NAV_STAGES_THEMATIQUES_INDIVIDUEL.'_filter']))
		$print_all = true;			
	
	$nbTotal = 0;
	if (isset($_REQUEST['type_sejour_'._NAV_ACCUEIL_GROUPE.'_filter']) || $print_all)
	{
		$nbRes = getListeSejourAccueilGroupe($listeAG, array("disableLimit" => true));
		$nbTotal += $nbRes;		
		$nbMax = $nbRes;		
	}
	if (isset($_REQUEST['type_sejour_'._NAV_SEJOURS_TOURISTIQUES_GROUPE.'_filter']) || $print_all)		
	{
		$nbRes = getListeSejourTouristiquesGroupe($listeTourG, array("disableLimit" => true));	
		$nbTotal += $nbRes;
		if ($nbRes > $nbMax)
			$nbMax = $nbRes;		
	}	
	if (isset($_REQUEST['type_sejour_'._NAV_STAGES_THEMATIQUES_GROUPE.'_filter']) || $print_all)
	{	
		$nbRes = getListeStagesThematiquesGroupe($listeThemG, array("disableLimit" => true));	
		$nbTotal += $nbRes;
		if ($nbRes > $nbMax)
			$nbMax = $nbRes;		
	}
	if (isset($_REQUEST['type_sejour_'._NAV_ACCUEIL_INDIVIDUEL.'_filter']) || $print_all)	
	{
		$nbRes = getListeAcceuilIndividuels($listeAI, array("disableLimit" => true));	
		$nbTotal += $nbRes;
		if ($nbRes > $nbMax)
			$nbMax = $nbRes;		
	}
	if (isset($_REQUEST['type_sejour_'._NAV_SHORT_BREAK.'_filter']) || $print_all)
	{	
		$nbRes = getListeShortBreak($listeSB, array("disableLimit" => true));	
		$nbTotal += $nbRes;
		if ($nbRes > $nbMax)
			$nbMax = $nbRes;		
	}
	if (isset($_REQUEST['type_sejour_'._NAV_STAGES_THEMATIQUES_INDIVIDUEL.'_filter']) || $print_all)
	{	
		$nbRes = getListeStagesThematiquesIndividuels($listeThemI, array("disableLimit" => true));	
		$nbTotal += $nbRes;
		if ($nbRes > $nbMax)
			$nbMax = $nbRes;		
	}
	
	$liste = array();
	for ($i = 0; $i < $nbMax ; $i++)
	{
		if (isset ($listeAG[$i]))
			$liste[] = $listeAG[$i];
			
		if (isset ($listeTourG[$i]))
			$liste[] = $listeTourG[$i];		
			
		if (isset ($listeThemG[$i]))
			$liste[] = $listeThemG[$i];

		if (isset ($listeAI[$i]))
			$liste[] = $listeAI[$i];

		if (isset ($listeSB[$i]))
			$liste[] = $listeSB[$i];

		if (isset ($listeThemI[$i]))
			$liste[] = $listeThemI[$i];	
					
	}
	
	$page = (isset($_REQUEST['P']) && $_REQUEST['P'] > 1? $_REQUEST['P']  : 1);
	$start = ($page < 1) ? 0 : (($page - 1)* _NB_ENR_PAGE_RES);
	$end = $page * _NB_ENR_PAGE_RES;	
	
	for ($i = $start ; $i < $end ; $i++)
	{
		if (isset($liste[$i]))
			$listeRes[] = $liste[$i];
	}	
	
	//$listeRes = array_merge($listeAG, $listeTourG, $listeThemG, $listeAI, $listeSB, $listeThemI);
	//shuffle($listeRes);
	$nbRes = $nbTotal;
}

elseif ($Rub == _NAV_DESTINATIONS)	
{
	$this->assign('txt_resultat',get_libLocal('lib_destination_trouvees'));
	
	if (isset($_REQUEST['amb_filter']) && $_REQUEST['amb_filter'] != '')	
		$params['id_centre_ambiance'][] = $_REQUEST['amb_filter'];
	
	if ($_REQUEST['individuel'] == 'on')	
		$params['individuel'] = true;
	
	if ($_REQUEST['groupe'] == 'on')	
		$params['groupe'] = true;
	
	$nbRes = getListeCentre($listeRes, $params);
//	trace($listeRes);
	
}

elseif (in_array($Rub, $GLOBALS["_NAV_DESTINATIONS"]))
{
	$this->assign('txt_resultat',get_libLocal('lib_destination_trouvees'));
	$params = array();
	switch ($Rub)
	{
		case _NAV_CENTRES_MER :
			$params['id_centre_environnement'][] = _CONST_CENTRE_ENV_MER;
			break;
		case _NAV_CENTRES_MONTAGNE:
			$params['id_centre_environnement'][] = _CONST_CENTRE_ENV_MONTAGNE;
			break;
		case _NAV_CENTRES_CAMPAGNE:
			$params['id_centre_environnement'][] = _CONST_CENTRE_ENV_CAMPAGNE;
			break;			
		case _NAV_CENTRES_VILLE:
			$params['id_centre_environnement'][] = _CONST_CENTRE_ENV_VILLE;
			break;
		case _NAV_CENTRES_NEW:
			$params['moins_6_mois'] = true;
			break;			
	}
	
	if (isset($_REQUEST['capacite_lits_filter']) && $_REQUEST['capacite_lits_filter'] != '')	
		$params['capacite_lits'] = $_REQUEST['capacite_lits_filter'];		
	
	$nbEnvMontagne = getListeCentreInfos('environnement_montagne', $listeEnvMontagne);	
	for ($i = 0 ; $i <= $nbEnvMontagne ; $i++)
	{	
		if (isset($_REQUEST['environnement_montagne_'.$listeEnvMontagne[$i]["id"].'_filter']))	
			$params['id_centre_environnement_montagne'][] = $listeEnvMontagne[$i]["id"];
	}			
		
	
	$nbRes = getListeCentre($listeRes, $params);
}
	
//Pagination
// [RPL] 18/10/2010 - pas de pagination pour les r�sultats de recherche d'offres ---------------------------------------
if( $_GET['Rub'] == _NAV_FICHE_CENTRE )
	$nbPages = 1;
else // [/RPL] ---------------------------------------------------------------------------------------------------------
	$nbPages = ceil($nbRes / _NB_ENR_PAGE_RES);
$currentPage = (isset($_REQUEST['P']) ? $_REQUEST['P'] : 1);

$startPage = $currentPage - ceil(_NB_PAGE_TOT_RES/2) + 1;
$endPage = $currentPage + ceil(_NB_PAGE_TOT_RES/2) ;

if ($startPage <= 0)
	$startPage = 1;	

if ($endPage > $nbPages)
	$endPage = $nbPages +1;


// --------------------------------------------------------------
// --- URL PREVIOUS
if(isset($_REQUEST['P'])){
	if(($_REQUEST['P'] > 1)){
		$previousPage = $_REQUEST['P']-1;
	}else{
		$previousPage = 1;
	}
}else{
	$previousPage = 1;
}

if($previousPage == 1 || !$previousPage){
	$url_previous = get_url_nav($_GET['Rub']);
}else{
	$params_page = array();
	$params_page[0]["id"] = $previousPage;
	$url_previous = get_url_nav($_GET['Rub'],$params_page);
}
$this -> assign ('urlPreviousPage', $url_previous);
// --------------------------------------------------------------
// --- URL NEXT
if(isset($_REQUEST['P'])){
	$val  = $_REQUEST['P']+1;
	if($val >= $nbPages){
		
		$next = $nbPages;
	}else{
		
		$next = $val;
	}
}else{
	
	$next  = $nbPages;
}

if($next == 1  || !$next){
	$url_next = get_url_nav($_GET['Rub']);
}else{
	$params_page = array();
	$params_page[0]["id"] = $next;
	$url_next = get_url_nav($_GET['Rub'],$params_page);
}
$this -> assign ('urlNextPage', $url_next);
// --------------------------------------------------------------
// --- Derniere page
if($nbPages>1){
	$params_page = array();
	$params_page[0]["id"] = $nbPages;
	$this -> assign ('url_last_page', get_url_nav($_GET['Rub'],$params_page));
}else{
	$this -> assign ('url_last_page', get_url_nav($_GET['Rub']));
}
// --------------------------------------------------------------

$this -> assign ('currentPage', $currentPage);

$this -> assign ('urlPagination', get_url_nav($_GET['Rub']));
$this -> assign ('nbPages', $nbPages);
$this -> assign ("nbTotal", $nb);


// ------ FFR
unset($tab);
for($i = $startPage; $i<$endPage;$i++){
	$params_page = array();
	$params_page[0]["id_name"]="P";
	$params_page[0]["id"]=$i;
	
	if($i == 1){
		$tab["url"] = get_url_nav($_GET['Rub']);
	}else{
		$tab["url"] = get_url_nav($_GET['Rub'],$params_page);
	}
	
	$tab["currentPage"] = $i;
	
	$TabPagination[] = $tab;
	unset($tab);
}


$this -> assign ('TabPagination', $TabPagination);
$this -> assign ('$page', $_GET["P"]);

//Pas de filtres si moins de 10 resultats ou si CVL en langue etrangere (Organisateurs CVL)
//if ($nbRes < _NB_MIN_RES_FOR_FILTER || ($Rub == _NAV_CVL && $_SESSION['ses_langue'] != _ID_FR))	
// On veut conserver les criteres de recherche en permanence pour pouvoir effectuer rapidement une nouvelle recherche
if ( $Rub == _NAV_CVL && $_SESSION['ses_langue'] != _ID_FR )
{
	$this -> assign ('affichFilter', false);	
}
else
{
	$this -> assign ('affichFilter', true);

	if (in_array($Rub, $GLOBALS["_NAV_SEJOUR"]))
		$this -> assign ('affichFilterSejour', true);
	elseif (in_array($Rub, $GLOBALS["_NAV_DESTINATIONS"]))
		$this -> assign ('affichFilterCentre', true);

}

//On affiche	
$this -> assign ('nbRes', $nbRes);
$this -> assign ('listeRes', $listeRes);


$this->display('blocs/resultat_recherche.tpl');

?>