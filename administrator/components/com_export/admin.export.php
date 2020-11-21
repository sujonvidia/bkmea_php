<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
// assign global folder paths
$exportPath   = $GLOBALS['mosConfig_absolute_path'] . '/administrator/export_doc';
$downloadPath = $GLOBALS['mosConfig_live_site']     . '/administrator/export_doc';

// load additional components
require_once( $mainframe->getPath( 'admin_html' ) );
include $mosConfig_absolute_path.'/administrator/includes/pcl/zip.lib.php';
require_once( '../includes/epb.function.php' );

// retrieve row selection from forms
$cid   = mosGetParam( $_REQUEST, 'cid','' );
$id   = mosGetParam( $_REQUEST, 'id', '' );
$option   = mosGetParam( $_REQUEST, 'option', '' );
$type   = mosGetParam( $_REQUEST, 'export_tic_type', '' );

$exportFor = array();
$exportFor[1] = "Bkmea";
$exportFor[2] = "Association";

$typeName = array();
$typeName[1] = "Circular";
$typeName[2] = "Trade Fair";
$typeName[3] = "Trade Lead";

if (!is_array( $cid )) {
    $cid = array(0);
}

// process the workflow selection
switch ($task) {
    case 'generate':
    case 'generatedb':
        generateExport( $option );
        break;

    case 'remove':
        deleteExport( $cid, $option, '' );
        break;

    case 'cancelExport':
        CancelExport( $id, $option );
        break;

    case 'cancel':
        mosRedirect( 'index2.php?option='.$option );
        break;

    case 'show':
    case 'showdb':
    default:
        showExportList( $option, $type );
        break;
}

function showExportList( $option, $type )
{
        global $database, $mainframe, $mosConfig_list_limit, $mosConfig_absolute_path;
        global $baDBBackupPath, $downloadPath;

        $limit              = $mainframe->getUserStateFromRequest( "viewlistlimit", 'limit', $mosConfig_list_limit );
        $limitstart         = $mainframe->getUserStateFromRequest( "view{$section}limitstart", 'limitstart', 0 );
        $filter_type        = $_REQUEST['filter_type'];

        // get the total number of records
        if($filter_type)
        {
            $query = " SELECT count(ihl.id) FROM #__v3_info_hub_log as ihl, #__stakeholder as sh "
                    ." where ihl.is_circular_fair_lead_stat='".$filter_type."' and sh.id=ihl.is_bkmea_association "
                    ." order by ihl.id DESC " ;
        }
        else{
            $query = " SELECT count(ihl.id) FROM #__v3_info_hub_log as ihl, #__stakeholder as sh "
                    ." where sh.id=ihl.is_bkmea_association order by ihl.id DESC " ;
        }
        $database->setQuery( $query );
        $total = $database->loadResult();

        require_once( $mosConfig_absolute_path . '/administrator/includes/pageNavigation.php' );
        $pageNav = new mosPageNav( $total, $limitstart, $limit );

        //get circular list from database
        if($filter_type)
        {
            $query = " SELECT ihl.*,sh.name as export_for FROM #__v3_info_hub_log as ihl, #__stakeholder as sh "
                    ." where ihl.is_circular_fair_lead_stat='".$filter_type."' and sh.id=ihl.is_bkmea_association "
                    ." order by ihl.id DESC LIMIT $pageNav->limitstart, $pageNav->limit";
        }
        else{
            $query = " SELECT ihl.*,sh.name as export_for FROM #__v3_info_hub_log as ihl, #__stakeholder as sh "
                    ." where sh.id=ihl.is_bkmea_association "
                    ." order by ihl.id DESC LIMIT $pageNav->limitstart, $pageNav->limit" ;
        }
        $database->setQuery( $query );
        $rows = $database->loadObjectList();

        $arr = array();
        $arr[] = mosHTML::makeOption( '0', "All" );
        $arr[] = mosHTML::makeOption( '1', "Circular" );
        $arr[] = mosHTML::makeOption( '2', "Trade Fair" );
        $arr[] = mosHTML::makeOption( '3', "Trade Lead" );

        $lists = array();
        $lists['filter_type'] = mosHTML::selectList( $arr, 'filter_type', 'class="inputbox" size="1" onchange="javascript: document.adminForm.submit( );"', 'value', 'text', $filter_type );

        // load presentation layer
        HTML_export::showExportList( $rows, $option, $lists, $pageNav );
}


