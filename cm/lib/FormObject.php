<?php

/**
 * FormObject is a bridge between a Template system and a Datbase Object system
 * Template = TemplatePower, DataObject = DataObject (from PEAR)
 *
 * To use:
 *     Create a form, with {varName} subsitutions for the result variables
 *     And search[varName] fields to send search parameters.
 *     You will have to send a number of hidden variables, notably 'action'
 *     In order to tell FormObject how to process the form.
 * @see TemplatePower docs for more information on how to set up blocks and such
 *
 *     Create a php script to catch the results of the form. In that script,
 *     create a new FormObject, passing in $_GET and $_POST.
 *     If the create is successful, call the processAction() method.
 *     FormObject will return the results of the action you specified
 *     by populating a form and displaying it.
 *
 * CVS Info: $Id: FormObject.php,v 1.13 2002/07/24 21:43:58 cyface Exp $
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

/**
 * FormObject is the Generic Form Interface Object
 *
 * @author Tim White <tim@cyface.com>
 * @package ConMaster
 **/
class FormObject {
    /* BEGIN PUBLIC METHODS */

    /**
     * Constructor takes the inputs from the form and, based on 'action', processes them.
     * @param string $inGet - the $_GET variable from a form
     * @param string $inPost - the $_POST variable from a form
	 * @return boolean True if success False if Failure
	 * @access public
     * @see DataObject.php (PEAR)
     * @see TemplatePower
     **/
    function FormObject ($inGet, $inPost)
    {
        if ($inPost) { //Set the data of this object to the Post vars if they came through
            $this->data = $inPost;
        } else {
            $this->data = $inGet; //Otherwise, use the get vars
        }

		//We have to have table and action in the data to continue
        if (!$this->data['table'] or !$this->data['action']) {
            echo '<br>No Table or Action<br>';
            return false;
		}

		//Init this object's private properties from $this->data
        $this->table = $this->data['table'];
		$this->form_constants['table'] = $this->table;  //Some forms need to have the table name passed in
        $this->action = $this->data['action'];

        // initialize DataObject
        $options = &PEAR::getStaticProperty('DB_DataObject', 'options');
        $config = parse_ini_file('./lib/DataObjects/cyface.ini', true);
        $options = $config['DB_DataObject'];

		//Load the appropriate DataObject for this form
        $objectName = 'DataObjects_' . ucwords($this->table); //Name of DataObject subclass to use for data access
        if ($this->data['id']) { //If id is not null, we are loading a single record
            $this->dataObject = DB_DataObject::staticGet($objectName, $this->data['id']);
        } else { //We are loading mutiple records, or more like, processing the included table
            require_once('./lib/DataObjects/' . ucwords($this->table) . '.php');
            $this->dataObject = new $objectName;
        }

		//Load the appropriate template and initialize it
		if ($this->data['template']) {  //If a template specified, use it
		  	$templateName = './templates/' . $this->data['template'];
		} else { //Otherwise, default to <table>_edit.html
		$templateName = './templates/' . $this->table . '_edit.html';
		}
        $this->template = new TemplatePower($templateName); //make a new TemplatePower object with default 'Edit' template
        $this->template->prepare(); //let TemplatePower do its thing, parsing etc.;

		//If constants were specified, load them
		if ($this->data['load_constants']) {
			$this->loadConstants();
		}

		//Set up the included object, if specified
        if ($this->data['included_table']) {
            $this->included_table = $this->data['included_table'];
            require_once('./lib/DataObjects/' . ucwords($this->included_table) . '.php');
            $incObjectName = 'DataObjects_' . ucwords($this->included_table); //Name of DataObject subclass to use for data access
            $this->incDataObject = new $incObjectName; //Start with an empty included object.  It gets loaded in edit()
            if ($this->data['included_order_by']) {
                $this->incDataObject->orderBy($this->data['included_order_by']);
            }
        }
        return true;
    }  //End constructor FormObject
	/**
     * ProcessAction grabs the correct form template, connects to the DB if needed, and outputs the filled out form
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
			echo '<br>Invalid Action<br>';
            return false;
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
	    return true;
	}  //End function display

	/* END PUBLIC METHODS */

	/* BEGIN PRIVATE PROPERTIES */

	var $table = false; //Name of the DB table this object maps to.								@access private
	var $action = false; //The current action to execute										@access private
	var $included_table = false; //Name of the DB table this object's included table maps to.	@access private
    var $data = array('id' => false); //A hash of the data elements of this form 				@access private
    var $form_constants = array('table' => false); //A hash of constatnts to pass to the form   @access private
	var $dataObject = false; //The dataObject associcated with this form 						@access private
    var $incDataObject = false; //The included dataObject associcated with this form (subform)	@access private
    var $template = false; //The template Object associcated with this form						@access private

