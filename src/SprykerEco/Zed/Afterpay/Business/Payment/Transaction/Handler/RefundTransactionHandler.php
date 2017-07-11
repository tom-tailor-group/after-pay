<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Handler;

use Generated\Shared\Transfer\AfterpayRefundRequestTransfer;
use Generated\Shared\Transfer\AfterpayRefundResponseTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Afterpay\Business\Payment\PaymentReaderInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Refund\RefundRequestBuilderInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\RefundTransactionInterface;

class RefundTransactionHandler implements RefundTransactionHandlerInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\RefundTransactionInterface
     */
    protected $transaction;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\PaymentReaderInterface
     */
    protected $paymentReader;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Refund\RefundRequestBuilderInterface
     */
    private $refundRequestBuilder;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface
     */
    private $paymentWriter;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\RefundTransactionInterface $transaction
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\PaymentReaderInterface $paymentReader
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface $paymentWriter
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Refund\RefundRequestBuilderInterface $refundRequestBuilder
     */
    public function __construct(
        RefundTransactionInterface $transaction,
        PaymentReaderInterface $paymentReader,
        PaymentWriterInterface $paymentWriter,
        RefundRequestBuilderInterface $refundRequestBuilder
    ) {
        $this->transaction = $transaction;
        $this->paymentReader = $paymentReader;
        $this->refundRequestBuilder = $refundRequestBuilder;
        $this->paymentWriter = $paymentWriter;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    public function refund(ItemTransfer $itemTransfer, OrderTransfer $orderTransfer)
    {
        $refundRequestTransfer = $this->buildRefundRequestForOrderItem($itemTransfer, $orderTransfer);
        $paymentTransfer = $this->getPaymentTransferForItem($itemTransfer);

        // Refund expences with the last order item.
        if ($this->isLastItemToRefund($itemTransfer, $paymentTransfer)) {
            $this->addExpensesToRefundRequest($paymentTransfer->getExpenseTotal(), $refundRequestTransfer);
        }

        $refundResponseTransfer = $this->transaction->executeTransaction($refundRequestTransfer);

        $this->updateOrderPayment(
            $refundResponseTransfer,
            $orderTransfer->getIdSalesOrder()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRefundRequestTransfer
     */
    protected function buildRefundRequestForOrderItem(ItemTransfer $itemTransfer, OrderTransfer $orderTransfer)
    {
        $refundRequestTransfer = $this->refundRequestBuilder
            ->buildBaseRefundRequestForOrder($orderTransfer);

        $this->refundRequestBuilder
            ->addOrderItemToRefundRequest(
                $itemTransfer,
                $refundRequestTransfer
            );

        return $refundRequestTransfer;
    }

    /**
     * @param int $expenseTotal
     * @param \Generated\Shared\Transfer\AfterpayRefundRequestTransfer $refundRequestTransfer
     *
     * @return void
     */
    protected function addExpensesToRefundRequest(
        $expenseTotal,
        AfterpayRefundRequestTransfer $refundRequestTransfer
    ) {
        $this->refundRequestBuilder
            ->addOrderExpenseToRefundRequest(
                $expenseTotal,
                $refundRequestTransfer
            );
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayPaymentTransfer
     */
    protected function getPaymentTransferForItem(ItemTransfer $itemTransfer)
    {
        return $this->paymentReader
            ->getPaymentByIdSalesOrder(
                $itemTransfer->getFkSalesOrder()
            );
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayRefundResponseTransfer $refundResponseTransfer
     * @param int $idSalesOrder
     *
     * @return void
     */
    protected function updateOrderPayment(AfterpayRefundResponseTransfer $refundResponseTransfer, $idSalesOrder)
    {
        if (!$refundResponseTransfer->getTotalCapturedAmount()) {
            return;
        }

        $this->paymentWriter->saveTotalCapturedAmountByIdSalesOrder(
            $refundResponseTransfer->getTotalCapturedAmount(),
            $idSalesOrder
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\AfterpayPaymentTransfer $paymentTransfer
     *
     * @return bool
     */
    protected function isLastItemToRefund($itemTransfer, $paymentTransfer)
    {
        return $itemTransfer->getRefundableAmount() + $paymentTransfer->getExpenseTotal()
            === $paymentTransfer->getCapturedTotal();
    }

}
