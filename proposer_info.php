<?php include("./configuration.php");

include("./pear/db.php");
       global $mosConfig_dbprefix;
if ($_POST['Validity']){
       //$query="select Firm_name as fir from mos_users where username='".$name."'";
       $query="select firm_name as firm_name, concat(applicant_address_street ,' ', applicant_address_town_suburb"
              ."\n ,' ', applicant_address_district ,' ', applicant_address_division ,' ', applicant_address_country) as address"
              ."\n from ".$mosConfig_dbprefix."member where member_reg_no ='".$_POST['member_reg_no']."' and is_delete=0";

       //$query=$database->replaceTablePrefix($query);
       $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
       $res =& $dbconn->query($query);
       $row =& $res->fetchRow();
}

?>
<html>
<head>
<title><?php echo $mosConfig_sitename." - Check Proposer"; ?></title>
<link href="templates/JavaBean/css/template_css.css" type="text/css" rel=stylesheet>
<script language=javascript>

function closewin(){
        <?php if ($_GET['from']==1) {
                    if ($row->firm_name) {
         ?>
        opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_one_name.value="<?php echo $row->firm_name; ?>";
        opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_one_address.value="<?php echo $row->address; ?>";
        opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_one_member_reg_no.value="<?php echo $_POST['member_reg_no']; ?>";
        <?php
                    }
        } else if ($_GET['from']==2){
                     if ($row->firm_name) {
        ?>
        opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_two_name.value="<?php echo $row->firm_name; ?>";
        opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_two_address.value="<?php echo $row->address; ?>";
        opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_two_member_reg_no.value="<?php echo $_POST['member_reg_no']; ?>";
        <?php }
        } ?>
        //opener.document.mosForm.username.value="<?php echo $name; ?>";

        self.close();
}
</script>
</head>
<body>

<form method=post name=chkform action="<?php $PHP_SELF ?>" title="check">
<table>
<tr>
<td height=26 colspan=3 align=center valign=middle>
<?php

       if ($_POST['member_reg_no'])
           echo $row->firm_name ? "Firm name :".$row->firm_name."<br>"."Address :".$row->address : 'There is no such Member' ;

       //str_replace(" ","",$u);
?>
</td>
</tr>
<tr>
  <td width=13%>&nbsp;</td>
        <td width=19%>
                Member Reg NO:
        </td>
        <td width="68%">
        <input type="text" name="member_reg_no" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['member_reg_no']; ?>" />

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
