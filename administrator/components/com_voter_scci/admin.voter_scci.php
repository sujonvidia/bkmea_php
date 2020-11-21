<?php
/**
* @version $Id: admin.voter_scci.php,v 1.7 2006/11/05 05:06:10 morshed Exp $
* @package Mambo
* @subpackage Categories
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );
//require_once( $mainframe->getPath( 'class' ) );

$cid = mosGetParam( $_POST, 'cid', array(0) );
$id = mosGetParam( $_REQUEST, 'id','' );

switch ($task) {

        case 'save':
                save_voter( $cid,$option );
                break;

        case 'is_voter_not':
                update_voter( $cid,$option );
                break;

        case 'cancel':
                cancel_voter();
                break;

        default:
                show_voter( $section, $option );
                break;
}

/**
* Compiles the list of firms
* @param string The name of the category section
* @param string The name of the module
*/
function show_voter( $section, $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;
        global $config_voter_election_date,$mosconfig_voter_new_date,$mosconfig_voter_renew_date;

        $last_reg_id=$_SESSION['working_reg_year_id'];
        $search_tin = $_POST['search_tin'];
        $election_date      =mosHTML::ConvertDateForDatatbase($config_voter_election_date);
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
        $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
        $search = $database->getEscaped( trim( strtolower( $search ) ) );

        $where=array();
        if ($search) {
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' || LOWER(m.member_reg_no) LIKE '%$search%' )";
        }
        if ($search_tin) {
                $where[] = "( m.tin = '$search_tin' )";
        }
        //get tin numbers;
        $query = "select distinct tin as tin from #__member";
        $database->setQuery( $query);
        $rows = $database->loadObjectList();
        //prepare result object to result array;
        $temp = array();
        for($i=0;$i<count($rows);$i++){
             $temp[$i]="'".$rows[$i]->tin."'";
        }
        //prepare string from member id array
        $tin = implode(',',$temp );
        $tin = trim($tin)==""?"''":$tin;

         $query = "select count(*) from #__member as m"
                 ."\n left join #__member_history as mh on m.id=mh.member_id "
                 ."\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                 ."\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
                 ."\n JOIN (select tin,count(*) as count1 from #__member as m4"
                 ."\n LEFT JOIN #__member_history as mh1 on m4.id=mh1.member_id"
                 ."\n where m4.is_delete=0 and  mh1.reg_year_id= '$last_reg_id'"
                 ."\n and ((mh1.entry_type=1 and "
                 ."\n mh1.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
                 ."\n || (mh1.entry_type=2 and mh1.reg_date<="
                 ."\n date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))"
                 ."\n and m4.tin in ($tin)"
                 ."\n group by m4.tin) as m3 ON m.tin=m3.tin"
                 ."\n where m3.count1>1 and m.is_delete=0 and  mh.reg_year_id= '$last_reg_id'"
                 //."\n and ((select count(*) from #__member as m1 where m1.tin in m.tin)=1)"
                 . (count( $where ) ? "\n and " . implode( ' AND ', $where ) : "")
                 ."\n and ((mh.entry_type=1 and "
                 ."\n mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
                 ."\n || (mh.entry_type=2 and mh.reg_date<="
                 ."\n date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))"
                 ."\n order by m.tin"
                 ;

        $database->setQuery( $query);
        // get the total number of records
        $total = $database->loadResult();

        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );


         $query = "select distinct(m.id) as id, m.applicant_title as title ,m.firm_name as companyname,"
                 ."\n m.applicant_name AS name,m.applicant_last_name AS last_name,"
                 ."\n mt.name as member_type, mh.is_voter as is_voter, u.name AS editor,"
                 ."\n m.member_reg_no as member_reg_no, m.tin as tin from #__member as m"
                 ."\n left join #__member_history as mh on m.id=mh.member_id "
                 ."\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                 ."\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
                 ."\n JOIN (select tin,count(*) as count1 from #__member as m4"
                 ."\n LEFT JOIN #__member_history as mh1 on m4.id=mh1.member_id"
                 ."\n where m4.is_delete=0 and  mh1.reg_year_id= '$last_reg_id'"
                 ."\n and ((mh1.entry_type=1 and "
                 ."\n mh1.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
                 ."\n || (mh1.entry_type=2 and mh1.reg_date<="
                 ."\n date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))"
                 ."\n and m4.tin in ($tin)"
                 ."\n group by m4.tin) as m3 ON m.tin=m3.tin"
                 ."\n where m3.count1>1 and m.is_delete=0 and  mh.reg_year_id= '$last_reg_id'"
                 //."\n and ((select count(*) from #__member as m1 where m1.tin in m.tin)=1)"
                 . (count( $where ) ? "\n and " . implode( ' AND ', $where ) : "")
                 ."\n and ((mh.entry_type=1 and "
                 ."\n mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
                 ."\n || (mh.entry_type=2 and mh.reg_date<="
                 ."\n date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))"
                 ."\n order by m.tin"
                 . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
                 ;

        //echo $query;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return;
        }

        // build list of type
        //$javascript = 'onchange="document.adminForm.submit();"';
        //$lists['search_tin']= mosAdminMenus::MemberTin( 'search_tin', $search_tin, $javascript);

        voter_html::show( $rows, $pageNav,$lists, $search);
}

