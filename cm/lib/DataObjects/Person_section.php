<?
/*
* Table Definition for person_section
*/



require_once('DB/DataObject.php');

class DataObjects_Person_section extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='person_section';                  // table name
    var $id;                              // int(11)  not_null primary_key unsigned auto_increment
    var $person_id;                       // int(11)  not_null unsigned
    var $section_id;                      // int(11)  not_null unsigned
    var $complete_event_number;           // string(10)  not_null
    var $reg_type;                        // string(80)  not_null
    var $score;                           // int(4)  
    var $place;                           // int(4)  
    var $judge;                           // string(10)  
    var $price;                           // real(10) 
	var $old_price;                       // real(10) 
    var $score_packet_id;                 // int(11)  unsigned
    var $packet_position;                 // int(4)  
    var $judge_score;                     // int(4)  
    var $scenario_score;                  // int(4)  
    var $convention_id;                   // int(11)  not_null unsigned
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Person_section',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
	
	/*
	* insert - Inserting a person section means that you are either registering them, or adding them to a packet.
	*          As a result, there are a lot of things that have to happen when one is added.  That stuff happens here.
	* 
	*/
	function insert() {		
		//Find the section row that matches the complete event number that was input
		$sectionObject = DB_DataObject::staticGet('DataObjects_Section','complete_event_number',$this->complete_event_number);
		
		//Error if that complete event number wasn't found
		if (!$sectionObject) {
			require_once('PEAR.php');
			return new PEAR_Error('That Complete Event Number Does Not Exist.');
		}
		
		//Check to make sure that the event is not full
		if ($sectionObject->event_full == 'CHECKED' or $sectionObject->event_full == 'True') {
			require_once('PEAR.php');
			return new PEAR_Error('Event Full');
		}
		
		//Update the section's event fullness indicators
		$sectionObject->num_registered++;
		if ($sectionObject->num_registered == $sectionObject->max_registered) {
			$sectionObject->event_full = 'CHECKED';
		}
		$sectionObject->update(); //Save the section record ASAP.
		
		$sectionObject->getLinks(); //Load the related event info
		//echo '<PRE> Found Section Object'; print_r($sectionObject); echo '<PRE>';
		
		//Copy the default information from the section & event records to this object
		$this->section_id = $sectionObject->id;
		$this->event_id = $sectionObject->event_id;
		$this->price = $sectionObject->_event_id->price;
		$this->old_price = $sectionObject->_event_id->price; //old_price is used to - off the old price of an event when the price is updated
		$this->convention_id = $sectionObject->convention_id;
		
		//Now find the related person record, and update their total fee
		$personObject = DB_DataObject::staticGet('DataObjects_Person',$this->person_id);
		$personObject->total_fee += $this->price;
		$personObject->update();
		
		return DB_DataObject::insert(); //Call the parent method
	}
	
	function delete() {		
		//Find the section row that matches the complete event number that was input
		$sectionObject = DB_DataObject::staticGet('DataObjects_Section',$this->section_id);
		//echo '<PRE> Found Section Object'; print_r($sectionObject); echo '<PRE>';
		
		//Update the section's event fullness indicators
		$sectionObject->num_registered--;
		if ($sectionObject->num_registered < $sectionObject->max_registered) {
			$sectionObject->event_full = null;
		}
		$sectionObject->update(); //Save the section record ASAP.
		
		//Now find the related person record, and update their total fee
		$personObject = DB_DataObject::staticGet('DataObjects_Person',$this->person_id);
		$personObject->total_fee -= $this->price;
		$personObject->update();
		
		return DB_DataObject::delete(); //Call the parent method
	}
	
	function update() {	
		//Now find the related person record, and update their total fee
		$personObject = DB_DataObject::staticGet('DataObjects_Person',$this->person_id);
		$personObject->total_fee -= $this->old_price;
		$personObject->total_fee += $this->price;
		$personObject->update();
		
		$this->old_price = $this->price; //old_price is used to - off the old price of an event when the price is updated
		
		return DB_DataObject::update(); //Call the parent method
	}
}
?>