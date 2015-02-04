<?php echo "<?php\n"; ?>
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
/* @var $this <?php echo $this->getControllerClass(); ?> */
/* @var $model <?php echo $this->getModelClass(); ?> */
/* @var $css */
if(!$print) Utilities::showHideLink('<?php echo $this->getModelClass();?>',Yii::t('app','general.label.<?php echo $this->getModelClass();?>'),Yii::app()->params['General_DefaultShowHeaders']);
if(!$css) if(!$print) $css=Utilities::getCustomCSSPath(); else $css=Utilities::getPrintCSS('<?php echo $this->getModelClass(); ?>');
$totals=$model->totalProvider();
$this->widget('zii.widgets.CDetailView', array(
	'id'=>'<?php echo $this->getModelClass();?>',
	'data'=>$model,
	'cssFile'=>$css,
	'htmlOptions'=>array(
		'class'=> 'editableDetail table table-bordered table-striped table-hover',
		'style'=>Yii::app()->params['General_DefaultShowHeaders'] || $print ?'':'display:none;'
	),
	'nullDisplay'=>'',
	'attributes'=>array(
<? foreach($this->tableSchema->columns as $column) {
	echo "\t\t'".$column->name."',\n";
}
?>
		),
));
?>