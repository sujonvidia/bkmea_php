<?php
/**
* @version $Id: admin.membership_renew_ccci.php,v 1.23 2006/12/21 11:53:42 morshed Exp $
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
$cid             = mosGetParam( $_REQUEST, 'cid', array(0) );
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
                saveMember_renew( $id );
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


        $search_type_id     = $_POST['search_type_id'];
        $sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
        $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
        $search = $database->getEscaped( trim( strtolower( $search ) ) );

        $where = array();

        if ($search_type_id > 0) {
                $where[] = "m.type_id='$search_type_id'";
        }
        if ($search && trim($_REQUEST['searchin'])!="") {
                                $where[] = " LOWER(m.".$_REQUEST['searchin'].") LIKE '%$search%' ";
        }

        $working_reg_year_id = $_SESSION['working_reg_year_id'];
        //get maximum registration year id;
        $query = "select max(id) from #__member_reg_year where id<'$working_reg_year_id'";
             $database->setQuery( $query);
             $max_reg_year_id = $database->loadResult();
        //get valid member id for current registration year;
        $query = "select member_id as id from #__member_history where reg_year_id = '$working_reg_year_id'";
             $database->setQuery( $query);
             $rows = $database->loadObjectList();
        //prepare result object to result array;
        $temp = array();
        for($i=0;$i<count($rows);$i++){
             $temp[$i]=$rows[$i]->id;
       }
       //prepare string from member id array
            $members = implode(',',$temp );
            $members = trim($members)==""?"''":$members;
       //count number of outstanding member for current registration year
       $query = "select count(m.id)  FROM #__member AS m, #__member_type AS mt"
              . "\n left join #__member_history as mh on m.id=mh.member_id"
              . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where )." and " : " where ")
              . "\n mh.reg_year_id = '$max_reg_year_id' and "
              . "\n mh.member_id not in ($members) and "
              . "\n (mh.entry_type='1' or mh.entry_type='2') and mt.id = m.type_id "
              ;
        $database->setQuery( $query);
        $total = $database->loadResult();
        //page navigation
        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );
                //query to get outstanding member information from database;
                $query = "select m.id as id, mh.member_reg_no as member_reg_no, m.firm_name AS companyname,"
              . "\n m.applicant_title as a_title, m.applicant_name as a_first_name, "
              . "\n m.applicant_last_name as a_last_name, m.representative_title as r_title, "
              . "\n m.representative_name as r_first_name, m.representative_last_name as r_last_name,"
              . "\n mt.id as type, mt.name as member_type  FROM #__member AS m, #__member_type AS mt"
              . "\n left join #__member_history as mh on m.id=mh.member_id"
              . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where )." and " : " where ")
              . "\n mh.reg_year_id = '$max_reg_year_id' and "
              . "\n mh.member_id not in ($members) and "
              . "\n (mh.entry_type='1' or mh.entry_type='2') and mt.id = m.type_id "
              . "\n ORDER BY mh.member_reg_no, m.type_id "
              . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
              ; //echo $query;
        $database->setQuery( $query);
        //echo $query;
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return;
        }


        /*
      if (count($where)==0)
      {
          $query= "select count(*) FROM mos_member AS m"
          . "\n left join #__member_history as mh on m.id=mh.member_id"
          . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
          . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
          . "\n where mh.reg_year_id = (select max(id) from #__member_reg_year where id<'$working_reg_year_id')"
          . "\n and member_id not in (select member_id from #__member_history"
          . "\n where reg_year_id = '$working_reg_year_id')"
          . "\n and (mh.entry_type='1' or mh.entry_type='2') "
          . "\n ORDER BY mh.member_reg_no, m.type_id"
          ;
      }
      else
      {
          $query= "select count(*) FROM mos_member AS m"
          . "\n left join #__member_history as mh on m.id=mh.member_id"
          . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
          . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
          . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
          . "\n and mh.reg_year_id = (select max(id) from #__member_reg_year where id<'$working_reg_year_id')"
          . "\n and member_id not in (select member_id from #__member_history"
          . "\n where reg_year_id = '$working_reg_year_id')"
          . "\n and (mh.entry_type='1' or mh.entry_type='2') "
          . "\n ORDER BY  mh.member_reg_no, m.type_id"
          ;


      }

      $database->setQuery( $query);

      $total = $database->loadResult();

      require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
      $pageNav = new mosPageNav( $total, $limitstart, $limit );


      if (count($where)==0)
      {    // to get the member information who did not renew the in the current year but renewed in the last year
           $query= "select m.id as id, mh.member_reg_no as member_reg_no, m.firm_name AS companyname,"
           . "\n m.applicant_title as a_title, m.applicant_name as a_first_name, "
           . "\n m.applicant_last_name as a_last_name, m.representative_title as r_title, "
           . "\n m.representative_name as r_first_name, m.representative_last_name as r_last_name, "
           . "\n mt.id as type, mt.name as member_type FROM mos_member AS m"
           . "\n left join #__member_history as mh on m.id=mh.member_id"
           . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
           . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
           . "\n where mh.reg_year_id = (select max(id) from #__member_reg_year where id <'$working_reg_year_id')"
           . "\n and member_id not in (select member_id from #__member_history"
           . "\n where reg_year_id = '$working_reg_year_id')"
           . "\n and (mh.entry_type='1' or mh.entry_type='2') "
           //. "\n ORDER BY  m.member_reg_no, m.type_id"
           . "\n ORDER BY m.firm_name"
           . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
           ;
      }
      else
      {
            $query= "select m.id as id, mh.member_reg_no as member_reg_no, m.firm_name AS companyname,"
             . "\n m.applicant_title as a_title, m.applicant_name as a_first_name, "
             . "\n m.applicant_last_name as a_last_name, m.representative_title as r_title, "
             . "\n m.representative_name as r_first_name, m.representative_last_name as r_last_name,"
             . "\n mt.id as type, mt.name as member_type FROM mos_member AS m"
             . "\n left join #__member_history as mh on m.id=mh.member_id"
             . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
             . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
             . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
             . "\n and mh.reg_year_id = (select max(id) from #__member_reg_year where id <'$working_reg_year_id')"
             . "\n and member_id not in (select member_id from #__member_history"
             . "\n where reg_year_id = '$working_reg_year_id')"
             . "\n and (mh.entry_type='1' or mh.entry_type='2') "
             //. "\n ORDER BY  m.member_reg_no, m.type_id"
             . "\n ORDER BY m.firm_name"
             . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
             ;
                }


        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return;
        }
*/
        // build list of type
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['search_type_id']                   = mosAdminMenus::MemberType( 'search_type_id', $option, intval( $search_type_id ), '', $javascript);

        Member_renew_html::show( $rows, $pageNav,$lists);
}

