<?php
/**
    Shop System Plugins - Terms of use

    This terms of use regulates warranty and liability between Wirecard
    Central Eastern Europe (subsequently referred to as WDCEE) and it's
    contractual partners (subsequently referred to as customer or customers)
    which are related to the use of plugins provided by WDCEE.

    The Plugin is provided by WDCEE free of charge for it's customers and
    must be used for the purpose of WDCEE's payment platform integration
    only. It explicitly is not part of the general contract between WDCEE
    and it's customer. The plugin has successfully been tested under
    specific circumstances which are defined as the shopsystem's standard
    configuration (vendor's delivery state). The Customer is responsible for
    testing the plugin's functionality before putting it into production
    enviroment.
    The customer uses the plugin at own risk. WDCEE does not guarantee it's
    full functionality neither does WDCEE assume liability for any
    disadvantage related to the use of this plugin. By installing the plugin
    into the shopsystem the customer agrees to the terms of use. Please do
    not use this plugin if you do not agree to the terms of use!
*/

  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE','wirecard_checkout_page_transaction');
  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_RETURN', 'callback/wirecard/checkout_page_return.php');
  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRM', 'callback/wirecard/checkout_page_confirm.php');
  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INITIATION_URL','https://checkout.wirecard.com/page/init.php');
  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INIT_SERVER_URL', 'https://checkout.wirecard.com/page/init-server.php');
  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TOOLKIT_URL','https://checkout.wirecard.com/page/toolkit.php'); 
  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_REDIRECT','checkout_wirecard_checkout_page.php');
  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IFRAME','wirecard_checkout_page_iframe.php');
  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGINVERSION', '1.10.0');
  define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGINNAME', 'xtCommerce3');
  define('MODULE_PAYMENT_WIRECARD_REDIRECT_TIMEOUT_SECOUNDS', 2);
  
class wirecard_checkout_page {
    var $code, $title, $description, $enabled, $transaction_id;

    var $customerIdDemoMode = 'D200001';
    var $customerIdTestMode = 'D200411';
    var $secretDemoMode = 'B8AKTPWBRMNBV455FG6M2DANE99WU2';
    var $secretTestMode = 'CHCSH7UGHVVX2P7EHDHSY4T2S4CGYK4QBE4M5YUUG2ND5BEZWNRZW5EJYVJQ';
    var $toolkitPasswordTestMode = 'jcv45z';
    var $toolkitPasswordDemoMode = 'jcv45z';
	
	var $customerStatementLength = 23; //9x prefix, 1x whitespace, 1x id: char, 10x OrderID
		
    /**
     * confirmation debug-log.
     * Use this for debug useage only!
     * @param $message
     */
    function debug_log( $message )
    {
        file_put_contents('wirecard_checkout_page_notify_debug.txt', date('Y-m-d H:i:s') . ' ' . $message . "\n", FILE_APPEND);
    }

    // class constructor
    function wirecard_checkout_page()
    {
        global $order, $language;

		$configExportUrl      = constant(strtoupper($_SERVER['REQUEST_SCHEME']).'_SERVER').DIR_WS_ADMIN.'wcp_config_export.php';

        $this->code           = 'wirecard_checkout_page';
        $this->title          = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_TITLE;
        $this->description    = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DESCRIPTION;
		
		if(strpos($_SERVER['REQUEST_URI'], 'admin/modules.php') !== false && $this->_isInstalled($c)) {
            $this->description .= '<br/><a href="'.$configExportUrl.'" class="button" style="margin: auto; ">'.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_EXPORT_CONFIG_LABEL.'</a>';
        }
		
        $this->displaytext    = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT;
        $this->sort_order     = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SORT_ORDER;
        $this->enabled        = ((MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS == 'True') ? true : false);

        $this->transaction_id = '';

        if ((int)MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_ID > 0)
        {
            $this->order_status = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_ID;
        }

        if ((int)MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID > 0)
        {
            $this->order_status_pending = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID;
        } else {
            $this->order_status_pending = 1;
        }

        if (is_object($order))
        {
            $this->update_status();
        }
		
		$this->form_action_url = 'checkout_process.php';
    }

	
	/// @brief collect data and create a array with wirecard checkout page infos
    function get_order_post_variables_array() {
		global $order, $order_total_modules, $currency, $xtPrice, $session_started, $insert_id;

        $qLanguage = $_SESSION['language_code'];

        if ($qLanguage == "us")
        {
            $qLanguage = "en";
        }

        $qCurrency = $order->info['currency'];

        $this->transaction_id = $this->generate_trid();

        // construct the orderDescription -> displayed within Payment Center
        // substitute some special characters
        $orderDescription = $this->transaction_id . ' - ' .
                          $order->customer['firstname'] . ' ' .
                          $order->customer['lastname'];

        // construct the amount value
        $total = $order->info['total'];
        if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1)
        {
            $total += $order->info['tax'];
        }
        $amount = round($xtPrice->xtcCalculateCurrEx($total,$qCurrency), $xtPrice->get_decimal_places($qCurrency));

        // construct the returnUrl. we will use one url for all types of return (success, cancel, failure)
        // FILENAME_CHECKOUT_PROCESS
        $returnUrl = xtc_href_link(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_RETURN, '', 'SSL', true, false);
        $confirmUrl = xtc_href_link(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRM, 'confirm=true', 'SSL', true, false);

		require_once('includes/classes/wcp_mobile_detect.php');
        // construct the real payment type. if subtype is submittet via post, we have to use them

        $paymentType = (isset($_SESSION['wirecard_checkout_page']['payMethod'])) ? $_SESSION['wirecard_checkout_page']['payMethod'] : "SELECT";
        $shopVersion = PROJECT_VERSION;
        // pluginVersion = base64(Shopname; Shopversion; Lib-Dependency; Pluginname; Pluginversion)
        $pluginVersion =  base64_encode('xtCommerce3;' . $shopVersion . ';mobile detect '.WirecardCEE_MobileDetect::VERSION.';xtCommerce3;'. MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGINVERSION);

