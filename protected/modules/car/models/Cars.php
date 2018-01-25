<?php

/**
 * This is the model class for table "{{cars}}".
 *
 * The followings are the available columns in table '{{cars}}':
 * @property string $id
 * @property string $create_date
 * @property string $update_date
 * @property string $expire_date
 * @property string $user_id
 * @property string $brand_id
 * @property string $model_id
 * @property string $room_color_id
 * @property string $body_color_id
 * @property string $body_state_id
 * @property string $body_type_id
 * @property string $state_id
 * @property string $city_id
 * @property string $fuel_id
 * @property string $gearbox_id
 * @property string $car_type_id
 * @property string $plate_type_id
 * @property string $purchase_type_id
 * @property string $purchase_details
 * @property string $distance
 * @property string $status
 * @property string $visit_district
 * @property string $description
 * @property string $creation_date
 * @property int $seen
 * @property int $confirm_priority
 * @property string $plan_title
 * @property string $plan_rules
 * @property string $title
 * @property [] $oldImages
 * @property CarImages $mainImage
 * @property array $numberOfInstallments
 * @property array $deliveryInDays
 * @property array $numberOfMonth
 * @property string $price
 * @property string $show_in_top
 * @property string $update_count
 *
 * The followings are the available model relations:
 * @property CarImages[] $carImages
 * @property Lists $plateType
 * @property Users $user
 * @property Brands $brand
 * @property Models $model
 * @property Lists $gearbox
 * @property Lists $carType
 * @property Lists $roomColor
 * @property Lists $bodyColor
 * @property Lists $bodyState
 * @property Lists $bodyType
 * @property Towns $state
 * @property Places $city
 * @property Lists $fuel
 */
class Cars extends CActiveRecord
{
    const PURCHASE_TYPE_CASH = 0;
    const PURCHASE_TYPE_INSTALMENT = 1;
    const PURCHASE_TYPE_AGREEMENT = 2;

    const STATUS_DELETED = -1;
    const STATUS_PENDING = 0;
    const STATUS_APPROVED = 1;
    const STATUS_REFUSED = 2;

