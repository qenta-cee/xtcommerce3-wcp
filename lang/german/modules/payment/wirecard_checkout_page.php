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
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DESCRIPTION', 'Wirecard Checkout Page<br>Zus&auml;tzliche Informationen &uuml;ber Wirecard Produkte erhalten Sie unter <a href="http://www.wirecard.at">http://www.wirecard.at</a><br>
  <br>Die technische Dokumentation finden Sie hier: <br>
  <img src="images/icon_arrow_right.gif"><a href="https://integration.wirecard.at/doku.php/request_parameters">Request Parameter</a><br />
  <img src="images/icon_arrow_right.gif"><a href="https://integration.wirecard.at/doku.php/response_parameters">Response Parameter</a><br />
  <img src="images/icon_arrow_right.gif"><a href="https://integration.wirecard.at/doku.php/payment_methods:start">Zahlungsmittel</a><br />');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS_TITLE','Wirecard Checkout Page Modul aktivieren');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_STATUS_DESC','M&ouml;chten Sie Zahlungen &uuml;ber Wirecard Checkout Page akzeptieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMERID_TITLE','Customer ID');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMERID_DESC','Ihre Wirecard-Kundennummer (customerId, im Format D2#####).');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOPID_TITLE','Shop ID');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOPID_DESC','Shop-Kennung bei mehreren Onlineshops.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET_TITLE','Secret');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SECRET_DESC','Geheime Zeichenfolge, die Sie von Wirecard erhalten haben, zum Signieren und Validieren von Daten zur Pr&uuml;fung der Authentizit&auml;t.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_USE_IFRAME_TITLE','Iframe verwenden');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_USE_IFRAME_DESC','Startet den Wirecard Checkout Page Zahlungsprozess in einem Iframe innerhalb des Shops. <strong>Hinweis:</strong> F&uuml;r PayPal und Sofort&uuml;berweisung wird immer eine Weiterleitung verwendet.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SELECT_TITLE','Zahlungsmittel SELECT');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SELECT_DESC','Die Zahlungsmittelauswahl erfolgt auf der Wirecard Checkout Page. Wenn aktiviert, werden keine weiteren Zahlungsmittel der Wirecard Checkout Page im Shop angezeigt.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_TITLE','Kreditkarte');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_DESC','Zahlungsmittel Kreditkarte aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MASTERPASS_TITLE','Masterpass');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MASTERPASS_DESC','Zahlungsmittel Masterpass aktivieren?');
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
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SOFORTUEBERWEISUNG_TITLE', 'SOFORT &Uuml;berweisung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SOFORTUEBERWEISUNG_DESC','Zahlungsmittel SOFORT &Uuml;berweisung aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDL_TITLE','iDEAL');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDL_DESC','Zahlungsmittel iDEAL aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_GIROPAY_TITLE','giropay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_GIROPAY_DESC','Zahlungsmittel giropay aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_TITLE','Kauf auf Rechnung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_DESC','Zahlungsmittel Kauf auf Rechnung aktivieren?');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_MOTO_TITLE','Kreditkarte - Post / Telefonbestellung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_MOTO_DESC','Zahlungsmittel Kreditkarte - Post / Telefonbestellung aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BANCONTACT_TITLE','Bancontact');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BANCONTACT_DESC','Zahlungsmittel Bancontact aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_TITLE','eKonto');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_DESC','Zahlungsmittel eKonto aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_TITLE','Kauf auf Raten');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_DESC','Zahlungsmittel Kauf auf Raten aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_TITLE','Trustly');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_DESC','Zahlungsmittel Trustly aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_TITLE','moneta.ru');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_DESC','Zahlungsmittel moneta.ru aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PRZELEWY24_TITLE','Przelewy24');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PRZELEWY24_DESC','Zahlungsmittel Przelewy24 aktivieren?');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_TITLE','POLi');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_DESC','Zahlungsmittel POLi aktivieren?');
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

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_PROVIDER_TITLE', 'Provider f&uuml;r Kauf auf Rechnung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_PROVIDER_DESC', 'W&auml;hlen Sie einen Kauf auf Rechnung Provider aus.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_SHIPPING_TITLE', 'Rechnungsadresse und Versandadresse m&uuml;ssen &uuml;bereinstimmen');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_SHIPPING_DESC', 'Nur einstellbar f&uuml;r payolution');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_COUNTRIES_TITLE', 'Erlaubte L&auml;nder f&uuml;r Rechnungsadresse');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_COUNTRIES_DESC', 'Geben Sie erlaubte L&auml;nder ein (e.g. AT,DE)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_CURRENCIES_TITLE', 'Akzeptierte W&auml;hrungen');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_CURRENCIES_DESC', 'Geben Sie erlaubte W&auml;hrungen ein (e.g. EUR,CHF)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MIN_AMOUNT_TITLE','Mindestbetrag Kauf auf Rechnung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MIN_AMOUNT_DESC','Geben Sie den Mindestbetrag f&uuml;r Kauf auf Rechnung an.  (&euro;)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MAX_AMOUNT_TITLE','H&ouml;chstbetrag Kauf auf Rechnung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INVOICE_MAX_AMOUNT_DESC','Geben Sie den H&ouml;chstbetrag f&uuml;r Kauf auf Rechnung an.  (&euro;)');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_PROVIDER_TITLE', 'Provider f&uuml;r Kauf auf Raten');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_PROVIDER_DESC', 'W&auml;hlen Sie einen Kauf auf Raten Provider aus.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_SHIPPING_TITLE', 'Rechnungsadresse und Versandadresse m&uuml;ssen &uuml;bereinstimmen');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_SHIPPING_DESC', 'Nur einstellbar f&uuml;r payolution');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_COUNTRIES_TITLE', 'Erlaubte L&auml;nder f&uuml;r Rechnungsadresse');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_COUNTRIES_DESC', 'Geben Sie erlaubte L&auml;nder ein (e.g. AT,DE)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_CURRENCIES_TITLE', 'Akzeptierte W&auml;hrungen');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_CURRENCIES_DESC', 'Geben Sie erlaubte W&auml;hrungen ein (e.g. EUR,CHF)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MIN_AMOUNT_TITLE','Mindestbetrag Kauf auf Raten');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MIN_AMOUNT_DESC','Geben Sie den Mindestbetrag f&uuml;r Kauf auf Raten an.  (&euro;)');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MAX_AMOUNT_TITLE','H&ouml;chstbetrag Kauf auf Raten');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_INSTALLMENT_MAX_AMOUNT_DESC','Geben Sie den H&ouml;chstbetrag f&uuml;r Kauf auf Raten an.  (&euro;)');


