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
	#{*			CONTENT		        *}#
	#{*************************}#
	<div id="content" class="clear blogContainer">
    	<div id="wideContent">
			<iframe id="blogIframe" name="myframe" class="autoHeight" scrolling="no" frameborder="0"  src="http://www.ethic-etapes.fr/forum/index.php"></iframe>
		</div>	
				
    </div>
    
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#
