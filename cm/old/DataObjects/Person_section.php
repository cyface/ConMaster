<?
/*
* Table Definition for person_section
*/



require_once('DB/DataObject.php');

class DataObjects_Person_section extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='person_section';                  // table name
    var $id;                              // int(11)  not_null primary_key unsigned auto_increment
    var $person_id;                       // int(11)  not_null unsigned
    var $section_id;                      // int(11)  not_null unsigned
    var $complete_event_number;           // string(10)  not_null
    var $reg_type;                        // string(80)  not_null
    var $score;                           // int(4)  
    var $place;                           // int(4)  
    var $judge;                           // string(10)  
    var $price;                           // real(10)  
    var $score_packet_id;                 // int(11)  unsigned
    var $packet_position;                 // int(4)  
    var $judge_score;                     // int(4)  
    var $scenario_score;                  // int(4)  
    var $convention_id;                   // int(11)  not_null unsigned
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Person_section',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>