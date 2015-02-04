<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
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
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
<?php echo "?>"; 
$parent=$this->_parentRelationName;
$parentM=$this->_parentClassName;
$parentTableName=$this->_parentTableName;
?>

<legend><?php echo "<?php echo Yii::t('app','general.label.".$this->getModelClass()."');?>";?></legend>
<? echo "<?php \$this->renderPartial('/".$parent."/_view', array('model'=>\$model->".$parent.")); ?>\n"; ?>
<? echo "<?php if(\$model->".$parent."->status==Yii::app()->params['".$parentM."_final_status']) return; ?>\n"; ?>
<div class="form">
<?php 
echo "<?php \$form = \$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'".$this->class2id($this->modelClass)."-form',
		'type'=>'inline',
		'htmlOptions'=>array('class'=>'well'),
		'enableAjaxValidation'=>false,
));"; ?>

<?php echo "echo \$form->errorSummary(\$model);\n?>\n\n"; ?>
<?php
echo "<?php echo \$form->hiddenField(\$model, '".$parentTableName."'); ?>\n";
$firstColumn=null;
$buildNewRecordDialog=false;
foreach($this->tableSchema->columns as $column) {
	if($column->autoIncrement) continue;
	if($column->name==$parentTableName) continue;
	if (!$firstColumn) $firstColumn=$column->name;
	$activeField="<?php ".$this->generateActiveField($this->modelClass,$column)." ?>\n";
	if (!$buildNewRecordDialog)	$buildNewRecordDialog=strpos($activeField,'select2Row');
	echo $activeField;
}
?>

<?php echo "<?php Utilities::actionSaveButton(\$this, \$model->isNewRecord)?>\n"; ?>

<?php echo "<?php \$this->endWidget(); ?>\n"; ?>

<?php echo "<?php Utilities::initialFocus('".$this->getModelClass()."_".$firstColumn."'); ?>\n"; ?>
<?php echo "<?php Utilities::getFlashes(); ?>\n"; ?>

</div><!-- form -->

<?php if ($buildNewRecordDialog) echo "<?php Utilities::buildNewRecordDialog(\$this); ?>";?>