<?php
$this->pageTitle = '邮件重置密码'.$this->titleSeparator.Yii::app()->name;
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">带 <span class="required">*</span> 为必填项.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'passwd1'); ?>
		<?php echo $form->passwordField($model,'passwd1',array('size'=>18)); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'passwd2'); ?>
		<?php echo $form->passwordField($model,'passwd2',array('size'=>18)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton("修改",array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->