<?

//***************************************************************************************************************
//  							 FONCTIONS SPECIFIQUES A L APPLICATION
//***************************************************************************************************************


//*************************************************************
//					FONCTIONS DIVERS
//*************************************************************

function getActuAndBonPlanParams()
{
	$params = array();
	$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_GENERALE;

	if ($_REQUEST['Rub'] == _NAV_FICHE_CENTRE)
	$params['id_centre'] = $_REQUEST['id_centre'];
	else if (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR_MOINS_18_ANS"]))
	{
		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_MOINS_18_ANS;
	}
	elseif (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR_REUNION"]))
	{
		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_SEMINAIRE_REUNION;
	}
	elseif (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR_DECOUVERTE"]))
	{
		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_SEJOUR_INDIVIDUEL;
		$params['id_actualite_thematique'][] = _CONST_ACTU_THEMATIQUE_SEJOUR_GROUPE;
	}

	if (in_array($_REQUEST['Rub'], $GLOBALS["_NAV_SEJOUR"]) && isset($_REQUEST['id']))
	{
		$Rub = $_REQUEST['Rub'];
		$sql = "SELECT id_centre FROM ".$GLOBALS["_NAV_SEJOUR_TABLE"][$Rub]." WHERE id_".$GLOBALS["_NAV_SEJOUR_TABLE"][$Rub]." = ".$_REQUEST['id'];
		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). ' - '.$sql;
		else
		$params['id_centre'] = mysql_result($rst, 0, 'id_centre');
	}
	return $params;
}

function getCentreId($Rub,$id){
	switch ($Rub)
	{
		//** POUR LES -18 ANS
		case _NAV_CLASSE_DECOUVERTE :
			$sql="select id_centre from classe_decouverte where id_classe_decouverte=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_ACCUEIL_GROUPES_SCOLAIRES :
			$sql="select id_centre from accueil_groupes_scolaires where id_accueil_groupes_scolaires=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_CVL :
			$sql="select id_centre from cvl where id_cvl=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;

			//** POUR VOS REUNIONS
		case _NAV_ACCEUIL_REUNIONS :
			$sql="select id_centre from accueil_reunions where id_accueil_reunions=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_INCENTIVE :
		case _NAV_SEMINAIRES :
			$sql="select id_centre from seminaires where id_seminaires=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;

			//** DECOUVERTES TOURISTIQUES
		case _NAV_ACCUEIL_GROUPE :
			$sql="select id_centre from accueil_groupes_jeunes_adultes where id_accueil_groupes_jeunes_adultes=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_ACCUEIL_SPORTIF :
			$sql="select id_centre from accueil_groupes_jeunes_adultes where id_accueil_groupes_jeunes_adultes=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_SEJOURS_TOURISTIQUES_GROUPE :
			$sql="select id_centre from sejours_touristiques where id_sejours_touristiques=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_STAGES_THEMATIQUES_GROUPE :
			$sql="select id_centre from stages_thematiques_groupes where id_stages_thematiques_groupes=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_ACCUEIL_INDIVIDUEL :
			$sql="select id_centre from accueil_individuels_familles where id_accueil_individuels_familles=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_SHORT_BREAK :
			$sql="select id_centre from short_breaks where id_short_breaks=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_STAGES_THEMATIQUES_INDIVIDUEL :
			$sql="select id_centre from stages_thematiques_individuels where id_stages_thematiques_individuels=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;
		case _NAV_FICHE_ORGANISATEUR_CVL :
			$sql="select id_centre from organisateur_cvl where id_organisateur_cvl=".$id;
			$result = mysql_query($sql);
			$id = mysql_result($result,0,"id_centre");
			break;	
			
		default:
			$id=0;
			break;
	}

	return $id;

}


function getActualites(&$listeActu, $_params = "")
{
	$sqlActu = " SELECT a.id_actualite, trad.libelle as libelle, trad.description_courte as description_courte
				FROM actualite a
				INNER JOIN trad_actualite trad on a.id_actualite = trad.id__actualite
				WHERE ".get_multi_fullkit_choice("trad.id__langue", $_SESSION['ses_langue'])."
				AND date_debut <= NOW() and date_fin >= NOW() ";

	if ($_params['home'])
	$sqlActu .= " AND accueil = 1 ";

	if (isset($_params['id_actualite_thematique']) && $_REQUEST["Rub"]!=_NAV_FICHE_ORGANISATEUR_CVL)
	getClauseWhere('id_actualite_thematique', $_params['id_actualite_thematique'], $sqlActu);

	if (isset($_params['id_centre']))
	$sqlActu .= (($sqlActu == "")? '' : ' AND ')." id_centre =".$_params['id_centre']." ";
	
	// RPL - 26/05/2011 : gestion affichage par langue
	$sqlActu .= (($sqlActu == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", a.id__langue)>0';
	// RPL

	$sqlActu .= " ORDER BY RAND()";

	$rstActu = mysql_query($sqlActu);
	if (!$rstActu)
	echo mysql_error(). ' - '.$sqlActu;

	$nbActu = mysql_num_rows($rstActu);
	for ($i = 0 ; $i < $nbActu ; $i++)
	{
		$description = mysql_result($rstActu, $i, "description_courte");

		if ($_params['home'])
		$desc_max = 140;
		else
		$desc_max = 70;

		if (strlen($description) > $desc_max)
		$description = substr($description,0,$desc_max)."...";
		$params[0]["id"] = mysql_result($rstActu, $i, "id_actualite");
		$lien = "popin_actu.php?id=".$params[0]["id"];
		$listeActu[] = array ("titre" => mysql_result($rstActu,$i, "libelle"),
		"description" 	=> $description,
		"id" 			=> mysql_result($rstActu, $i, "id_actualite"),
		"lien" 			=> $lien);
	}
	return $nbActu;
} //getActualites()

function getBonPlan(&$listeBP, $_params)
{
	$sqlBP = " SELECT trad.libelle as libelle, bp.id_bon_plan, trad.description as description, DATE_FORMAT(date_debut,'%d/%m/%Y') as date_debut, DATE_FORMAT(date_fin,'%d/%m/%Y') as date_fin
				FROM bon_plan bp
				INNER JOIN trad_bon_plan trad on bp.id_bon_plan = trad.id__bon_plan
				WHERE ".get_multi_fullkit_choice("trad.id__langue", $_SESSION['ses_langue'])."
				AND date_debut <= NOW() and date_fin >= NOW() ";

	if ($_params['home'] == true)
	$sqlBP .= " AND accueil = 1 ";

	if (isset($_params['id_actualite_thematique'])  && $_REQUEST["Rub"]!=_NAV_FICHE_ORGANISATEUR_CVL)
	getClauseWhere('id_actualite_thematique', $_params['id_actualite_thematique'], $sqlBP);

	if (isset($_params['id_centre']))
	$sqlBP .= (($sqlBP == "")? '' : ' AND ')." id_centre =".$_params['id_centre']." ";
	
	// RPL - 26/05/2011 : gestion affichage par langue
	$sqlBP .= (($sqlBP == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", bp.id__langue)>0';
	// RPL

	$sqlBP .= " ORDER BY RAND()";

	$rstBP = mysql_query($sqlBP);
	if (!$rstBP)
	echo mysql_error(). ' - '.$sqlBP;

	$nbBP = mysql_num_rows($rstBP);
	for ($i = 0 ; $i < $nbBP ; $i++)
	{
		$description = mysql_result($rstBP, $i, "description");
		if (strlen($description) > 140)
		$description = substr($description,0,140)."...";


		$params[0]["id"] = mysql_result($rstBP, $i, "id_bon_plan");
		$lien = "popin_bp.php?id=".$params[0]["id"];
		//$lien = get_url_nav(_NAV_BON_PLAN,$params);

		$listeBP[] = array (	"titre" => mysql_result($rstBP, $i, "libelle"),
		"description" => $description,
		"id" 			=> mysql_result($rstBP, $i, "id_bon_plan"),
		"lien" => $lien ,
		"date_debut" => mysql_result($rstBP, $i, "date_debut"),
		"date_fin" => mysql_result($rstBP, $i, "date_fin"));
	}
	return $nbBP;
}


//*****************************************************************
//					FONCTIONS MOTEUR RECHERCHE SEJOUR / CENTRE
//*****************************************************************

function getListeCentreEnvironnement(&$listeEnvironnement)
{
	$sqlCEnv = "SELECT id_trad_centre_environnement, id__centre_environnement, libelle from trad_centre_environnement WHERE id__langue = ".$_SESSION['ses_langue']. " order by id_trad_centre_environnement";
	$rstCEnv = mysql_query($sqlCEnv);

	if (!$rstCEnv)
	echo mysql_error(). " - ".$sqlCEnv;

	$nbCEnv = mysql_num_rows($rstCEnv)	;
	for ($i = 0 ; $i < $nbCEnv ; $i++)
	{
		$id = mysql_result($rstCEnv, $i, "id__centre_environnement");
		$listeEnvironnement[] = array ("id" => $id,
		"libelle" => mysql_result($rstCEnv, $i, "libelle"),
		"current" => (isset($_REQUEST['env_'.$id.'_filter']) || $_REQUEST['env_filter'] == $id ) ? true : false);
	}
	return $nbCEnv;
} // getListeCentreEnvironnement(&$listeEnvironnement)


function getListeCentreAmbiance(&$liste)
{
	$sqlCAmb = "SELECT id_trad_centre_ambiance, id__centre_ambiance, libelle from trad_centre_ambiance WHERE id__langue = ".$_SESSION['ses_langue']. " order by libelle";
	$rstCAmb = mysql_query($sqlCAmb);

	if (!$rstCAmb)
	echo mysql_error(). " - ".$sqlCAmb;

	$nbCAmb = mysql_num_rows($rstCAmb)	;
	for ($i = 0 ; $i < $nbCAmb ; $i++)
	{
		$id = mysql_result($rstCAmb, $i, "id__centre_ambiance");
		$liste[] = array ("id" => $id,
		"libelle" => mysql_result($rstCAmb, $i, "libelle"),
		"current" => (isset($_REQUEST['amb_'.$id.'_filter']) || $_REQUEST['amb_filter'] == $id ) ? true : false);
	}
	return $nbCAmb;
} // getListeCentreAmbiance(&$listeEnvironnement)

function getListeCentreCapaciteSalleReu(&$listeCapacite)
{
	$sql = "SELECT distinct(capacite_salle) from centre ORDER BY capacite_salle ASC ";
	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nb ; $i++)
	{
		if (mysql_result($rst, $i, "capacite_salle") == "")
		continue;

		$listeCapacite[] = array (	"id" => $i,
		"libelle" => mysql_result($rst, $i, "capacite_salle"));
	}

	return $nb;
} // getListeCentreCapaciteSalleReu(&$listeCapacite)

function getListeCentreSiteTouristique(&$listeSites, $_params = "")
{
	$sql = "SELECT id_centre_site_touristique, adresse FROM centre_site_touristique ";

	$sql .= " WHERE id_centre_1 = ".$_params['id_centre'];

	$sql .= " ORDER BY ordre ASC ";

	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nb ; $i++)
	{
		$adresse = mysql_result($rst, $i, "adresse");
		if ($adresse != "")
		{

			if (!eregi("http://", $adresse))

			$adresse = "http://".$adresse;
		}

		$listeSites[] = array (	"libelle" => getTradTable("centre_site_touristique",$_SESSION['ses_langue'],"libelle", mysql_result($rst, $i, "id_centre_site_touristique")),
		"lien" => $adresse );
	}

	return $nb;
} // getListeCentreSitesTouristiques(&$listeSites)


//*************************************************************
//					FONCTIONS MOTEUR RECHERCHE SEJOUR
//*************************************************************

function getListeRegions (&$listeRegions, $_params = "")
{
	$listeRegions = array();

	$sql = "SELECT * from centre_region ";

	if (isset($_params['id']))
	$sql .= " WHERE id_centre_region = ".$_params['id'];

	$sql .=" ORDER BY libelle ASC";
	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error(). " - ".$sql;

	$nbRegion = mysql_numrows($rst);
	for ($i = 0 ; $i < $nbRegion ; $i++)
	{
		$id = mysql_result($rst, $i, "id_centre_region");
		$listeRegions[] = array( "id" => $id,
		"libelle" => mysql_result($rst, $i, "libelle"),
		"current" => ($_REQUEST['region_filter'] == $id) ? true : false);
	}
	return $nbRegion;
} // getRegions (&$listeRegions)


function getConditionFamille($id){
	$sql = "SELECT conditions FROM trad_accueil_individuels_familles WHERE id__accueil_individuels_familles=$id AND id__langue=".$_SESSION['ses_langue'];

	$rst = mysql_query($sql);
	return mysql_result($rst,0,"conditions");
}


function getListeSejourInfos($type, &$listeInfo, $_params = "")
{
	$listeInfo = array();

	if ($type != "")
	{

		$sqlSelect = "select id__sejour_".$type.", libelle from trad_sejour_".$type." WHERE id__langue = ".$_SESSION['ses_langue'];

		if (isset($_params['id']) )
		{
			if ($_params['id'][0] == '')
			return 0;

			$sqlSelect .= " AND (";
			$first = true;
			foreach ($_params['id'] as $id)
			{
				if ($id != '')
				{
					if ($first)
					{
						$where .= '';
						$first = false;
					}
					else
					$sqlSelect .= ' OR ';
					$sqlSelect .= " id__sejour_".$type." = ".$id;
				}
			}
			$sqlSelect .= ')';
		}

		$sqlSelect .= " ORDER BY id__sejour_".$type;

		$rstSelect = mysql_query($sqlSelect);

		if (!$rstSelect)
		echo (mysql_error(). " : ".$sqlSelect);
		else
		{
			$nbSelect = mysql_num_rows($rstSelect);
			for ($i = 0 ; $i < $nbSelect ; $i++)
			{
				$id = mysql_result($rstSelect,$i, "id__sejour_".$type);
				$listeInfo[] = array (	"id" => $id,
				"libelle" => mysql_result($rstSelect,$i, "libelle"),
				"current" => ((isset($_REQUEST[$type.'_'.$id.'_filter']) || $_REQUEST[$type.'_filter'] == $id)? true : false ) ) ;
			}
			return $nbSelect;
		}
	}
	else
	echo "Aucun type pour getListeSejourInfos()";

	return 0;
} // getListeSejourInfos($type, &$listeInfo)

function getListeCentreInfos($type, &$listeInfo, $_params = "")
{
	$listeInfo = array();

	if ($type != "")
	//if ($type != "" && isset($_params['id']) && $_params['id'][0] != '')
	{
		$sqlSelect = "SELECT id__centre_".$type.", libelle FROM trad_centre_".$type."
		WHERE id__langue = ".$_SESSION['ses_langue'];

		if (isset($_params['id']) && $_params['id'][0] != '')
		{
			$sqlSelect .= " AND (";
			$first = true;
			foreach ($_params['id'] as $id)
			{
				if ($id != '')
				{
					if ($first)
					{
						$where .= '';
						$first = false;
					}
					else
					$sqlSelect .= ' OR ';
					$sqlSelect .= " id__centre_".$type." = ".$id;
				}
			}
			$sqlSelect .= ')';
		}

		$sqlSelect .= " order by id__centre_".$type;
		$rstSelect = mysql_query($sqlSelect);

		if (!$rstSelect)
		echo ("getListeCentreInfos : ".mysql_error(). " : ".$sqlSelect);
		else
		{
			$nbSelect = mysql_num_rows($rstSelect);
			for ($i = 0 ; $i < $nbSelect ; $i++)
			{
				$id = mysql_result($rstSelect,$i, "id__centre_".$type);
				$listeInfo[] = array (	"id" => $id,
				"libelle" => mysql_result($rstSelect,$i, "libelle"),
				"current" => ((isset($_REQUEST[$type.'_'.$id.'_filter']) || $_REQUEST[$type.'_filter'] == $id)? true : false ) ) ;
			}
			return $nbSelect;
		}
	}
	else
	//echo "Aucun type pour getListeCentreInfos()";

	return 0;
} // getListeSejourInfos($type, &$listeInfo)

function getListeCapaciteAccueilReunion(&$liste)
{
	$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_REU_10_20 , 	"libelle" => get_libLocal('centre_capacite_reu_10_20'), 	"current" => (($_REQUEST['capacite_reu_filter'] == _CONST_CENTRE_CAPACITE_REU_10_20) ? true : false));
	$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_REU_21_40 , 	"libelle" => get_libLocal('centre_capacite_reu_21_40'), 	"current" => (($_REQUEST['capacite_reu_filter'] == _CONST_CENTRE_CAPACITE_REU_21_40) ? true : false));
	$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_REU_41_80 , 	"libelle" => get_libLocal('centre_capacite_reu_41_80'), 	"current" => (($_REQUEST['capacite_reu_filter'] == _CONST_CENTRE_CAPACITE_REU_41_80) ? true : false));
	$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_REU_81_100 , 	"libelle" => get_libLocal('centre_capacite_reu_81_100'), 	"current" => (($_REQUEST['capacite_reu_filter'] == _CONST_CENTRE_CAPACITE_REU_81_100) ? true : false));
	$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_REU_101_140 , "libelle" => get_libLocal('centre_capacite_reu_101_140'), 	"current" => (($_REQUEST['capacite_reu_filter'] == _CONST_CENTRE_CAPACITE_REU_101_140) ? true : false));
	$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_REU_141_200 , "libelle" => get_libLocal('centre_capacite_reu_141_200'), 	"current" => (($_REQUEST['capacite_reu_filter'] == _CONST_CENTRE_CAPACITE_REU_141_200) ? true : false));
	$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_REU_MORE_200 ,"libelle" => get_libLocal('centre_capacite_reu_more_200'), 	"current" => (($_REQUEST['capacite_reu_filter'] == _CONST_CENTRE_CAPACITE_REU_MORE_200) ? true : false));

} //getListeCapaciteAccueilReunion($liste)

