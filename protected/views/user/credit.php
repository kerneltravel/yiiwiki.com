<?php
$this->layout = 'user';

$this->pageTitle = "我的积分".$this->titleSeparator.Yii::app()->name;

$this->breadcrumbs=array(
	'个人中心'=>array('home'),
	'我的积分',
);

?>
<h1>我的积分</h1>

<p>
    <b>当前积分</b>: <?php echo $model->credit;?>
</p>


<div>
    <?php
    $this->renderPartial('//wiki/content',array('data'=>@file_get_contents(Yii::app()->basePath.'/data/pages/credit.txt')));
    ?>
</div>