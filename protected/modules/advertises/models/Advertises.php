<?php

/**
 * This is the model class for table "{{advertises}}".
 *
 * The followings are the available columns in table '{{advertises}}':
 * @property string $id
 * @property string $title
 * @property string $banner
 * @property string $link
 * @property string $placement
 * @property string $create_date
 * @property string $expire_date
 * @property string $status
 * @property string $script
 * @property string $type
 */
class Advertises extends CActiveRecord
{
    const PLACE_HOME_SLIDER_STATICS_ABOVE = 1;
    const PLACE_HOME_SLIDER_STATICS_BELOW = 2;
    const PLACE_HOME_SLIDER_LEFT = 3;
    const PLACE_HOME_LOGOS_LEFT = 4;
    const PLACE_HOME_LOGOS_RIGHT = 5;
    const PLACE_CAR_LIST_BETWEEN_CARS = 6;
    const PLACE_CAR_LIST_LEFT = 7;
    const PLACE_CAR_LIST_RIGHT = 8;
    const PLACE_CAR_LIST_BELOW_FILTERS = 9;
    const PLACE_NEWS_LIST_LEFT = 10;
    const PLACE_NEWS_LIST_RIGHT = 11;
    const PLACE_NEWS_LIST_HEADER_LEFT = 12;
    const PLACE_NEWS_LIST_HEADER_CENTER = 13;
    const PLACE_NEWS_TOP = 14;

    const STATUS_DISABLE = 0;
    const STATUS_ENABLE = 1;

    const TYPE_SCRIPT = 1;
    const TYPE_BANNER = 2;

    public $placementLabels = [
        self::PLACE_HOME_SLIDER_STATICS_ABOVE => 'صفحه اصلی - روی اسلایدر - بالای آمار',
        self::PLACE_HOME_SLIDER_STATICS_BELOW => 'صفحه اصلی - روی اسلایدر - زیر آمار',
        self::PLACE_HOME_SLIDER_LEFT => 'صفحه اصلی - روی اسلایدر - سمت چپ',
        self::PLACE_HOME_LOGOS_LEFT => 'صفحه اصلی - سمت چپ لوگوها',
        self::PLACE_HOME_LOGOS_RIGHT => 'صفحه اصلی - سمت راست لوگوها',
        self::PLACE_CAR_LIST_BETWEEN_CARS => 'صفحه آگهی ها - بین آگهی ها',
        self::PLACE_CAR_LIST_LEFT => 'صفحه آگهی ها - سمت چپ صفحه',
        self::PLACE_CAR_LIST_RIGHT => 'صفحه آگهی ها - سمت راست صفحه',
        self::PLACE_CAR_LIST_BELOW_FILTERS => 'صفحه آگهی ها - زیر فیلترها',
        self::PLACE_NEWS_TOP => 'صفحه اخبار - بالای لیست',
        self::PLACE_NEWS_LIST_LEFT => 'صفحه اخبار - سمت چپ صفحه',
        self::PLACE_NEWS_LIST_RIGHT => 'صفحه اخبار - سمت راست صفحه',
        self::PLACE_NEWS_LIST_HEADER_LEFT => 'صفحه اخبار - سمت چپ نوار بالا',
        self::PLACE_NEWS_LIST_HEADER_CENTER => 'صفحه اخبار - وسط نوار بالا',
    ];

    public $statusLabels = [
        self::STATUS_DISABLE => 'فعال',
        self::STATUS_ENABLE => 'غیرفعال',
    ];

    public $typeLabels = [
        self::TYPE_SCRIPT => 'کد تبلیغ',
        self::TYPE_BANNER => 'تصویر و لینک',
    ];

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{advertises}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, banner, link', 'length', 'max'=>255),
			array('placement', 'length', 'max'=>2),
			array('create_date, expire_date', 'length', 'max'=>20),
			array('status, type', 'length', 'max'=>1),
//			array('script', 'filter', 'filter' => 'strip_tags'),
			array('script', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, banner, link, placement, create_date, expire_date, status, type', 'safe', 'on'=>'search'),
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
			'banner' => 'تصویر',
			'link' => 'لینک',
			'placement' => 'مکان در سایت',
			'create_date' => 'تاریخ ثبت',
			'expire_date' => 'تاریخ انقضا',
			'status' => 'وضعیت',
			'type' => 'نوع تبلیغ',
			'script' => 'کد تبلیغ',
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
		$criteria->compare('banner',$this->banner,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('placement',$this->placement,true);
		$criteria->compare('create_date',$this->create_date,true);
		$criteria->compare('expire_date',$this->expire_date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('type',$this->type);
		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Advertises the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function getPlacementLabels($all = true)
    {
        if ($all)
            return $this->placementLabels;
        $exists = Yii::app()->db->createCommand()
            ->select('placement')
            ->from('{{advertises}}')
            ->group('placement');

        if(!$this->isNewRecord && $this->placement)
            $exists->andWhere('placement != :placement', [':placement' => $this->placement]);

        $validPlaces = array_filter($this->placementLabels, function ($k) use ($exists) {
            return !in_array($k, $exists->queryColumn());
        }, ARRAY_FILTER_USE_KEY);
        return $validPlaces ?: ['' => 'تمام مکان های تبلیغات پر هستند'];
    }

    public function getPlacementLabel()
    {
        return isset($this->placementLabels[$this->placement]) ? $this->placementLabels[$this->placement] : "";
    }

    public function getStatusLabels(){
        return $this->statusLabels;
    }

    public function getStatusLabel()
    {
        return isset($this->statusLabels[$this->status]) ? $this->statusLabels[$this->status] : "";
    }

    public function getTypeLabels(){
        return $this->typeLabels;
    }

    public function getTypeLabel()
    {
        return isset($this->typeLabels[$this->type]) ? $this->typeLabels[$this->type] : "";
    }

    public static function GetInPlacement($placement)
    {
        $cr = new CDbCriteria();
        $cr->compare('placement', $placement);
        return self::model()->find($cr);
    }
}
