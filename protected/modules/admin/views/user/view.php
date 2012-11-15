<?php
$this->breadcrumbs=array(
	'所有用户'=>array('admin'),
	$model->username,
);

?>

<h1>查看用户信息 #<?php echo $model->id; ?></h1>

<div>
    <?php echo CHtml::link('修改用户信息',array('update','id'=>$model->id));?> | 
    <?php echo CHtml::link('查看该用户发布的文章',array('wiki/admin','Article[user_id]'=>$model->id));?>
</div>

<hr class="space" />

<?php $this->widget('zii.widgets.CDetailView', array(
	'data'=>$model,
    'cssFile'=>Yii::app()->request->baseUrl.'/css/detail-view.css',
	'attributes'=>array(
		'id',
		'username',
		'nickname',
		'email',
		'gender',
        array(
            'name'=>'reg_date',
            'value'=>$model->getRegDate(),
        ),
		array(
            'name'=>'modify_date',
            'value'=>$model->getModifyDate(),
        ),
	),
)); ?>
