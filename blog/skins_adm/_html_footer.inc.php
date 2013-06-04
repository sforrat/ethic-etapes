<?php
/**
 * This file displays the admin page footer.
 *
 * This file is part of the evoCore framework - {@link http://evocore.net/}
 * See also {@link http://sourceforge.net/projects/evocms/}.
 *
 * @copyright (c)2003-2009 by Francois PLANQUE - {@link http://fplanque.net/}
 *
 * {@internal License choice
 * - If you have received this file as part of a package, please find the license.txt file in
 *   the same folder or the closest folder above for complete license terms.
 * - If you have received this file individually (e-g: from http://evocms.cvs.sourceforge.net/)
 *   then you must choose one of the following licenses before using the file:
 *   - GNU General Public License 2 (GPL) - http://www.opensource.org/licenses/gpl-license.php
 *   - Mozilla Public License 1.1 (MPL) - http://www.opensource.org/licenses/mozilla1.1.php
 * }}
 *
 * {@internal Open Source relicensing agreement:
 * }}
 *
 * @package admin
 *
 * @version $Id: _html_footer.inc.php,v 1.12 2009/03/23 23:29:01 fplanque Exp $
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

if( $mode != 'iframe' )
{
	/**
	 * Icon Legend
	 */
	if( $IconLegend = & get_IconLegend() )
	{ // Display icon legend, if activated by user
		$IconLegend->display_legend();
	}

	echo $this->get_footer_contents();

	// CALL PLUGINS NOW:
	global $Plugins;
	$Plugins->trigger_event( 'AdminAfterPageFooter', array() );


	// Close open divs, etc...
	echo $this->get_body_bottom();
}

if( $this->get_path(0) == 'files'
	|| $this->get_path_range(0,1) == array( 'blogs', 'perm' )
	|| $this->get_path_range(0,1) == array( 'blogs', 'permgroup' ) )
{ // init checkall JS functions
	?>
	<script type="text/javascript">
		initcheckall();
		<?php
		if( $this->get_path(0) == 'files' )
		{
			global $checkall;
			?> setcheckallspan(0<?php if( isset($checkall) ) echo ', '.(int)$checkall; ?>); <?php
		}
		?>
	</script>
	<?php
}

// fp TODO: check if this makes sense here
include_footerlines(); // enables translation strings for js

?>

<!-- End of skin_wrapper -->
</div>

</body>
</html>
<?php
/*
 * $Log: _html_footer.inc.php,v $
 */
?>