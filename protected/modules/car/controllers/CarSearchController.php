<?php

class CarSearchController extends Controller
{
    /**
     * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
     * using two-column layout. See 'protected/views/layouts/column2.php'.
     */
    public $layout = '//layouts/inner';

    /**
     * @return array action filters
     */
    public function filters()
    {
        return array();
    }

    /**
     * @return array actions type list
     */
    public static function actionsType()
    {
        return array(
            'frontend' => array(
                'brand',
                'all',
            )
        );
    }

    /**
     * Search cars by brand and model name.
     */
    public function actionBrand()
    {
        Yii::app()->theme = 'frontend';
        $brand = null;
        if (isset($_POST['Search']))
            $brand = $_POST['Search']['brand'];
        elseif (Yii::app()->request->getQuery('title'))
            $brand = Yii::app()->request->getQuery('title');
        else
            $this->redirect(['/site']);

        $criteria = new CDbCriteria();
        $criteria->with = ['brand'];
        $criteria->compare('brand.slug', $brand, true);
        $dataProvider = new CActiveDataProvider('Cars', [
            'criteria' => $criteria,
        ]);

        $filters = [];
        if ($queryString = Yii::app()->request->getQueryString()) {
            $queryStrings = explode('&', $queryString);
            foreach ($queryStrings as $queryString) {
                $arr = explode('=', $queryString);
                $filters[$arr[0]] = $arr[1];
            }
        }

        $this->render('brand', array(
            'brand' => Brands::model()->findByAttributes(['slug' => $brand]),
            'filters' => $filters,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Search cars by other fields
     */
    public function actionAll()
    {
        Yii::app()->theme = 'frontend';

        $query = null;
        $method = null;
        if (Yii::app()->request->getQuery('body')) {
            $query = Yii::app()->request->getQuery('body');
            $method = 'body';
        } elseif (Yii::app()->request->getQuery('price')) {
            $query = Yii::app()->request->getQuery('price');
            $method = 'price';
        } elseif (Yii::app()->request->getQuery('special')) {
            $query = Yii::app()->request->getQuery('special');
            $method = 'special';
        }

        $criteria = new CDbCriteria();

        switch ($method) {
            case "body":
                $criteria->with[] = 'bodyType';
                $criteria->compare('bodyType.title', $query, true);
                break;

            case "price":
                $price = explode('-', $query);
                $criteria->addCondition('purchase_type_id = :type');
                $criteria->params[':type'] = 0;
                if (count($price) == 2)
                    $criteria->addBetweenCondition('purchase_details', ($price[0] * 1000000), ($price[1] * 1000000));
                else {
                    $criteria->addCondition('purchase_details >= :price');
                    $criteria->params[':price'] = (1000 * 1000000);
                }
                break;

            case "special":
                $criteria->with[] = 'plateType';
                $criteria->compare('plateType.title', str_replace('-', ' ', $query), true);
                break;
        }
        $dataProvider = new CActiveDataProvider('Cars', [
            'criteria' => $criteria,
        ]);

        $this->render('cars-list', array(
            'dataProvider' => $dataProvider,
        ));
    }

    public function createFilterUrl($query, $value)
    {
        $url = "?{$query}={$value}";
        if ($queryString = Yii::app()->request->getQueryString()) {
            $queryStringArray = explode('&', $queryString);
            unset($queryStringArray[key(preg_grep("/{$query}/", $queryStringArray))]);
            if (count($queryStringArray) != 0)
                $url = "?" . implode("&", $queryStringArray) . "&{$query}={$value}";
        }

        return $url;
    }
}