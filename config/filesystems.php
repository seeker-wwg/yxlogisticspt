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

    'default' => 'local',

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

    'cloud' => 's3',

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
        'qiniu' => [
            'driver'  => 'qiniu',
            'domains' => [
                'default'   => 'http://pcilpjnot.bkt.clouddn.com/', //你的七牛域名
                'https'     => 'xxxxx',         //你的HTTPS域名
                'custom'    => 'xxxxx',     //你的自定义域名
            ],
            'access_key'=> '3ajVsvxYFuD5JnPbgptYoG4SBUnaQxhW1s5QYPck',  //AccessKey
            'secret_key'=> '43f4nuDWsO8z09NXtRe4PtAypYZhf3LxtYx6vEri',  //SecretKey
            'bucket'    => 'yxwuliu',  //Bucket名字
            'notify_url'=> '',  //持久化处理回调地址
        ],
//        'disks' => [
//            'qiniu' => [
//                'driver'  => 'qiniu',
//                'domains' => [
//                    'default'   => 'http://peielch2z.bkt.clouddn.com/', //你的七牛域名
//                    'https'     => 'xxxxx',         //你的HTTPS域名
//                    'custom'    => 'xxxxx',     //你的自定义域名
//                ],
//                'access_key'=> 'C0YaRvnEGUOkDz3rZH97kCUegUUFZ4O25bNMUOfc',  //AccessKey
//                'secret_key'=> 'Jrv5Ndabx6iel8ZJIxEEugju1KHXrO1FPFceGX8d',  //SecretKey
//                'bucket'    => 'yaxiangwuliu',  //Bucket名字
//                'notify_url'=> '',  //持久化处理回调地址
//            ],

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
            'key' => env('AWS_KEY'),
            'secret' => env('AWS_SECRET'),
            'region' => env('AWS_REGION'),
            'bucket' => env('AWS_BUCKET'),
        ],

    ],

];
