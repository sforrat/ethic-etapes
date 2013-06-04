<form id="frmContactFuturEE" name="frmContactFuturEE" method="post">
	<fieldset class="popinForm">
		<p>
			<label for="slctContactFuturEECiv">#{smarty_trad value='lib_civilite'}# : </label>				
			<select id="slctContactFuturEECiv" name="slctContactFuturEECiv">
				#{section loop=$listeCivilite name=index}#
					<option value="#{$listeCivilite[index].id}#">#{$listeCivilite[index].libelle}#</option>
				#{/section}#
			</select>
		</p>
		<p>
			<label for="txtContactFuturEENom">#{smarty_trad value='lib_nom'}#* : </label>							
			<input type="text" id="txtContactFuturEENom" name="txtContactFuturEENom" class="text" />
		</p>
		<p>
			<label for="txtContactFuturEEPrenom">#{smarty_trad value='lib_prenom'}#* : </label>						
			<input type="text" id="txtContactFuturEEPrenom" name="txtContactFuturEEPrenom" class="text" />
		</p>
		<p>
			<label for="txtContactFuturEEEmail">#{smarty_trad value='lib_email'}#* :</label>	 					
			<input type="text" id="txtContactFuturEEEmail" name="txtContactFuturEEEmail" class="text" />
		</p>
		<p>
			<label for="txtContactFuturEENomEquipmt">#{smarty_trad value='lib_nom_equipement'}#* : </label>						
			<input type="text" id="txtContactFuturEENomEquipmt" name="txtContactFuturEENomEquipmt" class="text" />
		</p>
		<p>
			<label for="txtContactFuturEEFonction">#{smarty_trad value='lib_fonction'}# : </label>						
			<input type="text" id="txtContactFuturEEFonction" name="txtContactFuturEEFonction" class="text" />
		</p>
		<p>
			<label for="txtContactFuturEEAdresse">#{smarty_trad value='lib_adresse'}# :</label>	
			<input type="text" id="txtContactFuturEEAdresse" name="txtContactFuturEEAdresse" class="text" />
			<label for="txtContactFuturEECp">#{smarty_trad value='lib_code_postal'}#* :</label>				
			<input type="text" id="txtContactFuturEECp" name="txtContactFuturEECp" class="text" />
		</p>
		<p>
			<label for="txtContactFuturEEVille">#{smarty_trad value='lib_ville'}#* :	</label>						
			<input type="text" id="txtContactFuturEEVille" name="txtContactFuturEEVille" class="text" />
			<label for="slctContactFuturEEPays">#{smarty_trad value='lib_pays'}#* : </label>	
			<select id="slctContactFuturEEPays" name="slctContactFuturEEPays">
				#{section loop=$listePays name=index}#
					<option  #{if $listePays[index].selected == "1"}#selected#{/if}# value="#{$listePays[index].id}#">#{$listePays[index].libelle}#</option>
				#{/section}#
			</select>
		</p>
		<p>
			<label for="txtContactFuturEETel">#{smarty_trad value='lib_telephone'}#* :</label>				
			<input type="text" id="txtContactFuturEETel" name="txtContactFuturEETel" class="text" />
			<label for="txtContactFuturEEFax">#{smarty_trad value='lib_fax'}# : </label>								
			<input type="text" id="txtContactFuturEEFax" name="txtContactFuturEEFax" class="text" />
		</p>
		<p>
			<label for="txtaContactFuturEEPresentStruct">#{smarty_trad value='lib_presentation_structure'}# :</label>	 							
			<textarea cols="20" rows="5" id="txtaContactFuturEEPresentStruct" name="txtaContactFuturEEPresentStruct"></textarea> 
		</p>
		<p class="validLine">
			<input type="button" value="#{smarty_trad value='lib_submit'}#" onClick="checkFormCentreContactFuturEE();" />
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#.</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>		
	</fieldset>
</form>