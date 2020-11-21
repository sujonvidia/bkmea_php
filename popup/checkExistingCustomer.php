<?php
   include("../configuration.php");
   include("../includes/database.php");
   global $mosConfig_dbprefix,$mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db;
   $database=new database($mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db,$mosConfig_dbprefix);
   
   $query = "select * from #__templates_menu where menuid=0 and client_id=0";
   $database->setQuery($query);
   $res = $database->loadObjectList();
   $row = $res[0];
   
   $search_customer=strtolower($_POST['search_customer']);
   if (intval($_POST['search_type'])==1){
       $where="WHERE id='$search_customer'";
       $selected1="Selected";
   }
   else if (intval($_POST['search_type'])==2){
       $where="WHERE organization_name LIKE '%$search_customer%'";
       $selected2="Selected";
   }
   else if (intval($_POST['search_type'])==3){
        $where="WHERE customer_title LIKE '%$search_customer%' OR customer_first_name LIKE '%$search_customer%' OR customer_last_name LIKE '%$search_customer%'";
        $selected3="Selected";
   }
   else if (intval($_POST['search_type'])==4){
        $where="WHERE address LIKE '%$search_customer%' OR country LIKE '%$search_customer%'";
        $selected4="Selected";
   }
   else if (intval($_POST['search_type'])==5){
        $where="WHERE email LIKE '%$search_customer%'";
        $selected5="Selected";
   }
   else if (intval($_POST['search_type'])==6){
        $where="WHERE phone_no LIKE '%$search_customer%'";
        $selected6="Selected";
   }
   else if (intval($_POST['search_type'])==7){
        $where="WHERE mobile_no LIKE '%$search_customer%'";
        $selected7="Selected";
   }

   $query="select * from #__customer ".$where;
   $database->setQuery($query);
   $res =& $database->loadObjectList();
   //$row =& $res->fetchRow();

?>
<html>
<head>
<title><?php echo $mosConfig_sitename." - Check Existing Customer Availability"; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/templates/<?php echo $row->template; ?>/css/template_css.css" />
<script language="javascript">

function closewin(customerID){
        opener.document.<?php echo trim($_GET['formName']); ?>.customer_id.value=customerID;
        self.close();
}
function validate(){
  var customerInformation;
  var searchType=document.chkform.search_type.value;
  var searchCustomer=document.chkform.search_customer.value;
  switch (searchType){
     case "1":
     customerInformation="customer ID";
     break;
     case "2":
     customerInformation="firm name";
     break;
     case "3":
     customerInformation="customer name";
     break;
     case "4":
     customerInformation="customer address";
     break;
     case "5":
     customerInformation="customer e-mail address";
     break;
     case "6":
     customerInformation="customer phone";
     break;
     case "7":
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
        <input type="text" name="search_customer" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['search_customer']; ?>" />
        &nbsp;in&nbsp;
        <select name="search_type">
               <option value="0">All</option>
               <option value="1" <?php echo $selected1;?> >Customer ID</option>
               <option value="2" <?php echo $selected2;?> >Firm Name</option>
               <option value="3" <?php echo $selected3;?> >Customer Name</option>
               <option value="4" <?php echo $selected4;?> >Address</option>
               <option value="5" <?php echo $selected5;?> >E-mail</option>
               <option value="6" <?php echo $selected6;?> >Phone</option>
               <option value="7" <?php echo $selected7;?> >Mobile</option>
        </select>&nbsp;

        <!--input type="hidden" name="search_type" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['search_type']; ?>" /-->
        &nbsp;<input type="submit" name="Validity" class="button"   value=" Search " onClick="return validate();" />
        &nbsp;<input type="button" name="Close" class="button" value="Close" onclick="javascript:self.close();" />
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
    <table class="sectiontableentry1" align="center" width="95%">
    <tr >
      <td width="100%" colspan="8" align="center"><font size="3"><b>Existing Customer Information</b></font></td>
     </tr>
     <tr height="2">
      <td width="100%" colspan="8" align="center">&nbsp;</td>
     </tr>
    <tr class="tableheader">
      <td width="5%">ID</td>
      <td width="18%">Firm Name</td>
      <td width="15%">Name</td>
      <td width="18%">Address</td>
      <td width="15%">E-mail</td>
      <td width="12%">Phone</td>
      <td width="12%">Mobile</td>
      <td width="5%">&nbsp;</td>
    </tr>
    <?php
    if (isset($_POST['search_type'])){
    	for($i=0;$i<count($res);$i++){
    		$row = $res[$i];
        ?>
        <tr class="sectiontableentry2">
          <td width="5%"><?php echo $row->id;?></td>
          <td width="18%"><?php echo stripslashes($row->organization_name);?></td>
          <td width="15%"><?php echo $row->customer_title." ".$row->customer_first_name." ".$row->customer_last_name;?></td>
          <td width="18%"><?php echo stripslashes($row->address);?></td>
          <td width="15%"><?php echo $row->email;?></td>
          <td width="12%"><?php echo $row->phone_no;?></td>
          <td width="12%"><?php echo $row->mobile_no;?></td>
          <td width="5%">
             <!--input type="button" name="Close" class="button" value=" Select " onclick="javascript:closewin('<?php echo $row->id;?>');" /-->
             <a href="javascript:closewin('<?php echo $row->id;?>');">&nbsp;Select&nbsp;</a>
          </td>
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
</form>
</body>
</html>
