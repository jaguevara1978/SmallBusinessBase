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
class Utilities {
	public static function limitString($string,$max) {
		$addStr='..';
		$maxLength=$max - strlen($addStr);
		if (strlen($string)>$maxLength)
			return substr($string,0,$maxLength).$addStr;
		return $string;
	}

	public static function translateTitle($title) {
		$splitted = explode(" ",$title);
		$result = '';
		foreach ($splitted as &$value){
			if ($value!=Yii::app()->name) {
				if (strlen($result)) $result = $result.' ';
				$result = $result.Yii::t('app', $value);
			}
		}
		return $result;
	}

	public static function registerCustomScript($alias='baseApp.components.js',$file='custom.js') {
		$file=Yii::getPathOfAlias($alias).'/'.$file;
		$jsFile = Yii::app()->getAssetManager()->publish($file);
		Yii::app()->getClientScript()->registerScriptFile($jsFile);
	}
	
	public static function registerDatePickerReInstall($attributes) {
		$insideLine='';
		foreach ($attributes as &$attr) {
			$insideLine.="$('#".$attr."_datePicker').bdatepicker({'showAnim':'fold','dateFormat':'yy-mm-dd','autoclose':true,'debug':false,'placement':'left','format':'yyyy-mm-dd','language':'es','weekStart':0});";
		}
		if (strlen($insideLine) > 0) {
			Yii::app()->clientScript->registerScript('re-install-date-picker', "function reinstallDatePicker(id, data) {".$insideLine."}");
		}
		return 'reinstallDatePicker';
	}
	
	public static function buildDatePicker($controller, $model, $attribute) {
		return $controller->widget('bootstrap.widgets.TbDatePicker', array(
						'model'=>$model,
						'attribute'=>$attribute,
						// additional javascript options for the date picker plugin
						'options'=>array(
								'showAnim'=>'fold',
								'dateFormat'=>'yy-mm-dd',  // optional Date formatting
								'autoclose'=>true,
								'debug'=>false,
								'placement'=>'left',
								'format'=>'yyyy-mm-dd',  // optional Date formatting
								'language'=>Yii::app()->language,
						),
						'htmlOptions'=>array(
								'style'=>'height:20px;',
								'class'=>'span2',
								'id'=>$attribute.'_datePicker',
						),
				),
				true);
	}

	public static function editableColumnDatePicker($view,$model,$url,$attr='date') {
		return array(
				'class'=>'EditableColumn',
				'name'=>$attr,
				'filter'=>Utilities::buildDatePicker($view, $model, $attr),
				'headerHtmlOptions'=>array('style'=>'width: 80px'),
				'editable'=>array(
						'type'=>'date',
						'viewformat'=>'yyyy-mm-dd',
						'options'=>array('showbuttons'=>false,
								//'visible'=>$data->$attr !== null ? true : false,
								),
						'url'=>$view->createUrl($url),
				),
		);
	}
	
	public static function formToolTip($form, $attr) {
		if(Yii::app()->params['General_ActivateToolTips'])
			$form->widget('bootstrap.widgets.TbExtendedTooltip',
					array(
						'tooltipTable'=>'tooltips',
						'key'=>$attr,
						'editable'=>false,
						'htmlOptions'=>array('style'=>'padding: 0px 5px 0px 0px;',),
					)
			);
	}

	public static function formDatePicker($form, $model,$attr='date',$toolTipKey=null,$showToolTip=true) {
		echo $form->datepickerRow(
				$model,
				$attr,
				array(
					'prepend'=>'<i class="icon-calendar"></i>',
					'class'=>'span2',
					'options'=>array(
							'showAnim'=>'fold',
							'autoclose'=>true,
							'debug'=>false,
							'placement'=>'right',
							'format'=>'yyyy-mm-dd',  // optional Date formatting
							'language'=>'es',
					),
				)
		);
		if (!$toolTipKey) $toolTipKey=$attr;
		if($showToolTip) Utilities::formToolTip($form, $toolTipKey);
	}
	
