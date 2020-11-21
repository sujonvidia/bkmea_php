<?php

/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: docman.php,v 1.40 2006/06/21 04:40:14 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');
session_start();
require_once($mainframe->getPath('front_html'));
require_once($mainframe->getPath('class'));

// mainframe is an API workhorse, lots of 'core' interaction routines
$_DOCMAN = new dmMainFrame(_DM_TYPE_SITE);
$_DOCMAN->loadLanguage('frontend');

$_DMUSER = $_DOCMAN->getUser();

require_once($_DOCMAN->getPath('classes', 'html'));
require_once($_DOCMAN->getPath('classes', 'utils'));
require_once($_DOCMAN->getPath('classes', 'theme'));

$document                 = (isset($document)) ? $document : null;
$document_name         = (isset($document_name)) ? $document_name : null;
$document_type         = (isset($document_type)) ? $document_type : null;

$task                         = mosGetParam($_REQUEST, "task", "");
$gid                         = mosGetParam($_REQUEST, "gid", 0);
$script                 = mosGetParam($_REQUEST, "script", 0);

$ordering                 = mosGetParam($_REQUEST, "order", 'date');
$direction                 = mosGetParam($_REQUEST, "dir"        , $_DOCMAN->getCfg('default_order2'));

$revision                 = mosGetParam($_REQUEST, "revision", 0);
$archive                 = mosGetParam($_REQUEST, "archive", 0);
$Itemid                 = mosGetParam($_REQUEST, "Itemid" , 0);

$limitstart         = mosGetParam($_REQUEST, "limitstart", 0);
$limit                         = mosGetParam($_REQUEST, "limit", $_DOCMAN->getCfg('perpage'));
$total                         = DOCMAN_Cats::countDocsInCatByUser($gid, $_DMUSER);

//Add by Camellia team
$step        = mosGetParam($_REQUEST, "step", "");
$pid        = mosGetParam($_REQUEST, "pid", "");
$customer        = mosGetParam($_REQUEST, "customer", "");
$directorytype        = mosGetParam($_REQUEST, "directorytype", "");
$cat_id        = mosGetParam($_REQUEST, "cat_id");
$member_price=     mosGetParam($_REQUEST, "member_price");
$nonmember_price=    mosGetParam($_REQUEST, "nonmember_price");
$search_criteria=    mosGetParam($_REQUEST, "search_criteria");
$upload_year=    mosGetParam($_REQUEST, "upload_year");
if ($total <= $limit) {
    $limitstart = 0;
}

