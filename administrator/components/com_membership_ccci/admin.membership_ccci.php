<?php
/**
* @version $Id: admin.membership_ccci.php,v 1.45 2006/12/21 11:53:06 morshed Exp $
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

       /* case 'newB':
                editMembershipB( $option, 0, $task );
                break;

        case 'newC':
                editMembershipC( $option, 0 );
                break;

        case 'preview':
                previewMembership( $option, 0 );
                break; */
        case 'edit' :
                editMembership( $option, $cid[0] );
                break;
        case 'editA':
                editMembership( $option, $id );
                break;

       /* case 'editB':
                editMembershipB( $option, $id );
                break;

        case 'editC':
                editMembershipC( $option, $id );
                break;

        case 'preview_':
                previewMembership( $option, $id );
                break; */

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
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' OR LOWER(m.member_reg_no)='$search' OR LOWER(m.tin)='$search' ) ";
        }


        $sub="mh.reg_year_id='".$_SESSION['working_reg_year_id']."' and ( mh.entry_type=1 || "
             ."\n mh.entry_type=2 )";

        // get the total number of records
        $query = "SELECT count(*) FROM #__member AS m"
                . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
                . "\n where m.is_delete=0 and $sub and m.type_id!=1 and  m.type_id!=2 "
                . (count( $where ) ? "\n and " . implode( ' AND ', $where ) : "")
                ;
        $database->setQuery( $query );
        $total = $database->loadResult();

        require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit  );

        $query = "SELECT mt.name AS type, m.applicant_title AS applicant_title,"
        ."\n m.applicant_name AS applicant_name, m.applicant_last_name AS applicant_last_name, m.id as id,"
        . "\n u.name AS editor, m.firm_name AS firm_name, m.member_reg_no as member_reg_no"
        . "\n FROM #__member AS m"
        . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
        . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
        . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
        . "\n where m.is_delete=0 and $sub and m.type_id!=1 and  m.type_id!=2 "
        . ( count( $where ) ? "\n  and " . implode( ' AND ', $where ) : "")
        . "\n ORDER BY m.firm_name"
        //. "\n ORDER BY m.member_reg_no, m.type_id"
        . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
        ;
        $database->setQuery( $query );

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
function editMembership( $option, $id ) {
        global $database, $my, $dbconn;

        MemberSessionUnregister();

        $_SESSION['last_reg_year_id']                  = $_SESSION['working_reg_year_id'];

        $lists = array();
        /*$lists['type_id']                      = mosAdminMenus::MemberType( 'type_id', 'visibility_hidden', intval( $_SESSION['type_id'] ), 1 );
        $lists['corporate_status']             = mosAdminMenus::CorporateStatus( 'corporate_status', $_SESSION['corporate_status'], 'visibility_hidden');
        $lists['last_reg_year_id']             = mosAdminMenus::RegYear( 'last_reg_year_id',  intval( $_SESSION['last_reg_year_id'] ), 'disabled' );
        $lists['proposer_1_title']             = mosAdminMenus::MemberTitle( 'proposer_1_title',$_SESSION['proposer_1_title'] );
        $lists['proposer_2_title']             = mosAdminMenus::MemberTitle( 'proposer_2_title',$_SESSION['proposer_2_title'] );
        $lists['proposer_1_designation']             = mosAdminMenus::Designation( 'proposer_1_designation',$_SESSION['proposer_1_designation'] );
        $lists['proposer_2_designation']             = mosAdminMenus::Designation( 'proposer_2_designation',$_SESSION['proposer_2_designation'] );
        $lists['applicant_title']             = mosAdminMenus::MemberTitle( 'applicant_title',$_SESSION['applicant_title'] );
        $lists['representative_title']             = mosAdminMenus::MemberTitle( 'representative_title',$_SESSION['representative_title'] );
        $lists['applicant_designation'] = mosAdminMenus::Designation( 'applicant_designation',  intval( $_SESSION['applicant_designation'] ));
        $lists['representative_designation'] = mosAdminMenus::Designation( 'representative_designation',  intval( $_SESSION['representative_designation'] ));
        $lists['principal_nominee_designation'] = mosAdminMenus::Designation( 'principal_nominee_designation',  intval( $_SESSION['principal_nominee_designation'] ));
        $lists['alt_nominee_designation'] = mosAdminMenus::Designation( 'alt_nominee_designation',  intval( $_SESSION['alt_nominee_designation'] ));
        $lists['principal_nominee_title'] = mosAdminMenus::Designation( 'principal_nominee_title',  intval( $_SESSION['principal_nominee_title'] ));
        $lists['alt_nominee_title'] = mosAdminMenus::Designation( 'alt_nominee_title',  intval( $_SESSION['alt_nominee_title'] ));
        $lists['parent']                  = mosAdminMenus::GroupAssociateList( 'parent',  intval( $_SESSION['parent'] ));
        $lists['is_memorandum_article']   = mosHTML::yesnoRadioList( 'is_memorandum_article', 'class="inputbox"', $_SESSION['is_memorandum_article'] );
        $lists['is_partnership_deed']     = mosHTML::yesnoRadioList( 'is_partnership_deed', 'class="inputbox"', $_SESSION['is_partnership_deed'] );
        */
        $javascript="onChange=\"return belongs_to();\"";
        $lists['type_id']                      = mosAdminMenus::MemberType( 'type_id', $option, intval($_SESSION['working_member_type_id']), 1,$javascript );
        $lists['corporate_status']             = mosAdminMenus::CorporateStatus( 'corporate_status', '', 'ccci');
        $lists['last_reg_year_id']             = mosAdminMenus::RegYear( 'last_reg_year_id',  $_SESSION['last_reg_year_id'], 'disabled' );
        $lists['proposer_1_title']             = mosAdminMenus::MemberTitle( 'proposer_1_title' );
        $lists['proposer_2_title']             = mosAdminMenus::MemberTitle( 'proposer_2_title' );
        $lists['proposer_1_designation']             = mosAdminMenus::Designation( 'proposer_1_designation' );
        $lists['proposer_2_designation']             = mosAdminMenus::Designation( 'proposer_2_designation' );
        $lists['applicant_title']             = mosAdminMenus::MemberTitle( 'applicant_title' );
        $lists['representative_title']             = mosAdminMenus::MemberTitle( 'representative_title' );
        $lists['applicant_designation'] = mosAdminMenus::Designation( 'applicant_designation' );
        $lists['representative_designation'] = mosAdminMenus::Designation( 'representative_designation');
        $lists['principal_nominee_designation'] = mosAdminMenus::Designation( 'principal_nominee_designation');
        $lists['alt_nominee_designation'] = mosAdminMenus::Designation( 'alt_nominee_designation');
        $lists['principal_nominee_title'] = mosAdminMenus::MemberTitle( 'principal_nominee_title');
        $lists['alt_nominee_title'] = mosAdminMenus::MemberTitle( 'alt_nominee_title');
        $lists['parent']                  = mosAdminMenus::GroupAssociateList( 'parent');
        $lists['is_memorandum_article']   = mosHTML::yesnoRadioList( 'is_memorandum_article', 'class="inputbox"',1 );
        $lists['is_partnership_deed']     = mosHTML::yesnoRadioList( 'is_partnership_deed', 'class="inputbox"',1);
        $lists['is_outside']   = mosHTML::yesnoRadioList( 'is_outside', 'class="inputbox"',0);
        $lists['business_type']             = mosAdminMenus::MultipleBusinessType( 'business_type[]','business_type' );

        //get registration date from member_reg_year table;
        $query=  "select start_date,end_date from #__member_reg_year "
                ."\n where id='".$_SESSION['last_reg_year_id']."'"
                ;
        $database->setQuery($query);
        $res=$database->loadObjectList();
        $start_date=mosHTML::ConvertDateDisplayShort($res[0]->start_date);
        $end_date=mosHTML::ConvertDateDisplayShort($res[0]->end_date);   //convert date
        $reg_id=$_SESSION['working_reg_year_id'];
        $query="select max(mh.member_reg_no) as member_reg_no"
               ."\n from #__member_history as mh"
               ."\n left join #__member as m on m.id=mh.member_id"
               ."\n where mh.reg_year_id=$reg_id and m.type_id='3'"
               ."\n group by m.type_id order by m.type_id;"
               ;
        $database->setQuery($query);
        $max_reg_no[0]=$database->loadResult();
        $query="select max(mh.member_reg_no) as member_reg_no"
               ."\n from #__member_history as mh"
               ."\n left join #__member as m on m.id=mh.member_id"
               ."\n where mh.reg_year_id=$reg_id and m.type_id='4'"
               ."\n group by m.type_id order by m.type_id;"
               ;
        $database->setQuery($query);
        $max_reg_no[1]=$database->loadResult();
        $query="select max(mh.member_reg_no) as member_reg_no"
               ."\n from #__member_history as mh"
               ."\n left join #__member as m on m.id=mh.member_id"
               ."\n where mh.reg_year_id=$reg_id and m.type_id='5'"
               ."\n group by m.type_id order by m.type_id;"
               ;
        $database->setQuery($query);
        $max_reg_no[2]=$database->loadResult();
        HTML_Membership::editMembership( $lists, $option, $id, $start_date, $end_date, $max_reg_no);
}


