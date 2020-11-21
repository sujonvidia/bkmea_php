<?php
/**
* @version $Id: admin.expire_member_list.php,v 1.11 2006/08/27 05:27:26 morshed Exp $
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
                enrollExpireMember( 0, $section );
                break;

        case 'edit':

                enrollExpireMember( intval( $cid[0] ) );
                break;

        case 'editA':
                enrollExpireMember( intval( $id ) );
                break;

        case 'save':
        case 'apply':
                saveExpireMember( $id, $option );
                break;

        case 'cancel':
                cancelExpireMember();
                break;

        default:
                showExpireMember( $section, $option );
                break;
}

/**
* Compiles a list of categories for a section
* @param string The name of the category section
*/
function showExpireMember( $section, $option ) {
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
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' || m.member_reg_no='$search' || m.tin='$search' )";
       }

       $working_reg_year_id=$_SESSION['working_reg_year_id'];
        //get maximum registration year id;
        $query = "select max(id) from #__member_reg_year where id<'$working_reg_year_id'";
             $database->setQuery( $query);
             $max_reg_year_id = $database->loadResult();
        //get valid member id for current registration year;
        $query = "select member_id as id from #__member_history where reg_year_id = '$working_reg_year_id' OR reg_year_id='$max_reg_year_id'";
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

        //get member id for previous registration year;
        $query = "select old_member_id as id from #__expire_member_maping";
             $database->setQuery( $query);
             $rows = $database->loadObjectList();
        //prepare result object to result array;
        $temp = array();
        for($i=0;$i<count($rows);$i++){
             $temp[$i]=$rows[$i]->id;
        }
        //prepare string from member id array
        $old_members = implode(',',$temp );
        $old_members = trim($old_members)==""?"''":$old_members;

        $query= "select count(*) FROM mos_member AS m"
        . "\n left join #__member_history as mh on m.id=mh.member_id"
        . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
        . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
        //. "\n where m.id not in (select member_id from #__member_history"
        //. "\n where reg_year_id = '$working_reg_year_id' ||"
        //. "\n reg_year_id = (select max(id) from #__member_reg_year where id<'$working_reg_year_id' ))"
        ."\n where m.id not in ($members)"
        . "\n and (mh.entry_type='1' or mh.entry_type='2')  and m.is_delete=0"
        //. "\n and m.id NOT IN (select old_member_id as id from #__expire_member_maping)"
        . "\n and m.id NOT IN ($old_members)"
        . ( count( $where ) ? "\n  AND " . implode( ' AND ', $where ) : "")
        . "\n ORDER BY mh.member_reg_no, m.type_id"
        ;

        $database->setQuery( $query);
        $total = $database->loadResult();

        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        $query="select distinct(m.id),m.applicant_title AS title,m.applicant_name AS first_name, "
             ."\n m.applicant_last_name AS last_name,m.firm_name AS companyname, mt.name as member_type,"
             ."\n m.representative_title AS rtitle,m.representative_name AS rfirst_name,m.representative_last_name AS rlast_name,"
             ."\n m.type_id as mtype, mh.member_reg_no as member_reg_no"
             ."\n from mos_member as m, mos_member_history as mh"
             ."\n LEFT JOIN mos_member_type AS mt ON mt.id = m.type_id"
             //."\n where m.id not in (select member_id from mos_member_history where reg_year_id = '$working_reg_year_id' || "
             //."\n reg_year_id = (select max(id) from mos_member_reg_year where id<'$working_reg_year_id' ) "
             . "\n where m.id not in ($members)"
             //."\n and (entry_type='1' or entry_type='2')) and m.is_delete=0"
             ."\n and (mh.entry_type='1' or mh.entry_type='2') and m.is_delete=0"
             //."\n and m.id NOT IN (select old_member_id from mos_expire_member_maping)"
             . "\n and m.id NOT IN ($old_members)"
             //."\n and mh.member_id=m.id and mh.reg_year_id<(select max(id) from mos_member_reg_year where id<'$working_reg_year_id')"
             ."\n and mh.member_id=m.id and mh.reg_year_id<'$max_reg_year_id'"
             . ( count( $where ) ? "\n  AND " . implode( ' AND ', $where ) : "")
             ."\n ORDER BY mh.member_reg_no, m.type_id "
             ."\n LIMIT $pageNav->limitstart, $pageNav->limit"
             ;

        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        //echo $query;
        if ($database->getErrorNum()) {
            echo $database->stderr();
            return;
        }
        // get list of sections for dropdown filter
        // build list of type
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['search_type_id']                   = mosAdminMenus::MemberType( 'search_type_id', $option, intval( $search_type_id ), '', $javascript);

        ExpireMember_html::show( $rows, $pageNav, $lists);
}

