<?php
/**
 * TbInputInline class file.
 * @author Christoffer Niska <ChristofferNiska@gmail.com>
 * @copyright Copyright &copy; Christoffer Niska 2011-
 * @license http://www.opensource.org/licenses/bsd-license.php New BSD License
 * @package bootstrap.widgets.input
 */

Yii::import('bootstrap.widgets.input.TbInputVertical');

/**
 * Bootstrap vertical form input widget.
 * @since 0.9.8
 */
class TbInputInline extends TbInputVertical {
	/**
	 * Renders a select2Field
	 * @return mixed|void
	 */
	protected function select2Field() {
		if (isset($this->htmlOptions['options'])) {
			$options = $this->htmlOptions['options'];
			unset($this->htmlOptions['options']);
		}

		if (isset($this->htmlOptions['events'])) {
			$events = $this->htmlOptions['events'];
			unset($this->htmlOptions['events']);
		}

		if (isset($this->htmlOptions['data'])) {
			$data = $this->htmlOptions['data'];
			unset($this->htmlOptions['data']);
		}

		if (isset($this->htmlOptions['asDropDownList'])) {
			$asDropDownList = $this->htmlOptions['asDropDownList'];
			unset($this->htmlOptions['asDropDownList']);
		}

		echo $this->getPrepend();
		$this->widget('bootstrap.widgets.TbSelect2', array(
			'model'=>$this->model,
			'attribute'=>$this->attribute,
			'options' => isset($this->options) ? $this->options : array(),
			'events' => isset($events) ? $events : array(),
			'data' => isset($this->data) ? $this->data : array(),
			'asDropDownList' => isset($asDropDownList) ? $asDropDownList : true,
			'htmlOptions' => $this->htmlOptions,
			'form' => $this->form
		));
		echo $this->getAppend();
	}

	/**
	 * Renders a datepicker field.
	 * @return string the rendered content
	 * @author antonio ramirez <antonio@clevertech.biz>
	 */
	protected function datepickerField() {
		if (isset($this->htmlOptions['options']))
		{
			$options = $this->htmlOptions['options'];
			unset($this->htmlOptions['options']);
		}

		if (isset($this->htmlOptions['events']))
		{
			$events = $this->htmlOptions['events'];
			unset($this->htmlOptions['events']);
		}

		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->getPrepend();
		$this->widget('bootstrap.widgets.TbDatePicker', array(
			'model' => $this->model,
			'attribute' => $this->attribute,
			'options' => isset($options) ? $options : array(),
			'events' => isset($events) ? $events : array(),
			'htmlOptions' => $this->htmlOptions,
		));
		echo $this->getAppend();
	}

	/**
	 * Renders a toogle button
	 * @return string the rendered content
	 */
	protected function toggleButton()
	{
		// widget configuration is set on htmlOptions['options']
		$options = array(
			'model' => $this->model,
			'attribute' => $this->attribute
		);
		if (isset($this->htmlOptions['options']))
		{
			$options = CMap::mergeArray($options, $this->htmlOptions['options']);
			unset($this->htmlOptions['options']);
		}
		$options['htmlOptions'] = $this->htmlOptions;

		//echo $this->getLabel();
		$this->widget('bootstrap.widgets.TbToggleButton', $options);
	}
	
	/**
	 * Renders a drop down list (select).
	 * @return string the rendered content
	 */
	protected function dropDownList() {
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->form->dropDownList($this->model, $this->attribute, $this->data, $this->htmlOptions);
	}

	/**
	 * Renders a password field.
	 * @return string the rendered content
	 */
	protected function passwordField() {
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->getPrepend();
		echo $this->form->passwordField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getAppend();
	}

	/**
	 * Renders a textarea.
	 * @return string the rendered content
	 */
	protected function textArea() {
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->form->textArea($this->model, $this->attribute, $this->htmlOptions);
	}

	/**
	 * Renders a text field.
	 * @return string the rendered content
	 */
	protected function textField() {
		$this->htmlOptions['placeholder'] = $this->model->getAttributeLabel($this->attribute);
		echo $this->getPrepend();
		echo $this->form->textField($this->model, $this->attribute, $this->htmlOptions);
		echo $this->getAppend();
	}
}
