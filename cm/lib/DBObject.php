<?php

require_once("pear/DB.php"); //PEAR Database Access Code
include_once("pear/Log.php"); //PEAR Database Access Code

/**
* DBObject is the Generic DB Interface Object
*
*
*/
class DBObject {
	var $table_name = false; //Name of the DB table this object maps to.
	var $db = false; //Database Connection Handle, set with DB_Connect
	var $log = false; //the log that this Object will write to
	var $validation_results = array(); //A hash of the fieldname and error messages.
	var $data = array('id' => false); //A hash of the data elements of this object.

	/**
	* constructor looks up the names of the fields in the database and builds the data array
	*
	* @param string $inTableName name of the DB table to pull names from
	*/
    function DBObject ($inTableName) {
		$log = &Log::singleton('file', 'logs/db.log', 'db_log');
		$log->log('DB Object Created for ' . $inTableName);

		$this->table_name = $inTableName;

		$this->DB_Connect();

		$query = "SELECT * FROM $inTableName LIMIT 0";

		$result = $this->db->query($query);

		if (DB::isError($result)) {
			$log->log('DB Error!');
			$this->handle_pear_error($result);
			return false;
		}

		foreach ($result->tableInfo() as $key => $value) {
			//echo "Column: " . $value['name'] . '<br>'; //Testing Only
			$this->data[$value['name']] = false; //Add a key to the data array for each field name
		}
		return true;
	}//End function DBObject

	/**
	* validate_all validates the input hash using name-matched _validate functions
	*
	* @param array $inHash hashtable of names and input data you would like to validate
	*/
    function validate_all ($inHash) {
		//Reinitalize the validation_results field
		$this->validation_results = '';
		$validation_status = true;

		//For each field, look for a matching value in the inHash
		//If you find it, call its validation function if there is one
		foreach ($inHash as $key => $value) {
			if (method_exists($this, $key . '_validate')) {
				if (call_user_func(array(&$this, $key . '_validate'),$value)) {
				} else {
					$validation_status = false;
				}
			}
		}
		//Return true if everything was valid, false if anything wasn't
		//Exact error messages are in $this->validation_results
		return $validation_status;
	}//End function validate_all

	/**
	* assign_all assigns the input hash values to the name-matched object fields
	*
	* @param array $inHash hashtable of names and input data you would like to assign
	*/
	function assign_all ($inHash) {
		//echo "Attempting Assign All<br>";  //Testing Only
		if (!$this->data['id'] < 1) { //If this is an existing row, load the old data first
			$this->load_all($this->data['id']);
		}
		foreach ($this->get_data() as $key => $value) {
			if (array_key_exists($key, $inHash)) {
				$this->data[$key] = stripslashes($inHash[$key]);
			}
		}
		return true;
	} //End function assign_all

	/**
	* save_all saves the values of all the fields to the database
	*
	*/
	function save_all () {
		//echo 'Attempting Save All<br>'; //Testing only
		$this->DB_Connect();

		$whereClause = 'id = ' . $this->data['id'];

		if ($this->data['id'] < 1) {
			//echo 'Insert Mode<br>';  //Testing Only
			$func = DB_AUTOQUERY_INSERT;
		} else {
			//echo 'Update Mode<br>';  //Testing Only
			$func = DB_AUTOQUERY_UPDATE;
		}

		if ($func == DB_AUTOQUERY_UPDATE) { //Check to make sure it hasn't been mod'ed since last load
		    $last_modified = $this->db->getOne('SELECT last_modified FROM ' . $this->table_name . ' WHERE ' . $whereClause);
			if (DB::isError($last_modified)) {
				$this->handle_pear_error($last_modified);
				return false;
			}

			if ($last_modified != $this->data['last_modified']) {
				$this->validation_results['form'] .= '<br> Record has been modified since last load.  Form now shows latest values from DB.  Please repeat your edits and resave. ';
				$this->load_all($this->data['id']); //get the values from the DB for redisplay
				return false;
			}
		}

		unset($this->data['last_modified']); //Clear it out so that it gets updated automatically by MySQL.

		$fieldNames = array_keys($this->get_data());
		$fieldValues = array_values($this->get_data());

		$stmt = $this->db->autoPrepare($this->table_name,$fieldNames,$func,$whereClause);

		/*
		echo 'fieldNames:<br>'; //Testing only
		foreach ($fieldNames as $key => $value) {
			echo "NKey: $key, Value: $value<br>";
		}
		echo '<br>fieldValues:<br>';
				foreach ($fieldValues as $key => $value) {
					echo "VKey: $key, Value: $value<br>";
		}
		echo "WhereClause: $whereClause <br>";
		echo 'Prepared Stmt: ' . $this->db->prepared_queries[$stmt] . ' <br>';
		*/

		$result = $this->db->execute($stmt,$fieldValues);

		if (DB::isError($result)) {
			$this->handle_pear_error($result);
			return false;
		}

		if ($func == DB_AUTOQUERY_INSERT) { //New Record, need to fetch the newly generated id from the DB
			$this->data['id'] = $this->db->getOne('SELECT LAST_INSERT_ID() FROM ' . $this->table_name);
			if (DB::isError($this->data['id'])) {
				$this->handle_pear_error($this->data['id']);
				return false;
			}
			//echo 'ID: ' . $this->data['id'] . '<br>'; //Testing Only
		}

		$this->data['last_modified'] = $this->db->getOne('SELECT last_modified FROM ' . $this->table_name . ' WHERE id = ' . $this->data['id']);
			if (DB::isError($this->data['id'])) {
				$this->handle_pear_error($this->data['id']);
				return false;
			}
		//echo 'Last Mod: ' . $this->data['last_modified'] . '<br>'; //Testing Only

		$this->DB_Disconnect();
		return true;
	} //End function save_all

