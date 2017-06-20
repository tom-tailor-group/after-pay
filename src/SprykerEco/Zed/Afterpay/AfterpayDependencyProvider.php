<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay;

use Spryker\Shared\Kernel\Store;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;
use SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToCustomerBridge;
use SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToMoneyBridge;
use SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToSalesBridge;
use SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilEncodingBridge;
use SprykerEco\Zed\Afterpay\Dependency\Service\AfterpayToUtilTextBridge;

class AfterpayDependencyProvider extends AbstractBundleDependencyProvider
{

    const FACADE_MONEY = 'money facade';
    const FACADE_SALES = 'sales facade';
    const FACADE_CUSTOMER = 'customer facade';

    const SERVICE_UTIL_ENCODING = 'util encoding service';
    const SERVICE_UTIL_TEXT = 'util text service';
    const CURRENT_STORE = 'current store';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideBusinessLayerDependencies(Container $container)
    {
        $container[static::FACADE_MONEY] = function (Container $container) {
            return new AfterpayToMoneyBridge($container->getLocator()->money()->facade());
        };

        $container[self::FACADE_SALES] = function (Container $container) {
            return new AfterpayToSalesBridge($container->getLocator()->sales()->facade());
        };

        $container[self::FACADE_CUSTOMER] = function (Container $container) {
            return new AfterpayToCustomerBridge($container->getLocator()->customer()->facade());
        };

        $container[self::SERVICE_UTIL_ENCODING] = function (Container $container) {
            return new AfterpayToUtilEncodingBridge($container->getLocator()->utilEncoding()->service());
        };

        $container[self::SERVICE_UTIL_TEXT] = function (Container $container) {
            return new AfterpayToUtilTextBridge($container->getLocator()->utilText()->service());
        };

        $container[self::CURRENT_STORE] = function (Container $container) {
            return Store::getInstance();
        };

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container)
    {
        $container[self::FACADE_SALES] = function (Container $container) {
            return new AfterpayToSalesBridge($container->getLocator()->sales()->facade());
        };

        return $container;
    }

}
