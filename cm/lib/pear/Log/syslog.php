<?php
// $Id: syslog.php,v 1.1 2002/07/05 17:18:27 cyface Exp $
// $Horde: horde/lib/Log/syslog.php,v 1.6 2000/06/28 21:36:13 jon Exp $

/**
 * The Log_syslog class is a concrete implementation of the Log::
 * abstract class which sends messages to syslog on UNIX-like machines
 * (PHP emulates this with the Event Log on Windows machines).
 * 
 * @author  Chuck Hagenbuch <chuck@horde.org>
 * @version $Revision: 1.1 $
 * @since   Horde 1.3
 * @package Log 
 */
class Log_syslog extends Log {

    /** 
    * Integer holding the log facility to use. 
    * @var string
    */
    var $name = LOG_SYSLOG;

    
    /**
     * Constructs a new syslog object.
     * 
     * @param string $log_name The syslog facility.
     * @param string $ident    The identity string.
     * @param array  $conf     The configuration array.
     * @access public
     */
    function Log_syslog($log_name = LOG_SYSLOG, $ident = '', $conf = array())
    {    
        // bc compatibilty
        if( 0 == count( $conf )) {
            $conf = false ;
        }    
        $this->name = $log_name;
        $this->ident = $ident;
    }

    /**
     * Opens a connection to the system logger, if it has not already
     * been opened.  This is implicitly called by log(), if necessary.
     * @access public
     */
    function open()
    {
        if (!$this->opened) {
            openlog($this->ident, LOG_PID, $this->name);
            $this->opened = true;
        }
    }

    /**
     * Closes the connection to the system logger, if it is open.
     * @access public     
     */
    function close()
    {
        if ($this->opened) {
            closelog();
            $this->opened = false;
        }
    }

    /**
     * Sends $message to the currently open syslog * connection.  Calls
     * open() if necessary. Also passes the message along to any Log_observer
     * instances that are observing this Log.
     * 
     * @param string $message  The textual message to be logged.
     * @param string $priority (optional) The priority of the message.  Valid
     *                  values are: LOG_EMERG, LOG_ALERT, LOG_CRIT,
     *                  LOG_ERR, LOG_WARNING, LOG_NOTICE, LOG_INFO,
     *                  and LOG_DEBUG.  The default is LOG_INFO.
     * @access public     
     */
    function log($message, $priority = LOG_INFO)
    {
        if (!$this->opened) {
            $this->open();
        }

        syslog($priority, $message);
        $this->notifyAll(array('priority' => $priority, 'message' => $message));
    }
}

?>
