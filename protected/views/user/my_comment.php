<?php
$this->layout = 'user';

$this->pageTitle = '我的评论'.$this->titleSeparator.Yii::app()->name;

$this->breadcrumbs=array(
	'个人中心'=>array('home'),
	'我的评论',
);
?>
<h1>我的评论</h1>

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
            'header'=>'文章标题',
            'class'=>'CLinkColumn',
            'labelExpression'=>'$data->article->title',
            'urlExpression'=>'$data->getUrl()',
            'linkHtmlOptions'=>array(
                'target'=>'_blank'
            ),
            'htmlOptions'=>array(
                'style'=>'width:150px;'
            )
        ),
        array(
            "name"=>'content',
            'type'=>'html',
            'value'=>'$data->getSummary()',
            'htmlOptions'=>array(
                'class'=>'comment'
            )
        ),
        array(
            'name'=>'create_date',
            'value'=>'$data->getDate()',
            'htmlOptions'=>array(
                'style'=>'width:100px;'
            )
        )
    ),
))
?>