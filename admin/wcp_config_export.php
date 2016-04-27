<?php
/**
 * Shop System Plugins - Terms of use
 *
 * This terms of use regulates warranty and liability between Wirecard
 * Central Eastern Europe (subsequently referred to as WDCEE) and it's
 * contractual partners (subsequently referred to as customer or customers)
 * which are related to the use of plugins provided by WDCEE.
 *
 * The Plugin is provided by WDCEE free of charge for it's customers and
 * must be used for the purpose of WDCEE's payment platform integration
 * only. It explicitly is not part of the general contract between WDCEE
 * and it's customer. The plugin has successfully been tested under
 * specific circumstances which are defined as the shopsystem's standard
 * configuration (vendor's delivery state). The Customer is responsible for
 * testing the plugin's functionality before putting it into production
 * enviroment.
 * The customer uses the plugin at own risk. WDCEE does not guarantee it's
 * full functionality neither does WDCEE assume liability for any
 * disadvantage related to the use of this plugin. By installing the plugin
 * into the shopsystem the customer agrees to the terms of use. Please do
 * not use this plugin if you do not agree to the terms of use!
 */

$supportMails = array("support.at@wirecard.com", "support@wirecard.com");
$message = array('ERROR' => '', 'OK' => '');

require 'includes/application_top.php';

define('PAGE_URL', HTTP_SERVER . DIR_WS_ADMIN . basename(__FILE__));
define('PAGE_BACK_URL', HTTP_SERVER . DIR_WS_ADMIN . 'modules.php?set=payment&module=wirecard_checkout_page');
include_once('../includes/modules/payment/wirecard_checkout_page.php');
include_once(DIR_FS_CATALOG . 'lang/' . $_SESSION['language'] . '/modules/payment/wirecard_checkout_page.php');


$q = "SELECT configuration_key, configuration_value FROM configuration where configuration_key LIKE 'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_%'";
$res = xtc_db_query($q);
$confDataString = '';

while ($row = xtc_db_fetch_array($res)) {
    if ($row['configuration_key'] != 'MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET') {
        $confDataString .= $row['configuration_key'] . " = " . $row['configuration_value'] . "\n\r";
    } else {
        $confDataString .= $row['configuration_key'] . " = " . str_pad('', strlen($row['configuration_value']), 'X') . "\n\r";
    }
}

if (isset($_POST['submit'])) {
    if (!empty($_POST['wcp_config_export_reply_to_mail']) && !filter_var($_POST['wcp_config_export_reply_to_mail'], FILTER_VALIDATE_EMAIL)) {
        $message['ERROR'] = MODULE_PAYMENT_WCP_EXPORT_CONFIG_INVALID_MAIL;
    }
    $email = $confDataString . "\n\r\n\r";
    $email .= htmlspecialchars($_POST['wcp_config_export_description_text']) . "\n\r";

    $headers = array();
    $headers[] = "MIME-Version: 1.0";
    $headers[] = "Content-type: text/plain; charset=iso-8859-1";
    $headers[] = 'From: ' . STORE_NAME . ' <' . EMAIL_SUPPORT_REPLY_ADDRESS . '>';

    if (!empty($_POST['wcp_config_export_reply_to_mail']))
        $headers[] = "Reply-To: " . $_POST['wcp_config_export_reply_to_mail'];
    elseif (constant('EMAIL_SUPPORT_REPLY_ADDRESS'))
        $headers[] = "Reply-To: " . EMAIL_SUPPORT_REPLY_ADDRESS;
    else
        $headers[] = "Reply-To: " . CONTACT_US_EMAIL_ADDRESS;

    if (empty($message['ERROR'])) {
        if (mail($_POST['wcp_config_export_receiver'], 'WCP Config Export', $email, implode("\r\n", $headers))) {
            $message['OK'] = MODULE_PAYMENT_WCP_EXPORT_CONFIG_MAIL_SENT;
            unset($_POST);
        } else {
            $message['ERROR'] = MODULE_PAYMENT_WCP_EXPORT_CONFIG_MAIL_NOT_SENT;
        }
    }
}

