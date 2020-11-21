<?php
/**
* @version $Id: admin.membership_renew_scci.php,v 1.27 2006/07/16 07:20:35 morshed Exp $
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
$cid                 = mosGetParam( $_REQUEST, 'cid', array(0) );
$id                 = mosGetParam( $_REQUEST, 'id' );
if (!is_array( $cid )) {
        $cid = array(0);
}

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

        case 'cancel':
                cancelMember_renew();
                break;

        case 'save':
                saveMember_renew( $id );
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
       $sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
       $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
       $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
       $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
       $search = $database->getEscaped( trim( strtolower( $search ) ) );

       $where = array();

       if ($search_type_id > 0) {
                $where[] = "m.type_id='$search_type_id'";
       }
       if ($search) {
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' || m.member_reg_no='$search' )";
       }

       $working_reg_year_id=$_SESSION['working_reg_year_id'];

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
        $query= "select m.id as id,m.applicant_title AS title, mh.member_reg_no as member_reg_no"
               . "\n ,m.applicant_name AS name,m.applicant_last_name AS last_name"
               . "\n ,m.firm_name AS companyname, mt.name as member_type FROM #__member AS m"
               . "\n left join #__member_history as mh on m.id=mh.member_id"
               . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
              . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where )." and " : " where ")
              . "\n mh.reg_year_id = '$max_reg_year_id' and "
              . "\n mh.member_id not in ($members) and "
              . "\n (mh.entry_type='1' or mh.entry_type='2') and mt.id = m.type_id "
              . "\n ORDER BY mh.member_reg_no, m.type_id "
              . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
              ; //echo $query;
        $database->setQuery( $query);
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
      //    . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
          . "\n where mh.reg_year_id = (select max(id) from #__member_reg_year where id<'$working_reg_year_id' )"
          . "\n and member_id not in (select member_id from #__member_history"
          . "\n where reg_year_id = '$working_reg_year_id')"
          . "\n and (mh.entry_type='1' or mh.entry_type='2') and m.is_delete=0 "
          . "\n ORDER BY m.type_id, m.ordering"
          ;
      }
      else
      {
              $query= "select count(*) FROM mos_member AS m"
          . "\n left join #__member_history as mh on m.id=mh.member_id"
          . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
          . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
          . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
          . "\n and mh.reg_year_id = (select max(id) from #__member_reg_year where id<'$working_reg_year_id' )"
          . "\n and member_id not in (select member_id from #__member_history"
          . "\n where reg_year_id = '$working_reg_year_id')"
          . "\n and (mh.entry_type='1' or mh.entry_type='2')  and m.is_delete=0"
          . "\n ORDER BY m.type_id, m.ordering"
          ;


      }

      $database->setQuery( $query);

      $total = $database->loadResult();

      require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
      $pageNav = new mosPageNav( $total, $limitstart, $limit );


      if (count($where)==0)
      {
              $query= "select m.id as id, m.applicant_title AS title, mh.member_reg_no as member_reg_no"
              . "\n ,m.applicant_name AS name,m.applicant_last_name AS last_name"
              . "\n ,m.firm_name AS companyname,  mt.name as member_type FROM #__member AS m"
              . "\n left join #__member_history as mh on m.id=mh.member_id"
              . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
              . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
              . "\n where mh.reg_year_id = (select max(id) from #__member_reg_year where id<'$working_reg_year_id' )"
              . "\n and member_id not in (select member_id from #__member_history"
              . "\n where reg_year_id = '$working_reg_year_id')"
              . "\n and (mh.entry_type='1' or mh.entry_type='2')  and m.is_delete=0"
              . "\n ORDER BY mh.member_reg_no, m.type_id"
              . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
              ;         // to get the member information who did not renew the in the current year but renewed in the last year

      }
      else
      {
              $query= "select m.id as id,m.applicant_title AS title, mh.member_reg_no as member_reg_no"
               . "\n ,m.applicant_name AS name,m.applicant_last_name AS last_name"
               . "\n ,m.firm_name AS companyname, mt.name as member_type FROM #__member AS m"
               . "\n left join #__member_history as mh on m.id=mh.member_id"
               . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
               . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
               . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
               . "\n and mh.reg_year_id = (select max(id) from #__member_reg_year where id<'$working_reg_year_id' )"
               . "\n and member_id not in (select member_id from #__member_history"
               . "\n where reg_year_id = '$working_reg_year_id')"
               . "\n and (mh.entry_type='1' or mh.entry_type='2')  and m.is_delete=0"
               . "\n ORDER BY mh.member_reg_no, m.type_id"
               . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
               ;         // to get the member information who did not renew the in the current year but renewed in the last year
}

        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return;
        }
        */
        // get list of sections for dropdown filter
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

        $type                 = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );

        $working_reg_year_id=$_SESSION['working_reg_year_id'];

        if($uid!=0){

              $sql_query="select m.id as id,m.is_voter as is_voter ,"
              . "\n m.type_id as member_type_id, m.last_reg_date as renew_date ,m.firm_name as firm,"
              . "\n m.applicant_title as title,m.applicant_name as name,m.applicant_last_name as last_name"
              . "\n ,m.tin as tin,m.trade_licence_issued_by as trade_licence_issued_by,m.trade_licence_issue_date as trade_licence_issue_date,m.trade_licence_expire_date as trade_licence_expire_date"
              ."\n ,mt.name as Type , mh.member_reg_no as lastRegNO, mt.name as member_type "
              . "\n  FROM #__member AS m "
              //. "\n left JOin #__member_type as mt on mt.id=m.type_id where m.id ='$uid'"
               . "\n left JOin #__member_type as mt on mt.id=m.type_id "
               . "\n left JOin #__member_history as mh on mh.member_id=m.id where m.id = '$uid' "
              ;
              $sql_query=$database->replaceTablePrefix($sql_query);

              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $row =& $res->fetchRow();



              $sql_query="select name as curr_reg_year, id as yearid"
              . "\n from #__member_reg_year where id='$working_reg_year_id'"
              ;
              $sql_query=$database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $cur_reg_year =& $res->fetchRow();

              $sql_query="select  renewal_fee as renewal_fee, certificate_fee as certificate_fee from #__member_charge"
              . "\n where member_type_id= '$row->member_type_id'"
              . "\n and reg_year_id='$cur_reg_year->yearid'"
              ;

              $sql_query=$database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =&$dbconn->query($sql_query);
              $renew =&$res->fetchRow();

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

        $lists['bank']                  = mosAdminMenus::BankList( 'bank');
        $lists['is_voter']              = mosHTML::yesnoRadioList( 'is_voter', 'class="inputbox"', 1 );

        Member_renew_html::edit($cur_reg_year, $renew, $row, $lists, $redirect, $start_date, $end_date );
        empty($row);
}

