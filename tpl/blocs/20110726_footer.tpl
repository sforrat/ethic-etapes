#{if $CYBERCITE_ID_SITE != "" }#
<SCRIPT id='tg_passage_cybercite' language='JavaScript' src='http://tracking.veille-referencement.com/TAG/TAG_passage.js?idsite=#{$CYBERCITE_ID_SITE}#'></SCRIPT>
#{/if}#

<script type="text/javascript">
var _gaq = _gaq || [];
_gaq.push(['_setAccount', 'UA-19171854-1']);
_gaq.push(['_trackPageview']);

(function() {
  var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
  ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
  var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
})();
</script>


#{if $CONTENU_PIED != "" }#
<div class="cycbas">
#{$CONTENU_PIED}#
</div>
#{/if}#
		</div><!-- /#wrapper -->	
</body>
</html>