/**
* Saves the record on an edit form submit
* @param database A database connector object
*/
function saveMembership( $option, $id ) {
        global $database, $my, $dbconn, $mosConfig_absolute_path;

        $current_date_time = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];
        $image_path="./administrator/images/photograph/";
        $_SESSION['working_member_type_id'] = $_REQUEST['type_id'];
         // Query for check duplicate Member Registration Number
        $query="select mh.member_reg_no from #__member_history as mh"
                ."\n join #__member as m on m.id=mh.member_id"
                ."\n join #__member_type as mt on mt.id=m.type_id"
                ."\n where mh.member_reg_no='".$_POST['member_reg_no']."'"
                ."\n and mh.reg_year_id='".$_SESSION['working_reg_year_id']."' and m.type_id='".$_POST['type_id']."'"
                ;

        $query  =  $database->replaceTablePrefix($query);
        $result=mysql_query($query) or die(mysql_error());
        if (intval($_POST['member_reg_no'])!=0 && mysql_num_rows($result)>0){
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

         if(isset($_FILES['up_file'])){
                 global $mosConfig_absolute_path;
                 $old_image=trim($_SESSION['applicant_photograph']);
                 $image=trim($mosConfig_absolute_path."/administrator/images/photograph/".$id."/".$old_image);

                 if(!file_exists($mosConfig_absolute_path."/administrator/images/photograph/".$id."/")){
                         mkdir($mosConfig_absolute_path."/administrator/images/photograph/".$id."/",0777);
                 }else{
                         chmod($mosConfig_absolute_path."/administrator/images/photograph/".$id,0777);
                 }
                 if($old_image!="" && file_exists($image))
                         @unlink($image);
                 $con=upload();
                 echo $_SESSION['up_message'];
          }

        // by mizan
        $type_id=$_POST['type_id'];
        $parent=$_POST['parent'];// Belongs to
        $last_reg_year_id=$_POST['last_reg_year_id'];
        $member_reg_no=$_POST['member_reg_no'];
        $reg_date=mosHTML::ConvertDateForDatatbase($_POST['reg_date']);

        $money_receipt_no=$_POST['money_receipt_no'];
        $money_receipt_date=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
        //$date_of_formation=mosHTML::ConvertDateForDatatbase($_POST['date_of_formation']);
        $corporate_status=$_POST['corporate_status'];
        $establishment_year=$_POST['establishment_year'];
        $is_memorandum_article=$_POST['is_memorandum_article'];
        $is_partnership_deed=$_POST['is_partnership_deed'];

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

        $trade_licence_no=$_POST['trade_licence_no'];
        $trade_licence_issued_by=$_POST['trade_licence_issued_by'];
        $trade_licence_issue_date=mosHTML::ConvertDateForDatatbase($_POST['trade_licence_issue_date']);
        $trade_licence_expire_date=mosHTML::ConvertDateForDatatbase($_POST['trade_licence_expire_date']);
        $tin=$_POST['tin'];

        $import_reg_no=$_POST['import_reg_no'];
        $export_reg_no=$_POST['export_reg_no'];
        $indenting_trade_no=$_POST['indenting_trade_no'];
        $bank_name=$_POST['bank_name'];
        $bank_address=$_POST['bank_address'];

        $proposer_1_title=$_POST['proposer_1_title'];
        $proposer_1_name=$_POST['proposer_1_name'];
        $proposer_1_last_name=$_POST['proposer_1_last_name'];
        $proposer_1_designation=$_POST['proposer_1_designation'];
        $proposer_1_firm_name=$_POST['proposer_1_firm_name'];
        $proposer_2_title=$_POST['proposer_2_title'];
        $proposer_2_name=$_POST['proposer_2_name'];
        $proposer_2_last_name=$_POST['proposer_2_last_name'];
        $proposer_2_designation=$_POST['proposer_2_designation'];
        $proposer_2_firm_name=$_POST['proposer_2_firm_name'];

        $principal_nominee_title=$_POST['principal_nominee_title'];
        $principal_nominee_name=$_POST['principal_nominee_name'];
        $principal_nominee_last_name=$_POST['principal_nominee_last_name'];
        $principal_nominee_designation=$_POST['principal_nominee_designation'];
        $alt_nominee_title=$_POST['alt_nominee_title'];
        $alt_nominee_name=$_POST['alt_nominee_name'];
        $alt_nominee_last_name=$_POST['alt_nominee_last_name'];
        $alt_nominee_designation=$_POST['alt_nominee_designation'];

        $applicant_title=$_POST['applicant_title'];
        $applicant_name=$_POST['applicant_name'];
        $applicant_last_name=$_POST['applicant_last_name'];
        $applicant_designation=$_POST['applicant_designation'];
        $applicant_photograph=$_SESSION['applicant_photograph'];
        $representative_title=$_POST['representative_title'];
        $representative_name=$_POST['representative_name'];
        $representative_last_name=$_POST['representative_last_name'];
        $representative_designation=$_POST['representative_designation'];

        $is_outside=$_POST['is_outside'];

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
                                 .",representative_last_name,representative_designation,establishment_year"
                                 .",bank_name,bank_address,trade_licence_issued_by"
                                 .",trade_licence_no,trade_licence_issue_date,trade_licence_expire_date"
                                 .",principal_nominee_title,principal_nominee_name,principal_nominee_last_name"
                                 .",principal_nominee_designation,alt_nominee_title,alt_nominee_name"
                                 .",alt_nominee_last_name,alt_nominee_designation"
                                 .",money_receipt_no,money_receipt_date,import_reg_no,export_reg_no"
                                 .",indenting_trade_no,tin,reg_date,last_reg_date,date"
                                 .",is_memorandum_article,is_partnership_deed,proposer_1_firm_name"
                                 .",proposer_1_title,proposer_1_name,proposer_1_last_name"
                                 .",proposer_1_designation,proposer_2_firm_name,proposer_2_title"
                                 .",proposer_2_name,proposer_2_last_name,proposer_2_designation"
                                 .",parent,is_outside)"
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
                                 ."','".$representative_last_name."','".$representative_designation."','".$establishment_year
                                 ."','".$bank_name."','".$bank_address."','".$trade_licence_issued_by
                                 ."','".$trade_licence_no."','".$trade_licence_issue_date."','".$trade_licence_expire_date
                                 ."','".$principal_nominee_title."','".$principal_nominee_name."','".$principal_nominee_last_name
                                 ."','".$principal_nominee_designation."','".$alt_nominee_title."','".$alt_nominee_name
                                 ."','".$alt_nominee_last_name."','".$alt_nominee_designation
                                 ."','".$money_receipt_no."','".$money_receipt_date ."','".$import_reg_no
                                 ."','".$export_reg_no."','".$indenting_trade_no."','".$tin."','".$reg_date
                                 ."','".$reg_date."','".$current_date_time
                                 ."','".$is_memorandum_article."','".$is_partnership_deed."','".$proposer_1_firm_name
                                 ."','".$proposer_1_title."','".$proposer_1_name."','".$proposer_1_last_name
                                 ."','".$proposer_1_designation."','".$proposer_2_firm_name."','".$proposer_2_title
                                 ."','".$proposer_2_name."','".$proposer_2_last_name."','".$proposer_2_designation
                                 ."','".$parent."','".$is_outside."')";



                      $sql_query  =  $database->replaceTablePrefix($sql_query);

                      $msg="Failed to Add Member Information";

                      if(!mysql_query($sql_query)) {
                           mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }
                      $insert_id = mysql_insert_id($dbconn->connection);

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
                             .",is_voter,money_receipt_no,date,user_id,reg_date)"
                             ." values('".$insert_id."','1','".$_SESSION['last_reg_year_id']
                             ."','".$member_reg_no."','1','".$money_receipt_no
                             ."','".$current_date_time."','".$user_id."','".$reg_date."')";

                      $query  =  $database->replaceTablePrefix($query);

                      $msg="Failed to Add Member History";
                      if(!mysql_query($query)) {
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                           mosRedirect( "index2.php?option=$option&task=new&id=".$id."&mosmsg=".$msg );
                      }

                        // Account Transaction start
                          $reference_id=$database->insertid();
                          //get maximum transaction no from database
                          $sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
                          $database->setQuery($sql_trans);
                          $transaction_no=($database->loadResult()+1);

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
                         mosRedirect( "index2.php?option=$option&task=new&id=".$id."&mosmsg=".$msg );
                         }
                        // Accounts Transaction end
                      /*
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
                      */
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
        mosRedirect( "index2.php?option=$option&mosmsg=".$msg );

}


