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
    		#{include_php file="blocs/blocContact.php"}# 
    		#{include_php file="blocs/blocBrochure.php"}# 
    		#{include_php file="blocs/blocNewsletter.php"}# 
    	</div>
    	<div id="inner_content">	
			#{include_php file="blocs/blocAccessibilite.php"}#				
			<h1>#{$titre}#</h1>
			<div class="edito">
				#{include_php file="blocs/content.php"}# 
			</div>
    		#{include_php file="blocs/presentation_projet.php"}#     		
    	</div>
    </div>
    
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#
