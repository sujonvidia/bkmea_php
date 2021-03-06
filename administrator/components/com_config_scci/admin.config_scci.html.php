<?php
/**
* @version $Id: admin.config_scci.html.php,v 1.19 2006/07/24 04:27:08 morshed Exp $
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
//echo 'Debug: '.$my->usertype;
class HTML_config {

        function showconfig( &$row, &$lists, $option, $start_date, $end_date ) {
                global $mosConfig_absolute_path, $mosConfig_live_site;
                global $my,$mosconfig_calender_date_format;         // added by camellia team to validate access control

                       // added by camellia team to validate access control

                $tabs = new mosTabs(1);
?>
                <script type="text/javascript" language="javascript">


                var arr = new Array();
                   arr[27] ="0";
                   arr[28] ="1";
                   arr[29] ="2";
                   arr[30] = "3";
                   arr[31] = "4";
                   arr[32] = "5";
                   arr[33] = "6";
                   arr[34] = "7";
                   arr[35] = "8";
                   arr[36] = "9";
                   arr[37] = ".";

                function check_IntNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var form = document.adminForm;
                   var msg=mid;

                   str=form.elements[obj].value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 37; j++)
                      {
                        if(str.charAt(i) == arr[j])
                           break;
                      }
                      if(j>36)
                      {

                        alert(msg);
                        var temp = parseInt(str);
                        if(isNaN(temp))
                          form.elements[obj].value=0;
                        else
                          form.elements[obj].value=temp;
                        form.elements[obj].focus();
                        form.elements[obj].select();
                        break;
                      }
                   }
                }

                function check_FloatNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var che=0;
                   var form = document.adminForm;
                   var msg=mid;

                   str=form.elements[obj].value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 38; j++)
                      {
                         if(str.charAt(i) == arr[j]){
                          if ((str.charAt(i)==".")&& (che==0))
                          {
                                  che=1;
                          }
                          else if ((str.charAt(i)==".")&& (che==1))
                          {
                              alert(msg);
                              var temp = parseFloat(str);
                              form.elements[obj].value=temp;
                              form.elements[obj].focus();

                          }
                           break;
                        }

                      }
                      if(j>37)
                      {

                        alert(msg);
                        var temp = parseFloat(str);
                        if(isNaN(temp))
                          form.elements[obj].value=0;
                        else
                        form.elements[obj].value=temp;
                        form.elements[obj].focus();
                        break;
                      }
                   }
                }


                function submitbutton(pressbutton) {
                        var form = document.adminForm;
                        /*
                        var start, end, reg;
                        start =trim(form.start_date.value);
                        end   =trim(form.end_date.value);
                        reg   =trim(form.config_voter_election_date.value);
                        start=new Date(start.split('-')[2],start.split('-')[1],start.split('-')[0]);
                        end=new Date(end.split('-')[2],end.split('-')[1],end.split('-')[0]);
                        reg=new Date(reg.split('-')[2],reg.split('-')[1],reg.split('-')[0]);
                        */
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        } /*
                        else if(reg.getTime()<start.getTime() || reg.getTime()>end.getTime()){
                            alert("Election date must be between "+form.start_date.value+" and "+form.end_date.value);
                            form.config_voter_election_date.focus();
                        }  */
                        else{
                                submitform( pressbutton );
                        }
                }
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

                <td width="250"><table class="adminheading"><tr><th nowrap class="config">Global Configuration</th></tr></table></td>
                        <!--
                                Blocked by TeamCamellia

                <td width="270">

                                <span class="componentheading">configuration.php is :
                    <?php echo is_writable( '../configuration.php' ) ? '<b><font color="green"> Writeable</font></b>' : '<b><font color="red"> Unwriteable</font></b>' ?>
                    </span>

                </td>
<?php

                if (mosIsChmodable('../configuration.php')) {
                    if (is_writable('../configuration.php')) {
?>
                <td>
                    <input type="checkbox" id="disable_write" name="disable_write" value="1"/>
                    <label for="disable_write">Make unwriteable after saving</label>
                </td>
<?php
                    } else {
?>
                <td>
                    <input type="checkbox" id="enable_write" name="enable_write" value="1"/>
                    <label for="enable_write">Override write protection while saving</label>
                </td>
<?php
                    } // if
                } // if
