# phpMyAdmin MySQL-Dump
# version 2.3.0-rc2
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jul 19, 2002 at 03:16 PM
# Server version: 3.23.51
# PHP Version: 4.1.2
# Database : `cyface`
# --------------------------------------------------------

#
# Table structure for table `constant`
#

DROP TABLE IF EXISTS constant;
CREATE TABLE constant (
  id int(10) unsigned NOT NULL auto_increment,
  constant varchar(255) NOT NULL default '',
  name varchar(255) NOT NULL default '',
  value varchar(255) default NULL,
  extra_info varchar(255) default NULL,
  ordinal int(10) default NULL,
  convention_id int(10) unsigned NOT NULL default '1',
  last_modified timestamp(14) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='Constants, such as lists of values';

#
# Dumping data for table `constant`
#

INSERT INTO constant VALUES (1, 'reg_type', 'Pre-Reg', '10', 'Pre', 1, 1, 20020719113717);
INSERT INTO constant VALUES (2, 'reg_type', 'FRI Only', '10', 'One-Day', 3, 1, 20020719113737);
INSERT INTO constant VALUES (3, 'reg_type', 'SAT Only', '10', 'One-Day', 4, 1, 20020719113742);
INSERT INTO constant VALUES (4, 'reg_type', 'SUN Only', '10', 'One-Day', 5, 1, 20020719113752);
INSERT INTO constant VALUES (5, 'reg_type', 'Weekend', '15', 'On-Site', 2, 1, 20020719113831);
INSERT INTO constant VALUES (6, 'reg_type', 'VIP', '150', NULL, 6, 1, 20020719113912);
INSERT INTO constant VALUES (7, 'reg_type', 'THU Only', '10', NULL, 7, 1, 20020719114022);
INSERT INTO constant VALUES (8, 'reg_type', 'Staff', '0', NULL, 10, 1, 20020719140804);

