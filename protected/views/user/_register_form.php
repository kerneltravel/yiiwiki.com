<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">带 <span class="required">*</span> 为必填项.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>18)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'passwd1'); ?>
		<?php echo $form->passwordField($model,'passwd1',array('size'=>18)); ?>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'passwd2'); ?>
		<?php echo $form->passwordField($model,'passwd2',array('size'=>18)); ?>
	</div>

    <hr />
    
    <div class="row">
		<?php echo $form->labelEx($model,'gender'); ?>
		<?php echo $form->dropDownList($model,'gender',User::$_genders); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'nickname'); ?>
		<?php echo $form->textField($model,'nickname',array('size'=>10)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>40)); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton('注册',array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->