function getListeCapaciteLits(&$liste)
{
	switch ($_REQUEST['Rub'])
	{
		case _NAV_CENTRES_MER :
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_100 , 	  "libelle" => get_libLocal('centre_capacite_lits_100'), 	 "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_100) ? true : false));
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_100_150 ,  "libelle" => get_libLocal('centre_capacite_lits_100_150'), "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_100_150) ? true : false));
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_MORE_150 ,  "libelle" => get_libLocal('centre_capacite_lits_more_150'), "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_MORE_150) ? true : false));
			break;

		case _NAV_CENTRES_CAMPAGNE :
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_100 , 	  "libelle" => get_libLocal('centre_capacite_lits_100'), 	 "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_100) ? true : false));
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_MORE_100 ,  "libelle" => get_libLocal('centre_capacite_lits_more_100'), "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_MORE_100) ? true : false));
			break;

		case  _NAV_CENTRES_VILLE:
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_100 , 	  "libelle" => get_libLocal('centre_capacite_lits_100'), 	 "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_100) ? true : false));
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_100_200 ,  "libelle" => get_libLocal('centre_capacite_lits_100_200'), "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_100_200) ? true : false));
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_MORE_200 , "libelle" => get_libLocal('centre_capacite_lits_more_200'),"current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_MORE_200) ? true : false));
			break;

		default:
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_100 , 	  "libelle" => get_libLocal('centre_capacite_lits_100'), 	 "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_100) ? true : false));
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_100_150 ,  "libelle" => get_libLocal('centre_capacite_lits_100_150'), "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_100_150) ? true : false));
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_150_200 ,  "libelle" => get_libLocal('centre_capacite_lits_150_200'), "current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_150_200) ? true : false));
			$liste[] = array ( "id" => _CONST_CENTRE_CAPACITE_LITS_MORE_200 , "libelle" => get_libLocal('centre_capacite_lits_more_200'),"current" => (($_REQUEST['capacite_lits_filter'] == _CONST_CENTRE_CAPACITE_LITS_MORE_200) ? true : false));
			break;
	}


} //getListeCapaciteLits($liste)

//*************************************************************
//					FONCTIONS LISTES CENTRE
//*************************************************************

function getCentreRand()
{
	getListeCentre ($listeCentre);
	$indice = array_rand($listeCentre);
	return $listeCentre[$indice];
} // getCentreRand()

function getListeCentre (&$listeCentre, $_params = "")
{
	$listeCentre = array();
	$champSelect = "c.id_centre, c.libelle, c.ville, c.visuel_1,c.visuel_2,c.visuel_3,c.visuel_4,c.visuel_5,c.visuel_6,c.visuel_7,c.visuel_8,c.visuel_9,c.visuel_10, id_centre_region";
	$sql = "SELECT _champ_select
					FROM centre c ";


	//**VOUS VENEZ PLUTOT : SEUL OU EN FAMILLE
	if (isset($_params['individuel']) && !isset($_params['groupe']))
	$sql .= " INNER JOIN accueil_individuels_familles ac on ac.id_centre = c.id_centre ";

	//**VOUS VENEZ PLUTOT : EN GROUPE
	if (isset($_params['groupe']) && !isset($_params['individuel']))
	$sql .= " INNER JOIN accueil_groupes_jeunes_adultes agj on agj.id_centre = c.id_centre ";

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//**Ambiance
	if (isset($_params['id_centre_ambiance']))
	getClauseWhere('id_centre_ambiance', $_params['id_centre_ambiance'], $where);

	//**Nouvelles destinations
	if (isset($_params['moins_6_mois']))
	$where .= (($where == "") ? '' : " AND ")." DATE_ADD(date_inscription, INTERVAL 6 MONTH) >= NOW()";

	$where .= (($where == "") ? '' : " AND ")." c.etat=1";
	if (isset($_params['individuel'])  && !isset($_params['groupe']))
	$where .= (($where == "") ? '' : " AND ")." ac.etat=1";
	if (isset($_params['groupe']) && !isset($_params['individuel']))
	$where .= (($where == "") ? '' : " AND ")." agj.etat=1";

	//**CAPACITE D'ACCUEIL LITS
	if (isset($_params['capacite_lits']))
	{
		$min = "";
		$max = "";
		switch ($_params['capacite_lits'])
		{
			case _CONST_CENTRE_CAPACITE_LITS_100 :
				$max = 100;
				break;
			case _CONST_CENTRE_CAPACITE_LITS_100_150 :
				$min = 100;
				$max = 150;
				break;
			case _CONST_CENTRE_CAPACITE_LITS_100_200 :
				$min = 100;
				$max = 200;
				break;
			case  _CONST_CENTRE_CAPACITE_LITS_150_200 :
				$min = 150;
				$max = 200;
				break;
			case _CONST_CENTRE_CAPACITE_LITS_MORE_100 :
				$min = 100;
				break;
			case _CONST_CENTRE_CAPACITE_LITS_MORE_150 :
				$min = 150;
				break;
			case _CONST_CENTRE_CAPACITE_LITS_MORE_200 :
				$min = 200;
				break;
		}
		$where .= (($where == "") ? '(' : " AND (");

		if ($min != "")
		$where .= " nb_lit >= ".$min ;
		if ($max != "")
		$where .= (($min != "") ? ' AND ' : '')." nb_lit <= ".$max;

		$where .= ")";
	}

	//**Environnement montagne
	if (isset($_params['id_centre_environnement_montagne']))
	getClauseWhere('id_centre_environnement_montagne', $_params['id_centre_environnement_montagne'], $where);

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", c.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " GROUP BY c.id_centre ORDER BY RAND(".getRandOrderBy().")";

	//On récupère le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "c.id_centre", $sql) );

	if (!$rst)
	echo mysql_error(). " - ".$sql;

	$nbTotal = mysql_num_rows($rst);
	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requête pour récupérer uniquement le nombre d'éléments dont nous avons besoin
		if ($_params['disableLimit'] == false){
			$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;
		}

		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);

		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$description = getTradTable("centre",$_SESSION['ses_langue'],"presentation", mysql_result($rst,$i, "id_centre"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			for($cmpt = 1; $cmpt<=10; $cmpt++){
				if (getFileFromBDD(mysql_result($rst, $i, "visuel_".$cmpt), "centre") != ""){
					$visuel = getFileFromBDD(mysql_result($rst, $i, "visuel_".$cmpt), "centre");
					break;
				}
			}
			$listeCentre [] = array (	"id" => mysql_result($rst,$i, "id_centre"),
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(mysql_result($rst, $i, "libelle"), "utf-8"),
			"description" => $description,
			"image" => verif_visuel_1($visuel),
			"lien" => get_url_nav_centre(_NAV_FICHE_CENTRE, mysql_result($rst,$i, "id_centre")),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

		}
	}

	return $nbTotal;

} // getListeCentre (&$listeCentre, $_params = "")




//*************************************************************
//					FONCTIONS LISTES SEJOURS
//*************************************************************

function getClauseWhere ($champ, $values = array(), &$where)
{
	$where .= (($where == "") ? '(' : " AND (") ;
	$first = true;
	foreach ($values as $value)
	{
		if ($first)
		{
			$where .= '';
			$first = false;
		}
		else
		$where .= ' OR ';

		$where .= " ".$champ." like '%".$value."%' ";
	}
	$where .= ")";
}

function getRandOrderBy()
{
	$rand = $_SESSION['rand'];
	if (empty($rand) || $_SESSION['last_rub'] != $_REQUEST['Rub']) {
		srand((float)microtime()*1000000);
		$rand = rand();
		$_SESSION['rand'] = $rand;
	}
	$_SESSION['last_rub'] = $_REQUEST['Rub'];

	return $rand;
} // getRandOrderBy()

function getStartLimit($nbTotal)
{
	$pageCourante = 1;
	if (isset($_REQUEST['P']) && is_numeric($_REQUEST['P']))
	$pageCourante = $_REQUEST['P'];

	$nbPages = ceil($nbTotal / _NB_ENR_PAGE_RES)+1;

	if ($nbTotal <= _NB_ENR_PAGE_RES)
	$startPagination = 0;
	else
	$startPagination = (($pageCourante - 1) * _NB_ENR_PAGE_RES) ;

	if ($pageCourante > $nbPages)
	{
		$pageCourante = 1;
		$startPagination = 0;
	}
	return $startPagination;
} // getStartLimit($nbTotal)

function getSelectImages($table, &$champSelect)
{
	for ($i = 2 ; $i <= 10 ; $i++)
	$champSelect .= ','.$table.'.visuel_'.$i;
}

function getRstImages($rst, $i, $table, &$listeRes)
{
	for ($j = 1 ; $j <= 10 ; $j++)
	{
		if (mysql_result($rst, $i, $table.'.visuel_'.$j) != "")
		{
			if (getFileFromBDD(mysql_result($rst, $i, $table.'.visuel_'.$j)) != '')
			$listeRes [$i]['liste_image'][] = getFileFromBDD(mysql_result($rst, $i, $table.'.visuel_'.$j), $table);
		}
	}
} // getRstImages($rst, $i, $table, &$listeRes)

function getSejourRand()
{
	$listeRes = array();
	$arrayRub = $GLOBALS["_NAV_SEJOUR"];

	//On enl�ve tous les sejours de type "accueil"
	$tabRubAccueil = array (_NAV_ACCUEIL_GROUPES_SCOLAIRES, _NAV_ACCEUIL_REUNIONS, _NAV_ACCUEIL_GROUPE, _NAV_ACCUEIL_SPORTIF, _NAV_ACCUEIL_INDIVIDUEL);
	foreach ($tabRubAccueil as $RubAccueil )
	unset($arrayRub[array_search($RubAccueil, $arrayRub)]);

	$nb = 0;
	$listeRes = array();
	while ($nb == 0) //On fait un while pour v�rifier qu'il y ait bien un r�sultat
	{
		//On r�cup�re une _NAV au hasard
		$indice = array_rand($arrayRub);
		
		switch ($GLOBALS["_NAV_SEJOUR"][$indice])
		{
			case _NAV_CLASSE_DECOUVERTE :
				$nb = getListeSejourClasseDecouverte($listeRes);
				break;
			case _NAV_CVL :
				$nb = getListeSejourCVL($listeRes);
				break;
			case _NAV_SEMINAIRES :
				$nb = getListeSejourSeminaires($listeRes);
				break;
			case _NAV_SEJOURS_TOURISTIQUES_GROUPE :
				$nb = getListeSejourTouristiquesGroupe($listeRes);
				break;
			case _NAV_STAGES_THEMATIQUES_GROUPE :
				$nb = getListeStagesThematiquesGroupe($listeRes);
				break;
			case _NAV_SHORT_BREAK :
				$nb = getListeShortBreak($listeRes);
				break;
			case _NAV_STAGES_THEMATIQUES_INDIVIDUEL :
				$nb = getListeStagesThematiquesIndividuels($listeRes);
				break;
		}
	}

	//On récupère un séjour au hasard
	$indice = array_rand($listeRes);
	return $listeRes[$indice];
}


