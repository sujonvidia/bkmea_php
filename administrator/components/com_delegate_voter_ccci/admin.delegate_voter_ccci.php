<?php
/**
* @version $Id: admin.delegate_voter_ccci.php,v 1.4 2006/05/15 07:50:32 morshed Exp $
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
$cid                 = mosGetParam( $_POST, 'cid', array(0) );
$id = mosGetParam( $_REQUEST, 'id' );



switch ($task) {

        case 'save':
                saveDelegate_voter( $cid,$option );
                break;

        case 'cancel':
                cancelDelegate_voter();
                break;

        default:
                showDelegate_voter( $section, $option );
                break;
}

/**
* Compiles the list of firms
* @param string The name of the category section
* @param string The name of the module
*/
function showDelegate_voter( $section, $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;
        global $config_voter_election_date,$mosconfig_voter_new_date,$mosconfig_voter_renew_date;

        $last_reg_id=$_SESSION['working_reg_year_id'];
        $election_date=mosHTML::ConvertDateForDatatbase($config_voter_election_date);
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
        $search = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
        $search = $database->getEscaped( trim( strtolower( $search ) ) );

        $where=array();
        if ($search) {
                $where[] = "( LOWER(m.firm_name) LIKE '%$search%' || LOWER(m.member_reg_no) = '$search'  || mh.tin='$search' )";
        }

        // query added by mizan for the total number of records

        $query = "select count(*) "
                 ."\n from #__member as m"
                 ."\n left join #__member_history as mh on m.id=mh.member_id "
                 ."\n where m.is_delete!=1 and  mh.reg_year_id= '$last_reg_id' "
                 . (count( $where ) ? "\n and " . implode( ' AND ', $where ) : "")
                 ."\n and m.type_id='5' and ((mh.entry_type=1 and mh.reg_date<="
                 ."\n date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
                 ."\n ||(mh.entry_type=2 and mh.reg_date<= date_sub('".$election_date."',"
                 ."\n interval '$mosconfig_voter_renew_date' day)))"
                 ."\n order by m.firm_name"
                 ;

        $database->setQuery( $query);
        // get the total number of records
        $total = $database->loadResult();

        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        // query added by mizan for finding the delegate member

         $query = "select m.id as id, m.applicant_name as person ,m.firm_name as companyname,"
                 ."\n mt.name as member_type, mh.is_voter as is_voter,"
                 ."\n pt.firm_name as ParentName from #__member as m"
                 ."\n left join #__member_history as mh on m.id=mh.member_id "
                 ."\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                 ."\n left join #__member as pt on m.parent=pt.id"
                 ."\n where m.is_delete!=1 and  mh.reg_year_id= '$last_reg_id'"
                 . (count( $where ) ? "\n and " . implode( ' AND ', $where ) : "")
                 ."\n and m.type_id=5 and ((mh.entry_type=1 and "
                 ."\n mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
                 ."\n || (mh.entry_type=2 and mh.reg_date<="
                 ."\n date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))"
                 ."\n order by pt.firm_name,m.firm_name"
                 . "\n LIMIT $pageNav->limitstart, $pageNav->limit"
                 ;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        if ($database->getErrorNum()) {
                echo $database->stderr();
                return;
        }

        // build list of type
        $javascript = 'onchange="document.adminForm.submit();"';
        $lists['search_type_id']= mosAdminMenus::MemberType( 'search_type_id', $option, intval( $search_type_id ), $javascript);

        Delegate_voter_html::show( $rows, $pageNav,$lists, $search);
}

