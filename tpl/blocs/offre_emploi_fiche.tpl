<a id="backToResults" href="#{$url_retour_liste}#">#{smarty_trad value='lib_retour_offre_emploi'}#</a>	
<h1>#{$libelle}# - #{$contrat}#</h1>
<h2>#{$ville}# (#{$dept}#)</h2>
#{if $description != ""}#
<h3>#{smarty_trad value='lib_description_offre'}# :</h3>
<p>#{$description}#</p>
#{/if}#
<br />		

#{if $periode_texte != ""}#
<span class="bulletJob"><strong>#{$periode_texte}# :</strong> #{$periode}#</span> 
#{else}#
<span class="bulletJob"><strong>#{$date_debut_texte}# :</strong> #{$periode_debut}#</span> 
#{/if}#
<span class="bulletJob"><strong>#{smarty_trad value='lib_secteur'}# :</strong> #{$secteur}#</span>

<a href="#{$url_postuler}#" class="btn btn_orange"><span>#{smarty_trad value='lib_postuler_poste'}#</span></a>

<dl class="jobContact">
	<dt>#{smarty_trad value='lib_personne_contacter_maj'}#</dt>
	<dd>
		<strong>#{$contact_nom}# #{$contact_prenom}#<br />
		#{if $contact_email != ""}##{smarty_trad value='lib_adresse_mail'}# : #{$contact_email}#<br />#{/if}#
		#{if $contact_telephone != ""}#T. #{$contact_telephone}##{/if}#
		#{if $contact_fax != ""}# - F. #{$contact_fax}##{/if}# <br />
	</dd>
</dl>