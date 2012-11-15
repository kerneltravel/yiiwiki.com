<?php
$this->pageTitle = $model->title . $this->titleSeparator . Yii::app()->name;
$this->description = $model->getSummary(100);
$this->keywords  = $model->getKeywords();

$this->breadcrumbs=array(
	'新闻'=>array('index'),
    Lookup::item(News::CATEGORY_TYPE, $model->category)=>$model->getCategoryUrl(),
	$model->title=>$model->getUrl(),
    '阅读全文'
);

?>

<div class="wiki-view">
    <h1><?php echo CHtml::encode($model->title); ?></h1>

<?php $this->renderPartial('//wiki/content',array('data'=>$model->content)); ?>
</div>
