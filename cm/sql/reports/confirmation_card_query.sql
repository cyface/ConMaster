SELECT
	per.id AS person_id,
	per.first_name,
	per.last_name,
	per.street,
	per.city,
	per.state,
	per.zip,
	per.country,
	per.badge_number,
	per.reg_type,
	per.rpga_number,
	per.total_fee,
	per.amount_paid,
	per.total_fee - per.amount_paid AS amount_owed,
	sec.complete_event_number,
	SUBSTRING(event_name,1,40) AS event_name,
	DATE_FORMAT(sec.date,'%m/%d') as date,
	TIME_FORMAT(sec.start_time,'%l%p') as start_time,
	TIME_FORMAT(sec.end_time,'%l%p') as end_time,
	ps.price AS price
FROM
	person AS per,
	person_section AS ps,
	section AS sec,
	event AS ev
WHERE
	ps.person_id = per.id
AND ps.section_id = sec.id
AND ps.event_id = ev.id
AND per.badge_number IS NOT NULL
AND per.reg_type != 'Score Packet'
ORDER BY
	ps.person_id,
	sec.complete_event_number
;