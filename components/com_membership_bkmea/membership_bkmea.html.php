<?php
/**
* @version $Id: membership_bkmea.html.php,v 1.1 2005/12/01 07:55:04 aslam Exp $
* @package Mambo
* @subpackage Weblinks
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/HTML_toolbar.php' );

/**
* @package Mambo
* @subpackage Weblinks
*/
class HTML_Membership {
        /**
        * Writes PDF icon
        */
        function PdfIcon( $row, $params, $hide_js ) {
                global $mosConfig_live_site;
                if ( $params->get( 'pdf' ) && !$params->get( 'popup' ) && !$hide_js ) {
                        $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                        $link = $mosConfig_live_site. '/index2.php?option=com_membership_bkmea&amp;do_pdf=1&amp;id='. $row->id.'&amp;type_id='. $row->type_id;
                        if ( $params->get( 'icons' ) ) {
                                $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
                        } else {
                                $image = _CMN_PDF .'&nbsp;';
                        }
                        ?>
                        <td align="right" width="100%" class="buttonheading">
                        <a href="javascript:void window.open('<?php echo $link; ?>', 'win2', '<?php echo $status; ?>');" title="<?php echo _CMN_PDF;?>">
                        <?php echo $image; ?>
                        </a>
                        </td>
                        <?php
                }
        }

        function displaylist( &$categories, &$rows, $type_id, $currentcat=NULL, &$params, $tabclass ) {
                global $Itemid, $mosConfig_live_site, $hide_js;
                if ( $params->get( 'page_title' ) ) {
                        ?>
                        <div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
                        <?php echo $currentcat->header; ?>
                        </div>
                        <?php
                }
                ?>
                <form action="index.php" method="post" name="adminForm">

                <table width="100%" cellpadding="4" cellspacing="0" border="0" align="center" class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>">
                <tr>
                        <td width="60%" valign="top" class="contentdescription<?php echo $params->get( 'pageclass_sfx' ); ?>" colspan="2">
                        <?php
                        // show image
                        if ( $currentcat->img ) {
                                ?>
                                <img src="<?php echo $currentcat->img; ?>" align="<?php echo $currentcat->align; ?>" hspace="6" alt="<?php echo COMPANY_NAME;   ?>" />
                                <?php
                        }
                        echo $currentcat->descrip;
                        ?>
                        </td>
                </tr>
                <tr>
                        <td>
                        <?php
                        if ( count( $rows ) ) {
                                HTML_Membership::showTable( $params, $rows, $type_id, $tabclass );
                        }
                        ?>
                        </td>
                </tr>
                <tr>
                        <td>&nbsp;

                        </td>
                </tr>
                <tr>
                        <td>
                        <?php
                        // Displays listing of Categories
                        if ( ( $params->get( 'type' ) == 'category' ) && $params->get( 'other_cat' ) ) {
                                HTML_Membership::showCategories( $params, $categories, $type_id );
                        } else if ( ( $params->get( 'type' ) == 'section' ) && $params->get( 'other_cat_section' ) ) {
                                HTML_Membership::showCategories( $params, $categories, $type_id );
                        }
                        ?>
                        </td>
                </tr>
                </table>
                </form>
                <?php
                // displays back button
                mosHTML::BackButton ( $params, $hide_js );
        }

        /**
        * Display Table of items
        */
        function showTable( &$params, &$rows, $type_id, $tabclass ) {
                global $mosConfig_live_site,$Itemid;
                // icon in table display
                if ( $params->get( 'membership_icons' ) <> -1 ) {
                        $img = mosAdminMenus::ImageCheck( 'membership.png', '/images/M_images/', $params->get( 'membership_icons' ) );
                } else {
                        $img = NULL;
                }
                ?>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <?php
                if ( $params->get( 'headings' ) ) {
                        ?>
                        <tr>
                                <?php
                                if ( $img ) {
                                        ?>
                                        <td width=5% class="sectiontableheader<?php echo $params->get( 'pageclass_sfx' );  ?>">&nbsp;

                                        </td>
                                        <?php
                                }
                                ?>
                                <td width="45%" height="20"  class="sectiontableheader<?php echo $params->get( 'pageclass_sfx' ); ?>" align="left">
                                <?php echo "Firm Name"; ?>
                                </td>
                                <td width="45%" height="20" align=left class="sectiontableheader<?php echo $params->get( 'pageclass_sfx' ); ?>">
                                <?php echo "Address"; ?>
                                </td>
                                <?php
                                if ( $params->get( 'hits' ) ) {
                                        ?>
                                        <td width="5%" height="20" class="sectiontableheader<?php echo $params->get( 'pageclass_sfx' ); ?>" align="right">
                                        <div align=left><?php echo _HEADER_HITS; ?></div>
                                        </td>
                                        <?php
                                }
                                ?>
                        </tr>
                        <?php
                }

                $k = 0;
                foreach ($rows as $row) {
                        $iparams =& new mosParameters( $row->params );

                        $link = sefRelToAbs( 'index.php?option=com_membership_bkmea&task=view&Itemid='.$Itemid.'&type_id='. $type_id .'&id='. $row->id );
                        $menuclass = 'category'.$params->get( 'pageclass_sfx' );
                        switch ($iparams->get( 'target' )) {
                                // cases are slightly different
                                case 1:
                                // open in a new window
                                $txt = '<a href="'. $link .'" target="_blank" class="'. $menuclass .'">'. $row->firm_name .'</a>';
                                break;

                                case 2:
                                // open in a popup window
                                $txt = "<a href=\"#\" onclick=\"javascript: window.open('". $link ."', '', 'toolbar=no,location=no,status=no,menubar=no,scrollbars=yes,resizable=yes,width=780,height=550'); return false\" class=\"$menuclass\">". $row->companyname ."</a>\n";
                                break;

                                default:        // formerly case 2
                                // open in parent window
                                $txt = '<a href="'. $link .'" class="'. $menuclass .'">'. $row->firm_name .'</a>';
                                break;
                        }
                        ?>
                        <tr class="<?php echo $tabclass[$k]; ?>">
                                <?php
                                if ( $img ) {
                                        ?>
                                        <td height="20" align="center">
                                        &nbsp;&nbsp;<?php echo $img;?>&nbsp;&nbsp;
                                        </td>
                                        <?php
                                }
                                ?>
                                <td height="20">
                                <?php echo $txt; ?>
                                </td>
                                <td height="20">
                                <?php echo $row->applicant_address; ?>
                                </td>
                                <td height="20" align="center">
                                <?php echo $row->hits; ?>
                                </td>
                        </tr>
                        <?php
                        $k = 1 - $k;
                }
                ?>
                </table>
                <?php
        }

