<?php
$output = [];

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    require_once 'processNames.php';
    $output = addClearNames();
}
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
          crossorigin="anonymous">
    <title>NameListHolder</title>
  </head>
  <body>
    <div class="container">
      <h1>NameListHolder</h1>

      <form method="post" action="index.php">

        <input type="submit" name="addName" class="btn btn-primary" value="Add Name">
        <input type="submit" name="clearNames" class="btn btn-primary" value="Clear Names">

        <div class="form-group mt-3">
          <label for="name">Enter Name (First Last)</label>
          <input type="text" class="form-control" id="name" name="name" autocomplete="off">
        </div>

        <div class="form-group mt-3">
          <label for="namelist">List of Names</label>
          <textarea style="height: 500px;" class="form-control" id="namelist"><?php
           
            echo displayNames($output);
          ?></textarea>
        </div>

        
        <input type="hidden" name="namelist" value='<?php echo htmlspecialchars(json_encode($output)); ?>'>

      </form>
    </div>
  </body>
</html>