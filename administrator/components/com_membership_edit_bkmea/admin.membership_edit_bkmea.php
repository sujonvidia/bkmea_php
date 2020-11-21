<?php
/**
* @version $Id: admin.membership_edit_bkmea.php,v 1.18 2007/01/22 09:16:41 morshed Exp $
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
        $query =  "SELECT count(*) FROM #__member AS m"
                . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
                . (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
                . ( count( $where ) ? " and m.is_delete!=1 and $sub " : " where m.is_delete!=1 and $sub " )
                ;
        $database->setQuery( $query );
        $total = $database->loadResult();

        require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit  );

        $query = "SELECT m.*, mt.name AS type, mc.name as category,"
        . "\n u.name AS editor, m.firm_name AS firm_name"
        . "\n FROM #__member AS m "
        . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
        . "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
        . "\n LEFT JOIN #__member_category AS mc ON mc.id = m.member_category_id"
        . "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
        . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
        . ( count( $where ) ? " and m.is_delete!=1 and $sub " : " where m.is_delete!=1 and $sub " )
        //. "\n ORDER BY m.type_id, m.ordering"
        . "\n ORDER BY CAST(m.member_reg_no AS UNSIGNED) ASC"
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
function editMembershipA( $option, $id ) {
        global $database, $my, $dbconn,$opt;

        //switch($_POST['step']){
             //case 0: {
                //MemberSessionUnregister();
                if( $id!=0){
                     $sql_query1  =  "select * from #__member where id ='$id'";
                     $sql_query1  =  $database->replaceTablePrefix($sql_query1);
                     $dbconn->setFetchMode(DB_FETCHMODE_ASSOC);
                     $res =& $dbconn->query($sql_query1);
                     $row =& $res->fetchRow();
                     foreach ($row as $key => $value) {
                        $_SESSION[$key] = stripslashes($value);
                     }


                     //Registration year
                     $sql_query2  =  "select * from #__member_directors_info where member_id ='$id'";
                     $sql_query2  = $database->replaceTablePrefix($sql_query2);
                     $res  = & $dbconn->query($sql_query2);
                     $i = 1;
                     while ($res->fetchInto($row2)) {
                       foreach ($row2 as $key => $value) {
                         $key = "d_".$i."_".$key;
                         $_SESSION[$key] = stripslashes($value);
                       }
                       $i++;
                     }

                     if(!isset($opt) || $opt!="add_d"){
                         if ($i<6)
                             $_SESSION['total_director']=6 ;
                         else
                             $_SESSION['total_director'] = $i;
                     }


                     //export
                     $sql_query3  =  "select * from #__member_export_list where member_id ='$id'";
                     $sql_query3=$database->replaceTablePrefix($sql_query3);
                     $res  = & $dbconn->query($sql_query3);
                     $i = 1;
                     while ($res->fetchInto($row3)) {
                       foreach ($row3 as $key => $value) {
                         $key = "e_".$i."_".$key;
                         $_SESSION[$key] = stripslashes($value);
                       }
                       $i++;
                     }
                     if(!isset($opt) || $opt!="add_e"){
                         $_SESSION['total_expoter'] = $i;
                     }

                     // machine
                    //
                    /*
                     $sql_query5  =  "select * from #__machine order by id";
                     $sql_query5=$database->replaceTablePrefix($sql_query5);
                     $res  = & $dbconn->query($sql_query5);
                     $i = 1;
                     $machine_id=array();
                     while ($res->fetchInto($row5)) {
                         array_push($machine_id,$row5->id);

                       foreach ($row5 as $key => $value) {
                         $key = "m_".$i."_".$key;
                         $_SESSION[$key] = stripslashes($value);

                       }
                       $i++;
                     }

                       $_SESSION['total_machine'] = $i;

                     $machine_id=implode(',',$machine_id);
                     $sql_query4  =  "select * from #__member_machine where member_id ='$id' order by machine_id";
                     $sql_query4=$database->replaceTablePrefix($sql_query4);
                     $res  = & $dbconn->query($sql_query4);
                     $i = 1;
                     while ($res->fetchInto($row4)) {
                       foreach ($row4 as $key => $value) {
                         $key = "mm_".$i."_".$key;
                         $_SESSION[$key] = stripslashes($value);

                       }
                       $i++;
                     }

                      $_SESSION['total_member_machine'] = $i;
                      */

                     $sql_query4  =  "select * from #__member_machine where member_id ='$id'";
                     $sql_query4=$database->replaceTablePrefix($sql_query4);
                     $res  = & $dbconn->query($sql_query4);
                     $i = 1;
                     while ($res->fetchInto($row4)) {
                       foreach ($row4 as $key => $value) {
                         $key = "m_".$i."_".$key;
                         $_SESSION[$key] = stripslashes($value);

                       }
                       $i++;
                     }

                       if(!isset($opt) || $opt!="add_m"){

                       if ($i<4)
                             $_SESSION['total_member_machine']=4 ;
                         else
                             $_SESSION['total_member_machine'] = $i;

                     }



                     //manufacturer of
                     $query="select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id from #__member_product_line as mpl,#__product_line as pl"
                            ." where mpl.product_id=pl.id and mpl.business_type='3' and mpl.member_id='$id'";
                     $database->setQuery( $query );
                     $rows_manufacturer = $database->loadObjectList();
                     //product information of
                    /* $query="select mpl.product_id as id from #__member_product_line as mpl"
                            ." where mpl.member_id='$id'";
                     $query=$database->replaceTablePrefix($query);
                     $res =mysql_query($query);
                     $i=0;
                     while($row=mysql_fetch_array($res)){
                        $product_list[$i]=$row["id"];
                        $i++;
                     }
                     $_SESSION['product_list'] =$product_list;
                     */
                     //compliance information of
                     $query="select compliance_id as id from #__member_compliance_list"
                            ." where member_id='$id'";
                     $query=$database->replaceTablePrefix($query);
                     $res =mysql_query($query);
                     $i=0;
                     while($row=mysql_fetch_array($res)){
                        $compliance_list[$i]=$row["id"];
                        $i++;
                     }
                     $_SESSION['compliance_list'] =$compliance_list;

                     }

                     $Association_list=array();
                     $query="select association_id as id from #__member_association"
                            ." where member_id='$id'";
                     $query=$database->replaceTablePrefix($query);
                     $res =mysql_query($query);
                     $i=0;
                     while($row=mysql_fetch_array($res)){
                        $Association_list[$i]=$row["id"];
                        $i++;
                     }
                     $_SESSION['association_list'] =$Association_list;


         if($opt=="add_d"){
                      $total_director=$_SESSION['total_director'];
                      $_SESSION['total_director']=$total_director+1;
                        $opt="";
         }

         if($opt=="add_e"){
            $total_expoter=$_SESSION['total_expoter'];
            $_SESSION['total_expoter']=$total_expoter+1;
            $opt="";
        }

        if($opt=="add_m"){
            $total_member_machine=$_SESSION['total_member_machine'];
            $_SESSION['total_member_machine']=$total_member_machine+1;
            $opt="";
        }
               $query = "SELECT * from #__enclosure where published='1' order by id";
                    $database->setQuery( $query );
                    $rows = $database->loadObjectList();


               $query = "SELECT * from #__member_enclosure where member_id='$id' order by enclosure_id";
                    $database->setQuery( $query );
                    $member_inc = $database->loadObjectList();

        $lists = array();
        $lists['member_status']             = mosHTML::yesnoRadioList( 'member_status', 'class="inputbox"', $_SESSION['member_status'],'Permanent','Temporary' );
        //$lists['is_voter']                  = mosHTML::yesnoRadioList( 'is_voter', 'class="inputbox"', $_SESSION['is_voter'] );
        $lists['is_direct_export']          = mosHTML::yesnoRadioList( 'is_direct_export', 'class="inputbox"', $_SESSION['is_direct_export'] );
        // build list of categories
        $lists['type_id']                   = mosAdminMenus::MemberType( 'type_id', $option, intval( $_SESSION['type_id'] ) );
        $lists['member_category_id']        = mosAdminMenus::MemberCategory( 'member_category_id', $option, intval( $_SESSION['member_category_id'] ) );
        // build list of categories
        $lists['last_reg_year_id']          = mosAdminMenus::RegYear( 'last_reg_year_id',  intval( $_SESSION['last_reg_year_id'] ), 'disabled' );
        // build list of designation
        $lists['designation']               = mosAdminMenus::Designation( 'designation',  intval( $_SESSION['designation'] ) );
        $lists['location']                     = mosAdminMenus::Location( 'location', $_SESSION['location']  );


        $lists['applicant_title']             = mosAdminMenus::MemberTitle( 'applicant_title',$_SESSION['applicant_title'] );
        $lists['applicant_designation']   = mosAdminMenus::Designation( 'applicant_designation',  intval( $_SESSION['applicant_designation'] ));

        $lists['representative_title']             = mosAdminMenus::MemberTitle( 'representative_title',$_SESSION['representative_title'] );
        $lists['representative_designation']   = mosAdminMenus::Designation( 'representative_designation',  intval( $_SESSION['representative_designation']),'','','',1,1);

        $lists['proposer_one_title']             = mosAdminMenus::MemberTitle( 'proposer_one_title',$_SESSION['proposer_one_title'] );
        $lists['proposer_two_title']             = mosAdminMenus::MemberTitle( 'proposer_two_title',$_SESSION['proposer_two_title'] );
        $lists['proposer_one_designation'] = mosAdminMenus::Designation( 'proposer_one_designation',  intval( $_SESSION['proposer_one_designation'] ));
        $lists['proposer_two_designation'] = mosAdminMenus::Designation( 'proposer_two_designation',  intval( $_SESSION['proposer_two_designation'] ));

        //$lists['machine'] = mosAdminMenus::Machine( 'machine',  0 );
        $lists['product_list']               = mosAdminMenus::MultipleProductList( 'product_list[]', 'product_list' );
        $lists['compliance_list']              = mosAdminMenus::ComplianceList( 'compliance_list[]', 'compliance_list' );
        $lists['association_list']              = mosAdminMenus::MultipleAssociationList( 'association_list[]', 'association_list' );


        //get registration date from member_reg_year table;
        $query=  "select start_date,end_date from #__member_reg_year "
                ."\n where id='".$_SESSION['last_reg_year_id']."'"
                ;
        $database->setQuery($query);
        $res=$database->loadObjectList();
        $start_date=mosHTML::ConvertDateDisplayShort($res[0]->start_date);
        $end_date=mosHTML::ConvertDateDisplayShort($res[0]->end_date);


        HTML_Membership::editMembershipA($member_inc,$rows, $lists, $option, $id, $start_date, $end_date,$rows_manufacturer);
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

        if ($_POST[tabselection]=="0")
        {
               //association  list of -- Multiple select
               $association_list = $_POST['association_list'];
               $total=count($association_list);
               $del="";
               for ($i=0;$i<$total;$i++) {
                    $query="Select id from #__member_association where member_id='".$id."' and association_id='".$association_list[$i]."'";
                    $query=$database->replaceTablePrefix($query);
                    $res=mysql_query($query);
                    if(mysql_num_rows($res)==0){
                      $query="insert into #__member_association values('','".$id."','".$association_list[$i]."')";
                      $query=$database->replaceTablePrefix($query);
                      $res=mysql_query($query);
                    }
                    $del.=" and association_id!='".$association_list[$i]."'";
               }
               $query="delete from #__member_association where member_id='".$id."' ".$del;
               $database->setQuery($query);
               $con=$database->query();

                // Query for check duplicate Member Registration Number
                $query="select member_reg_no from #__member  "
                //."\n Left join #__member as m on m.id=mh.member_id"
                //."\n join #__member_type as mt on mt.id=m.type_id"
                //."\n join #__member_category as mc on mc.id=m.member_category_id"
                ." \n where member_reg_no='".$_POST['member_reg_no']
                //." \n ' and reg_year_id='".$_SESSION['working_reg_year_id']
                ."' "
                //."\n and m.type_id='".$_POST['type_id']."' and m.member_category_id='".$_POST['member_category_id']."'"
                ;

                $query  =  $database->replaceTablePrefix($query);
                 $result=mysql_query($query) or die(mysql_error());
                 if ($_SESSION['member_reg_no']!=$_POST['member_reg_no']){
                    if (intval($_POST['member_reg_no'])!=0 && mysql_num_rows($result)>0){
                    echo "<script> alert('Member Registration No Already Exist'); window.history.go(-1); </script>\n";
                    exit();
                    //$msg="Membership No. ".$_POST['member_reg_no']." Already Exist";
                    //mosRedirect( "index2.php?option=$option&task=new&mosmsg=".$msg );
                    }
                 }
                  // Query for check duplicate Money Receipt Number
                 $sql_query2="select * from #__member_trail where money_receipt_no ='".$_POST['money_receipt_no']."'";
                 $database->setQuery($sql_query2);
                 $total_row=$database->loadResult();
                 if ($_SESSION['money_receipt_no']!=$_POST['money_receipt_no']){
                     if(count($total_row)>0 ) {
                         echo "<script> alert('This Money Receipt No is already Exist\'s'); window.history.go(-1); </script>\n";
                         exit();
                     //$msg="Money Receipt No. ".$_POST['money_receipt_no']." Already Exist";
                     //mosRedirect( "index2.php?option=$option&task=new&mosmsg=".$msg );
                     }
                 }
                 //check member is renewed or new
				$sql = "select count(id) from #__member_history where member_id='".$id."' and entry_type='2'";
				$database->setQuery($sql);
				$isRenewal = intval($database->loadResult());				
				$subQuery = "";
				if(!$isRenewal){
					$subQuery  = "',reg_date='".mosHTML::ConvertDateForDatatbase($_POST['last_reg_date']);
				}
				
                $sql_query= "update #__member set type_id='".$_POST['type_id']
                      ."',member_reg_no='". $_POST['member_reg_no']
                      ."',last_reg_date='".mosHTML::ConvertDateForDatatbase($_POST['last_reg_date'])
                      .$subQuery
                      ."',firm_name='".$_POST['firm_name']
                      ."',applicant_title='".$_POST['applicant_title']
                      ."',applicant_name='".$_POST['applicant_name']
                      ."',applicant_last_name='".$_POST['applicant_last_name']
                      ."',applicant_designation='".$_POST['applicant_designation']
                      ."',applicant_home_phone='".$_POST['applicant_home_phone']
                      ."',applicant_office_phone='".$_POST['applicant_office_phone']
                      ."',office_phone='".$_POST['office_phone']
                      ."',member_category_id='".$_POST['member_category_id']
                      ."',member_status='".$_POST['member_status']
                      ."',money_receipt_no='".$_POST['money_receipt_no']
                      ."',money_receipt_date='".mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date'])
                      ."',commencing_date='".mosHTML::ConvertDateForDatatbase($_POST['commencing_date'])
                      ."',is_direct_export='".$_POST['is_direct_export']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);

                      $msg="Failed to Update Membership Information";

                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                             exit();

                      }
                      else $msg="General in Profile is updated Succesfully";

                      if(!$database->addMemberTrail($id,'3',$user_id,'','',$_POST['money_receipt_no'])){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }

                      //update history table
                      $query="update #__member_history set "
                             ." member_reg_no='".$_POST['member_reg_no']
                             ."', money_receipt_no='".$_POST['money_receipt_no']
                             ."' where member_id='$id' and entry_type='1'";
                      $query  =  $database->replaceTablePrefix($query);


                    // echo $query;
                      if(!mysql_query($query)) {
                           echo "<script> alert('Fail TO Update Membership History'); window.history.go(-1); </script>\n";
                             exit();

                      }



        }       /// end of tabselection ==0
        else if ($_POST[tabselection]=="1")
        {
                $sql_query= "update #__member set applicant_address_street='".$_POST['applicant_address_street']
                      ."',applicant_address_town_suburb='".$_POST['applicant_address_town_suburb']
                      ."',applicant_address_district='".$_POST['applicant_address_district']
                      ."',applicant_address_division='".$_POST['applicant_address_division']
                      ."',applicant_address_country='".$_POST['applicant_address_country']
                      ."',applicant_fax='". $_POST['applicant_fax']
                      ."',applicant_mobile='". $_POST['applicant_mobile']
                      ."',applicant_email='". $_POST['applicant_email']
                      ."',applicant_web='". $_POST['applicant_web']
                      ."',office_address_street='".$_POST['office_address_street']
                      ."',office_address_town_suburb='".$_POST['office_address_town_suburb']
                      ."',office_address_district='".$_POST['office_address_district']
                      ."',office_address_division='".$_POST['office_address_division']
                      ."',office_address_country='".$_POST['office_address_country']
                      ."',office_fax='". $_POST['office_fax']
                      ."',office_mobile='". $_POST['office_mobile']
                      ."',office_email='".$_POST['office_email']
                      ."',office_web='".$_POST['office_web']
                      ."',location='".$_POST['location']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);



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
                      $investment_temp=bcmul($_POST['investment'],1000000,3);
                      if (intval($investment_temp)==bcadd($investment_temp,0,3))
                          $investment=intval($investment_temp);
                      else
                          $investment=bcadd($investment_temp,0,3);

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
                      ."',investment='".$investment
                      ."',employee_female='".$_POST['employee_female']
                      ."',employee_total='".$_POST['employee_total']
                      ."',production_capacity='".$_POST['production_capacity']
                      ."',machine_number='".$_POST['machine_number']
                      ."',production_unit='".$_POST['production_unit']
                      ."',location='".$_POST['location']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";


                      $sql_query  =  $database->replaceTablePrefix($sql_query);



                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                             exit();

                      }else $msg="Capacity in Profile is updated Succesfully";

                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }




                   for($i=1; $i<=$_SESSION['total_member_machine']; $i++){
                       $machine_id="m_".$i."_id";
                       $machine_name="m_".$i."_machine_name";
                       $quantity="m_".$i."_quantity";

                       //$_SESSION[$machine_name]          = $_POST[$machine_name];
                       //$_SESSION[$quantity]  = $_POST[$quantity];

                       if ($_SESSION[$machine_id]!="" && $_POST[$machine_name]!="")
                       {
                                $query="update #__member_machine set quantity='".$_POST[$quantity]
                                   ."', machine_name='".$_POST[$machine_name]
                                   ."' where id='".$_SESSION[$machine_id]."' and member_id='$id'"
                                   ;
                                   $query=$database->replaceTablePrefix($query);
                                   mysql_query($query);
                                   echo $query;
                       }
                       else if ($_SESSION[$machine_id]!="" && $_POST[$machine_name]=="")
                       {
                               $query="delete from #__member_machine where id='".$_SESSION[$machine_id]."' and member_id='$id'"
                               ;
                               $query=$database->replaceTablePrefix($query);

                               mysql_query($query);
                       }
                       else if (trim($_POST[$machine_name])!="")
                       {
                          $query="insert into #__member_machine values('','$id','$_POST[$machine_name]','$_POST[$quantity]')";
                           $query=$database->replaceTablePrefix($query);
                             mysql_query($query);
                       }

                   }
                                           /*

                      for($i=1; $i<=$_SESSION['total_director']; $i++){
                            $d_id = "d_".$i."_id";
                            $director_name = "d_".$i."_name";
                            $director_office_phone = "d_".$i."_home_phone";
                            $director_home_phone = "d_".$i."_office_phone";

                             if($_SESSION[$director_name]!="" && $_SESSION[$d_id] != ""){
                                     $query="update #__member_directors_info set name='".$_SESSION[$director_name]
                                     ."',home_phone='".$_SESSION[$director_home_phone]
                                     ."',office_phone='".$_SESSION[$director_office_phone]
                                     ."' where id='".$_SESSION[$d_id]
                                     ."'";
                                     $query=$database->replaceTablePrefix($query);
                                     mysql_query($query);
                             }
                             if($_SESSION[$director_name]=="" && $_SESSION[$d_id] != ""){
                                     $query="delete from #__member_directors_info where id='".$_SESSION[$d_id]."'";
                                     $database->setQuery($query);
                                     $con=$database->query();
                             }
                             if($_SESSION[$director_name]!="" && INTVAL($_SESSION[$d_id])== 0)
                             {
                                     $query="insert into #__member_directors_info values('','".$id."','".$_SESSION[$director_name]."','".$_SESSION[$director_home_phone]."','".$_SESSION[$director_office_phone]."')";
                                     $query=$database->replaceTablePrefix($query);
                                     mysql_query($query);
                             }
                      }



                       $j=1;
                      for($i=1; $i<=$_SESSION['total_machine']; $i++){
                                        //$m_machine_id = "m_".$i."_machine_id";
                                 $machine_id="m_".$i."_id";
                                 $m_machine_id="mm_".$j."_machine_id";
                                 $machine_name="m_".$i."_machine_type";
                                 $m_quantity="mm_".$i."_quantity";

                               //  echo $_SESSION[$machine_id]."-".$_SESSION[$m_machine_id]."\n";
                                        if (($_SESSION[$machine_id]==$_SESSION[$m_machine_id]) && ($_POST[$m_quantity]!=""))
                                           {
                                              $query="update #__member_machine set quantity='".$_POST[$m_quantity]
                                                 ."' where machine_id='".$_SESSION[$m_machine_id]."' and member_id='$id'"
                                                 ;
                                                 $query=$database->replaceTablePrefix($query);
                                                 mysql_query($query);

                                              $j++;
                                           }


                                           else if (($_SESSION[$machine_id]==$_SESSION[$m_machine_id]) && (intval($_POST[$m_quantity])==0))
                                           {
                                              $query="delete from #__member_machine where machine_id='".$_SESSION[$m_machine_id]."' and member_id='$id'"
                                                 ;
                                               $query=$database->replaceTablePrefix($query);

                                                 mysql_query($query);

                                              $j++;
                                           }
                                           else if ((intval($_POST[$m_quantity])!=0))
                                           {
                                              $query="insert into #__member_machine values('','$id','$_SESSION[$machine_id]','$_POST[$m_quantity]')";


                                               $query=$database->replaceTablePrefix($query);

                                                 mysql_query($query);


                                           }
                      }

                       for($i=1; $i<=$_SESSION['total_member_machine']; $i++){
                                        //$m_machine_id = "m_".$i."_machine_id";
                                 $machine_id="m_".$i."_id";
                                 $m_machine_id="mm_".$j."_machine_id";
                                 $machine_name="m_".$i."_machine_type";
                                 $m_quantity="mm_".$i."_quantity";

                               //  echo $_SESSION[$machine_id]."-".$_SESSION[$m_machine_id]."\n";
                                        if (($_SESSION[$machine_id]==$_SESSION[$m_machine_id]) && ($_POST[$m_quantity]!=""))
                                           {
                                              $query="update #__member_machine set quantity='".$_POST[$m_quantity]
                                                 ."' where machine_id='".$_SESSION[$m_machine_id]."' and member_id='$id'"
                                                 ;
                                                 $query=$database->replaceTablePrefix($query);
                                                 mysql_query($query);

                                              $j++;
                                           }


                                           else if (($_SESSION[$machine_id]==$_SESSION[$m_machine_id]) && (intval($_POST[$m_quantity])==0))
                                           {
                                              $query="delete from #__member_machine where machine_id='".$_SESSION[$m_machine_id]."' and member_id='$id'"
                                                 ;
                                               $query=$database->replaceTablePrefix($query);

                                                 mysql_query($query);

                                              $j++;
                                           }
                                           else if ((intval($_POST[$m_quantity])!=0))
                                           {
                                              $query="insert into #__member_machine values('','$id','$_SESSION[$machine_id]','$_POST[$m_quantity]')";


                                               $query=$database->replaceTablePrefix($query);

                                                 mysql_query($query);


                                           }
                      } */


        } //end of tabselection 2
        else if ($_POST[tabselection]=="3")
        {


                $sql_query= "update #__member set representative_title='".$_POST['representative_title']
                      ."',representative_name='".$_POST['representative_name']
                      ."',representative_last_name='".$_POST['representative_last_name']
                      ."',representative_designation='".$_POST['representative_designation']
                      ."',representative_mobile='".$_POST['representative_mobile']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);



                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                             exit();

                      }
                      $msg="Representative Information in Profile is updated Succesfully";


                       for($i=1; $i<=$_SESSION['total_director']; $i++){
                       $director_id = "d_".$i."_id";
                       $director_name = "d_".$i."_name";
                       $director_office_phone ="d_".$i."_office_phone";
                       $director_home_phone =  "d_".$i."_home_phone";

                       $_SESSION[$director_name]          = $_POST[$director_name];
                       $_SESSION[$director_office_phone]  = $_POST[$director_office_phone];
                       $_SESSION[$director_home_phone]    = $_POST[$director_home_phone];
                   }

                      for($i=1; $i<=$_SESSION['total_director']; $i++){
                            $d_id = "d_".$i."_id";
                            $director_name = "d_".$i."_name";
                            $director_office_phone = "d_".$i."_office_phone";
                            $director_home_phone =  "d_".$i."_home_phone";

                             if($_SESSION[$director_name]!="" && $_SESSION[$d_id] != ""){
                                     $query="update #__member_directors_info set name='".$_SESSION[$director_name]
                                     ."',home_phone='".$_SESSION[$director_home_phone]
                                     ."',office_phone='".$_SESSION[$director_office_phone]
                                     ."' where id='".$_SESSION[$d_id]
                                     ."'";
                                     $query=$database->replaceTablePrefix($query);
                                     mysql_query($query);
                             }
                             if($_SESSION[$director_name]=="" && $_SESSION[$d_id] != ""){
                                     $query="delete from #__member_directors_info where id='".$_SESSION[$d_id]."'";
                                     $database->setQuery($query);
                                     $con=$database->query();
                             }
                             if($_SESSION[$director_name]!="" && INTVAL($_SESSION[$d_id])== 0)
                             {
                                     $query="insert into #__member_directors_info values('','".$id."','".$_SESSION[$director_name]."','".$_SESSION[$director_home_phone]."','".$_SESSION[$director_office_phone]."')";
                                     $query=$database->replaceTablePrefix($query);
                                     mysql_query($query);
                             }
                      }


                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }



        }// end of tabselection 3
        else if ($_POST[tabselection]=="4")
        {
                $sql_query= "update #__member set trade_licence_issued_by='".$_POST['trade_licence_issued_by']
                      ."',trade_licence_no='".$_POST['trade_licence_no']
                      ."',trade_licence_expire_date='".mosHTML::ConvertDateForDatatbase($_POST['trade_licence_expire_date'])
                      ."',trade_licence_issue_date='".mosHTML::ConvertDateForDatatbase($_POST['trade_licence_issue_date'])
                      ."',import_reg_no_expire_date='".mosHTML::ConvertDateForDatatbase($_POST['import_reg_no_expire_date'])
                      ."',export_reg_no_expire_date='".mosHTML::ConvertDateForDatatbase($_POST['export_reg_no_expire_date'])
                      ."',bond_licence_issue_date='".mosHTML::ConvertDateForDatatbase($_POST['bond_licence_issue_date'])
                      ."',vat_reg_issue_date='".mosHTML::ConvertDateForDatatbase($_POST['vat_reg_issue_date'])
                      ."',import_reg_no='".$_POST['import_reg_no']
                      ."',bond_licence_no='".$_POST['bond_licence_no']
                      ."',vat_reg_no='".$_POST['vat_reg_no']
                      ."',export_reg_no='".$_POST['export_reg_no']
                      ."',indenting_trade_no='".$_POST['indenting_trade_no']
                      ."',tin='".$_POST['tin']
                    //  ."',factory_act_reg_no='".$_POST['factory_act_reg_no']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);



                      if(!mysql_query($sql_query)) {
                         echo "<script> alert('Fail TO Update Membership Profile'); window.history.go(-1); </script>\n";
                             exit();

                      }else $msg="License Information in Profile is updated Succesfully";

                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }



        } // end of tabselection 4
        else if ($_POST[tabselection]=="5")
        {
                      $sql_query= "update #__member set proposer_one_title='".$_POST['proposer_one_title']
                      ."',proposer_one_name='".$_POST['proposer_one_name']
                      ."',proposer_one_last_name='".$_POST['proposer_one_last_name']
                      ."',proposer_one_address='".$_POST['proposer_one_address']
                      ."',proposer_one_member_reg_no='".$_POST['proposer_one_member_reg_no']

                      ."',proposer_two_title='".$_POST['proposer_two_title']
                      ."',proposer_two_name='".$_POST['proposer_two_name']
                      ."',proposer_two_last_name='".$_POST['proposer_two_last_name']
                      ."',proposer_two_address='".$_POST['proposer_two_address']
                      ."',proposer_two_member_reg_no='".$_POST['proposer_two_member_reg_no']
                      ."',date='".$current_date_time
                      ."',checked_out='0' where id='$id'";

                      $sql_query  =  $database->replaceTablePrefix($sql_query);

                      if(!mysql_query($sql_query)) {
                       //  echo "<script> alert('Fail to Update Membership Profile'); window.history.go(-1); </script>\n";
                         echo $sql_query;
                         exit();

                      }else $msg="Propsers\' Information in Profile are updated Succesfully";

                      if(!$database->addMemberTrail($id,'3',$user_id)){
                           $msg="Incorrect Member Trail Information";
                           //mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
                      }


        }// end of tabselection 5
        else if ($_POST[tabselection]=="6")
        {
                      //product list of -- Multiple select
                      /*$product_list = $_POST['product_list'];
                      $total=count($product_list);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_product_line where member_id='".$id."' and product_id='".$product_list[$i]."'";
                           $query=$database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_product_line values('','".$id."','".$product_list[$i]."','0')";
                             $query=$database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and product_id!='".$product_list[$i]."'";
                      }
                      $query="delete from #__member_product_line where member_id='".$id."' ".$del;
                      $database->setQuery($query);
                      $con=$database->query();
                      */
                      //compliance_list of -- Multiple select
                      $compliance_list = $_POST['compliance_list'];
                      $total=count($compliance_list);
                      $del="";
                      for ($i=0;$i<$total;$i++) {
                           $query="Select id from #__member_compliance_list where member_id='".$id."' and compliance_id='".$compliance_list[$i]."'";
                           $query=$database->replaceTablePrefix($query);
                           $res=mysql_query($query);
                           if(mysql_num_rows($res)==0){
                             $query="insert into #__member_compliance_list values('','".$id."','".$compliance_list[$i]."')";
                             $query=$database->replaceTablePrefix($query);
                             $res=mysql_query($query);
                           }
                           $del.=" and compliance_id!='".$compliance_list[$i]."'";
                      }
                      $query="delete from #__member_compliance_list where member_id='".$id."' ".$del;
                      $database->setQuery($query);
                      $con=$database->query();

                       for($i=1; $i<=$_SESSION['total_expoter']; $i++){
                           $e_id = "e_".$i."_id";
                           $e_lc_number = "e_".$i."_lc_number";
                           $e_lc_date = "e_".$i."_lc_date";
                           $e_importer_name = "e_".$i."_importer_name";
                           $e_country_id = "e_".$i."_country_id";
                           $e_cat_no_id = "e_".$i."_cat_no_id";
                           $e_quantity = "e_".$i."_quantity";
                           $e_amount = "e_".$i."_amount";

                           $_SESSION[$e_lc_number]       = $_POST[$e_lc_number];
                           $_SESSION[$e_lc_date]         = mosHTML::ConvertDateForDatatbase($_POST[$e_lc_date]);
                           $_SESSION[$e_importer_name]   = $_POST[$e_importer_name];
                           $_SESSION[$e_country_id]      = $_POST[$e_country_id];
                           $_SESSION[$e_cat_no_id]       = $_POST[$e_cat_no_id];
                           $_SESSION[$e_quantity]        = $_POST[$e_quantity];
                           $_SESSION[$e_amount]          = $_POST[$e_amount];

                       }

                      for($i=1; $i<=$_SESSION['total_expoter']; $i++){
                           $e_id = "e_".$i."_id";
                           $e_lc_number = "e_".$i."_lc_number";
                           $e_lc_date = "e_".$i."_lc_date";
                           $e_importer_name = "e_".$i."_importer_name";
                           $e_country_id = "e_".$i."_country_id";
                           $e_cat_no_id = "e_".$i."_cat_no_id";
                           $e_quantity = "e_".$i."_quantity";
                           $e_amount = "e_".$i."_amount";


                        if($_SESSION[$e_lc_number]!="" && $_SESSION[$e_id] != ""){
                              $query="update #__member_export_list set lc_number='".$_SESSION[$e_lc_number]
                                  ."',lc_date='" .$_SESSION[$e_lc_date]
                                  ."',importer_name='".$_SESSION[$e_importer_name]
                                  ."',country_id='".$_SESSION[$e_country_id]
                                  ."',cat_no_id='".$_SESSION[$e_cat_no_id]
                                  ."',quantity='".$_SESSION[$e_quantity]
                                  ."',amount='".$_SESSION[$e_amount]
                                  ."' where id='".$_SESSION[$e_id]
                                  ."'";
                                  $query=$database->replaceTablePrefix($query);
                                  mysql_query($query);
                                     }
                           if($_SESSION[$e_lc_number]=="" && $_SESSION[$e_id] != ""){
                              $query="delete from #__member_export_list where id='".$_SESSION[$e_id]."'";
                              $query=$database->replaceTablePrefix($query);
                              $database->setQuery($query);
                              $con=$database->query();
                           }
                           if($_SESSION[$e_lc_number]!="" && intval($_SESSION[$e_id])==0){
                              $query="insert into #__member_export_list values('','".$id."','".$_SESSION[$e_lc_number]."','".$_SESSION[$e_lc_date]."','".$_SESSION[$e_importer_name]."','".$_SESSION[$e_country_id]."','".$_SESSION[$e_cat_no_id]."','".$_SESSION[$e_quantity]."','".$_SESSION[$e_amount]."')";
                              $query=$database->replaceTablePrefix($query);
                              mysql_query($query);
                           }

                     }
                      $msg='Business Line Information is updated successfully';



        }//end of tabselection 6 :: enclosure
        else if ($_POST[tabselection]=="7")
        {

                      $query="delete from #__member_enclosure where member_id='$id' ";
                      $database->setQuery($query);
                      $database->query();

                      for ($i=0;$i<count($_POST['enclosure']);$i++){
                              if (!empty($_POST['enclosure'][$i])){
                                  $query="insert into #__member_enclosure (member_id,enclosure_id,enclosure_rule)"
                                          ." values('".$id."','".$_POST['enclosure'][$i]."','1')";

                                  $query  =  $database->replaceTablePrefix($query);
                                  $result=mysql_query($query) or die(mysql_error());
                              }
                      }

              /*

              for ($i=0;$i<count($_POST['enclosure']);$i++){
                      if (!empty($_POST['enclosure'][$i])){
                          $query="update #__member_enclosure set enclosure_rule='1'"
                          ."\n where member_id='$id' and enclosure_id='".$_POST['enclosure'][$i]."'"
                          ;


                          $query=$database->replaceTablePrefix($query);
                         mysql_query($query);
                      }

              }
              $cids = implode( ',', $_POST['enclosure'] );

              $query="update #__member_enclosure set enclosure_rule='0'"
              ."\n where member_id='$id' and enclosure_id NOT IN ($cids)"
              ;

              $query=$database->replaceTablePrefix($query);
              mysql_query($query);
              */
              $msg="Successfully update enclosed copy information";

        }

        MemberSessionUnregister();



        mosRedirect( "index2.php?option=com_membership_edit_bkmea&task=editA&id=".$id."&mosmsg=".$msg );
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
        mosRedirect("index2.php?option=com_membership_bkmea" );
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
          mosRedirect("index2.php?option=com_membership_edit_bkmea&task=editA&hidemainmenu=1&id=$member_id&mosmsg=".$msg );
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
          session_unregister('product_line_impoter_of');
          session_unregister('product_line_impoter_of_country');
          session_unregister('product_line_expoter_of');
          session_unregister('product_line_expoter_of_country') ;
          session_unregister('product_line_trader_of');
          session_unregister('product_line_dealer_of') ;
          session_unregister('product_line_manufacturer_of');
          session_unregister('product_line_indentor_of');
          session_unregister('product_line_assembler_of');
          session_unregister('product_line_service_provider_of');
          session_unregister('product_line_others');
          session_unregister('trade_licence_issued_by');
          session_unregister('trade_licence_no');
          session_unregister('trade_licence_expire_date');
          session_unregister('import_reg_no');
          session_unregister('export_reg_no');
          session_unregister('indenting_trade_no');
          session_unregister('tin');
          session_unregister('factory_act_reg_no');
          session_unregister('trade_licence_issue_date');
          session_unregister('proposer_one_title');
          session_unregister('proposer_one_name');
          session_unregister('proposer_one_last_name');
          session_unregister('proposer_one_address');
          session_unregister('proposer_one_member_reg_no');
          session_unregister('proposer_two_title');
          session_unregister('proposer_two_name');
          session_unregister('proposer_two_address');
          session_unregister('proposer_two_member_reg_no');
           session_unregister('representative_mobile');

           for($i=1; $i<=$_SESSION['total_director']; $i++){
              $director_id = "d_".$i."_id";
              $director_name = "d_".$i."_name";
              $director_office_phone = "d_".$i."_home_phone";
              $director_home_phone = "d_".$i."_office_phone";

              session_unregister($director_id);
              session_unregister($director_name);
              session_unregister($director_office_phone);
              session_unregister($director_home_phone);
        }
        session_unregister('total_director');

        for($i=1; $i<=$_SESSION['total_expoter']; $i++){
              $e_id = "e_".$i."_id";
              $e_lc_number = "e_".$i."_lc_number";
              $e_lc_date = "e_".$i."_lc_date";
              $e_importer_name = "e_".$i."_importer_name";
              $e_country_id = "e_".$i."_country_id";
              $e_cat_no_id = "e_".$i."_cat_no_id";
              $e_quantity = "e_".$i."_quantity";
              $e_amount = "e_".$i."_amount";

              session_unregister($e_id);
              session_unregister($e_lc_number);
              session_unregister($e_lc_date);
              session_unregister($e_importer_name);
              session_unregister($e_country_id);
              session_unregister($e_cat_no_id);
              session_unregister($e_quantity);
              session_unregister($e_amount);
        }
        session_unregister('total_expoter');



        for($i=1; $i<=$_SESSION['total_member_machine']; $i++){
              $mm_id = "m_".$i."_id";
              $mm_member_id = "m_".$i."_member_id";
              $mm_machine_name = "m_".$i."_machine_name";
              $mm_quantity  ="m_".$i."_quantity";
              session_unregister($mm_id);
              session_unregister($mm_member_id);
              session_unregister($mm_machine_name);
              session_unregister($mm_quantity);

        }
        session_unregister('total_member_machine');

}
?>
