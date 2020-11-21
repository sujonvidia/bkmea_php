  <?php
  include("../configuration.php");
  include("../pear/db.php");
  global $mosConfig_dbprefix,$dbconn;

  if ($_POST['Validity']){
     if (intval($_REQUEST['member_type'])>0){
        $memberType=" and m.type_id='".intval($_REQUEST['member_type'])."'";
     }
     else
         $memberType="";

  if (!empty($_REQUEST['reg_no']))
       $search_by=" and mh.member_reg_no ='".$_POST['member_reg_no']."'";
  else if (!empty($_REQUEST['tin']))
       $search_by=" and m.tin ='".$_POST['member_reg_no']."'";
  else
      $search_by="";
     //$query="select Firm_name as fir from mos_users where username='".$name."'";
     $query="select * from ".$mosConfig_dbprefix."member as m LEFT JOIN ".$mosConfig_dbprefix."member_history as mh"
             ."\n ON m.id=mh.member_id where mh.reg_year_id ='".$_REQUEST['reg_year_id']
             ."' ". $search_by
             ." and m.is_delete='0'".$memberType
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
      if ($row1->id==$_REQUEST['member_type'])
          $list_member_type.="<option value='$row1->id' selected>$row1->name</option>";
      else
          $list_member_type.="<option value='$row1->id'>$row1->name</option>";
  }
  $list_member_type.="</select>";
  ?>
  <html>
  <head>
  <title><?php echo $mosConfig_sitename." - Check Proposer"; ?></title>
  <link href="../templates/JavaBean/css/template_css.css" type="text/css" rel=stylesheet>
  <script language="javascript">
  function validate(){
    if (document.chkform.member_reg_no.value==""){
        alert('Please enter membership number or tin number.');
        return false;
    }
    else if (document.chkform.reg_no.checked==true && document.chkform.tin.checked==true){
        alert('Please select any one.');
        return false;
    }

    else if (document.chkform.reg_no.checked==false && document.chkform.tin.checked==false){
        alert('Please select membership number or tin number.');
        return false;
    }
   else if ( document.chkform.member_type.value==0 && document.chkform.reg_no.checked==true){
        alert('Please select member type.');
        return false;
   }
    return true;
  }

  function closewin(){
      <?php
      if ($_GET['from']==1) {
         if ($row->firm_name) {
      ?>
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_1_title.value="<?php echo $row->applicant_title; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_1_firm_name.value="<?php echo $row->firm_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_1_name.value="<?php echo $row->applicant_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_1_last_name.value="<?php echo $row->applicant_last_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_1_designation.value="<?php echo $row->applicant_designation; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].popup.value="1";
             opener.document.forms[<?php echo $_GET['formid']; ?>].popup_type_id.value="<?php echo $_REQUEST['member_type']; ?>";
      <?php
        }
      }
      else if ($_GET['from']==2){
         if ($row->firm_name) {
      ?>
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_2_title.value="<?php echo $row->applicant_title; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_2_firm_name.value="<?php echo $row->firm_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_2_name.value="<?php echo $row->applicant_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_2_last_name.value="<?php echo $row->applicant_last_name; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].proposer_2_designation.value="<?php echo $row->applicant_designation; ?>";
             opener.document.forms[<?php echo $_GET['formid']; ?>].popup.value="2";
             opener.document.forms[<?php echo $_GET['formid']; ?>].popup_type_id.value="<?php echo $_REQUEST['member_type']; ?>";
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
        /*
         if ($_POST['member_reg_no']=="" && $_POST['Validity'])
             echo "Please enter membership number";
         */
         if (isset($_POST['member_reg_no']))
             echo $row->firm_name ? "Firm name :".$row->firm_name : 'There is no such Member' ;
        ?>
        </td>
      </tr>
      <tr>
        <td width="5%">&nbsp;</td>
              <td width="30%" align="right">
                 Search By&nbsp;:
              </td>
              <td width="65%">
                 <input type="text" name="member_reg_no" class="inputbox" size="30" maxlength="50" value= "<?php echo $_POST['member_reg_no']; ?>" />
        </td>
      </tr>
      <tr>
        <td width="5%">&nbsp;</td>
              <td width="30%" align="right">
                 in&nbsp;:
              </td>
              <td width="65%">
                 <input type="checkbox" name="reg_no" />&nbsp;Membership Number&nbsp;
                 <input type="checkbox" name="tin"  />&nbsp;Tin Number
        </td>
      </tr>
      <tr>
        <td width="5%">&nbsp;</td>
              <td width="30%" align="right">
                 Member Type&nbsp;:
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
             <input type="submit" name="Validity" class="button" value="Check Availability" onclick="javascript:return validate();" />
             <input type="button" name="Close" class="button" value="Close" onclick="javascript:closewin();" />
        </td>
      </tr>
    </table>

    </form>
  </body>
  </html>
