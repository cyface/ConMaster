UPDATE person_section SET score = NULL where score = 0;
UPDATE person_section SET place = NULL where place = 0;
UPDATE person_section SET judge = NULL where LENGTH(judge) = 0;
UPDATE person_section SET judge = NULL where judge = 'False';
UPDATE person_section SET judge = 'CHECKED' where judge = 'True';
UPDATE person_section SET old_price = price where old_price is null;
UPDATE person_section SET score_packet_id = NULL where score_packet_id = 0;
UPDATE person_section SET packet_position = NULL where packet_position = 0 and judge is null;
UPDATE person_section SET judge_score = NULL where judge_score = 0;
UPDATE person_section SET scenario_score = NULL where scenario_score = 0;
UPDATE person_section SET convention_id = 1;