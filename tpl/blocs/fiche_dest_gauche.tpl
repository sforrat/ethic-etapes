		<div id="ficheDest" class="clear">
			<h1>
				#{if $ecoLabel}#
				<img src="images/dyn/ecolabel.gif" alt="#{smarty_trad value='lib_ecolabel'}#" class="picto_dest tooltipped" title="#{smarty_trad value='lib_ecolabel'}#"/>
				#{/if}#						
				#{if $label != ""}#
				<img src="images/dyn/#{$label}#.gif" alt="#{$title_label}#" title="#{$title_label}#" class="picto_dest tooltipped"/>
				#{/if}#
				<img src="#{$lstCentre.picto_region}#" alt="region : #{$lstCentre.region}#" class="map_region" />
				<strong>#{$lstCentre.ville}#</strong>
				#{$lstCentre.libelle}#
			</h1>
	<div id="ficheDest_side">
	<img src="#{$lstCentre.image[0]}#" alt="#{$lstCentre.ville}#" id="placeholder" />
	#{if $nbImage > 1}#
	#{if $bPlus4Image}#
	<span id="prev_carousel_dest"><img src="images/common/btn_carActu_prev.gif" alt="#{smarty_trad value='lib_precedent'}#" /></span>
	<span id="next_carousel_dest"><img src="images/common/btn_carActu_next.gif" alt="#{smarty_trad value='lib_suivant'}#" /></span>
	#{/if}#
	<div class="inner_carousel">
		<ul>
			#{section loop=$lstCentre.image name=index}#
				<li>
					<a href="#{$lstCentre.image[index]}#">
						<img src="#{$lstCentre.image[index]}#" alt="#{$lstCentre.ville}#" height="31" />
					</a>
				</li>
			#{/section}#
		</ul>
	</div>
	#{/if}#
	<img src="#{$lstCentre.logo}#" alt="#{$lstCentre.libelle}#" class="logoDest" />
	<p class="adresseDest">
		#{$lstCentre.adresse}# - #{$lstCentre.code_postal}# #{$lstCentre.ville}# <br />
		T. #{$lstCentre.telephone}# - F. #{$lstCentre.fax}# <br />
		<a href="form_centre_contact.php?id_centre=#{$id_centre}#" class="popinLink_ajax">#{smarty_trad value='lib_nous_contacter_maj'}#</a> <br /> 
		#{if $lstCentre.site_internet != ""}#
			#{if $lstCentre.site_internet != "http://"}#
			#{smarty_trad value='lib_site_internet'}# : <a href="#{$lstCentre.site_internet}#" target="_blank">#{$lstCentre.site_internet}#</a>
			#{/if}#
		#{/if}#
	</p>
</div><!-- /#ficheDest_side -->