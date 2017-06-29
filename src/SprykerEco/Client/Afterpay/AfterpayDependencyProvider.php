<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Client\Afterpay;

use Spryker\Client\Kernel\AbstractDependencyProvider;
use Spryker\Client\Kernel\Container;
use Spryker\Client\Session\ServiceProvider\SessionClientServiceProvider;
use Spryker\Client\ZedRequest\ServiceProvider\ZedRequestClientServiceProvider;
use SprykerEco\Client\Afterpay\Dependency\Client\AfterpayToLocaleBridge;
use SprykerEco\Client\Afterpay\Dependency\Client\AfterpayToQuoteBridge;

class AfterpayDependencyProvider extends AbstractDependencyProvider
{

    const CLIENT_LOCALE = 'client locale';
    const CLIENT_SESSION = SessionClientServiceProvider::CLIENT_SESSION; // todo remove mentioning of SessionClientServiceProvider
    const CLIENT_ZED_REQUEST = ZedRequestClientServiceProvider::CLIENT_ZED_REQUEST;
    const CLIENT_QUOTE = 'client quote';

    /**
     * @param \Spryker\Client\Kernel\Container $container
     *
     * @return \Spryker\Client\Kernel\Container
     */
    public function provideServiceLayerDependencies(Container $container)
    {
        $container[static::CLIENT_LOCALE] = function (Container $container) {
            return new AfterpayToLocaleBridge($container->getLocator()->locale()->client());
        };

        $container[static::CLIENT_QUOTE] = function (Container $container) {
            return new AfterpayToQuoteBridge($container->getLocator()->quote()->client());
        };

        $container[static::CLIENT_ZED_REQUEST] = function (Container $container) {
            return $container->getLocator()->zedRequest()->client(); //bridge missing
        };

        return $container;
    }

}