// check if the user actually has access to see this document
switch ($_DMUSER->canAccess()) {
    case 0:
              showMsgBox(_DML_NOLOG);
        return;
    case -1:
        showMsgBox(_DML_ISDOWN);
        return;
}
// component tasks
switch ($task)
{
    //standard operations
    case "doc_details":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        showDocumentDetails($gid,$cat_id);
        break;

    case "doc_purchase":
    {
        require_once($_DOCMAN->getPath('includes_f', 'documents'));

        switch($step){
                case "1":
                      doc_purchase_step1($pid);
                      break;
                case "2":
                      {
                          switch($customer){
                               case "new":
                                     doc_purchase_step2_newCustomer($pid);
                                     break;

                               case "ext":
                                     doc_purchase_step2_existingCustomer($pid);
                                     break;

                               case "mem":
                                     doc_purchase_step2_member($pid);
                                     break;

                               case "off":
                                     doc_purchase_step3($pid,$customer);
                                     break;
                          }
                      }
                      break;

                case "3":
                      doc_purchase_step3($pid,$customer);
                      break;

                case "4":
                      {
                         if(trim($customer)=="off")
                            doc_purchase_step5($pid,$customer);
                         else
                            doc_purchase_step4($pid,$customer);
                      }
                      break;

                case "5":
                      doc_purchase_step5($pid,$customer);
                      break;

                case "sales_tracker":
                      doc_sales_tracker();
                      break;
        }
        break;
    }

    case "doc_download":
        require_once($_DOCMAN->getPath('includes_f', 'download'));
        showDocumentDownload($gid);
        break;

    case "doc_view":
        require_once($_DOCMAN->getPath('includes_f', 'download'));
        showDocumentView($gid);
        break;

    //maintain operations
    case "doc_edit":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        showDocumentEdit($gid, $script);
        break;

    case "doc_save":
    case "save":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        saveDocument($gid);
        break;

    case "doc_cancel":
    case "cancel":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        cancelDocument($gid);
        break;

    case "doc_move":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        showDocumentMove($gid);
        break;

    case "doc_move_process":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        moveDocumentProcess($gid);
        break;

    case "doc_checkin":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        checkinDocument($gid);
        break;

    case "doc_checkout":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        checkoutDocument($gid);
        break;

    case "doc_reset":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        resetDocument($gid);
        break;

    case "doc_delete":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        deleteDocument($gid);
        break;

    case "doc_update":
            require_once($_DOCMAN->getPath('includes_f', 'upload'));
        showDocumentUpload($gid, $script, 1);
        break;

    case "doc_update_process":
                    require_once($_DOCMAN->getPath('includes_f', 'documents'));
        updateDocumentProcess($gid);
        break;

         //special operations
    case "doc_approve":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        approveDocument(array($gid));
        break;

    case "doc_unpublish":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        publishDocument(array($gid), 0);
        break;

    case "doc_publish":
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        publishDocument(array($gid));
        break;

    // upload operations
    case "upload":
            require_once($_DOCMAN->getPath('includes_f', 'upload'));
        showDocumentUpload($gid, $script, 0);
        break;

    // license operations
    case "license_result":
        require_once($_DOCMAN->getPath('includes_f', 'download'));
        licenseDocumentProcess($gid);
        break;

    // search operations
    case "search_form":
        require_once($_DOCMAN->getPath('includes_f', 'search'));
        showSearchForm($gid, $Itemid);
        break;

    case "search_result":
        require_once($_DOCMAN->getPath('includes_f', 'search'));
        showSearchResult($gid, $Itemid);
        break;

        // category operations
    case "cat_view" :
    default:
        require_once($_DOCMAN->getPath('includes_f', 'categories'));
        require_once($_DOCMAN->getPath('includes_f', 'documents'));
        showDocman($gid);
}

function showMsgBox($msg)
{
    HTML_docman::pageMsgBox($msg);
}

function showDocman($gid)
{
    global $upload_year;
    $html = new StdClass();
    $html->menu = fetchMenu($gid);
    $html->pathway = '';

    $pathway = fetchPathway($gid);
    $html->pathway = fetchPathway($gid);

    $html->category = '';

    if ($gid > 0) {
        $cat = fetchCategory($gid);
    }

    $html->cat_list = fetchCategoryList($gid,$upload_year);
    $html->doc_list = fetchDocumentList($gid,$upload_year);
    $html->pagenav   = fetchPageNav($gid);
    $html->pagetitle = fetchPageTitle($gid);

    HTML_docman::pageDocman($html);
}

function showDocumentDetails($gid,$cat_id)
{
    $html = new StdClass();
    $html->menu = fetchMenu($gid);
    $html->docdetails = fetchDocument($gid,$cat_id);

    HTML_docman::pageDocument($html);
}
//purchase step 1
function doc_purchase_step1($pid)
{
    global $my,$directorytype,$member_price,$nonmember_price;
    global $search_criteria,$mosConfig_owner;
    //Check Login;
    //$my->id==0 user is not logged In
    if(intval($my->id)==0 ){
            if(trim($directorytype)!="")
               $link="index.php?opt=product&directorytype=".$directorytype."&search_criteria=".$search_criteria."&member_price=".$member_price."&nonmember_price=".$nonmember_price;
            else
               $link="index.php?pid=".$pid."&opt=product";

            mosRedirect( $link, 'You must login to purchase. If you are not an authorized person, please contact the '.$mosConfig_owner.' office.' );
    }

    HTML_docman::purchase_step1($pid,$directorytype,$member_price,$nonmember_price);
}

//purchase step 2  for new customer
function doc_purchase_step2_newCustomer($pid)
{
    global $my,$directorytype,$member_price,$nonmember_price;

    $lists = array();
    $lists['country']    = mosAdminMenus::CountryList( "country", 18 );
    $lists['title']             = mosAdminMenus::MemberTitle( 'title','');
    HTML_docman::purchase_step2_newCustomer($pid,$lists,$directorytype,$member_price,$nonmember_price);
}

