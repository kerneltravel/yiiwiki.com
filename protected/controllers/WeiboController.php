<?php

/**
 * 描述 WeiboController
 *
 * @author Zhang Di <zhangdi5649@126.com>
 */
class WeiboController extends Controller{

    public function actionReturn(){

        if (isset($_REQUEST['code'])) {
            $token = Yii::app()->weibo->processRequest() ;
            if($token){
                $u = Yii::app()->weibo->getUser();
                LoginForm::loginByWeibo($u['id']);
                if(UserOption::hasSinaWeiboById($u['id'])){
                    $this->redirect (Yii::app()->user->returnUrl);
                }else
                    $this->redirect (array('user/registerByWeibo'));
                //$this->redirect (Yii::app()->weibo->returnUrl);
            }
        }
    }

    public function actionInfo(){
    }

}
