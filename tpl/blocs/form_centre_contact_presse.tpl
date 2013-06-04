<form id="frmContactPresse" name="frmContactPresse" method="post">
	<fieldset class="popinForm">
	<p>
		<label for="slctContactPresseCiv">#{smarty_trad value='lib_civilite'}# : </label>				
		<select id="slctContactPresseCiv" name="slctContactPresseCiv">
			#{section loop=$listeCivilite name=index}#
				<option value="#{$listeCivilite[index].id}#">#{$listeCivilite[index].libelle}#</option>
			#{/section}#
		</select>
	</p>
	<p>
		<label for="txtContactPresseNom">#{smarty_trad value='lib_nom'}#* : </label>						
		<input type="text" id="txtContactPresseNom" name="txtContactPresseNom" class="text" />
	</p>
	<p>
		<label for="txtContactPressePrenom">#{smarty_trad value='lib_prenom'}#* : </label>					
		<input type="text" id="txtContactPressePrenom" name="txtContactPressePrenom" class="text" />
	</p>
	<p>
		<label for="txtContactPresseEmail">#{smarty_trad value='lib_email'}#* : </label>					
		<input type="text" id="txtContactPresseEmail" name="txtContactPresseEmail" class="text" />
	</p>
	<p>
		<label for="txtContactPresseMedia">#{smarty_trad value='lib_media'}# : </label>					
		<input type="text" id="txtContactPresseMedia" name="txtContactPresseMedia" class="text" />
	</p>
	<p>
		<label for="txtContactPresseTel">#{smarty_trad value='lib_telephone'}# :</label>			
		<input type="text" id="txtContactPresseTel" name="txtContactPresseTel" class="text" />
	</p>
	<p>
		<label for="txtContactPresseFax">#{smarty_trad value='lib_fax'}# : </label>							
		<input type="text" id="txtContactPresseFax" name="txtContactPresseFax" class="text" />
	</p>
	<p>
	<label for="txtaContactPresseCommQuest">#{smarty_trad value='lib_commentaires_questions'}# : </label>						
	<textarea cols="20" rows="5" id="txtaContactPresseCommQuest" name="txtaContactPresseCommQuest"></textarea>
	</p>
	<p class="choiceNL spacedUp">
		<label>#{smarty_trad value='lib_newsletters'}# : </label><br />
		#{section name=sec1 loop=$TabTypeNews}#
			<input type="checkbox" class="radio" name="Newsletter" id="#{$TabTypeNews[sec1].id}#" value="#{$TabTypeNews[sec1].id}#" /><label for="#{$TabTypeNews[sec1].id}#">#{$TabTypeNews[sec1].libelle}#</label><br />
		#{/section}#
	</p>
	<p class="validLine">
		<input type="button" value="#{smarty_trad value='lib_submit'}#" onClick="checkFormCentreContactPresse();" />
	</p>
	<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
	<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>	
	</fieldset>
</form>