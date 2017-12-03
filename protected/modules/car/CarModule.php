<?php

class CarModule extends CWebModule
{
	public $controllerMap = array(
		'manage' => 'car.controllers.CarManageController',
		'brands' => 'car.controllers.CarBrandsController',
		'search' => 'car.controllers.CarSearchController',
	);

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'car.models.*',
			'car.components.*',
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