//purchase step 2 for existing customer
function doc_purchase_step2_existingCustomer($pid)
{
    global $my,$directorytype,$member_price,$nonmember_price;

    $lists = array();
    //$lists['country']    = mosAdminMenus::CountryList( "country", 18 );
    HTML_docman::purchase_step2_existingCustomer($pid,$lists,$directorytype,$member_price,$nonmember_price);
}

//purchase step 2 for existing customer
function doc_purchase_step2_member($pid)
{
    global $my,$directorytype,$member_price,$nonmember_price;

    $lists = array();

    HTML_docman::purchase_step2_member($pid,$lists,$directorytype,$member_price,$nonmember_price);
}

//purchase step 3:discount
function doc_purchase_step3($pid,$customer)
{
    global $database,$mosConfig_owner;
    global $my,$directorytype,$member_price,$nonmember_price;
    global $search_criteria;

    if (strtolower(trim($customer))=="new"){
       $_SESSION['title']=$_POST['title'];
       $_SESSION['name']=$_POST['name'];
       $_SESSION['last_name']=$_POST['last_name'];
       $_SESSION['firm_name']=$_POST['firm_name'];
       $_SESSION['address']=$_POST['address'];
       $_SESSION['country']=$_POST['country'];
       $_SESSION['phone']=$_POST['phone'];
       $_SESSION['mobile']=$_POST['mobile'];
       $_SESSION['email']=$_POST['email'];
    }
    elseif (strtolower(trim($customer))=="ext"){
       // Check existing customer
       $customer_id_sql_query="select id from #__customer where id ='".$_POST['customer_id']."'";
       $database->setQuery($customer_id_sql_query);
       $customer_total_row=$database->loadResult();

       if(count($customer_total_row)==0 ) {
         echo "<script> alert('Customer Id does not Exist'); window.history.go(-1); </script>\n";
         exit;
       }
       $_SESSION['customer_id']=$_POST['customer_id'];
    }
    elseif (strtolower(trim($customer))=="mem")
    {

       $sql="select m.* from #__stakeholder as m"
                ."\n where m.is_delete='0' and m.id='".$_REQUEST['member_reg_no']."'"
                ;
       $database->setQuery( $sql);
       $result=$database->loadObjectList();
       if(count($result)==0 ) {
         echo "<script> alert('Member does not Exist'); window.history.go(-1); </script>\n";
         exit;
       }
       $_SESSION['membership_id']=$result[0]->id;
       $_SESSION['title'] = '';
       $_SESSION['name']=$result[0]->contact_person;
       $_SESSION['last_name'] = '';
       $_SESSION['firm_name']=$result[0]->name;
       $_SESSION['address']=$result[0]->address;
       $_SESSION['country'] = '';
       $_SESSION['phone']=$result[0]->phone;
       $_SESSION['mobile']=$result[0]->mobile;
       $_SESSION['email']=$result[0]->email;
    }
    $sql_query="SELECT * from #__docman where id='".$pid."'";
    $database->setQuery( $sql_query );
    $rows=$database->loadObjectList();
    HTML_docman::purchase_step3($pid,$customer,$rows,$directorytype,$member_price,$nonmember_price);
}

