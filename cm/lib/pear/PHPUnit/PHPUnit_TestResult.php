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
// $Id: PHPUnit_TestResult.php,v 1.4 2002/07/18 21:39:39 cyface Exp $
//

require_once 'PHPUnit/PHPUnit_TestFailure.php';

/**
 * A TestResult collects the results of executing a test case.
 *
 * @package PHPUnit
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 *          Based upon JUnit, see http://www.junit.org/ for details.
 */
class PHPUnit_TestResult {
    /**
    * @var    array
    * @access protected
    */
    var $fErrors = array();

    /**
    * @var    array
    * @access protected
    */
    var $fFailures = array();

    /**
    * @var    array
    * @access protected
    */
    var $fListeners = array();

    /**
    * @var    array
    * @access protected
    */
    var $fPassedTests = array();

    /**
    * @var    integer
    * @access protected
    */
    var $fRunTests = 0;

    /**
    * @var    boolean
    * @access private
    */
    var $fStop = false;

    /**
    * Adds an error to the list of errors.
    * The passed in exception caused the error.
    *
    * @param  object
    * @param  object
    * @access public
    */
    function addError(&$test, &$t) {
        // not implemented
    }

    /**
    * Adds a failure to the list of failures.
    * The passed in exception caused the failure.
    *
    * @param  object
    * @param  object
    * @access public
    */
    function addFailure(&$test, &$t) {
        $this->fFailures[] = new PHPUnit_TestFailure($test, $t);
    }

    /**
    * Registers a TestListener.
    *
    * @param  object
    * @access public
    */
    function addListener(&$listener) {
        // not implemented
    }

    /**
    * Adds a passed test to the list of passed tests.
    *
    * @param  object
    * @access public
    */
    function addPassedTest(&$test) {
        $this->fPassedTests[] = $test;
    }

    /**
    * Informs the result that a test was completed.
    *
    * @param  object
    * @access public
    */
    function endTest(&$test) {
    }

    /**
    * Gets the number of detected errors.
    *
    * @return integer
    * @access public
    */
    function errorCount() {
        return sizeof($this->fErrors);
    }

    /**
    * Returns an Enumeration for the errors.
    *
    * @return array
    * @access public
    */
    function &errors() {
        return $this->fErrors;
    }

    /**
    * Gets the number of detected failures.
    *
    * @return integer
    * @access public
    */
    function failureCount() {
        return sizeof($this->fFailures);
    }

    /**
    * Returns an Enumeration for the failures.
    *
    * @return array
    * @access public
    */
    function &failures() {
        return $this->fFailures;
    }

    /**
    * Unregisters a TestListener.
    *
    * @param  object
    * @access public
    */
    function removeListener(&$listener) {
        // not implemented
    }

    /**
    * Runs a TestCase.
    *
    * @param  object
    * @access public
    */
    function run(&$test) {
        $this->startTest($test);
        $this->fRunTests++;

        $test->runBare();

        $this->endTest($test);
    }

    /**
    * Gets the number of run tests.
    *
    * @return integer
    * @access public
    */
    function runCount() {
        return $this->fRunTests;
    }

    /**
    * Runs a TestCase.
    *
    * @param  object
    * @param  object
    * @access public
    */
    function runProtected($test, $p) {
        // not implemented
    }

    /**
    * Checks whether the test run should stop.
    *
    * @access public
    */
    function shouldStop() {
        return $this->fStop;
    }

    /**
    * Informs the result that a test will be started.
    *
    * @param  object
    * @access public
    */
    function startTest(&$test) {
    }

    /**
    * Marks that the test run should stop.
    *
    * @access public
    */
    function stop() {
        $this->fStop = true;
    }

    /**
    * Returns a HTML representation of the test result.
    *
    * @return string
    * @access public
    */
    function toHTML() {
        return '<pre>' . htmlspecialchars($this->toString()) . '</pre>';
    }

    /**
    * Returns a text representation of the test result.
    *
    * @return string
    * @access public
    */
    function toString() {
        $result = '';

        foreach ($this->fPassedTests as $passedTest) {
            $result .= sprintf("TestCase %s->%s() passed\n",

                               get_class($passedTest),
                               $passedTest->getName()
                              );
        }

        foreach ($this->fFailures as $failedTest) {
            $result .= $failedTest->toString();
        }

        return $result;
    }
    /**
    * Returns whether the entire test was successful or not.
    *
    * @return boolean
    * @access public
    */
    function wasSuccessful() {
        if (empty($this->fErrors) && empty($this->fFailures)) {
            return true;
        } else {
            return false;
        }
    }
}
?>
