<?php

class NewsLetter extends CApplicationComponent
{
    public function sendNewsLetter($title, $body)
    {
        $model = new NewsLetterMessages;
        $model->title = $title;
        $model->body = $body;
        if(!Yii::app()->db->createCommand()
            ->select('COUNT(*)')
            ->from('{{news_letters}}')
            ->queryScalar()
        )
            throw new CHttpException(404, 'هیچ اشتراکی در خبرنامه ثبت نشده است.');
        $receivers = Yii::app()->db->createCommand()
            ->select('email')
            ->from('{{news_letters}}')
            ->queryColumn();
        if($model->save()){
            return Mailer::mail($receivers, CHtml::encode($model->title) . ' - خبرنامه جدید آرا خودرو',
                '', Yii::app()->params['noReplyEmail'], false, false, 'mail_template', array(
                    'title' => $model->title,
                    'body' => $model->body
                ));
        }
        return false;
    }
}