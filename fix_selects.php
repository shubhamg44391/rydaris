<?php
$directory = new RecursiveDirectoryIterator('resources/views');
$iterator = new RecursiveIteratorIterator($directory);

foreach ($iterator as $info) {
    if ($info->isFile() && $info->getExtension() === 'php') {
        $file = $info->getPathname();
        $content = file_get_contents($file);
        
        $newContent = preg_replace_callback('/<select\s+([^>]*)class="([^"]*)"([^>]*)>/i', function($matches) {
            $classes = $matches[2];
            // Replace form-control with form-select if it exists
            $classes = preg_replace('/\bform-control\b/', 'form-select', $classes);
            // Ensure form-select is present if neither form-control nor form-select is present
            if (strpos($classes, 'form-select') === false) {
                $classes .= ' form-select';
            }
            return '<select ' . $matches[1] . 'class="' . trim($classes) . '"' . $matches[3] . '>';
        }, $content);
        
        if ($newContent !== $content) {
            file_put_contents($file, $newContent);
            echo "Updated $file\n";
        }
    }
}
