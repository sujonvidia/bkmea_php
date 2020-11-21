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
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/templates/epb_template/css/template_css.css" />
<!--added by camellia team-->
<link rel="stylesheet" type="text/css" href="<?php echo $mosConfig_live_site; ?>/templates/epb_template/css/theme.css" />
<!-- required file include for calender by morshed-->
<link rel="stylesheet" href="<?php echo $mosConfig_live_site; ?>/includes/calender/calendar-blue.css" type="text/css"  />
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/calender/calendar.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/calender/lang/calendar-en.js" type="text/javascript"></script>
<script language="JavaScript" src="<?php echo $mosConfig_live_site; ?>/includes/calender/calendar-setup.js" type="text/javascript"></script>

</head>

<body>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="contentbg">
<tr>
        <td valign="top" class="greybg">
              <TABLE cellSpacing="0" cellPadding="0" width="100%" border="0">
              <TBODY>
              <TR>
                <TD>
                  <table width="100%" border="0" cellspacing="0" cellpadding="0"  background="<?php echo $mosConfig_live_site; ?>/templates/epb_template/images/header_bg.jpg">
                    <tr>
                      <td align="left" >
                      <img src="<?php echo $mosConfig_live_site; ?>/templates/epb_template/images/header_left.jpg" width="457px" height="80px"></td>
                      <td >&nbsp;</td>
                      <td  width="634px" align="right">
                      <img src="<?php echo $mosConfig_live_site; ?>/templates/epb_template/images/header_right.jpg" height="80px" width="300px"></td>
                    </tr>
                  </table>
                </TD>
              </TR>
              </TBODY>
            </TABLE>
                <table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
                </table>
                <table width="100%" border="0" cellspacing="0" cellpadding="0" height="480">
                  <!--DWLayoutTable-->
                  <tr>
                    <td width="180" rowspan="2" valign="top" class="contentbg">
                        <?php mosLoadModules ( 'left' ); ?>
                    </td>
                    <td width="5" height="83">&nbsp;</td>
                    <td align="right" valign="top">
                <table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
              <tr>
                <td height="5px"></td>
              </tr>
              <tr>
                <td class="pathway">
                  <?php

                                 mosPathWay();
                  ?>
                </td>
              </tr>
              <tr>
                <td style="padding-top:10px;"></td>
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
</tr>
</table>
<?php mosLoadModules( 'debug', -1 );?>
</body>
</html>
