# phpMyAdmin MySQL-Dump
# version 2.3.0-rc2
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jul 18, 2002 at 03:47 PM
# Server version: 3.23.51
# PHP Version: 4.1.2
# Database : `cyface`
# --------------------------------------------------------

#
# Table structure for table `note`
#

DROP TABLE IF EXISTS note;
CREATE TABLE note (
  id int(10) unsigned NOT NULL auto_increment,
  parent_table varchar(80) NOT NULL default '',
  parent_id int(10) unsigned NOT NULL default '0',
  subject varchar(255) default NULL,
  body text,
  sender varchar(80) NOT NULL default '',
  last_modified timestamp(14) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='Notes that can be attached to any object.';

#
# Dumping data for table `note`
#

INSERT INTO note VALUES (1, 'convention', 1, 'Hotel', 'The hotel for this convention was one of the stapleton hotels.', 'tlwhit2', 20020717174136);
INSERT INTO note VALUES (20, 'convention', 1, 'd', NULL, '', 20020718142350);
INSERT INTO note VALUES (19, 'convention', 1, 'c', NULL, '', 20020718142348);
INSERT INTO note VALUES (17, 'convention', 1, 'a', NULL, '', 20020718142344);
INSERT INTO note VALUES (18, 'convention', 1, 'b', NULL, '', 20020718142347);
INSERT INTO note VALUES (21, 'convention', 1, 'e', NULL, '', 20020718142352);
INSERT INTO note VALUES (22, 'convention', 1, 'f', NULL, '', 20020718142354);
INSERT INTO note VALUES (23, 'person', 1079, 'Swell Guy!', 'Boy, that Tim is a swell guy!', 'tlwhit2', 20020718143239);