define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT_TITLE','Kunden Abrechnungstext Prefix');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CUSTOMER_STATEMENT_DESC', '');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT_TITLE','Text auf der Bezahlseite');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_TEXT_DISPLAYTEXT_DESC', 'Text, der dem Kunden zu den Bestelldaten angezeigt wird');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SERVICEURL_TITLE','URL zur Kontakt-Seite');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SERVICEURL_DESC','URL der Kontakt-Seite (Impressum) des Onlineshops.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IMAGEURL_TITLE','Bild URL auf der Bezahlseite');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_IMAGEURL_DESC','Url zu Ihrem Logo auf der Bezahlseite (vorzugsweise 95x65 Pixel).');
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

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TITLE', 'payolution Nutzungsbedingungen');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_DESC', 'Kunden m&uuml;ssen die Nutzungsbedingungen von payolution w&auml;hrend des Bezahlprozesses akzeptieren.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_MID_TITLE', 'payolution mID');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYOLUTION_MID_DESC', 'payolution-H&auml;ndler-ID, Nicht base64 kodiert.');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TEXT_INSTALLMENT', 'Mit der &Uuml;bermittlung der f&uuml;r die Abwicklung des Ratenkaufes und einer Identit&auml;ts- und Bonit&auml;tspr&uuml;fung erforderlichen Daten an payolution bin ich einverstanden. Meine <a href="%s" target="_blank"><strong>Einwilligung</strong></a> kann ich jederzeit mit Wirkung f&uuml;r die Zukunft widerrufen.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SHOW_PAYOLUTION_INFOTEXT_TEXT_INVOICE', 'Mit der &Uuml;bermittlung der f&uuml;r die Abwicklung des Rechnungskaufes und einer Identit&auml;ts- und Bonit&auml;tspr&uuml;fung erforderlichen Daten an payolution bin ich einverstanden. Meine <a href="%s" target="_blank"><strong>Einwilligung</strong></a> kann ich jederzeit mit Wirkung f&uuml;r die Zukunft widerrufen.');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_TEXT','Kreditkarte');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MASTERPASS_TEXT', 'Masterpass');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MAESTRO_TEXT','Maestro SecureCode');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EPS_TEXT','eps Online-&Uuml;berweisung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PBX_TEXT','paybox');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PSC_TEXT','paysafecard');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_QUICK_TEXT','@Quick');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SEPA_DD_TEXT','SEPA Lastschrift');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_IDL_TEXT','iDEAL');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PAYPAL_TEXT','PayPal');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_GIROPAY_TEXT','giropay');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_SOFORTUEBERWEISUNG_TEXT','sofort&uuml;berweisung.de');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INVOICE_TEXT','Kauf auf Rechnung');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_CCARD_MOTO_TEXT','Kreditkarte - Post / Telefonbestellung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_BANCONTACT_TEXT','Bancontact');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_EKONTO_TEXT','eKonto');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_INSTALLMENT_TEXT','Kauf auf Raten');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_TRUSTLY_TEXT','Trustly');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_MONETA_TEXT','moneta.ru');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_PRZELEWY24_TEXT','Przelewy24');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYSYS_POLI_TEXT','POLi');
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


