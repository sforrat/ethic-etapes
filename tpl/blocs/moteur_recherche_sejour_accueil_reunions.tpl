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
									<label for="capacite_reu_filter">#{smarty_trad value='lib_capacite_accueil_reunion'}# :</label>
									<select id="capacite_reu_filter" name="capacite_reu_filter">
										<option value="">- #{smarty_trad value='lib_indifferent'}# -</option>
										#{section name=cap loop=$listeCapaciteReu}#
										<option value="#{$listeCapaciteReu[cap].id}#" #{if $listeCapaciteReu[cap].current}# selected="selected" #{/if}#>#{$listeCapaciteReu[cap].libelle}#</option>
										#{/section}#
									</select>
								</fieldset>		
								<p class="filter_valid"><input type="submit" value="#{smarty_trad value='lib_affinez_maj'}#" /></p>
							</form>
						</dd>
					</dl>