function deleteExport( $cid, $option )
{
    global $exportPath;

    // Cycle through all the selected Backups and Deleted them
    for ($i=0, $n=count($cid); $i < $n; $i++) {
        if ( !unlink( $exportPath.'/'.mosGetParam( $_REQUEST, 'f'.$cid[$i], 'FAILED' ) ) ) {
            // redirect to list screen
            $msg = 'Deletion of file(s) FAILED.';
            mosRedirect( 'index2.php?option='.$option.'&task=showdb', $msg );
        }
    }

    // redirect to list screen
    $msg = 'File(s) Deleted';
    mosRedirect( 'index2.php?option='.$option, $msg );
}

function cancelExport( $id, $option )
{
    global $exportPath, $database;
    $query = "select filename from #__v3_info_hub_log where id='".$id."'";
    $database->setQuery($query);
    $rows = $database->loadObjectList();
    $filename = $rows[0]->filename;

    $query = "delete from #__v3_info_hub_log where id='".$id."'";
    $database->setQuery($query);

    if ( $database->query() )
    {
       @unlink( $exportPath.'/'.$filename );
       $msg = 'The exported TIS data has been canceled successfully.';
       mosRedirect( 'index2.php?option='.$option, $msg );
    }
    // redirect to list screen
    $msg = 'Failed to cancel exported TIS data.';
    mosRedirect( 'index2.php?option='.$option, $msg );
}

function generateExport( $option ) {
    global $exportPath, $database, $exportFor, $mosConfig_absolute_path;

    //select partner organization;
    $query =  " select id, email from #__stakeholder where is_delete='0' and is_partner='1' ";
    $database->setQuery( $query );
    $rows = $database->loadObjectList();
    $hscodeRows = array();

    if(count($rows))
    {
       //exporte time and database version;
       set_time_limit(300);
       $OutBuffer .= "/* Generation Time: " . date("M j, Y \a\\t H:i") . " */\n";
       $OutBuffer .= "/* Server version: " . $database->getVersion() . " */\n\n";
       $subject = "Circulation";
       $body = "";

       for($i=0;$i<count($rows);$i++)
       {
          $row = $rows[$i];
          $query = " select pl.hscode from #__member_product_line as mpl, #__product_line as pl "
                  ." where mpl.member_id='".$row->id."' and mpl.product_id=pl.id ";
          $database->setQuery( $query );
          $hscodeRows = $database->loadResultArray();
          if(count($hscodeRows))
          {
             //hscode related circulation
             $con1 = expCirculation($row->id,$hscodeRows, $row->email, $subject, $body);
             $con2 = expTradeFair($row->id,$hscodeRows, $row->email, $subject, $body);
             $con3 = expTradeLead($row->id,$hscodeRows, $row->email, $subject, $body);
          }
          else
          {
             //all circulation;
             $con1 = expCirculation($row->id,$hscodeRows, $row->email, $subject, $body);
             $con2 = expTradeFair($row->id,$hscodeRows, $row->email, $subject, $body);
             $con3 = expTradeLead($row->id,$hscodeRows, $row->email, $subject, $body);
          }
       }
    }
    if($con1 || $con2 || $con3)
      $msg = 'Circulation has been exported successfully.';
    else
      $msg = 'There is no updated circulation.';
    mosRedirect( 'index2.php?option='. $option, $msg );

}

