<?php

include_once('./lib/DBObject.php'); //Database Access Object
include_once('./lib/class.TemplatePower.inc.php');
include_once('./lib/TemplateHelpers.inc.php');

/**
* FormObject is the Generic Form Interface Object
*
*/
class FormObject {
	var $table = false; //Name of the DB table this object maps to.
	var $data = array('id' => false); //A hash of the data elements of this form
	var $dataObject = false; //The dataObject associcated with this form
	var $template = false; //The template Object associcated with this form
	var $action = false; //The current action to execute

	/**
	* constructor looks up the names of the fields in the database and builds the data array
	*
	* @param string $inTableName name of the DB table to pull names from
	*/
    function FormObject ($inGet, $inPost) {
		if ($inPost) {
    		$this->data = $inPost;
		} else {
			$this->data = $inGet;
		}

		if (!$this->data['action'] or !$this->data['table_name']) {
			echo '<br>No Table or Action<br>';
		    return false;
		} else {
			$this->table_name = $this->data['table_name'];
			$this->dataObject = new DBObject($this->table_name);
			$this->action = $this->data['action'];
			
			if ($this->data['included_table_name']) {
				$this->included_table_name = $this->data['included_table_name'];
			    $this->incDataObject = new DBObject($this->included_table_name);
			}
			return true;
		}

	}//End constructor FormObject

	/**
	* processAction grabs the correct form template and processes it
	*
	*/
    function processAction () {
		$this->template = new TemplatePower('./templates/' . $this->table_name . '_' . 'edit' . '.html'); //make a new TemplatePower object
		$this->template->prepare();//let TemplatePower do its thing, parsing etc.;

		switch($this->action){
			case 'new':
				$this->template->assign('action_message', '<font color="#66CC00">Create A New ' . ucwords(str_replace('_',' ',$this->table_name)) . '</font>');
				break;
			case 'edit':
				$this->dataObject->load_all($this->data['id'],$this->data['load_children']);
				objectValueFill($this->dataObject,$this->template);
				break;
			case 'save':
				if ($this->dataObject->update_all($this->data)) { //Try to save the values to the DB using the object
				    $this->template->assign('action_message', '<font color="#66CC00">Saved</font>');
					objectValueFill($this->dataObject,$this->template);
				} else {
					$this->template->assign('action_message', '<font color="#FF0000">Save Failed, Please Correct Errors</font>');
					objectValueFill($this->dataObject,$this->template); //Put the values back into the form
					errorFill($this->dataObject,$this->template); //Fill in the error message placeholders with the save errors
				}
				break;
			case 'save_included':
				if ($this->incDataObject->update_all($this->data)) { //Try to save the values to the DB using the object
				    $this->template->assign('action_message', '<font color="#66CC00">Saved</font>');
					$this->dataObject->load_all($this->data['parent_id'],$this->data['load_children']);
					objectValueFill($this->dataObject,$this->template);
				} else {
					$this->template->assign('included_action_message', '<font color="#FF0000">Save Failed, Please Correct Errors</font>');
					objectValueFill($this->incDataObject,$this->template); //Put the values back into the form
					errorFill($this->incDataObject,$this->template); //Fill in the error message placeholders with the save errors
				}
				break;
			case 'delete':
				if ($this->data['id'] == '') { //No id for this record
					$this->dataObject->validation_results['form'] .= '<br> Tried to delete a non-existent record.';
					$this->template->assign('action_message', '<font color="#FF0000">Delete Failed!</font>');
					objectValueFill($this->dataObject,$this->template); //Put the values back into the form
					errorFill($this->dataObject,$this->template); //Fill in the error message placeholders with the save errors
				}
				if ($this->dataObject->delete($this->data['id'])) { //Try to delete the record in the DB using the object
				    $this->template = new TemplatePower('./templates/' . 'deleted.html'); //make a new TemplatePower objec
					$this->template->prepare();//let TemplatePower do its thing, parsing etc.
					$this->template->assign('action_message', '<font color="#66CC00">Deleted</font>');
					objectValueFill($this->dataObject,$this->template);
				} else {
					$this->template->assign('action_message', '<font color="#FF0000">Delete Failed!</font>');
					objectValueFill($this->dataObject,$this->template); //Put the values back into the form
					errorFill($this->dataObject,$this->template); //Fill in the error message placeholders with the save errors
				}
				break;
			case 'search':
				$this->template = new TemplatePower('./templates/' . $this->table_name . '_' . 'search' . '.html'); //make a new TemplatePower object
				$this->template->prepare();//let TemplatePower do its thing, parsing etc.;

				if ($this->data['search']) {
				    valueFill($this->data['search'],$this->template); //Put the search values back in the form fields
					$results = $this->dataObject->find_all($this->data['search'],$this->data['search_operators'],$this->data['load_children']);
					
					foreach ($results as $row) {
						$this->template->newBlock('result_row'); //create a new result_row block
						valueFill($row,$this->template);
					}
				}
				break;
			default:
				return false;
		} // switch
		return true;
	}//End function processAction

	/**
	* display calls the displayToScreen method of the template object
	*
	*/
    function display () {
		$this->template->printToScreen();
	}//End function display

} //End class FormObject

?>
