<div id="footer">
    <div class="span-24">
        <div class="span-6">
            <h3>关于</h3>
            <ul>
                <li>
                    <?php echo CHtml::link('关于网站',array('/site/page','view'=>'about'));?>
                </li>
                <li>
                    <?php echo CHtml::link('联系我们',array('/site/contact'));?>
                </li>
            </ul>
        </div>
        <div class="span-6">
            <h3>帮助</h3>
            <ul>
                <li>
                    <?php echo CHtml::link('markdown语法',array('/site/page','view'=>'markdownHelp'));?>
                </li>
                <li>
                    <?php echo CHtml::link('积分说明',array('/site/page','view'=>'credit'));?>
                </li>
                <li>
                    <?php echo CHtml::link('友情链接',array('/site/page','view'=>'aboutLink'));?>
                </li>
            </ul>
        </div>
        <div class="span-6">
            <h3>下载</h3>
            <ul>
                <li>
                    <?php echo CHtml::link('下载框架','http://www.yiiframework.com/download/');?>
                </li>
                <li>
                    <?php echo CHtml::link('网站源码',array('/site/page','view'=>'version'));?>
                </li>
            </ul>
        </div>
        <div class="span-6 last">
            <div id="tongji">
            Copyright &copy; <?php echo date('Y'); ?> by <?php echo CHtml::link('yiiwiki.com','http://www.yiiwiki.com');?>.<br/>
            All Rights Reserved.<br/>
            <?php echo CHtml::link(CHtml::image(Yii::app()->request->baseUrl.'/themes/black/images/yii-powered.png'),'http://www.yiiframework.com',array('target'=>'_blank')); ?><br/>
            <?php echo Yii::app()->params['tongji_baidu'];?><br />
            <?php echo Yii::app()->params['tongji_cnzz'];?>
            <?php echo Yii::app()->params['tongji_google'];?>
            </div>
        </div>
    </div>

</div>