<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\AdditionalServices\Handler;

use Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface;

class ValidateCustomerHandler implements ValidateCustomerHandlerInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface
     */
    protected $apiAdapter;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface $apiAdapter
     */
    public function __construct(AdapterInterface $apiAdapter)
    {
        $this->apiAdapter = $apiAdapter;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayValidateCustomerResponseTransfer
     */
    public function validateCustomer(AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer)
    {
        return $this->apiAdapter->sendValidateCustomerRequest($validateCustomerRequestTransfer);
    }

}
