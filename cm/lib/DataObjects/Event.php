<?
/*
* Table Definition for event
*/



require_once('DB/DataObject.php');

class DataObjects_Event extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='event';                 // table name
    var $id;                              // int(11)  not_null primary_key unsigned auto_increment
    var $event_number;                    // string(10)
    var $event_name;                      // blob(65535)  multiple_key blob
    var $game_system;                     // string(255)
    var $scenario_name;                   // string(255)
    var $author_name;                     // string(255)
    var $rpga;                            // string(7)
    var $rpga_event_type;                 // string(15)
    var $round_count;                     // int(6)
    var $description;                     // blob(65535)  blob
    var $price;                           // real(11)
    var $level;                           // string(50)
    var $type;                            // string(50)
    var $contact_person_id;               // int(11)  unsigned
    var $rpga_only;                       // string(7)
    var $sponsor;                         // string(50)
    var $rpga_event_code;                 // string(30)
    var $convention_id;                   // int(11)  not_null unsigned
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp

	/* ZE2 compatibility trick */
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Event',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	function insert() {
		//Set the event name
		if ($this->rpga == 'CHECKED') {$rpgaStr = 'RPGA ';}
		if ($this->scenario_name !='') {' ' . $scenarioStr = $this->scenario_name;}
		if ($this->rpga_event_type !='') {' ' . $typeStr = $this->rpga_event_type;}
		$this->event_name = $rpgaStr . $this->game_system . ' ' . $typeStr . ':' . $scenarioStr;

		return DB_DataObject::insert(); //Call the parent method
	}

	function update() {
		//Set the event name
		if ($this->rpga == 'CHECKED') {$rpgaStr = 'RPGA ';}
		if ($this->scenario_name !='') {$scenarioStr = ' ' . $this->scenario_name;}
		if ($this->rpga_event_type !='') {$typeStr = ' ' . $this->rpga_event_type;}
		$this->event_name = $rpgaStr . $this->game_system . $typeStr . ':' . $scenarioStr;
		
		//Update the section records attached to this event
		$sectionClass = DB_DataObject::staticAutoloadTable('section');
		$sectionObject = new $sectionClass;
		$sectionObject->event_id = $this->id;
		$sectionObject->find();
		//echo '<PRE> Found Section Objects\n'; print_r($sectionObject); echo '<PRE>'; //Testing Only

		while ($sectionObject->fetch()) {
			$sectionObject->event_number = $this->event_number;
			$sectionObject->update();
		}

		return DB_DataObject::update(); //Call the parent method
	}
	
	function delete() {
		//Delete the section records attached to this event
		$sectionClass = DB_DataObject::staticAutoloadTable('section');
		$sectionObject = new $sectionClass;
		$sectionObject->event_id = $this->id;
		$sectionObject->find();

		while ($sectionObject->fetch()) {
			//echo '<PRE> Found Person Section Objects'; print_r($personSectionObject); echo '<PRE>'; //Testing Only
			$deleteObject = new $sectionClass;
			$deleteObject->id = $sectionObject->id;
			$deleteObject->event_id = $sectionObject->event_id;
			$deleteObject->delete();
		}

		return DB_DataObject::delete(); //Call the parent method
	}
}
?>