<?php
$this->pageTitle = '修订历史'.$this->titleSeparator.$model->title;
$this->description = $model->title.' 的修订历史';


Yii::app()->getClientScript()->registerCssFile(Yii::app()->request->baseUrl.'/css/gridview.css');
Yii::app()->getClientScript()->registerScript('checkbox',<<<EOF
   var a1= 0;
   var a2= 0;
$('.history-wiki .items input:checkbox').click(function(){
    length = $('.history-wiki .items input:checked').length;
    if(length == 1){
        chd = $('.history-wiki .items input:checked')[0];
        a1 = $(chd).val();
        a2 = 0;
    }
    if(length > 2){
        $("#select_"+a1)[0].checked = false;
        a1 = a2;
        a2 = $(this).val();
    }
    if(length == 2){
        
        a2 = $(this).val();
        
    }

    if ($(".history-wiki input:checked").length == 2) {
        $(".history-wiki #compare").removeAttr("disabled");
    } else {
        $(".history-wiki #compare").attr("disabled", "disabled");
    }

});

$(".history-wiki #compare").click(function(){
    location.href="{$this->createUrl('/wiki/compare/',array('id'=>$model->id))}?r1="+a1+"&r2="+a2;
});
EOF
,  CClientScript::POS_LOAD);

?>

<div class="history-wiki grid-view">
    <h1><?php echo $model->getTitleLink();?> 的修订历史</h1>
    <table class="items">
        <thead>
            <tr>
                <th style="width:5%">&nbsp;</th>
                <th style="width:65%">修订</th>
                <th style="width:10%">作者</th>
                <th style="width:30%">修订时间</th>
            </tr>
        </thead>
        <tbody>
        <?php $i = 1;foreach($revisions as $revision):?>
            <tr class="<?php echo $i%2 == 0 ? 'even':'odd';?>">
                <td><?php echo CHtml::checkBox('Content[select]', false, array('value'=>$revision->revision,'id'=>'select_'.$revision->revision))?></td>
                <td><?php echo CHtml::link('#'.$revision->revision.' - '.$revision->summary,array('/wiki/compare','id'=>$model->id,'r1'=>$revision->revision))?></td>
                <td><?php echo $revision->author->getNameLink();?></td>
                <td><?php echo $revision->getCreateDate();?></td>
            </tr>
        <?php $i++; endforeach;?>
        </tbody>
    </table>

    <?php echo CHtml::button('比较选择的版本',array('disabled'=>true,'id'=>'compare'));?>
</div>
