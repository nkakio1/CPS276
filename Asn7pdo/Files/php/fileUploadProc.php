<?php
$CLASS_DIR = realpath(__DIR__ . '/../../classes');
require_once $CLASS_DIR . '/Db_conn.php';
require_once $CLASS_DIR . '/Pdo_methods.php';

$output = "";

if (isset($_POST['fileUpload'])) {
  $displayName = trim($_POST['fileName'] ?? '');
  if ($displayName === "") $output = "Please enter a file name.";
  elseif (!isset($_FILES['file']) || $_FILES['file']['error'] !== UPLOAD_ERR_OK) $output = "Please choose a PDF file to upload.";
  else {
    $tmp = $_FILES['file']['tmp_name'];
    $size = (int)($_FILES['file']['size'] ?? 0);
    if ($size <= 0 || $size > 1000000) $output = "The file must be less than 1,000,000 bytes.";
    else {
      $finfo = finfo_open(FILEINFO_MIME_TYPE);
      $mime = finfo_file($finfo, $tmp);
      finfo_close($finfo);
      if ($mime !== 'application/pdf') $output = "Only PDF files are allowed.";
      else {
        $destFolder = dirname(__DIR__) . '/files';
        if (!is_dir($destFolder) || !is_writable($destFolder)) $output = "Upload folder not writable.";
        else {
          $unique = uniqid('pdf_', true) . '.pdf';
          $dest = $destFolder . '/' . $unique;
          if (move_uploaded_file($tmp, $dest)) {
            $publicPath = 'files/' . $unique;
            $pdo = new PdoMethods();
            $sql = "INSERT INTO uploaded_files (file_name, file_path) VALUES (:n,:p)";
            $res = $pdo->otherBinded($sql, [
              [':n', $displayName, 'str'],
              [':p', $publicPath,  'str']
            ]);
            if ($res === 'noerror') $output = "File uploaded successfully.";
            else { @unlink($dest); $output = "Database error."; }
          } else $output = "File could not be saved.";
        }
      }
    }
  }
}

?>
