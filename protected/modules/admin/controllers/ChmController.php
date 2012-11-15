<?php

class ChmController extends AController
{
    public $docPath = 'docs/doc';
    public $charset = 'gb2312';
    public $name = 'Yii学习手册-Yii中文百科';
    
    public function getCategories(){
        $categories = array();

        foreach(Lookup::items(Article::CATEGORY_TYPE) as $key=>$category){
            $cat['articles'] = Article::model()->findAll('category=:category',array(':category'=>$key));
            $cat['name'] = $category;
            $categories[] = $cat;
        }
        return $categories;
    }

    public function getTags(){
        return Tag::model()->findAll();
    }
    
    public function actionGenerateAll()
	{
        $this->moveCss();
        $this->generate('index','index.html');
        $this->generate('chmIndex', 'manual.hhk');
        $this->generate('chmProject', 'manual.hhp');
        $this->generate('chmContents', 'manual.hhc');
        $this->generateAllArticle();
        $this->layout = 'column2';
        $this->renderText("生成完成");
	}

    public function actionPublish(){
        $model = new Chm();

        if(isset($_POST['Chm'])){
            $model->setAttributes($_POST['Chm']);
            if($model->save()){
                Yii::app()->user->setFlash('message','发布成功！');
                $this->refresh();
            }
        }
        
        $this->render('publish',array('model'=>$model));
    }

    public function actionEdit($id){
        $model = $this->load($id);

        if(isset($_POST['Chm'])){
            $model->setAttributes($_POST['Chm']);
            if($model->save()){
                Yii::app()->user->setFlash('message','修改成功！');
                $this->refresh();
            }
        }

        $this->render('edit',array('model'=>$model));

    }

    protected function load($id){
        $model = Chm::model()->findByPk((int)$id);
        if($model === null)
            new CHttpException (200, "错误的请求");
        else
            return $model;
    }

    public function actionAdmin(){
        $model = new Chm;
        $model->unsetAttributes();

        if(isset($_GET['Chm'])){
            $model->setAttributes($_GET['Chm']);
        }

        $this->render('admin',array('model'=>$model));
    }

    protected function generate($view,$filename,$params = array(),$includeLayout = false,$return = true){
        if($includeLayout)
            $content = $this->render($view,$params,$return);
        else
            $content = $this->renderPartial($view,$params,$return);
        file_put_contents($this->docPath.'/'.$filename,iconv('utf-8', $this->charset,$content));
    }

    protected function generateAllArticle(){
        $models = Article::model()->findAll(array('select'=>'id'));
        foreach($models as $model)
            $this->generateArticle ($model->id);
    }

    protected function generateArticle($articleId){
        $this->charset = 'utf-8';
        $this->layout ='/chm/main';
        $model = Article::model()->findByPk($articleId);
        $this->generate('article', $articleId.'.html',array('model'=>$model),true);
    }

    protected function moveCss($force = false){
        if(!file_exists($this->docPath.'/css') || $force)
            CFileHelper::copyDirectory ('protected/data/chm/css', $this->docPath.'/css');
    }
}