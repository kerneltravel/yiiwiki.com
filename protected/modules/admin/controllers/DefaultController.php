<?php

class DefaultController extends AController
{
    /**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow',
                'actions'=>array('login'),
                'users'=>array('*')
            ),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array(),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
    
	public function actionIndex()
	{
		$this->render('index');
	}

    public function actionLogin(){
        $this->layout = 'column1';
        $model=new AdminLoginForm;

		// collect user input data
		if(isset($_POST['AdminLoginForm']))
		{
			$model->attributes=$_POST['AdminLoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()){
                $returnUrl = isset($_GET['returnUrl'])?  urldecode($_GET['returnUrl']):Yii::app()->user->returnUrl;
                $this->redirect($returnUrl);
            }
		}
		// display the login form
		$this->render('login',array('model'=>$model));
    }

    /**
     * 退出登录，退出后跳转到主页
     */
    public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}