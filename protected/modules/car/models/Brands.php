<?php

/**
 * This is the model class for table "{{brands}}".
 *
 * The followings are the available columns in table '{{brands}}':
 * @property string $id
 * @property string $logo
 * @property string $title
 * @property string $slug
 * @property string $country_id
 *
 * The followings are the available model relations:
 * @property Countries $country
 * @property Cars[] $cars
 * @property integer $carsCount
 * @property integer $modelCount
 * @property Models[] $models
 */
class Brands extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{brands}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('logo, title, slug', 'required'),
			array('logo, title, slug', 'length', 'max'=>255),
			array('slug', 'unique'),
			array('country_id', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, logo, title, slug, country_id', 'safe', 'on'=>'search'),
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
			'country' => array(self::BELONGS_TO, 'Countries', 'country_id'),
			'cars' => array(self::HAS_MANY, 'Cars', 'brand_id'),
			'carsCount' => array(self::STAT, 'Cars', 'brand_id', 'condition' => 't.status = :status', 'params' => [':status' => Cars::STATUS_APPROVED]),
			'models' => array(self::HAS_MANY, 'Models', 'brand_id', 'order' => 'models.order'),
			'modelCount' => array(self::STAT, 'Models', 'brand_id', 'condition' => 'md.id IS NOT NULL', 'join' => 'LEFT JOIN {{model_details}} md ON md.model_id=t.id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'logo' => 'لوگو',
			'title' => 'عنوان فارسی',
			'slug' => 'عنوان یکتای برند به انگلیسی',
			'country_id' => 'نوع برند',
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
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Brands the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeValidate()
    {
        $this->slug = str_ireplace(' ','-',strtolower($this->slug));
        return parent::beforeValidate();
    }
	
	public function getTopBrands()
	{
		$criteria=new CDbCriteria;
		$criteria->compare('id',$this->id,true);
		$criteria->compare('logo',$this->logo,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('slug',$this->slug,true);
		$criteria->compare('country_id',$this->country_id,true);
		$criteria->order = 'id DESC';
		return 0;
	}

	public static function getList()
	{
		return CHtml::listData(self::model()->findAll(), 'id', 'title');
	}
}