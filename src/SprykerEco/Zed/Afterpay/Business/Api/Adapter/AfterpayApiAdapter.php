<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter;

use Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer;
use Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsResponseTransfer;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\ClientInterface;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter\TransferToCamelCaseArrayConverterInterface;
use SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingInterface;

class AfterpayApiAdapter implements AdapterInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\ClientInterface
     */
    protected $client;

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter\TransferToCamelCaseArrayConverterInterface
     */
    protected $transferConverter;

    /**
     * @var \SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingInterface
     */
    protected $utilEncoding;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\ClientInterface $client
     * @param \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter\TransferToCamelCaseArrayConverterInterface $transferConverter
     * @param \SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingInterface $utilEncoding
     */
    public function __construct(
        ClientInterface $client,
        TransferToCamelCaseArrayConverterInterface $transferConverter,
        AfterpayToUtilEncodingInterface $utilEncoding
    ) {
        $this->client = $client;
        $this->transferConverter = $transferConverter;
        $this->utilEncoding = $utilEncoding;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsResponseTransfer
     */
    public function sendAvailablePaymentMethodsRequest(AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer)
    {
        $jsonRequest = $this->buildAvailablePaymentMethodsJsonRequest($requestTransfer);
        $jsonResponse = $this->client->sendPost(
            AfterpayConstants::API_ENDPOINT_AVAILABLE_PAYMENT_METHODS,
            $jsonRequest
        );

        return $this->buildAvailablePaymentMethodsResponseTransfer($jsonResponse);
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer
     *
     * @return string
     */
    protected function buildAvailablePaymentMethodsJsonRequest(
        AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer
    ) {
        $requestArray = $this->transferConverter->convert($requestTransfer);

        return $this->utilEncoding->encodeJson($requestArray);
    }

    /**
     * @param string $jsonResponse
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsResponseTransfer
     */
    protected function buildAvailablePaymentMethodsResponseTransfer($jsonResponse)
    {
        $jsonResponseArray = $this->utilEncoding->decodeJson($jsonResponse, true);

        $responseTransfer = new AfterpayAvailablePaymentMethodsResponseTransfer();

        $riskCheckResultCode = null;

        if (
            isset(
                $jsonResponseArray['additionalResponseInfo'],
                $jsonResponseArray['additionalResponseInfo']['rsS_RiskCheck_ResultCode']
            )
        ) {
            $riskCheckResultCode = $jsonResponseArray['additionalResponseInfo']['rsS_RiskCheck_ResultCode'];
        }

        $responseTransfer
            ->setCheckoutId($jsonResponseArray['checkoutId'] ?? null)
            ->setOutcome($jsonResponseArray['outcome'] ?? null)
            ->setCustomer($jsonResponseArray['customer'] ?? [])
            ->setPaymentMethods($jsonResponseArray['paymentMethods'] ?? [])
            ->setRiskCheckResultCode($riskCheckResultCode);

        return $responseTransfer;
    }

}
