# phpMyAdmin MySQL-Dump
# version 2.3.0-rc2
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jul 29, 2002 at 02:43 PM
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
INSERT INTO constant VALUES (9, 'event_type', 'Role-Playing', NULL, NULL, 10, 1, 20020722103739);
INSERT INTO constant VALUES (10, 'event_type', 'Boardgame', '5', NULL, 20, 1, 20020722104820);
INSERT INTO constant VALUES (11, 'event_type', 'Miniatures', '5', NULL, NULL, 1, 20020722104840);
INSERT INTO constant VALUES (12, 'event_type', 'LARP', '10', NULL, 20, 1, 20020722104859);
INSERT INTO constant VALUES (13, 'event_type', 'Puffing Billy', '5', NULL, NULL, 1, 20020722104926);
INSERT INTO constant VALUES (14, 'event_type', 'Card Game', '5', NULL, NULL, 1, 20020722104940);
INSERT INTO constant VALUES (15, 'event_type', 'Mechandise', NULL, NULL, NULL, 1, 20020722105012);
INSERT INTO constant VALUES (16, 'event_type', 'Demonstration', '0', NULL, NULL, 1, 20020722105022);
INSERT INTO constant VALUES (17, 'event_type', 'Seminar', '0', NULL, NULL, 1, 20020722105036);
INSERT INTO constant VALUES (18, 'event_type', 'Special Event', NULL, NULL, NULL, 1, 20020722105102);
INSERT INTO constant VALUES (19, 'rpga_event_type', 'Benefit', 'BE', NULL, NULL, 1, 20020729143507);
INSERT INTO constant VALUES (20, 'rpga_event_type', 'Feature', 'FE', NULL, NULL, 1, 20020729143518);
INSERT INTO constant VALUES (21, 'rpga_event_type', 'Masters', 'MA', NULL, NULL, 1, 20020729143530);
INSERT INTO constant VALUES (22, 'rpga_event_type', 'Grand Masters', 'GM', NULL, NULL, 1, 20020729143544);
INSERT INTO constant VALUES (23, 'rpga_event_type', 'Paragon', 'PA', NULL, NULL, 1, 20020729143556);
INSERT INTO constant VALUES (24, 'rpga_event_type', 'Team', 'TE', NULL, NULL, 1, 20020729143607);
INSERT INTO constant VALUES (25, 'event_level', 'Beginner - Rules Taught', NULL, NULL, NULL, 1, 20020722105524);
INSERT INTO constant VALUES (26, 'event_level', 'Beginner', NULL, NULL, NULL, 1, 20020722105530);
INSERT INTO constant VALUES (27, 'event_level', 'Intermediate', NULL, NULL, NULL, 1, 20020722105542);
INSERT INTO constant VALUES (28, 'event_level', 'Advanced', NULL, NULL, NULL, 1, 20020722105546);

