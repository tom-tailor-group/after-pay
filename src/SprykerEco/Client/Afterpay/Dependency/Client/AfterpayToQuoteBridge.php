<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Afterpay\Dependency\Client;

class AfterpayToQuoteBridge implements AfterpayToQuoteInterface
{

    /**
     * @var \Spryker\Client\Quote\Session\QuoteSessionInterface
     */
    protected $quoteSession;

    /**
     * @param \Spryker\Client\Quote\Session\QuoteSessionInterface $quoteSession
     */
    public function __construct($quoteSession)
    {
        $this->quoteSession = $quoteSession;
    }

    /**
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getQuote()
    {
        return $this->quoteSession->getQuote();
    }

}
