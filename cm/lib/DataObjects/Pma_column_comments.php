<?
/*
* Table Definition for pma_column_comments
*/



require_once('DB/DataObject.php');

class DataObjects_Pma_column_comments extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='pma_column_comments';             // table name
    var $id;                              // int(5)  not_null primary_key unsigned auto_increment
    var $db_name;                         // string(64)  not_null multiple_key
    var $table_name;                      // string(64)  not_null
    var $column_name;                     // string(64)  not_null
    var $comment;                         // string(255)  not_null


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pma_column_comments',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>