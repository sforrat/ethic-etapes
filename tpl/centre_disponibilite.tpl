<link type="text/css" rel="stylesheet" href="css/jquery-ui.css"  media="all"/>
<script type="text/javascript" src="js/jquery.ui.core.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker.js"></script>
<script type="text/javascript" src="js/jquery.ui.datepicker-#{$prefixe}#.js"></script>

<div class="innerPopin">
	<h3>#{smarty_trad value='lib_formulaire_dispo'}#</h3>
	<form action="" method="POST" name="formDispo" id="formDispo" onsubmit="checkForm('formDispo','sendDispoCentre()',1); return false;" >					
		#{if $messageOK == 1}#
		<p class="messageForm">#{$message}#</p>
		#{/if}#
		<input type="hidden" id="centre" name="centre" value="#{$id_centre}#" />
		<fieldset class="popinForm">	
			<p>
				<label for="contact_youAre">#{smarty_trad value='lib_centre_contact_type'}#* :</label>
				<select id="contact_youAre" name="contact_youAre" onchange="majFormDispo(this.value)">
					<option value="1">#{smarty_trad value='lib_enseignant'}#</option>
					<option value="2">#{smarty_trad value='lib_agence_to_special_scolaire'}#</option>
					<option value="3">#{smarty_trad value='lib_organisateur_vacances'}#</option>
					<option value="4">#{smarty_trad value='lib_organisateur_reunion'}#</option>	
					<option value="5">#{smarty_trad value='lib_to_special_groupe'}#</option>	
					<option value="6">#{smarty_trad value='lib_ce'}#</option>
					<option value="7">#{smarty_trad value='lib_assoc'}#</option>
					<option value="8">#{smarty_trad value='lib_particulier'}#</option>	
					<option value="9">#{smarty_trad value='lib_autre'}#</option>
				</select>	
			</p>
			<p>
				<label>#{smarty_trad value='lib_civilite'}#* :</label>
				#{section name=sec1 loop=$TabCivilite}#					
						<input name="test-Civilite" type="radio" id="#{$TabCivilite[sec1].libelle}#" value="#{$TabCivilite[sec1].libelle}#" /><label for="#{$TabCivilite[sec1].libelle}#" class="labelCheckbox">#{$TabCivilite[sec1].libelle}#</label>
				#{/section}#							
			</p>
			
			<p>
				<label for="test-contact_name">#{smarty_trad value='lib_nom_prenom'}#* :</label>
				<input type="text" class="text" id="#{smarty_trad value='lib_nom_prenom'}#" name="test-name" />	
				<span id="Pecole">
					<label for="test-contact_nom_ecole">#{smarty_trad value='lib_nom_ecole'}#* :</label>
					<input type="text" class="text" id="#{smarty_trad value='lib_nom_ecole'}#" name="test-Pecole" />	
				</span>
			</p>			
			<p>
				<label for="test-email-contact_mail">#{smarty_trad value='lib_adresse_mail'}#* :</label>
				<input type="text" class="text" id="#{smarty_trad value='lib_adresse_mail'}#" name="test-email-mail"/>								
			</p>
			<p id="Pstructure" style="display:none;">
				<label for="test-contact_structure">#{smarty_trad value='lib_nom_structure'}#* :</label>
				<input type="text" class="text" id="#{smarty_trad value='lib_nom_structure'}#" name="test-Pstructure" />								
			</p>
			<p id="Passociation" style="display:none;">
				<label for="#{smarty_trad value='lib_nom_association}#">#{smarty_trad value='lib_nom_association}#* :</label>
				<input type="text" class="text" id="#{smarty_trad value='lib_nom_association}#" name="test-Passociation" />								
			</p>	
			<p id="Pdiscipline" style="display:none;">
				<label for="#{smarty_trad value='lib_discipline_sportive}#">#{smarty_trad value='lib_discipline_sportive}#* :</label>
				<select id="#{smarty_trad value='lib_discipline_sportive}#" name="test-Pdiscipline[]">
					#{section name=sec4 loop=$TabDiscipline}#
						<option value="#{$TabDiscipline[sec4].id}#">#{$TabDiscipline[sec4].libelle}#</option>
					#{/section}#
				</select>								
			</p>	
			<p>
				<span id="Padresse">
					<label for="#{smarty_trad value='lib_adresse'}#">#{smarty_trad value='lib_adresse'}#* :</label>
					<input type="text" class="text" id="#{smarty_trad value='lib_adresse'}#" name="test-Padresse" />
				</span>
				<span id="Pcp">
					<label for="#{smarty_trad value='lib_code_postal'}#">#{smarty_trad value='lib_code_postal'}#* :</label>
					<input type="text" class="text" id="#{smarty_trad value='lib_code_postal'}#" name="test-Pcp" />	
				</span>	
			</p>		
			<p>
				<span id="Pville">
					<label for="#{smarty_trad value='lib_ville'}#">#{smarty_trad value='lib_ville'}#* :</label>
					<input type="text" class="text" id="#{smarty_trad value='lib_ville'}#" name="test-Pville" />
				</span>
				<span id="Ppays">
					<label for="#{smarty_trad value='lib_pays'}#">#{smarty_trad value='lib_pays'}#* :</label>
					<select id="#{smarty_trad value='lib_pays'}#"  name="test-Ppays">
						#{section name=sec3 loop=$TabPays}#
							<option value="#{$TabPays[sec3].id}#"  #{if $TabPays[sec3].defaut==1}#selected#{/if}#>#{$TabPays[sec3].libelle}#</option>
						#{/section}#					
					</select>
				</span>	
			</p>			
			<p>
				<label for="#{smarty_trad value='lib_telephone'}#">#{smarty_trad value='lib_telephone'}#* :</label>
				<input type="text" class="text" id="#{smarty_trad value='lib_telephone'}#" name="test-contact_tel" />	
				<span id="PFax">
					<label for="contact_fax">#{smarty_trad value='lib_fax'}# :</label>
					<input type="text" class="text" id="contact_fax" name="PFax" />	
				</span>	
			</p>			
			<p id="Pniveau">
				<label for="#{smarty_trad value='lib_niveau_scolaire'}#">#{smarty_trad value='lib_niveau_scolaire'}#* :</label>
				<select id="#{smarty_trad value='lib_niveau_scolaire'}#" name="test-Pniveau[]">
					#{section name=sec5 loop=$TabNiveau}#
						<option value="#{$TabNiveau[sec5].id}#">#{$TabNiveau[sec5].libelle}#</option>
					#{/section}#					
				</select>							
			</p>
			<p id="Petablissement">
				<label for="#{smarty_trad value='lib_type_etablissement'}#">#{smarty_trad value='lib_type_etablissement'}#* :</label>
				<select id="#{smarty_trad value='lib_type_etablissement'}#" name="test-Petablissement[]">
				#{section name=sec2 loop=$TabType}#
				<option value="#{$TabType[sec2].id}#">#{$TabType[sec2].libelle}#</option>
				#{/section}#
				</select>
			</p>			
			<p id="PDateArrivee">				
				<label for="#{smarty_trad value='lib_date_arrivee'}#">#{smarty_trad value='lib_date_arrivee'}#* :</label>
				<input type="text" id="datepicker1" class="text smallText" name="test-PDateArrivee">	
			</p>	
			<p id="PDateDepart">
				<label for="#{smarty_trad value='lib_date_depart'}#">#{smarty_trad value='lib_date_depart'}#* :</label>
				<input type="text" id="datepicker2" class="text smallText" name="test-PDateDepart" class="datepicker">	
			</p>
			<p id="PNbPersonne">
				<label for="#{smarty_trad value='lib_nombre_personne'}#">#{smarty_trad value='lib_nombre_personne'}#* :</label>
				<input type="text" id="#{smarty_trad value='lib_nombre_personne'}#" name="test-PNbPersonne">						
			</p>
			<p>
				<label for="#{smarty_trad value='lib_commentaires_questions'}#">#{smarty_trad value='lib_commentaires_questions'}#* :</label>
				<span class="txtArea_container">
					<textarea id='#{smarty_trad value='lib_commentaires_questions'}#' name='test-commentaire' cols="20" rows="5" ></textarea>
				</span>				
			</p>
			<p class="choiceNL">
				#{smarty_trad value="lib_recevoir_actu_ee"}#* :<br />
				
				#{section name=sec1 loop=$TabTypeNews}#
					<input type="checkbox" class="radio" name="Newsletter[]" id="#{$TabTypeNews[sec1].libelle}#" value="#{$TabTypeNews[sec1].id}#" /><label for="#{$TabTypeNews[sec1].libelle}#">#{$TabTypeNews[sec1].libelle}#</label><br />
				#{/section}#
			</p>	
			<p class="captchaLine">#{include file="blocs/captcha.tpl"}#</p>
			<p class="validLine">
				<input type="submit" value="#{smarty_trad value='lib_submit'}#" />
			</p>
			<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
			<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>
		</fieldset>						
	</form>
</div>
<script type="text/javascript">
$(function() {
	$("#datepicker1").datepicker({
		showOn: 'button',
		buttonImage: 'images/calendar.gif',
		buttonImageOnly: true
	});

	$("#datepicker2").datepicker({
		showOn: 'button',
		buttonImage: 'images/calendar.gif',
		buttonImageOnly: true
	});
	
});
</script>
