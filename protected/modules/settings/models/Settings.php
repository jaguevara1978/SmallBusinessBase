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
 * This is the model class for table "settings".
 *
 * The followings are the available columns in table 'settings':
 * @property string $key
 * @property string $group
 * @property string $group_order
 * @property string $type
 * @property string $type_specs
 * @property string $value
 * @property string $data_type
 */
class Settings extends CActiveRecord {
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Proveedores the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return 'settings';
	}
	
	protected function afterConstruct() {
		if (!$this->key) $this->key=Yii::app()->params['Settings_def_key'];
		if (!$this->group) $this->group=Yii::app()->params['Settings_def_group'];
		if (!$this->group_order) $this->group_order=Yii::app()->params['Settings_def_group'];
		if (!$this->type) $this->type=Yii::app()->params['Settings_def_type'];
		if (!$this->type_specs) $this->type_specs=Yii::app()->params['Settings_def_type_specs'];
		if (!$this->value) $this->value=Yii::app()->params['Settings_def_value'];
		if (!$this->data_type) $this->data_type=Yii::app()->params['Settings_def_data_type'];
		/*Copy this values at the end of config/main.php, into 'params'=>array()...And replace nulls by the values you want*/
		//'Settings_def_key'=>null,
		//'Settings_def_group'=>null,
		//'Settings_def_type'=>null,
		//'Settings_def_type_specs'=>null,
		//'Settings_def_value'=>null,
		//'Settings_def_data_type'=>null,
		parent::afterConstruct();
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
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('key', 'UnqAttrValidate', 'with'=>'key'),
			array('key,group,group_order','required'),
			array('key','length','max'=>100),
			array('group,type,data_type','length','max'=>45),
			array('type_specs,value','length','max'=>200),
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('key, group, type, type_specs, value, data_type', 'safe', 'on'=>'search'),
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
			'key'=>Yii::t('app','model.Settings.Key'),
			'group'=>Yii::t('app','model.Settings.Group'),
			'group_order'=>Yii::t('app','model.Settings.Group order'),
			'type'=>Yii::t('app','model.Settings.Type'),
			'type_specs'=>Yii::t('app','model.Settings.Type Specs'),
			'value'=>Yii::t('app','model.Settings.Value'),
			'data_type'=>Yii::t('app','model.Settings.Data Type'),
		);
	}

	public function criteria(){
		$criteria=new CDbCriteria;

		$criteria->compare('t.key',$this->key,true);
		$criteria->compare('t.group',$this->group,true);
		$criteria->compare('t.group_order',$this->group_order,true);
		$criteria->compare('t.type',$this->type,true);
		$criteria->compare('t.type_specs',$this->type_specs,true);
		$criteria->compare('t.value',$this->value,true);
		$criteria->compare('t.data_type',$this->data_type,true);
		return $criteria;
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search() {
		$criteria=$this->criteria();
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array('defaultOrder'=>'id DESC',),
		));
	}

	public static function getCount() {
		return Settings::model()->count();
	}

	public function isEditable() {
		return true;
	}
}