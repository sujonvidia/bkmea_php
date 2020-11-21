<?php
/**
* @version $Id: admin.member_category_bkmea.php,v 1.3 2006/03/19 05:23:41 morshed Exp $
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
$section         = mosGetParam( $_REQUEST, 'section', 'content' );
$cid                 = mosGetParam( $_REQUEST, 'cid', array(0) );
if (!is_array( $cid )) {
        $cid = array(0);
}
$id = mosGetParam( $_REQUEST, 'id' );

switch ($task) {
        case 'new':
                editMember_Category( 0, $section );
                break;

        case 'edit':
                editMember_Category( intval( $cid[0] ) );
                break;

        case 'editA':
                editMember_Category( intval( $id ) );
                break;

        case 'save':
        case 'apply':
                saveMember_Category( $id );
                break;

        case 'remove':
                removeMember_Category( $section, $cid );
                break;

        case 'publish':
                publishMember_Category( $id, $cid, 1 );
                break;

        case 'unpublish':
                publishMember_Category( $id, $cid, 0 );
                break;

        case 'cancel':
                cancelMember_Category();
                break;

        case 'orderup':
                orderMember_Category( $cid[0], -1 );
                break;

        case 'orderdown':
                orderMember_Category( $cid[0], 1 );
                break;

        case 'saveorder':
                saveOrder( $cid, $section );
                break;

        default:
                showMember_Category( $section, $option );
                break;
}

/**
* Compiles a list of categories for a section
* @param string The name of the category section
*/
function showMember_Category( $section, $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

        $sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );

        $order                         = "\n ORDER BY mc.ordering";


        // get the total number of records
        $query = "SELECT count(*) FROM #__member_category";
        $database->setQuery( $query );
        $total = $database->loadResult();



        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        $query = "SELECT  mc.*, mc.checked_out as checked_out,"
        . "\n mc.id as id, g.name AS groupname, u.name AS editor,"
        . "\n mc.description as description, mc.name as name"
        . "\n FROM #__member_category AS mc,"
        . "\n #__users AS u, #__groups AS g "
        //. "\n where"
        //. "\n u.id = mc.checked_out and "
        //. "\n g.id = mc.access AND mc.published != -2"
        . "\n GROUP BY mc.id"
        . $order
        . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
        ;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return;
        }
        /*
        $count = count( $rows );

        // number of Active Items
        for ( $i = 0; $i < $count; $i++ ) {
                $query = "SELECT COUNT( a.id )"
                . "\n FROM #__content AS a"
                . "\n WHERE a.catid = ". $rows[$i]->id
                . "\n AND a.state <> '-2'"
                ;
                $database->setQuery( $query );
                $active = $database->loadResult();
                $rows[$i]->active = $active;
        }
        // number of Trashed Items
        for ( $i = 0; $i < $count; $i++ ) {
                $query = "SELECT COUNT( a.id )"
                . "\n FROM #__content AS a"
                . "\n WHERE a.catid = ". $rows[$i]->id
                . "\n AND a.state = '-2'"
                ;
                $database->setQuery( $query );
                $trash = $database->loadResult();
                $rows[$i]->trash = $trash;
        }

        // get list of sections for dropdown filter
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['sectionid']                        = mosAdminMenus::SelectSection( 'sectionid', $sectionid, $javascript );
        */
        Member_Category_html::show( $rows, $pageNav);
}

