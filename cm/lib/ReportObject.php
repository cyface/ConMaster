<?php

require_once('PEAR.php'); //Main PEAR stuff
require_once('DB.php'); //Database Access Interface
require_once('./lib/class.TemplatePower.inc.php'); //Main TemplatePower Stuff
require_once('./lib/TemplateHelpers.inc.php'); //Custom class that adds convienience methods for dealing with Templates
require_once('./lib/ErrorCheck.php'); //Error Checking Code

/**
 * ReportObject is an object that allows predefined queries to be run and displayed or export
 *
 * @author Tim White <tim@cyface.com>
 * @package ConMaster
 **/
class ReportObject {
	var $parms = false; //The report input parameters							@access private
	var $query = false; //The query string										@access private
	var $db = false; //The database connection handle							@access private
	var $result = false; //Rownumbered associative array of results				@access private
	var $columnNames = false; //array of the names of the result columns    	@access private

	/**
	 * ReportObject constructor
	 *
	 * @param array inGet - the $_GET array from a request, or an assoc array with the right stuff
	 * @param array inPost - the $_POST array from a request, or an assoc array with the right stuff
	 * @author Tim White <tim@cyface.com>
	 * @package ConMaster
 	 **/
	function ReportObject ($inGet, $inPost) {

		//Set up $this->parms
		if ($inPost) { //Set the data of this object to the Post vars if they came through
			$this->parms = $inPost;
		} else {
			$this->parms = $inGet; //Otherwise, use the get vars
        }

		//Set up $this->queryFile & $this->query
		if (isset($this->parms['queryFile'])) {
			$queryFile = './sql/reports/' . $this->parms['queryFile'];
		} else {
			echo "No Query File.";
			return false;
		}
		$this->query = implode('',file($queryFile,1));

		//echo "Query: $this->query \n";

		// get DataObject's config - so we can use the config directly.
		$options = &PEAR::getStaticProperty('DB_DataObject', 'options');
		$config = parse_ini_file('config/conmaster.ini', true);
		$options = $config['DB_DataObject'];

		$db = DB::connect($options['database']);

		errorCheck($db); //If $db is an error, display the message and exit

		$this->result = $db->getAll($this->query,null,DB_FETCHMODE_ASSOC);

		errorCheck($this->result); //If $this-result is an error, display the message and exit

		//echo '<pre>'; print_r($this->result); echo '</pre>';

		$this->columnNames = array_keys($this->result[0]);
	}

	/**
	 * getDelimitedResults returns a array with the results of the query delimited by a character described by $this->format
	 *
	 * @return array Returned array contains formatted results, with commas and tabs, etc.
	 * @author Tim White <tim@cyface.com>
	 * @package ConMaster
 	 **/
	function getDelimitedResults() {

		//Set up $format & $delimiter
		$format = $this->parms['format'];
		switch ($format) {
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

		//Set up $quotes
		if (isset($this->parms['quotes'])) {
			if ($this->parms['quotes'] == 'off') {
				$quotes = false;
			} else {
				$quotes = true;
			}
		} else {
			$this->quotes = true;
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
	} //End getDelimitedResults

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

	/**
	 * showReport merges the results of the query with the template defined by $templateFile
	 * @access private
	 * @return boolean True if success False if Failure
	 **/
	function showReport()
	{
		if (isset($this->parms['templateFile'])) {
			$templateFile = './templates/' . $this->parms['templateFile'];
		} else {
			echo "No Template File";
			return false;
		}

		$template = new TemplatePower($templateFile); //make a new TemplatePower object
		$template->prepare(); //let TemplatePower do its thing, parsing etc.

		if (isset($this->parms['totals'])) {
			$totals = $this->parms['totals'];
		} else {
			$totals = 'on';
		}

		$lastCol0 = -1;
		$subtotalCol0 = 0;
		$totalCol0 = 0;

		foreach ($this->result as $rowNum=>$rowData) {
			foreach ($this->columnNames as $colNum => $colName) {
				$varName = 'col' . $colNum;
				$$varName = $rowData[$colName]; //Tricky.  See the 'variable variables' section of the PHP manual
				$template->assign('col' . $colNum . 'Header', $colName); //Fill in Column Headers
			}

			//echo '<pre>Col1:'; echo print_r($col1); echo '</pre>';
			//echo '<pre>Col0:'; echo print_r($col0); echo '</pre>';
			switch ($lastCol0) {
				case -1:
					$lastCol0 = $col0;
					$template->newBlock('result_row');
					$template->assign('col0', $col0);
					break;
				case ($col0):
					$template->newBlock('result_row');
					$template->assign('col0', '');
					break;
				default: // when col0 changes
					if ($totals == 'on') {
						$template->newBlock("total_row");
						$template->assign('col0', $lastCol0 . ' Subtotal');
						$template->assign('col2', $subtotalCol0);
						$subtotalCol0 = 0;
					}

					$template->newBlock('result_row');
					$template->assign('col0', $col0);
					break;
			}  //end switch
			$lastCol0 = $col0;
			if ($totals == 'on') {
				$subtotalCol0 += $col2;
				$totalCol0 += $col2;
			}
			$template->assign('col1', $col1);
			$template->assign('col2', $col2);
		}
		if ($totals == 'on') {
			$template->newBlock("total_row"); //Final subtotal
			$template->assign('col0', $lastCol0 . ' Subtotal');
			$template->assign('col2', $subtotalCol0);
			$template->newBlock("total_row"); //Final total
			$template->assign('col0', 'Grand Total');
			$template->assign('col2', $totalCol0);
		}

		$template->printToScreen();
		return true;
	}  //End function showReport
}

?>