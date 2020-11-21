<?php
/**
* @version $Id: version.php,v 1.12 2005/02/19 02:06:44 eddieajau Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** Version information */
class version {
        /** @var string Product */
        var $PRODUCT = 'IMS';
        /** @var int Main Release Level */
        var $RELEASE = '4.5';
        /** @var string Development Status */
        var $DEV_STATUS = 'Stable';
        /** @var int Sub Release Level */
        var $DEV_LEVEL = '2.3';
        /** @var string Codename */
        var $CODENAME = 'Titan Reassigned';
        /** @var string Date */
        var $RELDATE = '15-June-2005';
        /** @var string Time */
        var $RELTIME = '04:30';
        /** @var string Timezone */
        var $RELTZ = 'GMT';
        /** @var string Copyright Text */
        var $COPYRIGHT = "";
        /** @var string Pdf Copyright Text */
        var $COPYRIGHT_PDF = "";
        /** @var string URL */
        var $URL = '';

        function version(){
                global $mosConfig_owner;
                $this->COPYRIGHT="&copy; Copyright GTZ. <a target='_blank' href='http://www.mislbd.com' class='copyright'>Developed by Millennium Information Solution Ltd.</a> ";
                $this->COPYRIGHT_PDF="© Copyright GTZ. Developed by Millennium Information Solution Ltd.";
        }

}
$_VERSION =& new version();

$version = $_VERSION->PRODUCT .' '. $_VERSION->RELEASE .'.'. $_VERSION->DEV_LEVEL .' '
. $_VERSION->DEV_STATUS
.' [ '.$_VERSION->CODENAME .' ] '. $_VERSION->RELDATE .' '
. $_VERSION->RELTIME .' '. $_VERSION->RELTZ;
?>