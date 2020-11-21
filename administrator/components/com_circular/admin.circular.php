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
include_once("../includes/epb.function.php");

$task        = trim( mosGetParam( $_REQUEST, 'task', null ) );
$id          = mosGetParam( $_REQUEST, 'id', '' );
$cid         = mosGetParam( $_REQUEST, 'cid', array( 0 ) );
$option      = mosGetParam($_REQUEST, 'option', '');
if(!$id){
        $id = $cid[0];
}

switch ($task) {
        case 'new':
                editCircular( 0, $option, $task);
                break;

        case 'edit':
                editCircular( $id, $option, $task );
                break;

        case 'editA':
                editCircular( $id, $option, $task );
                break;

        case 'save':
        case 'apply':
                 saveCircular( $option, $task );
                break;

        case 'remove':
                removeCircular( $cid, $option );
                break;

        default:
                showCircularList( $option );
                break;
}

function showCircularList( $option ) {
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;

        $sectionid          = $mainframe->getUserStateFromRequest( "sectionid{$option}{$section}", 'sectionid', 0 );
        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
        $filter_type        = $_REQUEST['filter_type'];
        $search             = $_REQUEST['search'];
        $search             = $database->getEscaped( trim( strtolower( $search ) ) );

        $where = Array();
        if($filter_type ){
             $where[] = $filter_type." LIKE '%$search%'";
        }
        else{
             empty($where);
             $search = '';
        }

        // get the total number of records
        $query = " SELECT count(*) FROM #__v3_circular "
                . (count( $where ) ? " where ".implode( ' AND ', $where ) : "");
        $database->setQuery( $query );
        $total = $database->loadResult();
        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        //get circular list from database
        $query = " SELECT * from #__v3_circular "
                 . (count( $where ) ? " where ".implode( ' AND ', $where ) : "")." order by id DESC "
                 . "\n LIMIT $pageNav->limitstart, $pageNav->limit " ;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();

        // get list for dropdown filter
        $types   = array();
        $types[] = mosHTML::makeOption( '0', 'Select type ' );
        $types[] = mosHTML::makeOption( 'title', 'Title' );
        $types[] = mosHTML::makeOption( 'search_keyword', 'Keyword' );
        $types[] = mosHTML::makeOption( 'issue_by', 'Issue By' );

        $lists = array();
        $lists['filter_type'] = mosHTML::selectList( $types, 'filter_type', 'class="inputbox" size="1" onchange="javascript: document.adminForm.submit( );"', 'value', 'text', "$filter_type" );

        HTML_Circular::showCircularList( $rows, $pageNav, $search, $option, $lists );
}

function editCircular( $uid='0', $option, $task='' ) {
        global $database;

        $row = new mosCircular( $database );
        // load the row from the db table
        $row->load( $uid );
        $query="select hscode from #__v3_circular_hscode where circular_id='".$row->id."' ";
        $database->setQuery($query);
        $hscode_arr = $database->loadResultArray();
        $row->hscode = implode(',',$hscode_arr);

        $lists = array();
        $lists['country_id']    = countryList('country_id', $uid?$row->country_id:18);

        HTML_Circular::editCircular( $row, $lists, $option, $task );
}

function saveCircular( $option, $task ) {
        global $database, $mosConfig_absolute_path;

        $row = new mosCircular( $database );

        if (!$row->bind( $_POST )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
        }

        $row->issue_date      = mosHTML::ConvertDateForDatatbase($_REQUEST['issue_date']);
        $row->date            = intval($_REQUEST['id'])==0?date('Y-m-d'):$row->date;
        $row->update_date     = date('Y-m-d H:i:s');

        // Circular file upload
        $fileUpMessage = "";
        if(isset($_FILES['up_file']) && $_FILES['up_file']['name'][0]!="")
        {
                $file      = $_FILES['up_file'];
                $filename  = time();
                $filename  = "epb_".substr($file['name'][0],0,strrpos($file['name'][0],'.'))."_".$filename.".".substr($file['name'][0],strrpos($file['name'][0],'.')+1,strlen($file['name'][0]));
                $fileUp = uploadFile($_FILES['up_file'], $mosConfig_absolute_path."/administrator/images/circular/", $filename);

                if($fileUp == "done"){
                        $row->file_name = $filename;
                        $fileUpMessage = "File uploaded successfully.";
                        @unlink($mosConfig_absolute_path."/administrator/images/circular/".$_REQUEST['original_file']);
                }
                else{
                        $row->file_name = $_REQUEST['original_file'];
                        $fileUpMessage = $fileUp;
                }
        }

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
        //hscode list -- Multiple select
        $hscode_list = array();
        $hscode_list = explode(',',$_REQUEST['hscode']);
        for ($i=0; $i<count($hscode_list); $i++)
        {
          if(is_numeric(trim($hscode_list[$i])))
          {
               $rowHscode = new mosCircularHscode( $database );
               $rowHscode->circular_id = $row->id;
               $rowHscode->hscode = trim($hscode_list[$i]);
               if($rowHscode->check())
               {
                 $rowHscode->store();
               }
               else
               {
                 if($rowHscode->_error!="duplicate" && $rowHscode->hscode!="")
                    $hscode_failed[] = $hscode_list[$i];
               }
               $hscode_arr[] = $rowHscode->hscode;
          }
        }
        $failed_msg = "";
        if(count($hscode_failed)){
                $failed_msg = "Failed to add HSCode( ".implode(', ',$hscode_failed)." )";
        }
        $hscode = implode("','",$hscode_arr);
        $hscode = "'".$hscode."'";
        $query="delete from #__v3_circular_hscode where circular_id='".$row->id."' and hscode not in(".$hscode.")";
        $database->setQuery($query);
        $database->query();

        $msg = 'Circular information has been saved successfully. ';
        mosRedirect( 'index2.php?option='.$option.'&errmsg='.$failed_msg, $msg );
}

function removeCircular( &$cid, $option ) {
        global $database;

        if ( count( $cid ) ) {
           $obj = new mosCircular( $database );
           foreach ($cid as $id) {
             if (!$obj->delete( $id )) {
                echo "<script> alert('".$obj->getError()."'); window.history.go(-1); </script>\n";
                exit();
             }
             $sql = "delete from #__v3_circular_hscode where circular_id='".$id."'";
             $database->setQuery($sql);
             $database->query();
           }
        }

        $msg = 'Circular information has been deleted successfully.';
        mosRedirect( 'index2.php?option='. $option, $msg );
}

?>
