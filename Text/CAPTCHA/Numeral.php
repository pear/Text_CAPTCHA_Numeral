<?php
/**
 * Numeral Captcha
 *
 * PHP version 5
 *
 * @category  Text
 * @package   Text_CAPTCHA_Numeral
 * @author    David Coallier <davidc@agoraproduction.com>
 * @author    Marcelo Araujo <msaraujo@php.net>
 * @copyright 2002-2007 Agora Production (http://agoraproduction.com)
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @link      http://pear.php.net/package/Text_CAPTCHA_Numeral
 */
require_once 'Text/CAPTCHA/Numeral/NumeralInterface.php';

// {{{ Class Text_CAPTCHA_Numeral
/**
 * Class used for numeral captchas
 *
 * This class is intended to be used to generate
 * numeral captchas as such as:
 * Example:
 *  Give me the answer to "54 + 2" to prove that you are human.
 *
 * @category  Text
 * @package   Text_CAPTCHA_Numeral
 * @author    David Coallier <davidc@agoraproduction.com>
 * @author    Marcelo Araujo <msaraujo@php.net>
 * @copyright 2002-2007 Agora Production (http://agoraproduction.com)
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD
 * @link      http://pear.php.net/package/Text_CAPTCHA_Numeral
 */
class Text_CAPTCHA_Numeral implements Text_CAPTCHA_Numeral_Interface
{
    // {{{ Variables
    /**
     * Minimum range value
     *
     * This variable holds the minimum range value
     * default set to "1"
     *
     * @var    integer $minValue The minimum range value
     */
    protected $minValue = '1';
  
    /**
     * Maximum range value
     *
     * This variable holds the maximum range value
     * default set to "50"
     *
     * @var    integer $maxValue The maximum value of the number range
     */
    protected $maxValue = '50';
  
    /**
     * Operators
     *
     * The valid operators to use
     * in the numeral captcha. We could
     * use / and * but not yet.
     *
     * @var    array $operators The operations for the captcha
     */
    protected $operators = array('+','-');
  
    /**
     * Operator to use
     *
     * This variable is basically the operation
     * that we're going to be using in the
     * numeral captcha we are about to generate.
     *
     * @var    string $operator The operation's operator
     */
    protected $operator = '';
  
    /**
     * Mathematical Operation
     *
     * This is the mathematical operation
     * that we are displaying to the user.
     *
     * @var    string $operation The math operation
     */
    protected $operation = '';
  
    /**
     * First number of the operation
     *
     * This variable holds the first number
     * of the numeral operation we are about
     * to generate.
     *
     * @var    integer $firstNumber The first number of the operation
     */
    protected $firstNumber = '';
  
    /**
     * Second Number of the operation
     *
     * This variable holds the value of the
     * second variable of the operation we are
     * about to generate for the captcha.
     *
     * @var    integer $secondNumber The second number of the operation    
     */
    protected $secondNumber = '';
  
    /**
     * The operation answer
     *
     * The answer to the numeral operation
     * we are about to do.
     *
     * @var    integer $answer The mathematical operation answer value.
     */
    protected $answer;
 
    /**
     * A constant that indicates the complexity of mathematical operations
     *
     * @access public
     *
     */
    const COMPLEXITY_ELEMENTARY = 1;
    
    /**
     * A constant that indicates the complexity of mathematical operations
     *
     * @access public
     *
     */
    const COMPLEXITY_HIGH_SCHOOL = 2;
       
    /**
     * A constant that indicates the complexity of mathematical operations
     *
     * @access public
     *
     */
    const COMPLEXITY_UNIVERSITY = 4;
 
    /**
     * Kept for backwards compatibility only; use the short constant.
     *
     * @deprecated
     */
    const TEXT_CAPTCHA_NUMERAL_COMPLEXITY_ELEMENTARY = 1;
    
    /**
     * Kept for backwards compatibility only; use the short constant.
     *
     * @deprecated
     */
    const TEXT_CAPTCHA_NUMERAL_COMPLEXITY_HIGH_SCHOOL = 2;
   
    /**
     * Kept for backwards compatibility only; use the short constant.
     *
     * @deprecated
     */
    const TEXT_CAPTCHA_NUMERAL_COMPLEXITY_UNIVERSITY = 4;
 
 
 
