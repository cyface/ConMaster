<?
/*
* Table Definition for person
*/



require_once('DB/DataObject.php');

class DataObjects_Person extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='person';                          // table name
    var $id;                              // int(9)  not_null primary_key unsigned auto_increment
    var $first_name;                      // string(80)  
    var $last_name;                       // string(80)  multiple_key
    var $middle_name;                     // string(80)  
    var $badge_number;                    // int(6)  
    var $street;                          // string(80)  
    var $city;                            // string(80)  
    var $state;                           // string(80)  
    var $zip;                             // string(15)  
    var $phone;                           // string(15)  
    var $reg_type;                        // string(80)  
    var $judge;                           // string(10)  
    var $staff;                           // string(10)  
    var $volunteer;                       // string(10)  
    var $rpga_number;                     // int(9)  
    var $total_fee;                       // real(10)  
    var $email_address;                   // string(80)  
    var $country;                         // string(30)  
    var $convention_id;                   // int(10)  not_null
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Person',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>