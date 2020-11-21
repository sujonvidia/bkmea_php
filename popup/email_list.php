<?php
   include("../configuration.php");
   include("../includes/database.php");
   global $mosConfig_dbprefix,$mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db;
   $database=new database($mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db,$mosConfig_dbprefix);
   
   $query = "select * from #__templates_menu where menuid=0 and client_id=0";
   $database->setQuery($query);
   $res = $database->loadObjectList();
   $row = $res[0];
   
   if($_REQUEST['type']==1){
      $query="select others_email_address from #__v3_circular_circulation where id='".$_GET['id']."'";
   }else if($_REQUEST['type']==2){
      $query="select others_email_address from #__v3_trade_fair_circulation where id='".$_GET['id']."'";
   }else if($_REQUEST['type']==3){
      $query="select others_email_address from #__v3_trade_lead_circulation where id='".$_GET['id']."'";
   }
   $database->setQuery($query);
   $rows = $database->loadObjectList();
   $rows = explode(",",$rows[0]->others_email_address);
?>
<html>
<head>
<title>Camellia :: Circulation </title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/templates/<?php echo $row->template; ?>/css/template_css.css" />
</head>

<body>
<table class="adminform" width="100%">
  <tr>
   <td>
     <table width="100%" border="0" cellpadding="2" cellspacing="2" class="adminheading">
       <!--DWLayoutTable-->
       <tr>
        <th class="categories" align="left" width="100%">
        Circulation : <?php echo $_GET['title']; ?> <br><br>
        </th>
       </tr>
     </table>
     <table class="adminlist"  width="100%">
       <tr>
         <th width="10%" align="left" >
         Sl.
         </th>
         <th width="90%" align="left" >
         Email Address
         </th>
       </tr>
       <?php
       if(count($rows)){
         for($i=0;$i<count($rows);$i++)
         {
           $email = $rows[$i];
           if(trim($email)!=""){
       ?>
            <tr class="row<?php echo ($i%2); ?>">
              <td width="10%" align="left" >
              <?php echo ($i+1); ?>
              </td>
              <td width="90%" align="left" >
              <?php echo $rows[$i]; ?>
              </td>
            </tr>
       <?php
           }
         }
       }
       ?>
     </table>
    </td>
  </tr>
</table>
</body>
</html>
