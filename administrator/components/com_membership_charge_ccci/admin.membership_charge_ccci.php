<?php
/**
* @version $Id: admin.membership_charge_ccci.php,v 1.2 2005/12/08 05:21:56 morshed Exp $
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
                editMembership_charge( 0, $section );
                break;

        case 'edit':
                editMembership_charge( intval( $cid[0] ) );
                break;

        case 'editA':
                editMembership_charge( intval( $id ) );
                break;

        case 'save':
                saveMembership_charge( $id );
                break;

        case 'remove':
                removeMembership_charge( $section, $cid );
                break;

        case 'publish':
                publishMembership_charge( $id, $cid, 1 );
                break;

        case 'unpublish':
                publishMembership_charge( $id, $cid, 0 );
                break;

        case 'cancel':
                cancelMembership_charge();
                break;

        default:
                showMembership_charge( $section, $option );
                break;
}

/**
* Compiles a list of categories for a section
* @param string The name of the category section
*/
function showMembership_charge( $section, $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

        //$sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );

        //$order                         = "\n ORDER BY mc.ordering";
        $order                         = "\n ORDER BY mc.id DESC";

        // get the total number of records
        $query = "SELECT count(*) FROM #__member_charge where reg_year_id='".$_SESSION['working_reg_year_id']."' ";
        $database->setQuery( $query );
        $total = $database->loadResult();



        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );


        $query = "SELECT  mc.*, mc.checked_out as checked_out, mc.renewal_fee as renewal_fee,"
        . "\n mc.id as id, g.name AS groupname, u.name AS editor"
        . "\n ,mt.name as member_type_name, mry.name as reg_year_name, mc.enrollment_fee as enrollment_fee "
        . "\n FROM #__member_charge AS mc "
        . "\n, #__member_reg_year AS mry, #__member_type AS mt "
        . "\n ,#__users AS u, #__groups AS g where mc.reg_year_id='".$_SESSION['working_reg_year_id']."' and "
        . "\n mry.id=mc.reg_year_id and  mt.id=mc.member_type_id and "
        . "\n g.id = mc.access AND mc.published != -2"
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

        $count = count( $rows );

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

        Membership_charge_html::show( $rows, $pageNav);
}

/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function editMembership_charge( $uid=0, $section='' ) {
        global $database, $my,$dbconn;

        $type                 = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );
        if($uid!=0){
              $sql_query = "select * from #__member_charge where id ='$uid'";
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
                mosRedirect( 'index2.php?option=com_membership_charge_ccci,The Membership charge id '. $row->id .' is currently being edited by another administrator' );
        }
        /*
        // make order list
        $order = array();

        // build the html select list for ordering
        $query = "SELECT ordering AS value, enrollment_fee AS text, renewal_fee AS text1"
        . "\n FROM #__membership_charge"
        . "\n ORDER BY ordering"
        ;
        $lists['ordering']               = mosAdminMenus::SpecificOrdering( $row, $uid, $query );
        */
        // build list of categories
        $lists['member_reg_id']             = mosAdminMenus::RegYear( 'member_reg_id',  intval( $row->reg_year_id ), 'disabled' );
        // build list of categories
        $lists['type_id']                   = mosAdminMenus::MemberType( 'type_id', $option, intval( $row->member_type_id ),'','disabled' );

        // build the html select list for the group access
        //$lists['access']                 = mosAdminMenus::Access( $row );
        // build the html radio buttons for published
        //$lists['published']              = mosHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published );
        // build the html select list for menu selection
        //$lists['menuselect']             = mosAdminMenus::MenuSelect( );

        Membership_charge_html::edit( $row, $lists, $redirect, $menus );
        empty($row);
}

