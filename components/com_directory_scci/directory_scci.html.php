<?php
/**
* @version $Id: directory_scci.html.php,v 1.6 2006/06/21 08:02:06 morshed Exp $
* @package Mambo
* @subpackage Search
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Search
*/

class search_html {

        function printformstart(  ) {

        ?>
        <script language="javascript">
            function submit_form(){
                    if(document.form1.search_type.value!="all" && document.form1.searchword.value=="") {
                            alert("Please enter search keyword.");
                            document.form1.searchword.focus();
                            return false;
                    }
                    return true;

            }
        </script>
        <?php
                echo "<form name='form1' action='index.php' method='post'>";
        }
        function printformend(  ) {
                echo "</form>";
        }
        function openhtml( $params ) {
                if ( $params->get( 'page_title' ) ) {
                        ?>
                        <div class="componentheading<?php echo $params->get( 'pageclass_sfx' ); ?>">
                        <?php echo $params->get( 'header' ); ?>
                        </div>
                        <?php
                }
        }

        function searchbox( $searchword, &$lists, $params,$pid ) {
                global $Itemid;
                ?>
                <!--form action="index.php" method="post"-->
                <table class="contentpaneopen<?php echo $params->get( 'pageclass_sfx' ); ?>">
                        <tr>
                                <td nowrap="nowrap">
                                Keyword
                                </td>
                                <td nowrap="nowrap">
                                <input type="text" name="searchword" size="15" value="<?php echo stripslashes($searchword);?>" class="inputbox" />
                                in <?php echo $lists['search_type']; ?>
                                </td>
                        </tr>
                        <tr>
                                <td nowrap="nowrap">
                                Product/Services
                                </td>
                                <td nowrap="nowrap">
                                <?php echo $lists['product_list']; ?>
                                &nbsp;&nbsp;&nbsp;Location  <?php echo $lists['location']; ?>
                                </td>
                        </tr>
                        <tr>
                                <td nowrap="nowrap">
                                Corporate Status
                                </td>
                                <td nowrap="nowrap">
                                <?php echo $lists['corporate_status']; ?>
                                &nbsp;&nbsp;&nbsp;Business Type   <?php echo $lists['business_type']; ?>
                                </td>
                        </tr>
                        <tr>
                                <td nowrap="nowrap">
                                Country of Incorporation
                                </td>
                                <td nowrap="nowrap">
                                <?php echo $lists['country_id']; ?>
                                </td>
                        </tr>
                        <tr>
                                <td nowrap="nowrap">
                                </td>
                                <td nowrap="nowrap">
                                <?php echo $lists['searchphrase']; ?>
                                <input type="submit" name="submit1" value="<?php echo _SEARCH_TITLE;?>" class="button"  onclick="javascript:return submit_form();"  />                                </td>
                        </tr>
                </table>

                <input type="hidden" name="option" value="com_directory_scci" />
                <input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" />
                <input type="hidden" name="pid" value="<?php echo $pid; ?>" />
                <!--/form-->
                <?php
        }

        function searchintro( $searchword, $params ) {
                ?>
                <table class="searchintro<?php echo $params->get( 'pageclass_sfx' ); ?>">
                <tr>
                        <td colspan="3" align="left">
                        <?php
                        if(isset($_POST['submit1']))
                           echo _PROMPT_KEYWORD . ' <b>' . stripslashes($searchword) . '</b>';
                        ?>
                <?php

        }

        function message( $message, $params ) {
                ?>
                <table class="searchintro<?php echo $params->get( 'pageclass_sfx' ); ?>">
                <tr>
                        <td colspan="3" align="left">
                        <?php eval ('echo "'.$message.'";');        ?>
                        </td>
                </tr>
                </table>
                <?php


        }

