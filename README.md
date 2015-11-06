## Challenge
In this challenge you will receive a string which you will need to verify if it has correctly matched brackets and then count how many pairs of brackets it contains.

If the string has correctly matched brackets you should return 1 and the number of bracket pairs, otherwise return 0. If there is no brackets, return 1.

For example, the output of `(example)[1]` should be “1 2” because all brackets have a match and there is 2 pairs of brackets. Although, the output of `(example)[1][` should be “0” because there is one unmatched bracket.

You must create a function to solve this problem and write the results to the standard output.

Notes:  
If all brackets are matched return 1 and number of bracket pairs.  
If the string has no brackets, return 1.  
If there is unmatched brackets, return 0.  
Only “( ) [ ]” will be used as brackets.  
Escaped brackets must be ignored. Ex: “\(“, “\)”, “\]”, “\[“

**Input Format:** Each test case contains a string  
**Output Format:** You will have to return a string with 1 and the number of matching brackets

## Installation

Install the vendor dependencies with Composer:

    $ composer install

## Usage

    $ php bracketchecker.php "example1"
    No Bracket Pairs Found
    
    $ php bracketchecker.php "example1\(\)()"
    Found 1 Bracket Pair

    $ php bracketchecker.php "(example)[1]"
    Found 2 Bracket Pairs
    
    $ php bracketchecker.php "(example)[1]]"
    You have extra closing brackets
    
    $ php bracketchecker.php "(example)[[1]"
    You have extra opening brackets
    
    $ php bracketchecker.php "(example)([1)]"
    You have mismtached brackets


