<?php
$CLASS_DIR = realpath(__DIR__ . '/../../classes');
require_once $CLASS_DIR . '/Db_conn.php';
require_once $CLASS_DIR . '/Pdo_methods.php';

$pdo = new PdoMethods();
$rows = $pdo->selectNotBinded("SELECT file_name, file_path FROM uploaded_files ORDER BY id DESC");

$listHtml = "<ul>";
if (is_array($rows) && count($rows) > 0) {
  foreach ($rows as $row) {
    $name = trim((string)($row['file_name'] ?? ''));
    if ($name === '') continue;
    $base = basename((string)($row['file_path'] ?? ''));
    $href = 'files/' . $base;
    $listHtml .= '<li><a target="_blank" href="'.htmlspecialchars($href).'">'.htmlspecialchars($name).'</a></li>';
  }
}
$listHtml .= "</ul>";
/*



    Explain why were are using the DB_conn class
    
The Db_conn class creates and manages the database connection using PDO. 
It keeps connection details in one place, making the code cleaner, reusable, and easier to maintain.



    Explain why we are using the Pdo_methods class

The Pdo_methods class provides simple, reusable methods for running SQL queries. It handles binding,
 execution, and error checking, reducing duplicate code and keeping database operations consistent and secure.




    Why are we storing the PDF files on the web server and not in the database

Storing files on the web server is more efficient for large files like PDFs. 
Databases are optimized for structured data, not large binary files. 
Keeping files on the server reduces database size and improves performance.



    The PdoMethods class extends DatabaseConn. Explain the benefits of this 
    inheritance structure and how it promotes code reusability and separation of concerns.

    PdoMethods can use the same connection setup without rewriting it, promoting code reusability. 
    It also supports separation of concerns — DatabaseConn handles 
    the connection details, while PdoMethods focuses on executing queries. 
    This keeps each class focused on one task, making the code cleaner, easier to maintain, and more modular.




    In the fileUploadProc.php, the code uses prepared statements with bindings. 
    Explain how this approach prevents SQL injection attacks and why it's considered a security best practice.

Using prepared statements with bindings prevents SQL injection by separating SQL code from user input. 
Instead of directly inserting user data into the query, placeholders are used, and the values are bound safely
 before execution. This ensures any malicious input is treated as plain text, not as executable SQL.
  It’s a security best practice 
because it protects the database from unauthorized access, data manipulation, and other injection-based attacks.
*/
?>