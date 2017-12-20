<?php

/**
 * This is the model class for table "{{users}}".
 *
 * The followings are the available columns in table '{{users}}':
 * @property string $id
 * @property string $username
 * @property string $password
 * @property string $email
 * @property string $role_id
 * @property string $create_date
 * @property string $status
 * @property string $verification_token
 * @property integer $change_password_request_count
 * @property integer $auth_mode
 * @property string $repeatPassword
 * @property string $oldPassword
 * @property string $newPassword
 * @property string $national_code
 *
 * The followings are the available model relations:
 * @property UserDetails $userDetails
 * @property UserTransactions[] $transactions
 * @property UserRoles $role
 * @property UserParking[] $parked
 * @property UserPlans[] $plans
 * @property UserPlans $activePlan
 * @property int $countParked
 */
class Users extends CActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return '{{users}}';
    }

    public $statusLabels = array(
        'pending' => 'در انتظار تایید',
        'active' => 'فعال',
        'blocked' => 'مسدود',
        'deleted' => 'حذف شده'
    );
    public $first_name;
    public $last_name;
    public $phone;
    public $mobile;
    public $statusFilter;
    public $repeatPassword;
    public $oldPassword;
    public $newPassword;
    public $roleId;
    public $type;
    public $verifyCode;

    /**
     * @param array $values
     */
    public function loadPropertyValues($values = array())
    {
        if(isset($values) && $values){
            $this->first_name = isset($values['first_name']) && !empty($values['first_name'])?$values['first_name']:null;
            $this->last_name = isset($values['last_name']) && !empty($values['last_name'])?$values['last_name']:null;
            $this->phone = isset($values['phone']) && !empty($values['phone'])?$values['phone']:null;
            $this->mobile = isset($values['mobile']) && !empty($values['mobile'])?$values['mobile']:null;
        }elseif($this){
            $this->first_name = $this->userDetails->first_name;
            $this->last_name = $this->userDetails->last_name;
            $this->phone = $this->userDetails->phone;
            $this->mobile = $this->userDetails->mobile;
        }
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('email, password', 'required', 'on' => 'insert,create'),
            array('verifyCode', 'activeCaptcha', 'on' => 'insert,create'),
            array('national_code', 'length', 'is' => 10, 'message' => 'کد ملی باید 10 رقم باشد.'),
            array('national_code, mobile', 'numerical', 'integerOnly' => true, 'message' => '{attribute} باید عددی باشد.'),
            array('email', 'required', 'on' => 'update'),
            array('role_id', 'default', 'value' => 1),
            array('email', 'required', 'on' => 'email, OAuthInsert'),
            array('email, national_code', 'unique', 'on' => 'insert, create, OAuthInsert, update'),
            array('change_password_request_count', 'numerical', 'integerOnly' => true),
            array('email', 'email'),
            array('email', 'filter', 'filter' => 'trim', 'on' => 'create, update'),
            array('username, password, verification_token', 'length', 'max' => 100, 'on' => 'create, update'),
            array('email', 'length', 'max' => 255),
            array('role_id, national_code', 'length', 'max' => 10),
            array('status', 'length', 'max' => 8),
            array('create_date', 'length', 'max' => 20),
            array('type, first_name, last_name, phone, mobile, national_code', 'safe'),

            // Register rules
            array('mobile, first_name, last_name, repeatPassword', 'required', 'on' => 'create'),
            array('repeatPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'create', 'message' => 'کلمه های عبور همخوانی ندارند'),
            array('email', 'email', 'on' => 'create'),
            array('email', 'unique', 'on' => 'create'),
            array('mobile', 'checkUnique', 'on' => 'create'),

            // change password rules
            array('oldPassword ,newPassword ,repeatPassword', 'required', 'on' => 'change_password'),
            array('repeatPassword', 'compare', 'compareAttribute' => 'newPassword', 'on' => 'change_password', 'message' => 'کلمه های عبور همخوانی ندارند'),
            array('oldPassword', 'oldPass', 'on' => 'change_password'),

            // recover password rules
            array('password', 'required', 'on' => 'recover_password'),
            array('repeatPassword', 'compare', 'compareAttribute' => 'password', 'on' => 'recover_password', 'message' => 'کلمه های عبور همخوانی ندارند'),

            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('type, roleId, create_date, status, verification_token, change_password_request_count, email ,statusFilter, first_name, last_name, phone, mobile, national_code', 'safe', 'on' => 'search'),
        );
    }

    public function activeCaptcha()
    {
        $code = Yii::app()->controller->createAction('captcha')->verifyCode;
        if(empty($code))
            $this->addError('verifyCode', 'کد امنیتی نمی تواند خالی باشد.');
        elseif($code != $this->verifyCode)
            $this->addError('verifyCode', 'کد امنیتی نامعتبر است.');
    }

    /**
     * Check this username is exist in database or not
     */
    public function oldPass($attribute, $params)
    {
        $bCrypt = new bCrypt();
        $record = Users::model()->findByAttributes(array('email' => $this->email));
        if(!$bCrypt->verify($this->$attribute, $record->password))
            $this->addError($attribute, 'کلمه عبور فعلی اشتباه است');
    }

    /**
     * Check this username is exist in database or not
     */
    public function checkUnique($attribute, $params)
    {
        $record = UserDetails::model()->countByAttributes(array('mobile' => $this->mobile));
        if($record)
            $this->addError($attribute, 'تلفن همراه تکراری می باشد.');
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'userDetails' => array(self::HAS_ONE, 'UserDetails', 'user_id'),
            'transactions' => array(self::HAS_MANY, 'UserTransactions', 'user_id'),
            'role' => array(self::BELONGS_TO, 'UserRoles', 'role_id'),
            'sessions' => array(self::HAS_MANY, 'Sessions', 'user_id', 'on' => 'user_type = "user"'),
            'countParked' => array(self::STAT, 'UserParking', 'user_id'),
            'parked' => array(self::HAS_MANY, 'UserParking', 'user_id'),
            'activePlan' => array(self::HAS_ONE, 'UserPlans', 'user_id', 'on' => 'activePlan.expire_date = -1 OR activePlan.expire_date > :time', 'params' => [':time' => time()], 'order' => 'activePlan.id DESC'),
            'plans' => array(self::HAS_MANY, 'UserPlans', 'user_id', 'order' => 'plans.id DESC'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'username' => 'نام کاربری',
            'password' => 'کلمه عبور',
            'role_id' => 'نقش',
            'email' => 'پست الکترونیک',
            'repeatPassword' => 'تکرار کلمه عبور',
            'oldPassword' => 'کلمه عبور فعلی',
            'newPassword' => 'کلمه عبور جدید',
            'create_date' => 'تاریخ ثبت نام',
            'status' => 'وضعیت کاربر',
            'verification_token' => 'Verification Token',
            'change_password_request_count' => 'تعداد درخواست تغییر کلمه عبور',
            'type' => 'نوع کاربری',
            'national_code' => 'کد ملی',
            'mobile' => 'تلفن همراه',
            'first_name' => 'نام',
            'last_name' => 'نام خانوادگی',
            'verifyCode' => 'کد امنیتی',
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

        $criteria->compare('username', $this->username, true);
        $criteria->compare('status', $this->statusFilter, true);
        $criteria->compare('role_id', $this->role_id);
        $criteria->compare('national_code', $this->national_code, true);
        $criteria->addSearchCondition('userDetails.first_name', $this->first_name);
        $criteria->addSearchCondition('userDetails.last_name', $this->last_name);
        $criteria->with = array('userDetails');
        $criteria->order = 'status ,t.id DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Users the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    protected function afterValidate()
    {
        if($this->isNewRecord)
            $this->password = $this->encrypt($this->password);
        parent::afterValidate();
    }

    public function encrypt($value)
    {
        $enc = NEW bCrypt();
        return $enc->hash($value);
    }

    public function afterSave()
    {
        if($this->isNewRecord){
            $model = new UserDetails;
            $model->user_id = $this->id;
            $model->first_name = $this->first_name;
            $model->last_name = $this->last_name;
            $model->phone = $this->phone;
            $model->mobile = $this->mobile;
            if(!$model->save())
                $this->addErrors($model->errors);

            $freePlan = Plans::model()->find('price = 0');
            if($freePlan){
                $model = new UserPlans;
                $model->user_id = $this->id;
                $model->plan_id = $freePlan->id;
                $model->join_date = time();
                $model->expire_date = -1;
                $model->price = 0;
                if(!$model->save())
                    $this->addErrors($model->errors);
            }
        }elseif($this->scenario == 'update'){
            $model = UserDetails::model()->findByPk($this->id);
            $model->first_name = $this->first_name;
            $model->last_name = $this->last_name;
            $model->phone = $this->phone;
            $model->mobile = $this->mobile;
            if(!@$model->save())
                $this->addErrors($model->errors);
        }
        parent::afterSave();
        return true;
    }

    public function generatePassword()
    {
        return substr(md5($this->national_code), 0, 8);
    }

    public function useGeneratedPassword()
    {
        $bCrypt = new bCrypt();
        return $bCrypt->verify($this->generatePassword(), $this->password);
    }

    /**
     * @param $plan Plans
     * @return bool
     */
    public function upgradePlan($plan)
    {
        $model = new UserPlans();
        $model->plan_id = $plan->id;
        $model->user_id = $this->id;
        $model->join_date = time();
        $model->expire_date = strtotime(date('Y/m/d 23:59:59', ($model->join_date + 30 * 24 * 60 * 60))); // 30 days
        $model->price = $plan->price;
        if($model->save())
            return $model->id;
        return false;
    }
}