<?php

include_once('./lib/DBObject.php');

/**
* PersonObject is the DB Interface Object
*
*
*/
class Person extends DBObject {
	var $data = array (
		'id' => false,
		'first_name' => false,
		'last_name' => false,
		'middle_name' => false,
		'badge_number' => false,
		'street' => false,
		'city' => false,
		'state' => false,
		'zip' => false,
		'phone' => false,
		'reg_type' => false,
		'judge' => false,
		'staff' => false,
		'volunteer' => false,
		'rpga_number' => false,
		'total_fee' => false,
		'email_address' => false,
		'con_code' => false
	);
	var $table_name = 'person'; //table_name is inherited from DBObject

} //End class Person

?>