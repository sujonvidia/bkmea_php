<?php
/**
* @version $Id: admin.membership_certificate_bkmea.php,v 1.5 2006/02/02 11:51:54 sami Exp $
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
                editMember_renew( 0, $section );
                break;

        case 'edit':

                editMember_renew( intval( $cid[0] ) );
                break;

        case 'editA':
                editMembership_certificate( intval( $id ) );
                break;

        case 'preview':
                previewMember_renew( intval( $id ) );
                break;

        case 'go2menu':
        case 'go2menuitem':
        case 'menulink':
        case 'save':
        case 'apply':
                saveMember_renew( $id );
                break;

        case 'remove':
                removeMember_renew( $section, $cid );
                break;

        case 'publish':
                publishMember_renew( $id, $cid, 1 );
                break;

        case 'unpublish':
                publishMember_renew( $id, $cid, 0 );
                break;

        case 'cancel':
                cancelMembership_certificate();
                break;

        case 'orderup':
                orderMember_renew( $cid[0], -1 );
                break;

        case 'orderdown':
                orderMember_renew( $cid[0], 1 );
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
                showMembership_certificate( $section, $option );
                break;
}

/**
* Compiles a list of categories for a section
* @param string The name of the category section
*/
function showMembership_certificate( $section, $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;


       $search_type_id = $_POST['search_type_id'];
        $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
        $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
        $search = $database->getEscaped( trim( strtolower( $search ) ) );

        $where = array();

        if ($search_type_id > 0) {
                $where[] = "m.type_id='$search_type_id'";
        }
        if ($search) {
               $where[] = "( LOWER(m.firm_name) LIKE '%$search%' OR LOWER(m.member_reg_no)='$search' ) ";
        }

        // get the total number of records
       /* $database->setQuery( "SELECT count(*) FROM #__member AS m"
                . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
        );*/
        $working_reg_year_id=$_SESSION['working_reg_year_id'];
        if (count($where)==0)
        {
                /*  $database->setQuery( "SELECT count(*) FROM #__member AS m"
                           . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                           . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
                           . "\n left join #__member_reg_year as ry on ry.id=m.last_reg_year_id"
                           . "\n left join #__member_history as mh ON m.id=member_id"

                           . "\n where mh.reg_year_id= (select max(id) from #__member_reg_year)"
                           . "\n and (mh.entry_type='1' or mh.entry_type='2')"
                           . "\n and m.is_delete=0"

                           );*/

                           $database->setQuery( "SELECT count(*) FROM #__member AS m"
                           . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                           . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
                           . "\n left join #__member_reg_year as ry on ry.id=m.last_reg_year_id"
                           . "\n left join #__member_history as mh ON m.id=member_id"

                           . "\n where mh.reg_year_id= $working_reg_year_id"
                           . "\n and (mh.entry_type='1' or mh.entry_type='2')"
                           . "\n and m.is_delete=0"
                           );


        }
        else{
                $database->setQuery( "SELECT count(*) FROM #__member AS m"
                           . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                           . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
                           . "\n left join #__member_reg_year as ry on ry.id=m.last_reg_year_id"
                           . "\n left join #__member_history as mh ON m.id=member_id"
                           . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
                           . "\n and mh.reg_year_id= '$working_reg_year_id'"
                           . "\n and (mh.entry_type='1' or mh.entry_type='2')"
                           . "\n and m.is_delete=0"

                           );
         }

        $total = $database->loadResult();

        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );


        if (count($where)==0)
        {
                $query = "SELECT m.*, m.applicant_title AS title,"
                         . "\n m.applicant_name AS name,"
                         . "\n m.applicant_last_name AS last_name,"
                         . "\n mh.member_reg_no AS member_reg_no,"
                         . "\n mc.name AS member_category,"
                         . "\n u.name AS editor,m.firm_name  AS companyname,"
                         . "\n mt.name as member_type"
                         . "\n FROM #__member AS m"
                         . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                         . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
                         . "\n left join #__member_reg_year as ry on ry.id=m.last_reg_year_id"
                         . "\n left join #__member_history as mh ON m.id=member_id"
                         . "\n left join #__member_category as mc ON mc.id=m.member_category_id"
                         . "\n where mh.reg_year_id= '$working_reg_year_id'"
                         . "\n and (mh.entry_type='1' or mh.entry_type='2')"
                         . "\n and m.is_delete=0"
                         . "\n ORDER BY m.type_id, m.ordering"
                         . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
                         ;
        }
        else
        {
                $query = "SELECT m.*, m.applicant_title AS title,"
                         . "\n m.applicant_name AS name,"
                         . "\n m.applicant_last_name AS last_name,"
                         . "\n mh.member_reg_no AS member_reg_no,"
                         . "\n mc.name AS member_category,"
                         . "\n u.name AS editor,m.firm_name  AS companyname,"
                         . "\n mt.name as member_type"
                         . "\n FROM #__member AS m"
                         . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                         . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
                         . "\n left join #__member_reg_year as ry on ry.id=m.last_reg_year_id"
                         . "\n left join #__member_history as mh ON m.id=member_id"
                         . "\n left join #__member_category as mc ON mc.id=m.member_category_id"
                         . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
                         . "\n and mh.reg_year_id= '$working_reg_year_id'"
                         . "\n and (mh.entry_type='1' or mh.entry_type='2')"
                         . "\n and m.is_delete=0"
                         . "\n ORDER BY m.type_id, m.ordering"
                         . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
                         ;



        }




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
        */
        $lists=array();
        // build list of categories
        $javascript = 'onchange="document.adminForm.submit();"';
         $lists['search_type_id']                   = mosAdminMenus::MemberType( 'search_type_id', $option, intval( $search_type_id ), 1, $javascript);

        Membership_certificate_html::show( $rows, $pageNav, $lists);
}

