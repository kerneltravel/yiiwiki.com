<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'chm-_form-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">带 <span class="required">*</span> 为必填项.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>20)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>4,'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
        <div class="hint">在此填写文档的描述内容</div>
	</div>

    <div class="row">
		<?php echo $form->labelEx($model,'article_count'); ?>
		<?php echo $form->textField($model,'article_count',array('size'=>10)); ?>
		<?php echo $form->error($model,'article_count'); ?>
        <div class="hint">在此填写文档包含的文章数量</div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'url'); ?>
		<?php echo $form->textField($model,'url',array('size'=>50)); ?>
		<?php echo $form->error($model,'url'); ?>
	</div>


	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord?"发布":"修改",array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->