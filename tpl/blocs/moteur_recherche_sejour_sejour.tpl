					<dl id="filter_results">
						<dt>#{smarty_trad value='lib_affinez_recherche'}#</dt>
						<dd class="clear">
							<form action="#{$action}#" method="post">		
              <input type="hidden" name="requestFilter" value="1"/>					
								<fieldset>
									<label>#{smarty_trad value='lib_type_sejour'}# :</label>
									#{section name=typ loop=$listeTypeSejour}#
									<input type="checkbox" class="checkbox" id="type_sejour_#{$listeTypeSejour[typ].id}#_filter" name="type_sejour_#{$listeTypeSejour[typ].id}#_filter" #{if $listeTypeSejour[typ].current}# checked="checked" #{/if}#/>
									<label for="type_sejour_#{$listeTypeSejour[typ].id}#_filter" class="labelCheckbox">#{$listeTypeSejour[typ].libelle}#</label>		
									#{/section}#							
								</fieldset>															
								<p class="filter_valid"><input type="submit" value="#{smarty_trad value='lib_affinez_maj'}#" /></p>
							</form>
						</dd>
					</dl>