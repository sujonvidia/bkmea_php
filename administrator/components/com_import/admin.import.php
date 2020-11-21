<?php

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

require_once( $mainframe->getPath( 'admin_html' ) );
include_once("../includes/epb.function.php");

$task   = trim( mosGetParam( $_REQUEST, 'task', null ) );
$option = mosGetParam($_REQUEST, 'option', '');

switch ($task)
{
    case 'cancel':
        mosRedirect("index2.php");
        break;

    case 'import':
        import($option);
        break;

    default:
        HTML_Import ::TISData($option);
        break;
}

function import($option)
{
    global $mosConfig_absolute_path, $database, $my;

    $fileName = trim($_FILES['up_file']['name'][0]);
    $importdir = $mosConfig_absolute_path."/administrator/temp";
    $fileUp = uploadFile($_FILES['up_file'], $importdir."/", $fileName);

    if (file_exists($importdir."/".$fileName))
    {
        if ($fileName=='') {
             mosRedirect("index2.php?option=com_import&errmsg=Please select a source file.");
             exit;
        }

        $query = "select count(*) from #__import_log where file_name='".$fileName."'";
        $database->setQuery( $query );
        if($database->loadResult())
        {
            mosRedirect("index2.php?option=com_import&errmsg=This file has already been imported.");
            exit();
        }

        if (eregi( '.zip$', $fileName ))
        {
            require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pclzip.lib.php' );
            require_once( $mosConfig_absolute_path . '/administrator/includes/pcl/pclerror.lib.php' );
            $zipfile = new PclZip( $importdir."/".$fileName );
            $ret = $zipfile->extract( PCLZIP_OPT_PATH, $importdir."/" );
            if($ret == 0) {
                    mosRedirect("index2.php?option=com_import&errmsg=Failed to unzip.");
                    return false;
            }
            $content = file_get_contents($importdir."/".$fileName.".sql");
            $queryArr = explode("\n",$content);
            for($i=0;$i<count($queryArr);$i++){
                 if(trim($queryArr[$i])!="" && !eregi("^[/*]",trim($queryArr[$i])) ){
                    $database->setQuery($queryArr[$i]);
                    $database->query();
                 }
            }
            @unlink($importdir."/".$fileName.".sql");
            $cir_type="";
            if (eregi( '^circular', $fileName ))
            {
                 $fileArr = mosReadDirectory($importdir."/circular/");
                 for($i=0; $i<count($fileArr);$i++){
                     copy($importdir."/circular/".$fileArr[$i], $mosConfig_absolute_path."/administrator/images/circular/".$fileArr[$i]);
                     @unlink($importdir."/circular/".$fileArr[$i]);
                 }
                 rmdir($importdir."/circular");
                 $cir_type="Circular";
            }
            else if(eregi( '^trade_fair', $fileName ))
            {
                 $fileArr = mosReadDirectory($importdir."/trade_fair/",".");
                 for($i=0; $i<count($fileArr);$i++){
                     copy($importdir."/trade_fair/".$fileArr[$i], $mosConfig_absolute_path."/administrator/images/trade_fair/".$fileArr[$i]);
                     @unlink($importdir."/trade_fair/".$fileArr[$i]);
                 }
                 rmdir($importdir."/trade_fair");
                 $cir_type="Trade Fair";
            }
            else if(eregi( '^trade_lead', $fileName ))
            {
                 $fileArr = mosReadDirectory($importdir."/dmdocuments/",".");
                 for($i=0; $i<count($fileArr);$i++){
                     @copy($importdir."/dmdocuments/".$fileArr[$i], $mosConfig_absolute_path."/dmdocuments/-1/".$fileArr[$i]);
                     @copy($importdir."/dmdocuments/".$fileArr[$i], $mosConfig_absolute_path."/dmdocdownload/-1/".$fileArr[$i]);
                     @unlink($importdir."/dmdocuments/".$fileArr[$i]);
                 }
                 rmdir($importdir."/dmdocuments");
                 $cir_type="Trade Lead";
            }
            else{
                 mosRedirect("index2.php?option=com_import&errmsg=This is a source name error, A valid source name should start with circular/ trade_fair/ trade_lead.");
            }
        }
        else
        {
            mosRedirect("index2.php?option=com_import&errmsg=This is a source file error, please select a zip file as source.");
        }
        @unlink($importdir."/".$fileName);
        $query = "insert into #__import_log values('','".$fileName."','".$my->id."','".date('Y-m-d')."')";
        $database->setQuery($query);
        $database->query();
    }
    else{
      mosRedirect("index2.php?option=com_import&errmsg=Failed to upload source file");
    }

    mosRedirect("index2.php?option=com_import","The ".$cir_type." information hes been imported successfully.");

}


?>
