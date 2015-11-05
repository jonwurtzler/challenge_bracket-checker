## Installation

Install the vendor dependencies with Composer:

    $ composer install

## Usage

    $ php bracketchecker.php "example1"
    Found 0 Bracket Pairs

    $ php bracketchecker.php "(example)[1]"
    Found 2 Bracket Pairs
    
    $ php bracketchecker.php "(example)[1]]"
    You have extra closing brackets
    
    $ php bracketchecker.php "(example)[[1]"
    You have extra opening brackets
    
    $ php bracketchecker.php "(example)([1)]"
    You have mismtached brackets

