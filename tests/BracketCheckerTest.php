<?php
use BracketChecker\BracketChecker;

/**
 * Created by PhpStorm.
 * User: jwurtzle
 * Date: 11/2/15
 * Time: 5:48 PM
 */
class BracketCheckerTest extends PHPUnit_Framework_TestCase
{

    public function testBasicSuccess() {
        $checker = new BracketChecker("(example)[1]");
        $this->assertEquals(2, $checker->checkBrackets());
    }

    public function testNoBrackets() {
        $checker = new BracketChecker("example1");
        $this->assertEquals(0, $checker->checkBrackets());
    }

    /**
     * @expectedException Exception
     */
    public function testMissingOpenerBrackets() {
        $checker = new BracketChecker("example)[1]");
        $checker->checkBrackets();
    }

    /**
     * @expectedException Exception
     */
    public function testMissingClosingBrackets() {
        $checker = new BracketChecker("(example[1]");
        $checker->checkBrackets();
    }
}
