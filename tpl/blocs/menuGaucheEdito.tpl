<div id="sidebar">					
	<ul id="subMenu_sidebar">
		#{section name=sec1 loop=$TabNav}#
		<li>
			<h2 #{if $TabNav[sec1].classe!=""}#class="#{$TabNav[sec1].classe}#"#{/if}#><a href="#{$TabNav[sec1].url}#">#{$TabNav[sec1].titre}#</a></h2>
			#{section name=sec2 loop=$TabNav[sec1].ss_rub}#
				#{if $smarty.section.sec2.first}#
				<ul>
				#{/if}#
					<li><a #{if $TabNav[sec1].ss_rub[sec2].classe!=""}#class="#{$TabNav[sec1].ss_rub[sec2].classe}#"#{/if}# href="#{$TabNav[sec1].ss_rub[sec2].url}#">#{$TabNav[sec1].ss_rub[sec2].titre}#</a></li>
				#{if $smarty.section.sec2.last}#
				</ul>
				#{/if}#
			#{/section}#
		</li>
		#{/section}#
	</ul>								
</div><!-- /#sidebar -->