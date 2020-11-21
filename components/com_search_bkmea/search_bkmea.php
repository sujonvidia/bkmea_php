<?php
/**
* @version $Id: search_bkmea.php,v 1.8 2006/05/28 04:13:56 nnabi Exp $
* @package Mambo
* @subpackage Search
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'front_html' ) );

switch ( $task ) {
        default:
                viewSearch();
                break;
}

$mail_opt = mosGetParam( $_REQUEST, 'mail_opt' );
$firm = mosGetParam( $_REQUEST, 'firm' );
$invert_search = mosGetParam($_REQUEST, 'invert_search', 0);

function viewSearch() {
        global $mainframe, $mosConfig_absolute_path, $mosConfig_lang, $my;
        global $Itemid, $database, $_MAMBOTS;

        $gid = $my->gid;
        $pid = mosGetParam( $_REQUEST, 'pid' );
        // Adds parameter handling
        if( $Itemid > 0 ) {
                $menu =& new mosMenu( $database );
                $menu->load( $Itemid );
                $params =& new mosParameters( $menu->params );
                $params->def( 'page_title', 1 );
                $params->def( 'pageclass_sfx', '' );
                $params->def( 'header', $menu->name, _SEARCH_TITLE );
                $params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
        } else {
                $params =& new mosParameters('');
                $params->def( 'page_title', 1 );
                $params->def( 'pageclass_sfx', '' );
                $params->def( 'header', _SEARCH_TITLE );
                $params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );
        }

        $searchword = mosGetParam( $_REQUEST, 'searchword', '' );
        $searchword = $database->getEscaped( trim( $searchword ) );

        $search_type = mosGetParam( $_REQUEST, 'search_type', '' );
        $search_type = $database->getEscaped( trim( $search_type ) );

        $search_ignore = array();
        @include "$mosConfig_absolute_path/language/$mosConfig_lang.ignore.php";

        $searchphrase = mosGetParam( $_REQUEST, 'searchphrase', 'any' );
        $searchphrases = array();

        $phrase = new stdClass();
        $phrase->value = 'any';
        $phrase->text = _SEARCH_ANYWORDS;
        $searchphrases[] = $phrase;

        $phrase = new stdClass();
        $phrase->value = 'all';
        $phrase->text = _SEARCH_ALLWORDS;
        $searchphrases[] = $phrase;

        $phrase = new stdClass();
        $phrase->value = 'exact';
        $phrase->text = _SEARCH_PHRASE;
        $searchphrases[] = $phrase;

        $lists=array();
        $lists['searchphrase'] = mosHTML::radioList( $searchphrases, 'searchphrase', '', mosGetParam( $_REQUEST, 'searchphrase', '' ) );
        $lists['location']     = mosAdminMenus::SearchLocation( 'location',$_POST['location']);
        $lists['product_list'] = mosAdminMenus::ProductList( 'product_list', $_POST['product_list'] );
        $lists['search_type']  = mosAdminMenus::SearchOption( 'search_type', $_POST['search_type'] );
        $lists['member_category_id']        = mosAdminMenus::MemberCategory( 'member_category_id', $option, intval( $_SESSION['member_category_id'] ) );
        $lists['compliance_list']              = mosAdminMenus::ComplianceListSingle( 'compliance_list', $_POST['compliance_list'] );
        $lists['is_direct_export']          = mosHTML::yesnoRadioList( 'is_direct_export', 'class="inputbox"', $_POST['is_direct_export'] );
        //$lists['is_direct_export']          = mosHTML::yesnoCheckBox( 'is_direct_export[]', 'class="inputbox"','', $javascript );
        $mode = array();
        $mode[] = mosHTML::makeOption('any' , "Any words");
        $mode[] = mosHTML::makeOption('all' , "All words");
        $mode[] = mosHTML::makeOption('exact', "Exact phrase");
        $lists['search_mode'] = mosHTML::selectList($mode , 'search_mode', 'id="search_mode" class="inputbox"' , 'value', 'text', $search_mode);
        $lists['invert_search'] = '<input type="checkbox" class="inputbox" name="invert_search" '. ($invert_search ? ' checked ' : ''). '/>';
        $lists['catid']  = mosAdminMenus::ProductCategory( 'catid', "com_docman", $_POST['catid'] );
        $lists['search_type1']  = mosAdminMenus::InfoProductSearchOption( 'search_type', $_POST['search_type'] );
        // html output
        search_html::searchbox( htmlspecialchars( $searchword ), $lists, $params,$pid );
}

?>
