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
/* @var $this SettingsController */
/* @var $model Settings */
?>
<?php
$disabled=!$model->isEditable();
$disabled=false;
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id'=>'settings-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
		'columns'=>array(
		array(
			'class'=>'EditableColumn',
			'name'=>'key',
			
			'editable'=>array(
					'url'=>CController::createUrl('Settings/updateKey'),
					'inputclass'=>'span2',
					'type'=>'textarea',
					
					
			),
		),
		array(
			'class'=>'EditableColumn',
			'name'=>'name',
			
			'editable'=>array(
					'url'=>CController::createUrl('Settings/updateName'),
					'inputclass'=>'span2',
					'type'=>'textarea',
					
					
			),
		),
		array(
			'class'=>'EditableColumn',
			'name'=>'type',
			
			'editable'=>array(
					'url'=>CController::createUrl('Settings/updateType'),
					'inputclass'=>'span3',
					
					
			),
		),
		array(
			'class'=>'EditableColumn',
			'name'=>'type_specs',
			
			'editable'=>array(
					'url'=>CController::createUrl('Settings/updateTypeSpecs'),
					'inputclass'=>'span2',
					'type'=>'textarea',
					
					'placement'=>'left',
			),
		),
		array(
			'class'=>'EditableColumn',
			'name'=>'value',
			
			'editable'=>array(
					'url'=>CController::createUrl('Settings/updateValue'),
					'inputclass'=>'span3',
					
					'placement'=>'left',
			),
		),

		array (
			'class'=>'ButtonColumnClearFilters',
			'template'=>'{delete}',
			'label'=>Yii::t('app','general.button.clearFilters'),
			'header'=>Yii::t('app','general.label.ops'),
			'viewButtonImageUrl'=>Yii::app()->request->baseUrl.Yii::app()->params['General_BaseImageDirectory'].'Show.png',
			'updateButtonImageUrl'=>Yii::app()->request->baseUrl.Yii::app()->params['General_BaseImageDirectory'].'Edit.png',
			'deleteButtonImageUrl'=>Yii::app()->request->baseUrl.Yii::app()->params['General_BaseImageDirectory'].'Erase.png',
			'deleteConfirmation'=>"js:'".Yii::t('app','message.confirmDelete')."\\n"
				.Yii::t('app','model.Settings.Key').": '+$(this).parent().parent().children(':nth-child(1)').text()
				+'\\n".Yii::t('app','model.Settings.Name').": '+$(this).parent().parent().children(':nth-child(2)').text()
				+'\\n".Yii::t('app','model.Settings.Type').": '+$(this).parent().parent().children(':nth-child(3)').text()
				+'\\n".Yii::t('app','model.Settings.TypeSpecs').": '+$(this).parent().parent().children(':nth-child(4)').text()
				+'\\n".Yii::t('app','model.Settings.Value').": '+$(this).parent().parent().children(':nth-child(5)').text()",
		),
	),
)); ?>
