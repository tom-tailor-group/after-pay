<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter;

interface AdapterFactoryInterface
{

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall\AvailablePaymentMethodsCallInterface
     */
    public function createAvailablePaymentMethodsCall();

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall\AuthorizePaymentCallInterface
     */
    public function createAuthorizePaymentCall();

}
