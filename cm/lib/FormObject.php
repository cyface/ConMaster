<?php

require_once('PEAR.php'); //Database Access Object
require_once('DataObject.php'); //Database Access Object
require_once('./lib/class.TemplatePower.inc.php');
require_once('./lib/TemplateHelpers.inc.php');

/**
* FormObject is the Generic Form Interface Object
*
*/
class FormObject {
	var $table = false; //Name of the DB table this object maps to.
	var $included_table = false; //Name of the DB table this object's included table maps to.
	var $data = array('id' => false); //A hash of the data elements of this form
	var $dataObject = false; //The dataObject associcated with this form
	var $incDataObject = false; //The included dataObject associcated with this form (subform)
	var $template = false; //The template Object associcated with this form
	var $action = false; //The current action to execute

	/**
	* constructor takes the inputs from the form and, based on 'action', processes them.
	*
	* @param string $inGet - the $_GET variable from a form
	* @param string $inPost - the $_POST variable from a form
	* @see DataObject.php (PEAR)
	* @see TemplatePower
	*/
    function FormObject ($inGet, $inPost) {
		if ($inPost) {
    		$this->data = $inPost;
		} else {
			$this->data = $inGet;
		}
		
		if (!$this->data['action'] or !$this->data['table']) {
			echo '<br>No Table or Action<br>';
		    return false;
		} else {
			$this->table = $this->data['table'];
			
			//initialize DataObject
			$options = &PEAR::getStaticProperty('DB_DataObject','options');
        	$config = parse_ini_file('./lib/DataObjects/cyface.ini',TRUE);
			$options = $config['DB_DataObject'];
			
			$objectName = 'DataObjects_'.ucwords($this->table); //Name of DataObject subclass to use for data access
			
			if ($this->data['id'] != '') {
			   $this->dataObject = DB_DataObject::staticGet($objectName,$this->data['id']); 
			} else {
				require_once('./lib/DataObjects/' . ucwords($this->table) . '.php');
				$this->dataObject = new $objectName;
			}
			
			$this->action = $this->data['action'];
			
			if ($this->data['included_table']) {
				$this->included_table = $this->data['included_table'];
				require_once('./lib/DataObjects/' . ucwords($this->included_table) . '.php');
				$incObjectName = 'DataObjects_' . ucwords($this->included_table); //Name of DataObject subclass to use for data access
			    $this->incDataObject = DB_DataObject::staticGet($incObjectName,$this->table . '_id',$this->data['id']); 
			}
			return true;
		}

	}//End constructor FormObject