/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function editMembership_certificate( $uid=0, $section='' ) {
        global $database, $my,$dbconn;

        $type                 = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );
        $working_reg_year_id=$_SESSION['working_reg_year_id'];
        if($uid!=0){



           /*   $sql_query=" select m.id as id,m.is_voter as is_voter,"
             . "\n m.type_id as member_type_id,m.last_reg_year_id as"
             . "\n last_reg_year_id, m.firm_name as firm,m.applicant_name"
             . "\n as aplicant,mt.Name as Type , m.member_reg_no as lastRegNO,"
             . "\n ry.name as yearname, m.applicant_address_street as street,"
             . "\n  m.applicant_address_town_suburb as town,"
             . "\n m.applicant_address_district as district,m.applicant_address_division"
             . "\n as division, m.applicant_address_country as country"
             . "\n FROM #__member AS m Left JOIN #__member_reg_year as ry"
             . "\n on m.last_reg_year_id=ry.id left JOin #__member_type as mt"
             . "\n on mt.id=m.type_id where m.id = '$uid'"
             ;*/

             $sql_query= "select m.id as id,m.is_voter as is_voter,"
             . "\n  m.type_id as member_type_id,mh.reg_year_id as"
             . "\n last_reg_year_id, m.firm_name as firm,m.applicant_title"
             . "\n as title,m.applicant_name as name, m.applicant_last_name as last_name,"
             ."\n mt.Name as Type , mh.member_reg_no as lastRegNO,"
             . "\n ry.name as yearname, m.applicant_address_street as street,"
             . "\n m.applicant_address_town_suburb as town,"
             . "\n m.applicant_address_district as district,m.applicant_address_division"
             . "\n as division, m.applicant_address_country as country"
             . "\n FROM #__member AS m"
             . "\n left join #__member_history as mh on m.id=mh.member_id"
             . "\n Left JOIN #__member_reg_year as ry"
             . "\n on mh.reg_year_id=ry.id left JOin #__member_type as mt"
             . "\n on mt.id=m.type_id where m.id = '$uid' and mh.reg_year_id='$working_reg_year_id'"
             ;




              $sql_query=$database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $row =& $res->fetchRow();


              /*$sql_query= "select count(id) as printed_times from #__member_certificate as"
               . "\n mc where mc.reg_year_id =(select max(id) from #__member_reg_year) and mc.member_id ='$row->id'"
               ;*/

               $sql_query= "select count(id) as printed_times from #__member_certificate as"
               . "\n mc where mc.reg_year_id ='$working_reg_year_id' and mc.member_id ='$row->id'"
               ;
               $sql_query=$database->replaceTablePrefix($sql_query);
               $res =& $dbconn->query($sql_query);
               $printedtimes =& $res->fetchRow();


        }
        else
          $row->id=0;

        //$row = new mosMember_reg_year( $database );
        // load the row from the db table
        //$row->load( $uid );

        // fail if checked out not by 'me'
        if ($row->checked_out && $row->checked_out <> $my->id) {
                mosRedirect( 'index2.php?option=com_membership_certificate_bkmea,The category '. $row->title .' is currently being edited by another administrator' );
        }



        // make order list
        $order = array();
        $database->setQuery( "SELECT COUNT(*) FROM #__membership" );
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
        /*$query = "SELECT ordering AS value, title AS text"
        . "\n FROM #__member_type"
        . "\n ORDER BY ordering"
        ; */

        $query = "SELECT ordering AS value"
        . "\n FROM #__member_type"
        . "\n ORDER BY ordering"
        ;
        $lists['ordering']               = mosAdminMenus::SpecificOrdering( $row, $uid, $query );
        // build for cheking voter
       // $lists['is_voter']              = mosHTML::yesnoRadioList( 'is_voter', 'class="inputbox"', $row->is_voter );

        if ($history->historyid)
            $is_voter=$history->is_voter;
        else
        $is_voter= $row->is_voter;

        $lists['is_voter']              = mosHTML::yesnoRadioList( 'is_voter', 'class="inputbox"', $is_voter );
        // build the html select list for the group access
        $lists['access']                 = mosAdminMenus::Access( $row );
        // build the html radio buttons for published
        $lists['published']              = mosHTML::yesnoRadioList( 'published', 'class="inputbox"', $row->published );
        // build the html select list for menu selection
        $lists['menuselect']             = mosAdminMenus::MenuSelect( );

