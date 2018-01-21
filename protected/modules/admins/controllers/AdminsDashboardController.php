<?php

class AdminsDashboardController extends Controller
{
    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'backend' => array(
                'index'
            )
        );
    }

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array(
            'checkAccess - index', // perform access control for CRUD operations
        );
    }

    public function actionIndex()
    {
        Yii::app()->getModule('contact');
        Yii::app()->getModule('comments');
        $statistics = [
            'contact' => ContactMessages::model()->count('seen = 0'),
            'pendingCars' => Cars::model()->count('status = :pending',[':pending' => Cars::STATUS_PENDING]),
            'dealerRequests' => DealershipRequests::model()->count('status = 0'),
            'carReports' => Reports::model()->count(),
            'newsComments' => Comment::model()->count('owner_name = "News" and status = 0')
        ];
        $this->render('index', compact('statistics'));
    }
}