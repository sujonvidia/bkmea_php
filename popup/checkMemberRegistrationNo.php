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
       $where=" AND mh.member_reg_no='$search_member'";
       $selected1="Selected";
   }
   else if (intval($_POST['search_type'])==2){
       $where=" AND m.firm_name LIKE '%$search_member%'";
       $selected2="Selected";
   }
   else if (intval($_POST['search_type'])==3){
        $where=" AND (m.applicant_title LIKE '%$search_member%' OR m.applicant_name LIKE '%$search_member%' OR m.applicant_last_name LIKE '%$search_member%')";
        $selected3="Selected";
   }
   else if (intval($_POST['search_type'])==4){
        $where=" AND m.firm_reg_address_street LIKE '%$search_member%'";
        $selected4="Selected";
   }
   else if (intval($_POST['search_type'])==5){
        $where=" AND m.firm_email LIKE '%$search_member%'";
        $selected5="Selected";
   }
   else if (intval($_POST['search_type'])==6){
        $where=" AND m.firm_phone LIKE '%$search_member%'";
        $selected6="Selected";
   }
   else if (intval($_POST['search_type'])==7){
        $where=" AND m.firm_mobile LIKE '%$search_member%'";
        $selected7="Selected";
   }
   if (intval($_REQUEST['type_id'])>0){
       $type_id=" and m.type_id='".$_REQUEST['type_id']."'";
   }
   else
      $type_id="";

   if(trim(strtolower($mosConfig_owner))=="bkmea"){
          $query="select m.*, mh.member_reg_no from #__member as m"
                ."\n left join #__member_history as mh on m.id=mh.member_id"
                ."\n WHERE is_delete='0' "
                .$where
                ;
   }else{
         $query="select m.*, mh.member_reg_no from #__member as m"
                ."\n join #__member_history as mh on m.id=mh.member_id"
                ."\n join #__member_type as mt on mt.id=m.type_id"
                ."\n WHERE is_delete='0'"
                ."\n and mh.reg_year_id='".$_REQUEST['working_reg_year_id']."'"
                .$where.$type_id
                ;
   }
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
     memberInformation="membership number";
     break;
     case "2":
     memberInformation="firm name";
     break;
     case "3":
     memberInformation="applicant name";
     break;
     case "4":
     memberInformation="firm address";
     break;
     case "5":
     memberInformation="firm e-mail address";
     break;
     case "6":
     memberInformation="firm phone";
     break;
     case "7":
     memberInformation="firm mobile";
     break;
  }
  if (searchType!=0 && searchMember==""){
     alert("Please enter "+memberInformation);
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
        <td width="11%">
                Keyword&nbsp;:
        </td>
        <td width="89%">
        <input type="text" name="search_member" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['search_member']; ?>" />
        <input type="hidden" name="working_reg_year_id" value= "<?php echo $_REQUEST['working_reg_year_id']; ?>" />
        <input type="hidden" name="type_id" value= "<?php echo $_REQUEST['type_id']; ?>" />
        &nbsp;in&nbsp;<select name="search_type">
               <option value="0">All</option>
               <option value="1" <?php echo $selected1;?> >Membership Number</option>
               <option value="2" <?php echo $selected2;?> >Firm Name</option>
               <option value="3" <?php echo $selected3;?> >Applicant Name</option>
               <option value="4" <?php echo $selected4;?> >Firm Address</option>
               <option value="5" <?php echo $selected5;?> >Firm E-mail</option>
               <option value="6" <?php echo $selected6;?> >Firm Phone</option>
               <option value="7" <?php echo $selected7;?> >Firm Mobile</option>
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
if (strtolower(trim($mosConfig_owner))=="ccci" || strtolower(trim($mosConfig_owner))=="scci"){
   $add="Firm Address";
}
else if (strtolower(trim($mosConfig_owner))=="bkmea"){
   $add="Applicant Address";
}
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
      <td width="17%">Name of the Firm</td>
      <td width="17%">Applicant Name</td>
      <td width="15%"><?php echo $add;?></td>
      <td width="12%">E-mail</td>
      <td width="10%">Phone</td>
      <td width="10%">Mobile</td>
      <td width="5%">&nbsp;</td>
    </tr>
<?php
if (isset($_POST['search_type'])){
	for($i=0;$i<count($res);$i++){
		$row = $res[$i];
          $type_id=$row->type_id;
          if (strtolower(trim($mosConfig_owner))=="ccci" || strtolower(trim($mosConfig_owner))=="scci"){
             if($type_id==1)
                $type="G";
             else if($type_id==2)
                $type="TA";
             else if($type_id==3)
                $type="O";
             else if($type_id==4)
                $type="A";
             else if($type_id==5)
                $type="D";
             $address="";
             $address=$row->firm_reg_address_street;
             $address.=trim($row->firm_reg_address_town_suburb)!=""? ", ".$row->firm_reg_address_town_suburb:"";
             $address.=trim($row->firm_reg_address_district)!=""? ", ".$row->firm_reg_address_district:"";
             $address.=trim($row->firm_reg_address_division)!=""? ", ".$row->firm_reg_address_division:"";
             $address.=trim($row->firm_reg_address_country)!=""? ", ".$row->firm_reg_address_country:"";
             $email= $row->firm_email;
             $phone=$row->firm_phone;
             $mobile=$row->firm_mobile;
          }
          else if (strtolower(trim($mosConfig_owner))=="bkmea"){
             if($type_id==1)
                $type="O";
             else if($type_id==2)
                $type="A";
             $address="";
             $address=$row->applicant_address_street;
             $address.=trim($row->applicant_address_town_suburb)!=""? ", ".$row->applicant_address_town_suburb:"";
             $address.=trim($row->applicant_address_district)!=""? ", ".$row->applicant_address_district:"";
             $address.=trim($row->applicant_address_division)!=""? ", ".$row->applicant_address_division:"";
             $address.=trim($row->applicant_address_country)!=""? ", ".$row->applicant_address_country:"";
             $email= $row->applicant_email;
             $phone=$row->applicant_office_phone;
             $mobile=$row->applicant_mobile;
          }
    ?>
    <tr class="sectiontableentry2">
      <td >&nbsp;<?php echo $type.$row->member_reg_no;?></td>
      <td ><?php echo stripslashes($row->firm_name);?></td>
      <td ><?php echo $row->applicant_title." ".$row->applicant_name." ".$row->applicant_last_name;?></td>
      <td ><?php echo $address;?></td>
      <td ><?php echo $email;?></td>
      <td ><?php echo $phone;?></td>
      <td ><?php echo $mobile;?></td>
      <td >
         <!--input type="button" name="Close" class="button" value=" Select " onclick="javascript:closewin('<?php echo $row->member_reg_no;?>');" /-->
      <a href="javascript:closewin('<?php echo $row->member_reg_no;?>','<?php echo $row->type_id;?>');">&nbsp;Select&nbsp;</a>
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
