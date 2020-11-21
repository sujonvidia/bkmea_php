<?php
/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: categories.php,v 1.19 2006/12/21 11:57:33 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');
$id=mosGetParam($_REQUEST,'id');

require_once($_DOCMAN->getPath('classes', 'file'));

include_once dirname(__FILE__) . '/categories.html.php';

switch ($task) {
    case "removeimage" :
        editCategory($option, $_GET['id']);
        break;
    case "edit" :
        editCategory($option, $cid[0]);
        break;
    case "new":
        editCategory($option, 0);
        break;
    case "cancel":
        cancelCategory();
        break;
    case "save":
        saveCategory($id);
        break;
    case "remove":
        removeCategories($option, $cid);
        break;
    case "publish":
        publishCategories("com_docman", $id, $cid, 1);
        break;
    case "unpublish":
        publishCategories("com_docman", $id, $cid, 0);
        break;
    case "orderup":
        orderCategory($cid[0], -1);
        break;
    case "orderdown":
        orderCategory($cid[0], 1);
        break;
    case "accesspublic":
        accessCategory($cid[0], 0);
        break;
    case "accessregistered":
        accessCategory($cid[0], 1);
        break;
    case "accessspecial":
        accessCategory($cid[0], 2);
        break;
    case "show":
    default :
        showCategories();
}

function showCategories()
{
    global $database, $my, $option, $menutype, $mainframe, $mosConfig_list_limit;

    $section = "com_docman";

    $sectionid = $mainframe->getUserStateFromRequest("sectionid{$section}{$section}", 'sectionid', 0);
    $limit = $mainframe->getUserStateFromRequest("viewlistlimit", 'limit', $mosConfig_list_limit);
    $limitstart = $mainframe->getUserStateFromRequest("view{$section}limitstart", 'limitstart', 0);
    $levellimit = $mainframe->getUserStateFromRequest("view{$option}limit$menutype", 'levellimit', 10);

     $query = "SELECT  c.*, c.checked_out as checked_out_contact_category, "
     . "\n c.parent_id as parent, g.name AS groupname, u.name AS editor"
     . "\n FROM #__categories AS c"
     . "\n LEFT JOIN #__users AS u ON u.id = c.checked_out"
     . "\n LEFT JOIN #__groups AS g ON g.id = c.access"
     . "\n LEFT JOIN #__docman AS d ON d.catid = c.id" //new added
     . "\n WHERE c.section='$section'"
     . "\n and c.is_delete=0"
     . "\n ORDER BY d.dmdate_published DESC,d.id DESC" ;  //dmdate_published added and ordering, parent_id remove

    $database->setQuery($query);

    $rows = $database->loadObjectList();

    if ($database->getErrorNum()) {
        echo $database->stderr();
        return false;
    }
    // establish the hierarchy of the categories
    $children = array();
    // first pass - collect children
    foreach ($rows as $v) {
        $pt = $v->parent;
        $list = @$children[$pt] ? $children[$pt] : array();
        array_push($list, $v);
        $children[$pt] = $list;
    }
    // second pass - get an indent list of the items
    $list = mosTreeRecurse(0, '', array(), $children, max(0, $levellimit-1));

    $total = count($list);

    require_once($GLOBALS['mosConfig_absolute_path'] . '/administrator/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    $levellist = mosHTML::integerSelectList(1, 20, 1, 'levellimit', 'size="1" onchange="document.adminForm.submit();"', $levellimit);
    // slice out elements based on limits
    $list = array_slice($list, $pageNav->limitstart, $pageNav->limit);

    $count = count($list);
    // number of Active Items
    for ($i = 0; $i < $count; $i++) {
        $query = "SELECT COUNT( d.id )"
         . "\n FROM #__docman AS d"
         . "\n WHERE d.is_delete=0  and d.catid = " . $list[$i]->id;
        // . "\n AND d.state <> '-2'";
        $database->setQuery($query);
        $active = $database->loadResult();
        $list[$i]->documents = $active;
    }
    // get list of sections for dropdown filter
    $javascript = 'onchange="document.adminForm.submit();"';
    //$lists['sectionid'] = mosAdminMenus::SelectSection('sectionid', $sectionid, $javascript);

    HTML_DMCategories::show($list, $my->id, $pageNav, $lists, 'other');
}

function editCategory($section = '', $uid = 0)
{
    global $database, $my, $_DOCMAN;
    global $mosConfig_absolute_path, $mosConfig_live_site;

    $type = mosGetParam($_REQUEST, 'type', '');
    $redirect = mosGetParam($_POST, 'section', '');
    //remove category image
    if($_GET['task']=="removeimage"){
         $file = $_DOCMAN->getCfg('dmpath') . "/".$uid."/".$_GET['image'];
         if(file_exists($file) && @unlink($file)){
            $database->setQuery("UPDATE #__categories SET image='' WHERE id='".$uid."'");
            if (!$database->query()) {
                 echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1);</script>\n";
                 exit();
            }
         }
    }

    $row = new mosDMCategory($database);
    // load the row from the db table
    $row->load($uid);
    // fail if checked out not by 'me'
    /*if ($row->checked_out && $row->checked_out <> $my->id) {
        mosRedirect('index2.php?option=com_docman&task=categories', 'The category ' . $row->title . ' is currently being edited by another administrator');
    }

    if ($uid) {
        // existing record
        $row->checkout($my->id);
        // code for Link Menu
    } else {
        // new record
        $row->section = $section;
        $row->published = 1;
    }*/
    // make order list
    $order = array();
    $database->setQuery("SELECT COUNT(*) FROM #__categories WHERE section='$row->section'");
    $max = intval($database->loadResult()) + 1;

    for ($i = 1; $i < $max; $i++) {
        $order[] = mosHTML::makeOption($i);
    }
    // build the html select list for ordering
    $query = "SELECT ordering AS value, name AS text"
     . "\n FROM #__categories"
     . "\n WHERE section = '$row->section'"
     . "\n ORDER BY ordering" ;
    $lists['ordering'] = mosAdminMenus::SpecificOrdering($row, $uid, $query);
    // build the select list for the image positions
    $active = ($row->image_position ? $row->image_position : 'left');
    //$lists['image_position'] = mosAdminMenus::Positions('image_position', $active, null, 0, 0);
    // Imagelist
    //$lists['image'] = dmHTML::imageList('image', $row->image);
    // build the html select list for the group access
    //$lists['access'] = mosAdminMenus::Access($row);
    // build the html radio buttons for published
    $lists['published'] = mosHTML::yesnoRadioList('published', 'class="inputbox"', $row->published);
    // build the html select list for paraent item
    $options = array();
    $options[] = mosHTML::makeOption('0', _DML_TOP);
    $lists['parent'] = dmHTML::categoryParentList($row->id, "", $options);

    HTML_DMCategories::edit($row, $section, $lists, $redirect);
}

