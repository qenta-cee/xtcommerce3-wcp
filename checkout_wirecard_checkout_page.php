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

include_once ('includes/application_top.php');

// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_CATALOG.'includes/modules/payment/wirecard_checkout_page.php');
require_once (DIR_FS_CATALOG.'lang/'.$_SESSION['language'].'/modules/payment/wirecard_checkout_page.php');


// if the customer is not logged on, redirect them to the login page

if (!isset ($_SESSION['customer_id']))
    xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));

// if there is nothing in the customers cart, redirect them to the shopping cart page
if ($_SESSION['cart']->count_contents() < 1)
    xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));

// avoid hack attempts during the checkout procedure by checking the internal cartID
if (isset ($_SESSION['cart']->cartID) && isset ($_SESSION['cartID'])) {
    if ($_SESSION['cart']->cartID != $_SESSION['cartID'])
        xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
}

// if no shipping method has been selected, redirect the customer to the shipping method selection page
if (!isset ($_SESSION['shipping']))
    xtc_redirect(xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));

$breadcrumb->add(NAVBAR_TITLE_1_CHECKOUT_CONFIRMATION, xtc_href_link(FILENAME_CHECKOUT_SHIPPING, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_CHECKOUT_CONFIRMATION);

require (DIR_WS_INCLUDES.'header.php');


if(isset($_GET['cancel']))
{
	$redirectUrl = xtc_href_link(FILENAME_SHOPPING_CART, '', 'SSL', true, false);

    $smarty->assign('CONTENT_TITLE', CHECKOUT_CANCEL_TITLE);
    $smarty->assign('CONTENT_TEXT', CHECKOUT_CANCEL_TEXT);
    $smarty->assign('REDIRECT_FORM', '
	<form action="'.$redirectUrl.'" method="post" target="_parent" name="wirecardCheckoutPageReturn">
    <?php echo $redirectText; ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="right">
                <input type="image" src="'. xtc_parse_input_field_data('templates/'.CURRENT_TEMPLATE.'/buttons/' . $_SESSION['language'] . '/button_continue.gif', array('"' => '&quot;')).'" alt="'.IMAGE_BUTTON_CONTINUE.'">
            </td>
        </tr>
    </table>
</form>');

}
elseif(isset($_GET['failure']))
{
	$redirectUrl = xtc_href_link(FILENAME_SHOPPING_CART, '', 'SSL', true, false);

    $smarty->assign('CONTENT_TITLE', CHECKOUT_FAILURE_TITLE);
    $smarty->assign('CONTENT_TEXT', CHECKOUT_FAILURE_TEXT);
    $smarty->assign('REDIRECT_FORM', '
	<form action="'.$redirectUrl.'" method="post" target="_parent" name="wirecardCheckoutPageReturn">
    <?php echo $redirectText; ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="right">
                <input type="image" src="'. xtc_parse_input_field_data('templates/'.CURRENT_TEMPLATE.'/buttons/' . $_SESSION['language'] . '/button_continue.gif', array('"' => '&quot;')).'" alt="'.IMAGE_BUTTON_CONTINUE.'">
            </td>
        </tr>
    </table>
</form>');
}
elseif(isset($_SESSION['wirecard_checkout_page']['process_form']) && $_SESSION['wirecard_checkout_page']['useIFrame'] == 'True')
{
	$iframeUrl = xtc_href_link('wirecard_checkout_page_iframe.php', '', 'SSL');
	$smarty->assign('IFRAME_URL', $iframeUrl); 
}
elseif(isset($_SESSION['wirecard_checkout_page']['process_form']) && $_SESSION['wirecard_checkout_page']['useIFrame'] == 'False')
{
    $smarty->assign('REDIRECT_FORM', xtc_draw_form('checkout_wirecard_checkout_page', MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INITIATION_URL, 'post', 'name="checkout_wirecard_checkout_page"') . $_SESSION['wirecard_checkout_page']['process_form'].$_SESSION['wirecard_checkout_page']['process_js']);
	$smarty->assign('CONTENT_TITLE', MODULE_PAYMENT_WCP_CHECKOUT_TITLE);
	$smarty->assign('CONTENT_TEXT', MODULE_PAYMENT_WCP_CHECKOUT_CONTENT);
	$smarty->assign('CHECKOUT_BUTTON', '<div id="wcp_continue_button" style="display:none">'.xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONFIRM_ORDER).'</div></form>'."\n");
}
else {
	xtc_redirect(xtc_href_link(FILENAME_SHOPPING_CART));
}


$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/checkout_wirecard_checkout_page.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
    $smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>
