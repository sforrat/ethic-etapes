<?
global $db;


$Rub = $_GET['Rub'];
$params = array();
$action = get_url_nav($Rub);
if ($Rub == _NAV_FICHE_CENTRE)
{	
	if (!isset($_REQUEST['id_type_sejour']) || $_REQUEST['id_type_sejour'] == '')
		return;
	else 
		$Rub = $_REQUEST['id_type_sejour'];	
		
	$paramsUrlAction[] = array ('id_name' => 'id_type_sejour', 'id' => $Rub);		
	$action	= get_url_nav_centre($_REQUEST['Rub'],$_REQUEST['id_centre'],$paramsUrlAction);
	//$params['id_centre'] = $_REQUEST['id_centre'];	
}

if ($Rub == _NAV_CLASSE_DECOUVERTE || 
	$Rub == _NAV_ACCUEIL_GROUPES_SCOLAIRES ||
	$Rub == _NAV_ACCEUIL_REUNIONS ||
	$Rub == _NAV_SEJOURS_TOURISTIQUES_GROUPE ||
	$Rub == _NAV_STAGES_THEMATIQUES_GROUPE ||
	$Rub == _NAV_SHORT_BREAK ||
	$Rub == _NAV_STAGES_THEMATIQUES_INDIVIDUEL) {
		
	//**LISTE DES REGIONS
	$nbRegion = getListeRegions($listeRegion);
	$this -> assign('listeRegion', $listeRegion);
	
	$this -> assign ('currRegion', $_REQUEST['region_filter']);
	
}


if ($Rub == _NAV_SEJOURS_TOURISTIQUES_GROUPE ||
	$Rub == _NAV_STAGES_THEMATIQUES_INDIVIDUEL) {
		
	//**LISTE DES PERIODES (printemps- été - automne - hiver)
	$nbPeriode = getListeSejourInfos('periode_disponibilite', $listePeriode);
	$this -> assign ('listePeriode', $listePeriode);
}


if ($Rub == _NAV_SEJOURS_TOURISTIQUES_GROUPE ) {
	
	//**LISTE DES DUREES ( week-end - semaine - plus d'une semaine)
	$nbDuree = getListeSejourInfos('duree', $listeDuree);
	$this -> assign ('listeDuree', $listeDuree);
}


if ($Rub == _NAV_CLASSE_DECOUVERTE) {
	
	//**LISTE NIVEAU SCOLAIRE ( maternelle, CP/CE ...)
	$nbNiveauScolaire = getListeSejourInfos('niveau_scolaire', $listeNiveauScolaire);
	$this -> assign ('listeNiveauScolaire', $listeNiveauScolaire);
}


if ($Rub == _NAV_CLASSE_DECOUVERTE ||
	$Rub == _NAV_CVL) {
		
	//**LISTE THEME ( expressions - patrimoine et terroir ...)
	$nbTheme = getListeSejourInfos('theme', $listeTheme);
	$this -> assign ('listeTheme', $listeTheme);
}

if ($Rub == _NAV_ACCUEIL_GROUPES_SCOLAIRES || 
	$Rub == _NAV_SEMINAIRES ||
	$Rub == _NAV_INCENTIVE ||
	$Rub == _NAV_ACCUEIL_GROUPE ||
	$Rub == _NAV_ACCUEIL_SPORTIF ||
	$Rub == _NAV_ACCUEIL_INDIVIDUEL ||
	$Rub == _NAV_SHORT_BREAK) {

	//**LISTE ENVIRONNEMENT ( mer - montagne - campagne - ville )
	$nbEnvrionnement = getListeCentreEnvironnement($listeEnvironnement);
	$this -> assign ('listeEnvironnement',$listeEnvironnement);
}

if ($Rub == _NAV_CVL) {
	
	//**LISTE AGE ENFANT ( 4/6 ans - 7/9 ans ... )
	$nbAgeEnfant = getListeSejourInfos('tranche_age', $listeAgeEnfant);
	$this -> assign ('listeAgeEnfant', $listeAgeEnfant);
}

if ($Rub == _NAV_ACCEUIL_REUNIONS) {
	
	//**LISTE DES CAPACITE D'ACCUEIL EN REUNION
	$nbCapacite = getListeCapaciteAccueilReunion($listeCapaciteReu);
	$this -> assign ('listeCapaciteReu', $listeCapaciteReu);
}

