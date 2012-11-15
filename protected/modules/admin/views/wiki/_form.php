<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">带 <span class="required">*</span> 的为必填项.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'category'); ?>
		<?php echo $form->dropDownList($model,'category',  Article::$_categories); ?>
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
        <div class="hint">
            <?php echo CHtml::link("Markdown 语法帮助",array('site/page','view'=>'markdownHelp'),array('target'=>'_blank'))?>
        </div>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'tags'); ?>
		<?php echo $form->textField($model,'tags',array('size'=>60,'maxlength'=>255)); ?>
        <div class="note">
            多个标签用英文中的逗号分隔
        </div>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? '提交' : '保存'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->