<form id="frmContactAutre" name="frmContactAutre" method="post">
	<fieldset class="popinForm">
		<p>
			<label for="slctContactAutreCiv">#{smarty_trad value='lib_civilite'}# : </label>		
			<select id="slctContactAutreCiv" name="slctContactAutreCiv">
				#{section loop=$listeCivilite name=index}#
					<option value="#{$listeCivilite[index].id}#">#{$listeCivilite[index].libelle}#</option>
				#{/section}#
			</select>
		</p>
		<p>
			<label for="txtContactAutreNom">#{smarty_trad value='lib_nom'}#* : 	</label>					
			<input type="text" id="txtContactAutreNom" name="txtContactAutreNom" class="text" />
		</p>
		<p>
			<label for="txtContactAutrePrenom">#{smarty_trad value='lib_prenom'}#* : </label>					
			<input type="text" id="txtContactAutrePrenom" name="txtContactAutrePrenom" class="text" />
		</p>
		<p>
			<label for="txtContactAutreEmail">#{smarty_trad value='lib_email'}#* : </label>					
			<input type="text" id="txtContactAutreEmail" name="txtContactAutreEmail" class="text" />
		</p>
		<p>
			<label for="txtContactAutreStructure">#{smarty_trad value='lib_nom_structure'}#* : </label>					
			<input type="text" id="txtContactAutreStructure" name="txtContactAutreStructure" class="text" />
		</p>
		<p>
			<label for="txtContactAutreAdresse">#{smarty_trad value='lib_adresse'}# :</label>
			<input type="text" id="txtContactAutreAdresse" name="txtContactAutreAdresse" class="text" />
			<label for="txtContactAutreCp">#{smarty_trad value='lib_code_postal'}#* :</label>			
			<input type="text" id="txtContactAutreCp" name="txtContactAutreCp" class="text" />
		</p>
		<p>
			<label for="txtContactAutreVille">#{smarty_trad value='lib_ville'}#* :	</label>					
			<input type="text" id="txtContactAutreVille" name="txtContactAutreVille" class="text" />
			<label for="slctContactAutrePays">#{smarty_trad value='lib_pays'}#* : </label>
			<select id="slctContactAutrePays" name="slctContactAutrePays">
				#{section loop=$listePays name=index}#
					<option  #{if $listePays[index].selected == "1"}#selected#{/if}# value="#{$listePays[index].id}#">#{$listePays[index].libelle}#</option>
				#{/section}#
			</select>
		</p>		
		<p>
			<label for="txtContactAutreTel">#{smarty_trad value='lib_telephone'}# :</label>			
			<input type="text" id="txtContactAutreTel" name="txtContactAutreTel" class="text" />
			<label for="txtContactAutreFax">#{smarty_trad value='lib_fax'}# : </label>							
			<input type="text" id="txtContactAutreFax" name="txtContactAutreFax" class="text" />
		</p>
		<p>
			<label for="txtaContactAutreCommQuest">#{smarty_trad value='lib_commentaires_questions'}# : </label>							
			<textarea cols="20" rows="5" id="txtaContactAutreCommQuest" name="txtaContactAutreCommQuest"></textarea>
		</p>
			<p class="choiceNL spacedUp">
			<label>#{smarty_trad value='lib_newsletters'}# :</label><br />
			#{section name=sec1 loop=$TabTypeNews}#
				<input type="checkbox" class="radio" name="test-Newsletter" id="#{$TabTypeNews[sec1].id}#" value="#{$TabTypeNews[sec1].id}#" /><label for="#{$TabTypeNews[sec1].id}#">#{$TabTypeNews[sec1].libelle}#</label><br />
			#{/section}#
		</p>
		<p class="validLine">
			<input type="button" value="#{smarty_trad value='lib_submit'}#" onClick="checkFormCentreContactAutre();" />
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>		
	</fieldset>
</form>