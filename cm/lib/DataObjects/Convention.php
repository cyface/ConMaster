<?
/*
* Table Definition for convention
*/



require_once('DB/DataObject.php');

class DataObjects_Convention extends DB_DataObject {

    ###START_AUTOCODE
    /* the code below is auto generated do not remove the above tag */

    var $__table='convention';                      // table name
    var $id;                              // int(11)  not_null primary_key unsigned auto_increment
    var $name;                            // string(50)  not_null
    var $sponsor_organization;            // string(50)  not_null
    var $rpga_convention_code;            // string(20)  not_null
    var $web_site_url;                    // string(200)  not_null
	var $logo_file;                       // string(200)  not_null
    var $last_modified;                   // timestamp(14)  not_null unsigned zerofill timestamp

	/* ZE2 compatibility trick */
    function __clone() { return $this;}
    
    /* Static get */
    function staticGet($k,$v=NULL) { return DB_DataObject::staticGet('DataObjects_Convention',$k,$v); }


    /* the code above is auto generated do not remove the tag below */
    ###END_AUTOCODE
}
?>