<?
/*
* Table Definition for constant
*/



require_once('DB/DataObject.php');

class DataObjects_Constant extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='constant';                            // table name
    var $id;                                 			// int(10)  not_null primary_key unsigned auto_increment
    var $constant;                        				// string(255)  not_null
    var $name;                           				// string(255)
    var $value;                            			    // string(255)
    var $option;                            			// string(255)
    var $convention_id;                                 // int(10)  not_null
    var $last_modified;                       			// timestamp(14)  not_null unsigned zerofill timestamp


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Constant',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>
