<?php

/**
 * FormObject is a bridge between the TemplatePower Form Template system
 * and the DataObject Database Object system from PEAR
 * @see TemplatePower <http://templatepower.codocad.com>
 * @see DataObject <http://pear.php.net/manual/en/packages.database.db-dataobject.php>
 *
 * To use:
 *	 Create forms with Template power with names of the form: 
 *		 <table>_edit.html
 *		 <table>_search.html
 *
 *	 Create a php script to catch the results of the form. 
 *	 In that script, create a new FormObject, passing in $_GET and $_POST.
 *	 If the create returns true, call the processAction() method.
 *	 FormObject will display the results of the action you specified
 *	 by populating a form and displaying it.
 *	 Typically, you call your 'catch' script with GET parms from links, and
 *	 process the results of submitted forms via POST.
 *	 Your forms & links will need to send a number of parms to configure the FormObject
 *	 See the FormObject Constructor for a list.
 *
 * CVS Info: $Id: FormObject.php,v 1.22 2002/08/16 23:47:43 cyface Exp $
 *
 * @author Tim White <tim@cyface.com>
 * @since PHP 4.0
 * @copyright Copyright (c) 2002 by Tim White
 * @license GNU General Public License
 **/

require_once('PEAR.php'); //Main PEAR stuff
require_once('DataObject.php'); //Database Access Object
require_once('./lib/class.TemplatePower.inc.php'); //Main TemplatePower Stuff
require_once('./lib/TemplateHelpers.inc.php'); //Custom class that adds convienience methods for dealing with Templates

/**
 * FormObject is the Generic Form Interface Object
 *
 * @author Tim White <tim@cyface.com>
 * @package ConMaster
 **/
class FormObject {
	/* BEGIN PUBLIC METHODS */

	/**
	 * Constructor takes uses the config params passed in sets up the DataObject and Template
	 * 
	 * Input parameters passed in via $_GET or $_POST:
	 *	table - name of the primary database table the form should access REQUIRED NO DEFAULT
	 *	action - action to take on that table (edit, save, search, delete, saveIncluded) REQUIRED NO DEFAULT
	 *	template - name of the html template, located in the templates directory, to use.  OPTIONAL DEFAULT = <table>_edit.html
	 *	form_constants - associative array of any items you just want to pass through (the data from the constant table will be added to this array automatically)
	 *	included_table - name of the table to include as a list of related records on the form OPTIONAL NO DEFAULT
	 *	included_order_by - name of the column to order the included records by OPTIONAL NO DEFAULT
	 *	included_where - where clause fragment to apply to the included table search (on top of <parent_id_col> = <parent_id>) OPTIONAL NO DEFAULT
	 *	included_id - the id of the included row you are updating (used when calling saveIncluded) REQUIRED FOR saveIncluded (when updating) & deleteIncluded NO DEFAULT
	 *	included_parent_id_col - name of the column on the included row that links to the parent record OPTIONAL DEFAULT = <parent_table>_id
	 *	included_search - value to search for an included record with.  Value is passed to the DataObjects_<table> class's includedInsert method for searching REQUIRED for saveIncluded (when inserting) NO DEFAULT
	 *	search[] - associative array of column = search value REQUIRED FOR search NO DEFAULT
	 *	search_operators[] - associative array of column = operator OPTIONAL DEFAULT = LIKE
	 *	<form values> the rest of the parameters will be column=value items for the actual form data REQUIRED for most forms NO DEFAULT
	 *
	 * @param string $inGet - the $_GET variable from a form
	 * @param string $inPost - the $_POST variable from a form
	 * @return boolean True if success False if Failure
	 * @access public
	 * @see DataObject.php (PEAR)
	 * @see TemplatePower
	 **/
	function FormObject ($inGet, $inPost)
	{
		//Set the data of this object using POST or GET
		if ($inPost) { 
			$this->data = $inPost;
		} else {
			$this->data = $inGet;
		}

		//We have to have table and action in the data to continue
		if (!$this->data['table'] or !$this->data['action']) {
			return PEAR::raiseError('No table or action');
		}
		
		// initialize DataObject from the ini files in the config directory
		$options = &PEAR::getStaticProperty('DB_DataObject', 'options');
		$config = parse_ini_file('config/conmaster.ini', true);
		$options = $config['DB_DataObject'];

		//Init this object's private properties from $this->data
		$this->table = $this->data['table'];
		$this->form_constants = $this->data['form_constants']; //Copy any passed in constants to the property
		$this->form_constants['table'] = $this->table;  //Some forms need to have the table name passed in
		$this->action = $this->data['action'];
		$this->included_table = $this->data['included_table'];
		$this->included_class = DB_DataObject::staticAutoloadTable($this->included_table); //@ means 'ignore errors'

		//Load the appropriate DataObject for this form
		$class = DB_DataObject::staticAutoloadTable($this->table); //Name of DataObject subclass to use for data access
		if ($this->data['id']) { //We are working with an existing record
			$this->dataObject = DB_DataObject::staticGet($class, $this->data['id']);
			if (!$this->dataObject) {
				return PEAR::raiseError("$this->table Id $this->data['id'] Not Found");
			}
		} else { //We are creating a new object
			 $this->dataObject = new $class;
		}

		//Load the appropriate template and initialize it
		if ($this->data['template']) {  //If a template specified, use it
			$templateName = './templates/' . $this->data['template'];
		} else { //Otherwise, default to <table>_edit.html
		$templateName = './templates/' . $this->table . '_edit.html';
		}
		$this->template = new TemplatePower($templateName); //make a new TemplatePower object with default 'Edit' template
		$this->template->prepare(); //let TemplatePower do its thing, parsing etc.;

		//If constants weren't disabled, build the form_constants array
		$this->loadConstants();
		
		return true;
	}  //End constructor FormObject
	/**
	 * ProcessAction executes the method named in $this->action
	 * Depends on: $this->action
	 * @access public
	 * @return boolean True if success False if Failure
	 **/
	function processAction ()
	{
		// Try and find a method of this object that matches this->action and run it
		if (method_exists($this, $this->action)) {
			return call_user_func(array(&$this, $this->action));
		} else {
			PEAR::raiseError('Invalid action');
		}
	}  //End function processAction

