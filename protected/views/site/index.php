<?php
$this->pageTitle = Yii::app()->name;
?>
<div class="span-23">
    <div class="span-17">
        <div class="flash-notice">
            <h3 class="red">关于 Yii</h3>
            <p class="text-indent">
                Yii 是一个基于组件、用于开发大型 Web 应用的<strong>高性能</strong> PHP 框架。Yii 几乎拥有了<strong>所有的特性</strong> ，包括 MVC、DAO/ActiveRecord、I18N/L10N、caching、基于 JQuery 的 AJAX 支持、用户认证和基于角色的访问控制、脚手架、输入验证、部件、事件、主题化以及 Web 服务等等。Yii 采用严格的 OOP 编写，Yii 使用简单，非常灵活，具有很好的可扩展性。
            </p>
        </div>
        <hr class="space" />
        <div class="span-8">
        <?php
			$this->widget('ArticleList',array('max'=>20,'title'=>'新闻','type'=>News::TYPE_NEWS,'style'=>'simple-red','sort'=>'modify_date desc,hits desc'));
        ?>
        </div>
        <div class="span-9 last">
            <?php
			$this->widget('ArticleList',array('max'=>20,'title'=>'教程','type'=>Article::TYPE_WIKI,'style'=>'simple-green','sort'=>'modify_date desc,hits desc'));
        ?>
        </div>
    </div>
    <div class="span-6 last">
        <?php
			$this->widget('ArticleList',array('title'=>'热门教程','type'=>Article::TYPE_WIKI,'style'=>'red','sort'=>'hits desc'));
        ?>
        <?php
			$this->widget('ArticleList',array('title'=>'最新新闻','type'=>News::TYPE_NEWS,'style'=>'green'));
        ?>
        <?php
			$this->widget('ArticleList',array('type'=>News::CATEGORY_TYPE,'style'=>'blue'));
        ?>
    </div>
</div>