?>
        -->
            </tr>
            </table>
<?php
                $tabs->startPane("configPane");

                if ($my->usertype=='Super Administrator' || $my->usertype=='Administrator' )
                {
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
                <!--
                Blocked by Team Camellia
                <tr>
                        <td>Show UnAuthorized Links:</td>
                        <td><?php echo $lists['auth']; ?><?php
                                $tip = 'If yes, will show links to content to registered content even if you are not logged in.  The user will need to login to see the item in full.';
                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Allow User Registration:</td>
                        <td><?php echo $lists['allowuserregistration']; ?><?php
                                $tip = 'If yes, allows users to self-register';
                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Use New Account Activation:</td>
                        <td><?php echo $lists['useractivation']; ?>
                        <?php
                                $tip = 'If yes, the user will be mailed a link to activate their account before they can log in.';
                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Require Unique Email:</td>
                        <td><?php echo $lists['uniquemail']; ?><?php
                                $tip = 'If yes, users cannot share the smae email address';
                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Debug Site:</td>
                        <td><?php echo $lists['debug']; ?><?php
                                $tip = 'If yes, displays diagnostic information and SQL errors if present';
                                echo mosToolTip( $tip );
                        ?></td>
                </tr>

                <tr>
                        <td>WYSIWYG Editor:</td>
                        <td><?php echo $lists['editor']; ?></td>
                </tr>
                <tr>
                        <td>Favourites Site Icon:</td>
                        <td>
                        <input class="text_area" type="text" name="config_favicon" size="20" value="<?php echo $row->config_favicon; ?>"/>
<?php
                        $tip = 'If left blank or the file cannot be found, the default favicon.ico will be used.';
                        echo mosToolTip( $tip, 'Favourite Icon' );
?>                        </td>
                </tr>
        -->
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
                // Locale tab blocked by camellia team by <!-- --> and ///
        ///        $tabs->startTab("Locale","Locale-page");
?>
        <!--
                <table class="adminform">
                <tr>
                        <td width="185">Language:</td>
                        <td><?php ///echo $lists['lang']; ?></td>
                </tr>
                <tr>
                        <td width="185">Time Offset:</td>
                        <td>
                        <?php ///echo $lists['offset']; ?>
<?php
                        ///$tip = "Current date/time configured to display: " . mosCurrentDate(_DATE_FORMAT_LC2);
                        //echo mosToolTip($tip);
?>                        </td>
                </tr>
                <tr>
                        <td width="185">Country Locale:</td>
                        <td><input class="text_area" type="text" name="config_locale" size="15" value="<?php ///echo $row->config_locale; ?>"/></td>
                </tr>
                </table>
                -->
<?php
        ///        $tabs->endTab();
                // Content tab blocked by camellia team by <!-- --> and ///

        ///        $tabs->startTab("Content","content-page");
?>
                <!--
                <table class="adminform">
                <tr>
                        <td colspan="3">* These Parameters control Output elements*<br/><br/></td>
                </tr>
                <tr>
                        <td width="200">Linked Titles:</td>
                        <td width="100"><?php ///echo $lists['link_titles']; ?></td>
                        <td><?php
                                ///$tip = 'If yes, the title of content items will be hyperlinked to the item';
                                ///echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td width="200">Read More Link:</td>
                        <td width="100"><?php ///echo $lists['readmore']; ?></td>
                        <td><?php
///                                $tip = 'If set to show, the read-more link will show if main-text has been provided for the item';
///                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Item Rating/Voting:</td>
                        <td><?php ///echo $lists['vote']; ?></td>
                        <td><?php
///                                $tip = 'If set to show, a voting system will be enabled for content items';
///                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Author Names:</td>
                        <td><?php ///echo $lists['hideauthor']; ?></td>
                        <td><?php
///                                $tip = 'If set to show, the name of the author will be displayed.  This a global setting but can be changed at menu and item levels.';
///                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Created Date and Time:</td>
                        <td><?php ///echo $lists['hidecreate']; ?></td>
                        <td><?php
///                                $tip = 'If set to show, the date and time an item was created will be displayed. This a global setting but can be changed at menu and item levels.';
///                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Modified Date and Time:</td>
                        <td><?php ///echo $lists['hidemodify']; ?></td>
                        <td><?php
///                                $tip = 'If set to show, the date and time an item was last modified will be displayed.  This a global setting but can be changed at menu and item levels.';
///                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>Hits:</td>
                        <td><?php ///echo $lists['hits']; ?></td>
                        <td><?php
///                                $tip = 'If set to show, the hits for a particular item will be displayed.  This a global setting but can be changed at menu and item levels.';
///                                echo mosToolTip( $tip );
                        ?></td>
                </tr>
                <tr>
                        <td>PDF Icon:</td>
                        <td><?php ///echo $lists['hidepdf']; ?></td>
<?php
///                        if (!is_writable( "$mosConfig_absolute_path/media/" )) {
///                                echo "<td align=\"left\">";
///                                echo mosToolTip('Option not available as /media directory not writable');
///                                echo "</td>";
//                        } else {
?>                                <td>&nbsp;</td>
<?php
///                        }
?>                </tr>
                <tr>
                        <td>Print Icon:</td>
                        <td><?php ///echo $lists['hideprint']; ?></td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Email Icon:</td>
                        <td><?php ///echo $lists['hideemail']; ?></td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Icons:</td>
                        <td><?php ///echo $lists['icons']; ?></td>
                        <td><?php ///echo mosToolTip('Print, PDF and Email will utilise Icons or Text'); ?></td>
                </tr>
                <tr>
                        <td>Table of Contents on multi-page items:</td>
                        <td><?php ///echo $lists['multipage_toc']; ?></td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Back Button:</td>
                        <td><?php ///echo $lists['back_button']; ?></td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Content Item Navigation:</td>
                        <td><?php ///echo $lists['item_navigation']; ?></td>
                        <td>&nbsp;</td>
                </tr>
                -->
<!-- prepared for future releases
                <tr>
                        <td>Multi lingual content support:</td>
                        <td><?php //echo $lists['ml_support']; ?></td>
                        <td><?php //echo mosToolTip('In order to use multi lingual content you MUST have installed the MambelFish component.'); ?></td>
                </tr>
-->
<!--
                <input type="hidden" name="config_ml_support" value="<?php echo $row->config_ml_support?>">
                </table>
                -->
<?php
///                $tabs->endTab();
                // Database tab blocked by camellia team by <!-- --> and ///
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
                <!--
                Blocked by Team Camellia
                <tr>
                        <td>MySQL Database Prefix:</td>
                        <td>
                        <input class="text_area" type="text" name="config_dbprefix" size="10" value="<?php echo $row->config_dbprefix; ?>"/>
                        &nbsp;<?php echo mosWarning('!! DO NOT CHANGE UNLESS YOU HAVE A DATABASE BUILT USING TABLES WITH THE PREFIX YOU ARE SETTING !!'); ?>
                        </td>
                </tr>
                -->
                </table>

<?php
                $tabs->endTab();
                // Server tab blocked by camellia team by <!-- --> and ///
                ///$tabs->startTab("Server","server-page");
?>
<!--
                <table class="adminform">
                <tr>
                        <td width="185">Absolute Path:</td>
                        <td width="450"><strong><?php echo $row->config_path; ?></strong></td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Live Site:</td>
                        <td><strong><?php echo $row->config_live_site; ?></strong></td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Secret Word:</td>
                        <td><strong><?php echo $row->config_secret; ?></strong></td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>GZIP Page Compression:</td>
                        <td>
                        <?php echo $lists['gzip']; ?>
                        <?php echo mosToolTip('Compress buffered output if supported'); ?>
                        </td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Login Session Lifetime:</td>
                        <td>
                        <input class="text_area" type="text" name="config_lifetime" size="10" value="<?php echo $row->config_lifetime; ?>"/>
                        &nbsp;seconds&nbsp;
                        <?php echo mosToolTip('Auto logout after this time of inactivity'); ?>
                        </td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Error Reporting:</td>
                        <td><?php echo $lists['error_reporting']; ?></td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Help Server:</td>
                        <td><input class="text_area" type="text" name="config_helpurl" size="50" value="<?php echo $row->config_helpurl; ?>"/></td>
                </tr>
                <tr>
<?php
        $mode = 0;
        $flags = 0644;
        if ($row->config_fileperms!='') {
                $mode = 1;
                $flags = octdec($row->config_fileperms);
        } // if
?>
                        <td valign="top">File Creation:</td>
                <td>
                    <fieldset><legend>File Permissions</legend>
                        <table cellpadding="1" cellspacing="1" border="0">
                            <tr>
                                <td><input type="radio" id="filePermsMode0" name="filePermsMode" value="0" onclick="changeFilePermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
                                <td><label for="filePermsMode0">Dont CHMOD new files (use server defaults)</label></td>
                            </tr>
                            <tr>
                                <td><input type="radio" id="filePermsMode1" name="filePermsMode" value="1" onclick="changeFilePermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
                                <td>
                                                                <label for="filePermsMode1">CHMOD new files</label>
                                                                <span id="filePermsValue"<?php if (!$mode) echo ' style="display:none"'; ?>>
                                                                to:        <input class="text_area" type="text" readonly="readonly" name="config_fileperms" size="4" value="<?php echo $row->config_fileperms; ?>"/>
                                                                </span>
                                                                <span id="filePermsTooltip"<?php if ($mode) echo ' style="display:none"'; ?>>
                                                                &nbsp;<?php echo mosToolTip('Select this option to define permission flags for new created files'); ?>
                                                                </span>
                                                        </td>
                            </tr>
                            <tr id="filePermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
                                <td>&nbsp;</td>
                                <td>
                                    <table cellpadding="0" cellspacing="1" border="0">
                                        <tr>
                                            <td style="padding:0px">User:</td>
                                            <td style="padding:0px"><input type="checkbox" id="filePermsUserRead" name="filePermsUserRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="filePermsUserRead">read</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="filePermsUserWrite" name="filePermsUserWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="filePermsUserWrite">write</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="filePermsUserExecute" name="filePermsUserExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px" colspan="3"><label for="filePermsUserExecute">execute</label></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0px">Group:</td>
                                            <td style="padding:0px"><input type="checkbox" id="filePermsGroupRead" name="filePermsGroupRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="filePermsGroupRead">read</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="filePermsGroupWrite" name="filePermsGroupWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="filePermsGroupWrite">write</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="filePermsGroupExecute" name="filePermsGroupExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px" width="70"><label for="filePermsGroupExecute">execute</label></td>
                                                                                <td><input type="checkbox" id="applyFilePerms" name="applyFilePerms" value="1"/></td>
                                            <td nowrap="nowrap">
                                                                                        <label for="applyFilePerms">
                                                                                                Apply to existing files
                                                                                                &nbsp;<?php
                                                                                                echo mosWarning(
                                                                                                        'Checking here will apply the permission flags to <em>all existing files</em> of the site.<br/>'.
                                                                                                        '<b>INAPPROPRIATE USAGE OF THIS OPTION MAY RENDER THE SITE INOPERATIVE!</b>'
                                                                                                );?>
                                                                                        </label>
                                                                                </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0px">World:</td>
                                            <td style="padding:0px"><input type="checkbox" id="filePermsWorldRead" name="filePermsWorldRead" value="1" onclick="saveFilePerms()"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="filePermsWorldRead">read</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="filePermsWorldWrite" name="filePermsWorldWrite" value="1" onclick="saveFilePerms()"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="filePermsWorldWrite">write</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="filePermsWorldExecute" name="filePermsWorldExecute" value="1" onclick="saveFilePerms()"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px" colspan="4"><label for="filePermsWorldExecute">execute</label></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
                        <td>&nbsp;</td>
            </tr>
            <tr>
<?php
        $mode = 0;
        $flags = 0755;
        if ($row->config_dirperms!='') {
                $mode = 1;
                $flags = octdec($row->config_dirperms);
        } // if
?>
                        <td valign="top">Directory Creation:</td>
                <td>
                    <fieldset><legend>Directory Permissions</legend>
                        <table cellpadding="1" cellspacing="1" border="0">
                            <tr>
                                <td><input type="radio" id="dirPermsMode0" name="dirPermsMode" value="0" onclick="changeDirPermsMode(0)"<?php if (!$mode) echo ' checked="checked"'; ?>/></td>
                                <td><label for="dirPermsMode0">Dont CHMOD new directories (use server defaults)</label></td>
                            </tr>
                            <tr>
                                <td><input type="radio" id="dirPermsMode1" name="dirPermsMode" value="1" onclick="changeDirPermsMode(1)"<?php if ($mode) echo ' checked="checked"'; ?>/></td>
                                <td>
                                                                <label for="dirPermsMode1">CHMOD new directories</label>
                                                                <span id="dirPermsValue"<?php if (!$mode) echo ' style="display:none"'; ?>>
                                                               to: <input class="text_area" type="text" readonly="readonly" name="config_dirperms" size="4" value="<?php echo $row->config_dirperms; ?>"/>
                                                                </span>
                                                                <span id="dirPermsTooltip"<?php if ($mode) echo ' style="display:none"'; ?>>
                                                                &nbsp;<?php echo mosToolTip('Select this option to define permission flags for new created directories'); ?>
                                                                </span>
                                                        </td>
                            </tr>
                            <tr id="dirPermsFlags"<?php if (!$mode) echo ' style="display:none"'; ?>>
                                <td>&nbsp;</td>
                                <td>
                                    <table cellpadding="1" cellspacing="0" border="0">
                                        <tr>
                                            <td style="padding:0px">User:</td>
                                            <td style="padding:0px"><input type="checkbox" id="dirPermsUserRead" name="dirPermsUserRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 0400) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="dirPermsUserRead">read</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="dirPermsUserWrite" name="dirPermsUserWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 0200) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="dirPermsUserWrite">write</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="dirPermsUserSearch" name="dirPermsUserSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 0100) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px" colspan="3"><label for="dirPermsUserSearch">search</label></td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0px">Group:</td>
                                            <td style="padding:0px"><input type="checkbox" id="dirPermsGroupRead" name="dirPermsGroupRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 040) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="dirPermsGroupRead">read</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="dirPermsGroupWrite" name="dirPermsGroupWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 020) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="dirPermsGroupWrite">write</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="dirPermsGroupSearch" name="dirPermsGroupSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 010) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px" width="70"><label for="dirPermsGroupSearch">search</label></td>
                                                                                <td><input type="checkbox" id="applyDirPerms" name="applyDirPerms" value="1"/></td>
                                            <td nowrap="nowrap">
                                                                                        <label for="applyDirPerms">
                                                                                                Apply to existing directories
                                                                                                &nbsp;<?php
                                                                                                echo mosWarning(
                                                                                                        'Checking here will apply the permission flags to <em>all existing directories</em> of the site.<br/>'.
                                                                                                        '<b>INAPPROPRIATE USAGE OF THIS OPTION MAY RENDER THE SITE INOPERATIVE!</b>'
                                                                                                );?>
                                                                                        </label>
                                                                                </td>
                                        </tr>
                                        <tr>
                                            <td style="padding:0px">World:</td>
                                            <td style="padding:0px"><input type="checkbox" id="dirPermsWorldRead" name="dirPermsWorldRead" value="1" onclick="saveDirPerms()"<?php if ($flags & 04) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="dirPermsWorldRead">read</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="dirPermsWorldWrite" name="dirPermsWorldWrite" value="1" onclick="saveDirPerms()"<?php if ($flags & 02) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px"><label for="dirPermsWorldWrite">write</label></td>
                                            <td style="padding:0px"><input type="checkbox" id="dirPermsWorldSearch" name="dirPermsWorldSearch" value="1" onclick="saveDirPerms()"<?php if ($flags & 01) echo ' checked="checked"'; ?>/></td>
                                            <td style="padding:0px" colspan="3"><label for="dirPermsWorldSearch">search</label></td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                        </table>
                    </fieldset>
                </td>
                        <td>&nbsp;</td>
              </tr>
                </table>-->
