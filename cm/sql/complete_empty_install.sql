# phpMyAdmin MySQL-Dump
# version 2.3.2
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Oct 17, 2002 at 09:01 AM
# Server version: 3.22.32
# PHP Version: 4.1.2
# Database : cyface
# --------------------------------------------------------

#
# Table structure for table badge_number_seq
#

DROP TABLE IF EXISTS badge_number_seq;
CREATE TABLE badge_number_seq (
   id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
   PRIMARY KEY (id)
);
# --------------------------------------------------------

#
# Table structure for table constant
#

DROP TABLE IF EXISTS constant;
CREATE TABLE constant (
   id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
   constant varchar(255) NOT NULL,
   name varchar(255) NOT NULL,
   value varchar(255),
   extra_info varchar(255),
   ordinal int(10),
   convention_id int(10) unsigned DEFAULT '1' NOT NULL,
   last_modified timestamp(14),
   PRIMARY KEY (id)
);
# --------------------------------------------------------

#
# Table structure for table convention
#

DROP TABLE IF EXISTS convention;
CREATE TABLE convention (
   id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
   name varchar(50) NOT NULL,
   sponsor_organization varchar(50) NOT NULL,
   rpga_convention_code varchar(20) NOT NULL,
   web_site_url varchar(200) NOT NULL,
   logo_file varchar(255),
   last_modified timestamp(14),
   PRIMARY KEY (id)
);
# --------------------------------------------------------

#
# Table structure for table event
#

DROP TABLE IF EXISTS event;
CREATE TABLE event (
   id int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
   event_number smallint(6),
   event_name text,
   game_system varchar(255),
   scenario_name varchar(255),
   author_name varchar(255),
   rpga varchar(7),
   rpga_event_type varchar(15),
   round_count smallint(6),
   description text,
   price decimal(10,0),
   level varchar(50),
   type varchar(50),
   contact_person_id int(11) unsigned,
   rpga_only varchar(7),
   sponsor varchar(50),
   rpga_event_code varchar(30),
   convention_id int(11) unsigned DEFAULT '1' NOT NULL,
   last_modified timestamp(14),
   PRIMARY KEY (id)
);
# --------------------------------------------------------

#
# Table structure for table item
#

DROP TABLE IF EXISTS item;
CREATE TABLE item (
   id int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
   name varchar(255) NOT NULL,
   owner varchar(255) NOT NULL,
   access varchar(255) NOT NULL,
   type varchar(255) NOT NULL,
   category varchar(255) NOT NULL,
   subcategory varchar(255) NOT NULL,
   description text NOT NULL,
   last_modified timestamp(14),
   PRIMARY KEY (id)
);
# --------------------------------------------------------

#
# Table structure for table note
#

DROP TABLE IF EXISTS note;
CREATE TABLE note (
   id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
   parent_table varchar(80) NOT NULL,
   parent_id int(10) unsigned DEFAULT '0' NOT NULL,
   subject varchar(255),
   body text,
   sender varchar(80) NOT NULL,
   last_modified timestamp(14),
   PRIMARY KEY (id)
);
# --------------------------------------------------------

#
# Table structure for table person
#

DROP TABLE IF EXISTS person;
CREATE TABLE person (
   id mediumint(9) unsigned DEFAULT '0' NOT NULL auto_increment,
   first_name varchar(80),
   last_name varchar(80) NOT NULL,
   middle_name varchar(80),
   badge_number smallint(6),
   street varchar(80),
   city varchar(80),
   state varchar(80),
   zip varchar(15),
   phone varchar(15),
   reg_type varchar(80),
   rpga_number mediumint(9),
   total_fee decimal(10,2),
   additional_fees decimal(10,2),
   amount_paid decimal(10,2),
   payment_type varchar(15),
   email_address varchar(80),
   country varchar(30),
   convention_id int(10) DEFAULT '0' NOT NULL,
   last_modified timestamp(14),
   PRIMARY KEY (id),
   KEY last_name (last_name)
);
# --------------------------------------------------------

#
# Table structure for table person_section
#

DROP TABLE IF EXISTS person_section;
CREATE TABLE person_section (
   id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
   person_id int(10) unsigned DEFAULT '0' NOT NULL,
   section_id int(10) unsigned DEFAULT '0' NOT NULL,
   event_id int(10) unsigned DEFAULT '0' NOT NULL,
   reg_type varchar(80) DEFAULT 'default' NOT NULL,
   score int(10) unsigned,
   prorated_score int(10) unsigned,
   place int(10) unsigned DEFAULT '0' NOT NULL,
   judge varchar(10),
   price decimal(10,0),
   old_price decimal(10,0),
   score_packet_id int(10) unsigned,
   packet_position int(10) unsigned,
   scenario_score int(10) unsigned,
   convention_id int(10) unsigned DEFAULT '1' NOT NULL,
   last_modified timestamp(14),
   PRIMARY KEY (id)
);
# --------------------------------------------------------

#
# Table structure for table pma_bookmark
#

DROP TABLE IF EXISTS pma_bookmark;
CREATE TABLE pma_bookmark (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   dbase varchar(255) NOT NULL,
   user varchar(255) NOT NULL,
   label varchar(255) NOT NULL,
   query text NOT NULL,
   PRIMARY KEY (id)
);
# --------------------------------------------------------

