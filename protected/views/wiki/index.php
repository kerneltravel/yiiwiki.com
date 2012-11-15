<?php
if(isset($_GET['category'])){
    $this->addKeyword(Lookup::item(Article::CATEGORY_TYPE, $_GET['category']));
    $title = Lookup::item(Article::CATEGORY_TYPE, $_GET['category']).' - ';
}
$this->pageTitle = $title.'教程'.$this->titleSeparator.Yii::app()->name;

$this->description = $this->pageTitle;

$this->addKeyword('教程');

$this->breadcrumbs = array(
    '教程'=>array('/wiki/index')
);

?>

<h1>教程</h1>
<?php if($this->showTips):?>
<div class="tips">
    <?php echo CHtml::link('关闭',array('wiki/index'),array('class'=>'close right'));?>
    <?php echo $tips['content'];?>
</div><!-- tips -->

<?php endif;?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'ajaxUpdate'=>false,
    'pager'=>array(
        'class'=>'ext.ywpager.YWPager',
        'header'=>null,
    ),
    'sortableAttributes'=>array(
    ),
)); ?><!-- list -->
