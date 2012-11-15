<?php
$this->breadcrumbs=array(
	'文章管理',
	'所有文章',
);


Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
");
?>

<h1>
    <?php
    if($model->author !== null)
        echo $model->author->nickname.'发布的';
    else
        echo '所有';
    ?>文章
</h1>

<?php echo CHtml::link('高级搜索','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'article-grid',
    'dataProvider'=>$model->search(),
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
	'columns'=>array(
		'id',
        array(
            'class'=>'CLinkColumn',
            'header'=>'标题',
            'labelExpression'=>'$data->title',
            'urlExpression'=>'$data->url',
            'linkHtmlOptions'=>array('target'=>'_blank')
        ),
		array(
            'name'=>'category',
            'value'=>'$data->categoryName'
        ),
		array(
            'name'=>'user_id',
            'type'=>'html',
            'value'=>'CHtml::link($data->author->nickname,array("/admin/user/view","id"=>$data->user_id));'
        ),
        array(
            'name'=>'modify_date',
            'value'=>'$data->getModifyDate()'
        ),
        array(
            'name'=>'commentCount'
        ),
        array(
            'name'=>'rating',
            'type'=>'html'
        ),
		/*
		'modify_date',
		'tags',
		'hits',
		*/
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
