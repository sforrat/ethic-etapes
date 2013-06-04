#{include file="blocs/header.tpl"}#
	
	<style type="text/css">
		#ficheDest_side .inner_carousel , #footer , #backTop , #searchBox , .btn {display:none !important;}
		#wrapper {width:700px;}
		#ficheDest_side , #ficheDest_main {float:none;width:100%;}
		#blocSlider li .blocSlider_content {display:block !important;width:95%;}
		#blocSlider li h3 {background-image:none;}
		.accessGuide {width:95% !important;}
		#ficheDest_side .logoDest {margin:15px 0;}
		#ficheDest_side .adresseDest {text-align:left;}
		.innerPopin .accessGuide .locate img {float:none;display:block;margin-bottom:20px;}
	</style>	
	#{*************************}#
	#{*			CONTENT		  *}#
	#{*************************}#
	   	
			<div id="content" class="clear">
					
			
				<div id="inner_content">	
					<ul class="controlBox clear">
						<li class="print">
							<a href="javascript:window.print()" target="_blank">#{smarty_trad value='lib_imprimer'}#</a>
						</li>
					</ul>					
					#{include_php file="blocs/fiche_dest_gauche.php"}#
					#{include_php file="blocs/fiche_dest_principale.php"}#
					#{include_php file="blocs/fiche_centre_tarifs.php"}#
					#{include_php file="blocs/fiche_centre_localisation.php"}#
				</div><!-- /#inner_content-->

			</div><!-- /#content -->
    
    
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
		<script type="text/javascript"> 		
		
			initGMap(); // init de la google map une fois que le contenu a fini de charger dans la popin
		
	</script>
#{include_php file="blocs/footer.php"}#
