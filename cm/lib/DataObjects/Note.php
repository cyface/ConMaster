<?
/*
* Table Definition for note
*/



require_once('DB/DataObject.php');

class DataObjects_Note extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='note';                            // table name
    var $id;                                  // int(10)  not_null primary_key unsigned auto_increment
    var $parent_table;                        // string(80)  not_null
    var $parent_id;                           // int(10)  not_null
    var $subject;                              // string(255)  not_null
    var $body;                                 // blob(65535)  not_null blob
    var $sender;                               // string(80)  not_null
    var $last_modified;                       // timestamp(14)  not_null unsigned zerofill timestamp

	/* ZE2 compatibility trick */
    function __clone() { return $this;}

    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Note',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>