<?/** Table Definition for section* CVS Info: $Id: Section.php,v 1.8 2003/09/17 20:31:08 cyface Exp $*/require_once('DB/DataObject.php');class DataObjects_Section extends DB_DataObject {    ###START_AUTOCODE    /* the code below is auto generated do not remove the above tag */    var $__table='section';                         // table name    var $id;                              // int(11)  not_null primary_key auto_increment    var $event_id;                        // int(11)  not_null    var $event_number;                    // int(6)  not_null multiple_key    var $section_number;                  // int(4)  not_null multiple_key    var $complete_event_number;           // string(10)  not_null    var $date;                    		  // date(10)  not_null    var $start_time;                      // time(8)  not_null    var $end_time;                        // time(8)  not_null    var $location;                        // string(255)    var $num_registered;                  // int(4)    var $max_registered;                  // int(4)	var $registrations_open;              // int(4)    var $event_full;                      // string(7)    var $results_entered;                 // string(7)    var $event_ran;                       // string(7)  not_null    var $notes;                           // string(80)    var $slots_left;                      // string(1)    var $numeric_section;                 // int(4)    var $advance_to_section;              // string(10)    var $round;                           // string(2)    var $convention_id;                   // int(11)  not_null unsigned    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp	/* ZE2 compatibility trick */    function __clone() { return $this;}    /* Static get */    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Section',$k,$v); }    /* the code above is auto generated do not remove the tag below */    ###END_AUTOCODE	function insert() {		$this->complete_event_number = $this->event_number . '.' . $this->section_number; //Build the complete event number		if ($this->max_registered == null) {			$this->max_registered = 6;		}		//Set the event_full indicator & registrations_open		$this->registrations_open = $this->max_registered - $this->num_registered;		if ($this->registrations_open > $this->max_registered) {			$this->registrations_open = $this->max_registered;		}		if ($this->registrations_open <= 0) {			$this->event_full = 'CHECKED';		} else {			$this->event_full = 'N';		}		return DB_DataObject::insert(); //Call the parent method	}	function update() {		$this->complete_event_number = $this->event_number . '.' . $this->section_number; //Build the complete event number		//Set the event_full indicator & registrations_open		$this->registrations_open = $this->max_registered - $this->num_registered;		if ($this->registrations_open > $this->max_registered) {			$this->registrations_open = $this->max_registered;		}		if ($this->registrations_open <= 0) {			$this->event_full = 'CHECKED';		} else {			$this->event_full = 'N';		}		return DB_DataObject::update(); //Call the parent method	}	/*	* includedInsert - You are either registering them, or adding them to a packet.	*          As a result, there are a lot of things that have to happen.  That stuff happens here.	*	* @param string inValue - search value	*/	function includedInsert($inValue) {		//Based on the supplied slot number, look up the default slot information		//Find the slot row that matches the slot that was input		$slotObject = DB_DataObject::staticGet('DataObjects_Slot','slot_number',$inValue);		//Error if that slot wasn't found		if (!$slotObject) {			require_once('PEAR.php');			return new PEAR_Error('That Slot Does Not Exist.  Edit Your Convention To Add This Slot.');		}		//Copy the default information from the slot record to this object		$this->section_number = $slotObject->slot_number;		$this->date = $slotObject->date;		$this->start_time = $slotObject->start_time;		$this->end_time = $slotObject->end_time;		return $this->insert(); //Call the parent method	} //End function includedInsert	function delete() {		//Delete the person_section records attached to this section		$personSectionClass = DB_DataObject::staticAutoloadTable('person_section');		$personSectionObject = new $personSectionClass;		$personSectionObject->section_id = $this->section_id;		$personSectionObject->find();		//echo '<PRE> Found Person Section Objects'; print_r($personSectionObject); echo '<PRE>'; //Testing Only		while ($personSectionObject->fetch()) {			//echo '<PRE>Section -- Found Person Section Objects'; print_r($personSectionObject); echo '<PRE>'; //Testing Only			$deleteObject = new $personSectionClass;			$deleteObject->id = $personSectionObject->id;			$deleteObject->person_id = $personSectionObject->person_id;			$deleteObject->section_id = $this->id;			$deleteObject->price = $personSectionObject->price;			$deleteObject->delete();		}		return DB_DataObject::delete(); //Call the parent method	}}?>