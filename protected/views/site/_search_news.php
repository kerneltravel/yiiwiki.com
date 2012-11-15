<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'//news/_view',
    'ajaxUpdate'=>false,
    'sortableAttributes'=>array(
    ),
)); ?><!-- list -->
