<?php

return [
    'Admin' => [
        'name'         => 'Admin' ,
        'description'  => 'Admin Module' ,
        'status'       => true ,
        'services'     => [
            'provider' => 'Modules\\Admin\\AdminServiceProvider' ,
            'lang'     => [
                'path' => 'Modules/Admin/lang' ,
                'name' => 'Admin' ,
            ] ,
        ] ,
        'view'         => [
            'path' => 'Modules/Admin/resources/views' ,
        ] ,
        'dependencies' => [] ,
    ] ,
    'Category' => [
        'name'         => 'Category' ,
        'description'  => 'Category Module' ,
        'status'       => true ,
        'services'     => [
            'provider' => 'Modules\\Category\\CategoryServiceProvider' ,
            'lang'     => [
                'path' => 'Modules/Category/lang' ,
                'name' => 'Category' ,
            ] ,
        ] ,
        'view'         => [
            'path' => 'Modules/Category/resources/views' ,
        ] ,
        'dependencies' => [
            'Admin' ,
        ] ,
    ] ,
    'Article' => [
        'name'         => 'Article' ,
        'description'  => 'Article Module' ,
        'status'       => true ,
        'services'     => [
            'provider' => 'Modules\\Article\\ArticleServiceProvider' ,
            'lang'     => [
                'path' => 'Modules/Article/lang' ,
                'name' => 'Category' ,
            ] ,
        ] ,
        'view'         => [
            'path' => 'Modules/Article/resources/views' ,
        ] ,
        'dependencies' => [
            'Admin' ,
            'Article' ,
        ] ,
    ] ,
];
