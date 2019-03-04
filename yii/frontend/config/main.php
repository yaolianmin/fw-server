<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'basePath' => dirname(__DIR__),
    //'bootstrap' => ['log'],
    'controllerNamespace' => 'frontend\controllers',
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-frontend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the frontend
            'name' => 'advanced-frontend',
        ],
        // 'log' => [
        //     'traceLevel' => YII_DEBUG ? 3 : 0,
        //     'targets' => [
        //         [
        //             'class' => 'yii\log\FileTarget',
        //             'levels' => ['error', 'warning'],
        //         ],
        //     ],
        // ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        /*
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        */
        //以下的配置是使用邮箱发送消息的配置信息
        'mailer' => [
                'class' => 'yii\swiftmailer\Mailer',
                'viewPath' => '@common/mail',
                'transport' => [
                    'class' => 'Swift_SmtpTransport',
                    //我用的是QQ 的代理，所以这里是 QQ 的配置信息
                    'host' => 'smtp.qq.com',
                    'port' => 587,
                    'encryption' => 'tls',    
                    //这部分信息不应该公开，所以后期会由数据库中拿取
                    'username' => '1137500763',
                    'password' => 'swrmmuwrffulibhg',//这个密码是由qq开启smtp后系统自动给的
                ],
                //发送的邮件信息配置
                'messageConfig' => [

                    'charset' => 'utf-8',

                    'from' => ['1137500763@qq.com' => '南京智威亚通信科技有限公司']
                ],
        ],
    ],
    'params' => $params,

    'charset' => 'utf-8', //默认编码
    // 'language' => 'zh-CN', //语言
    'timeZone' => 'Asia/Shanghai', //默认时区
    
];
