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
 * @property string $year_id
 * @property string $room_color_id
 * @property string $body_color_id
 * @property string $body_state_id
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
 *
 * The followings are the available model relations:
 * @property CarImages[] $images
 * @property Lists $plateType
 * @property Users $user
 * @property Brands $brand
 * @property Models $model
 * @property Lists $gearbox
 * @property Lists $carType
 * @property Lists $roomColor
 * @property Lists $bodyColor
 * @property Lists $bodyState
 * @property Lists $state
 * @property Lists $city
 * @property Lists $fuel
 */
class Cars extends CActiveRecord
{
    public $images;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{cars}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, brand_id, model_id, year_id, room_color_id, body_color_id, body_state_id, state_id, city_id, fuel_id, gearbox_id, car_type_id, plate_type_id, purchase_type_id, creation_date, images', 'required'),
			array('create_date, update_date, expire_date', 'length', 'max'=>20),
			array('user_id, brand_id, model_id, year_id, room_color_id, body_color_id, body_state_id, state_id, city_id, fuel_id, gearbox_id, car_type_id, plate_type_id, purchase_type_id', 'length', 'max'=>10),
			array('purchase_details', 'length', 'max'=>1024),
			array('distance', 'length', 'max'=>6),
			array('creation_date', 'length', 'max'=>4),
			array('status', 'length', 'max'=>1),
			array('visit_district', 'length', 'max'=>255),
			array('description', 'safe'),
			array('images', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, create_date, update_date, expire_date, user_id, brand_id, model_id, year_id, room_color_id, body_color_id, body_state_id, state_id, city_id, fuel_id, gearbox_id, car_type_id, plate_type_id, purchase_type_id, purchase_details, distance, status, visit_district, description, creation_date', 'safe', 'on'=>'search'),
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
			'images' => array(self::HAS_MANY, 'CarImages', 'car_id'),
			'plateType' => array(self::BELONGS_TO, 'Lists', 'plate_type_id'),
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'gearbox' => array(self::BELONGS_TO, 'Lists', 'gearbox_id'),
			'carType' => array(self::BELONGS_TO, 'Lists', 'car_type_id'),
			'brand' => array(self::BELONGS_TO, 'Brands', 'brand_id'),
			'model' => array(self::BELONGS_TO, 'Models', 'model_id'),
			'roomColor' => array(self::BELONGS_TO, 'Lists', 'room_color_id'),
			'bodyColor' => array(self::BELONGS_TO, 'Lists', 'body_color_id'),
			'bodyState' => array(self::BELONGS_TO, 'Lists', 'body_state_id'),
			'state' => array(self::BELONGS_TO, 'Lists', 'state_id'),
			'city' => array(self::BELONGS_TO, 'Lists', 'city_id'),
			'fuel' => array(self::BELONGS_TO, 'Lists', 'fuel_id'),
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
			'year_id' => 'سال تولید',
			'room_color_id' => 'رنگ داخل',
			'body_color_id' => 'رنگ بدنه',
			'body_state_id' => 'وضعیت بدنه',
			'state_id' => 'استان',
			'city_id' => 'شهر',
			'fuel_id' => 'نوع سوخت',
			'gearbox_id' => 'نوع گیربکس',
			'car_type_id' => 'نوع خودرو',
			'plate_type_id' => 'نوع پلاک',
			'purchase_type_id' => 'نوع پرداخت',
			'purchase_details' => 'جزییات پرداخت',
			'distance' => 'کارکرد',
			'status' => 'وضعیت آگهی',
			'visit_district' => 'محله بازدید',
			'description' => 'توضیحات',
			'creation_date' => 'سال تولید',
			'title' => 'عنوان',
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
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('update_date',$this->update_date,true);
		$criteria->compare('expire_date',$this->expire_date,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('brand_id',$this->brand_id,true);
		$criteria->compare('model_id',$this->model_id,true);
		$criteria->compare('year_id',$this->year_id,true);
		$criteria->compare('room_color_id',$this->room_color_id,true);
		$criteria->compare('body_color_id',$this->body_color_id,true);
		$criteria->compare('body_state_id',$this->body_state_id,true);
		$criteria->compare('state_id',$this->state_id,true);
		$criteria->compare('city_id',$this->city_id,true);
		$criteria->compare('fuel_id',$this->fuel_id,true);
		$criteria->compare('gearbox_id',$this->gearbox_id,true);
		$criteria->compare('car_type_id',$this->car_type_id,true);
		$criteria->compare('plate_type_id',$this->plate_type_id,true);
		$criteria->compare('purchase_type_id',$this->purchase_type_id,true);
		$criteria->compare('purchase_details',$this->purchase_details,true);
		$criteria->compare('distance',$this->distance,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('visit_district',$this->visit_district,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('creation_date',$this->creation_date,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Cars the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function getTitle(){
        $separator = Yii::app()->language == 'fa_ir'?'،':',';
		return $this->brand && $this->model?"{$this->creation_date}{$separator} {$this->brand->title}{$separator} {$this->model->title}":null;
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
		if (JalaliDate::date('m', time(), false) <= 6)
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
        $endTime = strtotime($startDate[0] . '/' . $startDate[1] . '/' . $startDate[2].' 23:59:59');
		$cr->addCondition('create_date >= :start_date AND create_date <= :end_date');
		$cr->params[':start_date'] = $startTime;
		$cr->params[':end_date'] = $endTime;
		return self::model()->count($cr);
	}
}
