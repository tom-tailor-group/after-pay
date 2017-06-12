<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay\Checkout\Process;

use Generated\Shared\Transfer\AfterpayPaymentTransfer;
use Generated\Shared\Transfer\QuoteTransfer;
use Spryker\Yves\StepEngine\Dependency\Form\AbstractSubFormType;
use Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface;
use SprykerEco\Client\Afterpay\AfterpayClientInterface;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEco\Yves\Afterpay\Checkout\Process\PrePaymentQuoteExpanderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RiskCheckQuoteExpander implements PrePaymentQuoteExpanderInterface
{

    /**
     * @var \SprykerEco\Client\Afterpay\AfterpayClientInterface
     */
    protected $afterpayClient;

    /**
     * @param \SprykerEco\Client\Afterpay\AfterpayClientInterface $afterpayClient
     */
    public function __construct(AfterpayClientInterface $afterpayClient)
    {
        $this->afterpayClient = $afterpayClient;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuote(QuoteTransfer $quoteTransfer)
    {
        $availablePaymentMethods = $this->afterpayClient->getAvailablePaymentMethods($quoteTransfer);
        $quoteTransfer->setAfterpayRiskCheckInfo($availablePaymentMethods);

        return $quoteTransfer;
    }

}
