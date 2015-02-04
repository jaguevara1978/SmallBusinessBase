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
/* @var $this SettingsController */
/* @var $model Settings */
/* @var $form CActiveForm */
?>

<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php $form->label($model,Yii::t('app','model.Settings.Key')) ?>
		<?php echo $form->textAreaRow($model,'key', array('class'=>'span4', 'rows'=>1, 'size'=>100,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php $form->label($model,Yii::t('app','model.Settings.Name')) ?>
		<?php echo $form->textAreaRow($model,'name', array('class'=>'span4', 'rows'=>1, 'size'=>100,'maxlength'=>100)); ?>
	</div>

	<div class="row">
		<?php $form->label($model,Yii::t('app','model.Settings.Type')) ?>
		<?php echo $form->textFieldRow($model,'type',array('class'=>'span3', 'size'=>45,'maxlength'=>45,)); ?>
	</div>

	<div class="row">
		<?php $form->label($model,Yii::t('app','model.Settings.TypeSpecs')) ?>
		<?php echo $form->textAreaRow($model,'type_specs', array('class'=>'span5', 'rows'=>1, 'size'=>150,'maxlength'=>150)); ?>
	</div>

	<div class="row">
		<?php $form->label($model,Yii::t('app','model.Settings.Value')) ?>
		<?php echo $form->textFieldRow($model,'value',array('class'=>'span3', 'size'=>45,'maxlength'=>45,)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton(Yii::t('app','general.label.Search')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->