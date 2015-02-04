<?php $this->beginContent(Rights::module()->appLayout); ?>
<div class="span-24 last operations_ads">
	<div id="sidebar">
	<?php
		$this->beginWidget('zii.widgets.CPortlet', array(
			'title'=>Yii::t('app','Operations'),
		));

		$this->renderPartial('/_menu');
// 		$this->widget('zii.widgets.CMenu', array(
// 			'items'=>$this->menu,
// 			'htmlOptions'=>array('class'=>'operations'),
// 		));
		$this->endWidget();
	?>
	</div><!-- sidebar -->
</div>

<div id="rights" class="container">

	<div id="content">
		<?php $this->renderPartial('/_flash'); ?>
	
		<?php if( $this->id!=='install' ): ?>
		
			<!-- div id="menu" -->
				<?php //$this->renderPartial('/_menu'); ?>
			<!--/div-->

		<?php endif; ?>

		<?php echo $content; ?>

	</div><!-- content -->

</div>

<?php $this->endContent(); ?>