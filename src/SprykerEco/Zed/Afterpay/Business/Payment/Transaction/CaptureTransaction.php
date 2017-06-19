<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction;

use Generated\Shared\Transfer\AfterpayApiResponseTransfer;
use Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer;
use Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer;
use Generated\Shared\Transfer\AfterpayFullCaptureResponseTransfer;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Logger\TransactionLoggerInterface;

class CaptureTransaction implements CaptureTransactionInterface
{

    const TRANSACTION_TYPE = AfterpayConstants::TRANSACTION_TYPE_FULL_CAPTURE;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Logger\TransactionLoggerInterface
     */
    protected $transactionLogger;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface
     */
    protected $apiAdapter;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Logger\TransactionLoggerInterface $transactionLogger
     * @param \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface $apiAdapter
     */
    public function __construct(
        TransactionLoggerInterface $transactionLogger,
        AdapterInterface $apiAdapter
    ) {
        $this->transactionLogger = $transactionLogger;
        $this->apiAdapter = $apiAdapter;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer $fullCaptureRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function executeTransaction(AfterpayItemCaptureRequestTransfer $fullCaptureRequestTransfer)
    {
        $fullCaptureResponseTransfer = $this->apiAdapter->sendFullCaptureRequest($fullCaptureRequestTransfer);
        $this->logTransaction($fullCaptureRequestTransfer, $fullCaptureResponseTransfer);

        return $fullCaptureResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer $fullCaptureRequestTransfer
     * @param \Generated\Shared\Transfer\AfterpayApiResponseTransfer $apiResponseTransfer
     *
     * @return void
     */
    protected function logTransaction(
        AfterpayItemCaptureRequestTransfer $fullCaptureRequestTransfer,
        AfterpayApiResponseTransfer $apiResponseTransfer
    ) {
        $this->transactionLogger->logTransaction(
            static::TRANSACTION_TYPE,
            $fullCaptureRequestTransfer,
            $apiResponseTransfer
        );
    }
}
