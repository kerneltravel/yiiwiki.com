<div class="form">

<?php
$form=$this->beginWidget('CActiveForm', array(
	'id'=>'link-form',
	'enableAjaxValidation'=>false,
));
$failStatus = Link::STATUS_FAIL;
Yii::app()->getClientScript()->registerScript('status',<<<EOF
$('#Link_status').live('change',function(){
    if($('#Link_status').val() == $failStatus){
        $('#Link_status').parent().append('<textarea name="reason" id="reason" class="clear" cols=50 rows =4 onFocus="$(this).empty()" >请填写失败原因</textarea>');
    }else{
        $('#reason').remove();
    }
});
EOF
);
?>

	<p class="note">带 <span class="required">*</span> 的为必填项.</p>

	<?php echo $form->errorSummary($model); ?>

    <?php if(!$model->isNewRecord):?>
    <div class="row">
		<?php echo $form->labelEx($model,'create_date'); ?>
		<?php echo $model->getCreateDate(); ?>
	</div>
    <?php endif;?>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',  Lookup::items(Link::ADMIN_TYPE)); ?><br />
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('修改',array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->