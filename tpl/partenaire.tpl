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
    	
    	<div id="wideContent">
			<h1>#{$titre}#</h1>
			#{include_php file="blocs/content.php"}# 
			#{include_php file="blocs/partenaire.php"}# 
		</div>			
					
    </div>
    
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#
