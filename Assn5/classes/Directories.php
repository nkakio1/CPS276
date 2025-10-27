<?php
class Directories {
    public function createDirectoryAndFile($folderName, $fileContent) {
        $baseDir = __DIR__ . '/../directories';
        $targetDir = $baseDir . '/' . $folderName;

        if (is_dir($targetDir)) {
            return [
                'success' => false,
                'message' => 'A directory already exists with that name.'
            ];
        }

        if (!mkdir($targetDir, 0777, true)) {
            return [
                'success' => false,
                'message' => 'Error: Could not create directory.'
            ];
        }

        $filePath = $targetDir . '/readme.txt';
        if (file_put_contents($filePath, $fileContent) === false) {
            return [
                'success' => false,
                'message' => 'Error: Could not create file.'
            ];
        }

        $relativePath = 'directories/' . $folderName . '/readme.txt';
        return [
            'success' => true,
            'message' => 'File and directory were created successfully.',
            'link' => $relativePath
        ];
    }
}


/*
 * Explain the difference between creating a directory and creating a file in PHP. What PHP functions are used for each operation, 
 * and why is it important to check if a directory already exists before attempting to create it?
 * 
 * -mkdir($path, $mode = 0755, $recursive = false),    creates a directory
 * -file_put_contents($filename, $data),               creates a file and writes data to it
 * -avoid overwriting
 * -errors like if it already exists
 * -
 * 
 * 
 * Describe the flow of data from an HTML form submission to PHP processing. How does PHP access form data,
 * and what considerations should developers keep in mind when handling user input from forms?
 * 
 * -the user will input data to the form
 * -the form will be submitted to the server
 * -php will access the data using the $_POST or $_GET 
 * -considerations: validate input, ensure saftey in input, input size limits, project scope
 * 

Why is it important to properly close file handles after writing to files?
 What problems can occur if file handles are not closed, and how does this relate to system resource management?

 -closing file handles frees up system resources
 -if not closed, it can lead to memory leaks, file corruption, and data loss
 -If you open files with fopen() you must fclose($handle) after fwrite().
-accessing files with file_put_contents() automatically handles closing the file for you.
 * -if it is locked while open, other processes may not be able to access it flock()
 * 
 * 
 *

Why did we use 777 permissions and what should we use and why.
we should use 0755 for directories, and 0644 for files.
777 gives read, write, and execute permissions to everyone, which is a security risk.


Explain the benefits of organizing file and directory operations into a class structure. How does this approach improve code organization, 
reusability, and maintainability compared to writing all operations in procedural code?

    -modular code
    -easier to read
    -easier to maintain
    -reusable
    -seperation of concerns
    -testing
    */
?>
