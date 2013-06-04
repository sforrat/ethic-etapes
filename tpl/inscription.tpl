#{include file="blocs/header.tpl"}#
	
	#{**************************************************************}#
	#{*		BLOC HEADER = LOGO + PAVE ACCES ACCES CLIENT		   *}#
	#{**************************************************************}#
	
	#{***************************}#
	#{*	BLOC MENUS HORIZONTAUX	*}#
	#{***************************}#	
	#{include_php file="blocs/menus.php"}#
	#{include_php file="blocs/chemin_fer.php"}#	
	
	#{*************************}#
	#{*			CONTENT		  *}#
	#{*************************}#	
	
			<div id="content" class="clear">				
				<div id="sidebar">		
					<img src="images/common/visu_espace#{$type}#.png" alt="espace membre" />
				</div><!-- /#sidebar -->
				<div id="inner_content">	
					<!--<ul class="controlBox clear">
						<li>
							<button type="button" id="biggerText">T+</button><button type="button" id="smallerText">T-</button>
						</li>
						<li class="print">
							<a href="#">Imprimer</a>
						</li>
						<li class="comment">
							<a href="#">Laisser votre avis</a>
						</li>
					</ul>-->						
					<h1>#{$titre}#</h1>
					#{include_php file="blocs/content.php"}# 
					#{if $errorMsg != ''}#
						<br/><span style="color:red;">#{$errorMsg}#</span>
					#{/if}#
					<form action="inscription.php" method="post" onsubmit="VerifFormInscriptionPresse(); return false;" id="formPresse">			
						<fieldset class="skinThisForm">				
							<p>
								<label for="nom_media">#{smarty_trad value='lib_nom_media'}# * :</label>
								<input type="text" class="text" id="nom_media" name="nom_media" />								
							</p>
							<p>
								<label>#{smarty_trad value='lib_type_media'}# * :</label>
								#{foreach from=$TabTypesMedia key=id item=libelle}#				
									<input name="type_media" type="radio" id="#{$id}#" value="#{$id}#" /><label for="#{$id}#" class="labelRadio">#{$libelle}#</label>
								#{/foreach}#							
							</p>
							<p>
								<label>#{smarty_trad value='lib_public'}# * :</label>
								#{foreach from=$TabTypesPublic key=id item=libelle}#				
									<input name="types_public[]" type="checkbox" id="#{$id}#" value="#{$id}#" />#{$libelle}#
								#{/foreach}#							
							</p>
							
							<p>
								<label>#{smarty_trad value='lib_civilite'}# * :</label>
								#{foreach from=$TabCivilite key=id item=libelle}#				
									<input name="civilite" type="radio" id="#{$id}#" value="#{$id}#" /><label for="#{$id}#" class="labelRadio">#{$libelle}#</label>
								#{/foreach}#							
							</p>
							<p>
								<label for="nom_contact">#{smarty_trad value='lib_nom_prenom'}# * :</label>
								<input type="text" class="text" id="nom_contact" name="nom_contact" />
							</p>	
							<p>
								<label for="fonction">#{smarty_trad value='lib_fonction'}# * :</label>
								<input type="text" class="text" id="fonction" name="fonction" />
							</p>		
							<p>
								<label for="email">#{smarty_trad value='lib_adresse_mail'}# * :</label>
								<input type="text" class="text" id="email" name="email" "/>								
							</p>
							<p>
								<label for="telephone">#{smarty_trad value='lib_telephone'}# * :</label>
								<input type="text" class="text" id="telephone" name="telephone" />
							</p>			
							<p class="validLine">
								<input type="submit" name="confirm_inscription" value="#{smarty_trad value='lib_submit'}#" />
							</p>					
						</fieldset>						
					</form>					
				</div><!-- /#inner_content-->
			</div><!-- /#content -->
			
    #{include_php file="blocs/bottom.php"}#<br /><br />				
	
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#	