<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerEco\Zed\Afterpay\AfterpayDependencyProvider;

/**
 * @method \SprykerEco\Zed\Afterpay\Persistence\AfterpayQueryContainerInterface getQueryContainer()
 * @method \SprykerEco\Zed\Afterpay\AfterpayConfig getConfig()
 */
class AfterpayCommunicationFactory extends AbstractCommunicationFactory
{

    /**
     * @return \SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToSalesInterface
     */
    public function getSalesFacade()
    {
        return $this->getProvidedDependency(AfterpayDependencyProvider::FACADE_SALES);
    }

}
