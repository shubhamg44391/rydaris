<?php
$file = 'resources/views/vendor/extras/features.blade.php';
$content = file_get_contents($file);

$replacements = [
    '/--surface:\s*#ffffff;/i' => '--surface: var(--bg-2);',
    '/--text-main:\s*#0f172a;/i' => '--text-main: var(--text);',
    '/--text-muted:\s*#64748b;/i' => '--text-muted: var(--muted-2, #94a3b8);',
    '/--border-color:\s*#e2e8f0;/i' => '--border-color: var(--line);',
    '/background:\s*#ffffff;/i' => 'background: var(--bg-2);',
    '/background:\s*#fee2e2;/i' => 'background: rgba(239, 68, 68, 0.1);',
    '/background:\s*#f1f5f9;/i' => 'background: var(--bg);',
    '/background:\s*#e2e8f0;/i' => 'background: var(--line);',
    '/border-color:\s*#94a3b8;/i' => 'border-color: var(--line);',
    '/border:\s*1px\s*dashed\s*#cbd5e1;/i' => 'border: 1px dashed var(--line);',
    '/color:\s*#111827;/i' => 'color: var(--text);',
    '/color:\s*#94a3b8;/i' => 'color: var(--text);',
    '/background:\s*#ecfdf5;/i' => 'background: rgba(16, 185, 129, 0.1);',
    '/border:\s*1px\s*solid\s*#a7f3d0;/i' => 'border: 1px solid rgba(16, 185, 129, 0.2);'
];

foreach ($replacements as $pattern => $replacement) {
    $content = preg_replace($pattern, $replacement, $content);
}

file_put_contents($file, $content);
echo "Replaced successfully.\n";
