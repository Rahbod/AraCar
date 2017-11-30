<?php

class ListsManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'index', 'create', 'update', 'admin', 'delete', 'options', 'addOption', 'editOption'
			)
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view', array(
			'model' => $this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model = new Lists;

		if(isset($_POST['Lists'])){
			$model->attributes = $_POST['Lists'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create', array(
			'model' => $model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if(isset($_POST['Lists'])){
			$model->title = $_POST['Lists']['title'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->redirect(array('manage/options/'.$id));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Lists('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Lists']))
			$model->attributes = $_GET['Lists'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * @param $id
	 */
	public function actionOptions($id)
	{
		$model = new Lists('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Lists']))
			$model->attributes = $_GET['Lists'];
		$model->parent_id = $id;

		$this->render('options', array(
			'model' => $model,
            'list' => $this->loadModel($id)
		));
	}

	public function actionAddOption()
	{
		$model = new Lists('option_insert');
		$result = false;
		if(isset($_POST['Lists'])){
			$model->title = trim($_POST['Lists']['title']);
			$model->parent_id = $_POST['Lists']['parent_id'];
			$model->editable = 1;
			$model->is_root = 0;
			if($model->save()){
				if(Yii::app()->request->isAjaxRequest)
					$result = ['status' => true, 'msg' => 'گزینه جدید با موفقیت اضافه شد.'];
				else
					Yii::app()->user->setFlash('success', 'گزینه جدید با موفقیت اضافه شد.');
			}else{
				if(Yii::app()->request->isAjaxRequest)
					$result = ['status' => false, 'msg' => 'متاسفانه مشکلی در ثبت بوجود آمده است. لطفا مجددا تلاش فرمایید.'];
				else
					Yii::app()->user->setFlash('failed', 'متاسفانه مشکلی در ثبت بوجود آمده است. لطفا مجددا تلاش فرمایید.');
			}

			if($result){
				echo CJSON::encode($result);
				Yii::app()->end();
			}else
				$this->redirect(array('options' . $model->parent_id));
		}
		$this->redirect(array('admin'));
	}

    public function actionEditOption()
	{
		/** @var $model Lists */
		$model = $this->loadModel($_POST['Lists']['id']);
        $model->setScenario('option_update');
		$result = false;
		if(isset($_POST['Lists'])){
			$model->title = trim($_POST['Lists']['title']);
			if($model->save()){
				if(Yii::app()->request->isAjaxRequest)
					$result = ['status' => true, 'msg' => 'گزینه جدید با موفقیت ویرایش شد.'];
				else
					Yii::app()->user->setFlash('success', 'گزینه جدید با موفقیت ویرایش شد.');
			}else{
				if(Yii::app()->request->isAjaxRequest)
					$result = ['status' => false, 'msg' => 'متاسفانه مشکلی در ویرایش بوجود آمده است. لطفا مجددا تلاش فرمایید.'];
				else
					Yii::app()->user->setFlash('failed', 'متاسفانه مشکلی در ویرایش بوجود آمده است. لطفا مجددا تلاش فرمایید.');
			}

			if($result){
				echo CJSON::encode($result);
				Yii::app()->end();
			}else
				$this->redirect(array('options' . $model->parent_id));
		}
		$this->redirect(array('admin'));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Lists
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model = Lists::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Lists $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'lists-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}