<?php
// $Id: sql.php,v 1.2 2002/07/10 13:34:26 cyface Exp $
// $Horde: horde/lib/Log/sql.php,v 1.12 2000/08/16 20:27:34 chuck Exp $

require_once 'DB.php';

/**
 * The Log_sql class is a concrete implementation of the Log::
 * abstract class which sends messages to an SQL server.  Each entry
 * occupies a separate row in the database.
 *
 * This implementation uses PHP's PEAR database abstraction layer.
 *
 * CREATE TABLE log_table (
 *  unixtime    int NOT NULL,
 *  ident       char(16) NOT NULL,
 *  priority    int,
 *  message     varchar(200),
 *  primary key (unixtime, ident)
 * );
 *
 * @author  Jon Parise <jon@horde.org>
 * @version $Revision: 1.2 $
 * @since   Horde 1.3
 * @package Log 
 */
class Log_sql extends Log {

    /** 
    * Array containing the dsn information. 
    * @var string
    */
    var $dsn = '';

    /** 
    * Object holding the database handle. 
    * @var string
    */
    var $db = '';

    /** 
    * String holding the database table to use. 
    * @var string
    */
    var $table = 'log_table';

    /** 
    * Boolean indicating the current connection state. 
    * @var boolean
    */
    var $opened = false;


    /**
     * Constructs a new sql logging object.
     *
     * @param string $log_name     The target SQL table.
     * @param string $ident        The identification field.
     * @param array $conf          The connection configuration array.
     * @access public     
     */
    function Log_sql($log_name, $ident = '', $conf)
    {
        $this->table = $log_name;
        $this->ident = $ident;
        $this->dsn = $conf['dsn'];
    }

    /**
     * Opens a connection to the database, if it has not already
     * been opened. This is implicitly called by log(), if necessary.
     *
     * @return boolean   True on success, false on failure.
     * @access public     
     */
    function open()
    {
        if (!$this->opened) {
            $this->db = &DB::connect($this->dsn, true);
            if (DB::isError($this->db) || DB::isWarning($this->db)) {
                return false;
            }
            $this->opened = true;
        }

        return true;
    }

    /**
     * Closes the connection to the database, if it is open.
     *
     * @return boolean   True on success, false on failure.
     * @access public     
     */
    function close()
    {
        if ($this->opened) {
            $this->opened = false;
            return $this->db->disconnect();
        }

        return true;
    }

    /**
     * Inserts $message to the currently open database.  Calls open(),
     * if necessary.  Also passes the message along to any Log_observer
     * instances that are observing this Log.
     *
     * @param string $message  The textual message to be logged.
     * @param string $priority The priority of the message.  Valid
     *                  values are: LOG_EMERG, LOG_ALERT, LOG_CRIT,
     *                  LOG_ERR, * LOG_WARNING, LOG_NOTICE, LOG_INFO,
     *                  and LOG_DEBUG. The default is LOG_INFO.
     * @access public     
     */
    function log($message, $priority = LOG_INFO)
    {
        if (!$this->opened) {
            $this->open();
        }

        $timestamp = time();
        $q = "insert into $this->table
              values($timestamp, '$this->ident', $priority, '$message')";
        $this->db->query($q);
        $this->notifyAll(array('priority' => $priority, 'message' => $message));
    }
}

?>
