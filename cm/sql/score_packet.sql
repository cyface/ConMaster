# phpMyAdmin MySQL-Dump
# version 2.3.0
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Aug 12, 2002 at 02:31 PM
# Server version: 3.23.51
# PHP Version: 4.1.2
# Database : `cyface`
# --------------------------------------------------------

#
# Table structure for table `score_packet`
#

DROP TABLE IF EXISTS score_packet;
CREATE TABLE score_packet (
  id int(11) unsigned NOT NULL auto_increment,
  person_id int(11) unsigned NOT NULL default '0',
  event_id int(11) unsigned NOT NULL default '0',
  section_id int(11) unsigned NOT NULL default '0',
  scenario_score tinyint(4) unsigned default NULL,
  prorated_scenario_score int(10) unsigned default NULL,
  group_score tinyint(4) unsigned default NULL,
  number_of_players tinyint(4) unsigned default NULL,
  rpga_event_type varchar(15) NOT NULL default 'Feature',
  no_vote varchar(7) default NULL,
  status varchar(15) NOT NULL default 'Incomplete',
  convention_id int(11) unsigned NOT NULL default '1',
  last_modified timestamp(14) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `score_packet`
#

INSERT INTO score_packet VALUES (1, 1163, 107, 133, 61, 61, 28, 6, 'Benefit', NULL, 'Complete', 1, 20020812140538);
INSERT INTO score_packet VALUES (2, 20063, 107, 133, 73, 85, 19, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (3, 995, 108, 138, 81, 81, 23, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (4, 501, 108, 138, 70, 82, 27, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (5, 71, 113, 155, 80, 93, 24, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (7, 568, 113, 155, 74, 74, 28, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (8, 708, 118, 169, 74, 74, 25, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (10, 521, 112, 151, 76, 76, 21, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (11, 397, 112, 151, 80, 80, 25, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (13, 158, 116, 160, 69, 80, 24, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (15, 1163, 110, 142, 90, 90, 28, 6, 'Masters', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (16, 1115, 110, 142, 85, 99, 30, 5, 'Masters', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (17, 708, 114, 157, 75, 75, 24, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (18, 351, 114, 157, 73, NULL, 24, 7, 'Benefit', NULL, 'Complete', 1, 20020805110449);
INSERT INTO score_packet VALUES (19, 181, 114, 157, 90, NULL, 30, 7, 'Benefit', NULL, 'Complete', 1, 20020805110449);
INSERT INTO score_packet VALUES (22, 71, 187, 261, 92, 92, 29, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (24, 84, 193, 269, 95, 95, 26, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (25, 1163, 109, 139, 93, 93, 28, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (27, 20084, 107, 132, 71, 83, 25, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (29, 20063, 107, 129, 69, 80, 21, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (32, 397, 114, 158, 67, 67, 30, 6, 'Grand Masters', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (33, 568, 107, 129, 75, 87, 26, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (34, 84, 122, 178, 97, 97, 18, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (35, 265, 109, 139, 91, 91, 26, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (36, 1163, 110, 145, 102, 102, 30, 6, 'Grand Masters', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (37, 71, 110, 145, 85, 85, 27, 6, 'Masters', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (43, 1061, 119, 171, 69, 80, 28, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (44, 521, 113, 154, 75, 87, 25, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (45, 84, 108, 136, 95, 95, 27, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (53, 2049, 108, 134, 83, 83, 20, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (54, 192, 113, 154, 127, 127, 81, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (56, 2065, 112, 150, 20, 23, 20, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (59, 1163, 111, 147, 105, 105, 29, 6, 'Grand Masters', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (60, 20084, 109, 140, 102, 102, 26, 6, 'Benefit', NULL, 'Complete', 1, 20020812141156);
INSERT INTO score_packet VALUES (62, 20538, 107, 131, 66, 66, 30, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (64, 265, 109, 140, 97, 97, 25, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (65, 283, 121, 175, 86, 86, 26, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (66, 84, 122, 179, 82, 96, 24, 5, 'Benefit', NULL, 'Complete', 1, 20020812140258);
INSERT INTO score_packet VALUES (67, 20063, 107, 131, 57, 66, 25, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (68, 501, 108, 134, 68, 79, 24, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (69, 521, 112, 149, 82, 82, 29, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (70, 2064, 117, 166, 75, 87, 18, 5, 'Masters', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (72, 1031, 110, 143, 77, 90, 26, 5, 'Masters', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (73, 1163, 110, 143, 89, 89, 29, 6, 'Masters', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (75, 2049, 108, 137, 70, 82, 25, 5, 'Benefit', NULL, 'Complete', 1, 20020812141400);
INSERT INTO score_packet VALUES (76, 2065, 112, 149, 77, 90, 30, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (77, 20084, 117, 166, 87, 87, 15, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (78, 1061, 127, 185, 93, 93, 29, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (79, 351, 112, 149, 59, 83, 22, 4, 'Benefit', NULL, 'Complete', 1, 20020812102145);
INSERT INTO score_packet VALUES (80, 85, 120, 173, 119, 119, 15, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (81, 20538, 107, 130, 69, 80, 28, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (82, 568, 113, 153, 78, 78, 28, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (83, 534, 113, 152, 84, 84, 30, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (85, 521, 113, 152, 80, 93, 16, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (87, 501, 108, 136, 91, 91, 23, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (88, 20538, 107, 128, 66, 77, 26, 5, 'Benefit', NULL, 'Complete', 1, 20020812102137);
INSERT INTO score_packet VALUES (91, 1163, 116, 162, 65, 76, 28, 5, 'Benefit', NULL, 'Complete', 1, 20020812140952);
INSERT INTO score_packet VALUES (92, 2064, 189, 263, 93, 93, 28, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (97, 1061, 119, 172, 85, 85, 28, 6, 'Benefit', NULL, 'Complete', 1, 20020812095514);
INSERT INTO score_packet VALUES (101, 240, 114, 156, 93, NULL, 30, 7, 'Benefit', NULL, 'Complete', 1, 20020805110449);

