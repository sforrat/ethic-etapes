<?
Class Page {

	function Page($Rst, $Page, $NbEnrPage =_NB_ENR_PAGE, $NbPageTot=_NB_PAGE_TOT) {

		/*
		if (substr(phpversion(),0,1)==4) {//Version de php=4
			$TempNbEnrPage = _NB_ENR_PAGE;
			$TempNbPageTot = _NB_PAGE_TOT;
		}
		else {//Version de php=3
			$TempNbEnrPage = 2;
			$TempNbPageTot = 2;		
		}
		*/

		$this->NbEnrPage = $NbEnrPage; //$this->NbEnrPage ||  $TempNbEnrPage;
		$this->NbPageTot = $NbPageTot; //$this->NbPageTot || $TempNbPageTot;
		$this->Label =	"Pages";//"<img src=\"../images/page.gif\" width=\"29\" height=\"11\">";
		$this->Prev =	"&lt;";//"<img src=\"../images/precedent.gif\" width=\"80\" height=\"11\" border=0 alt=\"\">";
		$this->Next =	"&gt;";//"<img src=\"../images/suivante.gif\" width=\"65\" height=\"11\" border=0 alt=\"\">";
		$this->NbPix = 20;
		$this->AffPageSurNbPage=true;
		$this->TableBgColor = "";
		$this->TdBgColor = "black"; //"bgcolor=\"\"";
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

	function Affiche_variable($Rst, $Page, $Arg) {

		//$imgCallageLeft = "<img src=\"../images/pixtrans.gif\" width=\"75\" height=\"3\">";
		$imgCallageLeft = "";
		if ($this->PixTransCallage == 1) {
			$this->Label = $imgCallageLeft.$this->Label; 
		}	

		$imgSep = "";//"<img src=\"../images/page_fleches.gif\" width=\"23\" height=\"13\" border=0 alt=\"\">";


		$Page = $this->Init($Rst, $Page);
		$retour = "";
		if ($this->nb_page>1) {//Nombre de page > 1
			$retour = $retour. "<table border=\"".$this->TableBorder."\" cellspacing=\"".$this->CellSpacing."\" cellpadding=\"".$this->CellPadding."\" ".$this->TableBgColor."><tr><td ".$this->TdBgColor."><B>".$this->Label."&nbsp;&nbsp;&nbsp;</B></td>";
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
			$retour = $retour. "<td ".$this->TdBgColor." width=\"".$this->NbPix."\">";
			if ($Scope>1) {
				$n= $Page-$this->NbPageTot;
				$retour = $retour. "<a class='chemin' href=\"".$this->Fichier."?"."&".$Arg."&".$this->NomVar."=".$n."\">".$this->Prev."</a>";
				//$retour = $retour. "<a class='lienrech' href=\"javascript:Suivant(".$n.");\">".$this->Prev."</a>";
			}
			else {
				$retour = $retour. "&nbsp;";
			}
			$retour = $retour. "</td><td ".$this->TdBgColor." align=\"center\">";

			for ($p=($Scope*$this->NbPageTot)-($this->NbPageTot-1);$p<=$this->nb_page && $p<=($Scope*$this->NbPageTot);$p++) {
				if ($p == $Page) {
					$retour = $retour. "<span class='txtrge'><B>&nbsp;";
					if ($this->AffPageSurNbPage == true) {
						$retour = $retour. $p."<font size=\"1\">/".$this->nb_page."</font>";
					}
					else {
						$retour = $retour. $imgSep.$p;
					}
					$retour = $retour. "&nbsp;</B></span>";
				}
				else {
					$retour = $retour. "<a class='lienrech' href=\"".$this->Fichier."?".($Arg!=""?"&".$Arg."&":"").$this->NomVar."=".$p."\">".$imgSep.$p."</a>&nbsp;";
					//$retour = $retour. "<a class='lienrech' href=\"javascript:go(".$p.");\">".$imgSep.$p."</a>&nbsp;";
				}
			}

			$retour = $retour. "</td><td ".$this->TdBgColor." width=\"".$this->NbPix."\" align=\"right\">";
			$retour = $retour. "</td></tr></table>";
		}

		return $retour;
	}
}
?>