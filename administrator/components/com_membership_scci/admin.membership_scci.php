<?php
/**
* @version $Id: admin.membership_scci.php,v 1.43 2006/05/18 07:36:16 morshed Exp $
* @package Mambo
* @subpackage Weblinks
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

// ensure user has access to this function
if (!($acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'all' )
                | $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_membership_ccci' ))) {
        //mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$cid = mosGetParam( $_POST, 'cid', array(0) );
$id = mosGetParam( $_REQUEST, 'id' );
 //echo "cid=$cid";
switch ($task) {
        case 'new' :
        case 'newA':
                editMembership( $option, 0 );
                break;

        case 'edit' :
                mosRedirect( "index2.php?option=com_membership_edit_scci&task=editA&hidemainmenu=1&id=".$cid[0] );
                break;

        case 'editA':
                mosRedirect( "index2.php?option=com_membership_edit_scci&task=editA&hidemainmenu=1&id=".$id );
                break;

        case 'save':
                saveMembership( $option, $id );
                break;

        case 'remove':
                removeMembership( $cid, $option );
                break;

        case 'cancel':
                cancelMembership( $option );
                break;

        default:
                showMembership( $option );
                break;
}

/**
* Compiles a list of records
* @param database A database connector object
*/
function showMembership( $option ) {
        global $database, $mainframe, $mosConfig_list_limit;

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
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' OR LOWER(m.member_reg_no) = '$search' ) ";
        }

        $sub="(( mh.entry_type=1 and mh.reg_year_id='".$_SESSION['working_reg_year_id']."' )"
             ."\n || ( mh.entry_type=2 and mh.reg_year_id='".$_SESSION['working_reg_year_id']."' ))";

        // get the total number of records
        $query = "SELECT count(*) FROM #__member AS m"
                . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
                . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
                . ( count( $where ) ? " and m.is_delete=0 and $sub " : " where m.is_delete=0 and $sub " )
                . "\n and m.type_id !=1 and m.type_id!=2 "
                ;
        $database->setQuery( $query );
        $total = $database->loadResult();

        require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit  );

        $query = "SELECT mt.name AS type, m.applicant_title AS applicant_title,"
        ."\n m.applicant_name AS applicant_name,m.applicant_last_name AS applicant_last_name,m.id as id,"
        . "\n u.name AS editor, m.firm_name AS firm_name, mh.member_reg_no as member_reg_no"
        . "\n FROM #__member AS m"
        . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
        . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
        . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
        . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
        . ( count( $where ) ? " and m.is_delete=0 and $sub " : " where m.is_delete=0 and $sub " )
        . "\n and m.type_id !=1 and m.type_id!=2 "
        . "\n ORDER BY m.member_reg_no, m.type_id"
        . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
        ;
        $database->setQuery( $query );
        //echo $query;
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return false;
        }

        // build list of categories
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['search_type_id']                   = mosAdminMenus::MemberType( 'search_type_id', $option, intval( $search_type_id ), 1, $javascript);

        HTML_Membership::showMembership( $option, $rows, $lists, $search, $pageNav );
}

