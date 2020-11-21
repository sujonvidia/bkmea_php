<?php
/**
* @version $Id: admin.membership_renew_bkmea.php,v 1.21 2007/01/22 09:16:41 morshed Exp $
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
                editMember_renew( intval( $id ) );
                break;

        case 'preview':
                previewMember_renew( intval( $id ) );
                break;

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
                cancelMember_renew();
                break;

        case 'saveorder':
                saveOrder( $cid, $section );
                break;

        default:
                showMember_renew( $section, $option );
                break;
}

/**
* Compiles a list of categories for a section
* @param string The name of the category section
*/
function showMember_renew( $section, $option ) {
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
         $working_reg_year_id=$_SESSION['working_reg_year_id'];


        // get the total number of records
        /*$database->setQuery( "SELECT count(*) FROM #__member AS m"
                . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
        );*/ //last change on 07-12-2005 sami

        $database->setQuery( "SELECT count(*) FROM #__member AS m"
        . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
        . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
        . "\n left join #__member_reg_year as ry on ry.id=m.last_reg_year_id"
        . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
         . ( count( $where ) ? " and ":" where "  )
        ."\n m.is_delete=0 and m.last_reg_year_id<'$working_reg_year_id'"

        );

        $total = $database->loadResult();

        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );



        $query = "SELECT distinct(m.id),m.*,  m.applicant_title AS title,"
                         . "\n m.applicant_name AS name,"
                         . "\n m.applicant_last_name AS last_name,"
                         . "\n m.member_reg_no AS member_reg_no,"
        . "\n u.name AS editor,m.firm_name  AS companyname,"
        . "\n mt.name as member_type,ry.name as yearname"
        . "\n FROM #__member AS m"
        . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
        . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
        . "\n left join #__member_reg_year as ry on ry.id=m.last_reg_year_id"
        . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
         . ( count( $where ) ? " and ":" where "  )
        ."\n m.is_delete=0 and m.last_reg_year_id<'$working_reg_year_id'"
        //. "\n ORDER BY m.type_id, m.ordering"
        . "\n ORDER BY CAST(m.member_reg_no AS UNSIGNEd) ASC"
        . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
        ;


        /*$query = "SELECT m.*, m.applicant_name AS person,"
        . "\n u.name AS editor,m.firm_name  AS companyname,"
        . "\n mt.name as member_type,ry.name as yearname"
        . "\n FROM #__member AS m"
        . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
        . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
        . "\n left join #__member_reg_year as ry on ry.id=history.reg_year_id"
        . "\n JOIN ( select * from #__member_history join (select mh1.member_id,max(mh1.reg_year_id)"
        . "\n as maxyearid from #__member_history as mh1 where"
        . "\n mh1.reg_year_id<'$working_reg_year_id' group by mh1.member_id) AS tEMP on"
        . "\n temp.member_id=#__member_history.member_id"
        . "\n and #__member_history.reg_year_id = temp.maxyearid ) as history on history.member_id = m.id"
        . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
        ."\n and m.is_delete=0 and m.id not in (select member_id from #__member_history"
        ."\n  where reg_year_id = '$working_reg_year_id' and (entry_type=1 or entry_type=2)) "
        . "\n ORDER BY m.type_id, m.ordering"
        . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
        ; */



        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return;
        }
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['search_type_id']                   = mosAdminMenus::MemberType( 'search_type_id', $option, intval( $search_type_id ), 1, $javascript);

        Member_renew_html::show( $rows, $pageNav, $lists);
}

