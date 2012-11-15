<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'comment-form',
    'action'=>$this->getRoute() == 'wiki/view' ? $article->getUrl()."#comment-form":''
)); ?>

	<p class="note">评论最少 6 个字符.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php $this->widget('ext.markitup.EMarkitupWidget',array(
            'model'=>$model,
            'attribute'=>'content',
            'settings'=>'markdown',
            'htmlOptions'=>array(
                'style'=>'width:670px;height:200px'
            ),
            'options'=>array(
                'previewParserPath'=>$this->createUrl('preview'),
            ),
        ));?>
        <div class="hint">
            <?php echo CHtml::link("Markdown 语法帮助",array('site/page','view'=>'markdownHelp'),array('target'=>'_blank'))?>
        </div>
	</div>

    <?php if(CCaptcha::checkRequirements()): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($model,'verifyCode'); ?>
		</div>
		<div class="hint">请填写图片中的字母.
		<br/>不区分大小写.</div>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('发表',array('class'=>'button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->