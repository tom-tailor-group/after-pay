<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Authorize\RequestBuilder;

use Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;

class OneStepAuthorizeRequestBuilder implements AuthorizeRequestBuilderInterface
{

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer
     */
    public function buildAuthorizeRequest(OrderTransfer $orderWithPaymentTransfer)
    {
        $authorizeRequestTransfer = new AfterpayAuthorizeRequestTransfer();

        $this->addOrderWithItems($authorizeRequestTransfer, $orderWithPaymentTransfer);
        $this->addCustomerWithBillingAddress($authorizeRequestTransfer, $orderWithPaymentTransfer);
        $this->addPaymentDetails($authorizeRequestTransfer, $orderWithPaymentTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return void
     */
    protected function addOrderWithItems(
        AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer,
        OrderTransfer $orderWithPaymentTransfer
    ) {
        // todo: to be implemented
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return void
     */
    protected function addCustomerWithBillingAddress(
        AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer,
        OrderTransfer $orderWithPaymentTransfer
    ) {
        // todo: to be implemented
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderWithPaymentTransfer
     *
     * @return void
     */
    protected function addPaymentDetails(
        AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer,
        OrderTransfer $orderWithPaymentTransfer
    ) {
        // todo: to be implemented
    }

}