        //add consumerInformation for address verification.
        if(xtc_session_is_registered('customer_id'))
        {
            $consumerID = $_SESSION['customer_id'];
        }
        else
        {
            $consumerID = '';
        }
        $deliveryInformation = $order->delivery;
        if($deliveryInformation['country']['iso_code_2'] == 'US' || $deliveryInformation['country']['iso_code_2'] == 'CA')
        {
            $deliveryState = $this->_getZoneCodeByName($deliveryInformation['state']);
        }
        else
        {
            $deliveryState = $deliveryInformation['state'];
        }
        $billingInformation  = $order->billing;
        if($billingInformation['country']['iso_code_2'] == 'US' || $billingInformation['country']['iso_code_2'] == 'CA')
        {
            $billingState = $this->_getZoneCodeByName($billingInformation['state']);
        }
        else
        {
            $billingState = $billingInformation['state'];
        }

        $sql = 'SELECT customers_dob, customers_vat_id, customers_fax FROM ' . TABLE_CUSTOMERS .' WHERE customers_id="' . xtc_db_input($consumerID) . '" LIMIT 1;';
        $result = xtc_db_query($sql);
        $consumerInformation = mysql_fetch_assoc($result);
		$consumerBirthDate = '';
		$customers_vat_id = '';
		
        if($consumerInformation['customers_dob'] != '0000-00-00 00:00:00')
        {
            $consumerBirthDateTimestamp = strtotime($consumerInformation['customers_dob']);
            $consumerBirthDate = date('Y-m-d', $consumerBirthDateTimestamp);
        }
	
        if(!empty($consumerInformation['customers_vat_id'])) {
			$customers_vat_id = $consumerInformation['customers_vat_id']; 
		}

        $orderReference = str_pad($insert_id,'10','0',STR_PAD_LEFT);
		$customerStatementString = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT.' id:'.$orderReference;
		$customerStatementLength = ($paymentType != 'POLI') ? $this->customerStatementLength : 9;
		
		if($paymentType == 'POLI') 
			$customerStatementString = substr(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT,0,9);
		elseif(strlen($orderReference) > $customerStatementLength) 
			$customerStatementString = substr($orderReference,-$customerStatementLength);
		elseif(strlen($customerStatementString) > $customerStatementLength)
			$customerStatementString = substr(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT,0,$customerStatementLength-14).' id:'.$orderReference;

		
		switch(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE) {
            case 'Demo':
                $preshared_key = $this->secretDemoMode;
                $customerId = $this->customerIdDemoMode;
                break;
            case 'Test':
                $preshared_key = $this->secretTestMode;
                $customerId = $this->customerIdTestMode;
                break;
            case 'Live':
            default:
                $preshared_key = trim(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET);
                $customerId = trim(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMERID);
                break;
        }

        $postData = Array('customerId'                   => $customerId,
                          'language'                     => $qLanguage,
                          'paymentType'                  => $paymentType,
                          'amount'                       => $amount,
                          'currency'                     => $qCurrency,
                          'orderDescription'             => $orderDescription,
						  'successURL'            		=> xtc_href_link('callback/wirecard/checkout_page_callback.php', '', 'SSL'),
						  'cancelURL'             		=> xtc_href_link('callback/wirecard/checkout_page_callback.php', 'cancel=1', 'SSL'),
						  'failureURL'            		=> xtc_href_link('callback/wirecard/checkout_page_callback.php', 'failure=1', 'SSL'),
                          'serviceURL'                   => MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SERVICEURL,
						  
						  'confirmURL'            		=> xtc_href_link('callback/wirecard/checkout_page_confirm.php', '', 'SSL', false),
                          'consumerIpAddress'            => $_SERVER['REMOTE_ADDR'],
                          'consumerUserAgent'            => $_SERVER['HTTP_USER_AGENT'],

						  'pendingURL'            		=> xtc_href_link('callback/wirecard/checkout_page_callback.php', 'pending=1', 'SSL'),
                          'duplicateRequestCheck'       => (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DUPLICATE_REQUEST_CHECK == 'True') ? 'yes' : 'no',

						  'orderReference'        		 => $orderReference,
 			              'customerStatement'            => trim($customerStatementString),
			  
			              'displayText'                  => $this->displaytext,
                          'imageURL'                     => MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IMAGEURL,
						  
                          'autoDeposit'                  => (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_AUTO_DEPOSIT == 'True') ? 'yes' : 'no',
                          'confirmMail'                  => MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRMATION_MAIL,
                          'maxRetries'                   => MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_MAX_RETRIES,
                          'paymenttypeSortOrder'         => MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENTTYPE_SORT_ORDER,

                          'shopId'                       => MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOPID,
						  
 						  'order_id'        		     => $insert_id,
                          'trid'                         => $this->transaction_id,
                          'pluginVersion'                => $pluginVersion,
                          'consumerMerchantCrmId'        => md5($order->customer['email_address']),
						 );
						
						  

						
        if(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CUSTOMER_DATA == 'True') {
						
            $postData['companyName']               = $billingInformation['company'];
            $postData['companyVatId']              = $customers_vat_id;
						  
            $postData['consumerShippingFirstName'] = $deliveryInformation['firstname'];
            $postData['consumerShippingLastName']  = $deliveryInformation['lastname'];
            $postData['consumerShippingAddress1']  = $deliveryInformation['street_address'];
            $postData['consumerShippingAddress2']  = $deliveryInformation['suburb'];
            $postData['consumerShippingCity']      = $deliveryInformation['city'];
            $postData['consumerShippingZipCode']   = $deliveryInformation['postcode'];
            $postData['consumerShippingState']     = $deliveryState;
            $postData['consumerShippingCountry']   = $deliveryInformation['country']['iso_code_2'];
            $postData['consumerShippingPhone']     = $order->customer['telephone'];

            $postData['consumerBillingFirstName']  = $billingInformation['firstname'];
            $postData['consumerBillingLastName']   = $billingInformation['lastname'];
            $postData['consumerBillingAddress1']   = $billingInformation['street_address'];
            $postData['consumerBillingAddress2']   = $billingInformation['suburb'];
            $postData['consumerBillingCity']       = $billingInformation['city'];
            $postData['consumerBillingZipCode']    = $billingInformation['postcode'];
            $postData['consumerBillingState']      = $billingState;
            $postData['consumerBillingCountry']    = $billingInformation['country']['iso_code_2'];
            $postData['consumerBillingPhone']      = $order->customer['telephone'];
            $postData['consumerEmail']             = $order->customer['email_address'];
            $postData['consumerBirthDate']         = $consumerBirthDate;
		}
		 elseif(in_array($paymentType, array('INVOICE', 'INSTALLMENT'))) {
		    $postData['companyName']               = $billingInformation['company'];
            $postData['companyVatId']              = $customers_vat_id;

            $postData['consumerBillingFirstName']  = $billingInformation['firstname'];
            $postData['consumerBillingLastName']   = $billingInformation['lastname'];
            $postData['consumerBillingAddress1']   = $billingInformation['street_address'];
            $postData['consumerBillingAddress2']   = $billingInformation['suburb'];
            $postData['consumerBillingCity']       = $billingInformation['city'];
            $postData['consumerBillingZipCode']    = $billingInformation['postcode'];
            $postData['consumerBillingState']      = $billingState;
            $postData['consumerBillingCountry']    = $billingInformation['country']['iso_code_2'];
            $postData['consumerBillingPhone']      = $order->customer['telephone'];
            $postData['consumerEmail']             = $order->customer['email_address'];
            $postData['consumerBirthDate']         = $consumerBirthDate;
	    }

