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
    	#{include_php file="blocs/menuGaucheEdito.php"}# 
    	<div id="inner_content">	
			#{include_php file="blocs/blocAccessibilite.php"}#				
			<h1>#{$titre}#</h1>
			<div class="edito">
    		#{include_php file="blocs/content.php"}# 
    		#{include_php file="blocs/nouveau_projet.php"}# 
    		</div>
    	</div>
    </div>
    
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#