	/**
	* load_all loads the values of all the fields from the database
	*
	* @param string $primary_key - the primary key of the row to load
	* @param boolean $lock - true if you want to lock the row in the DB, defaults to false
	*/
	function load_all ($inKey, $inLoadChildren = false, $lock = false) {
		$this->DB_Connect();

		if ($lock) {
			$row = $this->db->getRow("SELECT * FROM $this->table_name FOR UPDATE WHERE id = $inKey",DB_FETCHMODE_ASSOC);
		} else {
			$row = $this->db->getRow("SELECT * FROM $this->table_name WHERE id = $inKey",DB_FETCHMODE_ASSOC);
		}

		if (DB::isError($row)) {
			$this->handle_pear_error($row);
		return false;
		}

		if ($row == '') { //No data found
			$this->validation_results['form'] .= '<br> Tried to load a non-existent record.';
			return false;
		}

		$row = $this->load_related($row); //Add sub-arrays for each related table
		
		if ($inLoadChildren) {
		    $row = $this->load_children($row); //Add sub-arrays for each related child row
		}
		
		//Assign each field from the row to the data array of this object
		foreach ($row as $key => $value) {
			$this->data[$key] = $row[$key];
		}
		
		return true;
	} //End function load_all

	/**
	* delete deletes the database row pointed to by this object
	*
	* @param string $primary_key - optional if you have already called load_all - the primary key of the row to delete
	*/
	function delete($inKey = false) {
		if (!$inKey) {
			if ($this->data['id']) {
		    	$inKey = $this->data['id'];
			} else {
				return false;
			}
		}
		$this->DB_Connect();

		$result = $this->db->query('DELETE FROM ' . $this->table_name . ' WHERE id = ' . $inKey,DB_FETCHMODE_ASSOC);

		if (DB::isError($result)) {
			$this->handle_pear_error($result);
			return false;
		}
		return true;
	} //End function delete

