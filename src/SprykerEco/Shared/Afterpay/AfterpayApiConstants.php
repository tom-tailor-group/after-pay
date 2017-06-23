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

}
