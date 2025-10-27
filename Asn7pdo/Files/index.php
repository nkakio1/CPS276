
<?php require_once __DIR__ . '/php/fileUploadProc.php'; ?>
<!DOCTYPE html>
<html lang="en"><head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    <title>File Upload</title>
  </head>
  <body>
    
    <div class="container">
        <h1>File Upload</h1>
        <p><a href="listFiles.php">Show File List</a></p>
        <div class="form-group">
          <label for="fileName">File Name</label>
          <div class="plain-msg"><?php echo isset($output) ? htmlspecialchars($output) : ''; ?></div>
        <form method="post" action="index.php" enctype="multipart/form-data">

          <input type="text" class="form-control" id="fileName" name="fileName">
        </div>
        <div class="form-group">
          <input type="file" name="file">
        </div>
        <button type="submit" name="fileUpload" class="btn btn-primary">Upload File</button>
      </form>
    </div>

  </body>
</html>
