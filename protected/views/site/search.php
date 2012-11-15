<?php
$this->layout = 'column2';

$this->renderPartial('_search_form',array('model'=>$model));
?>

<?php
$this->renderPartial('_tabs',array(
    'wikiDataProvider'=>$wikiDataProvider,
    'newsDataProvider'=>$newsDataProvider
));
?>
