<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay\Plugin;

use Generated\Shared\Transfer\AfterpayCustomerLookupRequestTransfer;
use Generated\Shared\Transfer\AfterpayValidateBankAccountRequestTransfer;
use Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer;
use Spryker\Yves\Kernel\AbstractPlugin;

/**
 * @method \SprykerEco\Yves\Afterpay\AfterpayFactory getFactory()
 */
class AfterpayBankAccountValidationPlugin extends AbstractPlugin implements BankAccountValidationPluginInterface
{

    /**
     * @param \Generated\Shared\Transfer\AfterpayValidateBankAccountRequestTransfer $validateBankAccountRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayValidateBankAccountResponseTransfer
     */
    public function validateBankAccount(AfterpayValidateBankAccountRequestTransfer $validateBankAccountRequestTransfer)
    {
        return $this
            ->getFactory()
            ->getAfterpayClient()
            ->validateBankAccount($validateBankAccountRequestTransfer);
    }

}
