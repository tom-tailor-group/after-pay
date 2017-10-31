<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Afterpay\Business;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\AfterpayCallBuilder;
use Generated\Shared\DataBuilder\TaxTotalBuilder;
use SprykerEcoTest\Zed\Afterpay\Mock\AfterpayFacadeMock;

class AfterpayFacadeAuthorizeTest extends Test
{
    /**
     * @return void
     */
    public function testAuthorize()
    {
        $input = $this->createRequestTransfer();
        $this->doFacadeCall($input);
    }

    /**
     * @return \Generated\Shared\Transfer\AfterpayCallTransfer
     */
    protected function createRequestTransfer()
    {
        $call = (new AfterpayCallBuilder())
            ->withBillingAddress()
            ->withShippingAddress()
            ->withTotals()
            ->withItem()
            ->build();

        $call->getTotals()->setTaxTotal(
            (new TaxTotalBuilder())->build()
        );

        return $call;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayCallTransfer $input
     *
     * @return void
     */
    protected function doFacadeCall($input)
    {
        (new AfterpayFacadeMock())->authorizePayment($input);
    }
}
