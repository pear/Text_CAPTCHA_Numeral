--TEST--
Text_CAPTCHA_Numeral::getOperation(),
Text_CAPTCHA_Numeral::getFirstNumber(),
Text_CAPTCHA_Numeral::getSecondNumber()
--FILE--
<?php
require_once 'Text/CAPTCHA/Numeral.php';

$num = new Text_CAPTCHA_Numeral();

$op = $num->getOperation();

$parts = split(" ", $op);

$numberOne = $num->getFirstNumber();
$numberTwo = $num->getSecondNumber();

if ($numberOne != $parts[0]) {
    print $numberOne . " does not equal " . $parts[0] . "\n";
}

if ($numberTwo != $parts[2]) {
    print $numberTwo . " does not equal " . $parts[2] . "\n";
}

print "OK";
?>
--EXPECT--
OK
