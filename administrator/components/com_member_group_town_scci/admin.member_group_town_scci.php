<?php
/**
* @version $Id: admin.member_group_town_scci.php,v 1.25 2006/06/18 09:30:05 morshed Exp $
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
$option         = mosGetParam( $_REQUEST, 'option', $_REQUEST['option'] );
$cid            = mosGetParam( $_REQUEST, 'cid', array(0) );
$id = mosGetParam( $_REQUEST, 'id' );
if (!is_array( $cid )) {
        $cid = array(0);
}

switch ($task) {
        case 'new':
                editMemberGroup_Town( 0, $section,$option );
                break;

        case 'edit':
                editMemberGroup_Town( intval( $cid[0] ),$option );
                break;

        case 'editA':
                editMemberGroup_Town( intval( $id ),$option );
                break;

        case 'save':
                saveMemberGroup_Town( $id,$option);
                break;

        case 'remove':
                removeMemberGroup_Town( $section, $cid,$option );
                break;

         case 'cancel':
                cancelMemberGroup_Town();
                break;

        default:
                showMemberGroup_Town( $section, $option );
                break;
}

/**
* Compiles a list of categories for a section
* @param string The name of the category section
*/
function showMemberGroup_Town( $section, $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

        //$sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
        $search_type_id = $_POST['search_type_id'];
        $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
        $search = $database->getEscaped( trim( strtolower( $search ) ) );

        $where = array();

        if ($search_type_id > 0) {
                $where[] = "m.type_id='$search_type_id'";
        }
        if ($search) {
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' || LOWER(m.member_reg_no) = '$search' )";
        }

        $sub="(( mh.entry_type=1 and mh.reg_year_id='".$_SESSION['working_reg_year_id']."' )"
             ."\n || ( mh.entry_type=2 and mh.reg_year_id='".$_SESSION['working_reg_year_id']."' ))";

        // get the total number of records
         $query = "SELECT count(*) FROM #__member AS m"
           . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
           . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
           . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
           . ( count( $where ) ? " and m.is_delete=0 and $sub " : " where m.is_delete=0 and $sub " )
           . "\n and (m.type_id=1 || m.type_id=2)"
           . "\n  ORDER BY m.member_reg_no, mt.id"
           ;
        $database->setQuery( $query );
        $total = $database->loadResult();

        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        $query = "SELECT m.id as id, mt.name AS type, m.firm_name as firm_name"
           . "\n ,m.representative_title as representative_title,m.representative_name as representative_name"
           . "\n ,m.representative_last_name as representative_last_name"
           . "\n ,mh.member_reg_no as member_reg_no FROM #__member AS m"
           . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
           . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
           . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
           . ( count( $where ) ? " and m.is_delete=0 and $sub " : " where m.is_delete=0 and $sub " )
           . "\n and (m.type_id=1 || m.type_id=2)"
           . "\n  ORDER BY m.member_reg_no, mt.id"
           . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
           ;

        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return;
        }

        $lists=array();
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['search_type_id']                   = mosAdminMenus::MemberType( 'search_type_id', $option, intval( $search_type_id ), 2, $javascript);
        HTML_MemberGroup_Town::show( $rows, $pageNav, $lists);
}