<?php
                ///$tabs->endTab();
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
                <!--
                Blocked by Team Camellia
                <tr>
                        <td valign="top">Show Title Meta Tag:</td>
                        <td>
                        <?php echo $lists['metatitle']; ?>
                        &nbsp;&nbsp;&nbsp;
                        <?php echo mosToolTip('Show the title meta tag when viewing content items'); ?>
                        </td>
                    </tr>
                <tr>
                        <td valign="top">Show Author Meta Tag:</td>
                        <td>
                        <?php echo $lists['metaauthor']; ?>
                        &nbsp;&nbsp;&nbsp;
                        <?php echo mosToolTip('Show the author meta tag when viewing content items'); ?>
                        </td>
                </tr>
                -->
                </table>
<?php
                $tabs->endTab();
                $tabs->startTab("Mail","mail-page");
?>
                <table class="adminform">
                <tr>
                        <td width="185">Mailer:</td>
                        <td><?php echo $lists['last_reg_year_id']; ?></td>
                </tr>
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
                // Server tab blocked by camellia team by <!-- --> and ///
                ///$tabs->startTab("Cache","cache-page");
?>
<!--
                <table class="adminform" border="0">
                <?php
                if (is_writeable($row->config_cachepath)) {
                        ?>
                        <tr>
                                <td width="185">Caching:</td>
                                <td width="500"><?php echo $lists['caching']; ?></td>
                                <td>&nbsp;</td>
                        </tr>
                        <?php
                }
                ?>
                <tr>
                        <td>Cache Folder:</td>
                        <td>
                        <input class="text_area" type="text" name="config_cachepath" size="50" value="<?php echo $row->config_cachepath; ?>"/>
