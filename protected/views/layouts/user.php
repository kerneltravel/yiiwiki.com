<?php $this->beginContent('//layouts/main'); ?>
<div class="container">
    <div class="span-6">
		<div id="user-sidebar">
		<?php
			$this->beginWidget('zii.widgets.CPortlet', array(
			));
        ?>
            <div class="title first">快捷面板</div>
            <?php
            $this->widget('zii.widgets.CMenu',array(
                'items'=>array(
                    array(
                        'label'=>'写文章',
                        'url'=>array('wiki/create'),
                        'linkOptions'=>array(
                            'class'=>'write-article'
                        ),
                    ),
                    array(
                        'label'=>'我的个人空间',
                        'url'=>array('/space'),
                        'linkOptions'=>array(
                            'class'=>'space'
                        ),
                    ),
                ),
            ));
            ?>
            <div class="title">个人信息</div>
            <?php
            $this->widget('zii.widgets.CMenu',array(
                'items'=>array(
                    array(
                        'label'=>'个人资料',
                        'url'=>array('user/edit'),
                        'linkOptions'=>array(
                            'class'=>'info'
                        ),
                    ),
                    array(
                        'label'=>'修改密码',
                         'url'=>array('user/changePassword'),
                        'linkOptions'=>array(
                            'class'=>'password'
                        ),
                    ),
                    array(
                        'label'=>'我的积分',
                        'url'=>array('user/credit'),
                        'linkOptions'=>array(
                            'class'=>'credit'
                        ),
                    ),
                ),
            ));
            ?>
            <div class="title">我的文章</div>
            <?php
            $this->widget('zii.widgets.CMenu',array(
                'items'=>array(
                    array(
                        'label'=>'发表文章',
                        'url'=>array('wiki/create'),
                        'linkOptions'=>array(
                            'class'=>'write-article'
                        ),
                    ),
                    array(
                        'label'=>'我的文章',
                        'url'=>array('user/myArticle'),
                        'linkOptions'=>array(
                            'class'=>'article'
                        ),
                    ),
                    array(
                        'label'=>'我的评论',
                         'url'=>array('user/myComment'),
                        'linkOptions'=>array(
                            'class'=>'comment'
                        ),
                    )
                ),
            ));
            ?>
		<?php
			$this->endWidget();
		?>
		</div><!-- sidebar -->
	</div>
	<div class="span-18 last">
		<div id="user-content">
            <?php foreach(array('notice','error','success') as $v):?>
                <?php if(Yii::app()->user->hasFlash($v)):?>
                    <div class="flash-<?php echo $v?>">
                        <?php echo Yii::app()->user->getFlash($v);?>
                    </div>
                <?php endif;?>
                     <?php endforeach;?>
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>