//purchase step 4:invoice
function doc_purchase_step4($pid,$customer)
{
    global $my,$directorytype,$member_price,$nonmember_price;
    global $search_criteria;

    if (strtolower(trim($customer))=="new"){
       $_SESSION['title']=$_POST['title'];
       $_SESSION['name']=$_POST['name'];
       $_SESSION['last_name']=$_POST['last_name'];
       $_SESSION['firm_name']=$_POST['firm_name'];
       $_SESSION['address']=$_POST['address'];
       $_SESSION['country']=$_POST['country'];
       $_SESSION['phone']=$_POST['phone'];
       $_SESSION['mobile']=$_POST['mobile'];
       $_SESSION['email']=$_POST['email'];
    }
    elseif (strtolower(trim($customer))=="ext"){
       $_SESSION['customer_id']=$_POST['customer_id'];
    }
    elseif (strtolower(trim($customer))=="mem"){
       $_SESSION['membership_id']=$_POST['membership_id'];
       $_SESSION['title']=$_POST['title'];
       $_SESSION['name']=$_POST['name'];
       $_SESSION['last_name']=$_POST['last_name'];
       $_SESSION['firm_name']=$_POST['firm_name'];
       $_SESSION['address']=$_POST['address'];
       $_SESSION['country']=$_POST['country'];
       $_SESSION['phone']=$_POST['phone'];
       $_SESSION['mobile']=$_POST['mobile'];
       $_SESSION['email']=$_POST['email'];

       //$_SESSION['member_reg_no']=$_POST['member_reg_no'];
       //$_SESSION['firm_name']=$_POST['firm_name'];
    }
    $_SESSION['product_price']=$_POST['product_price'];
    $_SESSION['product_name']=$_POST['product_name'];
    $_SESSION['product_file_name']=$_POST['product_file_name'];
    $_SESSION['discount']=$_POST['discount'];
    $_SESSION['discount_note']=$_POST['discount_note'];

    HTML_docman::purchase_step4($pid,$customer,$directorytype,$member_price,$nonmember_price);
}

