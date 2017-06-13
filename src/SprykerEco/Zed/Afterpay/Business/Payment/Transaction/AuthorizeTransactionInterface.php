<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction;

use Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer;
use Generated\Shared\Transfer\AfterpayRequestTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Zed\Afterpay\Business\Payment\Type\PaymentWithAuthorizeInterface;

interface AuthorizeTransactionInterface
{

    /**
     * @param \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function executeTransaction(AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer);

}
