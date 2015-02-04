<?php

class CrudCode extends CCodeModel
{
	public $model;
	public $controller;
	public $baseControllerClass='Controller';
	public $parent;

	private $_modelClass;
	public $_table;
	public $_parentTableName;
	public $_parentClassName;
	public $_parentRelationName;

	public function rules()
	{
		return array_merge(parent::rules(), array(
			array('model, controller', 'filter', 'filter'=>'trim'),
			array('model, controller, baseControllerClass, parent', 'required'),
			array('model', 'match', 'pattern'=>'/^\w+[\w+\\.]*$/', 'message'=>'{attribute} should only contain word characters and dots.'),
			array('controller', 'match', 'pattern'=>'/^\w+[\w+\\/]*$/', 'message'=>'{attribute} should only contain word characters and slashes.'),
			array('baseControllerClass', 'match', 'pattern'=>'/^[a-zA-Z_]\w*$/', 'message'=>'{attribute} should only contain word characters.'),
			array('baseControllerClass', 'validateReservedWord', 'skipOnError'=>true),
			array('model', 'validateModel'),
			array('baseControllerClass', 'sticky'),
		));
	}

	public function attributeLabels()
	{
		return array_merge(parent::attributeLabels(), array(
			'model'=>'Model Class',
			'controller'=>'Controller ID',
			'baseControllerClass'=>'Base Controller Class',
		));
	}

	public function requiredTemplates()
	{
		return array(
			'controller.php',
		);
	}

	public function init()
	{
		if(Yii::app()->db===null)
			throw new CHttpException(500,'An active "db" connection is required to run this generator.');
		parent::init();
	}

	public function successMessage()
	{
		$link=CHtml::link('try it now', Yii::app()->createUrl($this->controller), array('target'=>'_blank'));
		return "The controller has been generated successfully. You may $link.";
	}

	public function validateModel($attribute,$params)
	{
		if($this->hasErrors('model'))
			return;
		$class=@Yii::import($this->model,true);
		if(!is_string($class) || !$this->classExists($class))
			$this->addError('model', "Class '{$this->model}' does not exist or has syntax error.");
		else if(!is_subclass_of($class,'CActiveRecord'))
			$this->addError('model', "'{$this->model}' must extend from CActiveRecord.");
		else
		{
			$table=CActiveRecord::model($class)->tableSchema;
			if($table->primaryKey===null)
				$this->addError('model',"Table '{$table->name}' does not have a primary key.");
			else if(is_array($table->primaryKey))
				$this->addError('model',"Table '{$table->name}' has a composite primary key which is not supported by crud generator.");
			else
			{
				$this->_modelClass=$class;
				$this->_table=$table;
				$this->_parentTableName=$this->class2table($this->parent);
				$this->_parentClassName=ucfirst($this->parent);
				$this->_parentRelationName=$this->parent;
			}
		}
	}

	private function class2table($name) {
		$ret='';
		for($i=0;$i<strlen($name);$i++){
			$char=substr($name,$i,1);
			if($this->hasUpperCase($char)) $ret=$ret.'_'.strtolower($char);
			else $ret=$ret.$char; 
		}
		echo $ret;
		return $ret;
	}
	
	private function hasUpperCase($string) {
		return strtolower($string)!==$string;
	}

	public function prepare()
	{
		$this->files=array();
		$templatePath=$this->templatePath;
		$controllerTemplateFile=$templatePath.DIRECTORY_SEPARATOR.'controller.php';

		$this->files[]=new CCodeFile(
			$this->controllerFile,
			$this->render($controllerTemplateFile)
		);

		$files=scandir($templatePath);
		foreach($files as $file)
		{
			if(is_file($templatePath.'/'.$file) && CFileHelper::getExtension($file)==='php' && $file!=='controller.php')
			{
				$this->files[]=new CCodeFile(
					$this->viewPath.DIRECTORY_SEPARATOR.$file,
					$this->render($templatePath.'/'.$file)
				);
			}
		}
	}

	public function getModelClass()
	{
		return $this->_modelClass;
	}

	public function getControllerClass()
	{
		if(($pos=strrpos($this->controller,'/'))!==false)
			return ucfirst(substr($this->controller,$pos+1)).'Controller';
		else
			return ucfirst($this->controller).'Controller';
	}

	public function getModule()
	{
		if(($pos=strpos($this->controller,'/'))!==false)
		{
			$id=substr($this->controller,0,$pos);
			if(($module=Yii::app()->getModule($id))!==null)
				return $module;
		}
		return Yii::app();
	}

