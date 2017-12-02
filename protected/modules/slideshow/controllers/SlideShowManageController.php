<?php

class SlideShowManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public static function actionsType()
	{
		return array(
			'frontend'=>array(),
			'backend' => array(
				'create',
				'update',
				'admin',
				'delete',
				'upload',
				'deleteUpload',
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess', // perform access control for CRUD operations
			'postOnly + delete,deleteSelected', // we only allow deletion via POST request
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Slideshow;

        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if (!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
        $imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/slideshow/";
        if (!is_dir($imageDIR))
            mkdir($imageDIR);

		 $this->performAjaxValidation($model);

        $image = array();
		if(isset($_POST['Slideshow']))
		{
			$model->attributes=$_POST['Slideshow'];
            if (isset($_POST['Slideshow']['image'])) {
                $file = $_POST['Slideshow']['image'];
                $image = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }
			if($model->save()) {
                if ($model->image and file_exists($tmpDIR.$model->image))
                    rename($tmpDIR . $model->image, $imageDIR . $model->image);

				Yii::app()->user->setFlash('success', 'تصویر با موفقیت افزوده شد');
			}
			else
				Yii::app()->user->setFlash('failed' , 'متاسفانه در افزودن تصویر مشکل رخ داده است.');
			$this->redirect('admin');
		}

		$this->render('create',array(
			'model'=>$model,
            'image' => $image
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

        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if (!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
        $imageDIR = Yii::getPathOfAlias("webroot") . "/uploads/slideshow/";
        $imageUrl = Yii::app()->baseUrl .'/uploads/slideshow/';

        $image = array();
        if ($model->image and file_exists($imageDIR.$model->image)) {
            $file = $model->image;
            $image = array(
                'name' => $file,
                'src' => $imageUrl . '/' . $file,
                'size' => filesize($imageDIR . $file),
                'serverName' => $file,
            );
        }

		$this->performAjaxValidation($model);

		if(isset($_POST['Slideshow']))
		{
			$model->attributes=$_POST['Slideshow'];

            if (isset($_POST['Slideshow']['image']) and file_exists($tmpDIR.$_POST['Slideshow']['image'])) {
                $file = $_POST['Slideshow']['image'];
                $image = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }

			if($model->save())
			{
                if ($model->image and file_exists($tmpDIR.$model->image))
                    rename($tmpDIR . $model->image, $imageDIR . $model->image);

				Yii::app()->user->setFlash('success' , 'تصویر با موفقیت افزوده شد');
			}
			else
				Yii::app()->user->setFlash('failed' , 'متاسفانه در افزودن تصویر مشکل رخ داده است.');
			$this->redirect(Yii::app()->createUrl('/slideshow/manage/admin'));
			Yii::app()->end;
		}

		$this->render('update',array(
			'model'=>$model,
            'image' => $image
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
		$filePath = Yii::getPathOfAlias('webroot') . '/uploads/slideshow/';
		@unlink($filePath.$model->image);
		$model->delete();
		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Slideshow('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Slideshow']))
			$model->attributes=$_GET['Slideshow'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Slideshow the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Slideshow::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Slideshow $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='slideshow-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
    public function actionUpload()
    {
        $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp';

        if (!is_dir($tempDir))
            mkdir($tempDir);
        if (isset($_FILES)) {
            $file = $_FILES['image'];
            $ext = pathinfo($file['name'], PATHINFO_EXTENSION);
            $file['name'] = Controller::generateRandomString(5) . time();
            while (file_exists($tempDir . DIRECTORY_SEPARATOR . $file['name'].'.'.$ext))
                $file['name'] = Controller::generateRandomString(5) . time();
            $file['name'] = $file['name'] . '.' . $ext;
            if (move_uploaded_file($file['tmp_name'], $tempDir . DIRECTORY_SEPARATOR . CHtml::encode($file['name'])))
                $response = ['state' => 'ok', 'fileName' => CHtml::encode($file['name'])];
            else
                $response = ['state' => 'error', 'msg' => 'فایل آپلود نشد.'];
        } else
            $response = ['state' => 'error', 'msg' => 'فایلی ارسال نشده است.'];
        echo CJSON::encode($response);
        Yii::app()->end();
    }

    public function actionDeleteUpload()
    {
        $Dir = Yii::getPathOfAlias("webroot") . '/uploads/slideshow/';

        if (isset($_POST['fileName'])) {

            $fileName = $_POST['fileName'];

            $tempDir = Yii::getPathOfAlias("webroot") . '/uploads/temp/';

            $model = Slideshow::model()->findByAttributes(array('image' => $fileName));
            if ($model) {
                if (@unlink($Dir . $model->image)) {
                    $model->updateByPk($model->id,array('image'=>null));
                    $response = ['state' => 'ok', 'msg' => $this->implodeErrors($model)];
                } else
                    $response = ['state' => 'error', 'msg' => 'مشکل ایجاد شده است'];
            } else {
                @unlink($tempDir . $fileName);
                $response = ['state' => 'ok', 'msg' => 'حذف شد.'];
            }
            echo CJSON::encode($response);
            Yii::app()->end();
        }
    }
}
