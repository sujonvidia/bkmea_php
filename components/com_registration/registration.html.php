<?php
/**
* @version $Id: registration.html.php,v 1.4 2005/01/06 01:13:27 eddieajau Exp $
* @package Mambo
* @subpackage Users
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* @package Mambo
* @subpackage Users
*/
class HTML_registration {
        function lostPassForm($option) {
                ?>

<div class="componentheading">
        <?php echo _PROMPT_PASSWORD; ?>
</div>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
  <form action="index.php" method="post">
    <tr>
              <td colspan="2" height="10"></td>
    </tr>
    <tr>
      <td colspan="2"><?php echo _NEW_PASS_DESC; ?></td>
    </tr>
    <tr>
              <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td><?php echo _PROMPT_UNAME; ?></td>
      <td><input type="text" name="checkusername" class="inputbox" size="40" maxlength="25" /></td>
    </tr>
    <tr>
      <td><?php echo _PROMPT_EMAIL; ?></td>
      <td><input type="text" name="confirmEmail" class="inputbox" size="40" /></td>
    </tr>
    <tr>
              <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td></td>
        <td >
        <input type="hidden" name="option" value="<?php echo $option;?>" />
        <input type="hidden" name="task" value="sendNewPass" /> <input name=pass type="submit" class="button" value="<?php echo _BUTTON_SEND_PASS; ?>" />
        <input type="hidden" name="option" value="<?php echo $option;?>" />
        <input name=pass type="submit" class="button" value="Get Hints" /></td-->

    </tr>
  </form>
</table>
<?php
        }

