<?php
   include("../configuration.php");
   include("../includes/database.php");
   global $mosConfig_dbprefix,$mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db;
   $database=new database($mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db,$mosConfig_dbprefix);
   
  function ConvertDateForDatatbase($input){
            $input=trim($input);
            if($input=="")
              return "";
            else if($input=="00-00-0000")
              return "";
            else{
              $arr=explode("-",$input);
              $out=$arr[2]."-".$arr[1]."-".$arr[0];
              return $out;
            }
        }

   $date_from = ConvertDateForDatatbase($_POST['date_from']);
   $date_to   = ConvertDateForDatatbase($_POST['date_to']);
   $search_customer=strtolower($_POST['search_customer']);
   $where = array();
   if ($date_from != '' && $date_to != '' ) {
       //$reporting_period="Reporting Period : From ".$date_from_display." Upto ".$date_to_display;
       $where[] = "inv.date>='$date_from' and inv.date<='$date_to'";
   }
   else if ($date_from == '' && $date_to != '' ) {
       //$reporting_period="Reporting Period : Upto ".$date_to_display;
       $where[] = "inv.date<='$date_to'";
   }
   else if ($date_from != '' && $date_to == '' ) {
       //$reporting_period="Reporting Period : From ".$date_from_display;
       $where[] = "inv.date>='$date_from'";
   }

   if (intval($_POST['search_type'])==1){
       $where[]="inv.id='$search_customer'";
       $selected1="Selected";
   }
   else if (intval($_POST['search_type'])==2){
       $where[]="c.id='$search_customer'";
       $selected2="Selected";
   }
   else if (intval($_POST['search_type'])==3){
       $where[]="c.organization_name LIKE '%$search_customer%'";
       $selected3="Selected";
   }
   else if (intval($_POST['search_type'])==4){
        $where[]="(c.customer_title LIKE '%$search_customer%' OR c.customer_first_name LIKE '%$search_customer%' OR c.customer_last_name LIKE '%$search_customer%')";
        $selected4="Selected";
   }
   else if (intval($_POST['search_type'])==5){
        $where[]="(c.address LIKE '%$search_customer%' OR c.country LIKE '%$search_customer%')";
        $selected5="Selected";
   }
   else if (intval($_POST['search_type'])==6){
        $where[]="c.email LIKE '%$search_customer%'";
        $selected6="Selected";
   }
   else if (intval($_POST['search_type'])==7){
        $where[]="c.phone_no LIKE '%$search_customer%'";
        $selected7="Selected";
   }
   else if (intval($_POST['search_type'])==8){
        $where[]="c.mobile_no LIKE '%$search_customer%'";
        $selected8="Selected";
   }

   if (intval($_POST['productList'])>0){
        $where[]="d.id='".intval($_POST['productList'])."'";
   }
   else if (intval($_POST['productList'])==-99){
        $where[]="inv.product_type='2'";
   }
   else if (intval($_POST['productList'])==-100){
        $where[]="inv.product_type='3'";
   }
   $no_of_days_to_download_purchase_product=" WHERE DATE_ADD(inv.date,INTERVAL $mosconfig_no_of_days_to_download_purchase_product DAY)";
   $query="select distinct inv.*, inv.id as coupon_no, c.*,d.*, c.id as customer_id from ".$mosConfig_dbprefix
           ."invoice as inv left join #__customer as c on inv.customer_id=c.id "
           ." left join #__docman as d on inv.product_id=d.id "
           .$no_of_days_to_download_purchase_product.">=CURDATE() "
           . ( count( $where ) ? "\n AND " . implode( ' AND ', $where ) : "")
           ;
   $database->setQuery($query);
   $res =$database->loadObjectList();
   //$row =& $res->fetchRow();

   $queryProductList="select * from ".$mosConfig_dbprefix."docman as d ";
   $database->setQuery($queryProductList);
   $resProductList =$database->loadObjectList();
   $productList="<select name='productList'>";
   $productList.="<option value='0'>All</option>";
   for($i=0;$i<count($resProductList);$i++){
   	 $row = $resProductList[$i];
        $productList.="<option value='$row->id'>$row->dmname</option>";
   }
  $productList.="</select>";
?>
<html>
<head>
<title><?php echo $mosConfig_sitename." - Find Coupon Number"; ?></title>
<link href="../templates/epb_template/css/template_css.css" type="text/css" rel=stylesheet>
<link rel="stylesheet" href="<?php echo $mosConfig_live_site; ?>/includes/calender/calendar-blue.css" type="text/css"  />
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/calender/calendar.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/calender/lang/calendar-en.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/calender/calendar-setup.js" type="text/javascript"></script>
<script language="javascript">

function closewin(couponNumber){
        opener.document.<?php echo trim($_GET['formName']); ?>.invoice_no.value=couponNumber;
        self.close();
}
function validate(){
  var customerInformation;
  var searchType=document.chkform.search_type.value;
  var searchCustomer=document.chkform.search_customer.value;
  switch (searchType){
     case "1":
     customerInformation="Coupon number";
     break;
     case "2":
     customerInformation="customer ID";
     break;
     case "3":
     customerInformation="firm name";
     break;
     case "4":
     customerInformation="customer name";
     break;
     case "5":
     customerInformation="customer address";
     break;
     case "6":
     customerInformation="customer e-mail address";
     break;
     case "7":
     customerInformation="customer phone";
     break;
     case "8":
     customerInformation="customer mobile";
     break;
  }
  if (searchType!=0 && searchCustomer==""){
     alert("Please enter "+customerInformation);
     return false;
  }
  return true;
}
</script>
</head>
<body>
<br />
<form method="post" name="chkform" action="<?php $PHP_SELF ?>" title="check">

