<?php

class Calculator {
    public function calc($op = null, $a = null, $b = null) {
        if ($op === null) {
            return "No operator provided\n";
        }

        // Validate operator
        if (!in_array($op, ['+','-','*','/'])) {
            return "Invalid operator: {$op}\n";
        }

        // If operands missing, give an informative message
        if (!isset($a) || !isset($b)) {
            return "Missing operand(s) for operator {$op}\n";
        }

        if (!is_numeric($a) || !is_numeric($b)) {
            return "Non-numeric operand(s): {$a}, {$b}\n";
        }

        $a = (float)$a;
        $b = (float)$b;

        if ($op === '/' && $b == 0.0) {
            return "You CANNOT DIVIDE BY 0!!\n";
        }

        switch ($op) {
            case '+': $res = $a + $b; break;
            case '-': $res = $a - $b; break;
            case '*': $res = $a * $b; break;
            case '/': $res = $a / $b; break;
            default:
                return "Unhandled operator: {$op}\n";
        }

return 'Result of ' . $a . ' ' . $op . ' ' . $b . ' = ' . (string)$res . ' units' . "\n";
    }
}
?>
