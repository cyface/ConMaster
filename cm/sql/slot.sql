# phpMyAdmin MySQL-Dump
# version 2.3.0-rc2
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jul 17, 2002 at 10:34 AM
# Server version: 3.23.51
# PHP Version: 4.1.2
# Database : `cyface`
# --------------------------------------------------------

#
# Table structure for table `slot`
#

DROP TABLE IF EXISTS slot;
CREATE TABLE slot (
  id int(10) unsigned NOT NULL auto_increment,
  slot_number int(10) unsigned NOT NULL default '0',
  date date NOT NULL default '0000-00-00',
  start_time time NOT NULL default '00:00:00',
  end_time time NOT NULL default '00:00:00',
  convention_id int(10) unsigned NOT NULL default '1',
  PRIMARY KEY  (id),
  UNIQUE KEY slot_number (slot_number,convention_id)
) TYPE=MyISAM COMMENT='Possible times sections can run';

#
# Dumping data for table `slot`
#

INSERT INTO slot VALUES (1, 0, '1999-05-28', '08:00:00', '12:00:00', 1);
INSERT INTO slot VALUES (2, 1, '1999-05-28', '18:00:00', '22:00:00', 1);
INSERT INTO slot VALUES (3, 2, '1999-05-28', '22:00:00', '02:00:00', 1);
INSERT INTO slot VALUES (4, 3, '1999-05-29', '08:00:00', '12:00:00', 1);
INSERT INTO slot VALUES (5, 4, '1999-05-29', '12:30:00', '16:30:00', 1);
INSERT INTO slot VALUES (6, 5, '1999-05-29', '17:00:00', '21:00:00', 1);
INSERT INTO slot VALUES (7, 6, '1999-05-29', '21:00:00', '01:00:00', 1);
INSERT INTO slot VALUES (8, 7, '1999-05-30', '08:00:00', '12:00:00', 1);
INSERT INTO slot VALUES (9, 8, '1999-05-30', '12:30:00', '16:30:00', 1);
INSERT INTO slot VALUES (10, 9, '1999-05-30', '17:00:00', '21:00:00', 1);
INSERT INTO slot VALUES (11, 10, '1999-05-30', '21:00:00', '01:00:00', 1);
INSERT INTO slot VALUES (12, 11, '1999-05-31', '08:00:00', '12:00:00', 1);
INSERT INTO slot VALUES (13, 12, '1999-05-31', '12:30:00', '16:30:00', 1);
INSERT INTO slot VALUES (14, 13, '1999-05-31', '17:00:00', '19:00:00', 1);

