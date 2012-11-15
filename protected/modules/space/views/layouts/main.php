<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh_cn" lang="zh_cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="zh_cn" />
    <?php echo CHtml::metaTag($this->keywords, 'keywords'); ?>
    <?php echo CHtml::metaTag($this->description, 'description'); ?>

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/space/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?> - <?php echo Yii::app()->name;?> - Powered By YiiFramework</title>
    <?php
    Yii::app()->getClientScript()->registerCoreScript('jquery');
    ?>
</head>

<body>
<div id="header">
    <div id="top">
        <div class="right">
            <?php if(Yii::app()->user->isGuest):?>
            欢迎您，请 <?php echo CHtml::link('登录',array('/user/login'));?>
            · <?php echo CHtml::link('注册',array('/user/register'));?>
            · <?php echo CHtml::link('找回密码',array('/user/findPassword'));?>
            <?php else:?>
            欢迎您，<?php echo Yii::app()->user->name;?>
             · <?php echo CHtml::link('个人中心',array('/user/home'));?>
             · <?php echo CHtml::link('退出',array('/user/logout'));?>
            <?php endif;?>
        </div>
        <div class="left">
            <?php echo CHtml::link('百科首页',array('/'));?>
             | <?php echo CHtml::link('Yii官方网站','http://www.yiiframework.com',array('target'=>'_blank'));?>
        </div>
    </div>
    <div id="logo"><?php echo CHtml::link($this->spaceName,$this->user->getSpaceUrl()); ?></div>
</div><!-- header -->
<div class="container" id="page">

    <div id="mainmenu">
        <?php $this->widget('zii.widgets.CMenu',array(
            'firstItemCssClass'=>'first',
            'items'=>$this->menu,
        )); ?>
    </div><!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::link('yiiwiki.com','http://www.yiiwiki.com');?>.<br/>
		All Rights Reserved.<br/>
		<?php echo Yii::powered(); ?><br/>
        Version <?php echo Yii::app()->params['version']; ?><br/>
        <?php echo Yii::app()->params['tongji_baidu'];?>
        <?php echo Yii::app()->params['tongji_cnzz'];?>
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>