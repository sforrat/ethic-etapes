<tr>
  <td colspan="3">
  <?
    if($_REQUEST["TableDef"] == _CONST_TABLEDEF_ACCUEIL_GROUPE){
      $titre = "Tarifs enfants et scolaires N+1 :";
    }elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_GROUPE_ADULTE){
      $titre = "Tarifs groupes (hors enfants et scolaires)  N+1 :";
    }elseif($_REQUEST["TableDef"] == _CONST_TABLEDEF_SEJOUR_ACCUEIL_IND_FAMILLE){
      $titre = "Tarifs individuels N+1 :";
    }
  ?>
  <strong><? echo $titre;?></strong><br /><br />
  <?php
    echo "<table width='500px' border='1' cellspacing='0'>";
    echo "<tr>
              <td style=\"text-align:center\">&nbsp;</td>
              <td style=\"text-align:center\">B & B</td>
              <td style=\"text-align:center\">Demi-pension</td>
              <td style=\"text-align:center\">Pension compl&egrave;te</td>
              <td style=\"text-align:center\">Repas seul</td>
          </tr>          
          ";
    
    if($_GET["mode"]=="modif"){
      $sql_S = "select * from sejour_tarif_groupe_plus where id__table_def='".$_GET["TableDef"]."' and IdSejour='".$_GET["ID"]."'";
      $result_S = mysql_query($sql_S);
      
      $HS_bb = mysql_result($result_S,0,"HS_bb");
      $HS_dp = mysql_result($result_S,0,"HS_dp");
      $HS_pc = mysql_result($result_S,0,"HS_pc");
      $HS_rs = mysql_result($result_S,0,"HS_rs");
      
      $MS_bb = mysql_result($result_S,0,"MS_bb");
      $MS_dp = mysql_result($result_S,0,"MS_dp");
      $MS_pc = mysql_result($result_S,0,"MS_pc");
      $MS_rs = mysql_result($result_S,0,"MS_rs");
      
      $BS_bb = mysql_result($result_S,0,"BS_bb");
      $BS_dp = mysql_result($result_S,0,"BS_dp");
      $BS_pc = mysql_result($result_S,0,"BS_pc");
      $BS_rs = mysql_result($result_S,0,"BS_rs");
    }else{
      $HS_bb = 0;
      $HS_dp = 0;
      $HS_pc = 0;
      $HS_rs = 0;
      
      $MS_bb = 0;
      $MS_dp = 0;
      $MS_pc = 0;
      $MS_rs = 0;
      
      $BS_bb = 0;
      $BS_dp = 0;
      $BS_pc = 0;
      $BS_rs = 0;
    
    }

      echo "<tr>
              <td style=\"text-align:left\">Haute saison *</td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$HS_bb' id='HS_bb_n' name='HS_bb_n'/></td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$HS_dp' id='HS_dp_n' name='HS_dp_n'/></td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$HS_pc' id='HS_pc_n' name='HS_pc_n'/></td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$HS_rs' id='HS_rs_n' name='HS_rs_n'/></td>
            </tr>
            <tr>
              <td style=\"text-align:left\">Moyenne saison</td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$MS_bb' id='MS_bb_n' name='MS_bb_n'/></td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$MS_dp' id='MS_dp_n' name='MS_dp_n'/></td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$MS_pc' id='MS_pc_n' name='MS_pc_n'/></td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$MS_rs' id='MS_rs_n' name='MS_rs_n'/></td>
            </tr>
            <tr>
              <td style=\"text-align:left\">Basse saison</td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$BS_bb' id='BS_bb_n' name='BS_bb_n'/></td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$BS_dp' id='BS_dp_n' name='BS_dp_n'/></td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$BS_pc' id='BS_pc_n' name='BS_pc_n'/></td>
              <td style=\"text-align:center\"><input onkeyup='verif_numeric(this)' type='text' size='5' value='$BS_rs' id='BS_rs_n' name='BS_rs_n'/></td>
            </tr>";
   
    echo "</table>";
  ?>
  </td>
</tr>