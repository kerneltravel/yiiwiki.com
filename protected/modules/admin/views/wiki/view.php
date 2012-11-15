<?php
$this->breadcrumbs=array(
	'所有文章'=>array('admin'),
	$model->title,
);

?>

<h1>查看文章 #<?php echo $model->id; ?></h1>
<div>
    <?php echo CHtml::link('修改',array('update','id'=>$model->id));?>
    <?php echo CHtml::link('查看评论',array('comment/admin','article_id'=>$model->id));?>
</div>
<hr />
<div class="wiki-view">
<?php
echo $model->getTocs();
$this->renderPartial('//wiki/content',array('data'=>$model->content))
?>
</div>