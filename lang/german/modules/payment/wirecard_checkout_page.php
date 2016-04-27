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
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DESCRIPTION', 'Wirecard Checkout Page<br>Zus&auml;tzliche Informationen &uuml;ber Wirecard CEE Produkte erhalten Sie unter <a href="http://www.wirecard.at">http://www.wirecard.at</a><br>
  <br>Die technische Dokumentation finden Sie hier: <br>
  <img src="images/icon_arrow_right.gif"><a href="https://integration.wirecard.at/doku.php/request_parameters">Request Parameter</a><br />
  <img src="images/icon_arrow_right.gif"><a href="https://integration.wirecard.at/doku.php/response_parameters">Response Parameter</a><br />
  <img src="images/icon_arrow_right.gif"><a href="https://integration.wirecard.at/doku.php/payment_methods:start">Zahlungsmittel</a><br />');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS_TITLE','Wirecard Checkout Page Modul aktivieren');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS_DESC','M&ouml;chten Sie Zahlungen &uuml;ber Wirecard Checkout Page akzeptieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMERID_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#customerid"><strong>customerId</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMERID_DESC','Geben Sie Ihre Wirecard CEE Kundennummer ein.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOPID_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#shopid"><strong>shopId</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOPID_DESC','Geben Sie Ihre Wirecard CEE Shop ID ein.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#secret"><strong>secret</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET_DESC','Geben Sie den Secret (pre-shared key) f&uuml;r die Fingerprint-&Uuml;berpr&uuml;fung ein, den Sie von Wirecard CEE erhalten haben.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_USE_IFRAME_TITLE','Iframe verwenden');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_USE_IFRAME_DESC','Startet den Wirecard Checkout Page Zahlungsprozess in einem Iframe innerhalb des Shops. <strong>Hinweis:</strong> F&uuml;r PayPal und Sofort&uuml;berweisung wird immer eine Weiterleitung verwendet.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SELECT_TITLE','Zahlungsmittel SELECT');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SELECT_DESC','Die Zahlungsmittelauswahl erfolgt auf der Wirecard Checkout Page. Wenn aktiviert, werden keine weiteren Zahlungsmittel der Wirecard Checkout Page im Shop angezeigt.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TEXT_TITLE','Zahlungsmitteltext');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TEXT_DESC','Geben Sie den Text an, der als Beschreibung f&uuml;r die Zahlungsmittel SELECT dargestellt werden soll (z.B. MasterCard, Visa, ...).');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_TITLE','Kreditkarte');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_DESC','Zahlungsmittel Kreditkarte aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO_TITLE','Maestro SecureCode');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO_DESC','Zahlungsmittel Maestro SecureCode aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS_TITLE','eps Online-&Uuml;berweisung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS_DESC','Zahlungsmittel eps Online-&Uuml;berweisung aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX_TITLE','paybox');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX_DESC','Zahlungsmittel paybox aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC_TITLE','paysafecard');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC_DESC','Zahlungsmittel paysafecard aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK_TITLE','@Quick');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK_DESC','Zahlungsmittel @Quick aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD_TITLE','SEPA Lastschrift');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD_DESC','Zahlungsmittel SEPA Lastschrift aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL_TITLE', 'PayPal');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL_DESC','Zahlungsmittel Paypal aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE_TITLE', 'SOFORT &Uuml;berweisung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE_DESC','Zahlungsmittel SOFORT &Uuml;berweisung aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL_TITLE','iDEAL');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL_DESC','Zahlungsmittel iDEAL aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP_TITLE','giropay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP_DESC','Zahlungsmittel giropay aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_TITLE','Kauf auf Rechnung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_DESC','Zahlungsmittel Kauf auf Rechnung aktivieren?');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO_TITLE','Kreditkarte Mail Order / Telephone Order');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO_DESC','Kreditkartenzahlung ohne "Verified by Visa" und "MasterCard SecureCode"?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC_TITLE','Bancontact/Mister Cash');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC_DESC','Zahlungsmittel Bancontact/Mister Cash aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_TITLE','eKonto');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_DESC','Zahlungsmittel eKonto aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_TITLE','Kauf auf Raten');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_DESC','Zahlungsmittel Kauf auf Raten aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_TITLE','Trustly');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_DESC','Zahlungsmittel Trustly aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_TITLE','moneta.ru');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_DESC','Zahlungsmittel moneta.ru aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24_TITLE','Przelewy24');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24_DESC','Zahlungsmittel Przelewy24 aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_TITLE','POLi');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_DESC','Zahlungsmittel POLi aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS_TITLE','mpass');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS_DESC','Zahlungsmittel mpass aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT_TITLE','Skrill Direct');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT_DESC','Zahlungsmittel Skrill Direct aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET_TITLE','Skrill Digital Wallet');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET_DESC','Zahlungsmittel Skrill Digital Wallet aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG_TITLE','ePay.bg');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG_DESC','Zahlungsmittel ePay.bg aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY_TITLE','TatraPay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY_DESC','Zahlungsmittel TatraPay aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER_TITLE','Mein Gutschein');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER_DESC','Zahlungsmittel Mein Gutschein aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY_TITLE','TrustPay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY_DESC','Zahlungsmittel TrustPay aktivieren?');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MIN_AMOUNT_TITLE','Mindestbetrag Kauf auf Rechnung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MIN_AMOUNT_DESC','Geben Sie den Mindestbetrag f&uuml;r Kauf auf Rechnung an.  (&euro;)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MAX_AMOUNT_TITLE','H&ouml;chstbetrag Kauf auf Rechnung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MAX_AMOUNT_DESC','Geben Sie den H&ouml;chstbetrag f&uuml;r Kauf auf Rechnung an.  (&euro;)');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MIN_AMOUNT_TITLE','Mindestbetrag Kauf auf Raten');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MIN_AMOUNT_DESC','Geben Sie den Mindestbetrag f&uuml;r Kauf auf Raten an.  (&euro;)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MAX_AMOUNT_TITLE','H&ouml;chstbetrag Kauf auf Raten');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MAX_AMOUNT_DESC','Geben Sie den H&ouml;chstbetrag f&uuml;r Kauf auf Raten an.  (&euro;)');


