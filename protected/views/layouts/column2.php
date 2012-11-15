<?php $this->beginContent('//layouts/main'); ?>
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
            <?php if(strpos($this->getRoute(), 'wiki') !== false):?>
            <?php echo CHtml::link('写文章',array('wiki/create'),array('class'=>'button'))?>
            <hr class="space" />
            <?php endif;?>
            
            <?php echo CHtml::label('搜索文章', 'keywords',array('style'=>'font-size:1.2em;'))?>
            <div class="clear"></div>
            <?php echo CHtml::beginForm(array('/site/search'),'get',array(
                'onSubmit'=>"if($('#SearchForm_keywords').val() == ''){alert('请输入要搜索的内容');return false;}else {return true;}"
            ));?>
            <?php echo CHtml::textField('SearchForm[keywords]',null,array('style'=>'width:120px;padding:2px'));?>
            <?php echo CHtml::submitButton('搜索');?>
            <?php echo CHtml::endForm();?>
            <hr class="space" />
            <?php if($this->getRoute()=='wiki/index' || $this->getRoute()=='news/index'):?>
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

            <?php
            if(strpos($this->getRoute(), 'view') !== false || strpos($this->getRoute(), 'history') !== false || strpos($this->getRoute(), 'compare') !== false)
                $this->widget('ArticleInfo',array('article'=>$this->model));
            ?>

            <?php
            if(strpos($this->getRoute(), 'wiki') !== false)
                $this->widget('CategoryList');
            elseif(strpos($this->getRoute(), 'news') !== false){
                $this->widget('CategoryList',array('type'=>News::CATEGORY_TYPE));
            }
            ?>
            
            <?php $this->widget('TagCloud', array(
                'maxTags'=>20,
                'styleType'=>2
            )); ?>

            <?php
            $this->widget('ArticleList',array(
                'title'=>'最新教程',
                'max'=>20,
            ));
            ?>

            <?php
            $this->widget('ArticleList',array(
                'title'=>'最新新闻',
                'max'=>20,
                'type'=>  ArticleAR::TYPE_NEWS,
            ));
            ?>
		<?php
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	</div>
</div>
<?php $this->endContent(); ?>