	public static function editableDate($url=null) {
		return array(
					'type'=>'date',
					'viewformat'=>'yyyy-mm-dd',
					'options'=>array('showbuttons'=>false,),
					'url' =>$url,
				);
	}

// 	public static function editableDateColumn($name,$url=null,$filter=null) {
// 		return array(
// 			'class'=>'EditableColumn',
// 			'name'=>$name,
// 			'filter'=>$filter,
// 			'editable'=>Utilities::editableDate($url),
// 			'headerHtmlOptions'=>array('style'=>'width: 80px'),
// 		);
// 	}

	public static function editableSelect($list,$addOptions=null,$url=null) {
		$options=array('showbuttons'=>false);
		if ($addOptions) {
			while ($op = current($addOptions)) {
				$options[key($addOptions)]=$op;
				next($addOptions);
			}
		}
		return array(
					'type'=>'select',
					'source'=>$list,
					'options'=>$options,
					'url'=>$url,
				);
	}

	public static function widgetTbDatePicker($view, $model, $attr='fecha', $value=null) {
		if (!$value) $value=$model->fecha;
		return $view->widget('bootstrap.widgets.TbDatePicker', array(
				'model'=>$model,
				'attribute'=>$attr,
				'value'=>$value,  // pre-fill the value
				// additional javascript options for the date picker plugin
				'options'=>array(
						'autoclose'=>true,
						'debug'=>false,
						'format'=>'yyyy-mm-dd',  // optional Date formatting
				),
				'htmlOptions'=>array(
						'style'=>'height:20px;',
						'class'=>'span2',
				),
		));
	}
	
	public static function buildDialog($view,$title=null,$id='cru-dialog',$idFrame='cru-frame',$width=690,$height=500) {
		// add the (closed) dialog for the iframe
		$view->beginWidget('zii.widgets.jui.CJuiDialog', array(
				'id'=>$id,
				'options'=>array(
						'title'=>$title,
						'autoOpen'=>false,
						'modal'=>false,
						'width'=>$width,
						'height'=>$height,
				),
			), true);
		echo '<iframe id="'.$idFrame.'" width="100%" height="100%"></iframe>';
		$view->endWidget();
	}
	
	public static function buttonDialogClick($dialogId='cru-dialog',$frameId='cru-frame') {
		return 'function(){$("#'.$frameId.'").attr("src",$(this).attr("href")); $("#'.$dialogId.'").dialog("open");  return false;}';
	}
	
	public static function buttonDialogUrl($url) {
		return '$this->grid->controller->createUrl("'.$url.'", array("id"=>$data->id,"asDialog"=>1,"gridId"=>$this->grid->id))';
	}
	
	public static function detailViewEditableDate($name='fecha',$url=null) {
		return array(
					'name'=>$name,
					'editable'=>Utilities::editableDate($url),
				);
	}
	
