SELECT
	type,
	complete_event_number,
	complete_event_number,
	CONCAT('<B>',event_name,'</B><BR>',description,' &nbsp&nbsp ',level,'<BR><BR>', 
	DATE_FORMAT(date,'%a'),' ',TIME_FORMAT(start_time,'%l:%i%p'),' - ',TIME_FORMAT(end_time,'%l:%i%p'),' &nbsp&nbsp&nbsp Limit - ',max_registered),
	price
INTO OUTFILE 'bencondb.dat'
	FIELDS TERMINATED BY '|'
FROM
	event,
	section
WHERE
	event.id = section.event_id
ORDER BY
	type,
	complete_event_number
;
