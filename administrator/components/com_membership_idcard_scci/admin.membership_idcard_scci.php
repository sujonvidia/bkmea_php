<?php

// this for ctg


/**
* @version $Id: admin.membership_idcard_scci.php,v 1.14 2006/04/03 07:51:30 morshed Exp $
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
                editMember_renew( 0, $section );
                break;

        case 'edit':

                editMembership_idcard( intval( $cid[0] ) );
                break;

        case 'editA':
                editMembership_idcard( intval( $id ) );
                break;

        case 'preview':
                previewMember_renew( intval( $id ) );
                break;

        case 'remove':
                removeMember_renew( $section, $cid );
                break;

        case 'publish':
                publishMember_renew( $id, $cid, 1 );
                break;

        case 'unpublish':
                publishMember_renew( $id, $cid, 0 );
                break;

        case 'cancel':
                cancelMembership_idcard();
                break;

        case 'save':
                save_idcard();
                break;


        default:
                showMembership_idcard( $section, $option );
                break;
}

/**
* Compiles a list of categories for a section
* @param string The name of the category section
*/
function showMembership_idcard( $section, $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;


        $search_type_id = $_POST['search_type_id'];
        $limit = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart = $mainframe->getUserStateFromRequest( "view{$option}limitstart", 'limitstart', 0 );
        $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
        $search = $database->getEscaped( trim( strtolower( $search ) ) );

        $where = array();
          $working_reg_year_id=$_SESSION['working_reg_year_id'];

        if ($search_type_id > 0) {
                $where[] = "m.type_id='$search_type_id'";
        }
        if ($search) {
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' OR LOWER(m.member_reg_no) = '$search' ) ";
        }

         if (count($where)==0)
         {
                   $query=  "SELECT  count(*)"
                  . "\n FROM #__member AS m LEFT JOIN #__users AS u ON u.id = m.checked_out"
                  . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                  . "\n left join #__member_history as mh ON m.id=member_id"
                  //. ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
                  . "\n where mh.reg_year_id= '$working_reg_year_id'"
                  . "\n and (mh.entry_type='1' or mh.entry_type='2') and m.is_delete=0"
                  ;
         }
         else
         {
                  $query=  "SELECT  count(*)"
                  . "\n FROM mos_member AS m LEFT JOIN #__users AS u ON u.id = m.checked_out"
                  . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                  . "\n left join #__member_history as mh ON m.id=member_id"
                  . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
                  . "\n and mh.reg_year_id= '$working_reg_year_id'"
                  . "\n and (mh.entry_type='1' or mh.entry_type='2') and m.is_delete=0"
                  ;
         }
        $database->setQuery( $query );
        $total = $database->loadResult();


        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        if (count($where)==0)
        {
               $query ="SELECT  m.id as id, m.applicant_title AS title,"
               . "\n m.applicant_name AS name,m.applicant_last_name AS last_name,"
               . "\n u.name AS editor,m.firm_name  AS companyname,"
               . "\n mt.name as member_type, mh.member_reg_no as member_reg_no"
               . "\n FROM mos_member AS m LEFT JOIN #__users AS u ON u.id = m.checked_out"
               . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
               . "\n left join #__member_history as mh ON m.id=member_id"
               . "\n where mh.reg_year_id= '$working_reg_year_id'"
               . "\n and (mh.entry_type='1' or mh.entry_type='2') and m.is_delete=0"
               . "\n ORDER BY mh.member_reg_no, m.type_id"
               . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
               ;
        }
        else
        {
               $query ="SELECT  m.id as id, m.applicant_title AS title,"
               . "\n m.applicant_name AS name,m.applicant_last_name AS last_name,"
               . "\n u.name AS editor,m.firm_name  AS companyname,"
               . "\n mt.name as member_type, mh.member_reg_no as member_reg_no"
               . "\n FROM mos_member AS m LEFT JOIN #__users AS u ON u.id = m.checked_out"
               . "\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
               . "\n left join #__member_history as mh ON m.id=member_id"
               . ( count( $where ) ? "\n WHERE " . implode( ' AND ', $where ) : "")
               . "\n and mh.reg_year_id= '$working_reg_year_id'"
               . "\n and (mh.entry_type='1' or mh.entry_type='2') and m.is_delete=0"
               . "\n ORDER BY mh.member_reg_no, m.type_id"
               . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
               ;
        }

        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return;
        }
        $count = count( $rows );

        // get list of sections for dropdown filter
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['search_type_id']                   = mosAdminMenus::MemberType( 'search_type_id', $option, intval( $search_type_id ), '', $javascript);

        Membership_idcard_html::show( $rows, $pageNav,$lists);
}

