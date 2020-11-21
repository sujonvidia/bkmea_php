<?php
/*
* DOCMan 1.3.0 default template
* @version $Id: english.php,v 1.4 2006/04/26 06:57:17 nnabi Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
* -------------------------------------------
* Default english language file
* Creator: The DOCMan development team
* Email: admin@mambodocman.com
* Revision: 1.0
* Date: Mar 2005
*/
// ensure this file is being included by a parent file */
defined("_VALID_MOS") or die("Direct Access to this location is not allowed.");

DEFINE ('_DML_TPL_DATEFORMAT_LONG','%d.%m.%Y %H:%M');
DEFINE ('_DML_TPL_DATEFORMAT_SHORT','%d.%m.%Y');

// General
DEFINE("_DML_TPL_FILES"                 , "Files");
DEFINE("_DML_TPL_CATS"                         , "Categories");
DEFINE("_DML_TPL_DOCS"                         , "Info Products");
//DEFINE("_DML_TPL_CAT_VIEW"                 , "Downloads Home");
DEFINE("_DML_TPL_CAT_VIEW"                 , "Category List");
DEFINE("_DML_TPL_MUST_LOGIN"         , "You must login to submit new documents");
DEFINE("_DML_TPL_SUBMIT"                 , "Submit a new document");
//DEFINE("_DML_TPL_SEARCH_DOC"         , "Search document");
DEFINE("_DML_TPL_SEARCH_DOC"         , "Search Info Product");
DEFINE("_DML_TPL_LICENSE_DOC"         , "Document license");

// Titles
DEFINE("_DML_TPL_TITLE_BROWSE"  , "Downloads");
DEFINE("_DML_TPL_TITLE_EDIT"         , "Edit the document");
DEFINE("_DML_TPL_TITLE_SEARCH"  , "Search a document");
DEFINE("_DML_TPL_TITLE_DETAILS" , "Document details");
DEFINE("_DML_TPL_TITLE_MOVE"    , "Move document");
DEFINE("_DML_TPL_TITLE_UPDATE"  , "Update document");
DEFINE("_DML_TPL_TITLE_UPLOAD"  , "Submit a document");

// Documents
DEFINE("_DML_TPL_HITS"                         , "Hits");
DEFINE("_DML_TPL_DATEADDED"         , "Date added");
DEFINE("_DML_TPL_HOMEPAGE"                 , "Homepage");

//Document search
DEFINE ("_DML_TPL_ORDER_BY"         , "Order by");
DEFINE ("_DML_TPL_ORDER_NAME"         , "name");
DEFINE ("_DML_TPL_ORDER_DATE"         , "date");
DEFINE ("_DML_TPL_ORDER_HITS"         , "hits");
DEFINE ("_DML_TPL_ORDER_ASCENT" , "ascendent");
DEFINE ("_DML_TPL_ORDER_DESCENT", "descendent");

//Document edit

//Document move
DEFINE("_DML_TPL_MOVE_DOC"                 , "Move document to other category");

//Document update
DEFINE("_DML_TPL_UPDATE_DOC"            , "Update the document");
DEFINE("_DML_TPL_UPDATE_OVERWRITE" , "This will ALWAYS overwrite the file if the name is the same.");

//Document upload
DEFINE("_DML_TPL_UPLOAD_STEP"            , "Step");
DEFINE("_DML_TPL_UPLOAD_OF"            , "of");
DEFINE("_DML_TPL_UPLOAD_NEXT"            , "Next");
DEFINE("_DML_TPL_UPLOAD_DOC"            , "Upload Wizard");
DEFINE("_DML_TPL_TRANSFER"                    , "Tansfer a file from a web server");
DEFINE("_DML_TPL_LINK"                               , "Link a file from another server");
DEFINE("_DML_TPL_UPLOAD"                    , "Upload a file from your computer");

//Document tasks
DEFINE("_DML_TPL_DOC_DOWNLOAD"         , "Download");
DEFINE("_DML_TPL_DOC_VIEW"                 , "View");
DEFINE("_DML_TPL_DOC_DETAILS"         , "Details");
DEFINE("_DML_TPL_DOC_EDIT"                 , "Edit");
DEFINE("_DML_TPL_DOC_MOVE"                 , "Move");
DEFINE("_DML_TPL_DOC_DELETE"         , "Delete");
DEFINE("_DML_TPL_DOC_UPDATE"         , "Update");
DEFINE("_DML_TPL_DOC_CHECKOUT"         , "Checkout");
DEFINE("_DML_TPL_DOC_CHECKIN"         , "Checkin");
DEFINE("_DML_TPL_DOC_UNPUBLISH"        , "Unpublish");
DEFINE("_DML_TPL_DOC_PUBLISH"         , "Publish");
DEFINE("_DML_TPL_DOC_RESET"         , "Reset");
DEFINE("_DML_TPL_DOC_APPROVE"         , "Approve");

DEFINE("_DML_TPL_BACK"                    , "Back");

//Document details
DEFINE("_DML_TPL_DETAILSFOR"         , "Details for");
DEFINE("_DML_TPL_NAME"                         , "Name");
DEFINE("_DML_TPL_DESC"                         , "Description");
DEFINE("_DML_TPL_FNAME"                        , "Filename");
DEFINE("_DML_TPL_FSIZE"                        , "Filesize");
DEFINE("_DML_TPL_FTYPE"                        , "Filetype");
DEFINE("_DML_TPL_SUBBY"                        , "Creator");
DEFINE("_DML_TPL_SUBDT"                        , "Created On:");
DEFINE("_DML_TPL_OWNER"                        , "Viewers");
DEFINE("_DML_TPL_MAINT"                        , "Maintained by");
DEFINE("_DML_TPL_DOWNLOADS"         , "Downloads");
DEFINE("_DML_TPL_LASTUP"                , "Last updated on");
DEFINE("_DML_TPL_LASTBY"                , "Last updated by");
DEFINE("_DML_TPL_HOME"                         , "Homepage" );
DEFINE("_DML_TPL_MIME"                         , "Mime Type");
DEFINE("_DML_TPL_CHECKED_OUT"        , "Checked out");
DEFINE("_DML_TPL_CHECKED_BY"        , "Checked out by");
DEFINE("_DML_TPL_MD5_CHECKSUM"        , "MD5 Checksum");
DEFINE("_DML_TPL_CRC_CHECKSUM"        , "CRC Checksum");

//add by camellia team
DEFINE("_DML_TPL_PURCHASE"                         , "Purchase");
DEFINE("_DML_TPL_TITLE_PURCHASE_STEP1"                         , "Purchase Step 1");
DEFINE("_DML_TPL_TITLE_PURCHASE_STEP2"                         , "Purchase Step 2");
DEFINE("_DML_TPL_TITLE_PURCHASE_STEP3"                         , "Purchase Step 3");
DEFINE("_DML_TPL_TITLE_PURCHASE_STEP4"                         , "Purchase Step 4");
DEFINE("_DML_TPL_TITLE_PURCHASE_STEP5"                         , "Purchase Step 5");
DEFINE("_DML_TPL_PRICE_FOR_MEMBER"                         , "Price for Member");
DEFINE("_DML_TPL_PRICE_FOR_LOCAL_CLIENT"                         , "Price for Non Memnber");
DEFINE("_DML_TPL_PRICE_FOR_FOREIGN_CLIENT"                         , "Price for Foreign Customer");
DEFINE("_DML_TPL_NO_DOWNLOADS"                         , "Number of Download");
DEFINE("_DML_TPL_ABSTRACT_DESCRIPTION"                         , "Abstract");

?>