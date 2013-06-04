<div id="push_newsletter">
	<h2>#{smarty_trad value='lib_newsletter_maj'}#</h2>
	#{smarty_trad value='lib_texte_bloc_newsletter'}# <br />
	<form action="#{$url}#" method="POST">
		<p class="input_newsletter">
			<input id="email" name="email" type="text" class="text" value="#{smarty_trad value='lib_votre_adresse_mail'}#" />
			<input type="image" src="images/common/btn_carActu_next.gif" alt="#{smarty_trad value='lib_valider'}#"/>
		</p>
	</form>						
</div>	