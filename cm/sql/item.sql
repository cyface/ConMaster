# phpMyAdmin MySQL-Dump
# version 2.3.0-rc2
# http://phpwizard.net/phpMyAdmin/
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Jul 17, 2002 at 10:25 AM
# Server version: 3.23.51
# PHP Version: 4.1.2
# Database : `cyface`
# --------------------------------------------------------

#
# Table structure for table `item`
#

DROP TABLE IF EXISTS item;
CREATE TABLE item (
  id int(10) unsigned NOT NULL auto_increment,
  name varchar(255) NOT NULL default '',
  owner varchar(255) NOT NULL default '',
  access varchar(255) NOT NULL default '',
  type varchar(255) NOT NULL default '',
  category varchar(255) NOT NULL default '',
  subcategory varchar(255) NOT NULL default '',
  description text NOT NULL,
  last_modified timestamp(14) NOT NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='Campaign Items';

#
# Dumping data for table `item`
#

INSERT INTO item VALUES (199, 'Gregory', 'White', 'Access', 'FRI Only', 'Granby', 'gdw042@coweblink.net', 'Description', 20020703145646);
INSERT INTO item VALUES (36, 'Rice Storehouse', 'tlwhit2', 'Player', 'Building', 'Jingore', '', 'A large bamboo hut sectioned off into seven rooms, each holding a 1/2 koku of rice', 20020703145646);
INSERT INTO item VALUES (35, 'Livestock Pens', 'tlwhit2', 'Player', 'Building', 'Jingore', '', 'Chickens and pigs are kept here and butchered by the eta when needed.', 20020703145646);
INSERT INTO item VALUES (34, 'Eta Building', 'tlwhit2', 'Player', 'Building', 'Jingore', '', 'All of the Eta of Mimura (20+) live in this one large building.  They live so close to the village because of the lack of other arable land in the valley.', 20020703145646);
INSERT INTO item VALUES (33, 'Dry Goods Storage Building', 'tlwhit2', 'Player', 'Building', 'Jingore', '', 'Locked at all times, stores various dry goods in quantity.  Chonin has the key.', 20020703145646);
INSERT INTO item VALUES (32, 'Bridge of Mourning', 'tlwhit2', 'Player', 'Bridge', 'Mimura', '', 'A different shrine is built into each of the four endposts, and the bridge is heavily carved.', 20020703145646);
INSERT INTO item VALUES (31, 'Name', 'Owner', 'Access', 'Type', 'Category', 'Subcategory', 'Description', 20020703145646);
INSERT INTO item VALUES (198, 'Gregory', 'White', 'Access', 'FRI Only', 'Granby', 'gdw042@coweblink.net', 'Description', 20020703145646);
INSERT INTO item VALUES (37, 'Rice Storehouse, Large', 'tlwhit2', 'Player', 'Building', 'Jingore', '', 'This large rice storage building is locked at all times, and holds over half the district\'s rice reserves', 20020703145646);
INSERT INTO item VALUES (38, 'Storage Shed, Eta', 'tlwhit2', 'Player', 'Building', 'Jingore', '', 'This building holds the burial rags, shovels, butcher\'s implements and so forth.', 20020703145646);
INSERT INTO item VALUES (39, 'Yoriki Station', 'tlwhit2', 'Player', 'Building', 'Jingore', '', 'Simple office for Tsuniko, with a dojo in back.', 20020703145646);
INSERT INTO item VALUES (40, 'Agatamori Temple', 'tlwhit2', 'Player', 'Building', 'Omiatsu', '', 'Only temple in Mimura, built with donations from Doji Agatamori', 20020703151130);
INSERT INTO item VALUES (41, 'Akodo Dojo', 'tlwhit2', 'Player', 'Building', 'Omiatsu', '', 'Akodo Iyasu\'s training dojo.  5-6 students live here.', 20020703145646);
INSERT INTO item VALUES (42, 'Audience Chamber,  Ekaido\'s', 'tlwhit2', 'Player', 'Building', 'Omiatsu', '', 'A large audience chamber recently built by Lord Ekaido so that the village nobles don\'t have to come to his estate.', 20020703145646);
INSERT INTO item VALUES (43, 'Audience Chamber, Genjiri\'s', 'tlwhit2', 'Player', 'Building', 'Omiatsu', '', 'A very large building with an audience chamber and over 20 guest rooms, owned by Genjiri', 20020703145646);
INSERT INTO item VALUES (44, 'Bathhouse', 'tlwhit2', 'Player', 'Building', 'Omiatsu', 'foo', 'A cool water bathhouse fed by the Golden Koi.  Hot baths are also available for a 1 bu donation.', 20020703145646);
INSERT INTO item VALUES (45, 'Doji Agatamori\'s Home', 'tlwhit2', 'Player', 'Building', 'Omiatsu', '', 'Fairly large home, with extensive gardens.', 20020703145646);
INSERT INTO item VALUES (46, 'Empty Noble\'s Home', 'tlwhit2', 'Player', 'Building', 'Omiatsu', '', 'A very large home that stands empty - the previous tenant dissapeared under mysterious circumstances, and few talk about it.', 20020703145646);
INSERT INTO item VALUES (47, 'Isawa Fugato\'s Home', 'tlwhit2', 'Player', 'Building', 'Omiatsu', '', 'An expansive home with luxurious gardens owned by the retired Phoenix Courtier Isawa Fugato.', 20020703145646);
INSERT INTO item VALUES (48, 'Torii Arch', 'tlwhit2', 'Player', 'Building', 'Omiatsu', '', 'Beautiful black and red arch on wise snake pass road north of Agatamori temple', 20020703145646);
INSERT INTO item VALUES (49, 'Trading Post', 'tlwhit2', 'Player', 'Building', 'Omiatsu', '', 'A medium sized outdoor bazaar patronized havily by the nobles.', 20020703145646);
INSERT INTO item VALUES (50, 'Fruit and Vegetable Stand', 'tlwhit2', 'Player', 'Building', 'Ubanoru', '', 'Nigato sells fresh fruit and vegetables picked from her own garden, including wasabi.', 20020703145646);
INSERT INTO item VALUES (51, 'Livestock Pens, Ubanoru', 'tlwhit2', 'Player', 'Building', 'Ubanoru', '', 'The eta Kirebu is assigned to raise and slaughter swine and poultry.', 20020703145646);
INSERT INTO item VALUES (52, 'Lumber Yard', 'tlwhit2', 'Player', 'Building', 'Ubanoru', '', 'Iyzumi is a woodcutter, he and his eldest son cut wood most days.', 20020703145646);
INSERT INTO item VALUES (53, 'Natsuko\'s Home', 'tlwhit2', 'Player', 'Building', 'Ubanoru', '', 'Natsuko, the proprietory of Biwa\'s Hearth, lives here with her servants, and her friend Churyo.', 20020703145646);
INSERT INTO item VALUES (54, 'Paper Shop', 'tlwhit2', 'Player', 'Building', 'Ubanoru', '', 'Yomura is the local paper maker.  He makes it mostly from straw.', 20020703145646);
INSERT INTO item VALUES (55, 'Sake Works', 'tlwhit2', 'Player', 'Building', 'Ubanoru', '', 'Yasuki Kome owns this place, but it is operated by the heimin Kagemi.  Produces all the sake, shochu, and fruit brandy for this, and the neighboring valleys.', 20020703145646);
INSERT INTO item VALUES (56, 'Stables', 'tlwhit2', 'Player', 'Building', 'Ubanoru', '', 'The main stables for the village, it can hold 20+ horses.  The village\'s draft animals live here in the winter.  Proprietor is Akata.', 20020703145646);
INSERT INTO item VALUES (57, 'Storehouse', 'tlwhit2', 'Player', 'Building', 'Ubanoru', '', 'Looks like it has been deserted for a long time.', 20020703145646);
INSERT INTO item VALUES (58, 'Tattoo Shop', 'tlwhit2', 'Player', 'Building', 'Ubanoru', '', 'Mojiro ekes out a bare living here, with fewer than five customers a year.  He is extremely talented, however.', 20020703145646);
INSERT INTO item VALUES (59, 'Festival of Floating Lights', 'tlwhit2', 'Player', 'Celebration', 'Mimura', '', 'Heimin float rafts with candles down the tearful river, usually held on the first day of summer', 20020703145646);
INSERT INTO item VALUES (60, 'Painter\'s Day', 'tlwhit2', 'Player', 'Celebrationish', 'Mimura', '', 'Dragon 8-10, peasants are take off farming to paint their homes, and Lord Ekaido rewards the best ones.', 20020703145646);
INSERT INTO item VALUES (61, 'Setsuban Festival', 'tlwhit2', 'Player', 'Celebration', 'Mimura', '', 'Forgiveness of neighbors festival, sometimes Lord Ekaido cuts specific taxes', 20020703145646);
INSERT INTO item VALUES (62, 'Cherry Blossom Festival', 'tlwhit2', 'Player', 'Celebration', 'Rokugan', '', 'Held on Dragon 23, this celebration honors the blossoming of the Cherry trees', 20020703145646);
INSERT INTO item VALUES (63, 'Otosan Uchi', 'tlwhit2', 'Player', 'City', 'Rokugan', '', 'Capital of Rokugan, where the Emperor lives.', 20020703145646);
INSERT INTO item VALUES (64, 'Personal Gardens', 'tlwhit2', 'Player', 'Concept', 'Jingore', '', 'Heimin are allowed to grow vegetables on their property for personal use, untaxed', 20020703145646);
INSERT INTO item VALUES (65, 'Climate', 'tlwhit2', 'Player', 'Concept', 'Mimura', '', 'Hot and humid in the summer, cool and humid in the winter, snow doesn\'t usually last too long', 20020703145646);
INSERT INTO item VALUES (66, 'Duties, Heimin', 'tlwhit2', 'Player', 'Concept', 'Mimura', '', 'Most heimin work in one of the two rice paddies, some work in the main vegetable area, others harvest the wild sorghum', 20020703145646);
INSERT INTO item VALUES (67, 'Ashigaru', 'tlwhit2', 'Player', 'Concept', 'Rokugan', '', 'A heimin trained to military arts, always infantry.', 20020703145646);
INSERT INTO item VALUES (68, 'Fortunes', 'tlwhit2', 'Player', 'Concept', 'Rokugan', '', 'Symbols of koi, crows, dragons, and so forth adorn paper walls and doors everywhere', 20020703145646);
INSERT INTO item VALUES (69, 'Kyudo', 'tlwhit2', 'Player', 'Concept', 'Rokugan', '', 'Traditional art of archery.', 20020703145646);
INSERT INTO item VALUES (70, 'Spirituality', 'tlwhit2', 'Player', 'Concept', 'Rokugan', '', 'The people of Mimura have a deep spiritual core, but usually observe in private', 20020703145646);
INSERT INTO item VALUES (71, 'Luriku', 'tlwhit2', 'Player', 'Hamlet', 'E', '', 'Very small hamlet, only about 40 people, produces a small amount of rice, and some metal', 20020703145646);
INSERT INTO item VALUES (72, 'Jingore', 'tlwhit2', 'Player', 'Hamlet', 'Mimura NE', '', 'Heimin village, with some peddlers and merchants', 20020703145646);
INSERT INTO item VALUES (73, 'Omiatsu', 'tlwhit2', 'Player', 'Hamlet', 'Mimura NW', '', 'Noble area, very near river, shortage of dry land', 20020703145646);
INSERT INTO item VALUES (74, 'Ubanoru', 'tlwhit2', 'Player', 'Hamlet', 'Mimura S', '', 'Commerce area, teahouses and shops', 20020703145646);
INSERT INTO item VALUES (75, 'Gebranu', 'tlwhit2', 'Player', 'Hamlet', 'S', '', 'Small hamlet, known for their papercrafts', 20020703145646);
INSERT INTO item VALUES (76, 'Desadore', 'tlwhit2', 'Player', 'Hamlet', 'W', '', 'Fair sized hamlet, produces mostly rice', 20020703145646);
INSERT INTO item VALUES (77, 'Akarii', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 13 members.  Head of family is old and cynical.', 20020703145646);
INSERT INTO item VALUES (78, 'Chatsu', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Hemin family, 11 members', 20020703145646);
INSERT INTO item VALUES (79, 'Ejira', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 13 members, Ejira\'s wife is known as a folk herbalist', 20020703145646);
INSERT INTO item VALUES (80, 'Gaero', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 8 members', 20020703145646);
INSERT INTO item VALUES (81, 'Gebosi', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 14 members', 20020703145646);
INSERT INTO item VALUES (82, 'Gokuzui', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Hemin family, 11 members', 20020703145646);
INSERT INTO item VALUES (83, 'Haisan', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 14 members', 20020703145646);
INSERT INTO item VALUES (84, 'Hasaku', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 10 members.  Hasaku\'s father was convicted of murder two years ago, and he is now in charge.', 20020703145646);
INSERT INTO item VALUES (85, 'Kesai', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 9 members. Kesai is very handsome and intelligent', 20020703145646);
INSERT INTO item VALUES (86, 'Koshio', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 13 members.  Koshio has a reputation as a troublemaker and rabble rouser.  He has been publicly flogged, and placed under house arrest several times', 20020703145646);
INSERT INTO item VALUES (87, 'Kosura', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 14 members.  Tends to fight with his neighbors over misunderstandings', 20020703145646);
INSERT INTO item VALUES (88, 'Kuguri', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 13 members.  Kuguri is well-liked by most in the village.', 20020703145646);
INSERT INTO item VALUES (89, 'Migu', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 12 members, house has been broken into several times', 20020703145646);
INSERT INTO item VALUES (90, 'Ogarite', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 12 members, known for kite-making', 20020703145646);
INSERT INTO item VALUES (91, 'Otasoke', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Hemin family, 9 members', 20020703145646);
INSERT INTO item VALUES (92, 'Sanu', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 11 members.  Sanu lost his hand to and angry ronin over two years ago', 20020703145646);
INSERT INTO item VALUES (93, 'Shobui', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 19 members, has taken in many orphans', 20020703145646);
INSERT INTO item VALUES (94, 'Tago', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Hemin family, 17 members', 20020703145646);
INSERT INTO item VALUES (95, 'Tahi', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 9 members', 20020703145646);
INSERT INTO item VALUES (96, 'Tanamake', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 7 members.  Tanamake is the previous headman of the village.', 20020703145646);
INSERT INTO item VALUES (97, 'Tekaza', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 3 members.  Tekaza is recently married and lives with his bride and her mother', 20020703145646);
INSERT INTO item VALUES (98, 'Tsuzen', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 6 members.  Tsuzen is only 19, spends his time feeding his siblings, as his parents both recently died.', 20020703145646);
INSERT INTO item VALUES (99, 'Wujike', 'tlwhit2', 'Player', 'Heimin Family', 'Jingore', '', 'Heimin family, 9 members.  Wujike is the local painter of symbols.', 20020703145646);
INSERT INTO item VALUES (100, 'Blessings of the New Year', 'tlwhit2', 'Player', 'Inn', 'Jingore', '', 'Large and comfortable inn, proprietor is the well-mannered Otaki, who is fascinated with spiders.  He has 3 high class geisha working for him, Furiko, Maro, and Meyori', 20020703145646);
INSERT INTO item VALUES (101, 'The Goddess\'s Beauty', 'tlwhit2', 'Player', 'Inn', 'Omiatsu', '', 'A luxurious and reknowned inn.  Only the wealthiest nobles can stay here, but both rooms are always full.  The proprietor is Iryoke.', 20020703145646);
INSERT INTO item VALUES (102, 'Goyaku Inn', 'tlwhit2', 'Player', 'Inn', 'Ubanoru', '', 'The oldest building in the village, this inn is at the intersection of the two main roads. And is run by a young merchant woman named Masori.', 20020703145646);
INSERT INTO item VALUES (103, 'Shochu', 'tlwhit2', 'Player', 'Money', 'Rokugan', '', 'Rice Whiskey', 20020703145646);
INSERT INTO item VALUES (104, 'Zeni', 'tlwhit2', 'Player', 'Money', 'Rokugan', '', 'Copper coin, 1/100th of a Koku', 20020703145646);
INSERT INTO item VALUES (105, 'Gahei', 'tlwhit2', 'Player', 'Person', 'Jingore', '', 'Once an accomplished archer, he now focuses on teaching Shinsei\'s words, and studying Kyudo.', 20020703145646);
INSERT INTO item VALUES (106, 'Isawa Agachi', 'tlwhit2', 'Player', 'Person', 'Jingore', '', 'Retired Isawa Monk, spends much time reading old texts, and spinning tales.  Very thin, grey hair, has two young monks statying with him,', 20020703145646);
INSERT INTO item VALUES (107, 'Kuteri', 'tlwhit2', 'Player', 'Person', 'Jingore', '', 'Headman of Jingore.  Lives with his wife, 4 boys, 3 girls and 2 sisters.', 20020703145646);
INSERT INTO item VALUES (108, 'Madame Sadako', 'tlwhit2', 'Player', 'Person', 'Jingore', '', 'Runs the illegal geisha house in the Silver Okasan', 20020703145646);
INSERT INTO item VALUES (109, 'Mistress Kanemitsu', 'tlwhit2', 'Player', 'Person', 'Jingore', '', 'Real geisha (not just a prostitute) that is working for Madame Sadako for some mysterious reason', 20020703145646);
INSERT INTO item VALUES (110, 'Yutaro', 'tlwhit2', 'Player', 'Person', 'Jingore', '', 'Herbalist, and maker of healing teas.', 20020703145646);
INSERT INTO item VALUES (111, 'Azumi', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Homeless doer of odd jobs and the like.  Respected by most as hard working.', 20020703145646);
INSERT INTO item VALUES (112, 'Gehasa', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'A worthless beggar who frequents the Silver Okasan.  He is eta, and a constant source of trouble.', 20020703145646);
INSERT INTO item VALUES (113, 'Hitsu', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Wandering Ronin, with the scars of many battles.  Many fear him.', 20020703145646);
INSERT INTO item VALUES (114, 'Ijime', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Wandering peddler.  Easily known by his tall, bamboo frame pack, he tells a wicked joke, and sells just about everything.', 20020703145646);
INSERT INTO item VALUES (115, 'Jozen', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Ronin recently arrived and looking for work.', 20020703145646);
INSERT INTO item VALUES (116, 'Kruje', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Silver tounged freeloader, whom everyone loves.', 20020703145646);
INSERT INTO item VALUES (117, 'Kyuso', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Ronin staying at the Goyaku inn, waiting for work to come to him.', 20020703145646);
INSERT INTO item VALUES (118, 'Lord Ekaido', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Lord of Mimura and two smaller villages.  He is getting older, and spends little time in the village', 20020703145646);
INSERT INTO item VALUES (119, 'Otaryu', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Lord Ekaido\'s Tax Collector.  Revolting man, who travels between the three villages.', 20020703145646);
INSERT INTO item VALUES (120, 'Shinjo Magistrates', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Unicorn Samurai assigned to patrol area for bandits, here at request of Doji Agatamori', 20020703145646);
INSERT INTO item VALUES (121, 'Tokogashi', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Strange bard who spends a lot of time in the various teahouses of Mimura, doing more listening than performing.', 20020703145646);
INSERT INTO item VALUES (122, 'Tsuniko', 'tlwhit2', 'Player', 'Person', 'Mimura', '', 'Yoriki of Mimura, she is a distant cousin of Lord Ekaido.  Takes her job very seriously.', 20020703145646);
INSERT INTO item VALUES (123, 'Agatamori', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'See Doji Agatamori', 20020703145646);
INSERT INTO item VALUES (124, 'Akodo Iyasu', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Former Imperial Yojimbo to a Ikoma historian and scribe, he now teaches the sword and jiujutsu.', 20020703145646);
INSERT INTO item VALUES (125, 'Daidoji Genjiri', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'A gokenin of his own province elsewhere, this Crane lives here part of the year and maintains modest (by Crane standards) winter home.', 20020703145646);
INSERT INTO item VALUES (126, 'Doji Agatamori', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Retired Crane courtier, has built the temple, the school, and generally been a pillar of the community', 20020703145646);
INSERT INTO item VALUES (127, 'Fugato Isawa', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Retired Phoenix Courtier who moved to Mimura 3 years ago.', 20020703145646);
INSERT INTO item VALUES (129, 'Hometsu', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'See Ide Hometsu', 20020703145646);
INSERT INTO item VALUES (130, 'Ide Hometsu', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Son of an important Ide noble, Kojike.  Very young and lives with a small, overworked staff.', 20020703145646);
INSERT INTO item VALUES (131, 'Isawa Ayumi', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Eldest Daughter of Isawa Fugato (Amy\'s PC).', 20020703145646);
INSERT INTO item VALUES (132, 'Isawa Kiko', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Youngest Daughter of Isawa Fugato.', 20020703145646);
INSERT INTO item VALUES (133, 'Isawa Puzota', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Only son of Isawa Fugato, Phoenix courtier in Otosan Uchi', 20020703145646);
INSERT INTO item VALUES (134, 'Kakita Kyoko', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Entertainer and bard to the Isawa Fugato household.', 20020703145646);
INSERT INTO item VALUES (135, 'Miyahara Hitomi', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Former Badger clan samurai, now semi-ronin.  Guards Mimura due to final obligation from his lord before he died.  (Greg\'s PC)', 20020703145646);
INSERT INTO item VALUES (136, 'Shiba Kobuse', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Phoenix yojimbo to Isawa Ayumi (Jeff\'s PC)', 20020703145646);
INSERT INTO item VALUES (137, 'Shugoza Zabu', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'Monk, recently come to Mimura at the request of his order to investigate the Forest of Persistence Stone.  (Scott\'s PC).', 20020703145646);
INSERT INTO item VALUES (138, 'Yomori', 'tlwhit2', 'Player', 'Person', 'Omiatsu', '', 'A noble samurai of sketchy past who keeps to himself in his opulent home', 20020703145646);
INSERT INTO item VALUES (139, 'Asahina Goro', 'tlwhit2', 'Player', 'Person', 'Temple', '', 'The abbot of Agatamori temple.  A respected religious leader, who has sworn to serve in Mimura for three years.', 20020703145646);
INSERT INTO item VALUES (140, 'Chubei', 'tlwhit2', 'Player', 'Person', 'Temple', '', 'One of several nuns living in Agatamori Temple.  A former Agasha riddle solver.', 20020703145646);
INSERT INTO item VALUES (141, 'Gennai', 'tlwhit2', 'Player', 'Person', 'Temple', '', 'Researcher of Forbidden Lore at Agatamori Temple', 20020703145646);
INSERT INTO item VALUES (142, 'Kenichi', 'tlwhit2', 'Player', 'Person', 'Temple', '', 'Young Monk living at Agatamori Temple, chafes under Asahina Goro\'s micro-management', 20020703145646);
INSERT INTO item VALUES (144, 'Kageru', 'tlwhit2', 'Player', 'Person', 'Ubanoru', '', 'Kageru the cobbler is an old, unmarried man who is stern and unforgiving.  Many heimin go barefoot out of spite.', 20020703145646);
INSERT INTO item VALUES (145, 'Mirumoto Shimeko', 'tlwhit2', 'Player', 'Person', 'Ubanoru', '', 'Armorer.  She is very odd.  Her apprentice is Hito, and most of her work is for Lord Ekaido\'s men.', 20020703145646);
INSERT INTO item VALUES (146, 'Mishime', 'tlwhit2', 'Player', 'Person', 'Ubanoru', '', 'The resident heimin seamstress.  She, Onushi, and Suri provide all of Mimura with silk clothing.', 20020703145646);
INSERT INTO item VALUES (147, 'Mokote', 'tlwhit2', 'Player', 'Person', 'Ubanoru', '', 'Maker of Lacquerware', 20020703145646);
INSERT INTO item VALUES (148, 'Shinobu', 'tlwhit2', 'Player', 'Person', 'Ubanoru', '', 'Bonsai tree grower, and herb grower.', 20020703145646);
INSERT INTO item VALUES (149, 'Tsuru', 'tlwhit2', 'Player', 'Person', 'Ubanoru', '', 'Tsuru is the village metalsmith, who in general works in exchange for food.  Slow and methodical.', 20020703145646);
INSERT INTO item VALUES (150, 'Forest of Ishikure', 'tlwhit2', 'Player', 'Place', 'E', '', 'Legend has it that Ishikure, and imperial guardsman, dissapeared into this forest with his men 16 years ago, and the woods have been cursed ever since.', 20020703145646);
INSERT INTO item VALUES (151, 'Rice Paddy (N)', 'tlwhit2', 'Player', 'Place', 'E', '', 'Smaller rice paddy fed by a natural stram and small irrigation canals', 20020703145646);
INSERT INTO item VALUES (152, 'Way Station (E)', 'tlwhit2', 'Player', 'Place', 'E', '', 'Typical way station staffed by the head of a Heimin househould from Mimura', 20020703145646);
INSERT INTO item VALUES (153, 'Perfect Eye Watchtower', 'tlwhit2', 'Player', 'Place', 'N', '', 'Houses 30 men, and overlooks all of Mimura valley', 20020703145646);
INSERT INTO item VALUES (154, 'Vegetable Farms', 'tlwhit2', 'Player', 'Place', 'N', '', 'Smallish patch of arable soil beneath the Sabishii crags, only large amount of vegetables in area', 20020703145646);
INSERT INTO item VALUES (155, 'Wild Sorghum', 'tlwhit2', 'Player', 'Place', 'NE', '', 'Large patch of green and red sorghum that is freely gathered for tea and for export', 20020703145646);
INSERT INTO item VALUES (156, 'Cedar Forest', 'tlwhit2', 'Player', 'Place', 'NW', '', 'Small patch of cedar, controlled directly by Lord Ekaido, who sometimes grants permission to cut trees', 20020703145646);
INSERT INTO item VALUES (157, 'Gotsuna', 'tlwhit2', 'Player', 'Place', 'NW', '', 'Small patch of juniper trees found nowhere else in area, prized of Lord Ekaido', 20020703145646);
INSERT INTO item VALUES (158, 'Lord Ekaido\'s Estate', 'tlwhit2', 'Player', 'Place', 'NW', '', 'A half-day\'s walk from Mimura, this large estate is very richly appointed', 20020703145646);
INSERT INTO item VALUES (159, 'Watchtower and Training Grounds', 'tlwhit2', 'Player', 'Place', 'S', '', 'Main training area for Lord Ekaido\'s men. 20-50 men stationed here on average.', 20020703145646);
INSERT INTO item VALUES (160, 'Crow\'s Flight Forest', 'tlwhit2', 'Player', 'Place', 'SE', '', 'Legend has it that Shinsei\'s crow once flew over these trees.  Many villagers believe that these woods are home to bandits, if not goblins and oni.', 20020703145646);
INSERT INTO item VALUES (161, 'Open Fields', 'tlwhit2', 'Player', 'Place', 'SE', '', 'Lush grass covers this open, uncultivated area to the SE of the main rice paddy', 20020703145646);
INSERT INTO item VALUES (162, 'Rice Paddy (S)', 'tlwhit2', 'Player', 'Place', 'SE', '', 'Large rice paddy (400-500 koku/year) fed by the Golden Koi River', 20020703145646);
INSERT INTO item VALUES (163, 'The Great Repose', 'tlwhit2', 'Player', 'Place', 'SSW', '', 'A eerily quiet and calm patch of earth filled with little shrines.  A perfect place to meditate', 20020703145646);
INSERT INTO item VALUES (164, 'Forest of Reflection', 'tlwhit2', 'Player', 'Place', 'SW', '', 'A calm place, which legend has it was started when a monk planted a single tree', 20020703145646);
INSERT INTO item VALUES (165, 'Healthy Green Forest', 'tlwhit2', 'Player', 'Place', 'SW', '', 'Most of the wood from the village comes.', 20020703145646);
INSERT INTO item VALUES (166, 'Way Station (W)', 'tlwhit2', 'Player', 'Place', 'SW', '', 'A seldom vistited way station (most go to Lord Ekaido\'s Estate).', 20020703145646);
INSERT INTO item VALUES (167, 'Breath of the Sorrowful Bog', 'tlwhit2', 'Player', 'Place', 'W', '', 'Ugly, dangerous bog that makes the Golden Koi river rich, and makes the paddies fertile - children get lost there', 20020703145646);
INSERT INTO item VALUES (168, 'Coiled Serpent Tree Forest', 'tlwhit2', 'Player', 'Place', 'W', '', 'W side of the Tearful river - Cypress, Mahogany and Bamboo', 20020703145646);
INSERT INTO item VALUES (169, 'Forest of Persistence Stone', 'tlwhit2', 'Player', 'Place', 'W', '', 'Small forest, in the center of which is a stone over 4 people high carved with kanji at the very top - too high for human hands', 20020703145646);
INSERT INTO item VALUES (170, 'Plains of Grace', 'tlwhit2', 'Player', 'Place', 'W', '', 'Grasslands, rumored to be infested with monsters, and legends of strange lights in sky persist', 20020703145646);
INSERT INTO item VALUES (171, 'Plains of Grace', 'tlwhit2', 'Player', 'Place', 'W', '', 'See Johinsa no Heichi', 20020703145646);
INSERT INTO item VALUES (172, 'Sacred Stand', 'tlwhit2', 'Player', 'Place', 'W', '', 'Legend has it that 30 samurai died here fighting an unjust lord over 200 years ago.  Their wails can still be heard on the wind.', 20020703145646);
INSERT INTO item VALUES (173, 'Golden Koi River', 'tlwhit2', 'Player', 'River', 'Central', '', 'Feeds rice paddies', 20020703145646);
INSERT INTO item VALUES (174, 'Tearful River', 'tlwhit2', 'Player', 'River', 'Central', '', 'Cold, clear, slow river which many legends say is filled with the spirits of unhappy souls', 20020703145646);
INSERT INTO item VALUES (175, 'Kunshu Kido', 'tlwhit2', 'Player', 'Road', 'Mimura', '', '"Lord\'s Path" - Main E-W Road, used to be maintained by the Empire, but has fallen into disrepair', 20020703145646);
INSERT INTO item VALUES (176, 'Wise Snake Pass Road', 'tlwhit2', 'Player', 'Road', 'Mimura', '', 'Wise Snake Pass Road, main N-S road, historically controlled by Emperor, but recently ignored', 20020703145646);
INSERT INTO item VALUES (177, 'Broken Raven Path', 'tlwhit2', 'Player', 'Road', 'SW', '', 'A small dirt road, heavily rutted which leads to Delsadore and Lord Ekaido\'s Estate', 20020703145646);
INSERT INTO item VALUES (178, 'Children of the Sun', 'tlwhit2', 'Player', 'Teahouse', 'Jingore', '', 'Small teahouse on the E-W road.', 20020703145646);
INSERT INTO item VALUES (179, 'House of White Lillies', 'tlwhit2', 'Player', 'Teahouse', 'Jingore', '', 'A posh teahouse with tasteful décor.  Run by a little old man named Jume and his two daughters.', 20020703145646);
INSERT INTO item VALUES (180, 'The Silver Okasan', 'tlwhit2', 'Player', 'Teahouse', 'Jingore', '', 'Disreputable place where the dregs of the area hang out.  An illegal geisha house is in back', 20020703145646);
INSERT INTO item VALUES (181, 'The Whispering Crane', 'tlwhit2', 'Player', 'Teahouse', 'Jingore', '', 'A simple and cozy teahouse, run by two venerable women, Jurimiko and Chiyako.', 20020703145646);
INSERT INTO item VALUES (182, 'Biwa\'s Hearth', 'tlwhit2', 'Player', 'Teahouse', 'Ubanoru', '', 'Friendly, relaxing teahouse.  The owner, Natsuko, doesn\'t tolerate unhappy people.  Much music, stories and songs.', 20020703145646);
INSERT INTO item VALUES (183, 'The Faint Winds of Kojii\'s Favor', 'tlwhit2', 'Player', 'Teahouse', 'Ubanoru', '', 'A posh, expensive teahouse where regal and scholarly samurai come to relax.', 20020703145646);
INSERT INTO item VALUES (184, 'Bu', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', '1 Koku coin', 20020703145646);
INSERT INTO item VALUES (185, 'Cha-no-yo', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'The art and practice of the tea ceremony.', 20020703145646);
INSERT INTO item VALUES (186, 'Chomin', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'Word used by samurai class to refer to a heimin they aren\'t familiar with, usually means "get the headman"', 20020703145646);
INSERT INTO item VALUES (187, 'Chonin', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'Headman of village - Jingore\'s headman is Kuteri', 20020703145646);
INSERT INTO item VALUES (188, 'Daimyo', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', '"Great Name" - overlord, minimum income 10,000 koku', 20020703145646);
INSERT INTO item VALUES (189, 'Doshin', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'Doshin - Student (martial arts), or in law enforcement context a deputy', 20020703145646);
INSERT INTO item VALUES (190, 'Eta', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'Untouchable - caste of people who deal with death, butchery, and burial.', 20020703145646);
INSERT INTO item VALUES (191, 'Gokenin', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', '"House Man".  A lesser noble landlord.', 20020703145646);
INSERT INTO item VALUES (192, 'Heimin', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'Peasant, farmer', 20020703145646);
INSERT INTO item VALUES (193, 'Iaijutsu', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'Fast draw skill with the katana.', 20020703145646);
INSERT INTO item VALUES (194, 'Koku', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'Measure of wealth - amount of rice needed to feed a person for a year, about 5 bushels', 20020703145646);
INSERT INTO item VALUES (195, 'Oshogatsu', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'New Year\'s day', 20020703145646);
INSERT INTO item VALUES (196, 'Yojimbo', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', 'Noble bodyguard', 20020703145646);
INSERT INTO item VALUES (197, 'Yoriki', 'tlwhit2', 'Player', 'Terminology', 'Rokugan', '', '"Sheriff", in charge of city milita and patrols, passes judgement in Lord\'s absence.', 20020703145646);