define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE_TITLE', 'Konfiguration');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PLUGIN_MODE_DESC', 'Zum Testen der Integration eine vordefinierte Konfiguration ausw&auml;hlen. F&uuml;r Produktivsysteme "Production" ausw&auml;hlen.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DUPLICATE_REQUEST_CHECK_TITLE', 'Duplicate-Request-Check');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DUPLICATE_REQUEST_CHECK_DESC', 'Pr&uuml;fen, ob die gleiche Bestellung versehentlich mehrmals gestartet wurden.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_AUTO_DEPOSIT_TITLE', 'Automatisches abbuchen');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_AUTO_DEPOSIT_DESC', 'Automatisches Abbuchen der Zahlungen. Bitte kontaktieren Sie unsere Sales-Teams um dieses Feature freizuschalten.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRMATION_MAIL_TITLE', 'Best&auml;tigungsmail');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_CONFIRMATION_MAIL_DESC', 'Zahlungsbest&auml;tigung per E-Mail aktivieren.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_MAX_RETRIES_TITLE', 'Max. Versuche');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_MAX_RETRIES_DESC', 'Anzahl der maximalen Zahlungsversuche.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENTTYPE_SORT_ORDER_TITLE', 'Anzeigereihenfolge');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_PAYMENTTYPE_SORT_ORDER_DESC', 'Anzeigereihenfolge f&uuml;r Zahlungsmittel und deren untergeordnete Zahlungsmittel auf der Select-Seite festlegen.');

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CART_DATA_TITLE', 'Warenkorbdaten des Konsumenten mitsenden');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_CART_DATA_DESC', 'Weiterleitung des Warenkorbs des Kunden an den Finanzdienstleister.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_SHIPPING_DATA_TITLE', 'Versanddaten des Konsumenten mitsenden');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_SHIPPING_DATA_DESC', 'Weiterleitung der Versanddaten des Kunden an den Finanzdienstleister.');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_BILLING_DATA_TITLE', 'Verrechnungsdaten des Konsumenten mitsenden');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_SEND_BILLING_DATA_DESC', 'Weiterleitung der Rechnungsdaten des Kunden an den Finanzdienstleister.');

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

define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DEVICE_DETECTION_TITLE', 'Automatische Ger&auml;teerkennung');
define('MODULE_PAYMENT_WIRECARD_CHECKOUT_PAGE_DEVICE_DETECTION_DESC', 'Erkennen des Kundenger&auml;ts (Smartphone, Tablet, Desktop PC) zum Anzeigen einer optimierten Zahlseite.');

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
