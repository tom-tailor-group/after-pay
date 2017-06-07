<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Afterpay;

use Generated\Shared\Transfer\QuoteTransfer;

interface AfterpayClientInterface
{
    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return
     */
    public function getAvailablePaymentMethods(QuoteTransfer $quoteTransfer);

    /**
     * Specification:
     *  - Retrieve quote from current customer session
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getQuoteFromSession();

}
