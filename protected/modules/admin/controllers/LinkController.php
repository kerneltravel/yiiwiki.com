<?php

class LinkController extends AController
{
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Link;
        $model->status = Link::STATUS_APPROVED;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Link']))
		{
			$model->attributes=$_POST['Link'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Link']))
		{
			$model->attributes=$_POST['Link'];
			if($model->save()){
                if($model->oldStatus == Link::STATUS_PENDING && $model->status == Link::STATUS_APPROVED){
                    //发送邮件
                    Util::sendMail($model->email, "友情链接审核通过", "您好，您在 ".CHtml::link('Yii中文百科',Yii::app()->createAbsoluteUrl('/'))." 申请的友情链接 ".CHtml::link($model->url,$model->url)." 审核通过。\n 感谢您对『Yii中文百科』的支持.");
                }else if($model->oldStatus == Link::STATUS_PENDING && $model->status == Link::STATUS_FAIL){
                    //发送邮件
                    Util::sendMail($model->email, "友情链接审核失败", "您好，您在 ".CHtml::link('Yii中文百科',Yii::app()->createAbsoluteUrl('/'))." 申请的友情链接 ".CHtml::link($model->url,$model->url)." 审核失败，原因:{$_POST['reason']} 。\n 感谢您对『Yii中文百科』的支持.");
                }

                Yii::app()->user->setFlash('message','修改成功');
                $this->refresh();
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Link('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Link']))
			$model->attributes=$_GET['Link'];

		$this->render('admin',array(
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
