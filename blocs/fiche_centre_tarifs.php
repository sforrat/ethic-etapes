<?


/*
*	$_GET['n1'] :
*
* Indique s'il s'agit de l'ann�e N+1
*	Valeurs possibles :
*	- true : Il s'agit de l'ann�e N+1
*	- false : Il s'agit de l'ann�e N
*/

$iIdCentre = $_GET['id_centre'];
$afficheBoutonNplus1 = false;

if(isset($_GET['n1']))
{
	$bAnneePlus1 = true;
}
else
{
	$bAnneePlus1 = false;
}


/* tarifs g�n�raux (tous) */
if (!isset($_REQUEST['t']))
{
	$iNbCentreTarifsScolaire = getListeCentreTarifs(
		$listeTarifsScolaire,
		array(
		'table_name_accueil'=>'accueil_groupes_scolaires',
		'table_name_tarif'=>'sejour_tarif_groupe'),
		array('id_centre'=>array($iIdCentre))
	);
	$iNbCentreTarifsAdulte = getListeCentreTarifs(
		$listeTarifsAdulte,
		array(
		'table_name_accueil'=>'accueil_groupes_jeunes_adultes',
		'table_name_tarif'=>'sejour_tarif_groupe'),
		array('id_centre'=>array($iIdCentre))
	);
	$iNbCentreTarifsFamille = getListeCentreTarifs(
		$listeTarifsFamille,
		array(
		'table_name_accueil'=>'accueil_individuels_familles',
		'table_name_tarif'=>'sejour_tarif_groupe'),
		array('id_centre'=>array($iIdCentre))
	);
	
	$iNbCentreTarifsScolairePlus1 = getListeCentreTarifs(
		$listeTarifsScolairePlus1,
		array(
		'table_name_accueil'=>'accueil_groupes_scolaires',
		'table_name_tarif'=>'sejour_tarif_groupe_plus'),
		array('id_centre'=>array($iIdCentre))
	);
	$iNbCentreTarifsAdultePlus1 = getListeCentreTarifs(
		$listeTarifsAdultePlus1,
		array(
		'table_name_accueil'=>'accueil_groupes_jeunes_adultes',
		'table_name_tarif'=>'sejour_tarif_groupe_plus'),
		array('id_centre'=>array($iIdCentre))
	);
	$iNbCentreTarifsFamillePlus1 = getListeCentreTarifs(
		$listeTarifsFamillePlus1,
		array(
		'table_name_accueil'=>'accueil_individuels_familles',
		'table_name_tarif'=>'sejour_tarif_groupe_plus'),
		array('id_centre'=>array($iIdCentre))
	);
}

/* tarifs s�jours (sp�cifique) */
else
{
	 switch($_REQUEST['t'])
	 {
	 	case _NAV_ACCUEIL_GROUPES_SCOLAIRES:
		 	$iNbCentreTarifsScolaire = getListeCentreTarifs(
				$listeTarifsScolaire,
				array(
				'table_name_accueil'=>'accueil_groupes_scolaires',
				'table_name_tarif'=>'sejour_tarif_groupe'),
				array('id_centre'=>array($iIdCentre))
			);
			$iNbCentreTarifsScolairePlus1 = getListeCentreTarifs(
				$listeTarifsScolairePlus1,
				array(
				'table_name_accueil'=>'accueil_groupes_scolaires',
				'table_name_tarif'=>'sejour_tarif_groupe_plus'),
				array('id_centre'=>array($iIdCentre))
			);
		break;
		
	 	case _NAV_ACCUEIL_INDIVIDUEL:
	 		$iNbCentreTarifsFamille = getListeCentreTarifs(
				$listeTarifsFamille,
				array(
				'table_name_accueil'=>'accueil_individuels_familles',
				'table_name_tarif'=>'sejour_tarif_groupe'),
				array('id_centre'=>array($iIdCentre))
			);
			$iNbCentreTarifsFamillePlus1 = getListeCentreTarifs(
				$listeTarifsFamillePlus1,
				array(
				'table_name_accueil'=>'accueil_individuels_familles',
				'table_name_tarif'=>'sejour_tarif_groupe_plus'),
				array('id_centre'=>array($iIdCentre))
			);
	 	break;
	 	
	 	case _NAV_ACCUEIL_GROUPE:
	 	case _NAV_ACCUEIL_SPORTIF:
	 		$iNbCentreTarifsAdulte = getListeCentreTarifs(
				$listeTarifsAdulte,
				array(
				'table_name_accueil'=>'accueil_groupes_jeunes_adultes',
				'table_name_tarif'=>'sejour_tarif_groupe'),
				array('id_centre'=>array($iIdCentre))
			);
			$iNbCentreTarifsAdultePlus1 = getListeCentreTarifs(
				$listeTarifsAdultePlus1,
				array(
				'table_name_accueil'=>'accueil_groupes_jeunes_adultes',
				'table_name_tarif'=>'sejour_tarif_groupe_plus'),
				array('id_centre'=>array($iIdCentre))
			);
	 	break;
	 	
	 	default:
	 		
	 	break;
	 }
}