function saveCategory($id=0)
{
    global $database, $_DOCMAN;
    $pt=$id;
    $row = new mosDMCategory($database);

    if (!$row->bind($_POST)) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    if (!$row->check()) {
         if($id==0)
            $link='index2.php?option=com_docman&section=categories&task=new&mosmsg='.$row->getError();
         else
            $link='index2.php?option=com_docman&section=categories&mosmsg='.$row->getError();

         mosRedirect($link);
         //echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
         exit();
    }

    if (!$row->store()) {
        echo "<script> alert('" . $row->getError() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    //create category folder
    if(intval($pt)==0){
            $msg="Product Category Information has been Added Successfully";
            $category_id=$database->insertid();
            $id=$category_id;
    }else{
          $msg="Product Category Information has been Updated Successfully";
    }

    $row->checkin();
    $row->updateOrder("section='com_docman' AND parent_id='$row->parent_id'");

    $path = $_DOCMAN->getCfg('dmpath');
    $downloadpath = $_DOCMAN->getCfg('dmdownloadpath');

    //create category folder
    if(!file_exists($path."/".$id)){
            chmod($path,0777);
            mkdir($path."/".$id."/",0777);
    }

    //create category folder (download)
    if(!file_exists($downloadpath."/".$id)){
            chmod($downloadpath,0777);
            mkdir($downloadpath."/".$id."/",0777);
    }

    if(trim($_FILES['upload']['name'][0])!=""){
       //remove old image
       if(trim($_POST['image'])!="") {
            $file = $_DOCMAN->getCfg('dmpath') . "/".$id."/".$_POST['image'];
            @unlink($file);
       }
       //image upload
       $upload = new DOCMAN_FileUpload();
       $file_upload = mosGetParam($_FILES, 'upload');
       $result = &$upload->uploadHTTP($file_upload, $path."/".$id, _DM_VALIDATE_ADMIN);

       if (!$result) {
            mosRedirect("index2.php?option=com_docman&section=categories", _DML_ERROR_UPLOADING . " - " . $upload->_err);
       }
       else {
            //$database->setQuery("UPDATE #__categories SET image='". $database->getEscaped($result->name) ."' WHERE id='".$id."'");
            $temporary_image_name = $path."/".$id."/".$database->getEscaped($result->name);
             $image_name = $path."/".$id."/"."cat_image_".$id."_".$database->getEscaped($result->name);
             @rename($temporary_image_name,$image_name);

             $database->setQuery("UPDATE #__categories SET image='"."cat_image_".$id."_". $database->getEscaped($result->name) ."' WHERE id='".$id."'");


            if (!$database->query()) {
                  echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1);</script>\n";
                  exit();
            }
            if(intval($pt)==0)
               $msg="Product Category Information has been Added Successfully with the Image";
            else
               $msg="Product Category Information has been Updated Successfully with the Image";
       }
   }


    mosRedirect('index2.php?option=com_docman&section=categories&mosmsg='.$msg);
}