function expCirculation($id, &$hscodeRows, $email, $subject, $body)
{
    global $database, $mosConfig_absolute_path, $exportPath, $mosConfig_mailfrom, $mosConfig_fromname;

    $sql = " select max(process_datetime) as max_proc_datetime "
          ." from #__v3_info_hub_log where is_circular_fair_lead_stat='1' and is_bkmea_association='".$id."'";
    $database->setQuery($sql);
    $res = $database->loadObjectList();

    $zipfile = new zipfile();

    if(count($hscodeRows))
    {
       //for general hscode
       $query = " select distinct(c.id),c.* from #__v3_circular as c, #__v3_circular_hscode as ch "
               ." where c.id not in(select distinct(circular_id) from #__v3_circular_hscode) "
               ." and c.update_date>'".$res[0]->max_proc_datetime."'";
       $database->setQuery($query);
       $result = $database->loadObjectList();

       //hscode related
       for($i=0; $i<count($hscodeRows); $i++)
       {
          $query = " select distinct(c.id),c.* "
                  ." from #__v3_circular as c, #__v3_circular_hscode as ch "
                  ." where ch.hscode like '".$hscodeRows[$i]."%' and c.id=ch.circular_id "
                  ." and c.update_date>'".$res[0]->max_proc_datetime."' ";
          $database->setQuery($query);    echo $query;
          $hscodeList = $database->loadObjectList();
          $result = array_merge($result,$hscodeList);
       }
    }
    else
    {
       $query = " select c.* from #__v3_circular as c where c.update_date>'".$res[0]->max_proc_datetime."'";
       $database->setQuery($query);
       $result = $database->loadObjectList();
    }
                
    if(count($result)){
      foreach($result as $row)
      {
        $OutBuffer .= "/*Dumping data for table #__v3_circular */\n";
        $OutBuffer .= exportSQL($row, "#__v3_circular", '', '');
        if($row->file_name!="")
        {
           $content = file_get_contents($mosConfig_absolute_path."/administrator/images/circular/".$row->file_name);
           $zipfile -> addFile($content, "circular/".$row->file_name);
        }
        $mapId = "circular_id";
        $mapVal = "(select max(LAST_INSERT_ID(id)) from #__v3_circular )";
        $sql = "SELECT * FROM #__v3_circular_hscode where circular_id='".$row->id."'";
        $database->setQuery($sql);
        $hscodeRows = $database->loadObjectList();
        if(count($hscodeRows)){
          $OutBuffer .= "/* Dumping data for table #__v3_circular_hscode */\n";
          foreach($hscodeRows as $hscodeRow)
          {
             $OutBuffer .= exportSQL($hscodeRow, "#__v3_circular_hscode", $mapId, $mapVal);
          }
        }
      }

      $dumpFileName = "circular_".time().rand(date('Ymd'), time()).".zip";
      $zipfile -> addFile($OutBuffer, $dumpFileName.".sql");
      $fp = fopen("$exportPath/$dumpFileName", "wb");
      if($fp){
         fwrite($fp, $zipfile->file());
         fclose($fp);
         $query = "insert into #__v3_info_hub_log values('','1','".$id."','".date('Y-m-d H:i:s')
               ."','".$dumpFileName."','".$my->username."')";
         $database->setQuery($query);
         $database->query();
         $attachment = $exportPath."/".$dumpFileName;
      }
      if($email!="")
        mosMail($mosConfig_mailfrom, $mosConfig_fromname, $email, $subject, $body, $mode=true, Null, Null, $attachment);
    }
    else
      return false;
    return true;
}

