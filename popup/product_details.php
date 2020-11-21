<?php
include("../configuration.php");

              global $mosConfig_dbprefix;
       include("../pear/db.php");
       $query="select * from ".$mosConfig_dbprefix."docman where id='".$_GET['pid']."'";
       $dbconn->setFetchMode(DB_FETCHMODE_OBJECT);
       $res =& $dbconn->query($query);
       $row =& $res->fetchRow();

       if(trim($row->dmimage)!="" and file_exists("../dmdocuments/".$row->catid."/".$row->dmimage)){
          $product_image="../dmdocuments/".$row->catid."/".$row->dmimage;
       }
       else
          $product_image="../dmdocuments/img_na.jpg";

?>
<html>
<head>
<title><?php echo $mosConfig_sitename." - Product Details"; ?></title>
<link href="../templates/JavaBean/css/template_css.css" type="text/css" rel=stylesheet>
<script language="javascript">
 function closewin(){
      self.close();
 }
</script>
</head>
<body class="greybg">

<table width="407">
  <!--DWLayoutTable-->
   <tr height="10">
     <td width="1" height="11"></td>
     <td width="121" rowspan="5" valign="top"> <img border="1" src="<?php echo $product_image; ?>" width="120" height="120"> </td>
      <td width="1"></td>
      <td width="254"></td>
     <td width="1"></td>
   </tr>
   <tr height="10">
     <td height="25"></td>
     <td></td>
     <td valign="top"><strong>Title :</strong> <?php echo $row->dmname;?> </td>
     <td></td>
   </tr>
   <tr height="10">
     <td height="25"></td>
     <td></td>
     <td valign="top"><strong>Price for Member : </strong>Tk <?php echo ($row->price_for_member==intval($row->price_for_member)?$row->price_for_member.".00":round($row->price_for_member,2));?> </td>
     <td></td>
   </tr>
   <tr height="10">
     <td height="31"></td>
     <td></td>
     <td valign="top"><strong>Price for Non-Member : </strong> Tk <?php echo ($row->price_for_non_member==intval($row->price_for_non_member)?$row->price_for_non_member.".00":round($row->price_for_non_member,2));?> </td>
     <td></td>
   </tr>
   <tr height="10">
     <td height="24"></td>
     <td></td>
     <td>&nbsp;</td>
     <td></td>
   </tr>
   <tr>
     <td height="130" ></td>
     <td colspan="4" valign="top" ><strong>Abstract :</strong> <?php echo $row->dmdescription;?> </td>
   </tr>
   <tr>
     <td height="22" ></td>
     <td  colspan="4" align="center" valign="top" >
       <input type="button" class="button" value="Close" onClick="self.close();">          </td>
   </tr>
   <tr>
     <td height="7" ></td>
     <td ></td>
     <td ></td>
     <td ></td>
     <td ></td>
   </tr>
</table>


</body>
</html>
