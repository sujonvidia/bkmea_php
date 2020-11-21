<?php
include("../../configuration.php");
include("../../includes/database.php");
$database= new database($mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db,$mosConfig_dbprefix);

$search_member=strtolower($_POST['search_member']);
if(trim($_REQUEST['search_member'])!=""){
        if (intval($_POST['search_type'])==1 )
        {
                $where     = " AND m.member_reg_no='$search_member'";
                $selected1 = "Selected";
        }
        else if (intval($_POST['search_type'])==2){
                $where     = " AND m.firm_name LIKE '%$search_member%'";
                $selected2 = "Selected";
        }
        else if (intval($_POST['search_type'])==3){
                $where     = " AND (m.applicant_title LIKE '%$search_member%' OR m.applicant_name LIKE '%$search_member%' OR m.applicant_last_name LIKE '%$search_member%')";
                $selected3 = "Selected";
        }
        else if (intval($_POST['search_type'])==4){
                $where     =" AND m.applicant_address_street LIKE '%$search_member%'";
                $selected4 ="Selected";
        }
        else if (intval($_POST['search_type'])==6){
                $where     = " AND m.applicant_office_phone LIKE '%$search_member%'";
                $selected6 = "Selected";
        }
        else if (intval($_POST['search_type'])==8){
                $where     =" AND m.office_address_street LIKE '%$search_member%'";
                $selected8 ="Selected";
        }else {
                $where      = " and ( m.member_reg_no='$search_member'";
                $where     .= " or m.firm_name LIKE '%$search_member%'";
                $where     .= " or m.applicant_title LIKE '%$search_member%' OR m.applicant_name LIKE '%$search_member%' OR m.applicant_last_name LIKE '%$search_member%' ";
                $where     .= " or m.applicant_address_street LIKE '%$search_member%'";
                $where     .= " or m.applicant_office_phone LIKE '%$search_member%'";
                $where     .= " or m.office_address_street LIKE '%$search_member%' ) ";
        }
        $query = "select m.*, m.member_reg_no, mc.name as member_category, m.office_email as email "
        ."\n , m.applicant_title,  m.applicant_name, m.applicant_last_name "
        ."\n from #__member as m, #__member_category as mc "
        ."\n WHERE m.member_category_id=mc.id and is_delete='0' "
        .$where
        ;
        $database->setQuery($query);
        $res = $database->loadObjectList();
}
?>
  <html>
  <head>
  <title><?php echo $mosConfig_sitename." - Search Existing Member"; ?></title>
  <link href="../templates/mambo_admin/css/template_css.css" type="text/css" rel=stylesheet>
  <script language="javascript">
  function closewin(memberRegNo,catId, name,email)
  {
          opener.document.<?php echo trim($_GET['formName']); ?>.member_reg_no.value      = memberRegNo;
          opener.document.<?php echo trim($_GET['formName']); ?>.member_category_id.value = catId;
          opener.document.<?php echo trim($_GET['formName']); ?>.name.value = name;
          opener.document.<?php echo trim($_GET['formName']); ?>.email_address.value = email;
          self.close();
  }

  function validateForm(){
          var memberInformation;
          var searchType=document.chkform.search_type.value;
          var searchMember=document.chkform.search_member.value;
          switch (searchType){
                  case "1":
                  memberInformation="membership number";
                  break;
                  case "2":
                  memberInformation="factory name";
                  break;
                  case "3":
                  memberInformation="applicant name";
                  break;
                  case "4":
                  memberInformation="factory address";
                  break;
                  case "6":
                  memberInformation="factory phone";
                  break;
                  case "8":
                  memberInformation="office address";
                  break;
          }
          if (searchType!=0 && searchMember==""){
                  alert("Please enter "+memberInformation);
                  return false;
          }
          return true;
  }

  function aKeyWasPressed(e){

          if (document.layers){
                  Key = e.which;
          }
          else
          {
                  Key = window.event.keyCode;
          }
          if (Key == 13)
          {
                  document.chkform.submit();
          }
  }
  </script>
  </head>
  <body>
  <form method="post" name="chkform" action="<?php $PHP_SELF ?>" title="check" >
  <table class="adminForm">
  <tr>
   <td>
  <table  align="center">
  <tr>
          <td width="11%">
                  Keyword&nbsp;:
          </td>
          <td width="89%">
          <input type="text" name="search_member" onKeyPress="javascript: aKeyWasPressed();" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['search_member']; ?>" />
          &nbsp;in&nbsp;
          <select name="search_type">
              <option value="0">All</option>
              <option value="1" <?php echo $selected1;?> >Membership Number</option>
              <option value="2" <?php echo $selected2;?> >Name of Factory</option>
              <option value="3" <?php echo $selected3;?> >Applicant Name</option>
              <option value="4" <?php echo $selected4;?> >Factory Address</option>
              <!--option value="5" <?php //echo $selected5;?> >Factory E-mail</option>
              <option value="7" <?php //echo $selected7;?> >Factory Mobile</option-->
              <option value="6" <?php echo $selected6;?> >Factory Phone</option>
              <option value="8" <?php echo $selected8;?> >Office Address</option>
          </select>
          &nbsp;
          &nbsp;<input type="submit" name="search" class="button"   value=" Search " onClick="return validateForm();" />
          &nbsp;<input type="button" name="Close" class="button" value="Close" onclick="javascript:self.close();" />
          </td>
  </tr>
  </table>
  </td>
 </tr>
