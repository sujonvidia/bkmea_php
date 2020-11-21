<?php 

   include("../configuration.php");
   include("../includes/database.php");
   global $mosConfig_dbprefix,$mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db;
   $database=new database($mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db,$mosConfig_dbprefix);
   
   $query = "select * from #__templates_menu where menuid=0 and client_id=0";
   $database->setQuery($query);
   $res = $database->loadObjectList();
   $row1 = $res[0];
   
   $query="select money_receipt_no from #__member_trail where money_receipt_no='".$_REQUEST['money_receipt_no']."'";
   $database->setQuery($query);
   $res =$database->loadObjectList();
   $row =$res[0];

?>
<html>
<head>
<title><?php echo $mosConfig_sitename." - Check Money Receipt Availability"; ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/templates/<?php echo $row1->template; ?>/css/template_css.css" />
<script language="javascript">

function closewin(){
        opener.document.<?php echo trim($_GET['formName']); ?>.money_receipt_no.value="<?php echo $_REQUEST['money_receipt_no']; ?>";
        self.close();
}



                var arr = new Array();
                   arr[27] ="0";
                   arr[28] ="1";
                   arr[29] ="2";
                   arr[30] = "3";
                   arr[31] = "4";
                   arr[32] = "5";
                   arr[33] = "6";
                   arr[34] = "7";
                   arr[35] = "8";
                   arr[36] = "9";
                   arr[37] = ".";

                function check_IntNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var form = document.chkform;
                   var msg=mid;

                   str=form.elements[obj].value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 37; j++)
                      {
                        if(str.charAt(i) == arr[j])
                           break;
                      }
                      if(j>36)
                      {

                        alert(msg);
                        var temp = parseInt(str);
                        if(isNaN(temp))
                          form.elements[obj].value=0;
                        else
                          form.elements[obj].value=temp;
                        form.elements[obj].focus();
                        form.elements[obj].select();
                        break;
                      }
                   }
                }
</script>
</head>
<body>

<form method=post name=chkform action="<?php $PHP_SELF ?>" title="check">
<table>
<tr>
<td height=26 colspan=3 align=center valign=middle>
<?php
   echo "<br>";
   echo $_REQUEST['money_receipt_no'];
   if ($_REQUEST['money_receipt_no'])
       echo $row->money_receipt_no ? ' : This money receipt number is already in use' : ' : This money receipt number can be used';
   echo "<br><br>";
   //str_replace(" ","",$u);
?>
</td>
</tr>
<tr>
  <td width=7%>&nbsp;</td>
        <td width=36%>
                Money Receipt Number :
        </td>
        <td width="64%">
        <input type="text" name="money_receipt_no" class="inputbox" size="30" maxlength="50" value= "<?php echo $_REQUEST['money_receipt_no']; ?>"  onKeyUp="javascript:check_IntNumber('money_receipt_no','Enter valid money receipt number.');"  />

        </td>
</tr>
<tr>
  <td >&nbsp;</td>
        <td >&nbsp;

        </td>
        <td>
        <input type="submit" name="Validity" class="button"   value="Check Availability"  />
        <input type="button" name="Close" class="button"   value="Close" onclick="javascript:closewin();" />
        </td>
</tr>
</table>

</form>
</body>
</html>
