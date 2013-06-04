<tr>
  <td colspan="3">
  <hr /><strong>Détail de l’hébergement :</strong><br /><br />
  <?php
    echo "<table width='500px'>";
    echo "<tr>
              <td style=\"text-align:center\">Nb. Chambre</td>
              <td style=\"text-align:center\">Nb. lit</td>
              <td style=\"text-align:center\">&nbsp;</td>
              <td style=\"text-align:center\" colspan='2'>Lavabo, douche et WC dans la chambre</td>
              <td style=\"text-align:center\" colspan='2'>Lavabo + douche dans la chambre</td>
              <td style=\"text-align:center\" colspan='2'>Lavabo ou WC dans la chambre</td>
              <td style=\"text-align:center\" colspan='2'>Pas de sanitaires dans la chambre</td>
          </tr>
          <tr>
              <td style=\"text-align:center\">&nbsp;</td>
              <td style=\"text-align:center\">&nbsp;</td>
              <td style=\"text-align:center\">&nbsp;</td>
              <td style=\"text-align:center\">Chambres</td>
              <td style=\"text-align:center\">Lits</td>
              <td style=\"text-align:center\">Chambres</td>
              <td style=\"text-align:center\">Lits</td>
              <td style=\"text-align:center\">Chambres</td>
              <td style=\"text-align:center\">Lits</td>
              <td style=\"text-align:center\">Chambres</td>
              <td style=\"text-align:center\">Lits</td>
          </tr>
          
          ";
    
    
    $sql_S = "select * from centre_type_chambre";
    $result_S = mysql_query($sql_S);
    
    while($myrow_S= mysql_fetch_array($result_S)){
    
      if($_GET["mode"]=="modif"){
        $st = "select * from centre_detail_hebergement where id_centre_2='".$_GET["ID"]."' and id_centre_type_chambre='".$myrow_S["id_centre_type_chambre"]."'";
        $rs = mysql_query($st);
        
        $nb_chambre = mysql_result($rs,0,'nb_chambre');
        $nb_lit = mysql_result($rs,0,'nb_lit');
        $nb_lavDouWC_chambre = mysql_result($rs,0,'nb_lavDouWC_chambre');
        $nb_lavDouWC_lit = mysql_result($rs,0,'nb_lavDouWC_lit');
        $nb_lavDou_chambre = mysql_result($rs,0,'nb_lavDou_chambre');
        $nb_lavDou_lit = mysql_result($rs,0,'nb_lavDou_lit');
        $nb_lavOuWC_chambre = mysql_result($rs,0,'nb_lavOuWC_chambre');
        $nb_lavOuWC_lit = mysql_result($rs,0,'nb_lavOuWC_lit');
        $nb_noWC_chambre = mysql_result($rs,0,'nb_noWC_chambre');
        $nb_noWC_lit = mysql_result($rs,0,'nb_noWC_lit');
        
      }else{
          $nb_chambre = 0;
          $nb_lit = 0;
          $nb_lavDouWC_chambre = 0;
          $nb_lavDouWC_lit =0;
          $nb_lavDou_chambre = 0;
          $nb_lavDou_lit = 0;
          $nb_lavOuWC_chambre = 0;
          $nb_lavOuWC_lit = 0;
          $nb_noWC_chambre = 0;
          $nb_noWC_lit = 0;
      
      }
      
      
      
      echo "<tr>
              <td><input readonly type='text' size='5' value='$nb_chambre' id='nb_chambre_".$myrow_S["id_centre_type_chambre"]."' name='nb_chambre_".$myrow_S["id_centre_type_chambre"]."'/></td>
              <td><input readonly type='text' size='5' value='$nb_lit' id='nb_lit_".$myrow_S["id_centre_type_chambre"]."' name='nb_lit_".$myrow_S["id_centre_type_chambre"]."'/></td>
              <td style=\"text-align:center\">".$myrow_S["libelle"]."</td>
              <td><input onkeyup='additionne(".$myrow_S["id_centre_type_chambre"].")' type='text' size='5' value='$nb_lavDouWC_chambre' id='nb_lavDouWC_chambre_".$myrow_S["id_centre_type_chambre"]."' name='nb_lavDouWC_chambre_".$myrow_S["id_centre_type_chambre"]."'/></td>
              <td><input onkeyup='additionne(".$myrow_S["id_centre_type_chambre"].")' type='text' size='5' value='$nb_lavDouWC_lit' id='nb_lavDouWC_lit_".$myrow_S["id_centre_type_chambre"]."' name='nb_lavDouWC_lit_".$myrow_S["id_centre_type_chambre"]."'/></td>
              <td><input onkeyup='additionne(".$myrow_S["id_centre_type_chambre"].")' type='text' size='5' value='$nb_lavDou_chambre' id='nb_lavDou_chambre_".$myrow_S["id_centre_type_chambre"]."' name='nb_lavDou_chambre_".$myrow_S["id_centre_type_chambre"]."'/></td>
              <td><input onkeyup='additionne(".$myrow_S["id_centre_type_chambre"].")' type='text' size='5' value='$nb_lavDou_lit' id='nb_lavDou_lit_".$myrow_S["id_centre_type_chambre"]."' name='nb_lavDou_lit_".$myrow_S["id_centre_type_chambre"]."'/></td>
              <td><input onkeyup='additionne(".$myrow_S["id_centre_type_chambre"].")' type='text' size='5' value='$nb_lavOuWC_chambre' id='nb_lavOuWC_chambre_".$myrow_S["id_centre_type_chambre"]."' name='nb_lavOuWC_chambre_".$myrow_S["id_centre_type_chambre"]."'/></td>
              <td><input onkeyup='additionne(".$myrow_S["id_centre_type_chambre"].")' type='text' size='5' value='$nb_lavOuWC_lit' id='nb_lavOuWC_lit_".$myrow_S["id_centre_type_chambre"]."' name='nb_lavOuWC_lit_".$myrow_S["id_centre_type_chambre"]."'/></td>
              <td><input onkeyup='additionne(".$myrow_S["id_centre_type_chambre"].")' type='text' size='5' value='$nb_noWC_chambre' id='nb_noWC_chambre_".$myrow_S["id_centre_type_chambre"]."' name='nb_noWC_chambre_".$myrow_S["id_centre_type_chambre"]."'/></td>
              <td><input onkeyup='additionne(".$myrow_S["id_centre_type_chambre"].")' type='text' size='5' value='$nb_noWC_lit' id='nb_noWC_lit_".$myrow_S["id_centre_type_chambre"]."' name='nb_noWC_lit_".$myrow_S["id_centre_type_chambre"]."'/></td>
            </tr>";
    }
    echo "</table>";
  ?>
  </td>
</tr>