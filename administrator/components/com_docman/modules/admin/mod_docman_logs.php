<?php
/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: mod_docman_logs.php,v 1.1 2006/03/19 07:02:12 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2004 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Official website: http://www.mambodocman.com/
*/

/**
* * ensure this file is being included by a parent file
*/
defined('_VALID_MOS') or die('Direct Access to this location is not allowed.');

global $_DOCMAN;
$_DOCMAN->setType(_DM_TYPE_MODULE);
$_DOCMAN->loadLanguage('modules');

$database->setQuery("SELECT * FROM #__docman_log ORDER BY log_datetime DESC LIMIT 10");
$rows = $database->loadObjectList();

?>
<table class="adminlist">
	<tr>
	    <th colspan="3"><?php echo _DML_MOD_LOGS_TITLE;?></th>
	</tr>
<?php

if (!$_DOCMAN->getCfg('log')) echo '<tr><td>' . _DML_MOD_LOGS_DISABLED . '</td></tr>';

foreach ($rows as $row) {
    ?>
	<tr>
	    <td><a href="#edit" onClick="submitcpform('<?php echo $row->id;?>', '<?php echo $row->id;?>')"><?php echo $row->log_docid;?></a>
	    </td>
	    <td align="right"><?php echo $row->log_ip;?></td>
	    <td align="right"><?php echo $row->log_datetime;?></td>
	</tr>
<?php
} 

?>
</table>