function verif_visuel_1($visuel)
{
	if ($visuel == 'images/upload/portfolio_img/')
	$visuel = '';

	return ($visuel != '') ? $visuel : 'images/dyn/visu_sejour_defaut.jpg';
} // verif_visuel_1($visuel)



function getListeSejour($Rub, &$listeRes, $_params = "")
{
	switch ($Rub)
	{
		//** POUR LES -18 ANS
		case _NAV_CLASSE_DECOUVERTE :
			$nbRes = getListeSejourClasseDecouverte($listeRes, $_params);
			break;
		case _NAV_ACCUEIL_GROUPES_SCOLAIRES :
			$nbRes = getListeSejourAccueilScolaire($listeRes, $_params);
			break;
		case _NAV_CVL :
			$nbRes = getListeSejourCVL($listeRes, $_params);
			break;

			//** POUR VOS REUNIONS
		case _NAV_ACCEUIL_REUNIONS :
			$nbRes = getListeSejourAcceuilReunion($listeRes, $_params);
			break;
		case _NAV_INCENTIVE :
		case _NAV_SEMINAIRES :
			$nbRes = getListeSejourSeminaires($listeRes, $_params);
			break;

			//** DECOUVERTES TOURISTIQUES
		case _NAV_ACCUEIL_GROUPE :
			$nbRes = getListeSejourAccueilGroupe($listeRes, $_params);
			break;
		case _NAV_ACCUEIL_SPORTIF :
			$_params['accueil_sportif'] = true;
			$nbRes = getListeSejourAccueilGroupe($listeRes, $_params);
			break;
		case _NAV_SEJOURS_TOURISTIQUES_GROUPE :
			$nbRes = getListeSejourTouristiquesGroupe($listeRes, $_params);
			break;
		case _NAV_STAGES_THEMATIQUES_GROUPE :
			$nbRes = getListeStagesThematiquesGroupe($listeRes, $_params);
			break;
		case _NAV_ACCUEIL_INDIVIDUEL :
			$nbRes = getListeAcceuilIndividuels($listeRes, $_params);
			break;
		case _NAV_SHORT_BREAK :
			$nbRes = getListeShortBreak($listeRes, $_params);
			break;
		case _NAV_STAGES_THEMATIQUES_INDIVIDUEL :
			$nbRes = getListeStagesThematiquesIndividuels($listeRes, $_params);
			break;
	}

	return $nbRes;
} // getListeSejour($Rub, &$listeRes, $_params = "")

//------------------
//POUR LES -18 ANS--
//------------------
function getListeSejourClasseDecouverte(&$listeRes, $_params = "")
{

	//INFOS : Titre classe d�couverte - Ville - texte s�jour - image classe d�couverte
	$listeRes = array();

	if ($_SESSION['ses_langue'] != _ID_FR) //Pas de Classe de d�couverte
	return 0;


	$arrayChampSelect = array();

	$champSelect = "nom, id_classe_decouverte, centre.id_centre, libelle, ville, classe_decouverte.visuel_1, id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("classe_decouverte", $champSelect);

		$arrayChampSelect = array("adresse", "code_postal", "ville", "site_internet", "email", //Contact
		"id_sejour_niveau_scolaire", "id_sejour_periode_disponibilite", //Bloc gauche
		"agrement_edu_nationale_4", "agrement_edu_nationale_texte", "agrement_jeunesse_4", "agrement_jeunesse_texte", "agrement_tourisme_4", //Onglet Agr�ments
		"agrement_tourisme_texte", "agrement_ddass_4", "agrement_ddass_texte", "agrement_formation_4", "agrement_formation_text as agrement_formation_texte", "agrement_ancv_4",
		"agrement_ancv_text as agrement_ancv_texte", "agrement_autre_4", "agrement_autre_text as agrement_autre_texte",
		"a_partir_de_prix", "prix_par_29", "id_sejour_nb_lit__par_chambre", "nb_jours", "nb_nuits",//Onglet Tarif
		"nb_chambre", "nb_couvert", "nb_lit", "id_centre_service", "id_centre_activite", //Onglet Lieu du s�jour
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude",
		"id_centre_detention_label"); //Onglet acc�s
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$sql = "SELECT _champ_select
					FROM classe_decouverte
					INNER JOIN centre on centre.id_centre = classe_decouverte.id_centre ";

	$where = "";
	//**REGIONS
	if (isset($_params['id_centre_region']))
	$where = " id_centre_region = ".$_params['id_centre_region'];

	//**THEME ( expressions - patrimoine et terroir ...)
	if (isset($_params['id_sejour_theme']))
	$where .= (($where == "")? '' : ' AND ')." id_sejour_theme like '%".$_params['id_sejour_theme']."%'";

	//**NIVEAU SCOLAIRE ( maternelle, CP/CE ...)
	if (isset($_params['id_sejour_niveau_scolaire']))
	getClauseWhere('id_sejour_niveau_scolaire', $_params['id_sejour_niveau_scolaire'], $where);

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_classe_decouverte =".$_params['id_sejour']." ";

	//** FICHE ACCUEIL DE SCOLAIRE - Onglet Nos classes de d�couverte
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' classe_decouverte.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", classe_decouverte.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";



	//On récupère le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	if (!$rst)
	echo mysql_error(). " - ".$sql;

	$nbTotal = mysql_result ( $rst, 0, "nb" );

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//echo $sql;
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;



		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_classe_decouverte");

			$description = getTradTable("classe_decouverte",$_SESSION['ses_langue'],"details", mysql_result($rst,$i, "id_classe_decouverte"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide
			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
				$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(mysql_result($rst, $i, "nom"),"utf-8"),
			"nom_centre" => mysql_result($rst, $i, "libelle"),
			"id_centre" => mysql_result($rst, $i, "id_centre"),
			"description" => $description,
			"nb_jours" => mysql_result($rst, $i, "nb_jours"),
			"nb_nuits" => mysql_result($rst, $i, "nb_jours"),
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "classe_decouverte")),
			"lien" => get_url_nav_sejour(_NAV_CLASSE_DECOUVERTE, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'classe_decouverte', $listeRes);

				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}

				$id_centre = mysql_result($rst,$i, "centre.id_centre");

				//Contact
				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet Int�r�t P�dagogique
				$listeRes [$i]["interet_pedagogique"] = getTradTable("classe_decouverte",$_SESSION['ses_langue'],"interet_pedagogique", $id);

				//Onglet Tarifs
				$listeRes [$i]["duree_sejour"] = getTradTable("classe_decouverte",$_SESSION['ses_langue'],"duree_sejour", $id);
				$listeRes [$i]["prix_comprend"] = getTradTable("classe_decouverte",$_SESSION['ses_langue'],"prix_comprend", $id);
				$listeRes [$i]["prix_ne_comprend_pas"] = getTradTable("classe_decouverte",$_SESSION['ses_langue'],"prix_ne_comprend_pas", $id);

				//Onglet Lieu du s�jour
				$listeRes [$i]["presentation"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation", $id_centre);

				//Onglet acc�s
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);
			}

		}
	}

	//return $nbRes;
	return $nbTotal;
} // getListeSejourClasseDecouverte(&$listeRes)

function getListeSejourAccueilScolaire(&$listeRes, $_params = "")
{
	//INFOS : Nom centre - Ville - Presentation centre - Image accueil scolaire

	$arrayChampSelect = array();

	$champSelect = "id_accueil_groupes_scolaires , libelle, ville, accueil_groupes_scolaires.visuel_1, centre.id_centre as id_centre, id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("accueil_groupes_scolaires", $champSelect);
		$arrayChampSelect = array("presentation_region","adresse", "code_postal", "ville", "site_internet", "email",
		"nb_chambre", "nb_couvert", "nb_lit", "id_centre_service", "id_centre_activite",// Onglet Centre
		"agrement_edu_nationale_4", "agrement_edu_nationale_texte", "agrement_jeunesse_4", "agrement_jeunesse_texte", "agrement_tourisme_4", //Onglet Agrements
		"agrement_tourisme_texte", "agrement_ddass_4", "agrement_ddass_texte", "agrement_formation_4", "agrement_formation_text as agrement_formation_texte", "agrement_ancv_4",
		"agrement_ancv_text as agrement_ancv_texte", "agrement_autre_4", "agrement_autre_text as agrement_autre_texte",
		"id_sejour_nb_lit__par_chambre", "gratuite_chauffeur_4", "gratuite_accompagnateur_4", //Onglet Tarifs
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude",
		"id_centre_detention_label"); //Onglet Acc�s
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$listeRes = array();
	$sql = "SELECT _champ_select
					FROM accueil_groupes_scolaires
					INNER JOIN centre on centre.id_centre = accueil_groupes_scolaires.id_centre";

	$where = "";
	//**REGIONS
	if (isset($_params['id_centre_region']))
	$where = " id_centre_region = ".$_params['id_centre_region'];

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_accueil_groupes_scolaires =".$_params['id_sejour']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' accueil_groupes_scolaires.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", accueil_groupes_scolaires.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";


	//On recupere le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin

		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;


		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);

		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_accueil_groupes_scolaires");
			$description = getTradTable("centre",$_SESSION['ses_langue'],"presentation", mysql_result($rst,$i, "id_centre"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour eviter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			$image = getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "acceuil_groupes_scolaires");

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array ( "id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(mysql_result($rst, $i, "libelle"),"utf-8"),
			"description" => $description,
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "acceuil_groupes_scolaires")),
			"lien" => get_url_nav_sejour(_NAV_ACCUEIL_GROUPES_SCOLAIRES, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'accueil_groupes_scolaires', $listeRes);



				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}

				$id_centre = mysql_result($rst,$i, "centre.id_centre");
				$listeRes [$i]["id_centre"] = $id_centre;

				//**Onglet contact
				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//**Onglet Le Centre
				$listeRes [$i]["presentation"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation", $id_centre);
				$listeRes [$i]["presentation_region"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation_region", $id_centre);
				//**Onglet tarif
				$listeRes [$i]["haute_saison"] = getTradTable("accueil_groupes_scolaires",$_SESSION['ses_langue'],"haute_saison", $id);
				$listeRes [$i]["moyenne_saison"] = getTradTable("accueil_groupes_scolaires",$_SESSION['ses_langue'],"moyenne_saison", $id);
				$listeRes [$i]["basse_saison"] = getTradTable("accueil_groupes_scolaires",$_SESSION['ses_langue'],"basse_saison", $id);
				$listeRes [$i]["conditions_scolaires"] = getTradTable("accueil_groupes_scolaires",$_SESSION['ses_langue'],"conditions_scolaires", $id);

				//**Onglet Acc�s
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);

			}
		}
	}

	//return $nbRes;
	return $nbTotal;
} // getListeSejourAccueilScolaire(&$listeRes)

function getListeSejourCVL(&$listeRes, $_params = "")
{
	//INFOS : Titre s�jour - Ville - texte s�jour - images cvl

	$listeRes = array();
	$arrayChampSelect = array();

	$champSelect = "nom, id_cvl , libelle, ville, cvl.visuel_1, centre.id_centre, centre.id_centre as id_centre , id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("cvl", $champSelect);
		$arrayChampSelect = array("adresse", "code_postal", "ville", "site_internet", "id_sejour_tranche_age", "email",
		"agrement_edu_nationale_4", "agrement_edu_nationale_texte", "agrement_jeunesse_4", "agrement_jeunesse_texte", "agrement_tourisme_4", //Onglet Agr�ments
		"agrement_tourisme_texte", "agrement_ddass_4", "agrement_ddass_texte", "agrement_formation_4", "agrement_formation_text as agrement_formation_texte", "agrement_ancv_4",
		"agrement_ancv_text as agrement_ancv_texte", "agrement_autre_4", "agrement_autre_text as agrement_autre_texte",
		"a_partir_de_prix", "id_sejour_nb_lit__par_chambre", "nb_jours", "nb_nuits",//Onglet Tarif
		"nb_chambre", "nb_couvert", "nb_lit", "id_centre_service", "id_centre_activite", //Onglet Lieu du s�jour
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude",
		"id_centre_detention_label",
		"id_centre_detention_label"); //Onglet acc�s
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$sql = "SELECT _champ_select
					FROM cvl
					INNER JOIN centre on centre.id_centre = cvl.id_centre";

	$where = "";
	//**THEME ( expressions - patrimoine et terroir ...)
	if (isset($_params['id_sejour_theme']))
	$where .= " id_sejour_theme like '%".$_params['id_sejour_theme']."%'";

	//**AGE ENFANT ( 4/6 ans - 7/9 ans ... )
	if (isset($_params['id_sejour_tranche_age']))
	getClauseWhere('id_sejour_tranche_age', $_params['id_sejour_tranche_age'], $where);

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_cvl =".$_params['id_sejour']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' cvl.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", cvl.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";

	//On r�cup�re le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_cvl");
			$description = getTradTable("cvl",$_SESSION['ses_langue'],"presentation", mysql_result($rst,$i, "id_cvl"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(mysql_result($rst, $i, "nom"),"utf-8"),
			"nom_centre" => mysql_result($rst, $i, "libelle"),
			"id_centre" => mysql_result($rst, $i, "id_centre"),
			"description" => $description,
			"nb_jours" => mysql_result($rst, $i, "nb_jours"),
			"nb_nuits" => mysql_result($rst, $i, "nb_jours"),
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "cvl")),
			"lien" => get_url_nav_sejour(_NAV_CVL, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));
			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'cvl', $listeRes);

				//foreach ($arrayChampSelect as $champ)
				//$listeRes [$i][$champ] = mysql_result($rst, $i, $champ);
				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}
				$id_centre = mysql_result($rst,$i, "centre.id_centre");
				$listeRes [$i]["id_centre"] = $id_centre;

				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet Tarifs
				$listeRes [$i]["duree_sejour"] = getTradTable("cvl",$_SESSION['ses_langue'],"duree_sejour", $id);
				$listeRes [$i]["prix_comprend"] = getTradTable("cvl",$_SESSION['ses_langue'],"prix_comprend", $id);
				$listeRes [$i]["prix_ne_comprend_pas"] = getTradTable("cvl",$_SESSION['ses_langue'],"prix_ne_comprend_pas", $id);

				//Onglet Lieu du s�jour
				$listeRes [$i]["presentation"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation", $id_centre);

				//Onglet acc�s
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);

			}
		}
		
		
		
		
	}

	//return $nbRes;
	return $nbTotal;
} // getListeSejourCVL(&$listeRes)

