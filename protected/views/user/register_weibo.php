<?php
$this->pageTitle = "使用新浪微博注册".$this->titleSeparator.Yii::app()->name;
?>

<?php
$this->widget('zii.widgets.jui.CJuiTabs',array(
    'tabs'=>array(
        '还没有帐号'=>array(
            "content"=>$this->renderPartial('_register_form',array('model'=>$model),true),
            'id'=>'newRegister'
        ),
        '绑定已有帐号'=>array(
            "content"=>$this->renderPartial('_bind_form',array('model'=>$loginModel),true),
            'id'=>'bindAccount'
        )
    )
))
?>