//        Member_renew_html::edit($cur_reg_year, $renew, $row, $lists, $redirect, $menus );
        Membership_certificate_html::edit($row,  $printedtimes, $lists, $redirect, $menus );
        empty($row);
}

function previewMember_renew( $uid=0, $section='' ) {
        global $database, $my,$dbconn;

        $type                 = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );

         Member_renew_html::previewMember_renew($lists, $redirect, $menus );
}

/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/
function saveMember_renew( $id ) {
        global $database,$dbconn,$option;


        $redirect         = mosGetParam( $_POST, 'redirect', '' );

       /* $row = new mosMember_Type( $database );
        if (!$row->bind( $_POST )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        } */
        // save params

        $cur_reg_year1=$_SESSION['cur_reg_year'];
        $renew1=$_SESSION['renew'];
        $row1=$_SESSION['row'];
        $is_voter=$_SESSION['is_voter'];
        $money_receipt_no=$_SESSION['money_receipt_no'];
        $RenewFee1=$_SESSION['RenewFee'];
        $history=$_SESSION['history'];
        $published=$_POST['published'];
        $description=$_POST['description'];
        $access=$_POST['access'];
        $date = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];
        session_unregister();

        if($history->historyid)
        {
        $sql_query="update mos_member_history set money_receipt_no='$money_receipt_no' ,is_voter='$is_voter', amount='$RenewFee1' where id='$history->historyid'";

        $sql_query1= "update mos_member set last_reg_year_id ='$cur_reg_year1->yearid',last_reg_date='$date' where id ='$row1->id'";

        }

        else
        {
        $sql_query="insert into mos_member_history values('','$row1->id','2','$cur_reg_year1->yearid','$row1->lastRegNO','$is_voter', '$money_receipt_no','$RenewFee1','', '$date','$user_id')";

        $sql_query1= "update mos_member set last_reg_year_id ='$cur_reg_year1->yearid',last_reg_date='$date' where id ='$row1->id'";

        }
        if(!mysql_query($sql_query)) {
            echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
            exit();
        }
        else
          $msg="Successfully";

        //$row->checkin();
        //$row->updateOrder( "id='$id'" );

        mosRedirect( "index2.php?option=com_membership_renew_bkmea&mosmsg=$msg" );
}

