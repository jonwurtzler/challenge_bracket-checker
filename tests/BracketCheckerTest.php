<?php
use BracketChecker\BracketChecker;

/**
 * User: jwurtzle
 * Date: 11/2/15
 * Time: 5:48 PM
 */
class BracketCheckerTest extends PHPUnit_Framework_TestCase
{

    public function testSingleSuccess() {
        $checker = new BracketChecker("(example)1");
        $this->assertEquals(1, $checker->checkBrackets());
    }

    public function testTwoTypesInlineSuccess() {
        $checker = new BracketChecker("(example)[1]");
        $this->assertEquals(2, $checker->checkBrackets());
    }

    public function testNoBrackets() {
        $checker = new BracketChecker("example1");
        $this->assertEquals(0, $checker->checkBrackets());
    }

    public function testNoUnescapedBrackets() {
        $checker = new BracketChecker("\\(example\\)1");
        $this->assertEquals(0, $checker->checkBrackets());
    }

    public function testInternalBrackets() {
        $checker = new BracketChecker("(ex(amp)le)1");
        $this->assertEquals(2, $checker->checkBrackets());
    }

    public function testInternalEscapedBrackets() {
        $checker = new BracketChecker("(ex\\(amp\\)le)1");
        $this->assertEquals(1, $checker->checkBrackets());
    }

    public function testEmptyBrackets() {
        $checker = new BracketChecker("()1");
        $this->assertEquals(1, $checker->checkBrackets());
    }

    public function testSideBySideSameEmptyBrackets() {
        $checker = new BracketChecker("()()1");
        $this->assertEquals(2, $checker->checkBrackets());
    }

    public function testSideBySideSameBrackets() {
        $checker = new BracketChecker("(a)(b)1");
        $this->assertEquals(2, $checker->checkBrackets());
    }

    public function testManyBrackets() {
        $checker = new BracketChecker("(a[((c))])[([[b]])]1");
        $this->assertEquals(8, $checker->checkBrackets());
    }

    public function testManyWithEscapedBrackets() {
        $checker = new BracketChecker("(a[(\\(c\\))])\\[([[b]])\\]1");
        $this->assertEquals(6, $checker->checkBrackets());
    }

    /** ---------------------------------------------------------------
     * Testing Known reasons to throw Exceptions
     * -------------------------------------------------------------
     */

    /**
     * @expectedException Exception
     */
    public function testMissingOpenerBracket() {
        $checker = new BracketChecker("example)[1]");
        $checker->checkBrackets();
    }

    /**
     * @expectedException Exception
     */
    public function testMissingClosingBracket() {
        $checker = new BracketChecker("(example[1]");
        $checker->checkBrackets();
    }

    /**
     * @expectedException Exception
     */
    public function testMissingOpenerBracketFromEscape() {
        $checker = new BracketChecker("\\(example)[1]");
        $checker->checkBrackets();
    }

    /**
     * @expectedException Exception
     */
    public function testMissingClosingBracketFromEscape() {
        $checker = new BracketChecker("(example\\)[1]");
        $checker->checkBrackets();
    }

    /**
     * @expectedException Exception
     */
    public function testOffsetBrackets() {
        $checker = new BracketChecker("([(])1");
        $this->assertEquals(2, $checker->checkBrackets());
    }
}
