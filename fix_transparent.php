<?php
$file = 'resources/views/vendor/availability/index.blade.php';
$content = file_get_contents($file);

// Replace transparent var(--panel) background with solid var(--bg-2) for modal content
$content = str_replace('background: var(--panel) !important;', 'background: var(--bg-2) !important;', $content);
$content = str_replace('background: rgba(15, 23, 42, 0.6);', 'background: rgba(0, 0, 0, 0.75);', $content); // Darker backdrop

// Fix any other remaining issues
$content = preg_replace('/color:\s*#94a3b8/i', 'color: var(--muted-2)', $content);

file_put_contents($file, $content);
