<?php
/**
* @version $Id: admin.membership_charge_bkmea.php,v 1.7 2006/04/30 10:07:00 morshed Exp $
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

        case 'moveselect':
                moveMembership_chargeSelect( $option, $cid, $section );
                break;

        case 'movesave':
                moveMembership_chargeSave( $cid, $section );
                break;

        case 'copyselect':
                copyMembership_chargeSelect( $option, $cid, $section );
                break;

        case 'copysave':
                copyMembership_chargeSave( $cid, $section );
                break;

        case 'go2menu':
        case 'go2menuitem':
        case 'menulink':
        case 'save':
        case 'apply':
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

        case 'orderup':
                orderMembership_charge( $cid[0], -1 );
                break;

        case 'orderdown':
                orderMembership_charge( $cid[0], 1 );
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


        /*$query = "SELECT  mc.*, mc.checked_out as checked_out, mc.renewal_fee as renewal_fee,"
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
        ; */ //morshed bhai's one

        $query = "SELECT  mc.*, mc.checked_out as checked_out,"
        . "\n (mc.renewal_fee+mc.renew_development_fee+mc.safety_measure_renewal+mc.other_renewal_fee) as renewal_fee,"
        . "\n mc.id as id, g.name AS groupname, u.name AS editor"
        . "\n ,mt.name as member_type_name, mry.name as reg_year_name,"
        . "\n (mc.enrollment_fee+mc.enrollment_development_fee+mc.safety_measure_enrollment+mc.other_enrollment_fee) as enrollment_fee "
        . "\n FROM #__member_charge AS mc "
        . "\n, #__member_reg_year AS mry, #__member_type AS mt "
        . "\n ,#__users AS u, #__groups AS g where mc.reg_year_id='".$_SESSION['working_reg_year_id']."' and "
        . "\n mry.id=mc.reg_year_id and  mt.id=mc.member_type_id and "
        . "\n g.id = mc.access AND mc.published != -2"
        . "\n GROUP BY mc.id"
        . $order
        . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
        ;  //edited by sami becouse of development fee, safety measure worker welfare ,renew fee


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
                mosRedirect( 'index2.php?option=com_membership_charge_bkmea,The Membership charge id '. $row->id .' is currently being edited by another administrator' );
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
        $enrollment_development_fee=$_POST['enrollment_development_fee'];
        $safety_measure_enrollment=$_POST['safety_measure_enrollment'];
        $other_enrollment_fee=$_POST['other_enrollment_fee'];

        $renewal_fee=$_POST['renewal_fee'];
        $safety_measure_renewal=$_POST['safety_measure_renewal'];
        $renew_development_fee=$_POST['renew_development_fee'];
        $other_renewal_fee=$_POST['other_renewal_fee'];



        $access=0;//$_POST['access'];
        $published=1;//$_POST['published'];
        $date = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];

        if($id==0){
             $sql  =  "select id from #__member_charge where member_type_id='$member_type_id' and reg_year_id='$reg_year_id'";
             $sql  =  $database->replaceTablePrefix($sql);
             $res=mysql_query($sql);
             if(mysql_num_rows($res)==0){
                $sql_query="insert into #__member_charge values('','$member_type_id','$reg_year_id','$enrollment_fee','$renewal_fee','$date','$user_id','$published','','','','','$access','','','$enrollment_development_fee','$safety_measure_enrollment','$renew_development_fee','$safety_measure_renewal')";
                $sql_query  =  $database->replaceTablePrefix($sql_query);
                if(!mysql_query($sql_query)) {
                   echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                   exit();
                }
             }
             else{
                  $msg="Membership Charge Already exists";
                  //echo "<script> alert('Member Charge Already exist\'s'); window.history.go(-1); </script>\n";
                  mosRedirect( "index2.php?option=com_membership_charge_bkmea&task=new&mosmsg=".$msg );
                  exit();
             }
             $msg="Membership Charge added successfully";
        }
        else{
            /* $sql  =  "select id from #__member_charge where member_type_id='$member_type_id' and reg_year_id='$reg_year_id' and id!='$id'";
             $sql  =  $database->replaceTablePrefix($sql);
             $res=mysql_query($sql);
             if(mysql_num_rows($res)==0){   */
                  $sql_query = "update #__member_charge set
                          enrollment_fee='$enrollment_fee',renewal_fee='$renewal_fee',published='$published'
                          ,user_id='$user_id',access='$access'
                          ,enrollment_development_fee='$enrollment_development_fee'
                          ,safety_measure_enrollment ='$safety_measure_enrollment'
                          ,renew_development_fee='$renew_development_fee'
                          ,safety_measure_renewal='$safety_measure_renewal'
                          ,other_enrollment_fee='$other_enrollment_fee'
                          ,other_renewal_fee='$other_renewal_fee'
                           where id ='$id'";
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
             $msg="Membership Charge updated successfully";
        }

        $row->checkin();
        //$row->updateOrder( "id='$id'" );

        mosRedirect( "index2.php?option=com_membership_charge_bkmea&mosmsg=".$msg );
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
                        $msg="Membership Charge deleted successfully";
                }
        }

        if (count( $err )) {
                $cids = implode( "\', \'", $err );
                $msg = 'Category(s): '. $cids .' cannot be removed as they contain records';
                mosRedirect( 'index2.php?option=com_membership_charge_bkmea&section='. $section .'&mosmsg='. $msg );
        }

        mosRedirect( "index2.php?option=com_membership_charge_bkmea&mosmsg=".$msg );
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

        mosRedirect( 'index2.php?option=com_membership_charge_bkmea');
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
        mosRedirect( 'index2.php?option=com_membership_charge_bkmea' );
}

