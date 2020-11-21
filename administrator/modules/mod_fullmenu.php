<?php
/**
* @version $Id: bkmea_mod_fullmenu.php,v 1.30 2006/12/28 08:52:16 morshed Exp $
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
                global $acl, $database;
                global $mosConfig_live_site, $mosConfig_enable_stats, $mosConfig_caching;
                                global $my;
                $user_id=$my->id;

                // cache some acl checks
              //  $canConfig                         = $acl->acl_check( 'administration', 'config', 'users', $usertype );

                //$manageTemplates         = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_templates' );
             //   $manageTrash                 = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_trash' );
             //   $manageMenuMan                 = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_menumanager' );
                //$manageLanguages         = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_languages' );
                //installers menu for administrative panel
                //$installModules         = $acl->acl_check( 'administration', 'install', 'users', $usertype, 'modules', 'all' );
                //Modules menu for administrative panel
               // $editAllModules         = $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'modules', 'all' );
                //mambots menu for admin panel call here
                //$installMambots         = $acl->acl_check( 'administration', 'install', 'users', $usertype, 'mambots', 'all' );
                //$editAllMambots         = $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'mambots', 'all' );
              //  $installComponents         = $acl->acl_check( 'administration', 'install', 'users', $usertype, 'components', 'all' );
              //  $editAllComponents         = $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'components', 'all' );
                $canMassMail                 = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_massmail' );
              //  $canManageUsers         = $acl->acl_check( 'administration', 'manage', 'users', $usertype, 'components', 'com_users' );

        $query = "SELECT a.id, a.title, a.name,"
        . "\nCOUNT(DISTINCT c.id) AS numcat, COUNT(DISTINCT b.id) AS numarc"
        . "\n FROM #__sections AS a"
        . "\n LEFT JOIN #__categories AS c ON c.section=a.id"
        . "\n LEFT JOIN #__content AS b ON b.sectionid=a.id AND b.state=-1"
        . "\n WHERE a.scope='content'"
        . "\n GROUP BY a.id"
        . "\n ORDER BY a.ordering"
        ;
        $database->setQuery( $query );
        $sections = $database->loadObjectList();
                $nonemptySections = 0;
                foreach ($sections as $section)
                        if ($section->numcat > 0)
                                $nonemptySections++;
                $menuTypes = mosAdminMenus::menutypes();
?>
                <div id="myMenuID"></div>
                <script language="JavaScript" type="text/javascript">
                var myMenu =
                [
<?php
        // Home Sub-Menu
?>                        [null,'Home','index2.php',null,'Control Panel'],
                        //  [null,'Membership','camellia_my/index.php',null,'Control Panel'],
                        _cmSplit,
<?php
        // Site Sub-Menu
?>                        [null,'Site',null,null,'Site Management',
<?php
                      ///  if ($canConfig)
                                          ///if ($usertype=='Super Administrator'|| $usertype=='Administrator')
                                          //{
?>                                ['<img src="../includes/js/ThemeOffice/config.png" />','Global Configuration','index2.php?option=com_config_bkmea',null,'Configuration'],<?php
                        //}
                        if ($manageLanguages) {
?>                                ['<img src="../includes/js/ThemeOffice/language.png" />','Language Manager',null,null,'Manage languages',
                                          ['<img src="../includes/js/ThemeOffice/language.png" />','Site Languages','index2.php?option=com_languages',null,'Manage Languages'],
                                          ['<img src="../includes/js/ThemeOffice/install.png" />','Install','index2.php?option=com_installer&element=language',null,'Install Languages'],
                                  ],
<?php
                        }
?>
//                                ['<img src="../includes/js/ThemeOffice/media.png" />','Media Manager','index2.php?option=com_media',null,'Manage Media Files'],
                                        ['<img src="../includes/js/ThemeOffice/preview.png" />', 'Preview', null, null, 'Preview',
                                        ['<img src="../includes/js/ThemeOffice/preview.png" />','In New Window','<?php echo $mosConfig_live_site; ?>/index.php','_blank','<?php echo $mosConfig_live_site; ?>'],
                                        ['<img src="../includes/js/ThemeOffice/preview.png" />','Inline','index2.php?option=com_admin&task=preview',null,'<?php echo $mosConfig_live_site; ?>'],
                                      //  ['<img src="../includes/js/ThemeOffice/preview.png" />','Inline with Positions','index2.php?option=com_admin&task=preview2',null,'<?php echo $mosConfig_live_site; ?>'],
                                ],

<?php /*     statistics from site menu
                                ['<img src="../includes/js/ThemeOffice/globe1.png" />', 'Statistics', null, null, 'Site Statistics',
<?php
                        if ($mosConfig_enable_stats == 1) {
?>                                        ['<img src="../includes/js/ThemeOffice/globe4.png" />', 'Browser, OS, Domain', 'index2.php?option=com_statistics', null, 'Browser, OS, Domain'],
                                          ['<img src="../includes/js/ThemeOffice/globe3.png" />', 'Page Impressions', 'index2.php?option=com_statistics&task=pageimp', null, 'Page Impressions'],
<?php
                        }
?>                                        ['<img src="../includes/js/ThemeOffice/search_text.png" />', 'Search Text', 'index2.php?option=com_statistics&task=searches', null, 'Search Text']
                                ],
 */ ?>
