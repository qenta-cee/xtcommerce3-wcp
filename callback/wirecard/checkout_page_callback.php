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

chdir('../../');
include_once('includes/application_top.php');
include_once('includes/modules/payment/wirecard_checkout_page.php');

if(isset($_POST)) {
    $paymentState = '';
    $trid = isset($_POST['trid']) ? $_POST['trid'] : '';

    $q = xtc_db_query('SELECT RESPONSEDATA FROM ' . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE . ' WHERE trid = "' . xtc_db_input($trid) . '" LIMIT 1;');
    $dbEntry = xtc_db_fetch_array($q);
    $paymentInformation = json_decode($dbEntry['RESPONSEDATA'], true);

    $q = xtc_db_query('SELECT ORDERID FROM ' . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE . ' WHERE trid = "' . xtc_db_input($trid) . '" LIMIT 1;');
    $dbEntry = xtc_db_fetch_array($q);
    $order_id = json_decode($dbEntry['ORDERID'], true);

    $q = xtc_db_query('SELECT orders_status FROM ' . TABLE_ORDERS . ' WHERE orders_id = "' . $order_id . '" LIMIT 1;');
    $dbEntry = xtc_db_fetch_array($q);
    $order_state= json_decode($dbEntry['orders_status'], true);

    //fallback update of order
    if (isset($dbEntry['RESPONSEDATA'])) {
        $paymentState = $paymentInformation['paymentState'];
        if (isset($_SESSION['wirecard_checkout_page_fingerprintinvalid'])) {
            $paymentState = $_SESSION['wirecard_checkout_page_fingerprintinvalid'];
        }
    }
    else {
		chdir('callback/wirecard/');
        include ('checkout_page_confirm.php');

        $q = xtc_db_query('SELECT RESPONSEDATA FROM ' . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE . ' WHERE trid = "'.xtc_db_input($trid).'" LIMIT 1;');
		$dbEntry = xtc_db_fetch_array($q);

		$paymentInformation = json_decode($dbEntry['RESPONSEDATA'],true);

        if(isset($dbEntry['RESPONSEDATA'])) {
            $paymentState = $paymentInformation['paymentState'];
        }
        if (isset($_SESSION['wirecard_checkout_page_fingerprintinvalid'])) {
            $paymentState = $_SESSION['wirecard_checkout_page_fingerprintinvalid'];
        }
    }

    switch ($paymentState)
    {
        case 'SUCCESS':
        case 'PENDING':
            $_SESSION['cart']->reset(true);
			unset($_SESSION['wirecard_checkout_page']['payMethod']);	
			unset($_SESSION['payment']);
			unset($_SESSION['wcp_trustpay_bank_selected']);
            $link = xtc_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL');
            break;
        case 'CANCEL':
            $link = xtc_href_link('checkout_wirecard_checkout_page.php', 'cancel=1', 'SSL');
            break;
        default:
			unset($_SESSION['wirecard_checkout_page']['payMethod']);
			unset($_SESSION['payment']);	
			unset($_SESSION['wcp_trustpay_bank_selected']);
            unset($_SESSION['wirecard_checkout_page_fingerprintinvalid']);
            $link = xtc_href_link('checkout_wirecard_checkout_page.php', 'failure=1', 'SSL');
            break;
    }
}

xtc_db_close();
?>
<html>
<head>
</head>
<body onLoad="window.parent.location.href = '<?php echo $link; ?>'">
</body>
</html>
