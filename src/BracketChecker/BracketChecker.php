<?php namespace BracketChecker;

use \Exception;

class BracketChecker
{

    /**
     * @var string $baseString
     */
    private $baseString;

    /**
     * Running count of matched brackets
     *
     * @var int $bracketCount
     */
    private $bracketCount = 0;

    /**
     * @var array $bracketList
     */
    private $bracketList = [
        '(' => ')',
        '[' => ']',
    ];

    private $closingBracketList = [];

    /**
     * Set the base string that will be checked.
     *
     * @param string $baseString
     */
    public function __construct($baseString)
    {
        $this->baseString         = $baseString;
        $this->closingBracketList = array_values($this->bracketList);
    }

    /**
     * Main Searching method.
     *
     * @param $bracketString
     * @throws Exception
     */
    private function getBracketString($bracketString)
    {
        $length = strlen($bracketString);
        $bracketStack = [];

        for ($i = 0; $i < $length; $i++) {
            // Skip any character following a '\'
            if ($bracketString[$i] == "\\") {
                $i++;

            // Handle orphan closing bracket.
            } elseif (in_array($bracketString[$i], $this->closingBracketList)) {
                throw new Exception("You have mismatched brackets.\nSpecifically a closing bracket without an opening bracket.\n");

            // Found an opening bracket
            } elseif (array_key_exists($bracketString[$i], $this->bracketList)) {
                $bracketStack[] = $bracketString[$i];
            }
        }
    }

    public function checkBrackets()
    {
        $this->getBracketString($this->baseString);

        return $this->bracketCount;
    }

    // Find either '(' or '['
    // Find a matching ')' or ']' based on what was found
    //   If match found, rerun method using text from inside it.
    //   If not found, return false up the chain.



}