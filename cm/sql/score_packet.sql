# phpMyAdmin MySQL-Dump
# version 2.3.0-rc4
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jul 31, 2002 at 10:43 AM
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
  group_score tinyint(4) unsigned default NULL,
  number_of_players tinyint(4) unsigned default NULL,
  rpga_event_type varchar(15) NOT NULL default 'Feature',
  convention_id int(11) unsigned NOT NULL default '1',
  last_modified timestamp(14) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `score_packet`
#

INSERT INTO score_packet VALUES (1, 1163, 107, 33, 61, 28, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (2, 20063, 107, 133, 73, 19, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (3, 995, 108, 138, 81, 23, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (4, 501, 108, 138, 70, 27, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (5, 71, 113, 155, 80, 24, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (7, 568, 113, 155, 74, 28, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (8, 708, 118, 169, 74, 25, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (10, 521, 112, 151, 76, 21, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (11, 397, 112, 151, 80, 25, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (12, 181, 116, 160, 58, 29, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (13, 158, 116, 160, 69, 24, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (15, 1163, 110, 142, 90, 28, 6, 'Masters', 1, 20020731104227);
INSERT INTO score_packet VALUES (16, 1115, 110, 142, 85, 30, 5, 'Masters', 1, 20020731104227);
INSERT INTO score_packet VALUES (17, 708, 114, 157, 75, 24, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (18, 351, 114, 157, 73, 24, 7, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (19, 181, 114, 157, 90, 30, 7, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (20, 20084, 117, 165, 56, 25, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (22, 71, 187, 261, 92, 29, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (24, 84, 193, 269, 95, 26, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (25, 1163, 109, 139, 93, 28, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (27, 20084, 107, 132, 71, 25, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (29, 20063, 107, 129, 69, 21, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (32, 397, 114, 158, 67, 30, 6, 'Grand Masters', 1, 20020731104301);
INSERT INTO score_packet VALUES (33, 568, 107, 129, 75, 26, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (34, 84, 122, 178, 97, 18, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (35, 265, 109, 139, 91, 26, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (36, 1163, 110, 145, 102, 30, 6, 'Grand Masters', 1, 20020731104301);
INSERT INTO score_packet VALUES (37, 71, 110, 145, 85, 27, 6, 'Masters', 1, 20020731104227);
INSERT INTO score_packet VALUES (42, 351, 118, 167, 55, 26, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (43, 1061, 119, 171, 69, 28, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (44, 521, 113, 154, 75, 25, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (45, 84, 108, 136, 95, 27, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (48, 397, 113, 154, 58, 30, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (50, 181, 116, 161, 65, 23, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (53, 2049, 108, 134, 83, 20, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (54, 192, 113, 154, 127, 81, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (56, 2065, 112, 150, 20, 20, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (59, 1163, 111, 147, 105, 29, 6, 'Grand Masters', 1, 20020731104301);
INSERT INTO score_packet VALUES (60, 20084, 109, 139, 102, 26, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (61, 71, 118, 167, 55, 24, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (62, 20538, 107, 131, 66, 30, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (64, 265, 109, 140, 97, 25, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (65, 283, 121, 175, 86, 26, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (66, 84, 122, 179, 82, 25, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (67, 20063, 107, 131, 57, 25, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (68, 501, 108, 134, 68, 24, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (69, 521, 112, 149, 82, 29, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (70, 2064, 117, 166, 75, 18, 5, 'Masters', 1, 20020731104227);
INSERT INTO score_packet VALUES (72, 1031, 110, 143, 77, 26, 5, 'Masters', 1, 20020731104227);
INSERT INTO score_packet VALUES (73, 1163, 110, 143, 89, 29, 6, 'Masters', 1, 20020731104227);
INSERT INTO score_packet VALUES (75, 2049, 108, 134, 70, 25, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (76, 2065, 112, 149, 77, 30, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (77, 20084, 117, 166, 87, 15, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (78, 1061, 127, 185, 93, 29, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (79, 351, 112, 149, 59, 22, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (80, 85, 120, 173, 119, 15, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (81, 20538, 107, 130, 69, 28, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (82, 568, 113, 153, 78, 28, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (83, 534, 113, 152, 84, 30, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (85, 521, 113, 152, 80, 16, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (87, 501, 108, 136, 91, 23, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (88, 20538, 107, 128, 66, 26, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (89, 1061, 126, 184, 83, 25, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (91, 1163, 116, 161, 65, 28, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (92, 2064, 189, 263, 93, 28, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (93, 853, 135, 198, 0, 30, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (94, 20076, 128, 186, 0, 30, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (95, 71, 118, 169, 86, 30, 7, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (97, 1061, 119, 172, 85, 28, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (99, 20063, 107, 128, 50, 24, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (101, 240, 114, 156, 93, 30, 7, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (103, 611, 114, 156, 80, 29, 7, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (104, 1079, 119, 172, 80, 24, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (106, 611, 118, 169, 94, 27, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (109, 20155, 110, 144, 71, 26, 5, 'Masters', 1, 20020731104227);
INSERT INTO score_packet VALUES (110, 20084, 109, 141, 100, 28, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (111, 2017, 121, 177, 82, 26, 6, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (112, 2049, 113, 152, 68, 30, 5, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (113, 1163, 111, 146, 88, 29, 6, 'Grand Masters', 1, 20020731104301);
INSERT INTO score_packet VALUES (114, 397, 113, 152, 52, 23, 4, 'Benefit', 1, 20020731104227);
INSERT INTO score_packet VALUES (115, 828, 109, 141, 97, 22, 6, 'Benefit', 1, 20020731104227);

