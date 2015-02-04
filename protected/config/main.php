<?php
$dirName=dirname(__FILE__);
Yii::setPathOfAlias('editable', $dirName.'/../extensions/x-editable');
Yii::setPathOfAlias('bootstrap', $dirName.'/../extensions/bootstrap');
Yii::setPathOfAlias('emenu', $dirName.'/../extensions/emenu');
Yii::setPathOfAlias('UniqueAttributeValidator', $dirName.'/../extensions/UnqAttrValidate');
Yii::setPathOfAlias('baseApp', $dirName.'/../');
Yii::setPathOfAlias('baseModules', $dirName.'/../modules/');
Yii::setPathOfAlias('application.messages', $dirName.'/../messages/');
// Yii::setPathOfAlias('mPrint', $dirName.'/../extensions/mPrint/');
Yii::setPathOfAlias('css', $dirName.'/../../css/');
Yii::setPathOfAlias('print', $dirName.'/../extensions/print/');
Yii::setPathOfAlias('backup', $dirName.'/../modules/backup/');
Yii::setPathOfAlias('settings', $dirName.'/../modules/settings/');
Yii::setPathOfAlias('menumobile', $dirName.'/../modules/menumobile/');
Yii::setPathOfAlias('groupgridview', $dirName.'/../extensions/groupgridview');
return array(
	'language'=>'es',
	// preloading 'log' component
	'preload'=>array(
		//'log',
		'bootstrap'
	),
	'import'=>array(
			'application.models.*',
			'application.components.*',
			'application.extensions.grid.*',
			//'application.modules.rights.*',
			//'application.modules.rights.components.*',
			'baseModules.rights.*',
			'baseModules.rights.components.*',
			'editable.*',
			'baseApp.components.*',
			'UniqueAttributeValidator.*',
			'backup.*',
			'backup.BackupModule',
			'settings.*',
			'settings.SettingsModule',
			'menumobile.*',
			'menumobile.MenumobileModule',
	),
	'modules'=>array(
		'menumobile',
		// uncomment the following to enable the Gii tool
// 		'gii'=>array(
// 			'class'=>'system.gii.GiiModule',
// 			'password'=>'gii',
// 			// If removed, Gii defaults to localhost only. Edit carefully to taste.
// 			//'ipFilters'=>array('127.0.0.1','::1'),
// 			'generatorPaths'=>array('baseModules.gii'),
// 		),
		'rights'=>array(
			'class'=>'baseModules.rights.RightsModule',
			'userClass'=>'User',
			'superuserName'=>'Admin', // Name of the ROLE with super user privileges.
			'authenticatedName'=>'Auth', // Name of the authenticated user role.
			'userIdColumn'=>'id', // Name of the user id column in the database.
			'userNameColumn'=>'username', // Name of the user name column in the database.
			'enableBizRule'=>true, // Whether to enable authorization item business rules.
			'enableBizRuleData'=>false, // Whether to enable data for business rules.
			'displayDescription'=>true, // Whether to use item description instead of name.
			'flashSuccessKey'=>'RightsSuccess', // Key to use for setting success flash messages.
			'flashErrorKey'=>'RightsError', // Key to use for setting error flash messages.
			'baseUrl'=>'/rights', // Base URL for Rights. Change if module is nested.
			'layout'=>'rights.views.layouts.main', // Layout to use for displaying Rights.
			'appLayout'=>'application.views.layouts.main', // Application layout.
			'cssFile'=>'rights.css', // Style sheet file to use for Rights.
			'install'=>false, // Whether to enable installer.
			'debug'=>false, // Whether to enable debug mode.
		),
	),
	// application components
	'components'=>array(
// 		'assetManager' => array(
// 			'linkAssets' => true,
// 		),
		'session' => array(
				//'class' => 'CDbHttpSession',
				//'autoCreateSessionTable'=>false,
				'timeout'=>60*60, //60 * XX Minutes
				'cookieMode' =>'only',
				'cookieParams' => array('secure' => false, 'httponly' => false),
		),
		'user'=>array(
				// enable cookie-based authentication
				'allowAutoLogin'=>true,
				'class'=>'RWebUser',
		),
		// uncomment the following to enable URLs in path-format
		'urlManager'=>array(
				'urlFormat'=>'path',
				'rules'=>array(
						'<controller:\w+>/<id:\d+>'=>'<controller>/view',
						'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
						'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
				),
		),
		'dbBase' => array(
			'connectionString' => 'mysql:host=localhost;dbname=arkeasco_base',
			'username' => 'arkeasco_admindb',
			'password' => 'Admindb2012',
			'charset' => 'utf8',
			'class' => 'CDbConnection'
		),
		'coreMessages'=>array('basePath'=>null,),
		'errorHandler'=>array('errorAction'=>'site/error',),
// 		'log'=>array(
// 			'class'=>'CLogRouter',
// 			'routes'=>array(
// 				array(
// 					'class'=>'CFileLogRoute',
// 					'levels'=>'error, warning',
// 				),
// 				// uncomment the following to show log messages on web pages
// 				array('class'=>'CWebLogRoute',),
// 			),
// 		),
		'bootstrap' => array(
			'class' => 'bootstrap.components.Bootstrap',
			'coreCss'=>true,
			'responsiveCss'=>true,
			'yiiCss'=>true,
		),
		'authManager'=>array('class'=>'RDbAuthManager', // Provides support authorization item sorting.
		),
		//X-editable config
		'editable' => array(
			'class'=>'editable.EditableConfig',
			'form'=>'bootstrap',//form style: 'bootstrap', 'jqueryui', 'plain'
			'mode'=>'popup',//mode: 'popup' or 'inline'
			'defaults'=>array(//default settings for all editable elements
				'showbuttons'=>true,
				'placement' => 'right',
				'emptytext'=>Yii::t('app','Vacio'),
				'clear'=>'',
			),
		),
	),
	'params'=>array(
		'General_BaseConfig_Directory'=>$dirName,
		'General_BaseLayout_Directory'=>$dirName.'/../views/layouts/',
		'General_BaseLayout_File'=>$dirName.'/../views/layouts/main.php',
		'General_Column1Layout_File'=>$dirName.'/../views/layouts/column1.php',
		'General_Column2Layout_File'=>$dirName.'/../views/layouts/column2.php',
		'General_BaseDataLayout_File'=>$dirName.'/../views/layouts/baseData.php',
		'General_CleanViewLayout_File'=>$dirName.'/../views/layouts/cleanView.php',
		'General_SiteLogin_File'=>$dirName.'/../views/site/login.php',
		'General_SiteIndex_File'=>$dirName.'/../views/site/index.php',
		'General_SiteError_File'=>$dirName.'/../views/site/error.php',
		'General_Date_Format'=>'Y-m-d',
		'General_pageSize'=>10,
		'General_CustomCSS'=>'custom.css',
		'General_BaseCSSDirectory'=>$dirName.'/../../css/',
		'General_Print_CSS_ClientInvoice'=>'print_ci.css',
		'General_Print_CSS_CartList'=>'print_cl.css',
		'General_BaseImageDirectory'=>'/images/',
		'General_UserForm_File'=>$dirName.'/../views/user/_form.php',
		'General_UserAdmin_File'=>$dirName.'/../views/user/admin.php',
		'General_UserCreate_File'=>$dirName.'/../views/user/create.php',
		'General_UserUpdate_File'=>$dirName.'/../views/user/update.php',
	),
);
?>