<?php
$viewsDir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$files = [];
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $files[] = $file->getPathname();
    }
}

foreach ($files as $filePath) {
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Replace the exact style string found in select elements
    $search = 'style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem; min-height: 48px;"';
    $content = str_replace($search, '', $content);
    
    // Also add form-input-custom to form-select just in case
    if ($content !== $originalContent) {
        $content = str_replace('class="form-select', 'class="form-select form-input-custom', $content);
        $content = str_replace('form-input-custom form-input-custom', 'form-input-custom', $content);
        
        file_put_contents($filePath, $content);
        echo "Updated: " . $filePath . "\n";
    }
}
