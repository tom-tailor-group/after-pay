<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay\Plugin;

use Generated\Shared\Transfer\AfterpayInstallmentPlansRequestTransfer;

interface InstallmentPlansPluginInterface
{

    /**
     * @param \Generated\Shared\Transfer\AfterpayInstallmentPlansRequestTransfer $installmentPlansRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayInstallmentPlansResponseTransfer
     */
    public function getAvailableInstallmentPlans(
        AfterpayInstallmentPlansRequestTransfer $installmentPlansRequestTransfer
    );

}
