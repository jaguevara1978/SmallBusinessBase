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
@var $this UserController
@var $model User
@var $filterModel User
*/
$this->breadcrumbs=array(
	Yii::t('app','general.label.Users'),
	Yii::t('app','general.label.Create'),
);
if (Yii::app()->user->checkAccess('User.Create')
	|| Yii::app()->user->checkAccess('User.*')) 
	echo $this->renderPartial('_form', array('model'=>$model)); 
if (Yii::app()->user->checkAccess('User.Admin')
	|| Yii::app()->user->checkAccess('User.*')) 
	echo $this->renderPartial('admin', array('model'=>$filterModel));