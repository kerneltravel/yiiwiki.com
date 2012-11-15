<?php
$this->breadcrumbs=array(
	'页面管理'=>array('admin'),
	$model->title,
);

?>

<div class="wiki-view">
    <h1><?php echo $model->title; ?></h1>
    <div>
        <?php echo CHtml::link('修改',array('update','id'=>$model->id));?>
    </div>
    <hr />
    <?php
    $this->renderPartial('//wiki/content',array('data'=>$model->content));
    ?>
</div>