<?php
/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: documents.php,v 1.31 2006/12/26 06:45:59 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

include_once dirname(__FILE__) . '/documents.html.php';

require_once ($_DOCMAN->getPath('classes' , 'file'));
require_once($_DOCMAN->getPath('classes', 'mambots'));
include_once($_DOCMAN->getPath('classes', 'params'));

switch ($task) {
    case "publish" :
        publishDocument($cid, 1);
        break;
    case "unpublish":
        publishDocument($cid, 0);
        break;
    case "approve":
        approveDocument($cid, 1);
        publishDocument($cid, 1);
        break;
    case "unapprove":
        approveDocument($cid, 0);
        publishDocument($cid, 0);
        break;
    case "new":
        editDocument(0);
        break;
    case "removeimage":
        editDocument($_GET['cid']);      //$_POST['id']
        break;
    case "edit":
        editDocument($cid[0]);
        break;
    case "move_form":
        moveDocumentForm($cid);
        break;
    case "move_process":
        moveDocumentProcess($cid);
        break;
    case "remove":
        removeDocument($cid);
        break;
    case "save":
        saveDocument();
        break;
    case "cancel":
        cancelDocument();
        break;
    case "download" :
        downloadDocument($bid);
        break;
    case "show":
    default :
        showDocuments($pend, $sort, 0);
}

function showDocuments($pend, $sort, $view_type)
{
    global $_DOCMAN;
    require_once($_DOCMAN->getPath('classes', 'utils'));

    global $database, $mainframe, $option, $section;
    global $mosConfig_list_limit, $section, $menutype;

    $catid = $mainframe->getUserStateFromRequest("catidarc{option}{$section}", 'catid', 0);
    $limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$option}{$section}limitstart", 'limitstart', 0);
    $levellimit = $mainframe->getUserStateFromRequest("view{$option}{$section}limit", 'levellimit', 10);

    $search = $mainframe->getUserStateFromRequest("searcharc{$option}{$section}", 'search', '');
    $search = $database->getEscaped(trim(strtolower($search)));

    $where = array();

    if ($catid > 0) {
        $where[] = "a.catid='$catid'";
    }
    if ($search) {
        $where[] = "LOWER(a.dmname) LIKE '%$search%'";
    }
    /*
    if ($pend == 'yes') {
        $where[] = "a.approved LIKE '0'";
    }
    */
    // get the total number of records
   /*
    $query = "SELECT count(*) "
     . "\n FROM #__docman AS a"
     . (count($where) ? "\n WHERE " . implode(' AND ', $where) : "");
    $database->setQuery($query);
    $total = $database->loadResult();
    */
    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    // $where[] = "a.catid=cc.id";
    if ($sort == 'filename') {
        $sorttemp = "a.dmfilename";
    } else if ($sort == 'name') {
        $sorttemp = "a.dmname";
    } else if ($sort == 'date') {
      //else {
        $sorttemp = "a.dmdate_published";
    } else {
       // $sorttemp = "a.catid,a.dmname";
        $sorttemp = "a.dmdate_published";
    }

    $query = "SELECT a.*, cc.name AS category, u.name AS editor"
     . "\n FROM #__docman AS a"
     . "\n LEFT JOIN #__users AS u ON u.id = a.checked_out"
     . "\n LEFT JOIN #__categories AS cc ON cc.id = a.catid "
     . "\n WHERE cc.section='com_docman' and a.is_delete=0 and cc.is_delete='0'"
     . (count($where) ? "\n and " . implode(' AND ', $where) : "")
     . "\n ORDER BY " . $sorttemp . " DESC, a.id DESC" ;
    $database->setQuery($query);
    $rows = $database->loadObjectList();
    $total=count($rows);
    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }

    $dm_not_expire=",";
    $dm_expire=",";
    for($i=0;$i<count($rows);$i++){
            $row=&$rows[$i];
            if(strtotime($row->dmdate_expire)>strtotime(date("Y-m-d"))){
               $dm_not_expire.=$row->id.",";
            }
    }
    //echo $dm_not_expire;

    require_once($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    // slice out elements based on limits
    $rows = array_slice($rows, $pageNav->limitstart, $pageNav->limit);
    // add category name
    $list = DOCMAN_utils::categoryArray();
    for ($i = 0, $n = count($rows);$i < $n;$i++) {
        $row = &$rows[$i];
        $row->treename = array_key_exists($row->catid , $list) ?
        $list[$row->catid]->treename : '(orphan)';
    }
    // get list of categories
    $options = array();
    $options[] = dmHTML::makeOption('0', _DML_SELECT_CAT);
    //$options[] = dmHTML::makeOption('-1', _DML_ALL_CATS);
    $lists['catid'] = dmHTML::categoryList($catid, "document.adminForm.submit();", $options);
    // get unpublished documents
    $database->setQuery("SELECT count(*) FROM #__docman WHERE approved='0'");
    $number_pending = $database->loadResult();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    // get pending documents
    $database->setQuery("SELECT count(*) FROM #__docman WHERE published='0'");
    $number_unpublished = $database->loadResult();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }

    HTML_DMDocuments::showDocuments($rows, $lists, $search, $pageNav, $number_pending, $number_unpublished, $view_type, $dm_not_expire);
}

