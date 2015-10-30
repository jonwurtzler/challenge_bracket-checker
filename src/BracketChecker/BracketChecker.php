<?php namespace BracketChecker;

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

    /**
     * Set the base string that will be checked.
     *
     * @param string $baseString
     */
    public function __construct($baseString)
    {
        $this->baseString = $baseString;
    }

    private function findBracketPair($bracketString) {


        return true;
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
     * Find the first instance of the passed bracket in the given string.
     *   Ignore any escaped versions, ie '\{' should be ignored.
     *
     * @param string $bracketString
     * @param string $openingBracket
     * @param int    $offsetPos
     *
     * @return bool|int
     */
    private function findNextOpeningBracket($bracketString, $openingBracket, $offset = 0)
    {
        $bracketPos = strpos($bracketString, $openingBracket, $offset);
        var_dump("First Bracket Pos: " . $bracketPos . "\n");

        if ($bracketPos) {
            // Confirm the bracket wasn't escaped.
            if (!$this->isEscaped($bracketString, $bracketPos)) {
                return $bracketPos;

            // Continue the search, ignoring found escaped character.
            } else {
                return $this->findNextOpeningBracket($bracketString, $openingBracket, $bracketPos+1);
            }
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
                return $this->findMatchingClosingBracket($bracketString, $closingBracket, $matchingBracketPos-2);
            }
        }
    }

    /**
     * Determine if there
     * @param $bracketString
     *
     * @return bool|string
     * @throws \Exception
     */
    private function findNextBracketString($bracketString)
    {
        $nextOpeningPos     = null;
        $nextClosingBracket = "";

        foreach ($this->bracketList as $openingBracket => $closingBracket) {
            $bracketPos = $this->findNextOpeningBracket($bracketString, $openingBracket);

            if ($bracketPos) {
                // We haven't found an opening bracket yet.
                if ($nextOpeningPos === null) {
                    $nextOpeningPos     = $bracketPos;
                    $nextClosingBracket = $closingBracket;

                // Confirm the newly found bracket is before the previously found one.
                } else {
                    if ($bracketPos < $nextOpeningPos) {
                        $nextOpeningPos     = $bracketPos;
                        $nextClosingBracket = $closingBracket;
                    }
                }
            }
        }

        if (!empty($nextOpeningPos) && $nextOpeningPos > 0) {
            $nextEndingPos = $this->findMatchingClosingBracket($bracketString, $nextClosingBracket);
            if ($nextEndingPos) {
                // Make sure to add the found pair to class property.
                $this->bracketCount++;

                // Pass substr to be searched deeper
                return substr($bracketString, $nextOpeningPos, $nextEndingPos);
            // Stop
            } else {
                throw new \Exception("Brackets Mismatched");
            }
        }

        return false;
    }

    public function checkBrackets()
    {
        if ($this->findNextBracketString($this->baseString)) {
            return $this->bracketCount;
        }

        return $this->bracketCount;
    }

    // Find either '(' or '['
    // Find a matching ')' or ']' based on what was found
    //   If match found, rerun method using text from inside it.
    //   If not found, return false up the chain.



}