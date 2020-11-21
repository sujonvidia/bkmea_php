<?php
/**
* @version $Id: admin.member_group_town_ccci.php,v 1.17 2006/05/16 04:29:13 nnabi Exp $
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
$option         = mosGetParam( $_REQUEST, 'option', $_GET['option'] );
$cid                 = mosGetParam( $_REQUEST, 'cid', array(0) );
$id = mosGetParam( $_REQUEST, 'id' );
if (!is_array( $cid )) {
        $cid = array(0);
}

switch ($task) {
        case 'new':
                editMemberGroup_Town( 0, $section );
                break;

        case 'edit':
                editMemberGroup_Town( intval( $cid[0] ) );
                break;

        case 'editA':
                editMemberGroup_Town( intval( $id ) );
                break;

        case 'save':
                saveMemberGroup_Town( $id );
                break;

        case 'remove':
                removeMemberGroup_Town( $section, $cid );
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
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' || LOWER(m.member_reg_no)='$search' || LOWER(m.tin)='$search' )";
        }

        $sub="(( mh.entry_type=1 and mh.reg_year_id='".$_SESSION['working_reg_year_id']."' )"
             ."\n || ( mh.entry_type=2 and mh.reg_year_id='".$_SESSION['working_reg_year_id']."' ))";

        // get the total number of records
        $query = "SELECT count(*)"
          . "\n FROM #__member AS m"
          . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
           . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
          . "\n where m.is_delete=0 and (m.type_id=1 || m.type_id=2) and $sub "
          . ( count( $where ) ? "\n  and " . implode( ' AND ', $where ) : "")
          . "\n  ORDER BY m.member_reg_no ASC"
          ;

        $database->setQuery( $query );
        $total = $database->loadResult();

        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

           $query = "SELECT m.id as id, mt.name AS type, m.representative_name AS representative, m.firm_name as firm_name"
           . "\n ,m.representative_title as representative_title,m.representative_last_name as representative_last_name"
           . "\n ,mh.member_reg_no as member_reg_no FROM #__member AS m"
           . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
           . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
          . "\n where m.is_delete=0 and (m.type_id=1 || m.type_id=2) and $sub "
           . ( count( $where ) ? "\n  and " . implode( ' AND ', $where ) : "")
           . "\n  ORDER BY m.member_reg_no ASC"
           . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
           ;
         //echo $query;
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
function editMemberGroup_Town( $id=0, $section='' ) {
        global $database, $my,$dbconn;

        if($id!=0){
              $sql_query = "select * from #__member where id ='$id'";
              $sql_query  =  $database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $row =& $res->fetchRow();
              $selected_type_id=$row->type_id;
              $selected_location=$row->location;
              $selected_payment_mode=$row->payment_mode;
              $is_memorandum_article=$row->is_memorandum_article;
              $is_registration_certificate=$row->is_registration_certificate;


              //get registration year from member_history table;
                     $query= "select id from #__member_history "
                            ."\n where member_id='$id' and entry_type='1'"
                            ;
                     $database->setQuery($query);
                     $_SESSION['last_reg_year_id']=$database->loadResult();

                     //get member registration no. from member_history table;
                     $query= "select mh.member_reg_no, mh.money_receipt_no, mh.reg_date from #__member_history as mh "
                            ."\n where mh.member_id='$id' and mh.reg_year_id='".$_SESSION['working_reg_year_id']."'"
                            ;
                     $database->setQuery($query);
                     $history = $database->loadObjectList();
                     $row->member_reg_no = $history[0]->member_reg_no;
                     $_SESSION['member_reg_no']=$row->member_reg_no;
                     $row->money_receipt_no = $history[0]->money_receipt_no;
                     $_SESSION['money_receipt_no']=$row->money_receipt_no;
                     $row->reg_date = $history[0]->reg_date;

                     //get money receipt no. from member_trail table;
                     /*
                     $query= "select mt.money_receipt_no from #__member_trail as mt"
                            ."\n join #__member as m on m.id=mt.member_id"
                            ."\n where m.id='$id'"
                            ;
                     $database->setQuery($query);
                     $_SESSION['money_receipt_no']=$database->loadResult();
                     //$row->money_receipt_no=$database->loadResult();
                     */
                     //Registration year
                     $query1= "select mh.reg_year_id as reg_year_id from #__member_history as mh "
                            ." where mh.entry_type='1' and mh.member_id='$id' ";
                     $query1  =  $database->replaceTablePrefix($query1);
                     $res1 =mysql_query($query1);
                     $row1=mysql_fetch_array($res1);
                     $_SESSION['last_reg_year_id']=$row1["reg_year_id"];
        }
        else{
          $row->id=0;
          $is_memorandum_article=0;
          $is_registration_certificate=0;
        }
          $_SESSION['last_reg_year_id']                  = $_SESSION['working_reg_year_id'];





        //$row = new mosMember_reg_year( $database );
        // load the row from the db table
        //$row->load( $uid );

        // fail if checked out not by 'me'
        if ($row->checked_out && $row->checked_out <> $my->id) {
                mosRedirect( 'index2.php?option=com_member_group_town_ccci, The firm '. $row->name .' is currently being edited by another administrator' );
        }

        $lists = array();
        $lists['type_id']= mosAdminMenus::MemberType( 'type_id', $option, $selected_type_id, 2 );
        $lists['country_id']= mosAdminMenus::CountryList( 'country_id' );
        $lists['location']= mosAdminMenus::Location( 'location',$selected_location );
        $lists['payment_mode']= mosAdminMenus::PaymentMode( 'payment_mode',$selected_payment_mode);
        $lists['is_memorandum_article']= mosHTML::yesnoRadioList( 'is_memorandum_article', 'class="inputbox"',$is_memorandum_article );
        $lists['is_registration_certificate']= mosHTML::yesnoRadioList( 'is_registration_certificate', 'class="inputbox"',$is_registration_certificate );
        $lists['last_reg_year_id']          = mosAdminMenus::RegYear( 'last_reg_year_id',  intval( $_SESSION['last_reg_year_id'] ), 'disabled' );
        $lists['representative_designation'] = mosAdminMenus::Designation( 'representative_designation',  ($row->representative_designation? $row->representative_designation:10));
        $lists['proposer_1_designation'] = mosAdminMenus::Designation( 'proposer_1_designation',  $row->proposer_1_designation);
        $lists['proposer_2_designation'] = mosAdminMenus::Designation( 'proposer_2_designation',  $row->proposer_2_designation);

        $lists['is_outside']   = mosHTML::yesnoRadioList( 'is_outside', 'class="inputbox"', intval($row->is_outside));
        $lists['proposer_1_title']             = mosAdminMenus::MemberTitle( 'proposer_1_title',$row->proposer_1_title );
        $lists['proposer_2_title']             = mosAdminMenus::MemberTitle( 'proposer_2_title',$row->proposer_2_title );
        $lists['representative_title']             = mosAdminMenus::MemberTitle( 'representative_title',$row->representative_title );
        //get registration date from member_reg_year table;
        $query=  "select start_date,end_date from #__member_reg_year "
                ."\n where id='".$_SESSION['last_reg_year_id']."'"
                ;
        $database->setQuery($query);
        $res=$database->loadObjectList();
        $start_date=mosHTML::ConvertDateDisplayShort($res[0]->start_date);
        $end_date=mosHTML::ConvertDateDisplayShort($res[0]->end_date);   //convert date

        $query="select max(mh.member_reg_no) as member_reg_no"
               ."\n from #__member_history as mh"
               ."\n left join #__member as m on m.id=mh.member_id"
               ."\n where mh.reg_year_id='".$_SESSION['working_reg_year_id']."' and m.type_id='2' "
               ."\n group by m.type_id order by m.type_id;"
               ;
        $database->setQuery($query);
        $max_reg_no[0]=$database->loadResult();
        $query="select max(mh.member_reg_no) as member_reg_no"
               ."\n from #__member_history as mh"
               ."\n left join #__member as m on m.id=mh.member_id"
               ."\n where mh.reg_year_id='".$_SESSION['working_reg_year_id']."' and m.type_id='1' "
               ."\n group by m.type_id order by m.type_id;"
               ;
        $database->setQuery($query);
        $max_reg_no[1]=$database->loadResult();

        HTML_MemberGroup_Town::edit( $row, $lists, $id, $start_date, $end_date, $max_reg_no);
}

