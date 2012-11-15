<?php

class WikiController extends Controller
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
	 * Declares class-based actions.
	 */
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
				'actions'=>array('index','view','preview','search','captcha','fav','history','Compare'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update','updateComment','deleteComment','fav'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
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
        $comment = $this->newComment($model);

		$this->render('view',array(
			'model'=>$model,
            'comment'=>$comment,
		));
	}

    public function actionPreview(){
        $this->layout = 'preview';
        $this->render('content',array(
            'data'=>$_POST['data']
        ));
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Article;
        
		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
            $model->summary = Content::INIT_SUMMARY;
			if($model->save() && $model->createNewRevision()){
                //添加积分
                $model->author->plusCredit(User::CREDIT_NEW_ARTICLE,  Lookup::item('CreditReason', CreditLog::REASON_NEW_ARTICLE));
                
                if($model->isSendToWeibo){
                    $rs = Yii::app()->weibo->client->update($model->getWeiboContent());
                }
				$this->redirect($model->getUrl());
            }
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
        $model->setScenario('update');
        if(isset($_GET['revision']) && $this->loadRevision($model->id, $_GET['revision']) !== null){
            $revision = $this->loadRevision($model->id, $_GET['revision']);
            $model->title = $revision->title;
            $model->category = $revision->category;
            $model->content = $revision->content;
            $model->tags = $revision->tags;
        }

        $tmpModel = clone $model;

        if(isset($_POST['Article']))
		{
			$model->attributes=$_POST['Article'];
            
			if(Article::isChanged($tmpModel, $model) && $model->save() && $model->createNewRevision()){
                if($model->isSendToWeibo){
                    $rs = Yii::app()->weibo->client->update($model->getWeiboContent());
                }
                $this->redirect($model->getUrl());
            }else{
                if(!Article::isChanged($tmpModel, $model))
                    $model->addError('id', '没有进行任何修改');
            }
				
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionHistory($id){
        $model = $this->loadModel($id);

        $revisions = Content::model()->findAll('article_id=:article_id order by revision desc ,create_date desc',
            array(':article_id'=>$model->id)
        );

        $this->render('history',array(
            'revisions'=>$revisions,
            'model'=>$model,
        ));

    }

    public function actionCompare($id,$r1){
        $model = $this->loadModel($id);
        $r2 = Yii::app()->request->getParam('r2',$model->getLastVersion());
        $revision1 = $this->loadRevision($model->id,$r1);
        $revision2 = $this->loadRevision($model->id,$r2);

        $diff['title'] = TextDiff::compare($revision2->title, $revision1->title);
        $diff['category'] = TextDiff::compare(Lookup::item(Article::CATEGORY_TYPE, $revision2->category), Lookup::item(Article::CATEGORY_TYPE, $revision1->category));
        $diff['tags'] = TextDiff::compare($revision2->tags, $revision1->tags);
        $diff['content'] = TextDiff::compare($revision2->content, $revision1->content);
        
        $this->render('diff',array(
            'diff'=>$diff,
            'revision1'=>$revision1,
            'revision2'=>$revision2,
            'model'=>$model
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
            //减去积分
            $model->author->minuxCredit(User::CREDIT_DELETE_ARTICLE,  Lookup::item('CreditReason', CreditLog::REASON_DELETE_ARTICLE));
			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    protected function setCategory($cr){
        if(isset($_GET['category'])){
            $category = (int) $_GET['category'];
            $cr->addColumnCondition(array('category'=>$category));
            $this->tips[] = '分类 '.CHtml::tag('span',array('class'=>'category'),  Lookup::item(Article::CATEGORY_TYPE, $category)).' 下的所有文章';
            $this->showTips = true;
        }
    }

    protected function setTag($cr){
        if(isset($_GET['tag'])){
            $tag = $_GET['tag'];
            $cr->addSearchCondition('tags',$tag);
            $this->tips[] = '标签为 '.CHtml::tag('span',array('class'=>'tag'),$tag).' 下的所有文章';
            $this->showTips = true;
        }
    }

    protected function setSearchKeywords($cr){
        if(isset($_GET['keywords'])){
            $keywords = $_GET['keywords'];
            $cr->addSearchCondition('title',$keywords);
            $cr->addSearchCondition('content',$keywords);
            $this->tips[] = '搜索包含 '.CHtml::tag('span',array('class'=>'tag'),$keywords).' 的所有文章';
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
        $this->setTag($cr);
        $this->setSearchKeywords($cr);

        $cr->addColumnCondition(array('type'=>  Article::TYPE_TYPE));
        
		$dataProvider=new CActiveDataProvider('Article',array(
            'criteria'=>$cr,
            'pagination'=>array(
                'pageSize'=>20,
            ),
            'sort'=>array(
                'defaultOrder'=>'modify_date desc'
            ),
        ));
        
        if(isset($_GET['Article_sort'])){
            $sortAttribute = explode('.', $_GET['Article_sort']);
            $sortAttribute = $sortAttribute[0];
            $this->tips[] = '按 '.CHtml::tag('span',array('class'=>'attribute'),Article::model()->getAttributeLabel($sortAttribute)).' 排序';
            $this->showTips = true;
        }
        if($this->showTips){
            $params = $_GET;
            unset($params['Article_sort']);
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
		$model=Article::model()->findByPk($id);
        $this->_model = $model;
		if($model===null)
			throw new CHttpException(404,'页面不存在.');
		return $model;
	}
    
    public function loadComment($id)
	{
		$model=Comment::model()->findByPk($id);
        $this->_model = $model;
		if($model===null)
			throw new CHttpException(404,'页面不存在.');
		return $model;
	}

    public function loadRevision($id,$revision){
        $model = Content::model()->find('article_id=:article_id and revision=:revision',array(':article_id'=>$id,':revision'=>$revision));
        if($model===null)
			throw new CHttpException(404,'页面不存在.');
		return $model;
    }

    public function getModel(){
        return $this->_model;
    }

    public function actionUpdateComment($id){
        $model = $this->loadComment($id);
        if($model->user_id == Yii::app()->user->id){
            if(isset($_POST['Comment'])){
                $model->attributes=$_POST['Comment'];
                if($model->save())
                {
                    $this->redirect($model->url);
                }
            }
            
            $this->render('update_comment',array(
                'model'=>$model,
            ));
        }else
            throw new CHttpException(404,'页面不存在.');
    }

    public function actionDeleteComment($id){
        $model = $this->loadComment($id);
        if(Yii::app()->request->isPostRequest){
            if($model->user_id == Yii::app()->user->id){
                $model->delete();
                //减去积分
                $model->author->minuxCredit(User::CREDIT_DELETE_COMMENT,  Lookup::item('CreditReason', CreditLog::REASON_DELETE_COMMENT));
                echo json_encode(array('status'=>1));
            }else
                echo json_encode (array('status'=>0,'message'=>'你没有权限删除此评论'));
        }else
            echo json_encode (array('status'=>0,'message'=>'你没有权限删除此评论'));
    }

    public function actionFav(){
        if(Yii::app()->user->isGuest){
            echo json_encode(array(
                'status'=>-2
            ));
            Yii::app()->end();
        }
        if(Yii::app()->request->isPostRequest && isset($_POST['id']) && isset($_POST['type'])){
            $id = $_POST['id'];
            $type = $_POST['type'];
            $model = $this->loadModel($id);
            if(array_key_exists($type, UserFav::$types)){
                $isFavExist = UserFav::favExists($id, $type);
                switch ($type){
                    case UserFav::TYPE_FOLLOW:
                        if($isFavExist)
                            echo json_encode (array('status'=>-1,'message'=>'您已经关注过此文章了'));
                        else {
                            if(UserFav::add($id, $type))
                                echo json_encode (array('status'=>1,'message'=>'您已成功关注此文章'));
                            else
                                echo json_encode (array('status'=>-1,'message'=>'关注失败, 请重试或联系管理员'));
                        }
                        break;
                    case UserFav::TYPE_UNFOLLOW:
                        if(!UserFav::favExists($id, UserFav::TYPE_FOLLOW))
                            echo json_encode (array('status'=>-1,'message'=>'您未关注过此文章'));
                        else {
                            if(UserFav::remove($id, UserFav::TYPE_FOLLOW))
                                echo json_encode (array('status'=>1,'message'=>'您已成功取消关注此文章'));
                            else
                                echo json_encode (array('status'=>-1,'message'=>'取消关注失败, 请重试或联系管理员'));
                        }
                        break;
                    case UserFav::TYPE_THUMB_DOWN:
                        if(UserFav::favExists($id, UserFav::TYPE_THUMB_UP)){
                            UserFav::change($id, UserFav::TYPE_THUMB_UP, UserFav::TYPE_THUMB_DOWN);
                        }elseif(UserFav::favExists($id, UserFav::TYPE_THUMB_DOWN)){

                        }else {
                            UserFav::add($id, $type);
                        }
                        echo json_encode (array('status'=>1,'message'=>'操作成功'));
                        break;
                    case UserFav::TYPE_THUMB_UP:
                        if(UserFav::favExists($id, UserFav::TYPE_THUMB_DOWN)){
                            UserFav::change($id, UserFav::TYPE_THUMB_DOWN, UserFav::TYPE_THUMB_UP);
                        }elseif(UserFav::favExists($id, UserFav::TYPE_THUMB_UP)){
                            
                        }else {
                            UserFav::add($id, $type);
                        }
                        echo json_encode (array('status'=>1,'message'=>'操作成功'));
                        break;
                }
            }else
                echo json_encode (array(
                    'status'=>-1,
                    'message'=>'错误的类型'
                ));
        }else
            echo json_encode(array(
                'status'=>-1,
                'message'=>'请求出错'
            ));
    }

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='article-form')
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
        unset($params['Article_sort']);
        $sortList[] = array('label'=>'按发布时间排序','url'=>$this->createUrl(Yii::app()->getController()->getRoute(),$params + array('Article_sort'=>'create_date.desc')));
        $sortList[] = array('label'=>'按修改时间排序','url'=>$this->createUrl(Yii::app()->getController()->getRoute(),$params + array('Article_sort'=>'modify_date.desc')));
        $sortList[] = array('label'=>'按浏览量排序','url'=>$this->createUrl(Yii::app()->getController()->getRoute(),$params + array('Article_sort'=>'hits.desc')));
        return $sortList;
    }

    /**
	 * Creates a new comment.
	 * This method attempts to create a new comment based on the user input.
	 * If the comment is successfully created, the browser will be redirected
	 * to show the created comment.
	 * @param Post the post that the new comment belongs to
	 * @return Comment the comment instance
	 */
	protected function newComment($article)
	{
		$comment=new Comment;
        
		if(isset($_POST['Comment']))
		{
			$comment->attributes=$_POST['Comment'];
			if($article->addComment($comment))
			{
                //添加积分
                $article->author->plusCredit(User::CREDIT_NEW_COMMENT,  Lookup::item('CreditReason', CreditLog::REASON_NEW_COMMENT));
                Yii::app()->user->setFlash('message','评论发表成功.');
				$this->redirect($comment->url);
			}
		}
		return $comment;
	}
}