<?php
                        if ($manageTemplates) {
?>                                ['<img src="../includes/js/ThemeOffice/template.png" />','Template Manager',null,null,'Change site template',
                                          ['<img src="../includes/js/ThemeOffice/template.png" />','Site Templates','index2.php?option=com_templates',null,'Change site template'],
                                          ['<img src="../includes/js/ThemeOffice/install.png" />','Install','index2.php?option=com_installer&element=template&client=',null,'Install Site Templates'],
                                          _cmSplit,
                                          ['<img src="../includes/js/ThemeOffice/template.png" />','Administrator Templates','index2.php?option=com_templates&client=admin',null,'Change admin template'],
                                          ['<img src="../includes/js/ThemeOffice/install.png" />','Install','index2.php?option=com_installer&element=template&client=admin',null,'Install Administrator Templates'],
                                          _cmSplit,
                                          ['<img src="../includes/js/ThemeOffice/template.png" />','Module Positions','index2.php?option=com_templates&task=positions',null,'Template positions']
                                  ],
<?php
                        }
                        if ($manageTrash) {
?>                                ['<img src="../includes/js/ThemeOffice/trash.png" />','Trash Manager','index2.php?option=com_trash',null,'Manage Trash'],

<?php
                        }
?>
                                                   ['<img src="../includes/js/ThemeOffice/users.png" />','Your Details','index2.php?option=com_users&task=editA&id=<? echo $user_id; ?>&pd=?',null,'Your Details'],
<?php

                      ///  if ($canManageUsers || $canMassMail) {
                                                if ($usertype=='Super Administrator'||$usertype=='Administrator')
                                                {
?>                                ['<img src="../includes/js/ThemeOffice/users.png" />','User Manager','index2.php?option=com_users&task=view',null,'Manage users'],
<?php
                                                }
                     ///           }
?>                        ],
<?php
        // Menu Sub-Menu
?>                        _cmSplit,

<?php
                        if ($manageMenuMan) {
?>
                                                        [null,'Menu',null,null,'Menu Management',
                                ['<img src="../includes/js/ThemeOffice/menus.png" />','Menu Manager','index2.php?option=com_menumanager',null,'Menu Manager'],
                                _cmSplit,
<?php

                        foreach ( $menuTypes as $menuType ) {
?>                                ['<img src="../includes/js/ThemeOffice/menus.png" />','<?php echo $menuType;?>','index2.php?option=com_menus&menutype=<?php echo $menuType;?>',null,''],
<?php
                        }
                                                ?>
                                                ],
                                <?php
                                        }
?>
                        _cmSplit,
<?php
        // Content Sub-Menu
?>                  //     [null,'Content',null,null,'Content Management',
<?php
         //               if (count($sections) > 0) {
?>         //                       ['<img src="../includes/js/ThemeOffice/edit.png" />','Content by Section',null,null,'Content Managers',
<?php
             //                   foreach ($sections as $section) {
               //                         $txt = addslashes( $section->title ? $section->title : $section->name );
?>               //                         ['<img src="../includes/js/ThemeOffice/document.png" />','<?php echo $txt;?>', null, null,'<?php echo $txt;?>',
<?php
                   //                     if ($section->numcat) {
?>                   //                             ['<img src="../includes/js/ThemeOffice/edit.png" />', '<?php echo $txt;?> Items', 'index2.php?option=com_content&sectionid=<?php echo $section->id;?>',null,null],
<?php
                       //                 }
