<?php
$directory = new RecursiveDirectoryIterator('resources/views');
$iterator = new RecursiveIteratorIterator($directory);

foreach ($iterator as $info) {
    if ($info->isFile() && $info->getExtension() === 'php') {
        $file = $info->getPathname();
        $content = file_get_contents($file);
        
        $newContent = preg_replace('/(<select[^>]*style="[^"]*)(background(?:-color)?:\s*#ffffff;?)([^"]*")/i', '$1$3', $content);
        $newContent = preg_replace('/(<select[^>]*style="[^"]*)(border:\s*1px\s*solid\s*#[a-f0-9]{6};?)([^"]*")/i', '$1$3', $content);
        
        if ($newContent !== $content) {
            file_put_contents($file, $newContent);
            echo "Cleaned styles in $file\n";
        }
    }
}
