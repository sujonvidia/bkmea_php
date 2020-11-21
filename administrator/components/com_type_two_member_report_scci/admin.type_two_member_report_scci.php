<?php
/**
* @version $Id: admin.type_two_member_report_scci.php,v 1.1 2006/07/13 09:16:38 morshed Exp $
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
$mailmerge  = mosGetParam( $_REQUEST, 'mailmerge' );
$office_copy  = mosGetParam( $_REQUEST, 'office_copy' );
$report_for  = mosGetParam( $_REQUEST, 'report_for' );
$date_from   = mosGetParam( $_REQUEST, 'date_from' );
$date_to     = mosGetParam( $_REQUEST, 'date_to' );

switch ($task) {
        default:
                viewMember_Report( $option );
                break;
}


/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function viewMember_Report( $option ) {
        global $database, $dbconn;
        global $type_id, $for, $mailmerge,$office_copy, $report_for, $date_from, $date_to;

        $lists=array();
        $lists['type_id']                   = mosAdminMenus::MemberTypeList( 'type_id', $type_id );
        $lists['report_for']                = mosAdminMenus::ReportFor( 'report_for', $report_for, '', $for );
        $lists['office_copy']               = mosHTML::yesnoRadioList( 'office_copy', 'class="inputbox"',1,' Office Purpose  ',' Outside Clients  ');

        Member_Report_html::View( $lists);
}



?>