?>                      //                          ['<img src="../includes/js/ThemeOffice/add_section.png" />', 'Add/Edit <?php echo $txt;?> Categories', 'index2.php?option=com_categories&section=<?php echo $section->id;?>',null, null],
<?php
                         //               if ($section->numarc) {
?>                        //                        ['<img src="../includes/js/ThemeOffice/backup.png" />', '<?php echo $txt;?> Archive', 'index2.php?option=com_content&task=showarchive&sectionid=<?php echo $section->id;?>',null,null],
<?php
    //                                    }
?>      //                                  ],
<?php
      //                          } // foreach
?>       //                         ],
          //                      _cmSplit,
<?php
           //             }
?>
             //                   ['<img src="../includes/js/ThemeOffice/edit.png" />','All Content Items','index2.php?option=com_content&sectionid=0',null,'Manage Content Items'],
//                                  ['<img src="../includes/js/ThemeOffice/edit.png" />','Static Content Manager','index2.php?option=com_typedcontent',null,'Manage Typed Content Items'],
               //                   _cmSplit,
                  //                ['<img src="../includes/js/ThemeOffice/add_section.png" />','Section Manager','index2.php?option=com_sections&scope=content',null,'Manage Content Sections'],
<?php
         //               if (count($sections) > 0) {
?>        //                        ['<img src="../includes/js/ThemeOffice/add_section.png" />','Category Manager','index2.php?option=com_categories&section=content',null,'Manage Content Categories'],
<?php
         //               }
