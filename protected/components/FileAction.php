<?php

/**
 * 描述 FileAction
 *
 * @author 张迪
 */
class FileAction extends CAction {

    public $viewParam = 'view';
    public $defaultView = 'index';
    public $view;
    public $basePath = 'protected/data/pages';
    public $layout;
    public $renderAsMarkDown = false;
    private $_viewPath;
    private $_pages;

    public function getRequestedView() {
        if ($this->_viewPath === null) {
            if (!empty($_GET[$this->viewParam]))
                $this->_viewPath = $_GET[$this->viewParam];
            else
                $this->_viewPath = $this->defaultView;
        }
        return $this->_viewPath;
    }

    protected function resolveView($viewPath) {
        if (preg_match('/^\w[\w\.\-]*$/', $viewPath)) {
            $view = strtr($viewPath, '.', '/').'.txt';
            if (!empty($this->basePath))
                $view = $this->basePath . '/' . $view;
            if (file_exists($view)) {
                $this->view = $view;
                return;
            }else
                return;
        }
        throw new CHttpException(404, '该页面不存在');
    }

    public function run() {
        $this->resolvePages();
        $this->resolveView($this->getRequestedView());
        
        $controller = $this->getController();
        if ($this->layout !== null) {
            $layout = $controller->layout;
            $controller->layout = $this->layout;
        }

        $this->onBeforeRender($event = new CEvent($this));
        if (!$event->handled) {
            $text = file_get_contents($this->view);
            $controller->render('//wiki/content',array('data'=>$text));
            $this->onAfterRender(new CEvent($this));
        }

        if ($this->layout !== null)
            $controller->layout = $layout;
    }

    public function resolvePages(){
        $this->_pages = require Yii::app()->basePath.'/config/pages.php';
        $controller = $this->getController();
        $controller->pageTitle = $this->_pages[$_GET['view']].$controller->titleSeparator.Yii::app()->name;
    }

    public function onBeforeRender($event) {
        $this->raiseEvent('onBeforeRender', $event);
    }

    public function onAfterRender($event) {
        $this->raiseEvent('onAfterRender', $event);
    }

}

?>