<?php
                        if (is_writeable($row->config_cachepath)) {
                                echo mosToolTip('Current cache is directory is <b>Writeable</b>');
                        } else {
                                echo mosWarning('The cache directory is UNWRITEABLE - please set this directory to CHMOD755 before turning on the cache');
                        }
?>                        </td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Cache Time:</td>
                        <td><input class="text_area" type="text" name="config_cachetime" size="5" value="<?php echo $row->config_cachetime; ?>"/> seconds</td>
                        <td>&nbsp;</td>
                </tr>
                </table>
                -->
                <?php
                ///$tabs->endTab();
                // Statistics tab blocked by camellia team by <!-- --> and ///
                ///$tabs->startTab("Statistics","stats-page");
                ?>
                <!---
                <table class="adminform">
                <tr>
                        <td width="185">Statistics:</td>
                        <td width="100"><?php ///echo $lists['enable_stats']; ?></td>
                        <td><?php ///echo mostooltip('Enable/disable collection of site statistics'); ?></td>
                </tr>
                <tr>
                        <td>Log Content Hits by Date:</td>
                        <td><?php ///echo $lists['log_items']; ?></td>
                        <td><span class="error"><?php ///echo mosWarning('WARNING : Large amounts of data will be collected'); ?></span></td>
                </tr>
                <tr>
                        <td>Log Search Strings:</td>
                        <td><?php ///echo $lists['log_searches']; ?></td>
                        <td>&nbsp;</td>
                </tr>
                </table>
                -->
                <?php
                ///$tabs->endTab();
                // SEO tab blocked by camellia team by <!-- --> and ///
                ///$tabs->startTab("SEO","seo-page");
                ?>
                <!--
                <table class="adminform">
                <tr>
                        <td width="200"><strong>Search Engine Optimization</strong></td>
                        <td width="100">&nbsp;</td>
                        <td>&nbsp;</td>
                </tr>
                <tr>
                        <td>Search Engine Friendly URLs:</td>
                        <td><?php ///echo $lists['sef']; ?>&nbsp;</td>
                        <td><span class="error"><?php ///echo mosWarning('Apache only! Rename htaccess.txt to .htaccess before activating'); ?></span></td>
                </tr>
                <tr>
                        <td>Dynamic Page Titles:</td>
                        <td><?php ///echo $lists['pagetitles']; ?></td>
                        <td><?php ///echo mosToolTip('Dynamically changes the page title to reflect current content viewed'); ?></td>
                </tr>
                </table>
                -->
