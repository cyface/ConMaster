<?
/*
* Table Definition for pma_pdf_pages
*/



require_once('DB/DataObject.php');

class DataObjects_Pma_pdf_pages extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='pma_pdf_pages';                   // table name
    var $db_name;                         // string(64)  not_null multiple_key
    var $page_nr;                         // int(10)  not_null primary_key unsigned auto_increment
    var $page_descr;                      // string(50)  not_null


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Pma_pdf_pages',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>