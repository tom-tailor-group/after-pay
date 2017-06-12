<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Afterpay;

use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \SprykerEco\Client\Afterpay\AfterpayFactory getFactory()
 */
class AfterpayClient extends AbstractClient implements AfterpayClientInterface
{

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function getQuoteFromSession()
    {
        return $this->getFactory()
            ->getQuoteClient()
            ->getQuote();
    }

    /**
     * {@inheritdoc}
     *
     * @api
     *
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsTransfer
     */
    public function getAvailablePaymentMethods(QuoteTransfer $quoteTransfer)
    {
        return $this->getFactory()
            ->createZedStub()
            ->getAvailablePaymentMethodsByQuote($quoteTransfer);
    }

}
