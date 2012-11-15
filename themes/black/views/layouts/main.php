<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="zh_cn" lang="zh_cn">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="zh_cn" />
    <?php echo CHtml::metaTag($this->keywords, 'keywords'); ?>
    <?php echo CHtml::metaTag($this->description, 'description'); ?>
    <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl ; ?>/fav.ico" />
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl ; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl ; ?>/css/style.css" />
	<title><?php echo CHtml::encode($this->pageTitle); ?> - Powered By YiiFramework</title>
    <?php
    Yii::app()->getClientScript()->registerCoreScript('jquery');
    ?>
</head>

<body>
    <div id="header-wrap" >
        <?php $this->renderPartial('//layouts/header',array());?>
    </div>

<div class="container" id="page">
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>

	<?php echo $content; ?>

</div><!-- page -->
<a id="sideTop" href="#top">返回顶部</a>
<div id="link-wrap">
    <?php $this->renderPartial('//layouts/links');?>
</div><!-- link -->
<div id="footer-wrap">
    <?php $this->renderPartial('//layouts/footer',array());?>
</div><!-- footer -->
<!-- JiaThis Button BEGIN -->
<script type="text/javascript" src="http://v2.jiathis.com/code/jiathis_r.js?type=left&amp;btn=l1.gif" charset="utf-8"></script>
<!-- JiaThis Button END -->
</body>
</html>