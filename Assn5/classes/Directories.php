<?php
/**
 * Class Directories
 *  - Creates a subdirectory in /directories
 *  - Writes readme.txt with provided content
 *  - Exposes state for UI messages and link to the created file
 */
class Directories
{
    private string $baseFs;   // filesystem absolute path to /directories
    private string $baseWeb;  // web-relative path to /directories

    public string $error = '';
    public string $lastFolder = '';
    public string $lastFileFs = '';

    public function __construct(string $baseFs, string $baseWeb = 'directories')
    {
        $this->baseFs  = rtrim($baseFs, DIRECTORY_SEPARATOR);
        $this->baseWeb = trim($baseWeb, '/');

        if (!is_dir($this->baseFs)) {
            $this->error = 'Base "directories" folder is missing. Please create it first.';
        }
    }

    /**
     * Create the folder and file.
     * Returns true on success, false on failure (with $error set).
     */
    public function create(string $folderName, string $content): bool
    {
        // We’ll sanitize to letters-only to enforce the assignment rules.
        $clean = preg_replace('/[^a-zA-Z]/', '', $folderName ?? '');
        if ($clean === '') {
            $this->error = 'Folder names must contain alphabetic characters only.';
            return false;
        }

        $this->lastFolder = $clean;
        $targetDir = $this->baseFs . DIRECTORY_SEPARATOR . $clean;

        // If already exists, show the required message.
        if (is_dir($targetDir)) {
            $this->error = 'A directory already exists with that name.';
            return false;
        }

        // Try to create the directory.
        if (!@mkdir($targetDir, 0775, true)) {
            $this->error = 'Error: could not create the directory.';
            return false;
        }

        // Create readme.txt with the provided content.
        $this->lastFileFs = $targetDir . DIRECTORY_SEPARATOR . 'readme.txt';
        if (@file_put_contents($this->lastFileFs, $content) === false) {
            $this->error = 'Error: directory created, but file could not be written.';
            return false;
        }

        return true;
    }

    /**
     * Returns the web path to the created readme.txt (for the success link).
     * Example: directories/MyFolder/readme.txt
     */
    public function webFileHref(): string
    {
        if ($this->lastFolder === '') return '';
        return $this->baseWeb . '/' . rawurlencode($this->lastFolder) . '/readme.txt';
    }
}
