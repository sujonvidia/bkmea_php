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

include_once("components/com_docman/docman.config.php");
$_DOCMAN = new dmConfig();

switch ($task) {
        case 'new':
                editTradeLead( 0, $option, $task);
                break;

        case 'edit':
                editTradeLead( $id, $option, $task );
                break;

        case 'editA':
                editTradeLead( $id, $option, $task );
                break;

        case 'save':
        case 'apply':
                 saveTradeLead( $option, $task );
                break;

        case 'remove':
                removeTradeLead( $cid, $option );
                break;

        default:
                showTradeLeadList( $option );
                break;
}

function showTradeLeadList( $option ) {
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
        $query = " SELECT count(*) FROM #__docman where catid='-1' "
                . (count( $where ) ? "  and ".implode( ' AND ', $where ) : "");
        $database->setQuery( $query );
        $total = $database->loadResult();
        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        //get trade lead list from database
        $query = " SELECT * from #__docman where catid='-1'"
                 . (count( $where ) ? " and ".implode( ' AND ', $where ) : "")." order by id DESC "
                 . "\n LIMIT $pageNav->limitstart, $pageNav->limit " ;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();

        // get list for dropdown filter
        $types   = array();
        $types[] = mosHTML::makeOption( '0', 'Select Type ' );
        $types[] = mosHTML::makeOption( 'dmname', 'Name' );
        $types[] = mosHTML::makeOption( 'search_keyword', 'Keyword' );

        $lists = array();
        $lists['filter_type'] = mosHTML::selectList( $types, 'filter_type', 'class="inputbox" size="1" onchange="javascript: document.adminForm.submit( );"', 'value', 'text', "$filter_type" );

        HTML_TradeLead::showTradeLeadList( $rows, $pageNav, $search, $option, $lists );
}

function editTradeLead( $uid='0', $option, $task='' ) {
        global $database, $my;

        $row = new mosDMDocument( $database );
        // load the row from the db table
        $row->load( $uid );
        $database->setQuery("SELECT id as tid FROM #__v3_trade_lead WHERE doc_id='" . $row->id . "'");
        $tid = $database->loadObjectList();
        $row1 = new mosTradeLead( $database );
        $row1->load( $tid[0]->tid );
        foreach($row1 as $index=>$value){
                $index!='id'?$row->$index = $value:$row->tid=$value;
        }

        $query="select hscode from #__v3_trade_lead_hscode where doc_id='".$row->id."' ";
        $database->setQuery($query);
        $hscode_arr = $database->loadResultArray();
        $row->hscode = implode(',',$hscode_arr);

        // creator user information
        if ($doc->dmsubmitedby > '0' && $doc->dmsubmitedby != $my->id) {
            $database->setQuery("SELECT id, name FROM #__users WHERE id='" . $doc->dmsubmitedby . "'");
            $created = $database->loadObjectList();
        }
        else{
            $row->dmdate_published = date('Y-m-d');
            $row->createdby = $my->name ? $my->name : $my->username;
        }

        // updater user information
        if ($doc->dmlastupdateby > '0' && $doc->dmlastupdateby != $my->id) {
            $database->setQuery("SELECT id, name FROM #__users WHERE id='" . $doc->dmlastupdateby . "'");
            $last = $database->loadObjectList();
        }
        else{
            $row->dmlastupdateon = date('Y-m-d h:i:s');
            $row->updatedby = $my->name ? $my->name : $my->username;
        }

        $types   = array();
        $types[] = mosHTML::makeOption( '0', 'Select Type ' );
        $types[] = mosHTML::makeOption( '1', 'Export' );
        $types[] = mosHTML::makeOption( '2', 'Import' );

        $lists = array();
        $lists['is_export_query'] = mosHTML::selectList( $types, 'is_export_query', 'class="inputbox" size="1" ', 'value', 'text', $row->is_export_query );
        $lists['published']  = mosHTML::yesnoRadioList('published', 'class="inputbox"', $uid?$row->published:1);
        $lists['country_id'] = countryList('country_id', $row->country_id);

        HTML_TradeLead::editTradeLead( $row, $lists, $option, $task );
}

