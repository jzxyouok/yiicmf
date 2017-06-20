<?php
return
[
    'logDbTarget/agents/clear-logs' =>
    [
        'description'       => \Yii::t('yiisns/logdb', 'Cleaning mysql logs'),
        'agent_interval'    => 3600*3, // 每三个小时
        'next_exec_at'      => \Yii::$app->formatter->asTimestamp(time()) + 3600*3,
        'is_period'         => 'N'
    ]
];