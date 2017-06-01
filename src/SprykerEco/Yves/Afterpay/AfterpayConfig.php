<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay;

use Spryker\Zed\Kernel\AbstractBundleConfig;
use SprykerEco\Shared\Afterpay\AfterpayConstants;

class AfterpayConfig extends AbstractBundleConfig
{

    /**
     * @return string
     */
    public function getAfterpayAddressValidationIsEnabled()
    {
        return $this->get(AfterpayConstants::AFTERPAY_SERVICE_VALIDATE_ADDRESS_IS_ENABLED);
    }

}