function expTradeFair($id, $hscodeRows, $email, $subject, $body)
{
    global $database, $mosConfig_absolute_path, $exportPath, $mosConfig_mailfrom, $mosConfig_fromname;

    $sql = " select max(process_datetime) as max_proc_datetime "
          ." from #__v3_info_hub_log where is_circular_fair_lead_stat='2' and is_bkmea_association='".$id."'";
    $database->setQuery($sql);
    $res = $database->loadObjectList();

    $zipfile = new zipfile();
    if(count($hscodeRows))
    {
       //for general hscode
      $query = " select distinct(t.id),t.* from #__v3_trade_fair as t, #__v3_trade_fair_hscode as th "
              ." where t.id not in(select distinct(circular_id) from #__v3_trade_fair_hscode) "
              ." and t.update_date>'".$res[0]->max_proc_datetime."'";
       $database->setQuery($query);
       $result = $database->loadObjectList();

       //hscode related
       for($i=0; $i<count($hscodeRows); $i++)
       {
          $query = " select distinct(t.id),t.* from #__v3_trade_fair as t, #__v3_trade_fair_hscode as th "
                  ." where th.hscode like '".$hscodeRows[$i]."%' and t.id=th.circular_id "
                  ." and t.update_date>'".$res[0]->max_proc_datetime."' ";
          $database->setQuery($query);
          $hscodeList = $database->loadObjectList();
          $result = array_merge($result,$hscodeList);
       }
    }
    else
    {
       $query = " select c.* from #__v3_trade_fair as c where c.update_date>'".$res[0]->max_proc_datetime."'";
       $database->setQuery($query);
       $result = $database->loadObjectList();
    }

    if(count($result)){
       foreach($result as $row)
       {
         $OutBuffer .= "/* Dumping data for table #__v3_trade_fair */\n";
         $OutBuffer .= exportSQL($row, "#__v3_trade_fair", '', '');
         if($row->file_name!="")
         {
            $content = file_get_contents($mosConfig_absolute_path."/administrator/images/trade_fair/".$row->file_name);
            $zipfile -> addFile($content, "trade_fair/".$row->file_name);
         }
         $mapId = "trade_fair_id";
         $mapVal = "(select max(LAST_INSERT_ID(id)) from #__v3_trade_fair )";
         $sql = "SELECT * FROM #__v3_trade_fair_hscode where trade_fair_id='".$row->id."'";
         $database->setQuery($sql);
         $hscodeRows = $database->loadObjectList();
         if(count($hscodeRows)){
           $OutBuffer .= "/* Dumping data for table #__v3_trade_fair_hscode */\n";
           foreach($hscodeRows as $hscodeRow)
           {
              $OutBuffer .= exportSQL($hscodeRow, "#__v3_trade_fair_hscode", $mapId, $mapVal);
           }
         }
       }
       $dumpFileName = "trade_fair_".time().rand(date('Ymd'), time()).".zip";
       $zipfile -> addFile($OutBuffer, $dumpFileName.".sql");
       $fp = fopen("$exportPath/$dumpFileName", "wb");
       if($fp){
         fwrite($fp, $zipfile->file());
         fclose($fp);
         $query = "insert into #__v3_info_hub_log values('','2','".$id."','".date('Y-m-d H:i:s')
               ."','".$dumpFileName."','".$my->username."')";
         $database->setQuery($query);
         $database->query();
         $attachment = $exportPath."/".$dumpFileName;
       }
       if($email!="")
         mosMail($mosConfig_mailfrom, $mosConfig_fromname, $email, $subject, $body, $mode=true, Null, Null, $attachment);
    }
    else
      return false;
    return true;
}

