--TEST--
Text_CAPTCHA_Numeral::getOperation(),
Text_CAPTCHA_Numeral::getAnswer()
--FILE--
<?php
    require_once 'Text/CAPTCHA/Numeral.php';

    $num = new Text_CAPTCHA_Numeral;

    $op     = $num->getOperation();
    $answer = $num->getAnswer();
    
    $parts = explode(' ', $op);

    $numberOne = $num->getFirstNumber();
    $numberTwo = $num->getSecondNumber();
    
    $textOne = 'First number';
    $textTwo = 'Second number';
    
    //print "Operation & Answer: $op = $answer ?\n";
    
    print "Result:";
    
    switch ($parts[1]) {
        case '-':
            if (($numberOne - $numberTwo) == $answer) {
                print "    PASSED\n";
            } else {
                print "    FAILED\n";
            }
            break;
        case '+':
            if (($numberOne + $numberTwo) == $answer) {
                print "    PASSED\n";
            } else {
                print "    FAILED\n";
            }
            break;
    }
?>
--EXPECT--
Result:    PASSED

