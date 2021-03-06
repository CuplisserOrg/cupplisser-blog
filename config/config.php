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
    'table'=>[
        'posts'=> 'blog_posts',
        'categories'=> 'blog_categories',
        'tags'=> 'blog_tags',
        'comments'=> 'blog_comments'
    ],
    'posts' =>[
        'per_page' => 10,
    ],
    'users'=>[
        "table" => "users",
    ],
    'views_path'=> 'admin-blog::',
    "assets" => array(
        "js"=> array(
            asset("js/app.js"),
            asset("js/jquery.min.js"),
            asset("libs/sweetalert2/sweetalert2.all.min.js"),
            asset("js/dashboard.js")

        )
    )
];