//-------------------
//POUR VOS REUNIONS--
//-------------------
function getListeSejourAcceuilReunion(&$listeRes, $_params = "")
{
	// INFOS : VILLE - Nom Centre - Texte Centre - Image séjour
	$arrayChampSelect = array();
	
	$champSelect = "id_accueil_reunions, libelle, ville, accueil_reunions.visuel_1, centre.id_centre as id_centre , id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("accueil_reunions", $champSelect);
		$arrayChampSelect = array( "adresse","code_postal", "ville", "site_internet", "email",
		"nb_salle_reunion", "capacite_salle_min", "capacite_salle_max",
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude",
		"id_centre_detention_label"); //Onglet accès
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$listeRes = array();
	$sql = "SELECT _champ_select
					FROM accueil_reunions
					INNER JOIN centre on centre.id_centre = accueil_reunions.id_centre";

	$where = "";
	//**REGIONS
	if (isset($_params['id_centre_region']))
	$where = " id_centre_region = ".$_params['id_centre_region'];

	//**CAPACITE D'ACCUEIL EN REUNION
	if (isset($_params['capacite_reu']))
	{
		$min = "";
		$max = "";
		switch ($_params['capacite_reu'])
		{
			case _CONST_CENTRE_CAPACITE_REU_10_20 :
				$min = 10;
				$max = 20;
				break;
			case _CONST_CENTRE_CAPACITE_REU_21_40 :
				$min = 21;
				$max = 40;
				break;
			case _CONST_CENTRE_CAPACITE_REU_41_80 :
				$min = 41;
				$max = 80;
				break;
			case _CONST_CENTRE_CAPACITE_REU_81_100 :
				$min = 81;
				$max = 100;
				break;
			case _CONST_CENTRE_CAPACITE_REU_101_140 :
				$min = 101;
				$max = 140;
				break;
			case _CONST_CENTRE_CAPACITE_REU_141_200 :
				$min = 141;
				$max = 200;
				break;
			case _CONST_CENTRE_CAPACITE_REU_MORE_200 :
				$min = 200;
				break;
		}
		$where .= (($where == "") ? '(' : " AND (");

		if ($min != "")
		$where .= " capacite_salle_min <= ".$min ;
		if ($max != "")
		$where .= " AND capacite_salle_max >= ".$max;

		$where .= ")";
	}

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_accueil_reunions =".$_params['id_sejour']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' accueil_reunions.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", accueil_reunions.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";
	
	//On récupère le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );
	
	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requête pour récupérer uniquement le nombre d'éléments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
	
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_accueil_reunions");
			$description = getTradTable("centre",$_SESSION['ses_langue'],"presentation", mysql_result($rst,$i, "id_centre"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];


			if ($_SESSION['ses_langue'] == _ID_ES || $_SESSION['ses_langue'] == _ID_DE)
			$lien = get_url_nav_centre(_NAV_FICHE_CENTRE,mysql_result($rst,$i, "centre.id_centre"));
			else{
				$lien = get_url_nav_sejour(_NAV_ACCEUIL_REUNIONS, $id);
				//echo 'lien '.$id.' = '.$lien.'<br />';
			}
			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(mysql_result($rst, $i, "libelle"),"utf-8"),
			"nom_centre" => mb_strtoupper(mysql_result($rst, $i, "libelle"),"utf-8"),
			"description" => $description,
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "accueil_reunions")),
			"lien" => $lien,
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));
			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'accueil_reunions', $listeRes);

				//foreach ($arrayChampSelect as $champ)
				//$listeRes [$i][$champ] = mysql_result($rst, $i, $champ);
				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}

				$id_centre = mysql_result($rst,$i, "centre.id_centre");
				$listeRes [$i]["id_centre"] = $id_centre;

				//**Contact
				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet accès
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);

			}
		}
		
	}

	//return $nbRes;
	//echo '<br />NB Fin : '.$nbTotal;
	return $nbTotal;
} // getListeSejourAcceuilReunion(&$listeRes)

function getListeSejourSeminaires(&$listeRes, $_params = "")
{
	//INFOS : Nom s�minaire  - Ville - Pr�sentation s�minaire - Image s�minaire

	$listeRes = array();

	if ($_SESSION['ses_langue'] != _ID_FR) //Pas Seminaires
	return 0;

	$arrayChampSelect = array();

	$champSelect = "nom, id_seminaires, id_sejour_theme_seminaire, libelle, ville, seminaires.visuel_1, centre.id_centre , id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("seminaires", $champSelect);
		$arrayChampSelect = array("adresse", "code_postal", "ville", "site_internet", "id_sejour_accueil_handicap", "email",
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude", //Onglet acc�s
		"a_partir_de_prix",//Onglet Tarif
		"nb_chambre", "nb_couvert", "nb_lit", "id_centre_service", "id_centre_activite", "nb_salle_reunion",
		"id_centre_detention_label", "capacite_salle_min","capacite_salle_max" ); //Onglet Lieu du s�jour
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$sql = "SELECT _champ_select
					FROM seminaires
					INNER JOIN centre on centre.id_centre = seminaires.id_centre";

	$where = "";
	//**THEMATIQUE DU SEMINAIRE
	if (isset ($_params['id_sejour_theme_seminaire']))
	getClauseWhere('id_sejour_theme_seminaire', $_params['id_sejour_theme_seminaire'], $where);

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_seminaires =".$_params['id_sejour']." ";

	//** FICHE ACCUEIL DE REUNION - Onglet Exemple de s�minaires
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' seminaires.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", seminaires.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";

	//On r�cup�re le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_seminaires");
			$description = getTradTable("seminaires",$_SESSION['ses_langue'],"presentation", mysql_result($rst,$i, "id_seminaires"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(mysql_result($rst, $i, "nom"),"utf-8"),
			"nom_centre" => mysql_result($rst, $i, "libelle"),
			"id_centre" => mysql_result($rst, $i, "id_centre"),
			"id_sejour_theme_seminaire" => mysql_result($rst, $i, "id_sejour_theme_seminaire"),
			"description" => $description,
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "seminaires")),
			"lien" => get_url_nav_sejour(_NAV_SEMINAIRES, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'seminaires', $listeRes);

				//foreach ($arrayChampSelect as $champ)
				//$listeRes [$i][$champ] = mysql_result($rst, $i, $champ);
				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}
				$id_centre = mysql_result($rst,$i, "centre.id_centre");
				$listeRes [$i]["id_centre"] = $id_centre;

				//Onglet Contact
				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet Descriptif
				$listeRes [$i]["description_complete"] = getTradTable("seminaires",$_SESSION['ses_langue'],"descriptif", $id);

				//Onglet Tarifs
				$listeRes [$i]["prix_comprend"] = getTradTable("seminaires",$_SESSION['ses_langue'],"prix_comprend", $id);
				$listeRes [$i]["prix_ne_comprend_pas"] = getTradTable("seminaires",$_SESSION['ses_langue'],"prix_ne_comprend_pas", $id);

				//Onglet Lieu du s�jour
				$listeRes [$i]["presentation"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation", $id_centre);


				//Onglet acc�s
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);

			}
		}
	}

	//return $nbRes;
	return $nbTotal;
} // getListeSejourSeminaires(&$listeRes)

//--------------------------
//DECOUVERTES TOURISTIQUES--
//--------------------------
function getListeSejourAccueilGroupe(&$listeRes, $_params = "")
{
	//INFOS : Nom centre - texte pr�sentation centre - image accueil de groupe

	$listeRes = array();
	$arrayChampSelect = array();
	$champSelect = "id_accueil_groupes_jeunes_adultes, libelle, ville, accueil_groupes_jeunes_adultes.visuel_1, centre.id_centre as id_centre , id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("accueil_groupes_jeunes_adultes", $champSelect);
		$arrayChampSelect = array("adresse", "code_postal", "ville", "site_internet", "email",
		"nb_lit", "nb_couvert", "nb_chambre",
		"nb_salle_reunion", "capacite_salle_min", "capacite_salle_max",
		"id_sejour_centre_adapte",
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude", //Onglet acc�s
		"id_centre_activite", "id_sejour_services_sportifs", "sports_adaptes_FFH_4", "trad_accueil_groupes_jeunes_adultes.sports_adaptes_FFH_libelle_multi",//Onglet Les activit�s
		"sejour_preparation", "accueil_groupes_jeunes_adultes.sejour_preparation_commentaire", "sejour_rentree", "accueil_groupes_jeunes_adultes.sejour_rentree_commentaire", "sejour_oxygenation", "accueil_groupes_jeunes_adultes.sejour_oxygenation_commentaire", "forfait_autre", "trad_accueil_groupes_jeunes_adultes.forfait_autre_commentaire_multi",
		"id_centre_detention_label");
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$sql = "SELECT _champ_select
					FROM accueil_groupes_jeunes_adultes
					INNER JOIN trad_accueil_groupes_jeunes_adultes ON (id_accueil_groupes_jeunes_adultes = id__accueil_groupes_jeunes_adultes AND trad_accueil_groupes_jeunes_adultes.id__langue = ".$_SESSION['ses_langue'].") 
					INNER JOIN centre on centre.id_centre = accueil_groupes_jeunes_adultes.id_centre";

	
	$where = "";
	if ($_params['accueil_sportif'] == true)
	{
		$where = " (piste_athetisme = 1
									OR piscine = 1
									OR terrains_exterieurs = 1
									OR terrains_couverts = 1
									OR dojos = 1
									OR courts_tennis = 1
									OR trad_accueil_groupes_jeunes_adultes.installations_autres_multi != '')";
	}

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//**CAPACITE D'ACCUEIL LITS
	if (isset($_params['capacite_lits']))
	{
		$min = "";
		$max = "";
		switch ($_params['capacite_lits'])
		{
			case _CONST_CENTRE_CAPACITE_LITS_100 :
				$max = 100;
				break;
			case _CONST_CENTRE_CAPACITE_LITS_100_150 :
				$min = 100;
				$max = 150;
				break;
			case  _CONST_CENTRE_CAPACITE_LITS_150_200 :
				$min = 150;
				$max = 200;
				break;
			case _CONST_CENTRE_CAPACITE_LITS_MORE_200 :
				$min = 200;
				break;
		}
		$where .= (($where == "") ? '(' : " AND (");

		if ($min != "")
		$where .= " nb_lit >= ".$min ;
		if ($max != "")
		$where .= (($min != "") ? ' AND ' : '')." nb_lit <= ".$max;

		$where .= ")";
	}

	//**DISCIPLINE SPORTIVE (athl�tisme, basket ...)
	if (isset($_params['id_centre_activite']))
	$where .= (($where == "")? '' : ' AND ')." id_centre_activite like '%".$_params['id_centre_activite']."%'";

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_accueil_groupes_jeunes_adultes =".$_params['id_sejour']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' accueil_groupes_jeunes_adultes.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", accueil_groupes_jeunes_adultes.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";
	
	//On r�cup�re le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );
	
	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		//echo '<br/>Query : '.$sql;


		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_accueil_groupes_jeunes_adultes");
			$description = getTradTable("centre",$_SESSION['ses_langue'],"presentation", mysql_result($rst,$i, "id_centre"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(mysql_result($rst, $i, "libelle"),"utf-8"),
			"nom_centre" => mb_strtoupper(mysql_result($rst, $i, "libelle"),"utf-8"),
			"description" => $description,
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "acceuil_groupes_jeunes_adultes")),
			"lien" => get_url_nav_sejour(($_params['accueil_sportif']) ? _NAV_ACCUEIL_SPORTIF : _NAV_ACCUEIL_GROUPE, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'acceuil_groupes_jeunes_adultes', $listeRes);

				//foreach ($arrayChampSelect as $champ)
				//$listeRes [$i][$champ] = mysql_result($rst, $i, $champ);
				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}
				$id_centre = mysql_result($rst,$i, "centre.id_centre");
				$listeRes [$i]["id_centre"] = $id_centre;

				//Onglet contact
				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet Les sites touristiques
				$listeRes [$i]["presentation_region"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation_region", $id_centre);

				//Onglet Les installations sportives
				if ($_params['accueil_sportif'])
				{
					$listeRes [$i]["commentaire_accueil_sportifs"] = getTradTable("accueil_groupes_jeunes_adultes",$_SESSION['ses_langue'],"commentaire_accueil_sportifs_multi", $id);
					//$listeRes [$i]["sports_adaptes_FFH_libelle"] = getTradTable("accueil_groupes_jeunes_adultes",$_SESSION['ses_langue'],"sports_adaptes_FFH_libelle_multi", $id);
				}

				//Onglet Tarifs
				$listeRes [$i]["haute_saison"] = getTradTable("accueil_groupes_jeunes_adultes",$_SESSION['ses_langue'],"haute_saison", $id);
				$listeRes [$i]["moyenne_saison"] = getTradTable("accueil_groupes_jeunes_adultes",$_SESSION['ses_langue'],"moyenne_saison", $id);
				$listeRes [$i]["basse_saison"] = getTradTable("accueil_groupes_jeunes_adultes",$_SESSION['ses_langue'],"basse_saison", $id);
				$listeRes [$i]["conditions_groupes"] = getTradTable("accueil_groupes_jeunes_adultes",$_SESSION['ses_langue'],"conditions_groupes", $id);

				//Onglet acc�s
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);

			}
		}
	}

	//return $nbRes;
	return $nbTotal;
} // getListeSejourAccueilGroupe(&$listeRes)

