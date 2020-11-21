<?php
/**
* @version $Id: admin.membership_edit_scci.php,v 1.23 2006/08/27 05:31:28 morshed Exp $
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
                | $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_membership_edit_scci' ))) {
        //mosRedirect( 'index2.php', _NOT_AUTH );
}

require_once( $mainframe->getPath( 'admin_html' ) );
//require_once( $mainframe->getPath( 'class' ) );

$cid = mosGetParam( $_POST, 'cid', array(0) );
$id = mosGetParam( $_REQUEST, 'id' );
 //echo "cid=$cid";
switch ($task) {
        case 'new' :
        case 'newA':
                editMembershipA( $option, 0 );
                break;

        case 'edit' :
                editMembershipA( $option, $cid[0] );
                break;
        case 'editA':
                editMembershipA( $option, $id );
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
        case 'dbli':
                deleteBusinessLineInformation();
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
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' OR LOWER(m.member_reg_no) LIKE '%$search%' ) ";
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

        $query = "SELECT mt.name AS type, m.applicant_name AS applicant_name, m.id as id,"
        . "\n u.name AS editor, m.firm_name AS firm_name,m.member_reg_no AS member_reg_no"
        . "\n FROM #__member AS m"
        . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
        . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
        . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
        . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
        . ( count( $where ) ? " and m.is_delete=0 and $sub " : " where m.is_delete=0 and $sub " )
        . "\n and m.type_id !=1 and m.type_id!=2 "
        . "\n ORDER BY m.member_reg_no"
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
        $lists['search_type_id']     = mosAdminMenus::MemberType( 'search_type_id', $option, intval( $search_type_id ), 1, $javascript);

        HTML_Membership::showMembership( $option, $rows, $lists, $search, $pageNav );
}

/**
* Compiles information to add or edit
* @param integer The unique id of the record to edit (0 if new)
*/
function editMembershipA( $option, $id ) {
        global $database, $my, $dbconn;

        //switch($_POST['step']){
             //case 0: {
                MemberSessionUnregister();
                if( $id!=0){
                     $sql_query1  =  "select * from #__member where id ='$id'";
                     $sql_query1  =  $database->replaceTablePrefix($sql_query1);
                     $dbconn->setFetchMode(DB_FETCHMODE_ASSOC);
                     $res =& $dbconn->query($sql_query1);
                     $row =& $res->fetchRow();
                     foreach ($row as $key => $value) {
                        $_SESSION[$key] = stripslashes($value);
                     }

                     //get registration year from member_history table;
                     $query= "select reg_year_id from #__member_history "
                            ."\n where member_id='$id' and entry_type='1'"
                            ;
                     $database->setQuery($query);
                     $_SESSION['last_reg_year_id']=$database->loadResult();

                     //Registration year
                     $query= "select mh.reg_year_id as reg_year_id from #__member_history as mh "
                            ." where mh.entry_type='1' and mh.member_id='$id'";
                     $query  =  $database->replaceTablePrefix($query);
                     $res =mysql_query($query);
                     $row=mysql_fetch_array($res);
                     $_SESSION['last_reg_year_id']=$row["reg_year_id"];

                     //importer of
                     $query="select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id from #__member_product_line as mpl,#__product_line as pl"
                            ." where mpl.product_id=pl.id and mpl.business_type='1' and mpl.member_id='$id'";
                     $database->setQuery( $query );
                     $rows_importer = $database->loadObjectList();


                     //expoter of
                     $query="select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id from #__member_product_line as mpl,#__product_line as pl"
                            ." where mpl.product_id=pl.id and mpl.business_type='2' and mpl.member_id='$id'";
                     $database->setQuery( $query );
                     $rows_exporter = $database->loadObjectList();


                     //manufacturer of
                     $query="select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id from #__member_product_line as mpl,#__product_line as pl"
                            ." where mpl.product_id=pl.id and mpl.business_type='3' and mpl.member_id='$id'";
                     $database->setQuery( $query );
                     $rows_manufacturer = $database->loadObjectList();


                     //trader of
                     $query="select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id from #__member_product_line as mpl,#__product_line as pl"
                            ." where mpl.product_id=pl.id and mpl.business_type='4' and mpl.member_id='$id'";
                     $database->setQuery( $query );
                     $rows_trader = $database->loadObjectList();


                     //dealer of
                     $query="select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id from #__member_product_line as mpl,#__product_line as pl"
                            ." where mpl.product_id=pl.id and mpl.business_type='5' and mpl.member_id='$id'";
                     $database->setQuery( $query );
                     $rows_dealer = $database->loadObjectList();


                     //indentor of
                     $query="select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id from #__member_product_line as mpl,#__product_line as pl"
                            ." where mpl.product_id=pl.id and mpl.business_type='6' and mpl.member_id='$id'";
                     $database->setQuery( $query );
                     $rows_indentor = $database->loadObjectList();


                     //assembler of
                     $query="select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id from #__member_product_line as mpl,#__product_line as pl"
                            ." where mpl.product_id=pl.id and mpl.business_type='7' and mpl.member_id='$id'";
                     $database->setQuery( $query );
                     $rows_assembler = $database->loadObjectList();


                     //service_provider of
                     $query="select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id from #__member_product_line as mpl,#__product_line as pl"
                            ." where mpl.product_id=pl.id and mpl.business_type='8' and mpl.member_id='$id'";
                     $database->setQuery( $query );
                     $rows_service_provider = $database->loadObjectList();
                     // business type

                     /*$query="select business_type as id from #__member_business_type where member_id='$id'";
                     $query  =  $database->replaceTablePrefix($query);
                     $res =mysql_query($query);
                     $i=0;
                     while($row=mysql_fetch_array($res)){
                        $business_type[$i]=$row["id"];
                        $i++;
                     }
                     $_SESSION['business_type'] =$business_type;  */

                }//end edit functionality
                //else{
                     $_SESSION['last_reg_year_id']                  = $_SESSION['working_reg_year_id'];
                //}
             //}
          //   break;
        //}
        $javascript="onChange=\"return belongs_to();\"";
        $lists = array();
        $lists['type_id']                      = mosAdminMenus::MemberType( 'type_id', $option, intval( $_SESSION['type_id'] ), 1,$javascript );
        $lists['country_id']                   = mosAdminMenus::CountryList( 'country_id', $_SESSION['country_id']  );
        $lists['location']                     = mosAdminMenus::Location( 'location', $_SESSION['location']  );
        $lists['corporate_status']             = mosAdminMenus::CorporateStatus( 'corporate_status', $_SESSION['corporate_status'] );
        $lists['last_reg_year_id']             = mosAdminMenus::RegYear( 'last_reg_year_id',  intval( $_SESSION['last_reg_year_id'] ), 'disabled' );
        $lists['applicant_designation'] = mosAdminMenus::Designation( 'applicant_designation',  intval( $_SESSION['applicant_designation'] ));
        $lists['representative_designation'] = mosAdminMenus::Designation( 'representative_designation',  intval( $_SESSION['representative_designation'] ));
        /*$lists['product_line_impoter_of']               = mosAdminMenus::MultipleProductList( 'product_line_impoter_of[]', 'product_line_impoter_of' );
        $lists['product_line_impoter_of_country']       = mosAdminMenus::MultiCountryList( 'product_line_impoter_of_country[]', 'product_line_impoter_of_country' );
        $lists['product_line_expoter_of']               = mosAdminMenus::MultipleProductList( 'product_line_expoter_of[]', 'product_line_expoter_of' );
        $lists['product_line_expoter_of_country']       = mosAdminMenus::MultiCountryList( 'product_line_expoter_of_country[]', 'product_line_expoter_of_country' );
        $lists['product_line_trader_of']                = mosAdminMenus::MultipleProductList( 'product_line_trader_of[]', 'product_line_trader_of' );
        $lists['product_line_dealer_of']                = mosAdminMenus::MultipleProductList( 'product_line_dealer_of[]', 'product_line_dealer_of' );
        $lists['product_line_manufacturer_of']          = mosAdminMenus::MultipleProductList( 'product_line_manufacturer_of[]', 'product_line_manufacturer_of' );
        $lists['product_line_indentor_of']              = mosAdminMenus::MultipleProductList( 'product_line_indentor_of[]', 'product_line_indentor_of' );
        $lists['product_line_assembler_of']             = mosAdminMenus::MultipleProductList( 'product_line_assembler_of[]', 'product_line_assembler_of' );
        $lists['product_line_service_provider_of']      = mosAdminMenus::MultipleProductList( 'product_line_service_provider_of[]', 'product_line_service_provider_of' );
        */$lists['proposer1_title']             = mosAdminMenus::MemberTitle( 'proposer1_title',$_SESSION['proposer1_title'] );
        $lists['proposer2_title']             = mosAdminMenus::MemberTitle( 'proposer2_title',$_SESSION['proposer2_title'] );
        $lists['applicant_title']             = mosAdminMenus::MemberTitle( 'applicant_title',$_SESSION['applicant_title'] );
        $lists['representative_title']             = mosAdminMenus::MemberTitle( 'representative_title',$_SESSION['representative_title'] );

        $lists['production_unit']             = mosAdminMenus::ProductUnit( 'product_unit',$_SESSION['production_unit'] );
        //$lists['business_type']             = mosAdminMenus::MultipleBusinessType( 'business_type[]','business_type' );

        HTML_Membership::editMembershipA( $lists, $option, $id, $start_date, $end_date,$rows_importer,$rows_exporter,$rows_manufacturer,$rows_trader,$rows_dealer,$rows_indentor,$rows_assembler,$rows_service_provider);
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
        $money_receipt_date_history=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
        //if ($_POST[tabselection]=="0")
        //{
                     $query="select mh.member_reg_no from #__member_history as mh"
                     ."\n join #__member as m on m.id=mh.member_id"
                     ."\n join #__member_type as mt on mt.id=m.type_id"
                     ."\n where mh.member_reg_no='".$_POST['member_reg_no']."'"
                     ."\n and m.is_delete=0 and m.type_id='".$_POST['type_id']."'"
                     ;

                     $query  =  $database->replaceTablePrefix($query);

                     //check duplicate membership code
                     if ($_SESSION['member_reg_no']!=$_POST['member_reg_no']){
                            if (mysql_num_rows($result)>0){
                                   echo "<script> alert(Membership Code Already Exist); window.history.go(-1); </script>\n";
                                   exit();
                                  // $msg="Membership No. ".$_POST['member_reg_no']." Already Exist";
                                  // mosRedirect( "index2.php?option=$option&task=editA&id=".$id."&mosmsg=".$msg );
                            }
                       }

                        // Query for check duplicate Money Receipt Number
                       $sql_query2="select * from #__member_trail where money_receipt_no ='".$_POST['money_receipt_no']."'";
                       $database->setQuery($sql_query2);
                       $total_row=$database->loadResult();
                       if ($_SESSION['money_receipt_no']!=$_POST['money_receipt_no']){
                             if(count($total_row)>0 ) {
                                echo "<script> alert('Money Receipt No is already Exists'); window.history.go(-1); </script>\n";
                                exit();
                                //$msg="Money Receipt No. ".$_POST['money_receipt_no']." Already Exist";
                                //mosRedirect( "index2.php?option=$option&task=editA&id=".$id."&mosmsg=".$msg );
                             }
                       }
                       $sql_query= "update #__member set type_id='".$_POST['type_id']
                      ."',member_reg_no='". $_POST['member_reg_no']
                      //."',is_voter='".$_SESSION['is_voter']
                      ."',reg_date='".mosHTML::ConvertDateForDatatbase($_POST['reg_date'])
                      ."',firm_name='".$_POST['firm_name']
                      ."',country_id='". $_POST['country_id']
                      ."',corporate_status='". $_POST['corporate_status']
                      ."',bank_name='".$_POST['bank_name']
                      ."',bank_address='".$_POST['bank_address']
                      ."',money_receipt_no='".$_POST['money_receipt_no']
                      ."',date_of_formation='".mosHTML::ConvertDateForDatatbase($_POST['date_of_formation'])
                      ."',money_receipt_date='".mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date'])
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);
                      $save_tab1=mysql_query($sql_query);

                      //$msg="Failed to Update Membership Information".$sql_query;
                      //if(!mysql_query($sql_query)) {
                      //   echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                      //       exit();
                      //
                      //}
                      //else
                      //    $msg="General in Profile is updated Succesfully";

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

                      //history  update and trail entry

                      // echo $query;
                      //if(!mysql_query($query)) {
                      //     echo "<script> alert('Fail TO Update Membership History'); window.history.go(-1); </script>\n";
                      //       exit();
                      //
                      //}



        //}       /// end of tabselection ==0
        //else if ($_POST[tabselection]=="1")
        //{
                $sql_query= "update #__member set firm_reg_address_street='".$_POST['firm_reg_address_street']
                      ."',firm_reg_address_town_suburb='".$_POST['firm_reg_address_town_suburb']
                      ."',firm_reg_address_district='".$_POST['firm_reg_address_district']
                      ."',firm_reg_address_division='".$_POST['firm_reg_address_division']
                      ."',firm_reg_address_country='".$_POST['firm_reg_address_country']
                      ."',firm_phone='".$_POST['firm_phone']
                      ."',firm_fax='".$_POST['firm_fax']
                      ."',firm_mobile='".$_POST['firm_mobile']
                      ."',firm_email='".$_POST['firm_email']
                      ."',firm_web='".$_POST['firm_web']
                      ."',head_office_address_street='".$_POST['head_office_address_street']
                      ."',head_office_address_town_suburb='".$_POST['head_office_address_town_suburb']
                      ."',head_office_address_district='".$_POST['head_office_address_district']
                      ."',head_office_address_division='".$_POST['head_office_address_division']
                      ."',head_office_address_country='".$_POST['head_office_address_country ']
                      ."',head_office_phone='".$_POST['head_office_phone']
                      ."',head_office_mobile='".$_POST['head_office_mobile']
                      ."',head_office_fax='".$_POST['head_office_fax']
                      ."',head_office_email='".$_POST['head_office_email']
                      ."',head_office_web='".$_POST['head_office_web']
                      ."',location='".$_POST['location']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);
                      $save_tab2=mysql_query($sql_query);

                      /*
                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                             exit();

                      }else $msg="Addresses in Profile are updated Succesfully";

                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }

        } //end of 1
        else if ($_POST[tabselection]=="2")
        {
        */
                      $sql_query= "update #__member set financial_turnover_volume='".$_POST['financial_turnover_volume']
                      ."',financial_local_sales_1='".$_POST['financial_local_sales_1']
                      ."',financial_local_sales_2='".$_POST['financial_local_sales_2']
                      ."',financial_local_sales_3='".$_POST['financial_local_sales_3']
                      ."',financial_local_sales_4='".$_POST['financial_local_sales_4']
                      ."',financial_local_sales_5='".$_POST['financial_local_sales_5']
                      ."',financial_export_sales_1='".$_POST['financial_export_sales_1']
                      ."',financial_export_sales_2='".$_POST['financial_export_sales_2']
                      ."',financial_export_sales_3='".$_POST['financial_export_sales_3']
                      ."',financial_export_sales_4='".$_POST['financial_export_sales_4']
                      ."',financial_export_sales_5='".$_POST['financial_export_sales_5']
                      ."',financial_export_sales_5='".$_POST['financial_export_sales_5']
                      ."',employee_male='".$_POST['employee_male']
                      ."',employee_female='".$_POST['employee_female']
                      ."',employee_total='".$_POST['employee_total']
                      ."',production_capacity='".$_POST['production_capacity']
                      ."',production_unit='".$_POST['production_unit']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";


                      $sql_query  =  $database->replaceTablePrefix($sql_query);
                      $save_tab3=mysql_query($sql_query);
                     /*

                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                             exit();

                      }else $msg="Capacity in Profile is updated Succesfully";

                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }

        } //end of tabselection 2
        else if ($_POST[tabselection]=="3")
        {
        */
                if(isset($_FILES['up_file'])){
                     $applicant_old_image      = trim($_SESSION['applicant_photograph']);
                     $applicant_image=trim($mosConfig_absolute_path."/administrator/images/photograph/".$id."/".$applicant_old_image);
                     $representative_old_image = trim($_SESSION['representative_photograph']);
                     $representative_image=trim($mosConfig_absolute_path."/administrator/images/photograph/".$id."/".$representative_old_image);

                     if(!file_exists($mosConfig_absolute_path."/administrator/images/photograph/".$id."/")){
                             mkdir($mosConfig_absolute_path."/administrator/images/photograph/".$id."/",0777);
                     }else{
                             chmod($mosConfig_absolute_path."/administrator/images/photograph/".$id,0777);
                     }

                     if ($_FILES['up_file']['name'][0]!="")
                     {
                             $applicant_photograph=$_FILES['up_file']['name'][0];
                     }
                     else
                         $applicant_photograph= $applicant_old_image;


                     if ($_FILES['up_file']['name'][1]!="")
                     {
                             $representative_photograph=$_FILES['up_file']['name'][1];
                     }
                     else{
                             if (empty($_FILES['up_file']['name'][1]) && $_POST['check_propietor_information']=="on")
                                 $representative_photograph =$applicant_photograph;
                             else
                                 $representative_photograph =$representative_old_image;
                     }

                      if($applicant_old_image!="" && file_exists($applicant_image) && $_FILES['up_file']['name'][0]!="")
                              @unlink($applicant_image);
                      if($representative_old_image!="" && file_exists($representative_image) && $_FILES['up_file']['name'][1]!="" && $applicant_old_image!=$representative_old_image)
                              @unlink($representative_image);

                      else if($representative_old_image!="" && file_exists($representative_image) && $_POST['check_propietor_information']=="on" && $applicant_old_image!=$representative_old_image)
                              @unlink($representative_image);


                      $con=upload();
                     //if(intval($con)==1){
                     //}

                }
                else
                {
                    /*if ($_POST['check_propietor_information']=="on"){
                                 $representative_photograph =trim($_SESSION['applicant_photograph']);
                                 $representative_old_image = trim($_SESSION['representative_photograph']);
                                 $representative_image=trim($mosConfig_absolute_path."/administrator/images/photograph/".$id."/".$representative_old_image);
                                 if($representative_old_image!="" && file_exists($representative_image))
                                 @unlink($representative_image);


                        }
                    else*/
                       {

                          $applicant_photograph =trim($_SESSION['applicant_photograph']);
                          $representative_photograph =trim($_SESSION['representative_photograph']);
                       }

                }

                $sql_query= "update #__member set applicant_title='".$_POST['applicant_title']
                      ."',applicant_name='".$_POST['applicant_name']
                      ."',applicant_last_name='".$_POST['applicant_last_name']
                      ."',applicant_designation='".$_POST['applicant_designation']
                      ."',applicant_photograph='".$applicant_photograph
                      ."',representative_title='".$_POST['representative_title']
                      ."',representative_name='".$_POST['representative_name']
                      ."',representative_last_name='".$_POST['representative_last_name']
                      ."',representative_designation='".$_POST['representative_designation']
                      ."',representative_photograph='".$representative_photograph
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);
                      $save_tab4=mysql_query($sql_query);

                     /*
                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                             exit();

                      }
                      else  $msg="Representative Information in Profile is updated Succesfully";

                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }



        }// end of tabselection 3
        else if ($_POST[tabselection]=="4")
        {
        */
                $sql_query= "update #__member set trade_licence_issued_by='".$_POST['trade_licence_issued_by']
                      ."',trade_licence_no='".$_POST['trade_licence_no']
                      ."',trade_licence_expire_date='".mosHTML::ConvertDateForDatatbase($_POST['trade_licence_expire_date'])
                      ."',trade_licence_issue_date='".mosHTML::ConvertDateForDatatbase($_POST['trade_licence_issue_date'])
                      ."',import_reg_no='".$_POST['import_reg_no']
                      ."',export_reg_no='".$_POST['export_reg_no']
                      ."',indenting_trade_no='".$_POST['indenting_trade_no']
                      ."',tin='".$_POST['tin']
                      ."',factory_act_reg_no='".$_POST['factory_act_reg_no']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);
                      $save_tab5=mysql_query($sql_query);

                      /*
                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                             exit();

                      }else $msg="License Information in Profile is updated Succesfully";

                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }
                      */
                      if ($_SESSION['tin']!=$_POST['tin'])
                      {
                             $query="select m.id as id from #__member as m"
                             ."\n join #__member_history as mh on m.id=mh.member_id"
                             ."\n where m.tin ='".$_POST['tin']."' and"
                             ."\n mh.reg_year_id='".$_SESSION['last_reg_year_id']."'"
                             ;

                             $query  =  $database->replaceTablePrefix($query);
                             $result=mysql_query($query) or die(mysql_error());
                             if (mysql_num_rows($result)>1){
                                     $query="update #__member_history as mh set mh.is_voter=0"
                                     ."\n where mh.member_id in (select id from #__member where tin='".$_POST['tin']."')"
                                     ."\n and mh.reg_year_id='".$_SESSION['last_reg_year_id']."'"
                                    ;

                             $query  =  $database->replaceTablePrefix($query);
                             $result=mysql_query($query) or die(mysql_error());
                             }else
                             {
                                  $query="update #__member_history as mh set mh.is_voter=1"
                                     ."\n where mh.member_id in (select id from #__member where tin='".$_POST['tin']."')"
                                     ."\n and mh.reg_year_id='".$_SESSION['last_reg_year_id']."'"
                                    ;

                             $query  =  $database->replaceTablePrefix($query);
                             $result=mysql_query($query) or die(mysql_error());
                             }

                             $query="select m.id as id from #__member as m"
                             ."\n join #__member_history as mh on m.id=mh.member_id"
                             ."\n where m.tin ='".$_SESSION['tin']."' and"
                             ."\n mh.reg_year_id='".$_SESSION['last_reg_year_id']."'"
                             ;

                             $query  =  $database->replaceTablePrefix($query);
                             $result=mysql_query($query) or die(mysql_error());
                             if (mysql_num_rows($result)==1){
                                     $query="update #__member_history as mh set mh.is_voter=1"
                                     ."\n where mh.member_id in (select id from #__member where tin='".$_SESSION['tin']."')"
                                     ."\n and mh.reg_year_id='".$_SESSION['last_reg_year_id']."'"
                                    ;

                             $query  =  $database->replaceTablePrefix($query);
                             $result=mysql_query($query) or die(mysql_error());
                             }

                      }
        /*

        } // end of tabselection 4
        else if ($_POST[tabselection]=="5")
        {
        */
                      $sql_query= "update #__member set proposer1_title='".$_POST['proposer1_title']
                      ."',proposer1_name='".$_POST['proposer1_name']
                      ."',proposer1_last_name='".$_POST['proposer1_last_name']
                      ."',proposer1_address='".$_POST['proposer1_address']
                      ."',proposer1_member_reg_no='".$_POST['proposer1_member_reg_no']
                      ."',proposer1_firm_name='".$_POST['proposer1_firm_name']
                      ."',proposer2_title='".$_POST['proposer2_title']
                      ."',proposer2_name='".$_POST['proposer2_name']
                      ."',proposer2_last_name='".$_POST['proposer2_last_name']
                      ."',proposer2_address='".$_POST['proposer2_address']
                      ."',proposer2_member_reg_no='".$_POST['proposer2_member_reg_no']
                      ."',proposer2_firm_name='".$_POST['proposer2_firm_name']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);
                      $save_tab6=mysql_query($sql_query);
                      /*
                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail to Update Membership Profile'); window.history.go(-1); </script>\n";
                         exit();

                      }else $msg="Propsers' Information in Profile are updated Succesfully";

                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }



        }// end of tabselection 5
        else if ($_POST[tabselection]=="6")
        {
        */
                      $sql_query= "update #__member set product_line_others='".$_POST['product_line_others']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);
                      $save_tab7=mysql_query($sql_query);
                      /*
                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                         exit();
                      }

                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }
                      */
                     /*
                     //impoter of -- Multiple select
                      $impoter = $_POST['product_line_impoter_of'];
                      $total=count($impoter);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_line where member_id='".$id."' and product_id='".$impoter[$i]."' and business_type='1'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_line values('','".$id."','".$impoter[$i]."','1')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and product_id!='".$impoter[$i]."'";
                      }
                      $query="delete from #__member_product_line where member_id='".$id."' ".$del." and business_type='1'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //expoter of -- Multiple select
                      $expoter = $_POST['product_line_expoter_of'];
                      $total=count($expoter);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_line where member_id='".$id."' and product_id='".$expoter[$i]."' and business_type='2'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_line values('','".$id."','".$expoter[$i]."','2')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and product_id!='".$expoter[$i]."'";
                      }
                      $query="delete from #__member_product_line where member_id='".$id."' ".$del." and business_type='2'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //trader of -- Multiple select
                      $trader = $_POST['product_line_trader_of'];
                      $total=count($trader);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_line where member_id='".$id."' and product_id='".$trader[$i]."' and business_type='3'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_line values('','".$id."','".$trader[$i]."','3')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and product_id!='".$trader[$i]."'";
                      }
                      $query="delete from #__member_product_line where member_id='".$id."' ".$del." and business_type='3'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //dealer of -- Multiple select
                      $dealer = $_POST['product_line_dealer_of'];
                      $total=count($dealer);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_line where member_id='".$id."' and product_id='".$dealer[$i]."' and business_type='4'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_line values('','".$id."','".$dealer[$i]."','4')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and product_id!='".$dealer[$i]."'";
                      }
                      $query="delete from #__member_product_line where member_id='".$id."' ".$del." and business_type='4'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //manufacturer of -- Multiple select
                      $manufacturer = $_POST['product_line_manufacturer_of'];
                      $total=count($manufacturer);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_line where member_id='".$id."' and product_id='".$manufacturer[$i]."' and business_type='5'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_line values('','".$id."','".$manufacturer[$i]."','5')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and product_id!='".$manufacturer[$i]."'";
                      }
                      $query="delete from #__member_product_line where member_id='".$id."' ".$del." and business_type='5'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //indentor of -- Multiple select
                      $indentor = $_POST['product_line_indentor_of'];
                      $total=count($indentor);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_line where member_id='".$id."' and product_id='".$indentor[$i]."' and business_type='6'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_line values('','".$id."','".$indentor[$i]."','6')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and product_id!='".$indentor[$i]."'";
                      }
                      $query="delete from #__member_product_line where member_id='".$id."' ".$del." and business_type='6'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //assembler of -- Multiple select
                      $assembler = $_POST['product_line_assembler_of'];
                      $total=count($assembler);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_line where member_id='".$id."' and product_id='".$assembler[$i]."' and business_type='7'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_line values('','".$id."','".$assembler[$i]."','7')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and product_id!='".$assembler[$i]."'";
                      }
                      $query="delete from #__member_product_line where member_id='".$id."' ".$del." and business_type='7'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //service_provider of -- Multiple select
                      $service_provider = $_POST['product_line_service_provider_of'];
                      $total=count($service_provider);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_line where member_id='".$id."' and product_id='".$service_provider[$i]."' and business_type='8'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_line values('','".$id."','".$service_provider[$i]."','8')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and product_id!='".$service_provider[$i]."'";
                      }
                      $query="delete from #__member_product_line where member_id='".$id."' ".$del." and business_type='8'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //impoter of country -- Multiple select
                      $impoter_of_country = $_POST['product_line_impoter_of_country'];
                      $total=count($impoter_of_country);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_country where member_id='".$id."' and country_id='".$impoter_of_country[$i]."' and business_type='1'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_country values('','".$id."','".$impoter_of_country[$i]."','1')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and country_id!='".$impoter_of_country[$i]."'";
                      }
                      $query="delete from #__member_product_country where member_id='".$id."' ".$del." and business_type='1'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //expoter of country -- Multiple select
                      $expoter_of_country = $_POST['product_line_expoter_of_country'];
                      $total=count($expoter_of_country);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_country where member_id='".$id."' and country_id='".$expoter_of_country[$i]."' and business_type='2'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_country values('','".$id."','".$expoter_of_country[$i]."','2')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and country_id!='".$expoter_of_country[$i]."'";
                      }
                      $query="delete from #__member_product_country where member_id='".$id."' ".$del." and business_type='2'";
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);

                      //Business Type -- Multiple select
                      $business = $_POST['business_type'];
                      $total=count($business);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select * from #__member_business_type where member_id='".$id."' and business_type='".$business[$i]."'";
                           $query  =  $database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_business_type values('','".$id."','".$business[$i]."')";
                             $query  =  $database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and business_type!='".$business[$i]."'";
                      }
                      $query="delete from #__member_business_type where member_id='".$id."' ".$del;
                      $query  =  $database->replaceTablePrefix($query);
                      $res=mysql_query($query);
                                                */



        //}//end of tabselection 6
        if(!$database->addMemberTrail($id,'3',$user_id,'','',$_POST['money_receipt_no'])){
            $msg="Incorrect Member Trail Information";
            //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
        }

        //update history table
        $query="update #__member_history set "
        ." member_reg_no='".$_POST['member_reg_no']
        ."', money_receipt_no='".$_POST['money_receipt_no']
        ."', reg_date='".mosHTML::ConvertDateForDatatbase($_POST['reg_date'])
        ."', money_receipt_date='".$money_receipt_date_history
        ."' where member_id='$id'  and reg_year_id='".$_SESSION['working_reg_year_id']."' ";
        $query  =  $database->replaceTablePrefix($query);
        $history_update=mysql_query($query);

        if(!($save_tab1 && $save_tab2 && $save_tab3 && $save_tab4 && $save_tab5 && $save_tab6 && $save_tab7))
        {
                $msg="Failed to update member information";
        }
        else
            $msg="Member Information Updated Successfully";

        MemberSessionUnregister();

        mosRedirect( "index2.php?option=com_membership_edit_scci&task=editA&id=".$id."&mosmsg=".$msg );
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
             if(do_upload( $_FILES['up_file'], $image_path)){
                     $file=$_FILES['up_file'];
                     $_SESSION['folder_name']=$folder_name;

                     $_SESSION['applicant_photograph']=$file['name'][0];
                     $_SESSION['representative_photograph']=$file['name'][1];
                     $con = 1;
             }
             else
               $con = 0;
        }
        return $con;
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
       // $row = new mosMembership( $database );
       // $row->bind( $_POST );
       // $row->checkin();
        MemberSessionUnregister();
        mosRedirect("index2.php?option=com_membership_scci" );
}

