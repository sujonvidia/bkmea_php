<?php include("./configuration.php"); ?>
<html>
<head>
<title><?php echo $mosConfig_sitename." - Check User Availability"; ?></title>
<link href="templates/JavaBean/css/template_css.css" type="text/css" rel=stylesheet>
<script language=javascript>

function closewin(){
        opener.document.forms[<?php echo intval($_GET['formid']); ?>].username.value="<?php echo $_POST['name']; ?>";
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
              global $mosConfig_dbprefix;
       include("./pear/db.php");
       echo $_POST['name'];
       $query="select username from ".$mosConfig_dbprefix."users where username='".$_POST['name']."'";
       $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
       $res =& $dbconn->query($query);
       $row =& $res->fetchRow();
       if ($_POST['name'])
       echo $row->username ? ' : This name is already in use' : ' : You can use this one';
       //str_replace(" ","",$u);
?>
</td>
</tr>
<tr>
  <td width=13%>&nbsp;</td>
        <td width=19%>
                User Name:
        </td>
        <td width="68%">
        <input type="text" name="name" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['name']; ?>" />

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