function getListeSejourTouristiquesGroupe(&$listeRes, $_params = "")
{
	//INFOS : Nom s�jour  - Ville - Descriptif sommaire du s�jour - Image s�jour

	$listeRes = array();
	$arrayChampSelect = array();

	$champSelect = "id_sejours_touristiques , libelle, ville, sejours_touristiques.visuel_1, centre.id_centre , id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("sejours_touristiques", $champSelect);
		$arrayChampSelect = array("adresse", "code_postal", "ville", "site_internet", "email",
		"adapte_IME_IMP_4",
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude",//Onglet acc�s
		"nb_chambre", "nb_couvert", "nb_lit", "id_centre_service", "id_centre_activite",//Onglet Lieu du s�jour
		"a_partir_de_prix", "nb_jours", "nb_nuits",
		"id_centre_detention_label");  //Onglet Tarif
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$sql = "SELECT _champ_select
					FROM sejours_touristiques
					INNER JOIN centre on centre.id_centre = sejours_touristiques.id_centre";

	$where = "";
	//**REGIONS
	if (isset($_params['id_centre_region']))
	$where = " id_centre_region = ".$_params['id_centre_region'];

	//**PERIODES (printemps- �t� - automne - hiver)
	if (isset($_params['id_sejour_periode_disponibilite']))
	getClauseWhere('id_sejour_periode_disponibilite', $_params['id_sejour_periode_disponibilite'], $where);

	//**DUREES ( week-end - semaine - plus d'une semaine)
	if (isset($_params['id_sejour_duree']))
	getClauseWhere('id_sejour_duree', $_params['id_sejour_duree'], $where);

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_sejours_touristiques =".$_params['id_sejour']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' sejours_touristiques.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", sejours_touristiques.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";


	//On r�cup�re le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_sejours_touristiques");
			$description = getTradTable("sejours_touristiques",$_SESSION['ses_langue'],"descriptif", mysql_result($rst,$i, "id_sejours_touristiques"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(getTradTable("sejours_touristiques",$_SESSION['ses_langue'],"nom_sejour", mysql_result($rst,$i, "id_sejours_touristiques")), "utf-8"),
			"nom_centre" => mysql_result($rst, $i, "libelle"),
			"id_centre" => mysql_result($rst, $i, "id_centre"),
			"description" => $description,
			"nb_jours" => mysql_result($rst, $i, "nb_jours"),
			"nb_nuits" => mysql_result($rst, $i, "nb_jours"),
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "sejours_touristiques")),
			"lien" => get_url_nav_sejour(_NAV_SEJOURS_TOURISTIQUES_GROUPE, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'sejours_touristiques', $listeRes);

				//foreach ($arrayChampSelect as $champ)
				//$listeRes [$i][$champ] = mysql_result($rst, $i, $champ);
				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}
				$id_centre = mysql_result($rst,$i, "centre.id_centre");

				//Onglet contact
				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet Le d�roulement du s�jour
				$listeRes [$i]["details"] = getTradTable("sejours_touristiques",$_SESSION['ses_langue'],"details", $id);

				//Onglet Lieu du s�jour
				$listeRes [$i]["presentation"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation", $id_centre);

				//Onglet Tarifs
				$listeRes [$i]["duree_sejour"] = getTradTable("sejours_touristiques",$_SESSION['ses_langue'],"duree_sejour", $id);
				$listeRes [$i]["prix_comprend"] = getTradTable("sejours_touristiques",$_SESSION['ses_langue'],"prix_comprend", $id);
				$listeRes [$i]["prix_ne_comprend_pas"] = getTradTable("sejours_touristiques",$_SESSION['ses_langue'],"prix_ne_comprend_pas", $id);


				//Onglet acc�s
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);

			}
		}
	}

	//return $nbRes;
	return $nbTotal;
} // getListeSejourTouristiquesGroupe(&$listeRes)

function getListeStagesThematiquesGroupe(&$listeRes, $_params = "")
{
	//INFOS : Nom stage  - Ville - Descriptif sommaire du stage - Image stage

	$listeRes = array();
	$arrayChampSelect = array();

	$champSelect = "id_stages_thematiques_groupes , libelle, ville, stages_thematiques_groupes.visuel_1, centre.id_centre , id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("stages_thematiques_groupes", $champSelect);
		$arrayChampSelect = array("adresse", "code_postal", "ville", "site_internet", "id_sejour_periode_disponibilite", "email",
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude",//Onglet acc�s
		"nb_chambre", "nb_couvert", "nb_lit", "id_centre_service", "id_centre_activite",//Onglet Lieu du s�jour
		"a_partir_de_prix", "nb_jours", "nb_nuits",
		"id_centre_detention_label"); //Onglet Tarif
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$sql = "SELECT _champ_select
					FROM stages_thematiques_groupes
					INNER JOIN centre on centre.id_centre = stages_thematiques_groupes.id_centre";

	$where = "";
	//**REGIONS
	if (isset($_params['id_centre_region']))
	$where = " id_centre_region = ".$_params['id_centre_region'];

	//**THEMATIQUE DE STAGE
	if (isset($_params['id_sejour_stage_theme']))
	$where .= (($where == "")? '' : ' AND ')." id_sejour_stage_theme = ".$_params['id_sejour_stage_theme'];

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_stages_thematiques_groupes =".$_params['id_sejour']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' stages_thematiques_groupes.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", stages_thematiques_groupes.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";


	//On r�cup�re le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_stages_thematiques_groupes");
			$description = getTradTable("stages_thematiques_groupes",$_SESSION['ses_langue'],"descriptif", mysql_result($rst,$i, "id_stages_thematiques_groupes"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(getTradTable("stages_thematiques_groupes",$_SESSION['ses_langue'],"nom_stage", mysql_result($rst,$i, "id_stages_thematiques_groupes")), "utf-8"),
			"nom_centre" => mysql_result($rst, $i, "libelle"),
			"id_centre" => mysql_result($rst, $i, "id_centre"),
			"description" => $description,
			"nb_jours" => mysql_result($rst, $i, "nb_jours"),
			"nb_nuits" => mysql_result($rst, $i, "nb_jours"),
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "stages_thematiques_groupes")),
			"lien" => get_url_nav_sejour(_NAV_STAGES_THEMATIQUES_GROUPE, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'stages_thematiques_groupes', $listeRes);

				//foreach ($arrayChampSelect as $champ)
				//$listeRes [$i][$champ] = mysql_result($rst, $i, $champ);
				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}

				$id_centre = mysql_result($rst,$i, "centre.id_centre");

				//Onglet contact
				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet D�roulement du stage
				$listeRes [$i]["description"] = getTradTable("stages_thematiques_groupes",$_SESSION['ses_langue'],"descriptif", $id);

				//Onglet Lieu du s�jour
				$listeRes [$i]["presentation"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation", $id_centre);

				//Onglet Tarifs
				$listeRes [$i]["duree_sejour"] = getTradTable("stages_thematiques_groupes",$_SESSION['ses_langue'],"duree_sejour", $id);
				$listeRes [$i]["prix_comprend"] = getTradTable("stages_thematiques_groupes",$_SESSION['ses_langue'],"prix_comprend", $id);
				$listeRes [$i]["prix_ne_comprend_pas"] = getTradTable("stages_thematiques_groupes",$_SESSION['ses_langue'],"prix_ne_comprend_pas", $id);

				//Onglet acc�s
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);

			}
		}
	}

	//return $nbRes;
	return $nbTotal;
} // getListeStagesThematiquesGroupe(&$listeRes)

function getListeAcceuilIndividuels(&$listeRes, $_params = "")
{
	//INFOS : Nom centre - Ville - texte pr�sentation centre - image accueil

	$listeRes = array();
	$arrayChampSelect = array();
	$champSelect = "id_accueil_individuels_familles, libelle, ville, accueil_individuels_familles.visuel_1, centre.id_centre as id_centre , id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("accueil_individuels_familles", $champSelect);
		$arrayChampSelect = array("adresse", "code_postal", "ville", "site_internet", "email",
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude",//Onglet acc�s
		"id_centre_activite",//Onglet activit�s et �quipements
		"id_sejour_services_familles_bebes", "id_sejour_services_familles_enfants",
		"id_centre_detention_label"); //Onglet sp�cial famille
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$sql = "SELECT _champ_select
					FROM accueil_individuels_familles
					INNER JOIN centre on centre.id_centre = accueil_individuels_familles.id_centre";


	$where = "";
	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_accueil_individuels_familles =".$_params['id_sejour']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' accueil_individuels_familles.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", accueil_individuels_familles.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";

	//On r�cup�re le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_accueil_individuels_familles");
			$description = getTradTable("centre",$_SESSION['ses_langue'],"presentation", mysql_result($rst,$i, "id_centre"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(mysql_result($rst, $i, "libelle"),"utf-8"),
			"nom_centre" => mb_strtoupper(mysql_result($rst, $i, "libelle"),"utf-8"),
			"description" => $description,
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "accueil_individuels_familles")),
			"lien" => get_url_nav_sejour(_NAV_ACCUEIL_INDIVIDUEL, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'accueil_individuels_familles', $listeRes);

				//foreach ($arrayChampSelect as $champ)
				//$listeRes [$i][$champ] = mysql_result($rst, $i, $champ);
				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}

				$id_centre = mysql_result($rst,$i, "centre.id_centre");
				$listeRes [$i]["id_centre"] = $id_centre;

				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet Les sites touristiques
				$listeRes [$i]["presentation_region"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation_region", $id_centre);


				//**Onglet tarif
				$listeRes [$i]["haute_saison"] = getTradTable("accueil_individuels_familles",$_SESSION['ses_langue'],"haute_saison", $id);
				$listeRes [$i]["moyenne_saison"] = getTradTable("accueil_individuels_familles",$_SESSION['ses_langue'],"moyenne_saison", $id);
				$listeRes [$i]["basse_saison"] = getTradTable("accueil_individuels_familles",$_SESSION['ses_langue'],"basse_saison", $id);
				$listeRes [$i]["conditions_famille"] = getTradTable("accueil_individuels_familles",$_SESSION['ses_langue'],"conditions", $id);

				//Onglet acc�s
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);

			}
		}
	}

	//return $nbRes;
	return $nbTotal;
} // getListeAcceuilIndividuels(&$listeRes)

function getListeShortBreak(&$listeRes, $_params = "")
{
	//INFOS : Nom SB - Ville - texte pr�sentation SB - image short break
	$listeRes = array();
	$arrayChampSelect = array();
	$champSelect = "id_short_breaks, libelle, ville, short_breaks.visuel_1, centre.id_centre as id_centre , id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("short_breaks", $champSelect);
		$arrayChampSelect = array("adresse", "code_postal", "ville", "site_internet", "email",
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude",//Onglet acc�s
		"nb_chambre", "nb_couvert", "nb_lit", "id_centre_service", "id_centre_activite",//Onglet Lieu du s�jour
		"a_partir_de_prix", "nb_jours", "nb_nuits",
		"id_centre_detention_label"); //Onglet Tarif
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$sql = "SELECT _champ_select
					FROM short_breaks
					INNER JOIN centre on centre.id_centre = short_breaks.id_centre";

	$where = "";
	//**REGIONS
	if (isset($_params['id_centre_region']))
	$where = " id_centre_region = ".$_params['id_centre_region'];

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//**THEME DE SHORT BREAK
	if (isset($_params['id_sejour_short_break_theme']))
	$where .= (($where == "")? '' : ' AND ')." id_sejour_short_break_theme = ".$_params['id_sejour_short_break_theme'];

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_short_breaks =".$_params['id_sejour']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' short_breaks.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';
	
	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", short_breaks.id__langue)>0';
	// RPL

	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";

	//On recupere le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_short_breaks");
			$description = getTradTable("short_breaks",$_SESSION['ses_langue'],"descriptif", $id);
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(getTradTable("short_breaks",$_SESSION['ses_langue'],"nom", $id), "utf-8"), //Nom du SB
			"nom_centre" => mysql_result($rst, $i, "libelle"), //Nom du centre
			"id_centre" => mysql_result($rst, $i, "id_centre"),
			"description" => $description,
			"nb_jours" => mysql_result($rst, $i, "nb_jours"),
			"nb_nuits" => mysql_result($rst, $i, "nb_jours"),
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "short_breaks")),
			"lien" => get_url_nav_sejour(_NAV_SHORT_BREAK, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'short_breaks', $listeRes);

				//foreach ($arrayChampSelect as $champ)
				//$listeRes [$i][$champ] = mysql_result($rst, $i, $champ);
				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}

				$id_centre = mysql_result($rst,$i, "centre.id_centre");

				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet Lieu du sejour
				$listeRes [$i]["presentation"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation", $id_centre);

				//Onglet Tarifs
				$listeRes [$i]["duree_sejour"] = getTradTable("short_breaks",$_SESSION['ses_langue'],"duree_sejour", $id);
				$listeRes [$i]["prix_comprend"] = getTradTable("short_breaks",$_SESSION['ses_langue'],"prix_comprend", $id);
				$listeRes [$i]["prix_ne_comprend_pas"] = getTradTable("short_breaks",$_SESSION['ses_langue'],"prix_ne_comprend_pas", $id);


				//Onglet acces
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);

			}

		}
	}

	//return $nbRes;
	return $nbTotal;
} // getListeShortBreak(&$listeRes)