        function display( $totalRows, $price, $search_criteria ,$pid) {
                global $mosConfig_live_site;

                $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                //search_html::PdfIcon( $phrase, $location, $product );
                // number of matches found
                printf( _SEARCH_MATCHES, $totalRows );
                //echo search_html::PdfIcon( $search_criteria);
                ?>
                        </td>
                </tr>
                </table>
                <br />
                <?php if($totalRows!=0){ ?>
                <table class="contentpaneopen">

                <tr class="sectiontableheader" height="24">
                    <td width="28%">
                    &nbsp;<b>Type</b>
                    </td>
                    <td width="11%" align="center" >
                    <b>#&nbsp;of&nbsp;Matches</b>
                    </td>
                    <td width="23%" align="center">
                    <b>Price for Member</b>
                    </td>
                    <td width="27%" align="center">
                    <b>Price for Non-member</b>
                    </td>
                    <td width="11%">
                    </td>
                </tr>

                <tr class="sectiontableentry3"  height="20">
                    <td>
                    &nbsp;General Contact
                    </td>
                    <td  align="center">
                    <?php echo $totalRows; ?>
                    </td>
                    <!--td  align="center">
                    <?php
                    $member_price=$price['general_contact_member'];
                    echo $member_price;
                    ?> Tk.
                    </td>
                    <td  align="center">
                    <?php
                    $nonmember_price=$price['general_contact_non_member'];
                    echo $nonmember_price;

                    ?> Tk.
                    </td-->
                    <td  align="center">
                    <?php
                    $member_price=$price['general_contact_member']==intval($price['general_contact_member'])?$price['general_contact_member'].".00":round($price['general_contact_member'],2);
                    echo "Tk. ".$member_price;
                    ?>
                    </td>
                    <td  align="center">
                    <?php
                    $nonmember_price=$price['general_contact_non_member']==intval($price['general_contact_non_member'])?$price['general_contact_non_member'].".00":round($price['general_contact_non_member'],2);
                    echo "Tk. ".$nonmember_price;

                    ?>
                    </td>
                    <td >
                    <A HREF="index.php?option=com_docman&search_criteria=<?php echo $search_criteria; ?>&task=doc_purchase&step=1&pid=<?php echo $pid; ?>&directorytype=gen&member_price=<?php echo $member_price; ?>&nonmember_price=<?php echo $nonmember_price; ?>" onMouseOver="javascript:window.status='Info Product';return true;">Purchase</a>
                    </td>
                </tr>
                <tr class="sectiontableentry3"  height="20">
                    <td >
                    &nbsp;Full Profile
                    </td>
                    <td  align="center">
                    <?php echo $totalRows; ?>
                    </td>
                    <!--td  align="center">
                    <?php
                    $member_price =$price['detail_contact_member'];
                    echo $member_price;
                    ?> Tk.
                    </td>
                    <td  align="center">
                    <?php
                    $nonmember_price=$price['detail_contact_non_member'];
                    echo $nonmember_price;
                    ?> Tk.
                    </td-->
                    <td  align="center">
                    <?php
                    $member_price =$price['detail_contact_member']==intval($price['detail_contact_member'])?$price['detail_contact_member'].".00":round($price['detail_contact_member'],2);
                    echo "Tk. ".$member_price;
                    ?>
                    </td>
                    <td  align="center">
                    <?php
                    $nonmember_price=$price['detail_contact_non_member']==intval($price['detail_contact_non_member'])?$price['detail_contact_non_member'].".00":round($price['detail_contact_non_member'],2);
                    echo "Tk. ".$nonmember_price;
                    ?>
                    </td>
                    <td >
                    <A HREF="index.php?option=com_docman&search_criteria=<?php echo $search_criteria; ?>&task=doc_purchase&step=1&pid=<?php echo $pid; ?>&directorytype=full&member_price=<?php echo $member_price; ?>&nonmember_price=<?php echo $nonmember_price; ?>" onMouseOver="javascript:window.status='Info Product';return true;">Purchase</a>
                    </td>
                </tr>
                </table>
        <?php
             }
        }
        function PdfIcon( $search_criteria ) {
               global $mosConfig_live_site;
               global $searchword, $search_type;//, $_POST['product_list'], $_POST['location']
               $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
               $link = $mosConfig_live_site. "/index2.php?option=com_search_scci&amp;do_pdf=1&amp;pdf_type=gen&amp;search_criteria=".$search_criteria;
               $image = mosAdminMenus::ImageCheck( 'pdf_button.png', '/images/M_images/', NULL, NULL, _CMN_PDF );
               echo $link;
               ?>
               <a href="javascript:void window.open('<?php echo $link; ?>', 'win2', '<?php echo $status; ?>');" title="<?php echo _CMN_PDF;?>">
               Print <?php echo $image; ?>
               </a>
               <?php
        }

}
?>
