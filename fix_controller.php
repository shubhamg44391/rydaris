<?php
$file = 'app/Http/Controllers/Vendor/ExtrasController.php';
$content = file_get_contents($file);

$content = str_replace("'group_id' => 'nullable|exists:groups,id',", "'group_ids' => 'nullable|array',\n            'group_ids.*' => 'exists:groups,id',", $content);

file_put_contents($file, $content);
echo "Updated controller validation.\n";
