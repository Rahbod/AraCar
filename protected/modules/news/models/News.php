<?php

/**
 * This is the model class for table "{{news}}".
 *
 * The followings are the available columns in table '{{news}}':
 * @property string $id
 * @property string $title
 * @property string $sub_title
 * @property string $summary
 * @property string $body
 * @property string $image
 * @property string $seen
 * @property string $create_date
 * @property string $publish_date
 * @property string $status
 * @property string $category_id
 * @property string $sort
 * @property string $author_id
 *
 * The followings are the available model relations:
 * @property NewsCategories $category
 * @property Tags[] $tags
 * @property NewsTagRel[] $tagsRel
 * @property Admins $author
 */
class News extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{news}}';
	}

	public $formTags=[];
	public $statusLabels=[
		'draft' => 'پیش نویس',
		'publish' => 'انتشار یافته',
		'pending' => 'تایید نشده',
	];

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		$purifier  = new CHtmlPurifier();
		$purifier->setOptions(array(
			'HTML.Allowed'=> 'p,a,b,i,br,img',
			'HTML.AllowedAttributes'=> 'style,id,class,src,a.href',
		));
		return array(
			array('title, sub_title, body, category_id', 'required'),
			array('title, sub_title, seen', 'length', 'max'=>255),
			array('summary', 'length', 'max'=>2000),
			array('title, sub_title','filter','filter' => 'strip_tags'),
			array('summary, body','filter','filter'=>array($purifier,'purify')),
			array('image', 'length', 'max'=>200),
			array('status', 'length', 'max'=>7),
			array('category_id, sort, author_id', 'length', 'max'=>10),
			array('create_date, publish_date, formTags', 'safe'),
			array('create_date', 'default' , 'value' => time()),
			array('seen', 'default' , 'value' => 0),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, sub_title, summary, body, image, seen, create_date, publish_date, status, category_id, sort', 'safe', 'on'=>'search'),
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
			'category' => array(self::BELONGS_TO, 'NewsCategories', 'category_id'),
			'tagsRel' => array(self::HAS_MANY, 'NewsTagRel', 'news_id'),
			'tags' => array(self::MANY_MANY, 'Tags', '{{news_tag_rel}}(news_id,tag_id)'),
			'author' => array(self::BELONGS_TO, 'Admins', 'author_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'شناسه خبر',
			'title' => 'عنوان خبر',
			'sub_title' => 'سوتیتر',
			'summary' => 'خلاصه',
			'body' => 'متن خبر',
			'image' => 'تصویر',
			'seen' => 'بازدید',
			'create_date' => 'تاریخ ثبت',
			'publish_date' => 'تاریخ انتشار',
			'status' => 'وضعیت',
			'category_id' => 'دسته بندی',
			'sort' => 'ترتیب',
			'formTags' => 'برچسب ها',
			'author_id' => 'نویسنده',
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
		$criteria->compare('sub_title',$this->sub_title,true);
		$criteria->compare('summary',$this->summary,true);
		$criteria->compare('body',$this->body,true);
		$criteria->compare('image',$this->image,true);
		$criteria->compare('seen',$this->seen,true);
		$criteria->compare('publish_date',$this->publish_date,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('category_id',$this->category_id,true);
		$criteria->compare('sort',$this->sort,true);
		$criteria->compare('author_id',$this->author_id,true);

        if(Yii::app()->user->roles != 'superAdmin') {
            $criteria->addCondition('author_id = :authorID');
            $criteria->params[':authorID'] = Yii::app()->user->getId();
        }

//		$criteria->sort = 't.sort';
		$criteria->order = 'create_date DESC';
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}


	protected function afterSave()
	{
		if($this->formTags && !empty($this->formTags)) {
			if(!$this->isNewRecord)
				NewsTagRel::model()->deleteAll('news_id='.$this->id);
			foreach($this->formTags as $tag) {
				$tagModel = Tags::model()->findByAttributes(array('title' => $tag));
				if($tagModel) {
					$tag_rel = new NewsTagRel();
					$tag_rel->news_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				} else {
					$tagModel = new Tags;
					$tagModel->title = $tag;
					$tagModel->save(false);
					$tag_rel = new NewsTagRel();
					$tag_rel->news_id = $this->id;
					$tag_rel->tag_id = $tagModel->id;
					$tag_rel->save(false);
				}
			}
		}
		parent::afterSave();
	}

	public function getKeywords()
	{
		$tags = CHtml::listData($this->tags,'title','title');
		return implode(',',$tags);
	}

	public function getStatusLabel(){
		return $this->statusLabels[$this->status];
	}

	/**
	 * get Valid New to show
	 * @return CDbCriteria
	 */
	public static function getValidNews(){
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.status = "publish"');
		$criteria->order = 't.publish_date DESC';
		return $criteria;
	}

	public static function getSearchCriteria($text, $words){
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.status = "publish"');
		$criteria->order = 't.publish_date DESC';
		$criteria->with = array('category');
		$condition = 't.title LIKE :text OR t.summary LIKE :text OR t.body LIKE :text OR category.title LIKE :text';
		$criteria->params['text'] = "%{$text}%";
		foreach($words as $key => $word){
			$condition .= " OR t.title LIKE :text$key OR t.summary LIKE :text$key OR t.body LIKE :text$key OR category.title LIKE :text$key";
			$criteria->params["text$key"] = "%{$word}%";
		}
		$criteria->addCondition($condition);
		$criteria->together = true;
        $criteria->order = 't.publish_date DESC';
        return $criteria;
	}
}
