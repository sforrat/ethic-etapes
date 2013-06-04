<form id="frmContactPartenaire" name="frmContactPartenaire" method="post">
	<fieldset class="popinForm">
	<p>
	<label for="slctContactPartenaireCiv">#{smarty_trad value='lib_civilite'}# : 	</label>			
		<select id="slctContactPartenaireCiv" name="slctContactPartenaireCiv">
			#{section loop=$listeCivilite name=index}#
				<option value="#{$listeCivilite[index].id}#">#{$listeCivilite[index].libelle}#</option>
			#{/section}#
		</select>
	</p>
	<p>
		<label for="txtContactPartenaireNom">#{smarty_trad value='lib_nom'}#* : </label>						
		<input type="text" id="txtContactPartenaireNom" name="txtContactPartenaireNom" class="text" />
	</p>
	<p>
		<label for="txtContactPartenairePrenom">#{smarty_trad value='lib_prenom'}#* : </label>					
		<input type="text" id="txtContactPartenairePrenom" name="txtContactPartenairePrenom" class="text" />
	</p>
	<p>
		<label for="txtContactPartenaireEmail">#{smarty_trad value='lib_email'}#* : </label>					
		<input type="text" id="txtContactPartenaireEmail" name="txtContactPartenaireEmail" class="text" />
	</p>
	<p>
		<label for="txtContactPartenaireStructure">#{smarty_trad value='lib_nom_structure'}#* :</label> 					
		<input type="text" id="txtContactPartenaireStructure" name="txtContactPartenaireStructure" class="text" />
	</p>
	<p>
		<label for="txtContactPartenaireTel">#{smarty_trad value='lib_telephone'}# :</label>			
		<input type="text" id="txtContactPartenaireTel" name="txtContactPartenaireTel" class="text" />
	</p>
	<p>
		<label for="txtContactPartenaireFax">#{smarty_trad value='lib_fax'}# : </label>							
		<input type="text" id="txtContactPartenaireFax" name="txtContactPartenaireFax" class="text" />
	</p>
	<p>
		<label for="txtaContactPartenaireCommQuest">#{smarty_trad value='lib_commentaires_questions'}# : 	</label>						
		<textarea cols="20" rows="5" id="txtaContactPartenaireCommQuest" name="txtaContactPartenaireCommQuest"></textarea>
	</p>
	<p class="choiceNL spacedUp">
		<label>#{smarty_trad value='lib_newsletters'}# : </label><br />
		#{section name=sec1 loop=$TabTypeNews}#
			<input type="checkbox" class="radio" name="Newsletter" id="#{$TabTypeNews[sec1].id}#" value="#{$TabTypeNews[sec1].id}#" /><label for="#{$TabTypeNews[sec1].id}#">#{$TabTypeNews[sec1].libelle}#</label><br />
		#{/section}#
	</p>
	<p class="validLine">
		<input type="button" value="#{smarty_trad value='lib_submit'}#" onClick="checkFormCentreContactPartenaire();" />
	</p>
	<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
	<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>	
	</fieldset>
</form>