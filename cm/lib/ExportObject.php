<?php

require_once('PEAR.php'); //Main PEAR stuff
require_once('DataObject.php'); //Database Access Object
require_once('DB.php'); //Database Access Interface

function handle_pear_error ($error) {
    echo "An error occurred while trying to run your query.<br>\n";
    echo "Error message: " . $error->getMessage() . "<br>\n";
    echo "A more detailed error description: " . $error->getDebugInfo() . "<br>\n";
}

/**
 * ExportObject is the Generic Flat File Export Object
 *
 * @author Tim White <tim@cyface.com>
 * @package ConMaster
 **/
class ExportObject {
	var $query = false; //The query string							@access private
	var $queryFile = false; //The file containing the query string	@access private
	var $db = false; //The database connection handle				@access private

	/**
	 * ExportObject constructor
	 *
	 * @param array inGet - the $_GET array from a request, or an assoc array with the right stuff
	 * @author Tim White <tim@cyface.com>
	 * @package ConMaster
 	 **/
	function ExportObject ($inGet) {
		$this->queryFile = $inGet['queryFile'];

		if (!$this->queryFile) {
			echo "No Query File.";
			return false;
		}

		$this->format = $inGet['format'];

		if (isset($inGet['quotes'])) {
			if ($inGet['quotes'] == 'off') {
				$this->quotes = false;
			} else {
				$this->quotes = true;
			}
		} else {
			$this->quotes = true;
		}
		$this->query = implode('',file('./sql/' . $this->queryFile,1));

		// get DataObject's config - so we can use the config directly.
		$options = &PEAR::getStaticProperty('DB_DataObject', 'options');
		$config = parse_ini_file('./lib/DataObjects/cyface.ini', true);
		$options = $config['DB_DataObject'];

		PEAR::setErrorHandling(PEAR_ERROR_CALLBACK, 'handle_pear_error');

		$db = DB::connect($options['database']);

		$this->result = $db->getAll($this->query,null,DB_FETCHMODE_ASSOC);

	}

	/**
	 * getFormattedResults returns a array with the formatted results of the query
	 *
	 * @return array Returned array contains formatted results, with commas and tabs, etc.
	 * @author Tim White <tim@cyface.com>
	 * @package ConMaster
 	 **/
	function getFormattedResults() {
		//Set up the delimiter
		switch ($this->format) {
			case 'csv':
				$delimiter = ',';
				break;
			case 'tab':
				$delimiter = "\t";
				break;
			default:
				echo 'Unsupported format or format not specified.';
				return false;
		}

		foreach ($this->result as $rowNum=>$rowData) {
			$row = ''; //Clear out the row
			foreach ($rowData as $field) {
				if ($this->quotes) {
					$field = str_replace ("\"","\'",$field); //Remove nasty quotes
					$field = "\"" . $field . "\""; //Add good quotes
				}
				$row .= $field . $delimiter; //Add a delimiter on the end
			}
			$row = rtrim($row,$delimiter); //snip off trailing delimiter
			$row .= "\r\n"; //Add a final crlf
			$returnArray[] = $row; //Add the row onto the end of the array.
		}
		return $returnArray;
	} //End getFormattedResults

	/**
	 * getRawResults returns an array with the raw results of the query
	 *
	 * @return array Returned array contains raw associative array of results.
	 * @author Tim White <tim@cyface.com>
	 * @package ConMaster
	 **/
	function getRawResults() {
		return $this->result;
	} //End getRawResults

}

?>