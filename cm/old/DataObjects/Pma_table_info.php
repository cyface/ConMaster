<?
/*
* Table Definition for pma_table_info
*/



require_once('DB/DataObject.php');

class DataObjects_Pma_table_info extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='pma_table_info';                  // table name
    var $db_name;                         // string(64)  not_null primary_key
    var $table_name;                      // string(64)  not_null primary_key
    var $display_field;                   // string(64)  not_null


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pma_table_info',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>