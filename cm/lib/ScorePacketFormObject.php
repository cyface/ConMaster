<?php

/**
 * ScorePacketFormObject is a child of the FormObject class that implements
 * special stuff that is only needed by the Score Packet Form.
 *
 * @see FormObject for usage information
 *
 * CVS Info: $Id: ScorePacketFormObject.php,v 1.6 2002/10/16 18:25:52 cyface Exp $
 *
 * This class is copyright (c) 2002 by Tim White
 * @author Tim White <tim@cyface.com>
 * @since PHP 4.0
 * @copyright This class is copyright (c) 2002 by Tim White
 **/

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

	/**
	 * newPacket sets up the lists of events and sections to pick from, then shows the edit form
	 *
     **/
	function newPacket ()
	{
		$eventClass = DB_DataObject::staticAutoloadTable('event');
		$this->eventObject = new $eventClass;
		$this->eventObject->whereAdd("type = 'Role-Playing'");
		$this->eventObject->orderBy("scenario_name");
		$this->eventObject->find();

		while ($this->eventObject->fetch()) { // Pull the results through the object and put them on the form
				$this->template->newBlock('EventList_row'); //create a new result row
				objectValueFill($this->eventObject, $this->template); //Fill in values on the included row
		}

		$this->template->gotoBlock("_ROOT");

		$sectionClass = DB_DataObject::staticAutoloadTable('section');
		$this->sectionObject = new $sectionClass;
		$this->sectionObject->query("SELECT section.* FROM section,event WHERE section.event_id = event.id AND event.type = 'Role-Playing' ORDER BY section_number");

		while ($this->sectionObject->fetch()) { // Pull the results through the object and put them on the form
				$this->template->newBlock('SectionList_row'); //create a new result row
				objectValueFill($this->sectionObject, $this->template); //Fill in values on the included row
		}

		$this->template->gotoBlock("_ROOT");

		$this->edit();
			}

	/**
	 * edit overloads FormObject->edit() to allow error checking and precise control over the included stuff
	 *
     **/
	function edit ()
	{
		$this->dataObject->getLinks();

		objectValueFill($this->dataObject, $this->template);
		rowFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the main form

		if ($this->template->getVarValue('form_error') != '') {  //If there is an error, skip the rest
			return;
		}

		if ($this->included_table) {
			//Set up the included object
			$this->incDataObject = new $this->included_class;
			if ($this->data['included_order_by']) {
				$this->incDataObject->orderBy($this->data['included_order_by']);
			}
			if ($this->data['included_where']) {
				$this->incDataObject->whereAdd($this->data['included_where']);
			}

			$this->template->newBlock('included_header'); //create a new header for the included rows
			objectValueFill($this->dataObject, $this->template); //Fill in values on the included header
			rowFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the included header
			$this->incDataObject->score_packet_id = $this->dataObject->id;
			$this->incDataObject->find(); //Try and load it with the current data

			$judge_score = 0;
			$player_total_score = 0;
			$player_total_places = 0;
			while ($this->incDataObject->fetch()) { // Pull the results through the object and put them on the form
				$this->incDataObject->getLinks();
				$this->template->newBlock($this->included_table . '_row'); //create a new result row
				objectValueFill($this->incDataObject, $this->template); //Fill in values on the included row
				if ($this->incDataObject->packet_position == 0) {
					$judge_score = $this->incDataObject->score;
					$this->template->assign('place','N/A');
					$this->template->assign('position_disp','Judge');
				} else {
					$player_total_score += $this->incDataObject->score;
					$player_total_places += $this->incDataObject->place;
					$this->template->assign('position_disp',$this->incDataObject->packet_position);
				}
				$position_list[] = $this->incDataObject->packet_position; //Toss the position into an array
			}

			//See if the packet is complete.
			if ($this->incDataObject->N-1 != $this->dataObject->number_of_players) { //-1 to remove the judge
				$this->template->newBlock($this->included_table . '_footer'); //create a new result row
				objectValueFill($this->dataObject, $this->template); //Fill in values on the included row //Fills in event, section id
				if ($this->incDataObject->N == 0) { //new packet
					$this->template->assign('packet_position',0);
					$this->template->assign('place','N/A');
					$this->template->assign('judge','CHECKED');
					$this->template->assign('position_disp','Judge');
				} else {

					$nextPosition = $this->incDataObject->packet_position+1;
					foreach ($position_list as $rownum=>$position) { //Look for a hole and use it if found.
						if ($rownum != $position) {
							$nextPosition = $rownum;
							break;
						}
					}
					$this->template->assign('packet_position',$nextPosition);
					$this->template->assign('position_disp',$nextPosition);
				}
				if ($this->data['no_vote'] == 'CHECKED') {
					$this->template->assign('score',10);
				}
				$this->template->gotoBlock('_ROOT');
				$this->template->assign('status','Incomplete');
				$this->dataObject->status = 'Incomplete';
				$this->dataObject->update();
				$numMissing = $this->dataObject->number_of_players - ($this->incDataObject->N - 1);
				$this->errorString .= " You must add $numMissing participants(s) to complete this packet.";
				$this->template->assign('form_error', $this->errorString);
				return;
			}

			//Begin error checking
			$status = 'Complete';  //Optimistic, eh?

			if ($this->dataObject->no_vote != 'CHECKED') {  //Only error-check voting packets.
				$scoreTotals = array(3=>39,4=>56,5=>70,6=>80,7=>90);
				if ($player_total_score != $scoreTotals[$this->dataObject->number_of_players]) {
					$this->errorString .= ' The player scores must total ' . $scoreTotals[$this->dataObject->number_of_players] . ', but they total ' . $player_total_score;
				}

				$placeTotals = array(3=>6,4=>10,5=>15,6=>21,7=>28);
				if ($player_total_places != $placeTotals[$this->dataObject->number_of_players] ) {
					$this->errorString .= ' The player places must total ' . $placeTotals[$this->dataObject->number_of_players] . ', but they total ' . $player_total_places;
				}

				if ($this->dataObject->group_score < 6 OR $this->dataObject->group_score > 30) {
					$this->errorString .= ' The group score must be between 6 and 30';
				}

				$scenario_score_max = ($this->dataObject->number_of_players + 1) * 15;
				$scenario_score_min = ($this->dataObject->number_of_players + 1) * 3;
				if ($this->dataObject->scenario_score < $scenario_score_min OR $this->dataObject->scenario_score > $scenario_score_max ) {
					$this->errorString .= " The scenario score must be between $scenario_score_min and $scenario_score_max";
				}
			}
			$this->template->gotoBlock('_ROOT');

			if ($this->errorString != '') {
				$this->template->assign('form_error', $this->errorString);
				$status = 'Error';
			}

			$this->template->assign('status', $status);
			$this->dataObject->status = $status;
			$this->dataObject->update();
		} //End "If incDataObject...
    }

	/**
	 * save tweaks some data, then calls FormObject's save() method
	 *
     **/
	function save()
	{
		if ($this->data['number_of_players'] != 6) {
			$scenario_max = ($this->data['number_of_players'] + 1) * 15;
			$this->data['prorated_scenario_score'] = round(($this->data['scenario_score'] / $scenario_max) * 105);
		} else {
			$this->data['prorated_scenario_score'] = $this->data['scenario_score'];
		}
		return FormObject::save(); //Call parent object's method
	}

	/**
	 * addParticipant adds a given participant to the packet by locating or creating a person_section record
	 *
     **/
	function addParticipant()
	{
		//***Locate the person who's RPGA number was entered

		//***Start by looking for them in the person table
		$personClass = DB_DataObject::staticAutoloadTable('person');
		if (intval(rtrim($this->data['included_search'])) != 0) { //Only search if something reasonable was entered.
			$personObject = DB_DataObject::staticGet($personClass,'rpga_number',rtrim($this->data['included_search']));
		}
		//echo '<pre>Person Object'; print_r($personObject); echo 'Included Search' . rtrim($this->data['included_search']) .'</pre>';

		//***If we didn't find them in the person table, look in the RPGAList.txt file
		if (!$personObject) { //If the rpga number was not found
			if (file_exists('resources/RPGAList.txt')) {
				$fp = fopen("resources/RPGAList.txt",'r');
				while ($data = fgetcsv ($fp, 1000, "\t")) {
					if ($data[0] == $this->data['included_search']) { //Found them in the external file
						$foundData = $data;
						break;
					}
				}
				//***If we found that RPGA Number in the file, see if their name is in the person table
				if (isset($foundData)) {
					$personObject = new $personClass;
					$personObject->first_name = $data[1];
					$personObject->last_name = $data[2];
					$personObject->city = $data[3];
					$personObject->state = $data[4];

					$personObject->find();

					//***If their name is in the person table, just update the rec with the RPGA number
					if ($personObject->N !=0) {
						$personObject->fetch();
						if ($personObject->rpga_number == 0) {
							$personObject->rpga_number = $data[0];
							$personObject->update();
						}
					//***If their name isn't in the person table, insert the data from RPGAList.txt into person
					} else {
						$personObject->rpga_number = $data[0];
						$personObject->country = $data[5];
						$personObject->id = $personObject->insert();
					}
					//echo '<pre>'; print_r($personObject); echo '</pre>';
				}
			}

			//***If they aren't in the person table or RPGAList.txt, throw an error and exit
			if (!$personObject) {
				$this->errorString .= ' That RPGA Number Does Not Exist.';
				$this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
				$this->edit();
				return;
			}
		}

		//***Try to find an existing Person Section record for this person/event combo - i.e. their registration for this event
		$personSectionClass = DB_DataObject::staticAutoloadTable('person_section');
		$personSectionObject = new $personSectionClass;
		$personSectionObject->person_id = $personObject->id;
		$personSectionObject->event_id = $this->data['event_id'];
		$personSectionObject->section_id = $this->data['section_id'];
		$personSectionObject->score_packet_id = '';
		$personSectionObject->find();
		//***If they are registered, assign that person_section record to this packet
		if ($personSectionObject->N > 0) {//Found a match
			$personSectionObject->fetch(); //get the found record
			$personSectionObject->setFrom($this->data); //Copy the matching items onto the object
			//Calculate prorated score
			if ($personSectionObject->packet_position == 0) {
				$personSectionObject->prorated_score = ($personSectionObject->score / (30 * $this->dataObject->number_of_players)) * 180;
			} else {
				$personSectionObject->prorated_score = ($personSectionObject->score / (4 * ($this->dataObject->number_of_players + 1))) * 28;
			}
			$personSectionObject->update();
			$this->template->assign('action_message', '<font color="#66CC00">Participant Attached</font>');
			if ($personSectionObject->packet_position == 0) {
				$this->dataObject->person_id = $personSectionObject->person_id;
				$this->dataObject->update();
			}
		//***They aren't registered, we need to create a new Person Section Record
		} else {
			$personSectionObject = new $personSectionClass; //Have to start over with a new object due to a DB_DataObject "feature"

			$personSectionObject->setFrom($this->data); //Copy the matching items onto the object
			$personSectionObject->person_id = $personObject->id;
			$personSectionObject->reg_type = 'Score Packet';
			$personSectionObject->price = 0.00;
			$personSectionObject->old_price = 0.00; //old_price is used to minus off the old price of an event when the price is updated

			//Calculate prorated score
			if ($personSectionObject->packet_position == 0) {
				$personSectionObject->prorated_score = ($personSectionObject->score / (30 * $this->dataObject->number_of_players)) * 180;
			} else {
				$personSectionObject->prorated_score = ($personSectionObject->score / (4 * ($this->dataObject->number_of_players + 1))) * 28;
			}

			$personSectionObject->insert(); //Save the record to the database
			$this->template->assign('action_message', '<font color="#66CC00">Participant Added</font>');

			//Attach the judge's person_id directly to the packet
			if ($personSectionObject->packet_position == 0) {
				$this->dataObject->person_id = $personSectionObject->person_id;
				$this->dataObject->update();
			}
		} //End 'if existing person section record not found...'

		//***Auto-calculate the places of all the participants
		$personSectionObject = new $personSectionClass;
		$personSectionObject->score_packet_id = $this->data['score_packet_id'];
		$personSectionObject->orderBy('score desc,packet_position');
		$personSectionObject->find();

		$place = 0;
		while ($personSectionObject->fetch()) {
			$updateObject = $personSectionObject;
			//echo '<pre>'; print_r($this->data); echo '</pre>';
			if (($place > 0) && ($this->data['no_vote'] == 'CHECKED')) {
				$updateObject->place = 4;
			} else {
				$updateObject->place = $place;
			}
			$updateObject->update();
			$place++;
		}

		$this->edit();
	} //End function addParticipant

	/**
	 * saveIncluded overloads FormObject->saveIncluded, and calculates prorated scores
	 *
	 **/
	function saveIncluded ()
	{
		$this->incDataObject = new $this->included_class;
		$this->incDataObject->setFrom($this->data); //Copy the form data into the included object.

		///Calculate prorated score
		if ($this->incDataObject->packet_position == 0) {
			$this->incDataObject->prorated_score = ($this->incDataObject->score / (30 * $this->dataObject->number_of_players)) * 180;
		} else {
			$this->incDataObject->prorated_score = ($this->incDataObject->score / (4 * ($this->dataObject->number_of_players + 1))) * 28;
		}

		if ($this->data['included_id']) { // Only update the DB if an id was supplied
			$this->incDataObject->id = $this->data['included_id'];
			$result = $this->incDataObject->update();
			$this->template->assign('action_message', '<font color="#66CC00">Updated</font>');
		} else { // If no id supplied we are inserting
			if ($this->data['included_search']) {
				$result = $this->incDataObject->includedInsert($this->data['included_search']);
			} else {
				$result = $this->incDataObject->id = $this->incDataObject->insert();
			}
			$this->template->assign('action_message', '<font color="#66CC00">Added</font>');
		}

		if (PEAR::isError($result)) {
			$this->template->assign('form_error', $result->getMessage());
			$this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
		}

		$incClassName = get_class($this->incDataObject);
		$this->incDataObject = new $incClassName; //Have to clear out the old stuff so that edit() will work - workaround for DataObject 'bug'
		if ($this->data['included_order_by']) {
			$this->incDataObject->orderBy($this->data['included_order_by']);
		}
		$this->edit();
    }

	/**
	 * deleteIncluded overloads FormObject->deleteIncluded, and allows non-Score Packet person sections to survive
	 *
	 **/
	function deleteIncluded ()
	{
		if ($this->data['included_id'] == '') { // No id for this record
			$this->dataObject->validation_results['form'] .= '<br> Tried to delete a non-existent record.';
			$this->template->assign('action_message', '<font color="#FF0000">Delete Failed!</font>');
			$this->dataObject->get($this->data['parent_id']);
			$incClassName = get_class($this->incDataObject);
			$this->incDataObject = new $incClassName; //reinit the object to get around DataObject bug
			$this->edit();
		}

		$this->incDataObject = new $this->included_class;
		$this->incDataObject->get($this->data['included_id']);

		if ($this->incDataObject->reg_type == 'Score Packet') {
			$this->incDataObject->score_packet_id = '';
			$this->incDataObject->update();
		} else {
			$result = $this->incDataObject->delete(); //Try to delete the record in the DB using the object
			if (PEAR::isError($result)) {
				$this->template->assign('form_error', $result->getMessage());
				$this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
			} else {
				$this->template->assign('action_message', '<font color="#FF0000">Row Deleted</font>');
			}
		}

		$this->dataObject->get($this->data['parent_id']);

		if ($this->incDataObject->packet_position == 0) { //judge
			$this->dataObject->person_id = '';
			$this->dataObject->update();
		}


		$incClassName = get_class($this->incDataObject);
		$this->incDataObject = new $incClassName; //reinit the object to get around DataObject bug
		if ($this->data['included_order_by']) {
			$this->incDataObject->orderBy($this->data['included_order_by']);
		}
		$this->edit();
	}

	/**
	 * search overloads FormObject->search, and uses a four table join to allow very flexible searches
	 *
     **/
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
			$query = 'SELECT score_packet.* FROM score_packet';
			$query .= ' LEFT JOIN event ON score_packet.event_id=event.id';
			$query .= ' LEFT JOIN section ON score_packet.section_id=section.id';
			$query .= ' LEFT JOIN person ON score_packet.person_id=person.id';
			$query .= ' WHERE 1';
			foreach ($this->data['search'] as $field => $value) {
                $whereLine = $this->buildWhereLine($field, $this->data['search_operators'][$field], $value);
                if ($whereLine) {
                    $query .= ' AND ' . $whereLine;
                }
            }

            if ($this->data['orderBy']) {
				$query .= ' ORDER BY ' . $this->data['orderBy'];
			} else {
				$query .= ' ORDER BY id';
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
    }
}  //End class ScorePacketFormObject

?>
