<?php
/**
 * Global Configuration Override
 *
 * You can use this file for overriding configuration values from modules, etc.
 * You would place values in here that are agnostic to the environment and not
 * sensitive to security.
 *
 * @NOTE: In practice, this file will typically be INCLUDED in your source
 * control, so do not include passwords or other sensitive information in this
 * file.
 */

return [
    'db' => [
        'driver' => 'Pdo_Mysql',
        'host' => 'localhost',
        'database' => 'zf3_helpdesk',
        'username' => 'root',
        'password' => ''
    ],
    'mail' => [
        'name' => 'smtp.mailtrap.io',
        'host' => 'smtp.mailtrap.io',
        'port' => 2525,
        'connection_class' => 'login',
        'connection_config' => [
            'from' => 'zf3napratica@teste.com',
            'username' => '65a8b57fe90430',
            'password' => '793ac291b82033',
            //'ssl' => 'ssl', --- GMAIL
            'auth' => 'CRAM-MD5'
        ]
    ]
];
