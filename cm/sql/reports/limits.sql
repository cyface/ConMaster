SELECT
	complete_event_number,
	registrations_open
INTO OUTFILE 'limited.dat'
	FIELDS TERMINATED BY '|'
FROM
	section
WHERE
	max_registered != 999
ORDER BY
	complete_event_number
;