/**
* Deletes one or more categories from the categories table
*
* @param string $ The name of the category section
* @param array $ An array of unique category id numbers
*/
function removeCategories($section, $cid)
{
    global $database;

    if (count($cid) < 1) {
        echo "<script> alert('Select a category to delete'); window.history.go(-1);</script>\n";
        exit;
    }

    $cids = implode(',', $cid);
    // Check to see if the category holds child documents and/or subcategories
    $query = "SELECT c.id, c.name, c.parent_id, COUNT(s.catid) AS numcat, COUNT(u.id) as numkids"
     . "\n FROM #__categories AS c"
     . "\n LEFT JOIN #__docman     AS s ON s.catid=c.id"
     . "\n LEFT JOIN #__categories AS u ON u.parent_id =c.id"
     . "\n WHERE c.id IN ($cids) and s.is_delete='0' "
     . "\n GROUP BY c.id" ;

    /*$query = "SELECT count(catid) as catid FROM #__docman "
     . "\n WHERE catid IN ($cids) and is_delete=0 "
     . "\n GROUP BY catid"
     ;
    */
    $database->setQuery($query);

    if (!($rows = $database->loadObjectList())) {
        echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
    }

    $err = array();
    $cid1 = array();

    foreach ($rows as $row) {
        if ($row->numcat == 0 && $row->numkids == 0) {
            $cid1[] = $row->id;
        } else {
            $err[] = $row->name;
        }
    }

    if (count($cid) && count($err)<1) {
        $cids = implode(',', $cid);
        //$database->setQuery("DELETE FROM #__categories WHERE id IN ($cids)");
        $update_query="update #__categories SET is_delete='1' WHERE id IN ($cids)";
        $database->setQuery($update_query);
        if (!$database->query()) {
            echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        }
    }

    if (count($err)) {
        if (count($err) > 1) {
            $cids = implode(', ', $err);
            $msg = "Categories: \"$cids\"";
        } else {
            $msg = "Category \"" . $err[0]."\"" ;
        }
        $msg .= ' cannot be deleted as it contain info product(s)';
        mosRedirect('index2.php?option=com_docman&section=categories&mosmsg=' . $msg);
    }

    $msg = (count($err) > 1 ? _DML_CATS :"The ". _DML_CAT ." has been ") . _DML_DELETED." Successfully";
    mosRedirect('index2.php?option=com_docman&section=categories&mosmsg=' . $msg);
}

/**
* Publishes or Unpublishes one or more categories
*
* @param string $ The name of the category section
* @param integer $ A unique category id (passed from an edit form)
* @param array $ An array of unique category id numbers
* @param integer $ 0 if unpublishing, 1 if publishing
* @param string $ The name of the current user
*/

function publishCategories($section, $categoryid = null, $cid = null, $publish = 1)
{
    global $database, $my;

    if (!is_array($cid)) {
        $cid = array();
    }
    if ($categoryid) {
        $cid[] = $categoryid;
    }

    if (count($cid) < 1) {
        $action = $publish ? _PUBLISH : _DML_UNPUBLISH;
        echo "<script> alert('" . _DML_SELECTCATTO . " $action'); window.history.go(-1);</script>\n";
        exit;
    }

    $cids = implode(',', $cid);

    $query = "UPDATE #__categories SET published='$publish'"
     . "\nWHERE id IN ($cids) AND (checked_out=0 OR (checked_out='$my->id'))" ;
    $database->setQuery($query);
    if (!$database->query()) {
        echo "<script> alert('" . $database->getErrorMsg() . "'); window.history.go(-1); </script>\n";
        exit();
    }

    if (count($cid) == 1) {
        $row = new mosCategory($database);
        $row->checkin($cid[0]);
    }
    mosRedirect('index2.php?option=com_docman&section=categories&mosmsg=Info Product Category has been'.($publish==1?'Published':'Unpublished').' Successfully');
}

/**
* Cancels an edit operation
*
* @param string $ The name of the category section
* @param integer $ A unique category id
*/
function cancelCategory()
{
    global $database;

    $row = new mosDMCategory($database);
    $row->bind($_POST);
    $row->checkin();
    mosRedirect('index2.php?option=com_docman&section=categories');
}

/**
* Moves the order of a record
*
* @param integer $ The increment to reorder by
*/
function orderCategory($uid, $inc)
{
    global $database;

    $row = new mosDMCategory($database);
    $row->load($uid);
    $row->move($inc, "section='$row->section'");
    mosRedirect('index2.php?option=com_docman&section=categories');
}

/**
* changes the access level of a record
*
* @param integer $ The increment to reorder by
*/
function accessCategory($uid, $access)
{
    global $database;

    $row = new mosDMCategory($database);
    $row->load($uid);
    $row->access = $access;

    if (!$row->check()) {
        return $row->getError();
    }
    if (!$row->store()) {
        return $row->getError();
    }

    mosRedirect('index2.php?option=com_docman&section=categories');
}

?>
