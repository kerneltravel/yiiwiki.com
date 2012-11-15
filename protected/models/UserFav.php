<?php

/**
 * 用户喜欢、关注表 模型
 *
 * 对应表 'user_fav'
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $article_id
 * @property integer $type
 * @property integer $create_date
 * @property integer $modify_date
 */
class UserFav extends CActiveRecord
{
    const TYPE_FOLLOW = 1;
    const TYPE_UNFOLLOW = 2;

    const TYPE_THUMB_UP = 3;
    const TYPE_THUMB_DOWN = 4;

    public static $types = array(
        self::TYPE_FOLLOW => '关注',
        self::TYPE_UNFOLLOW => '取消关注',
        self::TYPE_THUMB_DOWN => '不支持',
        self::TYPE_THUMB_UP => '支持'
    );

    /**
	 * Returns the static model of the specified AR class.
	 * @return UserFav the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{user_fav}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('user_id, article_id, type, create_date, modify_date', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, user_id, article_id, type, create_date, modify_date', 'safe', 'on'=>'search'),
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
            'user'=>array(self::BELONGS_TO, 'User', 'user_id'),
            'article'=>array(self::BELONGS_TO, 'Article', 'article_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'user_id' => 'User',
			'article_id' => 'Article',
			'type' => 'Type',
			'create_date' => 'Create Date',
			'modify_date' => 'Modify Date',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('user_id',$this->user_id);
		$criteria->compare('article_id',$this->article_id);
		$criteria->compare('type',$this->type);
		$criteria->compare('create_date',$this->create_date);
		$criteria->compare('modify_date',$this->modify_date);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

    protected function  beforeSave() {
        if(parent::beforeSave()){
            if($this->isNewRecord){
                $this->create_date = $this->modify_date = time();
            }else
                $this->modify_date = time();
            return true;
        }else
            return false;
    }

    public static function favExists($article_id, $type){
        $user_id = Yii::app()->user->id;
        return self::model()->exists('article_id=:article_id and type=:type and user_id=:user_id',array(':user_id'=>$user_id,':article_id'=>$article_id,':type'=>$type));
    }

    public static function add($article_id, $type){
        $model = new self;
        $model->user_id = Yii::app()->user->id;
        $model->article_id = $article_id;
        $model->type = $type;
        return $model->save();
    }

    public static function remove($article_id, $type){
        $user_id = Yii::app()->user->id;
        $model = self::model()->find('article_id=:article_id and type=:type and user_id=:user_id',array(':user_id'=>$user_id,':article_id'=>$article_id,':type'=>$type));
        return $model->delete();
    }

    public static function change( $article_id, $oldType, $newType){
        $user_id = Yii::app()->user->id;
        $model = self::model()->find('article_id=:article_id and type=:type and user_id=:user_id',array(':user_id'=>$user_id,':article_id'=>$article_id,':type'=>$oldType));
        $model->type = $newType;
        return $model->save();
    }

    public static function getCountByType($article_id,$type){
        return self::model()->count('article_id=:article_id and type=:type',array(':article_id'=>$article_id,':type'=>$type));
    }

    public static function getFollowCount($article_id){
        return self::getCountByType($article_id, self::TYPE_FOLLOW);
    }

    public static function getThumbUpCount($article_id){
        return self::getCountByType($article_id, self::TYPE_THUMB_UP);
    }

    public static function getThumbDownCount($article_id){
        return self::getCountByType($article_id, self::TYPE_THUMB_DOWN);
    }
}