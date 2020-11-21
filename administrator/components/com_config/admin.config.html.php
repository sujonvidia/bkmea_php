<?php
/**
* @version $Id: admin.config.html.php,v 1.1 2006/09/06 11:04:01 morshed Exp $
* @package Mambo
* @subpackage Config
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Config
*/
class HTML_config {

        function showconfig( &$row, &$lists, $option ) {
                global $mosConfig_absolute_path, $mosConfig_live_site;
                global $my;        // added by camellia team to validate access control

                $tabs = new mosTabs(1);
?>
                <script language="javascript" type="text/javascript" >
                <!--
                function saveFilePerms()
                {
                                var f = document.adminForm;
                                if (f.filePermsMode0.checked)
                                        f.config_fileperms.value = '';
                                else {
                                        var perms = 0;
                                if (f.filePermsUserRead.checked) perms += 400;
                                        if (f.filePermsUserWrite.checked) perms += 200;
                                        if (f.filePermsUserExecute.checked) perms += 100;
                                        if (f.filePermsGroupRead.checked) perms += 40;
                                        if (f.filePermsGroupWrite.checked) perms += 20;
                                        if (f.filePermsGroupExecute.checked) perms += 10;
                                        if (f.filePermsWorldRead.checked) perms += 4;
                                        if (f.filePermsWorldWrite.checked) perms += 2;
                                        if (f.filePermsWorldExecute.checked) perms += 1;
                                        f.config_fileperms.value = '0'+''+perms;
                                }
                }
                function changeFilePermsMode(mode)
                {
                    if(document.getElementById) {
                        switch (mode) {
                            case 0:
                                document.getElementById('filePermsValue').style.display = 'none';
                                document.getElementById('filePermsTooltip').style.display = '';
                                document.getElementById('filePermsFlags').style.display = 'none';
                                break;
                            default:
                                document.getElementById('filePermsValue').style.display = '';
                                document.getElementById('filePermsTooltip').style.display = 'none';
                                document.getElementById('filePermsFlags').style.display = '';
                        } // switch
                    } // if
                                saveFilePerms();
                }
                function saveDirPerms()
                {
                                var f = document.adminForm;
                                if (f.dirPermsMode0.checked)
                                        f.config_dirperms.value = '';
                                else {
                                        var perms = 0;
                                if (f.dirPermsUserRead.checked) perms += 400;
                                        if (f.dirPermsUserWrite.checked) perms += 200;
                                        if (f.dirPermsUserSearch.checked) perms += 100;
                                        if (f.dirPermsGroupRead.checked) perms += 40;
                                        if (f.dirPermsGroupWrite.checked) perms += 20;
                                        if (f.dirPermsGroupSearch.checked) perms += 10;
                                        if (f.dirPermsWorldRead.checked) perms += 4;
                                        if (f.dirPermsWorldWrite.checked) perms += 2;
                                        if (f.dirPermsWorldSearch.checked) perms += 1;
                                        f.config_dirperms.value = '0'+''+perms;
                                }
                }
                function changeDirPermsMode(mode)
                {
                    if(document.getElementById) {
                        switch (mode) {
                            case 0:
                                document.getElementById('dirPermsValue').style.display = 'none';
                                document.getElementById('dirPermsTooltip').style.display = '';
                                document.getElementById('dirPermsFlags').style.display = 'none';
                                break;
                            default:
                                document.getElementById('dirPermsValue').style.display = '';
                                document.getElementById('dirPermsTooltip').style.display = 'none';
                                document.getElementById('dirPermsFlags').style.display = '';
                        } // switch
                    } // if
                                saveDirPerms();
                }
            //-->
            </script>
            <form action="index2.php" method="post" name="adminForm">
            <input type="hidden" name="tabselection">

            <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
            <table cellpadding="1" cellspacing="1" border="0" width="100%">
            <tr>
                <td width="250">
                 <table class="adminheading">
                  <tr>
                   <th nowrap class="config">Global Configuration</th>
                  </tr>
                  </table>
                </td>

            </tr>
            </table>
<?php
            $tabs->startPane("configPane");   
                $tabs->startTab("Site","site-page");
?>
                <table class="adminform">
                <tr>
                        <td width="185">Site Offline:</td>
                        <td><?php echo $lists['offline']; ?></td>
                </tr>
                <tr>
                        <td valign="top">Offline Message:</td>
                        <td><textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_offline_message"><?php echo htmlspecialchars($row->config_offline_message, ENT_QUOTES); ?></textarea><?php
                                $tip = 'A message that displays if your site is offline';
                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td valign="top">System Error Message:</td>
                        <td><textarea class="text_area" cols="60" rows="2" style="width:500px; height:40px" name="config_error_message"><?php echo htmlspecialchars($row->config_error_message, ENT_QUOTES); ?></textarea><?php
                                $tip = 'A message that displays if site could not connect to the database';
                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Site Name:</td>
                        <td><input class="text_area" type="text" name="config_sitename" size="50" value="<?php echo $row->config_sitename; ?>"/></td>
                </tr>
                <tr>
                        <td>List Length:</td>
                        <td><?php echo $lists['list_length']; ?><?php
                                $tip = 'Sets the default length of lists in the administrator for all users';
                                echo mosToolTip( $tip );
                        ?></td>
                </tr>

                </table>
<?php
                $tabs->endTab();
                $tabs->startTab("Database","db-page");
?>

                <table class="adminform">
                <tr>
                        <td width="185">Hostname:</td>
                        <td><input class="text_area" type="text" name="config_host" size="25" value="<?php echo $row->config_host; ?>"/></td>
                </tr>
                <tr>
                        <td>MySQL Username:</td>
                        <td><input class="text_area" type="text" name="config_user" size="25" value="<?php echo $row->config_user; ?>"/></td>
                </tr>
                <tr>
                        <td>MySQL Password:</td>
                        <td><input class="text_area" type="text" name="config_password" size="25" value="<?php echo $row->config_password; ?>"/></td>
                </tr>
                <tr>
                        <td>MySQL Database:</td>
                        <td><input class="text_area" type="text" name="config_db" size="25" value="<?php echo $row->config_db; ?>"/></td>
                </tr>
                </table>

<?php
                $tabs->endTab();
                $tabs->startTab("Metadata","metadata-page");
?>
                <table class="adminform">
                <tr>
                        <td width="185" valign="top">Global Site Meta Description:</td>
                        <td><textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_metadesc"><?php echo htmlspecialchars($row->config_metadesc, ENT_QUOTES); ?></textarea></td>
                </tr>
                <tr>
                        <td valign="top">Global Site Meta Keywords:</td>
                        <td><textarea class="text_area" cols="50" rows="3" style="width:500px; height:50px" name="config_metakeys"><?php echo htmlspecialchars($row->config_metakeys, ENT_QUOTES); ?></textarea></td>
                </tr>
                </table>
<?php
                $tabs->endTab();
                $tabs->startTab("Mail","mail-page");
?>
                <table class="adminform">
                <tr>
                        <td>Mail From:</td>
                        <td><input class="text_area" type="text" name="config_mailfrom" size="50" value="<?php echo $row->config_mailfrom; ?>"/></td>
                </tr>
                <tr>
                        <td>From Name:</td>
                        <td><input class="text_area" type="text" name="config_fromname" size="50" value="<?php echo $row->config_fromname; ?>"/></td>
                </tr>
                <tr>
                        <td>Sendmail Path:</td>
                        <td><input class="text_area" type="text" name="config_sendmail" size="50" value="<?php echo $row->config_sendmail; ?>"/></td>
                </tr>
                <tr>
                        <td>SMTP Auth:</td>
                        <td><?php echo $lists['smtpauth']; ?></td>
                </tr>
                <tr>
                        <td>SMTP User:</td>
                        <td><input class="text_area" type="text" name="config_smtpuser" size="50" value="<?php echo $row->config_smtpuser; ?>"/></td>
                </tr>
                <tr>
                        <td>SMTP Pass:</td>
                        <td><input class="text_area" type="text" name="config_smtppass" size="50" value="<?php echo $row->config_smtppass; ?>"/></td>
                </tr>
                <tr>
                        <td>SMTP Host:</td>
                        <td><input class="text_area" type="text" name="config_smtphost" size="50" value="<?php echo $row->config_smtphost; ?>"/></td>
                </tr>
                </table>
<?php
                $tabs->endTab();
                $tabs->endPane();
?>
                <input type="hidden" name="option" value="<?php echo $option; ?>"/>
                <input type="hidden" name="config_path" value="<?php echo $row->config_path; ?>"/>
                <input type="hidden" name="config_live_site" value="<?php echo $row->config_live_site; ?>"/>
                <input type="hidden" name="config_secret" value="<?php echo $row->config_secret; ?>"/>
                  <input type="hidden" name="task" value=""/>
                </form>
                <script  type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
<?php
        }

}
?>