	/**
	* processAction grabs the correct form template, connects to the DB if needed, and outputs the filled out form
	*
	*/
    function processAction () {
		$this->template = new TemplatePower('./templates/' . $this->table . '_' . 'edit' . '.html'); //make a new TemplatePower object
		$this->template->prepare();//let TemplatePower do its thing, parsing etc.;

		switch($this->action){
			case 'new':
				$this->template->assign('action_message', '<font color="#66CC00">Create A New ' . ucwords(str_replace('_',' ',$this->table)) . '</font>');
				break;
			case 'edit':
				$this->dataObject->get($this->data['id']);
				if ($this->data['getLinks']) {
				   $this->dataObject->getLinks(); 
				}
				objectValueFill($this->dataObject,$this->template);
				if ($this->incDataObject) {
					while($this->incDataObject->fetch()){ //Pull the results through the object and put them on the form
						$this->incDataObject->getLinks();
						//echo '<PRE> Object:'; print_r($this->incDataObject); echo '</PRE>';
						$this->template->newBlock($this->included_table . '_row'); //create a new result_row block
						objectValueFill($this->incDataObject,$this->template);
					}
				}
				break;
			case 'save':
				$this->dataObject->setFrom($this->data); //Copy the form data into the object.
				if ($this->dataObject->id) {
				    $this->dataObject->update();
				} else {
					$this->dataObject->id = $this->dataObject->insert();
				}
				$this->template->assign('action_message', '<font color="#66CC00">Saved</font>');
				if ($this->data['getLinks']) {
				   $this->dataObject->getLinks(); 
				}
				objectValueFill($this->dataObject,$this->template);
				if ($this->incDataObject) {
					while($this->incDataObject->fetch()){ //Pull the results through the object and put them on the form
						$this->incDataObject->getLinks();
						//echo '<PRE> Object:'; print_r($this->incDataObject); echo '</PRE>';
						$this->template->newBlock($this->included_table . '_row'); //create a new result_row block
						objectValueFill($this->incDataObject,$this->template);
					}
				}
	
				//$this->template->assign('action_message', '<font color="#FF0000">Save Failed, Please Correct Errors</font>');
				//objectValueFill($this->dataObject,$this->template); //Put the values back into the form
				//errorFill($this->dataObject,$this->template); //Fill in the error message placeholders with the save errors
				break;
			case 'save_included': //TEST
				$this->incDataObject->setFrom($this->data); //Copy the form data into the object.
				if ($this->incDataObject->id) {
				    $this->incDataObject->update();
				} else {
					$this->incDataObject->id = $this->incDataObject->insert();
				}
				$this->template->assign('action_message', '<font color="#66CC00">Saved</font>');
				$this->dataObject->get($this->data['parent_id']);
				objectValueFill($this->dataObject,$this->template);
				break;
			case 'delete':
				if ($this->data['id'] == '') { //No id for this record
					$this->dataObject->validation_results['form'] .= '<br> Tried to delete a non-existent record.';
					$this->template->assign('action_message', '<font color="#FF0000">Delete Failed!</font>');
					objectValueFill($this->dataObject,$this->template); //Put the values back into the form
					errorFill($this->dataObject,$this->template); //Fill in the error message placeholders with the save errors
					return false;
				}
					$this->dataObject->setFrom($this->data);
					$this->dataObject->delete(); //Try to delete the record in the DB using the object
				    $this->template = new TemplatePower('./templates/' . 'deleted.html'); //make a new TemplatePower objec
					$this->template->prepare();//let TemplatePower do its thing, parsing etc.
					$this->template->assign('action_message', '<font color="#66CC00">Deleted</font>');
					objectValueFill($this->dataObject,$this->template);
				break;
			case 'search':
				$this->template = new TemplatePower('./templates/' . $this->table . '_' . 'search' . '.html'); //make a new TemplatePower object
				$this->template->prepare();//let TemplatePower do its thing, parsing etc.;

				if ($this->data['search']) { //Only bother to search if they submit critera, show the blank form regardless
				    valueFill($this->data['search'],$this->template); //Put the search values back in the form fields
					foreach ($this->data['search'] as $field => $value) {
						$whereLine = $this->buildWhereLine($field, $this->data['search_operators'][$field], $value);
						if ($whereLine) {
							$this->dataObject->whereAdd($whereLine);
						}
					}
					$this->dataObject->find();
						
					while($this->dataObject->fetch()){ //Pull the results through the object and put them on the form
						$this->dataObject->getLinks();
						//echo '<PRE> Object:'; print_r($this->dataObject); echo '</PRE>';
						$this->template->newBlock('result_row'); //create a new result_row block
						objectValueFill($this->dataObject,$this->template);
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

	/**
	* display calls the displayToScreen method of the template object
	*
	* @param string $inField - name of the field to compare to a value
	* @param string $inOperator - the comparison name (as would appear on a search form)
	* @param string $inValue - value to compare to
	* @return string - assembled where clause line such as: last_name LIKE '%white%'
	*/
	function buildWhereLine ($inField, $inOperator, $inValue) {
		if ($inValue == '') {
			return false;
		}
		$prefix = "'%"; //characters to put before value in whereClause
		$postfix = "%'"; //characters to put after value in whereClause
		$operator = ' LIKE '; //SQL where operator to use in whereClause
		switch ($inOperator) {
		  	case 'contains':
		  		//Nothing special, this this our model case
		  		break;
		  	case 'starts with':
		  		$prefix = "'";
		  		break;
			case 'ends with':
		  		$postfix = "'";
		  		break;
			case 'equals':
				$operator = ' = ';
		  		$prefix = '';
				$postfix = '';
		  		break;
			case 'is null':
				$operator = ' IS NULL ';
				$value = '';
		  		$prefix = '';
				$postfix = '';
		  		break;
			case 'is not null':
				$operator = ' IS NOT NULL ';
				$value = '';
		  		$prefix = '';
				$postfix = '';
		  		break;
			default:
		  		//Took care of this with our var init above
		  		break;
		} //End switch
		return ($inField . $operator . $prefix . $inValue . $postfix);			
	} //End function buildWhereLine
	
} //End class FormObject

?>
