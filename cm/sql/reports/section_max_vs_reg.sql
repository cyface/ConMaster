SELECT 
	event_name as Event,
	complete_event_number as Section,
	CONCAT(num_registered,'/',max_registered) as 'Registrations/Max'
FROM
	event,
	section 
WHERE	
	section.event_id = event.id