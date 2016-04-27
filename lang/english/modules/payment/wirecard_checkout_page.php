<?php
/**
Shop System Plugins - Terms of Use

These terms of use regulate the warranty and liability between Wirecard
Central Eastern Europe (subsequently referred to as WDCEE) and its
contractual partners (subsequently referred to as customer or customers)
which are related to the use of plugins provided by WDCEE.

The plugin is provided by WDCEE free of charge for its customers and
must be used for the purpose of WDCEE's payment platform integration
only. The plugin is explicitly not part of the general contract between WDCEE
and its customer. The plugin has been successfully tested under
specific circumstances which are defined as the shop system's standard
configuration (vendor's delivery state). The customer is responsible for
testing the plugin's functionality prior to deploying the plugin in production
environment.
The customer uses the plugin at his own risk. WDCEE does not guarantee its
full functionality neither does WDCEE assume liability for any
disadvantages related to the use of this plugin. By installing the plugin
into the shop system the customer agrees with these terms of use. Please do
not use this plugin if you do not agree with these terms of use!
 */

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_TITLE', 'Wirecard Checkout Page');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DESCRIPTION', 'Wirecard Checkout Page<br>Additional information about Wirecard products can be obtained from <a href="http://www.wirecard.at">http://www.wirecard.at</a><br>
  For the technical documentation go to: <br>
  <img src="images/icon_arrow_right.gif"><a href="https://integration.wirecard.at/doku.php/request_parameters">request parameters</a><br>
  <img src="images/icon_arrow_right.gif"><a href="https://integration.wirecard.at/doku.php/response_parameters">response parameters</a><br>
  <img src="images/icon_arrow_right.gif"><a href="https://integration.wirecard.at/doku.php/payment_methods:start">payment methods</a><br>');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS_TITLE','Enable Wirecard Checkout Page Module');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS_DESC','Do you want to accept Wirecard Checkout Page payments?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMERID_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#customerid"><strong>customerId</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMERID_DESC','Enter your customer ID you received from Wirecard CEE.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOPID_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#shopid"><strong>shopId</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOPID_DESC','Enter your shop ID you received from Wirecard CEE.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#secret"><strong>secret</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET_DESC','Enter the secret string (pre-shared key) you received from Wirecard CEE for the fingerprint-hash.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_USE_IFRAME_TITLE','Use Iframe');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_USE_IFRAME_DESC','Start Wirecard Checkout Page in an Iframe in your shop. <strong>Note:</strong> PayPal and Sofort&uuml;berweisung will always use page redirect.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SELECT_TITLE','Enable payment method SELECT');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SELECT_DESC','The customer can select the payment method in Wirecard Checkout Page. If activated, no other payment method is displayed in the shop.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TEXT_TITLE','Payment method text');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TEXT_DESC','Enter the text which should be displayed as description for the payment method SELECT (e.g. MasterCard, Visa, ...).');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_TITLE','Credit Card');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_DESC','Enable payment method Credit Card?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO_TITLE','Maestro SecureCode');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO_DESC','Enable payment method Maestro SecureCode?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS_TITLE','eps Online-&Uuml;berweisung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS_DESC','Enable payment method eps Online-&Uuml;berweisung?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX_TITLE','paybox');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX_DESC','Enable payment method paybox?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC_TITLE','paysafecard');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC_DESC','Enable payment method paysafecard?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK_TITLE','@Quick');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK_DESC','Enable payment method @Quick?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD_TITLE','SEPA Direct Debit');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD_DESC','Enable payment method SEPA Direct Debit?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL_TITLE', 'PayPal');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL_DESC','Enable payment method Paypal?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE_TITLE', 'SOFORT Banking');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE_DESC','Enable payment method SOFORT Banking?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL_TITLE','iDEAL');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL_DESC','Enable payment method iDEAL?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP_TITLE','giropay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP_DESC','Enable payment method Giropay?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_TITLE','Invoice');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_DESC','Enable payment method Invoice?');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO_TITLE','Credit Card - Mail Order / Telephone Order');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO_DESC','Enable payment method Credit Card - Mail Order / Telephone Order without "Verified by Visa" and "MasterCard SecureCode"?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC_TITLE','Bancontact/Mister Cash');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC_DESC','Enable payment method Bancontact/Mister Cash?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_TITLE','eKonto');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_DESC','Enable payment method eKonto?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_TITLE','Installment');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_DESC','Enable payment method Installment?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_TITLE','Trustly');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_DESC','Enable payment method Trustly?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_TITLE','moneta.ru');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_DESC','Enable payment method moneta.ru?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24_TITLE','Przelewy24');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24_DESC','Enable payment method Przelewy24?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_TITLE','POLi');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_DESC','Enable payment method POLi?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS_TITLE','mpass');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS_DESC','Enable payment method mpass?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT_TITLE','Skrill Direct');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT_DESC','Enable payment method Skrill Direct?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET_TITLE','Skrill Digital Wallet');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET_DESC','Enable payment method Skrill Digital Wallet?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG_TITLE','ePay.bg');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG_DESC','Enable payment method ePay.bg?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY_TITLE','TatraPay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY_DESC','Enable payment method TatraPay?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER_TITLE','My Voucher');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER_DESC','Enable payment method MyVoucher?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY_TITLE','TrustPay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY_DESC','Enable payment method TrustPay?');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TITLE', 'payolution terms checkbox');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_DESC', 'The buyer needs to accept payolution terms for installment and invoice payments.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_MID_TITLE', 'payolution mID');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_MID_DESC', '');