function upload(){

        global $mosConfig_absolute_path, $id;
        $image_path=$mosConfig_absolute_path."/administrator/images/photograph/";
        if($id>0)
           $folder_name=$id;
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
                     $_SESSION['applicant_photograph']=$file['name'];
                     $return=true;
             }
             else
               $return=false;
        }
        return $return;
}
/*
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
                else if (!move_uploaded_file($file['tmp_name'][0], $dest_dir.$file['name'][0])){
                        $_SESSION['up_message']="Upload FAILED FOR APPLICANT PHOTOGRAPH " ;
                        $up=false;
                }
                else {
                        mosChmod($dest_dir.$file['name'][0]);
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
                    else if (!move_uploaded_file($file['tmp_name'][1], $dest_dir.$file['name'][1])){
                            $_SESSION['up_message']="Upload FAILED FOR RRPRESENTATIVE PHOTOGRAPH " ;
                            $up=false;
                    }
                    else {
                            mosChmod($dest_dir.$file['name'][1]);
                            $_SESSION['up_message']="Upload complete";
                            $up=true;
                    }
                }

        $clearUploads = true;
        return $up;
}
*/
function do_upload($file, $dest_dir)
{
        global $clearUploads;

                if (file_exists($dest_dir.$file['name'])) {
                        $_SESSION['up_message']="Upload FAILED : File allready exists";
                        $up=false;
                }
                if (strcasecmp(substr($file['name'],-4),".jpg"))  {
                        $_SESSION['up_message']="Only file type .jpg can be uploaded";
                        $up=false;
                }
                if ($file['name']=="") {
                        $_SESSION['up_message'] = "";
                        $up=false;
                }
                else if (!move_uploaded_file($file['tmp_name'], $dest_dir.strtolower($file['name']))){
                        $_SESSION['up_message']="Upload FAILED" ;
                        $up=false;

                }
                else {
                        mosChmod($dest_dir.$file['name']);
                        $_SESSION['up_message']="Upload complete";
                        $up=true;
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

         session_unregister('last_reg_year_id');
         session_unregister('up_message');
         session_unregister('folder_name');
         session_unregister('applicant_photograph');
         session_unregister('business_type');
}
?>