		if(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CART_DATA == 'True') {
            $basketAmount = 0;
            $basketCurrency = $qCurrency;
            $basketItemsCount = 0;	
				
		    foreach ($_SESSION['cart']->contents as $productId=>$quantityArray) {
				$result = xtc_db_query("SELECT p.products_tax_class_id,p.products_price,d.products_name FROM ".TABLE_PRODUCTS." as p JOIN ".TABLE_PRODUCTS_DESCRIPTION." as d ON p.products_id = d.products_id WHERE p.products_id = '" . xtc_db_input($productId) . "'");
				$product = xtc_db_fetch_array($result);

                $basketItemsCount++;
				$basketAmount += ($product['products_price'] * $quantityArray['qty']);

				$tax_rate = $xtPrice->TAX[$product['products_tax_class_id']];
				
				if(PRICE_IS_BRUTTO) {
					$price = $product['products_price'];
					$tax = $product['products_price']/100 * $tax_rate;
				}
				else {
					$price = ($product['products_price'] / (100+$tax_rate)) * 100;
					$tax = ($product['products_price'] / (100+$tax_rate)) * $tax_rate;
				}
				
                $postData['basketItem'.$basketItemsCount.'ArticleNumber'] = $productId;
                $postData['basketItem'.$basketItemsCount.'Description'] = $product['products_name'];
                $postData['basketItem'.$basketItemsCount.'Quantity'] = $quantityArray['qty'];
                $postData['basketItem'.$basketItemsCount.'Tax'] = number_format($tax,2);
                $postData['basketItem'.$basketItemsCount.'UnitPrice'] = number_format($price,2);
		    }
			
            $postData['basketAmount'] = number_format($basketAmount,2);
            $postData['basketCurrency'] = $basketCurrency;
            $postData['basketItems'] = $basketItemsCount;
        }
	   
		// set layout if isset
        if(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DEVICE_DETECTION == 'True')
            $postData['layout'] = $this->_getClientDevice();

		
		$postData = array_map('utf8_encode',$postData);
		
        $requestFingerprintOrder = 'secret';
        $tempArray = array('secret' => $preshared_key);
        foreach($postData AS $parameterName => $parameterValue)
        {
            $requestFingerprintOrder .= ','.$parameterName;
            $tempArray[(string)$parameterName] = (string)$parameterValue;
        }
		
        $requestFingerprintOrder .= ',requestFingerprintOrder';
        $tempArray['requestFingerprintOrder'] = $requestFingerprintOrder;

        $hash = hash_init('sha512', HASH_HMAC, $preshared_key);
        foreach ($tempArray as $key => $value) {
            hash_update($hash, $value);
        }
        $postData['requestFingerprintOrder'] = $requestFingerprintOrder;
        $postData['requestFingerprint'] = hash_final($hash);

        xtc_db_query("INSERT INTO " . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE . " (TRID, PAYSYS, DATE, ORDERID) VALUES ('" . $this->transaction_id . "', '" . $paymentType . "', NOW(), ".$insert_id.")");