define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#customerstatement"><strong>customerStatement</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT_DESC', 'Kunden Abrechnungstext Prefix');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters#displaytext"><strong>displayText</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT_DESC', 'Infotext, welcher auf der Bezahlseite angezeigt wird.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SERVICEURL_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#serviceurl"><strong>serviceUrl</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SERVICEURL_DESC','Geben Sie die URL zu Ihrer Kontaktseite ein..');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IMAGEURL_TITLE','<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#imageurl"><strong>imageUrl</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IMAGEURL_DESC','Geben Sie die URL der Grafik ein, die w&auml;hrend dem Bezahlvorgang auf Wirecard Checkout Page angezeigt werden soll.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SORT_ORDER_TITLE','Anzeigereihenfolge');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SORT_ORDER_DESC','Reihenfolge der Anzeige. Kleinste Ziffer wird zuerst angezeigt.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ZONE_TITLE','Zahlungszone');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ZONE_DESC','Wenn eine Zone ausgew&auml;hlt ist, gilt die Zahlungsmethode nur f&uuml;r diese Zone.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_ID_TITLE','Bestellstatus festlegen');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_ID_DESC','Bestellungen, welche mit diesem Modul gemacht werden, auf diesen Status setzen.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID_TITLE','Bestellstatus f&uuml;r ausstehende Zahlungen festlegen');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ORDER_STATUS_PENDING_ID_DESC','Bestellungen, welche mit diesem Modul gemacht werden und im Bezahlstatus pending sind, auf diesen Status setzen.');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENT_TITLE', 'Bezahlvorgang');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_REDIRECTTEXT', 'Sie werden in K&uuml;rze weitergeleitet.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT','Herzlichen Dank f&uuml;r Ihre Bestellung.');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TITLE', 'payolution-Zahlungsbedingungen Checkbox');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_DESC', 'Der K&auml;ufer muss die payolution-Zahlungsbedingungen f&uuml;r Rechnungs- und Ratenkauf akzeptieren.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_MID_TITLE', 'payolution mID');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_MID_DESC', '');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TEXT_INSTALLMENT', 'Mit der &Uuml;bermittlung der f&uuml;r die Abwicklung des Ratenkaufes und einer Identit&auml;ts- und Bonit&auml;tspr&uuml;fung erforderlichen Daten an payolution bin ich einverstanden. Meine <a href="%s" target="_blank"><strong>Einwilligung</strong></a> kann ich jederzeit mit Wirkung f&uuml;r die Zukunft widerrufen.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TEXT_INVOICE', 'Mit der &Uuml;bermittlung der f&uuml;r die Abwicklung des Rechnungskaufes und einer Identit&auml;ts- und Bonit&auml;tspr&uuml;fung erforderlichen Daten an payolution bin ich einverstanden. Meine <a href="%s" target="_blank"><strong>Einwilligung</strong></a> kann ich jederzeit mit Wirkung f&uuml;r die Zukunft widerrufen.');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_TEXT','Kreditkarte');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO_TEXT','Maestro SecureCode');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS_TEXT','eps Online-&Uuml;berweisung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX_TEXT','paybox');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC_TEXT','paysafecard');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK_TEXT','@Quick');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD_TEXT','SEPA Lastschrift');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDEAL_TEXT','iDEAL');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL_TEXT','PayPal');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_WGP_TEXT','giropay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_C2P_TEXT','CLICK2PAY');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SUE_TEXT','sofort&uuml;berweisung.de');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_TEXT','Rechnung');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARDMOTO_TEXT','Kreditkarte Mail Order / Telephone Order');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BMC_TEXT','Bancontact/Mister Cash');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_TEXT','eKonto');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_TEXT','Ratenzahlung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_TEXT','Trustly');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_TEXT','moneta.ru');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_P24_TEXT','Przelewy24');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_TEXT','POLi');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MPASS_TEXT','mpass');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLDIRECT_TEXT','Skrill Direct');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SKRILLWALLET_TEXT','Skrill Digital Wallet');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPAY_BG_TEXT','ePay.bg');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TATRAPAY_TEXT','TatraPay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_VOUCHER_TEXT','Mein Gutschein');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTPAY_TEXT','TrustPay');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ERROR_TITEL', 'Zahlungsfehler');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ERROR_NOTRID', 'Keine Transaktions-ID vorhanden');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CANCEL_TEXT', 'Sie haben die Zahlung abgebrochen.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PENDING_TEXT', 'Die Zahlungsfreigabe erfolgt zu einem sp&auml;teren Zeitpunkt.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ERROR_TEXT', 'Ihre Zahlung war leider ung&uuml;ltig!');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_FINGERPRINT_TEXT', 'Die Daten&uuml;berpr&uuml;fung ist leider fehlgeschlagen.');


