<?php
/**
* @version $Id: admin.membership_bkmea.php,v 1.34 2006/08/13 11:11:41 morshed Exp $
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
| $acl->acl_check( 'administration', 'edit', 'users', $my->usertype, 'components', 'com_membership_bkmea' ))) {
	///        mosRedirect( 'index2.php', _NOT_AUTH );
	// blocked by Team Camellia so that amm admin users can get access to this
}

require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$cid = mosGetParam( $_POST, 'cid', array(0) );
$id = mosGetParam( $_REQUEST, 'id' );
$option = mosGetParam( $_REQUEST, 'option' );

switch ($task) {
	case 'new' :
	case 'newA':
		editMembership( $option, 0 );
		break;

		/*case 'newB':
		editMembershipB( $option, 0, $task );
		break;

		case 'newC':
		editMembershipC( $option, 0 );
		break;

		case 'preview':
		previewMembership( $option, 0 );
		break; */

	case 'edit':
		//editMembership( $option, $cid[0]);
		mosRedirect('index2.php?option=com_membership_edit_bkmea&task=editA&hidemainmenu=1&id='.$cid[0]);
		break;

	case 'editA':
		//editMembership( $option, $id );
		mosRedirect('index2.php?option=com_membership_edit_bkmea&task=editA&hidemainmenu=1&id='.$id);
		break;

		/*case 'editB':
		editMembershipB( $option, $id );
		break;

		case 'editC':
		editMembershipC( $option, $id );
		break;

		case 'preview_':
		previewMembership( $option, $id );
		break;*/

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
		$where[] = "( LOWER(m.firm_name) LIKE '%$search%' OR LOWER(m.member_reg_no)='$search' ) ";
	}

	$sub="(( mh.entry_type=1 and mh.reg_year_id='".$_SESSION['working_reg_year_id']."' )"
	."\n || ( mh.entry_type=2 and mh.reg_year_id='".$_SESSION['working_reg_year_id']."' ))";

	// get the total number of records
	$query =  "SELECT count(*) FROM #__member AS m"
	. "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
	. (count( $where ) ? "\nWHERE " . implode( ' AND ', $where ) : "")
	. ( count( $where ) ? " and m.is_delete=0 and $sub " : " where m.is_delete=0 and $sub " )
	;
	$database->setQuery( $query );
	$total = $database->loadResult();

	require_once( $GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php' );
	$pageNav = new mosPageNav( $total, $limitstart, $limit  );

	$query = "SELECT m.*, mt.name AS type, mc.name as category,"
	. "\n u.name AS editor, m.firm_name AS firm_name,mh.member_reg_no as member_reg_no"
	. "\n FROM #__member AS m "
	. "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
	. "\n LEFT JOIN #__member_history AS mh ON mh.member_id = m.id"
	. "\n LEFT JOIN #__member_category AS mc ON mc.id = m.member_category_id"
	. "\n LEFT JOIN #__users AS u ON u.id = m.checked_out"
	. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
	. ( count( $where ) ? " and m.is_delete=0 and $sub " : " where m.is_delete=0 and $sub " )
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

function editMembership( $option, $id ) {
	global $database, $my, $dbconn;

	$query = "SELECT * from #__enclosure where published='1' order by id";
	$database->setQuery( $query );
	$rows = $database->loadObjectList();

	$_SESSION['last_reg_year_id']                  = $_SESSION['working_reg_year_id'];

	$lists = array();
	$lists['member_status']             = mosHTML::yesnoRadioList( 'member_status', 'class="inputbox"', 0,'Permanent','Temporary' );
	//$lists['is_voter']                  = mosHTML::yesnoRadioList( 'is_voter', 'class="inputbox"', $_SESSION['is_voter'] );
	$lists['is_direct_export']          = mosHTML::yesnoRadioList( 'is_direct_export', 'class="inputbox"', 0 );
	// build list of categories
	$lists['type_id']                   = mosAdminMenus::MemberType( 'type_id', $option,'', 1 );
	$lists['member_category_id']        = mosAdminMenus::MemberCategory( 'member_category_id', $option );
	// build list of categories
	$lists['last_reg_year_id']          = mosAdminMenus::RegYear( 'last_reg_year_id',  intval( $_SESSION['last_reg_year_id'] ), 'disabled' );
	// build list of designation
	$lists['applicant_title']             = mosAdminMenus::MemberTitle( 'applicant_title' );
	$lists['applicant_designation'] = mosAdminMenus::Designation( 'applicant_designation');
	$lists['representative_designation'] = mosAdminMenus::Designation( 'representative_designation',0,'','','',1,1);
	$lists['proposer_one_title']             = mosAdminMenus::MemberTitle( 'proposer_one_title' );
	$lists['proposer_two_title']             = mosAdminMenus::MemberTitle( 'proposer_two_title' );
	$lists['representative_title']             = mosAdminMenus::MemberTitle( 'representative_title' );
	$lists['location']                     = mosAdminMenus::Location( 'location', $_SESSION['location']  );
	//get registration date from member_reg_year table;
	$query=  "select start_date,end_date from #__member_reg_year "
	."\n where id='".$_SESSION['last_reg_year_id']."'"
	;
	$database->setQuery($query);
	$res=$database->loadObjectList();
	$start_date=mosHTML::ConvertDateDisplayShort($res[0]->start_date);
	$end_date=mosHTML::ConvertDateDisplayShort($res[0]->end_date);   //convert date

	HTML_Membership::editMembership( $rows,$lists, $option, $id, $start_date, $end_date);
}


/**
* Saves the record on an edit form submit
* @param database A database connector object
*/
function saveMembership( $option, $id=0 ) {
	global $database, $my, $dbconn, $mosConfig_absolute_path;

	$current_date_time = date( "Y-m-d H:i:s" );
	$current_date = date( "Y-m-d" );
	$user_id=$_SESSION['session_username'];

	// Query for check duplicate Member Registration Number
	$query="select member_reg_no from #__member  "
	//."\n Left join #__member as m on m.id=mh.member_id"
	//."\n join #__member_type as mt on mt.id=m.type_id"
	//."\n join #__member_category as mc on mc.id=m.member_category_id"
	."\n where member_reg_no='".$_POST['member_reg_no']."'"
	//."\n and m.type_id='".$_POST['type_id']."' and m.member_category_id='".$_POST['member_category_id']."'"
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
	$query="select mt.money_receipt_no from #__member_trail as mt"
	."\n where mt.money_receipt_no='".$_POST['money_receipt_no']."'"
	;

	$query  =  $database->replaceTablePrefix($query);
	$result=mysql_query($query) or die(mysql_error());
	if (mysql_num_rows($result)>0){
		//echo "<script> alert(Money Receipt No ".$money_receipt_no." Already Exist); window.history.go(-1); </script>\n";
		//exit();
		$msg="Money Receipt No. ".$_POST['money_receipt_no']." Already Exist";
		mosRedirect( "index2.php?option=$option&task=new&mosmsg=".$msg );
	}

	// by mizan
	$type_id=$_POST['type_id'];
	$last_reg_year_id=$_POST['last_reg_year_id'];
	$member_reg_no=$_POST['member_reg_no'];
	$reg_date=mosHTML::ConvertDateForDatatbase($_POST['reg_date']);
	$is_direct_export=$_POST['is_direct_export'];

	$money_receipt_no=$_POST['money_receipt_no'];
	$money_receipt_date=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
	$commencing_date=mosHTML::ConvertDateForDatatbase($_POST['commencing_date']);
	$member_category_id=$_POST['member_category_id'];
	$member_status=$_POST['member_status'];

	$trade_licence_no=$_POST['trade_licence_no'];
	$trade_licence_issued_by=$_POST['trade_licence_issued_by'];
	$trade_licence_issue_date=mosHTML::ConvertDateForDatatbase($_POST['trade_licence_issue_date']);
	$trade_licence_expire_date=mosHTML::ConvertDateForDatatbase($_POST['trade_licence_expire_date']);
	$import_reg_no_expire_date=mosHTML::ConvertDateForDatatbase($_POST['import_reg_no_expire_date']);
	$export_reg_no_expire_date=mosHTML::ConvertDateForDatatbase($_POST['export_reg_no_expire_date']);
	$tin=$_POST['tin'];

	$import_reg_no=$_POST['import_reg_no'];
	$export_reg_no=$_POST['export_reg_no'];
	$indenting_trade_no=$_POST['indenting_trade_no'];
	$machine_number=$_POST['machine_number'];
	$production_capacity=$_POST['production_capacity'];
	$production_unit=$_POST['production_unit'];

	$applicant_title=$_POST['applicant_title'];
	$applicant_name=$_POST['applicant_name'];
	$applicant_last_name=$_POST['applicant_last_name'];
	$applicant_designation=$_POST['applicant_designation'];
	$firm_name=$_POST['firm_name'];
	$applicant_address_street=$_POST['applicant_address_street'];
	$applicant_address_town_suburb=$_POST['applicant_address_town_suburb'];
	$applicant_address_district=$_POST['applicant_address_district'];
	$applicant_address_division=$_POST['applicant_address_division'];
	$applicant_address_country=$_POST['applicant_address_country'];
	$applicant_home_phone=$_POST['applicant_home_phone'];
	$applicant_office_phone=$_POST['applicant_office_phone'];
	$applicant_mobile=$_POST['applicant_mobile'];
	$applicant_fax=$_POST['applicant_fax'];
	$applicant_email=$_POST['applicant_email'];
	$applicant_web=$_POST['applicant_web'];

	$office_address_street=$_POST['office_address_street'];
	$office_address_town_suburb=$_POST['office_address_town_suburb'];
	$office_address_district=$_POST['office_address_district'];
	$office_address_division=$_POST['office_address_division'];
	$office_address_country=$_POST['office_address_country'];
	$office_phone=$_POST['office_phone'];
	$office_mobile=$_POST['office_mobile'];
	$office_fax=$_POST['office_fax'];
	$office_email=$_POST['office_email'];
	$office_web=$_POST['office_web'];

	$proposer_one_title=$_POST['proposer_one_title'];
	$proposer_one_name=$_POST['proposer_one_name'];
	$proposer_one_last_name=$_POST['proposer_one_last_name'];
	$proposer_one_address=$_POST['proposer_one_address'];
	$proposer_one_member_reg_no=$_POST['proposer_one_member_reg_no'];
	$proposer_two_title=$_POST['proposer_two_title'];
	$proposer_two_name=$_POST['proposer_two_name'];
	$proposer_two_last_name=$_POST['proposer_two_last_name'];
	$proposer_two_address=$_POST['proposer_two_address'];
	$proposer_two_member_reg_no=$_POST['proposer_two_member_reg_no'];

	$representative_title=$_POST['representative_title'];
	$representative_name=$_POST['representative_name'];
	$representative_last_name=$_POST['representative_last_name'];
	$representative_designation=$_POST['representative_designation'];
	$location=$_POST['location'];
	$investment_temp=bcmul($_POST['investment'],1000000,3);
	if (intval($investment_temp)==bcadd($investment_temp,0,3))
	$investment=intval($investment_temp);
	else
	$investment=bcadd($investment_temp,0,3);

	// ******** Added by Hassan at 02-06-2007 **********
	$bond_licence_no			= $_POST['bond_licence_no'];
	$bond_licence_issue_date	= mosHTML::ConvertDateForDatatbase($_POST['bond_licence_issue_date']);
	$vat_reg_no					= $_POST['vat_reg_no'];
	$vat_reg_issue_date			= mosHTML::ConvertDateForDatatbase($_POST['vat_reg_issue_date']);
	
	// ******* end Add *********************

	if($id==0){
		$sql_query= "insert into #__member (type_id,member_category_id,member_reg_no,money_receipt_no"
		.",money_receipt_date,member_status,firm_name,applicant_title,applicant_name"
		.",applicant_last_name,applicant_designation,applicant_address_street,applicant_address_town_suburb"
		.",applicant_address_district,applicant_address_division"
		.",applicant_address_country,applicant_home_phone"
		.",applicant_office_phone,applicant_mobile,applicant_fax,applicant_email,applicant_web"
		.",commencing_date,office_address_street,office_address_town_suburb"
		.",office_address_district,office_address_division,office_address_country"
		.",office_phone,office_mobile,office_fax,office_email,office_web,is_direct_export,proposer_one_title"
		.",proposer_one_name,proposer_one_last_name,proposer_one_address"
		.",proposer_one_member_reg_no,proposer_two_title,proposer_two_name"
		.",proposer_two_last_name,proposer_two_address,proposer_two_member_reg_no"
		.",representative_title,representative_name,representative_last_name"
		.",representative_designation,machine_number,production_capacity,production_unit"
		.",last_reg_year_id,reg_date,last_reg_date,import_reg_no,export_reg_no"
		.",indenting_trade_no,tin,trade_licence_no,trade_licence_issued_by"
		.",trade_licence_issue_date,trade_licence_expire_date"
		.",import_reg_no_expire_date,export_reg_no_expire_date,representative_mobile"
		.",investment,date,location,bond_licence_no,bond_licence_issue_date,vat_reg_no,vat_reg_issue_date)"
		." values ('". $type_id."','".$member_category_id."','".$member_reg_no
		."','".$money_receipt_no."','".$money_receipt_date."','".$member_status
		."','".$firm_name."','".$applicant_title."','".$applicant_name
		."','".$applicant_last_name."','".$applicant_designation."','".$applicant_address_street
		."','".$applicant_address_town_suburb."','".$applicant_address_district
		."','".$applicant_address_division."','".$applicant_address_country
		."','".$applicant_home_phone."','".$applicant_office_phone
		."','".$applicant_mobile."','".$applicant_fax."','".$applicant_email
		."','".$applicant_web."','".$commencing_date."','".$office_address_street
		."','".$office_address_town_suburb."','".$office_address_district
		."','".$office_address_division."','".$office_address_country
		."','".$office_phone."','".$office_mobile."','".$office_fax
		."','".$office_email."','".$office_web."','".$is_direct_export
		."','".$proposer_one_title."','".$proposer_one_name."','".$proposer_one_last_name
		."','".$proposer_one_address."','".$proposer_one_member_reg_no
		."','".$proposer_two_title."','".$proposer_two_name."','".$proposer_two_last_name
		."','".$proposer_two_address."','".$proposer_two_member_reg_no
		."','".$representative_title."','".$representative_name
		."','".$representative_last_name."','".$representative_designation
		."','".$machine_number."','".$production_capacity."','".$production_unit
		."','".$_SESSION['last_reg_year_id']."','".$reg_date."','".$reg_date
		."','".$import_reg_no ."','".$export_reg_no."','".$indenting_trade_no."','".$tin
		."','".$trade_licence_no."','".$trade_licence_issued_by
		."','".$trade_licence_issue_date
		."','".$trade_licence_expire_date
		."','".$import_reg_no_expire_date
		."','".$export_reg_no_expire_date
		."','".$_POST['representative_mobile']
		."','".$investment
		."','".$current_date_time."','".$location."','".$bond_licence_no."','".$bond_licence_issue_date
		."','".$vat_reg_no."','".$vat_reg_issue_date."')";

		$sql_query  =  $database->replaceTablePrefix($sql_query);

		$msg="Failed to Add Member Information".$sql_query;

		if(!mysql_query($sql_query)) {
			mosRedirect( "index2.php?option=$option&task=new&mosmsg=".$msg );
		}
		$insert_id = mysql_insert_id($dbconn->connection);

		// data insert into member enclosure start

		for ($i=0;$i<count($_POST['enclosure']);$i++){
			if (!empty($_POST['enclosure'][$i])){
				$query="insert into #__member_enclosure (member_id,enclosure_id,enclosure_rule)"
				." values('".$insert_id."','".$_POST['enclosure'][$i]."','1')";

				$query  =  $database->replaceTablePrefix($query);
				$result=mysql_query($query) or die(mysql_error());
			}
		}


		/*
		for ($i=0;$i<count($_POST['enclosure']);$i++){
		if (!empty($_POST['enclosure'][$i])){
		$query="insert into #__member_enclosure (member_id,enclosure_id,enclosure_rule)"
		." values('".$insert_id."','".$_POST['enclosure'][$i]."','1')";

		$query  =  $database->replaceTablePrefix($query);
		$result=mysql_query($query) or die(mysql_error());
		}
		}
		$enc_id=Array();
		for ($j=0;$j<count($_POST['enc']);$j++){
		$enc_id[$j]=$_POST['enc'][$j];
		}
		for ($i=0;$i<count($_POST['enclosure']);$i++){
		for ($j=0;$j<count($enc_id);$j++){
		if ($enc_id[$j]==$_POST['enclosure'][$i]){
		$enc_id[$j]="";
		}
		}
		}

		for ($i=0;$i<count($enc_id);$i++){
		if (!empty($enc_id[$i])){
		$query="insert into #__member_enclosure (member_id,enclosure_id,enclosure_rule)"
		." values('".$insert_id."','".$enc_id[$i]."','0')";

		$query  =  $database->replaceTablePrefix($query);
		$result=mysql_query($query) or die(mysql_error());
		}
		}
		*/
		// data insert into member enclosure end

		/*$msg="Failed to Add Member Enclosure";
		if(!mysql_query($query)) {
		//mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
		mosRedirect( "index2.php?option=$option&mosmsg=".$msg );
		} */

		// data insert into member history
		$query="insert into #__member_history (member_id,entry_type,reg_year_id,member_reg_no"
		.",is_voter,money_receipt_no,date,user_id)"
		." values('".$insert_id."','1','".$_SESSION['last_reg_year_id']
		."','".$member_reg_no."','1','".$money_receipt_no
		."','".$current_date_time."','".$user_id."')";

		$query  =  $database->replaceTablePrefix($query);

		$msg="Failed to Add Member History";
		if(!mysql_query($query)) {
			//mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
			mosRedirect( "index2.php?option=$option&id=".$id."&mosmsg=".$msg );
		}


		//account transaction start

		$reference_id=mysql_insert_id($dbconn->connection);
		$sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
		$database->setQuery($sql_trans);
		$transaction_no=($database->loadResult()+1);

		$sql_query="select  enrollment_fee as admission_fee, enrollment_development_fee"
		."\n as yearly_subscription_fee,safety_measure_enrollment as safety_measure_enrollment "
		."\n ,other_enrollment_fee as other_enrollment_fee "
		."\n from #__member_charge where member_type_id= '$type_id'"
		. "\n and reg_year_id='".$_SESSION['last_reg_year_id']."'"
		;
		$database->setQuery($sql_query);
		$fee =$database->loadObjectList();
		$admision_fee=$fee[0]->admission_fee;
		$yearly_subscription_fee=$fee[0]->yearly_subscription_fee;
		$safety_measure_enrollment=$fee[0]->safety_measure_enrollment;
		$other_enrollment_fee=$fee[0]->other_enrollment_fee;

		$account_query1="insert into #__account_transaction values('','$transaction_no','101','$admision_fee','0','$reference_id','$money_receipt_date','$current_date')";
		$account_query1=$database->replaceTablePrefix($account_query1);
		$account_query2="insert into #__account_transaction values('','$transaction_no','1','$admision_fee','1','$reference_id','$money_receipt_date','$current_date')";
		$account_query2=$database->replaceTablePrefix($account_query2);

		$transaction_no=$transaction_no+1;
		$account_query3="insert into #__account_transaction values('','$transaction_no','102','$yearly_subscription_fee','0','$reference_id','$money_receipt_date','$current_date')";
		$account_query3=$database->replaceTablePrefix($account_query3);
		$account_query4="insert into #__account_transaction values('','$transaction_no','1','$yearly_subscription_fee','1','$reference_id','$money_receipt_date','$current_date')";
		$account_query4=$database->replaceTablePrefix($account_query4);

		$transaction_no=$transaction_no+1;
		$account_query5="insert into #__account_transaction values('','$transaction_no','103','$safety_measure_enrollment','0','$reference_id','$money_receipt_date','$current_date')";
		$account_query5=$database->replaceTablePrefix($account_query5);
		$account_query6="insert into #__account_transaction values('','$transaction_no','1','$safety_measure_enrollment','1','$reference_id','$money_receipt_date','$current_date')";
		$account_query6=$database->replaceTablePrefix($account_query6);

		$transaction_no=$transaction_no+1;
		$account_query7="insert into #__account_transaction values('','$transaction_no','3011','$other_enrollment_fee','0','$reference_id','$money_receipt_date','$current_date')";
		$account_query7=$database->replaceTablePrefix($account_query7);
		$account_query8="insert into #__account_transaction values('','$transaction_no','1','$other_enrollment_fee','1','$reference_id','$money_receipt_date','$current_date')";
		$account_query8=$database->replaceTablePrefix($account_query8);

		if(!(mysql_query($account_query1) && mysql_query($account_query2) && mysql_query($account_query3) && mysql_query($account_query4) && mysql_query($account_query5) && mysql_query($account_query6) && mysql_query($account_query7) && mysql_query($account_query8) ))
		{
			echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
			exit();
		}
		// account transaction end

		if(trim($tin)!=""){
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
				."\n and mh.reg_year_id='".$_SESSION['last_reg_year_id']."'"
				;

				$query  =  $database->replaceTablePrefix($query);
				$result=mysql_query($query) or die(mysql_error());
			}
		}

		if(!$database->addMemberTrail($insert_id,'1',$user_id,'','',$money_receipt_no)){
			$msg="Incorrect Member Trail Information";
			//mosRedirect( "index2.php?option=$option&task=preview_&id=".$id."&mosmsg=".$msg );
			mosRedirect( "index2.php?option=$option&id=".$id."&mosmsg=".$msg );
		}


		//$mosmsg='Member profile is saved successfully';
		$msg='Member profile is saved successfully';
	}

	SessionUnregister();

	$row = new mosMembership( $database );
	$row->bind( $_POST );
	$row->checkin();
	mosRedirect( "index2.php?option=$option&mosmsg=".$msg );
	//HTML_Membership::Confirmation( $option, $id , $mosmsg);
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
		$database->setQuery( "DELETE FROM #__member_compliance_list WHERE member_id IN ($cids)" );
		$con2=$database->query();
		$database->setQuery( "DELETE FROM #__member_directors_info WHERE member_id IN ($cids)" );
		$con3=$database->query();
		$database->setQuery( "DELETE FROM #__member_export_list WHERE member_id IN ($cids)" );
		$con4=$database->query();
		$database->setQuery( "DELETE FROM #__member_product_line WHERE member_id IN ($cids)" );
		$con5=$database->query();
		$database->setQuery( "DELETE FROM #__member_history WHERE member_id IN ($cids)" );
		$con6=$database->query();
		*/
		if (!$con1 || !$con ) {
			echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
		}
		else
		$msg="Member Information Deleted Successfully";
	}

	mosRedirect( "index2.php?option=$option&mosmsg=".$msg );
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
	SessionUnregister();
	mosRedirect( "index2.php?option=$option" );
}

function SessionUnregister(){
	//global


	session_unregister( "last_reg_year_id" );




}
?>
