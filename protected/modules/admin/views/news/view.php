<?php
$this->breadcrumbs=array(
	'新闻管理'=>array('admin'),
	$model->title,
);

?>

<div class="wiki-view">

    <h1 class="title"><?php echo CHtml::encode($model->title)?></h1>
<?php
$this->renderPartial('//wiki/content',array('data'=>$model->content));
?>
</div>
