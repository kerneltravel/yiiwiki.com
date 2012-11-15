<?php
$this->layout = 'user';

$this->pageTitle = '我的文章'.$this->titleSeparator.Yii::app()->name;

$this->breadcrumbs=array(
	'个人中心'=>array('home'),
	'我的文章',
);
?>
<h1>我的文章</h1>

<?php
$this->widget('zii.widgets.grid.CGridView',array(
    'dataProvider'=>$dataProvider,
    'cssFile'=>Yii::app()->request->baseUrl.'/css/gridview.css',
    'template'=>"{items}\n{pager}",
    'columns'=>array(
        array(
            'name'=>'id',
            'htmlOptions'=>array(
                'style'=>'width:10px;'
            )
        ),
        array(
            'class'=>'CLinkColumn',
            'labelExpression'=>'$data->title',
            'urlExpression'=>'$data->getUrl()',
            'linkHtmlOptions'=>array(
                'target'=>'_blank'
            )
        ),
        'commentCount',
        'rating:html',
        array(
            'name'=>'create_date',
            'value'=>'$data->getCreateDate()',
            'htmlOptions'=>array(
                'style'=>'width:100px;'
            )
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{update}',
            'updateButtonImageUrl'=>false,
            'updateButtonUrl'=>'Yii::app()->createUrl("wiki/update",array("id"=>$data->id))'

        ),
    ),
))
?>