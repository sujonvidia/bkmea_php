<?php
/**
* @version $Id: membership_bkmea.php,v 1.1 2005/12/01 07:55:04 aslam Exp $
* @package Mambo
* @subpackage Weblinks
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/** load the html drawing class */
require_once( $mainframe->getPath( 'front_html' ) );
require_once( $mainframe->getPath( 'class' ) );
$mainframe->setPageTitle( "Membership" );

$task = trim( mosGetParam( $_REQUEST, 'task', "" ) );
$id = intval( mosGetParam( $_REQUEST, 'id', 0 ) );
$sectionid         = trim( mosGetParam( $_REQUEST, 'sectionid', 0 ) );
$type_id = intval( mosGetParam( $_REQUEST, 'type_id', 0 ) );
$Itemid = intval( mosGetParam( $_REQUEST, 'Itemid', 0 ) );

// cache activation
$cache =& mosCache::getCache( 'com_membership_bkmea' );

switch ($task) {
        case 'new':
        editMembership( 0, $option );
        break;

        case 'edit':
        /** disabled until permissions system can handle it */
        editMembership( 0, $option );
        break;

        case 'save':
        saveMembership( $option );
        break;

        case 'cancel':
        cancelMembership( $option );
        break;

        case 'view':
        showItem( $id, $type_id, $Itemid );
        break;

        default:
        listMembership( $type_id );
        break;
}

function listMembership( $type_id ) {
        global $mainframe, $database, $my;
        global $mosConfig_shownoauth, $mosConfig_live_site, $mosConfig_absolute_path;
        global $cur_template, $Itemid;

        /* Query to retrieve all categories that belong under the web links section and that are published. */
        $query = "SELECT *, COUNT(m.id) AS nummembers FROM #__member_type AS mt"
        . "\n LEFT JOIN #__membership AS m ON m.type_id = mt.id"
        . "\n WHERE m.published='1' AND m.approved='1'  AND mt.published='1' AND mt.access <= '$my->gid'"
        . "\n GROUP BY mt.id"
        . "\n ORDER BY mt.ordering"
        ;
        $database->setQuery( $query );
        $categories = $database->loadObjectList();

        $rows = array();
        $currentcat = NULL;
        if ( $type_id ) {
                // membership
                $query = "SELECT id, firm_name, applicant_address, hits, params FROM #__membership as m"
                . "\nWHERE type_id = '$type_id' AND published='1' AND approved='1' AND archived=0"
                . "\nORDER BY ordering"
                ;
                $database->setQuery( $query );
                $rows = $database->loadObjectList();

                // current cate info
                $query = "SELECT name, description, FROM #__member_type"
                . "\n WHERE id = '$type_id'"
                . "\n AND published = '1'"
                ;
                $database->setQuery( $query );
                $database->loadObject( $currentcat );
        }

        // Parameters
        $menu =& new mosMenu( $database );
        $menu->load( $Itemid );
        $params =& new mosParameters( $menu->params );

        $params->def( 'hits', $mainframe->getCfg( 'hits' ) );

        $params->def( 'page_title', 1 );
        $params->def( 'header', $menu->name );
        $params->def( 'pageclass_sfx', '' );
        $params->def( 'headings', 1 );
        $params->def( 'item_description', 1 );
        $params->def( 'other_cat_section', 1 );
        $params->def( 'other_cat', 1 );
        $params->def( 'description', 1 );
        $params->def( 'description_text', 'Membership' );
        $params->def( 'image', '-1' );
        $params->def( 'membership_icons', '' );
        $params->def( 'image_align', 'right' );
        $params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );

        if ( $type_id ) {
                $params->set( 'type', 'type' );
        } else {
                $params->set( 'type', 'section' );
        }

        // page description
        $currentcat->descrip = '';
        if( ( @$currentcat->description ) <> '' ) {
                $currentcat->descrip = $currentcat->description;
        } else if ( !$type_id ) {
                // show description
                if ( $params->get( 'description' ) ) {
                        $currentcat->descrip = $params->get( 'description_text' );
                }
        }

        // page image
        $currentcat->img = '';
        $path = $mosConfig_live_site .'/images/stories/';
        if ( ( @$currentcat->image ) <> '' ) {
                $currentcat->img = $path . $currentcat->image;
                $currentcat->align = $currentcat->image_position;
        } else if ( !$catid ) {
                if ( $params->get( 'image' ) <> -1 ) {
                        $currentcat->img = $path . $params->get( 'image' );
                        $currentcat->align = $params->get( 'image_align' );
                }
        }

        // page header
        $currentcat->header = '';
        if ( @$currentcat->name <> '' ) {
                $currentcat->header = $currentcat->name;
        } else {
                $currentcat->header = $params->get( 'header' );
        }

        // used to show table rows in alternating colours
        $tabclass = array( 'sectiontableentry1', 'sectiontableentry2' );

        HTML_Membership::displaylist( $categories, $rows, $type_id, $currentcat, $params, $tabclass );
}