// delete business line information
  function deleteBusinessLineInformation( ){
          global $database;

          $member_id = $_REQUEST['member_id'];
          $product_id = $_REQUEST['product_id']; //product id
          $businessType = $_REQUEST['businessType'];
          $member_product_id = $_REQUEST['member_product_id'];

          // delete product's information
          $queryProduct="delete from #__member_product_line where member_id='".$member_id."' and business_type='$businessType' and product_id='$product_id'";
          $queryProduct  =  $database->replaceTablePrefix($queryProduct);
          $resProduct=mysql_query($queryProduct);

          // delete country's information
          $queryCountry="delete from #__member_product_country where member_product_id='".$member_product_id."'";
          $queryCountry  =  $database->replaceTablePrefix($queryCountry);
          $resCountry=mysql_query($queryCountry);

          if ($resProduct && $resCountry )
              $msg="Business line information has been deleted successfully";
          else
              $msg="Failed to delete business line information";
          mosRedirect("index2.php?option=com_membership_edit_scci&task=editA&hidemainmenu=1&id=$member_id&mosmsg=".$msg );
  }

function MemberSessionUnregister(){
         //global
         session_unregister('id');
         //step 1
         session_unregister('type_id');
         session_unregister('member_reg_no');
         session_unregister('last_reg_year_id');
         session_unregister('is_voter');
         session_unregister('reg_date');
         session_unregister('firm_name');
         session_unregister('firm_reg_address_street');
         session_unregister('firm_reg_address_town_suburb') ;
         session_unregister('firm_reg_address_district');
         session_unregister('firm_reg_address_division');
         session_unregister('firm_reg_address_country');
         session_unregister('firm_phone');
         session_unregister('firm_fax');
         session_unregister('firm_email');
         session_unregister('firm_web');
         session_unregister('firm_mobile');
         session_unregister('head_office_address_street');
         session_unregister('head_office_address_town_suburb');
         session_unregister('head_office_address_district');
         session_unregister('head_office_address_division');
         session_unregister('head_office_address_country');
         session_unregister('head_office_phone');
         session_unregister('head_office_fax');
         session_unregister('head_office_email');
         session_unregister('head_office_web');
         session_unregister('head_office_mobile');
         session_unregister('corporate_status');
         session_unregister('establishment_year');
         session_unregister('country_id');
         session_unregister('location');
         session_unregister( "employee_male" );
         session_unregister( "employee_female" );
         session_unregister( "employee_total" );
         session_unregister( "production_capacity" );

         //step 2
          session_unregister('applicant_title');
          session_unregister('applicant_name');
          session_unregister('applicant_last_name');
          session_unregister('applicant_designation');
          session_unregister('applicant_photograph');
          session_unregister('representative_photograph');
          session_unregister('representative_title');
          session_unregister('representative_name');
          session_unregister('representative_last_name');
          session_unregister('representative_designation');
          session_unregister('bank_name');
          session_unregister('bank_address');
          session_unregister('money_receipt_no');
          session_unregister('money_receipt_date');

          session_unregister('financial_local_sales_1');
          session_unregister('financial_local_sales_2');
          session_unregister('financial_local_sales_3');
          session_unregister('financial_local_sales_4');
          session_unregister('financial_local_sales_5');
          session_unregister('financial_export_sales_1');
          session_unregister('financial_export_sales_2');
          session_unregister('financial_export_sales_3');
          session_unregister('financial_export_sales_4');
          session_unregister('financial_export_sales_5');
          session_unregister('financial_turnover_volume');
          session_unregister('up_message');
          session_unregister('folder_name');
          session_unregister('applicant_photograph');
          session_unregister('representative_photograph');

          //step 3
         /* session_unregister('product_line_impoter_of');
          session_unregister('product_line_impoter_of_country');
          session_unregister('product_line_expoter_of');
          session_unregister('product_line_expoter_of_country') ;
          session_unregister('product_line_trader_of');
          session_unregister('product_line_dealer_of') ;
          session_unregister('product_line_manufacturer_of');
          session_unregister('product_line_indentor_of');
          session_unregister('product_line_assembler_of');
          session_unregister('product_line_service_provider_of');
          */session_unregister('product_line_others');
          session_unregister('trade_licence_issued_by');
          session_unregister('trade_licence_no');
          session_unregister('trade_licence_expire_date');
          session_unregister('import_reg_no');
          session_unregister('export_reg_no');
          session_unregister('indenting_trade_no');
          session_unregister('tin');
          session_unregister('factory_act_reg_no');
          session_unregister('trade_licence_issue_date');
          session_unregister('proposer1_title');
          session_unregister('proposer1_name');
          session_unregister('proposer1_last_name');
          session_unregister('proposer1_address');
          session_unregister('proposer1_member_reg_no');
          session_unregister('proposer2_title');
          session_unregister('proposer2_name');
          session_unregister('proposer2_address');
          session_unregister('proposer2_member_reg_no');

          session_unregister('importer_selected');
          session_unregister('exporter_selected');
          session_unregister('indentor_selected');
          //session_unregister('business_type');
}
?>
