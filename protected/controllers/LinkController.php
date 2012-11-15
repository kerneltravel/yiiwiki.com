<?php

class LinkController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

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
				'actions'=>array('index','apply'),
				'users'=>array('*'),
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
	public function actionApply()
	{
		$model=new Link;
        
		if(isset($_POST['Link']))
		{
			$model->attributes=$_POST['Link'];
			if($model->save()){
                Util::sendMail($model->email, '友情链接申请', "您提交的 {$model->getLink()} 友情链接我们已经收到，请等待审核！\n审核通过后我们会以邮件方式通知您。");
                Util::sendMail(Yii::app()->params['adminEmail'], "有人向你的网站申请友情链接", "有人向你的网站申请友情链接，请及时登录 ".CHtml::link("网站后台",Yii::app()->createAbsoluteUrl('/admin')).' 进行审核。');

                Yii::app()->user->setFlash("message",'恭喜您，申请友情链接成功,请等待审核.');
                $this->refresh();
            }
		}

		$this->render('apply',array(
			'model'=>$model,
		));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Link',array(
            'pagination'=>false,
            'criteria'=>array(
                'condition'=>'status=:status',
                'params'=>array(
                    ':status'=>Link::STATUS_APPROVED
                ),
            )
        ));

		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Link::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='link-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
