	  <table width="100%" cellspacing="1" cellpadding="0" border="0" bgcolor="<?=get_inter_color($MenuTableBgColor,0.25)?>">
        <tr> 
          <td> 
            <table width="100%" cellspacing="0" border="0" cellpadding="1">
              <tr bgcolor="<?=get_inter_color($MenuBgColor,0.1)?>"> 
                <td class="chemin"> 
                  <?
		// MODIF LAC 08/01/04 : On affiche le chemin pour l'administrateur uniquement
		if (($TableDef)&&($_SESSION['ses_profil_user']<=2)) {		
				?>
                  <?=$MenuCurrentItemTitle;?>
                  > <a href="<?=NomFichier($_REQUEST['PHP_SELF'],0)."?TableDef=$TableDef&idItem=$idItem&DisplayMode=$DisplayMode&DisplayMenu=$DisplayMenu&Page=0&AscDesc=&ordre=";?>"> 
                  <?echo $CurrentPageTitle;?>
                  </a> 
				<? 
				if (GetModeNameFromMode($mode,$ModeCol,$TitreCol)) {
					echo " > ";	
				}

				echo GetModeNameFromMode($mode,$ModeCol,$TitreCol);

				if (GetModeNameFromMode($mode,$ModeCol,$TitreCol)) {
					echo " ".$item;
				}

		}
		else {
			echo ($inc_toolbar_option_welcome.$StyleName.".");
		}
		?>
                </td>
                <td align="right" class="chemin"> 
                  <?
			if ($_SESSION['ses_profil_user']) {
			?>
				  &lt;&nbsp;<a href="bo.php?Home=1"><?=$inc_toolbar_option_retour?></a>&nbsp;&nbsp;&nbsp;&nbsp; 
                  x&nbsp;<a href="<?=NomFichier($_REQUEST['PHP_SELF'],0)."?SessionClose=1"?>"><?=$inc_toolbar_option_exit?></a>&nbsp;&nbsp;&nbsp;&nbsp; 
            <?
			}
			//Affichage de la date du jour
			echo "<i>".CDate(date("Y-m-d"),3)."</i>";
			?>
                </td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
<?
get_bo_toolbar_separateur();
?> 
