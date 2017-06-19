<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall;

use Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer;

interface CaptureCallInterface
{

    /**
     * @param \Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function execute(AfterpayItemCaptureRequestTransfer $requestTransfer);

}
