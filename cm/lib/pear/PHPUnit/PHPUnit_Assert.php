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
// $Id: PHPUnit_Assert.php,v 1.2 2002/07/10 13:34:26 cyface Exp $
//

/**
 * A set of assert methods.
 *
 * @package PHPUnit
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 *          Based upon JUnit, see http://www.junit.org/ for details.
 */
class PHPUnit_Assert {
    /**
    * Asserts that two variables are equal.
    *
    * @param  mixed
    * @param  mixed
    * @param  string
    * @param  mixed
    * @access public
    */
    function assertEquals($expected, $actual, $message = '', $delta = 0) {
        if (empty($message)) {
            $_delta = ($delta != 0) ? ('+/- ' . $delta) : '';

            $message = sprintf('expected %s%s, actual %s',

                               $expected,
                               $_delta,
                               $actual
                              );
        }

        if (is_numeric($expected) && is_numeric($actual)) {
            if (!($actual >= ($expected - $delta) && $actual <= ($expected + $delta))) {
                return $this->fail($message);
            }
        } else {
            if ($expected != $actual) {
                return $this->fail($message);
            }
        }

        return $this->pass();
    }

    /**
    * Asserts that an object isn't null.
    *
    * @param  object
    * @param  string
    * @access public
    */
    function assertNotNull($object, $message = '') {
        if (empty($message)) {
            $message = 'expected NOT NULL, actual NULL';
        }

        if ($object == NULL) {
            return $this->fail($message);
        }

        return $this->pass();
    }

    /**
    * Asserts that an object is null.
    *
    * @param  object
    * @param  string
    * @access public
    */
    function assertNull($object, $message = '') {
        if (empty($message)) {
            $message = 'expected NULL, actual NOT NULL';
        }

        if ($object != NULL) {
            return $this->fail($message);
        }

        return $this->pass();
    }

    /**
    * Asserts that two objects refer to the same object.
    *
    * @param  object
    * @param  object
    * @param  string
    * @access public
    */
    function assertSame($expected, $actual, $message = '') {
        // not implemented
    }

    /**
    * Asserts that a condition is true.
    *
    * @param  boolean
    * @param  string
    * @access public
    */
    function assertTrue($condition, $message = '') {
        if (empty($message)) {
            $message = 'expected true, actual false';
        }

        if (!$condition) {
            return $this->fail($message);
        }

        return $this->pass();
    }

    /**
    * Fails a test with the given message.
    *
    * @param  string
    * @access protected
    */
    function fail($message = '') {
    }

    /**
    * Passes a test.
    *
    * @access protected
    */
    function pass() {
    }
}
?>