/**
* Compiles information to add or edit
* @param integer The unique id of the record to edit (0 if new)
*/
function editMembership( $option, $id=0 ) {
        global $database, $my, $dbconn;


                //MemberSessionUnregister();

                     //$row->id=0;
                     $_SESSION['last_reg_year_id']                  = $_SESSION['working_reg_year_id'];
                     $_SESSION['representative_designation']=8;

        $javascript="onChange=\"return belongs_to();\"";
        $lists = array();
        $lists['type_id']                      = mosAdminMenus::MemberType( 'type_id', $option, intval( $_SESSION['type_id'] ), 1,$javascript );
        $lists['corporate_status']             = mosAdminMenus::CorporateStatus( 'corporate_status', $_SESSION['corporate_status'] );
        $lists['last_reg_year_id']             = mosAdminMenus::RegYear( 'last_reg_year_id',  intval( $_SESSION['last_reg_year_id'] ), 'disabled' );
        $lists['applicant_designation'] = mosAdminMenus::Designation( 'applicant_designation',  intval( $_SESSION['applicant_designation'] ));
        $lists['representative_designation'] = mosAdminMenus::Designation( 'representative_designation',  intval( $_SESSION['representative_designation'] ));
        $lists['proposer1_title']             = mosAdminMenus::MemberTitle( 'proposer1_title',$_SESSION['proposer1_title'] );
        $lists['proposer2_title']             = mosAdminMenus::MemberTitle( 'proposer2_title',$_SESSION['proposer2_title'] );
        $lists['applicant_title']             = mosAdminMenus::MemberTitle( 'applicant_title',$_SESSION['applicant_title'] );
        $lists['representative_title']             = mosAdminMenus::MemberTitle( 'representative_title',$_SESSION['representative_title'] );
        $lists['location']             = mosAdminMenus::Location( 'location',$_SESSION['location'] );
        $lists['business_type']             = mosAdminMenus::MultipleBusinessType( 'business_type[]','business_type' );
        //get registration date from member_reg_year table;
        $query=  "select start_date,end_date from #__member_reg_year "
                ."\n where id='".$_SESSION['last_reg_year_id']."'"
                ;
        $database->setQuery($query);
        $res=$database->loadObjectList();
        $start_date=mosHTML::ConvertDateDisplayShort($res[0]->start_date);
        $end_date=mosHTML::ConvertDateDisplayShort($res[0]->end_date);   //convert date
        $end_year=explode("-",$end_date);
        $row->trade_licence_expire_date="30-06-".$end_year[2];

        HTML_Membership::editMembership( $row, $lists, $option, $id, $start_date, $end_date);
}

