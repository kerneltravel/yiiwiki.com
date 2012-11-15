<?php
$this->pageTitle = '快速查看'.$this->titleSeparator.Yii::app()->name;
?>
<h1>快速查看</h1>

<p>
	快速查看方式可以帮助你快速的查看网站的内容。
</p>
<p>
    如果您希望使用离线查看请点击下载chm文件：
</p>
<dl>
    <?php foreach($models as $model):?>
    <dt>
        <?php echo $model->name?>
    </dt>
    <?
        if(!empty($model->description))
            echo CHtml::tag('dd',array(),$model->description);
        if(!empty($model->article_count))
            echo CHtml::tag('dd',array(),'<b>文章</b> : '.$model->article_count);
        echo '<dd><b>下载地址</b> : ['.CHtml::link('下载地址',$model->url).']</dd>';
    ?>
    <dd><b>发布时间</b> : <?php echo date('Y年m月d日 H时i分',$model->create_date);?></dd>
    <dd><b>最后修改时间</b> : <?php echo date('Y年m月d日 H时i分',$model->modify_date);?></dd>
    <?php endforeach;?>
</dl>
