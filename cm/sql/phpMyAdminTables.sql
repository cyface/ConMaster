# phpMyAdmin MySQL-Dump
# version 2.3.0-rc2
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jul 14, 2002 at 07:24 PM
# Server version: 3.23.51
# PHP Version: 4.1.2
# Database : `cyface`
# --------------------------------------------------------

#
# Table structure for table `pma_bookmark`
#

DROP TABLE IF EXISTS pma_bookmark;
CREATE TABLE pma_bookmark (
  id int(11) NOT NULL auto_increment,
  dbase varchar(255) NOT NULL default '',
  user varchar(255) NOT NULL default '',
  label varchar(255) NOT NULL default '',
  query text NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `pma_bookmark`
#

INSERT INTO pma_bookmark VALUES (1, 'cyface', 'cyface', 'person_state_count', 'SELECT state, count(*) FROM person GROUP BY state');
INSERT INTO pma_bookmark VALUES (2, 'cyface', 'cyface', 'person_city_count', 'SELECT city, count(*) FROM person WHERE state = \'CO\' GROUP BY city');
# --------------------------------------------------------

#
# Table structure for table `pma_column_comments`
#

DROP TABLE IF EXISTS pma_column_comments;
CREATE TABLE pma_column_comments (
  id int(5) unsigned NOT NULL auto_increment,
  db_name varchar(64) NOT NULL default '',
  table_name varchar(64) NOT NULL default '',
  column_name varchar(64) NOT NULL default '',
  comment varchar(255) NOT NULL default '',
  PRIMARY KEY  (id),
  UNIQUE KEY db_name (db_name,table_name,column_name)
) TYPE=MyISAM;

#
# Dumping data for table `pma_column_comments`
#

# --------------------------------------------------------

#
# Table structure for table `pma_pdf_pages`
#

DROP TABLE IF EXISTS pma_pdf_pages;
CREATE TABLE pma_pdf_pages (
  db_name varchar(64) NOT NULL default '',
  page_nr int(10) unsigned NOT NULL auto_increment,
  page_descr varchar(50) NOT NULL default '',
  PRIMARY KEY  (page_nr),
  KEY db_name (db_name)
) TYPE=MyISAM;

#
# Dumping data for table `pma_pdf_pages`
#

INSERT INTO pma_pdf_pages VALUES ('cyface', 1, 'a');
# --------------------------------------------------------

#
# Table structure for table `pma_relation`
#

DROP TABLE IF EXISTS pma_relation;
CREATE TABLE pma_relation (
  master_db varchar(64) NOT NULL default 'cyface',
  master_table varchar(64) NOT NULL default '',
  master_field varchar(64) NOT NULL default '',
  foreign_db varchar(64) NOT NULL default 'cyface',
  foreign_table varchar(64) NOT NULL default '',
  foreign_field varchar(64) NOT NULL default '',
  PRIMARY KEY  (master_db,master_table,master_field),
  KEY foreign_field (foreign_db,foreign_table)
) TYPE=MyISAM;

#
# Dumping data for table `pma_relation`
#

INSERT INTO pma_relation VALUES ('cyface', 'event', 'convention_id', 'cyface', 'convention', 'id');
INSERT INTO pma_relation VALUES ('cyface', 'person', 'convention_id', 'cyface', 'convention', 'id');
INSERT INTO pma_relation VALUES ('cyface', 'person_section', 'convention_id', 'cyface', 'convention', 'id');
INSERT INTO pma_relation VALUES ('cyface', 'score_packet', 'convention_id', 'cyface', 'convention', 'id');
INSERT INTO pma_relation VALUES ('cyface', 'section', 'convention_id', 'cyface', 'convention', 'id');
INSERT INTO pma_relation VALUES ('cyface', 'person_section', 'person_id', 'cyface', 'person', 'id');
INSERT INTO pma_relation VALUES ('cyface', 'person_section', 'section_id', 'cyface', 'section', 'id');
INSERT INTO pma_relation VALUES ('cyface', 'person_section', 'score_packet_id', 'cyface', 'score_packet', 'id');
INSERT INTO pma_relation VALUES ('cyface', 'section', 'event_id', 'cyface', 'event', 'id');
INSERT INTO pma_relation VALUES ('cyface', 'event', 'contact_person_id', 'cyface', 'person', 'id');
# --------------------------------------------------------

#
# Table structure for table `pma_table_coords`
#

DROP TABLE IF EXISTS pma_table_coords;
CREATE TABLE pma_table_coords (
  db_name varchar(64) NOT NULL default '',
  table_name varchar(64) NOT NULL default '',
  pdf_page_number int(11) NOT NULL default '0',
  x float(10,2) unsigned NOT NULL default '0.00',
  y float(10,2) unsigned NOT NULL default '0.00',
  PRIMARY KEY  (db_name,table_name,pdf_page_number)
) TYPE=MyISAM;

#
# Dumping data for table `pma_table_coords`
#

INSERT INTO pma_table_coords VALUES ('cyface', 'convention', 1, '10.00', '10.00');
INSERT INTO pma_table_coords VALUES ('cyface', 'person', 1, '200.00', '200.00');
# --------------------------------------------------------

#
# Table structure for table `pma_table_info`
#

DROP TABLE IF EXISTS pma_table_info;
CREATE TABLE pma_table_info (
  db_name varchar(64) NOT NULL default '',
  table_name varchar(64) NOT NULL default '',
  display_field varchar(64) NOT NULL default '',
  PRIMARY KEY  (db_name,table_name)
) TYPE=MyISAM;

#
# Dumping data for table `pma_table_info`
#