/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/

function saveMemberGroup_Town( $id ) {
        global $database,$dbconn,$option;

        $current_date_time = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];


         // Query for check duplicate Member Registration Number
        $query="select mh.member_reg_no from #__member_history as mh"
                ."\n join #__member as m on m.id=mh.member_id"
                ."\n join #__member_type as mt on mt.id=m.type_id"
                ."\n where mh.member_reg_no='".$_POST['member_reg_no']."'"
                ."\n and mh.member_reg_no='".$_SESSION['working_reg_year_id']."' and m.type_id='".$_POST['type_id']."'"
                ;

        $query  =  $database->replaceTablePrefix($query);
        $result=mysql_query($query) or die(mysql_error());
        if ($_SESSION['member_reg_no']!=$_POST['member_reg_no']){
           if (intval($_POST['member_reg_no'])!=0 && mysql_num_rows($result)>0){
           //echo "<script> alert(Money Receipt No ".$money_receipt_no." Already Exist); window.history.go(-1); </script>\n";
           //exit();
           $msg="Membership No. ".$_POST['member_reg_no']." Already Exist";
           mosRedirect( "index2.php?option=$option&task=new&mosmsg=".$msg );
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
            mosRedirect( "index2.php?option=$option&task=new&mosmsg=".$msg );
            }
        }
        /*
        $row = new mosIndustry_Profile( $database );
        if (!$row->bind( $_POST )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }

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
        //echo $_POST['product_name'][2];die();
        //$id=$_POST['id'];
        $type_id=$_POST['type_id'];
        $member_reg_no=$_POST['member_reg_no'];
        $is_voter=0;
        $firm_name=$_POST['firm_name'];
        $firm_address_street=$_POST['firm_reg_address_street'];
        $firm_address_town_suburb=$_POST['firm_reg_address_town_suburb'];
        $firm_address_district=$_POST['firm_reg_address_district'];
        $firm_address_division=$_POST['firm_reg_address_division'];
        $firm_address_country=$_POST['firm_reg_address_country'];
        $firm_phone=$_POST['firm_phone'];
        $firm_fax=$_POST['firm_fax'];
        $firm_email=$_POST['firm_email'];
        $firm_web=$_POST['firm_web'];
        $representative_title=$_POST['representative_title'];
        $representative_name=$_POST['representative_name'];
        $representative_last_name=$_POST['representative_last_name'];
        $representative_designation=$_POST['representative_designation'];
        $payment_mode=$_POST['payment_mode'];
        $employee_total=$_POST['employee_total'];
        $location=$_POST['location'];
        $reg_date=mosHTML::ConvertDateForDatatbase($_POST['reg_date']);
        $last_reg_date=$_POST['last_reg_date'];
        $date = date( "Y-m-d H:i:s" );
        $is_delete=0;
        $date_of_formation=mosHTML::ConvertDateForDatatbase($_POST['date_of_formation']);
        $is_registration_certificate=$_POST['is_registration_certificate'];
        $is_memorandum_article=$_POST['is_memorandum_article'];
        $proposer_1_name=$_POST['proposer_1_name'];
        $proposer_1_designation=$_POST['proposer_1_designation'];
        $proposer_2_name=$_POST['proposer_2_name'];
        $proposer_2_designation=$_POST['proposer_2_designation'];
        $money_receipt_no=$_POST['money_receipt_no'];
        $money_receipt_date=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
        if($id==0){
                $sql="select id from #__member where firm_name='$firm_name'";
                $sql  =  $database->replaceTablePrefix($sql);
                $res=mysql_query($sql);
                if(mysql_num_rows($res)==0){
                   /*$sql_query="insert into #__member values('','$type_id','$member_reg_no',"
                               ."'$is_voter','$firm_name','$firm_address_street',"
                               ."'$firm_address_town_suburb','$firm_address_district','$firm_address_division',"
                               ."'$firm_address_country','$firm_phone','$firm_fax','$firm_email',"
                               ."'$firm_web','','','','','','','','','','','','','','',"
                               ."'$representative_name','$representative_designation',"
                               ."'','','','','','','','','','','',"
                               ."'$payment_mode','','','','','','','','','','','','','','','','','','','',"
                               ."'$employee_total','','$location','$reg_date','$last_reg_date','$date',"
                               ."'','','','','','','','','$is_delete','$date_of_formation',"
                               ."'$is_registration_certificate','$is_memorandum_article','',"
                               ."'$proposer_1_name','$proposer_1_designation',"
                               ."'$proposer_2_name','$proposer_2_designation','','')";
                     */
                       $sql_query= "insert into #__member (type_id,member_reg_no,firm_name,firm_reg_address_street"
                                 .",firm_reg_address_town_suburb,firm_reg_address_district,firm_reg_address_division"
                                 .",firm_reg_address_country,firm_phone,firm_fax,firm_email,firm_web,firm_mobile"
                                 .",is_voter,representative_title,representative_name"
                                 .",representative_last_name,representative_designation,establishment_year"
                                 .",money_receipt_no,money_receipt_date"
                                 .",reg_date,last_reg_date,date"
                                 .",is_memorandum_article,proposer_1_firm_name"
                                 .",proposer_1_title,proposer_1_name,proposer_1_last_name"
                                 .",proposer_1_designation,proposer_2_firm_name,proposer_2_title"
                                 .",proposer_2_name,proposer_2_last_name,proposer_2_designation"
                                 .",is_delete,date_of_formation,is_registration_certificate,employee_total,payment_mode,location"
                                 .",is_outside)"
                                 ." values ('". $type_id."','".$member_reg_no."','".$firm_name
                                 ."','".$_POST['firm_reg_address_street']."','".$_POST['firm_reg_address_town_suburb']
                                 ."','".$_POST['firm_reg_address_district']."','".$_POST['firm_reg_address_division']
                                 ."','".$_POST['firm_reg_address_country']."','".$firm_phone."','". $firm_fax
                                 ."','".$firm_email."','".$firm_web."','".$_POST['firm_mobile']
                                 ."','".$is_voter."','".$representative_title."','".$representative_name
                                 ."','".$representative_last_name."','".$representative_designation."','".$establishment_year
                                 ."','".$_POST['money_receipt_no']."','".$money_receipt_date
                                 ."','".$reg_date
                                 ."','".$reg_date."','".$current_date_time
                                 ."','".$is_memorandum_article."','".$_POST['proposer_1_firm_name']
                                 ."','".$_POST['proposer_1_title']."','".$proposer_1_name."','".$_POST['proposer_1_last_name']
                                 ."','".$proposer_1_designation."','".$_POST['proposer_2_firm_name']."','".$_POST['proposer_2_title']
                                 ."','".$proposer_2_name."','".$_POST['proposer_2_last_name']."','".$proposer_2_designation
                                 ."','0','".$date_of_formation."','".$is_registration_certificate."','".$employee_total
                                 ."','".$payment_mode."','".$location."','".$_POST['is_outside']
                                 ."')";


                   $sql_query  =  $database->replaceTablePrefix($sql_query);
                   if(!mysql_query($sql_query)) {
                      $msg="Failed to add group/Town associate Member, please try again.".$sql_query;
                      mosRedirect( "index2.php?option=com_member_group_town_ccci&task=editA&mosmsg=". $msg );
                      //echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                      exit();
                   }
                   /// kep record history of data inserting into member history table
                   $insert_id = mysql_insert_id($dbconn->connection);

                      $query="insert into #__member_history values('','".$insert_id."','1','"
                              .$_SESSION['last_reg_year_id']."','".$member_reg_no."','"
                              .$is_voter."','".$money_receipt_no."','"
                              .$amount."','','".$current_date_time."','".$user_id."','".$reg_date."')";
                      $query  =  $database->replaceTablePrefix($query);

                      $msg="Failed to Add Member History";
                      if(!mysql_query($query)) {
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

                      /// kep record of data inserting into member trail table
                      if(!$database->addMemberTrail($insert_id,'1',$user_id,'','',$money_receipt_no)){
                           $msg="Incorrect Member Trail Information";
                           mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }

                }else{
                      //echo "<script> alert('Member Type Already exist\'s'); window.history.go(-1); </script>\n";

                      $msg="Member group and town associate with that name, please try again.".$sql_query;
                      mosRedirect( "index2.php?option=com_member_group_town_ccci&task=editA&mosmsg=". $msg );
                      exit();
                }

                $msg="Member group and town associate added successfully";
                mosRedirect( "index2.php?option=com_member_group_town_ccci&mosmsg=".$msg );
        }
        else{
                $sql="select id from #__member where firm_name='$firm_name' and id!='$id'";
                $sql  =  $database->replaceTablePrefix($sql);
                $res=mysql_query($sql);
                if(mysql_num_rows($res)==0){
                  $sql_query = "update #__member set type_id='$type_id',member_reg_no='$member_reg_no',"
                               ."is_voter='$is_voter',firm_name='$firm_name',"
                               ."firm_reg_address_street='$firm_address_street',"
                               ."firm_reg_address_town_suburb='$firm_address_town_suburb',"
                               ."firm_reg_address_district='$firm_address_district',"
                               ."firm_reg_address_division='$firm_address_division',"
                               ."firm_reg_address_country='$firm_address_country',"
                               ."firm_phone='$firm_phone',"
                               ."firm_fax='$firm_fax',"
                               ."firm_email='$firm_email',"
                               ."firm_web='$firm_web',"
                               ."firm_mobile='".$_POST['firm_mobile']."',"
                               ."money_receipt_no='".$_POST['money_receipt_no']."',"
                               ."money_receipt_date='".mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date'])."',"
                               ."representative_title='".$_POST['representative_title']."',"
                               ."representative_name='$representative_name',"
                               ."representative_last_name='".$_POST['representative_last_name']."',"
                               ."representative_designation='$representative_designation',"
                               ."payment_mode='$payment_mode',"
                               ."employee_total='$employee_total',"
                               ."location='$location',"
                               ."reg_date='$reg_date',"
                               ."last_reg_date='$last_reg_date',"
                               ."date='$date',"
                               ."is_delete='$is_delete',"
                               ."date_of_formation='$date_of_formation',"
                               ."is_registration_certificate='$is_registration_certificate',"
                               ."is_memorandum_article='$is_memorandum_article',"
                               ."is_outside='".$_POST['is_outside']."',"
                               ."proposer_1_firm_name='".$_POST['proposer_1_firm_name']."',"
                               ."proposer_1_title='".$_POST['proposer_1_title']."',"
                               ."proposer_1_name='$proposer_1_name',"
                               ."proposer_1_last_name='".$_POST['proposer_1_last_name']."',"
                               ."proposer_1_designation='$proposer_1_designation',"
                               ."proposer_2_firm_name='".$_POST['proposer_2_firm_name']."',"
                               ."proposer_2_title='".$_POST['proposer_2_title']."',"
                               ."proposer_2_name='$proposer_2_name',"
                               ."proposer_2_last_name='".$_POST['proposer_2_last_name']."',"
                               ."proposer_2_designation='$proposer_2_designation' where id ='$id'";

                     $database->setQuery( $sql_query );
                     if(!$database->query()) {
                        $msg="Failed to update member group and town associate, please try again.".$sql_query;
                        mosRedirect( "index2.php?option=com_member_group_town_ccci&task=editA&id=$id&mosmsg=". $msg );
                        //echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                        exit();
                     }

                      // keep record of data updating of  member trail table
                      if(!$database->addMemberTrail($id,'3',$user_id,'','',$money_receipt_no)){
                           $msg="Incorrect Member Trail Information";
                           mosRedirect( "index2.php?option=$option&id=".$id."&mosmsg=".$msg );
                      }

                      //update history table
                      // keep record of data updating of  member table in t5he member history table
                      $query="update #__member_history set "
                             ." member_reg_no='".$member_reg_no."'"
                             .",reg_date='".$reg_date
                             ."' ,money_receipt_no='".$_POST['money_receipt_no']
                             ."' where member_id='$id' and reg_year_id='".$_SESSION['working_reg_year_id']."' ";
                      $query  =  $database->replaceTablePrefix($query);


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
                       }

                      $msg="Failed to Update Member History";
                      if(!mysql_query($query)) {
                           mosRedirect( "index2.php?option=$option&&id=".$id."&mosmsg=".$msg );
                      }

                      $msg="Member Group and Town Associate updated successfully";
                      mosRedirect( "index2.php?option=com_member_group_town_ccci&mosmsg=".$msg );
                }
                else{
                    //echo "<script> alert('Member Type Already exist\'s'); window.history.go(-1); </script>\n";
                    $msg="Member group and town associate already with that name, please try again.";
                    mosRedirect( "index2.php?option=com_member_group_town_ccci&task=editA&id=$id&mosmsg=". $msg );
                    exit();
                }
                $msg="Member group and town associate updated successfully";
        }
        session_unregister('member_reg_no');
        session_unregister('money_receipt_no');
        $row->checkin();
        mosRedirect( "index2.php?option=com_member_group_town_ccci&mosmsg=".$msg );
}

