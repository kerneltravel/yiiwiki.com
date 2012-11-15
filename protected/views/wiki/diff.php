<?php
$this->pageTitle = '比较版本'.$this->titleSeparator.$model->title;
?>
<div class="wiki-revision">
    <h1>
        <?php echo $model->getTitleLink();?>中 #<?php echo $revision1->revision;?> 和 #<?php echo $revision2->revision;?> 的区别
    </h1>
    <div class="revert">
        <?php echo CHtml::link('还原到 #'.$revision1->revision,array('/wiki/update','id'=>$model->id,'revision'=>$revision1->revision));?>
         | <?php echo CHtml::link('还原到 #'.$revision2->revision,array('/wiki/update','id'=>$model->id,'revision'=>$revision2->revision));?>
        
    </div>
    <div class="entry">
        <?php if(empty($diff['title'])):?>
        <div class="unchanged">
            未改变
        </div>
        <?php else:?>
        <div class="changed">
            有改变
        </div>
        <?php endif;?>
        <div class="label">
            标题
        </div>
        <div class="diff">
            <span>
                <?php echo empty($diff['title']) ? $revision1->title:$diff['title']; ?>
            </span>
        </div>
    </div>
    <div class="entry">
        <?php if(empty($diff['category'])):?>
        <div class="unchanged">
            未改变
        </div>
        <?php else:?>
        <div class="changed">
            有改变
        </div>
        <?php endif;?>
        <div class="label">
            分类
        </div>
        <div class="diff">
            <span>
                <?php echo empty($diff['category']) ? Lookup::item(Article::CATEGORY_TYPE, $revision1->category):$diff['category']; ?>
            </span>
        </div>
    </div>
    <div class="entry">
        <?php if(empty($diff['tags'])):?>
        <div class="unchanged">
            未改变
        </div>
        <?php else:?>
        <div class="changed">
            有改变
        </div>
        <?php endif;?>
        <div class="label">
            标签
        </div>
        <div class="diff">
            <span>
                <?php echo empty($diff['tags']) ? $revision1->tags:$diff['tags']; ?>
            </span>
        </div>
    </div>
    <div class="entry">
        <?php if(empty($diff['content'])):?>
        <div class="unchanged">
            未改变
        </div>
        <?php else:?>
        <div class="changed">
            有改变
        </div>
        <?php endif;?>
        <div class="label">
            内容
        </div>
        <div class="diff">
            <pre><?php echo empty($diff['content']) ? $revision1->content:$diff['content']; ?></pre>
        </div>
    </div>
</div>
