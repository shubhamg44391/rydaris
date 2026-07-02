<?php
$viewsDir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$files = [];
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php' && strpos($file->getFilename(), 'index.blade.php') !== false) {
        $files[] = $file->getPathname();
    }
}

foreach ($files as $filePath) {
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Remove <strong> and </strong>
    $content = str_replace(['<strong>', '</strong>'], '', $content);
    
    if ($content !== $originalContent) {
        file_put_contents($filePath, $content);
        echo "Updated: " . $filePath . "\n";
    }
}