        return $postData;
    }
	
	
	/// @brief nothing to do for update_status
    function update_status() {
        return true;
    }

    /// @brief decorate process button
    function process_button() {
		if(isset($_POST["wirecard_checkout_page"])) {
			$_SESSION['wirecard_checkout_page']['payMethod'] = $_POST["wirecard_checkout_page"];
		}

		if(('INVOICE' === $_SESSION['wirecard_checkout_page']['payMethod'] || 'INSTALLMENT' === $_SESSION['wirecard_checkout_page']['payMethod'])&& isset($_POST["customers_dob"])) {
			if (checkdate(substr(xtc_date_raw($_POST["customers_dob"]), 4, 2), substr(xtc_date_raw($_POST["customers_dob"]), 6, 2), substr(xtc_date_raw($_POST["customers_dob"]), 0, 4)))
			{
				$_SESSION['wirecard_checkout_page']['customers_dob'] = $_POST["customers_dob"];
				$consumerID = xtc_session_is_registered('customer_id') ? $_SESSION['customer_id'] : "";
				$sql = 'UPDATE ' . TABLE_CUSTOMERS .' SET customers_dob = "'.xtc_db_prepare_input($_POST["customers_dob"]).'" WHERE customers_id="' . xtc_db_input($consumerID) . '"';

				$result = mysql_fetch_assoc(xtc_db_query($sql));
			}
			else {
				xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(ENTRY_DATE_OF_BIRTH_ERROR), 'SSL'));
			}
		}
		if(('INVOICE' === $_SESSION['wirecard_checkout_page']['payMethod']) && isset($_POST["customers_vat_id"]) && $this->_customerIsMerchant()) {
			if(!empty($_POST["customers_vat_id"])) {
				$consumerID = xtc_session_is_registered('customer_id') ? $_SESSION['customer_id'] : "";
				$sql = 'UPDATE ' . TABLE_CUSTOMERS .' SET customers_vat_id = "'.xtc_db_prepare_input($_POST["customers_vat_id"]).'" WHERE customers_id="' . xtc_db_input($consumerID) . '"';

				$result = mysql_fetch_assoc(xtc_db_query($sql));
			}
			else
				xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ENTRY_VAT_ERROR), 'SSL'));
		}    
			
		if('INVOICE' === $_SESSION['wirecard_checkout_page']['payMethod'] && MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT == 'True' && (!isset($_POST['wcp_accepted_payolution_terms_invoice']) || $_POST['wcp_accepted_payolution_terms_invoice'] != 1)) {
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_ACCEPT_TERMS), 'SSL'));
		}	
				
		if('INSTALLMENT' === $_SESSION['wirecard_checkout_page']['payMethod'] && MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT == 'True' && (!isset($_POST['wcp_accepted_payolution_terms_installment']) || $_POST['wcp_accepted_payolution_terms_installment'] != 1)) {
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_ACCEPT_TERMS), 'SSL'));
		}	

		//check if paymethod is allowed
		if('INVOICE' === $_SESSION['wirecard_checkout_page']['payMethod'] && !$this->_preInvoiceCheck()) {
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMETHOD_NOT_ALLOWED), 'SSL'));
		}
		
		if('INSTALLMENT' === $_SESSION['wirecard_checkout_page']['payMethod'] && !$this->_preInstallmentCheck()) {
			xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMETHOD_NOT_ALLOWED), 'SSL'));
		}	
	}

    /// @brief unset temp order id from session
    function before_process() {
        if(isset($_SESSION['tmp_oID'])) {
            $_SESSION['wirecard_checkout_page']['tmp_oID'] = $_SESSION['tmp_oID'];
        }

        unset($_SESSION['tmp_oID']);
        $this->tmpOrders = true;
        return true;
    }
	
	
	/// @brief finalize payment after order is created
    function payment_action() {
		global $insert_id;
		
        $response = array();

		if($_SESSION['wirecard_checkout_page']['tmp_oID']) {
		    xtc_db_query('INSERT INTO '.TABLE_ORDERS_STATUS_HISTORY.'
             (orders_id, date_added, customer_notified, comments)
             VALUES
               ('. (int)$_SESSION['wirecard_checkout_page']['tmp_oID'].', NOW(), "0", "'.xtc_db_input(sprintf(MODULE_PAYMENT_WCP_ANOTHER_ORDER, $insert_id)) . '")');
			   
            unset($_SESSION['wirecard_checkout_page']['tmp_oID']);
        }
		
        include(DIR_FS_CATALOG.'lang/'.$_SESSION['language'].'/modules/payment/wirecard_checkout_page.php');

        //perform init request and get redirect URL
        $content = http_build_query($this->get_order_post_variables_array());
        $header = "Host: checkout.wirecard.com\r\n"
            . "User-Agent: " . $_SERVER["HTTP_USER_AGENT"] . "\r\n"
            . "Content-Type: application/x-www-form-urlencoded\r\n"
            . "Content-Length: " . strlen($content) . "\r\n"
            . "Connection: close\r\n";

        $options = array(
            'http' => array(
                'header'  => $header,
                'method'  => 'POST',
                'content' => $content,
            )
        );

        $context = stream_context_create($options);

        if (!$result = file_get_contents(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INIT_SERVER_URL, false, $context)) {
            $response["message"] = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_COMMUNICATION_ERROR;
        } else {
            parse_str($result, $response);
        }

        //redirect user
        if(isset($response["redirectUrl"])) {
            //update order status
            xtc_db_query("update " . TABLE_ORDERS . " set orders_status = '" . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID . "', last_modified = now() where orders_id = '" . (int)$_SESSION['tmp_oID'] . "'");

            //always use redirect for PayPal and Sofortueberweisung
            switch($_SESSION['wirecard_checkout_page']['payMethod']) {
                case 'PAYPAL':
                case 'SOFORTUEBERWEISUNG': $useIFrame = 'False'; break;
                default: $useIFrame = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_USE_IFRAME;
            }

            if($useIFrame == 'False') {
                header("Location: " . $response["redirectUrl"]);
            }
            else {
                $timeout = MODULE_PAYMENT_WIRECARD_REDIRECT_TIMEOUT_SECOUNDS*1000;
                $disableTimeout = $timeout-50;
                $reEnableTimeout = $timeout*5;

                // redirect
                $process_form = '<form name="wcp_process_form" id="wcp_process_form" method="POST" action="'.($response["redirectUrl"]).'" >';

                $process_js = '<script type="text/javascript">
                            setTimeout("var element = document.getElementById(\"wcp_continue_button\");element.style.display = \'none\';",'. $disableTimeout .');
                            setTimeout("document.wcp_process_form.submit();",'.$timeout.');
                            setTimeout("var element = document.getElementById(\"wcp_continue_button\");element.style.display = \'block\';",'. $reEnableTimeout .');
                       </script>';

                $translation = array(
                    'title'   => MODULE_PAYMENT_WCP_CHECKOUT_TITLE,
                    'header'  => MODULE_PAYMENT_WCP_CHECKOUT_HEADER,
                    'content' => MODULE_PAYMENT_WCP_CHECKOUT_CONTENT
                );

                $_SESSION['wirecard_checkout_page']['useIFrame'] = $useIFrame;
                $_SESSION['wirecard_checkout_page']['process_form'] = $process_form;
                $_SESSION['wirecard_checkout_page']['process_js'] = $process_js;
                $_SESSION['wirecard_checkout_page']['translation'] = $translation;

                xtc_redirect(xtc_href_link('checkout_wirecard_checkout_page.php', '', 'SSL'));
                die();
            }
        } else {
            //finalize order
            $this->xtc_remove_order($_SESSION['tmp_oID'], true);
            unset($_SESSION['tmp_oID']);

            //redirect user and show error message
            xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'error_message='.urlencode($response["message"]), 'SSL'));
        }
    }
	
	
	    /// @brief nothing to do
    function after_process()
    {
        return true;
    }

    // class methods
    function javascript_validation()
    {
        return false;
    }

    function selection()
    {
		global $order;
		
        if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SELECT == 'True')
        {
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TEXT == '')
            {
                return array('id' => $this->code,
                             'module' => $this->title);
            }
            else
            {
                return array('id' => $this->code,
                             'module' => $this->title,
                             'fields' => array(array('title' => '', 'field' => MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TEXT)));
            }
        }
        else
        {
            // we have to use a JavaScript helper function to select the main-payment type if a sub type was selected
            $subTypes = array();
            $jsHelper = 'onClick="for (var i = 0; i < document.forms.length; i++){var form = document.forms[i];for (var j = 0; j < form.elements.length; j++){var element = form.elements[j];if (element.value ==  \'' . $this->code . '\' && element.type == \'radio\'){element.checked = true; break;}}}"';
			
			$jsFunctions = '
			<script>
			 function addDobField(elemId) {
										if(document.getElementById(elemId + \'customers_dob\') === null) {	
											var tr = document.createElement(\'tr\');
											var td1 = tr.appendChild(document.createElement(\'td\'));
											var td2 = tr.appendChild(document.createElement(\'td\'));
											td2.id = elemId + \'customers_dob\';
											td2.innerHTML = \''.MODULE_PAYMENT_WCP_DATE_OF_BIRTH_TEXT.'\';
											td2.width = \'100px\';

											var td3 = tr.appendChild(document.createElement(\'td\'));
											var inputDob = document.createElement(\'input\')
											inputDob.maxlength = 10;
											inputDob.name = \'customers_dob\';
											td3.appendChild(inputDob);
											document.getElementById(elemId).appendChild(tr);
										}
									}
			function addVatIdField(elemId) {
										if(document.getElementById(elemId + \'customers_vat_id\') === null) {	
											var tr = document.createElement(\'tr\');
											var td1 = tr.appendChild(document.createElement(\'td\'));
											var td2 = tr.appendChild(document.createElement(\'td\'));
											td2.id = elemId + \'customers_vat_id\';
											td2.width = \'100px\';
											td2.innerHTML = \''.MODULE_PAYMENT_WCP_ENTRY_VAT_ID.'\';

											var td3 = tr.appendChild(document.createElement(\'td\'));
											var inputDob = document.createElement(\'input\')
											inputDob.name = \'customers_vat_id\';
											td3.appendChild(inputDob);
											document.getElementById(elemId).appendChild(tr);
										}
									}
			 </script>';

			$payolutionAdditonalInfoText = '';
			if(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT == 'True') {
				$payolutionAdditonalInfoTextInstallment = xtc_draw_checkbox_field('wcp_accepted_payolution_terms_installment', '1').' '.sprintf(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TEXT_INSTALLMENT,'https://payment.payolution.com/payolution-payment/infoport/dataprivacyconsent?mId='.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_MID);
				$payolutionAdditonalInfoTextInvoice = xtc_draw_checkbox_field('wcp_accepted_payolution_terms_invoice', '1').' '.sprintf(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TEXT_INVOICE,'https://payment.payolution.com/payolution-payment/infoport/dataprivacyconsent?mId='.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_MID);
			}
  
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'CCARD', (('CCARD' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/maestro_secure_code.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO_TEXT);
            }

			if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD == 'True')
            {
				
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'CCARD', (('CCARD' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/ccard.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_TEXT);
            }
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO == 'True')
            {
				if($this->_preCc_MotoCheck()) {
					$subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'CCARD-MOTO', (('CCARD-MOTO' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
										'field' => xtc_image(DIR_WS_ICONS.'/wcp/ccard_moto.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO_TEXT);
				}
            }
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'EPS', (('EPS' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/eps-online-ueberweisung.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS_TEXT);
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'IDL', (('IDL' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/ideal.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL_TEXT);
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'GIROPAY', (('GIROPAY' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/giropay.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP_TEXT);
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'TATRAPAY', (('TATRAPAY' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/tatrapay.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY_TEXT);
            }
			
			if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY == 'True')
            {
                 $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'TRUSTPAY', (('TRUSTPAY' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/trustpay.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY_TEXT);
            }
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'SOFORTUEBERWEISUNG', (('SOFORTUEBERWEISUNG' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/sofort_ueberweisung.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE_TEXT);
            }

			if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'SKRILLDIRECT', (('SKRILLDIRECT' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/skrill_direct.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT_TEXT);
            }
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'SKRILLWALLET', (('SKRILLWALLET' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/skrill_digital_wallet.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET_TEXT);
            }
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'MPASS', (('MPASS' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/mpass.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS_TEXT);
            }
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'BANCONTACT_MISTERCASH', (('BANCONTACT_MISTERCASH' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/bancontact_mistercash.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC_TEXT);
            }

		    if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24 == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'PRZELEWY24', (('PRZELEWY24' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/p24.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24_TEXT);
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'MONETA', (('MONETA' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/moneta_ru.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_TEXT);
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'POLI', (('POLI' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/poli.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_TEXT);
            }
			
			if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'EKONTO', (('EKONTO' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/ekonto.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_TEXT);
            }
			
			if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'TRUSTLY', (('TRUSTLY' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/trustly.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_TEXT);
            }
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'PBX', (('PBX' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/paybox.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX_TEXT);
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'PSC', (('PSC' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/paysafecard_mypaysafecard.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC_TEXT);
            }		
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'QUICK', (('QUICK' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/quick.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK_TEXT);
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'PAYPAL', (('PAYPAL' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/paypal.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL_TEXT);
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'EPAY_BG', (('EPAY_BG' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/epay.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG_TEXT);
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'SEPA-DD', (('SEPA-DD' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
                                    'field' => xtc_image(DIR_WS_ICONS.'/wcp/sepa.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD_TEXT);
            }
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE == 'True')
            {
				$jsHelperInvoice = '';
				if(!$this->_getCustomersDob()) {
					$jsHelperInvoice .= "addDobField('WCP-INVOICE-TABLE');";
				}
				if(!$this->_getCustomersVatId() && $this->_customerIsMerchant()) {
					$jsHelperInvoice .= "addVatIdField('WCP-INVOICE-TABLE');";
				}
								
				$includeJs = '';
				//if payment is already selected add fields on page load
				if('INVOICE' === $_SESSION['wirecard_checkout_page']['payMethod'] && !empty($jsHelperInvoice)) {
					$includeJs = '<script>window.onload = function() {'.$jsHelperInvoice.'}</script>';
				}

				if(!empty($jsHelperInvoice))
					$jsHelperInvoice = substr($jsHelper,0,-1).$jsHelperInvoice.'"';
				else
					$jsHelperInvoice = $jsHelper;

                if($this->_preInvoiceCheck()) {
                    $subTypes[] = array('title' => $includeJs.xtc_draw_radio_field('wirecard_checkout_page', 'INVOICE', (('INVOICE' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelperInvoice),
										'field' => '<table id="WCP-INVOICE-TABLE">
										<tr><td>'.xtc_image(DIR_WS_ICONS.'/wcp/invoice.jpg').'</td><td colspan="2">'.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_TEXT.'</td></tr>
										<tr><td></td><td colspan="2">'.$payolutionAdditonalInfoTextInvoice.'</td></tr>
										</table>');

				}
            }
			
            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT == 'True')
            {
				$jsHelperInstallment = '';
				if(!$this->_getCustomersDob()) {
					$jsHelperInstallment .= "addDobField('WCP-INSTALLMENT-TABLE');";
				}

				$includeJs = '';
				//if payment is already selected add fields on page load
				if('INSTALLMENT' === $_SESSION['wirecard_checkout_page']['payMethod'] && !empty($jsHelperInstallment)) {
					$includeJs = '<script>window.onload = function() {'.$jsHelperInstallment.'}</script>';
				}				
				
				if(!empty($jsHelperInstallment))
					$jsHelperInstallment = substr($jsHelper,0,-1).$jsHelperInstallment.'"';
				else
					$jsHelperInstallment = $jsHelper;
			
                if($this->_preInstallmentCheck()) {
                    $subTypes[] = array('title' => $includeJs.xtc_draw_radio_field('wirecard_checkout_page', 'INSTALLMENT', (('INSTALLMENT' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelperInstallment),
										'field' => '<table id="WCP-INSTALLMENT-TABLE">
										<tr><td>'.xtc_image(DIR_WS_ICONS.'/wcp/installment.jpg').'</td><td colspan="2">'.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_TEXT.'</td></tr>
										<tr><td></td><td colspan="2">'.$payolutionAdditonalInfoTextInstallment.'</td></tr>
										</table>');
                }
            }

            if (MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER == 'True')
            {
                $subTypes[] = array('title' => xtc_draw_radio_field('wirecard_checkout_page', 'VOUCHER', (('VOUCHER' === $_SESSION['wirecard_checkout_page']['payMethod']) ? true : false), $jsHelper),
									'field' => xtc_image(DIR_WS_ICONS.'/wcp/myVoucher.jpg').' '.MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER_TEXT);
            }


			//add js functions
			if($subTypes[0]) {
				$subTypes[0]['title'] = $jsFunctions.$subTypes[0]['title'];
			}
			
            return array('id' => $this->code,
                         'module' => $this->title,
                         'fields' => $subTypes);
        }
    }

    /*
     * @return bool
     */
    function _preInvoiceCheck() {
        global $order, $customer, $xtPrice;

        $currency = $order->info['currency'];
        $total = $order->info['total'];
        $amount = round($xtPrice->xtcCalculateCurrEx($total,$currency), $xtPrice->get_decimal_places($currency));
        
        $country_code = $order->billing['country']['iso_code_2'];    
		$invoice_min_amount = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MIN_AMOUNT;
		$invoice_max_amount = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MAX_AMOUNT;		
		//check if age is already available
		//send true if no age is available, then show age field in payment selection form
		if($this->_getCustomersDob()) {
			$ageCheck = $this->_preAgeCheck();
		}
		else {
			$ageCheck = true;
		}
        return ($ageCheck && 
		(($amount >= $invoice_min_amount || empty($invoice_min_amount)) && ($amount <= $invoice_max_amount || ((empty($invoice_max_amount) && $invoice_max_amount !== "0")))) &&
        ($currency == 'EUR') &&
        (in_array($country_code, Array('AT', 'DE', 'CH'))) &&
        ($order->delivery === $order->billing));
    }

    /*
     * @return bool
     */
    function _preInstallmentCheck() {
        global $order, $customer, $xtPrice;

        $currency = $order->info['currency'];
        $total = $order->info['total'];
        $amount = round($xtPrice->xtcCalculateCurrEx($total,$currency), $xtPrice->get_decimal_places($currency));

        $country_code = $order->billing['country']['iso_code_2'];
		$installment_min_amount = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MIN_AMOUNT;
		$installment_max_amount = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MAX_AMOUNT;		
		//check if age is already available
		//send true if no age is available, then show age field in payment selection form
		if($this->_getCustomersDob()) {
			$ageCheck = $this->_preAgeCheck();
		}
		else {
			$ageCheck = true;
		}
        return ($ageCheck && 
		    (($amount >= $installment_min_amount || empty($installment_min_amount)) && ($amount <= $installment_max_amount || ((empty($installment_max_amount) && $installment_max_amount !== "0")))) &&
            ($currency == 'EUR') &&
            (in_array($country_code, Array('AT', 'DE', 'CH'))) &&
            ($order->delivery === $order->billing));
    }

	/*
     * @return bool
     */
    function _preAgeCheck() {
		
        $consumerID = xtc_session_is_registered('customer_id') ? $_SESSION['customer_id'] : "";
		$sql = 'SELECT (COUNT(*) > 0) as cnt FROM ' . TABLE_CUSTOMERS .' WHERE DATEDIFF(NOW(), customers_dob) > 6574 AND customers_id="' . xtc_db_input($consumerID) . '"';
        $result = mysql_fetch_assoc(xtc_db_query($sql));

        $ageCheck = (bool) $result['cnt'];

        return ($ageCheck);
    }
	
    /*
     * @return bool
     */
    function _preCc_MotoCheck() {
        return ($_SESSION['customers_status']['customers_status_id'] == DEFAULT_CUSTOMERS_STATUS_ID_ADMIN);
    }
	
	
	/*
     * @return String
     */
    function _getCustomersDob() {
		$consumerID = xtc_session_is_registered('customer_id') ? $_SESSION['customer_id'] : "";
		$sql = 'SELECT customers_dob FROM ' . TABLE_CUSTOMERS .' WHERE customers_id="' . xtc_db_input($consumerID) . '"';

        $result = mysql_fetch_assoc(xtc_db_query($sql));

		if($result['customers_dob'] !== '0000-00-00 00:00:00')
			return $result['customers_dob'];

		return null;
    }
	
	/*
     * @return bool
     */
    function _getCustomersVatId() {
		$consumerID = xtc_session_is_registered('customer_id') ? $_SESSION['customer_id'] : "";
		$sql = 'SELECT customers_vat_id FROM ' . TABLE_CUSTOMERS .' WHERE customers_id="' . xtc_db_input($consumerID) . '"';

        $result = mysql_fetch_assoc(xtc_db_query($sql));

		if(!empty($result['customers_vat_id']))
			return $result['customers_vat_id'];

		return null;
    }
	
	function _customerIsMerchant() {
		$customersStatusId = xtc_session_is_registered('customers_status') ? $_SESSION['customers_status']['customers_status_id'] : "";
		
		if(3 == $customersStatusId)
			return true;

		return false;
    }
	
    function pre_confirmation_check()
    {
        return false;
    }

    function confirmation()
    {
        return false;
    }

    function check()
    {
        if (!isset($this->_check))
        {
            $check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS'");
            $this->_check = xtc_db_num_rows($check_query);
        }
        return $this->_check;
    }

    function install()
    {
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS', 'True', '6', '0', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE', 'Demo', '6', '1', 'xtc_cfg_select_option(array(\'Demo\', \'Test\', \'Live\'),', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMERID', '$this->customerIdDemoMode', '6', '2', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET', '$this->secretDemoMode', '6', '3', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOPID', '', '6', '5', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_USE_IFRAME', 'True', '6', '6', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SELECT', 'True', '6', '7', 'xtc_cfg_select_option(array(\'True\', \'False\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TEXT', 'Select your pament method', '6', '6', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD', 'False', '6', '202', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO', 'False', '6', '204', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS', 'False', '6', '206', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL', 'False', '6', '208', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP', 'False', '6', '210', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY', 'False', '6', '211', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY', 'False', '6', '212', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE', 'False', '6', '213', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX', 'False', '6', '214', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC', 'False', '6', '216', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK', 'False', '6', '218', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL', 'False', '6', '220', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG', 'False', '6', '221', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD', 'False', '6', '222', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE', 'False', '6', '228', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO', 'False', '6', '230', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC', 'False', '6', '232', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO', 'False', '6', '234', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT', 'False', '6', '236', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY', 'False', '6', '238', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA', 'False', '6', '240', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24', 'False', '6', '242', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI', 'False', '6', '244', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS', 'False', '6', '246', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT', 'False', '6', '248', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET', 'False', '6', '250', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER', 'False', '6', '253', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SERVICEURL', '', '6', '300', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IMAGEURL', '', '6', '301', now())");
        
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MIN_AMOUNT', '100', '6', '310', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MAX_AMOUNT', '10000', '6', '311', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MIN_AMOUNT', '100', '6', '320', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MAX_AMOUNT', '10000', '6', '321', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT', '', '6', '330', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT', '', '6', '331', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CUSTOMER_DATA', 'True', '6', '332', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CART_DATA', 'True', '6', '333', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SORT_ORDER', '0', '6', '400', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ZONE', '0', '6', '410', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_ID', '1', '6', '420', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, use_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID', '1', '6', '430', 'xtc_cfg_pull_down_order_statuses(', 'xtc_get_order_status_name', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DEVICE_DETECTION', 'False', '6', '331', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT', 'False', '6', '332', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_MID', '', '6', '333', now())");

        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DUPLICATE_REQUEST_CHECK', 'False', '6', '340', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_AUTO_DEPOSIT', 'False', '6', '341', 'xtc_cfg_select_option(array(\'False\', \'True\'), ', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRMATION_MAIL', '', '6', '342', '', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_MAX_RETRIES', '', '6', '343', '', now())");
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENTTYPE_SORT_ORDER', '', '6', '344', '', now())");

		
		
        xtc_db_query("insert into " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) values ('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ALLOWED', '', '6', '0', now())");
        xtc_db_query("CREATE TABLE IF NOT EXISTS `".MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE."` (
                        `TRID` varchar(255) NOT NULL default '',
                        `DATE` datetime NOT NULL default '0000-00-00 00:00:00',
                        `PAYSYS` varchar(50) NOT NULL default '',
                        `BRAND` varchar(100) NOT NULL default '',
                        `ORDERNUMBER` int(11) unsigned NOT NULL default '0',
                        `ORDERDESCRIPTION` varchar(255) NOT NULL default '',
                        `STATE` varchar(20) NOT NULL default '',
                        `MESSAGE` varchar(255) NOT NULL default '',
                        `ORDERID` int(11) unsigned NOT NULL default '0',
                        `GATEWAY_REF_NUM` varchar(255) NULL default '',
						`RESPONSEDATA` TEXT NULL DEFAULT NULL,
                         PRIMARY KEY  (`TRID`)
                        )");

        if(!$this->table_column_exists(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE,RESPONSEDATA)) {
            xtc_db_query("ALTER TABLE `" . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE . "` ADD `RESPONSEDATA` TEXT NULL DEFAULT NULL");
        }
		
		// add ADMIN ACCESS
		$t_check = $this->table_column_exists('admin_access', 'wcp_config_export');
		if($t_check == false)
		{
			$t_query = "ALTER TABLE `admin_access` ADD `wcp_config_export` INT( 1 ) NOT NULL DEFAULT '0'";
			$t_success &= xtc_db_query($t_query);

			$t_query = "UPDATE `admin_access` SET `wcp_config_export` = '1' WHERE `customers_id` = '1' OR `customers_id` = 'groups'";
			$t_success &= is_numeric(xtc_db_query($t_query));		
		}
    }

    function remove()
    {
      $removeTXTable = isset($_GET['removeTXTable']) ? $_GET['removeTXTable'] : 'false';
      if($removeTXTable == 'true')
      {
          xtc_db_query("DROP TABLE ".MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE);
      }
      else
      {
          xtc_db_query("delete from " . TABLE_CONFIGURATION . " where configuration_key in ('" . xtc_db_input(implode("', '", $this->keys())) . "')");
          ?>
          <html>
          <head>
          <script language="JavaScript" type="text/JavaScript">
              if(confirm("Do you want to remove the Wirecard Checkout Page transactions-table from your system?") == true)
              {
                  window.location.href = "<?php echo xtc_href_link(FILENAME_MODULES, 'set=' . $_GET['set'] . '&module=wirecard_checkout_page&action=remove&removeTXTable=true'); ?>";
              }
              else
              {
                  window.location.href = "<?php echo xtc_href_link(FILENAME_MODULES, 'set=' . $_GET['set'] . '&module=wirecard_checkout_page'); ?>";
              }
          </script>
          </head>
          <body>

          </body>
          </html>
          <?php
          die();
      }
    }

    function keys()
    {
        return array('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS',
		             'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE', 
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMERID',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOPID',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_USE_IFRAME',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SELECT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TEXT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL',					
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY',
					'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MIN_AMOUNT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MAX_AMOUNT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MIN_AMOUNT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MAX_AMOUNT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SERVICEURL',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IMAGEURL',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SORT_ORDER',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_ID',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ZONE',
					'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DEVICE_DETECTION',
                    'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT',
					'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DUPLICATE_REQUEST_CHECK',
					'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_AUTO_DEPOSIT',
					'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRMATION_MAIL',
					'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_MAX_RETRIES',
					'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENTTYPE_SORT_ORDER',
					'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CUSTOMER_DATA',
					'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CART_DATA',
					);
    }

    function generate_trid()
    {
        do
        {
          $trid = xtc_create_random_value(16);
          $result = xtc_db_query("SELECT TRID FROM " . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE . " WHERE TRID = '" . $trid . "'");
        }
        while (xtc_db_num_rows($result));

        return $trid;
    }

    function _getZoneCodeByName($zoneName)
    {
        $sql = 'SELECT zone_code FROM ' . TABLE_ZONES . ' WHERE zone_name=\'' . xtc_db_input($zoneName) . '\' LIMIT 1;';
        $result = xtc_db_query($sql);
        $resultRow = mysql_fetch_row($result);
        return $resultRow[0];
    }

    function _wirecardCheckoutPageConfirmResponse($message = null)
    {
        if($message != null)
        {
            $this->debug_log($message);
            $value = 'result="NOK" message="' . $message . '" ';
        }
        else
        {
            $value = 'result="OK"';
        }
        return '<!--<QPAY-CONFIRMATION-RESPONSE ' . $value . ' />-->';
    }

    function admin_order($oID)
    {
        return false;
    }

    /// @brief Check if column exists in table
    function table_column_exists($p_table, $p_column)
    {
        $return = false;

        $check = xtc_db_query("DESCRIBE `" . $p_table . "` '" . $p_column . "'");
		$result = mysql_num_rows($check);

        if($result > 0)
        {
            $return = true;
        }
        return $return;
    }
	
	function _isInstalled() {
        $result = xtc_db_query("SELECT count(*) FROM ".TABLE_CONFIGURATION." WHERE configuration_key = 'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS'");
        $resultRow = mysql_fetch_row($result);
        return $resultRow[0];
    }
	
	/// @brief detects customer's device type (tablet, smartphone, desktop)
    function _getClientDevice()
    {
        require_once('includes/classes/wcp_mobile_detect.php');
        $detect = new WirecardCEE_MobileDetect;
        return ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'smartphone') : 'desktop');
    }

	// from admin/includes/functions/general.php
    function xtc_remove_order($order_id, $restock = false)
    {
	    if ($restock == 'on') {
		    $order_query = xtc_db_query("select products_id, products_quantity from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".xtc_db_input($order_id)."'");
		    while ($order = xtc_db_fetch_array($order_query)) {
			    xtc_db_query("update ".TABLE_PRODUCTS." set products_quantity = products_quantity + ".$order['products_quantity'].", products_ordered = products_ordered - ".$order['products_quantity']." where products_id = '".$order['products_id']."'");
		    }
	    }

	    xtc_db_query("delete from ".TABLE_ORDERS." where orders_id = '".xtc_db_input($order_id)."'");
	    xtc_db_query("delete from ".TABLE_ORDERS_PRODUCTS." where orders_id = '".xtc_db_input($order_id)."'");
	    xtc_db_query("delete from ".TABLE_ORDERS_PRODUCTS_ATTRIBUTES." where orders_id = '".xtc_db_input($order_id)."'");
	    xtc_db_query("delete from ".TABLE_ORDERS_STATUS_HISTORY." where orders_id = '".xtc_db_input($order_id)."'");
	    xtc_db_query("delete from ".TABLE_ORDERS_TOTAL." where orders_id = '".xtc_db_input($order_id)."'");
    }
}
