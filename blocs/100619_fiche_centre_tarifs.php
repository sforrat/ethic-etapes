<?


/*
*	$_GET['n1'] :
*
* Indique s'il s'agit de l'année N+1
*	Valeurs possibles :
*	- true : Il s'agit de l'année N+1
*	- false : Il s'agit de l'année N
*/
$iIdCentre = $_GET['id_centre'];

if(isset($_GET['n1']))
{
	$bAnneePlus1 = true;
	$sTableTarifs = 'sejour_tarif_groupe_plus';
}
else
{
	$bAnneePlus1 = false;
	$sTableTarifs = 'sejour_tarif_groupe';
}


$iNbCentreTarifsScolaire = getListeCentreTarifs(
$listeTarifsScolaire,
array(
'table_name_accueil'=>'accueil_groupes_scolaires',
'table_name_tarif'=>$sTableTarifs),
array('id_centre'=>array($iIdCentre)));

if (!isset($_REQUEST['t']) && $_REQUEST['t'] != _NAV_ACCUEIL_GROUPES_SCOLAIRES)
{
$iNbCentreTarifsAdulte = getListeCentreTarifs(
$listeTarifsAdulte,
array(
'table_name_accueil'=>'accueil_groupes_jeunes_adultes',
'table_name_tarif'=>$sTableTarifs),
array('id_centre'=>array($iIdCentre)));

$iNbCentreTarifsFamille = getListeCentreTarifs(
$listeTarifsFamille,
array(
'table_name_accueil'=>'accueil_individuels_familles',
'table_name_tarif'=>$sTableTarifs),
array('id_centre'=>array($iIdCentre)));
}
$listeTarifsScolaire=$listeTarifsScolaire[$iIdCentre];
$listeTarifsAdulte=$listeTarifsAdulte[$iIdCentre];
$listeTarifsFamille=$listeTarifsFamille[$iIdCentre];

if(($listeTarifsScolaire) || ($iNbCentreTarifsAdulte) || ($iNbCentreTarifsFamille))
{
	$this->assign("is_tarifs",true);
	if($bAnneePlus1) $this->assign("bAnneePlus1",true);
	else $this->assign("bAnneePlus1",false);

	if($iNbCentreTarifsScolaire) $this->assign("listeTarifsScolaire",$listeTarifsScolaire);
	if($iNbCentreTarifsAdulte) $this->assign("listeTarifsAdulte",$listeTarifsAdulte);
	if($iNbCentreTarifsFamille) $this->assign("listeTarifsFamille",$listeTarifsFamille);

	$this->assign("id_centre",$iIdCentre);

	$this->assign("LIB_BED_BREAKFAST", strtoupper(get_libLocal('lib_bed_breakfast')));
	$this->assign("LIB_DEMI_PENSION", strtoupper(get_libLocal('lib_demi_pension')));
	$this->assign("LIB_PENSION_COMPLETE", strtoupper(get_libLocal('lib_pension_complete')));
	$this->assign("LIB_REPAS_SEUL", strtoupper(get_libLocal('lib_repas_seul')));
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




$this->display('blocs/fiche_centre_tarifs.tpl');
?>