/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function editMember_renew( $uid=0, $section='' ) {
        global $database, $my,$dbconn;

        $type             = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );
        $working_reg_year_id = $_SESSION['working_reg_year_id'];
        if($uid!=0){
              $sql_query="select m.trade_licence_no, m.id as id,m.is_voter as is_voter ,"
              . "\n m.applicant_title as a_title, m.applicant_name as a_first_name, "
              . "\n m.applicant_last_name as a_last_name, m.representative_title as r_title, "
              . "\n m.representative_name as r_first_name, m.representative_last_name as r_last_name,"
              . "\n m.type_id as member_type_id, m.last_reg_date as renew_date ,m.firm_name as firm,"
              . "\n mt.name as Type, mt.id as type_id , "
              . "\n m.trade_licence_issued_by"
              . "\n FROM #__member AS m, #__member_type as mt "
              . "\n where m.id ='$uid' and mt.id=m.type_id"
              ;
              $sql_query=$database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $row =& $res->fetchRow();

              $query="select max(mh.member_reg_no) as member_reg_no "
                     ."\n from #__member_history as mh"
                     ."\n left join #__member as m on m.id=mh.member_id "
                     ."\n where m.type_id='".$row->member_type_id."' and mh.reg_year_id='".$working_reg_year_id."'"
                     ;
              $database->setQuery($query);
              $last_reg_no=$database->loadResult();

              $sql_query="select name as curr_reg_year, id as yearid"
              . "\n from #__member_reg_year where id='$working_reg_year_id'"
              ;
              $sql_query = $database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res = &$dbconn->query($sql_query);
              $cur_reg_year = &$res->fetchRow();
              $sql_query = "select  renewal_fee as renewal_fee from #__member_charge"
                                       . "\n where member_type_id= '$row->member_type_id'"
                         . "\n and reg_year_id='$cur_reg_year->yearid'"
                         ;
              $sql_query = $database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res   = &$dbconn->query($sql_query);
              $renew = &$res->fetchRow();

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
                mosRedirect( 'index2.php?option=com_Member_renew_ccci,The category '. $row->title .' is currently being edited by another administrator' );
        }



        // make order list
        $order = array();
        $database->setQuery( "SELECT COUNT(*) FROM #__member" );
        $max = intval( $database->loadResult() ) + 1;

        for ($i=1; $i < $max; $i++) {
                $order[] = mosHTML::makeOption( $i );
        }


        $is_voter= $row->is_voter;

        $lists['is_voter']              = mosHTML::yesnoRadioList( 'is_voter', 'class="inputbox"', $is_voter );

        Member_renew_html::edit($cur_reg_year, $renew, $row, $lists, $redirect, $start_date, $end_date, $last_reg_no );
        empty($row);
}
/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/
function saveMember_renew( $id ) {
        global $database,$dbconn,$option;


        $redirect         = mosGetParam( $_POST, 'redirect', '' );

        $money_receipt_no= $_POST['money_receipt_no'];
        $date1=mosHTML::ConvertDateForDatatbase($_POST['renew_date']);
        $money_receipt_date=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
        $RenewFee1= $_POST['RenewFee'];
        $is_voter=$_POST['is_voter'];
        $membership_no=$_POST['membership_no'];
        $cur_reg_year1=$_SESSION['cur_reg_year'];
        $renew1=$_SESSION['renew'];
        $row1=$_SESSION['row'];
        $published=$_POST['published'];
        $description=$_POST['description'];
        $access=$_POST['access'];
        $date = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];
        //session_unregister('session_username');
        //session_unregister('cur_reg_year');
        $trade_licence_no = $_REQUEST['trade_licence_no'];
        $trade_licence_issued_by = $_REQUEST['trade_licence_issued_by'];
        $trade_licence_issue_date = mosHTML::ConvertDateForDatatbase($_POST['trade_licence_issue_date']);
        $trade_licence_expire_date = mosHTML::ConvertDateForDatatbase($_POST['trade_licence_expire_date']);



        $sql_query1="Select mh.member_reg_no as member_reg_no from #__member_history as mh left join"
                  ."\n #__member as m on mh.member_id=m.id where mh.reg_year_id='$cur_reg_year1->yearid' and mh.member_reg_no='$membership_no'"
                  ."\n and m.type_id='$row1->member_type_id' and mh.member_reg_no='".$_POST['membership_no']."'"
                  ;
        $database->setQuery($sql_query1);
        $row=$database->loadObjectList();


         if(intval($membership_no)!=0 && count($row)>0) {
            echo "<script> alert('Given Member Registration No already Exist\'s'); window.history.go(-1); </script>\n";
            exit();
        }
        else
        {
                  // Query for check duplicate Money Receipt Number start
                  $sql_query2="select * from #__member_trail where money_receipt_no ='".$_POST['money_receipt_no']."'";
                  $database->setQuery($sql_query2);
                  $total_row=$database->loadResult();

                  if(count($total_row)>0 ) {
                          //echo "<script> alert('This Money Receipt No is already Exists'); window.history.go(-1); </script>\n";
                          //exit();
                          $msg="Money Receipt No. ".$_POST['money_receipt_no']." Already Exist";
                          mosRedirect( "index2.php?option=com_membership_renew_ccci&mosmsg=$msg" );
                  }
                  // Query for check duplicate Money Receipt Number end

                    $sql_query="insert into #__member_history values('','$row1->id','2','$cur_reg_year1->yearid','$membership_no','$is_voter', '$money_receipt_no','$RenewFee1','', '$date','$user_id','$date1')";
                    $database->setQuery($sql_query);
                    $con1=$database->query();
                    $reference_id=$database->insertid();

                    $sql_query1= "update #__member set last_reg_date='$date1',date='$date',"
                                 ."member_reg_no='$membership_no',money_receipt_no='".$_POST['money_receipt_no']
                                 ."',trade_licence_no='".$trade_licence_no."', trade_licence_issued_by='".$trade_licence_issued_by
                                 ."',trade_licence_issue_date='".$trade_licence_issue_date
                                 ."',trade_licence_expire_date='".$trade_licence_expire_date."' where id ='$row1->id'";
                    $sql_query1=$database->replaceTablePrefix($sql_query1);
                    $con2=mysql_query($sql_query1);


                    // Account Transaction start

                     //get maximum transaction no from database
                     $sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
                     $database->setQuery($sql_trans);
                     $transaction_no=($database->loadResult()+1);

                     //get membership charge
                     /*$sql_query="select  renewal_fee as renewal_fee "
                     ."\n from #__member_charge where member_type_id= '".$_POST['type_id']."'"
                     . "\n and reg_year_id='".$_SESSION['working_reg_year_id']."'"
                     ;
                     $database->setQuery($sql_query);
                     $fee =$database->loadObjectList();
                     $renewal_fee=$fee[0]->renewal_fee; */
                     //prepare transaction query();

                     $date=date("Y-m-d");
                     $account_query1="insert into #__account_transaction values('','$transaction_no','110','$RenewFee1','0','$reference_id','$money_receipt_date','$date')";
                     $account_query1=$database->replaceTablePrefix($account_query1);
                     $account_query2="insert into #__account_transaction values('','$transaction_no','1','$RenewFee1','1','$reference_id','$money_receipt_date','$date')";
                     $account_query2=$database->replaceTablePrefix($account_query2);

                     if(!(mysql_query($account_query1) && mysql_query($account_query2) ) ){
                        $msg="Failed to add accounts transaction";
                        //mosRedirect( "index2.php?option=$option&task=new&id=".$id."&mosmsg=".$msg );
                        mosRedirect( "index2.php?option=com_membership_renew_ccci&mosmsg=$msg" );
                     }
                        // Accounts Transaction end

        }

        if(!$database->addMemberTrail($row1->id,'2',$user_id,'','',$money_receipt_no))
        {
                           $msg="Incorrect member trail information";

        }

        if(!$con1 || !$con2) {
            echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
            exit();
        }
        else
          $msg="Member is Renewed Successfully";

        mosRedirect( "index2.php?option=com_membership_renew_ccci&mosmsg=$msg" );
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
        mosRedirect( 'index2.php?option=com_membership_renew_ccci' );
}


?>
