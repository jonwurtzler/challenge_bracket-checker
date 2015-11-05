<?php
/**
 * Challenge Yourselph - 001
 * Matching Brackets
 *
 * Write a function that will verify if a passed string has correctly matched brackets and then count how many pairs of brackets it contains.
 *
 * Usage: php bracketchecker.php "[string]"
 * Example: php bracketchecker.php "(example)[1]"
 *
 * @author Jon Wurtzler <jon.wurtzler@gmail.com>
 */

use BracketChecker\BracketChecker;

require_once __DIR__ . '/vendor/autoload.php';

$input = (string) isset($argv[1]) ? $argv[1] : "";

if (!empty($input)) {
    $checker = new BracketChecker($input);

    try {
        $pairCount = $checker->checkBrackets();
        if ($pairCount < 1) {
            echo("No Bracket Pairs Found\n");
        } elseif ($pairCount == 1) {
            echo("Found 1 Bracket Pair\n");
        } else {
            echo("Found {$pairCount} Bracket Pairs\n");
        }
    } catch (Exception $e) {
        echo ($e->getMessage());
    }

} else {
    echo("Please enter a string to check.  Ex: '(example)[1]'");
}