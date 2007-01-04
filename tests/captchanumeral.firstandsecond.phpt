--TEST--
Text_CAPTCHA_Numeral::getOperation(), 
Text_CAPTCHA_Numeral::getFirstNumber()
Text_CAPTCHA_Numeral::getSecondNumber()
--FILE__
<?php
    error_reporting(E_ALL & ~E_STRICT);
    require_once 'Text/CAPTCHA/Numeral.php';

    $num = new Text_CAPTCHA_Numeral;

    $op = $num->getOperation();

    $parts = split(" ", $op);

    $numberOne = $num->getFirstNumber();
    $numberTwo = $num->getSecondNumber();
    
    $textOne = 'First number';
    $textTwo = 'Second number';
    
    printf ("%-20s: %d (%d)\n", $textOne, $parts[0], $numberOne);
    printf ("%-20s: %d (%d)\n", $textTwo, $parts[2], $numberTwo);
?>
--EXPECT--
First number      : X (X)
Second number     : Y (Y)

    
