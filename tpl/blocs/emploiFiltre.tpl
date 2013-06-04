<dl id="filter_results"> 
	<dt>#{smarty_trad value='lib_affinez_recherche'}#</dt> 
	<dd class="clear"> 
		<form action="#{$urlForm}#" method="POST"> 
			<fieldset> 
				<label for="secteur_filter">#{smarty_trad value='lib_secteur_activite'}# :</label> 
				<select id="secteur_filter" name="secteur_filter"> 
					<option value="0">- #{smarty_trad value='lib_indifferent'}# -</option> 
					#{section name=sec1 loop=$TabSecteur}#
					<option value="#{$TabSecteur[sec1].id}#" #{$TabSecteur[sec1].selected}#>#{$TabSecteur[sec1].libelle}#</option>
					#{/section}#
				</select> 
			</fieldset> 
			<fieldset> 
				<label for="region_filter">#{smarty_trad value='lib_region'}# :</label> 
				<select id="region_filter" name="region_filter"> 
					<option value="0">- #{smarty_trad value='lib_indifferent'}# -</option> 
					#{section name=sec1 loop=$TabRegion}#
					<option value="#{$TabRegion[sec1].id}#" #{$TabRegion[sec1].selected}#>#{$TabRegion[sec1].libelle}#</option>
					#{/section}#
				</select> 
			</fieldset> 
			<fieldset> 
				<label for="contractType_filter">#{smarty_trad value='lib_type_contrat'}# :</label> 
				<select id="contractType_filter" name="contractType_filter"> 
					<option value="0">- #{smarty_trad value='lib_indifferent'}# -</option> 
					#{section name=sec1 loop=$TabContrat}#
					<option value="#{$TabContrat[sec1].id}#" #{$TabContrat[sec1].selected}#>#{$TabContrat[sec1].libelle}#</option>
					#{/section}#							
				</select> 
			</fieldset> 
			<p class="filter_valid"><input type="submit" value="#{smarty_trad value='lib_affinez_maj'}#" /></p> 
		</form> 
	</dd> 
</dl>