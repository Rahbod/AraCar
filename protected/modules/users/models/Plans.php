<?php

/**
 * This is the model class for table "{{plans}}".
 *
 * The followings are the available columns in table '{{plans}}':
 * @property string $id
 * @property string $title
 * @property integer $price
 * @property string $rules
 * @property string $status
 *
 * The followings are the available model relations:
 * @property UserPlans[] $userPlans
 */
class Plans extends CActiveRecord
{
	const STATUS_DISABLED = 0;
	const STATUS_ENABLED = 1;
    public static $statusLabels = [
        0 => 'غیر فعال',
        1 => 'فعال',
    ];

    public $adsCount;
    public $adsDuration;
    public $adsImageCount;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{plans}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, adsCount, adsDuration, adsImageCount, price', 'required'),
			array('price', 'numerical', 'integerOnly'=>true),
			array('price', 'checkPrice'),
			array('title', 'length', 'max'=>255),
			array('rules', 'length', 'max'=>1024),
			array('status', 'length', 'max'=>1),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, price, rules, status', 'safe', 'on'=>'search'),
		);
	}

    /**
     * Check price rule
     * @param string $attribute
     * @param array $params
     * @return boolean
     */
    public function checkPrice($attribute, $params)
    {
        if ($this->id != 1 and $this->$attribute < 100)
            $this->addError($attribute, $this->getAttributeLabel($attribute) . ' نمی تواند کمتر از 100 تومان باشد.');
        return true;
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'userPlans' => array(self::HAS_MANY, 'UserPlans', 'plan_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه',
			'title' => 'عنوان',
			'price' => 'تعرفه',
			'rules' => 'قوانین',
			'status' => 'وضعیت',
			'adsCount' => 'تعداد آگهی مجاز',
			'adsDuration' => 'مدت آگهی',
			'adsImageCount' => 'تعداد تصویر آگهی',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('price',$this->price);
		$criteria->compare('rules',$this->rules,true);
		$criteria->compare('status',$this->status,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Plans the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}