	/**
	 * Display calls the printToScreen method of the template object
	 * @access public
	 * @return boolean True if success False if Failure
	 **/
	function display ()
	{
		$this->template->printToScreen();
	}  //End function display

	/* END PUBLIC METHODS */

	/* BEGIN PRIVATE PROPERTIES */

	var $table = false; //Name of the DB table this object maps to.								@access private
	var $action = false; //The current action to execute										@access private
	var $included_table = false; //Name of the DB table this object's included table maps to	@access private
	var $included_class = false; //Name of the included table's DataObject subclass 			@access private
	var $data = array('id' => false); //A hash of the data elements of this form				@access private
	var $form_constants = array('table' => false); //A hash of constants to pass to the form	@access private
	var $dataObject = false; //The dataObject associcated with this form						@access private
	var $incDataObject = false; //The included dataObject associcated with this form (subform)	@access private
	var $template = false; //The template Object associcated with this form					 	@access private

	/* END PRIVATE PROPERTIES */

	/* BEGIN PRIVATE METHODS */

	/**
	 * Edit shows the edit form for this object (a blank form if a new object)
	 * Depends on: $this->dataObject, $this->template
	 * @access private
	 **/
	function edit()
	{
		//Load any related tables' data
		$this->dataObject->getLinks();
		
		//Fill in the form variables on the form
		objectValueFill($this->dataObject, $this->template);
		
		//Fill in the constants on the form
		rowFill(array('form_constants' => $this->form_constants),$this->template);
		
		//Process the included table, if one was specified
		if ($this->included_table) {
			$this->editIncluded();
		}
	}  //End function edit
	
	/**
	 * EditIncluded builds the rows for the included table.
	 * Depends on: $this->dataObject, $this->template, $this->included_table
	 * @access private
	 **/
	function editIncluded() 
	{
		//Set up the included object
		$this->incDataObject = new $this->included_class;
		if ($this->data['included_order_by']) {
			$this->incDataObject->orderBy($this->data['included_order_by']);
		}
		if ($this->data['included_where']) {
			$this->incDataObject->whereAdd($this->data['included_where']);
		}
		
		//Display the included Header
		$this->template->newBlock('included_header'); //create a new header for the included rows
		objectValueFill($this->dataObject, $this->template); //Fill in values on the included header
		rowFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the included header
		
		//Search for the included table's records that are related to the master object
		if ($this->data['included_parent_id_col']) {
			$parent_id_col = $this->data['included_parent_id_col'];
		} else {
			$parent_id_col = $this->table . '_id';
		}
		$this->incDataObject->$parent_id_col = $this->dataObject->id;
		$this->incDataObject->find(); //Try and load it with the current data
		
		//Pull each included record and create a new form block for it
		while ($this->incDataObject->fetch()) { // Pull the results through the object and put them on the form
			$this->incDataObject->getLinks();
			$this->template->newBlock($this->included_table . '_row'); //create a new result row
			objectValueFill($this->incDataObject, $this->template); //Fill in values on the included row
			rowFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the included row
		}	
	}
	
	/**
	 * Save copies the $this->data variables with matching names to this object, and updates them in the DB
	 * Depends on: $this->dataObject, $this->template, form info in $this->data
	 * @access private
	 **/
	function save()
	{
		//Copy the form data into the object
		$this->dataObject->setFrom($this->data); 
		
		//Update/Insert the record in the database
		if ($this->dataObject->id) {
			$result = $this->dataObject->update();
		} else {
			$result = $this->dataObject->insert();
			$this->dataObject->id = $result;
		}
		
		errorCheck($result); //If $result is an error, display the message and exit
		
		$this->template->assign('action_message', 'Saved');
		
		$this->edit();
	}  //End function save
	