/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/
function saveMembership_charge( $id ) {
        global $database,$dbconn,$option;

        //$menu             = mosGetParam( $_POST, 'menu', 'mainmenu' );
        //$menuid           = mosGetParam( $_POST, 'menuid', 0 );
        $redirect         = mosGetParam( $_POST, 'redirect', '' );
        $oldtitle         = mosGetParam( $_POST, 'oldtitle', null );

        $row = new mosMembership_charge( $database );
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
        $member_type_id=$_POST['type_id'];
        $reg_year_id=$_POST['member_reg_id'];
        $enrollment_fee=$_POST['enrollment_fee'];
        $renewal_fee=$_POST['renewal_fee'];
        $access=0;//$_POST['access'];
        $published=1;//$_POST['published'];
        $date = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];

        if($id==0){
             $sql  =  "select id from #__member_charge where member_type_id='$member_type_id' and reg_year_id='$reg_year_id'";
             $sql  =  $database->replaceTablePrefix($sql);
             $res=mysql_query($sql);
             if(mysql_num_rows($res)==0){
                $sql_query="insert into #__member_charge values('','$member_type_id','$reg_year_id','$enrollment_fee','$renewal_fee','$date','$user_id','$published','','','','','$access','','')";
                $sql_query  =  $database->replaceTablePrefix($sql_query);
                if(!mysql_query($sql_query)) {
                   echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                   exit();
                }
             }
             else{
                  $msg="Member Charge Already exists";
                  //echo "<script> alert('Member Charge Already exist\'s'); window.history.go(-1); </script>\n";
                  mosRedirect( "index2.php?option=com_membership_charge_ccci&task=new&mosmsg=".$msg );
                  exit();
             }
             $msg="Member Charge added successfully";
        }
        else{
            /* $sql  =  "select id from #__member_charge where member_type_id='$member_type_id' and reg_year_id='$reg_year_id' and id!='$id'";
             $sql  =  $database->replaceTablePrefix($sql);
             $res=mysql_query($sql);
             if(mysql_num_rows($res)==0){   */
                  $sql_query = "update #__member_charge set
                          enrollment_fee='$enrollment_fee',renewal_fee='$renewal_fee',published='$published'
                          ,user_id='$user_id',access='$access' where id ='$id'";
                  $database->setQuery( $sql_query );
                  if(!$database->query()) {
                      echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                      exit();
                  }
            /* }
             else{
                  $msg="Registration Year Already exists";
                  mosRedirect( "index2.php?option=com_member_reg_year&task=editA&id=$id&mosmsg=".$msg );
                  //echo "<script> alert('Registration Year Already exist\'s'); window.history.go(-1); </script>\n";
                  exit();
             }*/
             $msg="Member Charge Updated Successfully";
        }

        $row->checkin();
        //$row->updateOrder( "id='$id'" );

        mosRedirect( "index2.php?option=com_membership_charge_ccci&mosmsg=".$msg );
}

/**
* Deletes one or more categories from the categories table
* @param string The name of the category section
* @param array An array of unique category id numbers
*/
function removeMembership_charge( $section, $cid ) {
        global $database;

        if (count( $cid ) < 1) {
                echo "<script> alert('Select a category to delete'); window.history.go(-1);</script>\n";
                exit;
        }

        if (count( $cid )) {
                $cids = implode( ',', $cid );
                $database->setQuery( "DELETE FROM #__member_charge WHERE id IN ($cids)" );
                if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                }else{
                        $msg="Member Charge deleted successfully";
                }
        }

        if (count( $err )) {
                $cids = implode( "\', \'", $err );
                $msg = 'Category(s): '. $cids .' cannot be removed as they contain records';
                mosRedirect( 'index2.php?option=com_membership_charge_ccci&section='. $section .'&mosmsg='. $msg );
        }

        mosRedirect( "index2.php?option=com_membership_charge_ccci&mosmsg=".$msg );
}

/**
* Publishes or Unpublishes one or more categories
* @param string The name of the category section
* @param integer A unique category id (passed from an edit form)
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The name of the current user
*/
function publishMembership_charge( $categoryid=null, $cid=null, $publish=1 ) {
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

        $query = "UPDATE #__member_charge SET published='$publish'"
        . "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
        ;
        $database->setQuery( $query );
        if (!$database->query()) {
                echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                exit();
        }

        if (count( $cid ) == 1) {
                $row = new mosCategory( $database );
                $row->checkin( $cid[0] );
        }

        mosRedirect( 'index2.php?option=com_membership_charge_ccci');
}

/**
* Cancels an edit operation
* @param string The name of the category section
* @param integer A unique category id
*/
function cancelMembership_charge() {
        global $database;

        $redirect = mosGetParam( $_POST, 'redirect', '' );

        $row = new mosCategory( $database );
        $row->bind( $_POST );
        $row->checkin();
        mosRedirect( 'index2.php?option=com_membership_charge_ccci' );
}

?>
