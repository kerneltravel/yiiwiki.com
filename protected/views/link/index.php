<?php
$this->pageTitle = '友情链接';
$this->description = '友情链接';
$this->addKeyword('友情链接');

$this->breadcrumbs=array(
	'友情链接',
);
Yii::import('ext.qtip.QTip');
$models = $dataProvider->getData();

foreach($models as $model){
    QTip::qtip('.link-view a#link-'.$model->id,array(
        'content'=>$model->description,
        'style'=>array(
            'tip'=>true,
            'padding'=>10,
            'border'=>array(
                'width'=>3,
                'radius'=>5,
            ),
            'textAlign'=>'center',
            'name'=>'blue',
        ),'position'=>array(
            'corner'=>array(
                'tooltip'=>'bottomMiddle',
                'target'=>'topMiddle'
            )
        )
    ));
}

?>

<h1>友情链接</h1>

<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'link-view',
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>

<div class="clear"></div>
<hr class="space" />
<?php echo CHtml::link("我要申请",array('/link/apply'),array('class'=>'button'));?>
