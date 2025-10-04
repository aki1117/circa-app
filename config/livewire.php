<?php

return [
    'temporary_file_upload' => [
        'disk' => null, // Use default disk
        'rules' => null, // Validation rules
        'directory' => null,
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5, // In minutes
    ],
    
    'manifest_path' => null,
    
    'back_button_cache' => false,
    
    'render_on_redirect' => false,
];