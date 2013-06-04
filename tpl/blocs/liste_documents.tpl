				<ul class="pressRelease">
					#{section name=index loop=$listeFic}#
						<li>
							<a href="#{$listeFic[index].fichier}#" target="_blank" class="btn btn_green"><span>TELECHARGEZ</span></a>
							<img src="images/common/picto_#{$listeFic[index].type}#.png" alt="document PDF" />
							#{$listeFic[index].titre}#<br />
							<em>#{$listeFic[index].date}# - #{$listeFic[index].taille}#ko - #{$listeFic[index].langue}#</em>						
						</li>
					#{/section}#
					</ul>	