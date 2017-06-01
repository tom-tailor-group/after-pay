<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay;

use Spryker\Yves\Kernel\AbstractFactory;
use SprykerEco\Yves\Afterpay\Form\InvoiceSubForm;
use SprykerEco\Yves\Afterpay\Form\DataProvider\InvoiceDataProvider;
use SprykerEco\Yves\Afterpay\Handler\AfterpayHandler;

/**
 * @method \SprykerEco\Yves\Afterpay\AfterpayConfig getConfig()
 */
class AfterpayFactory extends AbstractFactory
{

    /**
     * @return \SprykerEco\Yves\Afterpay\Handler\AfterpayHandlerInterface
     */
    public function createAfterpayHandler()
    {
        return new AfterpayHandler(
            $this->getAfterpayClient()
        );
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\SubFormInterface
     */
    public function createInvoiceForm()
    {
        return new InvoiceSubForm();
    }

    /**
     * @return \Spryker\Yves\StepEngine\Dependency\Form\StepEngineFormDataProviderInterface
     */
    public function createInvoiceFormDataProvider()
    {
        return new InvoiceDataProvider();
    }

    /**
     * @return \SprykerEco\Client\Afterpay\AfterpayClientInterface
     */
    public function getAfterpayClient()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::CLIENT_AFTERPAY);
    }

    /**
     * @return \SprykerEco\Yves\Afterpay\AfterpayConfig
     */
    public function getYvesConfig()
    {
        return $this->getConfig();
    }

}
