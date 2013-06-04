<form action="processing/sendNewCentre.action.php" method="POST" name="formContact" id="formContact" onsubmit="checkForm('formContact'); return false;" >					
	#{if $messageOK == 1}#
	<p class="messageForm">#{$message}#</p>
	#{/if}#
	
	<fieldset class="skinThisForm">	
		<p class="spacedDown">
			<label for="contact_youAre">#{smarty_trad value='lib_centre_contact_type'}#* :</label>
			<select id="contact_youAre" name="contact_youAre" onchange="majFormNewsletter(this.value)">
				<option value="1">#{smarty_trad value='lib_enseignant'}#</option>
				<option value="2">#{smarty_trad value='lib_organisateur_vacances'}#</option>
				<option value="3">#{smarty_trad value='lib_organisateur_reunion'}#</option>	
				<option value="4">#{smarty_trad value='lib_to_scolaire'}#</option>	
				<option value="5">#{smarty_trad value='lib_to_groupe'}#</option>
				<option value="6">#{smarty_trad value='lib_ce'}#</option>
				<option value="7">#{smarty_trad value='lib_assoc'}#</option>	
				<option value="8">#{smarty_trad value='lib_particulier'}#</option>	
				<option value="9">#{smarty_trad value='lib_autre'}#</option>	
					<option value="9">test</option>
			</select>	
		</p>
		<p>
			#{smarty_trad value='lib_civilite'}#* :
			#{section name=sec1 loop=$TabCivilite}#
				<label for="#{$TabCivilite[sec1].libelle}#">
					<input name="test-Civilite" type="radio" class="text" id="#{$TabCivilite[sec1].libelle}#" value="#{$TabCivilite[sec1].libelle}#" />#{$TabCivilite[sec1].libelle}#</label>
			#{/section}#							
		</p>
		
		<p>
			<label for="test-contact_name">#{smarty_trad value='lib_nom_prenom'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_prenom'}#" name="test-contact_name" />								
		</p>
		<p id="Pecole">
			<label for="test-contact_nom_ecole">#{smarty_trad value='lib_nom_ecole'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_ecole'}#" name="test-Pecole" />								
		</p>
		<p>
			<label for="test-email-contact_mail">#{smarty_trad value='lib_adresse_mail'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_adresse_mail'}#" name="test-email-contact_mail"/>								
		</p>
		<p id="Pcollectivite" style="display:none;">
			<label for="test-contact_collectivite">#{smarty_trad value='lib_nom_collectivite'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_collectivite'}#" name="test-Pcollectivite" />								
		</p>
		<p id="Pequipement" style="display:none;">
			<label for="test-contact_equipement">#{smarty_trad value='lib_nom_equipement'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_equipement'}#" name="test-Pequipement" />								
		</p>
		<p id="PFonction" style="display:none;">
			<label for="test-contact_fonction">#{smarty_trad value='lib_fonction'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_fonction'}#" name="test-PFonction" />								
		</p>
		<p id="Pstructure" style="display:none;">
			<label for="test-contact_structure">#{smarty_trad value='lib_nom_structure'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_structure'}#" name="test-Pstructure" />								
		</p>
		<p id="Pmedia" style="display:none;">
			<label for="#{smarty_trad value='lib_media'}#">#{smarty_trad value='lib_media'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_media'}#"  name="test-Pmedia" />								
		</p>
		<p id="Passociation" style="display:none;">
			<label for="#{smarty_trad value='lib_nom_association}#">#{smarty_trad value='lib_nom_association}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_association}#" name="test-Passociation" />								
		</p>	
		<p id="Pdiscipline" style="display:none;">
			<label for="#{smarty_trad value='lib_discipline_sportive}#">#{smarty_trad value='lib_discipline_sportive}#* :</label>
			<select id="#{smarty_trad value='lib_discipline_sportive}#" name="test-Pdiscipline[]" multiple>
			#{section name=sec4 loop=$TabDiscipline}#
			<option value="#{$TabDiscipline[sec4].id}#">#{$TabDiscipline[sec4].libelle}#</option>
			#{/section}#
			</select>								
		</p>	
		<p id="Padresse">
			<label for="#{smarty_trad value='lib_adresse'}#">#{smarty_trad value='lib_adresse'}# :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_adresse'}#" name="test-Padresse" />								
		</p>
		<p id="Pcp">
			<label for="#{smarty_trad value='lib_code_postal'}#">#{smarty_trad value='lib_code_postal'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_code_postal'}#" name="test-Pcp" />							
		</p>
		<p id="Pville">
			<label for="#{smarty_trad value='lib_ville'}#">#{smarty_trad value='lib_ville'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_ville'}#" name="test-Pville" />							
		</p>
		<p id="Ppays">
			<label for="#{smarty_trad value='lib_pays'}#">#{smarty_trad value='lib_pays'}#* :</label>
			<select class="selectedTxt" id="#{smarty_trad value='lib_pays'}#"  name="test-Ppays">
				#{section name=sec3 loop=$TabPays}#
					<option value="#{$TabPays[sec3].id}#">#{$TabPays[sec3].libelle}#</option>
				#{/section}#
				
			</select>	
		</p>
		<p>
			<label for="#{smarty_trad value='lib_telephone'}#">#{smarty_trad value='lib_telephone'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_telephone'}#" name="test-contact_tel" />							
		</p>
		<p id="PFax">
			<label for="contact_fax">#{smarty_trad value='lib_fax'}# :</label>
			<input type="text" class="text" id="contact_fax" name="PFax" />							
		</p>
		<p id="Pniveau">
			<label for="#{smarty_trad value='lib_niveau_scolaire'}#">#{smarty_trad value='lib_niveau_scolaire'}#* :</label>
			<select id="#{smarty_trad value='lib_niveau_scolaire'}#" name="test-Pniveau[]" multiple>
				#{section name=sec5 loop=$TabNiveau}#
					<option value="#{$TabNiveau[sec5].id}#">#{$TabNiveau[sec5].libelle}#</option>
				#{/section}#
				
			</select>	
					
		</p>
		<p id="Petablissement">
			<label for="#{smarty_trad value='lib_type_etablissement'}#">#{smarty_trad value='lib_type_etablissement'}#* :</label>
			<select id="#{smarty_trad value='lib_type_etablissement'}#" name="test-Petablissement[]" multiple>
			#{section name=sec2 loop=$TabType}#
			<option value="#{$TabType[sec2].id}#">#{$TabType[sec2].libelle}#</option>
			#{/section}#
			</select>
		</p>
		<p>
			<label for="#{smarty_trad value='lib_presentation_projet'}#">#{smarty_trad value='lib_presentation_projet'}#* :</label>
			<span class="txtArea_container">
				<textarea id='#{smarty_trad value='lib_presentation_projet'}#' name='test-contact_commentaire' cols="20" rows="5" ></textarea>
			</span>				
		</p>
		
		<p class="validLine">
			<input type="submit" value="#{smarty_trad value='lib_submit'}#" />
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>
	</fieldset>						
</form>