?>         //                       _cmSplit,
   //                               ['<img src="../includes/js/ThemeOffice/home.png" />','Frontpage Manager','index2.php?option=com_frontpage',null,'Manage Frontpage Items'],
    //                              ['<img src="../includes/js/ThemeOffice/edit.png" />','Archive Manager','index2.php?option=com_content&task=showarchive&sectionid=0',null,'Manage Archive Items'],
    //                   ],
        //_cmSplit,
           [null,'Member',null,null,'Member Management',
        <?php
                if ($usertype=='Super Administrator' )
                {
                ?>
                            ['<img src="../includes/js/ThemeOffice/content.png" />','Member Category','index2.php?option=com_member_category_bkmea',null,'Member Category'],
                         // ['<img src="../includes/js/ThemeOffice/language.png" />','Member Type','index2.php?option=com_member_type',null,'Member Type'],
                         ['<img src="../includes/js/ThemeOffice/content.png" />','Registration Year','index2.php?option=com_member_reg_year_bkmea',null,'Registration Year'],
                         ['<img src="../includes/js/ThemeOffice/content.png" />','Charge Setup','index2.php?option=com_membership_charge_bkmea',null,'Charge Setup'],
         <?php
                 }
         ?>
                          ['<img src="../includes/js/ThemeOffice/content.png" />','Member Profile','index2.php?option=com_membership_bkmea',null,'Member Profile'],
                          ['<img src="../includes/js/ThemeOffice/content.png" />','Non Member Profile','index2.php?option=com_non_member_scci',null,'Non Member Profile'],
                           ['<img src="../includes/js/ThemeOffice/content.png" />','Member Renew','index2.php?option=com_membership_renew_bkmea',null,'Member Renew'],
                         ['<img src="../includes/js/ThemeOffice/content.png" />','Member Certificate','index2.php?option=com_membership_certificate_bkmea',null,'Member Certificate'],


           ],
           _cmSplit,
           [null,'Info Product',null,null,'Info Product',
//                            ['<img src="../includes/js/ThemeOffice/language.png" />','Configuration','index2.php?option=com_docman&section=config',null,'Configuration'],
                            ['<img src="../includes/js/ThemeOffice/content.png" />','Product Category','index2.php?option=com_docman&section=categories',null,'Product Category'],
                            ['<img src="../includes/js/ThemeOffice/content.png" />','Product Management','index2.php?option=com_docman&section=documents',null,'Product Management']
                           /* ['<img src="../includes/js/ThemeOffice/language.png" />','Product Statistics','index2.php?option=com_docman&task=stats',null,'Product Statistics']*/


           ],
             _cmSplit,
                        [null,'Manage',null,null,'Manage',

                           ['<img src="../includes/js/ThemeOffice/content.png" />','Circulars','index2.php?option=com_circular',null,'Circulars'],
                           ['<img src="../includes/js/ThemeOffice/content.png" />','Trade Fair','index2.php?option=com_trade_fair',null,'Trade Fair'],
                           ['<img src="../includes/js/ThemeOffice/content.png" />','Trade Leads','index2.php?option=com_trade_lead',null,'Trade Leads']
                           ,['<img src="../includes/js/ThemeOffice/content.png" />','HS Code','index2.php?option=com_hscode_registration','manage','HS Code']
                           ,['<img src="../includes/js/ThemeOffice/content.png" />','Manage Board of Director','index2.php?option=com_board_of_director','manage','Manage Board of Director']
                        ],
         _cmSplit,
            [null,'Report',null,null,'Report',
                             ['<img src="../includes/js/ThemeOffice/document.png" />','Member List','index2.php?option=com_member_report_bkmea&for=0',null,'Member List']
                            ,['<img src="../includes/js/ThemeOffice/document.png" />','All Member List','index2.php?option=com_all_member_report_bkmea',null,'All Member List']
                            ,['<img src="../includes/js/ThemeOffice/document.png" />','Outstanding Subscription','index2.php?option=com_member_report_bkmea&for=1',null,'Outstanding Subscription']
                            ,['<img src="../includes/js/ThemeOffice/document.png" />','Mailing List','index2.php?option=com_mail_merge_bkmea&for=0',null,'Mailing List']
                            ,['<img src="../includes/js/ThemeOffice/document.png" />','All Mailing List','index2.php?option=com_all_mail_merge_bkmea',null,'All Mailing List']
                            ,['<img src="../includes/js/ThemeOffice/document.png" />','Top Member','index2.php?option=com_top_member_report_bkmea',null,'Top Member']


                        <?php
                        /*if($usertype=='Super Administrator'){ ?>
                           ,['<img src="../includes/js/ThemeOffice/language.png" />','Accounts Report','index2.php?option=com_accounts_transaction_report_bkmea',null,'Accounts Report']
                           ,['<img src="../includes/js/ThemeOffice/language.png" />','History',null,null,'History',
                             ['<img src="../includes/js/ThemeOffice/language.png" />','Member','index2.php?option=com_member_history_report&for=bkmea',null,'Member'],
                             ['<img src="../includes/js/ThemeOffice/language.png" />','User','index2.php?option=com_user_report&for=bkmea',null,'User']

                           ]*/
                        if($usertype=='Super Administrator'){ ?>
                           ,['<img src="../includes/js/ThemeOffice/document.png" />','Accounts Report','index2.php?option=com_accounts_transaction_report_bkmea',null,'Accounts Report']
                           ,['<img src="../includes/js/ThemeOffice/sections.png" />','History',null,null,'History',
                             ['<img src="../includes/js/ThemeOffice/document.png" />','Member','index2.php?option=com_member_history_report&for=bkmea',null,'Member'],
                             ['<img src="../includes/js/ThemeOffice/document.png" />','User','index2.php?option=com_user_report&for=bkmea',null,'User']
                             ]
                            ,['<img src="../includes/js/ThemeOffice/sections.png" />','Info Product',null,null,'Info Product',
                             ['<img src="../includes/js/ThemeOffice/document.png" />','Info Product Sales','index2.php?option=com_info_product_sales_report&for=bkmea',null,'Info Product Sales Report'],
                             ['<img src="../includes/js/ThemeOffice/document.png" />','Info Product List','index2.php?option=com_info_product_list_report&for=bkmea',null,'Info Product List'],
                             ['<img src="../includes/js/ThemeOffice/document.png" />','Customer','index2.php?option=com_info_product_customer_report&for=bkmea',null,'Customer']

                           ]
                        <?php
                        }
                        if ($usertype=='Super Administrator'||$usertype=='Administrator')
                                {
                                ?>
                        //,['<img src="../includes/js/ThemeOffice/language.png" />','Users',null,null,'Users',
                        //['<img src="../includes/js/ThemeOffice/language.png" />','Admin Users','',null,'Admin Users'],
                        //['<img src="../includes/js/ThemeOffice/language.png" />','Registered Members','',null,'Registered Users'],
                        //]
                        <?php
                                }
                                ?>
           ],
         _cmSplit,
            [null,'Tools',null,null,'Tools',
                       ['<img src="../includes/js/ThemeOffice/config.png" />','Check Money Receipt Number','../popup/checkMoneyReceipt.php','_blank','Check Money Receipt Number'],
                       ['<img src="../includes/js/ThemeOffice/config.png" />','Database Backups','index2.php?option=com_babackup&task=showdb',null,'Database Backups'],
                       ['<img src="../includes/js/ThemeOffice/config.png" />','Set Permission','../popup/setpermission.php','_blank','Set Permission'],
                       ['<img src="../includes/js/ThemeOffice/config.png" />','Search HS Code','index2.php?option=com_search_existing_hscode','tools','Search HS Code'],
                       ['<img src="../includes/js/ThemeOffice/config.png" />','Import TIS Data','index2.php?option=com_import',null,'Import TIS Data']
                       /*['<img src="../includes/js/ThemeOffice/config.png" />','Backup',null,null,'Site Backup',
                              ['<img src="../includes/js/ThemeOffice/backup.png" />','Create Backup','index2.php?option=com_babackup&task=confirm',null,'Create Backup'],
                              ['<img src="../includes/js/ThemeOffice/db.png" />','Database Backups','index2.php?option=com_babackup&task=showdb',null,'Database Backups'],
                              ['<img src="../includes/js/ThemeOffice/preview.png" />','Site Backups','index2.php?option=com_babackup&task=show',null,'Site Backups']
                       ] */
           ],
