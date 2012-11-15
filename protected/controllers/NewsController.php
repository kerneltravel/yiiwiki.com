<?php

class NewsController extends Controller
{
    public $showTips = false;
    public $tips = array();

    private $_model = null;
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
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
        $model = $this->loadModel($id);
        $model->updateCounters(array('hits'=>1),'id=:id',array(':id'=>$model->id));
		$this->render('view',array(
			'model'=>$model,
		));
	}

    protected function setCategory($cr){
        if(isset($_GET['category'])){
            $category = (int) $_GET['category'];
            $cr->addColumnCondition(array('category'=>$category));
            $this->tips[] = '分类 '.CHtml::tag('span',array('class'=>'category'),  Lookup::item(News::CATEGORY_TYPE, $category)).' 下的所有文章';
            $this->showTips = true;
        }
    }

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
        $cr = new CDbCriteria;
        $this->setCategory($cr);
        $cr->addColumnCondition(array('type'=>News::TYPE_NEWS));

		$dataProvider=new CActiveDataProvider('News',array(
            'criteria'=>$cr,
            'pagination'=>array(
                'pageSize'=>20,
            ),
            'sort'=>array(
                'defaultOrder'=>'modify_date desc'
            ),
        ));

        if(isset($_GET['News_sort'])){
            $sortAttribute = explode('.', $_GET['News_sort']);
            $sortAttribute = $sortAttribute[0];
            $this->tips[] = '按 '.CHtml::tag('span',array('class'=>'attribute'),News::model()->getAttributeLabel($sortAttribute)).' 排序';
            $this->showTips = true;
        }
        if($this->showTips){
            $params = $_GET;
            unset($params['News_sort']);
            array_unshift($params, $_GET['r']);
            $tips['url'] = $params;
            $tips['content'] = implode(', ', $this->tips);
        }
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
            'sortAttribute'=>$sortAttribute,
            'tips'=>$tips,
            'showTips'=>$showTips,
		));
	}


	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
        $this->_model = $model;
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    /**
     * 返回排序列表
     * @return array
     */
    public function getSortList(){
        $params = $_GET;
        unset($params['News_sort']);
        $sortList[] = array('label'=>'按发布时间排序','url'=>$this->createUrl(Yii::app()->getController()->getRoute(),$params + array('News_sort'=>'create_date.desc')));
        $sortList[] = array('label'=>'按修改时间排序','url'=>$this->createUrl(Yii::app()->getController()->getRoute(),$params + array('News_sort'=>'modify_date.desc')));
        $sortList[] = array('label'=>'按浏览量排序','url'=>$this->createUrl(Yii::app()->getController()->getRoute(),$params + array('News_sort'=>'hits.desc')));
        return $sortList;
    }

    public function getModel(){
        return $this->_model;
    }
}
