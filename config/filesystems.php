<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application. Just store away!
    |
    */

    'default' => env('FILESYSTEM_DRIVER', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Default Cloud Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Many applications store files both locally and in the cloud. For this
    | reason, you may specify a default "cloud" driver here. This driver
    | will be bound as the Cloud disk implementation in the container.
    |
    */

    'cloud' => env('FILESYSTEM_CLOUD', 's3'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Here you may configure as many filesystem "disks" as you wish, and you
    | may even configure multiple disks of the same driver. Defaults have
    | been setup for each driver as an example of the required options.
    |
    | Supported Drivers: "local", "ftp", "s3", "rackspace"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app'),
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => env('APP_URL').'/storage',
            'visibility' => 'public',
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

        'admin' => [
            'driver' => 'local',
            'root' => public_path('uploads'),
            'visibility' => 'public',
            'url' => env('APP_URL').'/uploads',
        ],
        'qiniu' => [
            'driver'     => 'qiniu',
            'access_key' => env('QINIU_ACCESS_KEY', 'ju5Jhuk***********mXRl1sxUgFJL'),
            'secret_key' => env('QINIU_SECRET_KEY', 'xYF5q64***************-3CQ99cKDm0'),
            'bucket'     => env('QINIU_BUCKET', 'w****s'),
            'domain'     => env('QINIU_DOMAIN', 'http://wx1.********.com'), // or host: https://xxxx.clouddn.com
         ],
        // 'qiniu' => [
        //     'driver'  => 'qiniu',
        //     'domains' => [
        //         'https'     => 'wx1.******.com',         //你的HTTPS域名
        //         'default'   => 'wx1.*******.com', //你的七牛域名
        //         'custom'    => 'wx1.*********.com',                //你的自定义域名
        //      ],
        //     'access_key'=> 'ju5Jhuk****************Rl1sxUgFJL',  //AccessKey
        //     'secret_key'=> 'xYF5q6*****************9cKDm0',  //SecretKey
        //     'bucket'    => 'wxcms',  //Bucket名字
        //     'notify_url'=> '',  //持久化处理回调地址
        //     'url'       => 'https://wx1.wechatrank.com',  // 填写文件访问根url
        // ],
    ],

];