	/**
	 * saveIncluded copies the $this->data variables with matching names to this object's includedObject, and updates the included rec the DB
	 * Depends on: $this->dataObject, $this-incDataObject, $this->template
	 * @access private
	 **/
	function saveIncluded()
	{
		if (!isset($this->data['id'])) { // If id is null, either the form is hosed, or they somehow didn't save the main record before adding children.
			PEAR::raiseError('No id');
		}
		$this->incDataObject = new $this->included_class;
		$this->incDataObject->setFrom($this->data); //Copy the form data into the included object.

		if ($this->data['included_id']) { // if we have an id, we are updating
			$this->incDataObject->id = $this->data['included_id']; //Didn't get set in setFrom, since included_id isn't a column
			$result = $this->incDataObject->update();
		} else { // If no id supplied we are inserting
			if ($this->data['included_search']) {
				$result = $this->incDataObject->includedInsert($this->data['included_search']);
			} else {
				$result = $this->incDataObject->id = $this->incDataObject->insert();
			}
		}

		$errorMessage = errorCheck($result); //If $result is an error, print message and exit
		
		if ($errorMessage) {
			$this->template->assign('form_error', $errorMessage);
			$this->template->assign('action_message', 'Error!');
		} else {
			$this->template->assign('action_message', 'Saved');
		}
		
		$this->edit();
	}  //End function saveIncluded

	/**
	 * delete deletes the parent (master, main) record from the database
	 * @access private
	 **/
	function delete()
	{		
		errorCheck( $this->dataObject->delete() ); //Try to delete the record in the DB using the object
		
		$this->template = new TemplatePower('./templates/deleted.html'); //switch to the delete template
		$this->template->prepare(); //let TemplatePower do its thing, parsing etc.		
	}  //End function delete

	/**
	 * deleteIncluded copies the $this->data variables for the included Object and deletes the matching row in the DB
	 * @access private
	 **/
	function deleteIncluded()
	{
		if (!$this->data['included_id']) { // No id for this record
			PEAR::raiseError('No included_id');
		}
		
		$this->incDataObject = new $this->included_class;
		$this->incDataObject->get($this->data['included_id']);
		
		errorCheck($this->incDataObject->delete()); //Try to delete the record in the DB using the object
		
		$this->template->assign('action_message', 'Row Deleted');
		
		$this->edit();
	}  //End function deleteIncluded
	
	/**
	 * search uses the $this->data(search[]) variables with matching names to this object, and returns matching rows from the DB
	 * @access private
	 **/
	function search()
	{
		//Switch to, and set up the search template
		$this->template = new TemplatePower('./templates/' . $this->table . '_' . 'search' . '.html'); //make a new TemplatePower object
		$this->template->prepare(); //let TemplatePower do its thing, parsing etc.;
		valueFill($this->data, $this->template); //Put the search values back in the form fields
		rowFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the search form
		
		// Only continue if they submitted critera
		if (!$this->data['search']) { // Only bother to search if they submit critera, show the blank form regardless
			return;
		}
		
		//Build up the search criteria
		foreach ($this->data['search'] as $field => $value) {
			$whereLine = $this->buildWhereLine($field, $this->data['search_operators'][$field], $value);
			if ($whereLine) {
				$this->dataObject->whereAdd($whereLine);
			}
		}
		
		//Search
		errorCheck ( $this->dataObject->find() );
		
		$this->template->assign('action_message', $this->dataObject->N . ' Found');
		
		//Populate the search results on the form
		while ($this->dataObject->fetch()) { // Pull the results through the object and put them on the form
			$this->dataObject->getLinks();
			$this->template->newBlock('result_row'); //create a new result_row block
			objectValueFill($this->dataObject, $this->template);
		}
	}  //End function search

	/**
	 * loadConstants loads constant table into form_constants[]
	 * @access private
	 **/
	function loadConstants() {
			$constantClass = DB_DataObject::staticAutoloadTable('constant');  //Load the subclass definition
			$constantObject = new $constantClass;  //Create a new instance of the object

			$constantObject->orderBy('constant,ordinal');
			$constantObject->find();  //Get all the constants

			$lastConstant = false;
			while ($constantObject->fetch()) {  //Loop through multiple results and assign to form_constants
				if ($constantObject->constant != $lastConstant) {
					$loopCnt = 0;
				}
				$this->form_constants[$constantObject->constant][$loopCnt] = $constantObject;
				$loopCnt++;
				$lastConstant = $constantObject->constant;
			}
	} //End function loadConstants

	/**
	 * buildWhereLine takes a field, operator and value and builds a SQL where clause line
	 * @param string $inField - name of the field to compare to a value
	 * @param string $inOperator - the comparison name (as would appear on a search form)
	 * @param string $inValue - value to compare to
	 * @return string - assembled where clause line such as: last_name LIKE '%white%'
	 * @access private
	 **/
	function buildWhereLine ($inField, $inOperator, $inValue)
	{
		if ($inValue == '') {
			return false;
		}
		$prefix = "'%"; //characters to put before value in whereClause
		$postfix = "%'"; //characters to put after value in whereClause
		$operator = ' LIKE '; //SQL where operator to use in whereClause
		switch ($inOperator) {
			case 'contains':
				// Nothing special, this this our model case
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
				// Took care of this with our var init above
				break;
		}  //End switch
		return ($inField . $operator . $prefix . $inValue . $postfix);
	}  //End function buildWhereLine
}  //End class FormObject

?>