//purchase step 5:Download
function doc_purchase_step5($pid,$customer)
{
    global $database,$my,$mosconfig_no_of_days_to_download_purchase_product,$mosConfig_absolute_path,$Itemid;
    global $directorytype,$member_price,$nonmember_price;
    global $mosConfig_live_site, $mosConfig_owner;
    global $search_criteria;

    if(strtolower($mosConfig_owner)=="scci")
       $pdf_option="com_search_scci";
    else if(strtolower($mosConfig_owner)=="bkmea")
       $pdf_option="com_search_bkmea";
    else if(strtolower($mosConfig_owner)=="ccci")
       $pdf_option="com_search_ccci";
    $et=1;
    $catid=$_REQUEST['catid'];
    $invoice_no=intval($_REQUEST['invoice_no']);
    $invoice_id=$_REQUEST['invoice_no'];
    $dmcounter=intval($_REQUEST['dmcounter']);
    /*
    if (intval($pid)==0)
        $pid=intval($_REQUEST['id']);
    */
    if ($dmcounter==1){
       if ($pid>0){
           $sql_query="update #__docman set dmcounter=dmcounter+1 where id='".$pid."'";
           $database->setQuery( $sql_query );
           $database->query();
       }
       $downloadname=$_REQUEST['dmfilename'];
       $invoice_id=$_REQUEST['invoice_id'];
       $et=$_REQUEST['et'];
       $info_product_link=$mosConfig_live_site."/dmdocdownload/".$catid."/".$downloadname;
        ?>
        <script language="javascript" type="text/javascript">
            var newWin;
            if (null != newWin && !newWin.closed)
                closeNewWindow();
            var islink="<?php echo trim($directorytype); ?>";
            if(islink==""){
               var page='<?php echo $info_product_link; ?>';
               var status='width=700,height=400,scrollbars=yes,resizable=yes,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no';
            }
            else{
               var page = "<?php echo $mosConfig_live_site; ?>/index2.php?option=<?php echo $pdf_option;?>&amp;do_pdf=1&pdf_type=<?php echo trim($directorytype); ?>&search_criteria=<?php echo trim($search_criteria); ?>&invoice_id=<?php echo $invoice_id; ?>&et=<?php echo $et; ?>";
               var status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
            }

            newWin=window.open(page,'',status);
            newWin.focus();

        </script>

    <?php
    }
    else if ($dmcounter==0 && $invoice_no==0){
        // Check duplicate Money Receipt Number
         if($_POST['money_receipt_no']!=""){
              // Query for check duplicate Money Receipt Number
              $money_receipt_sql_query="select id from #__member_trail where money_receipt_no ='".$_POST['money_receipt_no']."'";
              /*$money_receipt_sql_query="select mt.* from #__member_trail as mt,#__invoice as inv"
              ."\n where mt.member_id=inv.id and mt.money_receipt_no ='".$_POST['money_receipt_no']."'"; */
              $database->setQuery($money_receipt_sql_query);
              $money_receipt_total_row=$database->loadResult();
              if(count($money_receipt_total_row)>0 ) {
                  echo "<script> alert('Money receipt number already exist!'); window.history.go(-1); </script>\n";
                  exit;
              }
         }
         $current_date = date( "Y-m-d" );
         $money_receipt_date=$current_date;
         // Insert New customer information (Non member)
         if (strtolower(trim($customer))=="new" OR strtolower(trim($customer))=="mem"){

             $query_new_customer="insert into #__customer (membership_id,customer_title,customer_first_name"
                 .",customer_last_name,organization_name,address,country,email,phone_no,mobile_no)"
                 ." values ('".$_POST['membership_id']."','".$_POST['title']."','".$_POST['name']
                 ."','".$_POST['last_name']."','".$_POST['firm_name']."','".$_POST['address']
                 ."','".$_POST['country']."','".$_POST['email']
                 ."','".$_POST['phone']."','".$_POST['mobile']."')"
                 ;

             $database->setQuery($query_new_customer);
             if(!$database->query()) {
                 //echo "<script> alert('Fail to Add New Customer Information'); window.history.go(-1); </script>\n";
                 //exit();
                 mosRedirect( 'index.php?option=com_docman&task=doc_purchase&step=2&customer=new&mosmsg='.$msg );
             }
             $money_receipt_date="";
             $money_receipt_date=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
             $insert_id=$database->insertid();
             //$reference_id=$insert_id;
        }
        // Check existing customer id
         if (strtolower(trim($customer))=="ext"){
             $money_receipt_date="";
             $money_receipt_date=mosHTML::ConvertDateForDatatbase($_POST['money_receipt_date']);
             $insert_id=$_POST['customer_id'];

        }
        if (trim($directorytype)!=""){
            $accountId=202;
            if (strtolower(trim($directorytype))=="gen")
                 $productType=2;
            else if (strtolower(trim($directorytype))=="full")
                 $productType=3;

        }
        else{
            $accountId=201;
            $productType=1;
        }
        // Insert data into invoice table
        $query_invoice="insert into #__invoice (customer_id,product_id,price,discount,money_receipt_no"
                 .",money_receipt_date,file_name,transaction_id,note,user,product_type,date)"
                 ." values ('".$insert_id."','".$pid."','".$_POST['product_price']
                 ."','".$_POST['discount']."','".$_POST['money_receipt_no']
                 ."','".$money_receipt_date
                 ."','".$_POST['product_file_name']."','".$accountId."','".$_POST['discount_note']
                 ."','".$my->username."','".$productType."','".$current_date."')"
                 ;

        $database->setQuery($query_invoice);
        if(!$database->query()) {
            echo "<script> alert('Fail to add invoice information'); window.history.go(-1); </script>\n";
            exit();
        }
        // Accounts Transaction
        /*
        if (trim($directorytype)!="")
            $accountId=202;
        else
            $accountId=201;
         */
        $reference_id=$database->insertid();
        $invoice_id=$database->insertid();
        $sql_trans="select max(transaction_no) as transaction_no from #__account_transaction";
        $database->setQuery($sql_trans);
        $transaction_no=($database->loadResult()+1);
        //$info_product_sales_fee=intval($_POST['product_price'])-intval($_POST['discount']);
        $info_product_sales_fee=intval($_POST['payable_amount']);
        $account_query1="insert into #__account_transaction values('','$transaction_no','$accountId','$info_product_sales_fee','0','$reference_id','$money_receipt_date','$current_date')";
        $account_query1=$database->replaceTablePrefix($account_query1);
        $account_query2="insert into #__account_transaction values('','$transaction_no','1','$info_product_sales_fee','1','$reference_id','$money_receipt_date','$current_date')";
        $account_query2=$database->replaceTablePrefix($account_query2);
        if( !(mysql_query($account_query1) && mysql_query($account_query2)) ){
             echo "<script> alert('Fail to add accounts information'); window.history.go(-1); </script>\n";
             exit();
        }
        // account transaction end

        //insert member trail information
        if(!$database->addMemberTrail($reference_id,'7',$my->username,'','',$_POST['money_receipt_no'])){
            echo "<script> alert('Incorrect member trail information'); window.history.go(-1); </script>\n";
            exit();
        }

    }
    if ($pid && strtolower(trim($directorytype))=="" ){
        $sub=" where doc.id='".$pid;
        $query = "SELECT doc.id as did,doc.catid as catid,doc.dmname,doc.dmfilename as dmfilename FROM #__docman as doc"
        .$sub
        ."'\n and (dmdate_expire='0000-00-00' or CURDATE()<=dmdate_expire) and is_delete='0'"
        ;
        $msg='Info product is not available';
        $database->setQuery( $query );
        $rows=$database->loadObjectList();
    }
    else if ($invoice_no>0){
            // doc.catid as catid, is rempved from query
        $no_of_days_to_download_purchase_product=" and DATE_ADD(inv.date,INTERVAL $mosconfig_no_of_days_to_download_purchase_product DAY)";
        $sub=" where inv.id='".$invoice_no;
        $query_sales_tracker = "SELECT inv.*,inv.id as id, doc.id as did,doc.catid as catid,doc.dmname,doc.dmfilename as dmfilename FROM #__invoice as inv"
        ."\n left join #__docman as doc on inv.product_id=doc.id".$sub
        ."'\n".$no_of_days_to_download_purchase_product.">=CURDATE()"
        ;
        $msg='Info product with supplied number is not available';
        $database->setQuery( $query_sales_tracker );
        $rows=$database->loadObjectList();
        $et=0;
    }
    if (strtolower(trim($customer))!="off" && $dmcounter==0){
            if (strtolower(trim($directorytype))=="gen")
                 $pname="General Contact";
            else if (strtolower(trim($directorytype))=="full")
                 $pname="Full Profile";
            else
                $pname=$_REQUEST['product_name'];
       if ($invoice_no==0){
    ?>
        <script language="javascript" type="text/javascript">

               status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
               link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_docman&amp;do_pdf=1&amp;report_for=coupon&customerID=<?php echo $insert_id;?>&invoiceID=<?php echo $reference_id;?>&pName=<?php echo $pname;?>';
               void window.open(link, 'win2', status);

        </script>
    <?php
      }
    }


    //if (count($rows)<=0  && strtolower(trim($directorytype))=="" )
      // mosRedirect( 'index.php?option=com_docman&task=doc_purchase&step=sales_tracker&invoice_no='.$invoice_no.'&mosmsg='.$msg );
    if (count($rows)<=0 && $invoice_no>0)
        mosRedirect( 'index.php?option=com_docman&task=doc_purchase&step=sales_tracker&invoice_no='.$invoice_no.'&mosmsg='.$msg );
    HTML_docman::purchase_step5($rows,$pid,$directorytype,$member_price,$nonmember_price,$invoice_id,$et);
}



