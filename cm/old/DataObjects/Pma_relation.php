<?
/*
* Table Definition for pma_relation
*/



require_once('DB/DataObject.php');

class DataObjects_Pma_relation extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='pma_relation';                    // table name
    var $master_db;                       // string(64)  not_null primary_key
    var $master_table;                    // string(64)  not_null primary_key
    var $master_field;                    // string(64)  not_null primary_key
    var $foreign_db;                      // string(64)  not_null multiple_key
    var $foreign_table;                   // string(64)  not_null
    var $foreign_field;                   // string(64)  not_null


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pma_relation',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>