<?php

return [
    'route_prefix' => 'admin/blog',
    'frontend_prefix' => 'blog',
    'frontend' => [
        'posts_per_page'    => 10,
    ],
    'ckeditor' => [
        'path'              => 'https://cdn.ckeditor.com/4.7.3/standard-all/ckeditor.js',
        'custom_config'     => '/vendor/cupplisser/blog/public/js/ckeditor_config.js',
        'file_browser_url'  => 'images?laravel-blog-embed=true',
        'image_upload_url'  => 'images/dialog-upload',
    ],
];