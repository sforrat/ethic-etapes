<script type="text/javascript">
$(function() {
	$("#datepicker").datepicker({
		showOn: 'button',
		buttonImage: 'images/calendar.gif',
		buttonImageOnly: true
	});
});
</script>

<h1>#{$titre}#</h1>
<form action="processing/candidature.action.php" method="post" class="formGeneric" enctype="multipart/form-data" id="formPostuler" onsubmit="verifCandidature();return false;">
	#{if $erreur == 1}#
	<p class="error">#{smarty_trad value='lib_erreur_champ_obligatoire'}#</p>
	#{/if}#
	#{if $ok == 1}#
	<p class="error">#{smarty_trad value='lib_candidature_ok'}#</p>
	#{/if}#
	<p>#{smarty_trad value='lib_texte_form_candidature'}#</p>					
	<fieldset class="skinThisForm">
		#{if $offre != ""}#
		<p>
			<label for="postulerReference">#{smarty_trad value='lib_offre'}# * :</label>
			<input type="text" class="text" value="#{$offre}#" id="postulerReference" name="postulerReference" readonly="true" />
			<input type="hidden"  value="#{$idoffre}#" id="postulerOffre" name="postulerOffre" />
			<input type="hidden"  value="#{$idsecteur}#" id="postulerSecteur" name="postulerSecteur" />
		</p>
		<p>
			<label for="postulerRegion">#{smarty_trad value='lib_region'}# * :</label>
			<input type="text" class="text" value="#{$region}#" id="postulerRegion" name="postulerRegion" readonly="true" /> 
			<input type="hidden" value="#{$idregion}#" id="postulerIdRegion" name="postulerIdRegion" />
		</p>
		#{else}#
		<p>
			<label for="postulerIntitule">#{smarty_trad value='lib_secteur'}# * :</label>
			<select id="postulerSecteur" name="postulerSecteur">
			#{section name=sec1 loop=$TabSecteur}#
				<option value="#{$TabSecteur[sec1].id}#">#{$TabSecteur[sec1].libelle}#</option>
			#{/section}#
			</select>
		</p>
		<p>
			<label for="postulerIdRegion">#{smarty_trad value='lib_region'}# * :</label>
			<select id="postulerIdRegion" name="postulerIdRegion">
			#{section name=sec2 loop=$TabRegion}#
				<option value="#{$TabRegion[sec2].id}#">#{$TabRegion[sec2].libelle}#</option>
			#{/section}#
			</select>
		</p>
		#{/if}#
		<p>
			<label for="datepicker">#{smarty_trad value='lib_date_debut_embauche'}# * :</label>
			<input type="text" class="text" id="datepicker" value="#{$date}#" name="datepicker" />
		</p>
		<p>
			<label for="postulerNom">#{smarty_trad value='lib_nom'}# * :</label>
			<input type="text" class="text" value="#{$nom}#" id="postulerNom" name="postulerNom" />
		</p>
		<p>
			<label for="postulerPrenom">#{smarty_trad value='lib_prenom'}# * :</label>
			<input type="text" class="text" value="#{$prenom}#" id="postulerPrenom" name="postulerPrenom" />
		</p>
		<p>
			<label for="postulerEmail">#{smarty_trad value='lib_email'}# * :</label>
			<input type="text" class="text" value="#{$email}#" id="postulerEmail" name="postulerEmail" />
		</p>
		<p>
			<label for="postulerTelephone">#{smarty_trad value='lib_telephone'}# * :</label>
			<input type="text" class="text" value="#{$tel}#" id="postulerTelephone" name="postulerTelephone" />&nbsp; Ex : 0435635223
		</p>
		<p>
			<label for="postulerMessage">#{smarty_trad value='lib_presentation_projet'}# * :</label>
			<span class="txtArea_container">
				<textarea id="postulerMessage" name="postulerMessage" class="inputTextarea">#{$message}#</textarea>
			</span>
		</p>
		<p>
			<label for="postulerCV">#{smarty_trad value='lib_dl_cv'}# * :</label>
			<input type="file" class="" value="" id="postulerCV" name="postulerCV" />
		</p>
		<p>
			<label for="postulerMotivation">#{smarty_trad value='lib_dl_motivation'}# * :</label>
			<input type="file" class="" value="" id="postulerMotivation" name="postulerMotivation" />
		</p>	
		<p class="validLine">
			<input type="submit" name="btn" value="#{$lib_postuler}#" class="inputSubmit">
		</p>
		<p class="mandatoryFields">* #{smarty_trad value='lib_champ_obligatoire'}#</p>
		<p class="disclaimer">#{smarty_trad value='lib_mention_cnil'}#</p>
	</fieldset>	
</form>
