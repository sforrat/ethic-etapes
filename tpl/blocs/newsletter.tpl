<form action="processing/sendNewsletter.action.php" method="POST" name="formContact" id="formContact" onsubmit="checkForm('formContact'); return false;" >					
	#{if $messageOK == 1}#
	<p class="messageForm">#{$message}#</p>
	#{/if}#
	
	<fieldset class="skinThisForm">	
		
		<p>
			<label>#{smarty_trad value='lib_civilite'}#* :</label>
			#{section name=sec1 loop=$TabCivilite}#				
					<input name="test-Civilite" type="radio" id="#{$TabCivilite[sec1].libelle}#" value="#{$TabCivilite[sec1].libelle}#" /><label for="#{$TabCivilite[sec1].libelle}#" class="labelRadio">#{$TabCivilite[sec1].libelle}#</label>
			#{/section}#							
		</p>
		
		<p>
			<label for="test-contact_name">#{smarty_trad value='lib_nom_prenom'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_nom_prenom'}#" name="test-contact_name" />								
		</p>
		
		<p>
			<label for="test-email-contact_mail">#{smarty_trad value='lib_adresse_mail'}#* :</label>
			<input type="text" class="text" id="#{smarty_trad value='lib_adresse_mail'}#" name="test-email-contact_mail" value="#{$email}#"/>								
		</p>
		
		
		<p class="choiceNL spacedUp">
			#{smarty_trad value="lib_type_newsletter_ee"}#* :<br />
			#{section name=sec1 loop=$TabTypeNews}#
				<input type="checkbox" class="radio" name="test-Newsletter[]" id="#{$TabTypeNews[sec1].id}#" value="#{$TabTypeNews[sec1].id}#" /><label for="#{$TabTypeNews[sec1].id}#">#{$TabTypeNews[sec1].libelle}#</label><br />
			#{/section}#
			#{*
			<input type="radio" class="radio" id="getGP"  name="test-Newsletter" value="#{smarty_trad value='lib_type_newsletter_grand_public'}#" /><label for="getGP">#{smarty_trad value='lib_type_newsletter_grand_public'}#</label><br />
			<input type="radio" class="radio" id="getScolaire"  name="test-Newsletter" value="#{smarty_trad value='lib_type_newsletter_scolaire'}#" /><label for="getScolaire">#{smarty_trad value='lib_type_newsletter_scolaire'}#</label><br />
			<input type="radio" class="radio" id="getReunion"  name="test-Newsletter" value="#{smarty_trad value='lib_type_newsletter_reunion'}#" /><label for="getReunion">#{smarty_trad value='lib_type_newsletter_reunion'}#</label><br />
			*}#
	</p>	
		<p class="validLine">
			<input type="submit" value="#{smarty_trad value='lib_submit'}#" />
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>
	</fieldset>						
</form>