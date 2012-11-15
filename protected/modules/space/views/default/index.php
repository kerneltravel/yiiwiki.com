<?php
$this->pageTitle  = $this->user->nickname."的个人主页";
?>
<h4>文章</h4>
<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'article-list',
    'template'=>"{items}\n{pager}",
	'dataProvider'=>$dataProvider,
	'itemView'=>'//wiki/_view',
    'ajaxUpdate'=>false,
)); ?><!-- list -->