/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function editMemberGroup_Town( $id=0, $option ) {
        global $database, $my,$dbconn;
        MemberSessionUnregister();
        if($id!=0){
              $sql_query = "select * from #__member where id ='$id'";
              $sql_query  =  $database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $row =& $res->fetchRow();
              $selected_type_id=$row->type_id;
              $representative_designation=$row->representative_designation;
              $_SESSION['applicant_photograph']=$row->applicant_photograph;
              $_SESSION['representative_photograph']=$row->representative_photograph;
              $selected_location=$row->location;
              //get registration year from member_history table;
                     $query= "select id from #__member_history "
                            ."\n where member_id='$id' and entry_type='1'"
                            ;
                     $database->setQuery($query);
                     $_SESSION['last_reg_year_id']=$database->loadResult();

                     //get member registration no. from member_history table;
                     $query= "select mh.member_reg_no from #__member_history as mh"
                            ."\n join #__member as m on m.id=mh.member_id"
                            ."\n where m.id='$id'"
                            ;
                     $database->setQuery($query);
                     $_SESSION['member_reg_no']=$database->loadResult();

                     //get money receipt no. from member_trail table;
                     $query= "select mt.money_receipt_no from #__member_trail as mt"
                            ."\n join #__member as m on m.id=mt.member_id"
                            ."\n where m.id='$id'"
                            ;
                     $database->setQuery($query);
                     $_SESSION['money_receipt_no']=$database->loadResult();

                     //Registration year
                     $query1= "select mh.reg_year_id as reg_year_id from #__member_history as mh "
                            ." where mh.entry_type='1' and mh.member_id='$id' ";
                     $query1  =  $database->replaceTablePrefix($query1);
                     $res1 =mysql_query($query1);
                     $row1=mysql_fetch_array($res1);
                     $_SESSION['last_reg_year_id']=$row1["reg_year_id"];
                     /*
                     // business type
                     $query="select business_type as id from #__member_business_type where member_id='$id'";
                     $query  =  $database->replaceTablePrefix($query);
                     $res =mysql_query($query);
                     $i=0;
                     while($row=mysql_fetch_array($res)){
                        $business_type[$i]=$row["id"];
                        $i++;
                     }
                     $_SESSION['business_type'] =$business_type;
                     */

        }
        else{
          $row->id=0;
          $representative_designation=8;
          $_SESSION['applicant_photograph']='';
          $_SESSION['representative_photograph']='';
          //$is_memorandum_article=0;
          //$is_registration_certificate=0;
        }
          $_SESSION['last_reg_year_id']                  = $_SESSION['working_reg_year_id'];





        //$row = new mosMember_reg_year( $database );
        // load the row from the db table
        //$row->load( $uid );

        // fail if checked out not by 'me'
        if ($row->checked_out && $row->checked_out <> $my->id) {
                mosRedirect( "index2.php?option=".$option.", The firm ". $row->name ." is currently being edited by another administrator" );
        }
        $javascript="onChange=\"return belongs_to();\"";
        $lists = array();
        $lists['type_id']= mosAdminMenus::MemberType( 'type_id', $option, $selected_type_id, 2,$javascript );
        $lists['country_id']= mosAdminMenus::CountryList( 'country_id' );
        //$lists['location']= mosAdminMenus::Location( 'location',$selected_location );
        //$lists['payment_mode']= mosAdminMenus::PaymentMode( 'payment_mode',$selected_payment_mode);
        //$lists['is_memorandum_article']= mosHTML::yesnoRadioList( 'is_memorandum_article', 'class="inputbox"',$is_memorandum_article );
        //$lists['is_registration_certificate']= mosHTML::yesnoRadioList( 'is_registration_certificate', 'class="inputbox"',$is_registration_certificate );
        $lists['last_reg_year_id']          = mosAdminMenus::RegYear( 'last_reg_year_id',  intval( $_SESSION['last_reg_year_id'] ), 'disabled' );
        $lists['representative_designation'] = mosAdminMenus::Designation( 'representative_designation',  $representative_designation);
        $lists['applicant_designation'] = mosAdminMenus::Designation( 'applicant_designation',  $row->applicant_designation);
        $lists['location']             = mosAdminMenus::Location( 'location',$selected_location );
        $lists['proposer1_title']             = mosAdminMenus::MemberTitle( 'proposer1_title',$_SESSION['proposer1_title'] );
        $lists['proposer2_title']             = mosAdminMenus::MemberTitle( 'proposer2_title',$_SESSION['proposer2_title'] );
        $lists['applicant_title']             = mosAdminMenus::MemberTitle( 'applicant_title',$_SESSION['applicant_title'] );
        $lists['representative_title']             = mosAdminMenus::MemberTitle( 'representative_title',$_SESSION['representative_title'] );


        //get registration date from member_reg_year table;
        $query=  "select start_date,end_date from #__member_reg_year "
                ."\n where id='".$_SESSION['last_reg_year_id']."'"
                ;
        $database->setQuery($query);
        $res=$database->loadObjectList();
        $start_date=mosHTML::ConvertDateDisplayShort($res[0]->start_date);
        $end_date=mosHTML::ConvertDateDisplayShort($res[0]->end_date);   //convert date

        HTML_MemberGroup_Town::edit( $row, $lists, $id, $start_date, $end_date);
}

