  <?php
  include("../configuration.php");
  include("../pear/db.php");
  global $mosConfig_dbprefix,$dbconn;

  if ($_POST['Validity']){
     if (intval($_POST['member_type'])>0){
        $memberType=" and type_id='".intval($_POST['member_type'])."'";
     }
     else
         $memberType="";
     //$query="select Firm_name as fir from mos_users where username='".$name."'";
     $query="select firm_name as firm_name, applicant_name,applicant_last_name,concat(firm_reg_address_street ,' ', firm_reg_address_town_suburb"
            ."\n ,' ', firm_reg_address_district ,' ', firm_reg_address_division ,' ', firm_reg_address_country) as address"
            ."\n from ".$mosConfig_dbprefix."member where member_reg_no ='".$_POST['member_reg_no']."' and is_delete='0'".$memberType
            ;
     $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
     $res =& $dbconn->query($query);
     $row =& $res->fetchRow();
  }
  $query_type="select * from ".$mosConfig_dbprefix."member_type";
  $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
  $res1 =& $dbconn->query($query_type);
  //$row1 =& $res1->fetchRow();
  $list_member_type="<select name='member_type'><option value='0'>Select Member Type</option>";
  while ($row1 =& $res1->fetchRow()){
      $list_member_type.="<option value='$row1->id'>$row1->name</option>";
  }
  $list_member_type.="</select>";
  ?>
  <html>
  <head>
  <title><?php echo $mosConfig_sitename." - Check Proposer"; ?></title>
  <link href="../templates/JavaBean/css/template_css.css" type="text/css" rel=stylesheet>
  <script language=javascript>

  function closewin(){
      <?php
      if ($_GET['from']==1) {
         if ($row->firm_name) {
      ?>
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer1_firm_name.value="<?php echo $row->firm_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer1_name.value="<?php echo $row->applicant_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer1_last_name.value="<?php echo $row->applicant_last_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer1_address.value="<?php echo $row->address; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer1_member_reg_no.value="<?php echo $_POST['member_reg_no']; ?>";
      <?php
        }
      }
      else if ($_GET['from']==2){
         if ($row->firm_name) {
      ?>
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer2_firm_name.value="<?php echo $row->firm_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer2_name.value="<?php echo $row->applicant_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer2_last_name.value="<?php echo $row->applicant_last_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer2_address.value="<?php echo $row->address; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer2_member_reg_no.value="<?php echo $_POST['member_reg_no']; ?>";
      <?php
        }
      }
      ?>
      self.close();
  }
  </script>
  </head>
  <body>

    <form method="post" name="chkform" action="<?php $PHP_SELF ?>" title="check">
    <table>
      <tr>
        <td height="26" colspan="3" align="center" valign="middle">
        <?php
         if ($_POST['member_reg_no']=="" && $_POST['Validity'])
             echo "Please enter membership number";
         if ($_POST['member_reg_no'])
             echo $row->firm_name ? "Firm name :".$row->firm_name."<br>"."Address :".$row->address : 'There is no such Member' ;
        ?>
        </td>
      </tr>
      <tr>
        <td width="5%">&nbsp;</td>
              <td width="30%">
                 Member Reg No:
              </td>
              <td width="65%">
                 <input type="text" name="member_reg_no" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['member_reg_no']; ?>" />
        </td>
      </tr>
      <tr>
        <td width="5%">&nbsp;</td>
              <td width="30%">
                 Member Type:
              </td>
              <td width="65%">
                 <?php echo $list_member_type;?>
        </td>
      </tr>
      <tr>
        <td >&nbsp;</td>
           <td >&nbsp;

           </td>
           <td>
             <input type="submit" name="Validity" class="button" value="Check Availability"  />
             <input type="button" name="Close" class="button" value="Close" onclick="javascript:closewin();" />
        </td>
      </tr>
    </table>

    </form>
  </body>
  </html>
