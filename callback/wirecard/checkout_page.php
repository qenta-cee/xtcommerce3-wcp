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
    require_once('includes/modules/payment/wirecard_checkout_page.php');
    require_once('includes/application_top.php');

    $formFields = '';
    $iFrameUsed = isset($_SESSION['wirecard_checkout_page']['iFrame']) ? $_SESSION['wirecard_checkout_page']['iFrame'] : false;
    if(isset($_POST['trid']))
    {
        foreach($_GET AS $param => $value)
        {
            $formFields .= xtc_draw_hidden_field($param, $value);
        }
        $sql = 'SELECT STATE, MESSAGE FROM ' . MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TRANSACTION_TABLE .' WHERE TRID="'.$_POST['trid'].'" LIMIT 1;';
        $result = xtc_db_query($sql);
        $row = mysql_fetch_assoc($result);
        if($row['STATE'] == 'SUCCESS')
        {
            $redirectUrl = xtc_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL', true, false);
            if(!$iFrameUsed)
            {
              xtc_redirect($redirectUrl);
            }
        }
        else if($row['STATE'] == 'PENDING')
        {
            $redirectUrl = xtc_href_link(FILENAME_CHECKOUT_SUCCESS, '', 'SSL', true, false);
            if(!$iFrameUsed)
            {
                xtc_redirect($redirectUrl);
            }
        }

        else
        {
            $redirectUrl = xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=wirecard_checkout_page&message=' . $row['MESSAGE'], 'SSL', true, false);
            if(!$iFrameUsed)
            {
              xtc_redirect($redirectUrl);
            }
            else
            {
                $formFields = xtc_draw_hidden_field('message', $row['MESSAGE']);
            }
        }
    }
    else
    {
        $redirectUrl = xtc_href_link(FILENAME_CHECKOUT_PAYMENT, 'payment_error=wirecard_checkout_page&message=' . $row['MESSAGE'], 'SSL', true, false);
        if(!$iFrameUsed)
        {
            xtc_redirect($redirectUrl);
        }
        else
        {
            $formFields = xtc_draw_hidden_field('message', $row['MESSAGE']);
        }
    }
    $redirectText = $_SESSION['wirecard_checkout_page']['paypage_redirecttext'];
    $_SESSION['wirecard_checkout_page'] = '';
?>
<form action="<?php echo $redirectUrl; ?>" method="get" target="_parent" name="wirecardCheckoutPageReturn">
    <?php echo $redirectText; ?>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
            <td align="right">
                <?php
                echo $formFields;
                ?>
                <input type="image" src="<?php echo xtc_parse_input_field_data('../../templates/'.CURRENT_TEMPLATE.'/buttons/' . $_SESSION['language'] . '/button_continue.gif', array('"' => '&quot;')) ?>" alt="<?php echo IMAGE_BUTTON_CONTINUE; ?>">
            </td>
        </tr>
    </table>
</form>
<script language="JavaScript" type="text/JavaScript">
    document.wirecardCheckoutPageReturn.submit();
</script>