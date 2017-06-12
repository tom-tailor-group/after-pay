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
        }
    }

    /**
     * @return string
     */
    public function getApiCredentialsAuthKey()
    {
        return $this->get(AfterpayConstants::API_CREDENTIALS_AUTH_KEY);
    }

}
