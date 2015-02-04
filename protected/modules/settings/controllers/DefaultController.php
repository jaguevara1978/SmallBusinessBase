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
class DefaultController extends Controller {
	public $layout='//layouts/column2';
	public function actionIndex() {
		$this->loadFromBase();
		$this->deleteUnused();
		$this->updateModel();
		$model=new ConfigForm;
		$settingsModel=Settings::model()->findAll();
	
		if (isset($_POST['ConfigForm'])) {
			$config=array();
			foreach ($settingsModel as $sModel) {
				$key=$sModel->key;
				$sModel->value=$_POST['ConfigForm'][$key];
				$sModel->update();
				$model->$key=$sModel->value;
				$config[$key]=$this->normalizeValue($sModel->data_type,$sModel->value);
			}
			//print_r($config);
			$str=base64_encode(serialize($config));
			$fp=fopen($this->getPath().'params.inc','w+');
			fwrite($fp,$str);
			Yii::app()->user->setFlash('success',Yii::t('app','message.successFullySaved'));
		} else {
			foreach($settingsModel as $sModel) {
				$key=$sModel->key;
				$model->$key=$sModel->value;
			}
		}
		$this->render('index',array('model'=>$model));
	}
	private function loadFromBase() {
		$settingsBaseModel=SettingsBase::model()->findAll();
		foreach ($settingsBaseModel as $sbModel) {
			if(Settings::Model()->count("t.key=:key",array(":key"=>$sbModel->key))<=0) {
				if(Yii::app()->params['General_'.substr($sbModel->group,4).'_Enabled']) {
					$settings=new Settings;
					$settings->attributes=$sbModel->attributes;
					$settings->save();
				}
			} else {
				$settings=Settings::model()->findByPk($sbModel->key);
				$settings->group=$sbModel->group;
				$settings->group_order=$sbModel->group_order;
				$settings->type=$sbModel->type;
				$settings->type_specs=$sbModel->type_specs;
				$settings->data_type=$sbModel->data_type;
				$settings->update();
			}
		}
		return $createdNew;
	}
	private function deleteUnused() {
		$settingsModel=Settings::model()->findAll();
		foreach ($settingsModel as $sModel)
			if(SettingsBase::Model()->count("t.key=:key",array(":key"=>$sModel->key))<=0)
				$sModel->delete();
	}
	protected function getPath() {
		//if(!$this->module->path) $this->module->path=__DIR__.'/../config/';
		if (!file_exists($this->module->path)) {
			mkdir($this->path);
			chmod($this->path,'777');
		}
		return $this->module->path;
	}
	private function normalizeValue($type,$valueP) {
		//if(!$valueP) return null;
		switch($type) {
			case 'date':
				if(!is_numeric($valueP)) return 'Today';
				if($valueP==0) return 'Today';
				if(!(strpos($valueP,'+')!==false) & !(strpos($valueP,'-')!==false)) $value='+'.$valueP;
				else $value=$valueP;
				$value=$value." day";
				break;
			case 'boolean':
				if(!$valueP) return 0;
				$value=$valueP;
				break;
			case 'boolean_num':
				if(!$valueP) return 0;
				$value=$valueP;
				break;
			case 'number':
				if(!is_numeric($valueP)) return null;
				$value=$valueP;
				break;
			default:
				$value=$valueP;
				break;
		}
		return $value;
	}

	private function updateModel() {
		$file = dirname(__FILE__).'/../models/ConfigForm.php';
		$content="<?php\n class ConfigForm extends CFormModel {\n";
		$settingsModel=SettingsBase::model()->findAll();
		foreach ($settingsModel as $model)
			$content.="\tpublic \$".$model->key.";\n";
		
		$content.="\tpublic function attributeLabels() {\n";
		$content.="\t\treturn array(\n";
		foreach ($settingsModel as $model)
			$content.="\t\t\t'".$model->key."'=>Yii::t('app','general.label.".$model->key."'),\n";
		$content.="\t\t);\n";
		$content.="\t}\n";
		$content.="}\n?>";
		file_put_contents($file, $content);
	}
}