/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function editMember_renew( $uid=0, $section='' ) {
        global $database, $my,$dbconn;

        $type                 = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );
        $working_reg_year_id=$_SESSION['working_reg_year_id'];

        if($uid!=0){

              $sql_query="select m.id as id,m.is_voter as is_voter ,m.last_reg_date as renew_date ,"
              . "\n m.type_id as member_type_id,m.last_reg_year_id as last_reg_year_id, m.firm_name"
              . "\n as firm,m.applicant_title as title,m.applicant_name as name,m.type_id as type_id,"
              ."\n m.applicant_last_name as last_name,mt.name as Type , m.member_reg_no as lastRegNO,"
              . "\n ry.name as yeartitle FROM #__member AS m Left JOIN #__member_reg_year as"
              . "\n ry on m.last_reg_year_id=ry.id left JOin #__member_type as mt on mt.id=m.type_id"
              . "\n where m.id ='$uid'"
              ;

             /* $sql_query="select m.id as id,m.is_voter as is_voter ,m.last_reg_date as renew_date ,"
              . "\n m.type_id as member_type_id,mh.reg_year_id as last_reg_year_id, m.firm_name"
              . "\n as firm,m.applicant_name as aplicant,mt.name as Type , mh.member_reg_no as lastRegNO,"
              . "\n ry.name as yeartitle FROM #__member AS m Left JOIN #__member_reg_year as"
              . "\n ry on m.last_reg_year_id=ry.id left JOin #__member_type as mt on mt.id=m.type_id"
              . "\n left join #__member_history as mh on mh.member_id=m.id"
              . "\n where m.id ='$uid' and mh.reg_year_id=(select max(reg_year_id) from #__member_history"
              . "\n  where reg_year_id<'$working_reg_year_id' and member_id='$uid')"
              ;*/



              $sql_query=$database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $row =& $res->fetchRow();

              /*$sql_query="select sum( renewal_fee) as renewal_fee from #__member_charge"
              . "\n where member_type_id= '$row->member_type_id' and reg_year_id>'$row->last_reg_year_id'"
              ; */

              $sql_query="select sum( renewal_fee+renew_development_fee+safety_measure_renewal+other_renewal_fee)"
              . "\n as renewal_fee from #__member_charge"
              . "\n where member_type_id= '$row->member_type_id' and reg_year_id>'$row->last_reg_year_id'"
              . "\n and reg_year_id<='$working_reg_year_id'"
              ;
              $sql_query=$database->replaceTablePrefix($sql_query);

              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =&$dbconn->query($sql_query);
              $renew =&$res->fetchRow();

             /* $sql_query="select name as curr_reg_year, id as yearid from #__member_reg_year"
              . "\n where id=(select max(id) from #__member_reg_year)"
              ;*/

              $sql_query="select name as curr_reg_year, id as yearid from #__member_reg_year"
              . "\n where id='$working_reg_year_id'"
              ;

              $sql_query=$database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $cur_reg_year =& $res->fetchRow();

              $sql_query="select id as historyid, is_voter as is_voter , money_receipt_no"
              . "\n as money_receipt_no , amount as renewal_fee from #__member_history"
              . "\n where reg_year_id= '$cur_reg_year->yearid' and member_reg_no='$row->lastRegNO'"
              . "\n and (entry_type='1' or entry_type='2') and member_id='$uid'"
              ;
              $sql_query=$database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $history =& $res->fetchRow();

              $sql_query="select my.name as enrolmentyear from mos_member_history as mh"
                         ."\n left join mos_member_reg_year as my on my.id=mh.reg_year_id"
                         ."\n where mh.member_id='$uid' and mh.entry_type=1"
                         ;
              $sql_query=$database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $enrolmentyear =& $res->fetchRow();


              //get start and end date from member_reg_year table;
              $query=  "select start_date,end_date from #__member_reg_year "
                      ."\n where id='".$_SESSION['working_reg_year_id']."'"
                      ;
              $database->setQuery($query);
              $res=$database->loadObjectList();
              $start_date=mosHTML::ConvertDateDisplayShort($res[0]->start_date);
              $end_date=mosHTML::ConvertDateDisplayShort($res[0]->end_date);   //convert date

        }
        else
          $row->id=0;

        // fail if checked out not by 'me'
        if ($row->checked_out && $row->checked_out <> $my->id) {
                mosRedirect( 'index2.php?option=com_member_renew_bkmea,The category '. $row->title .' is currently being edited by another administrator' );
        }


        if ($history->historyid)
            $is_voter=$history->is_voter;
        else
        $is_voter= $row->is_voter;

        $lists['is_voter']              = mosHTML::yesnoRadioList( 'is_voter', 'class="inputbox"', $is_voter );
        // build the html select list for the group access

        //Member_renew_html::edit($cur_reg_year, $renew, $row, $lists, $redirect, $menus );
        Member_renew_html::edit($history, $cur_reg_year, $renew, $row, $lists, $redirect, $start_date, $end_date,$enrolmentyear );
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

        // Query for check duplicate Money Receipt Number start
         $query="select mt.money_receipt_no from #__member_trail as mt"
                ."\n where mt.money_receipt_no='".$_POST['money_receipt_no']."'"
                ;

        $query  =  $database->replaceTablePrefix($query);
        $result=mysql_query($query) or die(mysql_error());
        if (mysql_num_rows($result)>0){
            $msg = 'Money Receipt No: '. $_POST['money_receipt_no'] .' Already Exists';
            mosRedirect( 'index2.php?option=com_membership_renew_bkmea&mosmsg='. $msg );
        }
        // Query for check duplicate Money Receipt Number end

        $current_date = date( "Y-m-d" );
        $redirect         = mosGetParam( $_POST, 'redirect', '' );
        $money_receipt_no= $_POST['money_receipt_no'];
        $money_receipt_date= mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
        $RenewFee1= $_POST['RenewFee'];
        $is_voter=$_POST['is_voter'];
        $date1=mosHTML::ConvertDateForDatatbase($_POST['renew_date']);
        $type_id=$_POST['type_id'];
        $cur_reg_year1=$_SESSION['cur_reg_year'];
        $renew1=$_SESSION['renew'];
        $row1=$_SESSION['row'];
        $history=$_SESSION['history'];
        $published=$_POST['published'];
        $description=$_POST['description'];
        $access=$_POST['access'];
        $current_invest=intval($_POST['investment']);
        $date = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];
        
        $working_reg_year_id=$_SESSION['working_reg_year_id'];
  

        if($history->historyid)                        
        { 
              $sql_query="update #__member_history set money_receipt_no='$money_receipt_no' ,is_voter='$is_voter', amount='$RenewFee1', "
              ." money_receipt_date='$money_receipt_date', money_receipt_no='$money_receipt_no' where id='$history->historyid'";
              $database->setQuery($sql_query);
              $con1=$database->query();
              $sql_query1= "update #__member set last_reg_year_id ='$working_reg_year_id',last_reg_date='$date1' , date='$date', investment=investment+$current_invest where id ='$row1->id'";
              $database->setQuery($sql_query1);
              $con2=$database->query();
        }

        else
        { 
          $sql_query1= "update #__member set last_reg_year_id ='$working_reg_year_id',last_reg_date='$date1', date='$date', investment=investment+$current_invest, "
          ." money_receipt_date='$money_receipt_date', money_receipt_no='$money_receipt_no' where id ='$row1->id'";
          $database->setQuery($sql_query1);
          
          $con1=$database->query();

           $sql_query="insert into #__member_history values('','$row1->id','2','$working_reg_year_id','$row1->lastRegNO','$is_voter', '$money_receipt_no','$RenewFee1','', '$date','$user_id','$money_receipt_date')";           
           $database->setQuery($sql_query);
           $con2=$database->query();
           $reference_id=$database->insertid();
           if(!$con1 || !$con2){
              echo "<script> alert('Failed to Renew Member'); window.history.go(-1); </script>\n";
              exit();
           }
           else
                  $msg="Member is Renewed Successfully";

           }

        //account transaction start

                      //$reference_id=$database->insertid();
                      //$reference_id=intval($reference_id)==0?intval($history->historyid):0;
                      $sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
                      $database->setQuery($sql_trans);
                      $transaction_no=($database->loadResult()+1);

                      $sql_query_fee="select  renew_development_fee as development_fee, safety_measure_renewal"
                      ."\n as safety_measure_renewal, renewal_fee as renewal_fee, other_renewal_fee as other_renewal_fee "
                      ."\n from #__member_charge where member_type_id= '".$type_id."'"
                      . "\n and reg_year_id='".$cur_reg_year1->yearid."'"
                      ;
                      $database->setQuery($sql_query_fee);
                      $fee =$database->loadObjectList();
                      $renewal_fee=$fee[0]->renewal_fee;
                      $safety_measure_renewal=$fee[0]->safety_measure_renewal;
                      $development_fee=$fee[0]->development_fee;
                      $other_renewal_fee=$fee[0]->other_renewal_fee;

                      $account_query1="insert into #__account_transaction values('','$transaction_no','110','$renewal_fee','0','$reference_id','$money_receipt_date','$current_date')";
                      $account_query1=$database->replaceTablePrefix($account_query1);
                      $account_query2="insert into #__account_transaction values('','$transaction_no','1','$renewal_fee','1','$reference_id','$money_receipt_date','$current_date')";
                      $account_query2=$database->replaceTablePrefix($account_query2);

                      $transaction_no=$transaction_no+1;
                      $account_query3="insert into #__account_transaction values('','$transaction_no','112','$safety_measure_renewal','0','$reference_id','$money_receipt_date','$current_date')";
                      $account_query3=$database->replaceTablePrefix($account_query3);
                      $account_query4="insert into #__account_transaction values('','$transaction_no','1','$safety_measure_renewal','1','$reference_id','$money_receipt_date','$current_date')";
                      $account_query4=$database->replaceTablePrefix($account_query4);

                      $transaction_no=$transaction_no+1;
                      $account_query5="insert into #__account_transaction values('','$transaction_no','113','$development_fee','0','$reference_id','$money_receipt_date','$current_date')";
                      $account_query5=$database->replaceTablePrefix($account_query5);
                      $account_query6="insert into #__account_transaction values('','$transaction_no','1','$development_fee','1','$reference_id','$money_receipt_date','$current_date')";
                      $account_query6=$database->replaceTablePrefix($account_query6);

                      $transaction_no=$transaction_no+1;
                      $account_query7="insert into #__account_transaction values('','$transaction_no','3111','$other_renewal_fee','0','$reference_id','$money_receipt_date','$current_date')";
                      $account_query7=$database->replaceTablePrefix($account_query7);
                      $account_query8="insert into #__account_transaction values('','$transaction_no','1','$other_renewal_fee','1','$reference_id','$money_receipt_date','$current_date')";
                      $account_query8=$database->replaceTablePrefix($account_query8);

                      if(!(mysql_query($account_query1) && mysql_query($account_query2) && mysql_query($account_query3) && mysql_query($account_query4) && mysql_query($account_query5) && mysql_query($account_query6)  && mysql_query($account_query7) && mysql_query($account_query8) ))
                      {
                           echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                           exit();
                       }
                      // account transaction end


        $user_id=$_SESSION['session_username'];

        //if(!$database->addMemberTrail($row1->id,'2',$user_id))
        if(!$database->addMemberTrail($row1->id,'2',$user_id,'','',$money_receipt_no))
        {
        $msg="Incorrect member trail information";

         }

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
                mosRedirect( 'index2.php?option=com_membership_renew_bkmea&mosmsg='. $msg );
        }

        mosRedirect( 'index2.php?option=com_membership_renew_bkmea');
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
function cancelMember_renew() {
        global $database;

        $redirect = mosGetParam( $_POST, 'redirect', '' );

        $row = new mosRenew( $database );
        $row->bind( $_POST );
        $row->checkin();
        mosRedirect( 'index2.php?option=com_membership_renew_bkmea' );
}

function saveOrder( &$cid, $section ) {
        global $database;

        $total                = count( $cid );
        $order                 = mosGetParam( $_POST, 'order', array(0) );
        $row                = new mosRenew( $database );
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
