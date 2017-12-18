<?php

class CarBrandsController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column2';
	public $tempPath = 'uploads/temp';
	public $logoPath = 'uploads/brands';
	public $modelImagePath = 'uploads/brands/models';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess'
		);
	}

	/**
	 * @return array actions type list
	 */
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'index', 'create', 'update', 'admin', 'delete', 'upload', 'deleteUpload',
				'models', 'modelAdd', 'modelEdit', 'modelDelete', 'modelDetailAdd', 'modelDetailEdit', 'modelDetailDelete',
				'order', 'uploadModelImage', 'deleteUploadModelImage'
			)
		);
	}

	public function actions()
	{
		return array(
			'upload' => array( // brand logo upload
				'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
				'attribute' => 'logo',
				'rename' => 'random',
				'validateOptions' => array(
					'acceptedTypes' => array('png', 'jpg', 'jpeg')
				)
			),
			'deleteUpload' => array( // delete brand logo uploaded
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'Brands',
				'attribute' => 'logo',
				'uploadDir' => '/uploads/brands/',
				'storedMode' => 'field'
			),
			'uploadModelImage' => array( // model image upload
				'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
				'attribute' => 'images',
				'rename' => 'random',
				'validateOptions' => array(
					'acceptedTypes' => array('png', 'jpg', 'jpeg')
				)
			),
			'deleteUploadModelImage' => array( // delete model image uploaded
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'ModelDetails',
				'attribute' => 'images',
				'uploadDir' => '/uploads/brands/models/',
				'storedMode' => 'json'
			),
			'order' => array( // ordering models
				'class' => 'ext.yiiSortableModel.actions.AjaxSortingAction',
			),
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
		$model = new Brands;
		$logo = [];
		if(isset($_POST['Brands'])){
			$model->attributes = $_POST['Brands'];
			$logo = new UploadedFiles($this->tempPath, $model->logo);
			if($model->save()){
				$logo->move($this->logoPath);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد. لطفا مدل های این برند را ثبت کنید.');
				$this->redirect(array('brands/models/' . $model->id));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create', array(
			'model' => $model,
			'logo' => $logo
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

		$logo = new UploadedFiles($this->logoPath, $model->logo);
		if(isset($_POST['Brands'])){
			// store model image value in oldImage variable
			$oldLogo = $model->logo;
			$model->attributes = $_POST['Brands'];
			if($model->save()){
				$logo->update($oldLogo, $model->logo, $this->tempPath);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update', array(
			'model' => $model,
			'logo' => $logo
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);
		$logo = new UploadedFiles($this->logoPath, $model->logo);
		$logo->remove($model->logo, true);
		foreach($model->models as $m){
			foreach($m->years as $detail){
				$images = new UploadedFiles($this->modelImagePath, $detail->images);
				$images->removeAll(true);
			}
		}
		$model->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax'])){
			Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;آیتم با موفقیت حذف شد.');
			$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('admin'));
		}
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
		$model = new Brands('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Brands']))
			$model->attributes = $_GET['Brands'];

		$this->render('admin', array(
			'model' => $model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @param bool $models
	 * @return Brands|Models the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id, $models = false)
	{
		$model = $models?Models::model()->findByPk($id):Brands::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * @param $id
	 * @return ModelDetails
	 * @throws CHttpException
	 */
	public function loadDetailsModel($id)
	{
		$model = ModelDetails::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404, 'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Brands $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'brands-form'){
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * @param $id
	 * @throws CHttpException
	 */
	public function actionModels($id)
	{
		$model = $this->loadModel($id);
		$modelsSearch = new Models('search');
		if(isset($_GET['Models']))
			$modelsSearch->attributes = $_GET['Models'];
		$modelsSearch->brand_id = $id;

		$this->render('models', [
			'model' => $model,
			'modelsSearch' => $modelsSearch
		]);
	}
	
	public function actionModelAdd()
	{
		$model = new Models;

		if(isset($_GET['ajax']) && $_GET['ajax'] === 'create-model-form'){
			$model->attributes = $_POST['Models'];
			$errors = CActiveForm::validate($model);
			if(CJSON::decode($errors)){
				echo $errors;
				Yii::app()->end();
			}
		}
		if(isset($_POST['Models'])){
			$model->attributes = $_POST['Models'];
			if($model->save()){
				echo CJSON::encode(array('status' => true, 'msg' => 'اطلاعات با موفقیت ذخیره شد.', 
					'url' => $this->createUrl('brands/modelEdit/'.$model->id)));
			}else
				echo CJSON::encode(array('status' => false, 'msg' => 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.'));
		}
		Yii::app()->end();
	}

	/**
	 * @param $id
	 * @throws CException
	 * @throws CHttpException
	 */
	public function actionModelEdit($id)
	{
		$model = $this->loadModel($id, true);

		if(isset($_POST['Models'])){
			$model->attributes = $_POST['Models'];
			if($model->save()){
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->refresh();
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$details = new ModelDetails('search');
		if(isset($_GET['ModelDetails']))
			$details->attributes = $_GET['ModelDetails'];
		$details->model_id = $model->id;

		$this->render('update_model', array(
			'model' => $model,
			'details' => $details
		));
	}

	public function actionModelDelete($id)
	{
		$model = $this->loadModel($id, true);
		$brID = $model->brand_id;
		foreach($model->details as $detail){
			$images = new UploadedFiles($this->modelImagePath, $detail->images);
			$images->removeAll(true);
		}
		$model->delete();

		if(!isset($_GET['ajax'])){
			Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;آیتم با موفقیت حذف شد.');
			$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('brands/models/'.$brID));
		}
	}


	public function actionModelDetailAdd()
	{
		$model = new ModelDetails;

		if(isset($_GET['ajax']) && $_GET['ajax'] === 'create-model-detail-form'){
			$model->attributes = $_POST['ModelDetails'];
			$errors = CActiveForm::validate($model);
			if(CJSON::decode($errors)){
				echo $errors;
				Yii::app()->end();
			}
		}
		if(isset($_POST['ModelDetails'])){
			$model->attributes = $_POST['ModelDetails'];
			$images = new UploadedFiles($this->tempPath,$model->images);
			if($model->save()){
				$images->move($this->modelImagePath);
				echo CJSON::encode(array('status' => true, 'msg' => 'اطلاعات با موفقیت ذخیره شد.',
					'url' => $this->createUrl('brands/modelEdit/'.$model->model_id)));
			}else
				echo CJSON::encode(array('status' => false, 'msg' => 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.'));
		}
		Yii::app()->end();
	}

	/**
	 * @param $id
	 * @throws CException
	 * @throws CHttpException
	 */
	public function actionModelDetailEdit($id)
	{
		$model = $this->loadDetailsModel($id);
		$images = new UploadedFiles($this->modelImagePath, $model->images);

		if(isset($_POST['ModelDetails'])){
			// store model image value in oldImage variable
			$oldImages = $model->images;
			$model->attributes = $_POST['ModelDetails'];
			if($model->save()){
				$images->update($oldImages, $model->images, $this->tempPath, true);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->refresh();
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update_model_details', array(
			'model' => $model,
			'images' => $images
		));
	}

	public function actionModelDetailDelete($id)
	{
		$model = $this->loadDetailsModel($id);
		$mID = $model->model_id;
		$images = new UploadedFiles($this->modelImagePath, $model->images);
		$images->removeAll(true);
		$model->delete();

		if(!isset($_GET['ajax'])){
			Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;آیتم با موفقیت حذف شد.');
			$this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('brands/modelEdit/'.$mID));
		}
	}
}