<?php

/**
 * ScorePacketFormObject is a child of the FormObject class that implements
 * special stuff that is only needed by the Score Packet Form.
 *
 * @see FormObject for usage information
 *
 * CVS Info: $Id: ScorePacketFormObject.php,v 1.1 2002/07/26 23:09:42 cyface Exp $
 *
 * This class is copyright (c) 2002 by Tim White
 * @author Tim White <tim@cyface.com>
 * @since PHP 4.0
 * @copyright This class is copyright (c) 2002 by Tim White
 **/

require_once('PEAR.php'); //Main PEAR stuff
require_once('DataObject.php'); //Database Access Object
require_once('./lib/class.TemplatePower.inc.php'); //Main TemplatePower Stuff
require_once('./lib/TemplateHelpers.inc.php'); //Custom class that adds convienience methods for dealing with Templates
require_once('./lib/FormObject.php'); //Custom class that adds convienience methods for dealing with Templates

/**
 * ScorePacketFormObject Form Interface Object for the Score Packet Form
 *
 * @author Tim White <tim@cyface.com>
 * @package ConMaster
 **/
class ScorePacketFormObject extends FormObject {
    /* BEGIN PUBLIC METHODS */

    function ScorePacketFormObject ($inGet, $inPost)
    {
    	return FormObject::FormObject($inGet, $inPost); //Call parent class's method.
    }

	/* END PUBLIC METHODS */

	/* BEGIN PRIVATE PROPERTIES */
	var $eventObject = false; //an Event DataObject to hold the list of possible events
	var $sectionObject = false; //a Section DataObject to hold the list of possible sections
	/* END PRIVATE PROPERTIES */

	/* BEGIN PRIVATE METHODS */

	function edit ()
	{
	
		require_once('./lib/DataObjects/Event.php');
        $this->eventObject = new DataObjects_Event;
		$this->eventObject->whereAdd("type = 'Role-Playing'");
		$this->eventObject->orderBy("event_name");
		$this->eventObject->find();
		
		while ($this->eventObject->fetch()) { // Pull the results through the object and put them on the form
                $this->template->newBlock('EventList_row'); //create a new result row
                objectValueFill($this->eventObject, $this->template); //Fill in values on the included row
		}
		
		$this->template->gotoBlock("_ROOT");
		
		require_once('./lib/DataObjects/Section.php');
        $this->sectionObject = new DataObjects_Section;
		$this->sectionObject->query("SELECT section.* FROM section,event WHERE section.event_id = event.id AND event.type = 'Role-Playing'");
	
		while ($this->sectionObject->fetch()) { // Pull the results through the object and put them on the form
                $this->template->newBlock('SectionList_row'); //create a new result row
                objectValueFill($this->sectionObject, $this->template); //Fill in values on the included row
		}
		
		$this->template->gotoBlock("_ROOT");
		
		return FormObject::edit(); //Call parent class's method.
	}
	