/*
*    @desc Edit a document entry
*/
function editDocument($uid)
{
    require_once ("components/com_docman/classes/DOCMAN_utils.class.php");
    require_once ("components/com_docman/classes/DOCMAN_params.class.php");

    global $database, $my, $mosConfig_absolute_path, $mosConfig_live_site;
    global $_DOCMAN;

    //remove category image
    if($_GET['task']=="removeimage"){
         $file = $_DOCMAN->getCfg('dmpath') . "/".$uid."/".$_GET['image'];
         if(file_exists($file) && @unlink($file)){
            $database->setQuery("UPDATE #__docman SET dmimage='' WHERE id='".$uid."'");
            if (!$database->query()) {
                 echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1);</script>\n";
                 exit();
            }
         }
    }

    $doc = new mosDMDocument($database);
    if ($uid) {
        $doc->load($uid);
       /* if ($doc->checked_out) {
            if ($doc->checked_out <> $my->id) {
                mosRedirect("index2.php?option=$option", _DML_THE_MODULE . " $row->title " . _DML_IS_BEING);
            }
        } else { // check out document...
            $doc->checkout($my->id);
        }*/
    } else {
        $doc->init_record();
    }

    // Begin building interface information...
    $lists = array();

    $lists['document_url']        = ''; //make sure
    $lists['original_dmfilename'] = $doc->dmfilename;
    if (strcasecmp(substr($doc->dmfilename , 0, _DM_DOCUMENT_LINK_LNG) , _DM_DOCUMENT_LINK) == 0) {
        $lists['document_url'] = substr($doc->dmfilename , _DM_DOCUMENT_LINK_LNG);
        $doc->dmfilename = _DM_DOCUMENT_LINK ;
    }

    // category select list
    $options = array(mosHTML::makeOption('0', _DML_SELECT_CAT));
    $lists['catid'] = dmHTML::categoryList($doc->catid, "", $options);
    // check if we have at least one category defined
    $database->setQuery("SELECT id " . "\n FROM #__categories " . "\n WHERE section='com_docman' LIMIT 1");

    if (!$checkcats = $database->loadObjectList()) {
        mosRedirect("index2.php?option=com_docman&section=categories", _DML_PLEASE_SEL_CAT);
    }

    // select lists
    $lists['approved'] = mosHTML::yesnoRadioList('approved', 'class="inputbox"', $uid?$doc->approved:1);
    $lists['published'] = mosHTML::yesnoRadioList('published', 'class="inputbox"', $uid?$doc->published:1);
    $lists['is_remove'] = mosHTML::yesnoRadioList('is_remove', 'class="inputbox"', 0, "Removed", "Unchanged");

    // licenses list
    /*
    $database->setQuery("SELECT id, name " . "\n FROM #__docman_licenses " . "\n ORDER BY name ASC");
    $licensesTemp = $database->loadObjectList();
    $licenses[] = mosHTML::makeOption('0', _DML_NO_LICENSE);

    foreach($licensesTemp as $licensesTemp) {
        $licenses[] = mosHTML::makeOption($licensesTemp->id, $licensesTemp->name);
    }

    $lists['licenses'] = mosHTML::selectList($licenses, 'dmlicense_id',
        'class="inputbox" size="1"', 'value', 'text', $doc->dmlicense_id);

    // licenses display list
    $licenses_display[] = mosHTML::makeOption('0', _DML_NO);
    $licenses_display[] = mosHTML::makeOption('1', _DML_YES);;
    $lists['licenses_display'] = mosHTML::selectList($licenses_display,
        'dmlicense_display', 'class="inputbox" size="1"', 'value', 'text', $doc->dmlicense_display);
    */
    if ($uploaded_file == '')
    {
        // Create docs List
        $dm_path      = $_DOCMAN->getCfg('dmpath');
        $fname_reject = $_DOCMAN->getCfg('fname_reject');

        $docFiles = mosReadDirectory($dm_path);

        $docs = array(mosHTML::makeOption('', _DML_SELECT_DOC));
        $docs[] = mosHTML::makeOption(_DM_DOCUMENT_LINK , _DML_LINKED);

        if ( count($docFiles) > 0 )
        {
            foreach ( $docFiles as $file )
            {

                if ( substr($file,0,1) == '.' ) continue; //ignore files starting with .
                if ( @is_dir($dm_path . '/' . $file) ) continue; //ignore directories
                if ( $fname_reject && preg_match("/^(".$fname_reject.")$/i", $file) ) continue; //ignore certain filenames

                       //$query = "SELECT * FROM #__docman WHERE dmfilename='" . $database->getEscaped($file) . "'";
                      //$database->setQuery($query);
                     //if (!($result = $database->query())) {
                //        echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
                     //}

                //if ($database->getNumRows($result) == 0 || $doc->dmfilename == $file) {
                    $docs[] = mosHTML::makeOption($file);
                //}
            } //end foreach $docsFiles
        }

        if ( count($docs) < 1 ) {
            mosRedirect("index2.php?option=$option&task=upload", _DML_YOU_MUST_UPLOAD);
        }

        $lists['dmfilename'] = mosHTML::selectList($docs, 'dmfilename',
            'class="inputbox" size="1"', 'value', 'text', $doc->dmfilename);
    } else { // uploaded_file isn't blank

            $filename = split("\.", $uploaded_file);
             $row->dmname = $filename[0];

        $docs = array(mosHTML::makeOption($uploaded_file));
        $lists['dmfilename'] = mosHTML::selectList($docs, 'dmfilename',
            'class="inputbox" size="1"', 'value', 'text', $doc->dmfilename);
    } // endif uploaded_file

    // permissions lists
    $lists['viewer']     = dmHTML::viewerList($doc, 'dmowner');
    $lists['maintainer'] = dmHTML::maintainerList($doc, 'dmmantainedby');

    // updater user information
    $last = array();
    if ($doc->dmlastupdateby > '0' && $doc->dmlastupdateby != $my->id) {
        $database->setQuery("SELECT id, name FROM #__users WHERE id='" . $doc->dmlastupdateby . "'");
        $last = $database->loadObjectList();
    } else $last[0]->name = $my->name ? $my->name : $my->username; // "Super Administrator"

    // creator user information
    $created = array();
    if ($doc->dmsubmitedby > '0' && $doc->dmsubmitedby != $my->id) {
        $database->setQuery("SELECT id, name FROM #__users WHERE id='" . $doc->dmsubmitedby . "'");
        $created = $database->loadObjectList();
    } else $created[0]->name = $my->name ? $my->name : $my->username; // "Super Administrator"

    // Imagelist
    $lists['image'] = dmHTML::imageList('dmthumbnail', $doc->dmthumbnail);

    // Params definitions
    $params_path = $mosConfig_absolute_path . '/administrator/components/com_docman/docman.params.xml';
        if(file_exists($params_path)) {
                $params =& new dmParameters( $doc->attribs, $params_path , 'params' );
        }

        /* ------------------------------ *
     *   MAMBOT - Setup All Mambots   *
     * ------------------------------ */
    $prebot = new DOCMAN_mambot('onBeforeEditDocument');
    $prebot->setParm('document' , $doc);
    $prebot->setParm('filename' , $filename);
    $prebot->setParm('user' , $_DMUSER);

     if (!$uid) {
        $prebot->copyParm('process' , 'new document');
    } else {
        $prebot->copyParm('process' , 'edit document');
    }

    $prebot->trigger();

    if ($prebot->getError()) {
            mosRedirect("index2.php?option=com_docman&section=documents", $prebot->getErrorMsg());
    }

    HTML_DMDocuments::editDocument($doc, $lists, $last, $created, $params);
}