/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function editMember_Category( $uid=0, $section='' ) {
        global $database, $my,$dbconn;

        $type                 = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );
        if($uid!=0){
              $sql_query = "select * from #__member_category where id ='$uid'";
              $sql_query  =  $database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $row =& $res->fetchRow();
        }
        else
          $row->id=0;

        //$row = new mosMember_reg_year( $database );
        // load the row from the db table
        //$row->load( $uid );

        // fail if checked out not by 'me'
        if ($row->checked_out && $row->checked_out <> $my->id) {
                mosRedirect( 'index2.php?option=com_member_category_bkmea,The category '. $row->title .' is currently being edited by another administrator' );
        }


        /*
        // make order list
        $order = array();
        $database->setQuery( "SELECT COUNT(*) FROM #__member_category" );
        $max = intval( $database->loadResult() ) + 1;

        for ($i=1; $i < $max; $i++) {
                $order[] = mosHTML::makeOption( $i );
        }

        // build the html select list for sections
        if ( $section == 'content' ) {
                $query = "SELECT s.id AS value, s.title AS text"
                . "\n FROM #__sections AS s"
                . "\n ORDER BY s.ordering"
                ;
                $database->setQuery( $query );
                $sections = $database->loadObjectList();
                $lists['section'] = mosHTML::selectList( $sections, 'section', 'class="inputbox" size="1"', 'value', 'text' );;
        } else {
                if ( $type == 'other' ) {
                        $section_name = 'N/A';
                } else {
                        $temp = new mosSection( $database );
                        $temp->load( $row->section );
                        $section_name = $temp->name;
                }
                $lists['section'] = '<input type="hidden" name="section" value="'. $row->section .'" />'. $section_name;
        }

        // build the html select list for category types
        $types[] = mosHTML::makeOption( '', 'Select Type' );
        if ($row->section == 'com_contact_details') {
                $types[] = mosHTML::makeOption( 'contact_category_table', 'Contact Category Table' );
        } else
        if ($row->section == 'com_newsfeeds') {
                $types[] = mosHTML::makeOption( 'newsfeed_category_table', 'Newsfeed Category Table' );
        } else
        if ($row->section == 'com_weblinks') {
                $types[] = mosHTML::makeOption( 'weblink_category_table', 'Weblink Category Table' );
        } else {
                $types[] = mosHTML::makeOption( 'content_category', 'Content Category Table' );
                $types[] = mosHTML::makeOption( 'content_blog_category', 'Content Category Blog' );
                $types[] = mosHTML::makeOption( 'content_archive_category', 'Content Category Archive Blog' );
        } // if
        $lists['link_type']                 = mosHTML::selectList( $types, 'link_type', 'class="inputbox" size="1"', 'value', 'text' );;

        // build the html select list for ordering
        $query = "SELECT ordering AS value, title AS text"
        . "\n FROM #__member_category"
        . "\n ORDER BY ordering"
        ;
        $lists['ordering']               = mosAdminMenus::SpecificOrdering( $row, $uid, $query );

        // build the html select list for the group access
        $lists['access']                 = mosAdminMenus::Access( $row );
        // build the html radio buttons for published
        $lists['published']              = mosHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published );
        // build the html select list for menu selection
        $lists['menuselect']             = mosAdminMenus::MenuSelect( );
        */
        Member_Category_html::edit( $row, $lists, $redirect, $menus );
        empty($row);
}

/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/
function saveMember_Category( $id ) {
        global $database,$dbconn,$option;

        //$menu             = mosGetParam( $_POST, 'menu', 'mainmenu' );
        //$menuid           = mosGetParam( $_POST, 'menuid', 0 );
        $redirect         = mosGetParam( $_POST, 'redirect', '' );
        $oldtitle         = mosGetParam( $_POST, 'oldtitle', null );

        $row = new mosMember_Category( $database );
        if (!$row->bind( $_POST )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }
        /*
        // save params
        $params = mosGetParam( $_POST, 'params', '' );
        if (is_array( $params )) {
                $txt = array();
                foreach ( $params as $k=>$v) {
                        $txt[] = "$k=$v";
                }
                $row->params = implode( "\n", $txt );
        }
        */

        $id=$_POST['id'];
        $name=$_POST['name'];
        $published=1;
        $description=$_POST['description'];
        $access=0;
        $date = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];

        if($id==0){
             $sql="select id from #__member_category where name='$name'";
             $sql  =  $database->replaceTablePrefix($sql);
             $res=mysql_query($sql);
             if(mysql_num_rows($res)==0){
                $sql_query="insert into #__member_category values('','$name','$description','$date','$user_id','$published','','','','','$access','','')";
                $sql_query  =  $database->replaceTablePrefix($sql_query);
                if(!mysql_query($sql_query)) {
                   $msg="Failed to Add Member Category, Please Try Again.";
                   mosRedirect( "index2.php?option=com_member_category_bkmea&task=editA&mosmsg=". $msg );
                   //echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                   exit();
                }
             }
             else{
                   $msg="There is a category already with that name, please try again.";
                   mosRedirect( "index2.php?option=com_member_category_bkmea&task=editA&mosmsg=". $msg );
                  //echo "<script> alert('Member Category Already exist\'s'); window.history.go(-1); </script>\n";
                  exit();
             }
             $msg="Member Category Added Successfully";
        }
        else{
             $sql="select id from #__member_category where name='$name' and id!='$id'";
             $sql  =  $database->replaceTablePrefix($sql);
             $res=mysql_query($sql);
             if(mysql_num_rows($res)==0){
                  $sql_query = "update #__member_category set name='$name',date='$date',user_id='$user_id',
                          description='$description',published='$published',access='$access' where id ='$id'";
                  $database->setQuery( $sql_query );
                  if(!$database->query()) {
                      $msg="Failed to Update Member Category, Please Try Again.";
                      mosRedirect( "index2.php?option=com_member_category_bkmea&task=editA&id=$id&mosmsg=". $msg );
                      //echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                      exit();
                  }
             }
             else{
                  //echo "<script> alert('Member Category Already exist\'s'); window.history.go(-1); </script>\n";
                  $msg="There is a category already with that name, please try again.";
                  mosRedirect( "index2.php?option=com_member_category_bkmea&task=editA&id=$id&mosmsg=". $msg );
                  exit();
             }
             $msg="Member Category Updated Successfully";
        }


        $row->checkin();
        //$row->updateOrder( "id='$id'" );
        empty($row);
        mosRedirect( "index2.php?option=com_member_category_bkmea&mosmsg=". $msg );
}

