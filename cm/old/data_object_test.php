<?php

// initialize the DataObject Manager
        
        require_once('PEAR.php');
        $options = &PEAR::getStaticProperty('DB_DataObject','options');
        $config = parse_ini_file('DataObjects/cm.ini',TRUE);
		
        $options = $config['DB_DataObject'];
        
        
        // use one of the extended classes.
        
        require_once('DataObjects/Person_section.php');
        
        $person_section = new DataObjects_Person_section;
	 
        $person_section->get(99);
		$results = $person_section->getLink('person_id');

		echo '<PRE>';
        	print_r($person_section);
			print_r($results);
		echo '</PRE>';

?>