/**
* Saves the record on an edit form submit
* @param database A database connector object
*/
function saveMembership( $option, $id=0 ) {
        global $database, $my, $dbconn, $mosConfig_absolute_path;

        $current_date_time = date( "Y-m-d H:i:s" );
        $date = date( "Y-m-d");
        $user_id=$_SESSION['session_username'];
        $image_path="./administrator/images/photograph/";

        // Query for check duplicate Member Registration Number
        $query="select mh.member_reg_no from #__member_history as mh"
                ."\n join #__member as m on m.id=mh.member_id"
                ."\n join #__member_type as mt on mt.id=m.type_id"
                ."\n where mh.member_reg_no='".$_POST['member_reg_no']."'"
                ."\n and m.is_delete=0 and m.type_id='".$_POST['type_id']."'"
                ;

        $query  =  $database->replaceTablePrefix($query);
        $result=mysql_query($query) or die(mysql_error());
        if (mysql_num_rows($result)>0){
            //echo "<script> alert(Money Receipt No ".$money_receipt_no." Already Exist); window.history.go(-1); </script>\n";
            //exit();
            $msg="Membership No. ".$_POST['member_reg_no']." Already Exist";
            mosRedirect( "index2.php?option=$option&task=new&mosmsg=".$msg );
        }

         // Query for check duplicate Money Receipt Number
        $sql_query2="select * from #__member_trail where money_receipt_no ='".$_POST['money_receipt_no']."'";
        $database->setQuery($sql_query2);
        $total_row=$database->loadResult();

        if(count($total_row)>0 ) {
            //echo "<script> alert('This Money Receipt No is already Exist\'s'); window.history.go(-1); </script>\n";
            //exit();
            $msg="Money Receipt No. ".$_POST['money_receipt_no']." Already Exist";
            mosRedirect( "index2.php?option=$option&task=new&mosmsg=".$msg );
        }

         // Upload Photograph
         if(isset($_FILES['up_file'])){
                 global $mosConfig_absolute_path;
                 $old_image=trim($_SESSION['applicant_photograph']);
                 $representative_old_image=trim($_SESSION['representative_photograph']);
                 $image=trim($mosConfig_absolute_path."/administrator/images/photograph/".$id."/".$old_image);
                 $representative_image=trim($mosConfig_absolute_path."/administrator/images/photograph/".$id."/".$representative_old_image);

                 #--------- Start::check photograph directory ---------#   
                 if(!file_exists($mosConfig_absolute_path."/administrator/images/photograph/".$id."/")){
                        mkdir($mosConfig_absolute_path."/administrator/images/photograph/".$id."/",0777);
                 }else{
                        chmod($mosConfig_absolute_path."/administrator/images/photograph/".$id,0777);
                 }
                 #-------------------------end-------------------------#

                 if($old_image!="" && file_exists($image))
                         @unlink($image);
                 if($representative_old_image!="" && file_exists($representative_image))
                         @unlink($representative_image);
                 $con=upload();
                 echo $_SESSION['up_message'];
          }


        $type_id=$_POST['type_id'];
        $last_reg_year_id=$_POST['last_reg_year_id'];
        $member_reg_no=$_POST['member_reg_no'];
        $reg_date=mosHTML::ConvertDateForDatatbase($_POST['reg_date']);
        $money_receipt_no=$_POST['money_receipt_no'];
        $money_receipt_date=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);

        $trade_licence_no=$_POST['trade_licence_no'];
        $trade_licence_issued_by=$_POST['trade_licence_issued_by'];
        $date_of_formation=mosHTML::ConvertDateForDatatbase($_POST['date_of_formation']);
        $trade_licence_issue_date=mosHTML::ConvertDateForDatatbase($_POST['trade_licence_issue_date']);
        $trade_licence_expire_date=mosHTML::ConvertDateForDatatbase($_POST['trade_licence_expire_date']);
        $corporate_status=$_POST['corporate_status'];
        $location=$_POST['location'];
        $amount=$_POST['amount'];


        $firm_name=$_POST['firm_name'];
        $firm_reg_address_street=$_POST['firm_reg_address_street'];
        $firm_reg_address_town_suburb=$_POST['firm_reg_address_town_suburb'];
        $firm_reg_address_district=$_POST['firm_reg_address_district'];
        $firm_reg_address_division=$_POST['firm_reg_address_division'];
        $firm_reg_address_country=$_POST['firm_reg_address_country'];
        $firm_phone=$_POST['firm_phone'];
        $firm_mobile=$_POST['firm_mobile'];
        $firm_fax=$_POST['firm_fax'];
        $firm_email=$_POST['firm_email'];
        $firm_web=$_POST['firm_web'];

        $head_office_address_street=$_POST['head_office_address_street'];
        $head_office_address_town_suburb=$_POST['head_office_address_town_suburb'];
        $head_office_address_district=$_POST['head_office_address_district'];
        $head_office_address_division=$_POST['head_office_address_division'];
        $head_office_address_country=$_POST['head_office_address_country'];
        $head_office_phone=$_POST['head_office_phone'];
        $head_office_mobile=$_POST['head_office_mobile'];
        $head_office_fax=$_POST['head_office_fax'];
        $head_office_email=$_POST['head_office_email'];
        $head_office_web=$_POST['head_office_web'];

        $tin=$_POST['tin'];
        $import_reg_no=$_POST['import_reg_no'];
        $export_reg_no=$_POST['export_reg_no'];
        $indenting_trade_no=$_POST['indenting_trade_no'];
        $bank_name=$_POST['bank_name'];
        $bank_address=$_POST['bank_address'];

        $proposer1_title=$_POST['proposer1_title'];
        $proposer1_name=$_POST['proposer1_name'];
        $proposer1_last_name=$_POST['proposer1_last_name'];
        $proposer1_address=$_POST['proposer1_address'];
        $proposer1_member_reg_no=$_POST['proposer1_member_reg_no'];
        $proposer1_firm_name=$_POST['proposer1_firm_name'];

        $proposer2_title=$_POST['proposer2_title'];
        $proposer2_name=$_POST['proposer2_name'];
        $proposer2_last_name=$_POST['proposer2_last_name'];
        $proposer2_address=$_POST['proposer2_address'];
        $proposer2_member_reg_no=$_POST['proposer2_member_reg_no'];
        $proposer2_firm_name=$_POST['proposer2_firm_name'];

        $applicant_title=$_POST['applicant_title'];
        $applicant_name=$_POST['applicant_name'];
        $applicant_last_name=$_POST['applicant_last_name'];
        $applicant_designation=$_POST['applicant_designation'];
        $applicant_photograph=$_SESSION['applicant_photograph'];
        $representative_title=$_POST['representative_title'];
        $representative_name=$_POST['representative_name'];
        $representative_last_name=$_POST['representative_last_name'];
        $representative_designation=$_POST['representative_designation'];
         if (empty($_SESSION['representative_photograph']) && $_POST['check_propietor_information']=="on")
            $representative_photograph=$_SESSION['applicant_photograph'];
        else
            $representative_photograph=$_SESSION['representative_photograph'];



        if($id==0){
                     $sql_query= "insert into #__member (type_id,member_reg_no,firm_name,firm_reg_address_street"
                                 .",firm_reg_address_town_suburb,firm_reg_address_district,firm_reg_address_division"
                                 .",firm_reg_address_country,firm_phone,firm_fax,firm_email,firm_web"
                                 .",head_office_address_street,head_office_address_town_suburb"
                                 .",head_office_address_district,head_office_address_division"
                                 .",head_office_address_country,head_office_phone,head_office_fax"
                                 .",head_office_email,head_office_web,corporate_status,applicant_title"
                                 .",applicant_name,applicant_last_name,applicant_designation"
                                 .",applicant_photograph,representative_title,representative_name"
                                 .",representative_last_name,representative_designation"
                                 .",representative_photograph,bank_name,bank_address"
                                 .",trade_licence_issued_by,trade_licence_no,trade_licence_expire_date"
                                 .",money_receipt_no,money_receipt_date,import_reg_no,export_reg_no"
                                 .",indenting_trade_no,tin,reg_date,last_reg_date,date,trade_licence_issue_date"
                                 .",proposer1_title,proposer1_name,proposer1_last_name"
                                 .",proposer1_address,proposer1_member_reg_no,proposer1_firm_name,proposer2_title"
                                 .",proposer2_name,proposer2_last_name,proposer2_address"
                                 .",proposer2_member_reg_no,proposer2_firm_name,date_of_formation,location"
                                 .",head_office_mobile,firm_mobile)"
                                 ." values ('". $type_id."','".$member_reg_no."','".$firm_name
                                 ."','".$firm_reg_address_street."','".$firm_reg_address_town_suburb
                                 ."','".$firm_reg_address_district."','".$firm_reg_address_division
                                 ."','".$firm_reg_address_country."','".$firm_phone."','". $firm_fax
                                 ."','".$firm_email."','".$firm_web."','".$head_office_address_street
                                 ."','".$head_office_address_town_suburb."','".$head_office_address_district
                                 ."','".$head_office_address_division."','".$head_office_address_country
                                 ."','".$head_office_phone."','".$head_office_fax."','".$head_office_email
                                 ."','".$head_office_web."','".$corporate_status."','".$applicant_title
                                 ."','".$applicant_name."','".$applicant_last_name
                                 ."','".$applicant_designation."','".$applicant_photograph
                                 ."','".$representative_title."','".$representative_name
                                 ."','".$representative_last_name."','".$representative_designation
                                 ."','".$representative_photograph."','".$bank_name."','".$bank_address
                                 ."','".$trade_licence_issued_by ."','".$trade_licence_no
                                 ."','".$trade_licence_expire_date."','".$money_receipt_no
                                 ."','".$money_receipt_date ."','".$import_reg_no
                                 ."','".$export_reg_no."','".$indenting_trade_no."','".$tin."','".$reg_date
                                 ."','".$reg_date."','".$current_date_time."','".$trade_licence_issue_date
                                 ."','".$proposer1_title."','".$proposer1_name."','".$proposer1_last_name
                                 ."','".$proposer1_address."','".$proposer1_member_reg_no
                                 ."','".$proposer1_firm_name."','".$proposer2_title
                                 ."','".$proposer2_name."','".$proposer2_last_name."','".$proposer2_address
                                 ."','".$proposer2_member_reg_no."','".$proposer2_firm_name
                                 ."','".$date_of_formation."','".$location."','".$head_office_mobile."','".$firm_mobile."')";



                      //$sql_query  =  $database->replaceTablePrefix($sql_query);
                      $database->setQuery($sql_query);
                      $msg="Failed to Add Member Information";

                      if(!$database->query()) {
                           mosRedirect( "index2.php?option=$option&task=new&id=".$id."&mosmsg=".$msg );
                      }
                      $insert_id = $database->insertid(); //mysql_insert_id($dbconn->connection);

                      //Business Type -- Multiple select
                      $business = $_POST['business_type'];
                      $total=count($business);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                             $query="insert into #__member_business_type values('','".$insert_id."','".$business[$i]."')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                      }

                      $query="insert into #__member_history (member_id,entry_type,reg_year_id,member_reg_no"
                             .",is_voter,money_receipt_no,amount,date,user_id,reg_date,money_receipt_date)"
                             ." values('".$insert_id."','1','".$_SESSION['last_reg_year_id']
                             ."','".$member_reg_no."','1','".$money_receipt_no."','".$amount
                             ."','".$current_date_time."','".$user_id."','".$reg_date."','".$money_receipt_date."')";

                      //$query  =  $database->replaceTablePrefix($query);
                      $database->setQuery($query);
                      $msg="Failed to Add Member History";
                      if(!$database->query()) {
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                           mosRedirect( "index2.php?option=$option&id=".$id."&mosmsg=".$msg );
                      }

                      //account transaction
                      $reference_id=$database->insertid();
                      $sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
                      $database->setQuery($sql_trans);
                      $transaction_no=($database->loadResult()+1);

                      $sql_query="select  enrollment_fee as admission_fee, renewal_fee as yearly_subscription_fee "
                      ."\n from #__member_charge where member_type_id= '$type_id'"
                      . "\n and reg_year_id='".$_SESSION['last_reg_year_id']."'"
                      ;
                      $database->setQuery($sql_query);
                      $fee =$database->loadObjectList();
                      $admision_fee=$fee[0]->admission_fee;
                      $yearly_subscription_fee=$fee[0]->yearly_subscription_fee;

                      $account_query1="insert into #__account_transaction values('','$transaction_no','101','$admision_fee','0','$reference_id','$money_receipt_date','$date')";
                      $account_query1=$database->replaceTablePrefix($account_query1);
                      $account_query2="insert into #__account_transaction values('','$transaction_no','1','$admision_fee','1','$reference_id','$money_receipt_date','$date')";
                      $account_query2=$database->replaceTablePrefix($account_query2);

                      $transaction_no=$transaction_no+1;
                      $account_query3="insert into #__account_transaction values('','$transaction_no','100','$yearly_subscription_fee','0','$reference_id','$money_receipt_date','$date')";
                      $account_query3=$database->replaceTablePrefix($account_query3);
                      $account_query4="insert into #__account_transaction values('','$transaction_no','1','$yearly_subscription_fee','1','$reference_id','$money_receipt_date','$date')";
                      $account_query4=$database->replaceTablePrefix($account_query4);

                      if(!(mysql_query($account_query1) && mysql_query($account_query2) && mysql_query($account_query3) && mysql_query($account_query4)  ))
                      {
                           echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                           exit();
                      }
                      $query="select m.id as id from #__member as m"
                             ."\n join #__member_history as mh on m.id=mh.member_id"
                             ."\n where m.tin ='".$tin."' and"
                             ."\n mh.reg_year_id='".$_SESSION['last_reg_year_id']."'"
                             ;

                      $query  =  $database->replaceTablePrefix($query);
                      $result=mysql_query($query) or die(mysql_error());
                      if (mysql_num_rows($result)>1){
                              $query="update #__member_history as mh set mh.is_voter=0"
                              ."\n where mh.member_id in (select id from #__member where tin='".$tin."')"
                              ."\n and mh.reg_year_id='".$_SESSION['last_reg_year_id']."' and is_delete='0'"
                             ;

                      $query  =  $database->replaceTablePrefix($query);
                      $result=mysql_query($query) or die(mysql_error());
                      }

                      if(!$database->addMemberTrail($insert_id,'1',$user_id,'','',$money_receipt_no)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                           mosRedirect( "index2.php?option=$option&id=".$id."&mosmsg=".$msg );
                      }

                      //photograph upload

                      @rename("./images/photograph/".$_SESSION['folder_name'],"./images/photograph/".$insert_id);
                      //$mosmsg='Member profile is saved successfully';

                      $msg='Member profile is saved successfully';
        }

        MemberSessionUnregister();

        $row = new mosMembership( $database );
        $row->bind( $_POST );
        $row->checkin();
        mosRedirect( "index2.php?option=com_membership_scci&mosmsg=".$msg );
        //HTML_Membership::Confirmation( $option, $id , $mosmsg);
}