        function showMember( &$rows, $type_id, $id, $tabclass, &$params, $currentcat=NULL ) {
                global $mainframe, $my, $hide_js;
                global $mosConfig_sitename, $Itemid, $mosConfig_live_site, $task;
                global $_MAMBOTS;
                foreach ($rows as $row) { }
                if ( $params->get( 'page_title' ) ) {
                        ?>
                        <div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
                        <?php echo $currentcat->header; ?>
                        </div>
                        <?php
                }
                // icon in table display
                if ( $params->get( 'Membership_icons' ) <> -1 ) {
                        $img = mosAdminMenus::ImageCheck( 'membership.png', '/images/M_images/', $params->get( 'membership_icons' ) );
                } else {
                        $img = NULL;
                }
                ?>

                <?php
                if ( $params->get( 'item_title' ) || $params->get( 'pdf' )  || $params->get( 'print' ) || $params->get( 'email' ) ) {
                        // link used by print button
                        $print_link = $mosConfig_live_site. '/index2.php?option=com_membership_bkmea&amp;task=view&amp;id='. $row->id .'&amp;Itemid='. $Itemid .'&amp;pop=1';
                        ?>
                        <table class="contentpaneopen<?php echo $params->get( 'pageclass_sfx' ); ?>">
                        <tr>
                        <td width=70%>
                        <div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
                         <?php
                          if ( $params->get( 'headings' ) ) {
                             echo "Membership details";
                          }
                          ?>
                         </div>
                        </td>
                        <td width=40%>
                                <?php
                                // displays Item Title
                                //HTML_content::Title( $row, $params, $link_on, $access );

                                // displays PDF Icon
                                HTML_Membership::PdfIcon( $row, $params, $hide_js );

                                // displays Print Icon
                                mosHTML::PrintIcon( $row, $params, $hide_js, $print_link );

                                // displays Email Icon
                                //HTML_content::EmailIcon( $row, $params, $hide_js );
                                ?>
                        </td>
                        </tr>
                        </table>
                        <?php
                 }
                 /*
                 class="contentpane<?php echo $params->get( 'pageclass_sfx' ); ?>"
                 */
                 ?>

                <table width="100%" border="0" cellspacing="0" cellpadding="0" >

                <?php

                        $iparams =& new mosParameters( $row->params );

                        $link = sefRelToAbs( 'index.php?option=com_membership_bkmea&task=view&type_id='. $type_id .'&id='. $row->id );
                        $menuclass = 'category'.$params->get( 'pageclass_sfx' );
                        $txt="";
                        ?>
                        <tr>
                            <td width=30% height="20" align="left" class="contentdescription<?php echo $params->get( 'pageclass_sfx' ); ?>">
                              <b>&nbsp;Company Name </b>
                            </td>
                            <td width=70% height="20" align="left">
                                <?php echo $row->companyname;?>
                            </td>
                        </tr>
                        <tr >
                            <td  height="20" align="left">
                              <b>&nbsp;Registration Date</b>
                            </td>
                            <td  height="20" align="left">
                                <?php echo "$row->start_date to $row->end_date";?>
                            </td>
                        </tr>
                        <tr >
                            <td  height="20" align="left">
                              <b>&nbsp;Contact Person</b>
                            </td>
                            <td  height="20" align="left">
                                <?php echo $row->person;?>
                            </td>
                        </tr>
                        <tr >
                            <td  height="20" align="left">
                              <b>&nbsp;Business Address</b>
                            </td>
                            <td w height="20" align="left">
                                <?php echo $row->address1;?>
                            </td>
                        </tr>
                        <tr >
                            <td  height="20" align="left">
                              <b>&nbsp;Mailing Address</b>
                            </td>
                            <td  height="20" align="left">
                                <?php echo $row->address2;?>
                            </td>
                        </tr>
                        <tr>
                            <td  height="20" >
                              <b>&nbsp;Head Office Address</b>
                            </td>
                            <td  height="20" align="left">
                                <?php echo $row->address3;?>
                            </td>
                        </tr>
                        <tr>
                            <td  height="20" >
                              <b>&nbsp;Contact Number</b>
                            </td>
                            <td  height="20" align="left">
                                <?php echo "$row->contact1(office), $row->contact2(Res)";?>
                            </td>
                        </tr>
                </table>
                <?php
        }

