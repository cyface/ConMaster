# phpMyAdmin MySQL-Dump
# version 2.3.0-rc2
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jul 14, 2002 at 07:10 PM
# Server version: 3.23.51
# PHP Version: 4.1.2
# Database : `cyface`
# --------------------------------------------------------

#
# Table structure for table `convention`
#

DROP TABLE IF EXISTS convention;
CREATE TABLE convention (
  id int(11) unsigned NOT NULL auto_increment,
  name varchar(50) NOT NULL default '',
  sponsor_organization varchar(50) NOT NULL default '',
  rpga_convention_code varchar(20) NOT NULL default '',
  web_site_url varchar(200) NOT NULL default '',
  last_modified timestamp(14) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='Information about each convention';

#
# Dumping data for table `convention`
#

INSERT INTO convention VALUES (1, 'Ben Con 1999', 'the RMBGA', 'BEN599CO', 'http://bengames.org/bencon', 20020703143828);
