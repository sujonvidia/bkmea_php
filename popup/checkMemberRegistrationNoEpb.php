<?php
   include("../configuration.php");
   include("../includes/database.php");
   global $mosConfig_dbprefix,$mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db;
   $database=new database($mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db,$mosConfig_dbprefix);
   
   $query = "select * from #__templates_menu where menuid=0 and client_id=0";
   $database->setQuery($query);
   $res = $database->loadObjectList();
   $row = $res[0];

   $search_member=strtolower($_POST['search_member']);
   
   if (intval($_POST['search_type'])==1){
        $where=" AND (m.name LIKE '%$search_member%' )";
        $selected1="Selected";
   }
   else if (intval($_POST['search_type'])==2){
        $where=" AND m.address LIKE '%$search_member%'";
        $selected2="Selected";
   }
   else if (intval($_POST['search_type'])==3){
        $where=" AND m.email LIKE '%$search_member%'";
        $selected3="Selected";
   }
   else if (intval($_POST['search_type'])==4){
        $where=" AND m.phone LIKE '%$search_member%'";
        $selected4="Selected";
   }
   else if (intval($_POST['search_type'])==5){
        $where=" AND m.mobile LIKE '%$search_member%'";
        $selected5="Selected";
   }
         $query="select m.* from #__stakeholder as m"
                ."\n WHERE m.is_delete='0' ".$where;
               
   $database->setQuery($query);
   $res =$database->loadObjectList();

?>
<html>
<head>
<title><?php echo $mosConfig_sitename." - Check Existing Member Availability"; ?></title>
<link href="../templates/<?php echo $row->template; ?>/css/template_css.css" type="text/css" rel=stylesheet>
<script language="javascript">
var mosConfig_owner='<?php echo strtolower($mosConfig_owner);?>';
function closewin(memberRegNo,memberType){
        opener.document.<?php echo trim($_GET['formName']); ?>.member_reg_no.value=memberRegNo;
        if (mosConfig_owner=="scci" || mosConfig_owner=="ccci")
           opener.document.<?php echo trim($_GET['formName']); ?>.type_id.value=memberType;
        self.close();
}
function validate(){
  var customerInformation;
  var searchType=document.chkform.search_type.value;
  var searchMember=document.chkform.search_member.value;
  switch (searchType){
     case "1":
     memberInformation="name";
     break;
     case "2":
     memberInformation="address";
     break;
     case "3":
     memberInformation="email";
     break;
     case "4":
     memberInformation="phone";
     break;
     case "5":
     memberInformation="mobile";
     break;
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
        <td width="11%">
                Keyword&nbsp;:
        </td>
        <td width="89%">
        <input type="text" name="search_member" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['search_member']; ?>" />
        <input type="hidden" name="working_reg_year_id" value= "<?php echo $_REQUEST['working_reg_year_id']; ?>" />
        <input type="hidden" name="type_id" value= "<?php echo $_REQUEST['type_id']; ?>" />
        &nbsp;in&nbsp;<select name="search_type">
               <option value="0">All</option>
               <option value="1" <?php echo $selected1;?> >Name</option>
               <option value="2" <?php echo $selected2;?> >Address</option>
               <option value="3" <?php echo $selected3;?> >Email</option>
               <option value="4" <?php echo $selected4;?> >Phone</option>
               <option value="5" <?php echo $selected5;?> >Mobile</option>
        </select>&nbsp;

        <!--input type="hidden" name="search_type" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['search_type']; ?>" /-->
        &nbsp;<input type="submit" name="Validity" class="button"   value=" Search " onClick="return validate();" />
        &nbsp;<input type="button" name="Close" class="button" value="Close" onclick="javascript:self.close();" />
        </td>
</tr>
<!--tr>
  <td >&nbsp;</td>
        <td >&nbsp;

        </td>
        <td>
        <input type="submit" name="Validity" class="button"   value="Search Member" onClick="return validate();" />

        </td>
</tr-->
</table>
<br />
<?php
if ($_POST['Validity']){
?>
<table class="sectiontableentry1" align="center" width="98%">
 <tr >
      <td width="100%" colspan="8" align="center"><font size="3"><b>Member Information</b></font></td>
     </tr>
     <tr height="2">
      <td width="100%" colspan="8" align="center">&nbsp;</td>
     </tr>
<tr class="tableheader">
      <td width="12%">Membership&nbsp;#</td>
      <td width="17%">Name</td>
      <td width="17%">Address</td>
      <td width="15%">Email</td>
      <td width="12%">Phone</td>
      <td width="10%">Mobile</td>
      <td width="5%">&nbsp;</td>
    </tr>
<?php
if (isset($_POST['search_type'])){
	for($i=0;$i<count($res);$i++){
		$row = $res[$i];
    ?>
    <tr class="sectiontableentry2">
      <td >&nbsp;<?php echo $row->id;?></td>
      <td ><?php echo $row->name;?></td>
      <td ><?php echo $row->address;?></td>
      <td ><?php echo $row->email;?></td>
      <td ><?php echo $row->phone;?></td>
      <td ><?php echo $row->mobile;?></td>
      <td >
      <a href="javascript:closewin('<?php echo $row->id;?>','0');">&nbsp;Select&nbsp;</a>
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
</form>
<br />
</body>
</html>
