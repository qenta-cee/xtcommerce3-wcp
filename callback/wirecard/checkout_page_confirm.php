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
// set order-status 1 (pending)
define('MODULE_PAYMENT_WCP_ORDER_STATUS_PENDING', 1);
// set order-status 2 (processing)
define('MODULE_PAYMENT_WCP_ORDER_STATUS_SUCCESS', 2);
// set order-status 99 (canceled)
define('MODULE_PAYMENT_WCP_ORDER_STATUS_FAILED', 99);
chdir('../../');

function debug_msg($msg)
{
    $fh = fopen('wirecard_checkout_page_notify_debug.txt', 'a');
    fwrite($fh, date('r'). ". ". $msg."\n");
    fclose($fh);
}
debug_msg('called script from '.$_SERVER['REMOTE_ADDR']);
$returnMessage = null;
if ($_POST)
{
    include_once ('includes/application_top.php');
    include_once ('includes/modules/payment/wirecard_checkout_page.php');

    $languageArray = Array('language' => htmlentities($_POST['confirmLanguage']),
        'language_id' => htmlentities($_POST['confirmLanguageId']));

    debug_msg("Finished Initialization of the confirm_callback.php script" );
    debug_msg("Received this POST: " . print_r($_POST, 1));
	
	if(get_magic_quotes_gpc() || get_magic_quotes_runtime())
	{
		$this->debug_log('magic_quotes enabled. Stripping slashes for consumer return.');
		foreach($_POST AS $key=>$value)
		{
			$responseArray[$key] = stripslashes($value);
		}
	}
	else
	{
		$responseArray = $_POST;
	}
	
	 $orderDesc            = isset($responseArray['orderDesc']) ? $responseArray['orderDesc'] : '';
        // orderNumber is only given if paymentState=success
        $orderNumber          = isset($responseArray['orderNumber']) ? $responseArray['orderNumber'] : 0;
        $paymentState         = isset($responseArray['paymentState']) ? $responseArray['paymentState'] : 'FAILURE';
        $paysys               = isset($responseArray['paymentType']) ? $responseArray['paymentType'] : '';
        $brand                = isset($responseArray['financialInstitution']) ? $responseArray['financialInstitution'] : '';
        $message              = '';
        $everythingOk         = false;

	$q = xtc_db_query("UPDATE " . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE . " SET " .
            "ORDERNUMBER=" . xtc_db_input($orderNumber) . ", " .
            "ORDERDESCRIPTION='" . xtc_db_input($orderDesc) . "', " .
            "STATE='" . xtc_db_input($paymentState) . "', " .
            "MESSAGE='" . xtc_db_input($message) . "', " .
            "GATEWAY_REF_NUM='" . xtc_db_input($gatewayRefNum) . "', " .
            "RESPONSEDATA='" . xtc_db_input(json_encode($responseArray)) . "', " .
            (xtc_not_null($paysys) ? "PAYSYS='" . xtc_db_input($paysys) . "', " : "") . // overwrite only if given in response
            "BRAND='" . xtc_db_input($brand) . "' " .
            "WHERE TRID='" . xtc_db_input($responseArray['trid']) . "'");
        
    if(!$q)
    {
        $returnMessage = 'Transactiontable update failed.';
    }
    debug_msg('Payment Table updated='.$q);
	
	$q = xtc_db_query('SELECT ORDERID FROM ' . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE . ' WHERE trid = "' . xtc_db_input($responseArray['trid']) . '" LIMIT 1;');
	$dbEntry = xtc_db_fetch_array($q);
	$order_id = $dbEntry['ORDERID'];
	
    if(isset($_POST['responseFingerprintOrder']) && isset($_POST['responseFingerprint']))
    {
        $responseFingerprintOrder = explode(',', $_POST['responseFingerprintOrder']);
        $tempArray  = array();
        $c = strtoupper($_POST['paymentCode']);

        switch(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE) {
            case 'Demo':
                $preshared_key = 'B8AKTPWBRMNBV455FG6M2DANE99WU2';
                break;
            case 'Test':
                $preshared_key = 'CHCSH7UGHVVX2P7EHDHSY4T2S4CGYK4QBE4M5YUUG2ND5BEZWNRZW5EJYVJQ';
                break;
            case 'Live':
            default:
                $preshared_key = trim(MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET);
                break;
        }

        //calculating fingerprint;
        foreach($responseFingerprintOrder as $k)
        {
            if (strcmp($k, 'secret') == 0)
            {
                $tempArray['secret'] = $preshared_key;
            } else {
                $tempArray[(string)$k] = (string)$_POST[$k];
            }
        }

        $hash = hash_init('sha512', HASH_HMAC, $preshared_key);

        foreach ($tempArray as $key => $value) {
            hash_update($hash, $value);
        }

        $calculated_fingerprint = hash_final($hash);

        if($calculated_fingerprint == $_POST['responseFingerprint'])
        {
            debug_msg('Fingerprint is OK');

            switch ($_POST['paymentState'])
            {
                case 'SUCCESS':
                    $order_status = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_ID;
                    break;

                case 'PENDING':
                    $order_status = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID;
                    break;

                default:
                    $order_status = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_FAILED;
            }
            debug_msg('Callback Process');
            $q = xtc_db_query('UPDATE ' . TABLE_ORDERS . ' SET orders_status=\'' . xtc_db_input($order_status) . '\' WHERE orders_id=\'' . $order_id.'\';');
            if(!$q)
            {
                $returnMessage = 'Orderstatus update failed.';
            }
            debug_msg('Order-Status updated='.$q);
            $avsStatusCode = isset($_POST['avsResponseCode']) ? $_POST['avsResponseCode'] : '';
            $avsStatusMessage = isset($_POST['avsResponseMessage']) ? $_POST['avsResponseMessage'] : '';
            if($avsStatusCode != '' && $avsStatusMessage != '')
            {
                $avsStatus = 'AVS Result: ' . $avsStatusCode . ' - ' . $avsStatusMessage;
            }
            else
            {
                $avsStatus = '';
            }
            debug_msg($avsStatus);
							
			//add response to order comments, due to the problem that the backend order details page cannot be modified
			$tmpStr = "$avsStatus\n";
			foreach($_POST as $k=>$v) {
				$tmpStr .= "$k: $v\n";
			}

            $q = xtc_db_query('INSERT INTO '.TABLE_ORDERS_STATUS_HISTORY.'
             (orders_id,  orders_status_id, date_added, customer_notified, comments)
             VALUES
               ('. (int)$order_id.', '.(int)$order_status.', NOW(), "0", "'.xtc_db_input($tmpStr) . '")');
            if(!$q)
            {
                $returnMessage = 'Statushistory update failed';
            }
            debug_msg('Order-Status-History updated='.$q);

            if(MODULE_PAYMENT_WCP_ORDER_STATUS_SUCCESS === $order_status) {		
                create_status_mail_for_order($order_id, $languageArray);
            }
        }
        else
        {
            $returnMessage = 'Fingerprint validation failed.';
            debug_msg('Invalid Responsefingerprint.');
            debug_msg('calc-fingerprint: ' .$calculated_fingerprint);
            debug_msg('response-fingerprint: '. $_POST['responseFingerprint']);
            $order_status = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_FAILED;
            $q = xtc_db_query('UPDATE ' . TABLE_ORDERS . ' SET orders_status=\'' . xtc_db_input($order_status) . '\' WHERE orders_id=\'' . $order_id.'\';');
        }
    }
    else
    {
        debug_msg('No fingerprint found.');
        if(isset($_POST['paymentState']) && $_POST['paymentState'] == 'CANCEL')
        {
            debug_msg('Order is Canceled');
            $order_status = MODULE_PAYMENT_WCP_ORDER_STATUS_FAILED;

            debug_msg('Callback Process');
             $q = xtc_db_query("UPDATE ".TABLE_ORDERS."
               SET orders_status='" . xtc_db_input($order_status) . "'
               WHERE orders_id='" . (int)$order_id . "'");
            if(!$q)
            {
                $returnMessage = 'Orderstatus update failed.';
            }
										
			//add response to order comments, due to the problem that the backend order details page cannot be modified
			$tmpStr = "";
			foreach($_POST as $k=>$v) {
				$tmpStr .= "$k: $v\n";
			}
			
            debug_msg('Order-Status updated='.$q);
            $q = xtc_db_query("INSERT INTO ".TABLE_ORDERS_STATUS_HISTORY."
               (orders_id,  orders_status_id, date_added, customer_notified, comments)
               VALUES
              ('" . (int)$order_id . "', '" . (int)$order_status . "', NOW(), '0', '".xtc_db_input($tmpStr)."')");
            if(!$q)
            {
                $returnMessage = 'Statushistory update failed';
            }
            debug_msg('Order-Status-History updated='.$q);

            // restock order
            $restocked = wirecard_checkout_page::xtc_remove_order($order_id, true);
            if($restocked)
            {
                debug_msg('Order Restocked');
            }
        }
        elseif(isset($_POST['paymentState']) && $_POST['paymentState'] == 'FAILURE')
        {
            $message = isset($_POST['message']) ? htmlentities($_POST['message']) : '';
            debug_msg('Order Failed: '.$message);
            $order_status = MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_FAILED;
            debug_msg('Callback Process');
             $q = xtc_db_query("UPDATE ".TABLE_ORDERS."
               SET orders_status='" . (int)$order_status . "'
               WHERE orders_id='" . (int)$order_id . "'");
            if(!$q)
            {
                $returnMessage = 'Orderstatus update failed.';
            }
            debug_msg('Order-Status updated='.$q);
            $q = xtc_db_query("INSERT INTO ".TABLE_ORDERS_STATUS_HISTORY."
               (orders_id,  orders_status_id, date_added, customer_notified, comments)
               VALUES
               ('" . (int)$order_id ."', '" . (int)$order_status . "', NOW(), '0', '" . xtc_db_input($message) . "')");

            if(!$q)
            {
                $returnMessage = 'Statushistory update failed';
            }
            debug_msg('Order-Status-History updated='.$q);

            // restock order
            $restocked = wirecard_checkout_page::xtc_remove_order($order_id, true);
            if($restocked)
            {
                debug_msg('Order Restocked');
            }
        }
        elseif(isset($_POST['paymentState']) && $_POST['paymentState'] == 'SUCCESS')
        {
            $returnMessage = 'Mandatory fields not used.';
        }
    }
}
else
{
    $returnMessage = 'Not a POST request';
}
echo _wirecardCheckoutPageConfirmResponse($returnMessage);
debug_msg("-- script reached eof - executed without errors --\n");

//copy of send_orders.php
function create_status_mail_for_order($oID, $language)
{
	$insert_id = (int)$oID;
   
    require_once (DIR_FS_INC.'xtc_get_order_data.inc.php');
    require_once (DIR_FS_INC.'xtc_get_attributes_model.inc.php');
    require_once (DIR_WS_CLASSES.'order.php');
    if (file_exists(DIR_WS_CLASSES . 'Smarty_2.6.14/Smarty.class.php'))
        require_once (DIR_WS_CLASSES . 'Smarty_2.6.14/Smarty.class.php');
    else
        require_once (DIR_WS_CLASSES . 'Smarty/Smarty.class.php');

	// check if customer is allowed to send this order!
    $order_query_check = xtc_db_query("SELECT
  					customers_id
  					FROM ".TABLE_ORDERS."
  					WHERE orders_id='".$insert_id."'");

$order_check = xtc_db_fetch_array($order_query_check);

   	$order = new order($insert_id);

	$smarty = new Smarty();
	
	$smarty->assign('address_label_customer', xtc_address_format($order->customer['format_id'], $order->customer, 1, '', '<br />'));
	$smarty->assign('address_label_shipping', xtc_address_format($order->delivery['format_id'], $order->delivery, 1, '', '<br />'));
	if ($_SESSION['credit_covers'] != '1') {
		$smarty->assign('address_label_payment', xtc_address_format($order->billing['format_id'], $order->billing, 1, '', '<br />'));
	}
	$smarty->assign('csID', $order->customer['csID']);
	
	$order_total = $order->getTotalData($insert_id); 
		$smarty->assign('order_data', $order->getOrderData($insert_id));
		$smarty->assign('order_total', $order_total['data']);

	// assign language to template for caching
	$smarty->assign('language', $language['language']);
	$smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');
	$smarty->assign('oID', $insert_id);
	if ($order->info['payment_method'] != '' && $order->info['payment_method'] != 'no_payment') {
		include (DIR_WS_LANGUAGES.$language['language'].'/modules/payment/'.$order->info['payment_method'].'.php');
		$payment_method = constant(strtoupper('MODULE_PAYMENT_'.$order->info['payment_method'].'_TEXT_TITLE'));
	}
	$smarty->assign('PAYMENT_METHOD', $payment_method);
	$smarty->assign('DATE', xtc_date_long($order->info['date_purchased']));

	$smarty->assign('NAME', $order->customer['name']);
	$smarty->assign('COMMENTS', $order->info['comments']);
	$smarty->assign('EMAIL', $order->customer['email_address']);
	$smarty->assign('PHONE',$order->customer['telephone']);


	// dont allow cache
	$smarty->caching = false;

	$html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$language['language'].'/order_mail.html');
	$txt_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$language['language'].'/order_mail.txt');

	// create subject
	$order_subject = str_replace('{$nr}', $insert_id, EMAIL_BILLING_SUBJECT_ORDER);
	$order_subject = str_replace('{$date}', strftime(DATE_FORMAT_LONG), $order_subject);
	$order_subject = str_replace('{$lastname}', $order->customer['lastname'], $order_subject);
	$order_subject = str_replace('{$firstname}', $order->customer['firstname'], $order_subject);

	// send mail to admin
	$mailAdmin = xtc_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, EMAIL_BILLING_ADDRESS, STORE_NAME, EMAIL_BILLING_FORWARDING_STRING, $order->customer['email_address'], $order->customer['firstname'], '', '', $order_subject, $html_mail, $txt_mail);

	// send mail to customer
	$mailCustomer = xtc_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $order->customer['email_address'], $order->customer['firstname'].' '.$order->customer['lastname'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $order_subject, $html_mail, $txt_mail);

	if (AFTERBUY_ACTIVATED == 'true') {
		require_once (DIR_WS_CLASSES.'afterbuy.php');
		$aBUY = new xtc_afterbuy_functions($insert_id);
		if ($aBUY->order_send())
			$aBUY->process_order();
	}
}

function _wirecardCheckoutPageConfirmResponse($message = null)
{
    if($message != null)
    {
        debug_msg($message);
        $value = 'result="NOK" message="' . $message . '" ';
    }
    else
    {
        $value = 'result="OK"';
    }
    return '<QPAY-CONFIRMATION-RESPONSE ' . $value . ' />';
}
