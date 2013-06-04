					<dl id="filter_results">
						<dt>#{smarty_trad value='lib_affinez_recherche'}#</dt>
						<dd class="clear">
							<form action="#{$action}#" method="post">
							<input type="hidden" name="requestFilter" value="1"/>
								<fieldset>
									<label>#{smarty_trad value='lib_niveau_scolaire'}# :</label>
									#{section name=nvs loop=$listeNiveauScolaire}#
									<input type="checkbox" class="checkbox" id="niveau_scolaire_#{$listeNiveauScolaire[nvs].id}#_filter"  name="niveau_scolaire_#{$listeNiveauScolaire[nvs].id}#_filter" #{if $listeNiveauScolaire[nvs].current}# checked="checked" #{/if}#/>
									<label for="niveau_scolaire_#{$listeNiveauScolaire[nvs].id}#_filter" class="labelCheckbox">#{$listeNiveauScolaire[nvs].libelle}# </label>		
									#{/section}#							
								</fieldset>	
								<fieldset>
									<label for="theme_filter">#{smarty_trad value='lib_theme_sejour'}# :</label>
									<select id="theme_filter" name="theme_filter">
										<option value="">- #{smarty_trad value='lib_indifferent'}# -</option>
										#{section name=the loop=$listeTheme}#
										<option value="#{$listeTheme[the].id}#" #{if $listeTheme[the].current}# selected="selected" #{/if}#>#{$listeTheme[the].libelle}#</option>
										#{/section}#
									</select>
								</fieldset>																
								<fieldset>
									<label for="region_filter">#{smarty_trad value='lib_region'}# :</label>
									<select id="region_filter" name="region_filter">
										<option value="">- #{smarty_trad value='lib_indifferent'}# -</option>
										#{section name=reg loop=$listeRegion}#
										<option value="#{$listeRegion[reg].id}#" #{if $listeRegion[reg].current}# selected="selected" #{/if}#>#{$listeRegion[reg].libelle}#</option>
										#{/section}#
									</select>
								</fieldset>
								<p class="filter_valid"><input type="submit" value="#{smarty_trad value='lib_affinez_maj'}#" /></p>
							</form>
						</dd>
					</dl>