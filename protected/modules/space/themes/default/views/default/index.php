<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'//wiki/_view',
    'ajaxUpdate'=>false,
    'sortableAttributes'=>array(
    ),
)); ?><!-- list -->