<?php
class Directories {
    public function createDirectoryAndFile($folderName, $fileContent) {
        $baseDir = __DIR__ . '/../directories';
        $targetDir = $baseDir . '/' . $folderName;

        // Check if directory already exists
        if (is_dir($targetDir)) {
            return [
                'success' => false,
                'message' => 'A directory already exists with that name.'
            ];
        }

        // Try to create directory
        if (!mkdir($targetDir, 0777, true)) {
            return [
                'success' => false,
                'message' => 'Error: Could not create directory.'
            ];
        }

        // Create readme.txt file
        $filePath = $targetDir . '/readme.txt';
        if (file_put_contents($filePath, $fileContent) === false) {
            return [
                'success' => false,
                'message' => 'Error: Could not create file.'
            ];
        }

        // Success
        $relativePath = 'directories/' . $folderName . '/readme.txt';
        return [
            'success' => true,
            'message' => 'File and directory were created successfully.',
            'link' => $relativePath
        ];
    }
}
?>
