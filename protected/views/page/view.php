<?php
$this->breadcrumbs=array(
	'帮助'=>array('index'),
	$model->title,
    '阅读全文'
);

$this->pageTitle = $model->title . $this->titleSeparator . Yii::app()->name;
$this->setDescription($model->getSummary());

?>

<div class="wiki-view">
    <h1 id="title"><?php echo CHtml::encode($model->title); ?></h1>
    <div class="dashed"></div>
<?php $this->renderPartial('//wiki/content',array('data'=>$model->content)); ?>
</div>
