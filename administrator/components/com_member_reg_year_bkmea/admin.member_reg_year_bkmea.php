<?php
/**
* @version $Id: admin.member_reg_year_bkmea.php,v 1.8 2006/03/19 05:24:32 morshed Exp $
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
                editMember_reg_year( 0, $section );
                break;

        case 'edit':
                editMember_reg_year( intval( $cid[0] ) );
                break;

        case 'editA':
                editMember_reg_year( intval( $id ) );
                break;

        case 'save':
        case 'apply':
                saveMember_reg_year( $id );
                break;

        case 'remove':
                removeMember_reg_year( $section, $cid );
                break;

        case 'publish':
                publishMember_reg_year( $id, $cid, 1 );
                break;

        case 'unpublish':
                publishMember_reg_year( $id, $cid, 0 );
                break;

        case 'cancel':
                cancelMember_reg_year();
                break;

        case 'orderup':
                orderMember_reg_year( $cid[0], -1 );
                break;

        case 'orderdown':
                orderMember_reg_year( $cid[0], 1 );
                break;

        case 'accesspublic':
                accessMenu( $cid[0], 0, $section );
                break;

        case 'accessregistered':
                accessMenu( $cid[0], 1, $section );
                break;

        case 'accessspecial':
                accessMenu( $cid[0], 2, $section );
                break;

        case 'saveorder':
                saveOrder( $cid, $section );
                break;

        default:
                showMember_reg_year( $section, $option );
                break;
}

/**
* Compiles a list of categories for a section
* @param string The name of the category section
*/
function showMember_reg_year( $section, $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

        //$sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );

        //$order                         = "\n ORDER BY mry.ordering";
        $order                         = "\n ORDER BY mry.id DESC";

        // get the total number of records
        $query = "SELECT count(*) FROM #__member_reg_year";
        $database->setQuery( $query );
        $total = $database->loadResult();



        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        $query = "SELECT  mry.checked_out as checked_out,"
        . "\n mry.id as id, g.name AS groupname, u.name AS editor,"
        . "\n mry.name as name, mry.start_date as start_date, mry.end_date as end_date"
        . "\n FROM #__member_reg_year AS mry,"
        . "\n #__users AS u, #__groups AS g"
        //. "\n where"
        //. "\n u.id = mry.checked_out and "
        //. "\n g.id = mry.access AND mry.published != -2"
        . "\n GROUP BY mry.id"
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
        Member_reg_year_html::show( $rows, $pageNav);
}

