<?php
require_once 'classes/Directories.php';

$result = null;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $folderName = $_POST['folderName'] ?? '';
    $fileContent = $_POST['fileContent'] ?? '';

    $dirHandler = new Directories();
    $result = $dirHandler->createDirectoryAndFile($folderName, $fileContent);
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
  <title>Assignment 5</title>
</head>
<body>
  <div class="container mt-4">
    <h1>Assignment 5</h1>

    <?php if ($result): ?>
      <p class="mt-2">
        <?php echo htmlspecialchars($result['message']); ?>
      </p>

      <?php if (!empty($result['link'])): ?>
        <p>
          <a href="<?php echo htmlspecialchars($result['link']); ?>" target="_blank">
            Path where file is located
          </a>
        </p>
      <?php endif; ?>
    <?php endif; ?>

    <p>Enter a folder name and the contents of a file. Folder names should contain alphanumeric characters only.</p>

    <form method="post" action="index.php">
      <div class="form-group">
        <label for="folderName">Folder Name</label>
        <input type="text" class="form-control" id="folderName" name="folderName" required>
      </div>

      <div class="form-group">
        <label for="fileContent">File Content</label>
        <textarea class="form-control" id="fileContent" name="fileContent" rows="5"></textarea>
      </div>

      <button type="submit" class="btn btn-primary">Submit</button>
    </form>
  </div>
</body>
</html>
