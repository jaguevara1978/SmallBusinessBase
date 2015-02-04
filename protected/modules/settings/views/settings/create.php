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
/* @var $filterModel Settings */

$this->breadcrumbs=array(
	Yii::t('app','general.label.Settings'),
	Yii::t('app','general.label.Create'),
);

$this->menu=array(
	array('label'=>Yii::t('app','general.label.Manage')." ".Yii::t('app','general.label.Settings'), 'url'=>array('admin')),
);
?>

<?php
	if (Yii::app()->user->checkAccess('Settings.Create')
		|| Yii::app()->user->checkAccess('Settings.*')) 
		echo $this->renderPartial('_form', array('model'=>$model)); 
?>

<?php 
	if (Yii::app()->user->checkAccess('Settings.Admin')
		|| Yii::app()->user->checkAccess('Settings.*')) 
		echo $this->renderPartial('admin', array('model'=>$filterModel));
?>