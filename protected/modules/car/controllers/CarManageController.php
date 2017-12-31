<?php

class CarManageController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $tempPath = 'uploads/temp';
    public $imagePath = 'uploads/cars';

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
                'index', 'create', 'update', 'admin', 'recycleBin', 'restore', 'delete', 'changeStatus'
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
        $model = new Cars;

        if(isset($_POST['Cars'])){
            $model->attributes = $_POST['Cars'];
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

        if(isset($_POST['Cars'])){
            $model->attributes = $_POST['Cars'];
            if($model->save()){
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                $this->redirect(array('admin'));
            }else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('update', array(
            'model' => $model,
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
        // status changed to deleted
        if($model->status != Cars::STATUS_DELETED){
            $model->status = Cars::STATUS_DELETED;
            $model->normalizePrice();
            $model->save(false);
        }else{
            // delete for ever
            $images = new UploadedFiles($this->imagePath, CHtml::listData($model->carImages, 'id', 'filename'));
            $images->removeAll(true);
            $model->delete();
        }

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
        $model = new Cars('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Cars']))
            $model->attributes = $_GET['Cars'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionRecycleBin()
    {
        $model = new Cars('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Cars']))
            $model->attributes = $_GET['Cars'];

        $this->render('recycle_bin', array(
            'model' => $model,
        ));
    }

    /**
     * Restore deleted course from recycle bin
     * @param $id
     * @throws CDbException
     * @throws CHttpException
     */
    public function actionRestore($id)
    {
        $model = $this->loadModel($id);
        $model->status = Cars::STATUS_PENDING;
        $model->normalizePrice();
        if($model->save(false))
            Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;با موفقیت بازیابی شد.');
        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl'])?$_POST['returnUrl']:array('recycleBin'));
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
        $model = Cars::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Cars $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'cars-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionChangeStatus()
    {
        $model = $this->loadModel($_POST['id']);
        if(key_exists($_POST['value'], $model->statusLabels)){
            $model->status = $_POST['value'];
            $model->normalizePrice();
            if($model->save(false)){
                echo CJSON::encode(array(
                    'status' => true,
                    'message' => 'با موفقیت انجام شد.'
                ));
                Yii::app()->end();
            }
        }
        echo CJSON::encode(array(
            'status' => false,
            'message' => 'خطا در انجام عملیات.'
        ));
    }
}