define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TEXT_INSTALLMENT', 'I agree that the data which are necessary for the liquidation of installments and which are used to complete the identity and credit check are transmitted to payolution.  My <a href="%s" target="_blank"><strong>consent</strong></a> can be revoked at any time with future effect.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TEXT_INVOICE', 'I agree that the data which are necessary for the liquidation of invoice payments and which are used to complete the identity and credit check are transmitted to payolution.  My <a href="%s" target="_blank"><strong>consent</strong></a> can be revoked at any time with future effect.');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MIN_AMOUNT_TITLE','Invoice minimum amount');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MIN_AMOUNT_DESC','Enter minimum amount for invoice. (&euro;)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MAX_AMOUNT_TITLE','Invoice maximum amount');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MAX_AMOUNT_DESC','Enter maximum amount for invoice. (&euro;)');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MIN_AMOUNT_TITLE','Installment minimum amount');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MIN_AMOUNT_DESC','Enter minimum amount for installment. (&euro;)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MAX_AMOUNT_TITLE','Installment maximum amount');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MAX_AMOUNT_DESC','Enter maximum amount for installment. (&euro;)');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters#customerstatement"><strong>customerStatement</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT_DESC', 'Customer statement prefix');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters#displaytext"><strong>displayText</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT_DESC', 'Info text displayed on Wirecard Checkout Page.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SERVICEURL_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters#customerid"><strong>serviceURL</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SERVICEURL_DESC','Enter the URL to your contact page.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IMAGEURL_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters#imageurl"><strong>imageURL</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IMAGEURL_DESC','Enter the URL of the image which should be displayed during the payment process on the Wirecard Checkout Page.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SORT_ORDER_TITLE','Sort order of display');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SORT_ORDER_DESC','Sort order of display. Lowest is displayed first.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ZONE_TITLE','Payment Zone');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ZONE_DESC','If a zone is selected, enable this payment method only for that zone.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_ID_TITLE','Set order status');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_ID_DESC','Set the status of orders made with this payment module to this value.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID_TITLE','Set order status pending');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID_DESC','Set the status of orders made with this payment module which are in payment state pending.');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_TEXT','Credit Card');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO_TEXT','Maestro SecureCode');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS_TEXT','eps Online-&Uuml;berweisung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX_TEXT','paybox');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC_TEXT','paysafecard');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK_TEXT','@Quick');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD_TEXT','SEPA Direct Debit');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL_TEXT','iDEAL');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL_TEXT','PayPal');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP_TEXT','giropay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_C2P_TEXT','CLICK2PAY');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE_TEXT','SOFORT Banking');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_TEXT','Invoice');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO_TEXT','Credit Card - Mail Order / Telephone Order');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC_TEXT','Bancontact/Mister Cash');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_TEXT','eKonto');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_TEXT','Installment');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_TEXT','Trustly');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_TEXT','moneta.ru');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24_TEXT','Przelewy24');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_TEXT','POLi');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS_TEXT','mpass');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT_TEXT','Skrill Direct');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET_TEXT','Skrill Digital Wallet');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG_TEXT','ePay.bg');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY_TEXT','TatraPay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER_TEXT','My Voucher');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY_TEXT','TrustPay');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ERROR_TITEL', 'Payment error');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ERROR_NOTRID', 'No transaction ID');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CANCEL_TEXT', 'You have canceled the payment process.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PENDING_TEXT', 'The payment confirmation will be sent later.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ERROR_TEXT', 'Your payment was invalid.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_FINGERPRINT_TEXT', 'An error occurred during data verification.');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE_TITLE', 'Plugin mode');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE_DESC', 'Switch the plugin mode between live, demo or test. <strong>Attention</strong>: Be aware that there is no payment processed in demo or test mode!');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DUPLICATE_REQUEST_CHECK_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#duplicaterequestcheck"><strong>duplicateRequestCheck</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DUPLICATE_REQUEST_CHECK_DESC', 'Enable to check if the same order has been unintentionally sent more than once.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_AUTO_DEPOSIT_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#autodeposit"><strong>autoDeposit</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_AUTO_DEPOSIT_DESC', 'Enables an automated deposit and day-end closing of payments depending on the payment method.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRMATION_MAIL_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#confirmmail"><strong>confirmMail</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRMATION_MAIL_DESC', 'E-mail address of the merchant for receiving payment information details.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_MAX_RETRIES_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#maxretries"><strong>maxRetries</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_MAX_RETRIES_DESC', 'Defines the maximum number of payment attempts regarding a certain order.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENTTYPE_SORT_ORDER_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#paymenttypesortorder"><strong>paymenttypeSortOrder</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENTTYPE_SORT_ORDER_DESC', 'Enables to define the sort order of all displayed payment methods and their corresponding sub-methods if your consumer uses SELECT as payment method.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CUSTOMER_DATA_TITLE', 'Submit customer information');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CUSTOMER_DATA_DESC', '');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CART_DATA_TITLE', 'Submit shopping cart information');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CART_DATA_DESC', '');