function removeDocument($cid)
{
    global $database;

    $document = new mosDMDocument($database);
    if ($document->remove($cid)) {
        mosRedirect("index2.php?option=com_docman&section=documents&mosmsg=The Information Product has been deleted successfully.");
    }
}

function cancelDocument()
{
    global $database;

    $document = new mosDMDocument($database);
    if ($document->cancel()) {
        mosRedirect("index2.php?option=com_docman&section=documents");
    }
}

function publishDocument($cid, $publish = 1)
{
    global $database;

    $document = new mosDMDocument($database);
    if ($document->publish($cid, $publish)) {
        mosRedirect("index2.php?option=com_docman&section=documents");
    }
}

/*
*    @desc Approves a document
*/

function approveDocument($cid, $approved = 1)
{
    global $database;

    $document = new mosDMDocument($database);
    if ($document->approve($cid, $approved)) {
        mosRedirect("index2.php?option=com_docman&section=documents");
    }
}

/*
*    @desc Saves a document
*/

function saveDocument()
{
    global $_DOCMAN, $database;
    //fetch current id
    $cid = mosGetParam($_POST , 'id' , 0);
    //create info product record
    $document = new mosDMDocument($database);
    // Load from id
    if (!$document->bind($_POST)) {
        echo "<script> alert('".$document->getError() ."'); window.history.go(-1); </script>\n";
        exit();
    }
    ####################### Start::File and Image Upload #######################
    //info product path
    $path = $_DOCMAN->getCfg('dmpath');
    $backup_path=$_DOCMAN->getCfg('dmbackuppath');
    $downloadpath=$_DOCMAN->getCfg('dmdownloadpath');
    $timestamp=strtotime(date('Y-m-d H:i:s',time()));
    #--- start to check directory and directory permission ---#
    #directory: products, backup and download                 #
    #if directory not exist's then create else set permission #
    #---------------------------------------------------------#
    /*
    if(!file_exists($path)){
            mkdir($path."/",0777);
    }else{
            chmod($path,0777);
    }
    if(!file_exists($downloadpath)){
            mkdir($downloadpath."/",0777);
    }else{
            chmod($downloadpath,0777);
    }
    if(!file_exists($backup_path)){
            mkdir($backup_path."/",0777);
    }else{
            chmod($backup_path,0777);
    }
    */
    #-------------  end directory checking  ------------------#
    #--- start::o check category and directory permission  ---#
    #directory: category                                      #
    #if directory not exist's then create else set permission #
    #---------------------------------------------------------#
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
    if (intval($cid)!=0){
        if(!file_exists($backup_path."/".$_POST['catid'])){
            mkdir($backup_path."/".$_POST['catid']."/",0777);
        }else{
            chmod($backup_path."/".$_POST['catid'],0777);
        }
    }
    #--------------------------end---------------------------#

    //image upload
    if(trim($_FILES['dmimage']['name'][0])!=""){
          $upload = new DOCMAN_FileUpload();
          $file_upload = mosGetParam($_FILES, 'dmimage');
          $result1 = &$upload->uploadHTTP($file_upload, $path."/".$_POST['catid'], _DM_VALIDATE_ADMIN);
          if (!$result1) {
             $image_upload=0;
          }
          else
              $image_upload=1;
    }

    //info product upload
    if(trim($_FILES['dmfilename']['name'][0])!="" ){
              $upload = new DOCMAN_FileUpload();
              $file_upload = mosGetParam($_FILES, 'dmfilename');
              $result2 = &$upload->uploadHTTP($file_upload, $path."/".$_POST['catid'], _DM_VALIDATE_ADMIN);
              if (!$result2) {
                 $product_upload=0;
              }
              else{
                  $product_upload=1;
              }
              $document->dmlink=0;
    }
    else{
          if(strtolower(trim($_POST['dmlink']))=="on")
            $document->dmlink=1;
          else
            $document->dmlink=0;

    }
    ####################### End::File and Image Upload  #######################
    if($_POST['dmdate_published']!="")
       $document->dmdate_published=mosHTML::ConvertDateForDatatbase($_POST['dmdate_published']);

     if (empty($_POST['dmdate_expire'])){
            $published_date=explode("-",mosHTML::ConvertDateForDatatbase($_POST['dmdate_published']));
            $year=intval($published_date[0])+1;
            $dmdate_expire=$year."-".$published_date[1]."-".$published_date[2];
            $document->dmdate_expire=$dmdate_expire;
     }
     else
        $document->dmdate_expire=mosHTML::ConvertDateForDatatbase($_POST['dmdate_expire']);

     $document->_tbl_key = "id";
     if (!$document->check()) { // Javascript SHOULD catch all this!
        echo "<h1><center>" . _DML_ENTRY_ERRORS . "</center><h1>";
        echo "<script> alert('".$document->getError() ."'); window.history.go(-1); </script>\n";
        exit();
     }

     if($cid==0)
     {
        if($image_upload==1){
            if((trim($_FILES['dmfilename']['name'][0])!="" && $product_upload==1) || trim($_POST['dmlink'])!=""){
                if (!$document->store()) {
                    echo "<script> alert('".$document->getError() ."'); window.history.go(-1); </script>\n";
                    exit();
                }
                $pid=$database->insertid();
                $msg="The Information Product has been Added Successfully.";
                $ip=1;
            }
            else
            {
                $msg="Failed to add Info product information because Info Product not uploaded.";
                $ip=0;
            }
        }
        else
        {
           $msg="Failed to add Info product information because Image not uploaded.";
           $ip=0;
        }
     }
     else{
        if(((trim($_FILES['dmimage']['name'][0])!="" && $image_upload==1) || trim($_FILES['dmimage']['name'][0])=="") && ((trim($_FILES['dmfilename']['name'][0])!="" && $product_upload==1) || trim($_FILES['dmfilename']['name'][0])==""))
        {
                 if (!$document->store()) {
                       echo "<script> alert('".$document->getError() ."'); window.history.go(-1); </script>\n";
                       exit();
                 }
                 $document->load($cid);
                 $pid=$cid;
                 //if category change of product
                 if ($_POST['cat_id']!=$_POST['catid']){
                     @copy($path."/".$_POST['cat_id']."/".$_POST['original_dmfilename'],$path."/".$_POST['catid']."/".$_POST['original_dmfilename']);
                     @copy($downloadpath."/".$_POST['cat_id']."/".$_POST['original_dmfilename'],$downloadpath."/".$_POST['catid']."/".$_POST['original_dmfilename']);
                     @unlink($path."/".$_POST['cat_id']."/".$_POST['original_dmfilename']);
                     @unlink($downloadpath."/".$_POST['cat_id']."/".$_POST['original_dmfilename']);
                 }
                 $msg="The Information Product has been Updated Successfully";
                 $ip=1;
        }
        else
        {
           $msg="Failed to update Info product, image or info product not uploaded successfully.";
           $ip=0;
        }
     }

     if($image_upload==1){
             //remove old image
             if(trim($_POST['image'])!="") {
                  $file = $path . "/".$_POST['catid']."/".$_POST['image'];
                  @unlink($file);
             }
             $temporary_image_name = $path."/".$_POST['catid']."/".$database->getEscaped($result1->name);
             $image_name = $path."/".$_POST['catid']."/".$pid."_".$database->getEscaped($result1->name);
             @rename($temporary_image_name,$image_name);
             $database->setQuery("UPDATE #__docman SET dmimage='".$pid."_".$database->getEscaped($result1->name) ."' WHERE id='".$pid."'");
             if ($database->query())
                $msg_img="Image";
    }
    //document upload
    if($product_upload==1){
       //remove old file
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

       $temporary_file_name = $path."/".$_POST['catid']."/".$database->getEscaped($result2->name);
       $product_name = $path."/".$_POST['catid']."/".$pid."_".$version."_".$database->getEscaped($result2->name);
       @rename($temporary_file_name,$product_name);

       if(file_exists($downloadpath."/".$_POST['catid']."/".$_POST['original_dmfilename']))
               @unlink($downloadpath."/".$_POST['catid']."/".$_POST['original_dmfilename']);
       $download_product_name = $downloadpath."/".$_POST['catid']."/".$pid."_".$version."_".$database->getEscaped($result2->name);
       @copy($product_name,$download_product_name);

       $product_name=$pid."_".$version."_".$database->getEscaped($result2->name);
       $database->setQuery("UPDATE #__docman SET dmfilename='".$product_name."' WHERE id='".$pid."'");
       if ($database->query())
          $msg_file="Info Product";
    }
    if($ip==1){
        if($msg_img!="" && $msg_file!="")
             $msg.=" with an".$msg_img." and ".$msg_file;
        else if($msg_img!="" && $msg_file=="")
             $msg.=" with an".$msg_img;
        else if($msg_img=="" && $msg_file!="")
             $msg.=" with an".$msg_file;
    }

    mosRedirect("index2.php?option=com_docman&section=documents&mosmsg=".$msg);
}