/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function enrollExpireMember( $uid=0, $section='' ) {
        global $database, $my, $mosConfig_owner;

        $type             = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );

        $sql_query="select m.id as id, mry.name as last_reg_year_name,m.member_reg_no as member_reg_no, "
          . "\n m.type_id as member_type_id, m.firm_name as firm_name,"
          . "\n m.applicant_title as title, m.applicant_name as first_name, m.applicant_last_name as last_name,"
          . "\n m.representative_title AS rtitle,m.representative_name AS rfirst_name,m.representative_last_name AS rlast_name,"
          . "\n mt.name as member_type, m.type_id as mtype "
          . "\n FROM #__member AS m , #__member_history as mh "
          . "\n left join #__member_reg_year as mry on mry.id=mh.reg_year_id"
          . "\n left JOin #__member_type as mt on mt.id=m.type_id"
          . "\n where m.id ='$uid' and mh.member_id=m.id order by mh.reg_year_id desc "
          ;
        $database->setQuery($sql_query);

        $res=$database->loadObjectList();
        $row=$res[0];
        if(strtolower($mosConfig_owner)=="scci"){
              $sql_query="select  sum(enrollment_fee + renewal_fee+certificate_fee) as enrollment_fee "
              ."\n from #__member_charge where member_type_id= '$row->member_type_id'"
              . "\n and reg_year_id='".$_SESSION['working_reg_year_id']."'"
              ;
        }
        else if(strtolower($mosConfig_owner)=="ccci"){
            //get membership charge
            $sql_query="select  enrollment_fee as enrollment_fee "
            ."\n from #__member_charge where member_type_id= '$row->member_type_id'"
            . "\n and reg_year_id='".$_SESSION['working_reg_year_id']."'"
            ;
        }
        $database->setQuery($sql_query);
        $enrollment_fee=$database->loadResult();
        $row->enrollment_fee=$enrollment_fee;
	/*
        $sql_query="select member_reg_no as member_reg_no"
              ."\n from #__member_history where reg_year_id='".$_GET['last_reg_year_id']."'"
              ."\n and member_id='$uid'"
              ;
        $database->setQuery($sql_query);
        $res=$database->loadObjectList();
        $row->member_reg_no=$res[0]->member_reg_no;
	*/
        //get start and end date from member_reg_year table;
        $query=  "select start_date,end_date from #__member_reg_year "
                 ."\n where id='".$_SESSION['working_reg_year_id']."'"
                 ;
        $database->setQuery($query);
        $res=$database->loadObjectList();
        $start_date=mosHTML::ConvertDateDisplayShort($res[0]->start_date);
        $end_date=mosHTML::ConvertDateDisplayShort($res[0]->end_date);   //convert date

        $lists=array();
        $lists['bank']                  = mosAdminMenus::BankList( 'bank');

        ExpireMember_html::edit($row, $start_date, $end_date, $lists );
        empty($row);
}

