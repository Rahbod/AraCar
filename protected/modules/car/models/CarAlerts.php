<?php

/**
 * This is the model class for table "{{car_alerts}}".
 *
 * The followings are the available columns in table '{{car_alerts}}':
 * @property string $id
 * @property string $user_id
 * @property string $model_id
 * @property string $from_year
 * @property string $to_year
 * @property string $from_price
 * @property string $to_price
 * @property string $create_date
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property Models $model
 */
class CarAlerts extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{car_alerts}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_id', 'required'),
			array('user_id, model_id, from_price, to_price', 'length', 'max'=>10),
			array('from_year, to_year', 'length', 'max'=>4),
			array('to_year', 'compare', 'operator' => '>=', 'compareAttribute' => 'from_year', 'message'=>'نباید بزرگتر از سال شروع باشد.'),
			array('to_price', 'compare', 'operator' => '>=', 'compareAttribute' => 'from_price', 'message'=>'نباید بزرگتر از قیمت شروع باشد.'),
			array('create_date', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, user_id, model_id, from_year, to_year, from_price, to_price, create_date', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
			'model' => array(self::BELONGS_TO, 'Models', 'model_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'کاربر',
			'model_id' => 'مدل',
			'from_year' => 'از سال',
			'to_year' => 'تا سال',
			'from_price' => 'از قیمت',
			'to_price' => 'تا قیمت',
			'create_date' => 'تاریخ ثبت',
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
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('model_id',$this->model_id,true);
		$criteria->compare('from_year',$this->from_year,true);
		$criteria->compare('to_year',$this->to_year,true);
		$criteria->compare('from_price',$this->from_price,true);
		$criteria->compare('to_price',$this->to_price,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CarAlerts the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
