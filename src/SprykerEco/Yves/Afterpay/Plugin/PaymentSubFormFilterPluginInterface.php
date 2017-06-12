<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay\Plugin;

use Spryker\Yves\StepEngine\Dependency\Plugin\Form\SubFormPluginCollection;

interface PaymentSubFormFilterPluginInterface
{

    /**
     * @param \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface[] $paymentSubforms
     *
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface[]
     */
    public function filterPaymentSubforms(array $paymentSubforms);

}
