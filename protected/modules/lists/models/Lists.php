<?php

/**
 * This is the model class for table "{{lists}}".
 *
 * The followings are the available columns in table '{{lists}}':
 * @property string $id
 * @property string $name
 * @property string $title
 * @property string $description
 * @property string $is_root
 * @property string $editable
 * @property string $parent_id
 * @property string $path
 *
 * The followings are the available model relations:
 * @property Lists $parent
 * @property Lists[] $options
 */
class Lists extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{lists}}';
	}

	public $editableLabels = [
		0 => 'ندارد',
		1 => 'دارد'
	];

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required', 'on' => 'insert'),
			array('title', 'required', 'on' => 'option_insert'),
			array('title', 'unique'
				//, 'on' => 'insert'
			),
			array('title', 'compareWithParent'),
			array('name', 'length', 'max' => 50),
			array('title, description, path', 'length', 'max' => 255),
			array('is_root, editable', 'length', 'max' => 1),
			array('parent_id', 'length', 'max' => 10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, title, description, is_root, editable, parent_id, path', 'safe', 'on' => 'search'),
		);
	}

	public function compareWithParent($attribute, $params)
	{
		if(!empty($this->title) && $this->parent_id){
			$record = Lists::model()->findByAttributes(array('id' => $this->parent_id, 'title' => $this->title));
			if($record)
				$this->addError($attribute, 'عنوان با عنوان والد یکسان است.');
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
			'parent' => array(self::BELONGS_TO, 'Lists', 'parent_id'),
			'options' => array(self::HAS_MANY, 'Lists', 'parent_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'name' => 'نام فیلد',
			'title' => 'عنوان',
			'description' => 'توضیحات',
			'is_root' => 'ریشه',
			'editable' => 'قابلیت ویرایش',
			'parent_id' => 'والد',
			'path' => 'مسیر',
		);
	}

	/**
	 * @param bool $root
	 * @param bool $parent_id
	 * @return CActiveDataProvider
	 */
	public function search($root = true, $parent_id = false)
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id, true);
		$criteria->compare('name', $this->name, true);
		$criteria->compare('title', $this->title, true);
		$criteria->compare('description', $this->description, true);
		$criteria->compare('is_root', $this->is_root, true);
		$criteria->compare('editable', $this->editable, true);
		$criteria->compare('path', $this->path, true);
		if($root)
			$criteria->addCondition('is_root = 1');

		if($parent_id)
			$criteria->compare('parent_id', $parent_id);
		else
			$criteria->compare('parent_id', $this->parent_id, true);

		$criteria->order = 'id DESC';
		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Lists the static model class
	 */
	public static function model($className = __CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string
	 */
	public function getFullTitle()
	{
		$fullTitle = $this->title;
		$model = $this;
		while($model->parent){
			$model = $model->parent;
			if($model->parent)
				$fullTitle = $model->title . ' - ' . $fullTitle;
			else
				$fullTitle = $fullTitle . ' (' . $model->title . ')';
		}
		return $fullTitle;
	}

	/**
	 * @param bool $display
	 * @return string
	 */
	public function hasEditable($display = false)
	{
		return $display?$this->editableLabels[$this->editable]:$this->editable;
	}

	public function beforeSave()
	{
		if(empty($this->parent_id))
			$this->parent_id = NULL;
		$this->path = null;
		return parent::beforeSave();
	}

	protected function afterSave()
	{
		$this->updatePath($this->id);
		return true;
	}

	/**
	 * Update Path field when model parent_id is changed
	 * @param $id
	 */
	private function updatePath($id)
	{
		/* @var $model Lists */
		$model = Lists::model()->findByPk($id);
		if($model->parent){
			$path = $model->parent->path?$model->parent->path . $model->parent_id . '-':$model->parent_id . '-';
			Lists::model()->updateByPk($model->id, array('path' => $path));
		}
		foreach($model->options as $option)
			$this->updatePath($option->id);
	}

	public function getRoots()
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('t.parent_id IS NULL AND is_root = 1');
		return $this->findAll($criteria);
	}

	public function getOptions($count = false)
	{
		$criteria = new CDbCriteria();
		$criteria->addCondition('path LIKE :regex1', 'OR');
		$criteria->addCondition('path LIKE :regex2', 'OR');
		$criteria->params[':regex1'] = $this->id . '-%';
		$criteria->params[':regex2'] = '%-' . $this->id . '-%';
		return $count?$this->count($criteria):$this->findAll($criteria);
	}

	public static function getList($name, $returnObject = false)
	{
		$data = Lists::model()->findByAttributes(['name' => $name]);
		if ($returnObject)
			return $data->getOptions();
		return $data ? CHtml::listData($data->getOptions(), 'id', 'title') : [];
	}
}