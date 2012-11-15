<?php
if(isset($_GET['category'])){
    $this->addKeyword(Lookup::item(News::CATEGORY_TYPE, $_GET['category']));
    $title = Lookup::item(News::CATEGORY_TYPE, $_GET['category']).' - ';
}
$this->pageTitle = $title.'新闻'.$this->titleSeparator.Yii::app()->name;

$this->description = $this->pageTitle;

$this->addKeyword('新闻');

$this->breadcrumbs = array(
    '新闻'=>array('/news/index')
);

?>

<h1>新闻</h1>
<?php if($this->showTips):?>
<div class="tips">
    <?php echo CHtml::link('关闭',array('news/index'),array('class'=>'close right'));?>
    <?php echo $tips['content'];?>
</div><!-- tips -->

<?php endif;?>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
