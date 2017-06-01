<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Yves\Afterpay;

use Spryker\Yves\Kernel\AbstractBundleDependencyProvider;
use Spryker\Yves\Kernel\Container;

class AfterpayDependencyProvider extends AbstractBundleDependencyProvider
{

    const CLIENT_AFTERPAY = 'afterpay client';
    const CLIENT_QUOTE = 'quote client';

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    public function provideDependencies(Container $container)
    {
        $container = $this->provideClients($container);

        return $container;
    }

    /**
     * @param \Spryker\Yves\Kernel\Container $container
     *
     * @return \Spryker\Yves\Kernel\Container
     */
    protected function provideClients(Container $container)
    {
        $container[static::CLIENT_AFTERPAY] = function (Container $container) {
            return $container->getLocator()->afterpay()->client();
        };

        $container[static::CLIENT_QUOTE] = function (Container $container) {
            return $container->getLocator()->quote()->client();
        };

        return $container;
    }

}
