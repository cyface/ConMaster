SELECT
	per.first_name,
	per.last_name,
	per.rpga_number,
	pack.id,
	pack.no_vote,
	pack.prorated_scenario_score,
	pack.number_of_players,
	ps.prorated_score,
	ev.event_name,
	ev.RPGA
FROM
	person per,
	score_packet pack,
	person_section ps,
	event ev
WHERE
	ps.person_id = per.id
AND ps.score_packet_id = pack.id
AND pack.event_id = ev.id
AND ps.judge = 'CHECKED'
AND ev.rpga = 'CHECKED'
ORDER BY
	per.rpga_number,
	ps.prorated_score desc
;

	