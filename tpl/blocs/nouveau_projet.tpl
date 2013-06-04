<form action="processing/sendNewProjet.action.php" method="POST" name="formContact" id="formContact" onsubmit="checkForm('formContact'); return false;" >					
	#{if $messageOK == 1}#
	<p class="messageForm">#{$message}#</p>
	#{/if}#
	
	<fieldset class="skinThisForm">	
		<p>
			<label>#{smarty_trad value='lib_civilite'}#* :</label>
			#{section name=sec1 loop=$TabCivilite}#				
				<input name="test-Civilite" type="radio" id="#{$TabCivilite[sec1].libelle}#" value="#{$TabCivilite[sec1].libelle}#" />
				<label class="labelRadio" for="#{$TabCivilite[sec1].libelle}#">#{$TabCivilite[sec1].libelle}#</label>
			#{/section}#							
		</p>
		
		<p>
			<label for="test-contact_name">#{smarty_trad value='lib_nom_prenom'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_prenom'}#" name="test-contact_name" />								
		</p>
		
		<p>
			<label for="test-email-contact_mail">#{smarty_trad value='lib_adresse_mail'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_adresse_mail'}#" name="test-email-contact_mail"/>								
		</p>

		<p id="Pequipement"">
			<label for="test-contact_equipement">#{smarty_trad value='lib_nom_equipement'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_equipement'}#" name="test-Pequipement" />								
		</p>
		<p id="PFonction"">
			<label for="test-contact_fonction">#{smarty_trad value='lib_fonction'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_fonction'}#" name="test-PFonction" />								
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
					<option #{if $TabPays[sec3].selected=="1"}#selected#{/if}# value="#{$TabPays[sec3].id}#">#{$TabPays[sec3].libelle}#</option>
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