function upload(){

        global $mosConfig_absolute_path, $id;
        $image_path=$mosConfig_absolute_path."/administrator/images/photograph/";
        if($id>0){
           $folder_name=$id;
           if(!file_exists($image_path.$folder_name))
               mkdir($image_path.$folder_name."/",0777);
        }
        else{
           $folder_name=date('d_m_y_h_i_s');     //when $id=0;
           mkdir($image_path.$folder_name."/",0777);
        }

        $image_path=$image_path.$folder_name."/";

        if(isset($_FILES['up_file']) && is_array($_FILES['up_file']))
        {
              /*  $dirPathPost = $_POST['dirPath'];

                if(strlen($dirPathPost) > 0)
                {
                        if(substr($dirPathPost,0,1)=='/')
                                $IMG_ROOT .= $dirPathPost;
                        else
                                $IMG_ROOT = $dirPathPost;
                }

                if(strrpos($IMG_ROOT, '/')!= strlen($IMG_ROOT)-1)
                        $IMG_ROOT .= '/';
                */

             if(do_upload( $_FILES['up_file'], $image_path)){
                     $file=$_FILES['up_file'];
                     $_SESSION['folder_name']=$folder_name;
                     $_SESSION['applicant_photograph']=$file['name'][0];
                     $_SESSION['representative_photograph']=$file['name'][1];
                     $return=true;
             }
             else
               $return=false;
        }
        return $return;
}

