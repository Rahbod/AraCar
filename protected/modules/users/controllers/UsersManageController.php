<?php

class UsersManageController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';
    public $defaultAction = 'admin';

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'index',
                'view',
                'create',
                'update',
                'admin',
                'delete',
                'userTransactions',
                'transactions',
                'dealerships',
                'createDealership',
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
            'postOnly + delete', // we only allow deletion via POST request
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
     * If creation is successful, the browser will be redirected to the 'views' page.
     */
    /*public function actionCreate()
    {
        $model = new Users();

        // Uncomment the following line if AJAX validation is needed
        // $this->performAjaxValidation($model);

        if(isset($_POST['Users'])){
            $model->attributes = $_POST['Users'];
            if($model->save())
                $this->redirect(array('views', 'id' => $model->id));
        }

        $this->render('create', array(
            'model' => $model,
        ));
    }*/

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'views' page.
     */
    public function actionCreateDealership()
    {
        $model = new Users();
        $model->setScenario('create-dealership');

        $tmpDIR = Yii::getPathOfAlias("webroot") . '/uploads/temp/';
        if (!is_dir($tmpDIR))
            mkdir($tmpDIR);
        $tmpUrl = Yii::app()->baseUrl .'/uploads/temp/';
        $avatarDIR = Yii::getPathOfAlias("webroot") . "/uploads/users/avatar/";
        if (!is_dir($avatarDIR))
            mkdir($avatarDIR);

        $this->performAjaxValidation($model);

        $avatar = array();
        if(isset($_POST['Users'])) {
            $model->attributes = $_POST['Users'];
            $model->role_id = 2;
            $model->status = 'active';

            if (isset($_POST['Users']['avatar'])) {
                $file = $_POST['Users']['avatar'];
                $avatar = array(
                    'name' => $file,
                    'src' => $tmpUrl . '/' . $file,
                    'size' => filesize($tmpDIR . $file),
                    'serverName' => $file,
                );
            }

            if ($model->save()) {
                if ($model->avatar and file_exists($tmpDIR.$model->avatar))
                    rename($tmpDIR . $model->avatar, $avatarDIR . $model->avatar);

                Yii::app()->user->setFlash('success', 'اطلاعات با موفقیت ثبت شد.');
                $this->refresh();
            }else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('create-dealership', array(
            'model' => $model,
            'avatar' => $avatar
        ));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'views' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $model->scenario = 'changeStatus';
        if(isset($_POST['Users'])){
            $model->attributes = $_POST['Users'];
            if($model->save()){
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                if(isset($_POST['ajax'])){
                    echo CJSON::encode(['status' => 'ok']);
                    Yii::app()->end();
                }else
                    $this->redirect(array('admin'));
            }else{
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
                if(isset($_POST['ajax'])){
                    echo CJSON::encode(['status' => 'error']);
                    Yii::app()->end();
                }
            }
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
        if($model->status == 'deleted')
            $model->delete();
        $model->updateByPk($model->id, array('status' => 'deleted'));

        // if AJAX request (triggered by deletion via admin grid views), we should not redirect the browser
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
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Users']))
            $model->attributes = $_GET['Users'];
        $model->role_id = 1;
        $this->render('admin', array(
            'model' => $model,
        ));
    }

    /**
     * Manages all models.
     */
    public function actionDealerships()
    {
        $model = new Users('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['Users']))
            $model->attributes = $_GET['Users'];
        $model->role_id = 2;
        $this->render('dealerships', array(
            'model' => $model,
        ));
    }

    /**
     * Show User Transactions
     *
     * @param $id
     */
    public function actionUserTransactions($id)
    {
        $model =new UserTransactions('search');
        $model->unsetAttributes();
        if(isset($_GET['UserTransactions']))
            $model->attributes = $_GET['UserTransactions'];
        $model->user_id = $id;
        //

        $this->render('user_transactions', array(
            'model' => $model
        ));
    }

    public function actionTransactions()
    {
        Yii::app()->theme = 'abound';
        $this->layout = '//layouts/main';

        $model = new UserTransactions('search');
        $model->unsetAttributes();  // clear any default values
        if (isset($_GET['UserTransactions']))
            $model->attributes = $_GET['UserTransactions'];

        $this->render('admin_transactions', array(
            'model' => $model,
        ));
    }

    /**
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return Users the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Users::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    /**
     * Performs the AJAX validation.
     * @param Users $model the model to be validated
     */
    protected function performAjaxValidation($model)
    {
        if(isset($_POST['ajax']) && $_POST['ajax'] === 'users-form'){
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }
}