/**
* Saves the catefory after the form submit
* @param array The id of firm
*/
function saveDelegate_voter( $cid,$option ) {
       global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;
        global $config_voter_election_date,$mosconfig_voter_new_date,$mosconfig_voter_renew_date;

        $election_date=mosHTML::ConvertDateForDatatbase($config_voter_election_date);
        $last_reg_id=$_SESSION['working_reg_year_id'];

         $cids=implode(',',$cid);

         // query for finding tottal no. of valid voter of a comapny of current register year
         $sql = "select count(m.id) as total_num_voter, m.parent as parentid,"
                 ."\n pt.firm_name as companyname from #__member as m"
                 ."\n left join #__member_history as mh on m.id=mh.member_id "
                 ."\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                 ."\n left join #__member as pt on m.parent=pt.id"
                 ."\n where m.is_delete!=1 and  mh.reg_year_id= '$last_reg_id'"
                 ."\n and m.type_id=5 and ((mh.entry_type=1 and "
                 ."\n mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
                 ."\n || (mh.entry_type=2 and mh.reg_date<="
                 ."\n date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))"
                 ."\n group by m.parent order by m.firm_name"
                 ;
        $sql  =  $database->replaceTablePrefix($sql);
        $res=mysql_query($sql) or die(mysql_error());

        // query for finding selected members and its parents of current register year
        $sql1 = "select m.id as id, m.parent as parentid"
                 ."\n from #__member as m where m.id in ($cids) order by m.firm_name, m.parent"
                 ;
        $sql1  =  $database->replaceTablePrefix($sql1);
        $res1=mysql_query($sql1) or die(mysql_error());

        // query for update (set is_voter equal to zero) of current register year
                $query = "select m.id as id"
                 ."\n from #__member as m"
                 ."\n left join #__member_history as mh on m.id=mh.member_id "
                 ."\n LEFT JOIN #__member_type AS mt ON mt.id = m.type_id"
                 ."\n left join #__member as pt on m.parent=pt.id"
                 ."\n where m.is_delete!=1 and  mh.reg_year_id= '$last_reg_id'"
                 ."\n and m.type_id=5 and ((mh.entry_type=1 and "
                 ."\n mh.reg_date<= date_sub('".$election_date."', interval '$mosconfig_voter_new_date' day))"
                 ."\n || (mh.entry_type=2 and mh.reg_date<="
                 ."\n date_sub('".$election_date."', interval '$mosconfig_voter_renew_date' day)))"
                 ."\n order by pt.firm_name,m.firm_name"
                 ;
                 $query  =  $database->replaceTablePrefix($query);
                 $result=mysql_query($query) or die(mysql_error());
                  while ($data=mysql_fetch_object($result)){
                       $database->setQuery( "update #__member_history set is_voter='0' WHERE member_id='$data->id'" );
                       $con2=$database->query();
                  }

        if (!is_array( $cid ) || count( $cid ) < 1) {
                echo "<script> alert('Select an item to make it voter'); window.history.go(-1);</script>\n";
                exit;
        }

        elseif (count( $cid )>0) {
                 $flag=1;
                 $mid=Array();
                 $mpid=Array();
                 $i=0;
                 while ($row1=mysql_fetch_array($res1)){
                                  $mid[$i]=$row1['id'];
                                  $mpid[$i]=$row1['parentid'];
                                  $i++;
                              }

                $member=Array(0);
                while ($row=mysql_fetch_array($res)){
                       $num_valid_voter=0;
                       $total_num_voter=0;

                       for ($j=0;$j<$i;$j++){

                            if ($row['parentid']==$mpid[$j]){
                                  $member[$total_num_voter]=$mid[$j];
                                  $total_num_voter++;
                              }
                       }

                      /* while ($row1=mysql_fetch_array($res1)){

                              if ($row['parentid']==$row1['parentid']){
                                  $member[$index]=$row1['id'];
                                  $num_voter=$num_voter+1;
                                  $index=$index+1;
                              }

                       }*/
                       $num_valid_voter=floor($row['total_num_voter']/5);
                       $members="";
                       $members=implode(',',$member);

                       if ($total_num_voter<=$num_valid_voter && $total_num_voter>0){
                               //$database->setQuery( "update #__member_history set is_voter='1' WHERE member_id IN ($cids)" );
                               $database->setQuery( "update #__member_history set is_voter='1' WHERE member_id in ($members)" );
                               $con1=$database->query();
                       }
                       elseif ($total_num_voter>$num_valid_voter){
                              $msg.="No. of valid voters is : $num_valid_voter of $row[companyname]";
                       }

                }


                if (!$con1  ) {
                        echo "<script> alert('".$database->getErrorMsg()."'); window.history.go(-1); </script>\n";
                }
                else{
                  $msg.=" Membership Information saved Successfully ";
                }
        }
        mosRedirect( "index2.php?option=com_delegate_voter_ccci&mosmsg=$msg" );
}


/**
* Cancels an operation
*/
function cancelDelegate_voter() {
        global $database;

        $redirect = mosGetParam( $_POST, 'redirect', '' );

        /*$row = new mosRenew( $database );
        $row->bind( $_POST );
        $row->checkin();*/
        mosRedirect( 'index2.php?option=com_delegate_voter_ccci' );
}


?>
