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
/* @var $this UserController */
/* @var $model User */
/* @var $form TbActiveForm */
?>
<legend><?php echo Yii::t('app','general.label.User');?></legend>
<div class="form">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'user-form',
		'type'=>'inline',
		'htmlOptions'=>array('class'=>'well'),
		'enableAjaxValidation'=>false,
));
echo $form->errorSummary($model);
?>

<?php echo $form->textFieldRow($model,'username',array('class'=>'span2', 'size'=>10,'maxlength'=>10)); ?>
<?php echo $form->textFieldRow($model,'name',array('class'=>'span3', 'size'=>60,'maxlength'=>80)); ?>
<?php echo $form->passwordFieldRow($model,'password', array('class'=>'span2', 'rows'=>1, 'size'=>254,'maxlength'=>254)); ?>
<?php echo $form->passwordFieldRow($model,'repeatpassword', array('class'=>'span2', 'rows'=>1, 'size'=>254,'maxlength'=>254)); ?>
<?php echo $form->hiddenField($model,'oldPassword', array('class'=>'span2', 'rows'=>1, 'size'=>254,'maxlength'=>254)); ?>

<?php Utilities::actionSaveButton($this, $model->isNewRecord)?>

<?php $this->endWidget(); ?>

<?php Utilities::initialFocus('User_username'); ?>
<?php Utilities::getFlashes(); ?>
</div><!-- form -->