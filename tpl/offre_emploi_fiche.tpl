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
			
			<div id="jobDetails">
    			#{include_php file="blocs/offre_emploi_fiche.php"}# 
    		</div><!-- /#jobDetails -->		
    	</div>
    </div>
    
    #{include_php file="blocs/bottom.php"}#<br /><br />
    
	#{*******************************}#
	#{*		BLOC FOOTER				*}#
	#{*******************************}#
	
#{include_php file="blocs/footer.php"}#			