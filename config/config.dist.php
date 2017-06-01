<?php
/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

/**
 * Copy over the following configs to your config
 */

use Spryker\Shared\Kernel\KernelConstants;
use Spryker\Shared\Oms\OmsConstants;
use Spryker\Shared\Sales\SalesConstants;
use Spryker\Zed\Oms\OmsConfig;
use SprykerEco\Shared\Afterpay\AfterpayConstants;

// Afterpay configuration

// Merchant config values, got from Afterpay

$config[AfterpayConstants::AFTERPAY_SERVICE_VALIDATE_ADDRESS_IS_ENABLED] = true;

$config[KernelConstants::DEPENDENCY_INJECTOR_YVES] = [
    'Checkout' => [
        'Afterpay',
    ],
];

$config[KernelConstants::DEPENDENCY_INJECTOR_ZED] = [
    'Payment' => [
        'Afterpay',
    ],
    'Oms' => [
        'Afterpay',
    ],
];

$config[OmsConstants::PROCESS_LOCATION] = [
    OmsConfig::DEFAULT_PROCESS_LOCATION,
    $config[KernelConstants::SPRYKER_ROOT] . '/heidelpay/config/Zed/Oms',
];

$config[OmsConstants::ACTIVE_PROCESSES] = [
    'AfterpayInvoice01',
];

$config[SalesConstants::PAYMENT_METHOD_STATEMACHINE_MAPPING] = [
    AfterpayConstants::PAYMENT_METHOD_INVOICE => 'AfterpayInvoice01',
];
