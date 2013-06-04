#{if $nbFilsKids > 0 || $nbFilsCompany > 0 || $nbFilsTourism > 0}#
<h1>#{smarty_trad value='lib_offres_ethic_etapes'}#</h1>
<ul id="push_offers" class="clear">
	#{if $nbFilsKids > 0}#
	<li class="offer_kids">
		<img src="images/dyn/visu_offer_kids.jpg" alt="Offres découvertes jeunes" class="visu_push_offer" />
		<p>
			#{section name=kids loop=$listeFilsKids}#
			<a href="#{$listeFilsKids[kids].lien}#"><strong> #{$listeFilsKids[kids].libelle}#</strong></a><br />
			#{/section}#
		</p>
	</li>
	#{/if}#
	#{if $nbFilsCompany > 0}#
	<li class="offer_company">
		<img src="images/dyn/visu_offer_company.jpg" alt="Offres découvertes entreprise" class="visu_push_offer" />
		<p>
			#{section name=comp loop=$listeFilsCompany}#
			<a href="#{$listeFilsCompany[comp].lien}#"><strong> #{$listeFilsCompany[comp].libelle}#</strong></a><br />
			#{/section}#					
		</p>
		<!--<div class="disableLayer"></div>-->
	</li>
	#{/if}#
	#{if $nbFilsTourism > 0}#
	<li class="offer_tourism">
		<img src="images/dyn/visu_offer_tourism.jpg" alt="Offres découvertes tourisme" class="visu_push_offer" />
		<p>
			#{section name=tour loop=$listeFilsTourism}#
			<a href="#{$listeFilsTourism[tour].lien}#"><strong> #{$listeFilsTourism[tour].libelle}#</strong></a><br />
			#{/section}#								
		</p>
		<!--<div class="disableLayer"></div>-->
	</li>
	#{/if}#
</ul><!-- /#push_offers -->
#{/if}#
<div id="ficheDest_results" class="skin_#{$type}#"><!-- 3 class de skin differentes en fonction de la couleur voulue -->
	<h2>#{$titreSejour}#</h2>
<!--#{include_php file="blocs/moteur_recherche_sejour.php"}#-->
#{include_php file="blocs/resultat_recherche.php"}#		
</div>
