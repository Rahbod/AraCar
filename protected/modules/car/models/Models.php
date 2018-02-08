<?php

/**
 * This is the model class for table "{{models}}".
 *
 * The followings are the available columns in table '{{models}}':
 * @property string $id
 * @property string $title
 * @property string $slug
 * @property string $brand_id
 * @property string $body_type_id
 * @property string $order
 *
 * The followings are the available model relations:
 * @property Cars[] $cars
 * @property integer $carsCount
 * @property ModelDetails[] $years
 * @property ModelDetails $lastYear
 * @property Brands $brand
 * @property Lists $bodyType
 */
class Models extends SortableCActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{models}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, slug, brand_id', 'required'),
            array('slug', 'unique'),
            array('title, slug', 'length', 'max' => 255),
            array('title, slug', 'filter', 'filter' => 'trim'),
            array('brand_id, body_type_id, order', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, title, slug, brand_id, body_type_id, order', 'safe', 'on' => 'search'),
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
            'cars' => array(self::HAS_MANY, 'Cars', 'model_id'),
            'carsCount' => array(self::STAT, 'Cars', 'model_id', 'condition' => 't.status = :status', 'params' => [':status' => Cars::STATUS_APPROVED]),
            'years' => array(self::HAS_MANY, 'ModelDetails', 'model_id'),
            'lastYear' => array(self::HAS_ONE, 'ModelDetails', 'model_id', 'order' => 'product_year DESC'),
            'brand' => array(self::BELONGS_TO, 'Brands', 'brand_id'),
            'bodyType' => array(self::BELONGS_TO, 'Lists', 'body_type_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'عنوان',
            'slug' => 'عنوان یکتای مدل',
            'brand_id' => 'برند',
            'body_type_id' => 'نوع بدنه',
            'order' => 'ترتیب',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('slug', $this->slug, true);
        $criteria->compare('brand_id', $this->brand_id, true);
        $criteria->compare('body_type_id', $this->body_type_id, true);
        $criteria->compare('order', $this->order, true);
        $criteria->order = 'title';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Models the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function beforeSave()
    {
        $this->slug = str_ireplace(' ', '-', strtolower($this->slug));
        return parent::beforeSave();
    }

    public static function getList($id)
    {
        $criteria = new CDbCriteria();
        $criteria->compare('brand_id', $id);
        $criteria->order = 't.title';
        return CHtml::listData(self::model()->findAll($criteria), 'id', 'title');
    }

    public function getYears($mode = 'list')
    {
        $list=[];
        if($this->brand->country->slug == 'iran'){
            $start = 1340;
            $end = (int)JalaliDate::date('Y',time(),false);
            for($i = $end; $i>=$start; $i--)
                if($mode == 'list')
                    $list[$i] = Controller::parseNumbers($i);
                else
                    $list[] = array('id' => $i, 'title' => Controller::parseNumbers($i));
        }else{
            $start = 1930;
            $end = (int)date('Y');
            for($i = $end; $i>=$start; $i--)
                if($mode == 'list')
                    $list[$i] = Controller::parseNumbers($i);
                else
                    $list[] = array('id' => $i, 'title' => Controller::parseNumbers($i));
        }
        return $list;
    }

    public function getTitleAndBrand()
    {
        return $this->brand->title . '، ' . $this->title;
    }
}