function saveTradeLead( $option, $task ) {
         global $database, $mosConfig_absolute_path, $_DOCMAN;

         $row = new mosDMDocument( $database );

         if (!$row->bind( $_POST )) {
                echo "<script> alert('".$row->getError()."'); window.history.go(-1); </script>\n";
                exit();
         }

         $row->dmdate_published = mosHTML::ConvertDateForDatatbase($_REQUEST['dmdate_published']);
         if(trim($_REQUEST['dmdate_expire'])!="")
           $row->dmdate_expire    = mosHTML::ConvertDateForDatatbase($_REQUEST['dmdate_expire']);
         else{
           $temp = explode("-",$row->dmdate_published);
           $row->dmdate_expire = date("Y-m-d",mktime(0,0,0,$temp[1],$temp[2],($temp[0]+1)));
         }
         $row->dmlastupdateon   = date( "Y-m-d H:i:s" );

         $path         = $_DOCMAN->dmpath;
         $backup_path  = $_DOCMAN->dmbackuppath;
         $downloadpath = $_DOCMAN->dmdownloadpath;

         //create category folder
         if(!file_exists($path."/".$_POST['catid'])){
                 mkdir($path."/".$_POST['catid']."/",0777);
         }else{
                 chmod($path."/".$_POST['catid'],0777);
         }

         //create category folder (download)
         if(!file_exists($downloadpath."/".$_POST['catid'])){
                 mkdir($downloadpath."/".$_POST['catid']."/",0777);
         }else{
                 chmod($downloadpath."/".$_POST['catid'],0777);
         }

         //create category folder (backup)
         if(!file_exists($backup_path."/".$_POST['catid'])){
                 mkdir($backup_path."/".$_POST['catid']."/",0777);
         }else{
                 chmod($backup_path."/".$_POST['catid'],0777);
         }

        //start image upload process
        if(isset($_FILES['up_image']) && $_FILES['up_image']['name'][0]!="")
        {
                $file      = $_FILES['up_image'];
                $filename  = time();
                $filename  = substr($file['name'][0],0,strrpos($file['name'][0],'.'))."_".$filename.".".substr($file['name'][0],strrpos($file['name'][0],'.')+1,strlen($file['name'][0]));
                $imageUp = uploadFile($_FILES['up_image'], $path."/".$_POST['catid']."/", $filename);

                if($imageUp == "done"){
                        $row->dmimage = $filename;
                        $imageUpMessage = "Image uploaded successfully.";
                        @unlink($path."/".$_POST['catid']."/".$_REQUEST['original_dmimage']);
                }
                else{
                        $row->dmimage = $_REQUEST['original_dmimage'];
                        $imageUpMessage = $imageUp;
                }
        }
        //end image upload process

        // trade lead file upload
        $fileUpMessage = "";
        if(isset($_FILES['up_file']) && $_FILES['up_file']['name'][0]!="")
        {
                $file   = $_FILES['up_file'];
                $fileUp = uploadFile($_FILES['up_file'], $path."/".$_POST['catid']."/", $file['name'][0]);
                if($fileUp == "done"){
                        $row->dmfilename = $filename;
                        $fileUpMessage = "File uploaded successfully.";
                }
                else{
                        $row->dmfilename = "";
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

        $row1 = new mosTradeLead( $database );
        $row1->bind( $_POST );
        $row1->id = $_REQUEST['tid'];
        $row1->doc_id = $row->id;
        $row1->date   = intval($row->id)==0?date('Y-m-d'):$row1->date;
        $row1->store();
        //file processing start
        if(isset($_FILES['up_file']) && $_FILES['up_file']['name'][0]!=""){
            if(trim($_POST['original_dmfilename'])!="") {
                $file = $path . "/".$_POST['catid']."/".$_POST['original_dmfilename'];
                if(file_exists($file)){
                   @copy($file,$backup_path."/".$_POST['catid']."/".$_POST['original_dmfilename']);
                   @unlink($file);
                   $file_arr=explode("_",$_POST['original_dmfilename']);
                   $version=intval($file_arr[1])+1;
                }
            }
            else
               $version=1;

            $temporary_file_name = $path."/".$_POST['catid']."/".$database->getEscaped($_FILES['up_file']['name'][0]);
            $product_name = $path."/".$_POST['catid']."/".$row->id."_".$version."_".$database->getEscaped($_FILES['up_file']['name'][0]);
            @rename($temporary_file_name,$product_name);

            if(file_exists($downloadpath."/".$_POST['catid']."/".$_POST['original_dmfilename']))
                   @unlink($downloadpath."/".$_POST['catid']."/".$_POST['original_dmfilename']);
            $download_product_name = $downloadpath."/".$_POST['catid']."/".$row->id."_".$version."_".$database->getEscaped($_FILES['up_file']['name'][0]);
            @copy($product_name,$download_product_name);

            $product_name=$row->id."_".$version."_".$database->getEscaped($_FILES['up_file']['name'][0]);
            $database->setQuery("UPDATE #__docman SET dmfilename='".$product_name."' WHERE id='".$row->id."'");
            if (!$database->query())
                    $image_msg="Failed to upload Trade Lead.";
        }
        //end file processing


        //hscode list -- Multiple select
        $hscode_list = array();
        $hscode_list = explode(',',$_REQUEST['hscode']);
        for ($i=0; $i<count($hscode_list); $i++)
        {
          if(is_numeric(trim($hscode_list[$i]))){
               $rowHscode = new mosTradeLeadHscode( $database );
               $rowHscode->doc_id = $row->id;
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
        $hscode = implode('\',\'',$hscode_arr);
        $hscode = "'".$hscode."'";
        $query="delete from #__v3_trade_lead_hscode where doc_id='".$row->id."' and hscode not in(".$hscode.")";
        $database->setQuery($query);
        $database->query();

        $msg = 'The trade lead information has been saved successfully. ';
        mosRedirect( 'index2.php?option='.$option.'&errmsg='.$failed_msg, $msg );
}

function removeTradeLead( &$cid, $option ) {
        global $database;

        if ( count( $cid ) ) {
           $obj = new mosDMDocument( $database );
           foreach ($cid as $id) {
             if (!$obj->delete( $id )) {
                echo "<script> alert('".$obj->getError()."'); window.history.go(-1); </script>\n";
                exit();
             }
             $sql = "delete from #__v3_trade_lead_hscode where doc_id='".$id."'";
             $database->setQuery($sql);
             $database->query();
           }
        }

        $msg = 'The trade lead information has been deleted successfully.';
        mosRedirect( 'index2.php?option='. $option, $msg );
}

?>
