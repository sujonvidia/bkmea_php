<?php
/**
* @version $Id: toolbar.info_product_sales_report_bkmea.php,v 1.1 2006/04/24 04:08:58 morshed Exp $
* @package Mambo
* @subpackage Categories
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'toolbar_html' ) );

switch ($task){
        case 'new':
        case 'edit':
        case 'editA':
                TOOLBAR_accounts_transaction::_EDIT();
                break;

        case 'moveselect':
                TOOLBAR_accounts_transaction::_MOVE();
                break;

        case 'copyselect':
                TOOLBAR_accounts_transaction::_COPY();
                break;

        default:
                TOOLBAR_accounts_transaction::_DEFAULT();
                break;
}
?>
