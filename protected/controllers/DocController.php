<?php

class DocController extends Controller
{
    public $layout = 'doc';

	public function actionIndex()
	{
        $models = Chm::model()->findAll(array('order'=>'modify_date desc,create_date desc'));
        
		$this->render('index',array('models'=>$models));
	}

    public function actionView($id){
        $model = $this->loadModel($id);
        $this->render('view',array('model'=>$model));
    }

    public function getTreeViewData(){
        $data = array();
        $data[] = array('text'=>  CHtml::link('快速查看首页',array('index')));
        foreach(Lookup::items(Article::CATEGORY_TYPE) as $key=>$category){
            $models = Article::model()->findAll(array('select'=>'id,title','condition'=>'category=:category','params'=>array(':category'=>$key)));
            $item['text'] = CHtml::tag('span',array(),$category);
            $item['expanded'] = false;
            $chileren = array();
            foreach($models as $model){
                $article['text'] = CHtml::link($model->title,array('view','id'=>$model->id));
                $chileren[] = $article;
            }
            $item['children'] = $chileren;
            $data[] = $item;
        }

        return $data;
    }

    public function loadModel($id)
	{
		$model=Article::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'页面不存在.');
		return $model;
	}
}