$listeTarifsScolaire=$listeTarifsScolaire[$iIdCentre];
$listeTarifsAdulte=$listeTarifsAdulte[$iIdCentre];
$listeTarifsFamille=$listeTarifsFamille[$iIdCentre];

$listeTarifsScolairePlus1 = $listeTarifsScolairePlus1[$iIdCentre];
$listeTarifsAdultePlus1=$listeTarifsAdultePlus1[$iIdCentre];
$listeTarifsFamillePlus1=$listeTarifsFamillePlus1[$iIdCentre];

if(
	($listeTarifsScolairePlus1[0]["bb"]>0 || $listeTarifsScolairePlus1[0]["dp"]>0 || $listeTarifsScolairePlus1[0]["pc"]>0 || $listeTarifsScolairePlus1[0]["rs"]>0) ||
	($listeTarifsScolairePlus1[1]["bb"]>0 || $listeTarifsScolairePlus1[1]["dp"]>0 || $listeTarifsScolairePlus1[1]["pc"]>0 || $listeTarifsScolairePlus1[1]["rs"]>0) ||
	($listeTarifsScolairePlus1[2]["bb"]>0 || $listeTarifsScolairePlus1[2]["dp"]>0 || $listeTarifsScolairePlus1[2]["pc"]>0 || $listeTarifsScolairePlus1[2]["rs"]>0) ||
	($listeTarifsAdultePlus1[0]["bb"]>0 || $listeTarifsAdultePlus1[0]["dp"]>0 || $listeTarifsAdultePlus1[0]["pc"]>0 || $listeTarifsAdultePlus1[0]["rs"]>0) ||
	($listeTarifsAdultePlus1[1]["bb"]>0 || $listeTarifsAdultePlus1[1]["dp"]>0 || $listeTarifsAdultePlus1[1]["pc"]>0 || $listeTarifsAdultePlus1[1]["rs"]>0) ||
	($listeTarifsAdultePlus1[2]["bb"]>0 || $listeTarifsAdultePlus1[2]["dp"]>0 || $listeTarifsAdultePlus1[2]["pc"]>0 || $listeTarifsAdultePlus1[2]["rs"]>0) ||
	($listeTarifsFamillePlus1[0]["bb"]>0 || $listeTarifsFamillePlus1[0]["dp"]>0 || $listeTarifsFamillePlus1[0]["pc"]>0 || $listeTarifsFamillePlus1[0]["rs"]>0) ||
	($listeTarifsFamillePlus1[1]["bb"]>0 || $listeTarifsFamillePlus1[1]["dp"]>0 || $listeTarifsFamillePlus1[1]["pc"]>0 || $listeTarifsFamillePlus1[1]["rs"]>0) ||
	($listeTarifsFamillePlus1[2]["bb"]>0 || $listeTarifsFamillePlus1[2]["dp"]>0 || $listeTarifsFamillePlus1[2]["pc"]>0 || $listeTarifsFamillePlus1[2]["rs"]>0)
)
{
	$afficheBoutonNplus1 = true;
}

if($bAnneePlus1)
{
	$listeTarifsScolaire=$listeTarifsScolairePlus1;
	$listeTarifsAdulte=$listeTarifsAdultePlus1;
	$listeTarifsFamille=$listeTarifsFamillePlus1;
}

