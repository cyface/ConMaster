SELECT 
	event_name as Event,
	complete_event_number as Section,
	num_registered as Registrations
FROM
	event,
	section 
WHERE	
	section.event_id = event.id