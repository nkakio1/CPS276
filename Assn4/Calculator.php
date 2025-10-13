<?php

class Calculator {
    public function calc($op = null, $a = null, $b = null) {
        if ($op === null) {
            return "No operator provided<br>";
        }

  
        if (!in_array($op, ['+','-','*','/'])) {
            return "Invalid operator: {$op}<br>";
        }


        if (!isset($a) || !isset($b)) {
            return "Missing operand(s) for operator {$op}<br>";
        }

        if (!is_numeric($a) || !is_numeric($b)) {
            return "Non-numeric operand(s): {$a}, {$b}<br>";
        }

        $a = (float)$a;
        $b = (float)$b;

        if ($op === '/' && $b == 0.0) {
            return "You CANNOT DIVIDE BY 0!!<br>";
        }

        switch ($op) {
            case '+': $res = $a + $b; break;
            case '-': $res = $a - $b; break;
            case '*': $res = $a * $b; break;
            case '/': $res = $a / $b; break;
            default:
                return "Unhandled operator: {$op}<br>";
        }

return 'Result of ' . $a . ' ' . $op . ' ' . $b . ' = ' . (string)$res . ' units' . "<br>";
    }
}

//require vs require once
// require will include and evaluate the specified file every time it is called
// require_once will check if the file has already been included, and if so, it will not include it again

// how does the divide prevent /0
// it checks if the second operand ($b) is 0 before performing the division and returns an error message if it is
/*
adding the ^ operator (exponentiation) you would need to add it to my operator array
if (!in_array($op, ['+','-','*','/','^'])) {
            return "Invalid operator: {$op}<br>";
        }
and then add a case for it in the switch statement
case '^': $res = pow($a, $b); break;
then add a test case in the index.php file
$result .= $Calculator->calc("^", 2, 3); // should return 8
*/

//what is the calculator class vs the calculator object?
// The Calculator class is a blueprint for creating calculator objects. It defines the methods and properties that the objects will have.
// The calculator object is an instance of the Calculator class, created using the 'new' keyword. It can use the methods defined in the class.


// why check if the last two operands are numbers?
// to ensure that the calculation can be performed without errors

// why separate logic from calling?
// to maintain a clean separation of concerns, making the code easier to read and maintain

?>