function do_upload($file, $dest_dir)
{
        global $clearUploads;

                if (file_exists($dest_dir.$file['name'][0])) {
                        $_SESSION['up_message']="Upload FAILED : File allready exists";
                        $up=false;
                }
                if (strcasecmp(substr($file['name'][0],-4),".jpg") || strcasecmp(substr($file['name'][0],-5),".jpeg"))  {
                        $_SESSION['up_message']="Only file type .jpg or .jpeg can be uploaded";
                        $up=false;
                }

                if ($file['name'][0]=="") {
                        $_SESSION['up_message'] = "";
                        $up=false;
                }
                else if (!move_uploaded_file($file['tmp_name'][0], $dest_dir.strtolower($file['name'][0]))){
                        $_SESSION['up_message']="Upload FAILED FOR APPLICANT PHOTOGRAPH " ;
                        $up=false;
                }
                else {
                        mosChmod($dest_dir.strtolower($file['name'][0]));
                        $_SESSION['up_message']="Upload complete";
                        $up=true;
                }
                if (!empty($file['name'][1])){
                    if (file_exists($dest_dir.$file['name'][1])) {
                            $_SESSION['up_message']="Upload FAILED : File allready exists";
                            $up=false;
                    }
                if (strcasecmp(substr($file['name'][1],-4),".jpg") || strcasecmp(substr($file['name'][1],-5),".jpeg"))  {
                        $_SESSION['up_message']="Only file type .jpg or .jpeg can be uploaded";
                        $up=false;
                }
                    if ($file['name'][1]=="") {
                            $_SESSION['up_message'] = "";
                            $up=false;
                    }
                    else if (!move_uploaded_file($file['tmp_name'][1], $dest_dir.strtolower($file['name'][1]))){
                            $_SESSION['up_message']="Upload FAILED FOR RRPRESENTATIVE PHOTOGRAPH " ;
                            $up=false;
                    }
                    else {
                            mosChmod($dest_dir.strtolower($file['name'][1]));
                            $_SESSION['up_message']="Upload complete";
                            $up=true;
                    }
                }

        $clearUploads = true;
        return $up;
}