/**
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderMembership_charge( $uid, $inc ) {
        global $database;

        $row = new mosMembership_charge( $database );
        $row->load( $uid );
        $row->move( $inc );
        mosRedirect( 'index2.php?option=com_membership_charge_bkmea');
}

/**
* Form for moving item(s) to a specific menu
*/
function moveMembership_chargeSelect( $option, $cid, $sectionOld ) {
        global $database;

        $redirect = mosGetParam( $_POST, 'section', 'content' );;

        if (!is_array( $cid ) || count( $cid ) < 1) {
                echo "<script> alert('Select an item to move'); window.history.go(-1);</script>\n";
                exit;
        }

        ## query to list selected categories
        $cids = implode( ',', $cid );
        $query = "SELECT a.name, a.section FROM #__member_reg_year AS a WHERE a.id IN ( ". $cids ." )";
        $database->setQuery( $query );
        $items = $database->loadObjectList();

        ## query to list items from categories
        $query = "SELECT a.title FROM #__content AS a WHERE a.catid IN ( ". $cids ." ) ORDER BY a.catid, a.title";
        $database->setQuery( $query );
        $contents = $database->loadObjectList();

        ## query to choose section to move to
        $query = "SELECT a.name AS `text`, a.id AS `value` FROM #__sections AS a WHERE a.published = '1' ORDER BY a.name";
        $database->setQuery( $query );
        $sections = $database->loadObjectList();

        // build the html select list
        $SectionList = mosHTML::selectList( $sections, 'sectionmove', 'class="inputbox" size="10"', 'value', 'text', null );

        Membership_charge_html::moveMembership_chargeSelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect );
}


/**
* Save the item(s) to the menu selected
*/
function moveMembership_chargeSave( $cid, $sectionOld ) {
        global $database;

        $sectionMove = mosGetParam( $_REQUEST, 'sectionmove', '' );

        $cids = implode( ',', $cid );
        $total = count( $cid );

        $query =         "UPDATE #__member_charge SET section = '". $sectionMove ."' "
        . "WHERE id IN ( ". $cids ." )"
        ;
        $database->setQuery( $query );
        if ( !$database->query() ) {
                echo "<script> alert('". $database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
                exit();
        }
        $query =         "UPDATE #__content SET sectionid = '". $sectionMove ."' "
        . "WHERE catid IN ( ". $cids ." )"
        ;
        $database->setQuery( $query );
        if ( !$database->query() ) {
                echo "<script> alert('". $database->getErrorMsg() ."'); window.history.go(-1); </script>\n";
                exit();
        }
        $sectionNew = new mosSection ( $database );
        $sectionNew->load( $sectionMove );

        $msg = $total ." Categories moved to ". $sectionNew->name;
        mosRedirect( 'index2.php?option=com_membership_charge_bkmea&mosmsg='. $msg );
}

