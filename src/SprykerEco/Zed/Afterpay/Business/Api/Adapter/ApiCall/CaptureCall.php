<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall;

use Generated\Shared\Transfer\AfterpayApiResponseTransfer;
use Generated\Shared\Transfer\AfterpayAuthorizeRequestTransfer;
use Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEco\Zed\Afterpay\AfterpayConfig;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\ClientInterface;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter\TransferToCamelCaseArrayConverterInterface;
use SprykerEco\Zed\Afterpay\Business\Exception\ApiHttpRequestException;
use SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingInterface;

class CaptureCall extends AbstractApiCall implements CaptureCallInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\ClientInterface
     */
    protected $client;

    /**
     * @var \SprykerEco\Zed\Afterpay\AfterpayConfig
     */
    protected $config;

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
     * @param \Generated\Shared\Transfer\AfterpayItemCaptureRequestTransfer $requestTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    public function execute(AfterpayItemCaptureRequestTransfer $requestTransfer)
    {
        try {
            $jsonResponse = $this->client->sendPost(
                $this->config->getCaptureApiEndpointUrl($requestTransfer->getOrderNumber())
            );
        } catch (ApiHttpRequestException $apiHttpRequestException) {
            $this->logApiException($apiHttpRequestException);
            $jsonResponse = '';
        }

        return $this->buildAuthorizeResponseTransfer($jsonResponse);
    }

    /**
     * @param string $jsonResponse
     *
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    protected function buildAuthorizeResponseTransfer($jsonResponse)
    {
        $jsonResponseArray = $this->utilEncoding->decodeJson($jsonResponse, true);

        $responseTransfer = new AfterpayApiResponseTransfer();

        $outcome = $jsonResponseArray['captureNumber']
            ? AfterpayConstants::API_TRANSACTION_OUTCOME_ACCEPTED
            : AfterpayConstants::API_TRANSACTION_OUTCOME_REJECTED;

        $responseTransfer
            ->setOutcome($outcome)
            ->setResponsePayload($jsonResponse);

        return $responseTransfer;
    }

}
