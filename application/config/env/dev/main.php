<?php
return [
    'bootstrap' => [ 'debug' ],
    'modules' => [
        'debug' => [
            'allowedIPs' => [ '*' ],
            'class' => 'yii\debug\Module'
        ]
    ]
];