<?php
        // Components Sub-Menu
        if ($installComponents) {
?>                        _cmSplit,
                        [null,'Components',null,null,'Component Management',
//                                ['<img src="../includes/js/ThemeOffice/install.png" />','Install/Uninstall','index2.php?option=com_installer&element=component',null,'Install/Uninstall components'],
//                                _cmSplit,
<?php
        $query = "SELECT * FROM #__components WHERE name <> 'frontpage' and name <> 'media manager' ORDER BY id"
        ;
        $database->setQuery( $query );
        $comps = $database->loadObjectList();   // component list
        $subs = array();    // sub menus
        // first pass to collect sub-menu items
        foreach ($comps as $row) {
            if ($row->parent) {
                if (!array_key_exists( $row->parent, $subs )) {
                    $subs[$row->parent] = array();
                }
                $subs[$row->parent][] = $row;
            }
        }
        $topLevelLimit = 19; //You can get 19 top levels on a 800x600 Resolution
        $topLevelCount = 0;
        foreach ($comps as $row) {
            if ($editAllComponents | $acl->acl_check( 'administration', 'edit', 'users', $usertype, 'components', $row->option )) {
                if ($row->parent == 0 && (trim( $row->admin_menu_link ) || array_key_exists( $row->id, $subs ))) {
                    $topLevelCount++;
                    if ($topLevelCount > $topLevelLimit) {
                        continue;
                    }
                    $name = addslashes( $row->name );
                    $alt = addslashes( $row->admin_menu_alt );
                    $link = $row->admin_menu_link ? "'index2.php?$row->admin_menu_link'" : "null";
                    echo "\t\t\t\t['<img src=\"../includes/$row->admin_menu_img\" />','$name',$link,null,'$alt'";
                    if (array_key_exists( $row->id, $subs )) {
                        foreach ($subs[$row->id] as $sub) {
                                echo ",\n";
                            $name = addslashes( $sub->name );
                            $alt = addslashes( $sub->admin_menu_alt );
                            $link = $sub->admin_menu_link ? "'index2.php?$sub->admin_menu_link'" : "null";
                            echo "\t\t\t\t\t['<img src=\"../includes/$sub->admin_menu_img\" />','$name',$link,null,'$alt']";
                        }
                    }
                    echo "\n\t\t\t\t],\n";
                }
            }
        }
        if ($topLevelLimit < $topLevelCount) {
            echo "\t\t\t\t['<img src=\"../includes/js/ThemeOffice/sections.png\" />','More Components...','index2.php?option=com_admin&task=listcomponents',null,'More Components'],\n";
        }
?>
                        ],
<?php
        // Modules Sub-Menu
                if ($installModules | $editAllModules) {
?>                        _cmSplit,
                        [null,'Modules',null,null,'Module Management',
<?php
                        if ($installModules) {
?>                                ['<img src="../includes/js/ThemeOffice/install.png" />', 'Install/Uninstall', 'index2.php?option=com_installer&element=module', null, 'Install custom modules'],
                                _cmSplit,
<?php
                        }
                        if ($editAllModules) {
?>                                ['<img src="../includes/js/ThemeOffice/module.png" />', 'Site Modules', "index2.php?option=com_modules", null, 'Manage Site modules'],
                                ['<img src="../includes/js/ThemeOffice/module.png" />', 'Administrator Modules', "index2.php?option=com_modules&client=admin", null, 'Manage Administrator modules'],
<?php
                        }
?>                        ],
<?php
                } // if ($installModules | $editAllModules)
        } // if $installComponents
        // Mambots Sub-Menu
        if ($installMambots | $editAllMambots) {
?>                        _cmSplit,
                        [null,'Mambots',null,null,'Mambot Management',
<?php
                if ($installMambots) {
?>                                ['<img src="../includes/js/ThemeOffice/install.png" />', 'Install/Uninstall', 'index2.php?option=com_installer&element=mambot', null, 'Install custom mambot'],
                                _cmSplit,
<?php
                }
                if ($editAllMambots) {
?>                                ['<img src="../includes/js/ThemeOffice/module.png" />', 'Site Mambots', "index2.php?option=com_mambots", null, 'Manage Site Mambots'],
<?php
                }
?>                        ],
<?php
        }
