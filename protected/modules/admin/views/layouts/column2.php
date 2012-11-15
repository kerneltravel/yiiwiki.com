<?php $this->beginContent('/layouts/admin'); ?>
<div class="container">
	<div class="span-4">
		<div id="sidebar">
            <h2><center>管理面板</center></h2>
            <?php
            $this->widget('zii.widgets.CMenu',array(
                'id'=>'sidemenu',
                'activateParents'=>true,
                'items'=>array(
                    array(
                        'label'=>'用户管理',
                        'items'=>array(
                            array(
                                'label'=>'所有用户',
                                'url'=>array('/admin/user/admin')
                            ),
                        ),
                        
                    ),
                    array(
                        'label'=>'文章管理',
                        'items'=>array(
                            array(
                                'label'=>'所有文章',
                                'url'=>array('/admin/wiki/admin')
                            ),
                        )
                    ),
                    array(
                        'label'=>'页面管理',
                        'items'=>array(
                            array(
                                'label'=>'所有页面',
                                'url'=>array('/admin/page/admin')
                            ),
                            array(
                                'label'=>'新页面',
                                'url'=>array('/admin/page/create')
                            ),
                        )
                    ),
                    array(
                        'label'=>'新闻管理',
                        'items'=>array(
                            array(
                                'label'=>'所有新闻',
                                'url'=>array('/admin/news/admin')
                            ),
                            array(
                                'label'=>'添加新闻',
                                'url'=>array('/admin/news/create')
                            ),
                        )
                    ),
                    array(
                        'label'=>'扩展管理',
                        'items'=>array(
                            array('label'=>'所有扩展','url'=>array('/admin/extension/admin')),
                            array('label'=>'发布扩展','url'=>array('/admin/extension/create')),
                        )
                    ),
                    array(
                        'label'=>'系统设置',
                        'items'=>array(
                            array('label'=>'初始化积分','url'=>array('/admin/system/initCredit')),
                        )
                    ),
                    array(
                        'label'=>'模块管理',
                        'items'=>array(
                            array(
                                'label'=>'所有模块',
                                'url'=>array('/admin/module/admin')
                            ),
                        )
                    ),
                    array(
                        'label'=>'chm 文档管理',
                        'items'=>array(
                            array('label'=>'所有文档','url'=>array('/admin/chm/admin')),
                            array('label'=>'发布新文档','url'=>array('/admin/chm/publish')),
                        )
                    ),
                    array(
                        'label'=>'友情链接管理',
                        'items'=>array(
                            array(
                                'label'=>'所有链接',
                                'url'=>array('/admin/link/admin')
                            ),
                            array(
                                'label'=>'添加链接',
                                'url'=>array('/admin/link/create')
                            ),
                        )
                    ),
                )
            ));
            ?>
		</div><!-- sidebar -->
	</div>
    <div class="span-20 last">
        <?php if(isset($this->breadcrumbs)):?>
            <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                'links'=>$this->breadcrumbs,
                'homeLink'=>CHtml::link('管理首页',array('/admin'))
            )); ?><!-- breadcrumbs -->
        <?php endif?>
		<div id="content">
			<?php echo $content; ?>
		</div><!-- content -->
	</div>
</div>
<?php $this->endContent(); ?>