<?php
$this->breadcrumbs=array(
	Yii::t('app','general.label.Backups'),
	Yii::t('app','general.label.Create'),
);?>

<?php $this->renderPartial('_list', array(
		'dataProvider'=>$dataProvider,
));
?>