        /**
        * Display links to categories
        */
        function showCategories( &$params, &$categories, $type_id ) {
                global $mosConfig_live_site, $Itemid;
                ?>
                <ul>
                <?php
                foreach ( $categories as $cat ) {
                        if ( $type_id == $cat->type_id ) {
                                ?>
                                <li>
                                        <b>
                                        <?php echo $cat->name;?>
                                        </b>
                                        &nbsp;
                                        <span class="small">
                                        (<?php echo $cat->nummembers;?>)
                                        </span>
                                </li>
                                <?php
                        } else {
                                $link = 'index.php?option=com_membership_bkmea&Itemid=' . $Itemid. '&type_id='. $cat->type_id;
                                ?>
                                <li>
                                        <a href="<?php echo sefRelToAbs( $link ); ?>" class="category<?php echo $params->get( 'pageclass_sfx' ); ?>">
                                        <?php echo $cat->name;?>
                                        </a>
                                        &nbsp;
                                        <span class="small">
                                        (<?php echo $cat->nummembers;?>)
                                        </span>
                                </li>
                                <?php
                        }
                }
                ?>
                </ul>
                <?php
        }

        /**
        * Writes the edit form for new and existing record (FRONTEND)
        *
        * A new record is defined when <var>$row</var> is passed with the <var>id</var>
        * property set to 0.
        * @param mosWeblink The weblink object
        * @param string The html for the categories select list
        */
        function editMembership( $option, &$row, &$lists ) {
                $Returnid = intval( mosGetParam( $_REQUEST, 'Returnid', 0 ) );
                ?>
                <script language="javascript" type="text/javascript">
                function submitbutton(pressbutton) {
                        var form = document.adminForm;
                        if (pressbutton == 'cancel') {
                                submitform( pressbutton );
                                return;
                        }

                        // do field validation
                        if (form.title.value == ""){
                                alert( "Weblink item must have a title" );
                        } else if (getSelectedValue('adminForm','catid') < 1) {
                                alert( "You must select a category." );
                        } else if (form.url.value == ""){
                                alert( "You must have a url." );
                        } else {
                                submitform( pressbutton );
                        }
                }
                </script>

                <form action="<?php echo sefRelToAbs("index.php"); ?>" method="post" name="adminForm" id="adminForm">
                <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                        <td class="contentheading">
                        <?php echo _SUBMIT_LINK;?>
                        </td>
                        <td width="10%">
                        <?php
                        mosToolBar::startTable();
                        mosToolBar::spacer();
                        mosToolBar::save();
                        mosToolBar::cancel();
                        mosToolBar::endtable();
                        ?>
                        </td>
                </tr>
                </table>

                <table cellpadding="4" cellspacing="1" border="0" width="100%">
                <tr>
                        <td width="20%" align="right">
                        <?php echo _NAME; ?>
                        </td>
                        <td width="80%">
                        <input class="inputbox" type="text" name="title" size="50" maxlength="250" value="<?php echo htmlspecialchars( $row->title, ENT_QUOTES );?>" />
                        </td>
                </tr>
                <tr>
                        <td valign="top" align="right">
                        <?php echo _SECTION; ?>
                        </td>
                        <td>
                        <?php echo $lists['type_id']; ?>
                        </td>
                </tr>
                <tr>
                        <td valign="top" align="right">
                        <?php echo _URL; ?>
                        </td>
                        <td>
                        <input class="inputbox" type="text" name="url" value="<?php echo $row->url; ?>" size="50" maxlength="250" />
                        </td>
                </tr>
                <tr>
                        <td valign="top" align="right">
                        <?php echo _URL_DESC; ?>
                        </td>
                        <td>
                        <textarea class="inputbox" cols="30" rows="6" name="description" style="width:300px" width="300"><?php echo htmlspecialchars( $row->description, ENT_QUOTES );?></textarea>
                        </td>
                </tr>
                </table>

                <input type="hidden" name="id" value="<?php echo $row->id; ?>" />
                <input type="hidden" name="option" value="<?php echo $option;?>" />
                <input type="hidden" name="task" value="" />
                <input type="hidden" name="ordering" value="<?php echo $row->ordering; ?>" />
                <input type="hidden" name="approved" value="<?php echo $row->approved; ?>" />
                <input type="hidden" name="Returnid" value="<?php echo $Returnid; ?>" />
                </form>
                <?php
        }

}

?>

