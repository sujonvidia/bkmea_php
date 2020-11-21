    <?php
    require_once('../../../configuration.php');
    require_once('../../../includes/database.php');
    require_once('admin.hscode.class.php');
    global $mosConfig_dbprefix,$mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db;
    $database=new database($mosConfig_host,$mosConfig_user,$mosConfig_password,$mosConfig_db,$mosConfig_dbprefix);

    $task = $_REQUEST['task'];
    $member_id = $_REQUEST['member_id'];
    $id = $_REQUEST['id']; //product id
    $hscodeType =$_REQUEST['hscodeType'];
    $businessType = $_REQUEST['businessType'];
    $country = $_REQUEST['country'];

    ?>
    <html>

    <head>
      <title></title>
  <script language="javascript" type="text/javascript">
        var ret;
  <!--
  function validate(){
        var form=document.adminForm;
        if (form.elements['product_line_impoter_of'].value==0 && form.elements['txtHSCode'].value==""){
           alert('Please select a product');
           form.elements['product_line_impoter_of'].focus();
           return false;
        }
        return true;
  }
  //-->
  var arr = new Array();
                   arr[27] ="0";
                   arr[28] ="1";
                   arr[29] ="2";
                   arr[30] = "3";
                   arr[31] = "4";
                   arr[32] = "5";
                   arr[33] = "6";
                   arr[34] = "7";
                   arr[35] = "8";
                   arr[36] = "9";
                   arr[37] = ".";

                function check_IntNumber(obj,mid)
                {
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var form = document.adminForm;
                   var msg=mid;

                   str=form.elements[obj].value;

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 37; j++)
                      {
                        if(str.charAt(i) == arr[j])
                           break;
                      }
                      if(j>36)
                      {

                        alert(msg);
                        var temp = parseInt(str);
                        if(isNaN(temp))
                          form.elements[obj].value=0;
                        else
                          form.elements[obj].value=temp;
                        form.elements[obj].focus();
                        form.elements[obj].select();
                        break;
                      }
                   }
                }

function hsCodeProductName(name){

        if (confirm(name)){
           ret=1;
        }
        else{
           ret=0;
        }
        return ret;
}
</script>
  <link rel="stylesheet" href="../../templates/mambo_admin/css/template_css.css" type="text/css" />
<link rel="stylesheet" href="../../templates/mambo_admin/css/theme.css" type="text/css" />

