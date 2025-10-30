<?php
require_once '/home/n/a/nakio/public_html/cps276/aSN8/classes/Date_time.php';
$dt = new Date_time();
$notes = $dt->checkSubmit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <!--Required meta tags-->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Display Notes</title>

  <!--Bootstrap CSS-->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
        crossorigin="anonymous">
</head>
<body>
  <div class="container">
    <h1>Display Notes</h1>
    <p><a href="index.php">Add Note</a></p>

    <form action="display_notes.php" method="post">
      <div class="form-group">
        <label for="begDate">Beginning Date</label>
        <input id="begDate" class="form-control" type="date" name="begDate">
      </div>
      <div class="form-group">
        <label for="endDate">Ending Date</label>
        <input id="endDate" class="form-control" type="date" name="endDate">
      </div>
      <div class="form-group">
        <button type="submit" class="btn btn-primary" name="getNotes" value="1">Get Notes</button>
      </div>
    </form>

    <!-- Messages/Table appear here -->
    <div class="mt-3">
      <?php echo $notes; ?>
    </div>
  </div>
</body>
</html>