/**
* Compiles information to add or edit a category
* @param string The name of the category section
* @param integer The unique id of the category to edit (0 if new)
* @param string The name of the current user
*/
function editMembership_idcard( $uid=0, $section='' ) {
        global $database, $my,$dbconn;

        $type                 = mosGetParam( $_REQUEST, 'type', '' );
        $redirect         = mosGetParam( $_REQUEST, 'section', 'content' );
        $working_reg_year_id=$_SESSION['working_reg_year_id'];
        if($uid!=0){


               $sql_query= "select m.id as id,m.is_voter as is_voter,"
               . "\n m.type_id as member_type_id, m.firm_name as firm,m.applicant_title AS title,"
               . "\n m.applicant_name AS name,m.applicant_last_name AS last_name,"
               . "\n mt.Name as Type , mh.member_reg_no as lastRegNO,"
               . "\n m.firm_reg_address_street as street, m.firm_reg_address_town_suburb as town,"
               . "\n m.firm_reg_address_district as district,m.firm_reg_address_division as division,"
               . "\n m.firm_reg_address_country as country FROM mos_member AS m"
               . "\n left JOin #__member_type as mt on mt.id=m.type_id "
               . "\n left JOin #__member_history as mh on mh.member_id=m.id where m.id = '$uid' and mh.reg_year_id='$working_reg_year_id'"
               ;

              $sql_query=$database->replaceTablePrefix($sql_query);
              $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
              $res =& $dbconn->query($sql_query);
              $row =& $res->fetchRow();


               $sql_query= "select count(id) as printed_times from #__member_idcard as mc where mc.reg_year_id ='$working_reg_year_id' and mc.member_id ='$row->id'";
               $sql_query=$database->replaceTablePrefix($sql_query);
               $res =& $dbconn->query($sql_query);
               $printedtimes =& $res->fetchRow();


        }
        else
          $row->id=0;
        $is_voter= $row->is_voter;

        $lists['is_voter']              = mosHTML::yesnoRadioList( 'is_voter', 'class="inputbox"', $is_voter );
        $lists['bank']                             = mosAdminMenus::BankList( 'bank');
//        Member_renew_html::edit($cur_reg_year, $renew, $row, $lists, $redirect, $menus );
        Membership_idcard_html::edit($row,  $printedtimes, $lists, $redirect, $menus );
        empty($row);
}
/**
* Saves the catefory after an edit form submit
* @param string The name of the category section
*/
function save_idcard( ) {
        global $database, $option,$mosConfig_live_site;

        $row=$_SESSION['row'];
        $money_receipt_no=$_POST['money_receipt_no'];
        $money_receipt_date=$_POST['money_receipt_date'];
        $printedtimes=$_POST['printed_time'];
        $date1=$_POST['date'];
        $bank=$_POST['bank'];
        $date = date( "Y-m-d H:i:s" );
        $user_id=$_SESSION['session_username'];

        $sql_query2="select * from mos_member_trail where money_receipt_no ='$money_receipt_no' and bank_id='$bank' ";
        $database->setQuery($sql_query2);
        $total_row=$database->loadResult();

        if(count($total_row)>0 ) {
            echo "<script> alert('This Money Receipt No is already Exist\'s'); window.history.go(-1); </script>\n";
            exit();
        }else
        {
             $working_reg_year_id=$_SESSION['working_reg_year_id'];
             $user_id=$_SESSION['session_username'];
             $status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
             $link = $mosConfig_live_site. '/index2.php?option=com_membership_idcard_scci&amp;do_pdf=1&amp;id='. $row->id.'&amp;user_id='.$user_id.'&amp;working_reg_year_id='.$working_reg_year_id.'&amp;bank='.$bank.'&amp;money_receipt_no='.$money_receipt_no.'&amp;money_receipt_date='.$money_receipt_date.'&amp;printedtimes='.$printedtimes;
             ?>
             <script language=javascript> window.open('<?php echo $link; ?>', 'win2', '<?php echo $status; ?>'); window.history.go(-1)</script>
             <?php
        }

}



/**
* Cancels an edit operation
* @param string The name of the category section
* @param integer A unique category id
*/
function cancelMembership_idcard() {
        global $database;

        $redirect = mosGetParam( $_POST, 'redirect', '' );

        //$row = new mosRenew( $database );
        //$row->bind( $_POST );
        //$row->checkin();

        mosRedirect( 'index2.php?option=com_membership_idcard_scci' );
}

?>
