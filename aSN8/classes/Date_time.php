<?php
require_once '/home/n/a/nakio/public_html/cps276/aSN8/classes/Pdo_methods.php';

/**
 * Date_time
 * Handles Add Note and Display Notes workflows.
 */
class Date_time {

  public function checkSubmit() {
    if (isset($_POST['addNote'])) {
      return $this->handleAdd();
    } else if (isset($_POST['getNotes'])) {
      return $this->handleGet();
    }
    return '';
  }

  private function handleAdd() {
    $dateTime = isset($_POST['dateTime']) ? trim($_POST['dateTime']) : '';
    $note     = isset($_POST['note']) ? trim($_POST['note']) : '';

    if ($dateTime === '' || $note === '') {
      return $this->message('You must enter a date, time, and note.');
    }

    $timestamp = strtotime($dateTime);
    if ($timestamp === false) {
      return $this->message('Invalid date/time format.');
    }

    $pdo = new PdoMethods();
    $sql = "INSERT INTO note (date_time, note) VALUES (:ts, :note)";
    $params = [
      [':ts', $timestamp, PDO::PARAM_INT],
      [':note', $note, PDO::PARAM_STR],
    ];

    try {
      $count = $pdo->otherBinded($sql, $params);
      if ($count > 0) {
        return $this->message('Note added.');
      } else {
        return $this->message('There was a problem adding the note.');
      }
    } catch (Exception $e) {
      return $this->message('Database error: ' . htmlspecialchars($e->getMessage()));
    }
  }

  private function handleGet() {
    $beg = isset($_POST['begDate']) ? trim($_POST['begDate']) : '';
    $end = isset($_POST['endDate']) ? trim($_POST['endDate']) : '';

    if ($beg === '' || $end === '') {
      return $this->message('No notes found for the date range selected.');
    }

    $begTs = strtotime($beg . ' 00:00:00');
    $endTs = strtotime($end . ' 23:59:59');

    if ($begTs === false || $endTs === false) {
      return $this->message('No notes found for the date range selected.');
    }

    $pdo = new PdoMethods();
    $sql = "SELECT date_time, note FROM note 
            WHERE date_time BETWEEN :beg AND :end 
            ORDER BY date_time DESC";
    $params = [
      [':beg', $begTs, PDO::PARAM_INT],
      [':end', $endTs, PDO::PARAM_INT],
    ];

    try {
      $result = $pdo->select($sql, $params);
      if (!$result || count($result) === 0) {
        return $this->message('No notes found for the date range selected.');
      }

      $html = '<div class="table-responsive"><table class="table table-striped">';
      $html .= '<thead><tr><th>Date and Time</th><th>Note</th></tr></thead><tbody>';
      foreach ($result as $r) {
        $html .= '<tr><td>' . htmlspecialchars(date('m/d/Y h:i a', (int)$r['date_time'])) .
                 '</td><td>' . nl2br(htmlspecialchars($r['note'])) . '</td></tr>';
      }
      $html .= '</tbody></table></div>';
      return $html;
    } catch (Exception $e) {
      return $this->message('Database error: ' . htmlspecialchars($e->getMessage()));
    }
  }

  /** Unified plain text message output */
  private function message($msg) {
    return '<p style="margin-top:10px; margin-bottom:10px;">' . htmlspecialchars($msg) . '</p>';
  }
}



/*
PROJECT CHECKLIST – ADD & DISPLAY NOTES (PHP)

1. FILES

aSN8/
  classes/Date_time.php
  classes/Db_conn.php
  classes/Pdo_methods.php
index.php
display_notes.php

2. DATABASE

CREATE TABLE note (
  note_id INT AUTO_INCREMENT PRIMARY KEY,
  date_time INT NOT NULL,
  note TEXT NOT NULL
);

4. PDO_METHODS.PHP

- Extends Db_conn.
- Provides reusable methods for common PDO operations (CRUD).
-add for this project

5. DATE_TIME.PHP

- Handles add & display logic.
- Converts datetime to timestamp and back.
- Returns plain text messages (no Bootstrap alerts).
- Builds compact bordered table for notes.

6. INDEX.PHP

-add php to html provided

7. DISPLAY_NOTES.PHP

-add php to html provided

CONCEPTS NEEDED – ADD & DISPLAY NOTES PROJECT

1. PHP Basics
2. Using classes, methods, and require/include
3. Handling HTML forms with POST 
4. Server-side validation 
5. Working with PDO for database access
6. Creating and using prepared statements
7. Binding parameters (bindValue / bindParam)
8. Executing SQL SELECT and INSERT queries
9. Converting dates with strtotime() and date()
10. Displaying data in HTML tables
11. Basic Bootstrap styling for layout
12. Handling and displaying simple messages
13. Managing file paths and includes
14. Debugging PHP errors and exceptions
*/

?>