/**
* Deletes one or more categories from the categories table
* @param string The name of the category section
* @param array An array of unique category id numbers
*/
function removeMemberGroup_Town( $section, $cid ) {
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
                       mosRedirect( "index2.php?option=com_member_group_town_ccci&mosmsg=".$msg );
                   }
                }
                elseif (mysql_num_rows($res)>0){
                        $msg = 'Member Group/ Town Associate(s): cannot be removed as they contain other records';
                        mosRedirect( 'index2.php?option=com_member_group_town_ccci&mosmsg='. $msg );
                }

                $msg="Member Group/ Town Associate deleted successfully";
        }

        if (count( $err )) {
                $cids = implode( "\', \'", $err );
                $msg = 'Member Group/ Town Associate(s): '. $cids .' cannot be removed as they contain records';
                mosRedirect( 'index2.php?option=com_member_group_town_ccci&mosmsg='. $msg );
        }

        mosRedirect( 'index2.php?option=com_member_group_town_ccci&mosmsg='.$msg);
}

/**
* Cancels an edit operation
* @param string The name of the category section
* @param integer A unique category id
*/
function cancelMemberGroup_Town() {
        global $database;

        /*$row = new mosMembership( $database );
        $row->bind( $_POST );
        $row->checkin();*/
        mosRedirect( 'index2.php?option=com_member_group_town_ccci' );
}


?>
