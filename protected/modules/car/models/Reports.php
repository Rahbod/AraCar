<?php

/**
 * This is the model class for table "{{reports}}".
 *
 * The followings are the available columns in table '{{reports}}':
 * @property integer $id
 * @property string $car_id
 * @property string $reason
 * @property string $description
 * 
 * The followings are the available model relations:
 * @property Cars $car
 */
class Reports extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{reports}}';
	}

    public $reasons = [
        'محتوای این آگهی نامناسب است.' => 'محتوای این آگهی نامناسب است.',
        'آگهی در برند یا مدل نامناسب قرار گرفته است.' => 'آگهی در برند یا مدل نامناسب قرار گرفته است.',
        'آگهی اسپم و چندین بار ثبت شده است.' => 'آگهی اسپم و چندین بار ثبت شده است.',
        'قیمت آگهی نامناسب است.' => 'قیمت آگهی نامناسب است.',
        'اطلاعات تماس آگهی مشکل دارد.' => 'اطلاعات تماس آگهی مشکل دارد.',
        'آگهی ارائه شده مشمول «فهرست مصادیق محتوای مجرمانه» می شود.' => 'آگهی ارائه شده مشمول «فهرست مصادیق محتوای مجرمانه» می شود.',
        'دلیل دیگر ...' => 'دلیل دیگر ...',
    ];
	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('car_id, reason', 'required'),
			array('car_id', 'length', 'max'=>10),
			array('reason', 'length', 'max'=>255),
			array('description', 'length', 'max'=>512),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, car_id, reason, description', 'safe', 'on'=>'search'),
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
			'car' => array(self::BELONGS_TO, 'Cars', 'car_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'car_id' => 'App',
			'reason' => 'دلیل‌ گزارش',
			'description' => 'توضیحات شما',
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

		$criteria->compare('id',$this->id);
		$criteria->compare('car_id',$this->car_id,true);
		$criteria->compare('reason',$this->reason,true);
		$criteria->compare('description',$this->description,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Reports the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
