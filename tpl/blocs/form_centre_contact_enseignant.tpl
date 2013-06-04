<form id="frmContactEnseignant" name="frmContactEnseignant" method="post">
	<fieldset class="popinForm">
		<p>
			<label for="slctContactEnseignantCiv">#{smarty_trad value='lib_civilite'}# : </label>			
			<select id="slctContactEnseignantCiv" name="slctContactEnseignantCiv">
				#{section loop=$listeCivilite name=index}#
					<option value="#{$listeCivilite[index].id}#">#{$listeCivilite[index].libelle}#</option>
				#{/section}#
			</select>
		</p>
		<p>
			<label for="txtContactEnseignantNom">#{smarty_trad value='lib_nom'}#* :</label> 						
			<input type="text" id="txtContactEnseignantNom" name="txtContactEnseignantNom" class="text" />
			<label for="txtContactEnseignantPrenom">#{smarty_trad value='lib_prenom'}#* : </label>				
			<input type="text" id="txtContactEnseignantPrenom" name="txtContactEnseignantPrenom" class="text" />
		</p>		
		<p>
			<label for="txtContactEnseignantEcole">#{smarty_trad value='lib_nom_ecole'}#* :</label>
			<input type="text" id="txtContactEnseignantEcole" name="txtContactEnseignantEcole" class="text" />
			<label for="txtContactEnseignantEmail">#{smarty_trad value='lib_email'}#* :</label> 					
			<input type="text" id="txtContactEnseignantEmail" name="txtContactEnseignantEmail" class="text" />
		</p>		
		<p>
			<label for="txtContactEnseignantAdresse">#{smarty_trad value='lib_adresse'}# :</label>					
			<input type="text" id="txtContactEnseignantAdresse" name="txtContactEnseignantAdresse" class="text" />
			<label for="txtContactEnseignantCp">#{smarty_trad value='lib_code_postal'}#* :</label>		
			<input type="text" id="txtContactEnseignantCp" name="txtContactEnseignantCp" class="text" />
		</p>		
		<p>
			<label for="txtContactEnseignantVille">#{smarty_trad value='lib_ville'}#* :	</label>				
			<input type="text" id="txtContactEnseignantVille" name="txtContactEnseignantVille" class="text" />
			<label for="slctContactEnseignantPays">#{smarty_trad value='lib_pays'}#* : </label>
			<select id="slctContactEnseignantPays" name="slctContactEnseignantPays">
				#{section loop=$listePays name=index}#
					<option  #{if $listePays[index].selected == "1"}#selected#{/if}# value="#{$listePays[index].id}#">#{$listePays[index].libelle}#</option>
				#{/section}#
			</select>
		</p>		
		<p>
			<label for="txtContactEnseignantTel">#{smarty_trad value='lib_telephone'}# :</label>			
			<input type="text" id="txtContactEnseignantTel" name="txtContactEnseignantTel" class="text" />
			<label for="txtContactEnseignantFax">#{smarty_trad value='lib_fax'}# : </label>						
			<input type="text" id="txtContactEnseignantFax" name="txtContactEnseignantFax" class="text"/>
		</p>		
		<p>
			<label for="slctContactEnseignantNivScol">#{smarty_trad value='lib_niveau_scolaire'}#* :</label>
			<select id="slctContactEnseignantNivScol" name="slctContactEnseignantNivScol">
			#{section loop=$listeNiveauScolaire name=index}#
				<option value="#{$listeNiveauScolaire[index].id}#">#{$listeNiveauScolaire[index].libelle}#</option>
			#{/section}#
			</select>
		</p>
		<p>
			<label for="slctContactEnseignantEtablissType">#{smarty_trad value='lib_type_etablissement'}#* : </label>
			<select id="slctContactEnseignantEtablissType" name="slctContactEnseignantEtablissType">
			#{section loop=$listeEtablissementType name=index}#
				<option value="#{$listeEtablissementType[index].id}#">#{$listeEtablissementType[index].libelle}#</option>
			#{/section}#
			</select>
		</p>
		<p>
			<label for="txtaContactEnseignantCommQuest">#{smarty_trad value='lib_commentaires_questions'}# : </label>							
			<textarea cols="20" rows="5" id="txtaContactEnseignantCommQuest" name="txtaContactEnseignantCommQuest"></textarea>
		</p>
		<p class="choiceNL spacedUp">
			<label>#{smarty_trad value='lib_newsletters'}# : </label><br />
			#{section name=sec1 loop=$TabTypeNews}#
				<input type="checkbox" class="radio" name="Newsletter" id="#{$TabTypeNews[sec1].id}#" value="#{$TabTypeNews[sec1].id}#" /><label for="#{$TabTypeNews[sec1].id}#">#{$TabTypeNews[sec1].libelle}#</label><br />
			#{/section}#
		</p>
		<p class="validLine">
			<input type="button" value="#{smarty_trad value='lib_submit'}#" onClick="checkFormCentreContactEnseignant();" />
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>		
	</fieldset>
</form>