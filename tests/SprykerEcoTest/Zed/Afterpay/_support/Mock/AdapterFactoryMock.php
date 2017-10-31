<?php

namespace SprykerEcoTest\Zed\Afterpay\Mock;

use SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterFactory;
use SprykerEcoTest\Zed\Afterpay\Mock\Call\AuthorizePaymentCallMock;

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
}
