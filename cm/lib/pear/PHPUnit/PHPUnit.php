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
// $Id: PHPUnit.php,v 1.1 2002/07/05 17:18:28 cyface Exp $
//

require_once 'PHPUnit/PHPUnit_TestSuite.php';

/**
 * PHPUnit runs a TestSuite and returns a TestResult object.
 *
 * Here is an example:
 *
 *   require_once 'PHPUnit/PHPUnit.php';
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
 *
 *     function testAdd() {
 *       $this->assertTrue($this->fValue1 + $this->fValue2 == 5);
 *     }
 *   }
 *
 *   $suite = new PHPUnit_TestSuite();
 *   $suite->addTest(new MathTest('testAdd'));
 *
 *   $result = PHPUnit::run($suite);
 *   echo $result->toHTML();
 *
 * Alternatively, you can pass a class name to the
 * PHPUnit_TestSuite() constructor and let it automatically add all
 * methods of that class that start with 'test' to the suite:
 *
 *   $suite  = new PHPUnit_TestSuite('MathTest');
 *   $result = PHPUnit::run($suite);
 *   echo $result->toHTML();
 *
 * @package PHPUnit
 * @author  Sebastian Bergmann <sb@sebastian-bergmann.de>
 *          Based upon JUnit, see http://www.junit.org/ for details.
 */
class PHPUnit {
    function &run(&$suite) {
        $result = new PHPUnit_TestResult();
        $suite->run($result);

        return $result;
    }
}
?>
