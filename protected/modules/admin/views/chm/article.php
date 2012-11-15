<div class="qucik-bar">
    <?php echo CHtml::link('查看原文','http://www.yiiwiki.com'.$model->url,array('target'=>'_blank')); ?> |
    <?php echo CHtml::link('写文章','http://www.yiiwiki.com/wiki/create',array('target'=>'_blank')); ?>
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