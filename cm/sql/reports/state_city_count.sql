SELECT state as State, city as City, COUNT(*) as 'Attendee Count'
FROM person
WHERE
	reg_type IS NOT NULL
AND state IS NOT NULL
AND city IS NOT NULL
GROUP BY state, city