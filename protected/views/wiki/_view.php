<div class="view">
    <h3 class="title">
        <span class="wiki">
        <?php echo CHtml::link($data->getTitle(),$data->getUrl());?>
        </span>
    </h3>
    <div class="teaser">
        <div class="info">
            <span class="author"><?php echo $data->author->getNameLink();?></span>
            <span class="date"><?php echo $data->getCreateDate();?></span>
            <span class="category"><?php echo CHtml::link($data->getCategoryName(),$data->getCategoryUrl());?></span>
            |&nbsp;
            <span class="view">浏览 <?php echo $data->hits;?> 次</span>
            <span class="comment">回复 <?php echo $data->commentCount?></span>
            <?php echo $data->getRatingView();?>
        </div>
        <?php echo $data->getSummary();?>

        <?php if(count($data->getTagLinks())>0):?>
        <div class="tags">
            <span class="tag"><b>标签</b></span>: <?php echo implode(', ', $data->getTagLinks())?>
        </div>
        <?php endif;?>
    </div>
</div>