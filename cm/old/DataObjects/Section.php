<?
/*
* Table Definition for section
*/



require_once('DB/DataObject.php');

class DataObjects_Section extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='section';                         // table name
    var $id;                              // int(11)  not_null primary_key auto_increment
    var $event_id;                        // int(11)  not_null
    var $event_number;                    // int(6)  not_null multiple_key
    var $section_number;                  // int(4)  not_null multiple_key
    var $complete_event_number;           // string(10)  not_null
    var $slot_date;                       // date(10)  not_null
    var $start_time;                      // time(8)  not_null
    var $end_time;                        // time(8)  not_null
    var $location;                        // string(255)  
    var $num_registered;                  // int(4)  
    var $max_registered;                  // int(4)  
    var $event_full;                      // string(7)  
    var $results_entered;                 // string(7)  
    var $event_ran;                       // string(7)  not_null
    var $notes;                           // string(80)  
    var $slots_left;                      // string(1)  
    var $numeric_section;                 // int(4)  
    var $advance_to_section;              // string(10)  
    var $round;                           // string(2)  
    var $convention_id;                   // int(11)  not_null unsigned
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Section',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>