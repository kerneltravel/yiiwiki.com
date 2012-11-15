<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'headerTemplate'=>'<li><a href="{url}" title="{title}">{title}</a></li>',
    'tabs'=>array(
        '教程 ('.$wikiDataProvider->getTotalItemCount().')'=>array('id'=>'wiki','content'=>$this->renderPartial('_search_wiki',array('dataProvider'=>$wikiDataProvider),true)),
        '新闻 ('.$newsDataProvider->getTotalItemCount().')'=>array('id'=>'news','content'=>$this->renderPartial('_search_news',array('dataProvider'=>$newsDataProvider),true)),
    ),
));
?>