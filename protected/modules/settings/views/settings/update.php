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

$this->breadcrumbs=array(
	Yii::t('app','general.label.Settings')=>array('admin'),
	$model->name=>array('view','id'=>$model->key),
	Yii::t('app','general.label.Update'),
);

$this->menu=array(
	array('label'=>Yii::t('app','general.label.Manage')." ".Yii::t('app','general.label.Settings'), 'url'=>array('admin')),
	array('label'=>Yii::t('app','general.label.Create')." ".Yii::t('app','general.label.Settings'), 'url'=>array('create')),
	array('label'=>Yii::t('app','general.label.View')." ".Yii::t('app','general.label.Settings'), 'url'=>array('view', 'id'=>$model->key)),
);
?>
<h1><?php echo Yii::t('app','general.label.Update').' '.Yii::t('app','general.label.Settings').' - '.$model->key;?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>