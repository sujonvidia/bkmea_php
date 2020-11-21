<?php
/**
* @version $Id: admin.info_product_list_report.php,v 1.1 2006/05/14 10:36:20 nnabi Exp $
* @package Mambo
* @subpackage Categories
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );

// get parameters from the URL or submitted form

$type_id     = mosGetParam( $_REQUEST, 'type_id' );
$for  = trim(mosGetParam( $_REQUEST, 'for' ));
$report_for  = mosGetParam( $_REQUEST, 'report_for' );
$date_from   = mosGetParam( $_REQUEST, 'date_from' );
$date_to     = mosGetParam( $_REQUEST, 'date_to' );
$option     = mosGetParam( $_REQUEST, 'option' );
$infoProductCategory     = mosGetParam( $_REQUEST, 'info_product_category' );

switch ($task) {
        default:
                viewAccounts_Transaction_Report( $option );
                break;
}


/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function viewAccounts_Transaction_Report( $option ) {
        global $database, $dbconn;
        global $type_id, $for, $report_for, $date_from, $date_to;

        $lists=array();
        $lists['info_product']                = mosAdminMenus::infoProductList( 'info_product','0');
        $lists['info_product_category']        = mosAdminMenus::ProductCategory( 'info_product_category', 'com_docman'  );
        info_Product_List_Report_html::View( $lists,$option );
}



?>
