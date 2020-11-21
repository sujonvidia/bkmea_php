<?php 
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
/*
* @version $Id: install.phpshop.php,v 1.13 2005/05/26 19:55:24 soeren_nb Exp $
* @package mambo-phpShop
* @subpackage Core
*
* @copyright (C) 2004 Soeren Eberhardt
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* mambo-phpShop is Free Software.
* mambo-phpShop comes with absolute no warranty.
*
* www.mambo-phpshop.net
*/
function com_install() 
{
global $mosConfig_absolute_path, $database;
include( $mosConfig_absolute_path. "/administrator/components/com_phpshop/version.php" );

// Check for some mambo-phpShop Tables. When they exist,
// offer an Upgrade
$database->setQuery( "SHOW TABLES LIKE '%pshop_%'" );
$pshop_tables = $database->loadObjectList();

if( !empty( $pshop_tables )) {
  $installation = "update";
}
else
  $installation = "new";
?>
<link rel="stylesheet" href="components/com_phpshop/install.css" type="text/css" />
<div align="center">
<table width="100%" border="0">
  <tr>
    <td valign="middle" align="center">
    
    <div id="ctr" align="center">
          <div class="install">
          <div id="stepbar">
            <div>
              <a href="http://www.mambo-phpShop.net" target="_blank">
              <img border="0" align="right" src="components/com_phpshop/cart.gif" alt="Cart" />
              </a><br/>
            </div>
          <div class="clr"></div><br/><br/><br/>

            <div class="step-on" >
              <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                Please consider a small donation to help me keep up the work on this component.<br /><br />
                <input type="hidden" name="cmd" value="_xclick" />
                <input type="hidden" name="business" value="soeren_nb@yahoo.de" />
                <input type="hidden" name="item_name" value="mambo-phpShop Donation" />
                <input type="hidden" name="item_number" value="" />
                <input type="hidden" name="currency_code" value="EUR" />
                <input type="hidden" name="tax" value="0" />
                <input type="hidden" name="no_note" value="0" />
                <input type="hidden" name="amount" value="" />
                <input type="image" src="components/com_phpshop/x-click-but21.gif" border="0" name="submit" alt="Make payments with PayPal - it's fast, free and secure!" />
              </form>
            </div>
          </div>
  
          
          <div id="right">

          <div id="step">Welcome to mambo-phpShop 1.2!</div>

          <div class="clr"></div>
          <pre><?php echo $version ?></pre>
          <h1>The first step of the Installation was <font color="green">SUCCESSFUL</font></h1>
          <table>
          <?php
          if( $installation == "new" ) { ?>
            <tr><td colspan="3" class="error">Let's prepare the database now (the Installation Script hasn't found existing mambo-phpShop Tables, so let's do a fresh installation).</td></tr>
            <tr>
              <td width="40%">Basic Installation has been finished. You can use mambo-phpShop in a moment after having clicked on a link below.<br/>
              </td>
              <td width="20%">&nbsp;</td>
              <td width="40%">
                To fill your Shop with dummy products, and to see how things can be set up, 
                you can install some Sample Data now.
              </td>
            </tr>
            <tr>
              <td width="40%">
                <a title="Go directly to the Shop &gt;&gt;" onclick="alert('Please don\'t interrupt the next Step! \n It is essential for running mambo-phpShop.');" name="Button1" class="button" href="index2.php?option=com_phpshop&install_type=newinstall">Go directly to the Shop &gt;&gt;</a>
              </td>
              <td width="20%">&nbsp;</td>
              <td width="40%">
              <a name="Button2" onclick="alert('Please don\'t interrupt the next Step! \n It is essential for running mambo-phpShop.');" class="button" title="Install SAMPLE DATA &gt;&gt;" href="index2.php?option=com_phpshop&install_type=newinstall&install_sample_data=true">Install SAMPLE DATA &gt;&gt;</a>
              </td>
            </tr>
            <tr>
              <td align="center" colspan="3"><br /><br /><hr /><br /></td>
            </tr>
          <?php 
          }
          else {  ?>
          <tr><td colspan="3" class="error">[UPDATE MODE]<br/>The Installation Script has found existing mambo-phpShop Tables, so let's update your Database.</td></tr>
            <tr>
              <td align="left" colspan="3">
                If you're upgrading from version <strong>1.2 RC2</strong> or <strong>Mambo eCommerce Edition</strong> you'll have to click on this link!<br />
                
                <br /><br/>
                <div align="center">
                <a title="UPDATE FROM VERSION 1.2 RC2 &gt;&gt;" onclick="alert('Please don\'t interrupt the next Step! \n It is essential for updating mambo-phpShop.');" name="Button2" class="button" href="index2.php?option=com_phpshop&install_type=update12">UPDATE FROM VERSION 1.2 RC2 &gt;&gt;</a>
                </div>
                <div class="error">Note:</div>If your Version Number is between 1.1 and 1.2 RC2 (e.g. <i>1.2 beta3</i>), you have to update your database before using the Step-by-Step SQL Update Scripts from the folder <pre>
                /administrator/components/com_phpshop/sql</pre> of your mambo-phpShop Installation. You can run these Scripts with <a href="http://mamboforge.net/projects/mosphpmyadmin/" target="_blank">phpMyAdmin for Mambo</a>.
                
              </td>
            </tr>
            <tr>
              <td align="center" colspan="3"><br /><br /><hr /><br /></td>
            </tr>
            <tr>
              <td align="center" colspan="3">If you're updating from version 1.1(a) you'll have to click on this link!<br /><br />
                <a name="Button2" class="button" title="UPDATE FROM VERSION 1.1(a) &gt;&gt;" onclick="alert('Please don\'t interrupt the next Step! \n It is essential for updating mambo-phpShop.');" href="index2.php?option=com_phpshop&install_type=update11">UPDATE FROM VERSION 1.1(a) &gt;&gt;<a />
              </td>
            </tr>
            <tr>
              <td align="center" colspan="3"><br /><br /><hr /><br /></td>
            </tr>
          <?php 
          } ?>
            <tr>
              <td align="center" colspan="3">Go to <a href="http://www.mambo-phpShop.net" target="_blank">mambo-phpShop.net</a> for further Help</td>
            </tr>
          </table>
          </div>

          <div class="clr"></div>
          
          </div>
  
   </td>
  </tr>
</table>
</div>
<?php
}
?>
