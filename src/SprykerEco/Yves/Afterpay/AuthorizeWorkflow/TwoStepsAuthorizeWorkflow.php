<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay\AuthorizeWorkflow;

use Generated\Shared\Transfer\QuoteTransfer;
use SprykerEco\Yves\Afterpay\AuthorizeWorkflow\Steps\AvailablePaymentMethodsStepInterface;
use SprykerEco\Yves\Afterpay\AuthorizeWorkflow\Steps\PaymentSubformsFilterInterface;

class TwoStepsAuthorizeWorkflow extends AbstractAfterpayAuthorizeWorkflow implements AfterpayAuthorizeWorkflowInterface
{

    /**
     * @var \SprykerEco\Yves\Afterpay\AuthorizeWorkflow\Steps\AvailablePaymentMethodsStepInterface
     */
    protected $availablePaymentMethodsStep;

    /**
     * @var \SprykerEco\Yves\Afterpay\AuthorizeWorkflow\Steps\PaymentSubformsFilterInterface
     */
    protected $paymentSubformsFilter;

    /**
     * @param \SprykerEco\Yves\Afterpay\AuthorizeWorkflow\Steps\AvailablePaymentMethodsStepInterface $availablePaymentMethodsStep
     * @param \SprykerEco\Yves\Afterpay\AuthorizeWorkflow\Steps\PaymentSubformsFilterInterface $paymentSubformsFilter
     */
    public function __construct(
        AvailablePaymentMethodsStepInterface $availablePaymentMethodsStep,
        PaymentSubformsFilterInterface $paymentSubformsFilter
    ) {

        $this->availablePaymentMethodsStep = $availablePaymentMethodsStep;
        $this->paymentSubformsFilter = $paymentSubformsFilter;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuoteBeforePaymentStep(QuoteTransfer $quoteTransfer)
    {
        $availablePaymentMethods = $this
            ->availablePaymentMethodsStep
            ->getAvailablePaymentMethods($quoteTransfer);

        $quoteTransfer->setAfterpayAvailablePaymentMethods($availablePaymentMethods);

        return $quoteTransfer;
    }

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface[] $paymentSubforms
     *
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface[]
     */
    public function filterAvailablePaymentMethods(array $paymentSubforms)
    {
        $filteredPaymentSubforms = $this
            ->paymentSubformsFilter
            ->filterPaymentSubforms($paymentSubforms);

        return $filteredPaymentSubforms;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function addPaymentDataToQuote(QuoteTransfer $quoteTransfer)
    {
        $quoteTransfer = parent::addPaymentDataToQuote($quoteTransfer);

        $this->addAvailablePaymentMethodsDataToPayment($quoteTransfer);

        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Generated\Shared\Transfer\QuoteTransfer
     */
    public function expandQuoteAfterPaymentStep(QuoteTransfer $quoteTransfer)
    {
        return $quoteTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return void
     */
    protected function addAvailablePaymentMethodsDataToPayment(QuoteTransfer $quoteTransfer)
    {
        $paymentTransfer = $quoteTransfer->getPayment();
        $availablePaymentMethodsTransfer = $quoteTransfer->getAfterpayAvailablePaymentMethods();

        $paymentTransfer
            ->setAfterpayCheckoutId($availablePaymentMethodsTransfer->getCheckoutId())
            ->setAfterpayCustomerNumber($availablePaymentMethodsTransfer->getCustomerNumber());
    }

}
