					<dl id="filter_results">
						<dt>#{smarty_trad value='lib_affinez_recherche'}#</dt>
						<dd class="clear">
							<form action="#{$action}#" method="post">
							<input type="hidden" name="requestFilter" value="1"/>
								<fieldset>
									<label>#{smarty_trad value='lib_environnement'}# :</label>
									#{section name=env loop=$listeEnvironnement}#
									<input type="checkbox" class="checkbox" id="env_#{$listeEnvironnement[env].id}#_filter" name="env_#{$listeEnvironnement[env].id}#_filter" #{if $listeEnvironnement[env].current}# checked="checked" #{/if}#/>
									<label for="env_#{$listeEnvironnement[env].id}#_filter" class="labelCheckbox">#{$listeEnvironnement[env].libelle}#</label>		
									#{/section}#							
								</fieldset>															
								<fieldset>
									<label>#{smarty_trad value='lib_thematique_seminaire'}# :</label>
									#{section name=the loop=$listeThemeSeminaire}#
									<input type="checkbox" class="checkbox" id="theme_seminaire_#{$listeThemeSeminaire[the].id}#_filter" name="theme_seminaire_#{$listeThemeSeminaire[the].id}#_filter" #{if $listeThemeSeminaire[the].current}# checked="checked" #{/if}#/>
									<label for="theme_seminaire_#{$listeThemeSeminaire[the].id}#_filter" class="labelCheckbox">#{$listeThemeSeminaire[the].libelle}#</label>		
									#{/section}#							
								</fieldset>	
								<p class="filter_valid"><input type="submit" value="#{smarty_trad value='lib_affinez_maj'}#" /></p>
							</form>
						</dd>
					</dl>