	public static function formAutoCompleteField($view,$id,$model,$attribute,$source,$hidden,$next='') {
		if ($next) $next = "$('#".$next."').focus(); $('#".$next."').select();";
		$view->widget('zii.widgets.jui.CJuiAutoComplete', array(
				'id'=>$id,
				'model'      =>$model,
				'attribute'  =>$attribute,
				'name'=>$attribute,
	            'value'=>'',
				'cssFile'=>'default',
	            'source'=>$source,
	            'options'=>array(
	                'showAnim'=>'fold',
	                'minLength'=>1,                
	                'select'=>"js:function(event, ui) {
						            $('#".$hidden."').val(ui.item.id);
	            					".$next."
						        }",
	            	'change'=>"js:function(event, ui) {
						            if (!ui.item) {
						                $('#".$hidden."').val('');
						            }
					            }",
	            	),
	            'htmlOptions'=>array(
	                'maxLength'=>'75',
					'onClick'=>'document.getElementById("'.$id.'").value="";
								document.getElementById("'.$hidden.'").value="";',
	            ),
	        ));
			Yii::app()->getClientScript()->registerScript($id.'Script', "
				$('#".$id."').data('autocomplete')._renderItem = function( ul, item ) {
				    var re = new RegExp( '(' + $.ui.autocomplete.escapeRegex(this.term) + ')', 'gi' );
				    var highlightedResult = item.label.replace( re, '<b>$1</b>' );
				    return $( '<li></li>' )
				      .data( 'item.autocomplete', item )
				      .append( '<a>' + highlightedResult + '</a>' )
				      .appendTo( ul );
				  };
			");
	}
	
	public static function printWidget($view, $title=null, $id='print-div', $cssFile='print.css', $localPath=false) {
// 		$view->widget('mPrint.mPrint', array(
// 				'id'=>$id,	//id of the print link
// 				'title'=>$title,		//the title of the document. Defaults to the HTML title
// 				//'cssFile'=>'print.css',
// 				'tooltip'=>Yii::t('app','general.label.Print'),	//tooltip message of the print icon. Defaults to 'print'
// 				'text'=>Yii::t('app','general.label.Print'),	//text which will appear beside the print icon. Defaults to NULL
// 				'element'=>'#printable',			//the element to be printed.
// 				'exceptions'=>array(),				//the element/s which will be ignored
// 				'publishCss'=>true,	//publish the CSS for the whole page?
// 				'alt'=>Yii::t('app','general.label.Print'),		//text which will appear if image can't be loaded
// 				'debug'=>true,		//enable the debugger to see what you will get
// 		));
		if($localPath) $cssPath=dirname(__FILE__).'/../../'.Yii::app()->params['Technical_FolderName'].'/css';
		else $cssPath=dirname(__FILE__).'/../../css';
		$view->widget('print.printWidget', array(
				'printedElement'=>'#printable',
				//'coverElement'=>'#page',
				'text'=>Yii::t('app','general.label.Print'),
				//'title'=>$title,
				//'cssPath'=>$cssPath,
				//'cssFile'=>$cssFile,
				'htmlOptions'=>array(),
		));
	}
	
	public static function initialFocus($fieldName) {
		Yii::app()->clientScript->registerCoreScript('jquery');
		Yii::app()->clientScript->registerScript($fieldName.'_initial_focus', '$("#'.$fieldName.'").focus();');
	}
	
	public static function getFlashes($stayTime='3000') {
		Yii::app()->getClientScript()->registerScript(
			'myHideEffect',
			'$(".flashes").animate({opacity: 1.0}, '.$stayTime.').fadeOut("slow");',
			CClientScript::POS_READY
			);
		$flashMessages=Yii::app()->user->getFlashes();
		if ($flashMessages) {
			echo '<ul class="flashes">';
			foreach($flashMessages as $key=>$message)
				echo '<li><div class="flash-' . $key . '">' . $message . "</div></li>\n";
			echo '</ul>';
		}
	}
	
	public static function actionSaveButton($view, $isNew, $asDialog=false, $url=null) {
		$widgetArray=array(
					'buttonType'=>'submit', 
					'type'=>'primary', 
					'label'=>$isNew ? Yii::t('app','general.button.Create') : Yii::t('app','general.button.Save'),);
		if ($asDialog) $widgetArray['url']=$url;
		echo "<div class='form-actions'>";
		$view->widget('bootstrap.widgets.TbButton', $widgetArray);
		echo "</div>";
	}

	public static function yesNoList() {
		return array('0'=>Yii::t('app','general.label.No'),'1'=>Yii::t('app','general.label.Yes'),);
	}

	public static function yesNoEditableColumn($view, $name,$url,$options=array()) {
		$yesNoList=Utilities::yesNoList();
		return array(
				'class'=>'EditableColumn',
				'name'=>$name,
				'filter'=>$yesNoList,
				'editable'=>array(
						'url'=>$view->createUrl($url),
						'placement'=>$options['placement'],
						'type'=>'select',
						'source'=>$yesNoList,
						'options'=>array(
								'showbuttons'=>false,
								'display'=>'js: function(value, sourceData) {
			                          var selected = $.grep(sourceData, function(o){ return value == o.value; }),
			                              colors = {1: "red", 0: "blue"};
			                          $(this).text(selected[0].text).css("color", colors[value]);
			                      }',
						),
				),
		);
	}

	public static function registerScriptAddNewRecord($attr,$url,$viewName,$dropId,$dialogDiv='divForForm') {
		$script="function addNew".$attr."() {
			".CHtml::ajax(array(
							'url'=>$url,
							'data'=> "js:$(this).serialize()",
							'type'=>'post',
							'dataType'=>'json',
							'success'=>"function(data) {
	                if (data.status == 'failure') {
						$('#dialog div.".$dialogDiv."').html(data.div);
						// Here is the trick: on submit-> once again this function!
						$('#dialog div.".$dialogDiv." form').submit(addNew".$attr.");
	                } else {
						$('#dialog div.".$dialogDiv."').html(data.div);
						setTimeout(\"$('#dialog').dialog('close') \",1000);
			    		$('#".$viewName."_".$attr."').prepend('<option value=\"' + data.value[0] +'\">' + data.value[1] + ' - ' + data.value[2] + '</option>');
			    		document.getElementById('".$viewName."_".$attr."').selectedIndex=0;
			      		var children=document.getElementById('".$dropId."').getElementsByTagName('*');
			    		children[0].getElementsByTagName('*')[0].innerHTML=data.value[1] + ' - ' + data.value[2];
					}
	            } ",
				'error'=>'function(xhr, ajaxOptions, thrownError) {
					alert(thrownError + "\r\n" + xhr.statusText + "\r\n" + xhr.responseText);
				}',
				)
		)."; return false; }";
		Yii::app()->clientScript->registerScript('addNewRecord'.$attr,$script,CClientScript::POS_END);
	}

	public static function addNewButton($attr,$url,$viewName,$dropId,$view) {
		Utilities::registerScriptAddNewRecord($attr,$url,$viewName,$dropId);
		echo '<div class="input-prepend" style="vertical-align: top; margin-right: 0px;">';
		echo '<span class="add-on">';
		$view->widget('bootstrap.widgets.TbButton', array(
				'type'=>'link',
				'buttonType'=>'button',
				'icon'=>'plus',
				'loadingText'=>'...',
				'htmlOptions'=>array(
						'style'=>'padding: 0px;',
						'onclick'=>"{
						addNew".$attr."();
						$('#dialog').dialog('open');
					}",
				),
		),false);
		echo '</span>';
		echo '</div>';
	}

	public static function select2Row($view,$viewName,$form,$model,$attr,$list,$class,$emptyLabel=null,$width='180px',$addButton=true,$url=null,$options=array()) {
		$dropId='s2id_'.$viewName.'_'.$attr;
		if (!$class) $class=$attr;
		if (!$url) $url=Yii::app()->createUrl($class.'/create',array('asDialog'=>true));
		if ($addButton)	Utilities::addNewButton($attr,$url,$viewName,$dropId,$view);
		if (!$emptyLabel) $emptyLabel=Yii::t('app','general.label.Select');
		if (!$list) $list=array(''=>Yii::t('app','message.NoDataFound'));
		echo $form->select2Row($model,$attr,$list,array('empty'=>$emptyLabel,'style'=>'width: '.$width.';','options'=>$options));
	}

	public static function buildNewRecordDialog($view,$id='dialog',$title=null,$div='divForForm') {
		if (!$title) $title=Yii::t('app','general.label.addNewRecord');
		$view->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
				'id'=>$id,
				'options'=>array(
						'title'=>$title,
						'autoOpen'=>false,
						'modal'=>true,
// 						'width'=>350,
// 						'height'=>450,
				),
		));
		echo '<div class="'.$div.'"></div>';
		$view->endWidget();
	}
	
	public static function toggleButtonRow($form,$model,$attr,$toolTipKey=null,$enabled=null,$disabled=null,$onChange=null) {
		if(!$enabled) $enabled=Yii::t('app','general.label.Yes');
		if(!$disabled) $disabled=Yii::t('app','general.label.No');
		echo $form->toggleButtonRow($model,$attr,array(
				'options'=>array(
						'enabledLabel'=>$enabled,
						'disabledLabel'=>$disabled,
						'value'=>true,
						'htmlOptions'=>array('style'=>'vertical-align: top;'),
						'onChange'=>$onChange,
				),
			)
		);
		if(!$toolTipKey) $toolTipKey=$attr;
		Utilities::formToolTip($form,$toolTipKey);
	}

	public static function toggleButtonColumn($name,$action,$labelChecked=null,$labelUnChecked=null) {
		return array(
			'class'=>'bootstrap.widgets.TbToggleColumn',
			'name'=>$name,
			'toggleAction'=>$action,
			'checkedButtonLabel'=>$labelChecked,
			'uncheckedButtonLabel'=>$labelUnChecked,
			'htmlOptions'=>array('style'=>'text-align: center;'),
		);
	}
	
	public static function params() {
		return array(
			// this is used in contact page
			'General_adminEmail'=>'@gmail.com',
			'General_Styles_TotalFooter'=>'color: #585858;',
			'General_Styles_TotalColumn'=>'text-align: right; color: #585858;',
			'General_Styles_DepositsFooter'=>'color: #5882FA;',
			'General_Styles_DepositsColumn'=>'text-align: right; color: #5882FA;',
			'General_Styles_PendingFooter'=>'color: #FA5858;',
			'General_Styles_PendingColumn'=>'text-align: right; color: #FA5858;',
	
			'ClientInvoice_def_id'=>null,
			'ClientInvoice_def_client'=>1,
			'ClientInvoice_def_date'=>'Today',
			'ClientInvoice_def_status'=>10,
			'ClientInvoice_stock_status'=>20,
			'ClientInvoice_final_status'=>30,
			'ClientInvoice_filter_def_status'=>10,
			'ClientInvoice_def_payment_date'=>'+30 day',
			'ClientInvoice_def_notes'=>null,
			'ClientInvoice_autoGenerate_details'=>true,
	
			'ClientInvoiceDetail_def_id'=>null,
			'ClientInvoiceDetail_def_client_invoice'=>null,
			'ClientInvoiceDetail_def_quantity'=>'',
			'ClientInvoiceDetail_def_product'=>null,
			'ClientInvoiceDetail_def_unit_value'=>'',
			'ClientInvoiceDetail_def_notes'=>null,
	
			'ClientInvoiceDeposit_def_id'=>null,
			'ClientInvoiceDeposit_def_client_invoice'=>null,
			'ClientInvoiceDeposit_def_date'=>'Today',
			'ClientInvoiceDeposit_def_value'=>null,
			'ClientInvoiceDeposit_def_notes'=>null,
			'ClientInvoiceDeposit_def_final_payment'=>null,
	
			'MeasureUnit_def_id'=>null,
			'MeasureUnit_def_code'=>null,
			'MeasureUnit_def_name'=>null,
			'MeasureUnit_def_eq_reference'=>null,
			'MeasureUnit_def_reference'=>null,
	
			'pri_def_date'=>'Today',
			'pri_def_payment_date'=>'+30 day',
			'pri_initial_status'=>40,
			'pri_stock_status'=>50,
			'pri_final_status'=>60,
	
			'Product_def_id'=>null,
			'Product_def_code'=>null,
			'Product_def_name'=>null,
			'Product_def_measure_unit'=>null,
			'Product_def_custom_order'=>null,
			'Product_def_default_qty'=>null,
			'Product_def_default_value'=>null,
			'Product_def_stock_movement'=>null,
	
			'Stock_def_id'=>null,
			'Stock_def_quantity'=>null,
			'Stock_def_product'=>null,
			'Stock_def_date'=>'Today',
			'Stock_def_init_stock_qty'=>null,
			'Stock_def_final_stock_qty'=>null,
			'Stock_def_movement_type'=>null,
			'Stock_def_client_invoice_detail'=>null,
			'Stock_def_provider_invoice_detail'=>null,
			'Stock_auto_date'=>true,
		);
	}

	public static function initMainLayout() {
		Yii::app()->clientScript->registerMetaTag("width=device-width, initial-scale=1.0","viewport");
		Yii::app()->clientScript->registerLinkTag('shortcut icon', null, Yii::app()->request->baseUrl.Yii::app()->params['General_BaseImageDirectory'].'favicon.ico');
		Utilities::registerCustomScript();
		$file=Yii::getPathOfAlias('css').'/screen.css';
		$jsFile = Yii::app()->getAssetManager()->publish($file);
		Yii::app()->clientScript->registerCssFile($jsFile);
		$file=Yii::getPathOfAlias('css').'/styles.css';
		$jsFile = Yii::app()->getAssetManager()->publish($file);
		Yii::app()->clientScript->registerCssFile($jsFile);
		Yii::app()->clientScript->registerScript('headerHeight',"$('#header').css('margin-top',$('#navBar').height());");
	}
	public static function getBaseDataModules() {
		if(Yii::app()->params['General_MenuJohnson'])
			$baseDataModules=array(
						'Product'=>array('name'=>'Productos','showName'=>'Products','enabled'=>'Product','url'=>array('/productos/admin'),),
						'Client'=>array('name'=>'Clientes','showName'=>'Clients','enabled'=>'Client','url'=>array('/clientes/admin'),),
						'Provider'=>array('name'=>'Proveedores','showName'=>'Providers','enabled'=>'Provider','url'=>array('/proveedores/admin'),),
						'MeasureUnit'=>array('name'=>'Unidades de Medida','showName'=>'Measure Units','enabled'=>'MeasureUnit','url'=>array('/unidadesDeMedida/admin'),),
					);
		else
			$baseDataModules=array(
						'Product'=>array('name'=>'Product'),
						'Client'=>array('name'=>'Client',),
						'Provider'=>array('name'=>'Provider',),
						'MeasureUnit'=>array('name'=>'MeasureUnit',),
					);
		
		foreach($baseDataModules as $value) {
			if (Yii::app()->user->checkAccess($value['name'].'.Admin')
					|| Yii::app()->user->checkAccess($value['name'].'.Create')
					|| Yii::app()->user->checkAccess($value['name'].'.*')){
				if(!isset($value['enabled'])) $value['enabled']=$value['name'];
				$strEnabled='General_'.$value['enabled'].'_Enabled';
				if(!Yii::app()->params[$strEnabled]) continue;
				//$masterAllowed=true;
				$showName=isset($value['showName']) ? $value['showName'] : Yii::t('app','general.label.'.$value['name'].'s');
				$showName=Yii::t('app',$showName);
				$showName=Utilities::limitString($showName,20);
				$url=isset($value['url']) ? $value['url'] : Yii::app()->createUrl($value['name'].'/create');
				if (isset($value['validateAdmin']))
					if (!Yii::app()->user->getIsSuperuser()) continue;
				$baseItems[]=array('label'=>$showName, 'url'=>$url);
			}
		}
		return $baseItems;
	}
	public static function getSystemModules() {
		if(Yii::app()->params['General_MenuJohnson'])
			$baseDataModules=array(
						'backup'=>array('name'=>'Backup','url'=>array('/backup'),),
						//'Config'=>array('name'=>'Config','showName'=>Yii::t('app','general.label.Config'),'url'=>array('/settings')),
						'Rights'=>array('name'=>'Rights','showName'=>Yii::t('app','general.label.Security'),'url'=>array('/rights'),),
						'User'=>array('name'=>'User','validateAdmin'=>true,),
						'UserMy'=>array('name'=>'User','showName'=>Yii::t('app','general.label.myData').' - '.Yii::app()->user->name,'url'=>Yii::app()->createUrl('/user/update',array('id'=>Yii::app()->user->id))),
					);
		else
			$baseDataModules=array(
						'backup'=>array('name'=>'Backup','url'=>array('/backup'),),
						'Config'=>array('name'=>'Config','showName'=>Yii::t('app','general.label.Config'),'url'=>array('/settings')),
						'Rights'=>array('name'=>'Rights','showName'=>Yii::t('app','general.label.Security'),'url'=>array('/rights'),),
						'User'=>array('name'=>'User','validateAdmin'=>true,),
						'UserMy'=>array('name'=>'User','showName'=>Yii::t('app','general.label.myData').' - '.Yii::app()->user->name,'url'=>Yii::app()->createUrl('/user/update',array('id'=>Yii::app()->user->id))),
					);
		
		foreach($baseDataModules as $value) {
			if (Yii::app()->user->checkAccess($value['name'].'.Admin')
					|| Yii::app()->user->checkAccess($value['name'].'.Create')
					|| Yii::app()->user->checkAccess($value['name'].'.*')){
				if(!isset($value['enabled'])) $value['enabled']=$value['name'];
				$strEnabled='General_'.$value['enabled'].'_Enabled';
				if(!Yii::app()->params[$strEnabled]) continue;
				//$masterAllowed=true;
				$showName=isset($value['showName']) ? $value['showName'] : Yii::t('app','general.label.'.$value['name'].'s');
				$showName=Yii::t('app',$showName);
				$showName=Utilities::limitString($showName,20);
				$url=isset($value['url']) ? $value['url'] : Yii::app()->createUrl($value['name'].'/create');
				if (isset($value['validateAdmin']))
					if (!Yii::app()->user->getIsSuperuser()) continue;
				$baseItems[]=array('label'=>$showName, 'url'=>$url);
			}
		}
		return $baseItems;
	}
	public static function buildMenu($controller) {
		if (!Yii::app()->user->id) $items=array();
		else {
			$itemsArray=array(
					'ClientInvoice'=>array('name'=>'ClientInvoice','label'=>Yii::t('app','general.label.Client Invoices'),),
					'AutoDepositCi'=>array('name'=>'AutoDepositCi','label'=>Yii::t('app','general.label.Auto Deposit Cis'),),
					'Payments'=>array('name'=>'Payments','label'=>Yii::t('app','general.label.Payments'),'url'=>Yii::app()->createUrl('ClientInvoiceDetail/payments'),),
					'Stock'=>array('name'=>'Stock','label'=>Yii::t('app','general.label.Stocks'),'url'=>Yii::app()->createUrl('Stock/productStock')),
					'CartList'=>array('name'=>'CartList','label'=>Yii::t('app','general.label.Cart List'),'url'=>Yii::app()->createUrl('ClientInvoice/cartList')),
					'ProviderInvoice'=>array('name'=>'ProviderInvoice','label'=>Yii::t('app','general.label.Provider Invoices'),),
			);
			foreach($itemsArray as $value) {
				if (Yii::app()->user->checkAccess($value['name'].'.Admin')
					|| Yii::app()->user->checkAccess($value['name'].'.Create')
					|| Yii::app()->user->checkAccess($value['name'].'.*')) {
			//print_r($value);
					if(!isset($value['enabled'])) $value['enabled']=$value['name'];
					$strEnabled='General_'.$value['enabled'].'_Enabled';
					if(!Yii::app()->params[$strEnabled]) continue;
					$url=isset($value['url']) ? $value['url'] : Yii::app()->createUrl($value['name'].'/create');
					$items[]=array('label'=>$value['label'], 'url'=>$url);
				}
			}

			/*Master data*/
			//$masterAllowed=false;
			//if ($masterAllowed)
			if($controller->isMobile() || $controller->isTablet()) {
				$items[]=array('label'=>Yii::t('app','general.label.baseData'), 'url'=>Yii::app()->createUrl('/menumobile/default/buildBaseDataMenu'));
				$items[]=array('label'=>Yii::t('app','general.label.System'), 'url'=>Yii::app()->createUrl('/menumobile/default/buildSystemMenu'));
			} else { 
				$items[]=array('label'=>Yii::t('app','general.label.baseData'), 'url'=>'#','items'=>Utilities::getBaseDataModules(),);
				$items[]=array('label'=>Yii::t('app','general.label.System'), 'url'=>'#','items'=>Utilities::getSystemModules(),);
			}
			/*Master data*/

			$items[]=array('label'=>Yii::t('app','general.label.Login'), 'url'=>array('/site/login'), 'visible'=>Yii::app()->user->isGuest);
			$items[]=array('label'=>Yii::t('app','general.label.Logout').' ('.Yii::app()->user->name.')', 'url'=>array('/site/logout'), 'visible'=>!Yii::app()->user->isGuest);
		}
		$controller->widget('bootstrap.widgets.TbNavbar', array(
				//'type'=>'inverse',
				//'fluid'=>true,
				'htmlOptions'=>array('id'=>'navBar',),
				'fixed'=>'top',
				'brand'=>Yii::app()->params['General_appName']?Yii::app()->params['General_appName']:Yii::app()->name,
				'collapse'=>true,
				'items'=>array(
					array(
						'class'=>'bootstrap.widgets.TbMenu',
						'items'=>$items,
						)
					)
				)
		);
// 		$view->widget('emenu.EMenu',array(
// 			'activeCssClass'=>'current',
// 			'theme'=>'adobe',
// 			'items'=>$items,
// 		));
	}
	private static function powered() {
		return '<p class="powered">'.Yii::t('app','general.label.PoweredBy',
				array(
					'{poweredBy}'=>'<a href="http://www.yiiframework.com" target="_blank" rel="external">Yii Framework</a> - 
									<a href="http://www.jquery.com" target="_blank" rel="external">jQuery</a> - 
									<a href="http://www.yiiframework.com/extension/bootstrap" target="_blank" rel="external">Yii-Bootstrap</a>'
				)
		).'</p>';
	}
	public static function getFooter() {
		echo '<p class="powered">'.
				'Copyright &copy; '.date('Y').' - '.(Yii::app()->params['General_appName']?Yii::app()->params['General_appName']:Yii::app()->name)
			.'</p>';
		echo '<p class="powered">'.
				Yii::t('app','general.label.allRightsReserved')
			.'</p>';
		echo '<p class="license">'.
				Yii::t('app','general.label.license',
					array(
						'{licenseUrl}'=>'<a href="http://www.viti.es/gnu/licenses/gpl.html" target="_blank" rel="external">'.Yii::t('app','general.label.Spanish').'</a> - 
										 <a href="http://www.gnu.org/licenses/gpl.html" target="_blank" rel="external">'.Yii::t('app','general.label.English').'</a> - 
										 <a href="http://www.gnu.org/licenses/" target="_blank" rel="external">'.Yii::t('app','general.label.ReadMore').'</a>'
					)
				)
			.'</p>';
		echo Utilities::powered();
	}

	public static function showHideLink($widgetName,$viewDescr=null,$defaultShow=false,$hideText=null,$showText=null,$id='showHide') {
		//if(!$defaultShow) Yii::app()->getClientScript()->registerScript('defaultHideView','$("#ClientInvoice").fadeOut(0);', CClientScript::POS_READY);
		if(!$hideText) $hideText=Yii::t('app',  'general.label.HideHeader');
		if(!$showText) $showText=Yii::t('app',  'general.label.ShowHeader');
		$hideText.=$viewDescr;
		$showText.=$viewDescr;
		echo CHtml::link(
				$defaultShow ? $hideText : $showText,
				"javascript:;",
				array(
					'style'=>'cursor: pointer;',
					'id'=>$id,
					"onclick"=>"showHideView('".$id."','".$widgetName."','".$hideText."','".$showText."'); return false;"
				)
			);
	}

	public static function getCustomCSSPath() {
		$file=Yii::getPathOfAlias('css').'/'.Yii::app()->params['General_CustomCSS'];
		$jsFile = Yii::app()->getAssetManager()->publish($file);
		Yii::app()->clientScript->registerCssFile($jsFile);
		return $jsFile;
	}

	public static function getPrintCSS($module) {
		$file=Yii::app()->params['General_CustomCSS_Directory'].Yii::app()->params['General_Print_CSS_'.$module];
		$jsFile = Yii::app()->getAssetManager()->publish($file);
		Yii::app()->clientScript->registerCssFile($jsFile);
		return $jsFile;
	}

	public static function getBaseDBConnection($dbBase=null) {
		if ($dbBase!==null) return $dbBase;
		$dbBase=Yii::app()->dbBase;
		if ($dbBase instanceof CDbConnection) {
			$dbBase->setActive(true);
			return $dbBase;
		} else throw new CDbException(Yii::t('yii','Active Record requires a "db" CDbConnection application component.'));
	}
}
?>