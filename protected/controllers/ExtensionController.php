<?php

class ExtensionController extends Controller
{
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Extension');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

    public function actionView($name){
        $model = $this->load($name);
        $model->updateCounters(array('hits'=>1),'id=:id',array(':id'=>$model->id));
        $this->render('view',array(
            'model'=>$model
        ));
    }

    protected function load($name){
        $model = Extension::model()->find('name=:name',array(':name'=>$name));

        if($model === null)
            throw new CHttpException (404, '页面不存在');
        else
            return $model;
    }

}