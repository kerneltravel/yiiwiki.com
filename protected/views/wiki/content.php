<div class="content">
<?php

$this->beginWidget('Markdown', array('purifyOutput'=>true));
echo $data;
$this->endWidget();
?>
</div>