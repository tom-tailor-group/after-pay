<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall;

use Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer;
use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

class AbstractApiCall
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter\TransferToCamelCaseArrayConverterInterface
     */
    protected $transferConverter;

    /**
     * @var \SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingInterface
     */
    protected $utilEncoding;

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $requestTransfer
     *
     * @return string
     */
    protected function buildJsonRequestFromTransferObject(AbstractTransfer $requestTransfer)
    {
        $requestArray = $this->transferConverter->convert($requestTransfer);
        return $this->utilEncoding->encodeJson($requestArray);
    }

}