/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/
function saveExpireMember( $id, $option ) {
        global $database,$dbconn,$option, $mosConfig_owner,$mosConfig_absolute_path;


        $bank = intval($_POST['bank']);
        $member_type_id   = $_POST['member_type_id'];
        $member_reg_no    = $_POST['member_reg_no'];
        $money_receipt_no = $_POST['money_receipt_no'];
        $enrollment_fee = $_POST['enrollment_fee'];
        $money_receipt_date = mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
        $enrollment_date    = mosHTML::ConvertDateForDatatbase($_POST['enrollment_date']);
        $date = date( "Y-m-d H:i:s" );
        $user_id = $_SESSION['session_username'];

        //get member information
        $query="select * from #__member where id='$id'";
        $database->setQuery($query);
        $rows=$database->loadObjectList();
        $object=$rows[0];

        $object->id='';
        $object->date=$date;
        $object->reg_date=$enrollment_date;
        $object->last_reg_date=$enrollment_date;
        strtolower($mosConfig_owner)=="ccci" ? ($object->member_reg_no=$member_reg_no) : "" ;

         // Query for check duplicate Money Receipt Number
        $sql_query2="select * from #__member_trail where money_receipt_no ='".$_POST['money_receipt_no']."'";
        $database->setQuery($sql_query2);
        $total_row=$database->loadResult();

        if(count($total_row)>0 ) {
            echo "<script> alert('This Money Receipt No is already Exist\'s'); window.history.go(-1); </script>\n";
            exit();
        }

        $fmtsql = "INSERT INTO #__member ( %s ) VALUES ( %s ) ";
        $fields = array();
        $values = array();
        foreach (get_object_vars( $object ) as $k => $v) {
                if (is_array($v) or is_object($v) or $v === NULL) {
                   continue;
                }
                if ($k[0] == '_') { // internal field
                   continue;
                }
                $fields[] = "`$k`";
                $values[] = "'" . $database->getEscaped( $v ) . "'";
        }
        $insert_query = sprintf( $fmtsql, implode( ",", $fields ) ,  implode( ",", $values ) ) ;

        $database->setQuery($insert_query);
        if(!$database->query()){
              $msg="Failed to Enroll Expire Member";
              mosRedirect( "index2.php?option=$option&task=editA&hidemainmenu=1&id=".$id."&mosmsg=".$msg );
        }
        $insert_id = $database->insertid();
        //update member status
        /* $query="update #__member set is_delete='1' where id='$id'";
        $database->setQuery($query);
        if(!$database->query()){
            $msg="Failed to Process Expire Member";
            mosRedirect( "index2.php?option=$option&task=editA&hidemainmenu=1&id=".$id."&mosmsg=".$msg );
        }  */


        $database->setQuery("insert into #__expire_member_maping values('','$id','$insert_id');");
        $database->query();
        //image copy
        $source_path=$mosConfig_absolute_path."/administrator/images/photograph/".$id;
        $destination_path=$mosConfig_absolute_path."/administrator/images/photograph/".$insert_id;

        mkdir($destination_path,0777);
        if(!CopyFiles($source_path,$destination_path))
           $up_msg="<br>Failed to copy applicant/representative photograph";
        else
          $up_msg="";

        //insert into member history table
        $query="insert into #__member_history (member_id,entry_type,reg_year_id,member_reg_no"
                   .",is_voter,money_receipt_no,amount,date,user_id,reg_date)"
                   ." values('".$insert_id."','1','".$_SESSION['working_reg_year_id']
                   ."','".$member_reg_no."','1','".$money_receipt_no."','".$enrollment_fee
                   ."','".$date."','".$user_id."','".$enrollment_date."')";
        $database->setQuery($query);
        if(!$database->query()){
             $msg="Failed to Add Member History";
             mosRedirect( "index2.php?option=$option&task=editA&hidemainmenu=1&id=".$id."&mosmsg=".$msg );
        }
        //get insert id for history entry;
        $reference_id=$database->insertid();
        //get maximum transaction no from database
        $sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
        $database->setQuery($sql_trans);
        $transaction_no=($database->loadResult()+1);

        if(strtolower($mosConfig_owner)=="scci")
        {
            //tin number issue
            $query="select count(m.id) from #__member as m"
                ."\n join #__member_history as mh on m.id=mh.member_id"
                ."\n where m.tin ='".$object->tin."' and"
                ."\n mh.reg_year_id='".$_SESSION['working_reg_year_id']."'"
                ;

            $database->setQuery($query);
            if ($database->loadResult()>1){
                 $query="update #__member_history as mh set mh.is_voter=0"
                 ."\n where mh.member_id in (select id from #__member where tin='".$object->tin."')"
                 ."\n and mh.reg_year_id='".$_SESSION['working_reg_year_id']."'"
                 ;
                 $database->setQuery($query);
                 $database->query();
            }

            //get membership charge
            $sql_query="select  enrollment_fee as admission_fee, renewal_fee as yearly_subscription_fee "
            ."\n from #__member_charge where member_type_id= '".$_POST['type_id']."'"
            . "\n and reg_year_id='".$_SESSION['working_reg_year_id']."'"
            ;
            $database->setQuery($sql_query);
            $fee =$database->loadObjectList();
            $admision_fee=$fee[0]->admission_fee;
            $yearly_subscription_fee=$fee[0]->yearly_subscription_fee;
            //prepare transaction query();
            $date=date("Y-m-d");
            $account_query1="insert into #__account_transaction values('','$transaction_no','101','$admision_fee','0','$reference_id','$money_receipt_date','$date')";
            $account_query1=$database->replaceTablePrefix($account_query1);
            $account_query2="insert into #__account_transaction values('','$transaction_no','1','$admision_fee','1','$reference_id','$money_receipt_date','$date')";
            $account_query2=$database->replaceTablePrefix($account_query2);

            $transaction_no=$transaction_no+1;
            $account_query3="insert into #__account_transaction values('','$transaction_no','100','$yearly_subscription_fee','0','$reference_id','$money_receipt_date','$date')";
            $account_query3=$database->replaceTablePrefix($account_query3);
            $account_query4="insert into #__account_transaction values('','$transaction_no','1','$yearly_subscription_fee','1','$reference_id','$money_receipt_date','$date')";
            $account_query4=$database->replaceTablePrefix($account_query4);

            if(!(mysql_query($account_query1) && mysql_query($account_query2) && mysql_query($account_query3) && mysql_query($account_query4)) ){
                   $msg="Failed to add accounts transaction";
                   mosRedirect( "index2.php?option=$option&task=editA&hidemainmenu=1&id=".$id."&mosmsg=".$msg );
            }
        }
        else if(strtolower($mosConfig_owner)=="ccci")
        {
            //get membership charge
            $sql_query="select  enrollment_fee as enrollment_fee "
            ."\n from #__member_charge where member_type_id= '".$_POST['type_id']."'"
            . "\n and reg_year_id='".$_SESSION['working_reg_year_id']."'"
            ;
            $database->setQuery($sql_query);
            $fee =$database->loadObjectList();
            $enrollment_fee=$fee[0]->enrollment_fee;
            //prepare transaction query();
            $date=date("Y-m-d");
            $account_query1="insert into #__account_transaction values('','$transaction_no','100','$enrollment_fee','0','$reference_id','$money_receipt_date','$date')";
            $account_query1=$database->replaceTablePrefix($account_query1);
            $account_query2="insert into #__account_transaction values('','$transaction_no','1','$enrollment_fee','1','$reference_id','$money_receipt_date','$date')";
            $account_query2=$database->replaceTablePrefix($account_query2);

            if(!(mysql_query($account_query1) && mysql_query($account_query2) ) ){
                   $msg="Failed to add accounts transaction";
                   mosRedirect( "index2.php?option=$option&task=editA&hidemainmenu=1&id=".$id."&mosmsg=".$msg );
            }
        }

        if(!$database->addMemberTrail($insert_id,'1',$user_id,'',$bank,$money_receipt_no)){
           $msg="Incorrect Member Trail Information";
           mosRedirect( "index2.php?option=$option&id=".$id."&mosmsg=".$msg );
        }
        $msg="Expire Member Enroll Successfully".$up_msg;

        mosRedirect( "index2.php?option=com_expire_member_list&mosmsg=$msg" );
}

/**
* Cancels an edit operation
* @param string The name of the category section
* @param integer A unique category id
*/
function cancelExpireMember() {
        global $database;
        //$redirect = mosGetParam( $_POST, 'redirect', '' );

        //$row = new mosRenew( $database );
        //$row->bind( $_POST );
        //$row->checkin();
        mosRedirect( 'index2.php?option=com_expire_member_list' );
}


//copy many files
function CopyFiles($source,$dest)
{
   $folder = opendir($source);
   while($file = readdir($folder))
   {
       if ($file == '.' || $file == '..') {
           continue;
       }

       if(is_dir($source.'/'.$file))
       {
           mkdir($dest.'/'.$file,0777);
           CopySourceFiles($source.'/'.$file,$dest.'/'.$file);
       }
       else
       {
           copy($source.'/'.$file,$dest.'/'.$file);
       }

   }
   closedir($folder);
   return 1;
}

?>
