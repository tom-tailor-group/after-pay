<?php

/**
 * MIT License
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

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall\ValidateCustomerCallInterface
     */
    public function createValidateCustomerCall();

}
