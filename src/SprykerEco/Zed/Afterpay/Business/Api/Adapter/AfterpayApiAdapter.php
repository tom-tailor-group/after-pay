<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter;

use Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer;
use Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer;
use Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer;

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

    /**
     * @param \Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayValidateCustomerResponseTransfer
     */
    public function sendValidateCustomerRequest(
        AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
    ) {
        return $this
            ->adapterFactory
            ->createValidateCustomerCall()
            ->execute($validateCustomerRequestTransfer);
    }

}