</head>

    <body>
    <table width="70%" border="0" cellspacing="1" cellpadding="1" align="center">
         <tr height="25">
          <td width="100%"> &nbsp;</td>
         </tr>
         <tr>
          <td width="100%" align="center"><h5>HS-Code (Harmonized System Code)</h5></td>
         </tr>

    </table>


    <?php

    switch ($task) {

        default:
                showInformation($member_id,$id,$hscodeType,$businessType,$country );
                break;
    }

     function saveInformation($member_id=0,$id=0,$hscodeType=0,$businessType=0,$country=0){
        global $database;
        $action=Array();$temp=Array();
        if (intval($_POST['txtHSCode'])>0){
            $temp=& HSCode::parentHSCodeId($_POST['txtHSCode']);
            $impoter=$temp[0];
            if (!$impoter){
                $msg="Invalid HS-Code";
                $error=1;
            }
            else {
                $query1="Select name as name from #__product_line where id='".$impoter."'";
                    $query1  =  $database->replaceTablePrefix($query1);
                    $rows = @mysql_query($query1);
                $result=@mysql_fetch_object($rows);
                $hsCodeProductName=$result->name;
                $status="<script language='javascript' type='text/javascript'>hsCodeProductName('".$hsCodeProductName."');</script>";
                //echo $status;

            }
        }
        else{
            if (intval($_POST['sub_product_line_impoter_of'])==0)
                $impoter = $_POST['product_line_impoter_of'];
            if (intval($_POST['sub_product_line_impoter_of'])>0)
                $impoter = $_POST['sub_product_line_impoter_of'];
            if ($impoter==0){
                $msg="Invalid HS-Code";
                $error=1;
            }
        }

        if (intval($impoter)>0){

            $del="";
            $query="Select id from #__member_product_line where member_id='".$member_id."' and product_id='".$impoter."' and business_type='$businessType'";
            $query  =  $database->replaceTablePrefix($query);
            $res=mysql_query($query);
            $member_product_id=0;
            if(@mysql_num_rows($res)==0){
               /*if ($status==1){
                if ($id==0){
                    $query="insert into #__member_product_line values('','".$member_id."','".$impoter."','$businessType')";
                    $query  =  $database->replaceTablePrefix($query);
                    if(mysql_query($query)){
                       $action['new']=1;
                       $member_product_id=$database->insertid();
                    }
                    else{
                       $action['new']=0;
                       $member_product_id=0;
                    }

                }

                else if($id>0){

                    $query="select id as id from #__member_product_line where member_id=".$member_id." and product_id=".$id." and business_type='$businessType'";
                    $database->setQuery( $query );
                    $rows = $database->loadObjectList();

                    $query="update #__member_product_line set product_id=".$impoter." where member_id=".$member_id." and product_id=".$id." and business_type='$businessType'";
                    $query  =  $database->replaceTablePrefix($query);
                    if(mysql_query($query)){
                       $action['edit']=1;
                       $member_product_id=$rows[0]->id;
                    }
                    else{
                       $action['edit']=0;
                       $member_product_id=0;
                    }
                }
              }*/
              //else if (intval($_POST['txtHSCode'])==0){
                if ($id==0){
                    $query="insert into #__member_product_line values('','".$member_id."','".$impoter."','$businessType')";
                    $query  =  $database->replaceTablePrefix($query);
                    if(mysql_query($query)){
                       $action['new']=1;
                       $member_product_id=$database->insertid();
                    }
                    else{
                       $action['new']=0;
                       $member_product_id=0;
                    }

                }

                else if($id>0){

                    $query="select id as id from #__member_product_line where member_id=".$member_id." and product_id=".$id." and business_type='$businessType'";
                    $database->setQuery( $query );
                    $rows = $database->loadObjectList();

                    $query="update #__member_product_line set product_id=".$impoter." where member_id=".$member_id." and product_id=".$id." and business_type='$businessType'";
                    $query  =  $database->replaceTablePrefix($query);
                    if(mysql_query($query)){
                       $action['edit']=1;
                       $member_product_id=$rows[0]->id;
                    }
                    else{
                       $action['edit']=0;
                       $member_product_id=0;
                    }
                }
              }
             //}
             else if (@mysql_num_rows($res)>0){
                    $query="select id as id from #__member_product_line where member_id=".$member_id." and product_id=".$impoter." and business_type='$businessType'";
                    $database->setQuery( $query );
                    $rows = $database->loadObjectList();
                    $member_product_id=$rows[0]->id;
                    $action['exist']=1;
             }

             if (intval($member_product_id)>0){
                 $impoter_of_country = $_POST['product_line_impoter_of_country'];
                 $total=count($impoter_of_country);
                 if ($total>0 && $country==1){
                 $del="";
                    for ($i=0;$i<$total;$i++) {
                         $query="Select id from #__member_product_country where country_id='".$impoter_of_country[$i]."' and member_product_id='$member_product_id'";
                         $query  =  $database->replaceTablePrefix($query);
                         $res=mysql_query($query);
                         if(mysql_num_rows($res)==0){
                            $query="insert into #__member_product_country values('','".$impoter_of_country[$i]."','".$member_product_id."')";
                            $query  =  $database->replaceTablePrefix($query);
                            if(@mysql_query($query)){
                               $action['country']=1;
                               //$action['exist']=0;
                               if ($action['edit']==1)
                                       $action['edit']=1;
                            }
                            else{
                               $action['country']=0;
                            }
                         }
                         if (intval($action['country'])==1){
                             $del.=" and country_id!='".$impoter_of_country[$i]."'";
                         }
                         else{
                             break;
                         }
                    }
                    if (intval($action['country'])==1){
                        $action['exist']=0;
                            $query="delete from #__member_product_country where member_product_id='".$member_product_id."' ".$del;
                            $query  =  $database->replaceTablePrefix($query);
                            $res=@mysql_query($query);
                    }

                 }
                    if (intval($action['exist'])==1){
                       $msg="Business line information already exists";
                       $error=1;
                    }
                    else{
                       if (intval($action['new'])==1){
                          $msg="Business line information has been added successfully";
                       }
                       else if (intval($action['edit'])==1){
                          $msg="Business line information has been updated successfully";
                       }
                       else if (intval($action['country'])==1){
                          $msg="Country information has been updated successfully";
                          $error=1;
                       }
                       else if (intval($_POST['txtHSCode'])==0){
                          $msg="Invalid HS-Code";
                          $error=1;
                       }
                       else if (intval($action['new'])==0){
                          $msg="Business line information has not been added successfully";
                          $error=1;
                       }
                       else if (intval($action['edit'])==0){
                          $msg="Business line information has not been updated successfully";
                          $error=1;
                       }
                    }
             }

        }

        return $msg."__".$error;
    }
    // draw input form
    function showInformation( $member_id=0,$id=0,$hscodeType=0,$businessType=0,$country=0 ){
        global $mosConfig_db,$database;
        if (trim($_REQUEST['btnSubmitAdd'])){
            $tmp=saveInformation($member_id,$id,$hscodeType,$businessType,$country);
            $tmp=explode("__",$tmp);
            $msg=$tmp[0];
            $error=$tmp[1];
            if (intval($error)!=1)
                echo "<script language='javascript'>opener.document.location.reload();</script>";
        }

        if (trim($_REQUEST['btnSub'])){
           $selected=$_POST['product_line_impoter_of'];
        }
        else{
           $selected=$id;
        }
        //$parentHSCode=array();
        $parentHSCode=HSCode::parentHSCode($hscodeType);
        $parentHSCodeId=Array();
        $parentHSCodeId= & HSCode::parentHSCodeId($parentHSCode);
        $hsCodeList=HSCode::hsCodeList($parentHSCodeId,'product_line_impoter_of',$selected);

        //query of selected country

        $query="select mpc.country_id as country_id from #__member_product_country as mpc, #__member_product_line as mpl"
                ." where mpc.member_product_id=mpl.id and mpl.member_id='$member_id' and mpl.business_type='$businessType' and mpl.product_id=".$id;
        $query  =  $database->replaceTablePrefix($query);

        $res =mysql_query($query);
        $i=0;
        while($row=mysql_fetch_array($res)){
           $product_line_impoter_of_country[$i]=$row["country_id"];
           $i++;
        }
        $countryList=HSCode::MultiCountryList('product_line_impoter_of_country[]',$product_line_impoter_of_country);

        $query="select parent_id as parent_id from #__product_line where id=".$id;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        $parent_id=$rows[0]->parent_id;
        $sub_parent_id=Array();
        $sub_parent_id= & $rows[0]->parent_id;

        $query="select parent_id as parent_id from #__product_line where id=".$parent_id;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        $parent_id=$rows[0]->parent_id;

        $query="select parent_id as parent_id,hscode from #__product_line where id=".$parent_id;
        $database->setQuery( $query );
        $rows = $database->loadObjectList();
        $parent_id=$rows[0]->parent_id;
        $hscode=$rows[0]->hscode;

        if (trim($_REQUEST['btnSub'])){
           $sub_parent_id[0]= $_POST['product_line_impoter_of'];
           $hsSubCodeList=HSCode::hsCodeList($sub_parent_id,'sub_product_line_impoter_of',$id);
           $style="display:inline;";
        }
        else if ($parent_id>0 ){
           $hsCodeList="";
           $hsCodeList=HSCode::hsCodeList($parentHSCodeId,'product_line_impoter_of',$sub_parent_id);
           $hsSubCodeList=HSCode::hsCodeList($sub_parent_id,'sub_product_line_impoter_of',$id);
           $style="display:inline;";
        }
        else{
            $style="display:none;";
        }

          if (intval($id)==0){
             $caption=" Add ";
             if ( trim($_REQUEST['btnSubmitAdd'])!="" || trim($_REQUEST['caption'])=="Add More" ){
                $caption=" Add More ";
             }
          }
          else{
             $caption=" Update ";
          }

    ?>
        <form name="adminForm" method="post" action="<?php $PHP_SELF?>">
        <input type="hidden" name="member_id" value="<?php echo $member_id;?>">
        <input type="hidden" name="id" value="<?php echo $id;?>">
        <input type="hidden" name="hscodeType" value="<?php echo $hscodeType;?>">
        <input type="hidden" name="businessType" value="<?php echo $businessType;?>">
        <input type="hidden" name="country" value="<?php echo $country;?>">
        <input type="hidden" name="caption" value="<?php echo trim($caption);?>">

        <table width="70%" cellspacing="0" cellpadding="0" align="center">
         <tr>
          <td width="100%" align="center"><?php echo $msg;?></td>
         </tr>
         <tr>
          <td width="100%" align="center">

        <table width="100%"  style="border:1px #aaa000 solid;" cellspacing="6" cellpadding="0" align="center">
         <tr>
          <td width="30%" align="right"> HS-Code&nbsp;:&nbsp;&nbsp;</td>
          <td width="70%"><input type="text" name="txtHSCode" onKeyUp="javascript:check_IntNumber('txtHSCode','Enter valid HS-Code');"></td>
         </tr>
         <tr>
          <td width="30%" align="right"> Select Product&nbsp;:&nbsp;&nbsp;</td>
          <td width="70%"><?php echo $hsCodeList;?>&nbsp;<input type="Submit" name="btnSub" value="Find Sub" onClick="javascript:return validate();"></td>
         </tr>
         <tr id="findSub" style="<?php echo $style;?>">
          <td width="30%" align="right"> Select Sub-Product&nbsp;:&nbsp;&nbsp;</td>
          <td><?php echo $hsSubCodeList;?></td>
         </tr>
         <tr>
         <?php
         if ($country==1){
         ?>
          <td width="30%" align="right"> Select a Country&nbsp;:&nbsp;&nbsp;</td>
          <td><?php echo $countryList;?></td>
         </tr>
         <?php
         }
         ?>
         <tr>
          <td width="30%"> </td>
          <td>
          <input type="Submit" value="<?php echo $caption;?>" name="btnSubmitAdd" onClick="javascript:return validate();">&nbsp;
          <input type="Button" value=" Close " name="btnClose" onClick="javascript:self.close();"></td>
         </tr>
        </table>
        </td>
        </tr>
        </table>
        </form>
    <?php


    }

    ?>

    </body>

    </html>