        function registerForm($option, $useractivation, &$lists) {

?>

        <script language="javascript" type="text/javascript">
                function submitbutton() {
                        var form = document.mosForm;
                        var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

                        // do field validation
                        if (form.name.value == "") {
                                alert( "<?php echo html_entity_decode(_REGWARN_NAME);?>" );
                        } else if (form.username.value == "") {
                                alert( "<?php echo html_entity_decode(_REGWARN_UNAME);?>" );
                        } else if (r.exec(form.username.value) || form.username.value.length < 3) {
                                alert( "<?php printf( html_entity_decode(_VALID_AZ09), html_entity_decode(_PROMPT_UNAME), 2 );?>" );
                        } else if (form.email.value == "") {
                                alert( "<?php echo html_entity_decode(_REGWARN_MAIL);?>" );
                        }/* else if (form.password.value.length < 6) {
                                alert( "<?php echo html_entity_decode(_REGWARN_PASS);?>" );
                        } else if (form.password2.value == "") {
                                alert( "<?php echo html_entity_decode(_REGWARN_VPASS1);?>" );
                        } else if ((form.password.value != "") && (form.password.value != form.password2.value)){
                                alert( "<?php echo html_entity_decode(_REGWARN_VPASS2);?>" );
                        } else if (r.exec(form.password.value)) {
                               alert( "<?php printf( html_entity_decode(_VALID_AZ09), html_entity_decode(_REGISTER_PASS), 6 );?>" );

                        } else if (form.hint.value=="") {
                                alert( "Please Insert HINTS " );
                        }*/
                        else {
                                form.submit();
                        }
                }

                       var newWin;

                 function newwindow()
               {
                         if (null != newWin && !newWin.closed)

                         closeNewWindow();
                         page='popup.php?name='+document.mosForm.username.value+'&formid=2';
                         newWin=window.open(page,'','width=399,height=90,scrollbars=no,resizable=no,top=180,left=200,status=no,menubar=no,directories=no,location=no,toolbar=no');
                         //var form = document.adminForm;
                         //location.href=popup.php;
                         //newWin.document.forms[chkform].name.value="a";
                         //opener.document.forms[chkform].name.value=form.username.value;

                         newWin.focus();

               }
               function go_page(){
                       window.location="index.php?option=com_frontpage&Itemid=1";
               }

        </script>

<div class="componentheading">
        <?php echo _REGISTER_TITLE; ?>
</div>
<form action="index.php" method="post" name="mosForm">
<div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>
<table cellpadding="0" cellspacing="0" border="0" width="100%" class="contentpane">
<tr>
<td colspan="2" height="10"></td>
</tr>
<tr>
<td colspan="2"><?php echo _REGISTER_REQUIRED; ?></td>
</tr>
<tr>
<td colspan="2" height="10"></td>
</tr>
    <tr>
      <td width="30%"><?php echo _REGISTER_NAME; ?> *</td>
      <td><input type="text" name="name" size="40"  maxlength="50" value="" class="inputbox" /></td>
    </tr>
    <tr>
      <td><?php echo _REGISTER_UNAME; ?> *</td>
      <td><input type="text" name="username"  maxlength="25" size="40" value="" class="inputbox" />
      <?php echo mosToolTip('This will be your Log in ID'); ?>
      </td>
    </tr>
        <tr>
             <td height="8"></td>
             <td></td>
    </tr>
    <tr>
        <td></td>
       <td>
          <input type="button" name="Validity" class="button" size="40"  value="Check Availability" onclick=javascript:newwindow(); />
       </td>
    </tr>
    <tr>
             <td>&nbsp;</td>
             <td></td>
    </tr>
      <tr>
                <td>
                <?php echo "Gender:"; ?>
                </td>
                <td>
                <?php echo $lists['gender']; ?>
                </td>
      </tr>

      <td><?php echo _REGISTER_EMAIL; ?> *</td>
      <td><input type="text" name="email" size="40"  maxlength="100" value="" class="inputbox" />
       <?php echo mosToolTip('This Email address will be needed if you forget your Password'); ?></td>
    </tr>

    <!--tr>
      <td><?php echo _REGISTER_PASS; ?> *</td>
      <td><input class="inputbox" type="password" name="password"  maxlength="100" size="40" value="" /></td>
    </tr-->

    <!--tr>
      <td><?php echo _REGISTER_VPASS; ?> *</td>
      <td><input class="inputbox" type="password" name="password2"  maxlength="100" size="40" value="" /></td>
    </tr-->

    <tr>
      <td><?php echo "Address:"; ?> </td>
      <td><input class="inputbox" type="text" name="address_line1"  maxlength="100" size="40" value="" /></td>
    </tr>

    <tr>
      <td><!--?php echo "Address 2"; ?--> </td>
      <td><input class="inputbox" type="text" name="address_line2"  maxlength="100" size="40" value="" /></td>
    </tr>


    <tr>
      <td><?php echo "City:"; ?> </td>
      <td><input class="inputbox" type="text" name="city"  maxlength="40" size="40" value="" /></td>
    </tr>
      <tr>
          <td>
                        <?php echo "Country:"; ?>
          </td>
          <td>
                  <?php echo $lists['country_id']; ?>
          </td>
          </tr>

    <tr>
      <td><?php echo "Phone:"; ?> </td>
      <td><input class="inputbox" type="text" name="phone"  maxlength="30" size="40" value="" /></td>
    </tr>

    <tr>
      <td><?php echo "Mobile:"; ?> </td>
      <td><input class="inputbox" type="text" name="mobile"  maxlength="30" size="40" value="" /></td>
    </tr>



    <tr>
        <td >      </td>
        <td >   <?php echo " <b>If you forget your Password</b>" ; ?>    </td>

    </tr>

    <tr>
      <td>Password <?php echo "Hints:"; ?> </td>
      <td><input class="inputbox" type="text" name="hint"  maxlength="30" size="40" value="" />
             <?php echo mosToolTip('Make sure You can remember your password from this hint but hard for others to guess'); ?></td>
    </tr>
    <tr>
        <td valign=top> <b> <?php echo " Terms Of Services" ; ?> </b>   </td>

        <td>
        <TEXTAREA   READONLY=TRUE ROWS=5 COLS=30>HELLO
        </TEXTAREA>

        </td>
    </tr>
    <tr>
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td></td>
      <td>
<input type="hidden" name="id" value="0" />
<input type="hidden" name="gid" value="0" />
<input type="hidden" name="useractivation" value="<?php echo $useractivation;?>" />
<input type="hidden" name="option" value="<?php echo $option; ?>" />
<input type="hidden" name="task" value="saveRegistration" />
<!--input type="button" value="<?php echo _BUTTON_SEND_REG; ?>" class="button" onclick="submitbutton()" /-->
<input type="button" value="<?php echo "I Agree"; ?>" class="button" onclick="submitbutton()" />
<input type="button" value="<?php echo "I Do not Agree"; ?>" class="button" onclick="javascript:go_page();" />
      </td>
     </tr>
</table>
<br>
</form>
        <script  type="text/javascript" src="./includes/js/overlib_mini.js"></script>

<?php
        }

}
?>
