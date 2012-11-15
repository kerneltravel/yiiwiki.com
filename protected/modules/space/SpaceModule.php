<?php

class SpaceModule extends DbWebModule
{
	public function init()
	{
        parent::init();
		// import the module-level models and components
		$this->setImport(array(
			'space.models.*',
			'space.components.*',
		));
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
}
