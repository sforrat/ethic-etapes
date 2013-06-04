<form id="frmContactCollectiv" name="frmContactCollectiv" method="post">
	<fieldset class="popinForm">
	<p>
		<label for="slctContactCollectivCiv">#{smarty_trad value='lib_civilite'}# : </label>			
		<select id="slctContactCollectivCiv" name="slctContactCollectivCiv">
			#{section loop=$listeCivilite name=index}#
				<option value="#{$listeCivilite[index].id}#">#{$listeCivilite[index].libelle}#</option>
			#{/section}#
		</select>
	</p>
	<p>	
		<label for="txtContactCollectivNom">#{smarty_trad value='lib_nom'}#* : </label>							
		<input type="text" id="txtContactCollectivNom" name="txtContactCollectivNom" class="text" />
	</p>
	<p>
		<label for="txtContactCollectivPrenom">#{smarty_trad value='lib_prenom'}#* : </label>						
		<input type="text" id="txtContactCollectivPrenom" name="txtContactCollectivPrenom" class="text" />
	</p>
	<p>
		<label for="txtContactCollectivEmail">#{smarty_trad value='lib_email'}#* : </label>						
		<input type="text" id="txtContactCollectivEmail" name="txtContactCollectivEmail" class="text" />
	</p>
	<p>
		<label for="txtContactCollectivNomCollec">#{smarty_trad value='lib_collectivite'}#* : </label>						
		<input type="text" id="txtContactCollectivNomCollec" name="txtContactCollectivNomCollec" class="text" />
	</p>
	<p>
		<label for="txtContactCollectivFonction">#{smarty_trad value='lib_fonction'}# : </label>						
		<input type="text" id="txtContactCollectivFonction" name="txtContactCollectivFonction" class="text" />
	</p>
	<p>
		<label for="txtContactCollectivAdresse">#{smarty_trad value='lib_adresse'}# :</label>	
		<input type="text" id="txtContactCollectivAdresse" name="txtContactCollectivAdresse" class="text" />
		<label for="txtContactCollectivCp">#{smarty_trad value='lib_code_postal'}#* :</label>				
		<input type="text" id="txtContactCollectivCp" name="txtContactCollectivCp" class="text" />
	</p>
	<p>
		<label for="txtContactCollectivVille">#{smarty_trad value='lib_ville'}#* :	</label>						
		<input type="text" id="txtContactCollectivVille" name="txtContactCollectivVille" class="text" />
		<label for="slctContactCollectivPays">#{smarty_trad value='lib_pays'}#* : </label>	
		<select id="slctContactCollectivPays" name="slctContactCollectivPays">
			#{section loop=$listePays name=index}#
				<option  #{if $listePays[index].selected == "1"}#selected#{/if}# value="#{$listePays[index].id}#">#{$listePays[index].libelle}#</option>
			#{/section}#
		</select>
	</p>
	<p>
		<label for="txtContactCollectivTel">#{smarty_trad value='lib_telephone'}# :</label>				
		<input type="text" id="txtContactCollectivTel" name="txtContactCollectivTel" class="text" />
		<label for="txtContactCollectivFax">#{smarty_trad value='lib_fax'}# : </label>								
		<input type="text" id="txtContactCollectivFax" name="txtContactCollectivFax" class="text" />
	</p>
	<p>
		<label for="txtaContactCollectivCommQuest">#{smarty_trad value='lib_commentaires_questions'}# : 	</label>							
		<textarea cols="20" rows="5" id="txtaContactCollectivCommQuest" name="txtaContactCollectivCommQuest"></textarea>
	</p>
	<p class="choiceNL spacedUp">
		<label>#{smarty_trad value='lib_newsletters'}# : </label><br />
		#{section name=sec1 loop=$TabTypeNews}#
			<input type="checkbox" class="radio" name="test-Newsletter" id="#{$TabTypeNews[sec1].id}#" value="#{$TabTypeNews[sec1].id}#" /><label for="#{$TabTypeNews[sec1].id}#">#{$TabTypeNews[sec1].libelle}#</label><br />
		#{/section}#
	</p>
	<p class="validLine">
		<input type="button" value="#{smarty_trad value='lib_submit'}#" onClick="checkFormCentreContactCollectivite();" />
	</p>
	<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
	<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>	
	</fieldset>
</form>