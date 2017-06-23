<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay\Plugin;

use Generated\Shared\Transfer\AfterpayValidateBankAccountRequestTransfer;

interface BankAccountValidationPluginInterface
{

    /**
     * @param \Generated\Shared\Transfer\AfterpayValidateBankAccountRequestTransfer $validateBankAccountRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayValidateBankAccountResponseTransfer
     */
    public function validateBankAccount(AfterpayValidateBankAccountRequestTransfer $validateBankAccountRequestTransfer);

}