function downloadDocument($bid)
{
    global $database, $_DOCMAN;
    // load document
    $doc = new mosDMDocument($database);
    $doc->load($bid);
    // download file
    //$file = new DOCMAN_File($doc->dmfilename, $_DOCMAN->getCfg('dmpath')); // blocked by camellia team
    $file = new DOCMAN_File($doc->dmfilename, $_DOCMAN->getCfg('dmpath'),$doc->catid); // added by camellia team
    $file->download();
    die; // Important!
}

function moveDocumentForm($cid)
{
    global $database;

    if (!is_array($cid) || count($cid) < 1) {
        echo "<script> alert('Select an item to move'); window.history.go(-1);</script>\n";
        exit;
    }
    // query to list items from documents
    $cids = implode(',', $cid);
    $query = "SELECT dmname FROM #__docman WHERE id IN ( " . $cids . " ) ORDER BY id, dmname";
    $database->setQuery($query);
    $items = $database->loadObjectList();
    // category select list
    $options = array(mosHTML::makeOption('1', _DML_SELECT_CAT));
    $lists['categories'] = dmHTML::categoryList("", "", $options);

    HTML_DMDocuments::moveDocumentForm($cid, $lists, $items);
}

function moveDocumentProcess($cid)
{
    global $database, $my;
    // get the id of the category to move the document to
    $categoryMove = mosGetParam($_POST, 'catid', '');
    // preform move
    $doc = new mosDMDocument($database);
    $doc->move($cid, $categoryMove);
    // output status message
    $cids = implode(',', $cid);
    $total = count($cid);

    $cat = new mosDMCategory ($database);
    $cat->load($categoryMove);

    $msg = $total . " Documents moved to " . $cat->name;
    mosRedirect('index2.php?option=com_docman&section=documents&mosmsg=' . $msg);
}
?>