define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE_TITLE', 'Plugin-Modus');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE_DESC', 'Wechseln Sie zwischen Live-, Demo- oder Test-Modus. <strong>Achtung</strong>: Es werden keine Transaktionen im Demo- oder Test-Modus verarbeitet!');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DUPLICATE_REQUEST_CHECK_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#duplicaterequestcheck"><strong>duplicateRequestCheck</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DUPLICATE_REQUEST_CHECK_DESC', 'Pr&uuml;fen, ob die gleiche Bestellung versehentlich mehrmals gestartet wurden.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_AUTO_DEPOSIT_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#autodeposit"><strong>autoDeposit</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_AUTO_DEPOSIT_DESC', 'Automatisches Abbuchen und Tagesabschluss in Abh&auml;ngigkeit des Zahlungsmittels aktivieren.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRMATION_MAIL_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#confirmmail"><strong>confirmMail</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRMATION_MAIL_DESC', 'Zahlungsbest&auml;tigung per E-Mail aktivieren.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_MAX_RETRIES_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#maxretries"><strong>maxRetries</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_MAX_RETRIES_DESC', 'Maximale Anzahl an Zahlungsversuchen f&uuml;r eine Bestellung.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENTTYPE_SORT_ORDER_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=autodeposit#paymenttypesortorder"><strong>paymenttypeSortOrder</strong></a>');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENTTYPE_SORT_ORDER_DESC', 'Anzeigereihenfolge f&uuml;r Zahlungsmittel und deren untergeordnete Zahlungsmittel auf der Select-Seite festlegen.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CUSTOMER_DATA_TITLE', 'Kundeninformationen senden');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CUSTOMER_DATA_DESC', '');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CART_DATA_TITLE', 'Warenkorbinformationen senden');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CART_DATA_DESC', '');

