<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction;

use Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer;

interface CaptureTransactionInterface
{

    /**
     * @param \Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer $fullCaptureRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function executeTransaction(AfterpayItemCaptureRequestTransfer $fullCaptureRequestTransfer);

}
