<div class="form">
    <script language="javascript">
        var optionItem = '<?php echo $model->getOptionRowForm();?>';
    </script>
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'module-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">带 <span class="required">*</span> 为必填项.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'screen_name'); ?>
		<?php echo $form->textField($model,'screen_name',array('size'=>45,'maxlength'=>45)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textField($model,'description',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',  Module::$statuses); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'theme'); ?>
		<?php echo $form->textField($model,'theme',array('size'=>20,'maxlength'=>45)); ?>
	</div>

	<div class="row" id="option">
		<?php echo $form->labelEx($model,'option'); ?>
        <?php echo CHtml::link('添加选项','javascript:void(0)',array('onclick'=>'$("#option").append(optionItem)'));?>
        <div class="clear"></div>
		<?php echo $model->getOptionsForm();?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '修改',array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->