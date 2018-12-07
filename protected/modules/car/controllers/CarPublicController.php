<?php

class CarPublicController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/public';
    public $tempPath = 'uploads/temp';
    public $imagePath = 'uploads/cars';
    public $thumbPath = 'thumbs/180x140';
    public $brandImagePath = 'uploads/brands';
    public $modelImagePath = 'uploads/brands/models';
    public $fileOptions = ['thumbnail' => ['width' => 180, 'height' => 140], 'resize' => ['width' => 450, 'height' => 300]];


    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess - research, view, getBrandModels, getModelYears, getStateCities, json', // perform access control for CRUD operations
        );
    }

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'sell', 'delete', 'edit', 'update', 'upload', 'deleteUpload', 'alert', 'authJson', // auth required
                'research', 'view', 'getBrandModels', 'getModelYears', 'getStateCities', 'json', // allow for all
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
                'storedMode' => 'record',
                'thumbSizes' => array(
                    $this->thumbPath
                )
            )
        );
    }

    /**
     * Displays a particular model.
     * @param integer $id the ID of the model to be displayed
     */
    public function actionView($id)
    {
        Yii::app()->theme = "frontend";
        $this->layout = '//layouts/inner';
        $model = $this->loadModel($id);
        $this->pageTitle = $model->getTitle(false);
        $this->pageHeader = $model->getTitle(false);
        $this->pageDescription = "";
        Yii::app()->db->createCommand()->update('{{cars}}', ['seen' => $model->seen + 1], 'id = :id', [':id' => $id]);
        $this->render('view', array(
            'car' => $model,
            'similar' => $model->getSimilar()
        ));
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionSell()
    {
        Yii::app()->theme = "frontend";
        $this->layout = '//layouts/inner';
        $this->pageTitle = 'فروش خودرو';
        $this->pageHeader = 'فروش خودرو';
        $this->pageDescription = 'درج آگهی فروش با چند کلیک ساده';

        $model = new Cars();
        $user = Users::model()->findByPk(Yii::app()->user->getId());
        $adImageCount = $user->getActivePlanRule('adsImageCount');
        $adLifeTime = $user->getActivePlanRule('adsDuration');
        $images = [];
        if(isset($_POST['Cars'])){
            $model->attributes = $_POST['Cars'];
            $model->user_id = Yii::app()->user->getId();
            $model->create_date = time();
            $model->expire_date = time() + $adLifeTime*24*60*60;
            $model->status = Cars::STATUS_PENDING;
            $model->normalizePrice();
            // plan rules set
            $model->plan_title = $user->getActivePlanTitle();
            $model->plan_rules = $user->getActivePlanRules(true);
            $model->confirm_priority = $user->getActivePlanRule('confirmPriority');
            $model->show_in_top = $user->getActivePlanRule('showOnTop');

            if(count($model->images) > $adImageCount)
                $model->addError('images', "تعداد تصویر مجاز {$adImageCount} می باشد.");
            $images = new UploadedFiles($this->tempPath, $model->images,$this->fileOptions);
            if($model->save()){
                $images->move($this->imagePath);
                Yii::app()->user->setFlash('sells-success', '<span class="icon-check"></span>&nbsp;&nbsp;خودرو با موفقیت ثبت شد و پس از تایید توسط کارشناسان در سایت قرار خواهد گرفت.');
                Notify::Send("خودرو با موفقیت ثبت شد.",$user->userDetails->mobile,"خودرو با موفقیت ثبت شد و پس از تایید توسط کارشناسان در سایت قرار خواهد گرفت.", $user->email);
                $this->redirect(array('/dashboard'));
            }else
                Yii::app()->user->setFlash('sells-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('sell', compact('model', 'images', 'user','adImageCount'));
    }


    public function actionAlert()
    {
        Yii::app()->theme = "frontend";
        $this->layout = '//layouts/inner';
        $this->pageTitle = 'درج گوش به زنگ';
        $this->pageHeader = 'درج گوش به زنگ';
        $this->pageDescription = 'درج هشدار برای یافتن خودروی موردنظر';

        $model = new CarAlerts();
        $user = Users::model()->findByPk(Yii::app()->user->getId());
        if(isset($_POST['CarAlerts'])){
            $model->attributes = $_POST['CarAlerts'];
            $model->user_id = Yii::app()->user->getId();
            $model->create_date = time();
            if($model->save()){
                Yii::app()->user->setFlash('alerts-success', '<span class="icon-check"></span>&nbsp;&nbsp;گوش به زنگ با موفقیت ثبت شد.');
                Notify::Send("گوش به زنگ با موفقیت ثبت شد.",$user->userDetails->mobile,"گوش به زنگ با موفقیت ثبت شد.", $user->email);
                $this->redirect(array('/dashboard#alerts-tab'));
            }else
                Yii::app()->user->setFlash('alerts-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('alert', compact('model', 'images', 'user','adImageCount'));
    }

    /**
     * Updates a particular model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id the ID of the model to be updated
     */
    public function actionEdit($id)
    {
        Yii::app()->theme = "frontend";
        $this->layout = '//layouts/inner';
        $model = $this->loadModel($id);
        $this->pageTitle = 'ویرایش خودروی ' . $model->getTitle(false);
        $this->pageHeader = 'ویرایش خودرو';
        $this->pageDescription = 'ویرایش آگهی فروش خودروی ' . $model->getTitle(false);
        $user = Users::model()->findByPk(Yii::app()->user->getId());
        $adImageCount = $model->getCarPlanRule('adsImageCount')?:$user->getActivePlanRule('adsImageCount');
        $images = [];
        if($model->carImages){
            $model->oldImages = CHtml::listData($model->carImages, 'id', 'filename');
            $images = new UploadedFiles($this->imagePath, $model->oldImages,$this->fileOptions);
        }
        if(isset($_POST['Cars'])){
            $exp = $model->expire_date;
            $model->attributes = $_POST['Cars'];
            $model->expire_date = $exp;
            $model->status = Cars::STATUS_PENDING;
            $model->normalizePrice();
            // set plan details if is null
            $model->plan_title = $model->plan_title?:$user->getActivePlanTitle();
            $model->plan_rules = $model->plan_rules?:$user->getActivePlanRules(true);
            $model->confirm_priority = $user->getActivePlanRule('confirmPriority');
            $model->show_in_top = $user->getActivePlanRule('showOnTop');
            if($model->save()){
                if(!$images){
                    $images = new UploadedFiles($this->tempPath, $model->images,$this->fileOptions);
                    $images->move($this->imagePath);
                }else
                    $images->update($model->oldImages, $model->images, $this->tempPath, true);
                Yii::app()->user->setFlash('sells-success', '<span class="icon-check"></span>&nbsp;&nbsp;اطلاعات با موفقیت ذخیره شد.');
                Notify::Send("آگهی شما با موفقیت ویرایش شد.",$user->userDetails->mobile,"آگهی شما با موفقیت ویرایش شد.", $user->email);
                $this->redirect(array('/dashboard'));
            }else
                Yii::app()->user->setFlash('sells-failed', 'در ثبت اطلاعات خطایی رخ داده است! لطفا مجددا تلاش کنید.');
        }

        $this->render('update', compact('model', 'images', 'adImageCount'));
    }

    /**
     * Deletes a particular model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id the ID of the model to be deleted
     */
    public function actionDelete($id)
    {
        $model = $this->loadModel($id);
        if(!Yii::app()->user->isGuest && (Yii::app()->user->type == 'admin' || (Yii::app()->user->type == 'user' && Yii::app()->user->getId() == $model->user_id))){
            // delete for ever
//            $images = new UploadedFiles($this->imagePath, $model->carImages);
//            $images = new UploadedFiles($this->imagePath, $model->carImages);
//            $images->removeAll(true);
//            $model->delete();
            // status changed to deleted
            $model->status = Cars::STATUS_DELETED;
            $model->normalizePrice();
            if($model->save(false))
                Yii::app()->user->setFlash('sells-success', 'خودروی شما با موفقیت از سایت حذف گردید.');
            else
                Yii::app()->user->setFlash('sells-failed', 'متاسفانه در حذف آگهی مشکلی بوجود آمده است! لطفا مجددا بررسی فرمایید.');
        }
        $this->redirect(['/dashboard']);
    }

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);
        $adsUpdateCount = $model->getCarPlanRule('adsUpdateCount');
        if($model->expire_date < time() && $adsUpdateCount - $model->update_count > 0 && !Yii::app()->user->isGuest && (Yii::app()->user->type == 'admin' || (Yii::app()->user->type == 'user' && Yii::app()->user->getId() == $model->user_id))) {
            $user = Users::model()->findByPk(Yii::app()->user->getId());
            $model->plan_title = $model->plan_title ?: $user->getActivePlanTitle();
            $model->plan_rules = $model->plan_rules ?: $user->getActivePlanRules(true);
            $adLifeTime = $model->getCarPlanRule('adsDuration') ?: $user->getActivePlanRule('adsDuration');
            $model->create_date = time();
            $model->expire_date = time() + $adLifeTime * 24 * 60 * 60;
            $model->normalizePrice();
            $model->update_count++;
            if ($model->save(false))
            {
                Yii::app()->user->setFlash('sells-success', 'خودروی شما با موفقیت به روزرسانی گردید.');
                Notify::Send("آگهی شما با موفقیت به روزرسانی گردید.",$user->userDetails->mobile,"آگهی شما با موفقیت به روزرسانی گردید.", $user->email);
            }
            else
                Yii::app()->user->setFlash('sells-failed', 'متاسفانه در به روزرسانی آگهی مشکلی بوجود آمده است! لطفا مجددا بررسی فرمایید.');
        }else if($adsUpdateCount - $model->update_count <= 0)
            Yii::app()->user->setFlash('sells-failed', 'تعداد به روزرسانی مجار به اتمام رسیده است.');
        else if($model->expire_date > time())
            Yii::app()->user->setFlash('sells-failed', 'تا زمانیکه آگهی منقضی نشده به روزرسانی مجاز نیست.');

        $this->redirect(['/dashboard']);
    }

    /**
     * @param bool $params
     * @throws CHttpException
     */
    public function actionResearch($params = false)
    {
        Yii::app()->theme = 'frontend';
        $this->layout = '//layouts/inner';
        $this->pageTitle = 'بررسی و مقایسه خودرو';
        $this->pageHeader = 'بررسی / مقایسه خودرو';
        $brand1 = null;
        $brand2 = null;
        $model1 = null;
        $model2 = null;
        $year1 = null;
        $year2 = null;

        $b1 = null;
        $m1 = null;
        $y1 = null;
        $b2 = null;
        $m2 = null;
        $y2 = null;
        $vs = null;
        if($params && $params = explode('/', $params)){
            $vs = array_search('vs', $params);
            if($vs === false){
                $b1 = isset($params[0]) && !empty($params[0])?$params[0]:null;
                $m1 = isset($params[1]) && !empty($params[1])?$params[1]:null;
                $y1 = isset($params[2]) && !empty($params[2])?$params[2]:null;
                $b2 = null;
                $m2 = null;
                $y2 = null;
            }else{
                $b1 = $vs != 0 && isset($params[0]) && !empty($params[0])?$params[0]:null;
                $m1 = $vs > 1 && isset($params[1]) && !empty($params[1])?$params[1]:null;
                $y1 = $vs > 2 && isset($params[2]) && !empty($params[2])?$params[2]:null;
                $b2 = isset($params[$vs+1]) && !empty($params[$vs+1])?$params[$vs+1]:null;
                $m2 = isset($params[$vs+2]) && !empty($params[$vs+2])?$params[$vs+2]:null;
                $y2 = isset($params[$vs+3]) && !empty($params[$vs+3])?$params[$vs+3]:null;
            }
            $brand1 = $b1?Brands::model()->findByAttributes(array('slug' => $b1)):null;
            $brand2 = $b2?Brands::model()->findByAttributes(array('slug' => $b2)):null;
            $model1 = $brand1 && $m1?Models::model()->findByAttributes(array('brand_id' => $brand1->id, 'slug' => $m1)):null;
            $model2 = $brand2 && $m2?Models::model()->findByAttributes(array('brand_id' => $brand2->id, 'slug' => $m2)):null;
            $year1 = $model1 && $y1?ModelDetails::model()->findByAttributes(array('model_id' => $model1->id, 'product_year' => $y1)):null;
            $year2 = $model2 && $y2?ModelDetails::model()->findByAttributes(array('model_id' => $model2->id, 'product_year' => $y2)):null;
        }

        $criteria = new CDbCriteria();
        $criteria->addCondition('models.id IS NOT NULL and lastYear.id IS NOT NULL');
        $criteria->with = array('models', 'models.lastYear');
        $criteria->order = 't.title';
        $brands = Brands::model()->findAll($criteria);
        $this->render('research', compact(
            'brands',
            'brand1',
            'brand2',
            'model1',
            'model2',
            'year1',
            'year2',
            'b1',
            'm1',
            'y1',
            'b2',
            'm2',
            'y2',
            'vs'
        ));
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

    public function actionGetBrandModels()
    {
        if(isset($_GET['id']) && !empty((int)$_GET['id'])){
            $id = $_GET['id'];
            $models = Models::getList($id);
            $list = [];
            foreach($models as $id => $title)
                $list[] = array('id' => $id, 'title' => $title);
            echo CJSON::encode(['status' => true, 'list' => $list]);
        }else if(!isset($_GET['id']))
            echo CJSON::encode(['status' => false, 'message' => 'خطا در دریافت اطلاعات.']);
        Yii::app()->end();
    }

    public function actionGetModelYears()
    {
        if(isset($_GET['id']) && !empty((int)$_GET['id'])){
            $id = $_GET['id'];
            $model = Models::model()->findByPk($id);
            echo CJSON::encode(['status' => true, 'list' => $model->getYears('ajax')]);
        }else
            echo CJSON::encode(['status' => false, 'message' => 'خطا در دریافت اطلاعات.']);
        Yii::app()->end();
    }

    public function actionGetStateCities()
    {
        if(isset($_GET['id']) && !empty((int)$_GET['id'])){
            $id = $_GET['id'];
            $models = Places::model()->findAllByAttributes(['town_id' => $id]);
            $list = [];
            foreach($models as $item)
                $list[] = array('id' => $item->id, 'title' => $item->name);
            echo CJSON::encode(['status' => true, 'list' => $list]);
        }else
            echo CJSON::encode(['status' => false, 'message' => 'خطا در دریافت اطلاعات.']);
        Yii::app()->end();
    }
    
    public function actionJson()
    {
        if(!isset($_POST['method']))
            $this->sendJson(['status' => false]);
        switch($_POST['method']){
            case 'getContact':
                if(!isset($_POST['hash']))
                    $this->sendJson(['status' => false]);
                $id = base64_decode($_POST['hash']);
                $model = Cars::model()->findByPk($id);
                if($model === null)
                    $this->sendJson(['status' => false]);
                $phone = $model->user->userDetails->mobile;
                $firstPart = substr($phone, 0, 4);
                $secPart = substr($phone, 4, 3);
                $thirdPart = substr($phone, 7, 2);
                $forthPart = substr($phone, 9, 2);
                $phone = "{$firstPart} {$secPart} {$thirdPart} {$forthPart}";
                $this->sendJson(['status' => true, 'phone' => $phone]);
                break;
            case 'getPhone':
                if(!isset($_POST['hash']))
                    $this->sendJson(['status' => false]);
                $id = base64_decode($_POST['hash']);
                $model = Cars::model()->findByPk($id);
                if($model === null)
                    $this->sendJson(['status' => false]);
                $phone = $model->user->userDetails->mobile;
                $this->sendJson(['status' => true, 'phone' => $phone]);
                break;
            case 'report':
                if(!isset($_POST['hash']))
                    $this->sendJson(['status' => false]);
                $id = base64_decode($_POST['hash']);
                $model = new Reports();
                if(isset($_POST['Reports']))
                    $model->attributes= $_POST['Reports'];
                $model->car_id = $id;
                if($model->save())
                    $this->sendJson(['status' => true, 'message' => "با تشکر، گزارش شما با موفقیت ثبت گردید و بررسی خواهد شد."]);
                $this->sendJson(['status' => false, 'message' => "مشکل در ثبت گزارش! لطفا مجددا تلاش فرمایید."]);
                break;
            default:
                $this->sendJson(['status' => false]);
        }
    }

    public function actionAuthJson()
    {
        if(!isset($_POST['method']))
            $this->sendJson(['status' => false]);
        switch($_POST['method']){
            case 'park':
                if(!isset($_POST['hash']))
                    $this->sendJson(['status' => false]);
                $carID = base64_decode($_POST['hash']);
                $userID = Yii::app()->user->getId();
                $parked = UserParking::model()->findByAttributes(['user_id' => $userID, 'car_id' => $carID]);
                if($parked === null){
                    $parkModel = new UserParking();
                    $parkModel->car_id = $carID;
                    $parkModel->user_id = $userID;
                    if($parkModel->save())
                        $this->sendJson(['status' => true, 'message' => 'خودرو با موفقیت به پارکینگ شما اضافه شد.']);
                    else
                        $this->sendJson(['status' => false, 'message' => 'در پارک خودرو مشکلی بوجود آمده است! لطفا مجددا تلاش فرمایید.']);
                }else{
                    if($parked->delete())
                        $this->sendJson(['status' => true, 'message' => 'خودرو با موفقیت از پارکینگ شما خارج شد.']);
                    else
                        $this->sendJson(['status' => false, 'message' => 'در خارج کردن خودرو از پارکینگ مشکلی بوجود آمده است! لطفا مجددا تلاش فرمایید.']);
                }
                break;
            case 'removeAlert':
                if(!isset($_POST['hash']))
                    $this->sendJson(['status' => false]);
                $id = base64_decode($_POST['hash']);
                $alert = CarAlerts::model()->findByPk($id);
                if($alert !== null)
                    if($alert->delete())
                        $this->sendJson(['status' => true, 'message' => 'گوش به زنگ با موفقیت حذف شد.']);
                    else
                        $this->sendJson(['status' => false, 'message' => 'در حذف گوش به زنگ مشکلی بوجود آمده است! لطفا مجددا تلاش فرمایید.']);
                else
                    $this->sendJson(['status' => false, 'message' => 'در حذف گوش به زنگ مشکلی بوجود آمده است! لطفا مجددا تلاش فرمایید.']);
                break;
            default:
                $this->sendJson(['status' => false, 'message' => 'خطا در مقادیر.']);
        }
    }

    private function sendJson($response)
    {
        echo CJSON::encode($response);
        Yii::app()->end();
    }
}