/**
* Deletes one or more records
* @param array An array of unique category id numbers
* @param string The current url option
*/
function removeMembership( $cid, $option ) {
        global $database;

        if (!is_array( $cid ) || count( $cid ) < 1) {
                echo "<script> alert('Select an item to delete'); window.history.go(-1);</script>\n";
                exit;
        }
        if (count( $cid )) {
                $cids = implode( ',', $cid );

                $database->setQuery( "update #__member set is_delete='1' WHERE id IN ($cids)" );
                $con1=$database->query();


                foreach($cid as $id=>$val){
                       $con=$database->addMemberTrail($val,'6',$_SESSION['session_username']);
                }
                /*
                $database->setQuery( "DELETE FROM #__member WHERE id IN ($cids)" );
                $con1=$database->query();
                $database->setQuery( "DELETE FROM #__member_product_country WHERE member_id IN ($cids)" );
                $con2=$database->query();
                $database->setQuery( "DELETE FROM #__member_product_line WHERE member_id IN ($cids)" );
                $con3=$database->query();
                $database->setQuery( "DELETE FROM #__member_history WHERE member_id IN ($cids)" );
                $con4=$database->query();
                */
                if (!$con1 || !$con ) {
                        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                }
                else
                  $msg="Membership Information Deleted Successfully";
        }

        //$msg="Membership Information deleted Successfully";
        mosRedirect( "index2.php?option=".$option."&mosmsg=". $msg );
}

/**
* Cancels an edit operation
* @param string The current url option
*/
function cancelMembership( $option ) {
        global $database;
        $row = new mosMembership( $database );
        $row->bind( $_POST );
        $row->checkin();
        MemberSessionUnregister();
        mosRedirect( "index2.php?option=$option" );
}

function MemberSessionUnregister(){
         //global
         //session_unregister('session_username');
         session_unregister('type_id');
         session_unregister('last_reg_year_id');
         session_unregister('corporate_status');
         session_unregister('applicant_designation');
         session_unregister('applicant_photograph');
         session_unregister('representative_designation');
         session_unregister('representative_photograph');
         session_unregister('representative_title');
         session_unregister('applicant_title');
         session_unregister('proposer1_title');
         session_unregister('proposer1_firm_name');
         session_unregister('proposer2_firm_name');
         session_unregister('proposer2_title');
         session_unregister('amount');

         session_unregister('up_message');
         session_unregister('folder_name');
         session_unregister('business_type');

}
?>
