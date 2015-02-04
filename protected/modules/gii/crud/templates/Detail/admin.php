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
<?php 
function className($tableName) {
	$className='';
	foreach(explode('_',$tableName) as $name)
		if($name!=='') $className.=ucfirst($name);
	return $className;
}
$parentTableName=$this->_parentTableName;
echo "\$totalProvider=\$model->totalProvider();\n";
echo "\$disabled=false;\n";
echo "\$disabled=!\$model->isEditable();\n";

/*Date Fields dispositions*/
$dateFields=array();
$dateFieldsAsText='';
foreach($this->tableSchema->columns as $column) {
	$pos = strpos(strtolower($column->name),'date');
	if($pos !== false) {
		$dateFields[]=$column->name;
		if ($dateFieldsAsText) $dateFieldsAsText.=',';
		$dateFieldsAsText.="'".$column->name."'";
	}
}
if ($dateFieldsAsText) echo "\$reInstall=Utilities::registerDatePickerReInstall(array(".$dateFieldsAsText."));\n";
/*Date Fields dispositions*/

foreach($this->tableSchema->foreignKeys as $fk) {
	if($fk[0]==$parentTableName) continue;
	echo "\$".$fk[0]."List=".className($fk[0])."::getList();\n";
}

$afterAjax='';
if (count($dateFields) > 0) $afterAjax="'afterAjaxUpdate'=>\$reInstall,\n";
?>$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'<?php echo $this->class2id($this->modelClass); ?>-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'fixedHeader'=>true,
	<?php echo $afterAjax; ?>
	'columns'=>array(
<?php

function calculateSpan($column) {
	$size=$column->size;
	$span='';
	switch ($size) {
		case ($size <= 5):
			$span="'inputclass'=>'span1',";
			break;
		case ($size <= 20):
			$span="'inputclass'=>'span2',";
			break;
		case ($size <= 80):
			$span="'inputclass'=>'span3',";
			break;
		default:
			$span="'inputclass'=>'span2',
					'type'=>'textarea',";
			break;
	}
	return $span;
}

$count=0;
$arraySize=sizeof($this->tableSchema->columns);
$placement='';
foreach($this->tableSchema->columns as $column) {
	if($column->autoIncrement)continue;
	if($column->name==$parentTableName) continue;
	$inputClass='';
	$type='';
	$filter='';
	if ($arraySize - (++$count) < 2) $placement="'placement'=>'left',";
	if ($this->tableSchema->foreignKeys[$column->name]) {
		$type="'type'=>'select',
				'source'=>\$".$column->name."List,
				'options'=>array('showbuttons'=>false,),";
		$filter="'filter'=>\$".$column->name."List,";
	 } else $inputClass=calculateSpan($column);

if (in_array($column->name,$dateFields)) {
	echo "		Utilities::editableColumnDatePicker(\$this,\$model,'".$this->getModelClass()."/update".className($column->name)."','".$column->name."'),\n";
} else
	if($column->type=='string' && $column->size<=1)
		echo "\t\tUtilities::toggleButtonColumn('".$column->name."','".$this->getModelClass()."/toggle'),\n";
	else echo "\t\tarray(
			'class'=>'EditableColumn',
			'name'=>'".$column->name."',
			".$filter."
			'editable'=>array(
					'url'=>CController::createUrl('".$this->getModelClass()."/update".className($column->name)."'),
					".$inputClass."
					".$type."
					".$placement."
			),
		),\n";
}
?>
		array(
			'name'=>'totalValue',
			'value'=>'$data->quantity * $data->unit_value',
			'type'=>'number',
			'footer'=>$totalProvider->sumTotalValue,
			'htmlOptions'=>array('style'=>Yii::app()->params['General_Styles_TotalColumn']),
			'footerHtmlOptions'=>array('style'=>Yii::app()->params['General_Styles_TotalFooter']),
			'filter'=>false,
		),
		array (
			'class'=>'CButtonColumn',
			'template'=>'{delete}',
			'header'=>Yii::t('app','general.label.ops'),
			'deleteConfirmation'=>"js:'".Yii::t('app','message.confirmDelete')."\\n"
			<?php 
			$count=0;
			$totalCount=0;
			$size=count($this->tableSchema->columns);
			foreach($this->tableSchema->columns as $column) {
				++$totalCount;
				if($column->autoIncrement) continue;
				if($column->name==$parentTableName) continue;
				++$count;
				if ($count <= 1) echo "	.Yii::t('app','model.".className($this->tableSchema->name).".".className($column->name)."').\": '+\$(this).parent().parent().children(':nth-child(".$count.")').text()";
				else
echo "				+'\\\\n\".Yii::t('app','model.".className($this->tableSchema->name).".".className($column->name)."').\": '+\$(this).parent().parent().children(':nth-child(".$count.")').text()";
				if ($totalCount>=$size) {
echo "				\n+'\\\\n\".Yii::t('app','model.".className($this->tableSchema->name).".totalValue').\": '+\$(this).parent().parent().children(':nth-child(".++$count.")').text()";
					echo "\",\n";
				}
				else echo "\n";
			}
			?>
		),
	),
)); ?>