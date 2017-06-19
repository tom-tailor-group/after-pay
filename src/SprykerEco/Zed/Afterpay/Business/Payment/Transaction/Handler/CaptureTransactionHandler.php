<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Handler;

use Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\CaptureTransactionInterface;

class CaptureTransactionHandler implements CaptureTransactionHandlerInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\CaptureTransactionInterface
     */
    protected $transaction;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\CaptureTransactionInterface $transaction
     */
    public function __construct(CaptureTransactionInterface $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return void
     */
    public function capture(ItemTransfer $itemTransfer)
    {
        $captureRequestTransfer = $this->buildCaptureRequest($itemTransfer);
        $this->transaction->executeTransaction($captureRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $itemTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer
     */
    protected function buildCaptureRequest(ItemTransfer $itemTransfer)
    {
        $fullCaptureRequestTransfer = (new AfterpayItemCaptureRequestTransfer())
            ->setOrderNumber($orderTransfer->getOrderReference())
            ->setFkSalesOrder($orderTransfer->getIdSalesOrder());

        return $fullCaptureRequestTransfer;
    }

}
