SELECT
	per.first_name,
	per.last_name,
	per.rpga_number,
	SUM(IF(sec.section_number=1,ps.prorated_score,0)) sec1,
	SUM(IF(sec.section_number=2,ps.prorated_score,0)) sec2,
	SUM(IF(sec.section_number=3,ps.prorated_score,0)) sec3,
	SUM(IF(sec.section_number=4,ps.prorated_score,0)) sec4,
	SUM(IF(sec.section_number=5,ps.prorated_score,0)) sec5,
	SUM(IF(sec.section_number=6,ps.prorated_score,0)) sec6,
	SUM(IF(sec.section_number=7,ps.prorated_score,0)) sec7,
	SUM(IF(sec.section_number=8,ps.prorated_score,0)) sec8,
	SUM(IF(sec.section_number=9,ps.prorated_score,0)) sec9,
	SUM(IF(sec.section_number=10,ps.prorated_score,0)) sec10,
	SUM(IF(sec.section_number=11,ps.prorated_score,0)) sec11,
	SUM(IF(sec.section_number=12,ps.prorated_score,0)) sec12,
	SUM(IF(sec.section_number=13,ps.prorated_score,0)) sec13,
	COUNT(*) num_events,
	AVG(ps.prorated_score) avg_score
FROM
	person per,
	score_packet pack,
	person_section ps,
	event ev,
	section sec
WHERE
	ps.person_id = per.id
AND ps.score_packet_id = pack.id
AND pack.event_id = ev.id
AND pack.section_id = sec.id
AND sec.section_number != 0
AND ps.judge = 'CHECKED'
GROUP BY
	per.first_name,
	per.last_name,
	per.rpga_number
HAVING
	COUNT(*) > 2
ORDER BY
	per.rpga_number
;