<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall;

use Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer;
use Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsResponseTransfer;
use SprykerEco\Zed\Afterpay\AfterpayConfig;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\ClientInterface;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter\TransferToCamelCaseArrayConverterInterface;
use SprykerEco\Zed\Afterpay\Business\Exception\ApiHttpRequestException;
use SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingInterface;

class AvailablePaymentMethodsCall extends AbstractApiCall implements AvailablePaymentMethodsCallInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\ClientInterface
     */
    protected $client;
    /**
     * @var \SprykerEco\Zed\Afterpay\AfterpayConfig
     */
    private $config;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\ClientInterface $client
     * @param \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter\TransferToCamelCaseArrayConverterInterface $transferConverter
     * @param \SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingInterface $utilEncoding
     * @param \SprykerEco\Zed\Afterpay\AfterpayConfig $config
     */
    public function __construct(
        ClientInterface $client,
        TransferToCamelCaseArrayConverterInterface $transferConverter,
        AfterpayToUtilEncodingInterface $utilEncoding,
        AfterpayConfig $config
    ) {
        $this->client = $client;
        $this->transferConverter = $transferConverter;
        $this->utilEncoding = $utilEncoding;
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayAvailablePaymentMethodsResponseTransfer
     */
    public function execute(AfterpayAvailablePaymentMethodsRequestTransfer $requestTransfer)
    {
        $jsonRequest = $this->buildJsonRequestFromTransferObject($requestTransfer);

        try {
            $jsonResponse = $this->client->sendPost(
                $this->config->getAvailablePaymentMethodsApiEndpointUrl(),
                $jsonRequest
            );
        } catch (ApiHttpRequestException $apiHttpRequestException) {
            $this->logApiException($apiHttpRequestException);
            $jsonResponse = '[]';
        }

        return $this->buildAvailablePaymentMethodsResponseTransfer($jsonResponse);
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

        $riskCheckResultCode = $this->extractRiskCheckCode($jsonResponseArray);
        $customerNumber = $this->extractCustomerNumber($jsonResponseArray);

        $responseTransfer
            ->setCheckoutId($jsonResponseArray['checkoutId'] ?? null)
            ->setOutcome($jsonResponseArray['outcome'] ?? null)
            ->setCustomer($jsonResponseArray['customer'] ?? [])
            ->setCustomerNumber($customerNumber)
            ->setPaymentMethods($jsonResponseArray['paymentMethods'] ?? [])
            ->setRiskCheckResultCode($riskCheckResultCode);

        return $responseTransfer;
    }

    /**
     * @param array $jsonResponseArray
     *
     * @return string|null
     */
    protected function extractRiskCheckCode($jsonResponseArray)
    {
        $riskCheckResultCode = null;

        if (isset(
            $jsonResponseArray['additionalResponseInfo'],
            $jsonResponseArray['additionalResponseInfo']['rsS_RiskCheck_ResultCode']
        )
        ) {
            $riskCheckResultCode = $jsonResponseArray['additionalResponseInfo']['rsS_RiskCheck_ResultCode'];
        }

        return $riskCheckResultCode;
    }
    /**
     * @param array $jsonResponseArray
     *
     * @return string|null
     */
    protected function extractCustomerNumber($jsonResponseArray)
    {
        $customerNumber = null;

        if (isset(
            $jsonResponseArray['customer'],
            $jsonResponseArray['customer']['customerNumber']
        )
        ) {
            $customerNumber = $jsonResponseArray['customer']['customerNumber'];
        }

        return $customerNumber;
    }

}
