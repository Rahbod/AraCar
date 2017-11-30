<?php

/**
 * This is the model class for table "{{model_details}}".
 *
 * The followings are the available columns in table '{{model_details}}':
 * @property string $id
 * @property string $model_id
 * @property string $product_year
 * @property string $images
 * @property string $details
 *
 * The followings are the available model relations:
 * @property Models $model
 */
class ModelDetails extends CActiveRecord
{
    public static $detailFields = [
        [
            'title' => 'ویژگی ها',
            'name' => 'attributes',

        ]
    ];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{model_details}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_id, product_year', 'required'),
			array('product_year', 'checkYear', 'on' => 'insert'),
			array('model_id', 'length', 'max'=>10),
			array('product_year', 'length', 'is'=>4),
			array('images, details', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, model_id, product_year, images, details', 'safe', 'on'=>'search'),
		);
	}

    public function checkYear($attribute, $params)
    {
        $year = (int)$this->$attribute;
        $unique = $this->findByAttributes(array('model_id' => $this->model_id, 'product_year' => $year));
        if($unique !== null)
            $this->addError($attribute, 'این سال تولید قبلا برای این مدل ایجاد شده است.');
        else{
            if($this->model->brand->country->slug == 'iran')
                if($year < 1370 && $year > 1410)
                    $this->addError($attribute, 'سال تولید نامعتبر است.');
                else if($year < 1990 && $year > 2030)
                    $this->addError($attribute, 'سال تولید نامعتبر است.');
        }
    }

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
            'model' => array(self::BELONGS_TO, 'Models', 'model_id')
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'model_id' => 'Model',
			'product_year' => 'سال تولید',
			'images' => 'تصاویر',
			'details' => 'جزییات',
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

		$criteria->compare('model_id',$this->model_id);
		$criteria->compare('product_year',$this->product_year,true);
		$criteria->order = 'product_year DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ModelDetails the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    protected function beforeSave()
    {
        $this->images = $this->images && is_array($this->images)?CJSON::encode($this->images):null;
        $this->details = $this->details && is_array($this->details)?CJSON::encode($this->details):null;
        return parent::beforeSave();
    }

    protected function afterFind()
    {
        parent::afterFind();
        $this->images = $this->images?CJSON::decode($this->images):null;
        $this->details = $this->details?CJSON::decode($this->details):null;
    }
}
