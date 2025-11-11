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
    $end = isset($_POST['endDate']) ? trim($_POST['endDate']) : '';        //q3 reader, validation if

    if ($beg === '' || $end === '') {
      return $this->message('No notes found for the date range selected.');
    }

    $begTs = strtotime($beg . ' 00:00:00');
    $endTs = strtotime($end . ' 23:59:59');                                 //q3 day length set

    if ($begTs === false || $endTs === false) {
      return $this->message('No notes found for the date range selected.'); //q3 validation
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






q1:Why are we using timestamps instead of the date.

theres a few reasons we might want to use timestamps instead of date strings in our database:
- Consistency: Timestamps provide a consistent format for storing date and time information, 
regardless of the timezone or locale. This helps avoid confusion when dealing with dates from 
different regions.

- Efficiency: Storing dates as integers (timestamps) can be more efficient in terms of storage
 and performance compared to storing them as strings. Integer comparisons are generally faster 
 than string comparisons.

- Easier calculations: Timestamps make it easier to perform date and time calculations,
 such as finding the difference between two dates, adding or subtracting time intervals,
  and sorting dates.





q2: Is there any advantage to using the Date_time class over just having a PHP function file.  What are they?

1. **Encapsulation**: The Date_time class encapsulates all date and 
time-related functionality in one place, making it easier to manage and maintain. 
If you need to change how dates are handled, you only need to update the class rather 
than searching through multiple function files.

2. **Reusability**: By using a class, you can create multiple instances
 of Date_time with different properties or methods, promoting code reuse. 
 This is more challenging with standalone functions.

3. **Organization**: A class provides a clear structure for your code, 
grouping related methods and properties together. This can make your codebase
 easier to navigate and understand.

4. **Inheritance and Polymorphism**: If you need to extend the functionality 
of the Date_time class, you can use inheritance to create subclasses with additional 
features. This is not possible with standalone functions.

5. **State Management**: A class can maintain state (e.g., a specific date and time)
 across multiple method calls, while standalone functions are stateless and require all
  data to be passed in as parameters.



q3: When a user requests to view notes within a specific date range, what logical steps must
 the application take to retrieve and present only the relevant notes,
  show that in your code and explan it? 

read the input dates from the form
validate the input dates to ensure they are in the correct format
convert the input dates to timestamps
query the database for notes within the specified date range
display the retrieved notes to the user





q4:
 Explain the importance of converting dates and times into a standardized format 
 (like a timestamp) before storing them in a database. What problems might arise if you don't?

Converting dates and times into a standardized format like a timestamp
 before storing them in a database is crucial for several reasons:
1. Consistency: A standardized format ensures that all date and time values are stored uniformly.
 This consistency is essential for accurate data retrieval, comparison, and manipulation.   
2. Timezone Handling: Timestamps are typically stored in UTC, which helps avoid issues related to
 timezones. If dates are stored in local time without standardization, it can lead to confusion
    when users from different timezones access the data.

3. Simplified Queries: Standardized date formats make it easier to write SQL queries for filtering,
    sorting, and aggregating data based on date and time.

4. Avoiding Ambiguity: Different date formats (e.g., MM/DD/YYYY vs. DD/MM/YYYY) can lead to
 misinterpretation of dates. A standardized format eliminates this ambiguity.

If dates and times are not converted to a standardized format before storage, several problems may arise:
- Inconsistent Data: Different formats can lead to inconsistent data entries,
 making it difficult to perform accurate queries and analyses.
- Query Errors: SQL queries may fail or return incorrect results if the date formats are not uniform






q5:Imagine the application becomes very popular and has millions of notes. 
What performance considerations might arise when displaying notes, and how could you address them?

Without an index, MySQL has to scan the entire table every time it looks for notes in a date range. so
Add an index on the date_time field.

Even if the query runs fast, returning all results can overload your server and browser.
If you show a lot of notes at once, it freezes the browser.
Use read replicas (multiple database servers) to share query load.
Use load balancers to distribute web traffic evenly across servers.
eg 
SELECT date_time, note 
FROM note
WHERE date_time BETWEEN :beg AND :end
ORDER BY date_time DESC
LIMIT 50 OFFSET 0;


As more users query overlapping date ranges, MySQL might repeat work.
Use query caching (MySQL’s or your application’s).
Avoid unnecessary conversions in SQL 
convert timestamps in PHP instead of the database.

Repeated queries for the same date range waste resources.
Use caching systems like PHP sessions to temporarily store frequent results.




*/





?>
