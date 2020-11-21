  <?php
  include("../configuration.php");
  include("../pear/db.php");
  global $mosConfig_dbprefix,$dbconn;

  //if ($_POST['Validity']){
     if (intval($_REQUEST['member_type'])>0){
        $memberType=" and m.type_id='".intval($_REQUEST['member_type'])."'";
     }
     else
         $memberType="";
     //$query="select Firm_name as fir from mos_users where username='".$name."'";
     $query="select * from ".$mosConfig_dbprefix."member as m LEFT JOIN ".$mosConfig_dbprefix."member_history as mh"
             ."\n ON m.id=mh.member_id where mh.reg_year_id ='".$_REQUEST['reg_year_id']
             ."' and mh.member_reg_no ='".$_POST['member_reg_no']
             ."' and m.is_delete='0'".$memberType
            ;
     $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
     $res =& $dbconn->query($query);
     $row =& $res->fetchRow();
     $address=$row->firm_reg_address_street;
     $address.=trim($row->firm_reg_address_town_suburb)!=""? ", ".$row->firm_reg_address_town_suburb:"";
     $address.=trim($row->firm_reg_address_district)!=""? ", ".$row->firm_reg_address_district:"";
     $address.=trim($row->firm_reg_address_division)!=""? ", ".$row->firm_reg_address_division:"";
     $address.=trim($row->firm_reg_address_country)!=""? ", ".$row->firm_reg_address_country:"";
  //}
  ?>
  <html>
  <head>
  <title><?php echo $mosConfig_sitename." - Check Proposer"; ?></title>
  <link href="../templates/JavaBean/css/template_css.css" type="text/css" rel=stylesheet>
  <script language="javascript">

  function closewin(){
      <?php
      if ($_GET['from']==1) {
         if ($row->firm_name) {
      ?>
             opener.document.<?php echo $_GET['formName']; ?>.proposer1_title.value="<?php echo $row->applicant_title; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer1_firm_name.value="<?php echo $row->firm_name; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer1_name.value="<?php echo $row->applicant_name; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer1_last_name.value="<?php echo $row->applicant_last_name; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer1_address.value="<?php echo $address; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer1_member_reg_no.value="<?php echo $row->member_reg_no; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.popup.value="1";
             opener.document.<?php echo $_GET['formName']; ?>.popup_type_id.value="<?php echo $_REQUEST['member_type']; ?>";
      <?php
        }
      }
      else if ($_GET['from']==2){
         if ($row->firm_name) {
      ?>
             opener.document.<?php echo $_GET['formName']; ?>.proposer2_title.value="<?php echo $row->applicant_title; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer2_firm_name.value="<?php echo $row->firm_name; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer2_name.value="<?php echo $row->applicant_name; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer2_last_name.value="<?php echo $row->applicant_last_name; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer2_address.value="<?php echo $address; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.proposer2_member_reg_no.value="<?php echo $row->member_reg_no; ?>";
             opener.document.<?php echo $_GET['formName']; ?>.popup.value="2";
             opener.document.<?php echo $_GET['formName']; ?>.popup_type_id.value="<?php echo $_REQUEST['member_type']; ?>";
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
             echo $row->firm_name ? "Firm name :".$row->firm_name : 'There is no such Member' ;
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
