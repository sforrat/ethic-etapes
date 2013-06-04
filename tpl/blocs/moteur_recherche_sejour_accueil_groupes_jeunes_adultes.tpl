					<dl id="filter_results">
						<dt>#{smarty_trad value='lib_affinez_recherche'}#</dt>
						<dd class="clear">
							<form action="#{$action}#" method="post">
							<input type="hidden" name="requestFilter" value="1"/>
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
								<fieldset>
									<label>#{smarty_trad value='lib_environnement'}# :</label>
									#{section name=env loop=$listeEnvironnement}#
									<input type="checkbox" class="checkbox" id="env_#{$listeEnvironnement[env].id}#_filter" name="env_#{$listeEnvironnement[env].id}#_filter" #{if $listeEnvironnement[env].current}# checked="checked" #{/if}#/>
									<label for="env_#{$listeEnvironnement[env].id}#_filter" class="labelCheckbox">#{$listeEnvironnement[env].libelle}#</label>		
									#{/section}#							
								</fieldset>	
								#{if $affichDiscipline}#	
								<fieldset>
									<label for="activite_filter">#{smarty_trad value='lib_discipline_sportive'}# :</label>
									<select id="activite_filter" name="activite_filter">
										<option value="">- #{smarty_trad value='lib_indifferent'}# -</option>
										#{section name=dis loop=$listeDiscipline}#
										<option value="#{$listeDiscipline[dis].id}#" #{if $listeDiscipline[dis].current}# selected="selected" #{/if}#>#{$listeDiscipline[dis].libelle}#</option>
										#{/section}#
									</select>
								</fieldset>		
								#{/if}#																				
								<p class="filter_valid"><input type="submit" value="#{smarty_trad value='lib_affinez_maj'}#" /></p>
							</form>
						</dd>
					</dl>