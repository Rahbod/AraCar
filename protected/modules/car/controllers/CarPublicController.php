<?php

class CarPublicController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/public';
	public $tempPath = 'uploads/temp';
	public $imagePath = 'uploads/cars';


	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess + sell', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	* @return array actions type list
	*/
	public static function actionsType()
	{
		return array(
			'frontend' => array(
				'index', 'sell', 'view',
                'getBrandModels', 'getModelYears',
				'upload', 'deleteUpload'
			)
		);
	}

	public function actions()
	{
		return array(
			'upload' => array( // brand logo upload
				'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
				'attribute' => 'images',
				'rename' => 'random',
				'validateOptions' => array(
					'acceptedTypes' => array('png', 'jpg', 'jpeg')
				)
			),
			'deleteUpload' => array( // delete brand logo uploaded
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'CarImages',
				'attribute' => 'filename',
				'uploadDir' => '/uploads/cars/',
				'storedMode' => 'record'
			)
		);
	}
	
	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionSell()
	{
		Yii::app()->theme = "frontend";
		$this->layout= '//layouts/inner';
		$this->pageTitle = 'فروش خودرو';
		$this->pageHeader = 'فروش خودرو';
		$this->pageDescription = 'درج آگهی فروش با چند کلیک ساده';

		$model=new Cars();

		$images = [];
		if(isset($_POST['Cars']))
		{
			$model->attributes=$_POST['Cars'];
            $model->user_id = Yii::app()->user->getId();
            $model->create_date = time();
            $model->status = Cars::STATUS_PENDING;
            $images = new UploadedFiles($this->tempPath, $model->images);
            if($model->save()){
                $images->move($this->imagePath);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('/dashboard'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('sell',array(
			'model'=>$model,
			'images' => $images
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
        $model->oldImages = $model->images;
        $images = new UploadedFiles($this->imagePath, $model->images);
		if(isset($_POST['Cars']))
		{
            // store model image value in oldImage variable
            $oldImages = $model->images;
            $model->attributes = $_POST['Cars'];
            if($model->save()){
                $images->update($oldImages, $model->images, $this->tempPath, true);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('update',array(
			'model'=>$model,
		));
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
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		echo 1;
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Cars('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Cars']))
			$model->attributes=$_GET['Cars'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Cars the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Cars::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Cars $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='cars-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function actionGetBrandModels(){
        if(isset($_GET['id']) && !empty((int)$_GET['id'])){
            $id = $_GET['id'];
            $models = Models::model()->findAllByAttributes(['brand_id' => $id]);
            $list=[];
            foreach($models as $item)
                $list[] = array('id' => $item->id, 'title' => $item->title);
            echo CJSON::encode(['status'=> true, 'list' => $list]);
        }else if(!isset($_GET['id']))
            echo CJSON::encode(['status'=> false, 'message' => 'خطا در دریافت اطلاعات.']);
        Yii::app()->end();
    }
    
    public function actionGetModelYears(){
        if(isset($_GET['id']) && !empty((int)$_GET['id'])){
            $id = $_GET['id'];
            $model = Models::model()->findByPk($id);
            echo CJSON::encode(['status'=> true, 'list' => $model->getYears('ajax')]);
        }else
            echo CJSON::encode(['status'=> false, 'message' => 'خطا در دریافت اطلاعات.']);
        Yii::app()->end();
    }

    public function actionGetStateCities(){
        if(isset($_GET['id']) && !empty((int)$_GET['id'])){
            $id = $_GET['id'];
            $models = Places::model()->findAllByAttributes(['town_id' => $id]);
            $list=[];
            foreach($models as $item)
                $list[] = array('id' => $item->id, 'title' => $item->name);
            echo CJSON::encode(['status'=> true, 'list' => $list]);
        }else
            echo CJSON::encode(['status'=> false, 'message' => 'خطا در دریافت اطلاعات.']);
        Yii::app()->end();
    }
}