function getListeStagesThematiquesIndividuels(&$listeRes, $_params = "")
{
	//INFOS : Nom stage  - Ville - Descriptif sommaire du stage - Image stage

	$listeRes = array();
	$arrayChampSelect = array();
	$champSelect = "id_stages_thematiques_individuels , libelle, ville, stages_thematiques_individuels.visuel_1, centre.id_centre , id_centre_region";
	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	{
		getSelectImages ("stages_thematiques_individuels", $champSelect);
		$arrayChampSelect = array("adresse", "code_postal", "ville", "site_internet", "id_sejour_periode_disponibilite", "email",
		"acces_route_4", "acces_train_4", "acces_avion_4", "acces_bus_metro_4", "latitude", "longitude",//Onglet acc�s
		"nb_chambre", "nb_couvert", "nb_lit", "id_centre_service", "id_centre_activite",//Onglet Lieu du s�jour
		"a_partir_de_prix", "nb_jours", "nb_nuits",
		"id_centre_detention_label"); //Onglet Tarif
		foreach ($arrayChampSelect as $champ)
		$champSelect .= " ,".$champ;
	}

	$sql = "SELECT _champ_select
					FROM stages_thematiques_individuels
					INNER JOIN centre on centre.id_centre = stages_thematiques_individuels.id_centre";

	$where = "";
	//**REGIONS
	if (isset($_params['id_centre_region']))
	$where = " id_centre_region = ".$_params['id_centre_region'];

	//**THEMATIQUE DE STAGE
	if (isset($_params['id_sejour_stage_theme']))
	$where .= (($where == "")? '' : ' AND ')." id_sejour_stage_theme = ".$_params['id_sejour_stage_theme'];

	//**PERIODES (printemps- �t� - automne - hiver)
	if (isset($_params['id_sejour_periode_disponibilite']))
	getClauseWhere('id_sejour_periode_disponibilite', $_params['id_sejour_periode_disponibilite'], $where);

	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//** FICHE SEJOUR
	if (isset($_params['id_sejour']))
	$where .= (($where == "")? '' : ' AND ')." id_stages_thematiques_individuels =".$_params['id_sejour']." ";

	//** FICHE CENTRE
	if (isset($_params['id_centre']))
	$where .= (($where == "")? '' : ' AND ')." centre.id_centre =".$_params['id_centre']." ";

	//** ACTIF
	$where .= (($where == "")? '' : ' AND ').' stages_thematiques_individuels.etat = 1';
	$where .= (($where == "")? '' : ' AND ').' centre.etat = 1';

	// RPL - 26/05/2011 : gestion affichage par langue
	$where .= (($where == "")? '' : ' AND ').' FIND_IN_SET("'.$_SESSION['ses_langue'].'", stages_thematiques_individuels.id__langue)>0';
	// RPL
	
	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " ORDER BY RAND(".getRandOrderBy().")";

	//On r�cup�re le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "count(*) as nb", $sql) );
	$nbTotal = mysql_result ( $rst, 0, "nb" );

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);
		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$id = mysql_result($rst,$i, "id_stages_thematiques_individuels");
			$description = getTradTable("stages_thematiques_individuels",$_SESSION['ses_langue'],"descriptif", mysql_result($rst,$i, "id_stages_thematiques_individuels"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide

			if (!isset($_params['id_sejour']) && strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
			$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

			getListeRegions($region, array('id' => mysql_result($rst,$i, "id_centre_region")));
			$region = $region[0]['libelle'];

			$listeRes [] = array (	"id" => $id,
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"libelle" => mb_strtoupper(getTradTable("stages_thematiques_individuels",$_SESSION['ses_langue'],"nom", mysql_result($rst,$i, "id_stages_thematiques_individuels")), "utf-8"),
			"nom_centre" => mysql_result($rst, $i, "libelle"),
			"id_centre" => mysql_result($rst, $i, "id_centre"),
			"description" => $description,
			"nb_jours" => mysql_result($rst, $i, "nb_jours"),
			"nb_nuits" => mysql_result($rst, $i, "nb_jours"),
			"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel_1"), "stages_thematiques_individuels")),
			"lien" => get_url_nav_sejour(_NAV_STAGES_THEMATIQUES_INDIVIDUEL, $id),
			"region" => stripAccents((strtolower(str_replace("'", '_',str_replace('-', '_',(str_replace(' ', '_',utf8_decode($region)))))))));

			//** FICHE SEJOUR
			if (isset($_params['id_sejour']))
			{
				getRstImages($rst, $i, 'stages_thematiques_individuels', $listeRes);
				//foreach ($arrayChampSelect as $champ)
				//$listeRes [$i][$champ] = mysql_result($rst, $i, $champ);
				foreach ($arrayChampSelect as $champ){
					if($champ == "site_internet"){
						if(!eregi("http://",mysql_result($rst, $i, $champ))){
							$val = "http://".mysql_result($rst, $i, $champ);
						}else{
							$val = mysql_result($rst, $i, $champ);
						}
					}else{
						$val = mysql_result($rst, $i, $champ);
					}
					$listeRes [$i][$champ] = $val;
				}
				$id_centre = mysql_result($rst,$i, "centre.id_centre");

				$listeRes [$i]["telephone"] = getTradTable("centre",$_SESSION['ses_langue'],"telephone", $id_centre);
				$listeRes [$i]["fax"] = getTradTable("centre",$_SESSION['ses_langue'],"fax", $id_centre);

				//Onglet D�roulement du stage
				$listeRes [$i]["description"] = getTradTable("stages_thematiques_individuels",$_SESSION['ses_langue'],"descriptif", $id);

				//Onglet Lieu du s�jour
				$listeRes [$i]["presentation"] = getTradTable("centre",$_SESSION['ses_langue'],"presentation", $id_centre);

				//Onglet Tarifs
				$listeRes [$i]["duree_sejour"] = getTradTable("stages_thematiques_individuels",$_SESSION['ses_langue'],"duree_sejour", $id);
				$listeRes [$i]["prix_comprend"] = getTradTable("stages_thematiques_individuels",$_SESSION['ses_langue'],"prix_comprend", $id);
				$listeRes [$i]["prix_ne_comprend_pas"] = getTradTable("stages_thematiques_individuels",$_SESSION['ses_langue'],"prix_ne_comprend_pas", $id);


				//Onglet acc�s
				$listeRes [$i]["acces_route_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_route_texte", $id_centre);
				$listeRes [$i]["acces_train_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_train_texte", $id_centre);
				$listeRes [$i]["acces_avion_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_avion_texte", $id_centre);
				$listeRes [$i]["acces_bus_metro_texte"] = getTradTable("centre",$_SESSION['ses_langue'],"acces_bus_metro_texte", $id_centre);


			}

		}
	}

	//return $nbRes;
	return $nbTotal;
} // getListeStagesThematiquesIndividuels(&$listeRes)

//*************************************************************
//					FONCTIONS FICHE SEJOURS
//*************************************************************

function getSejourPlus($Rub, $idSejour, &$listePlus)
{
	$listePlus = array();
	$sql = "SELECT id_sejour_les_plus FROM sejour_les_plus WHERE IdSejour =".$idSejour." AND id__table_def = ".$GLOBALS["_NAV_SEJOUR_TABLEDEF"][$Rub]." ORDER BY ordre ASC";

	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$nbRes = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nbRes ; $i++)
	$listePlus[] = getTradTable('sejour_les_plus', $_SESSION['ses_langue'], 'libelle', mysql_result($rst, $i, 'id_sejour_les_plus'));

	return $nbRes;

} // getSejourPlus()

function getSport($Rub, $idSejour, &$listeSport)
{
	$listeSport = array();
	$sql = "SELECT
				id_sejour_centre_adapte 
			FROM 
				accueil_groupes_jeunes_adultes 
			WHERE 
				id_accueil_groupes_jeunes_adultes =".$idSejour;

	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$tab = explode(",",mysql_result($rst, 0, 'id_sejour_centre_adapte'));
	$nbRes = 0;
	foreach($tab as $val){
		if($val>0){
			$nbRes++;
			$listeSport[] = getTradTable('sejour_centre_adapte', $_SESSION['ses_langue'], 'libelle', $val);
		}
	}
	return $nbRes;
} // getSejourPlus()

function getSejourMateriel($table, $idSejour, &$listeMateriel){
	$listeDateA = array();
	$sql = "select id_sejour_materiel_service from $table where id_$table = ".$idSejour;
	$result = mysql_query($sql);

	$liste = mysql_result($result,0,'id_sejour_materiel_service');
	$tab = explode(",",$liste);
	foreach($tab as $val){
		$sql_S = "select libelle from trad_sejour_materiel_service where id__sejour_materiel_service = ".$val." and id__langue=".$_SESSION["ses_langue"];
		$result_S  = mysql_query($sql_S );
		$listeMateriel[]["libelle"] = mysql_result($result_S,0,'libelle');
	}
}



function getSejourDateAccessible($Rub, $idSejour, &$listeDateA)
{
	$listeDateA = array();
	$sql = "SELECT DATE_FORMAT(`date`, '%d/%m/%Y') AS `date`, DATE_FORMAT(`date_fin`, '%d/%m/%Y') AS `date_fin` FROM sejour_date_accessible WHERE IdSejour =".$idSejour." AND id__table_def = ".$GLOBALS["_NAV_SEJOUR_TABLEDEF"][$Rub]." ORDER BY date ASC";

	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$nbRes = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nbRes ; $i++)
	{
		$listeDateA[] = array( "date_debut" => mysql_result($rst, $i, 'date'),
		"date_fin" => mysql_result($rst, $i, 'date_fin'));
	}

	return $nbRes;

} // getSejourDateAccessible($Rub, $idSejour, &$listeDateA)

function getSejourLoisirDispo($Rub, $idSejour, &$listeLoisir)
{
	$listeLoisir = array();
	$sql = "SELECT id_sejour_loisirs_dispo, prix FROM sejour_loisirs_dispo WHERE IdSejour =".$idSejour." AND id__table_def = ".$GLOBALS["_NAV_SEJOUR_TABLEDEF"][$Rub]." ORDER BY ordre ASC";

	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$nbRes = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nbRes ; $i++)
	{
		$listeLoisir[] = array( "libelle" => getTradTable('sejour_loisirs_dispo', $_SESSION['ses_langue'], 'libelle', mysql_result($rst, $i, 'id_sejour_loisirs_dispo')),
		"prix" => mysql_result($rst, $i, 'prix'),
		"commentaire" => getTradTable('sejour_loisirs_dispo', $_SESSION['ses_langue'], 'commentaire', mysql_result($rst, $i, 'id_sejour_loisirs_dispo')) );
	}

	return $nbRes;

} // getSejourLoisirDispo($Rub, $idSejour, &$listeLoisir)

//Accueil de r�union
function getSejourReunionInfos ($Rub, $idSejour, $type, &$listeInfo)
{
	if ($type == 'repas' || $type == 'pause' || $type == 'cocktail')
	$type = 'restauration_'.$type;

	$listeInfo = array();
	$sql = "SELECT id_sejour_".$type.", tarif FROM sejour_".$type." WHERE IdSejour =".$idSejour." AND id__table_def = ".$GLOBALS["_NAV_SEJOUR_TABLEDEF"][$Rub];

	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$nbRes = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nbRes ; $i++)
	{
		$listeInfo[] = array( "libelle" => getTradTable('sejour_'.$type, $_SESSION['ses_langue'], 'nom_formule', mysql_result($rst, $i, 'id_sejour_'.$type)),
		"prix" => mysql_result($rst, $i, 'tarif'),
		"commentaire" => getTradTable('sejour_'.$type, $_SESSION['ses_langue'], 'detail_prestation', mysql_result($rst, $i, 'id_sejour_'.$type)) );
	}

	return $nbRes;
} // getSejourReunionInfos ($Rub, $idSejour, $type, &$listeRestauration)

function getSejourSalleReunion ($Rub, $idSejour, &$listeSalle)
{
	$listeSalle = array();
	$sql = "SELECT * FROM sejour_salle_acceuil_reunion WHERE IdSejour =".$idSejour." AND id__table_def = ".$GLOBALS["_NAV_SEJOUR_TABLEDEF"][$Rub]." ORDER BY ordre ASC";

	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$sql_S = "SELECT commentaires_salles FROM trad_accueil_reunions WHERE id__accueil_reunions=$idSejour AND id__langue=".$_SESSION["ses_langue"];
	$rst_S = mysql_query($sql_S);
	$nbRes = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nbRes ; $i++)
	{
		$listeSalle[] = array( "libelle" => mysql_result($rst, $i, 'nom_salle'),
		"commentaires_salles" => mysql_result($rst_S, 0, 'commentaires_salles'),
		"prix_demi_journee" => mysql_result($rst, $i, 'tarif_demi_journee'),
		"prix_journee" => mysql_result($rst, $i, 'tarif_journee'),
		"prix_soiree" => mysql_result($rst, $i, 'tarif_soiree'),
		"taille" => mysql_result($rst, $i, 'taille'),
		"tour_table" => mysql_result($rst, $i, 'tour_table'),
		"conference" => mysql_result($rst, $i, 'conference'),
		"classe" => mysql_result($rst, $i, 'classe'),
		"tableau_blanc" => getSalleEquipementTrad(mysql_result($rst, $i, 'tableau_blanc_28')),
		"sonorisation" => getSalleEquipementTrad(mysql_result($rst, $i, 'sonorisation_28')),
		"paperboard" => getSalleEquipementTrad(mysql_result($rst, $i, 'paperboard_28')),
		"ecran" => getSalleEquipementTrad(mysql_result($rst, $i, 'ecran_28')),
		"climatisation" => getSalleEquipementTrad(mysql_result($rst, $i, 'climatisation_28')),
		"wifi_adsl" => getSalleEquipementTrad(mysql_result($rst, $i, 'wifi_adsl_28')));
	}

	return $nbRes;
} // getSejourSalleReunion ($Rub, $idSejour, &$listeSalle)

function getSalleEquipementTrad($code){
	if($code=="Oui")
		return get_libLocal("lib_reu_oui");
	elseif($code=="Non")
		return get_libLocal("lib_reu_non");
	else 	
		return get_libLocal("lib_reu_en_option");
}

function getSejourTarifGroupe($Rub, $idSejour, &$listeTarif)
{
	$listeTarif = array();
	$sql = "SELECT * FROM sejour_tarif_groupe WHERE IdSejour =".$idSejour." AND id__table_def = ".$GLOBALS["_NAV_SEJOUR_TABLEDEF"][$Rub];

	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$arraySaison = array("HS", "MS", "BS");
	$arrayPension = array("bb", "dp", "pc", "rs");

	$nbRes = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nbRes ; $i++)
	{
		foreach ($arraySaison as $saison)
		{
			foreach ($arrayPension as $pension)
			$listeTarif[$saison."_".$pension] = mysql_result($rst, $i, $saison."_".$pension) ;
		}
	}

	return $nbRes;
} // getSejourTarifGroupe($Rub, $idSejour, &$listeTarif)


function getSejourTarifGroupePlus1($Rub, $idSejour, &$listeTarif)
{
	$listeTarif = array();
	$sql = "SELECT * FROM sejour_tarif_groupe_plus WHERE IdSejour =".$idSejour." AND id__table_def = ".$GLOBALS["_NAV_SEJOUR_TABLEDEF"][$Rub];

	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$arraySaison = array("HS", "MS", "BS");
	$arrayPension = array("bb", "dp", "pc", "rs");

	$nbRes = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nbRes ; $i++)
	{
		foreach ($arraySaison as $saison)
		{
			foreach ($arrayPension as $pension)
			$listeTarif[$saison."_".$pension] = mysql_result($rst, $i, $saison."_".$pension) ;
		}
	}

	return $nbRes;
} // getSejourTarifGroupePlus1($Rub, $idSejour, &$listeTarif)


