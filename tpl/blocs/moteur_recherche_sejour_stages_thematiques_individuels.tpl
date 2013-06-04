					<dl id="filter_results">
						<dt>#{smarty_trad value='lib_affinez_recherche'}#</dt>
						<dd class="clear">
							<form action="#{$action}#" method="post">
							<input type="hidden" name="requestFilter" value="1"/>
								<fieldset>							
									<label for="region_filter">#{smarty_trad value='lib_region'}# :</label>
									<select id="region_filter" name="region_filter">
										<option value="">- #{smarty_trad value='lib_indifferent'}# -</option>
										#{section name=reg loop=$listeRegion}#
										<option value="#{$listeRegion[reg].id}#" #{if $listeRegion[reg].current}# selected="selected" #{/if}#>#{$listeRegion[reg].libelle}#</option>
										#{/section}#
									</select>
								</fieldset>
								<fieldset>							
									<label for="stage_theme_filter">#{smarty_trad value='lib_thematique_stage'}# :</label>
									<select id="stage_theme_filter" name="stage_theme_filter">
										<option value="">- #{smarty_trad value='lib_indifferent'}# -</option>
										#{section name=the loop=$listeThemeStage}#
										<option value="#{$listeThemeStage[the].id}#" #{if $listeThemeStage[the].current}# selected="selected" #{/if}#>#{$listeThemeStage[the].libelle}#</option>
										#{/section}#
									</select>
								</fieldset>											
								<fieldset>
									<label>#{smarty_trad value='lib_periode'}# :</label>
									#{section name=per loop=$listePeriode}#
									<input type="checkbox" class="checkbox" id="periode_disponibilite_#{$listePeriode[per].id}#_filter" name="periode_disponibilite_#{$listePeriode[per].id}#_filter" #{if $listePeriode[per].current}# checked="checked" #{/if}#/>
									<label for="periode_disponibilite_#{$listePeriode[per].id}#_filter" class="labelCheckbox">#{$listePeriode[per].libelle}#</label>		
									#{/section}#							
								</fieldset>									
								<p class="filter_valid"><input type="submit" value="#{smarty_trad value='lib_affinez_maj'}#" /></p>
							</form>
						</dd>
					</dl>