<?
global $db;

	$arrayCapaciteFilter = array (_NAV_CENTRES_MER, _NAV_CENTRES_CAMPAGNE, _NAV_CENTRES_VILLE);

	if (in_array($_REQUEST['Rub'], $arrayCapaciteFilter))
	{
		//**LISTE DES CAPACITES D'ACCUEIL (mois de 100 lits ...)
		$nbCapaciteLits = getListeCapaciteLits($listeCapaciteLits);
		$this -> assign ('listeCapaciteLits', $listeCapaciteLits);
		
		$this -> assign ('affichCapacite', true);	
	}
	elseif ($_REQUEST['Rub'] == _NAV_CENTRES_MONTAGNE)
	{
		//**Liste Massifs
		$nbEnvMontagne = getListeCentreInfos('environnement_montagne',$listeEnvMontagne);		
		$this -> assign ('listeEnvMontagne', $listeEnvMontagne);
		
		$this -> assign ('affichEnvMontagne', true);	
	}
	elseif ($_REQUEST['Rub'] == _NAV_DESTINATIONS)
	{
		if (isset($_REQUEST['individuel']))
			$this -> assign ('is_individuel_filter', true);
		
		if (isset($_REQUEST['groupe']))
			$this -> assign ('is_groupe_filter', true);	
		
		getListeCentreEnvironnement($listeCEnv);
		$this -> assign ('listeCEnv', $listeCEnv);
		
		getListeCentreAmbiance($liste);
		$this -> assign ('listeAmbiance', $liste);		
		
		
		$this -> assign ('lib_venez_plutot', ucfirst(strtolower(get_libLocal('lib_venez_plutot_maj'))));
		$this -> assign ('lib_recherche_plutot', ucfirst(strtolower(get_libLocal('lib_recherche_plutot_maj'))));
		
		$this -> assign ('affichMulticritere', true);
	}

	if ($_REQUEST['Rub'] != _NAV_CENTRES_NEW) //Pas de filtres pour Nouvelles destinations
	{
		$this -> assign ('action', get_url_nav($_REQUEST['Rub']));
		$this -> display("blocs/moteur_recherche_centre.tpl");
	}
?>