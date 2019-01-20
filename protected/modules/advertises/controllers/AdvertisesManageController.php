<?php

class AdvertisesManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $bannerPath = 'uploads/advertises';
	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess - upload, deleteUpload', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

    public function actions()
    {
        return array(
            'upload' => array( // brand logo upload
                'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
                'attribute' => 'banner',
                'rename' => 'random',
                'validateOptions' => array(
                    'acceptedTypes' => array('png', 'jpg', 'jpeg')
                )
            ),
            'deleteUpload' => array( // delete brand logo uploaded
                'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
                'modelName' => 'Advertises',
                'attribute' => 'banner',
                'uploadDir' => "/$this->bannerPath/",
                'storedMode' => 'field'
            )
        );
    }

	/**
	* @return array actions type list
	*/
	public static function actionsType()
	{
		return array(
			'backend' => array(
				'index', 'create', 'update', 'admin', 'delete'
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
	public function actionCreate()
	{
		$model=new Advertises;
        $banner = [];
		if(isset($_POST['Advertises']))
		{
			$model->attributes=$_POST['Advertises'];
            $banner = new UploadedFiles($this->tempPath, $model->banner);
			if($model->save()){
                $banner->move($this->bannerPath);
				Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
		}

		$this->render('create',array(
			'model'=>$model, 'banner' => $banner
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
        $banner = new UploadedFiles($this->bannerPath, $model->banner);

		if(isset($_POST['Advertises'])) {
            $old = $model->banner;
            $model->attributes = $_POST['Advertises'];
            if ($model->save()) {
                $banner->update($old, $model->banner, $this->tempPath);
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                $this->redirect(array('admin'));
            } else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

		$this->render('update',array(
			'model'=>$model, 'banner' => $banner
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
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
//        Yii::app()->db->createCommand('UPDATE `ym_advertises` SET `type`=2;')->execute();
//	    Yii::app()->db->createCommand('ALTER TABLE `ym_advertises`
//ADD COLUMN `script`  text NULL AFTER `status`,
//ADD COLUMN `type`  decimal(1,0) UNSIGNED NULL DEFAULT 1 AFTER `script`;')->execute();
		$model=new Advertises('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Advertises']))
			$model->attributes=$_GET['Advertises'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Advertises the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Advertises::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Advertises $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='advertises-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
