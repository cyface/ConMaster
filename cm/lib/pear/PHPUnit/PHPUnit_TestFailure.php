<?php
//
// +----------------------------------------------------------------------+
// | PHP Version 4                                                        |
// +----------------------------------------------------------------------+
// | Copyright (c) 1997-2002 The PHP Group                                |
// +----------------------------------------------------------------------+
// | This source file is subject to version 2.02 of the PHP license,      |
// | that is bundled with this package in the file LICENSE, and is        |
// | available at through the world-wide-web at                           |
// | http://www.php.net/license/2_02.txt.                                 |
// | If you did not receive a copy of the PHP license and are unable to   |
// | obtain it through the world-wide-web, please send a note to          |
// | license@php.net so we can mail you a copy immediately.               |
// +----------------------------------------------------------------------+
// | Author: Sebastian Bergmann <sb@sebastian-bergmann.de>                |
// +----------------------------------------------------------------------+
//
// $Id: PHPUnit_TestFailure.php,v 1.3 2002/07/10 22:57:08 cyface Exp $
//

/**
 * A TestFailure collects a failed test together with the caught exception.
 *
 * @package PHPUnit
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 *          Based upon JUnit, see http://www.junit.org/ for details.
 */
class PHPUnit_TestFailure {
    /**
    * @var    object
    * @access private
    */
    var $fFailedTest;

    /**
    * @var    string
    * @access private
    */
    var $fThrownException;

    /**
    * Constructs a TestFailure with the given test and exception.
    *
    * @param  object
    * @param  string
    * @access public
    */
    function PHPUnit_TestFailure(&$failedTest, &$thrownException) {
        $this->fFailedTest      = $failedTest;
        $this->fThrownException = $thrownException;
    }

    /**
    * Gets the failed test.
    *
    * @return object
    * @access public
    */
    function &failedTest() {
        return $this->fFailedTest;
    }

    /**
    * Gets the thrown exception.
    *
    * @return object
    * @access public
    */
    function &thrownException() {
        return $this->fThrownException;
    }

    /**
    * Returns a short description of the failure.
    *
    * @return string
    * @access public
    */
    function toString() {
        return sprintf("TestCase %s->%s() failed: %s\n",

                       get_class($this->fFailedTest),
                       $this->fFailedTest->getName(),
                       $this->fThrownException
                      );
    }
}
?>