function expTradeLead($id, $hscodeRows, $email, $subject, $body)
{
    global $database, $mosConfig_absolute_path, $exportPath, $mosConfig_mailfrom, $mosConfig_fromname;

    $sql = " select max(process_datetime) as max_proc_datetime "
          ." from #__v3_info_hub_log where is_circular_fair_lead_stat='3' and is_bkmea_association='".$id."' ";
    $database->setQuery($sql);
    $res = $database->loadObjectList();

    $zipfile = new zipfile();
    if(count($hscodeRows))
    {
       //for general hscode
      $query = " select distinct(d.id),d.* from #__docman as d, #__v3_trade_lead_hscode as th "
              ." where d.id not in(select distinct(doc_id) from #__v3_trade_lead_hscode) "
              ." and d.dmlastupdateon>'".$res[0]->max_proc_datetime."' and d.catid='-1' ";
       $database->setQuery($query);
       $result = $database->loadObjectList();

       //hscode related
        for($i=0; $i<count($hscodeRows); $i++)
       {
          $query = " select distinct(t.id),t.* from #__v3_trade_fair as t, #__v3_trade_fair_hscode as th "
                  ." where th.hscode like '".$hscodeRows[$i]."%' and t.id=th.circular_id "
                  ." and d.dmlastupdateon>'".$res[0]->max_proc_datetime."' and d.catid='-1' ";
          $database->setQuery($query);
          $hscodeList = $database->loadObjectList();
          $result = array_merge($result,$hscodeList);
       }
    }
    else
    {
       $query = " select c.* from #__docman as c where c.dmlastupdateon>'".$res[0]->max_proc_datetime."'";
       $database->setQuery($query);
       $result = $database->loadObjectList();
    }

    if(count($result)){
       foreach($result as $row)
        {
          $OutBuffer .= "/* Dumping data for table #__docman */\n";
          $OutBuffer .= exportSQL($row, "#__docman", '', '');
          if($row->dmfilename!="")
          {
             $content = file_get_contents($mosConfig_absolute_path."/dmdocuments/-1/".$row->dmfilename);
             $zipfile -> addFile($content, "dmdocuments/".$row->dmfilename);   ;
          }
          if($row->dmimage!="")
          {
             $content = file_get_contents($mosConfig_absolute_path."/dmdocuments/-1/".$row->dmimage);
             $zipfile -> addFile($content, "dmdocuments/".$row->dmimage);   ;
          }
          $OutBuffer .= "/* Dumping data for table #__v3_trade_lead */\n";
          $sql = "SELECT * FROM #__v3_trade_lead where doc_id='".$row->id."'";
          $database->setQuery($sql);
          $tradeLeadRows = $database->loadObjectList();
          $mapVal = "(select max(LAST_INSERT_ID(id)) from #__docman )";
          $OutBuffer .= exportSQL($tradeLeadRows[0], "#__v3_trade_lead", 'doc_id', $mapVal);
          $sql = "SELECT * FROM #__v3_trade_lead_hscode where doc_id='".$row->id."'";
          $database->setQuery($sql);
          $hscodeRows = $database->loadObjectList();
          if(count($hscodeRows)){
            $OutBuffer .= "/* Dumping data for table #__v3_trade_lead_hscode */\n";
            $mapVal = "(select max(LAST_INSERT_ID(id)) from #__docman )";
            foreach($hscodeRows as $hscodeRow)
            {
               $OutBuffer .= exportSQL($hscodeRow, "#__v3_trade_lead_hscode", 'doc_id', $mapVal);
            }
          }
        }
        $dumpFileName = "trade_lead_".time().rand(date('Ymd'), time()).".zip";
        $zipfile -> addFile($OutBuffer, $dumpFileName.".sql");
        $fp = fopen("$exportPath/$dumpFileName", "wb");
        if($fp){
          fwrite($fp, $zipfile->file());
          fclose($fp);
          $query = "insert into #__v3_info_hub_log values('','3','".$id."','".date('Y-m-d H:i:s')
               ."','".$dumpFileName."','".$my->username."')";
          $database->setQuery($query);
          $database->query();
          $attachment = $exportPath."/".$dumpFileName;
        }
        if($email!="")
          mosMail($mosConfig_mailfrom, $mosConfig_fromname, $email, $subject, $body, $mode=true, Null, Null, $attachment);
    }
    else
      return false;
    return true;
}

function getFileSizeText($filesize) {
    /**
     * Routine to display a formatted version of a filesize
     */
    return exportTools::getFileSizeText($filesize);
}

function exportSQL($row, $tblval, $mapField='', $mapVal)
{
    global $database;
    $InsertDump = "INSERT INTO `".$tblval."` VALUES (";
    $arr = mosObjectToArray($row); echo "->";
    foreach($arr as $key => $value)
    {
         if($key=='id')
           $InsertDump .= "'',";
         else if($key==$mapField)
           $InsertDump .= "".$mapVal.",";
         else
         {
            $value = addslashes( $value );
            $value = str_replace( "\n", '\r\n', $value );
            $value = str_replace( "\r", '', $value );
            if (preg_match ("/\b" . $FieldType[$tblval][$key] . "\b/i", "DATE TIME DATETIME CHAR VARCHAR TEXT TINYTEXT MEDIUMTEXT LONGTEXT BLOB TINYBLOB MEDIUMBLOB LONGBLOB ENUM SET"))
            {
                $InsertDump .= "'$value',";
            }
            else
            {
                $InsertDump .= "'$value',";      //single quotation added for null column
            }
         }
    }
    $InsertDump = rtrim($InsertDump,',') . ");\n";
    return $InsertDump;
}

/**
* @package Mambo
* @subpackage baBackup
*/
class exportTools {

    function getFileSizeText($filesize) {
        /**
         * Routine to display a formatted version of a filesize
         */

        if( $filesize >= 1024 && $filesize < 1048576) {
            // Size in kilobytes
            return round( $filesize / 1024, 2 ) . " KB";
        } elseif( $filesize >= 1048576 ) {
            // Size in megabytes
            return round( $filesize / 1024 / 1024, 2 ) . " MB";
        } else {
            // Size in bytes
            return $filesize . " bytes";
        }
    }

}


?>
