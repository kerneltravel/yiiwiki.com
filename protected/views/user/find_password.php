<?php
$this->pageTitle = '找回密码'.$this->titleSeparator.Yii::app()->name;
?>

<?php if(Yii::app()->user->hasFlash('message')):?>
<div class="flash-success">
    <?php echo Yii::app()->user->getFlash('message');?>
</div>

<?php else:?>

<?php
$this->renderPartial('_form_findPassword',array('model'=>$model));
?>

<?php endif;?>