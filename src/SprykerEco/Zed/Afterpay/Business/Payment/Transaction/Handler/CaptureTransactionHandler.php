<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Handler;

use Generated\Shared\Transfer\AfterpayCaptureRequestTransfer;
use Generated\Shared\Transfer\AfterpayCaptureResponseTransfer;
use Generated\Shared\Transfer\AfterpayPaymentTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Afterpay\Business\Payment\PaymentReaderInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Capture\CaptureRequestBuilderInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\CaptureTransactionInterface;

class CaptureTransactionHandler implements CaptureTransactionHandlerInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\CaptureTransactionInterface
     */
    protected $transaction;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\PaymentReaderInterface
     */
    protected $paymentReader;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Capture\CaptureRequestBuilderInterface
     */
    private $captureRequestBuilder;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface
     */
    private $paymentWriter;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\CaptureTransactionInterface $transaction
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\PaymentReaderInterface $paymentReader
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface $paymentWriter
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Capture\CaptureRequestBuilderInterface $captureRequestBuilder
     */
    public function __construct(
        CaptureTransactionInterface $transaction,
        PaymentReaderInterface $paymentReader,
        PaymentWriterInterface $paymentWriter,
        CaptureRequestBuilderInterface $captureRequestBuilder
    ) {
        $this->transaction = $transaction;
        $this->paymentReader = $paymentReader;
        $this->captureRequestBuilder = $captureRequestBuilder;
        $this->paymentWriter = $paymentWriter;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return void
     */
    public function capture(ItemTransfer $itemTransfer, OrderTransfer $orderTransfer)
    {
        $captureRequestTransfer = $this->buildCaptureRequestForOrderItem($itemTransfer, $orderTransfer);
        $paymentTransfer = $this->getPaymentTransferForItem($itemTransfer);

        if ($this->isFirstItemToCapture($paymentTransfer)) {
            $this->addExpensesToCaptureRequest($paymentTransfer->getExpenseTotal(), $captureRequestTransfer);
        }

        $captureResponseTransfer = $this->transaction->executeTransaction($captureRequestTransfer);

        $this->updateOrderPayment(
            $captureResponseTransfer,
            $orderTransfer->getIdSalesOrder()
        );
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayCaptureRequestTransfer
     */
    protected function buildCaptureRequestForOrderItem(ItemTransfer $itemTransfer, OrderTransfer $orderTransfer)
    {
        $captureRequestTransfer = $this->captureRequestBuilder
            ->buildBaseCaptureRequestForOrder($orderTransfer);

        $this->captureRequestBuilder
            ->addOrderItemToCaptureRequest(
                $itemTransfer,
                $captureRequestTransfer
            );

        return $captureRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayPaymentTransfer $paymentTransfer
     *
     * @return bool
     */
    protected function isFirstItemToCapture(AfterpayPaymentTransfer $paymentTransfer)
    {
        return $paymentTransfer->getCapturedTotal() - $paymentTransfer->getRefundedTotal() == 0;
    }

    /**
     * @param int $expenseTotal
     * @param \Generated\Shared\Transfer\AfterpayCaptureRequestTransfer $captureRequestTransfer
     *
     * @return void
     */
    protected function addExpensesToCaptureRequest(
        $expenseTotal,
        AfterpayCaptureRequestTransfer $captureRequestTransfer
    ) {
        $this->captureRequestBuilder
            ->addOrderExpenseToCaptureRequest(
                $expenseTotal,
                $captureRequestTransfer
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
     * @param \Generated\Shared\Transfer\AfterpayCaptureResponseTransfer $capturedResponseTransfer
     * @param int $idSalesOrder
     *
     * @return void
     */
    protected function updateOrderPayment(AfterpayCaptureResponseTransfer $capturedResponseTransfer, $idSalesOrder)
    {
        if (!$capturedResponseTransfer->getCapturedAmount()) {
            return;
        }

        $this->paymentWriter->increaseTotalCapturedAmountByIdSalesOrder(
            $capturedResponseTransfer->getCapturedAmount(),
            $idSalesOrder
        );

        $this->paymentWriter->setCaptureNumberByIdSalesOrder(
            $capturedResponseTransfer->getCaptureNumber(),
            $idSalesOrder
        );
    }

}
