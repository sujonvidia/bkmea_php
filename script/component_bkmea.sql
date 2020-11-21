/* 
SQLyog v4.0
Host - localhost : Database - camellia_db
**************************************************************
Server version 4.1.14-nt-log
*/

create database if not exists `camellia_db`;

use `camellia_db`;

/*
Table structure for mos_components
*/

drop table if exists `mos_components`;
CREATE TABLE `mos_components` (
  `id` int(11) NOT NULL auto_increment,
  `name` varchar(50) NOT NULL default '',
  `link` varchar(255) NOT NULL default '',
  `menuid` int(11) unsigned NOT NULL default '0',
  `parent` int(11) unsigned NOT NULL default '0',
  `admin_menu_link` varchar(255) NOT NULL default '',
  `admin_menu_alt` varchar(255) NOT NULL default '',
  `option` varchar(50) NOT NULL default '',
  `ordering` int(11) NOT NULL default '0',
  `admin_menu_img` varchar(255) NOT NULL default '',
  `iscore` tinyint(4) NOT NULL default '0',
  `params` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

/*
Table data for camellia_db.mos_components
*/

INSERT INTO `mos_components` VALUES 
(18,'Membership Renew','',0,11,'option=com_membership_renew','Membership Renew','com_membership_renew',0,'js/ThemeOffice/user.png',0,''),
(19,'Membership certificate','',0,11,'option=com_membership_certificate','Membership Certificate','com_membership_certificate',0,'js/ThemeOffice/user.png',0,''),
;

