<div id="ficheDest_main">
<ul class="rating">
	<li>
		<span>#{smarty_trad value='lib_classement'}# : </span>

		#{section name=class loop=$listeClassement}#
			<img src="#{$listeClassement[class].img}#" alt="#{$listeClassement[class].title}#" title="#{$listeClassement[class].title}#" class="tooltipped" />
		#{/section}#
	</li>
	<li>
		<span>#{smarty_trad value='lib_classement_1'}# : </span>
		#{section name=class1  loop=$listeClassement_1}#
			<img src="#{$listeClassement_1[class1].img}#" alt="#{$listeClassement_1[class1].title}#" title="#{$listeClassement_1[class1].title}#" class="tooltipped" />
		#{/section}#
	</li>
</ul>
#{$lstCentre.description}#

#{if !empty($lstCentre.url_hostelworld)}#
<p class="bookIt">
	<a href="form_reservation_accueil_individuel.php?id_centre=#{$id_centre}#" class="btn btn_teal popinLink_ajax"><span>#{smarty_trad value='lib_reserver'}#</span></a>
</p>
#{else}#
<p class="bookIt">
	<a href="fiche_centre_disponibilite.php?id_centre=#{$id_centre}#" class="btn btn_teal popinLink_ajax"><span>#{smarty_trad value='lib_reserver'}#</span></a>
</p>
#{/if}#

<p class="ficheDest_btn">
	<a href="form_centre_contact.php?id_centre=#{$id_centre}#" class="btn btn_orange popinLink_ajax"><span>#{smarty_trad value='lib_nous_contacter_maj'}#</span></a>
	<a href="fiche_centre_tarifs.php?id_centre=#{$id_centre}#" class="btn btn_green popinLink_ajax"><span>#{smarty_trad value='lib_tarifs'}#</span></a>
	#{*<a href="fiche_centre_disponibilite.php?id_centre=#{$id_centre}#" class="btn btn_blue popinLink_ajax"><span>#{smarty_trad value='lib_disponibilite_maj'}#</span></a>*}#
	<a href="fiche_centre_localisation.php?id_centre=#{$id_centre}#" class="btn popinLink_Gmap"><span>#{smarty_trad value='lib_localiser'}#</span></a>
</p>
<ul id="blocSlider">							
	<li>
		<h3>#{smarty_trad value='lib_centre_theme_centre'}#</h3>
		<div class="blocSlider_content">
			#{if $is_centrelesplus}#
				<strong>#{smarty_trad value='lib_plus_centre'}# :</strong><br />
				#{section loop=$listeCentreLesPlus name=index}#
						 - #{$listeCentreLesPlus[index].libelle}#<br />
				#{/section}#<br />
			#{/if}#
			
			<strong>#{smarty_trad value='lib_centre_capacite'}# :</strong><br />
			#{if $is_chambre}# 
				- #{smarty_trad value='lib_nb_chambre'}# : #{$lstCentre.nb_chambre}# <br /> 
			#{/if}#
			
			#{if $is_lit}# 
				- #{smarty_trad value='lib_nb_lit'}# : #{$lstCentre.nb_lit}# <br />
			#{/if}#
			
			#{if $is_couvert}# 
				- #{smarty_trad value='lib_nb_couvert'}# : #{$lstCentre.nb_couvert}# <br />
			#{/if}#
			<br />
			
			#{if $is_centreservice}#
				<strong>#{smarty_trad value='lib_centre_service'}# :</strong><br />
				#{section loop=$listeCentreService name=index}#
					<img src="#{$listeCentreService[index].libelle_visuel}#" width="30" height="30" alt="#{$listeCentreService[index].libelle}#" title="#{$listeCentreService[index].libelle}#" class="tooltipped" />&nbsp;
				#{/section}#
			#{/if}#
		</div>
	</li>
	<li>
		<h3>#{smarty_trad value='lib_centre_theme_activites'}#</h3>
		<div class="blocSlider_content">
			<strong>#{smarty_trad value='lib_centre_activites'}# :</strong><br />
			#{section loop=$listeCentreActivite name=index}#
				<img src="#{$listeCentreActivite[index].libelle_visuel}#" width="30" height="30" alt="#{$listeCentreActivite[index].libelle}#" title="#{$listeCentreActivite[index].libelle}#" class="tooltipped" />&nbsp;
			#{/section}#<br />
			<br />
			
			<strong>#{smarty_trad value='lib_centre_equipements'}# :</strong><br />
			#{section loop=$listeCentreEquipement name=index}#
				#{$listeCentreEquipement[index]}#<br />
			#{/section}#<br />
		</div>
	</li>
	<li>
		<h3>#{smarty_trad value='lib_centre_theme_infos'}#</h3>
		<div class="blocSlider_content">
			<strong> #{smarty_trad value='lib_region_presentation'}# : </strong><br />
			#{$lstCentre.presentation_region}#<br />
			<br />
			#{if $is_site_touristique}#
				<strong>#{smarty_trad value='lib_site_touristique'}# : </strong><br />
				#{section loop=$listeCentreSiteTour name=index}#
					- <a href="#{$listeCentreSiteTour[index].lien}#" target="_blank">#{$listeCentreSiteTour[index].libelle}#</a> <br />
				#{/section}#
				<br />
			#{/if}#
		</div>
	</li>
	<li>
		<h3>#{smarty_trad value='lib_centre_theme_avis'}#</h3>
		<div class="blocSlider_content">
		#{if $is_avis_internaute}#
			#{section loop=$listeCentreAvisIntern name=index}#
				<strong>#{$listeCentreAvisIntern[index].prenom}#&nbsp;#{$listeCentreAvisIntern[index].nom}# - <img class="tooltipped" src="images/#{$listeCentreAvisIntern[index].etoile}#" alt="#{$listeCentreAvisIntern[index].note}#" title="#{$listeCentreAvisIntern[index].note}#" /></strong><br />
				-&nbsp;#{$listeCentreAvisIntern[index].date}#<br />
				<i>"#{$listeCentreAvisIntern[index].commentaire}#"</i><br />
				<br />
			#{/section}#
		#{/if}#
		</div>
	</li>
</ul><!-- /#blocSlider -->
</div><!-- /#ficheDest_main -->
</div><!-- /#ficheDest -->	