<? 
$icone_size = 20;
$color_true = get_inter_color($MenuBgColor,0.25);//"#FFA6A6";
$color_false = get_inter_color($MenuBgColor,0.25);//"#00C100";


//--------------------------------------------------------
//			Récupération des données des SELECT 
//--------------------------------------------------------

$select = array();
$typeSelect = array("ambiance", "environnement", "environnement_montagne", "classement",
					 "detention_label", "activite", "service", "espace_detente");

foreach ($typeSelect as $type)
{
	$sqlSelect = "select id__centre_".$type.", libelle from trad_centre_".$type." where id__langue = ".$id_langue. " order by id__centre_".$type;
	$rstSelect = mysql_query($sqlSelect);
	
	if (!$rstSelect)
		echo (mysql_error(). " : ".$sqlSelect);
	else 
	{
		$nbSelect = mysql_num_rows($rstSelect);
		for ($i = 0 ; $i < $nbSelect ; $i++)
			$select[$type][mysql_result($rstSelect,$i, "id__centre_".$type)] = mysql_result($rstSelect,$i, "libelle") ;
	}
}


$sqlRegion = "select id_centre_region, libelle from centre_region order by id_centre_region";
$rstRegion = mysql_query($sqlRegion);
if (!$rstRegion)
	echo (mysql_error(). " : ".$sqlRegion);
else 
{
	$nbRegion = mysql_num_rows($rstRegion);
	for ($i = 0 ; $i < $nbRegion ; $i++)
		$select['region'][mysql_result($rstRegion,$i, "id_centre_region")] = mysql_result($rstRegion,$i, "libelle") ;
}
	
//--------------------------------------------------------
//						AFFICHAGE
//--------------------------------------------------------

?>
<div>
			