/**
* Form for copying item(s) to a specific menu
*/
function copyMembership_chargeSelect( $option, $cid, $sectionOld ) {
        global $database;

        $redirect = mosGetParam( $_POST, 'section', 'content' );;

        if (!is_array( $cid ) || count( $cid ) < 1) {
                echo "<script> alert('Select an item to move'); window.history.go(-1);</script>\n";
                exit;
        }

        ## query to list selected categories
        $cids = implode( ',', $cid );
        $query = "SELECT a.name, a.section FROM #__member_charge AS a WHERE a.id IN ( ". $cids ." )";
        $database->setQuery( $query );
        $items = $database->loadObjectList();

        ## query to list items from categories
        $query = "SELECT a.title, a.id FROM #__content AS a WHERE a.catid IN ( ". $cids ." ) ORDER BY a.catid, a.title";
        $database->setQuery( $query );
        $contents = $database->loadObjectList();

        ## query to choose section to move to
        $query = "SELECT a.name AS `text`, a.id AS `value` FROM #__sections AS a WHERE a.published = '1' ORDER BY a.name";
        $database->setQuery( $query );
        $sections = $database->loadObjectList();

        // build the html select list
        $SectionList = mosHTML::selectList( $sections, 'sectionmove', 'class="inputbox" size="10"', 'value', 'text', null );

        Membership_charge_html::copyMembership_chargeSelect( $option, $cid, $SectionList, $items, $sectionOld, $contents, $redirect );
}


/**
* Save the item(s) to the menu selected
*/
function copyMembership_chargeSave( $cid, $sectionOld ) {
        global $database;

        $sectionMove         = mosGetParam( $_REQUEST, 'sectionmove', '' );
        $contentid           = mosGetParam( $_REQUEST, 'item', '' );
        $total               = count( $contentid  );

        $category = new mosCategory ( $database );
        foreach( $cid as $id ) {
                $category->load( $id );
                $category->id = NULL;
                $category->title = "Copy of ".$category->title;
                $category->name = "Copy of ".$category->name;
                $category->section = $sectionMove;
                if (!$category->check()) {
                        echo "<script> alert('".$category->getError()."'); window.history.go(-1); </script>\n";
                        exit();
                }

                if (!$category->store()) {
                        echo "<script> alert('".$category->getError()."'); window.history.go(-1); </script>\n";
                        exit();
                }
                $category->checkin();
                // stores original catid
                $newcatids[]["old"] = $id;
                // pulls new catid
                $newcatids[]["new"] = $category->id;
        }

        $content = new mosContent ( $database );
        foreach( $contentid as $id) {
                $content->load( $id );
                $content->id = NULL;
                $content->sectionid = $sectionMove;
                $content->hits = 0;
                foreach( $newcatids as $newcatid ) {
                        if ( $content->catid == $newcatid["old"] ) {
                                $content->catid = $newcatid["new"];
                        }
                }
                if (!$content->check()) {
                        echo "<script> alert('".$content->getError()."'); window.history.go(-1); </script>\n";
                        exit();
                }

                if (!$content->store()) {
                        echo "<script> alert('".$content->getError()."'); window.history.go(-1); </script>\n";
                        exit();
                }
                $content->checkin();
        }

        $sectionNew = new mosSection ( $database );
        $sectionNew->load( $sectionMove );

        $msg = $total .' Categories copied to '. $sectionNew->name;
        mosRedirect( 'index2.php?option=com_membership_charge_bkmea&mosmsg='. $msg );
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

        mosRedirect( 'index2.php?option=com_membership_charge_bkmea&section='. $section );
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
        mosRedirect( 'index2.php?option=com_membership_charge_bkmea&section='. $redirect .'&task=editA&hidemainmenu=1&id='. $id, $msg );
}

function saveOrder( &$cid, $section ) {
        global $database;

        $total                = count( $cid );
        $order                 = mosGetParam( $_POST, 'order', array(0) );
        $row                = new mosMembership_charge( $database );
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
        mosRedirect( 'index2.php?option=com_membership_charge_bkmea', $msg );
} // saveOrder

?>
