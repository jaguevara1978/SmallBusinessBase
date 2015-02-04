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
/* @var $this SiteController */
/* @var $model LoginForm */
/* @var $form CActiveForm  */
$this->pageTitle=Yii::app()->name . ' - Login';
$this->breadcrumbs=array(
	Yii::t('app','general.label.Login'),
);
?>
<legend><?php echo Yii::t('app','general.label.pleaseFillOut')?></legend>
<div class="form">
<?php
$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'detlc-has-detfp-form',
		'type'=>'inline',
		'htmlOptions'=>array('class'=>'well'),
)); ?>
<?php 
// Yii::app()->clientScript->registerCoreScript('jquery');
// Yii::app()->clientScript->registerScript('something', '$("#LoginForm_username").focus();');
?>

<?php echo $form->errorSummary($model); ?>
<?php echo $form->textFieldRow($model, 'username', array('class'=>'span3')); ?>
<?php echo $form->passwordFieldRow($model, 'password', array('class'=>'span3')); ?>
<?php echo $form->checkboxRow($model, 'rememberMe'); ?>

<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>Yii::t('app','general.label.Login'))); ?>
</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
