<?php
return [
    'adminEmail' => 'andrewpraveen.n@gmail.com',
    'supportEmail' => 'admin@nationsvoice.com.lk',
    'senderEmail' => 'andrewpraveen.n@gmail.com',
    'senderName' => 'Example.com mailer',
    'user.passwordResetTokenExpire' => 3600,
    'user.passwordMinLength' => 8,
    'uploadPathIMG' => dirname(dirname(__DIR__)) . '/backend/web/uploads/',
    'back_host' => (YII_ENV_DEV ? 'http://winners.local/uploads/' : 'http://winners.jaan.lk/uploads/'),
    'config_constants' => [
        'PACKAGE_UPGRADE' => 'PACKAGE_UPGRADE'
    ],
];
