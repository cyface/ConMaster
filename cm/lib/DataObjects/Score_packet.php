<?
/*
* Table Definition for score_packet
*/



require_once('DB/DataObject.php');

class DataObjects_Score_packet extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='score_packet';                    // table name
    var $id;                              // int(11)  not_null primary_key unsigned auto_increment
    var $person_id;                        // int(11)  not_null
	var $event_id;                        // int(11)  not_null
	var $section_id;                      // int(11)  not_null
    var $scenario_score;                  // int(4)
    var $prorated_scenario_score;         // int(4)
    var $group_score;                     // int(4)
    var $number_of_players;               // int(4)
    var $rpga_event_type;                 // string(15)
    var $status;                          // string(15)
    var $no_vote;                         // string(7) (boolean)
    var $convention_id;                   // int(11)  not_null unsigned
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp


    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Score_packet',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE

    function delete() {
    	//Go through each related person_section row and either delete or detach it.
    	$class = DB_DataObject::staticAutoloadTable('person_section');
    	$personSectionObject = new $class;
    	$personSectionObject->score_packet_id = $this->id;
    	$personSectionObject->find();

    	if ($personSectionObject) {
			while ($personSectionObject->fetch()) {
				$psCopy = $personSectionObject; //Need to make a copy in order to allow the master to continue to iterate

				if ($psCopy->reg_type == 'Score Packet') {
					$psCopy->delete();
				} else {
					$psCopy->score_packet_id = '';
					$psCopy->update();
				}
			}
		}

		return DB_DataObject::delete(); //Call the parent method
	}
}
?>