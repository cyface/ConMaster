<?
/*
* Table Definition for slot
*/



require_once('DB/DataObject.php');

class DataObjects_Slot extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='slot';                  // table name
    var $id;                              // int(11)  not_null primary_key unsigned auto_increment
    var $name;                            // string(50)  
    var $sponsor_organization;            // string(50)   
    var $rpga_convention_code;            // string(20)   
    var $web_site_url;                    // string(200)  
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Slot',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>