?>
    <!doctype HTML>
    <html <?php echo HTML_PARAMS; ?>>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
        <title><?php echo MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_EXPORT_CONFIG_LABEL; ?></title>
        <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    </head>
    <body>
    <!-- header //-->
    <?php require DIR_WS_INCLUDES . 'header.php'; ?>
    <!-- header_eof //-->

    <!-- body //-->
    <table width="100%" cellspacing="2" cellpadding="2" border="0">
        <tbody>
        <tr>
            <td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
                <table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">

                    <!-- left_navigation //-->
                    <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
                    <!-- left_navigation_eof //-->

                </table>
            </td>

            <!-- body_text //-->
            <td class="boxCenter" width="100%" valign="top">
                    <span class="main">
                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="margin-bottom:5px">
                        <tbody>
                        <tr class="dataTableHeadingRow">
                            <td class="dataTableHeadingContentText"
                                style="border-right: 0px">
                                <strong><?php echo MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_EXPORT_CONFIG_LABEL; ?></strong>
                            </td>
                        </tr>

                        </tbody>
                    </table>

                    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="border: 1px solid #dddddd">
                        <tbody>
                        <tr class="dataTableRow">
                            <td><?php echo MODULE_PAYMENT_WCP_EXPORT_CONFIG_DESC; ?></td>
                        </tr>
                        <tr class="dataTableRow">
                            <td>&nbsp;</td>
                        </tr>
                        <tr class="dataTableRow">
                            <td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
                                <?php if ($message['ERROR']) {
                                    echo '<div style="color:#FF0000"><strong>' . $message['ERROR'] . '</strong></div>';
                                } ?>
                                <?php if ($message['OK']) {
                                    echo '<div style="color:#00FF00"><strong>' . $message['OK'] . '</strong></div>';
                                } ?>
                                <br>


                                <form method="post" action="<?php echo PAGE_URL; ?>?pm=<?php echo $c; ?>"
                                      name="wcp_config_export_form">
                                    <label
                                        for="wcp_config_export_receiver"
                                        style="display:block"><strong><?php echo MODULE_PAYMENT_WCP_EXPORT_CONFIG_RECEIVER; ?></strong></label>
                                    <select name="wcp_config_export_receiver">
                                        <?php foreach ($supportMails as $mailAddress) {
                                            $selected = '';
                                            if (isset($_POST['wcp_config_export_receiver']) && $mailAddress == $_POST['wcp_config_export_receiver']) {
                                                $selected = ' selected="selected"';
                                            }
                                            echo '<option value="' . $mailAddress . '"' . $selected . '>' . $mailAddress . '</option>';
                                        } ?>
                                    </select>
                                    <br>
                                    <br>
                                    <label
                                        for="wcp_config_export_config_string"
                                        style="display:block"><strong><?php echo MODULE_PAYMENT_WCP_EXPORT_CONFIG_CONFIG_STRING; ?></strong></label>
                                    <textarea name="wcp_config_export_config_string"
                                              cols="80"
                                              rows="20"
                                              style="overflow: scroll; resize: none;"
                                        ><?php echo $confDataString; ?></textarea>
                                    <br>
                                    <br>
                                    <label
                                        for="wcp_config_export_description_text"
                                        style="display:block"><strong><?php echo MODULE_PAYMENT_WCP_EXPORT_CONFIG_DESC_TEXT; ?></strong></label>
                                    <textarea name="wcp_config_export_description_text"
                                              cols="80"
                                              rows="20"
                                        ><?php if (isset($_POST['wcp_config_export_description_text'])) echo $_POST['wcp_config_export_description_text']; ?></textarea>
                                    <br>
                                    <br>
                                    <label
                                        for="wcp_config_export_reply_to_mail"
                                        style="display:block"><strong><?php echo MODULE_PAYMENT_WCP_EXPORT_CONFIG_RETURN_MAIL; ?></strong></label>
                                    <input type="text"
                                           value="<?php if (isset($_POST['wcp_config_export_reply_to_mail'])) echo $_POST['wcp_config_export_reply_to_mail']; ?>"
                                           name="wcp_config_export_reply_to_mail"
                                           size="80">
                                    <br>
                                    <br>
                                    <a href="<?php echo PAGE_BACK_URL; ?>" class="button"
                                       style="float:left;margin:auto;"><?php echo MODULE_PAYMENT_WCP_EXPORT_CONFIG_BACK_BUTTON; ?></a>
                                    <input class="button" type="submit"
                                           value="<?php echo MODULE_PAYMENT_WCP_EXPORT_CONFIG_SUBMIT_BUTTON; ?>"
                                           onclick="this.blur();" name="submit" style="margin: 1px 10px;">

                                </form>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                    </span>
                <script>
                    $(function () {
                        $('input.countrycb').click(function () {
                            $('dl.countrydata', $(this).parent()).slideToggle($(this).prop('checked'));
                        });
                        $('dl.countrydata', $('input.countrycb:checked').parent()).show();
                    });
                </script>

                <!-- body_text_eof //-->

        </tr>
    </table>
    <!-- body_eof //-->

    <!-- footer //-->
    <?php require DIR_WS_INCLUDES . 'footer.php'; ?>
    <!-- footer_eof //-->
    </body>
    </html>
<?php


require DIR_WS_INCLUDES . 'application_bottom.php';

