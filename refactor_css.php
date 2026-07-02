<?php
$viewsDir = __DIR__ . '/resources/views';
$iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($viewsDir));
$files = [];
foreach ($iterator as $file) {
    if ($file->isFile() && $file->getExtension() === 'php') {
        $files[] = $file->getPathname();
    }
}

$replacements = [
    'style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block;"' => 'class="form-label-custom"',
    'style="text-transform: uppercase; font-size: 0.75rem; color: #64748b; font-weight: 800; letter-spacing: 0.05em; margin-bottom: 8px; display: block"' => 'class="form-label-custom"',
    'style="font-size: 1.4rem; color: #111827; margin: 0;"' => 'class="panel-title"',
    'class="btn btn-primary rounded-pill px-4" style="min-height: 40px; font-weight: 800; font-size: 0.9rem;"' => 'class="btn btn-primary rounded-pill px-4 action-btn"',
    'class="btn btn-link text-muted" style="text-decoration: none; font-weight: 800; font-size: 0.9rem;"' => 'class="btn btn-link text-muted cancel-link"',
    'style="border: 1px solid #d7e0e8; border-radius: var(--radius); padding: 12px; font-size: 0.95rem;"' => '',
];

foreach ($files as $filePath) {
    $content = file_get_contents($filePath);
    $originalContent = $content;
    
    // Simple string replacements
    foreach ($replacements as $search => $replace) {
        $content = str_replace($search, $replace, $content);
    }
    
    if ($content !== $originalContent) {
        $content = str_replace('class="form-control', 'class="form-control form-input-custom', $content);
        $content = str_replace('form-input-custom form-input-custom', 'form-input-custom', $content);
        
        file_put_contents($filePath, $content);
        echo "Updated: " . $filePath . "\n";
    }
}
