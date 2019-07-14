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
                'model',
                'all',
                'autoComplete',
                'dealership',
            )
        );
    }

    /**
     * Search cars by brand name.
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

        $filters = Cars::getFilters();

        $criteria = Cars::duplicateQuery();
        $criteria->with[] = 'brand';
        $criteria->compare('brand.slug', $brand, true);
        $criteria = Cars::applyFilter($criteria, $filters);
        $dataProvider = new CActiveDataProvider('Cars', [
            'criteria' => $criteria,
        ]);

        $this->render('brand', array(
            'brand' => Brands::model()->findByAttributes(['slug' => $brand]),
            'filters' => $filters,
            'dataProvider' => $dataProvider,
        ));
    }

    /**
     * Search cars by model name.
     */
    public function actionModel()
    {
        Yii::app()->theme = 'frontend';
        $model = null;
        if (Yii::app()->request->getQuery('model'))
            $model = Yii::app()->request->getQuery('model');
        else
            $this->redirect(['/site']);

        /* @var Models $model */
        $model = Models::model()->find('slug = :slug', [':slug' => $model]);

        $filters = Cars::getFilters();
        $filters['model'] = $model->slug;

        $criteria = Cars::duplicateQuery();
        $criteria->compare('car.model_id', $model->id);
        $criteria = Cars::applyFilter($criteria, $filters);
        $dataProvider = new CActiveDataProvider('Cars', [
            'criteria' => $criteria,
        ]);

        $this->redirect(['/car/brand/' . $model->brand->slug . '?model=' . $model->slug]);
    }

    /**
     * Search cars by other fields
     */
    public function actionAll()
    {
        Yii::app()->theme = 'frontend';

        $filters = Cars::getFilters();
        $criteria = Cars::duplicateQuery();
        $criteria = Cars::applyFilter($criteria, $filters);
        $dataProvider = new CActiveDataProvider('Cars', [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 10
            ]
        ]);

        $this->render('cars-list', array(
            'filters' => $filters,
            'dataProvider' => $dataProvider,
        ));
    }

    public function actionAutoComplete()
    {
        if (isset($_POST['query'])) {
            $criteria = new CDbCriteria();
            $criteria->with = ['brand'];
            $criteria->alias = 'model';
            $criteria->addCondition('model.title REGEXP :field', 'OR');
            $criteria->addCondition('model.slug REGEXP :field', 'OR');
            $criteria->addCondition('brand.title REGEXP :field', 'OR');
            $criteria->addCondition('brand.slug REGEXP :field', 'OR');
            $criteria->params[':field'] = '^'.Persian2Arabic::parse($_POST['query']);
            /* @var Models[] $list */
            $list = Models::model()->findAll($criteria);

            $result = [];
            foreach($list as $model){
                $result[] = [
                    'title' => $model->getTitleAndBrand(),
                    'link' => $this->createUrl('model', ['model' => $model->slug]),
                ];
            }
            echo CJSON::encode($result);
        } else
            return null;
    }

    public function actionDealership($id = false, $title=  false)
    {
        Yii::app()->theme = "frontend";
        $this->layout = '//layouts/inner';

        // list of dealerships
        if(!$id && !$title){
            $this->pageTitle = 'جستجوی نمایشگاه ها';
            $this->pageHeader = 'جستجوی نمایشگاه ها';
            $this->pageDescription = 'با استفاده از فیلتر ها نمایشگاه موردنظر خود را جستجو کنید.';

            $filters = Cars::getFilters();
            $model = new Users('search');
            if(isset($_GET['Users'])){
                $model->attributes = $_GET['Users'];
            }
            $model->role_id = 2;
            $model->dealershipFilters = $filters;
            $this->render('dealerships', compact('model', 'filters'));
            Yii::app()->end();
        }

        // show dealership
        if($id){
            /* @var $model Users */
            $model = Users::model()->findByPk($id);
            $model->loadPropertyValues();
            $this->pageTitle = strpos('نمایشگاه',$model->dealership_name,0) ===0?$model->dealership_name:'نمایشگاه '.$model->dealership_name;
            $this->pageHeader = strpos('نمایشگاه',$model->dealership_name,0) ===0?$model->dealership_name:'نمایشگاه '.$model->dealership_name;
            $this->pageDescription = 'نشانی: '.strip_tags($model->userDetails->address);
            $this->pageLogo = $model->userDetails->avatar && file_exists(Yii::getPathOfAlias('webroot.uploads').'/users/avatar/'.$model->userDetails->avatar)?Yii::app()->getBaseUrl(true).'/uploads/users/avatar/'.$model->userDetails->avatar:false;

            $filters = Cars::getFilters();

            $criteria = Cars::duplicateQuery();
            $criteria->compare('user_id', $id, true);
            $criteria = Cars::applyFilter($criteria, $filters);
            $dataProvider = new CActiveDataProvider('Cars', [
                'criteria' => $criteria,
            ]);

            $this->render('dealership', compact('model', 'dataProvider', 'filters'));
            Yii::app()->end();
        }
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

    public function createFiltersBar($filters)
    {
        if(isset($filters['def']))
            unset($filters['def']);

        $result = "";
        foreach ($filters as $filter => $value) {
            $strTemp = '<div class="filter">';
            switch ($filter) {
                case "state":
                    $model = Towns::model()->find('slug = :slug', [':slug' => $value]);
                    $strTemp .= $model->name;
                    break;

                case "body":
                case "plate":
                    $model = Lists::model()->find('(id = :id OR title LIKE :title)', [':id' => urldecode($value), ':title' => str_replace('-', ' ', urldecode($value))]);
                    $strTemp .= $model->title;
                    break;

                case "car_type":
                case "gearbox":
                case "body_state":
                case "fuel":
                case "color":
                    $model = Lists::model()->findByPk($value);
                    $strTemp .= $model->title;
                    break;

                case "model":
                    $model = Models::model()->find('slug = :slug', [':slug' => $value]);
                    if($model === null)
                        throw new CHttpException(404, 'مدل موردنظر یافت نشد.');
                    $strTemp .= $model->title;
                    break;

                case "price":
                    $prices = explode('-', $value);
                    if(isset($prices[0] , $prices[1]) && !empty((float)$prices[0]) && !empty((float)$prices[1]))
                        $strTemp .= 'از ' . Controller::parseNumbers(number_format($prices[0])) . ' تا ' . Controller::parseNumbers(number_format($prices[1])) . ' میلیون تومان';
                    elseif(isset($prices[0]) and is_numeric($prices[0]))
                        $strTemp .= 'از ' . Controller::parseNumbers(number_format($prices[0])) .  ' میلیون تومان';
                    elseif(isset($prices[1]) and is_numeric($prices[1]))
                        $strTemp .= 'تا ' . Controller::parseNumbers(number_format($prices[1])) .  ' میلیون تومان';
                    break;

                case "min-year":
                    $strTemp .= "از سال". $value;
                    break;

                case "max-year":
                    $strTemp .= "تا سال". $value;
                    break;

                case "min-distance":
                    $strTemp .= "حداقل کارکرد ". ($value * 1000) . " کیلومتر";
                    break;

                case "max-distance":
                    $strTemp .= "حداکثر کارکرد ". ($value * 1000) . " کیلومتر";
                    break;

                case "purchase":
                    $strTemp .= Cars::$purchase_types[$value];
                    break;

                case "has-image":
                    if($value)
                        $strTemp .= 'عکس دار';
                    else
                        $strTemp .= 'عکس مهم نیست';
                    break;
                case "order":
                    $orderTypes = [
                        //"all"     => "مرتب سازی بر اساس",
                        "time"     => "به روزترین آگهی",
                        "max-cast" => "گرانترین",
                        "min-cast" => "ارزانترین",
                        "new-year" => "جدیدترین سال",
                        "old-year" => "قدیمی ترین سال",
                        "min-dist" => "کم کارکرد ترین",
                        "max-dist" => "پر کارکرد ترین"
                    ];
                    if($value)
                        $strTemp .= $orderTypes[$value];
                    break;
            }
            if(Yii::app()->request->getQuery('def') != $filter) {
                $strTemp .= '<a href="';
                $url = '';
                if ($queryString = Yii::app()->request->getQueryString()) {
                    $queryStringArray = explode('&', $queryString);
                    unset($queryStringArray[key(preg_grep("/{$filter}/", $queryStringArray))]);
                    if (count($queryStringArray) != 0)
                        $url = "?" . implode("&", $queryStringArray);
                    else
                        $url = $this->createUrl('/' . Yii::app()->request->pathInfo);
                }
                $strTemp .= $url . '"><i></i></a>';
            }
            $strTemp .= '</div>';
            $result .= $strTemp;
        }
        return $result;
    }
}