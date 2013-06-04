<?
// +--------------------------------------------------------------------------+
// | Back-Office - 17/12/2002                                                 |
// +--------------------------------------------------------------------------+
// | Copyright (c) 2002-2003 FullSud Team                                     |
// +--------------------------------------------------------------------------+
// | License:  Contact Fullsud : contact@fullsud.com                          |
// +--------------------------------------------------------------------------+
// | Library that sets class for Back-Office                                  |
// |                                                                          |
// | usage:                                                                   |
// |                                                                          |
// | example:                                                                 |
// |                                                                          |
// | required: - PHP                                                          |
// |           - MySQL                                                        |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Author:   Yoann CULAS <yculas@fullsud.com>                               |
// +--------------------------------------------------------------------------+



// +--------------------------------------------------------------------------+
// |                                                                          |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Parameters :                                                             |
// +--------------------------------------------------------------------------+
// | Date : 17/12/2002                                                        |
// +--------------------------------------------------------------------------+
class bo_button {

	// +--------------------------------------------------------------------------+
	// |                              CONSTRUCTEUR                                |
	// +--------------------------------------------------------------------------+
	function bo_button() {
		$this->name="Modifier";
		$this->action="";
		$this->c1 = "black";
		$this->c2 = "white";
		$this->title = "";
	}

	// +--------------------------------------------------------------------------+
	// |                              AFFICHE LE BOUTON                           |
	// +--------------------------------------------------------------------------+
	function display() {

global $MainFontColor;
		//On test si la couleur est fonce ou non
		if (is_light_color(get_inter_color($this->c1,0.6))) {
				$ratio_color = 0.8;
		}
		else {
				$ratio_color = 0.1;
		}

		$couleur_1 = get_inter_color($this->c1,0.7);
		$couleur_2 = get_inter_color($this->c1,0.6);
		$couleur_3 = get_inter_color($this->c1,0.2);
		$couleur_4 = get_inter_color($this->c2,$ratio_color);

	?>
	<table border="0" cellspacing="1" cellpadding="3" bgcolor="<?=$couleur_1?>">
		<tr>
			<td
				onmouseOver="this.style.backgroundColor='<?=$couleur_2?>';this.style.color='<?=$couleur_4?>'" 
				onmouseOut="this.style.backgroundColor='<?=$couleur_3?>';this.style.color='<?=$MainFontColor?>'" 
				onclick="<?=$this->action?>" style="cursor:pointer" bgcolor="<?=$couleur_3?>"
				title="<?=$this->title?>"
			>
			&nbsp;&nbsp;<?=ucfirst(strtolower($this->name))?>&nbsp;&nbsp;
			</td>
		</tr>
	</table>
	<?
	}

}