	/**
	* update_all validates, assigns, and then saves the data from the input hash
	*
	* @param array $inHash Hashtable of values to check, set, and save.
	*/
	function update_all ($inHash) {
		//cho "Attempting Update All<br>"; //Testing Only
		if ($this->validate_all($inHash)) {
			if ($this->assign_all($inHash)) {
				if ($this->save_all()) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} else {
			return false;
		}
	} //End function update_all

	/**
	* find_all takes the search critera and returns a result hash.
	*
	* @param array $inCriteria Hashtable field_name => search value
	* @param array $inOperators Optional Hashtable of field_name => search operator
	*/
	function find_all ($inCriteria, $inOperators = false, $inLoadChildren = false) {
		$this->DB_Connect();

		foreach ($inCriteria as $field => $value) {
			if ($value != '') {
					$prefix = "'%"; //characters to put before value in whereClause
					$postfix = "%'"; //characters to put after value in whereClause
					$operator = ' LIKE '; //SQL where operator to use in whereClause
				    switch($inOperators[$field]){
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
							$operator = '=';
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
				    }
					$whereClause .= $field . $operator . $prefix . $value . $postfix . " AND ";
				}
		}
		$whereClause = substr_replace($whereClause,'',strlen($whereClause)-5,5); //Strip off the trailing AND
		//echo "WhereClause: $whereClause <br>"; //Testing Only

		if ($whereClause == '') { //If they submit no criteria, find everything
			$whereClause = '1';
		}

		$results = $this->db->getAll("SELECT * FROM $this->table_name WHERE " . $whereClause,DB_FETCHMODE_ASSOC);

		if (DB::isError($results)) {
			$this->handle_pear_error($results);
			return false;
		}
		
		foreach ($results as $rownum => $rowdata) {
			$results[$rownum] = $this->load_related($rowdata);
			if ($inLoadChildren) {
			    $results[$rownum] = $this->load_children($rowdata);
			}
		}
		
		return $results;

	} //End function find_all


	/**
	* relation_list
	*
	*/
	function relation_list ($inTableName, $inDirection = 'master') {
		switch($inDirection){
			case 'master':
				$relations = $this->db->getAll('SELECT * FROM pma_relation WHERE ' . 'master_table = \'' . $inTableName . '\'',DB_FETCHMODE_ASSOC);
				break;
			case 'foreign':
				$relations = $this->db->getAll('SELECT * FROM pma_relation WHERE ' . 'foreign_table = \'' . $inTableName . '\'',DB_FETCHMODE_ASSOC);
				break;
			default:
				return false;
		}
		if (DB::isError($relations)) {
			$this->handle_pear_error($relations);
			return false;
		}
		//echo '<PRE>Relations:<br>';
		//print_r($relations);
		//echo '</PRE>';
		return $relations;
	}
	
	/**
	* load_related - loads the related table information for a given table row
	*
	* @param array - inRow - a hash representing a single row of the table	
	* @param array - inTableName - name of the table to load related records for - defaults to object's table_name
	*/
	function load_related ($inRow, $inTableName = false) {
		if (!$inTableName) {
		    $inTableName =$this->table_name;
		}
	
		$this->DB_Connect();
		if (!$relations = $this->relation_list($inTableName)) {//Get list of relations
				return $inRow;
		}
		
		foreach ($relations as $relation) {
			if ($inRow[$relation['master_field']] != '') {
				$sql = 'SELECT * FROM ' . $relation['foreign_table'] . ' WHERE ' . $relation['foreign_field'] . ' = \'' . $inRow[$relation['master_field']] . '\'';
				//echo 'SQL: ' . $sql . '<br>';
				$result = $this->db->getRow($sql,DB_FETCHMODE_ASSOC);
				
				if (DB::isError($result)) {
					$this->handle_pear_error($result);
					return false;
				}
				
				$inRow['related_' . $relation['foreign_table']] = $result;
			}
		}
		return $inRow;
	} //End function load_related
		
	/**
	* load_children - loads the related table information for a given table row
	*
	* @param array - inRow - a hash representing a single row of the table
	*/
	function load_children ($inRow) {
		$this->DB_Connect();
		$relations = $this->db->getAll('SELECT * FROM pma_relation WHERE foreign_table = \'' . $this->table_name . '\'',DB_FETCHMODE_ASSOC);
			
		if (DB::isError($relations)) {
				$this->handle_pear_error($relations);
				return false;
		}
			
		foreach ($relations as $relation) {
			if ($inRow[$relation['foreign_field']] != '') {
				$sql = 'SELECT * FROM ' . $relation['master_table'] . ' WHERE ' . $relation['master_field'] . ' = \'' . $inRow[$relation['foreign_field']] . '\'';
				//echo 'SQL: ' . $sql . '<br>';
				$results = $this->db->getAll($sql,DB_FETCHMODE_ASSOC);
				
				if (DB::isError($results)) {
					$this->handle_pear_error($results);
					return false;
				}
					
				foreach ($results as $rownum => $rowdata) {
					$results[$rownum] = $this->load_related($rowdata,$relation['master_table']);
				}
				
				$inRow['child_' . $relation['master_table']] = $results;
			}
		}
		return $inRow;
	} //End function load_children

	/**
	* DB_Connect connects to the database and sets $this->db if not already set
	*
	*/
	function DB_Connect () {
		if (!$this->db) {
			require_once('config.inc.php'); //Has dsn in it.
			$this->db = DB::connect($dsn,array('debug' => '5'));

			if (DB::isError($this->db)) {
				$this->handle_pear_error($this->db);
			}
		}
	} //End function DB_Connect

	/**
	* DB_Disconnect disconnects from the database and sets $this->db to false
	*
	*/
	function DB_Disconnect () {
		if (!$this->db) {
			$this->db = DB::disconnect($dsn);
			$this->db = false;
		}
		if (DB::isError($this->db)) {
			$this->handle_pear_error($this->db);
		}
	} //End function DB_Disconnect

	/**
	* handle_pear_error echos any pear errors
	*
	* @param array $error error data to echo
	*/
	function handle_pear_error ($error) {
		echo "An error occurred while trying to run your query.<br>\n";
		echo "Error message: " . $error->getMessage() . "<br>\n";
		echo "A more detailed error description: " . $error->getDebugInfo() . "<br>\n";
	}

	/**
	* val_in_list checks to see if the value is in the list supplied
	*
	* @param string $key name of the key that this value is assigned to
	* @param string $inVal value to see if matches the list
	* @param array $inList array of possible values
	*/
	function val_in_list ($key, $inVal, $inList) {
		if (in_array($inVal, $inList)) {
			return true;
		} else {
			$this->validation_results[$key] .= ucwords($key) . ' must be one of: ' . implode($inList,', ') . '.  ';
			return false;
		}
	} //End function val_in_list

	/**
	* get_data returns an array of the data fields this object.
	*
	*/
	function get_data () {
		return $this->data;
	} //End function get_data

} //End class DBObject

?>