	/* END PRIVATE PROPERTIES */

	/* BEGIN PRIVATE METHODS */

	/**
     * Edit shows the edit form for this object (a blank form if a new object)
	 * Depends on: $this->dataObject, $this->template
	 * Can use: $this-incDataObject
	 * @access private
	 * @return boolean True if success False if Failure
     **/
    function edit()
    {
        $this->dataObject->getLinks();
		objectValueFill($this->dataObject, $this->template);
		rowFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the main form
		if ($this->incDataObject) {
			$this->template->newBlock('included_header'); //create a new header for the included rows
            objectValueFill($this->dataObject, $this->template); //Fill in values on the included header
			rowFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the included header
			if ($this->data['included_parent_id_col']) {
				$parent_id_col = $this->data['included_parent_id_col'];
			} else {
				$parent_id_col = $this->table . '_id';
			}
            $this->incDataObject->$parent_id_col = $this->dataObject->id;
			if ($this->data['included_where']) {
			    $this->incDataObject->whereAdd($this->data['included_where']);
			}
            $this->incDataObject->find(); //Try and load it with the current data
            while ($this->incDataObject->fetch()) { // Pull the results through the object and put them on the form
                $this->incDataObject->getLinks();
                $this->template->newBlock($this->included_table . '_row'); //create a new result row
                objectValueFill($this->incDataObject, $this->template); //Fill in values on the included row
				rowFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the included row
            }
        }
        return true;
    }  //End function edit
	/**
     * Save copies the $this->data variables with matching names to this object, and updates them in the DB
     * Depends on: $this->dataObject, $this->template
	 * @access private
	 * @return boolean True if success False if Failure
	 **/
    function save()
    {
        $this->dataObject->setFrom($this->data); //Copy the form data into the object.
        if ($this->dataObject->id) {
            $result = $this->dataObject->update();
            if (PEAR::isError($result)) {
                $this->template->assign('form_error', $result->getMessage());
                $this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
            } else {
                $this->template->assign('action_message', '<font color="#66CC00">Updated</font>');
            }
        } else {
            $result = $this->dataObject->insert();
            if (PEAR::isError($result)) {
                $this->template->assign('form_error', $result->getMessage());
                $this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
            } else {
                $this->dataObject->id = $result;
                $this->template->assign('action_message', '<font color="#66CC00">Updated</font>');
            }
        }
        $this->template->assign('action_message', '<font color="#66CC00">Saved</font>');
        $this->edit();
        return true;
    }  //End function save
	/**
     * saveIncluded copies the $this->data variables with matching names to this object's includedObject, and updates the included rec the DB
     * Depends on: $this->dataObject, $this-incDataObject, $this->template
	 * @access private
	 * @return boolean True if success False if Failure
	 **/
    function saveIncluded()
    {
        if ($this->data['parent_id']) { // If parent_id is null, either the form is hosed, or they forgot to save the main record before adding children.
            $this->incDataObject->setFrom($this->data); //Copy the form data into the object.
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
        } else {
            $result = new PEAR_error ('You needed to save your main record before trying to add an included record.');
        }
        if (PEAR::isError($result)) {
            $this->template->assign('form_error', $result->getMessage());
            $this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
        }
        $this->dataObject->get($this->data['parent_id']);
        $incClassName = get_class($this->incDataObject);
        $this->incDataObject = new $incClassName; //Have to clear out the old stuff so that edit() will work - workaround for DataObject 'bug'
        if ($this->data['included_order_by']) {
            $this->incDataObject->orderBy($this->data['included_order_by']);
        }
        $this->edit();
        return true;
    }  //End function updateIncluded

	/**
     * delete copies the $this->data variables with matching names to this objec's includedObject, and deletes the matching included row in the DB
	 * @access private
	 * @return boolean True if success False if Failure
     **/
    function delete()
    {
        if ($this->data['id'] == '') { // No id for this record
            $this->template->assign('action_message', '<font color="#FF0000">Delete Failed!</font>');
            $this->edit();
            return false;
        }
        $this->dataObject->id = $this->data['id'];
        $result = $this->dataObject->delete(); //Try to delete the record in the DB using the object
        if (PEAR::isError($result)) {
            $this->template->assign('form_error', $result->getMessage());
            $this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
            $this->edit();
        } else {
            $this->template = new TemplatePower('./templates/deleted.html'); //make a new TemplatePower objec
            $this->template->prepare(); //let TemplatePower do its thing, parsing etc.
            valueFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the delete form
            $this->template->assign('action_message', '<font color="#FF0000">Deleted.</font>');
        }

        return true;
    }  //End function delete