if ($Rub == _NAV_INCENTIVE ||
	$Rub == _NAV_SEMINAIRES) {
		
	//**LISTE THEMATIQUE DU SEMINAIRE
	$nbThemeSeminaire = getListeSejourInfos('theme_seminaire', $listeThemeSeminaire);
	$this -> assign ('listeThemeSeminaire', $listeThemeSeminaire);
}

if ($Rub == _NAV_ACCUEIL_GROUPE) {
	
	//**LISTE DES CAPACITES D'ACCUEIL (mois de 100 lits ...)
	$nbCapaciteLits = getListeCapaciteLits($listeCapaciteLits);
	$this -> assign ('listeCapaciteLits', $listeCapaciteLits);
	
	$this -> assign ('affichCapacite', true);	
}

if ($Rub == _NAV_ACCUEIL_SPORTIF) {
	
	//**LISTE DISCIPLINE SPORTIVE (athlétisme, basket ...)
	$nbDiscipline = getListeCentreInfos('activite', $listeDiscipline);
	$this -> assign ('listeDiscipline', $listeDiscipline);
	
	$this -> assign ('affichDiscipline', true);	
}

if ($Rub == _NAV_STAGES_THEMATIQUES_GROUPE ||
	$Rub == _NAV_STAGES_THEMATIQUES_INDIVIDUEL) {

	//**LISTE THEMATIQUE DE STAGE
	$nbThemeStage = getListeSejourInfos('stage_theme', $listeThemeStage);
	$this -> assign ('listeThemeStage', $listeThemeStage);
}

if ($Rub == _NAV_SHORT_BREAK) {

	//**LISTE THEME DE SHORT BREAK
	$nbThemeShortBreak = getListeSejourInfos('short_break_theme', $listeThemeShortBreak);
	$this -> assign ('listeThemeShortBreak', $listeThemeShortBreak);
}

	switch ($Rub)
	{
		case _NAV_SEJOUR_MOINS_18_ANS:
			$tpl = "sejour";
			
			foreach ($GLOBALS["_NAV_SEJOUR_MOINS_18_ANS"] as $rub)
			{
				if ($_SESSION['ses_langue'] != _ID_FR)
				{
					if (!in_array($rub, $GLOBALS["_NAV_SEJOUR_V_ETRANGERE"]))
						continue;
				}
				
				$listeTypeSejour[] = array( "id" => $rub,
											"libelle" => get_trad_nav($rub),
											"current" => (isset($_REQUEST['type_sejour_'.$rub.'_filter']) ? 'checked="checked"' : ''));
			}
			$this -> assign ('listeTypeSejour', $listeTypeSejour);
			break;
			
		case _NAV_SEJOUR_REUNION:
			$tpl = "sejour";
			
			foreach ($GLOBALS["_NAV_SEJOUR_REUNION"] as $rub)
			{
				if ($_SESSION['ses_langue'] != _ID_FR)
				{				
					if (!in_array($rub, $GLOBALS["_NAV_SEJOUR_V_ETRANGERE"]))
						continue;
				}
									
				$listeTypeSejour[] = array( "id" => $rub,
											"libelle" => get_trad_nav($rub),
											"current" => (isset($_REQUEST['type_sejour_'.$rub.'_filter']) ? 'checked="checked"' : ''));
			}
			$this -> assign ('listeTypeSejour', $listeTypeSejour);
								
			break;			
			
		case _NAV_SEJOUR_DECOUVERTE:
			$tpl = "sejour";
			
			foreach ($GLOBALS["_NAV_SEJOUR_DECOUVERTE"] as $rub)
			{
				if ($_SESSION['ses_langue'] != _ID_FR)
				{				
					if (!in_array($rub, $GLOBALS["_NAV_SEJOUR_V_ETRANGERE"]))
						continue;
				}
									
				$listeTypeSejour[] = array( "id" => $rub,
											"libelle" => get_trad_nav($rub),
											"current" => (isset($_REQUEST['type_sejour_'.$rub.'_filter']) ? 'checked="checked"' : ''));
			}
			$this -> assign ('listeTypeSejour', $listeTypeSejour);

					
			break;				
			
		default :
			$tpl = $GLOBALS["_NAV_SEJOUR_TABLE"][$Rub];
			break;
	}
	

	$this -> assign ('action', $action);
	$this -> display("blocs/moteur_recherche_sejour_".$tpl.".tpl");
?>