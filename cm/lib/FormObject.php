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
			    $this->incDataObject = new $incObjectName; //Start with an empty included object.  It gets loaded in edit()
				if ($this->data['included_order_by']) {
					$this->incDataObject->orderBy($this->data['included_order_by']);
				}
			}
			
			$this->template = new TemplatePower('./templates/' . $this->table . '_' . 'edit' . '.html'); //make a new TemplatePower object with default 'Edit' template
			$this->template->prepare();//let TemplatePower do its thing, parsing etc.;

			return true;
		}

	} //End constructor FormObject

	/**
	* processAction grabs the correct form template, connects to the DB if needed, and outputs the filled out form
	*
	*/
    function processAction () {
		//Try and find a method of this object that matches this->action and run it
		if (method_exists($this, $this->action)) {
			return call_user_func(array(&$this, $this->action));
		} else {
			return false;
		}
	} //End function processAction
		
	/**
	* edit shows the edit form for this object (a blank form if a new object)
	*
	*/
	function edit() {
		if ($this->data['getLinks']) {
		   $this->dataObject->getLinks(); 
		}
		objectValueFill($this->dataObject,$this->template);
		if ($this->incDataObject) {
			$this->incDataObject->staticGet($this->table . '_id',$this->dataObject->id); //Try and load it with the current data
			while($this->incDataObject->fetch()){ //Pull the results through the object and put them on the form
				$this->incDataObject->getLinks();
				$this->template->newBlock($this->included_table . '_row'); //create a new result_row block
				objectValueFill($this->incDataObject,$this->template);
			}
		}
		return true;
	} //End function edit
	
	/**
	* update copies the $this->data variables with matching names to this object, and updates them in the DB
	*
	*/
	function save() {
		$this->dataObject->setFrom($this->data); //Copy the form data into the object.
		if ($this->dataObject->id) {
		    $this->dataObject->update();
		} else {
			$this->dataObject->id = $this->dataObject->insert();
		}
		$this->template->assign('action_message', '<font color="#66CC00">Saved</font>');
		$this->edit();
		return true;
	} //End function update
	
	/**
	* saveIncluded copies the $this->data variables with matching names to this object's includedObject, and updates the included rec the DB
	*
	*/
	function saveIncluded() {
		$this->incDataObject->setFrom($this->data); //Copy the form data into the object.
		if ($this->data['included_id']) {
			$this->incDataObject->id = $this->data['included_id'];
		    $this->incDataObject->update(); //Only update the DB if an id was supplied
			$this->template->assign('action_message', '<font color="#66CC00">Updated</font>');
		} else {
			$this->incDataObject->id = $this->incDataObject->insert();
			$this->template->assign('action_message', '<font color="#66CC00">Added</font>');
		}
		$this->dataObject->get($this->data['parent_id']);
		$incClassName = get_class($this->incDataObject);
		$this->edit();
		return true;
	} //End function updateIncluded
	
	/**
	* delete copies the $this->data variables with matching names to this objec's includedObject, and deletes the matching included row in the DB
	*
	*/
	function delete() {
		if ($this->data['id'] == '') { //No id for this record
			//$this->dataObject->validation_results['form'] .= '<br> Tried to delete a non-existent record.';
			$this->template->assign('action_message', '<font color="#FF0000">Delete Failed!</font>');
			$this->edit();
			return false;
		}
		$this->dataObject->id = $this->data['id'];
		$this->dataObject->delete(); //Try to delete the record in the DB using the object
		$this->template = new TemplatePower('./templates/' . 'deleted.html'); //make a new TemplatePower objec
		$this->template->prepare();//let TemplatePower do its thing, parsing etc.
		return true;
	} //End function delete
	
	/**
	* delete copies the $this->data variables with matching names to this object, and deletes the matching row in the DB
	*
	*/
	function deleteIncluded() {
		if ($this->data['included_id'] == '') { //No id for this record
			$this->dataObject->validation_results['form'] .= '<br> Tried to delete a non-existent record.';
			$this->template->assign('action_message', '<font color="#FF0000">Delete Failed!</font>');
			$this->dataObject->get($this->data['parent_id']);
			$incClassName = get_class($this->incDataObject);
			$this->incDataObject = new $incClassName; //reinit the object to get around DataObject bug
			$this->edit();
			return false;
		}
		$this->incDataObject->id = $this->data['included_id'];
		$this->incDataObject->delete(); //Try to delete the record in the DB using the object
		$this->template->assign('action_message', '<font color="#FF0000">Row Deleted</font>');
		$this->dataObject->get($this->data['parent_id']);
		$incClassName = get_class($this->incDataObject);
		$this->incDataObject = new $incClassName; //reinit the object to get around DataObject bug
		if ($this->data['included_order_by']) {
			$this->incDataObject->orderBy($this->data['included_order_by']);
		}
		$this->edit();
		return true;
	} //End function delete
	
	/**
	* search uses the $this->data(search[]) variables with matching names to this object, and returns matching rows from the DB
	*
	*/
	function search() {
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
				//echo '<PRE> Object{'; print_r($this->dataObject); echo '</PRE>';
				$this->template->newBlock('result_row'); //create a new result_row block
				objectValueFill($this->dataObject,$this->template);
			}
		}
		return true;
	} //End function search
	
	
	/**
	* report pulls the $this->data columns, and displays the results with breaks and subtotals
	*
	*/
	function report() {
		//Using the arrays passed in via $this->data, set up the query
		if ($this->data['selcols']) {
			$this->dataObject->selectAdd(); //Clear the default '*'
			foreach ($this->data['selcols'] as $colName) {
				$this->dataObject->selectAdd($colName);
			}
		} else {
			return false;
		}
		if ($this->data['groupcols']) {
			foreach ($this->data['groupcols'] as $colName) {
				$this->dataObject->groupBy($colName);
			}
		}
		if ($this->data['ordercols']) {
			foreach ($this->data['ordercols'] as $colName) {
				$this->dataObject->orderBy($colName);
			}
		}
		if ($this->data['where']) {
			foreach ($this->data['where'] as $whereRow) {
				$this->dataObject->whereAdd($whereRow);
			}
		}
		if ($this->data['limit']) {
			foreach ($this->data['limit'] as $limit) {
				$this->dataObject->limit($limit);
			}
		}
		
		$this->dataObject->find(); //Run the query with the stuff we just set

		$this->template = new TemplatePower( './templates/report_two_col.html' );//make a new TemplatePower object
		$this->template->prepare();//let TemplatePower do its thing, parsing etc.
		
		foreach ($this->data['selcols'] as $colNum => $colName) {
			$this->template->assign('col' . $colNum . 'Header',ucwords(str_replace('_',' ',$colName)));
		}
		
		$lastCol1 = -1;
		$subtotalCol1Col1 = 0;
		$totalCol1Col1 = 0;
		
		while ($this->dataObject->fetch()) {
			foreach ($this->data['selcols'] as $colNum => $colName) {
				$varName = 'col' . $colNum;
				$$varName = $this->dataObject->$colName; //Tricky.  See the 'variable variables section of the PHP manual
			}
			
			//echo '<pre>Col1:'; echo print_r($col1); echo '</pre>';
			
			switch ($lastCol1) {
				case -1:
					$lastCol1 = $this->dataObject;
					$this->template->newBlock('result_row');
					$this->template->assign('col1',$col1);
				break;
				case ($col1):
					$foo = 'state';
					$this->template->newBlock('result_row');
					$this->template->assign('col1','');
				break;
				default: //when col1 != $lastCol1
					$this->template->newBlock("total_row");
					$this->template->assign('col1',$lastCol1 . ' Subtotal');
					$this->template->assign('col3',$subtotalCol1);
					$subtotalCol1 = 0;
					
					$this->template->newBlock('result_row');
					$this->template->assign('col1',$col1);
				break;
			} //end switch
			$lastCol1 = $col1;
			$subtotalCol1 += $col3;
			$totalCol1 += $col3;
			$this->template->assign('col2',$col2);
			$this->template->assign('col3',$col3);
		}
		$this->template->newBlock("total_row"); //Final subtotal
		$this->template->assign('col1',$lastCol1 . ' Subtotal');
		$this->template->assign('col3',$subtotalCol1);
		$this->template->newBlock("total_row"); //Final total
		$this->template->assign('col1','Grand Total');
		$this->template->assign('col3',$totalCol1);

		return true;
	} //End function report
	
	/**
	* display calls the displayToScreen method of the template object
	*
	*/
    function display () {
		$this->template->printToScreen();
		return true;
	} //End function display

	/**
	* buildWhereLine takes a field, operator and value and builds a SQL where clause line
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
