<?php
$this->breadcrumbs=array(
	'用户管理',
	'所有用户',
);

$this->menu=array(
	array('label'=>'List User', 'url'=>array('index')),
	array('label'=>'Create User', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>所有用户</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<hr class="space" />
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'user-grid',
	'dataProvider'=>$model->search(),
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
	'columns'=>array(
		'id',
		'username',
		'nickname',
		'email',
		array(
            'name'=>'gender',
            'value'=>'$data->genderName'
        ),
        'articleCount',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
