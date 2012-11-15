<?php
Yii::app()->getClientScript()->registerScript('delete',<<<EOF
$('a.delete').live('click',
    function() {
        if(!confirm("确定删除?"))
            return false;
        $.fn.yiiListView.update('download-list', {
            type:'POST',
            url:$(this).attr('href'),
            success:function(data) {
                $.fn.yiiListView.update('download-list');
            },
        });
    return false;
    }
);
EOF
);
?>
<h1><?php echo CHtml::link($extension->name,$extension->url);?> 的文件</h1>

<?php
$this->widget('zii.widgets.CListView',array(
    'id'=>'download-list',
    'dataProvider'=>$dataProvider,
    'itemView'=>'_download_view'
));
?>
<hr class="space" />
<h2>添加文件</h2>
<?php
$this->renderPartial('_form_download',array('model'=>$model));
?>