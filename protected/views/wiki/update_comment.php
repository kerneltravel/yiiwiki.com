<?php
$this->pageTitle = '修改评论'.$this->titleSeparator.Yii::app()->name;
?>
<h1>
    修改对" <?php echo $model->article->titleLink;?> "的评论 <?php echo CHtml::link('#'.$model->id,$model->url)?>
</h1>
<?php
$this->renderPartial('_form_comment',array('model'=>$model,'article'=>$model->article))
?>
