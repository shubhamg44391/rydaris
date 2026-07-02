<?php
$files = [
    'resources/views/vendor/extras/create.blade.php',
    'resources/views/vendor/extras/edit.blade.php'
];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    if (strpos($content, 'select2.min.css') === false) {
        $content = str_replace(
            "@section('main-content')", 
            "@section('main-content')\n<link href=\"https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css\" rel=\"stylesheet\" />", 
            $content
        );
        
        $content = str_replace(
            "<script>\nfunction fcIconPrev()", 
            "<script src=\"https://code.jquery.com/jquery-3.7.1.min.js\"></script>\n<script src=\"https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js\"></script>\n<script>\nfunction fcIconPrev()", 
            $content
        );
        
        file_put_contents($file, $content);
        echo "Updated $file\n";
    }
}
