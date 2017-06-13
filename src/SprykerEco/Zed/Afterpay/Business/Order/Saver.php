<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Order;

use Generated\Shared\Transfer\CheckoutResponseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpay;
use Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpayOrderItem;
use Spryker\Zed\PropelOrm\Business\Transaction\DatabaseTransactionHandlerTrait;

class Saver implements SaverInterface
{

    use DatabaseTransactionHandlerTrait;

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    public function saveOrderPayment(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer)
    {
        $this->handleDatabaseTransaction(function () use ($quoteTransfer, $checkoutResponseTransfer) {
            $this->executeSavePaymentForOrderAndItemsTransaction($quoteTransfer, $checkoutResponseTransfer);
        });
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return void
     */
    protected function executeSavePaymentForOrderAndItemsTransaction(
        QuoteTransfer $quoteTransfer,
        CheckoutResponseTransfer $checkoutResponseTransfer
    ) {

        $paymentEntity = $this->buildPaymentEntity($quoteTransfer, $checkoutResponseTransfer);
        $paymentEntity->save();

        $idPayment = $paymentEntity->getIdPaymentAfterpay();

        foreach ($checkoutResponseTransfer->getSaveOrder()->getOrderItems() as $orderItem) {
            $this->savePaymentForOrderItem($orderItem, $idPayment);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $orderItemTransfer
     * @param int $idPayment
     *
     * @return void
     */
    protected function savePaymentForOrderItem(ItemTransfer $orderItemTransfer, $idPayment)
    {
        $paymentOrderItemEntity = new SpyPaymentAfterpayOrderItem();
        $paymentOrderItemEntity
            ->setFkPaymentAfterpay($idPayment)
            ->setFkSalesOrderItem($orderItemTransfer->getIdSalesOrderItem());

        $paymentOrderItemEntity->save();
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     * @param \Generated\Shared\Transfer\CheckoutResponseTransfer $checkoutResponseTransfer
     *
     * @return \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpay
     */
    protected function buildPaymentEntity(QuoteTransfer $quoteTransfer, CheckoutResponseTransfer $checkoutResponseTransfer): \Orm\Zed\Afterpay\Persistence\SpyPaymentAfterpay
    {
        $paymentEntity = new SpyPaymentAfterpay();
        $paymentEntity
            ->setPaymentMethod($quoteTransfer->getPayment()->getPaymentMethod())
            ->setFkSalesOrder($checkoutResponseTransfer->getSaveOrder()->getIdSalesOrder())
            ->setIdCheckout($quoteTransfer->getPayment()->getAfterpayCheckoutId());

        return $paymentEntity;
    }

}
