<?
/*
* Table Definition for pma_table_coords
*/



require_once('DB/DataObject.php');

class DataObjects_Pma_table_coords extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='pma_table_coords';                // table name
    var $db_name;                         // string(64)  not_null primary_key
    var $table_name;                      // string(64)  not_null primary_key
    var $pdf_page_number;                 // int(11)  not_null primary_key
    var $x;                               // real(10)  not_null unsigned
    var $y;                               // real(10)  not_null unsigned


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pma_table_coords',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>