function getListeOrganisateurCVL(&$Organisateur)
{
	$Organisateur = array();

	$sqlCentre = "SELECT id_centre FROM centre WHERE etat = 1";
	$rstCentre = mysql_query($sqlCentre);

	$nbCentre = mysql_num_rows($rstCentre);

	$listeCentre = array();
	for ($i = 0 ; $i < $nbCentre ; $i++)
	{
		$listeCentre[] = mysql_result($rstCentre, $i, 'id_centre');
	}


	$champSelect = 'id_organisateur_cvl, presentation_organisme, visuel';
	$sql = "SELECT _champ_select
			FROM organisateur_cvl 
			WHERE ";

	foreach ( $listeCentre as $index => $centre)
	{
		if ($index != 0)
		$sql .= ' OR ';
		$sql .= get_multi_fullkit_choice('id_centre',$centre);
	}

	//On r�cup�re le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "id_organisateur_cvl", $sql) );

	if (!$rst)
	echo mysql_error(). " - ".$sql;

	$nbTotal = mysql_num_rows($rst);

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;


		$rst = mysql_query($sql);
		if (!$rst)
		echo mysql_error(). ' - '.$sql;

		$nbRes = mysql_num_rows($rst);
		if ($nbRes > 0)
		{
			for ($i = 0 ; $i < $nbRes ; $i++)
			{
				$description = getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'presentation_organisme', mysql_result($rst, $i, 'id_organisateur_cvl'));
				if (strlen($description) > _NB_DESCRIPTION_MAX_CARACT)
				$description = coupe_espace(strip_tags($description,"<br>,<br />"),_NB_DESCRIPTION_MAX_CARACT);

				
				if($description != ''){
					$Organisateur[] = array( "ville" => mb_strtoupper(getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'libelle', mysql_result($rst, $i, 'id_organisateur_cvl'), 'utf-8')),
					"description" => $description,
					"image" => verif_visuel_1(getFileFromBDD(mysql_result($rst, $i, "visuel"), "organisateur_cvl")),
					"lien" => get_url_nav_organisateur_cvl(_NAV_FICHE_ORGANISATEUR_CVL, mysql_result($rst, $i, 'id_organisateur_cvl')) );
				}
			}
		}
		
		$nbTotal = count($Organisateur);
		
		
		
		
	}

	return $nbTotal;
}

function getOrganisateurCVL($idCentre, &$Organisateur)
{
	$Organisateur = array();

	$sql = "SELECT id_organisateur_cvl, presentation_organisme FROM organisateur_cvl where ".get_multi_fullkit_choice('id_centre', $idCentre);

	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$nbRes = mysql_num_rows($rst);
	if ($nbRes == 1)
	{
		$Organisateur = array( "libelle" => getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'libelle', mysql_result($rst, 0, 'id_organisateur_cvl')),
		"presentation" => getTradTable('organisateur_cvl', $_SESSION['ses_langue'], 'presentation_organisme', mysql_result($rst, 0, 'id_organisateur_cvl')),
		"lien" => get_url_nav_organisateur_cvl(_NAV_FICHE_ORGANISATEUR_CVL, mysql_result($rst, 0, 'id_organisateur_cvl')));
	}

	return $nbRes;
}

function getListeCentreEquipement(&$liste, $_params = "")
{
	$liste = array();

	$arrayEquipement = array ('aerodrome', 'centre_equestre', 'centre_nautique', 'salle_sport', 'terrain_jeux', 'parcours_sante',
	'sauna', 'terrain_boule', 'gymnase', 'raquette', 'arc', 'escalade', 'patinoire', 'pingpong', 'musculation', 'stade', 'tennis',
	'sentier', 'swingolf', 'velodrome', 'practice', 'golf', 'dojo');

	$arrayEquipementType = array('surplace', 'proche', 'distance');
	//boleen - boll�en - float

	$sql = "SELECT ";
	$first = true;
	foreach ($arrayEquipement as $equipement)
	{
		foreach ($arrayEquipementType as $type)
		{
			if ($first)
			$first = false;
			else
			$sql .= ',';
			$sql .= $equipement.'_'.$type;
		}
	}

	$sql .= " FROM centre";

	if (isset($_params['id_centre']))
	$sql .= " WHERE id_centre IN (".implode(',',$_params['id_centre']).")";


	$rst = mysql_query($sql);
	if (!$rst)
	echo mysql_error(). ' - '.$sql;

	$nbRes = mysql_num_rows($rst);
	if ($nbRes > 0)
	{
		foreach ($arrayEquipement as $equipement)
		{
			foreach ($arrayEquipementType as $type)
			{
				$liste[$equipement][$type] = mysql_result($rst, 0, $equipement.'_'.$type) ;
			}
		}
	}

	return $nbRes;
}

function getListeNewsletter(&$listeNewsletter)
{
	$sql = "SELECT libelle,id__types_newsletter FROM trad_types_newsletter WHERE id__langue=".$_SESSION["ses_langue"];
  $result = mysql_query($sql);
  
  while($myrow = mysql_fetch_array($result)){
    $listeNewsletter[] = array (	"id"        =>  $myrow["id__types_newsletter"],
		                              "libelle"   => 	$myrow["libelle"]);
  }

}


function getListeCivilite(&$listeCivilite)
{
	$sql .= " SELECT 		id_civilite as id
				  	FROM 			civilite 
						ORDER BY 	id_civilite ASC";
	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);

	while($row = mysql_fetch_object($rst))
	{
		$listeCivilite[] = array (	"id" =>  			$row->id,
		"libelle" => 	getTradTable("civilite",$_SESSION['ses_langue'],"libelle", $row->id));
	}

	return $nb;
} // getListeCivilite(&$listeCivilite)

function getListePays(&$listePays)
{
	$sql .= " SELECT 		id_pays as id, defaut
				  	FROM 			pays 
						ORDER BY 	id_pays ASC";
	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);

	while($row = mysql_fetch_object($rst))
	{
		$listePays[] = array (	"id" =>  			$row->id,
		"libelle" => 	getTradTable("pays",$_SESSION['ses_langue'],"libelle", $row->id),
		"selected" => $row->defaut);
	}

	return $nb;
} // getListePays(&$listePays)

function getListeEtablissementType(&$listeEtablissementType)
{
	$sql .= " SELECT 		id_etablissement_type as id
				  	FROM 			etablissement_type 
						ORDER BY 	id_etablissement_type ASC";
	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);

	while($row = mysql_fetch_object($rst))
	{
		$listeEtablissementType[] = array (	"id" =>  			$row->id,
		"libelle" => 	getTradTable("etablissement_type",$_SESSION['ses_langue'],"libelle", $row->id));
	}

	return $nb;
} // getListeCentreContactType(&$listeContactType, $_params = "")

function getListeDiscipline(&$listeDiscipline)
{
	$sql .= " SELECT 		id_discipline_sportive as id
				  	FROM 			discipline_sportive 
						ORDER BY 	id_discipline_sportive ASC";
	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);

	while($row = mysql_fetch_object($rst))
	{
		$listeDiscipline[] = array (	"id" =>  			$row->id,
		"libelle" => 	getTradTable("discipline_sportive",$_SESSION['ses_langue'],"libelle", $row->id));
	}

	return $nb;
} // getListeDiscipline(&$listeDiscipline)

function getListeCentreGP(&$listeCentre, $_params = "")
{
	$listeCentre = array();
	$champSelect = "centre_region.libelle as region,
					c.id_centre, 
					c.libelle, 
					c.adresse, 
					c.code_postal, 
					c.ville, 
					t.telephone, 
					t.fax, 
					c.email, 
					c.latitude, 
					c.longitude, 
					c.acces_route_4, 
					t.acces_route_texte, 
					c.acces_train_4, 
					t.acces_train_texte, 
					c.acces_avion_4, 
					t.acces_avion_texte, 
					c.acces_bus_metro_4, 
					t.acces_bus_metro_texte,
					c.logo,
					c.url_hostelworld,
					c.site_internet,
	c.visuel_1, c.visuel_2, c.visuel_3, c.visuel_4, c.visuel_5
	, c.visuel_6, c.visuel_7, c.visuel_8, c.visuel_9, c.visuel_10, c.nb_chambre, c.nb_lit, c.nb_couvert, 
	c.presentation_region, id_centre_detention_label, id_centre_classement, id_centre_classement_1";
	$sql = "SELECT _champ_select
					FROM centre c 
					inner join centre_region on (centre_region.id_centre_region = c.id_centre_region)
					inner join trad_centre t on (c.id_centre = t.id__centre and t.id__langue=".$_SESSION["ses_langue"].")";

	//**VOUS VENEZ PLUTOT : SEUL OU EN FAMILLE
	if (isset($_params['individuel']))
	$sql .= " INNER JOIN accueil_individuels_familles ac on ac.id_centre = c.id_centre ";

	//**VOUS VENEZ PLUTOT : EN GRUOPE
	if (isset($_params['groupe']))
	{
		$sql .= " INNER JOIN accueil_groupes_jeunes_adultes agj on agj.id_centre = c.id_centre ";
		$sql .= " INNER JOIN accueil_groupes_scolaires ags on ags.id_centre = c.id_centre ";
	}
	//**ENVIRONNEMENT ( mer - montagne - campagne - ville )
	if (isset($_params['id_centre_environnement']))
	getClauseWhere('id_centre_environnement', $_params['id_centre_environnement'], $where);

	//**Centre particulier
	if (isset($_params['id_centre']))
	{
		$where .= "id_centre IN (".implode(',',$_params['id_centre']).") AND trad_centre.id__langue=".$_SESSION['ses_langue'];
		$sql .= " INNER JOIN trad_centre on (c.id_centre = trad_centre.id__centre )";
	}

	if ($where != "")
	$sql .= " WHERE ".$where;

	$sql .= " GROUP BY c.id_centre ORDER BY RAND(".getRandOrderBy().")";


	//On r�cup�re le nombre total
	$rst = mysql_query ( str_replace("_champ_select", "c.id_centre", $sql) );

	if (!$rst)
	echo mysql_error(). " - ".$sql;

	$nbTotal = mysql_num_rows($rst);

	if ($nbTotal > 0)
	{
		$sql = str_replace("_champ_select", $champSelect, $sql);
		//On fait la requ�te pour r�cup�rer uniquement le nombre d'�l�ments dont nous avons besoin
		if (!isset($_params['disableLimit']))
		$sql .= " LIMIT " . getStartLimit($nbTotal) . "," . _NB_ENR_PAGE_RES;

		//echo '<br/>Query : '.$sql;

		$rst = mysql_query($sql);

		if (!$rst)
		echo mysql_error(). " - ".$sql;

		$nbRes = mysql_num_rows($rst);

		if($visuel_1=mysql_result($rst, $i, "visuel_1")) $aImage[] = verif_visuel_1(getFileFromBDD($visuel_1, "centre"));
		if($visuel_2=mysql_result($rst, $i, "visuel_2")) $aImage[] = getFileFromBDD($visuel_2, "centre");
		if($visuel_3=mysql_result($rst, $i, "visuel_3")) $aImage[] = getFileFromBDD($visuel_3, "centre");
		if($visuel_4=mysql_result($rst, $i, "visuel_4")) $aImage[] = getFileFromBDD($visuel_4, "centre");
		if($visuel_5=mysql_result($rst, $i, "visuel_5")) $aImage[] = getFileFromBDD($visuel_5, "centre");
		if($visuel_6=mysql_result($rst, $i, "visuel_6")) $aImage[] = getFileFromBDD($visuel_6, "centre");
		if($visuel_7=mysql_result($rst, $i, "visuel_7")) $aImage[] = getFileFromBDD($visuel_7, "centre");
		if($visuel_8=mysql_result($rst, $i, "visuel_8")) $aImage[] = getFileFromBDD($visuel_8, "centre");
		if($visuel_9=mysql_result($rst, $i, "visuel_9")) $aImage[] = getFileFromBDD($visuel_9, "centre");
		if($visuel_10=mysql_result($rst, $i, "visuel_10")) $aImage[] = getFileFromBDD($visuel_10, "centre");

		for ($i = 0 ; $i < $nbRes ; $i++)
		{
			$description = getTradTable("centre",$_SESSION['ses_langue'],"presentation", mysql_result($rst,$i, "id_centre"));
			$description = ($description == "") ? '&nbsp;' : $description; //Pour �viter de "casser" la liste si la description est vide
			$iIdCentre = mysql_result($rst,$i, "id_centre");


			$logo = getFileFromBDD(mysql_result($rst, $i, "logo"),"centre");
			if($logo==""){
				//$logo = "images/dyn/visu_sejour_defaut.jpg";
				$logo = "images/dyn/logo_";
				$logo .= trim(mb_strtolower(mysql_result($rst, $i, "ville"),'utf-8')).'.png';
				$logo = str_replace("-","_",$logo);
				$logo = str_replace(" ","_",$logo);
				$logo = str_replace("'","_",$logo);

				if (!file_exists($logo))
				$logo = "images/dyn/visu_sejour_defaut.jpg";
			}

			$region = get_no_accent_from_text_utf8( mysql_result($rst, $i, "region"));
			$region = mb_strtolower($region,"utf-8");
			$region = str_replace("-","_",$region);
			$region = str_replace(" ","_",$region);
			$region = str_replace("'","_",$region);
			$picto_region =_CONST_APPLI_URL."images/maps/carte_verte_france_".$region.".png";

			if(!eregi("http://",mysql_result($rst, $i, "site_internet"))){
				$siteInternet="http://".mysql_result($rst, $i, "site_internet");
			}else{
				$siteInternet = mysql_result($rst, $i, "site_internet");
			}
			$listeCentre [] = array (	"id" => $iIdCentre,
			"picto_region" => $picto_region ,
			"region" => mysql_result($rst, $i, "region"),
			"libelle" => mb_strtoupper(mysql_result($rst, $i, "libelle"),"utf-8"),
			"adresse" => mysql_result($rst, $i, "adresse"),
			"code_postal" => mysql_result($rst, $i, "code_postal"),
			"ville" => mb_strtoupper(mysql_result($rst, $i, "ville"), "utf-8"),
			"telephone" => mysql_result($rst, $i, "telephone"),
			"fax" => mysql_result($rst, $i, "fax"),
			"email" => mysql_result($rst, $i, "email"),
			"site_internet" => $siteInternet,
			"description" => $description,
			"image" => $aImage,
			"url_hostelworld" => mysql_result($rst, $i, "url_hostelworld"),
			"nb_chambre" => mysql_result($rst, $i, "nb_chambre"),
			"nb_lit" => mysql_result($rst, $i, "nb_lit"),
			"nb_couvert" => mysql_result($rst, $i, "nb_couvert"),
			"presentation_region" => getTradTable("centre",$_SESSION['ses_langue'],"presentation_region", $iIdCentre),
			"latitude" => mysql_result($rst, $i, "latitude"),
			"longitude" => mysql_result($rst, $i, "longitude"),
			"acces_route_4" => mysql_result($rst, $i, "acces_route_4"),
			"acces_route_texte" => mysql_result($rst, $i, "acces_route_texte"),
			"acces_train_4" => mysql_result($rst, $i, "acces_train_4"),
			"acces_train_texte" => mysql_result($rst, $i, "acces_train_texte"),
			"acces_avion_4" => mysql_result($rst, $i, "acces_avion_4"),
			"acces_avion_texte" => mysql_result($rst, $i, "acces_avion_texte"),
			"acces_bus_metro_4" => mysql_result($rst, $i, "acces_bus_metro_4"),
			"acces_bus_metro_texte" => mysql_result($rst, $i, "acces_bus_metro_texte"),
			"logo" => $logo,
			"id_centre_detention_label" => mysql_result($rst, $i, "id_centre_detention_label"),
			"id_centre_classement" => mysql_result($rst, $i, "id_centre_classement"),
			"id_centre_classement_1" => mysql_result($rst, $i, "id_centre_classement_1"));
		}
	}
	return $nbTotal;

}

