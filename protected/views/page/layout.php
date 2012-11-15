<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
	<div class="span-6">
        <div id="help-sidebar">
            <h1><?php echo CHtml::link('帮助',array('/page/index'));?></h1>
            <?php
            $this->widget('zii.widgets.CMenu',array(
                'items'=>Page::toMenuItem(),
            ));
            ?>
        </div>
	</div>
	<div class="span-18 last">
        <div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>