<?php
/**
* @version $Id: user.html.php,v 1.5 2005/02/14 09:47:42 kochp Exp $
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
class HTML_user {
        function frontpage() {
?>
<div class="componentheading">
        <?php echo _WELCOME; ?>
</div>

        <table cellpadding="0" cellspacing="0" border="0" width="100%">
                <tr>
                        <td><?php echo _WELCOME_DESC; ?></td>
                </tr>
        </table>
<?php
        }

        function userEdit($row, $option,$submitvalue, &$lists)
        {
?>
        <script language="javascript" type="text/javascript">
                function submitbutton() {
                        var form = document.mosUserForm;
                        var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

                        // do field validation
                        if (form.name.value == "") {
                                alert( "<?php echo _REGWARN_NAME;?>" );
                        } else if (form.username.value == "") {
                                alert( "<?php echo _REGWARN_UNAME;?>" );
                        } else if (r.exec(form.username.value) || form.username.value.length < 3) {
                                alert( "<?php printf( _VALID_AZ09, _PROMPT_UNAME, 4 );?>" );
                        } else if (form.email.value == "") {
                                alert( "<?php echo _REGWARN_MAIL;?>" );
                        }/* else if ((form.password.value != "") && (form.password.value != form.verifyPass.value)){
                                alert( "<?php echo _REGWARN_VPASS2;?>" );
                        } else if (r.exec(form.password.value)) {
                                alert( "<?php printf( _VALID_AZ09, _REGISTER_PASS, 4 );?>" );
                        } */else if (trim(form.hint.value)=="") {
                                alert( "Please Insert HINTS " );
                        }
                         else {
                                form.submit();
                        }
                }
        </script>
<form action="index.php" method="post" name="mosUserForm">
       <div id="overDiv" style="position:absolute; visibility:hidden; z-index:10000;"></div>

                <div class="componentheading">
                        <?php echo _EDIT_TITLE; ?>
                </div>
                <table cellpadding="5" cellspacing="0" border="0" width="100%">
    <tr>
      <td width=85><?php echo _YOUR_NAME; ?>*</td>
      <td><input class="inputbox" type="text" name="name"   maxlength="50" value="<?php echo $row->name;?>" size="40" /></td>
    </tr>
    <tr>
      <td><?php echo _EMAIL; ?>*</td>
      <td><input class="inputbox" type="text" name="email"  maxlength="100" value="<?php echo $row->email;?>" size="40" />
      <?php echo mosToolTip('This Email address will be needed if you forget your Password'); ?></td>
    <tr>
      <td><?php echo _UNAME; ?>*</td>
      <td><input class="inputbox" type="text" name="username"  maxlength="25" readonly=true value="<?php echo $row->username;?>" size="40" />
       <?php echo mosToolTip('Your cannot change user name'); ?>   </td>
    </tr>

     <tr>
        <td>
             <?php echo 'Gender:'; ?>
        </td>
        <td>
            <?php echo $lists['gender']; ?>
        </td>
    </tr>




    <!--tr>
      <td><?php echo _PASS; ?></td>
      <td><input class="inputbox" type="password" name="password" value="" size="40" /></td>
    </tr>
    <tr>
      <td><?php echo _VPASS; ?></td>
      <td><input class="inputbox" type="password" name="verifyPass" size="40" /></td>
    </tr>

    <tr-->   <!-- Blocked by sami coz we don't need it here -->
              <td>
                    <?php echo 'Address:'; ?>
             </td>
             <td>
                <input type="text" name="address_line1" class="inputbox" size="40" maxlength="100" value="<?php echo $row->address_line1; ?>" />
             </td>
   </tr>

   <tr>
          <td>
                        <!--?php echo 'Address Line2 :'; ?-->
          </td>
          <td>
             <input type="text" name="address_line2" class="inputbox" size="40" maxlength="100" value="<?php echo $row->address_line2; ?>" />
          </td>
   </tr>

    <tr>
                                        <td>
                                               <?php echo 'Phone:'; ?>
                                        </td>
                                        <td>
                                        <input class="inputbox" type="text" name="phone" size="40" maxlength="30" value="<?php echo $row->phone; ?>" />
                                        </td>
                                </tr>


                                <tr>
                                        <td>
                                        <?php echo 'Mobile:'; ?>
                                        </td>
                                        <td>
                                        <input class="inputbox" type="text" name="mobile" size="40" maxlength="30"  value="<?php echo $row->mobile; ?>" />
                                        </td>
                                </tr>


                                <tr>
                                        <td>
                                        <?php echo 'City:'; ?>
                                        </td>
                                        <td>
                                        <input class="inputbox" type="text" name="city" size="40"  maxlength="30" value="<?php echo $row->city; ?>" />
                                        </td>
                                </tr>
                                <tr>
                                        <td>
                                        <?php echo 'Country:'; ?>
                                        </td>
                                        <td>
                                        <?php echo $lists['country_id']; ?>
                                        </td>
                                </tr>


     <tr>
      <td><?php echo "Hints:"; ?>* </td>
      <td><input class="inputbox" type="text" name="hint" size="40" value="<?php echo $row->hint; ?>" />
      <?php echo mosToolTip('Make sure You can remember your password from this hint but hard for others to guess'); ?></td>
    </tr>


    <tr>
      <td colspan="2">
        <input class="button" type="button" value="<?php echo $submitvalue; ?>" onclick="submitbutton()" />
      </td>
    </tr>
  </table>
        <input type="hidden" name="id" value="<?php echo $row->id;?>" />
        <input type="hidden" name="option" value="<?php echo $option;?>">
        <input type="hidden" name="task" value="saveUserEdit" />
