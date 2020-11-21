<?php
/**
* @version $Id: admin.accounts_transaction_report_scci.php,v 1.1 2006/01/05 04:45:48 aslam Exp $
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
$for  = mosGetParam( $_REQUEST, 'for' );
$report_for  = mosGetParam( $_REQUEST, 'report_for' );
$date_from   = mosGetParam( $_REQUEST, 'date_from' );
$date_to     = mosGetParam( $_REQUEST, 'date_to' );
$option     = mosGetParam( $_REQUEST, 'option' );

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
        $lists['type_id']                   = mosAdminMenus::MemberTypeList( 'type_id', $type_id );
        $lists['report_for']                = mosAdminMenus::AccountsTransactionFor( 'report_for','0', $report_for);

        Accounts_Transaction_Report_html::View( $lists,$option );
}



?>
