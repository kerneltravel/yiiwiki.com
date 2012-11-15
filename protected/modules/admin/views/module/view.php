<?php
$this->breadcrumbs=array(
	'模块管理'=>array('admin'),
	$model->screen_name,
);

?>

<h1>模块信息 `<?php echo $model->screen_name; ?>`</h1>

<?php echo CHtml::link('修改',array('update','id'=>$model->id));?>
<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'name',
		'screen_name',
		'description',
		array(
            'name'=>'status',
            'type'=>'html',
            'value'=>$model->getStatusNameWithColor()
        ),
		'theme',
		array(
            'name'=>'option',
            'type'=>'html',
            'value'=>$model->getOptionsView(),
        ),
	),
)); ?>