<table align="center">

<tr>
        <td width="11%" align="right">
                Keyword&nbsp;:
        </td>
        <td width="89%">
        <input type="text" name="search_customer" class="inputbox" size="15" maxlength="100" value= "<?php echo $_POST['search_customer']; ?>" />
        &nbsp;in&nbsp;
        <select name="search_type">
               <option value="0">All</option>
               <option value="1" <?php echo $selected1;?> >Coupon Number</option>
               <option value="2" <?php echo $selected2;?> >Customer ID</option>
               <option value="3" <?php echo $selected3;?> >Firm Name</option>
               <option value="4" <?php echo $selected4;?> >Customer Name</option>
               <option value="5" <?php echo $selected5;?> >Address</option>
               <option value="6" <?php echo $selected6;?> >E-mail</option>
               <option value="7" <?php echo $selected7;?> >Phone</option>
               <option value="8" <?php echo $selected8;?> >Mobile</option>
        </select>&nbsp;
        Trade Lead : &nbsp
        <?php echo $productList;?>
        <!--input type="hidden" name="search_type" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['search_type']; ?>" /-->

        </td>
</tr>
<tr>
        <td width="11%" align="right">
                Date From&nbsp;:
        </td>
        <td width="89%">
        <input class="text_area" type="text" name="date_from" id="date_from" value="<?php echo date('d-m-Y');?>" size="25" />
        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
        &nbsp;&nbsp;Date To&nbsp;
        <input class="text_area" type="text" name="date_to" id="date_to" value="<?php echo date('d-m-Y');?>" size="25" />
        <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img2" border=0 class="calender_link">
        &nbsp;<input type="submit" name="Validity" class="button"   value=" Search " onClick="return validate();" />
        &nbsp;<input type="button" name="Close" class="button" value="Close" onclick="javascript:self.close();" />
        </td>
</tr>
<tr>
<td colspan=2>
<hr width=100% height=1>
</td>
</tr>
<!--tr>
  <td width=10%>&nbsp;</td>
        <td width=15%>&nbsp;

        </td>
        <td>
        <input type="submit" name="Validity" class="button"   value="Search Customer" onClick="return validate();" />

        </td>
</tr-->
</table>
<br />
<?php
if ($_POST['Validity']){
?>
    <table class="sectiontableentry1" align="center" width="98%">
    <tr >
      <td width="100%" colspan="8" align="center"><font size="3"><b>Info Products Coupon Information</b></font></td>
     </tr>
     <tr height="2">
      <td width="100%" colspan="8" align="center">&nbsp;</td>
     </tr>
    <tr class="tableheader">
      <td width="7%">Couopn&nbsp;#</td>
      <td width="9%">Sales date</td>
      <td width="12%">Name of the Trade Lead</td>
      <td width="5%">Cust. ID</td>
      <td width="14%">Name of the Firm</td>
      <td width="12%">Name</td>
      <td width="14%">Address</td>
      <td width="15%">E-mail</td>
      <td width="11%">Phone/Mobile</td>
    </tr>
    <?php
    if (isset($_POST['search_type']))
    {
     for($i=0;$i<count($res);$i++){
   	 $row = $res[$i];
            if ( !empty($row->product_id))
                $productName=$row->dmname;
            else if (intval($row->product_type)==2 && empty($row->product_id))
                $productName="General Contact";
            else if (intval($row->product_type)==3 && empty($row->product_id))
                $productName="Full Profile";
        ?>
        <tr class="sectiontableentry2">
          <td >&nbsp;<a href="javascript:closewin('<?php echo $row->coupon_no;?>');"><b><?php echo $row->coupon_no;?></b></a></td>
          <td><?php echo  date( 'd.m.Y', strtotime($row->date));?></td>
          <td><?php echo $productName;?></td>
          <td><?php echo $row->customer_id;?></td>
          <td><?php echo stripslashes($row->organization_name);?></td>
          <td><?php echo $row->customer_title." ".$row->customer_first_name." ".$row->customer_last_name;?></td>
          <td><?php echo stripslashes($row->address);?></td>
          <td><?php echo $row->email;?></td>
          <td><?php echo $row->phone_no.$row->mobile_no;?></td>
          <!--td-->
             <!--input type="button" name="Close" class="button" value=" Select " onclick="javascript:closewin('<?php echo $row->id;?>');" /-->
             <!--a href="javascript:closewin('<?php echo $row->coupon_no;?>');">&nbsp;Select&nbsp;</a>
          </td-->
        </tr>
        <?php
        }
    }
    ?>

    </table>
<?php
}
?>
<br />
<!--div align="center">
 <input type="button" name="Close" class="button" value="Close" onclick="javascript:self.close();" />
</div-->
<br />
<script type="text/javascript">
                        Calendar.setup({
                        inputField     :    "date_from",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                        Calendar.setup({
                        inputField     :    "date_to",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img2",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });

                </script>
</form>
</body>
</html>
