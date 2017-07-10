<?php

/**
 * MIT License
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerEco\Zed\Afterpay\Business\Payment\Transaction\Refund;

use Generated\Shared\Transfer\AfterpayCaptureRequestTransfer;
use Generated\Shared\Transfer\AfterpayRefundRequestTransfer;
use Generated\Shared\Transfer\AfterpayRequestOrderItemTransfer;
use Generated\Shared\Transfer\ItemTransfer;
use Generated\Shared\Transfer\OrderTransfer;
use SprykerEco\Shared\Afterpay\AfterpayConstants;
use SprykerEco\Zed\Afterpay\Business\Payment\Mapper\OrderToRequestTransferInterface;
use SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToMoneyInterface;

class RefundRequestBuilder implements RefundRequestBuilderInterface
{

    /**
     * @var \SprykerEco\Zed\Afterpay\Business\Payment\Mapper\OrderToRequestTransferInterface
     */
    protected $orderToRequestMapper;

    /**
     * @var \SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToMoneyInterface
     */
    private $money;

    /**
     * @param \SprykerEco\Zed\Afterpay\Business\Payment\Mapper\OrderToRequestTransferInterface $orderToRequestMapper
     * @param \SprykerEco\Zed\Afterpay\Dependency\Facade\AfterpayToMoneyInterface $money
     */
    public function __construct(
        OrderToRequestTransferInterface $orderToRequestMapper,
        AfterpayToMoneyInterface $money
    ) {
        $this->orderToRequestMapper = $orderToRequestMapper;
        $this->money = $money;
    }

    /**
     * @param \Generated\Shared\Transfer\OrderTransfer $orderTransfer
     *
     * @return \Generated\Shared\Transfer\AfterpayRefundRequestTransfer
     */
    public function buildBaseRefundRequestForOrder(OrderTransfer $orderTransfer)
    {
        $refundRequestTransfer = $this->orderToRequestMapper
            ->orderToBaseRefundRequest($orderTransfer);

        return $refundRequestTransfer;
    }

    /**
     * @param \Generated\Shared\Transfer\ItemTransfer $orderItemTransfer
     * @param \Generated\Shared\Transfer\AfterpayRefundRequestTransfer $refundRequestTransfer
     *
     * @return $this
     */
    public function addOrderItemToRefundRequest(
        ItemTransfer $orderItemTransfer,
        AfterpayRefundRequestTransfer $refundRequestTransfer
    ) {
        $orderItemRequestTransfer = $this->orderToRequestMapper->orderItemToAfterpayItemRequest($orderItemTransfer);

        $this->addOrderItemToRefundDetails($orderItemRequestTransfer, $refundRequestTransfer);
        //$this->increaseTotalToRefundAmounts($orderItemRequestTransfer, $refundRequestTransfer);

        return $this;
    }

    /**
     * @param int $expenseAmount
     * @param \Generated\Shared\Transfer\AfterpayCaptureRequestTransfer $refundRequestTransfer
     *
     * @return $this
     */
    public function addOrderExpenseToRefundRequest(
        $expenseAmount,
        AfterpayRefundRequestTransfer $refundRequestTransfer
    ) {
        $expenseItemRequestTransfer = $this->buildExpenseItemTransfer($expenseAmount);
        $this->addOrderItemToRefundRequest($expenseItemRequestTransfer, $refundRequestTransfer);

        return $this;
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayRequestOrderItemTransfer $orderItemRequestTransfer
     * @param \Generated\Shared\Transfer\AfterpayRefundRequestTransfer $refundRequestTransfer
     *
     * @return void
     */
    protected function addOrderItemToRefundDetails(
        AfterpayRequestOrderItemTransfer $orderItemRequestTransfer,
        AfterpayRefundRequestTransfer $refundRequestTransfer
    ) {
        $refundRequestTransfer->getOrderItems()->addItem($orderItemRequestTransfer);
    }

    /**
     * @param int $expenseAmount
     *
     * @return \Generated\Shared\Transfer\ItemTransfer
     */
    protected function buildExpenseItemTransfer($expenseAmount)
    {
        return (new ItemTransfer())
            ->setSku(AfterpayConstants::REFUND_EXPENSE_SKU)
            ->setName(AfterpayConstants::REFUND_EXPENSE_DESCRIPTION)
            ->setUnitGrossPrice($expenseAmount)
            ->setUnitPriceToPayAggregation($expenseAmount)
            ->setUnitTaxAmountFullAggregation(0)
            ->setQuantity(1);
    }

    /**
     * @param float $decimalValue
     *
     * @return int
     */
    protected function decimalToInt($decimalValue)
    {
        return $this->money->convertDecimalToInteger($decimalValue);
    }

    /**
     * @param int $intValue
     *
     * @return string
     */
    protected function intToDecimalString($intValue)
    {
        return (string)$this->money->convertIntegerToDecimal($intValue);
    }

    /**
     * @param \Generated\Shared\Transfer\AfterpayRequestOrderItemTransfer $orderItemRequestTransfer
     * @param \Generated\Shared\Transfer\AfterpayCaptureRequestTransfer $refundRequestTransfer
     *
     * @return void
     */
    /*protected function increaseTotalNetAmount(
        AfterpayRequestOrderItemTransfer $orderItemRequestTransfer,
        AfterpayCaptureRequestTransfer $refundRequestTransfer
    ) {
        $oldNetAmountDecimal = $this->decimalToInt((float)$refundRequestTransfer->getOrderDetails()->getTotalNetAmount());
        $itemNetAmountDecimal = $this->decimalToInt((float)$orderItemRequestTransfer->getNetUnitPrice());

        $newNetAmountDecimal = $oldNetAmountDecimal + $itemNetAmountDecimal;
        $refundRequestTransfer->getOrderDetails()->setTotalNetAmount(
            $this->intToDecimalString($newNetAmountDecimal)
        );
    }*/

    /**
     * @param \Generated\Shared\Transfer\AfterpayRequestOrderItemTransfer $orderItemRequestTransfer
     * @param \Generated\Shared\Transfer\AfterpayCaptureRequestTransfer $captureRequestTransfer
     *
     * @return void
     */
    /*protected function increaseTotalGrossAmount(
        AfterpayRequestOrderItemTransfer $orderItemRequestTransfer,
        AfterpayCaptureRequestTransfer $captureRequestTransfer
    ) {
        $oldGrossAmountDecimal = $this->decimalToInt((float)$captureRequestTransfer->getOrderDetails()->getTotalGrossAmount());
        $itemGrossAmountDecimal = $this->decimalToInt((float)$orderItemRequestTransfer->getGrossUnitPrice());

        $newGrossAmountDecimal = $oldGrossAmountDecimal + $itemGrossAmountDecimal;
        $captureRequestTransfer->getOrderDetails()->setTotalGrossAmount(
            $this->intToDecimalString($newGrossAmountDecimal)
        );
    }*/


    /**
     * @param \Generated\Shared\Transfer\AfterpayRequestOrderItemTransfer $orderItemRequestTransfer
     * @param \Generated\Shared\Transfer\AfterpayCaptureRequestTransfer $refundRequestTransfer
     *
     * @return void
     */
    /*protected function increaseTotalToCaptureAmounts(
        AfterpayRequestOrderItemTransfer $orderItemRequestTransfer,
        AfterpayCaptureRequestTransfer $refundRequestTransfer
    ) {
        $this->increaseTotalNetAmount($orderItemRequestTransfer, $refundRequestTransfer);
        $this->increaseTotalGrossAmount($orderItemRequestTransfer, $refundRequestTransfer);
    }*/


}
