<?php

class DefaultController extends SpaceController
{
	public function actionIndex()
	{
        $dataProvider=new CActiveDataProvider('Article',array(
            'criteria'=>array(
                'condition'=>'user_id=:user_id',
                'params'=>array(
                    ':user_id'=>$this->user->id,
                ),
            ),
            'sort'=>array(
                'defaultOrder'=>'modify_date desc'
            ),
        ));
		$this->render('index',array(
            'dataProvider'=>$dataProvider,
        ));
	}

    public function actionProfile(){
        $this->render('profile',array(
            'model'=>  $this->user,
        ));
    }

}