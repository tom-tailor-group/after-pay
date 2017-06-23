<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\AdditionalServices\Handler;

use Generated\Shared\Transfer\AddressTransfer;
use Generated\Shared\Transfer\AfterpayCustomerLookupRequestTransfer;
use Generated\Shared\Transfer\AfterpayValidateBankAccountRequestTransfer;
use Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToCustomerInterface;

class LookupCustomerHandler implements LookupCustomerHandlerInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface
     */
    protected $apiAdapter;

    /**
     * @var \SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToCustomerInterface
     */
    protected $customerFacade;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface $apiAdapter
     */
    public function __construct(AdapterInterface $apiAdapter)
    {
        $this->apiAdapter = $apiAdapter;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayCustomerLookupRequestTransfer $customerLookupRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayCustomerLookupResponseTransfer
     */
    public function lookupCustomer(AfterpayCustomerLookupRequestTransfer $customerLookupRequestTransfer)
    {
        return $this->apiAdapter->sendLookupCustomerRequest($customerLookupRequestTransfer);
    }

}