</form>

<script  type="text/javascript" src="./includes/js/overlib_mini.js"></script>
<!------------------------------------------------------------------------------------------------------------->
<?php
        }

        function userChangePassword($row, $option,$submitvalue)
        {
?>
 <script language="javascript" type="text/javascript">
                function submitbutton() {
                        var form = document.mosChangeForm;
                        var r = new RegExp("[\<|\>|\"|\'|\%|\;|\(|\)|\&|\+|\-]", "i");

                        // do field validation

                        if (trim(form.passwd.value)=="") {
                                alert( "Please Insert Current Password " );
                        }

                        else if (trim(form.password.value)=="") {
                                alert( "Please Insert New Password  " );
                        } else if ((form.password.value.length)<=5) {
                                alert( "Password must be six Character   " );
                        }



                        else if ((form.password.value != "") && (form.password.value != form.verifyPass.value)){
                                alert( "<?php echo _REGWARN_VPASS2;?>" );
                        } else if (r.exec(form.password.value)) {
                                alert( "<?php printf( _VALID_AZ09, _REGISTER_PASS, 4 );?>" );
                        }
                         else {
                                form.submit();
                        }
                }

                function go_page(){
                       window.location="index.php";
               }
        </script>
<form action="index.php" method="post" name="mosChangeForm">

                <div class="componentheading">
                        <?php echo "Change Password "; ?>
                </div>
                <table cellpadding="5" cellspacing="0" border="0" width="100%">


     <tr>
            <td><?php echo 'Current Password: *'; ?></td>
            <td>
                            <input  type="password" name="passwd" class="inputbox" size="40" />

            </td>
    </tr>


    <tr>
      <!--td><?php echo 'New '._PASS; ?></td-->   <!--   -->
      <td><?php echo 'New Password:'; ?></td>
      <td><input class="inputbox" type="password" name="password" value="" size="40" /></td>
    </tr>
    <tr>
      <!--td><?php echo _VPASS; ?></td-->
       <td><?php echo 'Confirm Password:'; ?></td>
      <td><input class="inputbox" type="password" name="verifyPass" size="40" /></td>
    </tr>



    <tr>
      <td colspan="2">
        <!--input class="button" type="button" value="<?php echo $submitvalue; ?>" onclick="submitbutton()" /-->
                <input class="button" type="button" value="<?php echo 'Save'; ?>" onclick="submitbutton()" />
                <input type="button" value="<?php echo "Cancel"; ?>" class="button" onclick="javascript:go_page();" />
      </td>
    </tr>
  </table>
        <input type="hidden" name="pass" value=1 />
        <input type="hidden" name="id" value="<?php echo $row->id;?>" />
        <input type="hidden" name="option" value="<?php echo $option;?>">
        <input type="hidden" name="task" value="saveUserEdit" />
</form>




<!------------------------------------------------------------------------------------------------------------->

<?php
        }

        function confirmation() {
                ?>
        <div class="componentheading">
                <?php echo _SUBMIT_SUCCESS; ?>
        </div>
        <table>
                <tr>
                        <td><?php echo _SUBMIT_SUCCESS_DESC; ?></td>
                </tr>
        </table>
<?php
        }
}
?>
