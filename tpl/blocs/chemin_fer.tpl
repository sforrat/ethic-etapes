<p id="breadcrumb">
#{section name=sec1 loop=$CHEMIN_FER}#
#{if $CHEMIN_FER[sec1].URL != ""}#
<a href='#{$CHEMIN_FER[sec1].URL}#' #{if $CHEMIN_FER[sec1].TARGET!="" }#target="#{$CHEMIN_FER[sec1].TARGET}#"#{/if}# title="#{$CHEMIN_FER[sec1].TITLE}#">#{$CHEMIN_FER[sec1].LIBELLE}#</a>
#{else}#
	#{if $CHEMIN_FER[sec1].SELECTED == 1 }#
	#{* Rubrique en cours *}#
	<em>#{$CHEMIN_FER[sec1].LIBELLE}#</em>
	#{else}#
	#{* pas rubrique en cours mais lien pas autoris� *}#
	<span>#{$CHEMIN_FER[sec1].LIBELLE}#</span>
	#{/if}#
#{/if}#
#{if $CHEMIN_FER[sec1].SELECTED != 1 }#
&nbsp;
#{/if}#
#{/section}#
</p>

<!--
<p id="breadcrumb">
	<a href="#">Accueil</a> <a href="#">A chacun son séjour</a> <em>Séjours touristiques groupes</em>
</p>
-->