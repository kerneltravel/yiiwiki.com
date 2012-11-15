<?php

class SystemController extends AController
{
	public function actionInitCredit()
	{
		$this->render('initCredit');
	}

    public function actionStartInitCredit(){
        if(Yii::app()->request->isPostRequest){
            $users = User::model()->findAll();
            foreach($users as $user){
                $user->initCredit();
            }

            echo json_encode(array('status'=>1));
        }
    }

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}