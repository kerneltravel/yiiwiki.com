<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh_cn" lang="zh_cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="zh_cn" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/admin.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/style.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?> 后台管理程序 - Powered By YiiFramework</title>
    <?php
    Yii::app()->getClientScript()->registerCoreScript('jquery');
    ?>
</head>

<body>
<div id="header">
    <div id="top">
        <?php echo CHtml::link('前台首页',array('/wiki/index'));?>
        <?php if(Yii::app()->user->isGuest):?>
        欢迎您，请 <?php echo CHtml::link('登录',array('default/login'));?>
        <?php else:?>
        欢迎您，<?php echo Yii::app()->user->name;?>
         · <?php echo CHtml::link('退出',array('default/logout'));?>
        <?php endif;?>
        · <?php echo CHtml::link('交流论坛','http://www.yiichina.org/forum/',array('target'=>'_blank'));?>
    </div>
</div><!-- header -->

<div class="container" id="page">
    <?php
    if(Yii::app()->user->hasFlash('message')){
        $this->beginWidget('zii.widgets.jui.CJuiDialog',array(
            'id'=>'dialog',
            'options'=>array(
                'title'=>'对话框',
                'modal'=>true,
                
            ),
        ));
        echo Yii::app()->user->getFlash('message');
        $this->endWidget();
    }
    ?>
	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::link('yiiwiki.com','http://www.yiiwiki.com');?>.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?><br/>
        Version <?php echo Yii::app()->params['version']; ?><br/>
	</div><!-- footer -->
</div><!-- page -->

</body>
</html>