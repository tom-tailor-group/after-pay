<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Exception;

use Exception;
use Generated\Shared\Transfer\AfterpayApiResponseErrorTransfer;

class ApiHttpRequestException extends Exception
{

    /**
     * @var $error
     */
    protected $error;

    /**
     * @param \Generated\Shared\Transfer\AfterpayApiResponseErrorTransfer $error
     *
     * @return void
     */
    public function setError(AfterpayApiResponseErrorTransfer $error)
    {
        $this->error = $error;
    }

    /**
     * @return \Generated\Shared\Transfer\AfterpayApiResponseErrorTransfer
     */
    public function getError()
    {
        return $this->error;
    }

}
