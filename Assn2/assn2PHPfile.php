
<?php

$evenNumbers = "\n Even Numbers: " . evenNumbersLoop();
function evenNumbersLoop() {
    $evens = [];
    for ($i = 1; $i <= 50; $i++) {
        if ($i % 2 == 0) {
            $evens[] = $i;
        }
    }
    return implode(" - ", $evens);
}

$form = <<<HTML
<div class="mb-3 pt-3">
  <label for="exampleFormControlInput1" class="form-label">Email address</label>
  <input type="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
</div>
<div class="mb-3">
  <label for="exampleFormControlTextarea1" class="form-label">Example textarea</label>
  <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
</div>
HTML;

function createTable($rows, $cols) {
    $table = '<table class="table table-bordered">';
    for ($i = 0; $i < $rows; $i++) {
        $table .= '<tr>';
        for ($j = 0; $j < $cols; $j++) {
            $table .= '<td>Row ' . ($i + 1) . ' Col ' . ($j + 1) . '</td>';
        }
        $table .= '</tr>';
    }
    $table .= '</table>';
    return $table;
}

?>


<!DOCTYPE html>
<html>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">

<body class="container">
    <?php
        echo $evenNumbers;
        echo $form;
        echo createTable(8, 6);
    ?>
</body>

</html>