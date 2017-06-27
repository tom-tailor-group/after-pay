<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Shared\Afterpay;

interface AfterpayApiConstants
{

    /** Capture call */
    const CAPTURE_CAPTURED_AMOUNT = 'capturedAmount';
    const CAPTURE_AUTHORIZED_AMOUNT = 'authorizedAmount';
    const CAPTURE_REMAINING_AUTHORIZED_AMOUNT = 'remainingAuthorizedAmount';
    const CAPTURE_CAPTURE_NUMBER = 'captureNumber';

    /** Validate bank account call */
    const VALIDATE_BANK_ACCOUNT_IS_VALID = 'isValid';

    /** Lookup installment plans call */
    const AVAILABLE_PLANS = 'availableInstallmentPlans';

    const BASKET_AMOUNT = "basketAmount";
    const NUMBER_OF_INSTALLMENTS = "numberOfInstallments";
    const INSTALLMENT_AMOUNT = "installmentAmount";
    const FIRST_INSTALLMENT_AMOUNT = "firstInstallmentAmount";
    const LAST_INSTALLMENT_AMOUNT = "lastInstallmentAmount";
    const INTEREST_RATE = "interestRate";
    const EFFECTIVE_INTEREST_RATE = "effectiveInterestRate";
    const EFFECTIVE_ANNUAL_PERCENTAGE_RATE = "effectiveAnnualPercentageRate";
    const TOTAL_INTEREST_AMOUNT = "totalInterestAmount";
    const STARTUP_FEE = "startupFee";
    const MONTHLY_FEE = "monthlyFee";
    const TOTAL_AMOUNT = "totalAmount";
    const INSTALLMENT_PROFILE_NUMBER = "installmentProfileNumber";
    const READ_MORE = "readMore";

}
