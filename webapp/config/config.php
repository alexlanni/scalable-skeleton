<?php

return [
    'advancedpdo' => [
        'driver' => 'mysql',
        'rw' => [
            'host'=>'datastoremaster',
            'dbname'=>'mydatabase',
            'user'=>'datastoreuser',
            'password'=>'test1234'
        ],

        'ro' => [
            [
                'host'=>'datastoreslaveA',
                'dbname'=>'mydatabase',
                'user'=>'datastoreuser',
                'password'=>'test1234'
            ]
        ]
    ]
];