SELECT 
	con.rpga_convention_code, 
	ev.rpga_event_code, 
	DATE_FORMAT(sec.date,'%m/%d/%y') AS date, 
	sec.round, 
	pkt.id AS packet_id, 
	pkt.rpga_event_type, 
	IF((ps.packet_position = 0)||(pkt.no_vote != 'CHECKED'),pkt.scenario_score,0) AS scenario_score, 
	IF(ps.packet_position = 0,0,IF(pkt.no_vote = 'CHECKED',18,pkt.group_score)) AS group_score, 
	IF(ps.packet_position = 0,'JU',IF(pkt.no_vote = 'CHECKED',4,CONCAT('P',ps.place))) AS place, 
	per.rpga_number, 
	IF(pkt.no_vote = 'CHECKED',IF(ps.packet_position = 0,140,10),IFNULL(ps.score,0)) AS score
FROM
	convention AS con,
	event AS ev,
	section AS sec,
	score_packet AS pkt,
	person AS per,
	person_section AS ps
WHERE
	pkt.convention_id = con.id
AND pkt.section_id = sec.id
AND pkt.event_id = ev.id
AND pkt.id = ps.score_packet_id
AND ps.person_id = per.id
AND ev.rpga_event_code IS NOT NULL
AND ev.rpga_event_code != ''
ORDER BY
	pkt.id,
	IF(ps.place IS NULL,0,ps.place)
;