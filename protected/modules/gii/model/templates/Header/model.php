<?php
/**
 * This is the template for generating the model class of a specified table.
 * - $this: the ModelCode object
 * - $tableName: the table name for this class (prefix is already removed if necessary)
 * - $modelClass: the model class name
 * - $columns: list of table columns (name=>CDbColumnSchema)
 * - $labels: list of attribute labels (name=>label)
 * - $rules: list of validation rules
 * - $relations: list of relations (name=>relation declaration)
 */
?>
<?php echo "<?php\n"; ?>
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
 * This is the model class for table "<?php echo $tableName; ?>".
 *
 * The followings are the available columns in table '<?php echo $tableName; ?>':
<?php foreach($columns as $column): ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations)): ?>
 *
 * The followings are the available model relations:
<?php foreach($relations as $name=>$relation): ?>
 * @property <?php
	if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches))
    {
        $relationType = $matches[1];
        $relationModel = $matches[2];

        switch($relationType){
            case 'HAS_ONE':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'BELONGS_TO':
                echo $relationModel.' $'.$name."\n";
            break;
            case 'HAS_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            case 'MANY_MANY':
                echo $relationModel.'[] $'.$name."\n";
            break;
            default:
                echo 'mixed $'.$name."\n";
        }
	}
    ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?php echo $modelClass; ?> extends <?php echo $this->baseClass; ?> {
	public $totalValue;
	public $sumTotalValue;
	public $totalDeposits;
	public $sumTotalDeposits;
	public $totalPending;
	public $sumTotalPending;

	protected function afterConstruct() {
<?php 
$parmsList="/*Copy this values at the end of Settings table in teh base DB...And replace nulls by the values you want*/\n\t\t";
foreach($columns as $column):
	$pos = strpos(strtolower($column->name),'date');
	$parmKey="'{$modelClass}_def_{$column->name}'";
	if($pos !== false) {
		$defValue="'Today'";
		$value="date(Yii::app()->params['General_Date_Format'], strtotime(Yii::app()->params[$parmKey]))";
	} else {
		$defValue='null';
		$value="Yii::app()->params[$parmKey]";
	}
	$parmsList.="//".$parmKey.",\n\t\t";
?>
		if (!$this-><?php echo $column->name; ?>) $this-><?php echo $column->name; ?>=<?php echo $value;?>;
<?php endforeach; ?>
		<?php echo $parmsList;?>
parent::afterConstruct();
	}

	protected function beforeSave() {
		return parent::beforeSave();
	}

	protected function afterSave() {
		parent::afterSave();
	}

	protected function beforeDelete() {
		<?php echo $modelClass; ?>Detail::model()->deleteAll('<?php echo $tableName;?>=:id',array(':id'=>$this->id));
		return parent::beforeDelete();
	}

	protected function afterDelete() {
		parent::afterDelete();
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
	 * @return <?php echo $modelClass; ?> the static model class
	 */
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
<?php if($connectionId!='db'):?>

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection() {
		return Yii::app()-><?php echo $connectionId ?>;
	}
<?php endif?>

	/**
	 * @return string the associated database table name
	 */
	public function tableName() {
		return '<?php echo $tableName; ?>';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules() {
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
<?php foreach($rules as $rule): ?>
			<?php echo $rule.",\n"; ?>
<?php endforeach; ?>
			
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations() {
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
<?php foreach($relations as $name=>$relation): ?>
			<?php echo "'$name' => $relation,\n"; ?>
<?php endforeach; ?>
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels() {
		return array(
<?php 
function className($tableName) {
	$className='';
	foreach(explode('_',$tableName) as $name)
		if($name!=='') $className.=ucfirst($name);
	return $className;
}
foreach($labels as $name=>$label): ?>
	<?php echo "		'$name'=>Yii::t('app','model.".className($tableName).".".$label."'),\n"; ?>
<?php endforeach; ?>
			'totalValue'=>Yii::t('app','general.label.totalValue'),
			'sumTotalValue'=>Yii::t('app','general.label.sumTotalValue'),
			'totalDeposits'=>Yii::t('app','general.label.totalDeposits'),
			'sumTotalDeposits'=>Yii::t('app','general.label.sumTotalDeposits'),
			'totalPending'=>Yii::t('app','general.label.totalPending'),
			'sumTotalPending'=>Yii::t('app','general.label.sumTotalPending'),
		);
	}
	
	public function criteria(){
		$criteria=new CDbCriteria;
<?php
foreach($columns as $name=>$column) {
	if($column->type==='string') {
		echo "\t\t\$criteria->compare('t.$name',\$this->$name,true);\n";
	} else {
		echo "\t\t\$criteria->compare('t.$name',\$this->$name);\n";
	}
}
?>
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
	
	public function totalProvider() {
		$criteria=$this->criteria();
		//Please modify the next line at your will
		$criteria->select='FORMAT(COALESCE(SUM(0),0),0) sumTotalValue';
		return <?php echo $modelClass; ?>::model()->find($criteria);
	}

	public static function getCount() {
		$count = <?php echo $modelClass; ?>::model()->count();
		return $count;
	}

	public function isEditable() {
		return true;
	}


	/********PROTECTED CODE FROM HERE************/
}