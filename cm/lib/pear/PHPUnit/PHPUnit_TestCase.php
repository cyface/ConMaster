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
// $Id: PHPUnit_TestCase.php,v 1.2 2002/07/10 13:34:26 cyface Exp $
//

require_once 'PHPUnit/PHPUnit_Assert.php';
require_once 'PHPUnit/PHPUnit_TestResult.php';

/**
 * A TestCase defines the fixture to run multiple tests.
 *
 * To define a TestCase
 *
 *   1) Implement a subclass of PHPUnit_TestCase.
 *   2) Define instance variables that store the state of the fixture.
 *   3) Initialize the fixture state by overriding setUp().
 *   4) Clean-up after a test by overriding tearDown().
 *
 * Each test runs in its own fixture so there can be no side effects
 * among test runs.
 *
 * Here is an example: 
 *
 *   class MathTest extends PHPUnit_TestCase {
 *     var $fValue1;
 *     var $fValue2;
 *
 *     function MathTest($name) {
 *       $this->PHPUnit_TestCase($name);
 *     }
 *    
 *     function setUp() {
 *       $this->fValue1 = 2;
 *       $this->fValue2 = 3;
 *     }
 *   }
 *
 * For each test implement a method which interacts with the fixture.
 * Verify the expected results with assertions specified by calling
 * assert with a boolean. 
 *
 *   function testPass() {
 *     $this->assertTrue($this->fValue1 + $this->fValue2 == 5);
 *   }
 *
 * @package PHPUnit
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 *          Based upon JUnit, see http://www.junit.org/ for details.
 */
class PHPUnit_TestCase extends PHPUnit_Assert {
    /**
    * The name of the test case.
    *
    * @var    string
    * @access private
    */
    var $fName = '';

    /**
    * PHPUnit_TestResult object
    *
    * @var    object
    * @access private
    */
    var $fResult;

    /**
    * Constructs a test case with the given name.
    *
    * @param  string  
    * @access public
    */
    function PHPUnit_TestCase($name = false) {
        if ($name != false) {
            $this->setName($name);
        }
    }

    /**
    * Counts the number of test cases executed by run(TestResult result).
    *
    * @return integer
    * @access public
    */
    function countTestCases() {
        return 1;
    }

    /**
    * Gets the name of a TestCase.
    *
    * @return string
    * @access public
    */
    function getName() {
        return $this->fName;
    }

    /**
    * Runs the test case and collects the results in a given TestResult object.
    *
    * @param  object
    * @return object
    * @access public
    */
    function run(&$result) {
        $this->fResult = &$result;
        $this->fResult->run(&$this);

        return $this->fResult;
    }

    /**
    * Runs the bare test sequence.
    *
    * @access public
    */
    function runBare() {
        $this->setUp();
        $this->runTest();
        $this->tearDown();
    }

    /**
    * Override to run the test and assert its state.
    *
    * @access protected
    */
    function runTest() {
        $name = $this->fName;
        $this->$name();
    }

    /**
    * Sets the name of a TestCase.
    *
    * @param  string
    * @access public
    */
    function setName($name) {
        $this->fName = $name;
    }

    /**
    * Returns a string representation of the test case.
    *
    * @return string
    * @access public
    */
    function toString() {
        return '';
    }

    /**
    * Creates a default TestResult object.
    *
    * @return object
    * @access protected
    */
    function createResult() {
        // not implemented
    }

    /**
    * Fails a test with the given message.
    *
    * @param  string
    * @access protected
    */
    function fail($message = '') {
        $this->fResult->addFailure($this, $message);
    }

    /**
    * Passes a test.
    *
    * @access protected
    */
    function pass() {
        $this->fResult->addPassedTest($this);
    }


    /**
    * Sets up the fixture, for example, open a network connection.
    * This method is called before a test is executed.
    *
    * @access protected
    */
    function setUp() {
    }

    /**
    * Tears down the fixture, for example, close a network connection.
    * This method is called after a test is executed.
    *
    * @access protected
    */
    function tearDown() {
    }
}
?>