	public function getControllerID()
	{
		if($this->getModule()!==Yii::app())
			$id=substr($this->controller,strpos($this->controller,'/')+1);
		else
			$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getUniqueControllerID()
	{
		$id=$this->controller;
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtolower($id[$pos+1]);
		else
			$id[0]=strtolower($id[0]);
		return $id;
	}

	public function getControllerFile()
	{
		$module=$this->getModule();
		$id=$this->getControllerID();
		if(($pos=strrpos($id,'/'))!==false)
			$id[$pos+1]=strtoupper($id[$pos+1]);
		else
			$id[0]=strtoupper($id[0]);
		return $module->getControllerPath().'/'.$id.'Controller.php';
	}

	public function getViewPath()
	{
		return $this->getModule()->getViewPath().'/'.$this->getControllerID();
	}

	public function getTableSchema()
	{
		return $this->_table;
	}

	public function generateInputLabel($modelClass,$column)
	{
		return "CHtml::activeLabelEx(\$model,'{$column->name}')";
	}

	public function generateInputField($modelClass,$column)
	{
		if($column->type==='boolean')
			return "CHtml::activeCheckBox(\$model,'{$column->name}')";
		else if(stripos($column->dbType,'text')!==false)
			return "CHtml::activeTextArea(\$model,'{$column->name}',array('rows'=>6, 'cols'=>50))";
		else
		{
			if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
				$inputField='activePasswordField';
			else
				$inputField='activeTextField';

			if($column->type!=='string' || $column->size===null)
				return "CHtml::{$inputField}(\$model,'{$column->name}')";
			else
			{
				if(($size=$maxLength=$column->size)>60)
					$size=60;
				return "CHtml::{$inputField}(\$model,'{$column->name}',array('size'=>$size,'maxlength'=>$maxLength))";
			}
		}
	}

	public function generateActiveLabel($modelClass,$column)
	{
		return "\$form->labelEx(\$model,'{$column->name}')";
	}

	public function calculateSpan($column) {
		$size=$column->size;
		$span='';
		switch ($size) {
			case ($size <= 5):
				$span="'class'=>'span1'";
				break;
			case ($size <= 20):
				$span="'class'=>'span2'";
				break;
			case ($size <= 80):
				$span="'class'=>'span3'";
				break;
			case ($size <= 100):
				$span="'class'=>'span4'";
				break;
			default:
				$span="'class'=>'span5'";
				break;
		}
		return $span;
	}

	public function className($tableName) {
		$className='';
		foreach(explode('_',$tableName) as $name)
			if($name!=='') $className.=ucfirst($name);
		return $className;
	}
	
	public function generateActiveField($modelClass,$column) {
		$size=$maxLength=$column->size;
		$span=$this->calculateSpan($column);
		$tableSchema=$this->getTableSchema();
		$pos = strpos(strtolower($column->name),'date');
		if($pos !== false)
			return "Utilities::formDatePicker(\$form, \$model,'{$column->name}')";
		
		if ($this->tableSchema->foreignKeys[$column->name]){
			return "Utilities::select2Row(\$this,'{$this->getModelClass()}',\$form,\$model,'{$column->name}',{$this->className($column->name)}::getList(),'{$this->className($column->name)}',Yii::t('app','general.label.{$this->className($column->name)}'),'180px')";
			//return "\$form->select2Row(\$model,'{$column->name}',{$this->className($column->name)}::getList(),array('empty'=>Yii::t('app','general.label.{$this->className($column->name)}'),'style'=>'width: 180px;','options' => array()))";
			//return "\$form->dropDownListRow(\$model,'{$column->name}',{$this->className($column->name)}::getList(),array('empty'=>Yii::t('app','general.label.{$this->className($column->name)}'),{$span}))";
		}
		if($column->type==='boolean')
			return "echo \$form->checkBoxRow(\$model,'{$column->name}');";

		if(stripos($column->dbType,'text')!==false || $size > 90)
			return "echo \$form->textAreaRow(\$model,'{$column->name}', array(".$span.", 'rows'=>1, 'size'=>$size,'maxlength'=>$maxLength));";
			
		if(preg_match('/^(password|pass|passwd|passcode)$/i',$column->name))
			$inputField='passwordFieldRow';
		else $inputField='textFieldRow';

		if($column->type=='string' && $size<=1)
			return "Utilities::toggleButtonRow(\$form,\$model,'{$column->name}');";

		if($column->type!=='string' || $column->size===null)
			return "echo \$form->{$inputField}(\$model,'{$column->name}', array(".$span."));";

		$additionalHtml='';
		if(stripos(strtolower($column->dbType),'decimal')!==false) $additionalHtml="'value'=>\$model->{$column->name}<=0 ? '': \$model->{$column->name},";
		if(($size=$maxLength=$column->size)>60) $size=60;
			return "echo \$form->{$inputField}(\$model,'{$column->name}',array(".$span.", 'size'=>$size,'maxlength'=>$maxLength,$additionalHtml));";
	}

	public function guessNameColumn($columns)
	{
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'name'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if(!strcasecmp($column->name,'title'))
				return $column->name;
		}
		foreach($columns as $column)
		{
			if($column->isPrimaryKey)
				return $column->name;
		}
		return 'id';
	}
}