<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Afterpay;

interface AfterpayConstants
{

    const PROVIDER_NAME = 'afterpay';

    const VENDOR_ROOT = 'VENDOR_ROOT';
    const PAYMENT_METHOD_INVOICE = self::PROVIDER_NAME . 'Invoice';


    const TRANSACTION_TYPE_AUTHORIZE = 'authorize';
    const TRANSACTION_TYPE_CAPTURE = 'capture';

    const AFTERPAY_SERVICE_VALIDATE_ADDRESS_IS_ENABLED = 'AFTERPAY_SERVICE_VALIDATE_ADDRESS_IS_ENABLED';
    const AFTERPAY_RISK_CHECK_CONFIGURATION = 'AFTERPAY_RISK_CHECK_CONFIGURATION';

    const PAYMENT_SUB_FORM_CHECKERS = 'PAYMENT_SUB_FORM_CHECKERS';
    const PRE_PAYMENT_QUOTE_EXPANDERS = 'PRE_PAYMENT_QUOTE_EXPANDERS';

    const RISK_CHECK_METHOD_INVOICE = 'Invoice';

}