/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function editMember_reg_year( $uid=0, $section='' ) {
        global $database, $my,$dbconn, $mosHtmlObj;

        $type                 = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );
        if($uid!=0){
              $sql_query = "select * from #__member_reg_year where id ='$uid'";
              $sql_query = $database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $row =& $res->fetchRow();

              $sql_query = "select DATE_ADD(end_date, INTERVAL 1 DAY) as end_date from #__member_reg_year where id = "
                          ."\n (select max(id) from #__member_reg_year where id < '$uid' )";
              $database->setQuery($sql_query);
              $prev_end_date=$database->loadResult();
              $prev_end_date=$mosHtmlObj->ConvertDateDisplayShort($prev_end_date);
        }
        else{
               $row->id=0;
               $sql_query = "select DATE_ADD(end_date, INTERVAL 1 DAY) as end_date from #__member_reg_year where id = "
                           ."\n (select max(id) from #__member_reg_year)";
               $database->setQuery($sql_query);
               $prev_end_date=$database->loadResult();
               $prev_end_date=$mosHtmlObj->ConvertDateDisplayShort($prev_end_date);
        }

        //$row = new mosMember_reg_year( $database );
        // load the row from the db table
        //$row->load( $uid );

        // fail if checked out not by 'me'
        if ($row->checked_out && $row->checked_out <> $my->id) {
                mosRedirect( 'index2.php?option=com_member_reg_year_bkmea,The category '. $row->title .' is currently being edited by another administrator' );
        }


        /*
        // make order list
        $order = array();
        $database->setQuery( "SELECT COUNT(*) FROM #__member_reg_year" );
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
        . "\n FROM #__member_reg_year"
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
        Member_reg_year_html::edit( $row, $lists, $redirect, $menus, $prev_end_date );
        empty($row);
}

/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/
function saveMember_reg_year( $id ) {
        global $database,$dbconn,$option;

        //$menu             = mosGetParam( $_POST, 'menu', 'mainmenu' );
        //$menuid           = mosGetParam( $_POST, 'menuid', 0 );
        $redirect         = mosGetParam( $_POST, 'redirect', '' );
        $oldtitle         = mosGetParam( $_POST, 'oldtitle', null );
        /*
        $row = new mosMember_reg_year( $database );
        if (!$row->bind( $_POST )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }

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
        $start_date=$_POST['start_date'];
        $start_date=mosHTML::ConvertDateForDatatbase($start_date);
        $end_date=$_POST['end_date'];
        $end_date  =mosHTML::ConvertDateForDatatbase($end_date);
        $published=1;//$_POST['published'];
        $description=$_POST['description'];
        $access=0;//$_POST['access'];
        $curr_date = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];

        //if $id=0 then new data will be inserted else data will be updated
        if($id==0){
             $sql  =  "select id from #__member_reg_year where name='$name' and start_date='$start_date' and end_date='$end_date'";
             $sql  =  $database->replaceTablePrefix($sql);
             $res=mysql_query($sql);
             if(mysql_num_rows($res)==0){
                         $sql_query="insert into #__member_reg_year values('','$name','$start_date','$end_date','$description','$curr_date','$user_id','$published','','','','','$access','','')";
                         $sql_query  =  $database->replaceTablePrefix($sql_query);
                         if(!mysql_query($sql_query)) {
                            $msg="Failed to add member registration year, please try again.";
                            mosRedirect( "index2.php?option=com_member_reg_year_bkmea&task=new&mosmsg=".$msg );
                            //echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                            exit();
                         }
                         else{
                               $insert_id = mysql_insert_id($dbconn->connection);
                               $query= " select max(reg_year_id) from"
                                                      ."\n #__member_charge where reg_year_id<$insert_id";

                               $database->setQuery( $query );
                               $max_id = $database->loadResult();
                               if($max_id!=NULL){
                                     $query2="select * from #__member_charge where reg_year_id='$max_id'";
                                     $database->setQuery( $query2 );
                                     $charge_rows = $database->loadObjectList();

                               }

                               $query1="select * from #__member_type";
                               $database->setQuery( $query1 );
                               $rows1 = $database->loadObjectList();
                               for($i=0; $i<count($rows1); $i++){
                                   $ro = &$rows1[$i];
                                   $type_id=$ro->id;
                                   $enrollment_fee=0;
                                   $renewal_fee=0;
                                   $enrollment_development_fee=0;
                                   $safety_measure_enrollment=0;
                                   $renew_development_fee=0;
                                   $safety_measure_renewal=0;
                                   $other_enrollment_fee=0;
                                   $other_renewal_fee=0;
                                   //check member charge available or not
                                   for($j=0; $j<count($charge_rows); $j++){
                                        $charge_row=&$charge_rows[$j];
                                        if($charge_row->member_type_id==$type_id ){
                                                $enrollment_fee =$charge_row->enrollment_fee;
                                                $renewal_fee   =$charge_row->renewal_fee;
                                                $enrollment_development_fee=$charge_row->enrollment_development_fee;
                                                $safety_measure_enrollment= $charge_row->safety_measure_enrollment;
                                                $renew_development_fee=$charge_row->renew_development_fee;
                                                $safety_measure_renewal=$charge_row->safety_measure_renewal;
                                                $other_enrollment_fee=$charge_row->other_enrollment_fee;
                                                $other_renewal_fee=$charge_row->other_renewal_fee;
                                                break;
                                        }
                                   }

                                   $insert_query  = "insert into #__member_charge values('','$type_id', "
                                                    ." '".$insert_id."',$enrollment_fee,$renewal_fee,'$curr_date','$user_id',"
                                                    ." '$published','','','','','$access','','','$enrollment_development_fee',"
                                                    ." '$safety_measure_enrollment','$renew_development_fee',"
                                                    ." '$safety_measure_renewal','$other_enrollment_fee','$other_renewal_fee')";

                                   $insert_query    =  $database->replaceTablePrefix($insert_query);
                                   mysql_query($insert_query);
                               }
                         }
             }
             else{
                  //echo "<script> alert('Registration Year Already exist\'s'); window.history.go(-1); </script>\n";
                  $msg="Registration year already with that name, please try again." ;
                  mosRedirect( "index2.php?option=com_member_reg_year_bkmea&task=new&mosmsg=".$msg );
                  exit();
             }
             $msg="Registration year of members added successfully with necessary charge setup";
        }
        else{
             $sql  = "select id from #__member_reg_year where name='$name' and start_date='$start_date' and end_date='$end_date' and id!='$id'";
             $sql  =  $database->replaceTablePrefix($sql);
             $res=mysql_query($sql);
             if(mysql_num_rows($res)==0){
                  $sql_query = "update #__member_reg_year set name='$name',date='$curr_date',
                      start_date='$start_date',end_date='$end_date',description='$description'
                      ,published='$published',access='$access',user_id='$user_id' where id ='$id'";
                  $database->setQuery( $sql_query );
                  if(!$database->query()) {
                      $msg="Failed to update member registration year, please try again.";
                      mosRedirect( "index2.php?option=com_member_reg_year_bkmea&task=editA&id=$id&mosmsg=".$msg );
                      //echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                      exit();
                  }
             }
             else{
                  $msg="Registration year already with that name, please try again.";
                  mosRedirect( "index2.php?option=com_member_reg_year_bkmea&task=editA&id=$id&mosmsg=".$msg );
                  //echo "<script> alert('Registration Year Already exist\'s'); window.history.go(-1); </script>\n";
                  exit();
             }
             $msg="Registration year of members updated successfully";
        }

        //$row->checkin();
        //$row->updateOrder( "id='$id'" );

        mosRedirect( "index2.php?option=com_member_reg_year_bkmea&mosmsg=".$msg );
}

/**
* Deletes one or more categories from the categories table
* @param string The name of the category section
* @param array An array of unique category id numbers
*/
function removeMember_reg_year( $section, $cid ) {
        global $database;

        if (count( $cid ) < 1) {
                echo "<script> alert('Select a category to delete'); window.history.go(-1);</script>\n";
                exit;
        }
        $cids = implode( ',', $cid );
        //check member table
        $query = "SELECT mry.id as id, mry.name as name, COUNT(mc.reg_year_id) AS numcat"
        . "\n FROM #__member_reg_year AS mry "
        . "\n LEFT JOIN #__member_charge AS mc ON mc.reg_year_id=mry.id "
        . "\n WHERE mry.id IN ($cids)"
        . "\n GROUP BY mry.id"
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

        if (count( $cid )) {
                $cids = implode( ',', $cid );
                $database->setQuery( "DELETE FROM #__member_reg_year WHERE id IN ($cids)" );
                if (!$database->query()) {
                     echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                }else
                    $msg="Registration year of members deleted successfully";
        }



        if (count( $err )) {
                $cids = implode( "\', \'", $err );
                $msg = 'Member Registration Year(s): '. $cids .' cannot be removed as they contain Charge List or Member Profile records';
                mosRedirect( 'index2.php?option=com_member_reg_year_bkmea&mosmsg='. $msg );
        }

        mosRedirect( 'index2.php?option=com_member_reg_year_bkmea&mosmsg='.$msg);
}

