<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'extension-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">带 <span class="required">*</span> 的为必填项.</p>

	<?php echo $form->errorSummary($model); ?>

    <?php if($model->isNewRecord):?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>128)); ?>
        <p class="hint">
            名称只能为数字,字母,'_'和'-',创建后名称不可修改.
        </p>
	</div>
    <?php endif;?>

    <div class="row">
		<?php echo $form->labelEx($model,'summary'); ?>
		<?php echo $form->textField($model,'summary',array('size'=>60,'maxlength'=>128)); ?>
	</div>
    
    <div class="row">
		<?php echo $form->labelEx($model,'demo_url'); ?>
		<?php echo $form->textField($model,'demo_url',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'project_url'); ?>
		<?php echo $form->textField($model,'project_url',array('size'=>60,'maxlength'=>255)); ?>
	</div>
    
	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
		<?php $this->widget('ext.markitup.EMarkitupWidget',array(
            'model'=>$model,
            'attribute'=>'content',
            'settings'=>'markdown',
            'htmlOptions'=>array(
                'style'=>'width:650px'
            ),
            'options'=>array(
                'previewParserPath'=>$this->createUrl('/wiki/preview'),
            ),
        ));?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存',array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->