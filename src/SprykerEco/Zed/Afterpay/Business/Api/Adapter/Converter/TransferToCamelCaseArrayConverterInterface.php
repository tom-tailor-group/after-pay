<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter;

use Spryker\Shared\Kernel\Transfer\AbstractTransfer;

interface TransferToCamelCaseArrayConverterInterface
{

    /**
     * @param \Spryker\Shared\Kernel\Transfer\AbstractTransfer $transfer
     *
     * @return mixed
     */
    public function convert(AbstractTransfer $transfer);

}