/**
* Publishes or Unpublishes one or more categories
* @param string The name of the category section
* @param integer A unique category id (passed from an edit form)
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The name of the current user
*/
function publishMember_reg_year( $categoryid=null, $cid=null, $publish=1 ) {
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

        $query = "UPDATE #__member_reg_year SET published='$publish'"
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

        mosRedirect( 'index2.php?option=com_member_reg_year_bkmea');
}

/**
* Cancels an edit operation
* @param string The name of the category section
* @param integer A unique category id
*/
function cancelMember_reg_year() {
        global $database;

        $redirect = mosGetParam( $_POST, 'redirect', '' );

        //$row = new mosCategory( $database );
        //$row->bind( $_POST );
        //$row->checkin();
        mosRedirect( 'index2.php?option=com_member_reg_year_bkmea' );
}

/**
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderMember_reg_year( $uid, $inc ) {
        global $database;

        $row = new mosMember_reg_year( $database );
        $row->load( $uid );
        $row->move( $inc );
        mosRedirect( 'index2.php?option=com_member_reg_year_bkmea');
}


/**
* changes the access level of a record
* @param integer The increment to reorder by
*/
function accessMenu( $uid, $access, $section ) {
        global $database;

        $row = new mosCategory( $database );
        $row->load( $uid );
        $row->access = $access;

        if ( !$row->check() ) {
                return $row->getError();
        }
        if ( !$row->store() ) {
                return $row->getError();
        }

        mosRedirect( 'index2.php?option=com_member_reg_year_bkmea&section='. $section );
}

