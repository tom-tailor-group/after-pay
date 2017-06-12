<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Afterpay\Zed;

use Generated\Shared\Transfer\QuoteTransfer;

interface AfterpayStubInterface
{

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsTransfer
     */
    public function getAvailablePaymentMethodsByQuote(QuoteTransfer $quoteTransfer);

}
