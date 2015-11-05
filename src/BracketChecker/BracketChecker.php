<?php namespace BracketChecker;

use \Exception;

class BracketChecker
{

    /**
     * @var string $baseString
     */
    private $baseString;

    /**
     * @var array $bracketList
     */
    private $bracketList = [
        '(' => ')',
        '[' => ']',
    ];

    private $closingBracketList = [];

    /**
     * Set the base string that will be checked and reverse the bracket list array for doing reverse bracket checks.
     *
     * @param string $baseString
     */
    public function __construct($baseString)
    {
        $this->baseString         = $baseString;
        $this->closingBracketList = array_flip($this->bracketList);
    }

    /**
     * Main Searching method.
     *
     * @param string $bracketString
     *
     * @return int   $bracketCount
     *
     * @throws Exception
     */
    public function checkBrackets()
    {
        $length = strlen($this->baseString);
        $bracketCount = 0;
        $bracketStack = [];

        for ($i = 0; $i < $length; $i++) {
            $currentStringChar = $this->baseString[$i];

            // Skip any character following a '\'
            if ($currentStringChar == "\\") {
                $i++;

            // Found an opening bracket
            }  elseif (array_key_exists($currentStringChar, $this->bracketList)) {
                array_push($bracketStack, $currentStringChar);

            // Handle closing bracket.
            } elseif (array_key_exists($currentStringChar, $this->closingBracketList)) {
                if (!empty($bracketStack)) {
                    $bracketArrayLen = count($bracketStack) - 1;

                    if ($bracketStack[$bracketArrayLen] == $this->closingBracketList[$currentStringChar]) {
                        array_pop($bracketStack);
                        $bracketCount++;
                    } else {
                        throw new Exception("You have mismtached brackets\n");
                    }
                } else {
                    throw new Exception("You have extra closing brackets\n");
                }
            }
        }

        // Check if any brackets remain
        if (!empty($bracketStack)) {
            throw new Exception("You have extra opening brackets\n");
        }

        return $bracketCount;
    }

}