<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\AfterpayAuthorizeTransactionLogRequestTransfer;
use Generated\Shared\Transfer\AfterpayRegistrationByIdAndQuoteRequestTransfer;
use Generated\Shared\Transfer\AfterpayRegistrationRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @method \SprykerEco\Zed\Afterpay\Business\AfterpayBusinessFactory getFactory()
 */
class AfterpayFacade extends AbstractFacade implements AfterpayFacadeInterface
{

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsTransfer
     */
    public function getAvailablePaymentMethods(QuoteTransfer $quoteTransfer)
    {
        return $this->getFactory()
            ->createAvailablePaymentMethodsHandler()
            ->getAvailablePaymentMethods($quoteTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function saveOrderPayment(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        $this->getFactory()
            ->createOrderSaver()
            ->saveOrderPayment($quoteTransfer, $checkoutResponseTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayResponseTransfer
     */
    public function authorizePayment(OrderTransfer $orderTransfer)
    {
        $this->getFactory()
            ->createAuthorizeTransactionHandler()
            ->authorize($orderTransfer);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param int $idSalesOrder
     *
     * @return \Generated\Shared\Transfer\AfterpayPaymentTransfer
     */
    public function getPaymentByIdSalesOrder($idSalesOrder)
    {
        return $this->getFactory()
            ->createPaymentReader()
            ->getPaymentByIdSalesOrder($idSalesOrder);
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return \Generated\Shared\Transfer\CheckoutResponseTransfer
     */
    public function postSaveHook(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        return $this->getFactory()
            ->createPostSaveHook()
            ->execute($quoteTransfer, $checkoutResponseTransfer);
    }

}