?>
<?php
        // Installer Sub-Menu
        if ($installModules) {
?>                        _cmSplit,
                        [null,'Installers',null,null,'Installer List',
<?php
                if ($manageTemplates) {
?>                                ['<img src="../includes/js/ThemeOffice/install.png" />','Templates - Site','index2.php?option=com_installer&element=template&client=',null,'Install Site Templates'],
                                ['<img src="../includes/js/ThemeOffice/install.png" />','Templates - Admin','index2.php?option=com_installer&element=template&client=admin',null,'Install Administrator Templates'],
<?php
                }
                if ($manageLanguages) {
?>                                ['<img src="../includes/js/ThemeOffice/install.png" />','Languages','index2.php?option=com_installer&element=language',null,'Install Languages'],
                                _cmSplit,
<?php
                }
?>                                ['<img src="../includes/js/ThemeOffice/install.png" />', 'Components','index2.php?option=com_installer&element=component',null,'Install/Uninstall Components'],
                                ['<img src="../includes/js/ThemeOffice/install.png" />', 'Modules', 'index2.php?option=com_installer&element=module', null, 'Install/Uninstall Modules'],
                                ['<img src="../includes/js/ThemeOffice/install.png" />', 'Mambots', 'index2.php?option=com_installer&element=mambot', null, 'Install/Uninstall Mambots'],
                        ],
<?php
        } // if ($installModules)
        // Messages Sub-Menu
        if ($canConfig) {
?>     //                   _cmSplit,
       //                   [null,'Messages',null,null,'Messaging Management',
        //                          ['<img src="../includes/js/ThemeOffice/messaging_inbox.png" />','Inbox','index2.php?option=com_messages',null,'Private Messages'],
        //                          ['<img src="../includes/js/ThemeOffice/messaging_config.png" />','Configuration','index2.php?option=com_messages&task=config&hidemainmenu=1',null,'Configuration']
        //                  ],
<?php
        // System Sub-Menu
?>                      //  _cmSplit,
                       //   [null,'System',null,null,'System Management',
<?php
                //  if ($canConfig) {
?>              //                  ['<img src="../includes/js/ThemeOffice/checkin.png" />', 'Global Checkin', 'index2.php?option=com_checkin', null,'Check-in all checked-out items'],
<?php
                //        if ($mosConfig_caching) {
?>              //                  ['<img src="../includes/js/ThemeOffice/config.png" />','Clean Cache','index2.php?option=com_content&task=clean_cache',null,'Clean the content items cache'],
<?php
                //        }
                //}
?>              //          ],
<?php
                        }
?>
                        _cmSplit,
<?php
        // Help Sub-Menu
?>                 //       [null,'Help','index2.php?option=com_admin&task=help',null,null]

                ];
                cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice');
                </script>
<?php
        }
}
$cache =& mosCache::getCache( 'mos_fullmenu' );

mosFullAdminMenu::show( $my->usertype );
//$cache->call( 'mosFullAdminMenu::show', $my->usertype );
?>
