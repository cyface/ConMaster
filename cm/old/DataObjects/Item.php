<?
/*
* Table Definition for item
*/



require_once('DB/DataObject.php');

class DataObjects_Item extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='item';                            // table name
    var $id;                              // int(11)  not_null primary_key unsigned auto_increment
    var $name;                            // string(255)  not_null
    var $owner;                           // string(255)  not_null
    var $access;                          // string(255)  not_null
    var $type;                            // string(255)  not_null
    var $category;                        // string(255)  not_null
    var $subcategory;                     // string(255)  not_null
    var $description;                     // blob(65535)  not_null blob
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Item',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>