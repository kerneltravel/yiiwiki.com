<?php

/**
 * 描述 DbWebModule
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */
class DbWebModule extends CWebModule{

    public $theme = null;
    public $defaultTheme = 'views';

    public function  init() {
        parent::init();
        if(!empty($this->theme) && !is_object($this->theme)){
            $this->theme = new CTheme($this->theme, $this->getBasePath().'/themes',null);
            Yii::app()->theme = $this->theme;
        }
    }

    public function getViewPath() {
        if(empty ($this->theme))
            return $this->getBasePath().DIRECTORY_SEPARATOR.'views';
        else
            return $this->getBasePath().DIRECTORY_SEPARATOR.'themes/'.$this->theme->getName().'/views';
    }

    public function  getDescription() {
        $model = Module::model()->find('name=?',array($this->getName));
        return $model->description;
    }

}
?>
