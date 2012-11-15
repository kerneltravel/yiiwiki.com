<?php

class ExtensionController extends AController
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
		$model=new Extension;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Extension']))
		{
			$model->attributes=$_POST['Extension'];
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

		if(isset($_POST['Extension']))
		{
			$model->attributes=$_POST['Extension'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionDownloadAdmin($ext_id){
        $extension = $this->loadModel($ext_id);
        
        
        $dataProvider = new CActiveDataProvider('ExtDownload', array(
            'criteria'=>array(
                'condition'=>'ext_id=:ext_id',
                'params'=>array(
                    ':ext_id'=>$extension->id
                )
            ),
            'pagination'=>false,
            'sort'=>array(
                'defaultOrder'=>'create_date desc'
            )
        ));

        $model = new ExtDownload;
        if(isset($_POST['ExtDownload'])){
            $model->attributes = $_POST['ExtDownload'];
            $model->ext_id = $extension->id;
            if($model->save()){
                Yii::app()->user->setFlash('message','添加成功');
                $this->refresh();
            }
        }
        $this->render('download_admin',array(
            'model'=>$model,
            'dataProvider'=>$dataProvider,
            'extension'=>$extension
        ));
    }

    public function actionDeleteDownload($id){
        if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadDownload($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'错误的请求.');
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
			throw new CHttpException(400,'错误的请求.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Extension');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Extension('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Extension']))
			$model->attributes=$_GET['Extension'];

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
		$model=Extension::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

    public function loadDownload($id){
        $model=ExtDownload::model()->findByPk($id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='extension-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