// +--------------------------------------------------------------------------+
// |                                                                          |
// |                                                                          |
// +--------------------------------------------------------------------------+
// | Parameters :                                                             |
// +--------------------------------------------------------------------------+
// | Date : 17/12/2002                                                        |
// +--------------------------------------------------------------------------+
Class Page {

	function Page($Rst, $Page, $NbEnrPage =_NB_ENR_PAGE_RES, $NbPageTot=_NB_PAGE_TOT_RES) {

		$this->NbEnrPage = $NbEnrPage; //$this->NbEnrPage ||  $TempNbEnrPage;
		$this->NbPageTot = $NbPageTot; //$this->NbPageTot || $TempNbPageTot;
		$this->Label =	"Pages";//"<img src=\"../images/page.gif\" width=\"29\" height=\"11\">";
		$this->Prev =	"&lt;";//"<img src=\"../images/precedent.gif\" width=\"80\" height=\"11\" border=0 alt=\"\">";
		$this->Next =	"&gt;";//"<img src=\"../images/suivante.gif\" width=\"65\" height=\"11\" border=0 alt=\"\">";
		$this->NbPix = 20;
		$this->AffPageSurNbPage=true;
		$this->TableBgColor = "";
		$this->TdBgColor = ""; //"bgcolor=\"\"";
		$this->CellSpacing = "0";
		$this->CellPadding = "0";
		$this->TableBorder = "0";
		$this->Fichier = "";

		$this->NomVar = "Page";

		//Specifique cosmed 05/10/2001
		$this->PixTransCallage = "0";

		$this->Init($Rst, $Page);
	}

	function NbEnrPage($NbEnrPage, $Rst, $Page) {
		$this->NbEnrPage=$NbEnrPage;
		$this->Init($Rst, $Page);
	}

	function Init($Rst, $Page) {
		if ($Page<1) { #Page 1 par defaut
			$Page = 1;
		}
		$nb = @mysql_num_rows($Rst);
		$this->nb_page = @intval($nb/$this->NbEnrPage);
		$reste =  @intval($nb%$this->NbEnrPage);
		$this->nb_page++; #Nombre de pages
		$min = ($Page-1)*$this->NbEnrPage; #Enr de depart
		$max = $Page*$this->NbEnrPage;	 #Enr de fin
		if ($Page == $this->nb_page) { #Derniere page
			$max = $min+$reste;
		}
		if (@is_int($nb/$this->NbEnrPage)) { //Si le nombre d'enr affi est un multiple du nombre total d'enr
			$this->nb_page--;
		}
		$this->Min = $min;
		$this->Max = $max;

		return($Page);
	}

	function Affiche($Rst, $Page, $Arg) {

		//Specifique au site cosmed 05/10/2001

		//$imgCallageLeft = "<img src=\"../images/pixtrans.gif\" width=\"75\" height=\"3\">";
		$imgCallageLeft = "";
		if ($this->PixTransCallage == 1) {
			$this->Label = $imgCallageLeft.$this->Label; 
		}	

		$imgSep = "";//"<img src=\"../images/page_fleches.gif\" width=\"23\" height=\"13\" border=0 alt=\"\">";


		$Page = $this->Init($Rst, $Page);
		if ($this->nb_page>1) {//Nombre de page > 1
			echo "<table border=\"".$this->TableBorder."\" cellspacing=\"".$this->CellSpacing."\" cellpadding=\"".$this->CellPadding."\" ".$this->TableBgColor."><tr><td ".$this->TdBgColor."><B>".$this->Label."&nbsp;&nbsp;&nbsp;</B></td>";
			$Scope = $Page%$this->NbPageTot;
			if ($Scope>0) {
				 $Scope = intval(($Page/$this->NbPageTot)+1);
			}
			else {
				 $Scope = intval(($Page/$this->NbPageTot));
			}
			if ($this->nb_page>=$this->NbPageTot) {
				$rest_page = $this->nb_page - ($this->NbPageTot*$Scope);
			}
			echo "<td ".$this->TdBgColor." width=\"".$this->NbPix."\">";
			if ($Scope>1) {
				$n= $Page-$this->NbPageTot;
				echo "<a href=\"".$this->Fichier."?"."&".$Arg."&".$this->NomVar."=".$n."\">".$this->Prev."</a>";
			}
			else {
				echo "&nbsp;";
			}
			echo "</td><td ".$this->TdBgColor." align=\"center\" class=\"chiffrenoir\">";

			for ($p=($Scope*$this->NbPageTot)-($this->NbPageTot-1);$p<=$this->nb_page && $p<=($Scope*$this->NbPageTot);$p++) {
				if ($p == $Page) {
					echo "<B>&nbsp;";
					if ($this->AffPageSurNbPage == true) {
						echo $p."<font size=\"1\">/".$this->nb_page."</font>";
					}
					else {
						echo $imgSep.$p;
					}
					echo "&nbsp;</B>";
				}
				else {
					echo "<a href=\"".$this->Fichier."?"."&".$Arg."&".$this->NomVar."=".$p."\">".$imgSep.$p."</a>&nbsp;";
				}
			}

			echo "</td><td ".$this->TdBgColor." width=\"".$this->NbPix."\" align=\"right\">";
			if ($rest_page>0) {
				$p = (($Scope+1)*$this->NbPageTot)-($this->NbPageTot-1);
				echo "<a href=\"".$this->Fichier."?"."&".$Arg."&".$this->NomVar."=".$p."\">".$this->Next."</a>";
			}
			else {
				echo "&nbsp;";
			}
			echo "</td></tr></table>";
		}
	}
}
?>