#
# Table structure for table pma_column_comments
#

DROP TABLE IF EXISTS pma_column_comments;
CREATE TABLE pma_column_comments (
   id int(5) unsigned DEFAULT '0' NOT NULL auto_increment,
   db_name varchar(64) NOT NULL,
   table_name varchar(64) NOT NULL,
   column_name varchar(64) NOT NULL,
   comment varchar(255) NOT NULL,
   PRIMARY KEY (id),
   UNIQUE db_name (db_name, table_name, column_name)
);
# --------------------------------------------------------

#
# Table structure for table pma_pdf_pages
#

DROP TABLE IF EXISTS pma_pdf_pages;
CREATE TABLE pma_pdf_pages (
   db_name varchar(64) NOT NULL,
   page_nr int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
   page_descr varchar(50) NOT NULL,
   PRIMARY KEY (page_nr),
   KEY db_name (db_name)
);
# --------------------------------------------------------

#
# Table structure for table pma_relation
#

DROP TABLE IF EXISTS pma_relation;
CREATE TABLE pma_relation (
   master_db varchar(64) DEFAULT 'cyface' NOT NULL,
   master_table varchar(64) NOT NULL,
   master_field varchar(64) NOT NULL,
   foreign_db varchar(64) DEFAULT 'cyface' NOT NULL,
   foreign_table varchar(64) NOT NULL,
   foreign_field varchar(64) NOT NULL,
   PRIMARY KEY (master_db, master_table, master_field),
   KEY foreign_field (foreign_db, foreign_table)
);
# --------------------------------------------------------

#
# Table structure for table pma_table_coords
#

DROP TABLE IF EXISTS pma_table_coords;
CREATE TABLE pma_table_coords (
   db_name varchar(64) NOT NULL,
   table_name varchar(64) NOT NULL,
   pdf_page_number int(11) DEFAULT '0' NOT NULL,
   x float(10,2) unsigned DEFAULT '0.00' NOT NULL,
   y float(10,2) unsigned DEFAULT '0.00' NOT NULL,
   PRIMARY KEY (db_name, table_name, pdf_page_number)
);
# --------------------------------------------------------

#
# Table structure for table pma_table_info
#

DROP TABLE IF EXISTS pma_table_info;
CREATE TABLE pma_table_info (
   db_name varchar(64) NOT NULL,
   table_name varchar(64) NOT NULL,
   display_field varchar(64) NOT NULL,
   PRIMARY KEY (db_name, table_name)
);
# --------------------------------------------------------

#
# Table structure for table score_packet
#

DROP TABLE IF EXISTS score_packet;
CREATE TABLE score_packet (
   id int(11) unsigned DEFAULT '0' NOT NULL auto_increment,
   person_id int(11) unsigned DEFAULT '0' NOT NULL,
   event_id int(11) unsigned DEFAULT '0' NOT NULL,
   section_id int(11) unsigned DEFAULT '0' NOT NULL,
   scenario_score tinyint(4) unsigned,
   prorated_scenario_score int(10) unsigned,
   group_score tinyint(4) unsigned,
   number_of_players tinyint(4) unsigned,
   rpga_event_type varchar(15) DEFAULT 'Feature' NOT NULL,
   no_vote varchar(7),
   status varchar(15) DEFAULT 'Incomplete' NOT NULL,
   convention_id int(11) unsigned DEFAULT '1' NOT NULL,
   last_modified timestamp(14),
   PRIMARY KEY (id)
);
# --------------------------------------------------------

#
# Table structure for table section
#

DROP TABLE IF EXISTS section;
CREATE TABLE section (
   id int(10) unsigned DEFAULT '0' NOT NULL auto_increment,
   event_id int(10) unsigned DEFAULT '0' NOT NULL,
   event_number int(10) unsigned DEFAULT '0' NOT NULL,
   section_number int(10) unsigned DEFAULT '0' NOT NULL,
   complete_event_number varchar(15) NOT NULL,
   date date,
   start_time time,
   end_time time,
   location varchar(255),
   num_registered int(10) unsigned DEFAULT '0' NOT NULL,
   max_registered int(10) unsigned DEFAULT '6' NOT NULL,
   registrations_open int(10) unsigned DEFAULT '6' NOT NULL,
   event_full varchar(7),
   results_entered varchar(7),
   event_ran varchar(7),
   advance_to_section int(10) unsigned,
   round int(10) unsigned DEFAULT '1' NOT NULL,
   convention_id int(10) unsigned DEFAULT '1' NOT NULL,
   last_modified timestamp(14),
   PRIMARY KEY (id),
   KEY complete_event_number (complete_event_number)
);
# --------------------------------------------------------

#
# Table structure for table slot
#

DROP TABLE IF EXISTS slot;
CREATE TABLE slot (
   id int(11) DEFAULT '0' NOT NULL auto_increment,
   slot_number int(5) DEFAULT '0' NOT NULL,
   date date DEFAULT '0000-00-00' NOT NULL,
   start_time time DEFAULT '00:00:00' NOT NULL,
   end_time time DEFAULT '00:00:00' NOT NULL,
   convention_id int(11) unsigned DEFAULT '1' NOT NULL,
   PRIMARY KEY (id),
   UNIQUE slot_number (slot_number, convention_id)
);

