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
$this->pageTitle=Yii::app()->name;
$this->breadcrumbs=array(
		Yii::t('app','general.label.WelcomeUser',array('{user}'=>Yii::app()->user->name)),
);
?>
<h3><i><?php echo Yii::t('app','general.label.WelcomeUser',array('{user}'=>Yii::app()->user->name))?></i></h3>
<p><?php echo Yii::t('app','general.Label.selectModule'); ?></p>
<?php 
Yii::app()->user->setFlash('warning', '<strong>'.Yii::t('app','message.Alert').'</strong>'.
		' Por favor recuerda realizar periodicamente una copia de seguridad de tus datos. Esto se realiza con el fin de evitar perdidas en casos de emergencia.
						<br><strong>No sabes como?:</strong>
						<br>En la opcion <strong>(Sistema -> Copia de seguridad -> Crear copia de seguridad)</strong> >> '.CHtml::link('Ir ya mismo!',$this->createUrl('/backup')).'
						<br>Por favor, consulta con el administrador para resolver cualquier inquietud. E-mail: jaguevara1978@gmail.com.');
$this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'X', // close link text - if set to false, no close link is displayed
		'alerts'=>array( // configurations per alert type
			'warning'=>array('block'=>true, 'fade'=>true, 'closeText'=>'X'),// success, info, warning, error or danger
		),
));
Yii::app()->user->setFlash('info', '<strong>'.Yii::t('app','message.Info').'</strong>'.
						'Por favor acuerdate que hay dos modulos nuevos a tu disposicion, 
						<br><strong>Copias de seguridad</strong> y <strong>Configuracion</strong>.
						<br>Por favor, dales una mirada y consulta con el administrador para resolver cualquier inquietud. E-mail: jaguevara1978@gmail.com.
						<br>
						<br>Actualmente se estan realizando cambios en la apariencia de las aplicaciones con el fin de mejorar el desempeno desde dispositivos moviles. Si esto te afecta, o notas algun problema, por favor comunicalo al administrador.');
$this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'X', // close link text - if set to false, no close link is displayed
		'alerts'=>array( // configurations per alert type
				'info'=>array('block'=>true, 'fade'=>true, 'closeText'=>'X'),// success, info, warning, error or danger
		),
));
?>