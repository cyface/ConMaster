<?
/*
* Table Definition for person_section
* CVS Info: $Id: Person_section.php,v 1.4 2002/07/17 23:26:48 cyface Exp $
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
		if ($this->id) { //The id may have gotten set in includedSearch below
			return DB_DataObject::update(); //Call the parent method
		}
		
		return DB_DataObject::insert(); //Call the parent method
	}
	
	function delete() {
		//Find the section row that matches the complete event number that was input
		$sectionObject = DB_DataObject::staticGet('DataObjects_Section',$this->section_id);
		//echo '<PRE> Found Section Object'; print_r($sectionObject); echo '<PRE>';
		
		//Update the section's event fullness indicators
		$sectionObject->num_registered--;
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
	
	/*
	* includedInsert - You are either registering them, or adding them to a packet.
	*          As a result, there are a lot of things that have to happen.  That stuff happens here.
	* 
	* @param string inValue - search value
	*/
	function includedInsert($inValue) {
		if ($this->reg_type != 'Score Packet') {
			
			//Find the section row that matches the complete event number that was input
			require_once('./lib/DataObjects/Section.php');
			$sectionObject =  new DataObjects_Section;
			$sectionObject->complete_event_number = $inValue;
			$sectionObject->convention_id = $this->convention_id;
			$sectionObject->find();
			
			//Error if that complete event number wasn't found
			if ($sectionObject->N == 0) {//Didn't find a match
				require_once('PEAR.php');
				return new PEAR_Error('That Complete Event Number Does Not Exist.');
			}
			
			//If we got this far, we found a matching section
			$sectionObject->fetch(); //Pull the matching record
			//Check to make sure that the event is not full
			if ($sectionObject->event_full == 'CHECKED' or $sectionObject->event_full == 'True') {
				require_once('PEAR.php');
				return new PEAR_Error('Event Full');
			}
			
			//Update the section's event fullness indicators
			$sectionObject->num_registered++;
			$sectionObject->update(); //Save the section record ASAP.
			
			$sectionObject->getLinks(); //Load the related event info
			//echo '<PRE> Found Section Object'; print_r($sectionObject); echo '<PRE>';
			
			//Copy the default information from the section & event records to this object
			$this->section_id = $sectionObject->id;
			$this->event_id = $sectionObject->event_id;
			$this->price = $sectionObject->_event_id->price;
			$this->old_price = $sectionObject->_event_id->price; //old_price is used to minus off the old price of an event when the price is updated
			
			//Now find the related person record, and update their total fee
			$personObject = DB_DataObject::staticGet('DataObjects_Person',$this->person_id);
			$personObject->total_fee += $this->price;
			$personObject->update();
			
			return DB_DataObject::insert(); //Call the parent method
		} //End "if $this->reg_type != 'Score Packet'"
		
		if ($this->reg_type == 'Score Packet') {
			//Try to find an existing Person Section record for this person/event combo - i.e. their registration for this event
			$personSectionSearcher = new DataObjects_Person_section;
			$personSectionSearcher->person_id = $personObject->id;
			$personSectionSearcher->event_id = $personObject->event_id;
			$personSectionSearcher->section_id = $personObject->section_id;
			$personSectionSearcher->find();
			if ($personSectionSearcher->N != 0) {//Found a match
				$personSectionSearcher->fetch(); //get the found record
				$this->setFrom($personSectionSearcher); //Copy the found records's fields into this object
				return DB_DataObject::insert(); //Call the parent method
			}
			
			//If we got this far, we need to create a score-packet only record for this person/event combo - i.e. they used a generic ticket
			//Find the person row that matches the rpga_number that was input
			//Note that this needs to be fixed to search within a convention...
			require_once('./lib/DataObjects/Person.php');
			$personObject = DataObjects_Person;
			
			//Error if that person wasn't found
			if (!$personObject) {
				require_once('PEAR.php');
				return new PEAR_Error('That RPGA Number Does Not Exist.');
			}
			$this->person_id = $personObject->id; //Copy the person's id to this record
			
			//Get the section record related to this object
			$sectionObject =  DB_DataObject::staticGet('DataObjects_Section',$this->section_id);
			
			//Update the section's event fullness indicators
			$sectionObject->num_registered++;
			$sectionObject->update(); //Save the section record ASAP.
			
			//Set the price information to 0 since this is a score packet only record
			$this->price = 0.00;
			$this->old_price = 0.00; //old_price is used to minus off the old price of an event when the price is updated
			
			return DB_DataObject::insert(); //Call the parent method
			return true;
		}//End "if $this->reg_type == 'Score Packet'"
		
		return false; //If we got this far, something is wrong!
	} //End function includedSearch
}
?>