<?php

        ///        $tabs->endTab();
        }
        // Directory tab is added by camellia team
                $tabs->startTab("Member","member-page");
                ?>
                <table class="adminform">
                        <tr>
                                <td>Working Reg. Year :</td>
                                <td><?php echo $lists['working_reg_year_id']; ?></td>
                        </tr>
                        <tr>
                                <td>Name of the President :</td>
                                <td>
                                <input class="text_area" type="text" name="config_president_name" size="30" value="<?php echo $row->config_president_name; ?>" maxlength="150" />
                                </td>
                        </tr>
                        <tr>
                                <td>Designation of Authority [Id Card]:</td>
                                <td>
                                <input class="text_area" type="text" name="config_designation_idcard" size="30" value="<?php echo $row->config_designation_idcard; ?>" maxlength="150" />
                                </td>
                        </tr>
        <?php
                if ($my->usertype=='Super Administrator')
                        {?>
                        <tr>
                                <td width="185"><strong>Voter list</strong></td>
                                <td>&nbsp;</td>
                        </tr>

                        <tr>
                                <td>For New Member:</td>
                                <td><input class="text_area" type="text" name="config_voter_new_date" size="20" value="<?php echo $row->config_voter_new_date; ?>"/>
                                <?php echo mosToolTip('Members will be voter who have REGISTERED this days before the Election date'); ?>        </td>
                        </tr>
                        <tr>
                                <td>For Renewal:</td>
                                <td><input class="text_area" type="text" name="config_voter_renew_date" size="20" value="<?php echo $row->config_voter_renew_date; ?>"/>
                                <?php echo mosToolTip('Members will be voter who have RENEWED this days before the Election date'); ?></td>
                        </tr>
                        <tr>
                                <td>Election date [dd-mm-yyyy]:</td>
                                <!--td><input class="text_area" type="text" name="config_voter_election_date" size="20" value="<?php echo $row->config_voter_election_date; ?>"/>
                                <?php echo mosToolTip('Next election date [dd-mm-yyyy]'); ?>        </td-->

                                <td>
                                        <input class="text_area" type="text" name="config_voter_election_date" id="config_voter_election_date" value="<?php echo trim($row->config_voter_election_date); ?>" readonly size="20" maxlength="255"    />
                                        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0  class="calender_link">
                                        <?php echo mosToolTip('Next election date [dd-mm-yyyy]'); ?>

                                </td>

                        </tr>
                <?php
                        }?>
                </table>
