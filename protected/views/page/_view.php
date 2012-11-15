<div class="view">
    <h3 class="title">
        <span class="page">
        <?php echo CHtml::link($data->title,array('page/view','id'=>$data->id));?>
        </span>
    </h3>
    <div class="teaser">
        <div class="info">
            <span class="date"><?php echo $data->getCreateDate();?></span>
        </div>
        <?php echo $data->getSummary();?>
    </div>
</div>