/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/
function saveMember_renew( $id ) {
        global $database,$dbconn,$option;


        $redirect         = mosGetParam( $_POST, 'redirect', '' );
        $money_receipt_date= mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
        $trade_licence_issue_date= mosHTML::ConvertDateForDatatbase($_POST['trade_licence_issue_date']);
        $trade_licence_expire_date= mosHTML::ConvertDateForDatatbase($_POST['trade_licence_expire_date']);
        $money_receipt_no= $_POST['money_receipt_no'];
        $trade_licence_no= $_POST['trade_licence_no'];
        $trade_licence_issued_by= $_POST['trade_licence_issued_by'];
        $firm_name= $_POST['firm_name'];
        $tin= $_POST['tin'];
        $RenewFee1= (intval($_POST['RenewFee']) - intval($_POST['certificate_fee']));
        $certificate_fee= $_POST['certificate_fee'];
        //$is_voter=$_POST['is_voter'];
        $is_voter=1;

        $cur_reg_year1=$_SESSION['cur_reg_year'];
        $renew1=$_SESSION['renew'];
        $row1=$_SESSION['row'];
        $date1=mosHTML::ConvertDateForDatatbase($_POST['renew_date']);
        $published=$_POST['published'];
        $description=$_POST['description'];
        $access=$_POST['access'];
        $date = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];
        session_unregister();
        $bank=$_POST['bank'];
        $member_reg_no=$_POST['member_reg_no'];
        $money_receipt_date=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);

        $sql_query2="select * from mos_member_trail where money_receipt_no ='$money_receipt_no' and bank_id='$bank'";
        $database->setQuery($sql_query2);
        $total_row=$database->loadResult();

         if(count($total_row)>0) {
            echo "<script> alert('This Money Receipt No is already Exists'); window.history.go(-1); </script>\n";
            exit();
        }else {
           $sql_query1= "update #__member set last_reg_date='$date1', date='$date', "
           ."\n trade_licence_issue_date='$trade_licence_issue_date', "
           ."\n trade_licence_expire_date='$trade_licence_expire_date',"
           ."\n trade_licence_no='$trade_licence_no', "
           ."\n member_reg_no='$member_reg_no', "
           ."\n money_receipt_no='$money_receipt_no', "
           ."\n trade_licence_issued_by='$trade_licence_issued_by', "
           ."\n tin='$tin',firm_name='$firm_name', "
           ."\n money_receipt_date='$money_receipt_date' "
           ."\n where id ='$row1->id'";
           $database->setQuery($sql_query1);
           $con1=$database->query();
           $sql_query="insert into #__member_history values('','$row1->id','2','$cur_reg_year1->yearid','$member_reg_no','$is_voter', '$money_receipt_no','$RenewFee1','', '$date','$user_id','$date1','$money_receipt_date')";
           $database->setQuery($sql_query);
           $con2=$database->query();
           if(!$con1 || !$con2){
                echo "<script> alert('Failed to Member Renew'); window.history.go(-1); </script>\n";
                exit();
           }
           else
             $msg="Member is Renewed Successfully";

           $reference_id=$database->insertid();
           $sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
           $database->setQuery($sql_trans);
           $transaction_no=($database->loadResult()+1);
           $date=date( "Y-m-d" );
           $account_query1="insert into #__account_transaction values('','$transaction_no','110','$RenewFee1','0','$reference_id','$money_receipt_date','$date')";
           $account_query1=$database->replaceTablePrefix($account_query1);
           $account_query2="insert into #__account_transaction values('','$transaction_no','1','$RenewFee1','1','$reference_id','$money_receipt_date','$date')";
           $account_query2=$database->replaceTablePrefix($account_query2);

           if(!(mysql_query($account_query1) && mysql_query($account_query2)  ))
           {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
           }
        }

        if(!$database->addMemberTrail($row1->id,'2',$user_id,'',$bank,$money_receipt_no))
        {
             $msg="Incorrect member trail information";

        }

        mosRedirect( "index2.php?option=com_membership_renew_scci&mosmsg=$msg" );
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
        mosRedirect( 'index2.php?option=com_membership_renew_scci' );
}



?>
