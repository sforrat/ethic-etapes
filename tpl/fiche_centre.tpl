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
				<a id="backToResults" href="javascript:history.back();" >#{smarty_trad value='lib_retour_resultat_recherche'}#</a>
				<div id="moteurResa">
					#{include_php file="blocs/recherche_geographique.php"}#
				</div>
				
				#{include_php file="blocs/blocActuAndBonPlan.php"}#			

				#{include_php file="blocs/blocNewsletter_simple.php"}#
			</div>	
			
			
				<div id="inner_content">	
					<ul class="controlBox clear">
						<li>
							<button type="button" id="biggerText">T+</button><button type="button" id="smallerText">T-</button>
						</li>
						<li class="print">
							<a href="#" onclick="window.open('#{$urlPrint}#', 'Imprimer_votre_recherche', 'height=550, width=717, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=yes, status=no'); return false;" target="_blank">#{smarty_trad value='lib_imprimer'}#</a>
						</li>
						<li class="comment">
							<a href="laissez_avis.php?id_centre=#{$id_centre}#" class="popinLink_ajax">#{smarty_trad value='lib_avis'}#</a>
						</li>	
					</ul>					
					#{include_php file="blocs/fiche_dest_gauche.php"}#
					#{include_php file="blocs/fiche_dest_principale.php"}#
					#{include_php file="blocs/fiche_dest_offres.php"}#
				</div><!-- /#inner_content-->

			</div><!-- /#content -->
    
    
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#
