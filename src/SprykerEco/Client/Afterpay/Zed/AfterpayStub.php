<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Afterpay\Zed;

use Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\ZedRequest\Stub\ZedRequestStub;

class AfterpayStub extends ZedRequestStub implements AfterpayStubInterface
{

    const ZED_GET_AVAILABLE_PAYMENT_METHODS = '/afterpay/gateway/get-available-payment-methods';
    const ZED_VALIDATE_CUSTOMER_ADDRESS = '/afterpay/gateway/validate-customer-address';

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface|\Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsTransfer
     */
    public function getAvailablePaymentMethodsByQuote(QuoteTransfer $quoteTransfer)
    {
        return $this->zedStub->call(
            static::ZED_GET_AVAILABLE_PAYMENT_METHODS,
            $quoteTransfer
        );
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\TransferInterface|\Generated\Shared\Transfer\AfterpayValidateCustomerResponseTransfer
     */
    public function validateCustomerAddress(AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer)
    {
        return $this->zedStub->call(
            static::ZED_VALIDATE_CUSTOMER_ADDRESS,
            $validateCustomerRequestTransfer
        );
    }

}
