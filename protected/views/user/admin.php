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
?>
<?php
/* @var $this UserController */
/* @var $model User */

$this->breadcrumbs=array(
	Yii::t('app','general.label.Users'),
	Yii::t('app','general.label.manage'),
);

$this->menu=array(
	array('label'=>Yii::t('app','general.label.Create')." ".Yii::t('app','general.label.User'), 'url'=>array('create')),
);
?>

<?php
 $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'user-grid',
    'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		array(
			'class'=>'EditableColumn',
			'name'=>'username',
			
			'editable'=>array(
					'url'=>CController::createUrl('User/updateUsername'),
					'inputclass'=>'span2',
					
					
			),
		),
		array(
			'class'=>'EditableColumn',
			'name'=>'name',
			
			'editable'=>array(
					'url'=>CController::createUrl('User/updateName'),
					'inputclass'=>'span3',
					
					
			),
		),
		array(
			'class'=>'EditableColumn',
			'name'=>'password',
			
			'editable'=>array(
					'url'=>CController::createUrl('User/updatePassword'),
					'inputclass'=>'span2',
					'type'=>'text',
					
					'placement'=>'left',
			),
		),

		array (
			'class'=>'ButtonColumnClearFilters',
			'template'=>'{delete}',
			'label'=>Yii::t('app','general.button.clearFilters'),
			'header'=>Yii::t('app','general.label.ops'),
			'deleteConfirmation'=>"js:'".Yii::t('app','message.confirmDelete')."\\n"
				.Yii::t('app','model.User.Username').": '+$(this).parent().parent().children(':nth-child(1)').text()
				+'\\n".Yii::t('app','model.User.Name').": '+$(this).parent().parent().children(':nth-child(2)').text()
				+'\\n".Yii::t('app','model.User.Password').": '+$(this).parent().parent().children(':nth-child(3)').text()",
		),
	),
)); ?>
