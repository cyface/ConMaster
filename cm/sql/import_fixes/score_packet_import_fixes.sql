UPDATE score_packet SET rpga_event_type = NULL WHERE LENGTH(rpga_event_type) = 0;
UPDATE score_packet SET rpga_event_type = 'Benefit' WHERE rpga_event_type = 'BE';
UPDATE score_packet SET rpga_event_type = 'Masters' WHERE rpga_event_type = 'MA';
UPDATE score_packet SET rpga_event_type = 'Grand Masters' WHERE rpga_event_type = 'GM';
UPDATE score_packet SET rpga_event_type = 'Paragon' WHERE rpga_event_type = 'PA';
UPDATE score_packet SET rpga_event_type = 'Team' WHERE rpga_event_type = 'TE';
UPDATE score_packet SET rpga_event_type = 'Feature' WHERE rpga_event_type = 'FE';