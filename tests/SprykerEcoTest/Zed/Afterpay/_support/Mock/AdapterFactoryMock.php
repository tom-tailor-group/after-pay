<?php

namespace SprykerEcoTest\Zed\Afterpay\Mock;

use SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterFactory;
use SprykerEcoTest\Zed\Afterpay\Mock\Call\AuthorizePaymentCallMock;
use SprykerEcoTest\Zed\Afterpay\Mock\Call\CaptureCallMock;

class AdapterFactoryMock extends AdapterFactory
{
    /**
     * @return \SprykerEcoTest\Zed\Afterpay\Mock\Call\AuthorizePaymentCallMock
     */
    public function createAuthorizePaymentCall()
    {
        return new AuthorizePaymentCallMock(
            $this->createHttpClient(),
            $this->createTransferToCamelCaseArrayConverter(),
            $this->getUtilEncodingService(),
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Api\Adapter\ApiCall\CaptureCallInterface
     */
    public function createCaptureCall()
    {
        return new CaptureCallMock(
            $this->createHttpClient(),
            $this->createTransferToCamelCaseArrayConverter(),
            $this->getUtilEncodingService(),
            $this->getAfterpayToMoneyBridge(),
            $this->getConfig()
        );
    }
}
