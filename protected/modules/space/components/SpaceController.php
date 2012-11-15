<?php

/**
 * 描述 SpaceController
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */
class SpaceController extends Controller{
    public $layout='column2';

    public $spaceName;

    public $user;
    
    public function  init() {
        parent::init();
        $id = Yii::app()->request->getParam('uid',Yii::app()->user->id);
        $this->user = $this->loadUser($id);
        $this->spaceName = $this->user->nickname."的个人空间";
    }

    protected function loadUser($id){
        $model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'页面不存在.');
		return $model;
    }

    public function  getMenu() {
        return array(
            array('label'=>'首页', 'url'=>$this->user->getSpaceUrl()),
            array('label'=>'个人资料', 'url'=>array('profile','uid'=>$this->user->id)),
        );
    }

}
?>
