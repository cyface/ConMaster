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
// $Id: PHPUnit_TestSuite.php,v 1.2 2002/07/10 13:34:26 cyface Exp $
//

require_once 'PHPUnit/PHPUnit_TestCase.php';

/**
 * A TestSuite is a Composite of Tests. It runs a collection of test cases.
 *
 * Here is an example using the dynamic test definition. 
 *
 *   $suite = new PHPUnit_TestSuite();
 *   $suite->addTest(new MathTest('testPass'));
 *
 * Alternatively, a TestSuite can extract the tests to be run automatically.
 * To do so you pass the classname of your TestCase class to the TestSuite
 * constructor. 
 *
 *   $suite = new TestSuite('classname');
 *
 * This constructor creates a suite with all the methods starting with
 * "test" that take no arguments.
 *
 * @package PHPUnit
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 *          Based upon JUnit, see http://www.junit.org/ for details.
 */
class PHPUnit_TestSuite {
    /**
    * The name of the test suite.
    *
    * @var    string
    * @access private
    */
    var $fName = '';

    /**
    * The tests in the test suite.
    *
    * @var    array
    * @access private
    */
    var $fTests = array();

    /**
    * Constructs a TestSuite.
    *
    * @param  mixed
    * @access public
    */
    function PHPUnit_TestSuite($test = false) {
        if ($test != false) {
            $this->setName($test);
            $this->addTestSuite($test);
        }
    }

    /**
    * Adds a test to the suite.
    *
    * @param  object
    * @access public
    */
    function addTest(&$test) {
        $this->fTests[] = $test;
    }

    /**
    * 
    *
    * @param  string
    * @param  array
    * @param  string
    * @access private
    */
    function addTestMethod($m, $names, $constructor) {
        // not implemented
    }

    /**
    * Adds the tests from the given class to the suite.
    *
    * @param  string
    * @access public
    */
    function addTestSuite($testClass) {
        if (class_exists($testClass)) {
            $methods = get_class_methods($testClass);

            foreach ($methods as $method) {
                if (substr($method, 0, 4) == 'test') {
                    $this->addTest(new $testClass($method));
                }
            }
        }
    }

    /**
    * Counts the number of test cases that will be run by this test.
    *
    * @return integer
    * @access public
    */
    function countTestCases() {
        $count = 0;

        foreach ($this->fTests as $test) {
            $count += $test->countTestCases();
        }

        return $count;
    }

    /**
    * Converts the stack trace into a string.
    *
    * @param  object
    * @return string
    * @access private
    */
    function exceptionToString($t) {
        // not implemented
    }

    /**
    * Gets a constructor which takes a single String as its argument.
    *
    * @param  string
    * @return string
    * @access private
    */
    function getConstructor($theClass) {
        // not implemented
    }

    /**
    * Returns the name of the suite.
    *
    * @return string
    * @access public
    */
    function getName() {
        return $this->fName;
    }

    /**
    * Runs the tests and collects their result in a TestResult.
    *
    * @param  object
    * @access public
    */
    function run(&$result) {
        for ($i = 0; $i < sizeof($this->fTests) && !$result->shouldStop(); $i++) {
            $this->fTests[$i]->run($result);
        }
    }

    /**
    * 
    *
    * @param  object
    * @param  object
    * @access public
    */
    function runTest(&$test, &$result) {
    }

    /**
    * Sets the name of the suite.
    *
    * @param  string
    * @access public
    */
    function setName($name) {
        $this->fName = $name;
    }

    /**
    * Returns the test at the given index.
    *
    * @param  integer
    * @return object
    * @access public
    */
    function &testAt($index) {
        if (isset($this->fTests[$index])) {
            return $this->fTests[$index];
        } else {
            return false;
        }
    }

    /**
    * Returns the number of tests in this suite.
    *
    * @return integer
    * @access public
    */
    function testCount() {
        return sizeof($this->fTests);
    }

    /**
    * Returns the tests as an enumeration.
    *
    * @return array
    * @access public
    */
    function &tests() {
        return $this->fTests;
    }

    /**
    * Returns a string representation of the test suite.
    *
    * @return string
    * @access public
    */
    function toString() {
        return '';
    }
}
?>
