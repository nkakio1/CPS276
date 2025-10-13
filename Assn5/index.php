<?php
require_once __DIR__ . '/classes/Directories.php';

$dirs = new Directories(__DIR__ . '/directories', 'directories');

$notice = '';
$error  = '';
$link   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $folder  = $_POST['folder']  ?? '';
    $content = $_POST['content'] ?? '';

    if ($dirs->error) {
        $error = $dirs->error;
    } else {
        if ($dirs->create($folder, $content)) {
            $notice = 'File and directory were created.';
            $link   = $dirs->webFileHref();
        } else {
            $error = $dirs->error;
        }
    }
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>File and Directory Assignment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>.form-note{color:#6c757d}</style>
</head>
<body class="bg-light">
  <div class="container py-4">

    <!-- Header -->
    <div class="row mb-3">
      <div class="col-12">
        <h1 class="h3 mb-0">File and Directory Assignment</h1>
        <p class="form-note mb-0">Enter a folder name and the contents of a file. Folder names should contain alphabetic characters only.</p>
      </div>
    </div>

    <!-- Error Banner -->
    <?php if ($error): ?>
      <div class="alert alert-warning d-flex align-items-center" role="alert">
        <div class="fw-semibold me-2">Directory Name Already Exists</div>
        <div><?= htmlspecialchars($error) ?></div>
      </div>
    <?php endif; ?>

    <!-- Success Banner -->
    <?php if ($notice): ?>
      <div class="alert alert-success" role="alert">
        <div class="fw-semibold">Directory Created and Link Shown</div>
        <div class="mt-1"><?= htmlspecialchars($notice) ?></div>
        <?php if ($link): ?>
          <div class="mt-2">
            <a class="link-primary" href="<?= htmlspecialchars($link) ?>" target="_blank" rel="noopener">
              Path where file is located
            </a>
          </div>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <!-- Card with Form -->
    <div class="card shadow-sm">
      <div class="card-body">
        <form method="post" novalidate>
          <div class="mb-3">
            <label for="folder" class="form-label">Folder Name</label>
            <input
              type="text"
              class="form-control"
              id="folder"
              name="folder"
              value="<?= isset($_POST['folder']) ? htmlspecialchars($_POST['folder']) : '' ?>"
              required
              aria-describedby="folderHelp"
            >
            <div id="folderHelp" class="form-text">Letters only; no spaces or special characters.</div>
          </div>

          <div class="mb-3">
            <label for="content" class="form-label">File Content</label>
            <textarea
              class="form-control"
              id="content"
              name="content"
              rows="8"
              required
            ><?= isset($_POST['content']) ? htmlspecialchars($_POST['content']) : '' ?></textarea>
          </div>

          <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>

  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
