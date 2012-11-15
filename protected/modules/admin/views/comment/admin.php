<?php
$this->breadcrumbs=array(
	'所有文章'=>array('wiki/admin'),
	$model->article->title=>array('wiki/view','id'=>$model->article_id),
    '所有评论'
);

?>

<h1>所有对 <?php echo CHtml::link($model->article->title,array('wiki/view','id'=>$model->article_id));?> 的评论</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'comment-grid',
	'dataProvider'=>$model->search(),
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
	'columns'=>array(
		'id',
		array(
            'name'=>'user_id',
            'type'=>'html',
            'value'=>'CHtml::link($data->author->nickname,array("user/view","id"=>$data->user_id))'
        ),
        array(
            'name'=>'content',
            'value'=>'Yii::app()->controller->renderPartial("//wiki/content",array("data"=>$data->content))',
        ),
		'create_date:datetime',
		'modify_date:datetime',
		array(
			'class'=>'CButtonColumn',
            'template'=>'{delete}',
            'deleteButtonImageUrl'=>false
		),
	),
)); ?>
