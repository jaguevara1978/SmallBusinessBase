<?php
Yii::import('zii.widgets.grid.CGridColumn');
class CEditableColumn extends CGridColumn
{
	/**
	 * @var string the attribute name of the data model. The corresponding attribute value will be rendered
	 * in each data cell. If {@link value} is specified, this property will be ignored
	 * unless the column needs to be sortable.
	 * @see value
	 * @see sortable
	 */
	public $name;
	/**
	 * @var string a PHP expression that will be evaluated for every data cell and whose result will be rendered
	 * as the content of the data cells. In this expression, the variable
	 * <code>$row</code> the row number (zero-based); <code>$data</code> the data model for the row;
	 * and <code>$this</code> the column object.
	 */
	public $value;
	public $sortable=true;
	public $callbackUrl = array('flag');
	private $_flagClass = "flag_link";
	
	/**
	 * Initializes the column.
	 */
	public function init()
	{
		parent::init();
		if($this->name===null && $this->value===null)
			throw new CException(Yii::t('zii','Either "name" or "value" must be specified for CEditableColumn.'));
		$cs=Yii::app()->getClientScript();
		$gridId = $this->grid->getId();
		$script = <<<SCRIPT
		jQuery("input[type='text']").change(function(e) {
			e.preventDefault();
			var link = this;
			$.ajax({
				dataType: "json",
				cache: false,
				
				success: function(data){
		 		 alert("$gridId");
				$('#$gridId').yiiGridView.update('$gridId');
				}
			});
		});
SCRIPT;
		$cs->registerScript(__CLASS__.$gridId.'#flag_link', $script);
	}
// 	url: link.href,
	
// 	/**
// 	 * Renders the header cell content.
// 	 * This method will render a link that can trigger the sorting if the column is sortable.
// 	 */
// 	protected function renderHeaderCellContent()
// 	{
// 		if($this->grid->enableSorting && $this->sortable && $this->name!==null)
// 			echo $this->grid->dataProvider->getSort()->link($this->name,$this->header);
// 		else
// 			parent::renderHeaderCellContent();
// 	}

// 	/**
// 	 * Renders the data cell content.
// 	 * @param integer the row number (zero-based)
// 	 * @param mixed the data associated with the row
// 	 */
// 	protected function renderDataCellContent($row,$data)
// 	{
// 		$field = $this->name;
// 		//printf('<input style="width:100%%" name="%s[%s]" type="text" value="%s" />', $data->tableSchema->name, $field, $data->$field);
// 		printf('<input class="flag_link" name="%s[%s]" type="text" value="%s" />', $data->tableSchema->name, $field, $data->$field);
// 	}
	protected function renderDataCellContent($row, $data) {
		$value=CHtml::value($data,$this->name);
	
		$this->callbackUrl['pk'] = $data->primaryKey;
		$this->callbackUrl['name'] = urlencode($this->name);
		$this->callbackUrl['value'] = (int)empty($value);
	
		$link = CHtml::normalizeUrl($this->callbackUrl);
	
		echo CHtml::textField($this->name,!empty($value) ? $value : 0, array(
				'class' => $this->_flagClass,
				'type'=>'POST',
		));
	}
	
	protected function renderHeaderCellContent()
	{
		if($this->grid->enableSorting && $this->sortable && $this->name!==null)
			echo $this->grid->dataProvider->getSort()->link($this->name,$this->header);
		else if($this->name!==null && $this->header===null)
		{
			if($this->grid->dataProvider instanceof CActiveDataProvider)
				echo CHtml::encode($this->grid->dataProvider->model->getAttributeLabel($this->name));
			else
				echo CHtml::encode($this->name);
		}
		else
			parent::renderHeaderCellContent();
	}
}