/**
* Deletes one or more categories from the categories table
* @param string The name of the category section
* @param array An array of unique category id numbers
*/
function removeMember_Category( $section, $cid ) {
        global $database;

        if (count( $cid ) < 1) {
                echo "<script> alert('Select a category to delete'); window.history.go(-1);</script>\n";
                exit;
        }
        /*
        $cids = implode( ',', $cid );
        //check membership table
        $query = "SELECT mc.id, mc.name, COUNT(m.type_id) AS numcat"
        . "\n FROM #__member_category AS mc"
        . "\n LEFT JOIN #__membership AS m ON m.type_id=mc.id"
        . "\n WHERE mc.id IN ($cids)"
        . "\n GROUP BY mc.id"
        ;
        $database->setQuery( $query );

        if (!($rows = $database->loadObjectList())) {
                echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        }

        $err = array();
        $cid = array();
        foreach ($rows as $row) {
                if ($row->numcat == 0) {
                        $cid[] = $row->id;
                } else {
                        $err[] = $row->name;
                }
        }

        //check membership charge table
        $query = "SELECT c.id, c.name, COUNT(c.member_type_id) AS numcat"
        . "\n FROM #__member_category AS c"
        . "\n LEFT JOIN #__membership_charge AS mc ON mc.member_type_id=c.id"
        . "\n WHERE c.id IN ($cids)"
        . "\n GROUP BY c.id"
        ;
        $database->setQuery( $query );

        if (!($rows = $database->loadObjectList())) {
                echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
        }

        $err = array();
        $cid = array();
        foreach ($rows as $row) {
                if ($row->numcat == 0) {
                        $cid[] = $row->id;
                } else {
                        $err[] = $row->name;
                }
        }
        */
        if (count( $cid )) {
                $cids = implode( ',', $cid );
                $database->setQuery( "DELETE FROM #__member_category WHERE id IN ($cids)" );
                if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                }
        }
        else
          $msg="Member Category deleted successfully";

        if (count( $err )) {
                $cids = implode( "\', \'", $err );
                $msg = 'Member Category(s): '. $cids .' cannot be removed as they contain records';
                mosRedirect( 'index2.php?option=com_member_category_bkmea&mosmsg='. $msg );
        }
        else
          $msg="Member Category Deleted Successfully";

        mosRedirect( 'index2.php?option=com_member_category_bkmea&mosmsg='. $msg);
}

/**
* Publishes or Unpublishes one or more categories
* @param string The name of the category section
* @param integer A unique category id (passed from an edit form)
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The name of the current user
*/
function publishMember_Category( $categoryid=null, $cid=null, $publish=1 ) {
        global $database, $my;

        if (!is_array( $cid )) {
                $cid = array();
        }
        if ($categoryid) {
                $cid[] = $categoryid;
        }

        if (count( $cid ) < 1) {
                $action = $publish ? 'publish' : 'unpublish';
                echo "<script> alert('Select a category to $action'); window.history.go(-1);</script>\n";
                exit;
        }

        $cids = implode( ',', $cid );

        $query = "UPDATE #__member_category SET published='$publish'"
        . "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
        ;
        $database->setQuery( $query );
        if (!$database->query()) {
                echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                exit();
        }

        if (count( $cid ) == 1) {
                $row = new mosMember_Category( $database );
                $row->checkin( $cid[0] );
        }

        mosRedirect( 'index2.php?option=com_member_category_bkmea');
}

/**
* Cancels an edit operation
* @param string The name of the category section
* @param integer A unique category id
*/
function cancelMember_Category() {
        global $database;

        $redirect = mosGetParam( $_POST, 'redirect', '' );

        $row = new mosMember_Category( $database );
        $row->bind( $_POST );
        $row->checkin();
        mosRedirect( 'index2.php?option=com_member_category_bkmea' );
}

/**
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderMember_Category( $uid, $inc ) {
        global $database;

        $row = new mosMember_Category( $database );
        $row->load( $uid );
        $row->move( $inc );
        mosRedirect( 'index2.php?option=com_member_category_bkmea');
}


function saveOrder( &$cid, $section ) {
        global $database;

        $total                = count( $cid );
        $order                 = mosGetParam( $_POST, 'order', array(0) );
        $row                = new mosMember_Category( $database );
        $conditions = array();

    // update ordering values
        for( $i=0; $i < $total; $i++ ) {
                $row->load( $cid[$i] );
                if ($row->ordering != $order[$i]) {
                        $row->ordering = $order[$i];
                if (!$row->store()) {
                    echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                    exit();
                } // if
                // remember to updateOrder this group
                $condition = "section='$row->section'";
                $found = false;
                foreach ( $conditions as $cond )
                    if ($cond[1]==$condition) {
                        $found = true;
                        break;
                    } // if
                if (!$found) $conditions[] = array($row->id, $condition);
                } // if
        } // for

        // execute updateOrder for each group
        foreach ( $conditions as $cond ) {
                $row->load( $cond[0] );
                $row->updateOrder( $cond[1] );
        } // foreach

        $msg         = 'New ordering saved';
        mosRedirect( 'index2.php?option=com_member_category_bkmea', $msg );
} // saveOrder

?>
