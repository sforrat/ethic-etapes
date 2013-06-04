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
					<img src="images/common/visu_espaceMembre.png" alt="espace membre" />
				</div><!-- /#sidebar -->
				<div id="inner_content">	
					<!--<ul class="controlBox clear">
						<li>
							<button type="button" id="biggerText">T+</button><button type="button" id="smallerText">T-</button>
						</li>
						<li class="print">
							<a href="#">#{smarty_trad value='lib_imprimer'}#</a>
						</li>
						<li class="comment">
							<a href="#">#{smarty_trad value='lib_avis'}#</a>
						</li>
					</ul>-->						
					<h1>#{$titre}#</h1>
					#{include_php file="blocs/content.php"}# 
					#{if $errorMsg != ''}#
						<br/><span style="color:red;">#{$errorMsg}#</span>
					#{/if}#
					#{if $successMsg != ''}#
						<br/><span>#{$successMsg}#</span>
					#{/if}#					
					<form action="#{$action}#">			
						<fieldset class="skinThisForm">								
							<p>
								<label for="login">#{smarty_trad value='lib_adresse_mail'}# :</label>
								<input type="text" class="text" id="login" name="login" value="#{$login}#"/>								
							</p>				
							<p class="validLine">
								<input type="submit" value="#{smarty_trad value='lib_envoyer_mdp'}#" />
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