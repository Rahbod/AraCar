<?php

class NewslettersManageController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/column2';

    /**
     * @return array action filters
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'admin',
                'delete',
                'send',
                'messages',
                'deleteMessage',
                'clearMessages',
            )
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess - insert, unsubscribe'
        );
    }

    /**
     * Creates a new model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     */
    public function actionInsert()
    {
        $model = new NewsLetters;

        if(isset($_POST['NewsLetters'])){
            $model->attributes = $_POST['NewsLetters'];
            if($model->save())
                echo CJSON::encode(['status' => true, 'msg'=>'عضویت در خبرنامه با موفقیت انجام شد.']);
            else
                echo CJSON::encode(['status' => false, 'msg' => str_replace('<br>', "\n", $this->implodeErrors($model))]);
        }else
            echo CJSON::encode(['status' => false, 'msg' => 'پست الکترونیکی نمی تواند خالی باشد.']);
        Yii::app()->end();
    }

    public function actionUnsubscribe()
    {
        if(isset($_GET['token']) && !empty($_GET['token'])){
            $id = NewsLetters::getIdFromToken($_GET['token']);
            if($this->loadModel($id)->delete())
                $flag = true;
            else
                $flag = false;
        }else
            throw new CHttpException(404, 'آدرس موردنظر موجود نیست.');
        $this->render('unsubscribe', array('flag' => $flag));
    }


    /**
     * Manages all models.
     */
    public function actionAdmin()
    {
        $model = new NewsLetters('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['NewsLetters']))
            $model->attributes = $_GET['NewsLetters'];

        $this->render('admin', array(
            'model' => $model,
        ));
    }

    public function actionSend()
    {
        $model = new NewsLetterMessages;
        if(!Yii::app()->db->createCommand()
            ->select('COUNT(*)')
            ->from('{{news_letters}}')
            ->queryScalar()
        )
            throw new CHttpException(404, 'هیچ اشتراکی در خبرنامه ثبت نشده است.');
        if(isset($_POST['NewsLetterMessages'])){
            $receivers = Yii::app()->db->createCommand()
                ->select('email')
                ->from('{{news_letters}}')
                ->queryColumn();
            $model->attributes = $_POST['NewsLetterMessages'];
            if($model->save()){
                $flag = Mailer::mail($receivers, CHtml::encode($model->title) . ' - خبرنامه جدید آرا خودرو',
                    '', Yii::app()->params['noReplyEmail'], false, false, 'mail_template', array(
                        'title' => $model->title,
                        'body' => $model->body
                    ));
                if($flag){
                    Yii::app()->user->setFlash('success', 'خبرنامه با موفقیت ارسال شد.');
                    $this->redirect(array('messages'));
                }else
                    Yii::app()->user->setFlash('success', 'ارسال خبرنامه با مشکل مواجه شد! لطفا مجدد تلاش کنید.');

            }else
                Yii::app()->user->setFlash('success', 'ارسال خبرنامه با مشکل مواجه شد! لطفا مجدد تلاش کنید.');
        }
        $this->render('send_news_letter', array(
            'model' => $model
        ));
    }

    public function actionMessages()
    {
        $model = new NewsLetterMessages('search');
        $model->unsetAttributes();  // clear any default values
        if(isset($_GET['NewsLetterMessages']))
            $model->attributes = $_GET['NewsLetterMessages'];

        $this->render('messages', array(
            'model' => $model,
        ));
    }

    public function actionDeleteMessage($id)
    {
        if(NewsLetterMessages::model()->findByPk($id)->delete())
            Yii::app()->user->setFlash('success', 'خبرنامه با موفقیت پاک شد.');
        else
            Yii::app()->user->setFlash('failed', 'حذف خبرنامه با مشکل مواجه شد! لطفا مجدد تلاش فرمایید.');
        $this->redirect(array('messages'));
    }

    public function actionClearMessages()
    {
        if(NewsLetterMessages::model()->deleteAll())
            Yii::app()->user->setFlash('success', 'تاریخچه خبرنامه ها با موفقیت پاک شد.');
        else
            Yii::app()->user->setFlash('failed', 'پاکسازی تاریخچه خبرنامه ها با مشکل مواجه شد! لطفا مجدد تلاش فرمایید.');
        $this->redirect(array('messages'));
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
     * Returns the data model based on the primary key given in the GET variable.
     * If the data model is not found, an HTTP exception will be raised.
     * @param integer $id the ID of the model to be loaded
     * @return NewsLetters the loaded model
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = NewsLetters::model()->findByPk($id);
        if($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }
}