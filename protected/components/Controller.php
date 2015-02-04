<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController {
	private $_pageTitle;
	public function getPageTitle() {
        if($this->_pageTitle!==null) return Yii::t('app',$this->_pageTitle);
        else {
			$controller = Yii::t('app','general.label.'.Yii::t('app', ucfirst(basename($this->getId()))));
			if($this->getAction()!==null && strcasecmp($this->getAction()->getId(),$this->defaultAction)) {
				$action = Yii::t('app', 'general.label.'.ucfirst($this->getAction()->getId()));
				return $this->_pageTitle=Yii::app()->name.' - '.Yii::t('app', '{action} {controller}', array('{action}' => $action, '{controller}' => $controller));
			} else return $this->_pageTitle=Yii::app()->name.' - '.$controller;
		}
	}

	public function filters() { 
		return array( 'rights', ); 
	}

	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1.php';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
}