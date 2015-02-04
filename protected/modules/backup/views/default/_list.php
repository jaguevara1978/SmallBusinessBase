<?php 
$this->widget('bootstrap.widgets.TbExtendedGridView', array(
	'id' => 'backups-grid',
	'dataProvider' => $dataProvider,
	'fixedHeader'=>true,
	'bulkActions' => array(
		'actionButtons' => array(
			array(
				'buttonType'=>'button',
				'type'=>'primary',
				'size'=>'small',
				'htmlOptions' => array('class'=>'bulk-action'),
				'label'=>Yii::t('app','general.label.Delete'),
				'click' => 'js:function(checked){
					var values = [];
					checked.each(function(){
						values.push($(this).val());
					});
				    $.ajax({
						type: "POST",
						url:"'.$this->createUrl('default/batchDelete').'", 
						data: {ids:values},
						success:function(data){ 
						    // update the grid now
						    $("#backups-grid").yiiGridView("update"); 
						}
					});
				}'
			)
		),
		// if grid doesn't have a checkbox column type, it will attach
		// one and this configuration will be part of it
		'checkBoxColumnConfig' => array('name'=>'name'),
	),
	'columns' => array(
		array(
			'name'=>'name',
			'header'=>Yii::t('app','general.label.Backup'),
		),
		array(
			'name'=>'size',
			'header'=>Yii::t('app','general.label.FileSize'),
		),
		array(
			'name'=>'create_time',
			'header'=>Yii::t('app','general.label.Date'),
		),
		array(
			'class' => 'CButtonColumn',
			'template' => ' {download}',
			  'buttons'=>array (
			        'download' => array (
			        	'label'=>Yii::t('app','general.label.Download'),
			            'url'=>'Yii::app()->createUrl("backup/default/download", array("file"=>$data["name"]))',
			        ),
			        'restore' => array (
			        	'label'=>Yii::t('app','general.label.Restore'),
			            'url'=>'Yii::app()->createUrl("backup/default/restore", array("file"=>$data["name"]))',
		        		'click'=>"function() {
							if(!confirm('".Yii::t('app','message.confirmDBRestauration')."')) return false;
							var th=this;
							$.fn.yiiGridView.update('{backups-grid}', {
								type:'POST',
								url:$(this).attr('href'),
								success:function(data) {
									$.fn.yiiGridView.update('{backups-grid}');
								},
								error:function(XHR) {
								}
							});
							return false;
						}",
		        	),
				),
		),
		array (
			'class' => 'CButtonColumn',
			'template' => '{delete}',
			  'buttons'=>array (
			        'delete' => array (
			            'url'=>'Yii::app()->createUrl("backup/default/delete", array("file"=>$data["name"]))',
			        ),
			    ),		
		),
	),
)
); ?>