/**
* Saves the catefory after the form submit
* @param array The id of firm
*/
function save_voter( $cid,$option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;
        global $config_voter_election_date,$mosconfig_voter_new_date,$mosconfig_voter_renew_date;

        $election_date=mosHTML::ConvertDateForDatatbase($config_voter_election_date);
        $last_reg_id=$_SESSION['working_reg_year_id'];

        if (count( $cid ))
            $cids = implode( ',', $cid );

        $query="select tin as tin, id as id, firm_name as firm from #__member where id IN ($cids)";
        $database->setquery($query);
        $rows=$database->loadObjectList();
        $list_error=array();
        $list_up=array();
        $list_up_firm=array();
        foreach($rows as $row){
                $query="select  count(*) from mos_member as m "
                       ."\n Left Join #__member_history as mh on m.id=mh.member_id"
                       ."\n where m.tin='".$row->tin."' and m.id!='".$row->id."' and mh.is_voter=1"
                       ."\n and ((mh.entry_type=1 and "
                       ."\n mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
                       ."\n || (mh.entry_type=2 and mh.reg_date<="
                       ."\n date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))"
                       ."\n and mh.reg_year_id='".$last_reg_id."'"
                       ;
                $database->setquery($query);
                $total_voter=$database->loadResult();

                if($total_voter>0)
                    array_push($list_error,$row->firm);
                else{
                    $sql="update mos_member_history set is_voter=1 where member_id='".$row->id."' and reg_year_id='".$last_reg_id."'";
                    $database->setQuery($sql);
                    if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                    }
                    else{
                       array_push($list_up_firm,$row->firm);
                    }
                }
        }
        /*
        if(count($list_up)>0){
                $for_voter=implode(',',$list_up);
                $sql="update mos_member_history set is_voter=1 where member_id in ($for_voter) and reg_year_id='".$last_reg_id."'";
                $database->setQuery($sql);
                if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                }
                $msg=stripcslashes("Successfully update, [".$error."]");

        }
        */

        if(count($list_up_firm)>0){
               $for_voter=implode(',',$list_up_firm);
               $msg=stripcslashes("Successfully update, [".$for_voter."]");
        }

        if(count($list_error)>0){
                $error=implode(',',$list_error);
                $msg=stripcslashes("<br>You can not make voter, [".$error."]");
        }

        mosRedirect( "index2.php?option=com_voter_scci&mosmsg=".$msg );
}

/**
* Saves the catefory after the form submit
* @param array The id of firm
*/
function update_voter( $cid,$option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;
        global $config_voter_election_date,$mosconfig_voter_new_date,$mosconfig_voter_renew_date;

        $election_date=mosHTML::ConvertDateForDatatbase($config_voter_election_date);
        $last_reg_id=$_SESSION['working_reg_year_id'];

        if (count( $cid )){
            $cids = implode( ',', $cid );
            $sql="update #__member_history set is_voter=0 where member_id in ($cids) and reg_year_id='".$last_reg_id."'";
            $database->setQuery($sql);
            if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
            }
            $msg=stripcslashes("Successfully updated");

        }

        mosRedirect( "index2.php?option=com_voter_scci&mosmsg=".$msg );
}


/**
* Cancels an operation
*/
function cancel_voter() {
        global $database;

        $redirect = mosGetParam( $_POST, 'redirect', '' );

        /*$row = new mosRenew( $database );
        $row->bind( $_POST );
        $row->checkin();*/
        mosRedirect( 'index2.php?option=com_voter_scci' );
}


?>
