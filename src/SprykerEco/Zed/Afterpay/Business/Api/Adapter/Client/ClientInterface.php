<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Api\Adapter\Client;

interface ClientInterface
{

    /**
     * @param string $endPoint
     * @param string $jsonBody
     *
     * @return string
     */
    public function sendPost($endPoint, $jsonBody);

}
