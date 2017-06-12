<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Zed\Afterpay\AfterpayDependencyProvider;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\AfterpayApiAdapter;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\Http\Guzzle;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter\TransferToCamelCaseArrayConverter;
use SprykerEco\Zed\Afterpay\Business\Payment\Handler\RiskCheck\AvailablePaymentMethodsHandler;
use SprykerEco\Zed\Afterpay\Business\Payment\Mapper\QuoteToRequestTransfer;

/**
 * @method \SprykerEco\Zed\Afterpay\Persistence\AfterpayQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\Afterpay\AfterpayConfig getConfig()
 */
class AfterpayBusinessFactory extends AbstractBusinessFactory
{

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Handler\RiskCheck\AvailablePaymentMethodsHandlerInterface
     */
    public function createAvailablePaymentMethodsHandler()
    {
        return new AvailablePaymentMethodsHandler(
            $this->createApiAdapter(),
            $this->createQuoteToRequestMapper()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface
     */
    protected function createApiAdapter()
    {
        return new AfterpayApiAdapter(
            $this->createHttpClient(),
            $this->createTransferToCamelCaseArrayConverter(),
            $this->createUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Converter\TransferToCamelCaseArrayConverterInterface
     */
    protected function createTransferToCamelCaseArrayConverter()
    {
        return new TransferToCamelCaseArrayConverter(
            $this->createUtilTextService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilTextInterface
     */
    protected function createUtilTextService()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::SERVICE_UTIL_TEXT);
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingInterface
     */
    protected function createUtilEncodingService()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::SERVICE_UTIL_ENCODING);
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client\Http\Guzzle
     */
    protected function createHttpClient()
    {
        return new Guzzle($this->getConfig());
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Mapper\QuoteToRequestTransferInterface
     */
    protected function createQuoteToRequestMapper()
    {
        return new QuoteToRequestTransfer(
            $this->getAfterpayToMoneyBridge(),
            $this->getCurrentStore()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToMoneyInterface
     */
    protected function getAfterpayToMoneyBridge()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::FACADE_MONEY);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    protected function getCurrentStore()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::CURRENT_STORE);
    }

}
