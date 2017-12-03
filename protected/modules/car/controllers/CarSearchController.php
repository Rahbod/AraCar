<?php

class CarSearchController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/inner';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array();
	}

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'frontend' => array(
				'brand',
			)
		);
	}

	/**
	 * Search cars by brand and model name.
	 */
	public function actionBrand()
	{
        Yii::app()->theme = 'frontend';
		$brand = null;
		if (isset($_POST['Search']))
			$brand = $_POST['Search']['brand'];
		elseif (Yii::app()->request->getQuery('title'))
			$brand = Yii::app()->request->getQuery('title');
		else
			$this->redirect(['/site']);

		$criteria = new CDbCriteria();
		$criteria->with = ['brand'];
		$criteria->compare('brand.title', $brand, true);
		$dataProvider = new CActiveDataProvider('Cars', [
			'criteria' => $criteria,
		]);

		$this->render('cars-list', array(
			'brand' => Brands::model()->findByAttributes(['slug' => $brand]),
			'dataProvider' => $dataProvider,
		));
	}
}