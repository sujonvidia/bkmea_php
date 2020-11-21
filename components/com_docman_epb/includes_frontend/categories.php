<?php
/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: categories.php,v 1.7 2006/05/25 10:26:38 nnabi Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

include_once dirname(__FILE__) . '/categories.html.php';
require_once($_DOCMAN->getPath('classes', 'model'));
require_once($_DOCMAN->getPath('classes', 'theme'));

function fetchCategory($id)
{
    global $_DMUSER;

    $cat = new DOCMAN_Category($id);

    // if the user is not authorized to access this category, redirect
    if(!$_DMUSER->canAccessCategory($cat->getDBObject())) {
            _returnTo('' , _DML_NOT_AUTHORIZED);
    }

    return HTML_DMCategories::displayCategory($cat->getLinkObject(),
        $cat->getPathObject(),
        $cat->getDataObject());
}

function fetchCategoryList($id,$upload_year=0)
{
    global $_DOCMAN, $_DMUSER;

    $children = DOCMAN_Cats::getChildsByUserAccess($id,"ordering ASC",'',$upload_year);
    if (count($children) == 0) {
        return;
    }

    $items = array();
    foreach($children as $child)
    {

       $cat = new DOCMAN_Category($child->id);

             $item = new StdClass();
               $item->links = &$cat->getLinkObject();
               $item->paths = &$cat->getPathObject();
        $item->data = &$cat->getDataObject();

        $item->data->dmfilename = $child->dmfilename;     // added y camellia team for info product's file name
        $item->data->dmlink = $child->dmlink;             // added by camellia team for link file
        $item->data->product_type = $child->product_type; // added by camellia team for types of product
        $item->data->dmdate_published = $child->dmdate_published; // added by camellia team for published date of info products
        $item->data->upload_year = $upload_year; // added by camellia team for published date of info products

       // if (intval($upload_year)==0){

       if (intval($upload_year)>0){
           $upload_year=explode("-",$child->dmdate_published);
           $upload_year=$upload_year[0];
       }
           $rows = DOCMAN_Docs::getDocsByUserAccess($child->catid, '', '', '',  0,$upload_year);
           $no_products=0;
           //foreach($rows as $row) {
           for ($i=0;$i<count($rows);$i++) {
               $row=& $rows[$i];
               $product_file=$_DOCMAN->getCfg('dmdownloadpath')."/".$row->catid."/".$row->dmfilename; // added by camellia team
               if ( (trim($row->dmfilename)!="" && file_exists($product_file) ) || ( intval($row->dmlink)==1 ) ){   // added by camellia team
                   $no_products++;
               } // added by camellia team
           }
           $item->data->no_products = $no_products;   // added by camellia team for No. of products associate with a category
       //}
       //else
          // $item->data->no_products = $child->no_products;   // added by camellia team for No. of products associate with a category

               $items[] = $item;

    }
    // display the entries
    return HTML_DMCategories::displayCategoryList($items);
}

?>
