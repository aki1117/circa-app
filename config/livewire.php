<?php

return [
    'temporary_file_upload' => [
        'disk' => 'local',
        'rules' => 'required|max:102400', // 100MB max
        'directory' => 'livewire-tmp',
        'middleware' => null,
        'preview_mimes' => [
            'png', 'gif', 'bmp', 'svg', 'wav', 'mp4',
            'mov', 'avi', 'wmv', 'mp3', 'm4a',
            'jpg', 'jpeg', 'mpga', 'webp', 'wma',
        ],
        'max_upload_time' => 5,
    ],
    
    // This is important - disable asset injection if using Filament
    'inject_assets' => false,
    
    'middleware_group' => 'web',
];