define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_DESC', 'Export der Konfiguration zu Wirecard');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_RECEIVER', 'Empf&auml;nger');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_CONFIG_STRING', 'Konfiguration');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_DESC_TEXT', 'Beschreibung');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_RETURN_MAIL', 'R&uuml;ckantwort an E-Mail');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_SUBMIT_BUTTON', 'Senden');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_BACK_BUTTON', 'Zur&uuml;ck');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_INVALID_MAIL', 'E-Mail-Addresse ung&uuml;ltig');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_MAIL_SENT', 'E-Mail versendet');
define('MODULE_PAYMENT_WCP_EXPORT_CONFIG_MAIL_NOT_SENT', 'E-Mail nicht versendet');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_EXPORT_CONFIG_LABEL', 'Konfiguration senden');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DEVICE_DETECTION_TITLE', '<a href="https://integration.wirecard.at/doku.php/request_parameters?s[]=customerid#layout"><strong>layout</strong></a> (automatische Ger&auml;teerkennung)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DEVICE_DETECTION_DESC', 'Erkennen des Kundenger&auml;ts (Smartphone, Tablet, Desktop) zum Anzeigen einer optimierten Bezahlseite.');

define('WCP_SHOPPING_CART_TITLE', 'Warenkorb');
define('WCP_YOUR_DATA_TITLE', 'Ihre Daten');
define('WCP_PAYMENT_TITLE', 'Versand &amp; Bezahlung');
define('WCP_CONFIRMATION_TITLE', 'Best&auml;tigung');

define('MODULE_PAYMENT_WCP_CHECKOUT_TITLE', 'Bezahlvorgang');
define('MODULE_PAYMENT_WCP_CHECKOUT_CONTENT', '<center>Sie werden zur Bezahlung weitergeleitet.</center>');

define('CHECKOUT_CANCEL_TITLE', 'Bezahlung abgebrochen');
define('CHECKOUT_CANCEL_TEXT', 'Sie haben Ihre Bezahlung abgebrochen!');

define('CHECKOUT_FAILURE_TITLE', 'Ein Fehler ist aufgetreten');
define('CHECKOUT_FAILURE_TEXT', 'Ein Fehler ist bei der Bezahlung aufgetreten!');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMETHOD_NOT_ALLOWED', 'Das ausgew&auml;hlte Zahlungsmittel ist nicht m&ouml;glich. Bitte w&auml;hlen Sie ein anderes Zahlungsmittel');
define('MODULE_PAYMENT_WCP_DATE_OF_BIRTH_TEXT', 'Geburtsdatum im Format (dd.mm.jjjj):');
define('MODULE_PAYMENT_WCP_ENTRY_VAT_ID', 'Ust-ID:');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_ENTRY_VAT_ERROR', 'Die eingegebene Ust-ID ist ung&uuml;ltig.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_ACCEPT_TERMS', 'Bitte willigen Sie der Daten&uuml;bermittlung an payolution ein.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_COMMUNICATION_ERROR', 'Kommunikationsfehler beim Zahlungsdienstleister. Bitte versuchen Sie es erneut.');
