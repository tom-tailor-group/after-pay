<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Handler;

use Generated\Shared\Transfer\AfterpayCallTransfer;
use SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Authorize\RequestBuilder\AuthorizeRequestBuilderInterface;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\AuthorizeTransactionInterface;

class AuthorizeTransactionHandler implements AuthorizeTransactionHandlerInterface
{
    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\AuthorizeTransactionInterface
     */
    protected $transaction;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Authorize\RequestBuilder\AuthorizeRequestBuilderInterface
     */
    protected $requestBuilder;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface
     */
    protected $paymentWriter;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\AuthorizeTransactionInterface $transaction
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Authorize\RequestBuilder\AuthorizeRequestBuilderInterface $requestBuilder
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface $paymentWriter
     */
    public function __construct(
        AuthorizeTransactionInterface $transaction,
        AuthorizeRequestBuilderInterface $requestBuilder,
        PaymentWriterInterface $paymentWriter
    ) {
        $this->transaction = $transaction;
        $this->requestBuilder = $requestBuilder;
        $this->paymentWriter = $paymentWriter;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayCallTransfer $afterpayCallTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function authorize(AfterpayCallTransfer $afterpayCallTransfer)
    {
        $authorizeRequestTransfer = $this->buildAuthorizeRequest($afterpayCallTransfer);

        return $this->transaction->executeTransaction($authorizeRequestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayCallTransfer $afterpayCallTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer
     */
    protected function buildAuthorizeRequest(AfterpayCallTransfer $afterpayCallTransfer)
    {
        $authorizeRequestTransfer = $this->requestBuilder->buildAuthorizeRequest($afterpayCallTransfer);

        return $authorizeRequestTransfer;
    }
}
