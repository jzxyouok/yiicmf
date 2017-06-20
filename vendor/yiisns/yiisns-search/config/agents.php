<?php
return [
    'search/clear/phrase' =>
    [
        'description'       => 'Clear search terms',
        'agent_interval'    => 3600*24,
        'next_exec_at'      => \Yii::$app->formatter->asTimestamp(time()) + 3600*24,
        'is_period'         => 'N'
    ]
];