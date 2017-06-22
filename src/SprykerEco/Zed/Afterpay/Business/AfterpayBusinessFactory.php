<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEco\Zed\Afterpay\AfterpayDependencyProvider;
use SprykerEco\Zed\Afterpay\Business\AdditionalServices\Handler\ValidateCustomerHandler;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterFactory;
use SprykerEco\Zed\Afterpay\Business\Api\Adapter\AfterpayApiAdapter;
use SprykerEco\Zed\Afterpay\Business\Order\Saver;
use SprykerEco\Zed\Afterpay\Business\Payment\Handler\RiskCheck\AvailablePaymentMethodsHandler;
use SprykerEco\Zed\Afterpay\Business\Payment\Mapper\OrderToRequestTransfer;
use SprykerEco\Zed\Afterpay\Business\Payment\Mapper\QuoteToRequestTransfer;
use SprykerEco\Zed\Afterpay\Business\Payment\PaymentReader;
use SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriter;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Authorize\RequestBuilder\OneStepAuthorizeRequestBuilder;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Authorize\RequestBuilder\TwoStepsAuthorizeRequestBuilder;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\AuthorizeTransaction;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Capture\CaptureRequestBuilder;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\CaptureTransaction;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Handler\AuthorizeTransactionHandler;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Logger\TransactionLogger;
use SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Handler\CaptureTransactionHandler;

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
     * @return \SprykerEco\Zed\Afterpay\Business\Order\SaverInterface
     */
    public function createOrderSaver()
    {
        return new Saver(
            $this->getConfig()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Handler\AuthorizeTransactionHandler
     */
    public function createAuthorizeTransactionHandler()
    {
        return new AuthorizeTransactionHandler(
            $this->createAuthorizeTransaction(),
            $this->createAuthorizeRequestBuilder(),
            $this->createPaymentWriter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Handler\CaptureTransactionHandler
     */
    public function createCaptureTransactionHandler()
    {
        return new CaptureTransactionHandler(
            $this->createCaptureTransaction(),
            $this->createPaymentReader(),
            $this->createPaymentWriter(),
            $this->createCaptureRequestBuilder()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Capture\CaptureRequestBuilderInterface
     */
    protected function createCaptureRequestBuilder()
    {
        return new CaptureRequestBuilder(
            $this->createOrderToRequestMapper(),
            $this->getAfterpayToMoneyBridge()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\PaymentReaderInterface
     */
    public function createPaymentReader()
    {
        return new PaymentReader(
            $this->getQueryContainer()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\CaptureTransaction
     */
    protected function createCaptureTransaction()
    {
        return new CaptureTransaction(
            $this->createTransactionLogger(),
            $this->createApiAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\AdditionalServices\Handler\ValidateCustomerHandler
     */
    public function createValidateCustomerHandler()
    {
        return new ValidateCustomerHandler(
            $this->createApiAdapter(),
            $this->getAfterpayToCustomerBridge()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\PaymentWriterInterface
     */
    protected function createPaymentWriter()
    {
        return new PaymentWriter(
            $this->getQueryContainer()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\AuthorizeTransactionInterface
     */
    protected function createAuthorizeTransaction()
    {
        return new AuthorizeTransaction(
            $this->createTransactionLogger(),
            $this->createApiAdapter()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Logger\TransactionLoggerInterface
     */
    protected function createTransactionLogger()
    {
        return new TransactionLogger(
            $this->getUtilEncodingService()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterInterface
     */
    public function createApiAdapter()
    {
        return new AfterpayApiAdapter(
            $this->createAdapterFactory()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Api\Adapter\AdapterFactoryInterface
     */
    protected function createAdapterFactory()
    {
        return new AdapterFactory();
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Authorize\RequestBuilder\AuthorizeRequestBuilderInterface
     */
    protected function createAuthorizeRequestBuilder()
    {
        $authorizeWorkflow = $this->getConfig()->getAfterpayAuthorizeWorkflow();

        switch ($authorizeWorkflow) {
            case AfterpayConstants::AFTERPAY_AUTHORIZE_WORKFLOW_ONE_STEP:
                return $this->createOneStepAuthorizeRequestBuilder();
            case AfterpayConstants::AFTERPAY_AUTHORIZE_WORKFLOW_TWO_STEPS:
                return $this->createTwoStepsAuthorizeRequestBuilder();
            default:
                return $this->createOneStepAuthorizeRequestBuilder();
        }
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Authorize\RequestBuilder\OneStepAuthorizeRequestBuilder
     */
    protected function createOneStepAuthorizeRequestBuilder()
    {
        return new OneStepAuthorizeRequestBuilder(
            $this->createOrderToRequestMapper()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Mapper\OrderToRequestTransferInterface
     */
    protected function createOrderToRequestMapper()
    {
        return new OrderToRequestTransfer(
            $this->getAfterpayToMoneyBridge(),
            $this->getCurrentStore()
        );
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Authorize\RequestBuilder\TwoStepsAuthorizeRequestBuilder
     */
    protected function createTwoStepsAuthorizeRequestBuilder()
    {
        return new TwoStepsAuthorizeRequestBuilder();
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingInterface
     */
    protected function getUtilEncodingService()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::SERVICE_UTIL_ENCODING);
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
     * @return \SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToCustomerInterface
     */
    protected function getAfterpayToCustomerBridge()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::FACADE_CUSTOMER);
    }

    /**
     * @return \SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToSalesInterface
     */
    protected function getAfterpayToSalesBridge()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::FACADE_SALES);
    }

    /**
     * @return \Spryker\Shared\Kernel\Store
     */
    protected function getCurrentStore()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::CURRENT_STORE);
    }

}
