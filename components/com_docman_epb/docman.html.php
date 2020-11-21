<?php

/*
* DOCMan 1.3.0 for Mambo 4.5.1 CMS
* @version $Id: docman.html.php,v 1.67 2006/06/21 09:40:02 morshed Exp $
* @package DOCMan_1.3.0
* @copyright (C) 2003 - 2005 The DOCMan Development Team
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Oficial website: http://www.mambodocman.com/
*/

defined('_VALID_MOS') or die('Direct access to this location is not allowed.');

if (defined('_DOCMAN_HTML')) {
    return;
} else {
    define('_DOCMAN_HTML', 1);
}

class HTML_docman
{
    function pageMsgBox($msg)
    {
        global $_DOCMAN;

        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assign('msg', $msg);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_msgbox.tpl.php');
    }

    function pageDocman(&$html)
    {
        global $_DOCMAN;

        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html', $html);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docbrowse.tpl.php');
    }

    function pageDocument(&$html)
    {
        global $_DOCMAN;

        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html' , $html);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docdetails.tpl.php');
    }

    function purchase_step1($pid,$directorytype,$member_price,$nonmember_price)
    {
        global $_DOCMAN;
        global $search_criteria;
        ?>
        <table width="100%" cellspacing="0" >
           <tr>
             <td >
             <b>Choose Customer</b>
             </td>
           </tr>
           <tr>
             <td >

             <ul>
             <?php ?>
             <li><a href="index.php?option=com_docman&task=doc_purchase&step=2&pid=<?php echo $pid; ?>&customer=new&directorytype=<?php echo $directorytype;?>&nonmember_price=<?php echo $nonmember_price;?>&search_criteria=<?php echo $search_criteria;?>">New Customer</a></li>
             <li><a href="index.php?option=com_docman&task=doc_purchase&step=2&pid=<?php echo $pid; ?>&customer=ext&directorytype=<?php echo $directorytype;?>&member_price=<?php echo $member_price;?>&search_criteria=<?php echo $search_criteria;?>">Existing Customer</a></li>
             <li><a href="index.php?option=com_docman&task=doc_purchase&step=2&pid=<?php echo $pid; ?>&customer=mem&directorytype=<?php echo $directorytype;?>&member_price=<?php echo $member_price;?>&search_criteria=<?php echo $search_criteria;?>">Member</a></li>
             <li><a href="index.php?option=com_docman&task=doc_purchase&step=2&pid=<?php echo $pid; ?>&customer=off&directorytype=<?php echo $directorytype;?>&member_price=<?php echo $member_price;?>&search_criteria=<?php echo $search_criteria;?>">Office Use</a></li>
             </ul>
             </td>
           </tr>
           <tr>
             <td >
              <dl>
              <dd class="dm_taskbar">
              <ul>
               <li><a class="btn" href="index.php">Cancel</a></li>
               <li><a class="btn" href="javascript: history.go(-1);">Back</a></li>
              </ul>
              </dd>
              </dl>
             </td>
           </tr>
        </table>
        <?php
    }

    function purchase_step2_newCustomer($pid,&$lists,$directorytype,$member_price,$nonmember_price)
    {
        global $_DOCMAN;
        global $search_criteria;
        ?>
        <script language="javascript" type="text/javascript">
            function echeck(str) {

                var at="@";
                var dot=".";
                var lat=str.indexOf(at);
                var lstr=str.length;
                var ldot=str.indexOf(dot);

                if (str.indexOf(at)==-1){
                   alert("Invalid e-mail id");
                   return false;
                }

                else if (str.indexOf(at)==-1 || str.indexOf(at)==0 || str.indexOf(at)==lstr){
                   alert("Invalid e-mail id");
                   return false;
                }

                else if (str.indexOf(dot)==-1 || str.indexOf(dot)==0 || str.indexOf(dot)==lstr){
                    alert("Invalid e-mail id");
                    return false;
                }

                 else if (str.indexOf(at,(lat+1))!=-1){
                    alert("Invalid e-mail id");
                    return false;
                 }

                 else if (str.substring(lat-1,lat)==dot || str.substring(lat+1,lat+2)==dot){
                    alert("Invalid e-mail id");
                    return false;
                 }

                 else if (str.indexOf(dot,(lat+2))==-1){
                    alert("Invalid e-mail id");
                    return false;
                 }

                 else if (str.indexOf(" ")!=-1){
                    alert("Invalid e-mail id");
                    return false;
                 }

        }
            function validate() {

               var form = document.userForm;
               if(form.firm_name.value == ""){
                  alert("Please enter name of the firm.");
                  form.firm_name.focus();
                  return false;
               }
               else if(form.name.value == ""){
                  alert("Please enter first name of the customer.");
                  form.name.focus();
                  return false;
               }
               else if(form.address.value == ""){
                  alert("Please enter customer address");
                  form.address.focus();
                  return false;
               }
               else if (form.email.value != "" && echeck(form.email.value)==false){
                  form.email.focus();
                  return false;
               }
               else{
                  return true;
               }
            }
         </script>
        <form action="index.php" method="post" name="userForm" id="adminForm" >
        <table width="100%" cellspacing="5" >
           <tr>
             <td colspan=2>
             <b>Enter Customer Information</b>
             </td>
           </tr>
           <tr width=100%>
               <td align="left">
               Name of the Firm :*
               </td>
               <td >
               <input class="text_area" type="text" name="firm_name" size="54" maxlength="150"  />
               </td>
          </tr>
           <tr width=100%>
               <td width="25%" align="left">
               [Customer Name] Title :
               </td>
               <td width="75%">
               <?php echo $lists['title'];  ?>

               </td>
          </tr>
          <tr width=100%>
               <td width="25%" align="left">
               First Name :*
               </td>
               <td  width="75%">
               <input class="text_area" type="text" name="name" size="20" maxlength="50" />
              </td>
          </tr>
          <tr width=100%>
               <td width="25%" align="left">
               Last Name :
               </td>
               <td  width="75%">
               <input class="text_area" type="text" name="last_name" size="20" maxlength="50" />
               </td>
          </tr>

           <tr width=100%>
               <td align="left">
               Address :*
               </td>
               <td >
                <input class="text_area" type="text" name="address" size="54" maxlength="255"  />
               </td>
          </tr>
           <tr width=100%>
               <td align="left">
               Country :
               </td>
               <td >
               <?php echo $lists['country'];  ?>
               </td>
          </tr>
           <tr width=100%>
               <td align="left">
               Phone :
               </td>
               <td >
                <input class="text_area" type="text" name="phone" size="54" maxlength="50"  />
               </td>
          </tr>
           <tr width=100%>
               <td align="left">
               Mobile :
               </td>
               <td >
               <input class="text_area" type="text" name="mobile" size="54" maxlength="50"  />
               </td>
          </tr>
           <tr width=100%>
               <td align="left">
               Email :
               </td>
               <td >
               <input class="text_area" type="text" name="email" size="54" maxlength="150"  />
               </td>
          </tr>
           <tr width=100% >
               <td height="5" >
               </td>
               <td >

               </td>
          </tr>


           <tr>
             <td>
             </td>
             <td >
             <input type="hidden" name="option" value="com_docman">
             <input type="hidden" name="task" value="doc_purchase">
             <input type="hidden" name="step" value="3">
             <input type="hidden" name="search_criteria" value="<?php echo $search_criteria; ?>">
             <input type="hidden" name="pid" value="<?php echo $pid; ?>">
             <input type="hidden" name="customer" value="new">
             <input type="hidden" name="directorytype" value="<?php echo $directorytype; ?>">
             <input type="hidden" name="member_price" value="<?php echo $member_price; ?>">
             <input type="hidden" name="nonmember_price" value="<?php echo $nonmember_price; ?>">
             <input class="button" type="submit" name="submit" value="Submit" onClick="return validate();">
             <input class="button" type="button" name="cancel" value="Cancel"  onclick="javascript: location.href='index.php';">
             <input class="button" type="button" name="back" value="Back" onclick="javascript: history.go(-1);">

             </td>
           </tr>
        </table>
        </form>
        <?php
    }

    function purchase_step2_existingCustomer($pid,&$lists,$directorytype,$member_price,$nonmember_price)
    {
        global $_DOCMAN;
        global $search_criteria;
        ?>
        <script language="javascript" type="text/javascript">
           var newWin;
                function newwindow(){
                      if (null != newWin && !newWin.closed)
                         closeNewWindow();
                      page='./popup/checkExistingCustomer.php?formName=userForm';
                      window.open(page,'','width=900,height=400,scrollbars=yes,resizable=no,top=150,left=60,status=no,menubar=no,directories=no,location=no,toolbar=no');
                      //newWin.focus();
               }
            function validate() {

               var form = document.userForm;
               if(form.customer_id.value == ""){
                  alert("Please enter the customer id");
                  form.customer_id.focus();
                  return false;
               }
               else{
                  return true;
               }
            }
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
                   var form = document.userForm;
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
         </script>
        <form action="index.php" method="post" name="userForm" id="adminForm" >
        <table width="100%" cellspacing="0" >
           <tr>
             <td colspan=2>
             <b>Existing Customer Information</b>
             </td>
           </tr>
           <tr width=100%>
               <td   width="20%">
               * Customer ID :
               </td>
               <td  width="80%">
               <input type="text" name="customer_id" size="25" maxlength="11" onKeyUp="javascript:check_IntNumber('customer_id','Enter valid customer id.');" />
               <a href="javascript:newwindow();" style="text-decoration:underline;" onMouseOver="javascript:window.status='Search Customer';return true"> Search Customer</a>
               </td>
          </tr>

          <!--tr>
        <td></td>
       <td>
          <input type="button" name="Validity" class="button" value="Search Customer" onclick=javascript:window.open('./popup/checkExistingCustomer.php?formid=1','','width=900,height=400,scrollbars=yes,resizable=no,top=150,left=60,status=no,menubar=no,directories=no,location=no,toolbar=no'); />
       </td>
    </tr-->
           <tr width=100% >
               <td height="5" >
               </td>
               <td >

               </td>
          </tr>
           <tr>
             <td>
             </td>
             <td >
             <input type=hidden name=pid value="<?php echo $pid; ?>">
             <input type=hidden name=step value="3">
             <input type=hidden name=option value="com_docman">
             <input type=hidden name=task value="doc_purchase">
             <input type="hidden" name="search_criteria" value="<?php echo $search_criteria; ?>">
             <input type="hidden" name="customer" value="ext">
             <input type="hidden" name="directorytype" value="<?php echo $directorytype; ?>">
             <input type="hidden" name="member_price" value="<?php echo $member_price; ?>">
             <input type="hidden" name="nonmember_price" value="<?php echo $nonmember_price; ?>">
             <input class="button" type=submit name=submit value="Submit" onClick="return validate();">
             <input class="button" type=button name=cancel value="Cancel"  onclick="javascript: location.href='index.php';">
             <input class="button" type=button name=Back value="Back" onclick="javascript: history.go(-1);">

             </td>
           </tr>
        </table>
        </form>
        <?php
    }

    function purchase_step2_member($pid,&$lists,$directorytype,$member_price,$nonmember_price)
    {
        global $_DOCMAN,$mosConfig_owner;
         global $search_criteria;

        ?>
        <script language="javascript" type="text/javascript">

                var newWin;
                var mosConfig_owner='<?php echo trim(strtolower($mosConfig_owner));?>';
                function newwindow(){
                      if (null != newWin && !newWin.closed)
                         closeNewWindow();
                         var form = document.userForm;
                         var working_reg_year_id="<?php echo $_SESSION['working_reg_year_id'];?>";
                         if (mosConfig_owner=="scci" || mosConfig_owner=="ccci")
                             var type_id=form.type_id.value;
                      page='./popup/checkMemberRegistrationNo.php?formName=userForm&working_reg_year_id='+working_reg_year_id+'&type_id='+type_id;
                      window.open(page,'','width=800,height=400,scrollbars=yes,resizable=no,top=180,left=150,status=no,menubar=no,directories=no,location=no,toolbar=no');
                      //newWin.focus();
               }
               function validate() {
               var form = document.userForm;
               if(form.member_reg_no.value == ""){
                  alert("Please enter the member id.");
                  form.member_reg_no.focus();
                  return false;
               }
               else{
                  return true;
               }
            }
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
                   var form = document.userForm;
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
        </script>
        <form action="index.php" method="post" name="userForm" id="adminForm" >
        <table width="100%" cellspacing="0" >
           <tr>
             <td colspan=2>
             <b>Member Information</b>
             </td>
           </tr>
           <tr width=100%>
               <td   width="25%">
               * Member Id :
               </td>
               <td  width="75%">
               <input type="text" name="member_reg_no" size="25" maxlength="11" onKeyUp="javascript:check_IntNumber('member_reg_no','Enter valid member id.');" />
               <a href="javascript:newwindow();" style="text-decoration:underline;" onMouseOver="javascript:window.status='Search Member';return true" > Search Member</a>
               </td>
           </tr>
           <tr width=100% >
               <td height="5" >
               </td>
               <td >

               </td>
          </tr>
           <tr>
             <td>
             </td>
             <td >
             <input type=hidden name=pid value="<?php echo $pid; ?>">
             <input type=hidden name=step value="3">
             <input type=hidden name=option value="com_docman">
             <input type=hidden name=task value="doc_purchase">
             <input type="hidden" name="customer" value="mem">
             <input type="hidden" name="search_criteria" value="<?php echo $search_criteria; ?>">
             <input type="hidden" name="directorytype" value="<?php echo $directorytype; ?>">
             <input type="hidden" name="member_price" value="<?php echo $member_price; ?>">
             <input type="hidden" name="nonmember_price" value="<?php echo $nonmember_price; ?>">
             <input class="button" type=submit name=submit value="Submit" onClick="return validate();">
             <input class="button" type=button name=cancel value="Cancel"  onclick="javascript: location.href='index.php';">
             <input class="button" type=button name=Back value="Back" onclick="javascript: history.go(-1);">

             </td>
           </tr>
        </table>
        </form>
        <?php
    }

    function purchase_step3($pid,$customer,&$rows,$directorytype,$member_price,$nonmember_price)
    {
        global $_DOCMAN;

        global $search_criteria;

        if (count($rows)>0){
            $row=& $rows[0];
            if (strtolower(trim($customer))=="new"){
                $price=$row->price_for_non_member==intval($row->price_for_non_member)?$row->price_for_non_member.".00":round($row->price_for_non_member,2);
            }
            else{
                $price=$row->price_for_member==intval($row->price_for_member)?$row->price_for_member.".00":round($row->price_for_member,2);
            }
        }
        else{
             if (strtolower(trim($customer))=="new"){
                $price=$nonmember_price==intval($nonmember_price)?$nonmember_price.".00":round($nonmember_price,2);
            }
            else{
                $price=$member_price==intval($member_price)?$member_price.".00":round($member_price,2);
            }

        }
        ?>
        <script language="javascript" type="text/javascript">

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
            function check_FloatNumber(obj,mid){
                   var i=0,j=0;
                   var str="";
                   var c=0;
                   var che=0;
                   var form = document.userForm;
                   var msg1="Please enter valid amount";
                   var msg2="";
                   var msg="";
                  if(mid==1)
                     msg=msg1;
                   else
                     msg=msg2;
                   str=form.elements[obj].value;
                   if (str>100){
                       alert('You can not enter discount greater than 100 %');
                       form.elements[obj].value=parseFloat(str);
                       form.elements[obj].focus();
                       form.elements[obj].select();
                   }

                   for(i = 0 ; i < str.length; i++)
                   {
                      for(j = 27 ; j < 38; j++)
                      {
                         if(str.charAt(i) == arr[j]){
                          if ((str.charAt(i)==".")&& (che==0))
                          {
                                  che=1;
                          }
                          else if ((str.charAt(i)==".")&& (che==1))
                          {
                              alert(msg);
                              form.elements[obj].focus();
                              form.elements[obj].select();

                          }
                           break;
                        }

                      }
                      if(j>37)
                      {

                        alert(msg);
                        var temp = parseFloat(str);
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

            function submitbutton() {

               var form = document.userForm;

               if(form.discount.value != "" && form.discount_note.value == ""){
                  alert("Please enter the discount note");
                  form.discount_note.focus();
                  return false;
               }
               else{
                  return true;
               }
            }
         </script>

        <form action="index.php" method="post" name="userForm" id="adminForm" >
        <?php
        if (strtolower(trim($customer))=="new"){
        ?>
            <input type="hidden" name="title" value="<?php echo $_SESSION['title'];?>" />
            <input type="hidden" name="name" value="<?php echo $_SESSION['name'];?>" />
            <input type="hidden" name="last_name" value="<?php echo $_SESSION['last_name'];?>" />
            <input type="hidden" name="firm_name" value="<?php echo $_SESSION['firm_name'];?>" />
            <input type="hidden" name="address" value="<?php echo $_SESSION['address'];?>" />
            <input type="hidden" name="country" value="<?php echo $_SESSION['country'];?>" />
            <input type="hidden" name="phone" value="<?php echo $_SESSION['phone'];?>" />
            <input type="hidden" name="mobile" value="<?php echo $_SESSION['mobile'];?>" />
            <input type="hidden" name="email" value="<?php echo $_SESSION['email'];?>" />
        <?php
        }
        elseif (strtolower(trim($customer))=="ext"){
        ?>
           <input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id'];?>" />
        <?php
        }
        elseif (strtolower(trim($customer))=="mem"){
        ?>
            <input type="hidden" name="membership_id" value="<?php echo $_SESSION['membership_id'];?>" />
            <input type="hidden" name="title" value="<?php echo $_SESSION['title'];?>" />
            <input type="hidden" name="name" value="<?php echo $_SESSION['name'];?>" />
            <input type="hidden" name="last_name" value="<?php echo $_SESSION['last_name'];?>" />
            <input type="hidden" name="firm_name" value="<?php echo $_SESSION['firm_name'];?>" />
            <input type="hidden" name="address" value="<?php echo $_SESSION['address'];?>" />
            <input type="hidden" name="country" value="<?php echo $_SESSION['country'];?>" />
            <input type="hidden" name="phone" value="<?php echo $_SESSION['phone'];?>" />
            <input type="hidden" name="mobile" value="<?php echo $_SESSION['mobile'];?>" />
            <input type="hidden" name="email" value="<?php echo $_SESSION['email'];?>" />

           <!--input type="hidden" name="member_reg_no" value="<?php echo $_SESSION['member_reg_no'];?>" />
           <input type="hidden" name="firm_name" value="<?php echo $_SESSION['firm_name'];?>" /-->
        <?php
        }

        ?>
        <table width="100%" cellspacing="0" >
           <tr>
             <td colspan=2>
             <b>Discount</b>
             </td>
           </tr>
           <tr width=100%>
               <td   width="20%">
               Trade Lead Price :
               </td>
               <td  width="80%">
               <?php echo "Tk. ".$price?>
               <input type="hidden" name="product_price" value="<?php echo $price;?>" />
               <input type="hidden" name="product_name" value="<?php echo $row->dmname;?>" />
               <input type="hidden" name="product_file_name" value="<?php echo $row->dmfilename;?>" />
               </td>
          </tr>
           <tr width=100%>
               <td   width="20%">
               Discount :
               </td>
               <td  width="80%">
               <?php

                    if (strtolower(trim($customer))=="off"){
               ?>
                        <input type="text" name="discount" size="25" maxlength="10" value="100" readonly /> %
               <?php
                    }
                    else{
               ?>
                         <input type="text" name="discount" size="25" maxlength="10" onKeyUp="javascript:check_FloatNumber('discount',1);" /> %
               <?php
                    }
               ?>
               </td>
          </tr>
           <tr width=100%>
               <td   width="20%" valign="top">
               Discount Note :
               </td>
               <td  width="80%">
               <?php
               editorArea( 'discount_note',  '' , 'discount_note', '80%;', '100', '60', '20' ) ;
               ?>
               </td>
          </tr>
           <tr width=100% >
               <td height="5" >
               </td>
               <td >

               </td>
          </tr>
           <tr>
             <td>
             </td>
             <td >
             <input type=hidden name=pid value="<?php echo $pid; ?>">
             <input type=hidden name=step value="4">
             <input type=hidden name=option value="com_docman">
             <input type=hidden name=task value="doc_purchase">
             <input type=hidden name="search_criteria" value="<?php echo $search_criteria; ?>">
             <input type=hidden name="customer" value="<?php echo $customer; ?>">
             <input type="hidden" name="directorytype" value="<?php echo $directorytype; ?>">
             <input type="hidden" name="member_price" value="<?php echo $member_price; ?>">
             <input type="hidden" name="nonmember_price" value="<?php echo $nonmember_price; ?>">
             <input class="button" type=submit name=submit value="Submit" onClick="return submitbutton();">
             <input class="button" type=button name=cancel value="Cancel"  onclick="javascript: location.href='index.php';">
             <input class="button" type=button name=Back value="Back" onclick="javascript: history.go(-1);">
             </td>
           </tr>
        </table>
        </form>
        <?php
    }

    function purchase_step4($pid,$customer,$directorytype,$member_price,$nonmember_price)
    {
        global $_DOCMAN, $mosConfig_live_site, $mosconfig_show_date_format,$mosconfig_calender_date_format;
        global $search_criteria;
        ?>

        <script language="javascript" type="text/javascript">

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
                   var form = document.userForm;
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
                function createPdf(){

                      status = 'status=no,toolbar=no,scrollbars=yes,titlebar=no,menubar=no,resizable=yes,width=640,height=480,directories=no,location=no';
                      link = '<?php echo $mosConfig_live_site; ?>'+'/index2.php?option=com_docman&amp;do_pdf=1&amp;report_for=bkmea';
                      window.open(link, 'win2', status);

                }
                var newWin;
                function newwindow(){
                      if (null != newWin && !newWin.closed)
                         closeNewWindow();
                      page='./popup/moneyReceipt_popup.php?money_receipt_no='+document.userForm.money_receipt_no.value+'&formName=userForm';
                      window.open(page,'','width=425,height=130,scrollbars=yes,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                      //newWin.focus();
               }
               function submitbutton() {

               var form = document.userForm;

               if(form.money_receipt_no.value == ""){
                  alert("Please enter the money receipt number");
                  form.money_receipt_no.focus();
                  return false;
               }
               else if(form.money_receipt_date.value == ""){
                  alert("Please enter the money receipt date");
                  form.money_receipt_date.focus();
                  return false;
               }
               else{
                  return true;
               }
            }
        </script>

        <form action="index.php" method="post" name="userForm" id="adminForm">
        <?php
        if (strtolower(trim($customer))=="new"){
        ?>
            <input type="hidden" name="title" value="<?php echo $_SESSION['title'];?>" />
            <input type="hidden" name="name" value="<?php echo $_SESSION['name'];?>" />
            <input type="hidden" name="last_name" value="<?php echo $_SESSION['last_name'];?>" />
            <input type="hidden" name="firm_name" value="<?php echo $_SESSION['firm_name'];?>" />
            <input type="hidden" name="address" value="<?php echo $_SESSION['address'];?>" />
            <input type="hidden" name="country" value="<?php echo $_SESSION['country'];?>" />
            <input type="hidden" name="phone" value="<?php echo $_SESSION['phone'];?>" />
            <input type="hidden" name="mobile" value="<?php echo $_SESSION['mobile'];?>" />
            <input type="hidden" name="email" value="<?php echo $_SESSION['email'];?>" />
        <?php
        }
        elseif (strtolower(trim($customer))=="ext"){
        ?>
           <input type="hidden" name="customer_id" value="<?php echo $_SESSION['customer_id'];?>" />
        <?php
        }
        elseif (strtolower(trim($customer))=="mem"){
        ?>
            <input type="hidden" name="membership_id" value="<?php echo $_SESSION['membership_id'];?>" />
            <input type="hidden" name="title" value="<?php echo $_SESSION['title'];?>" />
            <input type="hidden" name="name" value="<?php echo $_SESSION['name'];?>" />
            <input type="hidden" name="last_name" value="<?php echo $_SESSION['last_name'];?>" />
            <input type="hidden" name="firm_name" value="<?php echo $_SESSION['firm_name'];?>" />
            <input type="hidden" name="address" value="<?php echo $_SESSION['address'];?>" />
            <input type="hidden" name="country" value="<?php echo $_SESSION['country'];?>" />
            <input type="hidden" name="phone" value="<?php echo $_SESSION['phone'];?>" />
            <input type="hidden" name="mobile" value="<?php echo $_SESSION['mobile'];?>" />
            <input type="hidden" name="email" value="<?php echo $_SESSION['email'];?>" />

           <!--input type="hidden" name="member_reg_no" value="<?php echo $_SESSION['member_reg_no'];?>" />
           <input type="hidden" name="firm_name" value="<?php echo $_SESSION['firm_name'];?>" /-->

        <?php
        }

        ?>
        <input type="hidden" name="product_price" value="<?php echo $_SESSION['product_price'];?>" />
        <input type="hidden" name="product_name" value="<?php echo $_SESSION['product_name'];?>" />
        <input type="hidden" name="product_file_name" value="<?php echo $_SESSION['product_file_name'];?>" />

        <table width="100%" cellspacing="0" >
           <tr>
             <td colspan=2>
             <b>Trade Lead's Coupon</b>
             </td>
           </tr>
           <tr width=100%>
               <td   width="30%">
               Trade Lead :
               </td>
               <td  width="70%" height="20">
               <?php
               if (strtolower(trim($directorytype))=="gen")
                   $pname="General Contact";
               else if (strtolower(trim($directorytype))=="full")
                   $pname="Full Profile";
               else
                   $pname=$_SESSION['product_name'];
               echo $pname;
               ?>
               </td>
          </tr>
           <tr width=100%>
               <td  >
               Price :
               </td>
               <td   height="20">
               <?php echo "Tk. ".$_SESSION['product_price'];?>
               </td>
          </tr>
           <tr width=100%>
               <td   >
               Discount :
               </td>
               <td   height="20">
               <?php
               $discount=$_SESSION['discount']?$_SESSION['discount']:"0";
               echo $discount==intval($discount)?intval($discount).".00":round($discount,2);
               ?>%
               <input type="hidden" name="discount" value="<?php echo $_SESSION['discount'];?>" />
               <input type="hidden" name="discount_note" value="<?php echo $_SESSION['discount_note'];?>" />
               </td>
          </tr>
           <tr width=100%>
               <td   >
               Payable Amount :
               </td>
               <td   height="20">
               <?php
               $discount_amount=($_SESSION['product_price']*$_SESSION['discount'])/100;
               $payable_amount=$_SESSION['product_price']-round($discount_amount,2);
               echo "Tk. ".$payable_amount;

               ?>

               <input type="hidden" name="payable_amount" value="<?php echo $payable_amount;?>" />
               </td>
          </tr>
           <tr width=100%>
               <td   >
               * Money Receipt Number :
               </td>
               <td   height="20">
               <input type="text" name="money_receipt_no" size="20" maxlength="10" onKeyUp="javascript:check_IntNumber('money_receipt_no','Enter valid money receipt number.');"  />
               <a href="javascript:newwindow();" style="text-decoration:underline;">Check Money Receipt Number</a>
               </td>
          </tr>
          <!--tr>
        <td></td>
       <td>
          <input type="button" name="Validity" class="button" value="Check Availability" onclick=javascript:newwindow(); />
       </td>
    </tr-->
          <tr>
                <td >
                * Money Receipt Date :
                </td>
                <td colspan="2">
                <input class="text_area" type="text" name="money_receipt_date" id="money_receipt_date" value="<?php echo date('d-m-Y');?>" size="20" readonly/>
                <img src="<?php echo $mosConfig_live_site; ?>/administrator/images/calender.gif" id="img1" border=0 class="calender_link">
                </td>
          </tr>
           <tr width=100% >
               <td height="5" >
               </td>
               <td >

               </td>
          </tr>
           <tr>
             <td>
             </td>
             <td >
             <input type=hidden name=pid value="<?php echo $pid; ?>">
             <input type=hidden name=step value="5">
             <input type=hidden name=option value="com_docman">
             <input type=hidden name=task value="doc_purchase">
             <input type=hidden name="customer" value="<?php echo $customer; ?>">
             <input type=hidden name=from value="not_sales_tracker">
             <input type="hidden" name="search_criteria" value="<?php echo $search_criteria; ?>">
             <input type="hidden" name="directorytype" value="<?php echo $directorytype; ?>">
             <input type="hidden" name="member_price" value="<?php echo $member_price; ?>">
             <input type="hidden" name="nonmember_price" value="<?php echo $nonmember_price; ?>">
             <input class="button" type=submit name=submit value="Submit" onClick="javascript:return submitbutton()">
             <input class="button" type=button name=cancel value="Cancel"  onclick="javascript: location.href='index.php';">
             <input class="button" type=button name=Back value="Back" onclick="javascript: history.go(-1);">
             </td>
           </tr>
        </table>
        </form>
         <script language="javascript" type="text/javascript">
                        Calendar.setup({
                        inputField     :    "money_receipt_date",      // id of the input field
                        ifFormat       :    "<?php echo $mosconfig_calender_date_format; ?>",
                        showsTime      :    false,            // will display a time selector
                        button         :    "img1",   // trigger for the calendar (button ID)
                        singleClick    :    true,           // double-click mode
                        step           :    1                // show all years in drop-down boxes (instead of every other                                                                         year as default)
                        });


        </script>
        <?php
    }



    function purchase_step5(&$rows,$pid,$directorytype,$member_price,$nonmember_price,$invoice_id,$et)
    {
        global $_DOCMAN, $mosConfig_live_site,$mosConfig_absolute_path, $mosconfig_show_date_format;
        global $search_criteria;
        ?>
        <script language="javascript">
        function update_dmcounter(pid,dmfilename,catid,search_criteria,invoice_id,et){
             if (catid==0)
                 window.location.href='index.php?option=com_docman&task=doc_purchase&step=5&dmcounter=1&pid='+pid+'&directorytype='+dmfilename+'&catid='+catid+'&search_criteria='+search_criteria+'&invoice_id='+invoice_id+'&et='+et;
             else
                 window.location.href='index.php?option=com_docman&task=doc_purchase&step=5&dmcounter=1&pid='+pid+'&dmfilename='+dmfilename+'&catid='+catid+'&invoice_id='+invoice_id+'&et='+et;
        }
        </script>
        <form action="index.php" method="post" name="userForm" id="adminForm" >

        <table width="100%" cellspacing="0" >
           <tr>
             <td colspan="2">
             <b>Trade Lead Name</b>
             </td>
           </tr>
           <?php
           if( count($rows)>0 ){
               $row = &$rows[0];
               $docid=$row->did;
               $catid=$row->catid;
               $dmfilename=$row->dmfilename;
               $product_name=$row->dmname;
               if (intval($row->product_type)>1 ){
                   //$invoice_id=$row->id;
                   $docid=intval($docid)>0?$docid:0;
                   //$catid=intval($catid)>0?$catid:0;
                   $catid=0;
                   if (intval($row->product_type)==2){
                       $product_name="General Contact";
                       $dmfilename="gen";
                   }
                   else if (intval($row->product_type)==3){
                       $product_name="Full Profile";
                       $dmfilename="full";
                   }
               }


               //$absolute_path=$mosConfig_absolute_path."/dmdocuments/".$catid."/".$docid."/".$dmfilename;
               //$site_path="'dmdocuments/".$catid."/".$docid."/".$dmfilename."'";
               $link = "<A href=\"javascript:update_dmcounter($docid,'$dmfilename',$catid,'',$invoice_id,$et);\" title=\"Info Product\" onMouseOver=\"javascript:window.status='Info Product';return true\"><b>Open Trade Lead</b></a>";

           }
           else{
               if ( strtolower(trim($directorytype))=="gen" )
                    $product_name="General Contact";
               else if ( strtolower(trim($directorytype))=="full" )
                    $product_name="Detail Contact";
               $pid=$pid?$pid:0;
               $link = "<A href=\"javascript:update_dmcounter($pid,'$directorytype',0,'$search_criteria',$invoice_id,$et);\" title=\"Info Product\" onMouseOver=\"javascript:window.status='Info Product';return true\"><b>Open Trade Lead</b></a>";
           }

           ?>
           <tr width=100%>
               <td   width="70%">
               <?php echo $product_name;?>
               </td>
               <td  width="30%" height="20">
               <?php echo $link;?>
               </td>
          </tr>
           <tr width=100% >
               <td height="5" >
               </td>
               <td >

               </td>
          </tr>
           <tr>
             <td>
             </td>
             <td >
             <input type=hidden name=pid value="<?php echo $pid; ?>">
             <input type=hidden name=step value="5">
             <input type=hidden name=option value="com_docman">
             <input type=hidden name=task value="doc_purchase">
             <input type="hidden" name="dmcounter" value="<?php echo $dmcounter; ?>">
             <input type="hidden" name="directorytype" value="<?php echo $directorytype; ?>">
             <input type="hidden" name="search_criteria" value="<?php echo $search_criteria; ?>">
             <input type="hidden" name="member_price" value="<?php echo $member_price; ?>">
             <input type="hidden" name="nonmember_price" value="<?php echo $nonmember_price; ?>">
             <input class="button" type=button name=cancel value="Cancel"  onclick="javascript: location.href='index.php';">

             </td>
           </tr>
        </table>
        </form>
        <?php
    }

    function sales_tracker()
    {
        global $_DOCMAN;
        ?>
        <script language="javascript" type="text/javascript">

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
                   var form = document.userForm;
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
               var newWin;
                function newwindow(){
                      if (null != newWin && !newWin.closed)
                         closeNewWindow();
                      page='./popup/infoProductCouponEpb.php?formName=userForm';
                      window.open(page,'','width=800,height=400,scrollbars=yes,resizable=no,top=180,left=100,status=no,menubar=no,directories=no,location=no,toolbar=no');
                      //newWin.focus();
               }
               function submitbutton() {

               var form = document.userForm;

               if(form.invoice_no.value == "" || form.invoice_no.value == 0){
                  alert("Please enter coupon number");
                  form.invoice_no.focus();
                  return false;
               }

               else{
                  return true;
               }
            }
        </script>
        <form action="index.php" method="post" name="userForm" id="adminForm" >
        <table width="100%" cellspacing="0" >
           <tr>
             <td colspan=2>
             <b>Coupon Information</b>
             </td>
           </tr>
           <tr height="5">
             <td colspan=2>
             &nbsp;
             </td>
           </tr>
           <tr width=100%>
               <td   width="20%">
               * Coupon Number :
               </td>
               <td  width="80%">
               <input class="text_area" type="text" name="invoice_no" size="25" maxlength="60"  value="<?php echo $_REQUEST[invoice_no];?>" onKeyUp="javascript:check_IntNumber('invoice_no','Enter valid coupon number.');" />
               <a href="javascript:newwindow();" style="text-decoration:underline;" onMouseOver="javascript:window.status='Search Coupon Number';return true" >Search Coupon Number</a>
               </td>
          </tr>
           <tr width=100% >
               <td height="5" >
               </td>
               <td >

               </td>
          </tr>
           <tr>
             <td>
             </td>
             <td >
             <input type=hidden name=step value="5">
             <input type=hidden name=option value="com_docman">
             <input type=hidden name=task value="doc_purchase">
             <input type=hidden name=from value="sales_tracker">
             <input class="button" type="submit" name="submit" value="Submit" onClick="javascript:return submitbutton();">
             <input class="button" type=button name=cancel value="Cancel"  onclick="javascript: location.href='index.php';">

             </td>
           </tr>
        </table>
        </form>
        <?php
    }

    function pageDocumentEdit(&$html)
    {
        global $_DOCMAN;

        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html', $html);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docedit.tpl.php');
    }

    function pageDocumentMove(&$html)
    {
        global $_DOCMAN;

        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html', $html);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docmove.tpl.php');
    }

    function pageDocumentUpload(&$html, $step, $method, $update)
    {
        global $_DOCMAN;

        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html', $html);
        $tpl->assignRef('step', $step);
        $tpl->assignRef('method', $method);
        $tpl->assignRef('update', $update);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docupload.tpl.php');
    }

    function pageDocumentLicense(&$html, &$license)
    {
        global $_DOCMAN;

        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html',    $html   );
        $tpl->assignRef('license', $license);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_doclicense.tpl.php');
    }

    function pageSearch(&$html, &$items)
    {
        global $_DOCMAN;

        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('html' , $html);
        $tpl->assignRef('items', $items);
        // load a filter to trim whitespace
        $tpl->loadFilter('trimwhitespace');
        // Display a template using the assigned values.
        $tpl->display('page_docsearch.tpl.php');
    }

    function scriptDocumentEdit()
    {
             global $_DOCMAN;

             //set private cache control
                header("Cache-Control: private");

                //send javascript mime-type header
                header("Content-Type: text/javascript");

        $tpl = &new DOCMAN_Theme();
        // Display a template using the assigned values.
        $tpl->display('script_docedit.tpl.php');
    }

    function scriptDocumentUpload($step, $method, $update)
    {
            global $_DOCMAN;

            //set private cache control
                header("Cache-Control: private");

                //send javascript mime-type header
                header("Content-Type: text/javascript");

        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('step', $step);
        $tpl->assignRef('method', $method);
        $tpl->assignRef('update', $update);
        // Display a template using the assigned values.
        $tpl->display('script_docupload.tpl.php');
    }

    function fetchMenu(&$links, &$perms)
    {
        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('links', $links);
        $tpl->assignRef('perms', $perms);
        // Display a template using the assigned values.
        return $tpl->fetch('general/menu.tpl.php');
    }

    function fetchPathWay(&$links)
    {
        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('links', $links);
        // Display a template using the assigned values.
        return $tpl->fetch('general/pathway.tpl.php');
    }

    function fetchPageNav(&$pageNav, $link)
    {
        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('pagenav', $pageNav);
        $tpl->assignRef('link', $link);
        // Display a template using the assigned values.
        return $tpl->fetch('general/pagenav.tpl.php');
    }

    function fetchPageTitle(&$pageTitle)
    {
        $tpl = &new DOCMAN_Theme();
        // Assign values to the Savant instance.
        $tpl->assignRef('pagetitle', $pageTitle);
        // Display a template using the assigned values.
        return $tpl->fetch('general/pagetitle.tpl.php');
}

} // end class

?>