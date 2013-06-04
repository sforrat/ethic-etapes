<h2>#{smarty_trad value='lib_recherche_multicriteres_maj'}#</h2>
<form action="#{$action_recherche_multicriteres}#" method="post">
	<p class="clear">
		<label>#{smarty_trad value="lib_venez_plutot_maj"}# :</label>
		<input type="checkbox" class="checkbox" id="individuel" name="individuel" #{if $is_individuel_filter}# checked="checked" #{/if}#/>
		<label for="individuel" class="labelCheckbox">#{smarty_trad value="lib_seul_famille"}#</label>
		<input type="checkbox" class="checkbox" id="groupe" name="groupe" #{if $is_groupe_filter}# checked="checked" #{/if}#/>
		<label for="groupe" class="labelCheckbox noMargin">#{smarty_trad value="lib_en_groupe"}#</label>
	</p>
	<p class="clear fixIE">	
		<label for="searchingFor">#{smarty_trad value="lib_recherche_plutot_maj"}# :</label>
		<select id="searchingFor" name="amb_filter">
			<option value="">#{smarty_trad value='lib_indifferent'}#</option>	
			#{section name=amb loop=$listeAmbiance}#
				<option value="#{$listeAmbiance[amb].id}#" #{if $listeAmbiance[amb].current}# selected="selected" #{/if}#>#{$listeAmbiance[amb].libelle}#</option>						
			#{/section}#
		</select>
	</p>
	<p class="clear valid_moteurResa">
		<input type="submit" value="#{smarty_trad value="lib_recherchez_maj"}#" />
	</p>
</form>