function showItem ( $id, $type_id, $Itemid ) {
        global $mainframe, $database, $my;
        global $mosConfig_shownoauth, $mosConfig_live_site, $mosConfig_absolute_path;
        global $cur_template, $Itemid;
        $currentcat = NULL;
        //Record the hit
        $sql="UPDATE #__membership SET hits = hits + 1 WHERE id = ". $id ."";
        $database->setQuery( $sql );
        $database->query();

        $query=" SELECT m.id as id, m.type_id as type_id, m.companyname as companyname,"
        ."\n mry.start_date as start_date, mry.end_date as end_date,"
        ."\n m.person as person, m.address1 as address1, m.address2 as address2,"
        ."\n m.address3 as address3, m.contact1 as contact1, m.contact2 as contact2"
        ."\n FROM #__membership as m"
        ."\n , #__member_reg_year as mry "
        ."\n WHERE m.id = '$id' "
        ."\n and mry.id=m.member_reg_id" ;

        $database->setQuery($query);
        $rows = $database->loadObjectList();
        //$rows->load( $id );

        // Parameters
        $menu =& new mosMenu( $database );
        $menu->load( $Itemid );
        $params =& new mosParameters( $menu->params );
        $params->def( 'print', !$mainframe->getCfg( 'hidePrint' ) );
        $params->def( 'pdf', !$mainframe->getCfg( 'hidePdf' ) );
        $params->def( 'email', !$mainframe->getCfg( 'hideEmail' ) );
        $params->def( 'hits', $mainframe->getCfg( 'hits' ) );
        $params->def( 'icons', $mainframe->getCfg( 'icons' ) );

        $params->def( 'page_title', 1 );
        $params->def( 'header', $menu->name );
        $params->def( 'pageclass_sfx', '' );
        $params->def( 'headings', 1 );
        $params->def( 'hits', $mainframe->getCfg( 'hits' ) );
        $params->def( 'item_description', 1 );
        $params->def( 'other_cat_section', 1 );
        $params->def( 'other_cat', 1 );
        $params->def( 'description', 1 );
        $params->def( 'description_text', 'Membership detail ..' );
        $params->def( 'image', '-1' );
        $params->def( 'Membership_icons', '' );
        $params->def( 'image_align', 'right' );
        $params->def( 'back_button', $mainframe->getCfg( 'back_button' ) );

        if ( $type_id ) {
                $params->set( 'type', 'type' );
        } else {
                $params->set( 'type', 'section' );
        }

        // page description
        $currentcat->descrip = '';
        if( ( @$currentcat->description ) <> '' ) {
                $currentcat->descrip = $currentcat->description;
        } else if ( !$type_id ) {
                // show description
                if ( $params->get( 'description' ) ) {
                        $currentcat->descrip = $params->get( 'description_text' );
                }
        }

        // used to show table rows in alternating colours
        $tabclass = array( 'sectiontableentry1', 'sectiontableentry2' );

        //listMembership( $catid );
        HTML_Membership::showMember( $rows, $type_id, $id, $tabclass, $params, $currentcat );
}

function editWebLink( $id, $option ) {
        global $database, $my;
        global $mosConfig_absolute_path, $mosConfig_live_site;

        if ($my->gid < 1) {
                mosNotAuth();
                return;
        }

        $row = new mosMembership( $database );
        // load the row from the db table
        $row->load( $id );

        // fail if checked out not by 'me'
        if ($row->checked_out && $row->checked_out <> $my->id) {
                mosRedirect( "index2.php?option=$option",
                'The module $row->title is currently being edited by another administrator.' );
        }

        if ($id) {
                $row->checkout( $my->id );
        } else {
                // initialise new record
                $row->published                 = 0;
                $row->approved                 = 0;
                $row->ordering                 = 0;
        }

        // build list of categories
        $lists['catid']                         = mosAdminMenus::ComponentCategory( 'catid', $option, intval( $row->catid ) );

        HTML_Membership::editMembership( $option, $row, $lists );
}

function cancelMembership( $option ) {
        global $database, $my;

        if ($my->gid < 1) {
                mosNotAuth();
                return;
        }

        $row = new mosMembership( $database );
        $row->id = intval( mosGetParam( $_POST, 'id', 0 ) );
        $row->checkin();
        $Itemid = mosGetParam( $_POST, 'Returnid', '' );
        mosRedirect( "index.php?Itemid=$Itemid" );
}

/**
* Saves the record on an edit form submit
* @param database A database connector object
*/
function saveMembership( $option ) {
        global $database, $my;

        if ($my->gid < 1) {
                mosNotAuth();
                return;
        }

        $row = new mosMembership( $database );
        if (!$row->bind( $_POST, "approved published" )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }
        $isNew = $row->id < 1;

        $row->date = date( "Y-m-d H:i:s" );
        if (!$row->check()) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }
        if (!$row->store()) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }
        $row->checkin();

        /** Notify admin's */
        $query = "SELECT email, name"
        . "\n FROM #__users"
        . "\n WHERE usertype = 'superadministrator'"
        . "\n AND sendemail = '1'"
        ;
        $database->setQuery( $query );
        if(!$database->query()) {
                echo $database->stderr( true );
                return;
        }

        $adminRows = $database->loadObjectList();
        foreach( $adminRows as $adminRow) {
                mosSendAdminMail($adminRow->name, $adminRow->email, "", "Weblink", $row->title, $my->username );
        }

        $msg         = $isNew ? _THANK_SUB : '';
        $Itemid = mosGetParam( $_POST, 'Returnid', '' );
        mosRedirect( 'index.php?Itemid='. $Itemid, $msg );
}
?>

