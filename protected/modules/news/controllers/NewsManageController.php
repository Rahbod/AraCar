<?php

class NewsManageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';
    public $imagePath = 'uploads/news';
    public $fileOptions = ['thumbnail' => ['width' => 150, 'height' => 150], 'resize' => ['width' => 600, 'height' => 400]];

	/**
	 * @return array action filters
	 */
	public static function actionsType()
	{
		return array(
			'frontend'=>array(
				'index',
				'tag',
				'view',
				'latest',
			),
			'backend' => array(
				'create',
				'update',
				'admin',
				'delete',
				'upload',
				'deleteUpload',
				'order'
			)
		);
	}

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'checkAccess + create, update, admin, delete, upload, deleteUpload, order', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	public function actions()
	{
		return array(
			'upload' => array( // news image upload
				'class' => 'ext.dropZoneUploader.actions.AjaxUploadAction',
				'attribute' => 'image',
				'rename' => 'random',
				'validateOptions' => array(
					'acceptedTypes' => array('png', 'jpg', 'jpeg')
				)
			),
			'deleteUpload' => array( // delete news image uploaded
				'class' => 'ext.dropZoneUploader.actions.AjaxDeleteUploadedAction',
				'modelName' => 'News',
				'attribute' => 'image',
				'uploadDir' => '/uploads/news/',
				'storedMode' => 'field'
			),
			'order' => array(
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
		Yii::app()->theme = 'frontend';
		$this->layout = '//layouts/blog';
		$model = $this->loadModel($id);
		$this->keywords = $model->getKeywords();
		$this->description = mb_substr(strip_tags($model->summary),0,160,'UTF-8');
		$this->pageTitle = $model->title;
		// increase seen counter
		Yii::app()->db->createCommand()->update('{{news}}',array('seen'=>((int)$model->seen+1)),'id = :id',array(":id"=>$model->id));

		// get similar news
		$criteria = News::getValidNews();
		$criteria->addCondition('id <> :id');
		$criteria->addCondition('category_id = :catID');
		$criteria->params = array(':id' => $id, ':catID'=>$model->category_id);
		$criteria->limit = 5;
		$similarNewsProvider = new CActiveDataProvider("News",array(
			'criteria' => $criteria,
			'pagination' => array('pageSize'=>5)
		));
		$this->render('view',array(
			'model'=>$model,
			'similarNewsProvider' => $similarNewsProvider,
		));
	}

    /**
     * Lists all latest models.
     */
    public function actionLatest()
    {
        Yii::app()->theme = "frontend";
        $this->layout = "//layouts/blog";

        $latestNews = new CActiveDataProvider('News', [
            'criteria'=>News::getValidNews(),
            'pagination'=>false
        ]);

        $this->render('list', array(
            'dataProvider' => $latestNews,
            'listTitle' => 'تازه ها',
        ));
    }

	/**
     * Lists all models.
     */
    public function actionAll()
    {
        Yii::app()->theme = "frontend";
        $this->layout = "//layouts/blog";

        $news = new CActiveDataProvider('News', [
            'criteria'=>News::getValidNews(),
            'pagination'=>false
        ]);

        $this->render('list', array(
            'dataProvider' => $news,
            'listTitle' => 'اخبار',
        ));
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionTag($id)
    {
        Yii::app()->theme = "frontend";
        $this->layout = "//layouts/blog";

        $model = Tags::model()->findByPk($id);
        $this->keywords = 'آراخودرو,برچسب اخبار '.$model->title.',برچسب '.$model->title.','.$model->title;
        $this->pageTitle = 'برچسب '.$model->title;

        // get latest news
        $criteria = News::getValidNews();
        $criteria->together = true;
        $criteria->compare('tagsRel.tag_id',$model->id);
        $criteria->with[] = 'tagsRel';
        $dataProvider = new CActiveDataProvider("News",array(
            'criteria' => $criteria,
            'pagination' => array('pageSize' => 20)
        ));

        $this->render('tags',array(
            'model' => $model,
            'dataProvider' => $dataProvider
        ));
    }

    /**
     * Lists all models of category.
     *
     * @param $title string
     */
    public function actionCategory($title)
    {
        Yii::app()->theme = "frontend";
        $this->layout = "//layouts/blog";

        $criteria = News::getValidNews();
        $criteria->with = ['category'];
        $criteria->addCondition('category.title = :catTitle');
        $criteria->params[':catTitle'] = $title;
        $dataProvider = new CActiveDataProvider('News', [
            'criteria' => $criteria,
            'pagination' => false
        ]);

        $this->render('list', array(
            'dataProvider' => $dataProvider,
            'listTitle' => $title,
        ));
    }

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
    {
        $model = new News;

        $image = array();
        if(isset($_POST['News'])){
            $model->attributes = $_POST['News'];
            $image = new UploadedFiles($this->tempPath, $model->image, $this->fileOptions);
            $model->author_id = Yii::app()->user->getId();
            if($model->status == 'publish')
                $model->publish_date = time();

            $model->formTags = isset($_POST['News']['formTags'])?explode(',', $_POST['News']['formTags']):null;
            if($model->save()){
                $image->move($this->imagePath);
                Yii::app()->user->setFlash('success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                $this->redirect(array('admin'));
            }else
                Yii::app()->user->setFlash('failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('create', array(
            'model' => $model,
            'image' => $image
        ));
    }

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
     * @throws CHttpException The current user is not the author of this model
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

        if(Yii::app()->user->roles != 'superAdmin')
            if($model->author_id != Yii::app()->user->getId())
                throw new CHttpException('شما اجازه دسترسی به این صفحه را ندارید.', 403);


		$image = new UploadedFiles($this->imagePath, $model->image, $this->fileOptions);
		foreach($model->tags as $tag)
			array_push($model->formTags,$tag->title);

		if(isset($_POST['News']))
		{
            // store model image value in oldImage variable
            $oldImage = $model->image;
			$model->attributes=$_POST['News'];
			if($model->status == 'publish')
				$model->publish_date = time();
			$model->formTags = isset($_POST['News']['formTags'])?explode(',',$_POST['News']['formTags']):null;
			if($model->save())
			{
                $image->update($oldImage, $model->image, $this->tempPath);
				Yii::app()->user->setFlash('success' ,'<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
				$this->redirect(array('admin'));
			}else
				Yii::app()->user->setFlash('failed' ,'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
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
        $image = new UploadedFiles($this->imagePath, $model->image, $this->fileOptions);
        $image->remove($model->image, true);
		$model->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	public function actionIndex()
	{
		$this->actionAdmin();
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
        Yii::import('admins.models.*');
		$model=new News('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['News']))
			$model->attributes=$_GET['News'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return News the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=News::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param News $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='news-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
