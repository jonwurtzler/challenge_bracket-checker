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
     * Determine if the current bracket is escaped or not.
     *
     * @param string $bracketString
     * @param int $pos
     *
     * @return bool
     */
    private function isEscaped($bracketString, $pos) {
        if ($pos > 0) {
            if ($bracketString[$pos-1] == "\\") { return true; }
        }

        return false;
    }

    /**
     * Find a qualified closing bracket in the passed string.
     *
     * @param string $bracketString
     * @param string $closingBracket
     * @param int    $offset
     *
     * @return bool|int
     */
    private function findMatchingClosingBracket($bracketString, $closingBracket, $offset = -1)
    {
        // Search from the end of the string forward.
        //   Passing a neg offset will force strrpos to start at end and work forward.
        $matchingBracketPos = strrpos($bracketString, $closingBracket, $offset);

        if ($matchingBracketPos) {
            // Confirm the bracket wasn't escaped.
            if (!$this->isEscaped($bracketString, $matchingBracketPos)) {
                return $matchingBracketPos;

                // Continue the search, ignoring found escaped character.
                //   Use -2 to skip past the found '\' character as well.
            } else {
                $endingOffset = ((strlen($bracketString) - $matchingBracketPos) * -1) -1;
                return $this->findMatchingClosingBracket($bracketString, $closingBracket, $endingOffset);
            }
        }

        return null;
    }

    /**
     * Main Searching method.
     *   Iterates through each character looking for an opening bracket or a closing one
     * @param $bracketString
     * @throws Exception
     */
    private function getBracketString($bracketString)
    {
        $length = strlen($bracketString);

        for ($i = 0; $i < $length; $i++) {
            // Skip any character following a '\'
            if ($bracketString[$i] == "\\") {
                $i++;
            // Handle orphan closing bracket.
            } elseif (in_array($bracketString[$i], $this->closingBracketList)) {
                throw new Exception("You have mismatched brackets.\nSpecifically a closing bracket without an opening bracket.\n");
            // Found an opening bracket
            } elseif (array_key_exists($bracketString[$i], $this->bracketList)) {
                $closingBracket = $this->findMatchingClosingBracket($bracketString, $this->bracketList[$bracketString[$i]]);

                // No closing bracket, stop process fully
                if (empty($closingBracket)) {
                    throw new Exception("You have mismatched brackets.\nSpecifically an opening bracket without a closing bracket.\n");
                }

                // Found a full pair, increment total
                $this->bracketCount++;

                // Look through substring for more brackets
                $innerStrStart  = $i + 1;
                $innerStrLength = $closingBracket - $innerStrStart;

                // Update the current index to skip the found set
                $i = $closingBracket;

                // Any strings 2 or less are empty sets, skip looking for anything else.
                if ($innerStrLength > 2) {
                    $innerStr = substr($bracketString, $innerStrStart, $innerStrLength);

                    // Run the sub string through same method to find brackets.
                    $this->getBracketString($innerStr);
                }
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