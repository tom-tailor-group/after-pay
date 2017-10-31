<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEcoTest\Zed\Afterpay\Business;

use Codeception\TestCase\Test;
use Generated\Shared\DataBuilder\AfterpayCallBuilder;
use Generated\Shared\DataBuilder\TaxTotalBuilder;
use Generated\Shared\Transfer\AfterpayApiResponseTransfer;
use Generated\Shared\Transfer\AfterpayCallTransfer;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEcoTest\Zed\Afterpay\Mock\AfterpayFacadeMock;

class AfterpayFacadeAuthorizeTest extends Test
{
    /**
     * @return void
     */
    public function testAuthorize()
    {
        $input = $this->createRequestTransfer();
        $output = $this->doFacadeCall($input);
        $this->doTest($output);
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
     * @return \Generated\Shared\Transfer\AfterpayApiResponseTransfer
     */
    protected function doFacadeCall(AfterpayCallTransfer $input)
    {
        return (new AfterpayFacadeMock())->authorizePayment($input);
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayApiResponseTransfer $output
     *
     * @return void
     */
    protected function doTest(AfterpayApiResponseTransfer $output)
    {
        $this->assertNotEmpty($output->getOutcome());
        $this->assertEquals($output->getOutcome(), AfterpayConstants::API_TRANSACTION_OUTCOME_ACCEPTED);
        $this->assertNotEmpty($output->getCheckoutId());
        $this->assertNotEmpty($output->getReservationId());
        $this->assertNotEmpty($output->getResponsePayload());
    }
}