//purchase sales tracker
function doc_sales_tracker()
{

    HTML_docman::sales_tracker();
}

function showDocumentDownload($gid)
{
        global $database, $_DOCMAN;

        $doc = new DOCMAN_Document($gid);
        $data = &$doc->getDataObject();

         //check if we need to display a license
    if ($_DOCMAN->getCfg('display_license') &&
       ($data->dmlicense_display && $data->dmlicense_id))
    {
            //fetch the license form
            $html = new StdClass();
            $html->doclicense = fetchDocumentLicenseForm($gid);

                    //get the license text
                   $license = new mosDMLicenses($database);
                   $license->load($data->dmlicense_id);

            HTML_docman::pageDocumentLicense($html, $license->license);

        } else {
                download($doc, false);
        }
}

function showDocumentView($gid)
{
        global $database, $_DOCMAN;

        $doc = new DOCMAN_Document($gid);
        $data = &$doc->getDataObject();

         //check if we need to display a license
    if ($_DOCMAN->getCfg('display_license') &&
       ($data->dmlicense_display && $data->dmlicense_id))
    {
            //fetch the license form
            $html = new StdClass();
            $html->doclicense = fetchDocumentLicenseForm($gid);

                    //get the license text
                   $license = new mosDMLicenses($database);
                   $license->load($data->dmlicense_id);

            HTML_docman::pageDocumentLicense($html, $license->license);

        } else {
                download($doc, true);
        }
}

