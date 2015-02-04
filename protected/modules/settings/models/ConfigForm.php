<?php
 class ConfigForm extends CFormModel {
	public $AutoDepositCi_def_client;
	public $AutoDepositCi_def_date;
	public $AutoDepositCi_def_notes;
	public $AutoDepositCi_def_value;
	public $CartList_def_date;
	public $ClientInvoiceDeposit_def_date;
	public $ClientInvoiceDeposit_def_final_payment;
	public $ClientInvoiceDeposit_def_notes;
	public $ClientInvoiceDeposit_def_value;
	public $ClientInvoiceDetail_def_notes;
	public $ClientInvoiceDetail_def_product;
	public $ClientInvoiceDetail_def_quantity;
	public $ClientInvoiceDetail_def_unit_value;
	public $ClientInvoice_autoGenerate_details;
	public $ClientInvoice_def_client;
	public $ClientInvoice_def_date;
	public $ClientInvoice_def_notes;
	public $ClientInvoice_def_payment_date;
	public $ClientInvoice_def_status;
	public $ClientInvoice_filter_def_status;
	public $ClientInvoice_final_status;
	public $ClientInvoice_stock_status;
	public $Client_def_address;
	public $Client_def_code;
	public $Client_def_description;
	public $Client_def_mobile;
	public $Client_def_name;
	public $Client_def_phone;
	public $General_ActivateToolTips;
	public $General_adminEmail;
	public $General_appName;
	public $General_DefaultShowHeaders;
	public $General_Styles_DepositsColumn;
	public $General_Styles_DepositsFooter;
	public $General_Styles_PendingColumn;
	public $General_Styles_PendingFooter;
	public $General_Styles_TotalColumn;
	public $General_Styles_TotalFooter;
	public $MeasureUnit_def_code;
	public $MeasureUnit_def_eq_reference;
	public $MeasureUnit_def_name;
	public $MeasureUnit_def_reference;
	public $Product_def_code;
	public $Product_def_default_qty;
	public $Product_def_default_value;
	public $Product_def_measure_unit;
	public $Product_def_name;
	public $Product_def_stock_movement;
	public $ProviderInvoiceDeposit_def_date;
	public $ProviderInvoiceDeposit_def_final_payment;
	public $ProviderInvoiceDeposit_def_notes;
	public $ProviderInvoiceDeposit_def_value;
	public $ProviderInvoiceDetail_def_notes;
	public $ProviderInvoiceDetail_def_product;
	public $ProviderInvoiceDetail_def_quantity;
	public $ProviderInvoiceDetail_def_unit_value;
	public $ProviderInvoice_autoGenerate_details;
	public $ProviderInvoice_def_date;
	public $ProviderInvoice_def_notes;
	public $ProviderInvoice_def_payment_date;
	public $ProviderInvoice_def_provider;
	public $ProviderInvoice_def_status;
	public $ProviderInvoice_filter_def_status;
	public $ProviderInvoice_final_status;
	public $ProviderInvoice_stock_status;
	public $Provider_def_address;
	public $Provider_def_code;
	public $Provider_def_description;
	public $Provider_def_mobile;
	public $Provider_def_name;
	public $Provider_def_phone;
	public $Stock_auto_date;
	public $Stock_def_date;
	public $Stock_def_movement_type;
	public $Stock_def_product;
	public $Stock_def_quantity;
	public $User_def_name;
	public $User_def_password;
	public $User_def_username;
	public function attributeLabels() {
		return array(
			'AutoDepositCi_def_client'=>Yii::t('app','general.label.AutoDepositCi_def_client'),
			'AutoDepositCi_def_date'=>Yii::t('app','general.label.AutoDepositCi_def_date'),
			'AutoDepositCi_def_notes'=>Yii::t('app','general.label.AutoDepositCi_def_notes'),
			'AutoDepositCi_def_value'=>Yii::t('app','general.label.AutoDepositCi_def_value'),
			'CartList_def_date'=>Yii::t('app','general.label.CartList_def_date'),
			'ClientInvoiceDeposit_def_date'=>Yii::t('app','general.label.ClientInvoiceDeposit_def_date'),
			'ClientInvoiceDeposit_def_final_payment'=>Yii::t('app','general.label.ClientInvoiceDeposit_def_final_payment'),
			'ClientInvoiceDeposit_def_notes'=>Yii::t('app','general.label.ClientInvoiceDeposit_def_notes'),
			'ClientInvoiceDeposit_def_value'=>Yii::t('app','general.label.ClientInvoiceDeposit_def_value'),
			'ClientInvoiceDetail_def_notes'=>Yii::t('app','general.label.ClientInvoiceDetail_def_notes'),
			'ClientInvoiceDetail_def_product'=>Yii::t('app','general.label.ClientInvoiceDetail_def_product'),
			'ClientInvoiceDetail_def_quantity'=>Yii::t('app','general.label.ClientInvoiceDetail_def_quantity'),
			'ClientInvoiceDetail_def_unit_value'=>Yii::t('app','general.label.ClientInvoiceDetail_def_unit_value'),
			'ClientInvoice_autoGenerate_details'=>Yii::t('app','general.label.ClientInvoice_autoGenerate_details'),
			'ClientInvoice_def_client'=>Yii::t('app','general.label.ClientInvoice_def_client'),
			'ClientInvoice_def_date'=>Yii::t('app','general.label.ClientInvoice_def_date'),
			'ClientInvoice_def_notes'=>Yii::t('app','general.label.ClientInvoice_def_notes'),
			'ClientInvoice_def_payment_date'=>Yii::t('app','general.label.ClientInvoice_def_payment_date'),
			'ClientInvoice_def_status'=>Yii::t('app','general.label.ClientInvoice_def_status'),
			'ClientInvoice_filter_def_status'=>Yii::t('app','general.label.ClientInvoice_filter_def_status'),
			'ClientInvoice_final_status'=>Yii::t('app','general.label.ClientInvoice_final_status'),
			'ClientInvoice_stock_status'=>Yii::t('app','general.label.ClientInvoice_stock_status'),
			'Client_def_address'=>Yii::t('app','general.label.Client_def_address'),
			'Client_def_code'=>Yii::t('app','general.label.Client_def_code'),
			'Client_def_description'=>Yii::t('app','general.label.Client_def_description'),
			'Client_def_mobile'=>Yii::t('app','general.label.Client_def_mobile'),
			'Client_def_name'=>Yii::t('app','general.label.Client_def_name'),
			'Client_def_phone'=>Yii::t('app','general.label.Client_def_phone'),
			'General_ActivateToolTips'=>Yii::t('app','general.label.General_ActivateToolTips'),
			'General_adminEmail'=>Yii::t('app','general.label.General_adminEmail'),
			'General_appName'=>Yii::t('app','general.label.General_appName'),
			'General_DefaultShowHeaders'=>Yii::t('app','general.label.General_DefaultShowHeaders'),
			'General_Styles_DepositsColumn'=>Yii::t('app','general.label.General_Styles_DepositsColumn'),
			'General_Styles_DepositsFooter'=>Yii::t('app','general.label.General_Styles_DepositsFooter'),
			'General_Styles_PendingColumn'=>Yii::t('app','general.label.General_Styles_PendingColumn'),
			'General_Styles_PendingFooter'=>Yii::t('app','general.label.General_Styles_PendingFooter'),
			'General_Styles_TotalColumn'=>Yii::t('app','general.label.General_Styles_TotalColumn'),
			'General_Styles_TotalFooter'=>Yii::t('app','general.label.General_Styles_TotalFooter'),
			'MeasureUnit_def_code'=>Yii::t('app','general.label.MeasureUnit_def_code'),
			'MeasureUnit_def_eq_reference'=>Yii::t('app','general.label.MeasureUnit_def_eq_reference'),
			'MeasureUnit_def_name'=>Yii::t('app','general.label.MeasureUnit_def_name'),
			'MeasureUnit_def_reference'=>Yii::t('app','general.label.MeasureUnit_def_reference'),
			'Product_def_code'=>Yii::t('app','general.label.Product_def_code'),
			'Product_def_default_qty'=>Yii::t('app','general.label.Product_def_default_qty'),
			'Product_def_default_value'=>Yii::t('app','general.label.Product_def_default_value'),
			'Product_def_measure_unit'=>Yii::t('app','general.label.Product_def_measure_unit'),
			'Product_def_name'=>Yii::t('app','general.label.Product_def_name'),
			'Product_def_stock_movement'=>Yii::t('app','general.label.Product_def_stock_movement'),
			'ProviderInvoiceDeposit_def_date'=>Yii::t('app','general.label.ProviderInvoiceDeposit_def_date'),
			'ProviderInvoiceDeposit_def_final_payment'=>Yii::t('app','general.label.ProviderInvoiceDeposit_def_final_payment'),
			'ProviderInvoiceDeposit_def_notes'=>Yii::t('app','general.label.ProviderInvoiceDeposit_def_notes'),
			'ProviderInvoiceDeposit_def_value'=>Yii::t('app','general.label.ProviderInvoiceDeposit_def_value'),
			'ProviderInvoiceDetail_def_notes'=>Yii::t('app','general.label.ProviderInvoiceDetail_def_notes'),
			'ProviderInvoiceDetail_def_product'=>Yii::t('app','general.label.ProviderInvoiceDetail_def_product'),
			'ProviderInvoiceDetail_def_quantity'=>Yii::t('app','general.label.ProviderInvoiceDetail_def_quantity'),
			'ProviderInvoiceDetail_def_unit_value'=>Yii::t('app','general.label.ProviderInvoiceDetail_def_unit_value'),
			'ProviderInvoice_autoGenerate_details'=>Yii::t('app','general.label.ProviderInvoice_autoGenerate_details'),
			'ProviderInvoice_def_date'=>Yii::t('app','general.label.ProviderInvoice_def_date'),
			'ProviderInvoice_def_notes'=>Yii::t('app','general.label.ProviderInvoice_def_notes'),
			'ProviderInvoice_def_payment_date'=>Yii::t('app','general.label.ProviderInvoice_def_payment_date'),
			'ProviderInvoice_def_provider'=>Yii::t('app','general.label.ProviderInvoice_def_provider'),
			'ProviderInvoice_def_status'=>Yii::t('app','general.label.ProviderInvoice_def_status'),
			'ProviderInvoice_filter_def_status'=>Yii::t('app','general.label.ProviderInvoice_filter_def_status'),
			'ProviderInvoice_final_status'=>Yii::t('app','general.label.ProviderInvoice_final_status'),
			'ProviderInvoice_stock_status'=>Yii::t('app','general.label.ProviderInvoice_stock_status'),
			'Provider_def_address'=>Yii::t('app','general.label.Provider_def_address'),
			'Provider_def_code'=>Yii::t('app','general.label.Provider_def_code'),
			'Provider_def_description'=>Yii::t('app','general.label.Provider_def_description'),
			'Provider_def_mobile'=>Yii::t('app','general.label.Provider_def_mobile'),
			'Provider_def_name'=>Yii::t('app','general.label.Provider_def_name'),
			'Provider_def_phone'=>Yii::t('app','general.label.Provider_def_phone'),
			'Stock_auto_date'=>Yii::t('app','general.label.Stock_auto_date'),
			'Stock_def_date'=>Yii::t('app','general.label.Stock_def_date'),
			'Stock_def_movement_type'=>Yii::t('app','general.label.Stock_def_movement_type'),
			'Stock_def_product'=>Yii::t('app','general.label.Stock_def_product'),
			'Stock_def_quantity'=>Yii::t('app','general.label.Stock_def_quantity'),
			'User_def_name'=>Yii::t('app','general.label.User_def_name'),
			'User_def_password'=>Yii::t('app','general.label.User_def_password'),
			'User_def_username'=>Yii::t('app','general.label.User_def_username'),
		);
	}
}
?>