    // }}}
    // {{{ Constructor
    /**
     * Constructor with different levels of mathematical operations sets
     *
     * @param constant $complexityType How complex the captcha equation shall be.
     *                                 See the COMPLEXITY constants.
     * @param integer  $minValue       Minimal value of a number
     * @param integer  $maxValue       Maximal value of a number
     */
    public function __construct(
        $complexityType = self::COMPLEXITY_ELEMENTARY,
        $minValue = 1, $maxValue = 50
    ) {
         $this->prepare($complexityType, $minValue, $maxValue);
    }
    // }}}
    // {{{ protected function setRangeMinimum
    /**
     * Set Range Minimum value
     *
     * This function give the developer the ability
     * to set the range minimum value so the operations
     * can be bigger, smaller, etc.
     *
     * @param integer $minValue The minimum value
     *
     * @return void
     */
    protected function setRangeMinimum($minValue = '1')
    {
        $this->minValue = (int)$minValue;
    }
    // }}}
    // {{{ protected function generateFirstNumber
    /**
     * Sets the first number
     *
     * This function sets the first number
     * of the operation by calling the generateNumber
     * function that generates a random number.
     *
     * @return void
     *
     * @see $this->firstNumber, $this->generateNumber
     */
    protected function generateFirstNumber()
    {
        $this->setFirstNumber($this->generateNumber());
    }
    // }}}
    // {{{ protected function generateSecondNumber
    /**
     * Sets second number
     *
     * This function sets the second number of the
     * operation by calling generateNumber()
     *
     * @return void
     *
     * @see $this->secondNumber, $this->generateNumber()
     */
    protected function generateSecondNumber()
    {
        $this->setSecondNumber($this->generateNumber());
    }
    // }}}
    // {{{ protected function generateOperator
    /**
     * Sets the operation operator
     *
     * This function sets the operation operator by
     * getting the array value of an array_rand() of
     * the $this->operators() array.
     *
     * @return void
     *
     * @see $this->operators, $this->operator
     */
    protected function generateOperator()
    {
        $this->operator = $this->operators[array_rand($this->operators)];
    }
    // }}}
    // {{{ protected function setAnswer
    /**
     * Sets the answer value
     *
     * This function will accept the parameters which is
     * basically the result of the function we have done
     * and it will set $this->answer with it.
     *
     * @param integer $answerValue The answer value
     *
     * @return void
     *
     * @see $this->answer
     */
    protected function setAnswer($answerValue)
    { 
        $this->answer = $answerValue;
        return $this;
    }
    // }}}
    // {{{ protected function setFirstNumber
    /**
     * Set First number
     *
     * This function sets the first number
     * to the value passed to the function
     *
     * @param integer $value The first number value.
     *
     * @return Text_CAPTCHA_Numeral The self object
     */
    protected function setFirstNumber($value)
    {
        $this->firstNumber = (int)$value;
        return $this;
    }
    // }}}
    // {{{ protected function setSecondNumber
    /**
     * Sets the second number
     *
     * This function sets the second number
     * with the value passed to it.
     *
     * @param integer $value The second number new value.
     *
     * @return Text_CAPTCHA_Numeral The self object
     */
    protected function setSecondNumber($value)
    {
        $this->secondNumber = (int)$value;
        return $this;
    }
    // }}}
    // {{{ protected function setOperation
    /**
     * Set "operation" string the user needs to solve.
     *
     * This variable sets the operation variable
     * by taking the firstNumber, secondNumber and operator
     *
     * @param string $type May be null, or "F" to indicate a factorial operation
     *
     * @return void
     *
     * @see $this->operation
     */
    protected function setOperation($type = null)
    {
        if ($type == 'F') {
            $this->operation = $this->getFirstNumber() . ' ' . $this->operator;
        } else {
            $this->operation = $this->getFirstNumber() . ' ' .
            $this->operator . ' ' .
            $this->getSecondNumber();
        }
        return $this;
    }
    // }}}
    // {{{ protected function generateNumber
    /**
     * Generate a number
     *
     * This function takes the parameters that are in
     * the $this->maxValue and $this->minValue and get
     * the random number from them using mt_rand()
     *
     * @return integer Random value between minValue and maxValue
     */
    protected function generateNumber()
    {
        return mt_rand($this->minValue, $this->maxValue);
    }
    // }}}
    // {{{ protected function doAdd
    /**
     * Adds values
     *
     * This function will add the firstNumber and the
     * secondNumber value and then call setAnswer to
     * set the answer value.
     *
     * @return void
     *
     * @see $this->firstNumber, $this->secondNumber, $this->setAnswer()
     */
    protected function doAdd()
    {
        $answer = $this->getFirstNumber() + $this->getSecondNumber();
        $this->setAnswer($answer);
    }
    // }}}
    // {{{ protected function doMultiplication
    /**
     * Do Multiplication
     *
     * This method will multiply two numbers
     *
     * @return void
     *
     * @see $this->firstNumber, $this->secondNumber, $this->setAnswer
     */
    protected function doMultiplication()
    {
        $this->setAnswer($this->getFirstNumber() * $this->getSecondNumber());
    }
    // }}}
    // {{{ protected function doDivision
    /**
     * Do Division
     *
     * This function executes a division based on the two
     * numbers.
     *
     * @param integer $firstNumber  The first number of the operation.
     *                              This is by default set to null.
     * @param integer $secondNumber The second number of the operation
     *                              This is by default set to null.
     *
     * @return void
     */
    protected function doDivision($firstNumber = null, $secondNumber = null)
    {
        if (is_null($firstNumber)) {
            $firstNumber = $this->getFirstNumber();
        }

        if (is_null($secondNumber)) {
            $secondNumber = $this->getSecondNumber();
        }

        if ($secondNumber == 0) {
            ++$secondNumber;
            $this->doDivision($firstNumber, $secondNumber);
            return;
        }
       
        if ($firstNumber == 0) {
            $this->doDivision(++$firstNumber, $secondNumber);
            return;
        }
        
        if ($firstNumber % $secondNumber != 0) {
            --$firstNumber;
            --$secondNumber;
           
            $this->doDivision($firstNumber, $secondNumber);
            return;
        }

        $this->setFirstNumber($firstNumber)
            ->setSecondNumber($secondNumber)
            ->setOperation()
            ->setAnswer($this->getFirstNumber() / $this->getSecondNumber());
    }
    // }}}
    // {{{ protected function doModulus
    /**
     * Do modulus
     *
     * This method will do a modulus operation between two numbers
     *
     * @return void
     *
     * @see $this->firstNumber, $this->secondNumber, $this->setAnswer()
     */
    protected function doModulus()
    {
        $first  = $this->getFirstNumber();
        $second = $this->getSecondNumber();

        if ($first == $second) {
            $this->generateSecondNumber();
            $this->doModulus();
            return;
        }

        $this->setAnswer($this->getFirstNumber() % $this->getSecondNumber());
    }
    // }}}
    // {{{ protected function doSubstract
    /**
     * Does a substract on the values
     *
     * This function executes a substraction on the firstNumber
     * and the secondNumber to then call $this->setAnswer to set
     * the answer value.
     *
     * If the firstnumber value is smaller than the secondnumber value
     * then we regenerate the first number and regenerate the operation.
     *
     * @return void
     *
     * @see $this->firstNumber, $this->secondNumber, $this->setAnswer()
     */
    protected function doSubstract()
    {
         $first  = $this->getFirstNumber();
         $second = $this->getSecondNumber();
 
        /**
         * Check if firstNumber is smaller than secondNumber
         */
        if ($first < $second) {
            $this->setFirstNumber($second)
                ->setSecondNumber($first)
                ->setOperation();
        }

        $answer = $this->getFirstNumber() - $this->getSecondNumber();
        $this->setAnswer($answer);
    }
    // }}}
    // {{{ protected function doExponentiation
    /**
     * Does an exponentiation on the values
     *
     * This function executes an exponentiation
     *
     * @return void
     *
     * @see $this->setOperation, $this->getFirstNumber
     *      $this->getSecondNumber, $this->setAnswer()
     */
    protected function doExponentiation() 
    {        
        $this->setOperation()
            ->setAnswer(pow($this->getFirstNumber(), $this->getSecondNumber()));
    }
    // }}}
    // {{{ protected function doFactorial
    /**
     * Call static factorial method
     *
     * @return void
     */
    protected function doFactorial() 
    {
        $this->setOperation('F')
            ->setAnswer($this->calculateFactorial($this->getFirstNumber()));
    }   
    // }}}    
    // {{{ protected function calculateFactorial
    /**
     * Calculate factorial given an integer number
     *
     * @param integer $n The factorial to calculate
     *
     * @return integer The calculated value
     */
    protected function calculateFactorial($n) 
    {
        return $n <= 1 ? 1 : $n * $this->calculateFactorial($n - 1);
    }
    // }}}
    // {{{ protected function generateOperation
    /**
     * Generate the operation
     *
     * This function will call the setOperation() function
     * to set the operation string that will be called
     * to display the operation, and call the function necessary
     * depending on which operation is set by this->operator.
     *
     * @return void
     *
     * @see $this->setOperation(), $this->operator
     */
    protected function generateOperation()
    {
        $this->setOperation();

        switch ($this->operator) {
        case '+':
            $this->doAdd();
            break;
        case '-':
            $this->doSubstract();
            break;
        case '*':
            $this->doMultiplication();
            break;
        case '%':
            $this->doModulus();
            break;
        case '/':
            $this->doDivision();
            break;
        case '^':
            $this->minValue = 10;
            $this->doExponentiation();
            break;
        case '!':
            $this->minValue = 1;
            $this->maxValue = 10;
            $this->generateFirstNumber();
            $this->doFactorial();
            break;
        default:
            $this->doAdd();
            break;
        }
    }
    // }}}
    // {{{ public function getOperation
    /**
     * Get operation
     *
     * This function will get the operation
     * string from $this->operation
     *
     * @return string The operation String
     */
    public function getOperation()
    {
        return $this->operation;
    }
    // }}}
    // {{{ public function getAnswer
    /**
     * Get the answer value
     *
     * This function will retrieve the answer
     * value from this->answer and return it so
     * we can then display it to the user.
     *
     * @return string The operation answer value.
     */
    public function getAnswer()
    {
        return $this->answer;
    }
    // }}}
    // {{{ public function getFirstNumber
    /**
     * Get the first number
     *
     * This function will get the first number
     * value from $this->firstNumber
     *
     * @return integer $this->firstNumber The firstNumber
     */
    public function getFirstNumber()
    {
        return $this->firstNumber;
    }
    // }}}
    // {{{ public function getSecondNumber
    /**
     * Get the second number value
     *
     * This function will return the second number value
     *
     * @return integer $this->secondNumber The second number
     */
    public function getSecondNumber()
    {
        return $this->secondNumber;
    }
    // }}}
    // {{{ public function prepare
    /**
     * prepare class with the values
     *
     * This function prepare configure the values to 
     * generate the captcha 
     *
     * @param constant $complexityType How complex the captcha equation shall be.
     *                                 See the COMPLEXITY constants.
     * @param integer  $minValue       Minimal value of a number
     * @param integer  $maxValue       Maximal value of a number
     *
     * @return void
     */
    public function prepare($complexityType, $minValue, $maxValue)
    {
        $this->minValue = (int)$minValue;
        $this->maxValue = (int)$maxValue;

        switch ($complexityType) {
        case self::COMPLEXITY_HIGH_SCHOOL:
            $this->operators[] = '*';
            if ($this->maxValue < 70) {
                $this->maxValue = '70';
            }

            break;
        case self::COMPLEXITY_UNIVERSITY:
            $this->operators[] = '*';
            $this->operators[] = '%';
            $this->operators[] = '/';
            $this->operators[] = '^';
            $this->operators[] = '!';
            if ($this->maxValue < 100) {
                $this->maxValue = '100';
            }
            
            break;
        case self::COMPLEXITY_ELEMENTARY:
        default:
            break;
        }

        $this->generateFirstNumber();
        $this->generateSecondNumber();
        $this->generateOperator();
        $this->generateOperation();
    }
    // }}}    
    
}
// }}}
