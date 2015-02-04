<?php
$this->breadcrumbs=array(
	Yii::t('app', 'general.label.Backups')=>array('index'),
	Yii::t('app', 'general.button.Upload'),
);?>
<div class="form">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id' => 'install-form',
	'enableAjaxValidation' => true,
	'type'=>'inline',
	'htmlOptions'=>array('class'=>'well','enctype'=>'multipart/form-data'),
));
?>
<?php echo $form->fileFieldRow($model,'upload_file'); ?>
<?php Utilities::actionSaveButton($this, true)?>
<?php $this->endWidget(); ?>
<?php Utilities::getFlashes(); ?>
</div><!-- form -->