function showDocumentUpload($gid, $script, $update)
{
        $step   = mosGetParam($_REQUEST, "step", 1);
        $method = mosGetParam($_REQUEST, "method", null);

        if($script) {
            HTML_docman::scriptDocumentUpload($step, $method, $update);
            return;
    }

        //fetch the license form
    $html = new StdClass();
    $html->menu = fetchMenu();
    $html->docupload = fetchDocumentUploadForm($gid, $step, $method, $update);

    HTML_docman::pageDocumentUpload($html, $step, $method, $update);
}

function showDocumentEdit($gid, $script)
{
    if($script) {
            HTML_docman::scriptDocumentEdit();
            return;
    }

    $html = new StdClass();
    $html->menu = fetchMenu($gid);
    $html->docedit = fetchEditDocumentForm($gid);

    HTML_docman::pageDocumentEdit($html);
}

function showDocumentMove($gid)
{
    $html = new StdClass();
    $html->menu = fetchMenu($gid);
    $html->docmove = fetchMoveDocumentForm($gid);

    HTML_docman::pageDocumentMove($html);
}

function showSearchForm($gid, $Itemid)
{
    $html = new StdClass();
    $html->menu = fetchMenu(0);
    $html->searchform = fetchSearchForm($gid, $Itemid);
    $items = array();

    HTML_docman::pageSearch($html, $items);
}

function showSearchResult($gid, $Itemid)
{
    $html = new StdClass();
    $html->menu = fetchMenu(0);
    $html->searchform = fetchSearchForm($gid, $Itemid);
    $items = getSearchResult($gid, $Itemid);

    HTML_docman::pageSearch($html, $items);
}

function fetchMenu($gid = 0)
{
    global $_DOCMAN, $_DMUSER;

    // create links
    $links = new StdClass();
    $links->home = _taskLink(null);
    $links->search = _taskLink('search_form');
    $links->upload = _taskLink('upload', $gid);

    // create perms
    $perms = new StdClass();
    $perms->view = DM_TPL_AUTHORIZED;
    $perms->search = DM_TPL_AUTHORIZED;
    $perms->upload = DM_TPL_NOT_AUTHORIZED;

    if ($_DMUSER->canUpload()) {
        $perms->upload = DM_TPL_AUTHORIZED;
    } else {
        if ($_DMUSER->userid == 0 && $_DOCMAN->getCfg('user_upload') != -1) {
            $perms->upload = DM_TPL_NOT_LOGGED_IN;
        }
    }

    return HTML_docman::fetchMenu($links, $perms);
}

function fetchPathWay($id)
{
     if (!$id > 0) {
             return;
     }

    // get the category ancestors
    $ancestors = &DOCMAN_Cats::getAncestors($id);

    // add home link
    $home = new StdClass();
    $home->name  = _DML_TPL_CAT_VIEW;
    $home->title = _DML_TPL_CAT_VIEW;
    //$home->link  = DOCMAN_Utils::taskLink('');

    $ancestors[] = &$home;
    // reverse the array
    $ancestors = &array_reverse($ancestors);
    // display the pathway
    return HTML_docman::fetchPathWay($ancestors);
}

function fetchPageNav($gid)
{
    global $_DMUSER, $total, $limit, $limitstart, $direction, $ordering;

    // show pages naviagtion
    require_once($GLOBALS['mosConfig_absolute_path'] . '/includes/pageNavigation.php');
    $pageNav = new mosPageNav($total, $limitstart, $limit);

    if ($total <= $limit) {
        return;
    }

    $link  = 'index.php?option=com_docman&amp;task=cat_view'
            .'&amp;gid='.$gid
            .'&amp;dir='.$direction
            .'&amp;order='.$ordering;

    return HTML_docman::fetchPageNav($pageNav, $link);
}

function fetchPageTitle($id)
{
     if (!$id > 0) {
             return;
     }

    // get the category ancestors
    $ancestors = &DOCMAN_Cats::getAncestors($id);

    // reverse the array
    $ancestors = &array_reverse($ancestors);

    // display the pathway
    return HTML_docman::fetchPageTitle($ancestors);
}

function _taskLink($task, $gid = '', $params = null)
{
    return DOCMAN_Utils::taskLink($task, $gid, $params);
}

function _returnTo($task, $msg = '', $gid = '', $params = null)
{
    return DOCMAN_Utils::returnTo($task, $msg, $gid, $params);
}

?>