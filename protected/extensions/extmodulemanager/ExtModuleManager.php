<?php

/**
 * 描述 ExtModuleManager
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */
class ExtModuleManager extends CApplicationComponent{

    public function init(){
        parent::init();
        $models = Module::model()->findAll();
        $modules = array();
        foreach($models as $model){
            $modules[$model->name] = $model->getOptions();
        }
        Yii::app()->setModules($modules);
    }
    
}
?>
