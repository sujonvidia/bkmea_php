<?php
/**
* @version $Id: admin.hscode_registration.php,v 1.5 2007/03/19 07:10:02 aslam Exp $
* @package Mambo
* @subpackage Users
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
* Author: Morshed Alam
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'class' ) );
require_once( $mainframe->getPath( 'admin_html' ) );

$task        = trim( mosGetParam( $_REQUEST, 'task', null ) );
$cid         = mosGetParam( $_REQUEST, 'cid', array( 0 ) );
$option      = mosGetParam($_REQUEST, 'option', '');

if(!$id){
	$id = $cid[0];
}

switch ($task) {
	case 'new':
		editHsCodeRegistrationUd( 0, $option);
		break;

	case 'edit':
		editHsCodeRegistrationUd( $id, $option );
		break;

	case 'editA':
		editHsCodeRegistrationUd( $id, $option );
		break;

	case 'save':
	case 'apply':
		saveHsCodeRegistrationUd( $option, $task );
		break;
	case 'publish':
		changeHsCodeRegistrationUd( $cid,1, $option );
		break;
	case 'unpublish':
		changeHsCodeRegistrationUd( $cid,0, $option );
		break;
	case 'remove':
		removeHsCodeRegistrationUd( $cid, $option );
		break;

	default:
		showHsCodeRegistrationUd( $option );
		break;
}

//active product list for single select by Morshed
function parentHSCode( $name, $active=NULL, $javascript=NULL, $order='ordering', $size=1, $sel_cat=1 ) {
	global $database;

	$query = "SELECT id AS value, concat(hscode,', ',name) AS text"
	. "\n FROM #__product_line "
	;
	$database->setQuery( $query );
	//$pl = $database->loadObjectList();
	$pl = array();
	if ( $sel_cat ) {
		$pl[] = mosHTML::makeOption( '0', "Root" );
		$pl   = array_merge( $pl, $database->loadObjectList() );
	} else {
		$pl = $database->loadObjectList();
	}
	$pl = mosHTML::selectList($pl, $name, 'class="inputbox" size="'. $size .'" '. $javascript, 'value', 'text', $active );

	return $pl;
}

function showHsCodeRegistrationUd( $option ) {
	global $database, $mainframe, $mosConfig_absolute_path , $mosConfig_list_limit;

	$sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
	$limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
	$limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
	$filter_type        = $mainframe->getUserStateFromRequest( "filter_type{$option}", 'filter_type', 0 );
	$search                 = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
	$search                 = $database->getEscaped( trim( strtolower( $search ) ) );
	$where= Array();

	if (empty($filter_type) && empty($search)){
		$where[]=1;
	}else if ($filter_type=='0' && empty($search)){
		$where[]=1;
	}else if ($filter_type=='0' && !empty($search)){
		$where[] = "m.name LIKE '%$search%' OR m.description LIKE '%$search%'OR m.hscode LIKE '%$search%'";
	}else if ($filter_type=='hscode' && !empty($search)){
		$where[]   = "m.". $filter_type ." LIKE '$search%'";
	}else{
		$where[]   = "m.". $filter_type ." LIKE '%$search%'";
	}

	// get the total number of records
	$query = " SELECT count(*) FROM #__product_line as m"
	."\n where "
	. (count( $where ) ? implode( ' AND ', $where ) : "1")
	."\n and m.hscode <>'0' order by id DESC" ;
	$database->setQuery( $query );
	$total = $database->loadResult();
	require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit );

	//get info source from database;
	$query = " SELECT m.* FROM #__product_line as m"
	."\n where m.hscode <> '0' and "
	. (count( $where ) ? implode( ' AND ', $where ) : "1")
	."\n order by hscode ASC"
	."\n LIMIT $pageNav->limitstart, $pageNav->limit"
	;
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	// get list for dropdown filter
	$types[] = mosHTML::makeOption( '0', '- All -' );
	$types[] = mosHTML::makeOption( 'hscode', 'HS Code' );
	$types[] = mosHTML::makeOption( 'name', 'Commercial Name' );

	$lists['filter_type'] = mosHTML::selectList( $types, 'filter_type', 'class="inputbox" size="1" onchange="javascript: searchValidation()"', 'value', 'text', "$filter_type" );



	HTML_HsCodeRegistrationUd::showHsCodeRegistrationUd( $rows, $pageNav, $search, $option, $lists );
}

function editHsCodeRegistrationUd( $uid='0', $option='port_info_ud' ) {
	global $database, $my, $acl;

	$row = new mosHsCodeRegistrationUd( $database );
	// load the row from the db table
	$row->load( $uid );

	if ( $uid ) {
		$query = "SELECT * FROM #__product_line WHERE id='". $row->id ."'";
		$database->setQuery( $query );
		$contact = $database->loadObjectList();
	}
	$lists['is_service'] = mosHTML::yesnoRadioList('is_service','class="radio" size="1"',$row->is_service);
	$lists['parent_id']  = parentHSCode('parent_id',$row->parent_id);

	HTML_HsCodeRegistrationUd::editHsCodeRegistrationUd( $row,$lists, $option, $uid );
}

function saveHsCodeRegistrationUd( $option, $task ) {
	global $database, $my;
	global $mosConfig_live_site, $mosConfig_mailfrom, $mosConfig_fromname, $mosConfig_sitename;
	$row = new mosHsCodeRegistrationUd( $database );
	if (!$row->bind( $_POST ))
	{
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	$query="select count(*) from #__product_line WHERE hscode='".$_POST['hscode']."' and id!='".$row->id."'";
	$database->setQuery($query);
	if (intval($database->loadResult())>0)
	{
		//echo "<script> alert('This HS Code already exists in this style'); window.history.go(-1); </script>\n";
		mosRedirect( 'index2.php?option='. $option .'&task=view&errmsg=This HS Code already exists in this style' );
		exit();
	}

	if (!$row->store()) {
		echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
		exit();
	}

	switch ( $task ) {
		case 'apply':
			$msg = 'The HS code information has been saved successfully';
			mosRedirect( 'index2.php?option='. $option .'&task=editA&hidemainmenu=1&id='. $row->id, $msg );

		case 'save':
		default:
			$msg = 'The HS code information has been saved successfully';
			mosRedirect( 'index2.php?option='. $option .'&task=view',$msg );
			break;
	}
}

function removeHsCodeRegistrationUd( &$cid, $option ) {
	global $database, $mainframe;
	if ( count( $cid ) ) {
		$obj = new mosHsCodeRegistrationUd( $database );
		foreach ($cid as $id) {
			if (!$obj->delete( $id )) {
				echo "<script> alert('".$obj->getError()."'); window.history.go(-1); </script>\n";
				exit();
			}
		}
	}

	$msg = 'The HS code registration information has been deleted successfully';
	mosRedirect( 'index2.php?option='. $option , $msg );
}

function changeHsCodeRegistrationUd( $cid=null, $publish=1, $option ) {
	global $database, $my;

	if (count( $cid ) < 1) {
		$action = $publish ? 'publish' : 'unpublish';
		echo "<script> alert('Select an item to $action'); window.history.go(-1);</script>\n";
		exit;
	}

	$cids = implode( ',', $cid );

	$query = "UPDATE #__product_line SET is_service='$publish' WHERE id IN ($cids)";
	$database->setQuery( $query );
	if (!$database->query()) {
		echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		exit();
	}

	mosRedirect( 'index2.php?option='. $option );
}
?>
