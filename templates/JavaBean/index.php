<?php
    defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );
    // needed to seperate the ISO number from the language file constant _ISO
    $iso = explode( '=', _ISO );
    // xml prolog
    echo '<?xml version="1.0" encoding="'. $iso[1] .'"?' .'>';
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<?php
if ( $my->id ) {
        initEditor();
}
?>
<meta http-equiv="Content-Type" content="text/html; <?php echo _ISO; ?>" />
<?php mosShowHead(); ?>
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/templates/JavaBean/css/template_css.css" />
<!--added by camellia team-->
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/templates/JavaBean/css/theme.css" />
<!-- required file include for calender by morshed-->
<link rel="stylesheet" href="<?php echo $mosConfig_live_site; ?>/includes/calender/calendar-blue.css" type="text/css"  />
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/calender/calendar.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/calender/lang/calendar-en.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/calender/calendar-setup.js" type="text/javascript"></script>

</head>

<body>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0" class="contentbg">
<tr>
        <td width="6" bgcolor="#FFFFFF">
        <img src="<?php echo $mosConfig_live_site; ?>/templates/JavaBean/images/pixel.png" width="1" height="1" alt="spacer" />
        </td>
        <td valign="top" class="greybg">
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                <!--tr>
                        <td bgcolor="#FFFFFF">
                        <img src="<?php echo $mosConfig_live_site; ?>/templates/JavaBean/images/pixel.png" width="1" height="6" alt="spacer" /></td>
                        <td width="180" height="6" valign="bottom" bgcolor="#FFFFFF">
                        <img src="<?php echo $mosConfig_live_site; ?>/templates/JavaBean/images/search_01.png" width="180" height="3" alt="search" /></td>
                </tr-->
                <tr class="contentbg">
                        <td width=50% rowspan="3" valign="bottom">
                        <p>
                        <font class="title">
                        <?php echo $mosConfig_sitename; ?>
                        </font>
                        <br />
                        <font class="subtitle">
                        <?php echo _SITE_SLOGAN; ?>
                        </font>
                        </p>
                        </td>

                        <td valign="top"  width=30%>
                        </td>
                        <td valign="top" width=20% >
                        <?php
                        if(!((trim($_POST['option'])=="" || trim($_POST['option'])=="com_frontpage") && (trim($_GET['option'])=="" || trim($_GET['option'])=="com_frontpage")))
                              mosLoadModules ( 'user4', -1 );
                        ?>
                        </td>
                </tr>
                <tr class="contentbg">
                        <td height="10" colspan="3">
                        <img src="<?php echo $mosConfig_live_site; ?>/templates/JavaBean/images/pixel.png" width="1" height="10" alt="spacer" />
                        </td>
                </tr>
                </table>
                <!-- This is the vertical menu. Change the links as needed or delete the script from this line if you dont use it-->
                <table width="100%" border="0" cellpadding="0" cellspacing="0">
                <tr>
                        <td colspan="3">
                        <?php ///mosLoadModules ( 'user3', -1 );
                        // blocked by Team camellia <top hirizontal menu>
                        ?>
                        </td>
                </tr>
                </table>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" height="480">
                  <!--DWLayoutTable-->
                  <tr>
                    <td width="180" rowspan="2" valign="top" class="contentbg">
                        <?php mosLoadModules ( 'left' ); ?>
                    </td>
                    <td width="5" height="83">&nbsp;</td>
                    <td width="603" align="right" valign="top"><img src="<?php echo $mosConfig_live_site; ?>/templates/JavaBean/images/image_01.jpg" width="600" height="100" alt="header" />

                <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="12px"></td>
              </tr>
              <tr>
                <td class="pathway">
                  <?php

                                 mosPathWay();
                  ?>
                </td>
              </tr>
            </table>
            <table width="98%" border="0" align="center" cellpadding="4" cellspacing="0">
                <tr>
                  <td class="mainpage" >

                    <?php  mosMainBody(); ?>
                  </td>
                </tr>

              </table>
                        </td>
              </tr>
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                        <tr class="footerbg">
                                <td  height="30">&nbsp;</td>
                                <td>&nbsp;</td>
                                <td width="360" align="right" valign="middle" class="copyright">
                                <?php include_once( $GLOBALS['mosConfig_absolute_path'] . '/includes/footer.php' ); ?>
                                </td>
                        </tr>
                </table>
          </td>
        <td width="6" bgcolor="#FFFFFF">
        <img src="<?php echo $mosConfig_live_site; ?>/templates/JavaBean/images/pixel.png" width="1" height="1" alt="spacer"/>
        </td>
</tr>
</table>
<?php mosLoadModules( 'debug', -1 );?>
</body>
</html>