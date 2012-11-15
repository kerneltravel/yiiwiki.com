<?php

$this->layout = 'column2';

$this->pageTitle = "标签为 '{$tag}' 的文章";
?>

<h1>标签为 "<span class="red"><?php echo $tag;?></span>" 的文章</h1>
<?php
$this->renderPartial('_tabs',array(
    'wikiDataProvider'=>$wikiDataProvider,
    'newsDataProvider'=>$newsDataProvider
));
?>
