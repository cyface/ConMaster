<?
/*
* Table Definition for person
*/

require_once('DB/DataObject.php');

class DataObjects_Person extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='person';                          // table name
    var $id;                              // int(9)  not_null primary_key unsigned auto_increment
    var $first_name;                      // string(80)
    var $last_name;                       // string(80)  multiple_key
    var $middle_name;                     // string(80)
    var $badge_number;                    // int(6)
    var $street;                          // string(80)
    var $city;                            // string(80)
    var $state;                           // string(80)
    var $zip;                             // string(15)
    var $phone;                           // string(15)
    var $reg_type;                        // string(80)
    var $judge;                           // string(10)
    var $staff;                           // string(10)
    var $volunteer;                       // string(10)
    var $rpga_number;                     // int(9)
    var $total_fee;                       // real(10)
    var $additional_fees;                 // real(10)
    var $amount_paid;                     // real(10)
    var $payment_type;                    // string(15)
    var $email_address;                   // string(80)
    var $country;                         // string(30)
    var $convention_id;                   // int(10)  not_null
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp

	/* ZE2 compatibility trick */
    function __clone() { return $this;}
    
    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Person',$k,$v); }

    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

	function insert() {
		//Grab the database connection that has already been made by the parent's constructor:
		require_once('DB.php');
		$connections = &PEAR::getStaticProperty('DB_DataObject','connections');
		$__DB = &$connections[$this->_database_dsn_md5];
		if ($this->reg_type != null) {
			$this->badge_number = $__DB->nextId('badge_number'); //Fetch the next id in the sequence.  To set the sequence to a specifc value, use phpMyAdmin to tweak the value in the badge_number_seq table
		}
		return DB_DataObject::insert();
	}

	function delete() {
		//Delete the person_section records attached to this person
		$personSectionObject = DB_DataObject::factory('section');
		$personSectionObject->person_id = $this->person_id;
		$personSectionObject->find();
		//echo '<PRE> Found Person Section Objects'; print_r($personSectionObject); echo '<PRE>';

		while ($personSectionObject->fetch()) {
			$deleteObject = new $personSectionClass;
			$deleteObject->id = $personSectionObject->id;
			$deleteObject->section_id = $personSectionObject->section_id;
			$deleteObject->person_id = $this->id;
			$deleteObject->delete();
		}

		return DB_DataObject::delete(); //Call the parent method
	}

	function update() {
		global $_DB_DATAOBJECT; //Indicate to PHP that we want to use the already-defined global, as opposed to declaring a local var
		$__DB  = &$_DB_DATAOBJECT['CONNECTIONS'][$this->_database_dsn_md5];
		if ($this->reg_type != null && $this->reg_type != " ") {
			if ($this->badge_number == null || $this->badge_number <= 0) {
				$this->badge_number = $__DB->nextId('badge_number'); //Fetch the next id in the sequence.  To set the sequence to a specifc value, use phpMyAdmin to tweak the value in the badge_number_seq table
			}
		}
		else {
			$this->badge_number = 0;
		}
	
		return DB_DataObject::update(); //Call the parent method
	}

}
?>