</table>
     <table  class="adminForm">
       <tr>
        <td align="center">
   <?php if(trim($_REQUEST['search_member'])!=""){
           if(count($res)>0 ){ ?>
               <table  class="adminlist" align="center" width="98%" cellspacing="1">
               <tr >
                <th width="100%" colspan="7" align="center">Member Information</th>
               </tr>
               <tr>
                <th width="10%" class="title">Membership&nbsp;#</th>
                <th width="20%" class="title">Name of the Factory</th>
                <th width="15%" class="title">Applicant Name</th>
                <th width="20%" class="title">Factory Address</th>
                <th width="10%" class="title">Factory Phone</th>
                <th width="20%" class="title">Office Address</th>
                <th width="5%" class="title">&nbsp;</th>
              </tr>
          <?php
          $tableRow=0;
          for($i=0; $i<count($res); $i++)
          {
                  $row = $res[$i];

                  $factoryAddress  = "";
                  $factoryAddress  = $row->applicant_address_street;
                  $factoryAddress .= " ".trim($row->applicant_address_town_suburb);
                  $factoryAddress .= " ".trim($row->applicant_address_district);
                  $factoryAddress .= " ".trim($row->applicant_address_division);
                  $factoryAddress .= " ".trim($row->applicant_address_country);
                  $factoryEmail    = $row->applicant_email;
                  $factoryPhone    = $row->applicant_office_phone;
                  $factoryMobile   = $row->applicant_mobile;


                  $officeAddress  = "";
                  $officeAddress  = $row->office_address_street;
                  $officeAddress .= " ".trim($row->office_address_town_suburb);
                  $officeAddress .= " ".trim($row->office_address_district);
                  $officeAddress .= " ".trim($row->office_address_division);
                  $officeAddress .= " ".trim($row->office_address_country);
                  $officeEmail    = $row->office_email;
                  $officePhone    = $row->office_phone;
                  $officeMobile   = $row->office_mobile;
                  //$name = $row->applicant_title." ".$row->applicant_name." ".$row->applicant_last_name

          ?>
              <tr class="row<?php echo $tableRow; ?>">
                <td >&nbsp;<?php echo $row->member_reg_no." ".$row->member_category;?></td>
                <td ><?php echo stripslashes($row->firm_name);?></td>
                <td ><?php echo $row->applicant_title." ".$row->applicant_name." ".$row->applicant_last_name;?></td>
                <td ><?php echo $factoryAddress;?></td>
                <td ><?php echo $factoryPhone;?></td>
                <td ><?php echo $officeAddress;?></td>
                <td >
                <a href="javascript:closewin('<?php echo $row->member_reg_no; ?>','<?php echo $row->member_category_id; ?>','','');">Select</a>
                </td>
              </tr>
              <?php
              if($tableRow==0)
              $tableRow = 1;
              else
              $tableRow = 0;
          }
  ?>          </table>

  <?php
           } else{
                   echo "No items found.";
           }
   }else{
           echo "Enter keyword to search.";
   }

  ?>
    </td>
  </tr>
  </table>
  </form>
  </body>
  </html>
