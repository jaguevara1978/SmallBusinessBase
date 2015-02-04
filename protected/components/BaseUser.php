<?php
/* 
Small business administrator
Copyright (C) 2013 JULIO ALEXANDER GUEVARA MARULANDA

This program is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/
/**
 * This is the model class for table "User".
 *
 * The followings are the available columns in table 'User':
 * @property integer $id
 * @property string $username
 * @property string $name
 * @property string $password
 */
class BaseUser extends CActiveRecord {
	public $repeatpassword;
	public $oldPassword;
	
	protected function afterConstruct() {
		if (!$this->id) $this->id=Yii::app()->params['User_def_id'];
		if (!$this->username) $this->username=Yii::app()->params['User_def_username'];
		if (!$this->name) $this->name=Yii::app()->params['User_def_name'];
		if (!$this->password) $this->password=Yii::app()->params['User_def_password'];
		/*Copy this values at the end of config/main.php, into 'params'=>array()...And replace nulls by the values you want*/
		//'User_def_id'=>null,
		//'User_def_username'=>null,
		//'User_def_name'=>null,
		//'User_def_password'=>null,
		parent::afterConstruct();
	}

	protected function beforeSave() {
		if ($this->isNewRecord
			|| !($this->oldPassword===$this->password)) {
			$this->password = $this->encrypt($this->password);
		}
        return parent::beforeSave();
    }

    public function encrypt($value) {
    	$enc = new Encrypter();
        return $enc->hash($value);
    }

	public function behaviors() {
		return array(
			'RememberFilters' => array(
				'class' => 'RememberFilters',
				'defaults'=>array(), /* optional line */
				'defaultStickOnClear'=>false /* optional line */
			),
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return User the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'User';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('username','unique','attributeName'=>'username','className'=>'User','allowEmpty'=>false),
			// convert username to lower case
			array('username', 'filter', 'filter'=>'strtolower'),
			array('repeatpassword', 'compare', 'compareAttribute'=>'password', 'message'=>Yii::t('app','messages.passwordsDoNotMatch')),
				
			array('username, name, password, oldPassword', 'required'),
			array('username', 'length', 'max'=>10),
			array('name', 'length', 'max'=>80),
			array('password', 'length', 'max'=>254),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('id, username, name, password', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
			'id'=>Yii::t('app','model.User.ID'),
			'username'=>Yii::t('app','model.User.Username'),
			'name'=>Yii::t('app','model.User.Name'),
			'password'=>Yii::t('app','model.User.Password'),
			'repeatpassword'=>Yii::t('app','model.User.repeatPassword'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('username',$this->username,true);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('password',$this->password,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'id DESC',),
		));
	}
		
	public static function getList(){
		$criteria=new CDbCriteria;
		$criteria->select="id,CONCAT(IF(code<>'', CONCAT(code,' - '), ''),name) name";
		$criteria->order='name ASC';
		return CHtml::listData(User::model()->findAll($criteria),'id','name');
	}
	
	public static function getCount() {
		$count = User::model()->count();
		return $count;
	}	
}