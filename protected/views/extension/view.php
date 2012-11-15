<?php

$this->pageTitle = $model->name.$this->titleSeparator.'扩展';
$this->description = $model->getSummary();
$this->keywords  = $model->tags;
$this->breadcrumbs = array(
    '扩展'=>array('/extension/index'),
    $model->name=>$model->getUrl(),
    '阅读全文'
);
?>
<div class="span-23">
    <div class="span-17">
        <div class="wiki-view">
            <h1 id="title" class="title">
                <span class="extension">
                <?php echo $model->name; ?>
                </span>
            </h1>
            <i><?php echo CHtml::encode($model->summary);?></i>

            <div class="info">
                <span class="date"><?php echo $model->getCreateDate();?></span>, 浏览 <?php echo $model->hits;?> 次
            </div>
            <hr class="space" />
            <?php
            $this->renderPartial('//wiki/content',array('data'=>$model->content))
            ?>
        </div>

        <div>
            <span class="prev">上一篇: <?php echo $model->getPrevLink();?></span>
            
            <span class="next right">下一篇: <?php echo $model->getNextLink();?></span>
        </div>
        <hr class="space" />
    </div>
    <div class="span-6 last">
        <?php
			$this->beginWidget('zii.widgets.CPortlet', array(
                'title'=>'下载'
			));
        ?>
        <ul>
            <?php foreach($model->files as $file):?>
            <li>
                <?php echo CHtml::link($file->name,$file->download_url,array('target'=>'_blank'));?>
            </li>
            <?php endforeach;?>
        </ul>
        <?php $this->endWidget();?>
        <hr />
        <?php
			$this->beginWidget('zii.widgets.CPortlet', array(
			));
        ?>
        <ul>
            <li>
                <?php echo CHtml::tag('b',array(),'浏览').' : '.$model->hits.' 次';?>
            </li>
            <li>
                <?php echo CHtml::tag('b',array(),'发布时间').' : '.$model->getCreateDate();?>
            </li>
            <li>
                <?php echo CHtml::tag('b',array(),'标签').' : '.implode(', ', $model->getTagLinks());?>
            </li>
        </ul>
        <?php $this->endWidget();?>
    </div>
</div>
