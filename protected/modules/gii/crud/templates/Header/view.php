<?php
/**
 * The following variables are available in this template:
 * - $this: the CrudCode object
 */
?>
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
<?php
$nameColumn=$this->guessNameColumn($this->tableSchema->columns);
$label=$this->pluralize($this->class2name($this->modelClass));
echo "\$this->breadcrumbs=array(
	Yii::t('app','general.label.$label'),
	\$model->{$nameColumn},
);\n";
?>
$this->menu=array(
	array('label'=>Yii::t('app','general.label.Create')." ".Yii::t('app','general.label.<?php echo $this->modelClass; ?>'), 'url'=>array('create')),
	array('label'=>Yii::t('app','general.label.Update')." ".Yii::t('app','general.label.<?php echo $this->modelClass; ?>'), 'url'=>array('/<?php echo $this->modelClass; ?>Detail/create', 'headerId'=>$model->id)),
);
$title=Yii::t('app','general.label.<?php echo $this->modelClass; ?>').' '.$model->id;
<?php echo "Utilities::printWidget(\$this,\$title,'print_top');\n?>"; ?>

<?php echo "<div id='printable'>"; ?>

<?php echo "<?php \$this->renderPartial('_view', array('model'=>\$model,'print'=>1)); ?>"; ?>

<?php echo "<?php \$this->renderPartial('/".lcfirst($this->getModelClass())."Detail/view',array('headerId'=>\$model->id)); ?>"; ?>

<?php echo "</div>" ?>

<?php echo "<?php Utilities::printWidget(\$this,\$title,'print_bottom'); ?>"; ?>