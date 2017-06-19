<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter;

use Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer;
use Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer;
use Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer;
use Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer;

interface AdapterInterface
{

    const API_ENDPOINT_AVAILABLE_PAYMENT_METHODS = 'checkout/payment-methods';

    /**
     * @param \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsResponseTransfer
     */
    public function sendAvailablePaymentMethodsRequest(
        AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer
    );

    /**
     * @param \Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function sendAuthorizationRequest(
        AfterpayAuthorizeRequestTransfer $authorizeRequestTransfer
    );

    /**
     * @param \Generated\Shared\Transfer\AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayValidateCustomerResponseTransfer
     */
    public function sendValidateCustomerRequest(
        AfterpayValidateCustomerRequestTransfer $validateCustomerRequestTransfer
    );

    /**
     * @param \Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer $fullCaptureRequestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function sendFullCaptureRequest(
        AfterpayItemCaptureRequestTransfer $fullCaptureRequestTransfer
    );

    /**
     * @return string
     */
    public function getApiVersion();

    /**
     * @return string
     */
    public function getApiStatus();

}
