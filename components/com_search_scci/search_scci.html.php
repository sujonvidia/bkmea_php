<?php
/**
* @version $Id: search_scci.html.php,v 1.8 2006/06/21 08:02:06 morshed Exp $
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
                global $Itemid, $mosConfig_sitename;
                  $action_link_directory="index.php?option=com_directory_".strtolower($mosConfig_sitename);
                  $action_link_infoproduct="index.php?option=com_docman&task=search_result&Itemid=26";
                ?>
                <script language="javascript">

                  function submit_form(){
                          if(document.frmDirectory.search_type.value!="all" && document.frmDirectory.searchword.value=="") {
                                  alert("Please enter search keyword.");
                                  document.frmDirectory.searchword.focus();
                                  return false;
                          }
                          return true;

                  }
                </script>
                <table width="100%" cellspacing="0" cellpadding="0"  >
                    <tr >
                        <td width="49%" >
                             <form name='frmDirectory' action='<?php echo $action_link_directory; ?>' method='post'>
                             <table class="contentbg"  width="100%" cellspacing="1" cellpadding="0"><tr><td>
                             <table class="greybg" width="100%" height="160">
                                 <tr>
                                         <td nowrap="nowrap">
                                         <b>Search Directory</b>
                                         </td>
                                 </tr>
                                 <tr>
                                         <td nowrap="nowrap">
                                         Keyword
                                         <input type="text" name="searchword"size="15" value="<?php echo stripslashes($searchword);?>" class="inputbox" />
                                         </td>
                                 </tr>
                                 <tr>
                                         <td nowrap="nowrap">
                                         Search in <?php echo $lists['search_type']; ?>
                                         </td>
                                 </tr>
                                 <tr>
                                         <td nowrap="nowrap">
                                         Product/Services <?php echo $lists['product_list']; ?>
                                         </td>
                                 </tr>
                                 <tr>
                                        <td nowrap="nowrap" >
                                        Corporate Status   <?php echo $lists['corporate_status']; ?>
                                        </td>
                                 </tr>
                                 <tr>
                                        <td nowrap="nowrap" >
                                        Country of Incorporation   <?php echo $lists['country_id']; ?>
                                        </td>
                                 </tr>
                                 <tr>
                                        <td nowrap="nowrap" >
                                        Business Type   <?php echo $lists['business_type']; ?>
                                        </td>
                                 </tr>
                                 <tr>
                                         <td nowrap="nowrap">
                                         Location  <?php echo $lists['location']; ?>
                                         </td>
                                 </tr>
                                 <tr>
                                         <td colspan="3">
                                         <?php echo $lists['searchphrase']; ?>
                                         </td>
                                 </tr>
                                 <tr>
                                         <td nowrap="nowrap">
                                         <!--input type="hidden" name="Itemid" value="<?php echo $Itemid; ?>" /-->
                                         <input type="hidden"  name="pid" value="<?php echo $pid;?>"  />
                                         <input type="submit" name="submit1" value="<?php echo _SEARCH_TITLE;?>" class="button"  onclick="javascript:return submit_form();" />
                                         </td>
                                 </tr>
                             </table>
                             </td></tr></table>
                             </form>
                        </td>
                        <td width="3%"  >
                        </td >
                        <td width="48%"  valign="top">
                            <form name='frmInfoProduct' action='<?php echo $action_link_infoproduct; ?>' method='post' >
                            <table class="contentbg"  width="100%" cellspacing="1" cellpadding="0"  ><tr><td>
                            <table class="greybg" width="100%" height="160">
                                <tr>
                                         <td nowrap="nowrap">
                                         <b>Search Information Product</b>
                                         </td>
                                </tr>
                                <tr>
                                        <td nowrap="nowrap" >
                                        Keyword
                                        <input type="text" class="inputbox" id="search_phrase" name="search_phrase"  value="<?php echo $search_phrase ?>" />
                                        </td>
                                </tr>
                                <tr>
                                        <td nowrap="nowrap" >
                                         Search in <?php echo $lists['search_type1']; ?>
                                        </td>
                                </tr>
                                <tr>
                                        <td nowrap="nowrap" >
                                        Category   <?php echo $lists['catid'] ;?>
                                        </td>
                                </tr>
                                <tr>
                                        <td nowrap="nowrap" >
                                        Search By
                                        <?php echo $lists['invert_search'] . 'Not' ;?>
                                        <?php echo $lists['search_mode'] ;?>
                                        </td>
                                </tr>
                                 <tr>
                                        <td nowrap="nowrap">
                                        <input type="submit"  value="Search"   class="button" />
                                        </td>
                                 </tr>
                             </table>
                             </td></tr></table>
                             </form>
                        </td>
                    </tr>
                </table>
                <?php
        }
        function message( $message, $params ) {
                ?>
                <table class="searchintro">
                <tr>
                        <td colspan="3" align="left">
                        <?php eval ('echo "'.$message.'";');        ?>
                        </td>
                </tr>
                </table>
                <?php
        }
}
?>
