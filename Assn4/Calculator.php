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
<<<<<<< HEAD
            return "You CANNOT DIVIDE BY 0!!<br>";
=======
            return "Result of $a $op $b =  You CANNOT DIVIDE BY 0!!\n";
>>>>>>> 0798dd85df38f9681f9a3b9bc0a6871359d96e5c
        }

        switch ($op) {
            case '+': $res = $a + $b; break;
            case '-': $res = $a - $b; break;
            case '*': $res = $a * $b; break;
            case '/': $res = $a / $b; break;
            default:
                return "Unhandled operator: {$op}<br>";
        }

<<<<<<< HEAD
return 'Result of ' . $a . ' ' . $op . ' ' . $b . ' = ' . (string)$res . ' units' . "<br>";
=======
return "Result of $a $op $b = "  . (string)$res .  " units. \n";
>>>>>>> 0798dd85df38f9681f9a3b9bc0a6871359d96e5c
    }
}
?>