    public $oldImages = [];
    public $images;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{cars}}';
    }

    public static $purchase_types = [
        self::PURCHASE_TYPE_CASH => 'نقدی',
        self::PURCHASE_TYPE_INSTALMENT => 'اقساطی',
        self::PURCHASE_TYPE_AGREEMENT => 'توافقی',
    ];

    public $statusLabels = [
        self::STATUS_DELETED => 'حذف شده',
        self::STATUS_PENDING => 'در انتظار بررسی',
        self::STATUS_APPROVED => 'تایید شده',
        self::STATUS_REFUSED => 'رد شده',
    ];

    /**
     * @return array
     */
    public function getNumberOfInstallments()
    {
        $arr = [2 => 'قسط دوم'];
        for($i = 3;$i <= 60;$i++)
            $arr[$i] = Controller::parseNumbers($i) . ' اقساط';
        return $arr;
    }

    /**
     * @return array
     */
    public function getDeliveryInDays()
    {
        return [
            -1 => 'دلخواه',
            1 => 'فوری',
            7 => Controller::parseNumbers(7) . 'روز',
            12 => Controller::parseNumbers(12) . 'روز',
            15 => Controller::parseNumbers(15) . 'روز',
            20 => Controller::parseNumbers(20) . 'روز',
            30 => Controller::parseNumbers(30) . 'روز',
            45 => Controller::parseNumbers(45) . 'روز',
            60 => Controller::parseNumbers(60) . 'روز',
            90 => Controller::parseNumbers(90) . 'روز',
            120 => Controller::parseNumbers(120) . 'روز',

        ];
    }

    /**
     * @return array
     */
    public function getNumberOfMonth()
    {
        $arr = [1 => 'ماهیانه'];
        for($i = 2;$i <= 6;$i++)
            $arr[$i] = Controller::parseNumbers($i) . ' ماه';
        return $arr;
    }

    public function scopes()
    {
        return array(
            'sitemap' => $this->duplicateQuery(),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, brand_id, model_id, room_color_id, body_color_id, body_state_id, body_type_id, state_id, city_id, fuel_id, gearbox_id, car_type_id, plate_type_id, purchase_type_id, creation_date', 'required'),
            array('create_date, update_date, expire_date', 'length', 'max' => 20),
            array('user_id, brand_id, model_id, room_color_id, body_color_id, body_state_id, state_id, city_id, fuel_id, gearbox_id, car_type_id, plate_type_id', 'length', 'max' => 10),
            array('purchase_type_id', 'length', 'max' => 1),
            array('purchase_details', 'length', 'max' => 1024),
            array('distance', 'length', 'max' => 7),
            array('creation_date', 'length', 'max' => 4),
            array('status, show_in_top', 'length', 'max' => 1),
            array('update_count', 'length', 'max' => 2),
            array('status', 'default', 'value' => self::STATUS_PENDING),
            array('confirm_priority', 'default', 'value' => 0),
            array('show_in_top', 'default', 'value' => 0),
            array('update_count', 'default', 'value' => 0),
            array('visit_district', 'length', 'max' => 255),
            array('description, seen, plan_title, plan_rules', 'safe'),
            array('images, purchase_details', 'safe'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, show_in_top, update_count,create_date, update_date, expire_date, user_id, brand_id, model_id, room_color_id, body_color_id, body_state_id, state_id, city_id, fuel_id, gearbox_id, car_type_id, plate_type_id, purchase_type_id, purchase_details, distance, status, visit_district, description, creation_date, confirm_priority', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'carImages' => array(self::HAS_MANY, 'CarImages', 'car_id'),
            'plateType' => array(self::BELONGS_TO, 'Lists', 'plate_type_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
            'gearbox' => array(self::BELONGS_TO, 'Lists', 'gearbox_id'),
            'carType' => array(self::BELONGS_TO, 'Lists', 'car_type_id'),
            'brand' => array(self::BELONGS_TO, 'Brands', 'brand_id'),
            'model' => array(self::BELONGS_TO, 'Models', 'model_id', 'order' => 'model.order'),
            'roomColor' => array(self::BELONGS_TO, 'Lists', 'room_color_id'),
            'bodyColor' => array(self::BELONGS_TO, 'Lists', 'body_color_id'),
            'bodyState' => array(self::BELONGS_TO, 'Lists', 'body_state_id'),
            'bodyType' => array(self::BELONGS_TO, 'Lists', 'body_type_id'),
            'fuel' => array(self::BELONGS_TO, 'Lists', 'fuel_id'),
            'state' => array(self::BELONGS_TO, 'Towns', 'state_id'),
            'city' => array(self::BELONGS_TO, 'Places', 'city_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'images' => 'تصاویر',
            'id' => 'ID',
            'create_date' => 'تاریخ ثبت',
            'update_date' => 'تاریخ ویرایش',
            'expire_date' => 'تاریخ انقضاء',
            'user_id' => 'آگهی دهنده',
            'brand_id' => 'برند',
            'model_id' => 'مدل',
            'creation_date' => 'سال تولید',
            'fuel_id' => 'نوع سوخت',
            'gearbox_id' => 'نوع گیربکس',
            'body_state_id' => 'وضعیت بدنه',
            'body_type_id' => 'نوع شاسی',
            'body_color_id' => 'رنگ بدنه',
            'room_color_id' => 'رنگ داخل',
            'plate_type_id' => 'نوع پلاک',
            'distance' => 'کارکرد',
            'car_type_id' => 'نوع خودرو',
            'purchase_details' => 'جزییات پرداخت',
            'purchase_type_id' => 'نوع پرداخت',
            'description' => 'توضیحات',
            'state_id' => 'استان',
            'city_id' => 'شهر',
            'status' => 'وضعیت آگهی',
            'visit_district' => 'محله بازدید',
            'title' => 'عنوان',
            'seen' => 'آمار بازدید',
            'plan_title' => 'عنوان پلن',
            'plan_rules' => 'قوانین پلن',
            'confirm_priority' => 'الویت در تایید',
            'show_in_top' => 'نماش در صدر',
            'update_count' => 'تعداد به روزرسانی',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search($deleted = false, $admin = false)
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('create_date', $this->create_date, true);
        $criteria->compare('update_date', $this->update_date, true);
        $criteria->compare('expire_date', $this->expire_date, true);
        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('brand_id', $this->brand_id, true);
        $criteria->compare('model_id', $this->model_id, true);
        $criteria->compare('room_color_id', $this->room_color_id, true);
        $criteria->compare('body_color_id', $this->body_color_id, true);
        $criteria->compare('body_state_id', $this->body_state_id, true);
        $criteria->compare('body_type_id', $this->body_type_id, true);
        $criteria->compare('state_id', $this->state_id, true);
        $criteria->compare('city_id', $this->city_id, true);
        $criteria->compare('fuel_id', $this->fuel_id, true);
        $criteria->compare('gearbox_id', $this->gearbox_id, true);
        $criteria->compare('car_type_id', $this->car_type_id, true);
        $criteria->compare('plate_type_id', $this->plate_type_id, true);
        $criteria->compare('purchase_type_id', $this->purchase_type_id, true);
        $criteria->compare('purchase_details', $this->purchase_details, true);
        $criteria->compare('distance', $this->distance, true);
        $criteria->compare('status', $this->status, true);
        $criteria->compare('visit_district', $this->visit_district, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('creation_date', $this->creation_date, true);
        if($deleted)
            $criteria->addCondition('status = :deleted');
        else
            $criteria->addCondition('status <> :deleted');
        $criteria->params[':deleted'] = Cars::STATUS_DELETED;
        if($admin)
            $criteria->order = 'confirm_priority DESC, id';
        else
            $criteria->order = 'id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Cars the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getTitle($html = true)
    {
        $separator = Yii::app()->language == 'fa_ir'?'،':',';
        if($html)
            return $this->brand && $this->model?"<span>{$this->creation_date}</span> | <span>{$this->brand->title}{$separator} {$this->model->title}</span>":null;
        return $this->brand && $this->model?"{$this->creation_date} | {$this->brand->title}{$separator} {$this->model->title}":null;
    }

    public function getRawTitle()
    {
        $separator = Yii::app()->language == 'fa_ir'?'،':',';
        return $this->brand && $this->model?"{$this->creation_date} | {$this->brand->title}{$separator} {$this->model->title}":null;
    }


    /**
     * Returns create advertise count in last month
     * @return int
     */
    public static function getMonthlySell()
    {
        $cr = new CDbCriteria();
        $startDate = JalaliDate::toGregorian(JalaliDate::date('Y', time(), false), JalaliDate::date('m', time(), false), 1);
        $startTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2]);
        if(JalaliDate::date('m', time(), false) <= 6)
            $endTime = $startTime + (60 * 60 * 24 * 31);
        else
            $endTime = $startTime + (60 * 60 * 24 * 30);
        $cr->addCondition('create_date >= :start_date AND create_date <= :end_date');
        $cr->params[':start_date'] = $startTime;
        $cr->params[':end_date'] = $endTime;
        return self::model()->count($cr);
    }

    /**
     * Returns create advertise count in last month
     * @return int
     */
    public static function getDailySell()
    {
        $cr = new CDbCriteria();
        $startDate = JalaliDate::toGregorian(JalaliDate::date('Y', time(), false), JalaliDate::date('m', time(), false), JalaliDate::date('d', time(), false));
        $startTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2]);
        $endTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2] . ' 23:59:59');
        $cr->addCondition('create_date >= :start_date AND create_date <= :end_date');
        $cr->params[':start_date'] = $startTime;
        $cr->params[':end_date'] = $endTime;
        return self::model()->count($cr);
    }

    public function getStatusLabel()
    {
        return $this->statusLabels[$this->status];
    }

    protected function beforeSave()
    {
        if($this->isNewRecord)
            $this->update_date = time();
        $this->distance = str_replace(',', '', $this->distance);
        $this->plan_rules = is_array($this->plan_rules)?CJSON::encode($this->plan_rules):null;
        return parent::beforeSave();
    }

    protected function afterSave()
    {
        if($this->isNewRecord){
            if($this->images)
                foreach($this->images as $image){
                    $model = new CarImages();
                    $model->car_id = $this->id;
                    $model->filename = $image;
                    @$model->save();
                }
        }else if($this->images){
            $newImages = $this->oldImages?array_diff($this->images, $this->oldImages):$this->images;
            foreach($newImages as $image){
                $model = new CarImages();
                $model->car_id = $this->id;
                $model->filename = $image;
                @$model->save();
            }
        }
        parent::afterSave();
    }

    protected function afterFind()
    {
        parent::afterFind();
        if($this->purchase_type_id == self::PURCHASE_TYPE_INSTALMENT && $this->purchase_details)
            $this->purchase_details = CJSON::decode($this->purchase_details);
        $this->plan_rules = $this->plan_rules?CJSON::decode($this->plan_rules):null;
    }

    public function getCarPlanRule($name)
    {
        return $this->plan_rules && isset($this->plan_rules[$name]) && !empty($this->plan_rules[$name])?$this->plan_rules[$name]:null;
    }

    public function getViewUrl()
    {
        return Yii::app()->createUrl('/car/'.$this->id.'-'.$this->creation_date.'-'.$this->brand->slug.'-'.$this->model->slug.'-for-sale');
    }

    public function getSecureMobile()
    {
        if($this->user && $this->user->userDetails && $this->user->userDetails->mobile){
            $firstPart = substr($this->user->userDetails->mobile, 0, 4);
            $secPart = substr($this->user->userDetails->mobile, 4, 3);
            return $firstPart . ' ' . $secPart . ' ' . 'xx xxx';
        }else
            return false;
    }

    /**
     * @return CDbCriteria
     */
    public static function getValidQuery()
    {
        $cr = new CDbCriteria();
        $cr->addCondition('status <> :deleteStatus');
        $cr->addCondition('expire_date >= :now');
        $cr->params = array(
            ':deleteStatus' => Cars::STATUS_DELETED,
            ':now' => time()
        );
        return $cr;
    }

    /**
     * @return CDbCriteria
     */
    public static function duplicateQuery()
    {
        $criteria = new CDbCriteria();
        $criteria->alias = 'car';
        $criteria->addCondition('status = :status');
        $criteria->addCondition('expire_date >= :now');
        $criteria->params = array(
            ':status' => Cars::STATUS_APPROVED,
            ':now' => time()
        );
        $criteria->order = 'car.show_in_top DESC, car.update_date DESC';
        return $criteria;
    }


    public function getSimilar($activeProvider = false)
    {
        $cr = Cars::getValidQuery();
        $cr->compare('id', '<> ' . $this->id);
        $cr->addCondition('model_id = :model_id OR brand_id = :brand_id');
        $cr->params[':model_id'] = $this->model_id;
        $cr->params[':brand_id'] = $this->brand_id;
        $cr->order = 't.show_in_top DESC, t.update_date DESC';
        return $activeProvider?new CActiveDataProvider('Cars', array(
            'criteria' => $cr
        )):$this->findAll($cr);
    }

    public function getStatusLabels($withDelete = true)
    {
        if(!$withDelete)
            unset($this->statusLabels[Cars::STATUS_DELETED]);
        return $this->statusLabels;
    }

    public function getMainImage()
    {
        if($this->carImages)
            return $this->carImages[0];
        return null;
    }

    public static function ZeroKmCarCounts()
    {
        return self::model()->count('distance = 0');
    }

    public static function ResearchCounts()
    {
        return ModelDetails::model()->count();
    }

    public function getPurchaseDetail($name)
    {
        return $this->purchase_details && is_array($this->purchase_details) && isset($this->purchase_details[$name])?$this->purchase_details[$name]:null;
    }

    public function getPrice($convert = true, $postfix = 'تومان')
    {
        if($this->purchase_details == -1)
            return 'توافقی';
        if($this->purchase_type_id == Cars::PURCHASE_TYPE_CASH)
            $p = $this->purchase_details;
        elseif($this->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT)
            $p = $this->getPurchaseDetail('totalPrice');

        $p = number_format($p);
        $p = $postfix?$p . ' ' . $postfix:$p;
        return $convert?Controller::parseNumbers($p):$p;
    }
    
    public function normalizePrice(){
        // normalize price
        if($this->purchase_type_id == Cars::PURCHASE_TYPE_CASH)
        {
            if(isset($this->purchase_details['price']) && !empty($this->purchase_details['price']))
                $this->purchase_details = str_replace(',', '', $this->purchase_details['price']);
            else
                $this->purchase_details = str_replace(',', '', $this->purchase_details);
        }
        elseif($this->purchase_type_id == Cars::PURCHASE_TYPE_INSTALMENT){
            $details = $this->purchase_details;
            $details['deliveryInDays'] = $details['deliveryInDays'] == -1?$details['deliveryInFewDays']:$details['deliveryInDays'];
            foreach($details as $key => $detail)
                $details[$key] = str_replace(',', '', $detail);
            $this->purchase_details = CJSON::encode($details);
        }else
            $this->purchase_details = -1;
        //
    }
}