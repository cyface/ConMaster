<?php

include_once('./lib/DBObject.php');

/**
* ItemBean is the DB Interface Object
*
*
*/
class Item extends DBObject {
	var $data = array (
		'id' => false,
		'name' => 'NewItem',
		'owner' => 'Owner',
		'access' => 'Access',
		'type' => 'Type',
		'category' => 'Category',
		'subcategory' => 'SubCategory',
		'description' => 'Description'
	);
	var $table_name = 'item'; //table_name is inherited from DBObject

	/**
	* access_validate validates the access field
	*
	* @param $inVal value to validate
	*/
	function access_validate ($inVal) {
		return ($this->val_in_list('access',$inVal,array('GM','Player')));
	}

} //End class Item

?>