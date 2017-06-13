<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction;

use Generated\Shared\Transfer\AfterpayApiResponseTransfer;
use Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\AuthorizeWorkflow\AfterpayAuthorizeWorkflowInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Logger\TransactionLoggerInterface;

class AuthorizeTransaction implements AuthorizeTransactionInterface
{

    const TRANSACTION_TYPE = AfterpayConstants::TRANSACTION_TYPE_AUTHORIZE;

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
     * @param \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function executeTransaction(AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer)
    {
        $authorizeResponseTransfer = $this->apiAdapter->sendAuthorizationRequest($authorizeRequestTransfer);
        $this->logTransaction($authorizeRequestTransfer, $authorizeResponseTransfer);

        return $authorizeResponseTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
     * @param \Generated\Shared\Transfer\AfterpayApiResponseTransfer $authorizeResponseTransfer
     *
     * @return void
     */
    protected function logTransaction(
        AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer,
        AfterpayApiResponseTransfer $authorizeResponseTransfer
    ) {
        $this->transactionLogger->logTransaction(
            static::TRANSACTION_TYPE,
            $authorizeRequestTransfer,
            $authorizeResponseTransfer
        );
    }
}
