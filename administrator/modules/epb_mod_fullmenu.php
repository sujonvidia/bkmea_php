<?php
/**
* @version $Id: epb_mod_fullmenu.php,v 1.5 2007/01/10 12:15:11 morshed Exp $
* @package Mambo
* @copyright (C) 2000 - 2005 Miro International Pty Ltd
* @license http://www.gnu.org/copyleft/gpl.html GNU/GPL
* Mambo is Free Software
*/

/** ensure this file is being included by a parent file */
defined( '_VALID_MOS' ) or die( 'Direct Access to this location is not allowed.' );

/**
* Full DHTML Admnistrator Menus
* @package Mambo
*/
class mosFullAdminMenu {
        /**
        * Show the menu
        * @param string The current user type
        */
        function show( $usertype='' ) {
                global $database, $my;
                global $mosConfig_live_site, $mosConfig_enable_stats, $mosConfig_caching;
?>
                <div id="myMenuID"></div>
                <script language="JavaScript" type="text/javascript">

                var myMenu =
                [
                        [null,'Home','index2.php',null,'Control Panel'],
                        _cmSplit,
                        [null,'Site',null,null,'Site Management',
                           // ['<img src="../includes/js/ThemeOffice/config.png" />','Global Configuration','index2.php?option=com_config',null,'Configuration'],
                            ['<img src="../includes/js/ThemeOffice/users.png" />','Your Details','index2.php?option=com_users&task=editA&id=<? echo $my->id; ?>&pd=?',null,'Your Details']
<?php                       if ($usertype=='Super Administrator'||$usertype=='Administrator')
                            {
?>                               ,['<img src="../includes/js/ThemeOffice/users.png" />','User Manager','index2.php?option=com_users&task=view',null,'Manage users']
<?php                       }
?>                      ],
                        _cmSplit,
                        [null,'Manage',null,null,'Manage',
                           ['<img src="../includes/js/ThemeOffice/content.png" />','Stakeholder Profile','index2.php?option=com_stakeholder_profile',null,'Stakeholder Profile'],
                           ['<img src="../includes/js/ThemeOffice/content.png" />','Circulars','index2.php?option=com_circular',null,'Circulars'],
                           ['<img src="../includes/js/ThemeOffice/content.png" />','Trade Fair','index2.php?option=com_trade_fair',null,'Trade Fair'],
                           ['<img src="../includes/js/ThemeOffice/content.png" />','Trade Leads','index2.php?option=com_trade_lead',null,'Trade Leads']
                           ,['<img src="../includes/js/ThemeOffice/content.png" />','HS Code','index2.php?option=com_hscode_registration','manage','HS Code']
                        ],
                        _cmSplit,
                        [null,'Report',null,null,'Report',
                           ['<img src="../includes/js/ThemeOffice/document.png" />','Trade Lead Sales','index2.php?option=com_info_product_sales_report&for=epb',null,'Trade Lead Sales Report'],
                           ['<img src="../includes/js/ThemeOffice/document.png" />','Trade Lead List','index2.php?option=com_info_product_list_report&for=epb',null,'Trade Lead List'],
                           ['<img src="../includes/js/ThemeOffice/document.png" />','Customer','index2.php?option=com_info_product_customer_report&for=epb',null,'Customer']

                        ],
                        _cmSplit,
                        [null,'Tools',null,null,'Manage',
                           ['<img src="../includes/js/ThemeOffice/config.png" />','Search HS Code','index2.php?option=com_search_existing_hscode','tools','Search HS Code'],
                           ['<img src="../includes/js/ThemeOffice/config.png" />','Export TIS Data','index2.php?option=com_export',null,'Export TIS Data']
                        ]


                ];
                cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
                </script>
<?php
        }
}
$cache =& mosCache::getCache( 'mos_fullmenu' );
mosFullAdminMenu::show( $my->usertype );
?>
