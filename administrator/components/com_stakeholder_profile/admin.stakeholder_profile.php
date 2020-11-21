<?php
/**
* Stakeholder Information
* This file used to task handling
* grabs user inputs, process and validate the inputs
* Written by: Morshed Alam
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
require_once( $mainframe->getPath( 'admin_html' ) );
require_once( $mainframe->getPath( 'class' ) );

$task        = trim( mosGetParam( $_REQUEST, 'task', null ) );
$id          = mosGetParam( $_REQUEST, 'id', '' );
$cid         = mosGetParam( $_REQUEST, 'cid', array( 0 ) );
$option      = mosGetParam($_REQUEST, 'option', '');

if (!is_array( $cid )) {
        $cid = array ( 0 );
}

switch ($task) {
        case 'new':
                editStakeHolder( 0, $option, $task);
                break;

        case 'edit':
                editStakeHolder( $cid[0], $option, $task );
                break;

        case 'editA':
                editStakeHolder( $id, $option, $task );
                break;

        case 'ebli':
                editBusinessLineInfo( $id, $option, $task );
                break;

        case 'dbli':
                deleteBusinessLineInformation( $option );
                break;

        case 'save':
        case 'apply':
                 saveStakeHolder( $option, $task );
                break;

        case 'remove':
                removeStakeHolder( $cid, $option );
                break;

        default:
                showStakeHolderList( $option );
                break;
}

function showStakeHolderList( $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

        $sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
        $filter_type        = $_REQUEST['filter_type'];
        $search             = $_REQUEST['search'];
        //$filter_type        = $mainframe->getUserStateFromRequest( "filter_type{$option}", 'filter_type', 0 );
        //$search             = $mainframe->getUserStateFromRequest( "search{$option}", 'search', '' );
        $search             = $database->getEscaped( trim( strtolower( $search ) ) );

        $where = Array();
        if($filter_type){
             $where[] = $filter_type." LIKE '%$search%'";
        }
        else{
             empty($where);
             $search = '';
        }

        // get the total number of records
        $query = " SELECT count(id) FROM #__stakeholder "
                . (count( $where ) ? " where ".implode( ' AND ', $where ) : "");
        $database->setQuery( $query );
        $total = $database->loadResult();
        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        //get stakeholder list from database
        $query = " SELECT id,name,contact_person,address,organization_type_id,update_date from #__stakeholder "
                 . (count( $where ) ? " where ".implode( ' AND ', $where ) : "")." order by name "
                 . "\n LIMIT $pageNav->limitstart, $pageNav->limit " ;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();

        // get list for dropdown filter
        $types[] = mosHTML::makeOption( '0', 'Select Type ' );
        $types[] = mosHTML::makeOption( 'name', 'Name' );
        $types[] = mosHTML::makeOption( 'contact_person', 'Contact Person' );
        $types[] = mosHTML::makeOption( 'address', 'Address' );
        $types[] = mosHTML::makeOption( 'phone', 'Phone' );
        $types[] = mosHTML::makeOption( 'fax', 'Fax' );
        $types[] = mosHTML::makeOption( 'email', 'Email' );
        $types[] = mosHTML::makeOption( 'web', 'Website' );

        $lists = array();
        $lists['filter_type'] = mosHTML::selectList( $types, 'filter_type', 'class="inputbox" size="1" onchange="javascript: document.adminForm.submit( );"', 'value', 'text', $filter_type );

        HTML_StakeHolder::showStakeHolderList( $rows, $pageNav, $search, $option, $lists );
}

function editStakeHolder( $uid='0', $option, $task='' ) {
        global $database;

        $row = new mosStakeHolder( $database );
        // load the row from the db table
        $row->load( $uid );

        $sql = "select association_id as id from #__stakeholder_association where stk_id='".$uid."'";
        $database->setQuery($sql);
        $al = $database->loadResultArray();

        $lists = array();
        $lists['stk_type']             = stakeHolderTypeList('stk_type',$row->stk_type);
        $lists['organization_type_id'] = OrganizationTypeList('organization_type_id',$row->organization_type_id);
        $lists['association'] = MultipleAssociationList( 'association[]', $al );
        $lists['is_partner']  = mosHTML::yesnoRadioList( 'is_partner', 'class="inputbox"',intval($row->is_partner));

        HTML_StakeHolder::editStakeHolder( $row, $lists, $option, $task );
}

function saveStakeHolder( $option, $task ) {
        global $database;

        $row = new mosStakeHolder( $database );

        if (!$row->bind( $_POST )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }

        $row->issue_date      = mosHTML::ConvertDateForDatatbase($_REQUEST['issue_date']);
        $row->expire_date     = mosHTML::ConvertDateForDatatbase($_REQUEST['expire_date']);
        $row->reg_date        = mosHTML::ConvertDateForDatatbase($_REQUEST['reg_date']);
        $row->date            = intval($_REQUEST['id'])==0?date('Y-m-d'):$row->date;
        $row->update_date     = date('Y-m-d');

        if (!$row->check( )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }

        if (!$row->store()) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }
        if($_REQUEST['id']==0){
          $id = $database->insertid();
          $row->id = $id;
        }
        //association list -- Multiple select
        $asso_list = array();
        for ($i=0; $i<count($_REQUEST['association']); $i++)
        {
          $rowAss = new mosStakeHolderAssociation( $database );
          $rowAss->stk_id = $row->id;
          $rowAss->association_id = $_REQUEST['association'][$i];
          if($rowAss->check())
          {
            $rowAss->store();
          }
          $asso_list[] = $_REQUEST['association'][$i];
        }
        $asso_list = implode(',',$asso_list);
        $query="delete from #__stakeholder_association where stk_id='".$row->id."' and association_id not in(".$asso_list.")";
        $database->setQuery($query);
        $database->query();

        $msg = 'Successfully saved stakeholder information.';
        if($_REQUEST['id']==0){
           mosRedirect( 'index2.php?option='.$option.'&task=editA&id='.$id, $msg );
        }else{
           mosRedirect( 'index2.php?option='.$option,$msg );
        }
}

function removeStakeHolder( &$cid, $option ) {
        global $database;

        if ( count( $cid ) ) {
           $obj = new mosStakeHolder( $database );
           foreach ($cid as $id) {
             if (!$obj->delete( $id )) {
                echo "<script> alert('".$obj->getError()."'); window.history.go(-1); </script>\n";
                exit();
             }
           }
        }

        $msg = 'Stakeholder information deleted successfully.';
        mosRedirect( 'index2.php?option='. $option, $msg );
}
// delete business line information
function deleteBusinessLineInformation( $option ){
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
          mosRedirect("index2.php?option=$option&task=editA&id=".$member_id, $msg );
}


/**
* Select list of stakeholder type
*/
function stakeHolderTypeList( $name, $active=NULL, $javascript=NULL, $order='ordering', $size=1, $sel_cat=1 ) {
        global $database;

        $query = "SELECT id AS value, name AS text"
        . "\n FROM #__stakeholder_type ORDER BY id DESC"
        ;

        $database->setQuery( $query );
        if ( $sel_cat ) {
                $type[] = mosHTML::makeOption( '0', "Select Type" );
                $type   = array_merge( $type, $database->loadObjectList() );
        } else {
                $type   = $database->loadObjectList();
        }
        $type = mosHTML::selectList( $type, $name, 'class="inputbox" size="'. $size .'" '. $javascript, 'value', 'text', $active );

        return $type;
}

