<?php

namespace SprykerEcoTest\Zed\Afterpay\Mock\Call;

use Generated\Shared\DataBuilder\AfterpayCustomerLookupResponseBuilder;
use Generated\Shared\DataBuilder\AfterpayInstallmentPlansRequestBuilder;
use Generated\Shared\DataBuilder\AfterpayInstallmentPlansResponseBuilder;
use Generated\Shared\Transfer\AfterpayCustomerLookupRequestTransfer;
use Generated\Shared\Transfer\AfterpayInstallmentPlansRequestTransfer;
use Generated\Shared\Transfer\AfterpayInstallmentPlansResponseTransfer;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall\LookupCustomerCall;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall\LookupInstallmentPlansCall;

class LookupInstallmentPlansCallMock extends LookupInstallmentPlansCall
{
    /**
     * @param \Generated\Shared\Transfer\AfterpayInstallmentPlansRequestTransfer $installmentPlansRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayInstallmentPlansResponseTransfer
     */
    public function execute(AfterpayInstallmentPlansRequestTransfer $installmentPlansRequestTransfer)
    {
        return (new AfterpayInstallmentPlansResponseBuilder())
            ->withInstallmentPlan()
            ->build();
    }
}
