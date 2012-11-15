<?php
$this->pageTitle = $model->title.$this->titleSeparator.'快速查看';

$this->keywords  = $model->getKeywords();
$this->description = $model->getSummary();
?>
<div class="qucik-bar">
    <?php echo CHtml::link('查看原文',$model->url); ?> | 
    <?php echo CHtml::link('写文章',array('/wiki/create')); ?>
</div>
<h1 id="title">
    <?php echo $model->title; ?>
</h1>
<div id="info">
    作者：<?php echo CHtml::link($model->author->nickname,$model->author->homeUrl);?>
    发表时间：<?php echo $model->modifyDate;?>
</div>
<div class="wiki-view">
    <?php
    if($model->hasTocs())
        echo $model->getTocsView();
    $this->renderPartial('//wiki/content',array('data'=>$model->content))
    ?>

</div><!-- wiki view -->