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

        $filters = $this->getFilters();

        $criteria = Cars::duplicateQuery();
        $criteria->with[] = 'brand';
        $criteria->compare('brand.slug', $brand, true);
        $criteria = $this->applyFilter($criteria, $filters);
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

        $filters = $this->getFilters();
        $filters['model'] = $model->slug;

        $criteria = Cars::duplicateQuery();
        $criteria->compare('car.model_id', $model->id);
        $criteria = $this->applyFilter($criteria, $filters);
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

        $filters = $this->getFilters();

        $criteria = Cars::duplicateQuery();
        $criteria = $this->applyFilter($criteria, $filters);
        $dataProvider = new CActiveDataProvider('Cars', [
            'criteria' => $criteria,
            'pagination' => [
                'pageSize' => 1
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

    /**
     * Return array of filters that exists in query string.
     * @return array
    */
    protected function getFilters()
    {
        $filters = [];
        if ($queryString = Yii::app()->request->getQueryString()) {
            $queryStrings = explode('&', $queryString);
            foreach ($queryStrings as $queryString) {
                $arr = explode('=', $queryString);
                if($arr[0] != 'order')
                    $filters[$arr[0]] = $arr[1];
            }
        }

        return $filters;
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
                    $strTemp .= 'از ' . number_format($prices[0] * 1000000) . ' تا ' . number_format($prices[1] * 1000000) . ' میلیون تومان';
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
                    $strTemp .= 'عکس دار';
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

    /**
     * Apply selected filters to search car query.
     * @param CDbCriteria $criteria
     * @param array $filters
     * @return CDbCriteria
     */
    public function applyFilter($criteria, $filters)
    {
        foreach ($filters as $filter => $value) {
            switch ($filter) {
                case "state":
                    $criteria->with[] = 'state';
                    $criteria->compare('state.slug', $value, true);
                    break;

                case "body":
                    $criteria->with[] = 'bodyType';
                    $criteria->addCondition('(bodyType.id = :bodyTypeID OR bodyType.title LIKE :bodyTypeTitle)');
                    $criteria->params[':bodyTypeID'] = urldecode($value);
                    $criteria->params[':bodyTypeTitle'] = str_replace('-', ' ', urldecode($value));
                    break;

                case "car_type":
                    $criteria->addCondition('car.car_type_id = :carTypeID');
                    $criteria->params[':carTypeID'] = $value;
                    break;

                case "gearbox":
                    $criteria->addCondition('car.gearbox_id = :gearboxID');
                    $criteria->params[':gearboxID'] = $value;
                    break;

                case "body_state":
                    $criteria->addCondition('car.body_state_id = :bodyStateID');
                    $criteria->params[':bodyStateID'] = $value;
                    break;

                case "fuel":
                    $criteria->addCondition('car.fuel_id = :fuelID');
                    $criteria->params[':fuelID'] = $value;
                    break;

                case "plate":
                    $criteria->with[] = 'plateType';
                    $criteria->addCondition('(plateType.id = :plateTypeID OR plateType.title LIKE :plateTypeTitle)');
                    $criteria->params[':plateTypeID'] = urldecode($value);
                    $criteria->params[':plateTypeTitle'] = str_replace('-', ' ', urldecode($value));
                    break;

                case "color":
                    $criteria->addCondition('car.body_color_id = :bodyColorID');
                    $criteria->params[':bodyColorID'] = $value;
                    break;

                case "model":
                    $criteria->with[] = 'model';
                    $criteria->compare('model.slug', $value, true);
                    break;

                case "price":
                    $prices = explode('-', $value);
                    $criteria->compare('car.purchase_type_id', Cars::PURCHASE_TYPE_CASH, false);
                    $criteria->addBetweenCondition('car.purchase_details', $prices[0] * 1000000, $prices[1] * 1000000);
                    break;

                case "min-year":
                    $criteria->addCondition('car.creation_date >= :minYear');
                    $criteria->params[':minYear'] = $value;
                    break;

                case "max-year":
                    $criteria->addCondition('car.creation_date <= :maxYear');
                    $criteria->params[':maxYear'] = $value;
                    break;

                case "min-distance":
                    $criteria->addCondition('car.distance >= :minDistance');
                    $criteria->params[':minDistance'] = $value * 1000;
                    break;

                case "max-distance":
                    $criteria->addCondition('car.distance <= :maxDistance');
                    $criteria->params[':maxDistance'] = $value * 1000;
                    break;

                case "purchase":
                    $criteria->addCondition('car.purchase_type_id = :purchase');
                    $criteria->params[':purchase'] = $value;
                    break;

                case "has-image":
                    $criteria->with[] = 'carImages';
                    $criteria->together = true;
                    $criteria->addCondition('carImages.id IS NOT NULL');
                    break;

                case "order":
                    $field = $order = "";
                    switch($value){
                        case "time":
                            $field = "update_date";
                            $order = "DESC";
                            break;

                        case "max-cast":
                            $field = "purchase_details";
                            $order = "DESC";
                            break;

                        case "min-cast":
                            $field = "purchase_details";
                            $order = "ASC";
                            break;

                        case "new-year":
                            $field = "creation_date";
                            $order = "DESC";
                            break;

                        case "old-year":
                            $field = "creation_date";
                            $order = "ASC";
                            break;

                        case "min-dist":
                            $field = "distance";
                            $order = "ASC";
                            break;

                        case "max-dist":
                            $field = "distance";
                            $order = "DESC";
                            break;
                    }
                    $criteria->order = "car.{$field} {$order}";
                    break;
            }
        }

        if(!isset($filters['order']))
            $criteria->order = "car.update_date DESC";

        return $criteria;
    }
}