<?php
/**
* @version $Id: cpanel.php,v 1.5 2005/02/13 02:41:39 stingrey Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
?>
<!-- Following section added by Camellia Team to configure the Control panel
	This remove the left side icons and links -->
<table width="60%">
<tr>
	<td valign="top" align="center">
	<div style="width=100%;">
	<form action="index2.php" method="post" name="adminForm">
	<?php ///mosLoadAdminModules( 'cpanel', 1 ); ?>
	</form>
	</div>
	</td>
</tr>
</table>

<table class="adminform">
<tr>
	<td width="100%" valign="top" align="center"><b>Welcome to the Admin Control Panel of Information Management System</b>
	<?php // mosLoadAdminModules( 'icon', 0 ); ?>
	</td>
	<!--td width="50%" valign="top">
	<div style="width=100%;">
	<form action="index2.php" method="post" name="adminForm">
	<?php //mosLoadAdminModules( 'cpanel', 1 ); ?>
	</form>
	</div>
	</td-->
</tr>

</table>
<br /><br />
<img src="templates/mambo_admin/images/center_logo.png" alt="CCCI Logo" align="center" />