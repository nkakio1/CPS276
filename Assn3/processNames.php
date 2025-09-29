<?php
function addClearNames() {
    $names = [];

    if (isset($_POST['namelist']) && !empty($_POST['namelist'])) {
        $names = json_decode($_POST['namelist'], true) ?? [];
    }

    if (isset($_POST['addName']) && !empty(trim($_POST['name']))) {
        $fullName = trim($_POST['name']);
        $parts = explode(' ', $fullName, 2);
        $firstName = ucfirst(strtolower($parts[0] ?? ''));
        $lastName  = ucfirst(strtolower($parts[1] ?? ''));

        array_unshift($names, [
            'first' => $firstName,
            'last'  => $lastName
        ]);
    }

    if (isset($_POST['clearNames'])) {
        $names = [];
    }

    return $names;
}

function displayNames($names) {
    $output = "";
    if (!empty($names)) {
        foreach ($names as $person) {
            $output .= htmlspecialchars(trim($person['first'] . ' ' . $person['last'])) . "\n";
        }
    }
    return $output;
}
/*
//What is the purpose of separating the functionality between index.php and processNames.php?
//
//
//How does the $_SERVER["REQUEST_METHOD"] variable help determine when to process form submissions in PHP?
//
//
//How does PHP handle string-to-array conversion using the explode function, and why is this useful in this application?
//
//What role does the implode function play in formatting the output for the textarea?


//How does the use of "\n" inside a double-quoted string affect how names are displayed in the textarea? Why not use <br>?

//What security considerations should be taken into account when handling user input in this application?
*/
?>

