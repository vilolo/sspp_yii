<?php
return [
    [
        'class' => 'yii\rest\UrlRule',
        'controller' => ['v1/demo'],
        'extraPatterns' => [
            'GET bbb' => 'index',
        ],
    ]
];