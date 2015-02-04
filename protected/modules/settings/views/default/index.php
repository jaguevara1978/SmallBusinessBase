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
$this->breadcrumbs=array(
		Yii::t('app','general.label.Config'),
		Yii::t('app','general.label.Update'),
);
// $this->menu=array(
// 		array('label'=>Yii::t('app','general.label.Restore')." ".Yii::t('app','general.label.Config'), 'url'=>array('user')),
// );

?>
<legend><?php echo Yii::t('SettingsModule.set','Settings');?></legend>
<div class="form">

<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
		'id'=>'client-invoice-form',
		'type'=>'horizontal',
		'htmlOptions'=>array('class'=>'well'),
		'enableAjaxValidation'=>false,
));
Utilities::getFlashes();
Yii::app()->user->setFlash('danger', '<strong>'.Yii::t('app','message.Alert').'</strong> '.Yii::t('app','message.ConfigParamsModificacionCaution'));
$this->widget('bootstrap.widgets.TbAlert', array(
		'block'=>true, // display a larger alert block?
		'fade'=>true, // use transitions?
		'closeText'=>'X', // close link text - if set to false, no close link is displayed
		'alerts'=>array( // configurations per alert type
				//'success'=>array('block'=>true, 'fade'=>true, 'closeText'=>'X'),
				'danger'=>array('block'=>true, 'fade'=>true, 'closeText'=>'X'),// success, info, warning, error or danger
		),
));
echo $form->errorSummary($model);
$modelList=Settings::model()->findAll(array('order'=>'t.group asc, t.group_order asc'));
$panels=array();
$dbBase=Utilities::getBaseDBConnection();
foreach ($modelList as $m) {
	$mGroup=substr($m->group,4);
	if(!Yii::app()->params['General_'.$mGroup.'_Enabled']) continue;
	if($group!=$mGroup) {
		$group=$mGroup;
		$groupName=Yii::t('app','general.label.'.$group);
	}
	try {
		$tip=$dbBase->createCommand()
					->select('tooltip')
					->from('tooltips')
					->where('tooltip_key=:key', array(':key'=>$m->key))
					->queryScalar();
		switch($m->type) {
			case 'text':
				$panels[$groupName].=$form->textFieldRow($model,$m->key,array('class'=>'span5','rows'=>1,'size'=>200,'maxlength'=>200,'hint'=>$tip));
				break;
			case 'toggle':
				parse_str($m->type_specs,$array);
				$enabledLabel=$array['enabled']?Yii::t('app',$array['enabled']):Yii::t('app','general.label.Yes');
				$disabledLabel=$array['disabled']?Yii::t('app',$array['disabled']):Yii::t('app','general.label.No');
				$panels[$groupName].=$form->toggleButtonRow($model,$m->key,array(
											'hint'=>$tip,
											'options'=>array(
													'enabledLabel'=>$enabledLabel,
													'disabledLabel'=>$disabledLabel,
													'value'=>true,
													'htmlOptions'=>array('style'=>'vertical-align: top;'),
											),
										)
									);
				break;
			case 'select':
				parse_str($m->type_specs,$array);
				$list=$array['entity']::getList($array['listFilter']);
				$panels[$groupName].=$form->dropDownListRow($model,$m->key,$list,array('empty'=>Yii::t('app','Select'),'hint'=>$tip));
				break;
			case 'select_value':
				parse_str($m->type_specs,$array);
				$panels[$groupName].=$form->dropDownListRow($model,$m->key,$array['values'],array('empty'=>Yii::t('app','Select'),'hint'=>$tip));
				break;
		}
	} catch (Exception $e) {
		 continue;
	}
}
$this->widget('zii.widgets.jui.CJuiAccordion', array(
	'panels'=>$panels,
	// additional javascript options for the accordion plugin
// 	'htmlOptions'=>array(
// 		'style'=>'height:100px;',
// 	),
	'options'=>array(
		'animated'=>'bounceslide',
		'heightStyle'=>'content',
	),
));
?>
<?php Utilities::actionSaveButton($this, true)?>
<?php $this->endWidget(); ?>
</div><!-- form -->