/**
* Deletes one or more categories from the categories table
* @param string The name of the category section
* @param array An array of unique category id numbers
*/
function removeMember_renew( $section, $cid ) {
        global $database;

        if (count( $cid ) < 1) {
                echo "<script> alert('Select a category to delete'); window.history.go(-1);</script>\n";
                exit;
        }

        $cids = implode( ',', $cid );
        //check membership table
        $query = "SELECT mt.id, mt.name, COUNT(m.type_id) AS numcat"
        . "\n FROM #__member_type AS mt"
        . "\n LEFT JOIN #__member AS m ON m.type_id=mt.id"
        . "\n WHERE mt.id IN ($cids)"
        . "\n GROUP BY mt.id"
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
        $query = "SELECT mt.id, mt.name, COUNT(mc.member_type_id) AS numcat"
        . "\n FROM #__member_type AS mt"
        . "\n LEFT JOIN #__member_charge AS mc ON mc.member_type_id=mt.id"
        . "\n WHERE mt.id IN ($cids)"
        . "\n GROUP BY mt.id"
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
                $database->setQuery( "DELETE FROM #__member_type WHERE id IN ($cids)" );
                if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                }
        }

        if (count( $err )) {
                $cids = implode( "\', \'", $err );
                $msg = 'Membership Type(s): '. $cids .' cannot be removed as they contain records';
                mosRedirect( 'index2.php?option=com_membership_renew&mosmsg='. $msg );
        }

        mosRedirect( 'index2.php?option=com_membership_renew');
}

/**
* Publishes or Unpublishes one or more categories
* @param string The name of the category section
* @param integer A unique category id (passed from an edit form)
* @param array An array of unique category id numbers
* @param integer 0 if unpublishing, 1 if publishing
* @param string The name of the current user
*/
function publishMember_renew( $categoryid=null, $cid=null, $publish=1 ) {
        global $database, $my;

        if (!is_array( $cid )) {
                $cid = array();
        }
        if ($categoryid) {
                $cid[] = $categoryid;
        }

        if (count( $cid ) < 1) {
                $action = $publish ? 'publish' : 'unpublish';
                echo "<script> alert('Select a member to $action'); window.history.go(-1);</script>\n";
                exit;
        }

        $cids = implode( ',', $cid );

        $query = "UPDATE #__member SET published='$publish'"
        . "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))"
        ;
        $database->setQuery( $query );
        if (!$database->query()) {
                echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                exit();
        }

        //if (count( $cid ) == 1) {
        //        $row = new mosCategory( $database );
        //        $row->checkin( $cid[0] );
        //}

        mosRedirect( 'index2.php?option=com_membership_renew_bkmea');
}

/**
* Cancels an edit operation
* @param string The name of the category section
* @param integer A unique category id
*/
function cancelMembership_certificate() {
        global $database;

        $redirect = mosGetParam( $_POST, 'redirect', '' );

        //$row = new mosRenew( $database );
        //$row->bind( $_POST );
        //$row->checkin();

        mosRedirect( 'index2.php?option=com_membership_certificate_bkmea' );
}

/**
* Moves the order of a record
* @param integer The increment to reorder by
*/
function orderMember_renew( $uid, $inc ) {
        global $database;

        $row = new mosRenew( $database );
        $row->load( $uid );
        $row->move( $inc );
        mosRedirect( 'index2.php?option=com_membership_certificate_bkmea');
}


/**
* changes the access level of a record
* @param integer The increment to reorder by
*/
function accessMenu( $uid, $access, $section ) {
        global $database;

        $row = new mosMember_Category( $database );
        $row->load( $uid );
        $row->access = $access;

        if ( !$row->check() ) {
                return $row->getError();
        }
        if ( !$row->store() ) {
                return $row->getError();
        }

        mosRedirect( 'index2.php?option=com_member_type_bkmea&section='. $section);
}
/*
function menuLink( $id ) {
        global $database;

        //$category = new mosCategory( $database );
        //$category->bind( $_POST );
        //$category->checkin();

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
        mosRedirect( 'index2.php?option=com_member_type&section='. $redirect .'&task=editA&hidemainmenu=1&id='. $id, $msg );
}
  */
function saveOrder( &$cid, $section ) {
        global $database;

        $total                = count( $cid );
        $order                 = mosGetParam( $_POST, 'order', array(0) );
        $row                = new mosMember_Type( $database );
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
        mosRedirect( 'index2.php?option=com_membership_renew_bkmea', $msg );
} // saveOrder

?>
