<?
/*
* Table Definition for pma_bookmark
*/



require_once('DB/DataObject.php');

class DataObjects_Pma_bookmark extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='pma_bookmark';                    // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $dbase;                           // string(255)  not_null
    var $user;                            // string(255)  not_null
    var $label;                           // string(255)  not_null
    var $query;                           // blob(65535)  not_null blob


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pma_bookmark',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>