/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/

function saveMemberGroup_Town( $id,$option ) {
        global $database,$dbconn;

        $current_date_time = date( "Y-m-d H:i:s" );
        $date = date( "Y-m-d H:i:s" );
        $is_delete=0;

        $user_id=$_SESSION['session_username'];
        $image_path="./administrator/images/photograph/";

        // Query for check duplicate Member Registration Number
        $query="select mh.member_reg_no from #__member_history as mh"
                ."\n join #__member as m on m.id=mh.member_id"
                ."\n join #__member_type as mt on mt.id=m.type_id"
                ."\n where mh.member_reg_no='".$_POST['member_reg_no']."'"
                ."\n and is_delete=0 and m.type_id='".$_POST['type_id']."'"
                ;

        $query  =  $database->replaceTablePrefix($query);
        $result=mysql_query($query) or die(mysql_error());
        if ($_SESSION['member_reg_no']!=$_POST['member_reg_no']){
             if (mysql_num_rows($result)>0){
                    //echo "<script> alert(Money Receipt No ".$money_receipt_no." Already Exist); window.history.go(-1); </script>\n";
                    //exit();
                    $msg="Membership No. ".$_POST['member_reg_no']." Already Exist";
                    mosRedirect( "index2.php?option=$option&task=editA&id=".$id."&mosmsg=".$msg );
             }
        }

         // Query for check duplicate Money Receipt Number
        $sql_query2="select * from #__member_trail where money_receipt_no ='".$_POST['money_receipt_no']."'";
        $database->setQuery($sql_query2);
        $total_row=$database->loadResult();
        if ($_SESSION['money_receipt_no']!=$_POST['money_receipt_no']){
              if(count($total_row)>0 ) {
                 //echo "<script> alert('This Money Receipt No is already Exist\'s'); window.history.go(-1); </script>\n";
                 //exit();
                 $msg="Money Receipt No. ".$_POST['money_receipt_no']." Already Exist";
                 mosRedirect( "index2.php?option=$option&task=editA&id=".$id."&mosmsg=".$msg );
              }
        }

        if(isset($_FILES['up_file'])){
                 global $mosConfig_absolute_path;
                 $old_image=trim($_SESSION['applicant_photograph']);
                 $representative_old_image=trim($_SESSION['representative_photograph']);
                 $image=trim($mosConfig_absolute_path."/administrator/images/photograph/".$id."/".$old_image);
                 $representative_image=trim($mosConfig_absolute_path."/administrator/images/photograph/".$id."/".$representative_old_image);

                 $con=upload();

                 if($old_image!="" && file_exists($image) && !empty($_SESSION['applicant_photograph1']))
                         @unlink($image);
                 if($representative_old_image!="" && file_exists($representative_image) && !empty($_SESSION['representative_photograph1']) && $old_image!=$representative_old_image)
                         @unlink($representative_image);
                 elseif ($representative_old_image!="" && file_exists($representative_image) && $_POST['check_propietor_information']=="on" && $old_image!=$representative_old_image)
                         @unlink($representative_image);

                 echo $_SESSION['up_message'];
        }

        $type_id=$_POST['type_id'];
        $member_reg_no=$_POST['member_reg_no'];
        $reg_date=mosHTML::ConvertDateForDatatbase($_POST['reg_date']);
        $money_receipt_no=$_POST['money_receipt_no'];
        $money_receipt_date=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
        $location=$_POST['location'];

        $date_of_formation=mosHTML::ConvertDateForDatatbase($_POST['date_of_formation']);
        $rules_of_formation=$_POST['rules_of_formation'];
        $statement_of_association=$_POST['statement_of_association'];
        $bank_name=$_POST['bank_name'];
        $bank_address=$_POST['bank_address'];
        $type_of_business=$_POST['type_of_business'];

        $firm_name=$_POST['firm_name'];
        $firm_reg_address_street=$_POST['firm_reg_address_street'];
        $firm_reg_address_town_suburb=$_POST['firm_reg_address_town_suburb'];
        $firm_reg_address_district=$_POST['firm_reg_address_district'];
        $firm_reg_address_division=$_POST['firm_reg_address_division'];
        $firm_reg_address_country=$_POST['firm_reg_address_country'];
        $firm_phone=$_POST['firm_phone'];
        $firm_fax=$_POST['firm_fax'];
        $firm_mobile=$_POST['firm_mobile'];
        $firm_email=$_POST['firm_email'];
        $firm_web=$_POST['firm_web'];

        $head_office_address_street=$_POST['head_office_address_street'];
        $head_office_address_town_suburb=$_POST['head_office_address_town_suburb'];
        $head_office_address_district=$_POST['head_office_address_district'];
        $head_office_address_division=$_POST['head_office_address_division'];
        $head_office_address_country=$_POST['head_office_address_country'];
        $head_office_phone=$_POST['head_office_phone'];
        $head_office_fax=$_POST['head_office_fax'];
        $head_office_mobile=$_POST['head_office_mobile'];
        $head_office_email=$_POST['head_office_email'];
        $head_office_web=$_POST['head_office_web'];

        $type_of_business=$_POST['type_of_business'];
        $rules_of_formation=$_POST['rules_of_formation'];
        $statement_of_association=$_POST['statement_of_association'];

        $applicant_title=$_POST['applicant_title'];
        $applicant_name=$_POST['applicant_name'];
        $applicant_last_name=$_POST['applicant_last_name'];
        $applicant_designation=$_POST['applicant_designation'];

        if (!empty($_SESSION['applicant_photograph1']))
            $applicant_photograph=$_SESSION['applicant_photograph1'];
        elseif (empty($_SESSION['applicant_photograph1']))
            $applicant_photograph=$_SESSION['applicant_photograph'];

        $representative_title=$_POST['representative_title'];
        $representative_name=$_POST['representative_name'];
        $representative_last_name=$_POST['representative_last_name'];
        $representative_designation=$_POST['representative_designation'];
        //$representative_photograph=$_SESSION['representative_photograph1'];
        if (empty($_SESSION['representative_photograph1']) && $_POST['check_propietor_information']=="on")
            $representative_photograph=$applicant_photograph;
        elseif (!empty($_SESSION['representative_photograph1']) && $_POST['check_propietor_information']=="on")
            $representative_photograph=$_SESSION['representative_photograph1'];
        elseif (!empty($_SESSION['representative_photograph1']) && $_POST['check_propietor_information']!="on")
            $representative_photograph=$_SESSION['representative_photograph1'];
        elseif (empty($_SESSION['representative_photograph1']) && $_POST['check_propietor_information']!="on")
            $representative_photograph=$_SESSION['representative_photograph'];

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

        $country_id =18;
        $is_voter=0;
        $amount=$_POST['amount'];


        if($id==0){
               /* $sql="select id from #__member where firm_name='$firm_name'";
                $sql  =  $database->replaceTablePrefix($sql);
                $res=mysql_query($sql);
                if(mysql_num_rows($res)==0){  */
                   $sql_query= "insert into #__member (type_id,member_reg_no,reg_date,last_reg_date"
                                 .",money_receipt_no,money_receipt_date"
                                 .",location,type_of_business,date_of_formation"
                                 .",rules_of_formation,statement_of_association,bank_name,bank_address"
                                 .",firm_name,firm_reg_address_street"
                                 .",firm_reg_address_town_suburb,firm_reg_address_district,firm_reg_address_division"
                                 .",firm_reg_address_country,firm_phone,firm_fax,firm_email,firm_web,firm_mobile"
                                 .",head_office_address_street,head_office_address_town_suburb"
                                 .",head_office_address_district,head_office_address_division"
                                 .",head_office_address_country,head_office_phone,head_office_fax"
                                 .",head_office_email,head_office_web,head_office_mobile"
                                 .",applicant_title,applicant_name,applicant_last_name"
                                 .",applicant_designation,applicant_photograph"
                                 .",representative_title,representative_name,representative_last_name"
                                 .",representative_designation,representative_photograph"
                                 .",proposer1_address,proposer1_title,proposer1_name"
                                 .",proposer1_last_name,proposer1_member_reg_no,proposer1_firm_name"
                                 .",proposer2_address,proposer2_title,proposer2_name"
                                 .",proposer2_last_name,proposer2_member_reg_no,proposer2_firm_name"
                                 .",date) "
                                 ." values ('". $type_id."','".$member_reg_no."','".$reg_date
                                 ."','".$last_reg_date."','".$money_receipt_no."','".$money_receipt_date
                                 ."','".$location."','".$type_of_business."','".$date_of_formation
                                 ."','".$rules_of_formation."','".$statement_of_association."','".$bank_name
                                 ."','".$bank_address."','".$firm_name
                                 ."','".$firm_reg_address_street."','".$firm_reg_address_town_suburb
                                 ."','".$firm_reg_address_district."','".$firm_reg_address_division
                                 ."','".$firm_reg_address_country."','".$firm_phone."','". $firm_fax
                                 ."','".$firm_email."','".$firm_web."','".$firm_mobile
                                 ."','".$head_office_address_street."','".$head_office_address_town_suburb
                                 ."','".$head_office_address_district."','".$head_office_address_division
                                 ."','".$head_office_address_country."','".$head_office_phone."','". $head_office_fax
                                 ."','".$head_office_email."','".$head_office_web."','".$head_office_mobile
                                 ."','".$applicant_title."','".$applicant_name."','".$applicant_last_name
                                 ."','".$applicant_designation."','".$applicant_photograph
                                 ."','".$representative_title."','".$representative_name."','".$representative_last_name
                                 ."','".$representative_designation."','".$representative_photograph
                                 ."','".$proposer1_firm_name."','".$proposer1_title."','".$proposer1_name
                                 ."','".$proposer1_last_name."','".$proposer1_member_reg_no."','".$proposer1_firm_name
                                 ."','".$proposer2_firm_name."','".$proposer2_title."','".$proposer2_name
                                 ."','".$proposer2_last_name."','".$proposer2_member_reg_no."','".$proposer2_firm_name
                                 ."','".$date."')";

                   $sql_query  =  $database->replaceTablePrefix($sql_query);
                   if(!mysql_query($sql_query)) {
                      $msg="Failed to Add Member Profile, please try again." ;
                      mosRedirect( "index2.php?option=".$option."&task=editA&mosmsg=". $msg );
                      //echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                      exit();
                   }
                   /// keep record history of data inserting into member history table
                   $insert_id = mysql_insert_id($dbconn->connection);

                   //photograph upload

                   $applicant_photograph=$_SESSION['applicant_photograph1'];
                   @rename("./images/photograph/".$_SESSION['folder_name'],"./images/photograph/".$insert_id);

                      $query="insert into #__member_history (member_id,entry_type,reg_year_id,member_reg_no"
                              .",is_voter,money_receipt_no,amount,date,user_id,reg_date,money_receipt_date)"
                              ."\n values('".$insert_id."','1','".$_SESSION['last_reg_year_id']
                              ."','".$member_reg_no."','1','".$money_receipt_no."','".$amount
                              ."','".$current_date_time."','".$user_id."','".$reg_date."','".$money_receipt_date."')";

                      $query  =  $database->replaceTablePrefix($query);

                      $msg="Failed to Add Member History";
                      if(!mysql_query($query)) {
                           mosRedirect( "index2.php?option=".$option."&task=editA&id=".$id."&mosmsg=".$msg );
                      }

                      //account transaction
                      $reference_id=mysql_insert_id($dbconn->connection);
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
                      $date1=date( "Y-m-d" );
                      $account_query1="insert into #__account_transaction values('','$transaction_no','101','$admision_fee','0','$reference_id','$money_receipt_date','$date1')";
                      $account_query1=$database->replaceTablePrefix($account_query1);
                      $account_query2="insert into #__account_transaction values('','$transaction_no','1','$admision_fee','1','$reference_id','$money_receipt_date','$date1')";
                      $account_query2=$database->replaceTablePrefix($account_query2);

                      $transaction_no=$transaction_no+1;
                      $account_query3="insert into #__account_transaction values('','$transaction_no','100','$yearly_subscription_fee','0','$reference_id','$money_receipt_date','$date1')";
                      $account_query3=$database->replaceTablePrefix($account_query3);
                      $account_query4="insert into #__account_transaction values('','$transaction_no','1','$yearly_subscription_fee','1','$reference_id','$money_receipt_date','$date1')";
                      $account_query4=$database->replaceTablePrefix($account_query4);

                      if(!(mysql_query($account_query1) && mysql_query($account_query2) && mysql_query($account_query3) && mysql_query($account_query4)  ))
                      {
                           echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                           exit();
                      }

                      /// keep record of data inserting into member trail table
                      if(!$database->addMemberTrail($insert_id,'1',$user_id,'','0',$money_receipt_no)){
                           $msg="Incorrect Member Trail Information";
                           mosRedirect( "index2.php?option=".$option."&task=editA&id=".$id."&mosmsg=".$msg );
                      }

              /*  }else{
                      //echo "<script> alert('Member Type Already exist\'s'); window.history.go(-1); </script>\n";

                      $msg="Member with that name, please try again.";
                      mosRedirect( "index2.php?option=".$option."&task=editA&mosmsg=". $msg );
                      exit();
                }    */
                $msg="Member Profile Added Successfully";
                mosRedirect( "index2.php?option=".$option."&mosmsg=".$msg );

        }
        else{
                //$sql="select id from #__member where firm_name='$firm_name' and id!='$id' and is_delete=0";
                //$sql  =  $database->replaceTablePrefix($sql);
                //$res=mysql_query($sql);
               // if(mysql_num_rows($res)==0){
                  $sql_query = "update #__member set type_id='$type_id',"
                               ."member_reg_no='$member_reg_no',"
                               ."money_receipt_no='$money_receipt_no',"
                               ."money_receipt_date='$money_receipt_date',"
                               ."location='$location',"
                               ."reg_date='$reg_date',"
                               ."type_of_business='$type_of_business',"
                               ."date_of_formation='$date_of_formation',"
                               ."rules_of_formation='$rules_of_formation',"
                               ."statement_of_association='$statement_of_association',"
                               ."bank_name='$bank_name',"
                               ."bank_address='$bank_address',"
                               ."firm_name='$firm_name',"
                               ."firm_reg_address_street='$firm_reg_address_street',"
                               ."firm_reg_address_town_suburb='$firm_reg_address_town_suburb',"
                               ."firm_reg_address_district='$firm_reg_address_district',"
                               ."firm_reg_address_division='$firm_reg_address_division',"
                               ."firm_reg_address_country='$firm_reg_address_country',"
                               ."firm_phone='$firm_phone',firm_fax='$firm_fax',"
                               ."firm_email='$firm_email',firm_web='$firm_web',firm_mobile='$firm_mobile',"
                               ."head_office_address_street='$head_office_address_street',"
                               ."head_office_address_town_suburb='$head_office_address_town_suburb',"
                               ."head_office_address_district='$head_office_address_district',"
                               ."head_office_address_division='$head_office_address_division',"
                               ."head_office_address_country='$head_office_address_country',"
                               ."head_office_phone='$head_office_phone',head_office_fax='$head_office_fax',"
                               ."head_office_email='$head_office_email',head_office_web='$head_office_web',"
                               ."head_office_mobile='$head_office_mobile',"
                               ."applicant_title='$applicant_title',"
                               ."applicant_name='$applicant_name',"
                               ."applicant_last_name='$applicant_last_name',"
                               ."applicant_designation='$applicant_designation',"
                               ."applicant_photograph='$applicant_photograph',"
                               ."representative_title='$representative_title',"
                               ."representative_name='$representative_name',"
                               ."representative_last_name='$representative_last_name',"
                               ."representative_designation='$representative_designation',"
                               ."representative_photograph='$representative_photograph',"
                               ."proposer1_title='$proposer1_title',"
                               ."proposer1_name='$proposer1_name',"
                               ."proposer1_last_name='$proposer1_last_name',"
                               ."proposer1_address='$proposer1_address',"
                               ."proposer1_member_reg_no='$proposer1_member_reg_no',"
                               ."proposer1_firm_name='$proposer1_firm_name',"
                               ."proposer2_title='$proposer2_title',"
                               ."proposer2_name='$proposer2_name',"
                               ."proposer2_last_name='$proposer2_last_name',"
                               ."proposer2_address='$proposer2_address',"
                               ."proposer2_member_reg_no='$proposer2_member_reg_no',"
                               ."proposer2_firm_name='$proposer2_firm_name',"
                               ."date='$date'"
                               ." where id ='$id'";

                     $database->setQuery( $sql_query );
                     if(!$database->query()) {
                        $msg="Failed to Update Member Profile, please try again.";
                        mosRedirect( "index2.php?option=".$option."&task=editA&id=".$id."&mosmsg=". $msg );
                        //echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                        exit();
                     }

                      // keep record of data updating of  member trail table
                      if(!$database->addMemberTrail($id,'3',$user_id,'','',$_POST['money_receipt_no'])){
                           $msg="Incorrect Member Trail Information";
                           mosRedirect( "index2.php?option=".$option."&id=".$id."&mosmsg=".$msg );
                      }

                      //update money receipt number if changed
                     if ($_SESSION['money_receipt_no']!=$_POST['money_receipt_no']){
                            //update history table
                            $query1="update #__member_history set money_receipt_no='".$_POST['money_receipt_no']
                             ."' where money_receipt_no='".$_SESSION['money_receipt_no']."' ";
                            $database->setQuery($query1);
                            $con1=$database->query();

                            $query2="update #__member_trail set money_receipt_no='".$_POST['money_receipt_no']
                             ."' where money_receipt_no='".$_SESSION['money_receipt_no']."' ";
                            $database->setQuery($query2);
                            $con2=$database->query();

                            $query3="update #__member_certificate set money_receipt_no='".$_POST['money_receipt_no']
                             ."' where money_receipt_no='".$_SESSION['money_receipt_no']."' ";
                            $database->setQuery($query3);
                            $con3=$database->query();

                            //if($con1!=1 )
                       }


                      //update history table
                      // keep record of data updating of  member table in t5he member history table
                      $query="update #__member_history set "
                             ."member_reg_no='$member_reg_no',"
                             ."money_receipt_no='".$_POST['money_receipt_no']."',"
                             ."reg_date='$reg_date'"
                             ." where member_id='$id' and entry_type='1'";
                      $query  =  $database->replaceTablePrefix($query);

                      $msg="Failed to Update Member History";

                      if(!mysql_query($query)) {
                           mosRedirect( "index2.php?option=".$option."&id=".$id."&mosmsg=".$msg );
                      }

                      $msg="Member Profile Updated Successfully";
                      mosRedirect( "index2.php?option=".$option."&mosmsg=".$msg );
               /* }
                else{
                    //echo "<script> alert('Member Type Already exist\'s'); window.history.go(-1); </script>\n";
                    $msg="Member already with that name, please try again.";
                    mosRedirect( "index2.php?option=".$option."&task=editA&id=".$id."&mosmsg=". $msg );
                    exit();
                }   */
                $msg="Member Profile Updated Successfully";
        }

        $row->checkin();
        mosRedirect( "index2.php?option=".$option."&mosmsg=".$msg );
}

