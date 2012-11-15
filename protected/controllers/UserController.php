<?php

class UserController extends Controller
{

    public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
		);
	}
    
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('register','login','home','logout','findPassword',
                    'resetPassword','captcha','RegisterByWeibo','myArticle','myComment','credit'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('edit','changePassword'),
				'users'=>array('@'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRegister()
	{
		$model=new User('register');

		// Uncomment the following line if AJAX validation is needed

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()){
				if(LoginForm::loginByAccount($model->username, $model->passwd))
                    $this->redirect(Yii::app()->user->returnUrl);
                else
                    $this->redirect (array('login'));
            }
		}

		$this->render('register',array(
			'model'=>$model,
		));
	}

    public function actionRegisterByWeibo(){
        $weibo = Yii::app()->weibo;
        $weiboUser = $weibo->getUser();
        $model=new User('register');
        $model->nickname = $weiboUser['screen_name'];
        $loginModel = new LoginForm;
        if(UserOption::hasSinaWeiboById($weiboUser['id'])){
            throw new CHttpException(200, '你的微博帐号已绑定过，请不要重复绑定');
        }
		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
            $m = new UserOption;
            $m->key = UserOption::KEY_WEIBO_SINA_ID;
            $m->value = $weiboUser['id'];
			if($model->validate() && $m->validate()){
                $model->save(false);
                $m->user_id = $model->id;
                $m->save(false);
                if(LoginForm::loginByAccount($model->username, $model->passwd))
                    $this->redirect(Yii::app()->user->returnUrl);
                else
                    $this->redirect (array('login'));
            }
		}

        if(isset($_POST['LoginForm'])){
            $loginModel->attributes=$_POST['LoginForm'];
            $m = new UserOption;
            $m->key = UserOption::KEY_WEIBO_SINA_ID;
            $m->value = $weiboUser['id'];
            if($loginModel->validate() && $m->validate()){
                $loginModel->login();
                if(UserOption::hasBindWeiboForUser(Yii::app()->user->id)){
                    throw new CHttpException(200, '你已经绑定了微博，请不要重复绑定');
                }
                $m->user_id = Yii::app()->user->id;
                $m->save(false);
                $this->redirect(Yii::app()->user->returnUrl);
            }
        }
        $this->render('register_weibo',array(
            'model'=>$model,
            'loginModel'=>$loginModel,
        ));
    }

    /**
     * 用户中心
     */
    public function actionHome(){
        $id = Yii::app()->request->getParam('id',Yii::app()->user->id);
        $model = $this->loadModel($id);
        if($model->id == Yii::app()->user->id){
            $this->layout = 'user';
            $name = '我';
        }else{
            $name = $model->nickname;
            $this->layout = 'column2';
        }

        $dataProvider = new CActiveDataProvider("Article", array(
            'criteria'=>array(
                'condition'=>'user_id=:user_id',
                'order'=>'create_date desc',
                'params'=>array(
                    ':user_id'=>$model->id,
                ),
            ),
            'sort'=>false
        ));

        $commentProvider = new CActiveDataProvider("Comment", array(
            'criteria'=>array(
                'condition'=>'user_id=:user_id',
                'order'=>'create_date desc',
                'params'=>array(
                    ':user_id'=>$model->id,
                ),
            ),
            'sort'=>false
        ));
        


        $this->render('home',array(
            'name'=>$name,
            'dataProvider'=>$dataProvider,
            'model'=>$model,
            'commentProvider'=>$commentProvider,
        ));
    }

	public function actionEdit()
	{
		$model=$this->loadModel(Yii::app()->user->id);
        $model->setScenario('edit');

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()){
                Yii::app()->user->setFlash('success','个人资料修改成功');
                $this->refresh();
            }
		}

		$this->render('edit',array(
			'model'=>$model,
		));
	}

    public function actionChangePassword(){
        $model = $this->loadModel(Yii::app()->user->id);
        $model->setScenario('changePassword');

        if(isset($_POST['User']))
		{
			$model->attributes=$_POST['User'];
			if($model->save()){
                Yii::app()->user->setFlash('success','密码修改成功');
                $this->refresh();
            }
		}
        
        $this->render('change_password',array(
            'model'=>$model
        ));
    }

    /**
     * 登录页面
     */
    public function actionLogin()
	{
		$model=new LoginForm;

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
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

    public function actionFindPassword(){
        $model = new FindPasswordForm;

        if(isset ($_POST['FindPasswordForm'])){
            $model->setAttributes($_POST['FindPasswordForm']);
            if($model->validate()){
                $user = $model->getModel();
                if(Util::sendMail($user->email, '找回密码',$model->createEmailBody())){
                    Yii::app()->user->setFlash('message','找回密码成功，请登录您的邮箱查看');
                }else{
                    Yii::app()->user->setFlash('message','发送失败');
                }
                $this->refresh();
            }
        }

        $this->render('find_password',array(
            'model'=>$model,
        ));
    }

    public function actionResetPassword($token,$code){
        $email = base64_decode($code);
        $model = User::model()->find('email=:email',array(':email'=>$email));

        $serverToken = md5($model->id.$model->username.$model->passwd);
        if($token != $serverToken)
            throw new CHttpException (404, '该页面不存在');
        $model->setScenario('resetPassword');

        if(isset($_POST['User'])){
            $model->attributes = $_POST['User'];
            if($model->save()){
                $this->redirect(array('user/login'));
            }
        }

        $this->render('reset_password',array(
            'model'=>$model
        ));
    }

    public function actionMyArticle(){
        $model = $this->loadModel(Yii::app()->user->id);
        
        $dataProvider = new CActiveDataProvider("Article", array(
            'criteria'=>array(
                'condition'=>'user_id=:user_id',
                'order'=>'create_date desc',
                'params'=>array(
                    ':user_id'=>$model->id,
                ),
            ),
            'sort'=>false,
            'pagination'=>array(
                'pageSize'=>20,
            )
        ));
        
        $this->render('my_article',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    public function actionMyComment(){
        $model = $this->loadModel(Yii::app()->user->id);

        $dataProvider = new CActiveDataProvider("Comment", array(
            'criteria'=>array(
                'condition'=>'user_id=:user_id',
                'order'=>'create_date desc',
                'params'=>array(
                    ':user_id'=>$model->id,
                ),
            ),
            'sort'=>false,
            'pagination'=>array(
                'pageSize'=>20,
            )
        ));

        $this->render('my_comment',array(
            'dataProvider'=>$dataProvider,
        ));
    }

    public function actionCredit(){
        $model = $this->loadModel(Yii::app()->user->id);

        $this->render('credit',array(
            'model'=>$model,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=User::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'页面不存在.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
