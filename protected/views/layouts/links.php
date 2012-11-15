<?php
Yii::import('ext.qtip.QTip');
$models = Link::getAllApproved();

foreach($models as $model){
    QTip::qtip('a#link-'.$model->id,array(
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
<div id="link">
    <h4>
        <?php echo CHtml::link('申请友情链接',array('/link/apply'),array('class'=>'right apply'));?>
        <?php echo CHtml::link('友情链接',array('/link/index'));?>
    </h4>
    <div class="content">

        <?php echo implode('', Link::modelsToLinks($models));?>
    </div>
</div>