<style>
label {
width:300px;
display:block;
float:left;
margin-right:20px;
}
</style>			
<div style="width:600px;background:<?=get_inter_color($MenuBgColor,0.25)?>;padding:15px;">
			<form name="FormSearchCentre" method="post" action="<?=NomFichier($_SERVER['PHP_SELF'],0)."?".$_SERVER['QUERY_STRING'];?>">
			  <!--<table border="0" cellspacing="1" cellpadding="4" bgcolor="<?=$TableBgColor?>">
				<tr  bgcolor="<?=get_inter_color($MenuBgColor,0.25)?>"> -->
		<p>
			<span style="float:left;"><?=$inc_search_engine_recherche?></span>
			<a href="#" id="display_none"  <?= ($searchByCentre == true) ? '' : 'style="display:none;"' ?> onclick="javascript:this.style.display = 'none'; document.getElementById('display_block').style.display='block' ;document.getElementById('innerSearch').style.display='none';return false;" >Masquer</a>
			<a href="#" id="display_block" <?= ($searchByCentre == true) ? 'style="display:none;"' : '' ?> onclick="javascript:this.style.display = 'none'; document.getElementById('display_none').style.display='block' ;document.getElementById('innerSearch').style.display='block';return false;" >Afficher</a>
		</p>
		<div id="innerSearch" <?= ($searchByCentre == true) ? '' : 'style="display:none;"' ?>>
		<p>
			<label>Nom du centre : </label>
			<input type="text" name="nomCentre" class="InputText" value="<?=$_REQUEST['nomCentre'];?>">
		</p>
		<hr>
		<p>
			<label><b>Ambiance du centre : </b></label>
			<select name="ambiance">
				<option value="">Choisir</option>
				<?php foreach ($select['ambiance'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['ambiance'] == $value ? 'selected="selected"' : '')?> ><?= $libelle ?></option>
				<?php } ?>
			</select>
		</p>
		<hr>
		<p>
			<label><b>Environnement du centre : </b></label>
			<select name="environnement">
				<option value="">Choisir</option>
				<?php foreach ($select['environnement'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['environnement'] == $value ? 'selected="selected"' : '')?>  ><?= $libelle ?></option>
				<?php } ?>
			</select>
		</p>
		<p>
			<label>Massif : </label>
			<select name="environnement_montagne">
				<option value="">Choisir</option>
				<?php foreach ($select['environnement_montagne'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['environnement_montagne'] == $value ? 'selected="selected"' : '')?>  ><?= $libelle ?></option>
				<?php } ?>
			</select>
		</p>
		<hr>
		<p>
			<label>Code postal : </label>
			<input type="text" name="code_postal" class="InputText" value="<?= $_REQUEST['code_postal'] ?>">
		</p>
		<hr>
		<p>
			<label>R&eacute;gion : </label>
			<select name="region">
				<option value="">Choisir</option>
				<?php foreach ($select['region'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['region'] == $value ? 'selected="selected"' : '')?> ><?= $libelle ?></option>
				<?php } ?>
			</select>
		</p>
		<hr>
		<p>
			<label>Classement 1 : </label>
			<select name="classement1">
				<option value="">Choisir</option>
				<?php foreach ($select['classement'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['classement1'] == $value ? 'selected="selected"' : '')?>  ><?= $libelle ?></option>
				<?php } ?>
			</select>
		</p>
		<hr>
		<p>
			<label>Classement 2 : </label>
			<select name="classement2">
				<option value="">Choisir</option>
				<?php foreach ($select['classement'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['classement2'] == $value ? 'selected="selected"' : '')?> ><?= $libelle ?></option>
				<?php } ?>
			</select>
		</p>
		<hr>
		<p>
			<label>Nombre de chambres : </label>
			<input type="text" name="nb_chambre" class="InputText" value="<?= $_REQUEST['nb_chambre'] ?>">
		</p>
		<hr>
		<p>
			<label>Nombre de lits : </label>
			<input type="text" name="nb_lit" class="InputText" value="<?= $_REQUEST['nb_lit'] ?>">
		</p>
		<hr>
		<p>
			<label>Nombre de couverts : </label>
			<input type="text" name="nb_couvert" class="InputText" value="<?= $_REQUEST['nb_couvert'] ?>">
		</p>
		<p>
			<label>&agrave; l'assiette : </label>
			<input type="checkbox" name="couvert_assiette" class="InputText" <?=($_REQUEST['couvert_assiette'] == 'on' ? 'checked="checked"' : '')?>>
		</p>
		<p>
			<label>self service ou plats sur table : </label>
			<input type="checkbox" name="couvert_self" class="InputText" <?= ($_REQUEST['couvert_self'] == 'on' ? 'checked="checked"' : '')?>>
		</p>
		<hr>
		<p>
			<label>Nombre de salle de r&eacute;union : </label>
			<input type="text" name="nb_salle_reunion" class="InputText" value="<?= $_REQUEST['nb_salle_reunion'] ?>">
		</p>
		<hr>
		<p>
			<label>Capacit&eacute;s des salles : </label>
			<input type="text" name="capacite_salle" class="InputText" value="<?= $_REQUEST['capacite_salle'] ?>">
		</p>
		<hr>
		<p>
			<label>Nombre de chambres accessibles aux personnes &agrave; mobilit&eacute; r&eacute;duite : </label>
			<input type="text" name="nb_chambre_handicap" class="InputText" value="<?= $_REQUEST['nb_chambre_handicap'] ?>">
		</p>
		<hr>
		<p>
			<label>Nombre de lits accessibles aux personnes &agrave; mobilit&eacute; r&eacute;duite : </label>
			<input type="text" name="nb_lit_handicap" class="InputText" value="<?= $_REQUEST['nb_lit_handicap'] ?>">
		</p>
		<hr>
		<p>
			<label><b>D&eacute;tention de labels : </b></label>
			<select name="detention_label">
				<option value="">Choisir</option>
				<?php foreach ($select['detention_label'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['detention_label'] == $value ? 'selected="selected"' : '')?> ><?= $libelle ?></option>
				<?php } ?>
			</select>
		</p>
		<hr>
		<p>
			<label><b>Activit&eacute;s : </b></label>
			<select name="activite">
				<option value="">Choisir</option>
				<?php foreach ($select['activite'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['activite'] == $value ? 'selected="selected"' : '')?> ><?= $libelle ?></option>
				<?php } ?>
			</select>
		</p>
		<hr>
		<p>
			<label><b>Services disponibles au centre : </b></label>
			<select name="service">
				<option value="">Choisir</option>
				<?php foreach ($select['service'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['service'] == $value ? 'selected="selected"' : '')?> ><?= $libelle ?></option>
				<?php } ?>
			</select>
		</p>
		<hr>
		<p>
			<label><b>Espace d&eacute;tente : </b></label>
			<select name="espace_detente">
				<option value="">Choisir</option>
				<?php foreach ($select['espace_detente'] as $value => $libelle) { ?>
				<option value="<?= $value ?>" <?=($_REQUEST['espace_detente'] == $value ? 'selected="selected"' : '')?> ><?= $libelle ?></option>
				<?php } ?>			
			</select>
		</p>
		<input type="hidden" name="Page" value="0">	
		<p>
			<label>&nbsp;</label>
			<a href="javascript:document.FormSearchCentre.submit();"><img src="images/icones/icone_view.gif" alt="Rechercher" border="0">Chercher</a>
		</p>	
		</div>
</div>					

					</td>
				</tr>
			  </table>
			</form>
			</div>
