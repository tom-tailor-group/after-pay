<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Afterpay\AfterpayConstants;

class AfterpayConfig extends AbstractBundleConfig
{

    /**
     * @return string
     */
    public function getApiEndpointBaseUrl()
    {
        return $this->get(AfterpayConstants::API_ENDPOINT_BASE_URL);
    }

    /**
     * @param string $endpoint
     *
     * @return string
     */
    public function getApiEndpointPath($endpoint)
    {
        switch ($endpoint) {
            case AfterpayConstants::API_ENDPOINT_AVAILABLE_PAYMENT_METHODS:
                return AfterpayConstants::API_ENDPOINT_AVAILABLE_PAYMENT_METHODS_PATH;

            case AfterpayConstants::API_ENDPOINT_AUTHORIZE:
                return AfterpayConstants::API_ENDPOINT_AUTHORIZE_PATH;

            case AfterpayConstants::API_ENDPOINT_VALIDATE_ADDRESS:
                return AfterpayConstants::API_ENDPOINT_VALIDATE_ADDRESS_PATH;
        }
    }

    /**
     * @return string
     */
    public function getApiCredentialsAuthKey()
    {
        return $this->get(AfterpayConstants::API_CREDENTIALS_AUTH_KEY);
    }

    /**
     * @return string
     */
    public function getAfterpayAuthorizeWorkflow()
    {
        return $this->get(AfterpayConstants::AFTERPAY_AUTHORIZE_WORKFLOW);
    }

    /**
     * @param string $paymentMethod
     *
     * @return string
     */
    public function getPaymentChannelId($paymentMethod)
    {
        switch ($paymentMethod) {
            case AfterpayConstants::PAYMENT_METHOD_INVOICE:
                return $this->get(AfterpayConstants::PAYMENT_INVOICE_CHANNEL_ID);
            default:
                return $this->get(AfterpayConstants::PAYMENT_INVOICE_CHANNEL_ID);
        }
    }

}
