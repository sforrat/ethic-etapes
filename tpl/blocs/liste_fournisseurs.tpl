
					<ul>
						#{section name=index loop=$listeFCat}#
							<li><a href="#{$listeFCat[index].lien}#">#{$listeFCat[index].libelle}#</a></li>
						#{/section}#
					</ul>
				</div>
				<div class="supply">

						#{section name=index loop=$listeFCat}#
						<h3><a name="#{$listeFCat[index].libelle}#">#{$listeFCat[index].libelle}#</a></h3>
							<ul class="partners">
							#{section name=four loop=$listeFCat[index].fournisseurs}#	
								<li>
									<img src="#{$listeFCat[index].fournisseurs[four].logo}#" alt="#{$listeFCat[index].fournisseurs[four].libelle}#" />
									<h2>#{$listeFCat[index].fournisseurs[four].libelle}#</h2>
									<p>
									#{$listeFCat[index].fournisseurs[four].description}#						
									</p>
									<p><a href="#{$listeFCat[index].fournisseurs[four].lien}#" class="btn btn_blue popinLink_ajax cboxElement" onclick="return false;"><span>#{smarty_trad value='lib_en_savoir_plus'}#</span></a></p>
								</li>							
							#{/section}#	
							</ul>	
						#{/section}#					
				
				