define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_DESC', 'Submit configuration to Wirecard.');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_RECEIVER', 'Receiver');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_CONFIG_STRING', 'Configuration');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_DESC_TEXT', 'Description');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_RETURN_MAIL', 'Reply to');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_SUBMIT_BUTTON', 'Submit');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_BACK_BUTTON', 'Back');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_INVALID_MAIL', 'Invalid e-mail address');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_MAIL_SENT', 'Configuration has been sent successfully');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_MAIL_NOT_SENT', 'Configuration has not been sent');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_EXPORT_CONFIG_LABEL', 'Submit configuration');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DEVICE_DETECTION_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#layout"><strong>layout</strong></a> (automatic device detection)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DEVICE_DETECTION_DESC', 'If activated, the buyer&#039;s device will be auto-detected to optimize the payment page.');

define('WCP_SHOPPING_CART_TITLE', 'Shopping cart');
define('WCP_YOUR_DATA_TITLE', 'Your data');
define('WCP_PAYMENT_TITLE', 'Shipping &amp; Payment');
define('WCP_CONFIRMATION_TITLE', 'Confirmation');

define('MODULE_PAYMENT_WCP_CHECKOUT_TITLE', 'Payment process');
define('MODULE_PAYMENT_WCP_CHECKOUT_CONTENT', '<center>You will be redirected.</center>');

define('CHECKOUT_CANCEL_TITLE', 'Payment was canceled');
define('CHECKOUT_CANCEL_TEXT', 'You canceled your payment!');

define('CHECKOUT_FAILURE_TITLE', 'An error occurred');
define('CHECKOUT_FAILURE_TEXT', 'An error occurred during the payment process');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMETHOD_NOT_ALLOWED', 'The selected payment method is not available. Please select another payment method.');
define('MODULE_PAYMENT_WCP_DATE_OF_BIRTH_TEXT', 'Date of birth in format (dd.mm.yyyy)');
define('MODULE_PAYMENT_WCP_ENTRY_VAT_ID', 'vat id:');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ENTRY_VAT_ERROR', 'The used VAT ID is not valid.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_ACCEPT_TERMS', 'Please accept the payolution terms');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_COMMUNICATION_ERROR', 'Connection problem to payment provider. Please try again.');
