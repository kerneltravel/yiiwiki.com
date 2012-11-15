<?php
$this->breadcrumbs=array(
	'系统设置',
	'初始化积分',
);
$this->pageTitle = "初始化积分";
?>

<h1>初始化积分</h1>

<p>
    初始化积分将会删除现有积分，然后根据积分规则和用户现有的动作(发表文章评论)进行初始化积分。
</p>

<?php
echo CHtml::link("开始初始化",'',array('confirm'=>'确定开始初始化积分，初始化过程中请不要关闭浏览器！','ajax'=>array(
    'url'=>array('/admin/system/startInitCredit'),
    'type'=>'post',
    'dataType'=>'json',
    'success'=>"function(rs){if(rs.status==1) alert('初始化完成'); else alert('初始化失败')}"
),'class'=>'button'));
?>