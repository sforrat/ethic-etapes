					<dl id="filter_results">
						<dt>#{smarty_trad value='lib_affinez_recherche'}#</dt>
						<dd class="clear">
							<form action="#{$action}#" method="post">
								#{if $affichCapacite}#
								<fieldset>
									<label for="capacite_lits_filter">#{smarty_trad value='lib_capacite_accueil'}# :</label>
									<select id="capacite_lits_filter" name="capacite_lits_filter">
										<option value="">- #{smarty_trad value='lib_indifferent'}# -</option>
										#{section name=cap loop=$listeCapaciteLits}#
										<option value="#{$listeCapaciteLits[cap].id}#" #{if $listeCapaciteLits[cap].current}# selected="selected" #{/if}#>#{$listeCapaciteLits[cap].libelle}#</option>
										#{/section}#
									</select>
								</fieldset>	
								#{/if}#		
								#{if $affichEnvMontagne}#
								<fieldset>
									#{section name=cap loop=$listeEnvMontagne}#
										<input type="checkbox" class="checkbox" id="environnement_montagne_#{$listeEnvMontagne[cap].id}#_filter" name="environnement_montagne_#{$listeEnvMontagne[cap].id}#_filter" #{if $listeEnvMontagne[cap].current}# checked="checked" #{/if}#/>
										<label for="environnement_montagne_#{$listeEnvMontagne[cap].id}#_filter" class="labelCheckbox">#{$listeEnvMontagne[cap].libelle}#</label>											
									#{/section}#
								</fieldset>	
								#{/if}#	

								#{if $affichMulticritere}#
								<fieldset>
									<label>#{$lib_venez_plutot}# :</label>
									<input type="checkbox" class="checkbox" id="individuel" name="individuel" #{if $is_individuel_filter}# checked="checked" #{/if}#/>
									<label for="individuel" class="labelCheckbox">#{smarty_trad value="lib_seul_famille"}#</label>
									<input type="checkbox" class="checkbox" id="groupe" name="groupe" #{if $is_groupe_filter}# checked="checked" #{/if}#/>
									<label for="groupe" class="labelCheckbox noMargin">#{smarty_trad value="lib_en_groupe"}#</label>
								</fieldset>
								<fieldset>
									<label for="ambianceFilter">#{$lib_recherche_plutot}# :</label>
									<select id="ambianceFilter" name="amb_filter">
										<option value="">#{smarty_trad value='lib_indifferent'}#</option>	
										#{section name=amb loop=$listeAmbiance}#
											<option value="#{$listeAmbiance[amb].id}#" #{if $listeAmbiance[amb].current}# selected="selected" #{/if}#>#{$listeAmbiance[amb].libelle}#</option>						
										#{/section}#
									</select>
								</fieldset>							
								#{/if}#
															
								<p class="filter_valid"><input type="submit" value="#{smarty_trad value='lib_affinez_maj'}#" /></p>
							</form>
						</dd>
					</dl>