function getStakeholderTypeName($id){
        global $database;

        $query = "SELECT name FROM #__stakeholder_type where id='$id'" ;
        $database->setQuery( $query );
        return $database->loadResult();
}

/**
* Select list of stakeholder type
*/
function organizationTypeList( $name, $active=NULL, $javascript=NULL, $order='ordering', $size=1, $sel_cat=1 ) {
        global $database;

        $query = "SELECT id AS value, name AS text"
        . "\n FROM #__organization_type ORDER BY id DESC"
        ;

        $database->setQuery( $query );
        if ( $sel_cat ) {
                $orgType[] = mosHTML::makeOption( '0', "Select Organization Type" );
                $orgType   = array_merge( $orgType, $database->loadObjectList() );
        } else {
                $orgType   = $database->loadObjectList();
        }
        $orgType = mosHTML::selectList( $orgType, $name, 'class="inputbox" size="'. $size .'" '. $javascript, 'value', 'text', $active );

        return $orgType;
}

function organizationTypeName($id){
        global $database;

        $query = "SELECT name FROM #__organization_type where id='$id'" ;
        $database->setQuery( $query );
        return $database->loadResult();
}

function MultipleAssociationList( $name, &$active) {
       global $database;

       $query = "SELECT id AS value, name AS text"
       . "\n FROM #__association"
       ;
       $database->setQuery( $query );
       $al = $database->loadObjectList();

       $al = mosHTML::multipleselectList( $al, $name, 'class=inputbox size=5 multiple', 'value', 'text', $active );

       return $al;
}


function businessLineInformation($member_id=0,$hscodeType=0,$businessType=0,$countryId=0,$option){
      global $database;
      $sl=1;
      $query = " select pl.name as name,pl.hscode as hscode, mpl.product_id as id,mpl.id as member_product_id "
              ." from #__member_product_line as mpl,#__product_line as pl"
              ." where mpl.product_id=pl.id and mpl.business_type='".$businessType."' and mpl.member_id='$member_id'";
      $database->setQuery( $query );
      $rows = $database->loadObjectList();

      if(count($rows)){
       foreach ($rows as $row){
          $query="select pc.country_name as country_name from #__pshop_country as pc,#__member_product_country as mpc, #__member_product_line as mpl"
                  ." where pc.country_id=mpc.country_id and mpc.member_product_id=mpl.id and mpl.member_id='$member_id' and mpl.business_type='$businessType' and mpl.product_id=".$row->id;
          $database->setQuery( $query );
          $rows_country = $database->loadObjectList();
          $countryList="";
          $country=array();
          if (count($rows_country)>0){
              $i=0;
              foreach ($rows_country as $row_country){
                   $country[$i]=$row_country->country_name;
                   $i++;
              }
              $countryList=implode(", ",$country);
          }
          if (trim($countryList)!="")
              $countryList="(".$countryList.")";
          echo $sl.". ".$row->name."&nbsp;&nbsp;".$countryList."&nbsp;&nbsp;<!--a href=\"javascript:popupHSCode('edit',$member_id,$row->id,$hscodeType,$businessType,$countryId);\" style=\"text-decoration:none;\"><b>Edit</b></a>/&nbsp;-->"
              ."<a href=\"index2.php?option=$option&task=dbli&member_id=$member_id&product_id=$row->id&businessType=$businessType&member_product_id=$row->member_product_id\" style=\"text-decoration:none;\"><b>Delete</b></a>"."<br>";
          $sl++;
       }
      }
}


?>
