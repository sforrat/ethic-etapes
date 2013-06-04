<form id="frmContactParticul" name="frmContactParticul" method="post">
	<fieldset class="popinForm">
		<p>
			<label for="slctContactParticulCiv">#{smarty_trad value='lib_civilite'}# :</label> 				
			<select id="slctContactParticulCiv" name="slctContactParticulCiv">
				#{section loop=$listeCivilite name=index}#
					<option value="#{$listeCivilite[index].id}#">#{$listeCivilite[index].libelle}#</option>
				#{/section}#
			</select>
		</p>
		<p>
			<label for="txtContactParticulNom">#{smarty_trad value='lib_nom'}#* :</label>  						
			<input type="text" id="txtContactParticulNom" name="txtContactParticulNom" class="text" />
		</p>
		<p>
			<label for="txtContactParticulPrenom">#{smarty_trad value='lib_prenom'}#* : </label> 					
			<input type="text" id="txtContactParticulPrenom" name="txtContactParticulPrenom" class="text"  />
		</p>
		<p>
			<label for="txtContactParticulEmail">#{smarty_trad value='lib_email'}#* :</label>  					
			<input type="text" id="txtContactParticulEmail" name="txtContactParticulEmail" class="text" />
		</p>
		<p>
			<label for="txtContactParticulAdresse">#{smarty_trad value='lib_adresse'}# :</label> 
			<input type="text" id="txtContactParticulAdresse" name="txtContactParticulAdresse"class="text" />
			<label for="txtContactParticulCp">#{smarty_trad value='lib_code_postal'}#* :</label> 			
			<input type="text" id="txtContactParticulCp" name="txtContactParticulCp" class="text" />
		</p>
		<p>
			<label for="txtContactParticulVille">#{smarty_trad value='lib_ville'}#* :	</label> 					
			<input type="text" id="txtContactParticulVille" name="txtContactParticulVille" class="text" />
			<label for="slctContactParticulPays">#{smarty_trad value='lib_pays'}#* :</label>  
			<select id="slctContactParticulPays" name="slctContactParticulPays">
				#{section loop=$listePays name=index}#
					<option  #{if $listePays[index].selected == "1"}#selected#{/if}# value="#{$listePays[index].id}#">#{$listePays[index].libelle}#</option>
				#{/section}#
			</select>
		</p>
		<p>
			<label for="txtContactParticulTel">#{smarty_trad value='lib_telephone'}# :</label> 			
			<input type="text" id="txtContactParticulTel" name="txtContactParticulTel" class="text" />
		</p>
		<p>
			<label for="txtaContactParticulCommQuest">#{smarty_trad value='lib_commentaires_questions'}# : 	</label> 						
			<textarea cols="20" rows="5" id="txtaContactParticulCommQuest" name="txtaContactParticulCommQuest"></textarea>
		</p>
		<p class="choiceNL spacedUp">
			<label>#{smarty_trad value="lib_newsletters"}#* :</label><br />
			#{section name=sec1 loop=$TabTypeNews}#
				<input type="checkbox" class="radio" name="Newsletter" id="#{$TabTypeNews[sec1].id}#" value="#{$TabTypeNews[sec1].id}#" /><label for="#{$TabTypeNews[sec1].id}#">#{$TabTypeNews[sec1].libelle}#</label><br />
			#{/section}#
		</p>
		<p class="validLine">
			<input type="button" value="#{smarty_trad value='lib_submit'}#" onClick="checkFormCentreContactParticulier();" />
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>		
	</fieldset>
</form>