<?php
        $tabs->endTab();

        $tabs->startTab("Product","product-page");
?>
                <table class="adminform">

                        <tr>
                                <td>No. of days that the purchased product may be downloaded :</td>
                                <td>
                                <input type="text"  class="text_area" name="config_no_of_days_to_download_purchase_product"  value="<?php echo $row->config_no_of_days_to_download_purchase_product; ?>"  onKeyUp="javascript:check_FloatNumber('config_no_of_days_to_download_purchase_product','Enter valid number');" size="25" maxlength="10">
                                <?php
                                $tip = 'No. of days that the purchased product may be downloaded';
                                echo mosToolTip( $tip );
                                ?>
                                </td>
                        </tr>
                        <tr>
                        <td>Number of items in the Product Showcase :</td>
                        <td><?php echo $lists['config_category_list_length'];
                                $tip = 'Sets the category length of lists for public site';
                                echo mosToolTip( $tip );
                        ?>
                        </td>
                        </tr>
                        <tr>
                        <td>Number of items in the "Products in Demand" Category :</td>
                        <td><?php echo $lists['config_hot_product_list_length'];
                                $tip = 'Sets the hot product length of lists  for public site';
                                echo mosToolTip( $tip );
                        ?>
                        </td>
                        </tr>
                        <tr>
                                <td colspan="2"><b>Unit price for Members</b></td>
                        </tr>
                        <tr>
                                <td width="35%">General contact of local organization</td>
                                <td  width="65%" align="left"><input  class="text_area" type="text" name="config_local_general_contact_member" value="<?php echo $row->config_local_general_contact_member; ?>" onKeyUp="javascript:check_FloatNumber('config_local_general_contact_member','Enter valid amount');" size="15" maxlength="10"> Tk.</td>
                        </tr>
                        <tr>
                                <td>General contact of foreign organization </td>
                                <td><input type="text"  class="text_area" name="config_foreign_general_contact_member"  value="<?php echo $row->config_foreign_general_contact_member; ?>"  onKeyUp="javascript:check_FloatNumber('config_foreign_general_contact_member','Enter valid amount');" size="15" maxlength="10"> Tk.</td>
                        </tr>
                        <tr>
                                <td>Full profile of local organization </td>
                                <td><input type="text"  class="text_area" name="config_local_detail_contact_member"  value="<?php echo $row->config_local_detail_contact_member; ?>"  onKeyUp="javascript:check_FloatNumber('config_local_detail_contact_member','Enter valid amount');" size="15" maxlength="10"> Tk.</td>
                        </tr>
                        <tr>
                                <td>Full profile of foreign organization </td>
                                <td><input type="text"  class="text_area" name="config_foreign_detail_contact_member"  value="<?php echo $row->config_foreign_detail_contact_member; ?>"  onKeyUp="javascript:check_FloatNumber('config_foreign_detail_contact_member','Enter valid amount');" size="15" maxlength="10"> Tk.</td>
                        </tr>
                        <tr>
                                <td colspan="2"><b>Unit price for Non-Members</b></td>
                        </tr>
                        <tr>
                                <td width="35%">General contact of local organization </td>
                                <td  width="65%" align="left"><input  class="text_area" type="text" name="config_local_general_contact_non_member" value="<?php echo $row->config_local_general_contact_non_member; ?>" onKeyUp="javascript:check_FloatNumber('config_local_general_contact_non_member','Enter valid amount');"  size="15" maxlength="10"> Tk.</td>
                        </tr>
                        <tr>
                               <td>General contact of foreign organization </td>
                                <td><input type="text"  class="text_area" name="config_foreign_general_contact_non_member"  value="<?php echo $row->config_foreign_general_contact_non_member; ?>"  onKeyUp="javascript:check_FloatNumber('config_foreign_general_contact_non_member','Enter valid amount');"  size="15" maxlength="10"> Tk.</td>
                        </tr>
                        <tr>
                                <td>Full profile of local organization </td>
                                <td><input type="text"  class="text_area" name="config_local_detail_contact_non_member"  value="<?php echo $row->config_local_detail_contact_non_member; ?>"  onKeyUp="javascript:check_FloatNumber('config_local_detail_contact_non_member','Enter valid amount');"  size="15" maxlength="10"> Tk.</td>
                        </tr>
                        <tr>
                                <td>Full profile of foreign organization </td>
                                <td><input type="text"  class="text_area" name="config_foreign_detail_contact_non_member"  value="<?php echo $row->config_foreign_detail_contact_non_member; ?>"  onKeyUp="javascript:check_FloatNumber('config_foreign_detail_contact_non_member','Enter valid amount');"  size="15" maxlength="10"> Tk.</td>
                        </tr>
                </table>
<?php
        $tabs->endTab();
        $tabs->endPane();
?>
                <input type="hidden" name="option" value="<?php echo $option; ?>"/>
                <input type="hidden" name="start_date" value="<?php echo $start_date; ?>" />
                <input type="hidden" name="end_date" value="<?php echo $end_date; ?>" />
                <input type="hidden" name="config_path" value="<?php echo $row->config_path; ?>"/>
                <input type="hidden" name="config_live_site" value="<?php echo $row->config_live_site; ?>"/>
                <input type="hidden" name="config_secret" value="<?php echo $row->config_secret; ?>"/>
                  <input type="hidden" name="task" value=""/>
                </form>
                <script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "config_voter_election_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


                </script>
                <script  type="text/javascript" src="<?php echo $mosConfig_live_site;?>/includes/js/overlib_mini.js"></script>
<?php
        }

}
?>
