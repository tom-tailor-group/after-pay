<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter;

use Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer;
use Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer;

class AfterpayApiAdapter implements AdapterInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterFactoryInterface
     */
    protected $adapterFactory;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterFactoryInterface $adapterFactory
     */
    public function __construct(AdapterFactoryInterface $adapterFactory)
    {
        $this->adapterFactory = $adapterFactory;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsResponseTransfer
     */
    public function sendAvailablePaymentMethodsRequest(
        AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer
    ) {
        return $this
            ->adapterFactory
            ->createAvailablePaymentMethodsCall()
            ->execute($requestTransfer);
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function sendAuthorizationRequest(
        AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
    ) {
        return $this
            ->adapterFactory
            ->createAuthorizePaymentCall()
            ->execute($authorizeRequestTransfer);
    }

}
