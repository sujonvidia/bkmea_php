<?php
/**
* @version $Id: admin.all_member_report_bkmea.php,v 1.1 2006/07/05 06:35:27 morshed Exp $
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

        $lists=array();
		$lists['order_by']          = mosHTML::yesnoRadioList( 'order_by', 'class="inputbox"', 0,' Top Investors',' Top Employment' );
		$lists['fromYear']  		= mosHTML::integerSelectList(date('Y')-10,date('Y'),1,'fromYear', 'class="inputbox"',date('Y'));
        Member_Report_html::View( $lists );
}



?>
