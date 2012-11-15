<?php
$this->breadcrumbs=array(
	'扩展管理'=>array('admin'),
	$model->name,
);

?>

<h1>查看扩展 #<?php echo $model->id; ?></h1>
<div>
    <?php echo CHtml::link('修改',array('update','id'=>$model->id));?>
    <?php echo CHtml::link('管理下载',array('downloadAdmin','ext_id'=>$model->id));?>
</div>
<hr />
<?php
$this->renderPartial('//wiki/content',array('data'=>$model->content));
?>
