<div class="view">
    <div class="title">
    <?php echo CHtml::link($data->name,$data->download_url);?> [ <?php echo CHtml::link('删除此文件',array('deleteDownload','id'=>$data->id),array('class'=>'delete'));?> ]
    </div>
    <span class="date"><?php echo $data->getCreateDate();?></span>
    <hr class="space" />
</div>