function getListeCentreLesPlus(&$listeLesPlus, $_params = "")
{
	$sql = "SELECT id_centre_les_plus FROM centre_les_plus ";

	$sql .= " WHERE id_centre_1 IN ( ".implode(',',$_params['id_centre']).")";

	$sql .= " ORDER BY ordre ASC ";

	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nb ; $i++)
	{
		$listeLesPlus[] = array (	"libelle" => getTradTable("centre_les_plus",$_SESSION['ses_langue'],"libelle", mysql_result($rst, $i, "id_centre_les_plus")));
	}

	return $nb;
} // getListeCentreLesPlus(&$listeSites)

function getListeCentreService(&$listeService, $_params = "")
{
	$aIdService = array();

	$sql = "SELECT id_centre_service FROM centre ";
	$sql .= " WHERE id_centre IN ( ".implode(',',$_params['id_centre']).")";
	$sql .= " ORDER BY id_centre ASC ";

	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);

	### Cr�ation du tableau d'id de service en fct des id centre
	for ($i = 0 ; $i < $nb ; $i++)
	{
		$aIdService = array_merge($aIdService, explode(',',mysql_result($rst, $i, "id_centre_service")));
	}

	### Stockage temporaire de l'id visuel en fct de l'id des services
	$sql = "SELECT 	id_centre_service,
									visuel 
					FROM 		centre_service 
					WHERE 	id_centre_service IN ( ".implode(',',$aIdService).")";
	$rst = mysql_query($sql);

	while($row = mysql_fetch_object($rst))
	{
		$aTmpServiceVisuel[$row->id_centre_service] = $row->visuel;
	}

	### Lecture du tableau d'id de service
	foreach($aIdService as $iIdService)
	{
		$listeService[] = array (	"id" => $iIdService,
		"libelle" => getTradTable("centre_service",$_SESSION['ses_langue'],"libelle", $iIdService),
		"id_visuel" => $aTmpServiceVisuel[$iIdService],
		"libelle_visuel" => getFileFromBdd($aTmpServiceVisuel[$iIdService],'centre_service'));
	}


	return sizeof($aIdService);
} // getListeCentreService(&$listeService, $_params = "")

function getListeCentreActivite(&$listeActivite, $_params = "")
{
	$aIdActivite = array();

	$sql = "SELECT id_centre_activite FROM centre ";
	$sql .= " WHERE id_centre IN ( ".implode(',',$_params['id_centre']).")";
	$sql .= " ORDER BY id_centre ASC ";

	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);

	### Cr�ation du tableau d'id de Activite en fct des id centre
	for ($i = 0 ; $i < $nb ; $i++)
	{
		$aIdActivite = array_merge($aIdActivite, explode(',',mysql_result($rst, $i, "id_centre_activite")));
	}

	### Stockage temporaire de l'id visuel en fct de l'id des Activites
	$sql = "SELECT 	id_centre_activite,
									visuel 
					FROM 		centre_activite 
					WHERE 	id_centre_Activite IN ( ".implode(',',$aIdActivite).")";
	$rst = mysql_query($sql);

	while($row = mysql_fetch_object($rst))
	{
		$aTmpActiviteVisuel[$row->id_centre_activite] = $row->visuel;
	}

	### Lecture du tableau d'id de Activite
	foreach($aIdActivite as $iIdActivite)
	{
		$listeActivite[] = array (	"id" => $iIdActivite,
		"libelle" => getTradTable("centre_activite",$_SESSION['ses_langue'],"libelle", $iIdActivite),
		"id_visuel" => $aTmpActiviteVisuel[$iIdActivite],
		"libelle_visuel" => getFileFromBdd($aTmpActiviteVisuel[$iIdActivite],'centre_activite'));
	}


	return sizeof($aIdActivite);
} // getListeCentreActivite(&$listeActivite, $_params = "")

function getListeCentreAvisInternaute(&$listeAvis, $_params = "")
{
	$sql = "SELECT
				trad_laissez_avis_note.libelle as note,
				trad_laissez_avis_note.id__laissez_avis_note as idnote,
				laissez_avis.id_laissez_avis, 
				laissez_avis.nom, 
				laissez_avis.prenom, 
				DATE_FORMAT(laissez_avis.date_auto,'%d/%m/%Y') as date, 
				laissez_avis.email, 
				laissez_avis.avis as commentaire 
			FROM 
				laissez_avis
			inner join trad_laissez_avis_note on (trad_laissez_avis_note.id__langue = ".$_SESSION["ses_langue"]." and trad_laissez_avis_note.id__laissez_avis_note = laissez_avis.id_laissez_avis_note) ";

	$sql .= " WHERE laissez_avis.id_centre IN ( ".implode(',',$_params['id_centre']).")
						AND		laissez_avis.id__langue=".$_SESSION['ses_langue']."
						AND		laissez_avis.visible=1";

	$sql .= " ORDER BY date ASC ";

	$rst = mysql_query($sql) or die(mysql_error());

	if (!$rst)
	echo mysql_error. " - ".$sql;
	$tab[1] = "etoile5.gif";
	$tab[2] = "etoile4.gif";
	$tab[3] = "etoile3.gif";
	$tab[4] = "etoile2.gif";
	$tab[5] = "etoile1.gif";
	$nb = mysql_num_rows($rst);
	for ($i = 0 ; $i < $nb ; $i++)
	{
		$listeAvis[] = array (	"id" =>  mysql_result($rst, $i, "id_centre_avis_internaute"),
		"note" =>  				mysql_result($rst, $i, "note"),
		"nom" =>  				substr(mysql_result($rst, $i, "nom"),0,1)."...",
		"prenom" =>  			mysql_result($rst, $i, "prenom"),
		"date" =>  				mysql_result($rst, $i, "date"),
		"etoile" =>  			$tab[mysql_result($rst, $i, "idnote")],
		"mail" =>  				mysql_result($rst, $i, "mail"),
		"commentaire" =>  mysql_result($rst, $i, "commentaire"));
	}

	return $nb;
} // getListeCentreAvisInternaute(&$listeSites)

function getListeCentreTarifs(&$listeTarifs, $aQueryData, $_params = "")
{
	$aTableId = array('accueil_groupes_jeunes_adultes' => array('id' =>				_CONST_TABLEDEF_GROUPE_ADULTE,
	'id_field' => 'id_accueil_groupes_jeunes_adultes'),
	'accueil_groupes_scolaires' => array(	'id' =>				_CONST_TABLEDEF_ACCUEIL_GROUPE,
	'id_field' => 'id_accueil_groupes_scolaires'),
	'accueil_individuels_familles' => array('id' =>		_CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE,
	'id_field' => 'id_accueil_individuels_familles'));

	/*define("_CONST_TABLEDEF_ACCUEIL_GROUPE",538);
	define("_CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE",549);
	define("_CONST_TABLEDEF_GROUPE_ADULTE",542);*/

	$sql = 'SELECT 			accueil.id_centre,
							trad_accueil.haute_saison,
							trad_accueil.moyenne_saison, 
							trad_accueil.basse_saison,
							trad_accueil.haute_saison_n1,
							trad_accueil.moyenne_saison_n1,
							trad_accueil.basse_saison_n1,
							tarif.HS_bb,
							tarif.HS_dp,
							tarif.HS_pc,
							tarif.HS_rs,
							tarif.MS_bb,
							tarif.MS_dp,
							tarif.MS_pc,
							tarif.MS_rs,
							tarif.BS_bb,
							tarif.BS_dp,
							tarif.BS_pc,
							tarif.BS_rs
					FROM				'.$aQueryData['table_name_accueil'].' accueil 
					inner join  trad_'.$aQueryData['table_name_accueil'].' trad_accueil on (trad_accueil.id__langue='.$_SESSION["ses_langue"].' and
																							trad_accueil.id__'.$aQueryData['table_name_accueil'].' = accueil.id_'.$aQueryData['table_name_accueil'].')
					INNER JOIN	'.$aQueryData['table_name_tarif'].' tarif
					ON			 		accueil.'.$aTableId[$aQueryData['table_name_accueil']]['id_field'].' = tarif.IdSejour
					AND					tarif.id__table_def = '.$aTableId[$aQueryData['table_name_accueil']]['id'].'			
					WHERE				accueil.id_centre IN ('.implode(',',$_params['id_centre']).')';
	$rst = mysql_query($sql);

	if (!$rst)
	echo mysql_error. " - ".$sql;

	$nb = mysql_num_rows($rst);
	while($row = mysql_fetch_object($rst))
	{
		$listeTarifs[$row->id_centre][] = array(		"bb" => $row->HS_bb, // Haute saison B & B
		"dp" => $row->HS_dp, // Haute saison Demi-pension
		"pc" => $row->HS_pc, // Haute saison Pension compl�te
		"rs" => $row->HS_rs, // Haute saison Repas seul
		//"T_HS" => mb_strtoupper($row->haute_saison),
		"T_HS" => $row->haute_saison,
		"libelle" => mb_strtoupper(get_libLocal('lib_haute_saison'),"utf-8"));

		$listeTarifs[$row->id_centre][] = array(		"bb" => $row->MS_bb, // Haute saison B & B
		"dp" => $row->MS_dp, // Haute saison Demi-pension
		"pc" => $row->MS_pc, // Haute saison Pension compl�te
		"rs" => $row->MS_rs, // Haute saison Repas seul
		"T_MS" => $row->moyenne_saison,
		//"T_MS" => mb_strtoupper($row->moyenne_saison),
		"libelle" => mb_strtoupper(get_libLocal('lib_moyenne_saison')));

		$listeTarifs[$row->id_centre][] = array(		"bb" => $row->BS_bb, // Haute saison B & B
		"dp" => $row->BS_dp, // Haute saison Demi-pension
		"pc" => $row->BS_pc, // Haute saison Pension compl�te
		"rs" => $row->BS_rs, // Haute saison Repas seul
		"T_BS" => $row->basse_saison,
		"libelle" => mb_strtoupper(get_libLocal('lib_basse_saison')));
	}

	return $nb;
}

function getCentreLabels($params)
{
	if($params["id"][0]!=""){
		$nbLabel = getListeCentreInfos('detention_label',$listeLabel,$params);
		if($nbLabel>0){
			$tabVisuel = array();
			$visuel_label = "";
			foreach ($listeLabel as $label)
			{
				switch ($label['id'])
				{
					case 1 :
						//$template -> assign ('ecoLabel', true);
						$tabVisuel['ecolabel'] = true;
						break;
					case 2 :
						if ($visuel_label != '')
						$visuel_label .= '_';
						$visuel_label .= 'moteur';
						break;
					case 3 :
						if ($visuel_label != '')
						$visuel_label .= '_';
						$visuel_label .= 'mental';
						break;
					case 4 :
						if ($visuel_label != '')
						$visuel_label .= '_';
						$visuel_label .= 'auditif';
						break;
					case 5 :
						if ($visuel_label != '')
						$visuel_label .= '_';
						$visuel_label .= 'visuel';
						break;
					default:
						break;
				}

				if ($visuel_label != '')
				$tabVisuel['label'] = $visuel_label;

			}
		}
	}
	return $tabVisuel;
}	//getCentreLabels($params)

function add_slashes($texte){
	if (!get_magic_quotes_gpc()) {
		return addslashes($texte);
	} else {
		return $texte;
	}
}
function getPicto($id,$table){
	$sql = "select visuel from $table where id_$table=$id";
	$result = mysql_query($sql);
	return getFileFromBDD(mysql_result($result,0,"visuel"),$table);
}

function genere_mot_passe($longeur = 8)
{
	$mot_passe = "";
	$possible = "=@#-+23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKMNPQRSTUVWXYZ";
	$possible_length = strlen($possible) - 1;

	while($longeur --)
	{
		$except = substr($mot_passe, -$possible_length / 2);

		for ($n = 0 ; $n < 5 ; $n++)
		{
			$char = $possible{mt_rand(0, $possible_length)};

			if (strpos($except, $char) === false)
			{
				break;
			}
		}

		$mot_passe .= $char;
	}

	return $mot_passe;
}
// indique si l'URL HostelWorld est renseignee pour un centre
function isHostelWorld($id_centre){
	$sqlQuery = "SELECT url_hostelworld FROM centre WHERE id_centre=".$id_centre;
	$sqlResult = mysql_query($sqlQuery);
	$row = mysql_fetch_row($sqlResult);
	if($row[0]=="" || $row[0]==null)
		return false;
	else
		return true;
}




//============================================================================
// Controle le form inscription
//============================================================================
function isValidFormInscription($_aformContact)
{
	if(trim($_aformContact["nom_media"])=="") 		return false;
	if(trim($_aformContact["nom_contact"])=="") 	return false;
	if(trim($_aformContact["email"])=="") 			return false;
	if(trim($_aformContact["telephone"])=="") 		return false;
	if(trim($_aformContact["fonction"])=="") 		return false;
	if(empty($_aformContact["type_media"]))			return false;
	if(empty($_aformContact["civilite"]))			return false;
	if(empty($_aformContact["types_public"]))		return false;

	$nameRegex = "/^[^\d,._&@\(\)\$\%#]*$$/";
	$emailRegex = "/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/";

	if (!preg_match($nameRegex, $_aformContact["nom_media"])) 		return false;
	if (!preg_match($nameRegex, $_aformContact["nom_contact"])) 	return false;
	if (!preg_match($emailRegex, $_aformContact["email"])) 			return false;

	return true;
}

?>

