<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Yii中文百科',
    'language'=>'zh_cn',
    'timeZone'=>'Asia/Shanghai',
	'preload'=>array('log','moduleManager'),
	'import'=>array(
		'application.models.*',
        'application.models.behaviors.*',
		'application.components.*',
	),
    'theme'=>'black',
	'components'=>array(
        'moduleManager'=>array(
            'class'=>'ext.extmodulemanager.ExtModuleManager'
        ),
		'user'=>array(
			'allowAutoLogin'=>true,
            'loginUrl'=>array('user/login'),
            'stateKeyPrefix'=>'wiki'
		),
        'urlManager'=>array(
			'urlFormat'=>'path',
            'showScriptName'=>false,
			'rules'=>array(
                'tag/<tag:.*?>'=>'site/tag',
                'wiki/write'=>'wiki/create',
                'wiki/category/<category:\d+>/<name:.*?>'=>'wiki/index',
                'search/<keywords:.*?>'=>'wiki/index',
                'space/<uid:\d+>'=>'space/default/index',
                'user/profile/<uid:\d+>'=>'space/default/profile',
                'news/category/<category:\d+>/<name:.*?>'=>'news/index',
                'news/<id:\d+>/<title:.*?>'=>'news/view',
                'extension/<name:\w+>'=>'extension/view',
                'extension'=>'extension/index',
                'page/<view:\w+>'=>'page/view',
                'help'=>'page/index',
                'wiki'=>'wiki/index',
                'news'=>'news/index',
                'link'=>'link/index',
                '/'=>'site/index',
			),
		),
        'weibo'=>array(
            'class'=>'ext.weibo.YWeibo',
            'akey'=>'微博的 akey',
            'skey'=>'微博的 skey',
            'callbackUrl'=>'微博的 callbackUrl',
            'returnUrl'=>'微博的 returnUrl',
            'debug'=>false

        ),
		'db'=>  require dirname(__FILE__).'/db.php',

		'errorHandler'=>array(
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	'params'=>array(
		'adminEmail'=>'这里是管理员邮箱地址',
        'serviceEmail'=>require dirname(__FILE__).'/email.php',
        'site'=>array(
            'keywords'=>array(
                '关键字1',
                '关键字2',
            ),
        ),
        'version'=>'0.2.1',
        //以下为统计代码，可以自定义，然后在layout文件里面修改显示
        'tongji_cnzz'=>'cnzz统计代码',
        'tongji_baidu'=>'百度统计代码',
        'tongji_google'=>'Google统计代码'
	),
);
