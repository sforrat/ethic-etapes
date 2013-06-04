					<dl id="filter_results">
						<dt>#{smarty_trad value='lib_affinez_recherche'}#</dt>
						<dd class="clear">
							<form action="#{$action}#" method="post">
							<input type="hidden" name="requestFilter" value="1"/>
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
									<label>#{smarty_trad value='lib_age_enfant'}# :</label>
									#{section name=age loop=$listeAgeEnfant}#
									<input type="checkbox" class="checkbox" id="tranche_age_#{$listeAgeEnfant[age].id}#_filter" name="tranche_age_#{$listeAgeEnfant[age].id}#_filter" #{if $listeAgeEnfant[age].current}# checked="checked" #{/if}#/>
									<label for="tranche_age_#{$listeAgeEnfant[age].id}#_filter" class="labelCheckbox">#{$listeAgeEnfant[age].libelle}#</label>		
									#{/section}#							
								</fieldset>															
								<p class="filter_valid"><input type="submit" value="#{smarty_trad value='lib_affinez_maj'}#" /></p>
							</form>
						</dd>
					</dl>