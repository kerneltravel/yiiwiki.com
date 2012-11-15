<?php $this->beginContent('/layouts/main'); ?>
<div class="container">
	<div class="span-18">
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
	<div class="span-6 last">
		<div id="sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
			));
        ?>
            <?php echo CHtml::link('写文章',array('wiki/create'),array('class'=>'button'))?>
            <hr class="space" />
            <?php echo CHtml::label('搜索文章', 'keywords',array('style'=>'font-size:1.2em;'))?>
            <div class="clear"></div>
            <?php echo CHtml::textField('keywords',$_GET['keywords'],array('style'=>'width:120px;padding:2px'));?>
            <?php echo CHtml::button('搜索',array('style'=>'padding:2px 9px;','name'=>'','onClick'=>"if($('#keywords').val() == ''){alert('请输入要搜索的内容');return false;}location.href='{$this->createUrl('wiki/index',array('keywords'=>''))}'+$('#keywords').val()"));?>

            <?php if($this->getRoute()=='wiki/index'):?>
            <hr class="space" />
            <strong>排序</strong>
            <ul class="wiki-sort">
                <?php foreach($this->sortList as $item):?>
                <li>
                    <?php
                    if(Yii::app()->getRequest()->getUrl() != $item['url'])
                        echo CHtml::link($item['label'],$item['url']);
                    else
                        echo CHtml::tag('b',array(),$item['label']);
                    ?>
                </li>
                <?php endforeach;?>
            </ul><!-- sort list -->
            <?php endif;?>

            <?php if($this->getRoute() == 'wiki/view'):?>
            <hr class="space" />
            <ul>
                <?php if(Yii::app()->user->id == $this->model->user_id):?>
                <li>
                    <?php
                        echo CHtml::link('修改',array('update','id'=>$this->model->id));
                    ?>
                </li>
                <?php endif;?>
                <li>
                    <hr />
                    <b>作者</b>: <?php echo $this->model->author->getNameLink();?>
                </li>
                <li>
                    <b>分类</b>: <?php echo $this->model->getCategoryLink();?>
                </li>
                <li>
                    <b>浏览</b>: <?php echo $this->model->hits;?> 次
                </li>
                <li>
                    <b>发布时间</b>: <?php echo $this->model->getCreateDate();?>
                </li>
                <li>
                    <b>最后修改</b>: <?php echo $this->model->getModifyDate();?>
                </li>
                <li>
                    <b>标签</b>: <?php echo implode(', ', $this->model->getTagLinks());?>
                </li>
            </ul>
            <?php endif;?>
            <hr class="space" />
            <strong>分类</strong>
            <ul>
                <?php foreach(Article::$_categories as $key=>$value):?>
                <li>
                    <?php
                    if($_GET['category'] != $key)
                        echo CHtml::link($value, Article::createCategoryUrl($key));
                    else
                        echo CHtml::tag('b',array(),$value);
                    ?>
                    <?php echo CHtml::tag('span',array('class'=>'count'),'('.Article::getCountByCategory($key).')');?>
                </li>
                <?php endforeach;?>
            </ul><!-- category -->

            <hr class="space" />
            <strong>热门标签</strong>
            <ul>
                <?php foreach(Tag::model()->model()->findAll('1 order by frequency desc limit 20') as $tag):?>
                <li>
                    <?php
                    if($_GET['tag'] != $tag->name)
                        echo CHtml::link($tag->name, array('wiki/index','tag'=>$tag->name));
                    else
                        echo CHtml::tag('b',array(),$tag->name);
                    ?>
                    <?php echo CHtml::tag('span',array('class'=>'count'),'('.$tag->frequency.')');?>
                </li>
                <?php endforeach;?>
            </ul><!-- tags -->

            <hr class="space"/>
            <strong>最新文章</strong>
            <ul class="article-list">
                <?php foreach(Article::model()->findAll(array('order'=>'modify_date desc','limit'=>10)) as $m):?>
                <li>
                    <?php echo $m->titleLink;?>
                </li>
                <?php endforeach;?>
            </ul><!-- newest articles -->
		<?php
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>