if(($listeTarifsScolaire) || ($iNbCentreTarifsAdulte) || ($iNbCentreTarifsFamille))
{
	$this->assign("is_tarifs",true);
	if($bAnneePlus1)
		$this->assign("bAnneePlus1",true);
	else
		$this->assign("bAnneePlus1",false);

	if($iNbCentreTarifsScolaire)
	{
		$this->assign("listeTarifsScolaire",$listeTarifsScolaire);
	}
	if($iNbCentreTarifsAdulte)
	{
		$this->assign("listeTarifsAdulte",$listeTarifsAdulte);
	}
	if($iNbCentreTarifsFamille)
	{
		$this->assign("listeTarifsFamille",$listeTarifsFamille);
	}

	$this->assign("id_centre",$iIdCentre);

	$this->assign("LIB_BED_BREAKFAST", mb_strtoupper(get_libLocal('lib_bed_breakfast'),"utf-8"));
	$this->assign("LIB_DEMI_PENSION", mb_strtoupper(get_libLocal('lib_demi_pension'),"utf-8"));
	$this->assign("LIB_PENSION_COMPLETE", mb_strtoupper(get_libLocal('lib_pension_complete'),"utf-8"));
	$this->assign("LIB_REPAS_SEUL", mb_strtoupper(get_libLocal('lib_repas_seul'),"utf-8"));
}



if(
	($listeTarifsScolaire[0]["bb"]>0 || $listeTarifsScolaire[0]["dp"]>0 || $listeTarifsScolaire[0]["pc"]>0 || $listeTarifsScolaire[0]["rs"]>0) ||
	($listeTarifsScolaire[1]["bb"]>0 || $listeTarifsScolaire[1]["dp"]>0 || $listeTarifsScolaire[1]["pc"]>0 || $listeTarifsScolaire[1]["rs"]>0) ||
	($listeTarifsScolaire[2]["bb"]>0 || $listeTarifsScolaire[2]["dp"]>0 || $listeTarifsScolaire[2]["pc"]>0 || $listeTarifsScolaire[2]["rs"]>0)
	
	){

	$this->assign("listeTarifsScolaireNb", 1);
}else{

	$this->assign("listeTarifsScolaireNb", 0);
}

if(
	($listeTarifsAdulte[0]["bb"]>0 || $listeTarifsAdulte[0]["dp"]>0 || $listeTarifsAdulte[0]["pc"]>0 || $listeTarifsAdulte[0]["rs"]>0) ||
	($listeTarifsAdulte[1]["bb"]>0 || $listeTarifsAdulte[1]["dp"]>0 || $listeTarifsAdulte[1]["pc"]>0 || $listeTarifsAdulte[1]["rs"]>0) ||
	($listeTarifsAdulte[2]["bb"]>0 || $listeTarifsAdulte[2]["dp"]>0 || $listeTarifsAdulte[2]["pc"]>0 || $listeTarifsAdulte[2]["rs"]>0)
	
	){

	$this->assign("listeTarifsAdulteNb", 1);
}else{
	$this->assign("listeTarifsAdulteNb", 0);
}


if(
	($listeTarifsFamille[0]["bb"]>0 || $listeTarifsFamille[0]["dp"]>0 || $listeTarifsFamille[0]["pc"]>0 || $listeTarifsFamille[0]["rs"]>0) ||
	($listeTarifsFamille[1]["bb"]>0 || $listeTarifsFamille[1]["dp"]>0 || $listeTarifsFamille[1]["pc"]>0 || $listeTarifsFamille[1]["rs"]>0) ||
	($listeTarifsFamille[2]["bb"]>0 || $listeTarifsFamille[2]["dp"]>0 || $listeTarifsFamille[2]["pc"]>0 || $listeTarifsFamille[2]["rs"]>0)
	
	){

	
	$this->assign("listeTarifsFamilleNb", 1);
}else{
	$this->assign("listeTarifsFamilleNb", 0);
}
$this->assign('n1', $_GET['n1']);
$this->assign('afficheBoutonNplus1', $afficheBoutonNplus1);

$this->display('blocs/fiche_centre_tarifs.tpl');
?>