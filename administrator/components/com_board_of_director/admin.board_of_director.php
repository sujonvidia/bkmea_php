<?php
/**
* @version $Id: admin.board_of_director.php,v 1.1 2006/12/28 08:54:00 morshed Exp $
* @package Mambo
* @subpackage Users
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'class' ) );
require_once( $mainframe->getPath( 'admin_html' ) );
$task        = trim( mosGetParam( $_REQUEST, 'task', null ) );
$cid         = mosGetParam( $_REQUEST, 'cid', '' );
$option      = mosGetParam($_REQUEST, 'option', '');
if(!$id)
  $id = $cid[0];

switch ($task) {
        case 'new':
                editBoardOfDirector( 0, $option);
                break;

        case 'edit':
        case 'editA':
                editBoardOfDirector( $id, $option );
                break;

        case 'save':
        case 'apply':
                saveBoardOfDirector( $option, $task );
                break;
        case 'remove':
                removeBoardOfDirector( $cid, $option );
                break;

        case 'select_director': 
                selectBoardOfDirector( $cid, $option );
                break;

        default:
                showBoardOfDirector( $option );
                break;
}

function showBoardOfDirector( $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

        $sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
        $filter_type        = $mainframe->getUserStateFromRequest( "filter_type{$option}", 'filter_type', 0 );
        $search             = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
        $search             = $database->getEscaped( trim( strtolower( $search ) ) );
        $where= Array();

        if (empty($filter_type) && empty($search)){
                $where[]=1;
        }else if ($filter_type=='0' && empty($search)){
                $where[]=1;
        }else if ($filter_type=='0' && !empty($search)){
                $where[] = "(a.member_reg_no LIKE '$search%' OR a.name LIKE '$search%' )";
        }else{
                $where[]   = "a.". $filter_type ." LIKE '$search%'";
        }

        // get the total number of records
        $query = " SELECT count(*) FROM #__v3_board_of_director as a"
        ."\n where "
        . (count( $where ) ? implode( ' AND ', $where ) : "1")
        ;
        $database->setQuery( $query );
        $total = $database->loadResult();
        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        //get info source from database;
        $query = " SELECT a.* FROM #__v3_board_of_director as a"
        ."\n where "
        . (count( $where ) ? implode( ' AND ', $where ) : "1")
        ." order by id ASC" ;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();

        // get list for dropdown filter
        $types[] = mosHTML::makeOption( '0', '- All -' );
        $types[] = mosHTML::makeOption( 'member_reg_no', 'Member Reg. No' );
        $types[] = mosHTML::makeOption( 'name', 'Name' );

        $lists['filter_type'] = mosHTML::selectList( $types, 'filter_type', 'class="inputbox" size="1" onchange="javascript: searchValidation()"', 'value', 'text', "$filter_type" );


        HTML_BoardOfDirector::showBoardOfDirector( $rows, $pageNav, $search, $option,$lists );
}

function editBoardOfDirector( $uid='0', $option) {
        global $database;

        $row = new mosBoardOfDirector( $database );
        // load the row from the db table
        $row->load( $uid );

        if ( $uid ) {
                $query = "SELECT * FROM #__v3_board_of_director WHERE id='". $row->id ."'";
                $database->setQuery( $query );
                $contact = $database->loadObjectList();
        }
        else    // New entry mode
        {
            $row->member_reg_no=trim($_REQUEST['mem_code']);
            $row->member_category_id=intval($_REQUEST['cat']);
        }

        $lists['member_category_id'] = MemberCategory( 'member_category_id', $row->member_category_id, $javascript );
        $lists['is_active'] = yesnoRadioList('is_active','class="radio" size="1" ',($row->is_active==''? 1: $row->is_active));
        HTML_BoardOfDirector::editBoardOfDirector( $row,$lists, $option, $uid );
}

function saveBoardOfDirector( $option, $task ) {
        global $database;
        global $mosConfig_live_site;
        $row = new mosBoardOfDirector( $database );
        if (!$row->bind( $_POST )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }
        if(!$row->check()){
                mosRedirect( 'index2.php?option='. $option,'You must enter email address.' );
                break;
        }

        if(!$row->store()){
                mosRedirect( 'index2.php?option='. $option,'Failed to add director information.' );
                break;
        }
        mosRedirect( 'index2.php?option='. $option,'Director information added successfully.' );
}

function removeBoardOfDirector( &$cid, $option ) { 
        global $database, $mainframe;
        if ( count( $cid ) ) {
                $obj = new mosBoardOfDirector( $database );
                foreach ($cid as $id) {
                        if (!$obj->delete( $id )) {
                                echo "<script> alert('".$obj->getError()."'); window.history.go(-1); </script>\n";
                                exit();
                        }
                }
        }

        $msg = "Board of director information deleted successfully.";
        mosRedirect( 'index2.php?option='. $option , $msg );
}

function selectBoardOfDirector( &$cid, $option ) { 
        global $database, $mainframe; 
        if ( count( $cid ) ) { 
                $selectedId = implode(",",$cid);
                $query = "update #__v3_board_of_director set is_active='1' where id in (".$selectedId.")";
                $database->setQuery($query);
                $database->query(); 

                $query = "update #__v3_board_of_director set is_active='0' where id not in (".$selectedId.")";
                $database->setQuery($query);
                $database->query();
        }

        $msg = "Board of director selected successfully.";
        mosRedirect( 'index2.php?option='. $option , $msg );
}
function yesnoRadioList( $tag_name, $tag_attribs, $selected, $yes=_CMN_YES, $no=_CMN_NO ) {
                $arr = array(
                mosHTML::makeOption( '1', $yes, true ),
                mosHTML::makeOption( '0', $no, true )
                );
                return mosHTML::radioList( $arr, $tag_name, $tag_attribs, $selected );
        }

/**
* Select list of active member Category
* written by: Morshed Alam
*/
function MemberCategory( $name, $active=NULL, $javascript=NULL, $order='ordering', $size=1, $sel_cat=1 ) {
        global $database;

        $query = "SELECT id AS value, name AS text"
        . "\n FROM #__member_category"
        . "\n WHERE"
        . "\n published = '1'"
        . "\n ORDER BY id DESC"
        ;
        $database->setQuery( $query );
        if ( $sel_cat ) {
                $categories[] = mosHTML::makeOption( '0', "Select Member Category" );
                $categories = array_merge( $categories, $database->loadObjectList() );
        } else {
                $categories = $database->loadObjectList();
        }

        $categories = mosHTML::selectList( $categories, $name, 'class="inputbox" size="'. $size .'" '. $javascript, 'value', 'text', $active );

        return $categories;
}
?>

