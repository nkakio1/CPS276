<?php require_once __DIR__ . '/classes/Date_time.php';
$dt = new Date_time();
$notes = $dt->checkSubmit();?>
<!DOCTYPE html>
<html lang="en"><head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Note</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
    textarea {
      width: 200px;
      height: 400px;
    }
  </style>
  </head>
  <body>
      
      <div class="container">
        <h1>Add Note</h1>
        <p><a href="display_notes.php">Display Notes</a></p>
         <div id="messages"><?php echo $notes; ?></div>
        <form action="index.php" method="post">
        
        
        <div class="form-group">
          <label for="dateTime">Date and Time</label>
          <input type="datetime-local" class="form-control" id="dateTime" name="dateTime">
        </div>
        <div class="form-group">
          <label for="note">Note</label>
          <textarea name="note" class="form-control"></textarea>
        </div>
        <div class="form-group">
          <input type="submit" name="addNote" class="btn btn-primary" value="Add Note">
        </div>
      </form>
    </div>
  
</body></html>