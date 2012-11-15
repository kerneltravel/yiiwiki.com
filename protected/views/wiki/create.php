<?php
$this->layout = 'user';

$this->pageTitle = "新文章 - ".Yii::app()->name;

$this->breadcrumbs=array(
    '个人中心'=>array('user/home'),
    '我的文章'=>array('user/myArticle'),
	'新文章',
);
?>

<h1>新文章</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>