<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business;

use Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer;
use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
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
     * @param \Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayValidateCustomerResponseTransfer
     */
    public function validateCustomerAddress(
        AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
    ) {
        return $this->getFactory()
            ->createValidateCustomerHandler()
            ->validateCustomer($validateCustomerRequestTransfer);
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
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayResponseTransfer
     */
    public function capturePayment(ItemTransfer $itemTransfer, OrderTransfer $orderTransfer)
    {
        $this->getFactory()
            ->createCaptureTransactionHandler()
            ->capture($itemTransfer, $orderTransfer);
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
     * @return string
     */
    public function getApiVersion()
    {
        return $this->getFactory()
            ->createApiAdapter()
            ->getApiVersion();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return int
     */
    public function getApiStatus()
    {
        return $this->getFactory()
            ->createApiAdapter()
            ->getApiStatus();
    }

}
