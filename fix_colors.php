<?php
$file = 'resources/views/vendor/availability/index.blade.php';
$content = file_get_contents($file);

// Replace hardcoded light-theme colors with dark-theme CSS variables
$replacements = [
    '/background\s*:\s*#fff(?:fff)?/i' => 'background: var(--bg-2)',
    '/background-color\s*:\s*#fff(?:fff)?/i' => 'background-color: var(--bg-2)',
    '/background\s*:\s*white/i' => 'background: var(--bg-2)',
    '/color\s*:\s*#1e293b/i' => 'color: var(--text)',
    '/color\s*:\s*#475569/i' => 'color: var(--text)',
    '/color\s*:\s*#334155/i' => 'color: var(--text)',
    '/color\s*:\s*#0f172a/i' => 'color: var(--text)',
    '/color\s*:\s*#64748b/i' => 'color: var(--muted-2, #a1a1aa)',
    '/border\s*:\s*1px\s*solid\s*#e2e8f0/i' => 'border: 1px solid var(--line)',
    '/border-bottom\s*:\s*1px\s*solid\s*#e2e8f0/i' => 'border-bottom: 1px solid var(--line)',
    '/border-top\s*:\s*1px\s*solid\s*#e2e8f0/i' => 'border-top: 1px solid var(--line)',
    '/border\s*:\s*1px\s*solid\s*#cbd5e1/i' => 'border: 1px solid var(--line)',
    '/background\s*:\s*#fefce8/i' => 'background: rgba(250, 204, 21, 0.1)', // yellow alert bg
    '/color\s*:\s*#854d0e/i' => 'color: #facc15', // yellow alert text
    '/border\s*:\s*1px\s*solid\s*#fef08a/i' => 'border: 1px solid rgba(250, 204, 21, 0.2)', // yellow alert border
    '/background\s*:\s*#f8fafc/i' => 'background: var(--bg)',
    '/background\s*:\s*#f1f5f9/i' => 'background: var(--bg)',
    '/background\s*:\s*linear-gradient\(to\s*right,\s*#f8fafc,\s*#f1f5f9\)/i' => 'background: var(--bg)',
    '/box-shadow\s*:\s*inset\s*0\s*2px\s*4px\s*rgba\(0,0,0,0.02\)/i' => 'box-shadow: none',
    '/color\s*:\s*#2563eb/i' => 'color: var(--brand)',
];

foreach ($replacements as $pattern => $replacement) {
    $content = preg_replace($pattern, $replacement, $content);
}

// Fix modal content background explicitly
$content = preg_replace('/class="modal-content"\s*style="([^"]*)"/i', 'class="modal-content" style="$1; background: var(--panel) !important;"', $content);

file_put_contents($file, $content);
echo "Replaced colors successfully.\n";