function menuLink( $id ) {
        global $database;

        $category = new mosCategory( $database );
        $category->bind( $_POST );
        $category->checkin();

        $redirect        = mosGetParam( $_POST, 'redirect', '' );
        $menu                 = mosGetParam( $_POST, 'menuselect', '' );
        $name                 = mosGetParam( $_POST, 'link_name', '' );
        $sectionid        = mosGetParam( $_POST, 'sectionid', '' );
        $type                 = mosGetParam( $_POST, 'link_type', '' );

        switch ( $type ) {
                case 'content_category':
                        $link                 = 'index.php?option=com_content&task=category&sectionid='. $sectionid .'&id='. $id;
                        $menutype        = 'Content Category Table';
                        break;

                case 'content_blog_category':
                        $link                 = 'index.php?option=com_content&task=blogcategory&id='. $id;
                        $menutype        = 'Content Category Blog';
                        break;

                case 'content_archive_category':
                        $link                 = 'index.php?option=com_content&task=archivecategory&id='. $id;
                        $menutype        = 'Content Category Blog Archive';
                        break;

                case 'contact_category_table':
                        $link                 = 'index.php?option=com_contact&catid='. $id;
                        $menutype        = 'Contact Category Table';
                        break;

                case 'newsfeed_category_table':
                        $link                 = 'index.php?option=com_newsfeeds&catid='. $id;
                        $menutype        = 'Newsfeed Category Table';
                        break;

                case 'weblink_category_table':
                        $link                 = 'index.php?option=com_weblinks&catid='. $id;
                        $menutype        = 'Weblink Category Table';
                        break;

                default:;
        }

        $row                                 = new mosMenu( $database );
        $row->menutype                 = $menu;
        $row->name                         = $name;
        $row->type                         = $type;
        $row->published                = 1;
        $row->componentid        = $id;
        $row->link                        = $link;
        $row->ordering                = 9999;

        if (!$row->check()) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }
        if (!$row->store()) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }
        $row->checkin();
        $row->updateOrder( "menutype='". $menu ."'" );

        $msg = $name .' ( '. $menutype .' ) in menu: '. $menu .' successfully created';
        mosRedirect( 'index2.php?option=com_member_reg_year_bkmea&section='. $redirect .'&task=editA&hidemainmenu=1&id='. $id, $msg );
}

function saveOrder( &$cid, $section ) {
        global $database;

        $total                = count( $cid );
        $order                 = mosGetParam( $_POST, 'order', array(0) );
        $row                = new mosMember_reg_year( $database );
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
        mosRedirect( 'index2.php?option=com_member_reg_year_bkmea', $msg );
} // saveOrder

?>
