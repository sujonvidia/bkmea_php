<?php
 include("../configuration.php");
 include("../pear/db.php"); /**
        * Return entry type
        */
        function GetEntryTypeName( $id ) {
                global $mosConfig_absolute_path;
                switch($id){
                    case 1:
                         $name="Member Registration";
                         break;
                    case 2:
                         $name="Membership Renewal";
                         break;
                    case 3:
                         $name="Update Member Profile";
                         break;
                    case 4:
                         $name="Issue Certificate";
                         break;
                    case 5:
                         $name="Issue ID Card";
                         break;
                    case 6:
                         $name="Delete Member Profile";
                         break;
                    case 7:
                         $name="Information Product Sales";
                         break;
                }
                return $name;
        }
?>
<html>
<head>
<title><?php echo $mosConfig_sitename." - Check Money Receipt Number"; ?></title>
<link href="../templates/JavaBean/css/template_css.css" type="text/css" rel=stylesheet>
<script language="javascript">
     function newwindow()
               {
                         page='../popup/checkMoneyReceipt.php';
                         newWin=window.open(page,'','width=399,height=90,scrollbars=no,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');

               }
    </script>
</head>
<body onload="">

<form method="post" name="chkform" action="<?php $PHP_SELF ?>" >
<table>
<?php
     global $mosConfig_dbprefix;
     if(intval($_POST['money_receipt_no'])!=0){
       //If(isset($_POST['btnchkMRN']) ){
          $query="select m.type_id as type_id, mh.member_reg_no as member_reg_no,m.firm_name as firm_name,"
          ."\n mt.date as used_date ,mt.entry_type as entry_type from "
          ." ".$mosConfig_dbprefix."member_trail as mt,".$mosConfig_dbprefix."member as m, "
          ." ".$mosConfig_dbprefix."member_history as mh "
          ."\n where mt.member_id=mh.member_id and mt.money_receipt_no ='".$_POST['money_receipt_no']."' and m.id=mt.member_id order by mt.id ";
          $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
          $res =& $dbconn->query($query);
          $row =& $res->fetchRow();
          if(trim($row->firm_name)!=""){

             $entry=GetEntryTypeName($row->entry_type);
             $type_id=$row->type_id;
             if($type_id==1)
                $type="G";
             else if($type_id==2)
                $type="TA";
             else if($type_id==3)
                $type="O";
             else if($type_id==4)
                $type="A";

             echo "<tr><td width=40% align=right>Money Receipt No : </td><td>".$_POST['money_receipt_no']."</td></tr>";
             echo "<tr><td width=40% align=right>Used For : </td><td>".$row->firm_name."</td></tr>";
             echo "<tr><td width=40% align=right>Membership Code : </td><td>".$type.$row->member_reg_no."</td></tr>";
             echo "<tr><td width=40% align=right>Used Date : </td><td>".$row->used_date."</td></tr>";
             echo "<tr><td width=40% align=right>Used On : </td><td>".$entry."</td></tr>";
          }
          else
                  echo "<tr><td width=100% align=center colspan=2>You can use this money receipt number</td></tr>";
       //}
     }
     else
         echo "<tr><td width=100% align=center colspan=2>Please enter money receipt number</td></tr>";
?>
<tr>
        <td width=40%>
                Money Receipt Number :
        </td>
        <td width="60%">
        <input type="text" name="money_receipt_no" class="inputbox" size="30" maxlength="15" value= "<?php echo $money_receipt_no; ?>" />

        </td>
</tr>
<tr>
        <td >&nbsp;

        </td>
        <td>
        <input type="submit" name="btnchkMRN" class="button"   value="Check"  />
        <!--input type="button" name="Close" class="button"   value="Close" onclick="javascript:closewin();" /-->
        </td>
</tr>
</table>

</form>
</body>
</html>