	function addParticipant()
	{
		//Set up the master data object with the correct stuff
		$this->dataObject->get($this->data['parent_id']);
		
		//Locate the person who's RPGA number was entered
		$personObject = DB_DataObject::staticGet('DataObjects_Person','rpga_number',$this->data['included_search']);
		if (!$personObject) { //If the number wasn't found, exit with error
            $this->template->assign('form_error', 'That RPGA Number Does Not Exist.');
            $this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
			$incClassName = get_class($this->incDataObject);
    		$this->incDataObject = new $incClassName; //Have to clear out the old stuff so that edit() will work - workaround for DataObject 'bug'
      		if ($this->data['included_order_by']) {
         	 	$this->incDataObject->orderBy($this->data['included_order_by']);
      		}
			$this->edit();
			return false;
		} else {
			//Try to find an existing Person Section record for this person/event combo - i.e. their registration for this event
			require_once('./lib/DataObjects/Person_section.php');
			$personSectionObject = new DataObjects_Person_section;
			$personSectionObject->person_id = $personObject->id;
			$personSectionObject->event_id = $this->data['event_id'];
			$personSectionObject->section_id = $this->data['section_id'];
			$personSectionObject->find();
			if ($personSectionObject->N > 0) {//Found a match
				$personSectionObject->fetch(); //get the found record
				$personSectionObject->score_packet_id = $this->data['score_packet_id'];
				$personSectionObject->packet_position = $this->data['packet_position'];
				$personSectionObject->update();
                $this->template->assign('action_message', '<font color="#66CC00">Record Attached</font>');
				$this->edit();
				return true;
			} else { //We need to create a new Person Section Record for this combo
				$personSectionObject = new DataObjects_Person_section; //Have to start over with a new object due to a DB_DataObject "feature"
				
				$personSectionObject->person_id = $personObject->id;
				$personSectionObject->event_id = $this->data['event_id'];
				$personSectionObject->section_id = $this->data['section_id'];
				$personSectionObject->score_packet_id = $this->data['score_packet_id'];
				$personSectionObject->packet_position = $this->data['packet_position'];
				$personSectionObject->score = $this->data['score'];
				$personSectionObject->place = $this->data['place'];
				$personSectionObject->reg_type = 'Score Packet';
				$personSectionObject->price = 0.00;
				$personSectionObject->old_price = 0.00; //old_price is used to minus off the old price of an event when the price is updated
			
				$personSectionObject->insert(); //Save the record to the database
				$this->template->assign('action_message', '<font color="#66CC00">Record Added</font>');
				
				//Get the section record related to this object
				$sectionObject =  DB_DataObject::staticGet('DataObjects_Section',$this->data['section_id']);
			
				//Update the section's event fullness indicators
				$sectionObject->num_registered++;
				$sectionObject->update(); //Save the section record ASAP.
				
				$this->edit(); //Show the packet edit form again.
				return true;
			} //End 'if existing person section record not found...'
		} //End 'if person not found...'
	} //End function addParticipant

	 function search()
    {
		$this->template = new TemplatePower('./templates/' . $this->table . '_' . 'search' . '.html'); //make a new TemplatePower object
        $this->template->prepare(); //let TemplatePower do its thing, parsing etc.;
        valueFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the search form
        if ($this->data['search']) { // Only bother to search if they submit critera, show the blank form regardless
            valueFill($this->data, $this->template); //Put the search values back in the form fields
            
			//Add the table name to the id field.  Can't do this from the form becuase TemplatePower sees . as a block separator
			$this->data['search']['score_packet.id'] = $this->data['search']['id'];
			$this->data['search_operators']['score_packet.id'] = $this->data['search_operators']['id'];
			unset($this->data['search']['id']);
			unset($this->data['search_operators']['id']);	
			
			//Build up the query
			$query = 'SELECT score_packet.* FROM score_packet, event, section, person';
			$query .= ' WHERE score_packet.event_id = event.id';
			$query .= ' AND score_packet.section_id = section.id';
			$query .= ' AND score_packet.person_id = person.id';
			foreach ($this->data['search'] as $field => $value) {
                $whereLine = $this->buildWhereLine($field, $this->data['search_operators'][$field], $value);
                if ($whereLine) {
                    $query .= ' AND ' . $whereLine;
                }
            }
			//Run the query
            $result = $this->dataObject->query($query);
            if (PEAR::isError($result)) {
                $this->template->assign('form_error', $result->getMessage());
                $this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
            } else {
                $this->template->assign('action_message', $this->dataObject->N . ' Found');
            }

            while ($this->dataObject->fetch()) { // Pull the results through the object and put them on the form
                $this->dataObject->getLinks();
                // echo '<PRE> Object: <br>'; print_r($this->dataObject); echo '</PRE>';
                $this->template->newBlock('result_row'); //create a new result_row block
                objectValueFill($this->dataObject, $this->template);
            }
        }
        return true;
	}
	
}  //End class ScorePacketFormObject

?>
