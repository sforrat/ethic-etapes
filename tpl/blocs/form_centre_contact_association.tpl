<form id="frmContactAssociat" name="frmContactAssociat" method="post">
	<fieldset class="popinForm">
		<p>
			<label for="">#{smarty_trad value='lib_civilite'}# : </label>				
			<select id="slctContactAssociatCiv" name="slctContactAssociatCiv">
				#{section loop=$listeCivilite name=index}#
					<option value="#{$listeCivilite[index].id}#">#{$listeCivilite[index].libelle}#</option>
				#{/section}#
			</select>
		</p>
		<p>
			<label for="txtContactAssociatNom">#{smarty_trad value='lib_nom'}#* : </label>	 						
			<input type="text" id="txtContactAssociatNom" name="txtContactAssociatNom" class="text" />
		</p>
		<p>
			<label for="txtContactAssociatPrenom">#{smarty_trad value='lib_prenom'}#* :  </label>						
			<input type="text" id="txtContactAssociatPrenom" name="txtContactAssociatPrenom" class="text"/>
		</p>
		<p>
			<label for="txtContactAssociatEmail">#{smarty_trad value='lib_email'}#* : </label>	 					
			<input type="text" id="txtContactAssociatEmail" name="txtContactAssociatEmail" class="text"/>
		</p>
		<p>		
			<label for="txtContactAssociatNomOrg">#{smarty_trad value='lib_nom_association'}#* : </label>	 					
			<input type="text" id="txtContactAssociatNomOrg" name="txtContactAssociatNomOrg" class="text"/>
		</p>
		<p>
			<label for="slctContactAssociatDiscipline">#{smarty_trad value='lib_discipline_sportive'}#* : </label>	 
			<select id="slctContactAssociatDiscipline" name="slctContactAssociatDiscipline">
			#{section loop=$listeDiscipline name=index}#
				<option value="#{$listeDiscipline[index].id}#">#{$listeDiscipline[index].libelle}#</option>
			#{/section}#
			</select>
		</p>	
		<p>
			<label for="txtContactAssociatAdresse">#{smarty_trad value='lib_adresse'}# : </label>	
			<input type="text" id="txtContactAssociatAdresse" name="txtContactAssociatAdresse" class="text" />
			<label for="txtContactAssociatCp">#{smarty_trad value='lib_code_postal'}#* : </label>				
			<input type="text" id="txtContactAssociatCp" name="txtContactAssociatCp" class="text" />
		</p>
		<p>
			<label for="txtContactAssociatVille">#{smarty_trad value='lib_ville'}#* : </label>							
			<input type="text" id="txtContactAssociatVille" name="txtContactAssociatVille" class="text" />
			<label for="slctContactAssociatPays">#{smarty_trad value='lib_pays'}#* : </label>	 
			<select  id="slctContactAssociatPays" name="slctContactAssociatPays">
				#{section loop=$listePays name=index}#
					<option #{if $listePays[index].selected == "1"}#selected#{/if}# value="#{$listePays[index].id}#">#{$listePays[index].libelle}#</option>
				#{/section}#
			</select>
		</p>
		<p>
			<label for="txtContactAssociatTel">#{smarty_trad value='lib_telephone'}# : </label>				
			<input type="text" id="txtContactAssociatTel" name="txtContactAssociatTel" class="text" />
			<label for="txtContactAssociatFax">#{smarty_trad value='lib_fax'}# : </label>	 							
			<input type="text" id="txtContactAssociatFax" name="txtContactAssociatFax" class="text" />
		</p>
		<p>
			<label for="txtaContactAssociatCommQuest">#{smarty_trad value='lib_commentaires_questions'}# : </label>	 							
			<textarea cols="20" rows="5" id="txtaContactAssociatCommQuest" name="txtaContactAssociatCommQuest"></textarea>
		</p>
		<p class="choiceNL spacedUp">
			<label>#{smarty_trad value='lib_newsletters'}# : </label><br />
			#{section name=sec1 loop=$TabTypeNews}#
				<input type="checkbox" class="radio" name="Newsletter" id="#{$TabTypeNews[sec1].id}#" value="#{$TabTypeNews[sec1].id}#" /><label for="#{$TabTypeNews[sec1].id}#">#{$TabTypeNews[sec1].libelle}#</label><br />
			#{/section}#
		</p>
		<p class="validLine">
			<input type="button" value="#{smarty_trad value='lib_submit'}#" onClick="checkFormCentreContactAssociation();" />
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>		
	</fieldset>
</form>