/**
* Deletes one or more categories from the categories table
* @param string The name of the category section
* @param array An array of unique category id numbers
*/
function removeMemberGroup_Town( $section, $cid,$option ) {
        global $database;

        if (count( $cid ) < 1) {
                echo "<script> alert('Select a industry to delete'); window.history.go(-1);</script>\n";
                exit;
        }

        if (count( $cid )) {
                $cids = implode( ',', $cid );
                $sql="select id from #__member where is_delete=0 and parentid IN ($cids)";
                $sql  =  $database->replaceTablePrefix($sql);
                $res=mysql_query($sql);

                if (mysql_num_rows($res)==0){
                   /*$database->setQuery( "DELETE FROM #__member WHERE id IN ($cids)" );
                   if (!$database->query()) {
                        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                        }*/
                   $query="update #__member set is_delete=1"
                             ." where is_delete=0 and id IN ($cids)";
                   $query  =  $database->replaceTablePrefix($query);
                   $msg="Failed to Delete member group/ town associate";
                   if(!mysql_query($query)) {
                       mosRedirect( "index2.php?option=".$option."&mosmsg=".$msg );
                   }
                }
                elseif (mysql_num_rows($res)>0){
                        $msg = 'Member Group/ Town Associate(s): cannot be removed as they contain other records';
                        mosRedirect( "index2.php?option=".$option."&mosmsg=". $msg );
                }

                $msg="Member Group/ Town Associate deleted successfully";
        }

        if (count( $err )) {
                $cids = implode( "\', \'", $err );
                $msg = 'Member Group/ Town Associate(s): '. $cids .' cannot be removed as they contain records';
                mosRedirect( "index2.php?option=".$option."&mosmsg=". $msg );
        }

        mosRedirect( "index2.php?option=".$option."&mosmsg=".$msg);
}

