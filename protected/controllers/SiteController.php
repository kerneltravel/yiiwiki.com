<?php

class SiteController extends Controller
{
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
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'FileAction',
			),
            'script'=>array(
                'class'=>'ScriptAction'
            )
		);
	}

	/**
	 * This is the default 'index' action that is invoked
	 * when an action is not explicitly requested by users.
	 */
	public function actionIndex()
	{
        $cr = new CDbCriteria;
        $cr->order = 'modify_date desc,hits desc';
        $cr->limit = 10;

        $newsProvider = new CActiveDataProvider('News', array(
            'criteria'=>$cr,
            'pagination'=>false
        ));
        $articleProvider = new CActiveDataProvider('Article', array(
            'criteria'=>$cr,
            'pagination'=>false
        ));
		$this->render('index',array(
            'newsProvider'=>$newsProvider,
            'articleProvider'=>$articleProvider,
        ));
	}

    public function actionSearch(){
        $model = new SearchForm;
        $wikiCriteria = new CDbCriteria;
        $wikiCriteria->addColumnCondition(array('type'=>  ArticleAR::TYPE_WIKI));
        $newsCriteria = new CDbCriteria;
        $newsCriteria->addColumnCondition(array('type'=>  ArticleAR::TYPE_NEWS));
        
        if(isset ($_GET['SearchForm']['keywords']) && !empty($_GET['SearchForm']['keywords'])){
            $model->keywords = $_GET['SearchForm']['keywords'];
            $wikiCriteria->addSearchCondition('title', $model->keywords);
            $newsCriteria->addSearchCondition('title', $model->keywords);
        }

        $wikiDataProvider = new CActiveDataProvider('Article', array(
            'criteria'=>$wikiCriteria,
        ));

        $newsDataProvider = new CActiveDataProvider('News', array(
            'criteria'=>$newsCriteria,
        ));
        $this->render('search',array(
            'wikiDataProvider'=>$wikiDataProvider,
            'newsDataProvider'=>$newsDataProvider,
            'model'=>$model
        ));
    }

    public function actionTag(){
        $wikiCriteria = new CDbCriteria;
        $wikiCriteria->addColumnCondition(array('type'=>  ArticleAR::TYPE_WIKI));
        $newsCriteria = new CDbCriteria;
        $newsCriteria->addColumnCondition(array('type'=>  ArticleAR::TYPE_NEWS));

        if(isset ($_GET['tag']) && !empty($_GET['tag'])){
            $tag = $_GET['tag'];
            $wikiCriteria->addSearchCondition('tags', $tag);
            $newsCriteria->addSearchCondition('tags', $tag);
        }

        $wikiDataProvider = new CActiveDataProvider('Article', array(
            'criteria'=>$wikiCriteria,
        ));

        $newsDataProvider = new CActiveDataProvider('News', array(
            'criteria'=>$newsCriteria,
        ));
        $this->render('tag',array(
            'wikiDataProvider'=>$wikiDataProvider,
            'newsDataProvider'=>$newsDataProvider,
            'tag'=>$tag
        ));
    }


    /**
	 * This is the action to handle external exceptions.
	 */
	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}

	/**
	 * Displays the contact page
	 */
	public function actionContact()
	{
		$model=new ContactForm;
		if(isset($_POST['ContactForm']))
		{
			$model->attributes=$_POST['ContactForm'];
			if($model->validate())
			{
				$headers="From: {$model->email}\r\nReply-To: {$model->email}";
				mail(Yii::app()->params['adminEmail'],$model->subject,$model->body,$headers);
				Yii::app()->user->setFlash('contact','感谢您联系我们. 我们将会及时回复您.');
				$this->refresh();
			}
		}
		$this->render('contact',array('model'=>$model));
	}

    public function actionFeed(){
        Yii::import('ext.feed.*');
        $feed = new EFeed();

        $feed->title= Yii::app()->name;
        $feed->description = Yii::app()->params['site']['description'];
        $feed->addChannelTag('language', 'zh_cn');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));
        $feed->addChannelTag('link', $this->createAbsoluteUrl('site/feed'));

        $models = Article::model()->findAll();
        foreach($models as $model){
            $item = $feed->createNewItem();
            $item->title = $model->title;
            $item->link = $model->getAbsoluteUrl();
            $item->date = $model->modify_date;
            $item->description = $model->getSummary();
            $feed->addItem($item);
        }
        

        $feed->generateFeed();
        Yii::app()->end();
    }

    public function actionSitemap(){
        $sitemap = Yii::createComponent(array('class'=>'ext.extsitemap.ExtSitemap'));
        $item = $sitemap->createUrlItem();
        $item->loc = Yii::app()->createUrl('/');
        $item->lastmod =time();
        $item->priority = '1.0';
        $item->changefreq = 'daily';
        $sitemap->addUrlItem($item);

        //添加教程分类
        foreach(Lookup::items(Article::CATEGORY_TYPE) as $key=>$category){
            $item = $sitemap->createUrlItem();
            $item->loc = CHtml::encode(Article::createCategoryUrl($key));
            $item->lastmod = time();
            $item->priority = '0.5';
            $item->changefreq = 'daily';
            $sitemap->addUrlItem($item);
        }

        //添加新闻分类
        foreach(Lookup::items(News::CATEGORY_TYPE) as $key=>$category){
            $item = $sitemap->createUrlItem();
            $item->loc = CHtml::encode(News::createCategoryUrl($key));
            $item->lastmod = time();
            $item->priority = '0.5';
            $item->changefreq = 'daily';
            $sitemap->addUrlItem($item);
        }

        //添加标签

        $tags = Tag::model()->findAll();
        foreach($tags as $tag){
            $item = $sitemap->createUrlItem();
            $item->loc = CHtml::encode(Tag::getUrl($tag->name));
            $item->lastmod = time();
            $item->priority = '0.3';
            $item->changefreq = 'daily';
            $sitemap->addUrlItem($item);
        }

        //添加文章

        $articles = ArticleAR::model()->findAll(array('select'=>'id,title,type,modify_date'));
        foreach($articles as $article){
            $item = $sitemap->createUrlItem();
            $item->loc = CHtml::encode($article->getUrl());
            $item->lastmod = $article->modify_date;
            $item->priority = '0.2';
            $item->changefreq = 'weekly';
            $sitemap->addUrlItem($item);
        }

        $sitemap->render();
    }
}