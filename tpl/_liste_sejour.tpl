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
				
			#{include_php file="blocs/bloc_gauche.php"}#

				<div id="inner_content">	
					
					#{include_php file="blocs/resultat_recherche.php"}#
					
				</div><!-- /#inner_content-->
			</div><!-- /#content -->
    
    
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#