	/**
     * deleteIncluded copies the $this->data variables for the included Object and deletes the matching row in the DB
	 * @access private
	 * @return boolean True if success False if Failure
     **/
    function deleteIncluded()
    {
        if ($this->data['included_id'] == '') { // No id for this record
            $this->dataObject->validation_results['form'] .= '<br> Tried to delete a non-existent record.';
            $this->template->assign('action_message', '<font color="#FF0000">Delete Failed!</font>');
            $this->dataObject->get($this->data['parent_id']);
            $incClassName = get_class($this->incDataObject);
            $this->incDataObject = new $incClassName; //reinit the object to get around DataObject bug
            $this->edit();
            return false;
        }
        $this->incDataObject->get($this->data['included_id']);
        // echo '<PRE> IncObject Before Delete:<br>'; print_r($this->incDataObject); echo '</PRE>';
        $result = $this->incDataObject->delete(); //Try to delete the record in the DB using the object
        if (PEAR::isError($result)) {
            $this->template->assign('form_error', $result->getMessage());
            $this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
        } else {
            $this->template->assign('action_message', '<font color="#FF0000">Row Deleted</font>');
        }
        $this->dataObject->get($this->data['parent_id']);
        $incClassName = get_class($this->incDataObject);
        $this->incDataObject = new $incClassName; //reinit the object to get around DataObject bug
        if ($this->data['included_order_by']) {
            $this->incDataObject->orderBy($this->data['included_order_by']);
        }
        $this->edit();
        return true;
    }  //End function deleteIncluded
	/**
     * search uses the $this->data(search[]) variables with matching names to this object, and returns matching rows from the DB
	 * @access private
	 * @return boolean True if success False if Failure
     **/
    function search()
    {
        $this->template = new TemplatePower('./templates/' . $this->table . '_' . 'search' . '.html'); //make a new TemplatePower object
        $this->template->prepare(); //let TemplatePower do its thing, parsing etc.;
        valueFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the search form
        if ($this->data['search']) { // Only bother to search if they submit critera, show the blank form regardless
            valueFill($this->data, $this->template); //Put the search values back in the form fields
            foreach ($this->data['search'] as $field => $value) {
                $whereLine = $this->buildWhereLine($field, $this->data['search_operators'][$field], $value);
                if ($whereLine) {
                    $this->dataObject->whereAdd($whereLine);
                }
            }
            $result = $this->dataObject->find();
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
    }  //End function search
	/**
     * report pulls the $this->data columns, and displays the results with breaks and subtotals
	 * @access private
	 * @return boolean True if success False if Failure
     **/
    function report()
    {
        $this->template = new TemplatePower('./templates/report_two_col.html'); //make a new TemplatePower object
        $this->template->prepare(); //let TemplatePower do its thing, parsing etc.
        valueFill(array('form_constants' => $this->form_constants),$this->template); //Fill in the array of constants on the report form
        // Using the arrays passed in via $this->data, set up the query
        if ($this->data['selcols']) {
            $this->dataObject->selectAdd(); //Clear the default '*'
            foreach ($this->data['selcols'] as $colName) {
                $this->dataObject->selectAdd(stripslashes(urldecode($colName)));
            }
        } else {
            return false;
        }

        if ($this->data['titles']) {
            foreach ($this->data['titles'] as $colNum => $colName) {
                $this->template->assign('col' . $colNum . 'Header', $colName);
            }
        } else {
            foreach ($this->data['selcols'] as $colNum => $colName) {
                $this->data['titles'][$colNum] = ucwords(str_replace('_', ' ', $colName));
                $this->template->assign('col' . $colNum . 'Header', $this->data['titles'][$colNum]);
            }
        }

        if ($this->data['groupcols']) {
            foreach ($this->data['groupcols'] as $colName) {
                $this->dataObject->groupBy(stripslashes(urldecode($colName)));
            }
        }
        if ($this->data['ordercols']) {
            foreach ($this->data['ordercols'] as $colName) {
                $this->dataObject->orderBy(stripslashes(urldecode($colName)));
            }
        }
        if ($this->data['where']) {
            foreach ($this->data['where'] as $whereRow) {
                $this->dataObject->whereAdd(stripslashes(urldecode($whereRow)));
            }
        }
        if ($this->data['limit']) {
            foreach ($this->data['limit'] as $limit) {
                $this->dataObject->limit($limit);
            }
        }

        $result = $this->dataObject->find(); //Run the query with the stuff we just set
        if (PEAR::isError($result)) {
            $this->template->assign('form_error', $result->getMessage());
            $this->template->assign('action_message', '<font color="#FF0000">Error!</font>');
        } else {
            $this->template->assign('action_message', $this->dataObject->N . ' Found');
        }

        $lastCol1 = -1;
        $subtotalCol1Col1 = 0;
        $totalCol1Col1 = 0;

        while ($this->dataObject->fetch()) {
            foreach ($this->data['selcols'] as $colNum => $colName) {
                $varName = 'col' . $colNum;
                $varName = $this->dataObject->$colName; //Tricky.  See the 'variable variables section of the PHP manual
            }

            // echo '<pre>Col1:'; echo print_r($col1); echo '</pre>';
            switch ($lastCol1) {
            case -1:
                $lastCol1 = $this->dataObject;
                $this->template->newBlock('result_row');
                $this->template->assign('col1', $col1);
                break;
            case ($col1):
                $foo = 'state';
                $this->template->newBlock('result_row');
                $this->template->assign('col1', '');
                break;
            default: // when col1 != $lastCol1
                $this->template->newBlock("total_row");
                $this->template->assign('col1', $lastCol1 . ' Subtotal');
                $this->template->assign('col3', $subtotalCol1);
                $subtotalCol1 = 0;

                $this->template->newBlock('result_row');
                $this->template->assign('col1', $col1);
                break;
			}  //end switch
			$lastCol1 = $col1;
			$subtotalCol1 += $col3;
			$totalCol1 += $col3;
			$this->template->assign('col2', $col2);
			$this->template->assign('col3', $col3);
		}
		$this->template->newBlock("total_row"); //Final subtotal
		$this->template->assign('col1', $lastCol1 . ' Subtotal');
		$this->template->assign('col3', $subtotalCol1);
		$this->template->newBlock("total_row"); //Final total
		$this->template->assign('col1', 'Grand Total');
		$this->template->assign('col3', $totalCol1);

    	return true;
	}  //End function report
	/**
	 * loadConstants loads the groups in $this->data['load_constants'] into form_constants[] from constant
	 * @access private
	 **/
	function loadConstants() {
		foreach ($this->data['load_constants'] as $constant => $table) {
			//Load the appropriate DataObject for this form
			$objectName = 'DataObjects_' . ucwords($table); //Name of DataObject subclass to use for data access
			require_once('./lib/DataObjects/' . ucwords($table) . '.php');  //Load the subclass definition
			$constantObject = new $objectName;  //Create a new instance of the object

			//Set up the search criteria for the object
			if ($table == 'constant') {
				$constantObject->whereAdd('constant = \'' . $constant . '\'');
				$constantObject->orderBy('ordinal');
			}
        	if ($this->data['load_constants_where']) {
				if ($this->data['load_constants_where'][$constant]) {
					$constantObject->whereAdd(urldecode(stripslashes($this->data['load_constants_where'][$constant])));
				}
			}

			//Set the names for the result columns
			$cols['name']='name';
			$cols['value']='value';
			$cols['ordinal']='ordinal';
			$cols['extra_info']='extra_info';
			if ($this->data['load_constants_cols']) {
				if ($this->data['load_constants_cols'][$constant]) {
					list($cols['name'],$cols['value'],$cols['ordinal'],$cols['extra_info'])=split(',',$this->data['load_constants_cols'][$constant]);
				}
			}
			//echo "Columns:" . $cols['name'] . $cols['value'] . "<br>"; //Testing Only

			//Search
			$constantObject->find();
			$loopCnt = 0;
			while ($constantObject->fetch()) {  //Loop through multiple results and assign to form_constants
				$this->form_constants[$constant][$loopCnt]['name'] = $constantObject->$cols['name'];
				$this->form_constants[$constant][$loopCnt]['value'] = $constantObject->$cols['value'];
				$this->form_constants[$constant][$loopCnt]['ordinal'] = $constantObject->$cols['ordinal'];
				$this->form_constants[$constant][$loopCnt]['extra_info'] = $constantObject->$cols['extra_info'];
				$loopCnt++;
			}
		}
	    //echo '<PRE> form_constants:<br>'; print_r($this->form_constants); echo '</PRE>';
		return true;
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
