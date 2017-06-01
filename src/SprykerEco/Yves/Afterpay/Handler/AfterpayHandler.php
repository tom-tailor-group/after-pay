<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay\Handler;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;
use SprykerEco\Shared\Afterpay\AfterpayConstants;

class AfterpayHandler implements AfterpayHandlerInterface
{

    const PAYMENT_PROVIDER = AfterpayConstants::PROVIDER_NAME;
    const CHECKOUT_PARTIAL_SUMMARY_PATH = 'Afterpay/partial/summary';

    /**
     * @var array
     */
    protected static $paymentMethods = [
        AfterpayConstants::PAYMENT_METHOD_INVOICE => AfterpayConstants::PAYMENT_METHOD_INVOICE,
    ];

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer|\Generated\Shared\Transfer\QuoteTransfer $quoteTransfer
     *
     * @return \Spryker\Shared\Kernel\Transfer\AbstractTransfer
     */
    public function addPaymentToQuote(AbstractTransfer $quoteTransfer)
    {
        $paymentSelection = $quoteTransfer->getPayment()->getPaymentSelection();
        $quoteTransfer->getPayment()
            ->setPaymentProvider(static::PAYMENT_PROVIDER)
            ->setPaymentMethod(static::$paymentMethods[$paymentSelection]);

        return $quoteTransfer;
    }

}