/**
* Cancels an edit operation
* @param string The name of the category section
* @param integer A unique category id
*/
function cancelMemberGroup_Town() {
        global $database,$option;

        /*$row = new mosMembership( $database );
        $row->bind( $_POST );
        $row->checkin();*/
        MemberSessionUnregister();
        mosRedirect( "index2.php?option=".$option );
}

// File upload

function upload(){

        global $mosConfig_absolute_path, $id;
        $check_firm_address=$_POST['check_firm_address'];

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
                     //echo "<input type=hidden name=folder_name value='$folder_name'>";
                     $_SESSION['applicant_photograph1']=$file['name'][0];
                     $_SESSION['representative_photograph1']=$file['name'][1];
                     //echo "<input type=hidden name=applicant_photograph1 value='$file['name'][0]'>";
                     //echo "<input type=hidden name=representative_photograph1 value='$file['name'][1]'>";
                     //if($check_firm_address=="on")
                     //    $_SESSION['representative_photograph1']=$_SESSION['applicant_photograph1'];
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
                elseif (file_exists($dest_dir.$file['name'][1])) {
                        $_SESSION['up_message']="Upload FAILED : File allready exists";
                        $up=false;
                }
                if (strcasecmp(substr($file['name'][0],-4),".jpg"))  {
                        $_SESSION['up_message']="Only file type .jpg can be uploaded";
                        $up=false;
                }
                elseif (strcasecmp(substr($file['name'][1],-4),".jpg"))  {
                        $_SESSION['up_message']="Only file type .jpg can be uploaded";
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
                if ($file['name'][1]=="") {
                        $_SESSION['up_message'] = "";
                        $up=false;
                }
                else if (!move_uploaded_file($file['tmp_name'][1], $dest_dir.strtolower($file['name'][1]))){
                        $_SESSION['up_message']="Upload FAILED FOR APPLICANT PHOTOGRAPH " ;
                        $up=false;
                }
                else {
                        mosChmod($dest_dir.strtolower($file['name'][1]));
                        $_SESSION['up_message']="Upload complete";
                        $up=true;
                }

        $clearUploads = true;
        return $up;
}
*/

// file upload
function do_upload($file, $dest_dir)
{
        global $clearUploads;

                if (file_exists($dest_dir.$file['name'][0])) {
                        $_SESSION['up_message']="Upload FAILED : File allready exists";
                        $up=false;
                }

                if (strcasecmp(substr($file['name'][0],-4),".jpg"))  {
                        $_SESSION['up_message']="Only file type .jpg can be uploaded";
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
                    if (strcasecmp(substr($file['name'][1],-4),".jpg"))  {
                            $_SESSION['up_message']="Only file type .jpg can be uploaded";
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
function MemberSessionUnregister(){
         //global
         session_unregister('id');

          session_unregister('applicant_photograph');
          session_unregister('representative_photograph');
          session_unregister('applicant_photograph1');
          session_unregister('representative_photograph1');
          session_unregister('up_message');
          session_unregister('folder_name');
          session_unregister('member_reg_no');
          session_unregister('money_receipt_no');
         session_unregister('business_type');

}

?>
