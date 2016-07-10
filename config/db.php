<?php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'sqlite:' . implode(DIRECTORY_SEPARATOR, [dirname(__DIR__), 'db', 'db.sqlite']),
    'username' => '',
    'password' => '',
    'charset' => 'utf8',
    'on afterOpen' => function () {
        \Yii::$app->db->createCommand()
            ->checkIntegrity(true)
            ->execute();
    },
];
